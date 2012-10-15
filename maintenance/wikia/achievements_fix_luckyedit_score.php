<?php
/**
 * This script fixes the score of users with more than one lucky edit badge as part of the fix on rt#61228
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Federico 'Lox' Lucignano <federico@wikia-inc.com>
 *
 * @usage: SERVER_ID=177 php achievements_fix_luckyedit_score.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 */
ini_set( "include_path", dirname(__FILE__)."/../" );
$options = array('help');
require_once( 'commandLine.inc' );
global $IP, $wgCityId;

echo( "Update Achievements lucky edits score\n\n" );

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php achievements_takeRankingSnapshot.php\n\n" );
	exit( 0 );
}

require_once("$IP/extensions/wikia/AchievementsII/Ach_setup.php");

echo( "Loading list of users to process" );

$dbw = WikiFactory::db( DB_MASTER );
$users = $dbw->select('ach_user_badges', array( "DISTINCT user_id", 'wiki_id' ), array('badge_type_id' => BADGE_LUCKYEDIT));
$usersCount = $users->numRows();

echo(": {$usersCount} user(s) to process\n\n");

if($usersCount) {
	while($currentUser = $dbw->fetchObject($users)) {
		echo( "- Processing user {$currentUser->user_id} on wiki {$currentUser->wiki_id}: " );
		$badges = $dbw->selectField('ach_user_badges', array('COUNT(*) as cnt'), array('wiki_id' => $currentUser->wiki_id, 'user_id' => $currentUser->user_id, 'badge_type_id' => BADGE_LUCKYEDIT));

		if($badges > 1) {
			$score = $dbw->selectField('ach_user_score', array('score'), array('wiki_id' => $currentUser->wiki_id, 'user_id' => $currentUser->user_id));
			echo( "lucky edits {$badges}, original score {$score}" );

			$wgCityId = $currentUser->wiki_id;
			$srvc = new AchAwardingService();
			$srvc->migration($currentUser->user_id);

			sleep(3);
			$score = $dbw->selectField('ach_user_score', array('score'), array('wiki_id' => $currentUser->wiki_id, 'user_id' => $currentUser->user_id));
			echo( ", new score {$score}.\n" );
		}
		else {
			echo("this user has only {$badges} lucky edits, skipping.\n");
		}
	}

	echo("\nDone\n");
}
else {
	echo("Nothing to do\n");
}

$dbw->freeResult($users);

echo( "\n" );

?>
