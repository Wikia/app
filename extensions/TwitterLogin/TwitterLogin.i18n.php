<?php

/**
 * Internationalization file for the TwitterLogin extension.
 *
 * @file TwitterLogin.i18n.php
 *
 * @author David Raison
 */

$messages = array();

/** English
 * @author David Raison
 */
$messages['en'] = array(
	'twitterlogin' => 'Sign in using Twitter',
	'twitterlogin-signup' => 'You can register to this wiki using your twitter account',
	'twiterlogin-tietoaccount' => 'You are currently logged into this wiki as $1.<br/>You may sign in with Twitter to tie your twitter account to your existing mediawiki account.',
	'twitterlogin-desc' => 'Register and log in to a mediawiki using your twitter account',
	'twitterlogin-alreadyloggedin' => 'You\'re already logged in.',
	'twitterlogin-couldnotconnect' => 'Could not connect to Twitter. Refresh the page or try again later.'
);

/** Message Documentation
 * @author David Raison
 */
$messages['qqq'] = array(
	'twitterlogin' => 'Link of the special page',
	'twitterlogin-signup' => 'Explains users they can register and sign up to the wiki with their twitter account. Used on specialpage default.',
	'twiterlogin-tietoaccount' => 'Message displayed on the default specialpage when a logged in user visits it. (NOT in use)',
	'twitterlogin-desc' => 'Description of the extension, see setup file',
	'twitterlogin-alreadyloggedin' => 'Message displayed on the default specialpage. tietoaccount replacement.',
	'twitterlogin-couldnotconnect' => 'Tell the user the connection to twitter oauth server did not work.'
);
