<?php
/**
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */

echo "\n\n";

ini_set( "include_path", dirname(__FILE__)."/.." );
//require_once( 'commandLine.inc' );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
@require_once( '../../commandLine.inc' );
require_once ('videoSanitizerMigrationHelper.class.php');
require_once( 'videolog.class.php' );

global $IP, $wgCityId, $wgDBname, $wgExternalDatawareDB, $wgVideoHandlersVideosMigrated, $wgDBname, $wgStatsDB;

$wgVideoHandlersVideosMigrated = false; // be sure we are working on old files

$devboxuser = exec('hostname');
$sanitizeHelper = new videoSanitizerMigrationHelper($wgCityId, $wgDBname, $wgExternalDatawareDB);
$previouslyProcessed = $sanitizeHelper->getRenamedVideos("new", " 1 ");
$previouslyProcessed2 = $sanitizeHelper->getRenamedVideos("old", " 1 ");



if( isset( $options['help'] ) && $options['help'] ) {
	exit( 0 );
}

$IP = '/home/release/video_refactoring/trunk'; // HACK TO RUN ON SANDBOX
require_once( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

$dbw = wfGetDB( DB_MASTER );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
$dbw_stats = wfGetDB( DB_SLAVE, array(), $wgStatsDB );

$i = 0;
$timeStart = microtime( true );
$aTranslation = array();
$aAllFiles = array();
$allChangesArticleURLs=array();
$timeStart = microtime( true );

$rows = $dbw->query( "SELECT img_name FROM image WHERE img_media_type='VIDEO' AND
      ( img_name LIKE ':0%' OR
	img_name LIKE ':1%' OR
	img_name LIKE ':2%' OR
	img_name LIKE ':3%' OR
	img_name LIKE ':4%' OR
	img_name LIKE ':5%' OR
	img_name LIKE ':6%' OR
	img_name LIKE ':7%' OR
	img_name LIKE ':8%' OR
	img_name LIKE ':9%' )
" );

$rowCount = $rows->numRows();

$wiki = WikiFactory::getWikiByDB($wgDBname);
$wikiUrl = $wiki->city_url;





if ( $rowCount ) {

	while( $file = $dbw->fetchObject( $rows ) ) {
		$aAllFiles[ $file->img_name ] = 1;
	}

	print_r($aAllFiles);

	$i = 0;
	foreach( $aAllFiles as $sFile => $val ) {
		if ( strpos ( $sFile, ':' ) === 0 ) {
			if ( !empty( $previouslyProcessed[ $sFile ] ) || !empty( $previouslyProcessed2[ $sFile ] ) ) {
				$aTranslation[ $sFile ] = true;
			} else {
				echo "skipping: ".$sFile."\n";
			}
		}
	}
}

$dbw->freeResult( $rows );

$botUser = User::newFromName( 'WikiaBot' );

$i=0;

$count = count( $aTranslation );
$current = 0;
foreach ( $aTranslation as $key => $val ) {

	$rows = $dbw->query( "SELECT distinct il_from FROM imagelinks WHERE il_to ='".mysql_real_escape_string($key)."'");

	while( $file = $dbw->fetchObject( $rows ) ) {

		$articleId = $file->il_from;
		$oTitle = Title::newFromId( $articleId );
		echo "ARTICLE ID: $articleId \n";
		if ( $oTitle instanceof Title && $oTitle->exists() ){
			global $wgTitle;

			$wgTitle = $oTitle;
			$oArticle = new Article ( $oTitle );
			if ( $oArticle instanceof Article ){

				$allChangesArticleURLs[ str_replace('http://localhost/', $wikiUrl, $oTitle->getFullURL()) ] = $key;
			}

		}
	}

	$i++;
}
if (count ($allChangesArticleURLs) > 0 ) {
	echo( "Article List for cityId: $wgCityId  ( $wikiUrl ) \n" );
	foreach( $allChangesArticleURLs as $url => $v ) {
		echo "$url -> Video$v \n";
	}
}
?>