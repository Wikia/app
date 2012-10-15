<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * An extension for easy customisation of redirects on various events
 *
 * Simple, default scenario:
 * For redirect on account creation: add the title of a local wiki page to [[MediaWiki:Redirect-addnewaccount]]
 * For redirect after logout: add the title of a local wiki page to [[MediaWiki:Redirect-userlogoutcomplete]]
 *
 * This extension is a adaptation of 2 previously published extensions:
 * http://www.mediawiki.org/wiki/Extension:RedirectOnAccountCreation (Public Domain)
 * http://www.mediawiki.org/wiki/Extension:RedirectAfterLogout (Public Domain)
 *
 * @file
 * @ingroup Extensions
 *
 * @author Marcel Minke
 * @author Siebrand Mazeland
 * @license Creative Commons Attribution 3.0 Unported (http://creativecommons.org/licenses/by/3.0/)
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Redirect',
	'version' => '1.0',
	'author' => array( 'Marcel Minke', 'Siebrand Mazeland' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Redirect',
	'descriptionmsg' => 'redirect-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Redirect'] = $dir . 'Redirect.i18n.php';
$wgAutoloadClasses['RedirectHooks'] = $dir . 'Redirect.class.php';

$wgHooks['AddNewAccount'][] = 'RedirectHooks::afterAddNewAccount';
$wgHooks['UserLogout'][] = 'RedirectHooks::afterUserLogoutComplete';
