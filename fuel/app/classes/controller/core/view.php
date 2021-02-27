<?php

/**
 * Provides basic utilities for view generating controllers such as
 * additional stylesheet and script injection as well as setting a current_user
 * variable available to all views.
 * @author Melcher
 */
class Controller_Core_View extends Controller_Core_Lang {
	
	/**
	 * List of additional scripts to be loaded
	 * @var array
	 */
	private $add_js = [];
	
	/**
	 * List of additional stylesheets to be loaded
	 * @var array
	 */
	private $add_css = [];
	
	/**
	 * Add additional stylesheet(s).
	 * @param mixed $sheet Either a stylesheet name, url or array of stylesheets or urls.
	 */
	public function push_css($sheet) {
		if (is_array($sheet)) {
			foreach ($sheet as $single_sheet) {
				$this->push_css($single_sheet);
			}
		} else {
			$sheet .= Str::ends_with($sheet, '.css', true) ? '' : '.css';
			if (!in_array($sheet, $this->add_css)) {
				array_push($this->add_css, $sheet);
			}
		}
	}
	
	/**
	 * Add additional script(s).
	 * @param mixed $script Either a scriptname, url or array of scriptnames or urls.
	 */
	public function push_js($script) {
		if (is_array($script)) {
			foreach ($script as $single_script) {
				$this->push_js($single_script);
			}
		} else {
			$script .= Str::ends_with($script, '.js', true) ? '' : '.js';
			if (!in_array($script, $this->add_js)) {
				array_push($this->add_js, $script);
			}
		}
	}
	
	public function before() {
		parent::before();
		
		// Set global current_user for view
		View::set_global('current_user', $this->current_user);
	}
	
	public function after($reponse) {
		$theme = Theme::instance();
    
		// Inject CSS and JS files into template
		$theme->get_template()
			->set('add_js', $this->add_js)
			->set('add_css', $this->add_css);
		
		return parent::after($reponse);
	}
}
