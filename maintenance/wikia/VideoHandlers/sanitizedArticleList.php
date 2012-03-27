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
//$previouslyProcessed = $sanitizeHelper->getRenamedVideos("new", " 1 ");




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

$rows = $dbw_dataware->query( "SELECT sanitized_title, operation_time, article_title
	FROM video_migration_sanitization
	WHERE operation_status = 'OK' AND
      ( sanitized_title LIKE ':0%' OR
	sanitized_title LIKE ':1%' OR
	sanitized_title LIKE ':2%' OR
	sanitized_title LIKE ':3%' OR
	sanitized_title LIKE ':4%' OR
	sanitized_title LIKE ':5%' OR
	sanitized_title LIKE ':6%' OR
	sanitized_title LIKE ':7%' OR
	sanitized_title LIKE ':8%' OR
	sanitized_title LIKE ':9%' )
" );

$rowCount = $rows->numRows();

$wiki = WikiFactory::getWikiByDB($wgDBname);
$wikiUrl = $wiki->city_url;





if ( $rowCount ) {

	while( $file = $dbw->fetchObject( $rows ) ) {
		$aAllFiles[] = $file;
	}
}

$dbw->freeResult( $rows );

$botUser = User::newFromName( 'WikiaBot' );

$i=0;

$count = count( $aTranslation );
$current = 0;
foreach ( $aAllFiles as $key => $fileRow ) {

//	$rows = $dbw->query( "SELECT distinct il_from FROM imagelinks WHERE il_to ='".mysql_real_escape_string($key)."'");

//	while( $file = $dbw->fetchObject( $rows ) ) {


		$oTitle = Title::newFromText($fileRow->article_title);

		if ( $oTitle instanceof Title && $oTitle->exists() ){
			global $wgTitle;

			$wgTitle = $oTitle;


			$allChangesArticleURLs[ str_replace('http://localhost/', $wikiUrl, $oTitle->getFullURL()) ] = $fileRow->sanitized_title;


		}
//	}

//	$i++;
}
if (count ($allChangesArticleURLs) > 0 ) {
	echo( "Article List for cityId: $wgCityId  ( $wikiUrl ) \n" );
	foreach( $allChangesArticleURLs as $url => $v ) {
		echo str_replace("::", ":", "$url -> Video:$v \n");
	}
}
?>