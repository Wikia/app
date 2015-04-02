<?php
$messages = [];

$messages['en'] = [
	// General messages
	'emailext-desc' => 'An extension to handle delivering email',
	'emailext-no-reply-name' => 'No Reply',
	'emailext-fans-tagline' => 'The Social Universe for Fans by Fans<sup>TM</sup>',

	// Forgot password messages
	'emailext-password-email-greeting' => 'Hi $1,',
	'emailext-password-email-content' => 'Please use this temporary password to log in to Wikia: "$1"
<br /><br />
If you didn\'t request a new password, don\'t worry! Your account is safe and secure. You can ignore this email and continue log in to Wikia with your old password.
<br /><br />
Questions or concerns? Feel free to <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">contact us</a>.',
	'emailext-password-email-signature' => 'Wikia Community Support',
	'emailext-password-email-subject' => 'Reset password request',

	// Common email template messages (see i18n directory for email-specific messages)
	'emailext-fanverse-tagline' => 'The Social Universe for Fans by Fans',
	'emailext-recipient-notice' => 'Email sent to $1 from Wikia',
	'emailext-update-frequency' => 'To change which emails you receive or their frequency, please visit your [{{fullurl:Special:Preferences|#mw-prefsection-emailv2}} Preferences] page.',
	'emailext-unsubscribe' => 'To unsubscribe from all Wikia emails, click [$1 here].',
];

$messages['qqq'] = [
	// General messages
	'email-desc' => 'The description for this extension',
	'emailext-no-reply-name' => 'Name for sender of "no reply" email address',
	'emailext-fans-tagline' => 'Tagline for the footer of the email',

	// Forgot password messages
	'emailext-password-email-greeting' => 'Greeting for the forgot password email',
	'emailext-password-email-content' => 'Content for the forgot password email with instructions on how to proceed',
	'emailext-password-email-signature' => 'Signature line at the end of the forgot password email',
	'emailext-password-email-subject' => 'Subject of the forgot password email',

	// Common email template messages (see i18n directory for email-specific messages)
	'emailext-fanverse-tagline' => 'Trademarked tagline for Wikia.',
	'emailext-watchedpage-notice' => 'Informs the user who the intended recipient of the email is. $1 is the recipient\'s email address.',
	'emailext-update-frequency' => 'Provides a link for users to update their email preferences',
	'emailext-unsubscribe' => 'Provides a link for users to opt out of emails altogether. $1 is the unsubscribe link.',
];
