<?php

/*
 * Not a valid entry point, skip unless MEDIAWIKI is defined.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}


$messages = array();


/** English */
$messages['en'] = array(

	// TODO: Swap in the real message once connecting to existing accounts works.
	//'fbconnect-msg-for-existing-users' => "<strong>Already a Wikia user?</strong><br/>If you would like to connect this facebook account to an existing Wikia account, please <a href='#' class='ajaxLogin'>login</a> first.",
	'fbconnect-msg-for-existing-users' => "&nbsp;",
	
	'fbconnect-invalid-email' => "Please provide a valid email address.",
	'fbconnect-wikia-login-w-facebook' => 'Log in / Sign Up with Facebook Connect',
	'fbconnect-wikia-login-bullets' => '<ul><li>Sign up in just a few clicks</li><li>You have control of what goes to your feed</li></ul>',
);

/**
 * Message documentation (Message documentation)
 */
$messages['qqq'] = array(
	'fbconnect-msg-for-existing-users' => 'This is displayed next to the username field in the choose-name form.  If a user comes to the site and facebook connects,
										   the purpose of this message is to let them know how to procede if they are actually trying to connect their facebook account
										   to an existing account.'
);
