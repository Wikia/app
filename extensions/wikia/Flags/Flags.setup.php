<?php

/**
 * Wikia Flags Extension
 * @author Adam Karmiński
 *
 */

$dir = dirname(__FILE__) . '/';

/**
 * Controllers
 */
$wgAutoloadClasses['FlagsController'] = $dir . 'controllers/FlagsController.class.php';

/**
 * Models
 */
$wgAutoloadClasses['Flags\Models\FlagsModel'] = $dir . 'models/FlagsModel.class.php';
$wgAutoloadClasses['Flags\Models\Flag'] = $dir . 'models/Flag.class.php';
$wgAutoloadClasses['Flags\Models\FlagParameter'] = $dir . 'models/FlagParameter.class.php';
$wgAutoloadClasses['Flags\Models\FlagType'] = $dir . 'models/FlagType.class.php';

$wgExtensionCredits['other'][] = [
	'name'				=> 'Flags',
	'version'			=> '1.0',
	'author'			=> 'Adam Karmiński',
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Flags',
	'descriptionmsg'    => 'flags-desc'
];
