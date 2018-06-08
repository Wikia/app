<?php
/**
 * Announcements Extension
 *
 * @author Krzysztof Derek
 */
$dir = dirname( __FILE__ ) . '/';

$wgExtensionCredits['api'][] = [
	'name' => 'Announcements',
	'descriptionmsg' => 'announcements-desc',
	'authors' => [
		'Krzysztof Derek'
	],
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Announcements'
];


// Load needed classes
$wgAutoloadClasses['AnnouncementsController'] = $dir . 'AnnouncementsController.class.php';

// model classes
$wgAutoloadClasses['Announcements'] = $dir . 'models/Announcements.class.php';
