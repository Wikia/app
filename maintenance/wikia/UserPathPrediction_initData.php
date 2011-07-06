<?php
/**
 * This script downloads the data required for UserPathPrediction and parses it
 * in an intermediate format, then it spawns another process (one per each wiki
 * being considered in the data analysis) where that format gets further processed
 * and stored in DB in a summary table
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Federico 'Lox' Lucignano <federico(at)wikia-inc.com>
 * @author: Jakub Olek <bukaj.kelo(at)gmail.com>
 *
 * @usage: SERVER_ID=177 php UserPathPrediction_initData.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 */

ini_set( "include_path", dirname(__FILE__)."/../" );

$options = array(
	'help',
	'date'
);

require_once( 'commandLine.inc' );

global $IP;

if ( isset( $options['help'] ) ) {
	echo(
		"Usage: SERVER_ID=177 php UserPathPrediction_initData.php " .
		"--conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php " .
		"--aconf /usr/wikia/conf/current/AdminSettings.php " .
		"--date 20110623\n\n"
	);
	exit( 0 );
}

//by default the script will download and process data for the last 24 hours
$date = ( !empty( $options['date'] ) ) ? $options['date'] : date( "Ymd", strtotime( "-1 day" ) );//"20110504"

require_once( "$IP/extensions/wikia/hacks/UserPathPrediction/UserPathPrediction.setup.php" );

$app = F::app();

echo( "Initializing data analysis for User Path Prediction\n\n" );

$app->sendRequest( "UserPathPredictionService", "extractOneDotData", array( "date" => $date ) );
?>