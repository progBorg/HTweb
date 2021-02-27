<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */

return array(

	/**
	 * Default setup group
	 */
	'default_setup' => 'default',

	/**
	 * Default setup groups
	 */
	'setups' => array(
		'default' => array(),
	),

	/**
	 * Default settings
	 */
	'defaults' => array(

		/**
		 * Mail useragent string
		 */
		'useragent' => 'FuelPHP, PHP 7.4 Framework',

		/**
		 * Mail driver (mail, smtp, sendmail, noop)
		 */
		'driver' => 'mail',

		/**
		 * Whether to send as html, set to null for autodetection.
		 */
		'is_html' => true,

		/**
		 * Email charset
		 */
		'charset' => 'utf-8',

		/**
		 * Whether to encode subject and recipient names.
		 * Requires the mbstring extension: http://www.php.net/manual/en/ref.mbstring.php
		 */
		'encode_headers' => true,

		/**
		 * Ecoding (8bit, base64 or quoted-printable)
		 */
		'encoding' => '8bit',

		/**
		 * Email priority
		 */
		'priority' => \Email::P_NORMAL,

		/**
		 * Default sender details
		 */
		'from' => array(
			'email' => 'no-reply@hetverreoosten.com',
			'name'  => 'HVO Web',
		),

		/**
		 * Whether to validate email addresses
		 */
		'validate' => true,

		/**
		 * Auto attach inline files
		 */
		'auto_attach' => true,

		/**
		 * Auto generate alt body from html body
		 */
		'generate_alt' => true,

		/**
		 * Forces content type multipart/related to be set as multipart/mixed.
		 */
		'force_mixed' => false,

		/**
		 * Wordwrap size, set to null, 0 or false to disable wordwrapping
		 */
		'wordwrap' => 0,

		/**
		 * Newline
		 */
		'newline' => "\n",

		/**
		 * Attachment paths
		 */
		'attach_paths' => array(
			'', 		// absolute path
			DOCROOT, 	// relative to docroot.
		),

		/**
		 * Default return path
		 */
		'return_path' => false,

		/**
		 * Remove html comments
		 */
		'remove_html_comments' => true,

		/**
		 * When relative protocol uri's ("//uri") are used in the email body,
		 * you can specify here what you want them to be replaced with. Options
		 * are "http://", "https://" or \Input::protocol() if you want to use
		 * whatever was used to request the controller.
		 */
		'relative_protocol_replacement' => false,
	),
);
