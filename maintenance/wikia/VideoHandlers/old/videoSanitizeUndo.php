<?php
/**
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */


ini_set( "include_path", dirname(__FILE__)."/.." );
//require_once( 'commandLine.inc' );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
@require_once( '../../commandLine.inc' );
require_once ('videoSanitizerMigrationHelper.class.php');
require_once( 'videolog.class.php' );

global $IP, $wgCityId, $wgDBname, $wgExternalDatawareDB, $wgVideoHandlersVideosMigrated, $wgDBname;

$wgVideoHandlersVideosMigrated = false; // be sure we are working on old files

$devboxuser = exec('hostname');
$sanitizeHelper = new videoSanitizerMigrationHelper($wgCityId, $wgDBname, $wgExternalDatawareDB);
$previouslyProcessed = $sanitizeHelper->getRenamedVideos("old", " operation_status='OK'");

echo( "Video name UNSANITIZER script running for $wgCityId\n" );
videoLog( 'unsanitize', 'START', '');


if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php VideoSanitizeUndo.php\n" );
	exit( 0 );
}

require_once( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

$dbw = wfGetDB( DB_MASTER );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

$i = 0;
$timeStart = microtime( true );
$aTranslation = array();
$aAllFiles = array();
$allChangesArticleURLs=array();
$timeStart = microtime( true );

$aTranslation = $sanitizeHelper->getRenamedVideos("new", " 1 ");
$rowCount = count($aTranslation);
print_r( $aTranslation );

$botUser = User::newFromName( 'WikiaBot' );

$i=0;

$count = count( $aTranslation );
$current = 0;
foreach ( $aTranslation as $key => $val ) {
	echo "aTranslation[$key]=$val\n";
	
	$strippedNew = ( substr( $val, 0, 1 ) == ':' ) ? substr( $val, 1 ) : $val;
	$strippedOld = ( substr( $key, 0, 1 ) == ':' ) ? substr( $key, 1 ) : $key;

	$aTablesMove = array();
	$aTablesMove['archive']	= array (
		'where' => array( 'ar_namespace' => NS_LEGACY_VIDEO, 'ar_title' => $strippedOld ),
		'update' => array( 'ar_title' => $strippedNew )
	);

	$aTablesMove['cu_changes'] = array (
		'where' => array( 'cuc_namespace' => NS_LEGACY_VIDEO, 'cuc_title' => $strippedOld ),
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
		'where' => array( 'hidden_namespace' => NS_LEGACY_VIDEO, 'hidden_title' => $strippedOld ),
		'update' => array( 'hidden_title' => $strippedNew )
	);

	$aTablesMove['logging']	= array (
		'where' => array( 'log_namespace' => NS_LEGACY_VIDEO, 'log_title' => $strippedOld ),
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
		'where' => array( 'page_namespace' => NS_LEGACY_VIDEO, 'page_title' => $strippedOld ),
		'update' => array( 'page_title' => $strippedNew )
	);

	$aTablesMove['pagelinks'] = array (
		'where' => array( 'pl_namespace' => NS_LEGACY_VIDEO, 'pl_title' => $strippedOld ),
		'update' => array( 'pl_title' => $strippedNew )
	);

	$aTablesMove['protected_titles'] = array (
		'where' => array( 'pt_namespace' => NS_LEGACY_VIDEO, 'pt_title' => $strippedOld ),
		'update' => array( 'pt_title' => $strippedNew )
	);

	$aTablesMove['recentchanges'] = array (
		'where' => array( 'rc_namespace' => NS_LEGACY_VIDEO, 'rc_title' => $strippedOld ),
		'update' => array( 'rc_title' => $strippedNew )
	);

	$aTablesMove['redirect'] = array (
		'where' => array( 'rd_namespace' => NS_LEGACY_VIDEO, 'rd_title' => $strippedOld ),
		'update' => array( 'rd_title' => $strippedNew )
	);

	$aTablesMove['watchlist'] = array (
		'where' => array( 'wl_namespace' => NS_LEGACY_VIDEO, 'wl_title' => $strippedOld ),
		'update' => array( 'wl_title' => $strippedNew )
	);
	
	foreach(  $aTablesMove as $table => $actions ){
		if( $dbw->tableExists($table)) {
			$res = $dbw->update(
				$table,
				$actions['update'],
				$actions['where'],
				__METHOD__
			);
			$num = $dbw->affectedRows();
			if( $num ) {
				echo "updated $table (changes:$num)\n";
			}
			// ad error handling
		} else {
			echo "table $table does not exist on this wiki\n";
		}
	}

	$sanitizeHelper->logVideoTitle($val, $key, 'UNDO');
	$i++;
}

echo(": {$rowCount} videos processed.\n");
videoLog( 'unsanitize', 'RENAMED', "renamed:$i");


videoLog( 'unsanitize', 'STOP', "");

?>