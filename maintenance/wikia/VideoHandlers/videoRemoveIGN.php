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
	array('img_media_type'=>'VIDEO','img_minor_mime'=>'ign')
);

$count = 0;

while($row = $dbw->fetchObject($rows)) {
	$name = $row->img_name;
	$title = Title::newFromText($name, NS_FILE);
	$wgTitle = $title;
	if( $title->exists() ) {
		$file = wfFindFile( $name );
		$article = Article::newFromID( $title->getArticleID() );
		$article->doDelete('Removing IGN content', true);
		$file->delete('Removing IGN content', true);
		$count += 1;
	}
}
echo "Removed $count\n";
