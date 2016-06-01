<?php

/**
 * ConfirmEdit MediaWiki extension.
 *
 * This is a framework that holds a variety of CAPTCHA tools. The
 * default one, 'SimpleCaptcha', is not intended as a production-
 * level CAPTCHA system, and another one of the options provided
 * should be used in its place for any real usages.
 *
 * Copyright (C) 2005-2007 Brion Vibber <brion@wikimedia.org>
 * http://www.mediawiki.org/
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

$wgExtensionFunctions[] = 'confirmEditSetup';
$wgExtensionCredits['antispam'][] = array(
	'path' => __FILE__,
	'name' => 'ConfirmEdit',
	'author' => array( 'Brion Vibber', '...' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:ConfirmEdit',
	'version' => '1.1',
	'descriptionmsg' => 'captcha-desc',
);

/**
 * List of IP ranges to allow to skip the captcha, similar to the group setting:
 * "$wgGroupPermission[...]['skipcaptcha'] = true"
 *
 * Specific IP addresses or CIDR-style ranges may be used,
 * for instance:
 * $wgCaptchaWhitelistIP = array('192.168.1.0/24', '10.1.0.0/16');
 */
$wgCaptchaWhitelistIP = false;

$wgCaptcha = null;
$wgCaptchaClass = 'SimpleCaptcha';

/**
 * Actions which can trigger a captcha
 *
 * If the 'edit' trigger is on, *every* edit will trigger the captcha.
 * This may be useful for protecting against vandalbot attacks.
 *
 * If using the default 'addurl' trigger, the captcha will trigger on
 * edits that include URLs that aren't in the current version of the page.
 * This should catch automated linkspammers without annoying people when
 * they make more typical edits.
 *
 * The captcha code should not use $wgCaptchaTriggers, but CaptchaTriggers()
 * which also takes into account per namespace triggering.
 */
$wgCaptchaTriggers = array();
$wgCaptchaTriggers['edit']          = false; // Would check on every edit
$wgCaptchaTriggers['create']        = false; // Check on page creation.
$wgCaptchaTriggers['sendemail']     = false; // Special:Emailuser
$wgCaptchaTriggers['addurl']        = true;  // Check on edits that add URLs
$wgCaptchaTriggers['createaccount'] = true;  // Special:Userlogin&type=signup
$wgCaptchaTriggers['badlogin']      = true;  // Special:Userlogin after failure

/**
 * You may wish to apply special rules for captcha triggering on some namespaces.
 * $wgCaptchaTriggersOnNamespace[<namespace id>][<trigger>] forces an always on /
 * always off configuration with that trigger for the given namespace.
 * Leave unset to use the global options ($wgCaptchaTriggers).
 *
 * Shall not be used with 'createaccount' (it is not checked).
 */
$wgCaptchaTriggersOnNamespace = array();

# Example:
# $wgCaptchaTriggersOnNamespace[NS_TALK]['create'] = false; //Allow creation of talk pages without captchas.
# $wgCaptchaTriggersOnNamespace[NS_PROJECT]['edit'] = true; //Show captcha whenever editing Project pages.

/**
 * Indicate how to store per-session data required to match up the
 * internal captcha data with the editor.
 *
 * 'CaptchaSessionStore' uses PHP's session storage, which is cookie-based
 * and may fail for anons with cookies disabled.
 *
 * 'CaptchaCacheStore' uses $wgMemc, which avoids the cookie dependency
 * but may be fragile depending on cache configuration.
 */
$wgCaptchaStorageClass = 'CaptchaSessionStore';

/**
 * Number of seconds a captcha session should last in the data cache
 * before expiring when managing through CaptchaCacheStore class.
 *
 * Default is a half hour.
 */
$wgCaptchaSessionExpiration = 30 * 60;

/**
 * Number of seconds after a bad login that a captcha will be shown to
 * that client on the login form to slow down password-guessing bots.
 *
 * Has no effect if 'badlogin' is disabled in $wgCaptchaTriggers or
 * if there is not a caching engine enabled.
 *
 * Default is five minutes.
 */
$wgCaptchaBadLoginExpiration = 5 * 60;

/**
 * Allow users who have confirmed their e-mail addresses to post
 * URL links without being harassed by the captcha.
 */
