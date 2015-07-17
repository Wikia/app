<?php
/**
 * A simple extension that adds a newly registered user
 * to default watchlists.
 *
 * @package Wikia\extensions\AutoFollow
 * @version 1.0
 * @author Adam Karminski <adamk@wikia-inc.com>
 * @see https://github.com/Wikia/app/tree/dev/extensions/wikia/AutoFollow/
 * @tags: autofollow, auto, follow, staff, blog
 */

/**
 * @global Array The list of extension credits.
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionCredits
 */
$wgExtensionCredits['other'][] = [
	'path'              => __FILE__,
	'name'              => 'AutoFollow',
	'descriptionmsg'    => 'autofollow-ext-description',
	'version'           => '1.0',
	'author'            => [
		'Adam Karminski <adamk@wikia-inc.com>'
	],
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AutoFollow/',
];

$wgExtensionMessagesFiles['AutoFollow'] = __DIR__ . '/AutoFollow.i18n.php';

$wgAutoloadClasses['Wikia\AutoFollow\AutoFollowHooks'] = __DIR__ . '/AutoFollow.hooks.php';
$wgAutoloadClasses['Wikia\AutoFollow\AutoFollowTask'] = __DIR__ . '/AutoFollowTask.class.php';

$wgHooks['SignupConfirmEmailComplete'][] = 'Wikia\AutoFollow\AutoFollowHooks::onSignupConfirmEmailComplete';

/**
 * @global Array A language code to its community wikia's city_id map
 */
$wgAutoFollowLangCityIdMap = [
	'de' => 1779,
	'en' => 177,
	'es' => 3487,
	'fi' => 3083,
	'fr' => 10261,
	'it' => 11250,
	'ja' => 3439,
	'nl' => 10466,
	'pl' => 1686,
	'pt' => 696403,
	'ru' => 3321,
	'uk' => 3321, // Add Ukrainian users to the blog in Russian
	'zh' => 4079,
];

/**
 * @global Array A key of a flag set by the extension
 */
$wgAutoFollowFlag = 'autowatched-already';
