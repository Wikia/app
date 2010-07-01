<?php
/**
 * take old revisions and put events in events table via scribe
 * 
 *
 * @file
 * @ingroup Maintenance
 * @author Piotr Molski <moli@wikia-inc.com>
 */

ini_set( 'memory_limit', '512M' );
ini_set( "include_path", dirname(__FILE__)."/.." );
$IP = $GLOBALS["IP"];
require_once( "commandLine.inc" );
include_once("$IP/extensions/wikia/Scribe/ScribeClient.php");
include_once("$IP/extensions/wikia/Scribe/ScribeProducer.php");

# Do an initial scan for inactive accounts and report the result
echo( "Start script ...\n" );

$help = isset($options['help']);
$wikia = isset($options['wikia']) ? $options['wikia'] : '';
$events = isset($options['events']);
$sleep = isset($options['sleep']) ? $options['sleep'] : '';
$sloop = isset($options['sloop']) ? $options['sloop'] : '';
$scribe = isset($options['scribe']) ? $options['scribe'] : '';
#echo print_r($options, true);

function runArchiveStats($city_id) {
	global $IP, $wgWikiaLocalSettingsPath;
	global $wgMaxShellMemory;
	
	global $sleep, $sloop;
	$script_path = $_SERVER['PHP_SELF'];
	$wgMaxShellMemory = $wgMaxShellMemory * 3;
	$path = "SERVER_ID={$city_id} php {$script_path} --events=1 --conf {$wgWikiaLocalSettingsPath} --sleep=$sleep --sloop=$sloop";
	#echo $path . " \n";
	$return = wfShellExec( $path );
	echo $return;
}

function callScribeProducer($page_id, $page_ns, $rev_id, $user_id) {
	global $IP, $wgWikiaLocalSettingsPath, $wgCityId;
	$script_path = $_SERVER['PHP_SELF'];
	$path = "SERVER_ID={$wgCityId} php {$script_path} --scribe=1 --conf {$wgWikiaLocalSettingsPath} --page_id=$page_id --page_ns=$page_ns --rev_id=$rev_id --user_id=$user_id";
	#echo $path . " \n";
	$return = wfShellExec( $path );
	echo $return;
}

function checkIsNew($page_id, $rev_id) {
	wfProfileIn( __METHOD__ );

	$dbr = wfGetDB( DB_SLAVE, 'stats' );
	$oRow = $dbr->selectRow( 
		array( 'revision' ), 
		array( 'rev_id' ), 
		array( 
			"rev_id < " . intval($rev_id),
			'rev_page' => $page_id,
		),
		'archiveStatsData',
		array( 'ORDER BY' => 'rev_id') 
	);

	$return = ( isset( $oRow->rev_id ) ) ? false : true; 
}

function callEditHook($page_id, $rev_id, $page_ns, $user_id) {
	global $wgCityId, $wgServer;
	$wgServer = WikiFactory::getVarValueByName( "wgServer", $wgCityId );
	# flags
	$flags = "";
	# article
	$oArticle = Article::newFromID($page_id);
	# user
	$oUser = User::newFromId($user_id);
	# revision
	$oRevision = Revision::newFromId($rev_id);
	# status - new or edit
	$status = Status::newGood( array() );
	# check is new
	$status->value['new'] = checkIsNew($page_id, $rev_id);
	# call function
	$res = ScribeProducer::saveComplete( &$oArticle, &$oUser, null, null, null, null, null, &$flags, $oRevision, &$status, 0 );
	#
	unset($oArticle);
	unset($oUser);
	unset($oRevision);
	unset($status);
	unset($res);
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
	$dbr = wfGetDB( DB_SLAVE, 'stats' );
	$oRes = $dbr->select(
		array( 'page', 'revision' ), 
		array( 'page_id, page_namespace, rev_id, rev_user' ), 
		array( 'page_id = rev_page' ), 
		'archiveStatsData',
		array( 'ORDER BY' => 'rev_id') 
	);

	if ( $oRes ) {
		$count = $dbr->numRows( $oRes );
		echo "$count records found \n";
		if ( $count ) {
			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				#echo (" $loop % $sloop = " . $loop % $sloop . " \n");
				if ( ( $loop % $sloop ) == 0 ) {
					echo ("$loop. sleep: " . $sleep . "\n");
					sleep($sleep);
				}
				#callScribeProducer($oRow->page_id, $oRow->page_namespace, $oRow->rev_id, $oRow->rev_user);
				callEditHook($oRow->page_id, $oRow->rev_id, $oRow->page_namespace, $oRow->rev_user);
				$loop++;
			}
			$dbr->freeResult( $oRes );
		}
	}
} 
elseif ( $scribe ) {
	$page_id = isset($options['page_id']) ? $options['page_id'] : '';
	$rev_id = isset($options['rev_id']) ? $options['rev_id'] : '';
	$user_id = isset($options['user_id']) ? $options['user_id'] : '';
	$page_ns = isset($options['page_ns']) ? $options['page_ns'] : '';
	if ( $page_id && $rev_id ) {
		callEditHook($page_id, $rev_id, $page_ns, $user_id);
	}
}
else {
	$dbr = wfGetDB( DB_SLAVE, 'stats', $wgExternalSharedDB );
	$where = array( 'city_public' => 1 );
	if ( !empty($wikia) ) {
		$where['city_dbname'] = $wikia;
	}
	$res = $dbr->select( 'city_list', array( '*' ), $where, 'archiveStatsData' );
	while( $row = $dbr->fetchObject( $res ) ) {
		runArchiveStats($row->city_id);
	}
	$dbr->freeResult( $res );
}

echo "end \n";
