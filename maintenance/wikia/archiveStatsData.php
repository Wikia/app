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

$help = isset($options['help']);
$wikia = $options['wikia'];
$events = isset($options['events']);
$sleep = $options['sleep'];
$sloop = $options['sloop'];
#echo print_r($options, true);

function runArchiveStats($city_id) {
	global $IP, $wgWikiaLocalSettingsPath;
	global $sleep, $sloop;
	$script_path = $_SERVER['PHP_SELF'];
	$path = "SERVER_ID={$city_id} php {$script_path} --events=1 --conf {$wgWikiaLocalSettingsPath} --sleep=$sleep --sloop=$sloop";
	#echo $path . " \n";
	$return = wfShellExec( $path );
}

function callEditHook(&$articles, $oRow) {
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
}

if ( $help ) {
	echo <<<TEXT
Usage:
    php archiveStatsData.php --help
    php archiveStatsData.php [--sleep=X] [--sloop=Y]

    --help         : This help message
    --wikia=S      : Run script for Wikia (city_dbname)
    --sleep=X      : Sleep time in seconds - number of seconds after the execution of sloop=Y tasks
    --sloop=Y      : How many tasks the script should run to to sleep X seconds
TEXT;
	exit(0);
}
elseif ( $events ) {
	$loop = 1;
	if ( empty($sleep) ) {
		$sleep = 3;
	}
	if ( empty($sloop) ) {
		$sloop = 50;
	}
	$articles = array();
	$dbr = wfGetDB( DB_SLAVE, 'stats' );
	$oRes = $dbr->select(
		array( 'page', 'revision' ), 
		array( 'page_id, page_namespace, rev_id, rev_user' ), 
		array( 'page_id = rev_page' ), 
		$fname,
		array( 'ORDER BY' => 'rev_id', 'LIMIT' => 100) 
	);

	if ( $oRes ) {
		while( $oRow = $dbr->fetchObject( $oRes ) ) {
			if ( ( $loop % $sloop ) == 0 ) {
				echo "$loop. sleep: " . $sleep . "\n";
				sleep($sleep);
			}
			callEditHook(&$articles, $oRow);
			$loop++;
		}
		$dbr->freeResult( $oRes );
	} 
} 
else {
	$dbr = wfGetDB( DB_SLAVE, 'stats', $wgExternalSharedDB );
	$where = array( 'city_public' => 1 );
	if ( !empty($wikia) ) {
		$where['city_dbname'] = $wikia;
	}
	$res = $dbr->select( 'city_list', array( '*' ), $where, $fname );
	while( $row = $dbr->fetchObject( $res ) ) {
		runArchiveStats($row->city_id);
	}
	$dbr->freeResult( $res );
}

echo "end \n";
