<?php
/**
 * Pyrkon Scavenger Hunt for Fandom
 *
 * @author bart <bart(at)wikia-inc.com>
 */
$dir = __DIR__ . '/';

/**
 * Classes
 */
$wgAutoloadClasses['PyrkonScavengerHuntHooks'] = $dir . 'PyrkonScavengerHuntHooks.class.php';
$wgAutoloadClasses['PyrkonScavengerHuntApiController'] = $dir . 'PyrkonScavengerHuntApiController.class.php';
$wgAutoloadClasses['SpecialPyrkonScavengerHuntController'] = $dir . 'SpecialPyrkonScavengerHuntController.class.php';

/**
 * Hooks
 */
$wgHooks['BeforePageDisplay'][] = 'PyrkonScavengerHuntHooks::onBeforePageDisplay';

/**
 * Special Pages
 */
$wgSpecialPages['PyrkonScavengerHunt'] = 'SpecialPyrkonScavengerHuntController';

/**
 * Credits
 */

$wgExtensionCredits['other'][] = [
	'name' => 'Pyrkon Scavenger Hunt',
	'version' => '1.0',
	'author' => 'Bartłomiej Bart Kowalczyk',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/PyrkonScavengerHunt'
];
