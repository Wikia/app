<?php
/**
 * This script deletes duplicate badges and fixes the user scores as part of the fix on BugId:10264
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Owen Davis <owen@wikia-inc.com>
 *
 * @usage: SERVER_ID=177 php achievements_removeDuplicates.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 */
$options = array('help');
@require_once( '../commandLine.inc' );
global $IP, $wgCityId;

echo( "Remove Duplicate Badges\n\n" );

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php achievements_removeDuplicateBadges.php\n\n" );
	exit( 0 );
}

require_once("$IP/extensions/wikia/AchievementsII/Ach_setup.php");

echo( "Loading list of users to process" );

$dbw = WikiFactory::db( DB_MASTER );
// select user_id, wiki_id, badge_type_id, badge_lap, badge_level, min(date) as first, count(badge_type_id) dupes from ach_user_badges group by user_id,badge_type_id, badge_lap, badge_level having dupes > 1 ;
$rows = $dbw->select('ach_user_badges', 
		array( "user_id", 'wiki_id', 'badge_type_id', 'badge_lap', 'badge_level', 'min(date) as first', 'count(badge_type_id) as dupes' ),
		array (),						// criteria = all wikis
//		array( "wiki_id" => "413"),		// testing = one wiki
		__METHOD__,
		array("GROUP BY" => "wiki_id, user_id,badge_type_id, badge_lap, badge_level having dupes > 1"));

$rowCount = $rows->numRows();
print_pre($dbw);
echo(": {$rowCount} duplicate badges to process\n\n");

if($rowCount) {
	while($dupe = $dbw->fetchObject($rows)) {
		echo( "- Processing dupe for user {$dupe->user_id} on wiki {$dupe->wiki_id}\n" );

		// Delete all but the first duplicate badge
		$criteria = array();
		$criteria['user_id'] = $dupe->user_id;
		$criteria['wiki_id'] = $dupe->wiki_id;
		$criteria['badge_type_id'] = $dupe->badge_type_id;
		$criteria['badge_lap'] = $dupe->badge_lap;
		$criteria['badge_level'] = $dupe->badge_level; 
		$criteria[] =  "date > '{$dupe->first}'";
		$dbw->delete('ach_user_badges', $criteria);
		$dbw->commit();
		// wait for slave lag
		sleep(1); 
		// set the global wgCityId so AchAwardingService does the right thing
		$wgCityId = $dupe->wiki_id;
		$srvc = new AchAwardingService();
		// recalculate score
		$srvc->migration($dupe->user_id);

	}

	echo("\nDone\n");
}
else {
	echo("Nothing to do\n");
}

$dbw->freeResult($rows);

echo(": {$rowCount} duplicate badges deleted.\n\n");

?>
