<?php
/**
 * Remove unused user accounts from the database
 * An unused account is one which has made no edits
 *
 * @file
 * @ingroup Maintenance
 * @author Rob Church <robchur@gmail.com>
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
$IP = $GLOBALS["IP"];
require_once( "commandLine.inc" );
include_once("$IP/extensions/wikia/Scribe/ScribeClient.php");
include_once("$IP/extensions/wikia/Scribe/ScribeProducer.php");
$fname = 'archiveStatsData';

# Do an initial scan for inactive accounts and report the result
echo( "Start script ...\n" );

function runArchiveStats($city_id) {
	global $IP, $wgWikiaLocalSettingsPath;
	$script_path = $_SERVER['PHP_SELF'];
	$path = "SERVER_ID={$city_id} php {$script_path} --events=1 --conf {$wgWikiaLocalSettingsPath}";
	echo $path . " \n";
	#$return = wfShellExec( $path );
}

function callEditHook(&$articles, $oRow, $sleep = 0) {
	global $wgCityId, $wgServer;
	$wgServer = WikiFactory::getVarValueByName( "wgServer", $wgCityId );
	# flags
	$flags = "";
	# article
	$oArticle = Article::newFromID($oRow->page_id);
	# user
	$oUser = User::newFromId($oRow->rev_user);
	# revision
	$oRevision = Revision::newFromId($oRow->rev_id);
	# status - new or edit
	$status = Status::newGood( array() );
	# check is new
	if ( !isset($articles[$oRow->page_id]) ) {
		$status->value['new'] = true;
	}
	$articles[$oRow->page_id] = 1;
	# call function
	$res = ScribeProducer::saveComplete( &$oArticle, &$oUser, null, null, null, null, null, &$flags, $oRevision, &$status, 0 );
	if ( $sleep ) {
		usleep(500000);
	}
}

$main = isset($options['main']);
$events = isset($options['events']);
$sleep = isset($options['sleep']);
echo print_r($options, true);
exit;
if ( $main ) {
	$dbr = wfGetDB( DB_SLAVE, 'stats', $wgExternalSharedDB );
	$res = $dbr->select( 'wikicities', array( '*' ), 'city_public = 1', $fname );
	while( $row = $dbr->fetchObject( $res ) ) {
		runArchiveStats($row->city_id);
	}
	$dbr->freeResult( $res );
}
elseif ( $events ) {
	$articles = array();
	$dbr = wfGetDB( DB_SLAVE, 'stats' );
	$oRes = $dbr->select(
		array( 'page', 'revision' ), 
		array( 'page_id, page_namespace, rev_id, rev_user' ), 
		array( 'page_id = rev_page' ), 
		$fname,
		array( 'ORDER BY' => 'rev_id') 
	);

	if ( $oRes ) {
		while( $oRow = $dbr->fetchObject( $oRes ) ) {
			callEditHook(&$articles, $oRow, $sleep);
		}
		$dbr->freeResult( $oRes );
	} 
} else {
	echo "Invalid options \n";
}

echo "end \n";
