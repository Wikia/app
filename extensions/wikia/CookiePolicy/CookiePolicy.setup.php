<?
/**
 * @global Array $wgExtensionCredits The list of extension credits.
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionCredits
 */
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'CookiePolicy',
	'descriptionmsg' => 'cookie-policy-description',
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
$wgResourceModules['ext.cookiePolicyMessages'] = [
	'localBasePath' => __DIR__ . '/scripts',
	'remoteExtPath' => 'wikia/CookiePolicy/scripts',
	'messages' => [
		'cookie-policy-notification-message',
	],
	'dependencies' => [
		// needed for message wikitext parsing
		'mediawiki.jqueryMsg',
	],
];

/**
 * Add the JavaScript module to the output
 */
$wgHooks['BeforePageDisplay'][] = "Wikia\CookiePolicy\CookiePolicyHooks::onBeforePageDisplay";
