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


if( isset( $options['help'] ) && $options['help'] ) {
	exit( 0 );
}

//$IP = '/home/release/video_refactoring/trunk'; // HACK TO RUN ON SANDBOX
require_once( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );


$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

$i = 0;
$timeStart = microtime( true );
$aTranslation = array();
$aAllFiles = array();
$allChangesArticleURLs=array();
$timeStart = microtime( true );

$rows = $dbw_dataware->query( "SELECT img_name, wiki_id, provider
			       FROM video_premigrate
			       WHERE provider IN ('1', '16', '20')
			       GROUP BY img_name, wiki_id
			       ORDER BY wiki_id, provider

" );

$rowCount = $rows->numRows();

echo $rowCount . " files found. \n\n" ;

if ( $rowCount ) {

	while( $file = $dbw_dataware->fetchObject( $rows ) ) {
		$aAllFiles[] = $file;
	}
}

$dbw_dataware->freeResult( $rows );

$count = count( $aTranslation );
$current = 0;
$dataBase = '';
foreach ( $aAllFiles as $key => $fileRow ) {

			global $wgTitle;
			//print_r($wiki);

			if ( empty( $dataBase ) || $dataBase != $fileRow->wiki_id  ) {

				$wiki = WikiFactory::getWikiByID( $fileRow->wiki_id );

				echo "\n\nVideos from: ". $wiki->city_url ." \n";
				echo "========================================\n\n";

				$dbw = wfGetDB( DB_MASTER, array(), $wiki->city_dbname );

				$dataBase = $fileRow->wiki_id ;


			}

			$fileURL = $wiki->city_url . "wiki/File:" . $fileRow->img_name ;
			echo $fileURL;

			$rows = $dbw->query( "SELECT distinct il_from FROM imagelinks WHERE il_to ='".mysql_real_escape_string($fileRow->img_name)."'");
			$rowCount = $rows->numRows();

			echo " (" . $rowCount ." backlinks) \n";

			while( $file = $dbw->fetchObject( $rows ) ) {
				$articleId = $file->il_from;
				$oTitle = GlobalTitle::newFromId($articleId, $fileRow->wiki_id); //::newFromId( $articleId );

				echo "* " . $oTitle->getFullURL() . " [contains File:{$fileRow->img_name} ] \n";
			}


			//$allChangesArticleURLs[ str_replace('http://localhost/', $wikiUrl, $oTitle->getFullURL()) ] = $fileRow->sanitized_title;
			//$allChangesArticleURLs[ $wikiUrl . 'wiki/'. str_replace(" ", "_",$fileRow->article_title) ] = $fileRow->sanitized_title;
		//}
}
if (count ($allChangesArticleURLs) > 0 ) {

	foreach( $allChangesArticleURLs as $url => $v ) {
		echo str_replace("::", ":", "$url -> Video:$v \n");
	}
}
?>