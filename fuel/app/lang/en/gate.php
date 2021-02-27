<?php

return [
	'login' => [
		'title' => 'Login',
		'reset' => 'I lost my password',
		'btn' => 'Login',
		'label' => [
			'username' => 'Email or username',
			'pass' => 'Password',
			'remember_me' => 'Remember me',
		],
	],
	'empty_list' => 'There are no outstanding tokens',
	'reset' => [
		'title' => 'Reset your password',
		'msg' => 'Enter your mail address to receive a mail with instructions to reset your password.',
		'btn' => 'Request password reset',
		'label' => [
			'mail' => 'Email',
		],
		'mail' => [
			'subject' => 'Password reset requested',
			'body' => 'Hi, <br><br>A password reset was requested for the account on ' . __('site_title') . ' ' . __('site_sub') . ' which was registered using this mail address. ' .
			'If you did not request your password to be reset, please ignore this mail. Otherwise, visit this link within the next hour to reset your password: <br><br>' .
			'<a href="https://:link">https://:link</a> <br><br> --HVOweb Admin',
		],
	],
	'alert' => [
		'success' => [
			'reset_mail' => 'If the given mail address is associated with an account, you will receive a mail shortly.',
			'pass_changed' => 'Your password has been changed',
		],
		'error' => [
			'invalid_token' => 'The given reset token is invalid',
			'expired_token' => 'The given token has expired',
			'pass_mismatch' => 'The given passwords do not match',
		]
	]
];

