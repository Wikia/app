<?php
$messages = [];

$messages['en'] = [
	'emailext-desc' => 'An extension to handle delivering email',
	'emailext-password-email-greeting' => 'Hi $1,',
	'emailext-password-email-content' => 'Please use this temporary password to log in to Wikia: "$1"
<br /><br />
If you didn\'t request a new password, don\'t worry! Your account is safe and secure. You can ignore this email and continue log in to Wikia with your old password.
<br /><br />
Questions or concerns? Feel free to <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">contact us</a>.',
	'emailext-password-email-signature' => 'Wikia Community Support',
	'emailext-error-throttled-mailpassword' => 'Too many resend password requests sent',
];

$messages['qqq'] = [
	'email-desc' => 'The description for this extension',
	'emailext-password-email-greeting' => 'Greeting for the forgot password email',
	'emailext-password-email-content' => 'Content for the forgot password email with instructions on how to proceed',
	'emailext-password-email-signature' => 'Signature line at the end of the forgot password email',
	'emailext-error-throttled-mailpassword' => 'Message given when a user has requested a new password too many times',
];
