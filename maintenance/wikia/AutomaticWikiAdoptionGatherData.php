<?php
/**
 * AutomaticWikiAdoptionGatherData
 *
 * An AutomaticWikiAdoption extension for MediaWiki
 * Maintenance script for gathering data - mark wikis available for adoption
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-10-08
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage Maintanance
 *
 */

require_once('../commandLine.inc');

if (isset($options['help'])) {
	die( "Usage: php AutomaticWikiAdoptionGatherData.php [--quiet]

		  --help     you are reading it right now
		  --quiet    do not print anything to output\n\n");
}

global $wgExternalDatawareDB, $wgExternalSharedDB, $wgStatsDB;

$dbwWikicities = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
$dbrDataware = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);
$dbrStats = wfGetDB(DB_SLAVE, array(), $wgStatsDB);

$time14days = strtotime('-14 days');
$time27days = strtotime('-27 days');
$time30days = strtotime('-30 days');

$recentAdminEdit = array();
$wikisToAdopt = 0;

//get wikis with pages < 1000 and admins not active in last 14 days
$res = $dbrStats->query(
	'select e1.wiki_id, sum(e1.edits) as sum_edits from events_local_users e1 where e1.wiki_id > 0 group by e1.wiki_id having sum_edits < 1000 and (select count(0) from events_local_users e2 where e1.wiki_id = e2.wiki_id and all_groups like "%sysop%" and editdate > now() - interval 14 day) = 0;',
	__METHOD__
);

while ($row = $dbrStats->fetchObject($res)) {
	$res2 = $dbrStats->query(
		"select user_id, max(editdate) as lastedit from specials.events_local_users where wiki_id = {$row->wiki_id} and all_groups like '%sysop%' group by 1 order by null;",
		__METHOD__
	);

	$recentAdminEdit[$row->wiki_id] = array(
		'recentEdit' => time(),
		'admins' => array()
	);
	while ($row2 = $dbrStats->fetchObject($res2)) {
		if (($lastedit = wfTimestamp(TS_UNIX, $res2->lastedit)) < $recentAdminEdit[$row->wiki_id]['recentEdit']) {
			$recentAdminEdit[$row->wiki_id]['recentEdit'] = $lastedit;
		}
		$recentAdminEdit[$row->wiki_id]['admins'][] = $row2->user_id;
	}
}

foreach ($recentAdminEdit as $wikiId => $wikiData) {
	if ($wikiData['recentEdit'] < $time30days) {
		//let wiki to be adopted
		//TODO: use WikiFactory::setFlags() ? many queries instead of one - but logs this changes into WF log
		$row = $dbwWikicities->update(
			'city_list',
			'city_flags = ( city_flags | ' . WikiFactory::FLAG_ADOPTABLE . ' )',
			array('city_id' => $wikiId),
			__METHOD__
		);
		$wikisToAdopt++;

		//print info
		if (!isset($options['quiet'])) {
			echo "Wiki (id:$row->wiki_id) set as adoptable.\n";
		}
	} elseif ($wikiData['recentEdit'] < $time27days) {
		//at least one admin has not edited during 27 days
		foreach ($data['admins'] as $adminId) {
			sendMailToUser($wikiId, $adminId, 'second');
		}
	} else /*if ($wikiData['recentEdit'] < $time14days)*/ {
		//at least one admin has not edited during 14 days
		foreach ($data['admins'] as $adminId) {
			sendMailToUser($wikiId, $adminId, 'first');
		}
	}
}

if (!isset($options['quiet'])) {
	echo "Set $wikisToAdopt wikis as adoptable.\n";
}

function sendMailToUser($wikiId, $userId, $type) {
	//print info
	if (!isset($options['quiet'])) {
		echo "Sending e-mail to user (id:$userId) on wiki (id:$wikiId).\n";
	}

	$requestorUser = User::newFromId($userId);
	if ($requestorUser->isEmailConfirmed()) {
		//TODO: add some parameters (at least link to wiki)
		$requestorUser->sendMail(
			wfMsgForContent("automaticwikiadoption-mail-$type-subject"),
			wfMsgForContent("automaticwikiadoption-mail-$type-content"),
			null, //from
			null, //replyto
			'AutomaticWikiAdoption',
			wfMsgForContent("automaticwikiadoption-mail-$type-content-HTML")
		);
	}
}