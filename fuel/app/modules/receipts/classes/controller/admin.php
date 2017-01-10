<?php

namespace Receipts;

class Controller_Admin extends \Controller_Admin {
	
	public function action_create() {
		$this->template->title = 'Receipts';
		$this->template->subtitle = 'create';
		$data['sessions'] = \Sessions\Model_Session::get_ready_for_settlement();
		$data['products'] = \Products\Model_Product::get_ready_for_settlement();
		$this->template->content = \View::forge('admin/create', $data);
	}
	
	public function action_index() {
		$this->template->title = 'Receipts';
		
		$data['receipts'] = Model_Receipt::find('all');
		
		$this->template->content = \View::forge('admin/index', $data);
	}

	public function post_create() {
		$session_ids = \Input::post('sessions', []);
		$product_ids = \Input::post('products', []);
		
		if(sizeof($session_ids) == 0 && sizeof($product_ids) == 0) {
			\Utils::handle_recoverable_error('A receipt should at least settle one or more sessions/products.', '/receipts/admin/create');
		}
		
		$receipt = \Receipts\Model_Receipt::forge();
		$receipt->notes = \Input::post('notes', '');
		$receipt->date = date('Y-m-d');
		$receipt->save();

		$this->handle_sessions($session_ids, $receipt);
		$this->handle_products($product_ids, $receipt);
		
		\Response::redirect('/receipts/admin');
	}
	
	public function post_delete() {
		$id = \Input::post('receipt_id', null);
		
		if(isset($id)) {
			if(!($receipt = Model_Receipt::find($id))) {
				\Utils::handle_irrecoverable_error('Unable to delete non-existant receipt.');
			}
			
			$user_receipts = $receipt->users;	
			foreach($user_receipts as $user_receipt) {
				// Restore the points
				$user = $user_receipt->user;
				$user->points -= $user_receipt->points;
				$user->save();
			}
			
			$session_receipts = $receipt->sessions;
			foreach($session_receipts as $session_receipt) {
				// Undo settled state
				$session = $session_receipt->session;
				$session->settled = false;
				$session->save();		
			}
			
			$product_receipts = $receipt->products;
			foreach($product_receipts as $product_receipt) {
				// Undo settled state
				$product = $product_receipt->product;
				$product->settled = false;
				$product->save();
			}
			
			if($receipt->delete()) {
				\Session::set_flash('success', ('Receipt has been deleted.'));
			} else {
				\Session::set_flash('error', ('Could not delete receipt'));	
			}

			\Response::redirect('/receipts/admin/');
		}
		\Utils::handle_irrecoverable_error('No receipt id specified for deletion');
	}
	
	public function handle_products($product_ids, $receipt) {
		foreach($product_ids as $product_id) {
			$product = \Products\Model_Product::find($product_id);
			
			if(empty($product) || $product->settled || !$product->approved) {
				continue;
			}
			
			$product->settled = true;
			$product->save();
			
			$total_count = $product->count_participants();
			
			// If there are no people skip this session
			if ($total_count == 0 ) {
				continue;
			} else {
				$avg_cost = $product->cost / $total_count;
			}
			
			// Create a product receipt to relate the product to this receipt
			$product_receipt = Model_Product_Receipt::forge([
					'product_id' => $product->id,
					'receipt_id' => $receipt->id
				]);
			$product_receipt->save();
			
			$payer = $product->payer;
			$processed_payer = false;
			
			// Apply debits
			foreach($product->users as $product_user) {
				$user_id = $product_user->user->id;
					
				// Apply avg cost * amount
				$temp_balance = -($avg_cost * $product_user->amount);
				
				if($user_id == $payer->id) {
					$processed_payer = true;
					$temp_balance = $temp_balance + $product->cost;
				}
				
				$user_receipt = Model_User_Receipt::get_by_user($user_id, $receipt->id);
				$precision = 2;
				
				if (!isset($user_receipt)) {
					// Create new one
					$user_receipt = \Receipts\Model_User_Receipt::forge(array(
						'user_id' => $user_id,
						'receipt_id' => $receipt->id,
						'balance' => round($temp_balance, $precision),
					));	
				} else {
					// Update values if receipt already exists
					$user_receipt->balance += round($temp_balance, $precision);
				}
				
				$user_receipt->save();
			}
			
			
			// Process payer
			
			if (!$processed_payer) {
				$payer_receipt = Model_User_Receipt::get_by_user($payer->id, $receipt->id);
				if(!isset($payer_receipt)) {
					$payer_receipt = \Receipts\Model_User_Receipt::forge(array(
						'user_id' => $payer->id,
						'receipt_id' => $receipt->id,
						'balance' => round($product->cost, $precision),
					));	
				} else {
					$payer_receipt->balance += $product->cost;
				}

				$payer_receipt->save();
			}
			
		}
	}
	
	public function handle_sessions($session_ids, $receipt) {
		foreach($session_ids as $session_id) {
			$session = \Sessions\Model_Session::find($session_id);
		
			// If there is no session, skip
			if (empty($session) || $session->settled) {
				continue;
			} 
			
			$session->settled = true;
			$session->save();
			
			// Default loss
			$max_loss = 4;
			
			// Gain mutlipliers
			$cook_gain = 2;
			$dish_gain = 1;
			
			$dish_count = $session->count_dishwashers();
			$cook_count = $session->count_cooks();
			$total_count = $session->count_total_participants();
			
			if ($dish_count == 0) {
				$max_loss = 2; // No dishwashers means less loss
			} else if ($dish_count == 1) {
				$dish_gain = 2; // Double the multiplier for a single dishwasher
			}
			if ($cook_count == 2) {
				$cook_gain = 1; // Two cooks split the multiplier
			}
			
			// If there are no people or no cook, skip this session
			if ($total_count == 0 || $cook_count == 0) {
				continue;
			} else {
				$avg_cost = $session->cost / $total_count;
			}
			
			// Create a session receipt to relate the session to this receipt
			$session_receipt = Model_Session_Receipt::forge(array(
					'session_id' => $session->id,
					'receipt_id' => $receipt->id
				));
			$session_receipt->save();
			
		
			// Create a receipt for each user in the session
			foreach($session->enrollments as $enrollment) {
				$user_id = $enrollment->user->id;
				$guests = $enrollment->guests;
		
				$temp_points = -($max_loss + $max_loss * $guests);
				$temp_balance = -($avg_cost + $avg_cost * $guests);
				
				if ($enrollment->cook) {
					$temp_points += $cook_gain * $total_count;
				}			
				if ($enrollment->dishwasher) {
					$temp_points += $dish_gain * $total_count;
				}			
				if ($session->paid_by == $user_id) {
					$temp_balance += $session->cost;
				}
				
				$user_receipt = Model_User_Receipt::get_by_user($user_id, $receipt->id);
				$precision = 2;
				
				if (!isset($user_receipt)) {
					// Create new one
					$user_receipt = \Receipts\Model_User_Receipt::forge(array(
						'user_id' => $user_id,
						'receipt_id' => $receipt->id,
						'balance' => round($temp_balance, $precision),
						'points' => round($temp_points, $precision),
					));	
				} else {
					// Update values if receipt already exists
					$user_receipt->balance += round($temp_balance, $precision);
					$user_receipt->points += round($temp_points, $precision);
				}
				$user_receipt->save();	
				
				// Apply points delta to actual user 
				$user = \Model_User::find($user_id);
				$user->points += round($temp_points, $precision);
				$user->save();
			}
		}
	}
}