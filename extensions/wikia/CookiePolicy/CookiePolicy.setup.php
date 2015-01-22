<?

/**
 * @global Array $wgExtensionCredits The list of extension credits.
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionCredits
 */
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'CookiePolicy',
	'descriptionmsg' => 'wikia-in-your-lang-description',
	'version' => '1.0',
	'author' => [
		'Liz Lee <liz@wikia-inc.com>'
	],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CookiePolicy/',
);

$wgExtensionMessagesFiles['CookiePolicy'] = __DIR__ . '/CookiePolicy.i18n.php';

$wgAutoloadClasses['Wikia\CookiePolicy\CookiePolicyHooks'] = __DIR__ . '/CookiePolicy.hooks.php';

/**
 * Use ResourceLoader to load the JavaScript module
 */
$wgResourceModules['ext.cookiePolicy'] = [
	'localBasePath' => __DIR__ . '/scripts',
	'remoteExtPath' => 'wikia/CookiePolicy/scripts',
	'scripts' => 'cookiePolicy.js',
	'messages' => [
		'oasis-eu-cookie-policy-notification-message',
		'oasis-eu-cookie-policy-notification-link-text',
	],
	'dependencies' => [
		'wikia.cookies',
		'wikia.geo',
	],
];

/**
 * Add the JavaScript module to the output
 */
$wgHooks['BeforePageDisplay'][] = "Wikia\CookiePolicy\CookiePolicyHooks::onBeforePageDisplay";
