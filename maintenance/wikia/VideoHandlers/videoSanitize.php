<?php
/**
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */
ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
@require_once( '../../commandLine.inc' );
// $IP = '/home/pbablok/video/VideoRefactor/'; // HACK TO RUN ON SANDBOX
// echo( "$IP\n" );
echo( "Video name sanitizer script running for $wgCityId\n" );

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php VideoSanitizer.php\n" );
	exit( 0 );
}

require_once( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

$dbw = wfGetDB( DB_MASTER );

$i = 0;
$timeStart = microtime( true );
$aTranslation = array();
$aAllFiles = array();
$timeStart = microtime( true );

$rows = $dbw->query( "	SELECT img_name
			FROM image");

$rowCount = $rows->numRows();
echo( ": {$rowCount} videos found\n" );

if ( $rowCount ) {
	// before processing videos prepare 'status cache'
	// which contains information about previously processed
	// videos on this wiki
	//echo "Fetching data about previously processed videos\n";

	while( $file = $dbw->fetchObject( $rows ) ) {
		$aAllFiles[ $file->img_name ] = 1;
	}

	echo "[".intval( microtime( true ) - $timeStart)." s] table created \n";

	$i = 0;
	foreach( $aAllFiles as $sFile => $val ) {
		if ( strpos ( $sFile, ':' ) === 0 ) {
			// var_dump(':');
			$response = F::app()->sendRequest(
				'VideoHandlerController',
				'getSanitizedOldVideoTitleString',
				array(
					'videoText' => $sFile
				)
			)->getData();
			if( isset( $response['error'] ) ) continue;

			$newNameCandidate = $response['result'];
			$afterSanitizer = substr( $response['result'], 1);

			if (
				( $newNameCandidate != $sFile ) ||
				( isset ( $aAllFiles[ $afterSanitizer ] ) )
			){
				$found = false;
				$sufix = 0;
				$continue = true;
				while ( $continue == true ) {
					$sNewTitle = $newNameCandidate . ( empty( $sufix ) ? '' : '_'.$sufix );
					if ( 	!isset( $aAllFiles[ substr( $sNewTitle, 1) ] ) &&
						!isset( $aAllFiles[ $sNewTitle ] )
					) {
						$continue = false;
					}
					$sufix++;
				}
				$aTranslation[ $sFile ] = $sNewTitle;
			}
		}
	}
}
$dbw->freeResult( $rows );
echo "[".intval( microtime( true ) - $timeStart)." s] get translation table!\n";

var_dump( $aTranslation );

$botUser = User::newFromName( 'WikiaBot' );

foreach ( $aTranslation as $key => $val ) {
	$rows = $dbw->query( "SELECT distinct il_from FROM imagelinks WHERE il_to ='{$key}'");

	$strippedNew = str_replace( ':', '', $val );
	$strippedOld = str_replace( ':', '', $key );

	$aTablesMove = array();
	$aTablesMove['archive']	= array (
		'where' => array( 'ar_namespace' => NS_VIDEO, 'ar_title' => $strippedOld ),
		'update' => array( 'ar_title' => $strippedNew )
	);

	$aTablesMove['cu_changes'] = array (
		'where' => array( 'cuc_namespace' => NS_VIDEO, 'cuc_title' => $strippedOld ),
		'update' => array( 'cuc_title' => $strippedNew )
	);

	$aTablesMove['filearchive'] = array (
		'where' => array( 'fa_name' => $key ),
		'update' => array( 'fa_name' => $val )
	);

	$aTablesMove['image'] = array (
		'where' => array( 'img_name' => $key ),
		'update' => array( 'img_name' => $val )
	);

	$aTablesMove['hidden'] = array (
		'where' => array( 'hidden_namespace' => NS_VIDEO, 'hidden_title' => $strippedOld ),
		'update' => array( 'hidden_title' => $strippedNew )
	);

	$aTablesMove['logging']	= array (
		'where' => array( 'log_namespace' => NS_VIDEO, 'log_title' => $strippedOld ),
		'update' => array( 'log_title' => $strippedNew )
	);

	$aTablesMove['oldimage'] = array (
		'where' => array( 'oi_name' => $key ),
		'update' => array( 'oi_name' => $val )
	);

	$aTablesMove['oldimage'] = array (
		'where' => array( 'oi_archive_name' => $key ),
		'update' => array( 'oi_archive_name' => $val )
	);

	$aTablesMove['page'] = array (
		'where' => array( 'page_namespace' => NS_VIDEO, 'page_title' => $strippedOld ),
		'update' => array( 'page_title' => $strippedNew )
	);

	$aTablesMove['pagelinks'] = array (
		'where' => array( 'pl_namespace' => NS_VIDEO, 'pl_title' => $strippedOld ),
		'update' => array( 'pl_title' => $strippedNew )
	);

	$aTablesMove['protected_titles'] = array (
		'where' => array( 'pt_namespace' => NS_VIDEO, 'pt_title' => $strippedOld ),
		'update' => array( 'pt_title' => $strippedNew )
	);

	$aTablesMove['recentchanges'] = array (
		'where' => array( 'rc_namespace' => NS_VIDEO, 'rc_title' => $strippedOld ),
		'update' => array( 'rc_title' => $strippedNew )
	);

	$aTablesMove['redirect'] = array (
		'where' => array( 'rd_namespace' => NS_VIDEO, 'rd_title' => $strippedOld ),
		'update' => array( 'rd_title' => $strippedNew )
	);

	$aTablesMove['watchlist'] = array (
		'where' => array( 'wl_namespace' => NS_VIDEO, 'wl_title' => $strippedOld ),
		'update' => array( 'wl_title' => $strippedNew )
	);

	// Fixing links in article;
	// echo "SELECT distinct il_from FROM imagelinks WHERE il_to ='{$key}'! /n";
	while( $file = $dbw->fetchObject( $rows ) ) {
		// var_dump( $key );
//		echo "ONE! /n";
		// echo "DANGER! ".$file->il_from."/n";
		$articleId = $file->il_from;
		$oTitle = Title::newFromId( $articleId );
		if ( $oTitle instanceof Title && $oTitle->exists() ){
//			echo "TWO! /n";
			$oArticle = new Article ( $oTitle );
			if ( $oArticle instanceof Article ){
//				echo "THREE! /n";
				$sTextAfter = $sText = $oArticle->getContent();
//				var_dump( $sTextAfter, $key, $val );
//				var_dump( $oTitle );
				$spacesText = str_replace( '_', ' ', $key );

				foreach ( array( $key, $spacesText ) as $what ){

					var_dump( '---' );
//					var_dump( $sTextAfter );
//					var_dump( 'Video'.$what.'|' );
//					var_dump( 'Video'.$what.']' );
//					var_dump( strpos( $sTextAfter, 'Video'.$what.'|' ) );
//					var_dump( strpos( $sTextAfter, 'Video'.$what.']' ) );
					var_dump( '--' );

					$sTextAfter = str_replace( 'Video'.$what.'|', 'Video'.$val.'|', $sTextAfter );
					$sTextAfter = str_replace( 'Video'.$what.']', 'Video'.$val.']', $sTextAfter );
				}

				if ( $sTextAfter != $sText ) {
					echo "DANGER! /n";
//					$status = $oArticle->doEdit( $sTextAfter, 'Fixing broken video names', EDIT_UPDATE, false, $botUser );
//					var_dump( $status );
//					if ( is_object( $status ) && !$status->isOK() ){
//						var_dump( $status );
//					}
				} else {
					echo "FAIL! /n";
				}
			} else {
				var_dump( $oArticle );
			}
		} else {
			var_dump( $oTitle );
		}
	}

//	foreach(  $aTablesMove as $table => $actions ){
//		$dbw->update(
//			$table,
//			$actions['update'],
//			$actions['where'],
//			__METHOD__
//		);
//		// ad error handling
//	}
}

echo(": {$rowCount} videos processed.\n");
/*
 * wywala nam sie upload
 * check if new name will be available
 * change in page
 * upload
 * success -> change in all backlinking articles
 */

?>