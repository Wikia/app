<?php
/**
 * How to run this script:
 * $ cd maintenance/wikia/ImageReview/AdminUpload/upload.php
 * To upload an image on wikia.com (from wookiepedia [wikiid=147]) as a WikiaBot:
 * $ SERVER_ID=80433 php upload.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php --originalimageurl="http://images.nandy.wikia-dev.com/__cb20120524124212/starwars/images/6/6b/Wikia-Visualization-Add-3.jpg" --destimagename="Wikia-Visualization-Add-3,starwars.jpg" --userid=4663069 --wikiid=147
 */
require_once("../../../commandLine.inc");

$imageUrl = $options['originalimageurl'];
$destImageName = $options['destimagename'];
$sourceWikiId = intval($options['wikiid']);

$userId = $options['userid'];
$user = F::build('User', array($userId), 'newFromId');

echo "\n";

if( !($user instanceof User) ) {
	echo 'ERROR: Could not get user object'."\n";
	exit(1);
}

if( empty($imageUrl) ) {
	echo 'ERROR: Invalid original image url'."\n";
	exit(1);
}

if( empty($destImageName) ) {
	echo 'ERROR: Invalid destination name'."\n";
	exit(1);
}

if( $sourceWikiId <= 0 ) {
	echo 'ERROR: Invalid source wiki id'."\n";
	exit(1);
}

if( UploadFromUrl::isAllowed($user) !== true ) {
	echo 'ERROR: You do not have right permissions'."\n";
	exit(1);
}

$result = ImagesService::uploadImageFromUrl($imageUrl, $destImageName, $user);

if( $result['status'] === true ) {
	echo 'INFO: Image has been uploaded.'."\n";
	exit(0);
} else {
	echo 'ERROR: Something went wrong with uploading the image.'."\n";
	print_r($result['errors']);
	exit(1);
}
