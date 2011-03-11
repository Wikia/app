<?php
/**
 * AutomaticWikiAdoptionGatherDataMapper
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

class AutomaticWikiAdoptionGatherDataMapper {
	private $dbwWikicities;

	function getWikicitiesDB() {
		if ($this->dbwWikicities === null) {
			global $wgExternalSharedDB;
			$this->dbwWikicities = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		}
		return $this->dbwWikicities;
	}

	function getData() {
		global $wgStatsDB;

		$dbrStats = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
		$recentAdminEdit = array();

		//get wikis with pages < 1000 and admins not active in last 14 days but wit at least 1 edit
		//194785 = ID of wiki created on 2010-12-14 so it will work for wikis created after this project has been deployed
		$res = $dbrStats->query(
			'select e1.wiki_id, sum(e1.edits) as sum_edits from specials.events_local_users e1 ' .
			'where e1.wiki_id > 194785 ' .
			'group by e1.wiki_id ' .
			'having sum_edits < 1000 and (' .
			'select count(0) from specials.events_local_users e2 ' .
			'where e1.wiki_id = e2.wiki_id and ' .
			'all_groups like "%sysop%" and ' .
			'editdate > now() - interval 14 day ' .
			') = 0 and (' .
			'select count(*) from specials.events_local_users e3 ' .
			'where e1.wiki_id = e3.wiki_id and ' .
			'all_groups like "%sysop%" and ' .
			'edits > 0' .
			') > 0',
			__METHOD__
		);

		while ($row = $dbrStats->fetchObject($res)) {
			if (WikiFactory::IDtoDB($row->wiki_id) === false) {
				//check if wiki exists in city_list
				continue;
			}

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

		return $recentAdminEdit;
	}

	function getFlags($wikiId) {
		return WikiFactory::getFlags($wikiId);
	}

	function setFlags($wikiId, $flags) {
		WikiFactory::setFlags($wikiId, $flags);
	}
}