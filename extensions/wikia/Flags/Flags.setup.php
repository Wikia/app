<?php
/**
 * Wikia Flags Extension
 * @author Adam Karmiński
 *
 */

$wgExtensionCredits['other'][] = [
	'name'				=> 'Flags',
	'version'			=> '1.0',
	'author'			=> 'Adam Karmiński',
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Flags',
	'descriptionmsg'    => 'flags-desc'
];

/**
 * Controllers
 */
$wgAutoloadClasses['FlagsController'] = __DIR__ . '/controllers/FlagsController.class.php';

/**
 * Models
 */
$wgAutoloadClasses['Flags\Models\FlagsBaseModel'] = __DIR__ . '/models/FlagsBaseModel.class.php';
$wgAutoloadClasses['Flags\Models\Flag'] = __DIR__ . '/models/Flag.class.php';
$wgAutoloadClasses['Flags\Models\FlagParameter'] = __DIR__ . '/models/FlagParameter.class.php';
$wgAutoloadClasses['Flags\Models\FlagType'] = __DIR__ . '/models/FlagType.class.php';

/**
 * Other classes
 */
$wgAutoloadClasses['Flags\FlagsHooks'] = __DIR__ . '/FlagsHooks.class.php';

/**
 * Hooks
 */
$wgHooks['BeforePageDisplay'][] = 'Flags\FlagsHooks::onBeforePageDisplay';
$wgHooks['SkinTemplateNavigation'][] = 'Flags\FlagsHooks::onSkinTemplateNavigation';
