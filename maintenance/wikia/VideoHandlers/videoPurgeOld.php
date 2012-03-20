<?php
/**
 * @usage: SERVER_ID=177 php videoPurgeOld.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: SERVER_ID=177 php videoPurgeOld.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */

ini_set( "include_path", dirname(__FILE__)."/.." );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
require_once( '../../commandLine.inc' );

global $IP, $wgCityId, $wgExternalDatawareDB;

echo "***Purge Old Videos*** script running for $wgCityId\n";

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: usage: SERVER_ID=[CITY_ID] php videoPurgeOld.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php \n" );
	exit( 0 );
}

require_once( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

$dbw = wfGetDB( DB_MASTER );
//$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );


$timeStart = microtime( true );

$aAllVideos = array();
$aAllPages = array();
$aVideosToBeRemoved = array();
$timeStart = microtime( true );

$rows = $dbw->query( "SELECT img_name FROM image WHERE img_media_type='VIDEO'" );
$rowCount = $rows->numRows();

echo( ": {$rowCount} videos found\n" );

if ( $rowCount ) {

	while( $file = $dbw->fetchObject( $rows ) ) {
		$aAllVideos[ $file->img_name ] = 1;
	}

	echo "[".intval( microtime( true ) - $timeStart)." s] table created \n";


	foreach( $aAllVideos as $sFile => $val ) {
		
		if ( strpos ( $sFile, ':' ) === 0 ) {
			
			$videoName = substr( $sFile, 1 ); 
			
			if ( !empty( $aAllVideos[ $videoName ] )) {
				$aVideosToBeRemoved[] = $sFile;
			}
		}	
	}

	echo count($aVideosToBeRemoved) . " videos to purge in image table \n"; 
	print_r($aVideosToBeRemoved);
}

$dbw->freeResult( $rows );

$rows = $dbw->query( "SELECT page_id, page_namespace, page_title 
					  FROM page 
					  WHERE page_namespace IN (".implode(',',array(NS_VIDEO, NS_LEGACY_VIDEO)).")" );
$rowCount = $rows->numRows();

echo( ": {$rowCount} articles found\n" );

if ( $rowCount ) {
	
	$aArticleToRemove = array();
	
	while( $page = $dbw->fetchObject( $rows ) ) {
		$aAllPages[ $page->page_namespace ][ $page->page_title ] = $page->page_id;
	}	
	
	foreach ($aAllPages as $pageNamespace => $pageData) {
		if ($pageNamespace == NS_LEGACY_VIDEO) {
			
			foreach ($pageData as $articleTitle => $articleId) {
				
				if ( !empty($aAllPages[NS_VIDEO][$articleTitle]) ) {
					
					$aArticleToRemove[] = $articleId;
				}
			}
		}
	}

	echo count($aArticleToRemove) . " articles to purge \n"; 
	print_r($aArticleToRemove);	
	
}
$dbw->freeResult( $rows );


if ( count($aVideosToBeRemoved) > 0 ) {
	
	echo "Executing querys: \n";
	
	echo "DELETE FROM image WHERE img_name=? AND img_media_type='VIDEO' for ".count($aVideosToBeRemoved)." titles \n";
	foreach ($aVideosToBeRemoved as $videoTitleToRemove) {
		$dbw->delete(
			'image',
			array(
				'img_name' => $videoTitleToRemove,
				'img_media_type' => 'VIDEO'
			),
		    'purgeOldVideos::videoTitleToRemove'
		);
	}
}
//$dbw->affectedRows();

if ( count($aArticleToRemove) > 0 ) {
	
	$tables = array(
		'archive' => array('ns'=>'ar_namespace','id'=>'ar_page_id'),
		'cu_changes' => array('ns'=>'cuc_namespace','id'=>'cuc_id'),
		'hidden' => array('ns'=>'hidden_namespace','id'=>'hidden_page'),
		'logging' => array('ns'=>'log_namespace','id'=>'log_id'),
		'page' => array('ns'=>'page_namespace','id'=>'page_id'),
		'pagelinks' => array('ns'=>'pl_namespace','id'=>'pl_from'),
		'protected_titles' => array('ns'=>'pt_namespace','id'=>'pt_title'),
		'recentchanges' => array('ns'=>'rc_namespace','id'=>'rc_id'),
	);

	foreach( $tables as $tableName => $tableData ) {
		echo( "Processing $tableName\n" );

		if( !$dbw->tableExists($tableName) ) {
			echo "Table does not exist in this database\n";
			continue;
		}

		echo "DELETE FROM $tableName ";

		$dbw->delete(
			$tableName,
			array(
				$tableData['ns'] => NS_LEGACY_VIDEO,
				$tableData['id'] => $aArticleToRemove
			),
		    'purgeOldVideos::aArticleToRemove'
		);		
		echo $dbw->affectedRows() . " affected rows\n";

	}

	
}

wfWaitForSlaves( 2 );



?>