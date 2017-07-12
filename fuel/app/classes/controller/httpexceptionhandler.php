<?php
/**
 * Routed to by the router configuration.
 */
class Controller_HttpExceptionHandler extends \Controller_Core_Theme {
	
	public function before() {
		$this->public_content = true;
		parent::before();
	}
	
	public function action_404(\FuelException $e) {	
		$this->response_status = 404;
		$this->page_title = __('404.title');
		
		if(isset($e) && !empty($e->getMessage())) {
			$message = __('404.msg_exception', ['msg' => $e->getMessage()]);
		} else {
			$message = __('404.msg');
		}	
		$this->content = $message;
	}
	
	public function action_403() {	
		$this->response_status = 403;
		$this->page_title = __('403.title');
		$this->content = __('403.msg');
	}
}