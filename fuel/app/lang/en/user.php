<?php

return array(
	'name' => 'User',
	'name_plural' => 'Users',
	'empty_list' => 'There are no users to show here',
	'field' => array(
		'name' => 'Name',
		'username' => 'Username',
		'surname' => 'Surname',
		'active' => 'Active',
		'iban' => [
			'' => 'IBAN',
			'show' => 'Show IBAN',
			],
		'phone' => 'Phone',
		'start_year' => 'Start year',
		'end_year' => 'End year',
		'email' => 'Email',
		'img' => 'Avatar',
		'lang' => 'Language',	
		'group' => 'Group',
	),
	'language' => [
		'en' => 'English',
		'nl' => 'Nederlands',
	],	
	'alert' => array(
		'success' => [
			'update' => 'Settings have been saved',
		],
		'error' => array(
			'no_id' => 'Cannot not find user with id <strong>:id</strong>.',
			'cur_pass' => 'Current password is incorrect.',
			'update' => 'Cannot update user settings.',
			'invalid_iban' => 'The entered <strong>:label</strong> is not a valid IBAN',
			'invalid_lang' => 'The selected </strong>:label</strong> is invalid.',
		),
	),
	'wall' => [
		'title' => 'The Wall',
		'sub' => 'of fame',
		'msg' => 'This page shows the photo frames of all current inhabitants.',
		'btn' => 'List of all users',
	],
	'view' => [
		'btn' => 'Edit settings',
		'na' => 'N/a',
	],
	'edit' => [
		'title' => 'Edit settings',
		'label' => 'Change password',
		'placeholder' => [
			'current_pass' => 'Current password',
			'new_pass' => 'New password',
			're_pass' => 'Re-type password',
		],
		'btn' => 'Save settings',
	],
	'create' => [
		'btn' => 'Add user'
	]
  );
