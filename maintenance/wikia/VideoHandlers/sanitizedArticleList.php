<?php
/**
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */

ini_set( "include_path", dirname(__FILE__)."/.." );
//require_once( 'commandLine.inc' );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
require_once( '../../commandLine.inc' );
require_once ('videoSanitizerMigrationHelper.class.php');
require_once( 'videolog.class.php' );

global $IP, $wgCityId, $wgDBname, $wgExternalDatawareDB, $wgVideoHandlersVideosMigrated, $wgDBname, $wgStatsDB;

$wgVideoHandlersVideosMigrated = false; // be sure we are working on old files


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

$rows = $dbw_dataware->query( "SELECT sanitized_title, operation_time, article_title, city_id
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
	ORDER BY city_id
" );

$rowCount = $rows->numRows();
if ( $rowCount ) {

	while( $file = $dbw->fetchObject( $rows ) ) {
		$aAllFiles[] = $file;
	}
}

$dbw->freeResult( $rows );

$count = count( $aTranslation );
$current = 0;
foreach ( $aAllFiles as $key => $fileRow ) {

		//$oTitle = Title::newFromText($fileRow->article_title);


		//if ( $oTitle instanceof Title && $oTitle->exists() ){
			global $wgTitle;
			$wgTitle = $oTitle;
			$wikiUrl = WikiFactory::getWikiByID( $fileRow->city_id )->city_url;
			//$allChangesArticleURLs[ str_replace('http://localhost/', $wikiUrl, $oTitle->getFullURL()) ] = $fileRow->sanitized_title;
			$allChangesArticleURLs[ $wikiUrl . 'wiki/'. str_replace(" ", "_",$fileRow->article_title) ] = $fileRow->sanitized_title;
		//}
}
if (count ($allChangesArticleURLs) > 0 ) {

	foreach( $allChangesArticleURLs as $url => $v ) {
		echo str_replace("::", ":", "$url -> Video:$v \n");
	}
}
?>