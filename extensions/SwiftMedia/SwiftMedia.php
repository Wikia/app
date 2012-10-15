<?php
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,		// File name for the extension itself, required for getting the revision number from SVN - string, adding in 1.15
	'name' => "SwiftMedia",           // Name of extension - string
	'descriptionmsg' => "swiftmedia", // Same as above but name of a message, for i18n - string, added in 1.12.0
	'version' => 0,                   // Version number of extension - number or string
	'author' => "Russ Nelson",        // The extension author's name - string or array for multiple
	'url' => "http://www.mediawiki.org/wiki/Extension:SwiftMedia",            // URL of extension (usually instructions) - string
);

$wgAutoloadClasses['SwiftFile'] =
	$wgAutoloadClasses['SwiftForeignDBFile'] =
	$wgAutoloadClasses['SwiftForeignDBRepo'] =
	$wgAutoloadClasses['SwiftForeignDBviaLBRepo'] =
	$wgAutoloadClasses['SwiftRepo'] = dirname( __FILE__ ) . '/SwiftMedia.body.php';
$wgAutoloadClasses['CF_Authentication'] =
	$wgAutoloadClasses['CF_Connection'] =
	$wgAutoloadClasses['CF_Container'] =
	$wgAutoloadClasses['CF_Object'] = '/usr/share/php-cloudfiles/cloudfiles.php';

$wgExtensionMessagesFiles['swiftmedia'] = dirname( __FILE__ ) . '/SwiftMedia.i18n.php';
