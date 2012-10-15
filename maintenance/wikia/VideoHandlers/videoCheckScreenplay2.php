<?php

$_SERVER['QUERY_STRING'] = 'VideoCleanup';

ini_set( "include_path", dirname(__FILE__)."/.." );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
require_once( '../../commandLine.inc' );

global $IP, $wgCityId, $wgExternalDatawareDB;


$wgUser = User::newFromName( 'Wikia Video Library' );
$dbw = wfGetDB( DB_MASTER );

$rows = $dbw->select('image',
	'*',
	array('img_media_type'=>'VIDEO','img_minor_mime'=>'screenplay')
);


$urlTemplate = 'http://www.totaleclips.com/Player/Bounce.aspx?';

function getFileUrl($type, $bitrateid, $videoId) {
	global $urlTemplate;
	$fileParams = array(
		'eclipid' => $videoId,
		'vendorid' => ScreenplayApiWrapper::VENDOR_ID
	);

	$urlCommonPart = $urlTemplate . http_build_query($fileParams);
	return $urlCommonPart . '&type=' . $type . '&bitrateid=' . $bitrateid;
}

function getStandardBitrateCode($h) {
	if ($metadata = $h->getMetadata(true)) {
		if (!empty($metadata['stdBitrateCode'])) {
			return $metadata['stdBitrateCode'];
		}
	}

	return $h->getAspectRatio() <= (4/3) ? ScreenplayApiWrapper::STANDARD_43_BITRATE_ID : ScreenplayApiWrapper::STANDARD_BITRATE_ID;
}


$count = 0;

$updatethose = array();

while($row = $dbw->fetchObject($rows)) {
	$name = $row->img_name;
	$title = Title::newFromText($name, NS_FILE);
	$wgTitle = $title;
	$file = wfFindFile( $name );
	if( $file->exists() ) {
		echo "working on $name\n";
		$handler = $file->getHandler();
		$videoid = $handler->getVideoId();
		$urlfile = getFileUrl(ScreenplayApiWrapper::VIDEO_TYPE, getStandardBitrateCode($handler), $videoid);
		$urlhdfile = getFileUrl(ScreenplayApiWrapper::VIDEO_TYPE, ScreenplayApiWrapper::HIGHDEF_BITRATE_ID, $videoid);
		$meta = $row->img_metadata;
		$metaU = unserialize($meta);
		$metaU['streamUrl'] = $urlfile;
		$metaU['streamHdUrl'] = $urlhdfile;
		$meta = serialize($metaU);
		$updatethose[$name] = $meta;
	}
}

foreach($updatethose as $name => $meta) {
	$dbw->update(
		'image',
		array('img_metadata'=>$meta),
		array('img_name'=>$name)
	);
	echo "Updated $name\n";
}
