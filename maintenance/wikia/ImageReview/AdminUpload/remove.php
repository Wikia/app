<?php
/**
 * How to run this script:
 * $ cd maintenance/wikia/ImageReview/AdminUpload/upload.php
 * To remove an image from wikia.com as a WikiaBot:
 * $ SERVER_ID=80433 php remove.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php --imagename="Wikia-Visualization-Add-3,starwars.jpg" --userid=4663069
 */
require_once("../../../commandLine.inc");

$imageName = $options['imagename'];
$userId = $options['userid'];
$user = F::build('User', array($userId), 'newFromId');

if( !($user instanceof User) ) {
	echo 'ERROR: Could not get user object'."\n";
	exit;
}

if( !$user->isAllowed('delete') ) {
	echo 'ERROR: You do not have right permissions'."\n";
	exit;
}

if( empty($imageName) ) {
	echo 'ERROR: Invalid image name'."\n";
	exit;
}

$imageTitle = Title::newFromText($imageName, NS_FILE);

if( !($imageTitle instanceof Title) ) {
	echo 'ERROR: Could not get title object';
	exit;
}

$file = wfFindFile($imageTitle);
$status = $file->delete('automated deletion');

if( $status->ok === true ) {
	echo "\n"."INFO: File has been deleted"."\n";
} else {
	echo "\n"."ERROR: File has not been deleted"."\n";
	var_dump($status);
}