<?php
/**
 * Manages data on wikia's PowerUsers
 *
 * @package Wikia\extensions\PowerUser
 * @version 1.0
 * @author Adam Karminski <adamk@wikia-inc.com>
 * @see https://github.com/Wikia/app/tree/dev/extensions/wikia/PowerUser/
 */

/**
 * @global Array $wgExtensionCredits The list of extension credits.
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionCredits
 */
$wgExtensionCredits['other'][] = [
	'path'              => __FILE__,
	'name'              => 'PowerUser',
	'descriptionmsg'    => 'poweruser-ext-description',
	'version'           => '1.0',
	'author'            => [
		'Adam Karminski <adamk@wikia-inc.com>'
	],
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/PowerUser/',
];


$wgAutoloadClasses['Wikia\PowerUser\PowerUser'] = __DIR__ . '/PowerUser.class.php';
$wgAutoloadClasses['Wikia\PowerUser\PowerUserHooks'] = __DIR__ . '/PowerUser.hooks.php';

/**
 * Registering hooks
 */
$wgExtensionFunctions[] = 'Wikia\PowerUser\PowerUserHooks::setupHooks';
