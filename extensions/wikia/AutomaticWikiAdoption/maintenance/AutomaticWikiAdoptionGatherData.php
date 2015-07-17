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

		$wikisToAdopt = 0;
		$time45days = strtotime('-45 days');
		$time57days = strtotime('-57 days');
		$time60days = strtotime('-60 days');
		
		// set default
		$fromWikiId = 260000;	// 260000 = ID of wiki created on 2011-05-01
		$maxWikiId = (isset($commandLineOptions['maxwiki']) && is_numeric($commandLineOptions['maxwiki'])) ? $commandLineOptions['maxwiki'] : $this->getMaxWikiId();
		$range = 5000;
		if ( $fromWikiId <= $maxWikiId ) {
			// looping
			do {
				if ($maxWikiId-$fromWikiId < $range)
					$range = $maxWikiId - $fromWikiId;
				
				$toWikiId = $fromWikiId + $range;
				$recentAdminEdits = $this->getRecentAdminEdits($fromWikiId, $toWikiId);

				foreach ($recentAdminEdits as $wikiId => $wikiData) {
					$jobName = '';
					$jobOptions = array();
					if ($wikiData['recentEdit'] < $time60days) {
						$wikisToAdopt++;
						$this->setAdoptionFlag($commandLineOptions, $jobOptions, $wikiId, $wikiData);
					} elseif ($wikiData['recentEdit'] < $time57days) {
						$jobOptions['mailType'] = 'second';
						$this->sendMail($commandLineOptions, $jobOptions, $wikiId, $wikiData);
					} elseif ($wikiData['recentEdit'] < $time45days) {
						$jobOptions['mailType'] = 'first';
						$this->sendMail($commandLineOptions, $jobOptions, $wikiId, $wikiData);
					}
				}
			
				$fromWikiId = $toWikiId;
			} while ($maxWikiId > $toWikiId);
		}

		if (!isset($commandLineOptions['quiet'])) {
			echo "Set $wikisToAdopt wikis as adoptable.\n";
		}
	}

	function getRecentAdminEdits($fromWikiId=null, $toWikiId=null) {
		global $wgSpecialsDB;

		$recentAdminEdit = array();
		
		if ( !empty($fromWikiId) && !empty($toWikiId) ) {
			$dbrSpecials = wfGetDB(DB_SLAVE, array(), $wgSpecialsDB);

			//get wikis with edits < 1000 and admins not active in last 45 days
			//260000 = ID of wiki created on 2011-05-01 so it will work for wikis created after this project has been deployed
			$res = $dbrSpecials->query(
				'select e1.wiki_id, sum(e1.edits) as sum_edits from events_local_users e1 ' .
				'where e1.wiki_id > '.$fromWikiId.' and e1.wiki_id <= '.$toWikiId.' ' .
				'group by e1.wiki_id ' .
				'having sum_edits < 1000 and (' .
				'select count(0) from events_local_users e2 ' .
				'where e1.wiki_id = e2.wiki_id and ' .
				'all_groups like "%sysop%" and ' .
				'editdate > now() - interval 45 day ' .
				') = 0',
				__METHOD__
			);

			while ($row = $dbrSpecials->fetchObject($res)) {
				$wikiDbname = WikiFactory::IDtoDB($row->wiki_id);
				if ($wikiDbname === false) {
					//check if wiki exists in city_list
					continue;
				}
				
				if (WikiFactory::isPublic($row->wiki_id) === false) {
					//check if wiki is closed
					continue;
				}
				
				if (self::isFlagSet($row->wiki_id, WikiFactory::FLAG_ADOPTABLE)) {
					// check if adoptable flag is set
					continue;
				}
				
				$res2 = $dbrSpecials->query(
					"select user_id, max(editdate) as lastedit from events_local_users where wiki_id = {$row->wiki_id} and all_groups like '%sysop%' group by 1 order by null;",
					__METHOD__
				);

				$recentAdminEdit[$row->wiki_id] = array(
					'recentEdit' => time(),
					'admins' => array()
				);
				while ($row2 = $dbrSpecials->fetchObject($res2)) {
					if (($lastedit = wfTimestamp(TS_UNIX, $row2->lastedit)) < $recentAdminEdit[$row->wiki_id]['recentEdit']) {
						$recentAdminEdit[$row->wiki_id]['recentEdit'] = $lastedit;
					} else if ($row2->lastedit == '0000-00-00 00:00:00') { // use city_created if no lastedit
						$wiki = WikiFactory::getWikiByID($row->wiki_id);
						if (!empty($wiki)) {
							$recentAdminEdit[$row->wiki_id]['recentEdit'] = wfTimestamp(TS_UNIX, $wiki->city_created);
						}
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
			$acceptMails = $adminUser->setLocalPreference("adoptionmails", $defaultOption, $wikiId);
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
	
	// get max wiki_id for active wikis
	protected function getMaxWikiId() {
		global $wgExternalSharedDB;

		$maxWikiId = 0;
		
		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$row = $dbr->selectRow(
			'city_list',
			'max(city_id) max_wiki_id',
			array('city_public' => 1, 'city_created < now() - interval 45 day' ),
			__METHOD__
		);
		
		if ($row !== false)
			$maxWikiId = $row->max_wiki_id;
		
		return $maxWikiId;
	}
	
	// check if flag is set in city_flags
	protected static function isFlagSet($wikiId = null, $flag = null) {
		if ($wikiId && $flag) {
			$flags = WikiFactory::getFlags($wikiId);
			if ($flags & $flag) {
				return true;
			}
		}
		
		return false;
	}
}
