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

class AutomaticWikiAdoptionGatherData {
	
	//entry point
	function run($commandLineOptions) {
		global $wgEnableAutomaticWikiAdoptionMaintenanceScript;

		if (empty($wgEnableAutomaticWikiAdoptionMaintenanceScript)) {
			if (!isset($commandLineOptions['quiet'])) {
				echo "wgEnableAutomaticWikiAdoptionMaintenanceScript not true on central wiki (ID:177) - quitting.\n";
			}
			return;
		}

		$recentAdminEdits = $this->getRecentAdminEdits();
		$wikisToAdopt = 0;
		$time14days = strtotime('-14 days');
		$time27days = strtotime('-27 days');
		$time30days = strtotime('-30 days');

		foreach ($recentAdminEdits as $wikiId => $wikiData) {
			$jobName = '';
			$jobOptions = array();
			if ($wikiData['recentEdit'] < $time30days) {
				$wikisToAdopt++;
				$this->setAdoptionFlag($commandLineOptions, $jobOptions, $wikiId, $wikiData);
			} elseif ($wikiData['recentEdit'] < $time27days) {
				$jobOptions['mailType'] = 'second';
				$this->sendMail($commandLineOptions, $jobOptions, $wikiId, $wikiData);
			} else /*if ($wikiData['recentEdit'] < $time14days)*/ {
				$jobOptions['mailType'] = 'first';
				$this->sendMail($commandLineOptions, $jobOptions, $wikiId, $wikiData);				
			}
		}

		if (!isset($commandLineOptions['quiet'])) {
			echo "Set $wikisToAdopt wikis as adoptable.\n";
		}
	}

	function getRecentAdminEdits() {
		global $wgStatsDB, $wgStatsDBEnabled;

		$recentAdminEdit = array();
		
		if ( !empty($wgStatsDBEnabled) ) {
			$dbrStats = wfGetDB(DB_SLAVE, array(), $wgStatsDB);			

			//get wikis with pages < 1000 and admins not active in last 14 days but wit at least 1 edit
			//260000 = ID of wiki created on 2011-05-01 so it will work for wikis created after this project has been deployed
			$res = $dbrStats->query(
				'select e1.wiki_id, sum(e1.edits) as sum_edits from specials.events_local_users e1 ' .
				'where e1.wiki_id > 260000 ' .
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
				') > 0 LIMIT 10000',
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
					if (($lastedit = wfTimestamp(TS_UNIX, $row2->lastedit)) < $recentAdminEdit[$row->wiki_id]['recentEdit']) {
						$recentAdminEdit[$row->wiki_id]['recentEdit'] = $lastedit;
					}
					$recentAdminEdit[$row->wiki_id]['admins'][] = $row2->user_id;
				}
			}
		}

		return $recentAdminEdit;
	}
	
	function setAdoptionFlag($commandLineOptions, $jobOptions, $wikiId, $wikiData) {
		//let wiki to be adopted
		if (!isset($commandLineOptions['dryrun'])) {
			WikiFactory::setFlags($wikiId, WikiFactory::FLAG_ADOPTABLE);
		}

		//print info
		if (!isset($commandLineOptions['quiet'])) {
			echo "Wiki (id:$wikiId) set as adoptable.\n";
		}
	}
	
	function sendMail($commandLineOptions, $jobOptions, $wikiId, $wikiData) {
		global $wgSitename; 
		
		$wiki = WikiFactory::getWikiByID($wikiId);
		$magicwords = array('#WIKINAME' => $wiki->city_title);
		
		$flags = WikiFactory::getFlags($wikiId);
		$flag = $jobOptions['mailType'] == 'first' ? WikiFactory::FLAG_ADOPT_MAIL_FIRST : WikiFactory::FLAG_ADOPT_MAIL_SECOND;
		//this kind of e-mail already sent for this wiki
		if ($flags & $flag) {
			return;
		}

		$globalTitleUserRights = GlobalTitle::newFromText('UserRights', -1, $wikiId);
		$specialUserRightsUrl = $globalTitleUserRights->getFullURL();
		$globalTitlePreferences = GlobalTitle::newFromText('Preferences', -1, $wikiId);
		$specialPreferencesUrl = $globalTitlePreferences->getFullURL();

		wfLoadExtensionMessages('AutomaticWikiAdoption');
		//at least one admin has not edited during xx days
		foreach ($wikiData['admins'] as $adminId) {
			//print info
			if (!isset($commandLineOptions['quiet'])) {
				echo "Trying to send the e-mail to the user (id:$adminId) on wiki (id:$wikiId).\n";
			}

			$adminUser = User::newFromId($adminId);
			$defaultOption = null;
			if ( $wikiId > 194785 ) {
				$defaultOption = 1;
			}			
			$acceptMails = $adminUser->getOption("adoptionmails-$wikiId", $defaultOption);
			if ($acceptMails && $adminUser->isEmailConfirmed()) {
				$adminName = $adminUser->getName();
				if (!isset($commandLineOptions['quiet'])) {
					echo "Sending the e-mail to the user (id:$adminId, name:$adminName) on wiki (id:$wikiId).\n";
				}
				if (!isset($commandLineOptions['dryrun'])) {
					echo "Really Sending the e-mail to the user (id:$adminId, name:$adminName) on wiki (id:$wikiId).\n";
					$adminUser->sendMail(
						strtr(wfMsgForContent("wikiadoption-mail-{$jobOptions['mailType']}-subject"), $magicwords),
						strtr(wfMsgForContent("wikiadoption-mail-{$jobOptions['mailType']}-content", $adminName, $specialUserRightsUrl, $specialPreferencesUrl), $magicwords),
						null, //from
						null, //replyto
						'AutomaticWikiAdoption',
						strtr(wfMsgForContent("wikiadoption-mail-{$jobOptions['mailType']}-content-HTML", $adminName, $specialUserRightsUrl, $specialPreferencesUrl), $magicwords)
					);
				}
			}
		}

		if (!isset($commandLineOptions['dryrun'])) {
			WikiFactory::setFlags($wikiId, $flag);
		}
	}
}
