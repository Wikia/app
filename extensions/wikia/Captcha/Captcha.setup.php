<?php

/**
 * @file
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

$wgExtensionCredits['captcha'][] = [
	'path' => __FILE__,
	'name' => 'Captcha',
	'author' => ['Garth Webb'],
	'descriptionmsg' => 'captcha-desc',
];

/**
 * The 'skipcaptcha' permission key can be given out to
 * let known-good users perform triggering actions without
 * having to go through the captcha.
 *
 * By default, sysops and registered bot accounts will be
 * able to skip, while others have to go through it.
 */
$wgGroupPermissions['*'            ]['skipcaptcha'] = false;
$wgGroupPermissions['user'         ]['skipcaptcha'] = false;
$wgGroupPermissions['autoconfirmed']['skipcaptcha'] = false;
$wgGroupPermissions['bot'          ]['skipcaptcha'] = true; // registered bots
$wgGroupPermissions['sysop'        ]['skipcaptcha'] = true;
$wgAvailableRights[] = 'skipcaptcha';

/**
 * List of IP ranges to allow to skip the captcha, similar to the group setting:
 * "$wgGroupPermission[...]['skipcaptcha'] = true"
 *
 * Specific IP addresses or CIDR-style ranges may be used,
 * for instance:
 * $wgCaptchaWhitelistIP = [ '192.168.1.0/24', '10.1.0.0/16' ];
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
$wgCaptchaTriggers = [];
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
$wgCaptchaTriggersOnNamespace = [];

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
$wgCaptchaStorageClass = 'Captcha\Store\Session';

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
$wgAllowConfirmedEmail = false;

/**
 * Number of bad login attempts before triggering the captcha.  0 means the
 * captcha is presented on the first login.
 */
$wgCaptchaBadLoginAttempts = 3;

/**
 * Regex to whitelist URLs to known-good sites...
 * For instance:
 * $wgCaptchaWhitelist = '#^https?://([a-z0-9-]+\\.)?(wikimedia|wikipedia)\.org/#i';
 * Local admins can define a whitelist under [[MediaWiki:captcha-addurl-whitelist]]
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
$wgCaptchaRegexes = [];

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['Captcha'] = "$dir/Captcha.i18n.php";

$wgHooks['EditFilterMerged'][] = 'Captcha\Hooks::confirmEditMerged';
$wgHooks['UserCreateForm'][] = 'Captcha\Hooks::injectUserCreate';
$wgHooks['AbortNewAccount'][] = 'Captcha\Hooks::confirmUserCreate';
$wgHooks['LoginAuthenticateAudit'][] = 'Captcha\Hooks::triggerUserLogin';
$wgHooks['UserLoginForm'][] = 'Captcha\Hooks::injectUserLogin';
// $wgHooks['AbortLogin'][] = 'Captcha\Hooks::confirmUserLogin';
$wgHooks['EmailUserForm'][] = 'Captcha\Hooks::injectEmailUser';
$wgHooks['EmailUser'][] = 'Captcha\Hooks::confirmEmailUser';

# Register API hook
$wgHooks['APIEditBeforeSave'][] = 'Captcha\Hooks::confirmEditAPI';
$wgHooks['APIGetAllowedParams'][] = 'Captcha\Hooks::APIGetAllowedParams';
$wgHooks['APIGetParamDescription'][] = 'Captcha\Hooks::APIGetParamDescription';

/**
 * Autoload classes
 */

// Load Factories
$wgAutoloadClasses['Captcha\Factory\Module'] = "$dir/Factory/Module.class.php";
$wgAutoloadClasses['Captcha\Factory\Store'] = "$dir/Factory/Store.class.php";

// Load captcha modules
$wgAutoloadClasses['Captcha\Module\BaseCaptcha'] = "$dir/Module/BaseCaptcha.class.php";
$wgAutoloadClasses['Captcha\Module\ReCaptcha'] = "$dir/Module/ReCaptcha.class.php";

// Load storage modules
$wgAutoloadClasses['Captcha\Store\Base'] = "$dir/Store/Base.class.php";
$wgAutoloadClasses['Captcha\Store\Session'] = "$dir/Store/Session.class.php";
$wgAutoloadClasses['Captcha\Store\Cache'] = "$dir/Store/Cache.class.php";

// Main classes
$wgAutoloadClasses['Captcha\Handler'] = "$dir/Captcha.class.php";
$wgAutoloadClasses['CaptchaController'] = "$dir/CaptchaController.class.php";
$wgAutoloadClasses['Captcha\Hooks'] = "$dir/CaptchaHooks.class.php";

$wgCaptchaPrecedence = [
	'Captcha\Module\ReCaptcha'
];

// Always load the recaptcha shiz ... for now
$wgHooks['BeforePageDisplay'][] = 'efReCaptchaOnBeforePageDisplay';

/**
 * @param OutputPage $out
 * @param Skin $skin
 *
 * @return bool
 */
function efReCaptchaOnBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
	$langCode = $out->getContext()->getLanguage()->getCode();

	$src = str_replace( '$1', $langCode, Captcha\Module\ReCaptcha::API_URL_TEMPLATE );
	$out->addScript( '<script src="' . $src . '" async defer></script>' );
	return true;
}
