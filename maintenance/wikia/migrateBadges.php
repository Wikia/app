<?php
require_once("../commandLine.inc");
require_once("/usr/wikia/source/AchievementsII/extensions/wikia/AchievementsII/Ach_setup.php");

/*
 * SERVER_ID=11765 php migrateBadges.php --conf=/usr/wikia/conf/current/wiki.factory/LocalSettings.php
 * http://community.wikia.com/wiki/Special:WhereIsExtension?var=909&val=0
 */

/*
 * BADGES
 */

$badgesToInsert = array();
$dbr = wfGetDB(DB_MASTER);
$res = $dbr->query("select * from achievements_badges");
while($row = $dbr->fetchObject($res)) {

	$badge = array();

	if($row->badge_type > 0) {
		$badge['wiki_id'] = $wgCityId;
		$badge['user_id'] = $row->user_id;
		$badge['badge_type_id'] = -1 * $row->badge_type;
		$badge['badge_lap'] = $row->badge_lap;
		$badge['badge_level'] = $row->badge_level;
		$badge['date'] = $row->date;
		$badge['notified'] = $row->notified;
		$badgesToInsert[] = $badge;
	}
}

$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
$dbw->insert('ach_user_badges', $badgesToInsert);

sleep(1);

/*
 * CONUTERS
 */
$dbr = wfGetDB(DB_MASTER);
$res = $dbr->query("select * from achievements_counters");
while($row = $dbr->fetchObject($res)) {
	$counter = array();
	$counter['user_id'] = $row->user_id;
	$counter['data'] = array();

	$data = unserialize($row->data);

	foreach($data as $counter_key => $counter_value) {

		if($counter_key == 6) {
			$counter_value_new = array(1 => $counter_value['counter'], 2 => $counter_value['date']);
		} else if($counter_key == 13) {
			$counter_value_new = array(1 => $counter_value['counter'], 2 => $counter_value['date']);
		} else {
			$counter_value_new = $counter_value;
		}

		$counter['data'][-1 * $counter_key] = $counter_value_new;
	}

	$userCountersService = new AchUserCountersService($counter['user_id']);
	$userCountersService->setCounters($counter['data']);
	$userCountersService->save();

	$awardingService = new AchAwardingService();
	$awardingService->migration($counter['user_id']);

}
