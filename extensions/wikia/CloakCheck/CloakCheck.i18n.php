<?php
$messages = array();

$messages['en'] = array(
	'cloakcheck' => 'IRC CloakChecker', 
	'cloakcheck-desc' => 'provides an all-in-one interface to verify requirements for an IRC cloak',

	#form
	##only seen by staff
	'cloakcheck-form-username' => 'Username', 
	'cloakcheck-form-check' => 'check username', 
	##only seen by non-staff
	'cloakcheck-form-check-self' => 'Check my status', 

	#process
	'cloakcheck-process-empty' => 'username must not empty', 
	'cloakcheck-process-notexist' => 'username not exist',
	
	'cloakcheck-process-username' => 'Username: $1',

	'cloakcheck-process-accountage-yes' => 'Account old enough',
	'cloakcheck-process-accountage-no' => 'Account too new',

	'cloakcheck-process-emailconf-yes' => 'Email confirmed',
	'cloakcheck-process-emailconf-no' => 'Email not confirmed',

	'cloakcheck-process-edits-yes' => 'Enough edits',
	'cloakcheck-process-edits-no' => 'Not enough edits',
);
