<?php
$messages = [];

$messages['en'] = [
	// General messages
	'emailext-desc' => 'An extension to handle delivering email',
	'emailext-no-reply-name' => 'No Reply',

	// General errors
	'emailext-error-restricted-controller' => 'Access to this controller is restricted',
	'emailext-error-noname' => 'Required username has been left empty',
	'emailext-error-not-user' => 'Unable to create user object',
	'emailext-error-empty-user' => 'Unable to find user',
	'emailext-error-noemail' => 'User has no email address',
	'emailext-error-no-emails' => 'User does not wish to receive email',
	'emailext-error-user-blocked' => 'User is blocked from taking this action',

	// Forgot password messages and errors
	'emailext-password-email-greeting' => 'Hi $1,',
	'emailext-password-email-content' => 'Please use this temporary password to log in to Wikia: "$1"
<br /><br />
If you didn\'t request a new password, don\'t worry! Your account is safe and secure. You can ignore this email and continue log in to Wikia with your old password.
<br /><br />
Questions or concerns? Feel free to <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">contact us</a>.',
	'emailext-password-email-signature' => 'Wikia Community Support',
	'emailext-password-email-subject' => 'Reset password request',
	'emailext-error-password-throttled' => 'Too many resend password requests sent',
	'emailext-error-password-reset-forbidden' => 'This user is not allowed to change their password',
];

$messages['qqq'] = [
	// General messages
	'email-desc' => 'The description for this extension',
	'emailext-no-reply-name' => 'Name for sender of "no reply" email address',

	// General errors
	'emailext-error-restricted-controller' => 'Error message shown when an unauthorized user tries to access this extension',
	'emailext-error-noname' => 'Error message when a username was expected and an empty string was given instead',
	'emailext-error-not-user' => 'Error message when the code tried to create a User object but failed',
	'emailext-error-empty-user' => 'Error message when the code successfully creates a User object but it is an empty/anonymous user',
	'emailext-error-noemail' => 'Error message given when the user who is the recipient of an email does not have an email address on file',
	'emailext-error-no-emails' => 'Error message given when has unsubscribed from all Wikia email',
	'emailext-error-user-blocked' => 'Error message given when the user who triggered the email is blocked',

	// Forgot password messages and errors
	'emailext-password-email-greeting' => 'Greeting for the forgot password email',
	'emailext-password-email-content' => 'Content for the forgot password email with instructions on how to proceed',
	'emailext-password-email-signature' => 'Signature line at the end of the forgot password email',
	'emailext-password-email-subject' => 'Subject of the forgot password email',
	'emailext-error-password-throttled' => 'Error message given when a user has requested a new password too many times',
	'emailext-error-password-reset-forbidden' => 'Error shown when the user requesting a password reset does not have permission to do so',

];
