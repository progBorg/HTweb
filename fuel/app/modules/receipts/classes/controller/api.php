<?php

namespace Receipts;

use Api\Response_Status;

class Controller_Api extends \Api\Controller_Auth
{

	public function action_index() {
		return new Response_Status(400, 'Bad Request: Missing API function');
	}

	/**
	 * Creates data for the morris object used in the receipt view page.
	 *
	 * @param int|null $id The view Id
	 * @return Response_Status|array
	 */
	public function action_morris_data(int $id = null) {
		if (isset($id)) {
			$receipt = Model_Receipt::find($id);
			if (!$receipt) {
				return Response_Status::_404();
			}

			$data = [
				'data' => [],
				'xkey' => 'y',
				'ykeys' => ['a', 'b'],
				'labels' => [
					__('session.field.point_plural'),
					__('receipt.field.balance')
				]
			];

			foreach ($receipt->get_users() as $user_receipt) {
				array_push($data['data'], [
					'y' => addslashes($user_receipt->user->name),
					'a' => $user_receipt->points,
					'b' => $user_receipt->balance
				]);
			}

			return $data;
		} else {
			return new Response_Status(400, 'Bad Request: Missing view ID');
		}
	}
}