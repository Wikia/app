<?php
/**
 * This script takes a snapshot of the current user ranking if Achievements extension is enabled and stores it in the
 * ach_ranking_snapshots table stored in $wgExternalSharedDB
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Federico 'Lox' Lucignano <federico@wikia-inc.com>
 *
 * @usage: SERVER_ID=177 php achievements_takeRankingSnapshot.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 */

ini_set( "include_path", dirname(__FILE__)."/../" );
$options = array('help');
require_once( 'commandLine.inc' );
global $IP, $wgCityId;

echo( "Update Achievements users ranking snapshots\n\n" );

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php achievements_takeRankingSnapshot.php\n\n" );
	exit( 0 );
}

echo( "Loading list of wikis to process" );

$dbw = WikiFactory::db( DB_MASTER );
$cityList = $dbw->select('ach_user_score', array( "DISTINCT wiki_id" ));
$wikiCount = $cityList->numRows();

echo(": {$wikiCount} wiki(s) to process\n\n");

if($wikiCount) {
	require_once("$IP/extensions/wikia/AchievementsII/Ach_setup.php");
	
	while($currentCity = $dbw->fetchObject($cityList)) {
		$wgCityId = $currentCity->wiki_id;
		Ach_TakeRankingSnapshot();
	}

	echo("\nDone\n");
}
else {
	echo("Nothing to do\n");
}

$dbw->freeResult($cityList);

echo( "\n" );

?>
