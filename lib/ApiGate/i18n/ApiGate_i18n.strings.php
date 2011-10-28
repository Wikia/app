<?php
/**
 * Internationalisation file for API Gate library.
 *
 * Currently, this is meant to be included by a MediaWiki internationalization file, so
 * the format is designed to be compatible with that.
 */

$messages = array();

/** English
 *
 */
$messages['en'] = array(
	'apigate' => 'API Gate',
	'apigate-mysql-error' => 'There was a db error with query<br/>\"$1\"<br/><br/>Error was: \"$2\"',
	
	'apigate-intro' => 'Welcome to the Control Panel for managing your API keys.<br/><br/>This panel will let you control your contact-information (in case something goes wrong), see all of your API keys, and view usage statistics for each key.',

	'apigate-register-title' => 'Get an API Key',
	'apigate-register-heading' => 'Get an API Key',
	'apigate-register-name' => 'Name*',
	'apigate-register-hint-firstname' => 'First',
	'apigate-register-hint-lastname' => 'Last',
	'apigate-register-email' => 'Email*',
	'apigate-register-hint-email' => 'Email address',
	'apigate-register-hint-confirm-email' => 'Confirm email',
	'apigate-register-submit' => 'Submit',
	'apigate-register-implicit-agreement' => 'By clicking the button, you agree to the Terms of Service.',
	'apigate-register-error-noname' => 'Please enter your name.',
	'apigate-register-error-invalid-email' => 'Please enter a valid email address.',
	'apigate-register-error-email-doesnt-match' => 'Email addresses entered do not match.',
	'apigate-register-error-mysql_error' => 'Error trying to save new API key to the database.',
);

/** Message documentation (Message documentation)
 *
 */
$messages['qqq'] = array(
	'apigate' => 'The name of the system. Used anywhere branding is needed.',
	'apigate-intro' => 'This description is meant to be the first thing a user sees when they hit the control-panel page.',
	'apigate-register-title' => "The title tag of the registration page.",
	'apigate-register-heading' => "The top-level heading of the registration page.",
	'apigate-register-name' => 'Heading of the Name fields in the registration form. Asterisk is to indicate that it is required.',
	'apigate-register-hint-firstname' => 'HTML 5 Placeholder text in the text field for first name',
	'apigate-register-hint-lastname' => 'HTML 5 Placeholder text in the text field for last name (surname)',
	'apigate-register-email' => 'Heading of the Email field of the registration page. Asterisk is to indicate that it is required.',
	'apigate-register-submit' => 'Text on the submit button on the key-registration form.',
);