$ceAllowConfirmedEmail = false;

/**
 * Number of bad login attempts before triggering the captcha.  0 means the
 * captcha is presented on the first login.
 */
$wgCaptchaBadLoginAttempts = 3;

/**
 * Regex to whitelist URLs to known-good sites...
 * For instance:
 * $wgCaptchaWhitelist = '#^https?://([a-z0-9-]+\\.)?(wikimedia|wikipedia)\.org/#i';
 * Local admins can define a whitelist under [[MediaWiki:captcha-addurl-whitelist-confirm-edit]]
 */
$wgCaptchaWhitelist = false;

/**
 * Additional regexes to check for. Use full regexes; can match things
 * other than URLs such as junk edits.
 *
 * If the new version matches one and the old version doesn't,
 * toss up the captcha screen.
 *
 * @fixme Add a message for local admins to add items as well.
 */
$wgCaptchaRegexes = array();

/** Register special page */
$wgSpecialPages['Captcha'] = 'CaptchaSpecialPage';

$wgConfirmEditIP = dirname( __FILE__ );
$wgExtensionMessagesFiles['ConfirmEdit'] = "$wgConfirmEditIP/ConfirmEdit.i18n.php";
$wgExtensionMessagesFiles['ConfirmEditAlias'] = "$wgConfirmEditIP/ConfirmEdit.alias.php";

$wgHooks['EditFilterMerged'][] = 'ConfirmEditHooks::confirmEditMerged';
$wgHooks['UserCreateForm'][] = 'ConfirmEditHooks::injectUserCreate';
$wgHooks['AbortNewAccount'][] = 'ConfirmEditHooks::confirmUserCreate';
$wgHooks['LoginAuthenticateAudit'][] = 'ConfirmEditHooks::triggerUserLogin';
$wgHooks['UserLoginForm'][] = 'ConfirmEditHooks::injectUserLogin';
//$wgHooks['AbortLogin'][] = 'ConfirmEditHooks::confirmUserLogin';
$wgHooks['EmailUserForm'][] = 'ConfirmEditHooks::injectEmailUser';
$wgHooks['EmailUser'][] = 'ConfirmEditHooks::confirmEmailUser';
# Register API hook
$wgHooks['APIEditBeforeSave'][] = 'ConfirmEditHooks::confirmEditAPI';
$wgHooks['APIGetAllowedParams'][] = 'ConfirmEditHooks::APIGetAllowedParams';
$wgHooks['APIGetParamDescription'][] = 'ConfirmEditHooks::APIGetParamDescription';

$wgAutoloadClasses['ConfirmEditHooks'] = "$wgConfirmEditIP/ConfirmEditHooks.php";
$wgAutoloadClasses['SimpleCaptcha'] = "$wgConfirmEditIP/Captcha.php";
$wgAutoloadClasses['CaptchaStore'] = "$wgConfirmEditIP/CaptchaStore.php";
$wgAutoloadClasses['CaptchaSessionStore'] = "$wgConfirmEditIP/CaptchaStore.php";
$wgAutoloadClasses['CaptchaCacheStore'] = "$wgConfirmEditIP/CaptchaStore.php";
$wgAutoloadClasses['CaptchaSpecialPage'] = "$wgConfirmEditIP/ConfirmEditHooks.php";
$wgAutoloadClasses['HTMLCaptchaField'] = "$wgConfirmEditIP/HTMLCaptchaField.php";

/**
 * Set up $wgWhitelistRead
 */
function confirmEditSetup() {
	global $wgGroupPermissions, $wgCaptchaTriggers;
	if ( !$wgGroupPermissions['*']['read'] && $wgCaptchaTriggers['badlogin'] ) {
		// We need to ensure that the captcha interface is accessible
		// so that unauthenticated users can actually get in after a
		// mistaken password typing.
		global $wgWhitelistRead;
		$image = SpecialPage::getTitleFor( 'Captcha', 'image' );
		$help = SpecialPage::getTitleFor( 'Captcha', 'help' );
		$wgWhitelistRead[] = $image->getPrefixedText();
		$wgWhitelistRead[] = $help->getPrefixedText();
	}
}
