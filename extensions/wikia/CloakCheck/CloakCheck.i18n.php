<?php

$messages = array();

$messages['en'] = array(
	'cloakcheck' => 'IRC cloak eligibility check',
	'cloakcheck-desc' => 'Provides an all-in-one interface to verify requirements for an IRC cloak',

	#form
	##only seen by staff
	'cloakcheck-form-username' => 'Username:',
	'cloakcheck-form-check' => 'Check username',
	##only seen by non-staff
	'cloakcheck-form-check-self' => 'Check IRC cloak eligibility',

	#process
	'cloakcheck-process-empty' => 'Username must not be empty.',
	'cloakcheck-process-notexist' => 'Username does not exist.',

	'cloakcheck-process-username' => 'Username: $1',

	'cloakcheck-process-accountage-yes' => 'Account is old enough.',
	'cloakcheck-process-accountage-no' => 'Account is too new.',

	'cloakcheck-process-emailconf-yes' => 'E-mail address confirmed.',
	'cloakcheck-process-emailconf-no' => 'E-mail address not confirmed.',

	'cloakcheck-process-edits-yes' => 'User has enough edits.',
	'cloakcheck-process-edits-no' => 'User does not have enough edits.',
);
