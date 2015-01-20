<?php
/**
 * A simple extension that adds a newly registered user
 * to default watchlists.
 *
 * @package Wikia\extensions\AutoFollow
 * @version 1.0
 * @author Adam Karminski <adamk@wikia-inc.com>
 * @see https://github.com/Wikia/app/tree/dev/extensions/wikia/AutoFollow/
 */

/**
 * @global Array The list of extension credits.
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionCredits
 */
$wgExtensionCredits['other'][] = array(
	'path'              => __FILE__,
	'name'              => 'AutoFollow',
	'descriptionmsg'    => 'autofollow-ext-description',
	'version'           => '1.0',
	'author'            => [
		'Adam Karminski <adamk@wikia-inc.com>'
	],
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AutoFollow/',
);

$wgExtensionMessagesFiles['AutoFollow'] = __DIR__ . '/AutoFollow.i18n.php';

$wgAutoloadClasses['Wikia\AutoFollow\AutoFollowHooks'] = __DIR__ . '/AutoFollow.hooks.php';
$wgAutoloadClasses['Wikia\AutoFollow\AutoFollowTasks'] = __DIR__ . '/AutoFollowTasks.class.php';

$wgHooks['ConfirmEmailComplete'][] = "Wikia\AutoFollow\AutoFollowHooks::onConfirmEmailComplete";
