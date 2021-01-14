<?php
 
namespace Receipts;

class Controller_Receipts extends \Controller_Core_Theme {
	
	public function action_index() {
		$this->title = __('receipt.title');
		
		$data['receipts'] = Model_Receipt::get_by_user(\Auth::get_user_id()[1]);
		
		$this->content = \View::forge('index', $data);
	}
	
	public function action_view($id) {
		if (isset($id)) {
			$receipt = Model_Receipt::find($id);
			if (!$receipt) {
				\Utils::handle_irrecoverable_error(__('receipt.alert.error.no_receipt', ['id' => $id]));
			}
			$data['receipt'] = $receipt;
			$data['id'] = $id;

			$this->push_css('https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css');
			$this->push_js([
				'receipts/view',
				'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
				'https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js',
			]);
			
			$this->title = __('receipt.title_admin');
			$this->sub_title = date('l j F Y', strtotime($receipt->date));
			$this->content = \View::forge('view', $data);
		}
	}
	
	
}

