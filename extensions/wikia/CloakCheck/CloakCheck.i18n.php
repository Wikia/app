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

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'cloakcheck' => 'Controle in aanmerking komen voor IRC cloak',
	'cloakcheck-desc' => 'Biedt een interface voor het controleren op de voorwaarden voor een IRC-cloak',
	'cloakcheck-form-username' => 'Gebruikersnaam:',
	'cloakcheck-form-check' => 'Gebruikersnaam controleren',
	'cloakcheck-form-check-self' => 'Controleren of ik in aanmerking kom voor een IRC-cloak',
	'cloakcheck-process-empty' => 'Gebruikersnaam kan niet leeg zijn.',
	'cloakcheck-process-notexist' => 'De gebruikersnaam bestaat niet.',
	'cloakcheck-process-username' => 'Gebruikersnaam: $1',
	'cloakcheck-process-accountage-yes' => 'De gebruiker bestaat al lang genoeg.',
	'cloakcheck-process-accountage-no' => 'De gebruiker bestaat nog niet lang genoeg.',
	'cloakcheck-process-emailconf-yes' => 'Het e-mailadres is bevestigd.',
	'cloakcheck-process-emailconf-no' => 'Het e-mailadres is niet bevestigd.',
	'cloakcheck-process-edits-yes' => 'De gebruiker heeft voldoende bewerkingen gemaakt.',
	'cloakcheck-process-edits-no' => 'De gebruiker heeft onvoldoende bewerkingen gemaakt.',
);

/** Russian (Русский)
 * @author Eleferen
 */
$messages['ru'] = array(
	'cloakcheck-form-username' => 'Имя участника:',
	'cloakcheck-process-notexist' => 'Участника с таким именем не существует.',
	'cloakcheck-process-username' => 'Имя участника: $1',
	'cloakcheck-process-emailconf-yes' => 'Адрес электронной почты подтверждён.',
	'cloakcheck-process-emailconf-no' => 'Адрес электронной почты не подтверждён.',
	'cloakcheck-process-edits-yes' => 'Участником сделано необходимое число правок.',
	'cloakcheck-process-edits-no' => 'Участником не сделано необходимого числа правок.',
);

