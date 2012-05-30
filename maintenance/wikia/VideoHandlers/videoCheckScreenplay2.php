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

$count = 0;

while($row = $dbw->fetchObject($rows)) {
	$name = $row->img_name;
	$title = Title::newFromText($name, NS_FILE);
	$wgTitle = $title;
	$new_name = VideoFileUploader::sanitizeTitle( $name );
	$new_title = Title::newFromText($new_name, NS_FILE);
	if( $new_name != $name ) {
		$exists = $new_title->exists() ? '+++' : "---";
		echo "$exists $name is illegal name\n";
		echo "    Incorrect URL: " . WikiFactory::getLocalEnvURL( $title->getFullURL()) ."\n";
		if( $new_title->exists() ) {
			echo "    Correct   URL: " . WikiFactory::getLocalEnvURL( $new_title->getFullURL()) ."\n";
			// only remove if there is a copy under "correct" name
			$file = wfFindFile( $name );
			$article = Article::newFromID( $title->getArticleID() );
			$article->doDelete('Duplicated file, Illegal characters in name', true);
			$file->delete('Duplicated file, Illegal characters in name');
			$count += 1;
		}
	}
}
echo "Removed $count\n";
