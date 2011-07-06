<?php
/**
 * This script is spawned by UserPathPRediction_initData.php, it analyzes the data store in an intermediate format
 * and stores the results in the DB
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Federico 'Lox' Lucignano <federico(at)wikia-inc.com>
 *
 * @usage: SERVER_ID=177 php UserPathPrediction_analyzeData.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 */

ini_set( 'include_path', dirname( __FILE__ ) . '/../' );

$options = array( 'help' );

require_once( 'commandLine.inc' );

global $IP;

if ( isset( $options['help'] ) ) {
	echo(
		"Usage: SERVER_ID=177 php UserPathPrediction_initData.php " .
		"--conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php " .
		"--aconf /usr/wikia/conf/current/AdminSettings.php"
	);
	exit( 0 );
}

//by default the script will download and process data for the last 24 hours
$date = ( !empty( $options['date'] ) ) ? $options['date'] : date( "Ymd", strtotime( "-1 day" ) );//"20110504"

require_once( "$IP/extensions/wikia/hacks/UserPathPrediction/UserPathPrediction.setup.php" );

$app = F::app();
$wikiInfo =  $app->wg->DBname . '(' . $app->wg->CityId . ')';

$app->sendRequest( 'UserPathPredictionService', 'log', array( 'msg' => "Start data analysis for wiki: {$wikiInfo}" ) );
echo( "Analyzing data for wiki: {$wikiInfo}, this could take a while...\n\n" );

try{
	$app->sendRequest( 'UserPathPredictionService', 'analyzeLocalData' );
} catch (WikiaException $e) {
	$msg = $e->__toString();
	$app->sendRequest( 'UserPathPredictionService', 'log', array( 'msg' => $msg ) );
	echo $msg;
	exit( 1 );
}

echo( "Done.\n\n" );
?>