<?php

/**
 * Controller regulating access to protected pages. 
 * Implement this controller when a page needs logging in. 
 */
class Controller_Gate extends Controller_Core_Theme
{
	public function action_login() {
		// Already logged in
		Auth::check() and Response::redirect('/');
		
		$val = Validation::forge();

		if (Input::method() == 'POST') {
			// Create validator rules			
			$val->add('email', 'Email or Username')
			    ->add_rule('required');
			$val->add('password', 'Password')
			    ->add_rule('required');

			// Run validator
			if ($val->run()) {
				if (!Auth::check()) {
					if (Auth::login(Input::post('email'), Input::post('password'))) {
						if (($id = Auth::get_user_id()) !== false) {			
							// Does the user want to be remembered?
							if((Input::post('rememberme') == 'on' ? true : false)) {
								Auth::remember_me();
							} else {
								Auth::dont_remember_me();
							}
							
							$dest = Input::post('destination', '/');
							Response::redirect($dest);
						}
					} else {
						\View::set_global('login_error', 'Login failed!');
					}
				} else {
					\View::set_global('login_error', 'Already logged in!');
				}
			}
		}

		$this->push_css('gate/login');
		$this->push_js('gate/login');

		$this->title = 'Login';
		$this->content = View::forge('gate/login', array('val' => $val), false);
	}

	public function action_logout() {
		Auth::dont_remember_me();
		Auth::logout();
		Response::redirect('/');
	}

	/**
	 * Returns a random background image
	 *
	 * @throws FileAccessException
	 * @throws HttpNotFoundException
	 * @throws InvalidPathException
	 */
	public function get_login_image() {
		// Read login/ directory in image assets to find available pictures
		$image_dir = DOCROOT . Config::get('asset.paths.0') . Config::get('asset.img_dir') . 'login/';
		$images = File::read_dir($image_dir, 1, [
			// only get PNGs, JPGs and JPEGs
			'\.png$' => 'file',
			'\.jpg$' => 'file',
			'\.jpeg$' => 'file'
		]);
		// Return a 404 if no images were found
		if (is_null($images) or sizeof($images) == 0) {
			throw new HttpNotFoundException;
		}

		// Choose a random image
		$image_string = $images[array_rand($images, 1)];

		// Get full image path and the mimetype
		$image_path = $image_dir . $image_string;
		$image_mimetype = File::file_info($image_path)['mimetype'];

		// Send image inline
		File::download($image_path, null, $image_mimetype, null, false, 'inline');
	}
}
