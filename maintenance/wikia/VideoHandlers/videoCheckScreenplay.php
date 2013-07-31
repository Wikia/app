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

while($row = $dbw->fetchObject($rows)) {
	$w = $row->img_width;
	$h = $row->img_height;
	if( $w > 0 && $h  > 0 ) {
		$aspect = $w/$h;
		if ( $aspect < 1.7 ) {
			$name = $row->img_name;
			$title = Title::newFromText($name, NS_FILE);
			$url = WikiFactory::getLocalEnvURL($title->getFullUrl());
			$file = wfFindFile( $title );
			$img = $file->getFullUrl();
			$article = Article::newFromID($title->getArticleID());
			$body = $article->getContent();
			echo "$w\t$h\t$aspect\t$url\t$img\n";

			// fake the upload
			$metadata = unserialize($file->getMetadata());
			if( $metadata['aspectRatio'] > 1.7 ) {
				echo $metadata['aspectRatio'] . "<- skipping\n";
				continue;
			} else {
				echo $metadata['aspectRatio'] . "<- previous ratio\n";
			}
			$metadata['aspectRatio'] = 1.7777778;
			$apiWrapper = new ScreenplayApiWrapper($name, $metadata);
			$uploadedTitle = null;
			//$descriptionHeader = '==' . wfMsg('videohandler-description') . '==';
			//$body = $categoryStr."\n".$descriptionHeader."\n".$apiWrapper->getDescription();
			$result = VideoFileUploader::uploadVideo('screenplay', $name, $uploadedTitle, $body, false);
			if ($result->ok) {
				echo "reupload OK\n";
			} else {
				echo "reupload failed\n";
			}
			sleep(5);
		}
	}

}
