<?php
/**
 * How to run this script:
 * $ cd maintenance/wikia/ImageReview/PromoteImage/upload.php
 * To remove an image from wikia.com as a WikiaBot run without userid parameter
 *
 * $ SERVER_ID=80433 php remove.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php --imagename="Wikia-Visualization-Add-3,starwars.jpg" --userid=4663069
 */
$dir = dirname(__FILE__) . '/';
$cmdLineScript = realpath($dir . '../../../commandLine.inc');
require_once($cmdLineScript);

$imageName = $options['imagename'];
if (empty($options['userid'])){
	$user = User::newFromName('WikiaBot');
} else {
	$user = User::newFromId($options['userid']);
}


if( !($user instanceof User) ) {
	echo 'ERROR: Could not get bot user object'."\n";
	exit(2);
}

if( !$user->isAllowed('delete') ) {
	echo 'ERROR: You do not have right permissions'."\n";
	exit(3);
}

if( empty($imageName) ) {
	echo 'ERROR: Invalid image name'."\n";
	exit(4);
}

$imageTitle = Title::newFromText($imageName, NS_FILE);

if( !($imageTitle instanceof Title) ) {
	echo 'ERROR: Could not get title object';
	exit(5);
}

if ( empty( $wgEnableUploads ) ) {
	echo 'ERROR: File uploads disabled'."\n";
	exit(6);
}

$file = wfFindFile($imageTitle);

if( $file instanceof File && $file->exists() ) {
	$status = $file->delete('automated deletion');
} else {
	$status->ok = false;
	$status->errors = array('ERROR: File does not exist ('.$imageTitle.')');
}

if( $status->ok === true ) {
	echo "\n"."INFO: File has been deleted"."\n";
	exit(0);
} else {
	echo "\n"."ERROR: File has not been deleted"."\n";
	var_dump($status);
	exit(6);
}