<?php

$messages = [];

/** English */
$messages['en'] = [
	// Extension name
	'facebookclient-desc' => 'Enables users to [[Special:Connect|Connect]] with their [http://www.facebook.com Facebook] accounts.',

	'facebookclient-graphapi-not-configured' => 'Facebook App ID and App secret missing from configuration.',

	'prefs-facebookclient-prefstext' => 'Facebook Connect',
	'prefs-facebookclient-status-prefstext' => 'Status',

	'facebookclient-error' => 'Verification error',
	'facebookclient-errortext' => 'Yikes! It looks like that didn\'t work out. Please try again.',

	'facebookclient-connect-simple' => 'Connect',
	'facebookclient-convert' => 'Connect this account with Facebook',

	'facebookclient-disconnect-link' => 'You can also <a id="fbConnectDisconnect" href="#"> disconnect your Wikia account from Facebook.</a> You will be able to continue using your Wikia account as normal, with your history (edits, points, achievements) intact.',
	'facebookclient-disconnect-done' => 'Disconnecting <span id="fbConnectDisconnectDone">... done! </span>',
	'facebookclient-disconnect-info' => "We have emailed a new password to use with your account - you can log in with the same username as before. Hooray!",
	'facebookclient-disconnect-info-existing' => "You can still log in using your user name and password, as usual.",

	'facebookclient-unknown-error' => 'Unknown error, please try again.',

	'facebookclient-connect-existing' => 'Connect account with Facebook',
	'facebookclient-connect-login-legend' => 'Login to your existing account',
	'facebookclient-connect-username-label' => 'Username:',
	'facebookclient-connect-password-label' => 'Password:',
	'facebookclient-wrong-pass-msg' => 'The password you have entered is incorrect',
];

/**
 * Message documentation (Message documentation)
 */
$messages['qqq'] = array(
	'fbconnect-desc' => 'Short description of the FBConnect extension, shown in [[Special:Version]]. Do not translate or change links.',
	'fbconnect-disconnect-info-existing' => 'Confirmation message shown to users who have disconnected their account from Facebook but had a regular Wikia account.',
);