<?php
/**
 * This script removes badges from the Blog Post track with a lap higher than 1 and recalculates the user score
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Federico 'Lox' Lucignano <federico@wikia-inc.com>
 *
 * @usage: SERVER_ID=177 php achievements_removeBlogPostBadges.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 */

ini_set( "include_path", dirname(__FILE__)."/../" );
$options = array('help');
require_once( 'commandLine.inc' );
global $IP, $wgCityId;
require_once("$IP/extensions/wikia/AchievementsII/Ach_setup.php");

echo( "Remove awarded badges from the Blog Post track with lap higher than 1\n\n" );
echo( "Loading list of users to process" );

$dbw = WikiFactory::db( DB_MASTER );
$queryBadgeFilters = array('badge_type_id' => BADGE_BLOGPOST, 'badge_lap > 0');
$usersList = $dbw->select('ach_user_badges', array( "DISTINCT user_id" ), $queryBadgeFilters);
$usersCount = $usersList->numRows();

echo(": {$usersCount} user(s) have unwanted Blog Post badges\n\n");

if($usersCount) {
	echo("Removing the badges\n\n");
	$dbw->delete('ach_user_badges', $queryBadgeFilters);
	
	
	echo("Recalculating user score and counters:\n\n");
	
	while($currentUser = $dbw->fetchObject($usersList)) {
		echo("\t* Processing user {$currentUser->user_id}\n");
		
		$userCounters = $dbw->select('ach_user_counters', array('data'), array('user_id' => $currentUser->user_id));

		if($row = $dbw->fetchObject($userCounters)) {
			
			$counters = unserialize($row->data);
			
			foreach($counters as $wikiId => $data) {
				$data[BADGE_BLOGPOST] = 1;
				$wgCityId = $wikiId;

				echo("\t\t- Recalculating user counters for Wiki ID {$wikiId}\n");
				$userCountersService = new AchUserCountersService($currentUser->user_id);
				$userCountersService->setCounters($data);
				$userCountersService->save();

				echo("\t\t- Recalculating user score for Wiki ID {$wikiId}\n\n");
				$awardingService = new AchAwardingService();
				$awardingService->migration($currentUser->user_id);
			}

			
		}
		else {
			echo ('\t\tError, this user has no counters!');
		}
	}

	$dbw->commit();
	echo("\nDone\n");
}
else {
	echo("Nothing to do\n");
}

$dbw->freeResult($usersList);

echo( "\n" );
