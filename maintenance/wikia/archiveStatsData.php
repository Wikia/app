<?php
/**
 * take old revisions and put events in events table via scribe
 * 
 *
 * @file
 * @ingroup Maintenance
 * @author Piotr Molski <moli@wikia-inc.com>
 */

ini_set('memory_limit', '-1');
ini_set('display_errors', 'stderr');
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
$dateRun = isset($options['date']) ? $options['date'] : '';
#echo print_r($options, true);

function runArchiveStats($city_id, $serverName, $dateRun) {
	global $IP, $wgWikiaLocalSettingsPath;
#	global $wgMaxShellMemory, $wgMaxShellTime;
	
	global $sleep, $sloop;
	$script_path = $_SERVER['PHP_SELF'];
#	$wgMaxShellMemory = $wgMaxShellMemory * 10;
#	$wgMaxShellTime = $wgMaxShellTime * 10;
	$path = "SERVER_ID={$city_id} php {$script_path} --events=1 --conf {$wgWikiaLocalSettingsPath} --serverName=$serverName --sleep=$sleep --sloop=$sloop --date=$dateRun";
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

function time_duration($seconds, $use = null, $zeros = false) {
	$periods = array (
		'years'     => 31556926,
		'Months'    => 2629743,
		'weeks'     => 604800,
		'days'      => 86400,
		'hours'     => 3600,
		'minutes'   => 60,
		'seconds'   => 1
	);
	
	// Break into periods
	$seconds = (float) $seconds;
	$segments = array();
	foreach ($periods as $period => $value) {
		if ($use && strpos($use, $period[0]) === false) {
			continue;
		}
		$count = floor($seconds / $value);
		if ($count == 0 && !$zeros) {
			continue;
		}
		$segments[strtolower($period)] = $count;
		$seconds = $seconds % $value;
	}
	
	// Build the string
	$string = array();
	foreach ($segments as $key => $value) {
		$segment_name = substr($key, 0, -1);
		$segment = $value . ' ' . $segment_name;
		if ($value != 1) {
			$segment .= 's';
		}
		$string[] = $segment;
	}
	return implode(', ', $string);
}

function bytes($size) {
	$unit=array('b','kb','mb','gb','tb','pb');
	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
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

function callEditHook($page_id, $rev_id, $page_ns, $user_id, $serverName) {
	global $wgCityId, $wgServer;
	$wgServer = $serverName; 
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
	$res = ScribeProducer::saveComplete( $oArticle, $oUser, null, null, null, null, null, $flags, $oRevision, $status, 0 );
	#
	$oArticle = $oUser = $oRevision = $status = $res = null;
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
    --date=YYYYMM  : Run for YYYYMM date
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

	$wiki_start = time();
	echo "Run job for Wikia({$wgDBname}, $wgCityId) \n";
	$serverName = isset($options['serverName']) ? $options['serverName'] : WikiFactory::getVarValueByName( "wgServer", $wgCityId );
	
	$where = array( 'page_id = rev_page' );
	if ( $dateRun ) {
		$where[] = " date_format(rev_timestamp, '%Y%m') = '".$dateRun."' ";
	}
	
	$dbr = wfGetDB( DB_SLAVE, 'stats' );
	$oRes = $dbr->select(
		array( 'page', 'revision' ), 
		array( 'page_id, page_namespace, rev_id, rev_user' ), 
		$where, 
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
					echo ("$loop. sleep: " . $sleep . " " . bytes(memory_get_usage(true)) . " \n");
					sleep($sleep);
				}
				#callScribeProducer($oRow->page_id, $oRow->page_namespace, $oRow->rev_id, $oRow->rev_user);
				callEditHook($oRow->page_id, $oRow->rev_id, $oRow->page_namespace, $oRow->rev_user, $serverName);
				$loop++;
			}
			$dbr->freeResult( $oRes );
		}
	}
	$wiki_end = time();
	echo "Script finished for Wikia ({$wgDBname}, {$row->city_id}) after " . time_duration($wiki_end - $wiki_start) . " \n";
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
	$start = time();
	$res = $dbr->select( 'city_list', array( '*' ), $where, 'archiveStatsData' );
	while( $row = $dbr->fetchObject( $res ) ) {
		$serverName = WikiFactory::getVarValueByName( "wgServer", $row->city_id );
		runArchiveStats($row->city_id, $serverName, $dateRun);
	}
	$dbr->freeResult( $res );
	$end = time();
	echo "Script finished after: " . time_duration($end - $start) . " \n";
}

echo "end \n";
