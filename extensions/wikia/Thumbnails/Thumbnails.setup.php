<?
$wgExtensionCredits['videohandlers'][] = [
	'name' => 'VideoHandlers',
	'author' => [
		"Liz Lee <liz at wikia-inc.com>",
		"Saipetch Kongkatong <saipetch at wikia-inc.com>",
		"Garth Webb <garth at wikia-inc.com>",
		"Kenneth Kouot <kenneth at wikia-inc.com>",
		"James Sutterfield <james at wikia-inc.com>",
	],
	'url' => 'http://video.wikia.com',
	'descriptionmsg' => 'wikia-thumbnails-desc',
];

$dir = dirname( __FILE__ );

// Main classes
$wgAutoloadClasses[ 'ThumbnailVideo' ] = $dir . '/ThumbnailVideo.class.php';
$wgAutoloadClasses[ 'VideoThumbnailController' ] = $dir . '/VideoThumbnailController.class.php';
$wgAutoloadClasses[ 'ImageThumbnailController' ] = $dir . '/ImageThumbnailController.class.php';

