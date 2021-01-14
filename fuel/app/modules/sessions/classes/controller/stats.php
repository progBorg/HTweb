<?php

namespace Sessions;

class Controller_Stats extends \Controller_Core_Theme {
	
	public function action_index() {
		$this->push_css('https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css');
		$this->push_js([
			'sessions-stats',
			'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
			'https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js',
		]);

		$data['next_cook'] = Controller_Stats_Api::_fetch_stats()['next_cook']['name'];
		$data['checksum'] = Controller_Stats_Api::_fetch_stats()['checksum'];

		$this->title = __('session.stats.title');
		$this->content = \View::forge('stats', $data);
	}
	
	public function get_reset() {
		if (\Auth::has_access('sessions.administration')) {
			\Cache::delete(Controller_Stats_Api::CACHE_KEY);
		}
		\Response::redirect_back('sessions/stats');
	}
}