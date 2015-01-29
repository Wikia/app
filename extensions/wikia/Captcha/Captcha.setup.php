<?php

// This determines which captchas to instantiate and in what order.  Used by CaptchaFactory.  Entries are class names.
$wgCaptchaPrecedence = [
	'Capcha\Modules\ReCaptcha',
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
 * $wgCaptchaWhitelistIP = array('192.168.1.0/24', '10.1.0.0/16');
 */
$wgCaptchaWhitelistIP = false;

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
$wgCaptchaStorageClass = 'Captcha\SessionStore';

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

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Captcha'] = $dir . 'Captcha.i18n.php';

$wgHooks['EditFilterMerged'][] = 'Captcha\Hooks::confirmEditMerged';
$wgHooks['UserCreateForm'][] = 'Captcha\Hooks::injectUserCreate';
$wgHooks['AbortNewAccount'][] = 'Captcha\Hooks::confirmUserCreate';
$wgHooks['LoginAuthenticateAudit'][] = 'Captcha\Hooks::triggerUserLogin';
$wgHooks['UserLoginForm'][] = 'Captcha\Hooks::injectUserLogin';
$wgHooks['EmailUserForm'][] = 'Captcha\Hooks::injectEmailUser';
$wgHooks['EmailUser'][] = 'Captcha\Hooks::confirmEmailUser';

# Register API hook
$wgHooks['APIEditBeforeSave'][] = 'Captcha\Hooks::confirmEditAPI';
$wgHooks['APIGetAllowedParams'][] = 'Captcha\Hooks::APIGetAllowedParams';
$wgHooks['APIGetParamDescription'][] = 'Captcha\Hooks::APIGetParamDescription';

$wgAutoloadClasses['Captcha\Hooks'] = $dir . 'ConfirmEditHooks.php';
$wgAutoloadClasses['Captcha\Modules\BaseCaptcha'] = $dir . 'Captcha.php';
$wgAutoloadClasses['Captcha\Store'] = $dir . 'CaptchaStore.php';
$wgAutoloadClasses['Captcha\SessionStore'] = $dir . 'CaptchaStore.php';
$wgAutoloadClasses['Captcha\CacheStore'] = $dir . 'CaptchaStore.php';
