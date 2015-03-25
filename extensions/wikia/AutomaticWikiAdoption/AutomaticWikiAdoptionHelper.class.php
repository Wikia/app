<?php
/**
 * AutomaticWikiAdoptionHelper
 *
 * An AutomaticWikiAdoption extension for MediaWiki
 * Helper class
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-10-05
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/AutomaticWikiAdoption/AutomaticWikiAdoption_setup.php");
 */

class AutomaticWikiAdoptionHelper {

	//1000 articles - maximum amount of articles for wiki to allow adoption
	const MAX_ARTICLE_COUNT = 1000;
	//10 edits - minimum edits for user to allow adoption
	const MIN_EDIT_COUNT = 10;
	//60 days - delay between consecutive adoption (const can't have operators): (24 * 60 * 60) * 60
	const ADOPTION_DELAY = 5184000;
	//used for memcache as true/false/null causes problems
	const USER_ALLOWED = 1;
	const USER_NOT_ALLOWED = 2;
	const REASON_WIKI_NOT_ADOPTABLE = 3;
	const REASON_INVALID_ADOPTION_GROUPS = 4;
	const REASON_USER_BLOCKED = 5;
	const REASON_ADOPTED_RECENTLY = 6;
	const REASON_NOT_ENOUGH_EDITS = 7;
	const REASON_USER_NOT_ELIGIBLE = 8;
	//used as type in user_flags table
	const USER_FLAGS_AUTOMATIC_WIKI_ADOPTION = 1;

	/**
	 * check if user is allowed to adopt particular wiki
	 *
	 * @return 1(AutomaticWikiAdoptionHandler::USER_ALLOWED) if user can adopt, non-1 if not
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 * @author Hyun Lim
	 */
	static function isAllowedToAdopt($wikiId, $user) {
		global $wgMemc;
		wfProfileIn(__METHOD__);

		//uncachable tests
		//DB in read only mode
		if (wfReadOnly()) {
			wfProfileOut(__METHOD__);
			Wikia::log(__METHOD__, __LINE__, 'not allowed to adopt: DB read only');
			return false;
		}

		//only logged in can be a sysop
		if ($user->isAnon()) {
			wfProfileOut(__METHOD__);
			Wikia::log(__METHOD__, __LINE__, 'not allowed to adopt: anon');
			return false;
		}

		//cachable tests
		$memcKey = wfMemcKey($user->getId(), 'AutomaticWikiAdoption-user-allowed-to-adopt');
		$allowed = $wgMemc->get($memcKey);
		if (!empty($allowed)) {
			wfProfileOut(__METHOD__);
			Wikia::log(__METHOD__, __LINE__, 'value stored in memcache: ' . $allowed);
			return $allowed == self::USER_ALLOWED;
		}
		unset($allowed);

		//wiki has more than 1000 pages && admin not active && hasn't been adopted recently
		if (!self::isWikiAdoptable($wikiId)) {
			Wikia::log(__METHOD__, __LINE__, 'not allowed to adopt: wiki not adoptable');
			$allowed = self::REASON_WIKI_NOT_ADOPTABLE;
		}

		$groups = $user->getEffectiveGroups();
		//staff - omit other checks
		if (!isset($allowed) && in_array('staff', $groups)) {
			Wikia::log(__METHOD__, __LINE__, 'allowed to adopt: staff');
			$allowed = self::USER_ALLOWED;
		}

		//already a sysop or bot
		if (!isset($allowed) && (in_array('bot', $groups) || in_array('sysop', $groups))) {
			Wikia::log(__METHOD__, __LINE__, 'not allowed to adopt: bot/sysop');
			$allowed = self::REASON_INVALID_ADOPTION_GROUPS;
		}

		//Phalanx - check if user is blocked
		if (!isset($allowed) && $user->isBlocked()) {
			Wikia::log(__METHOD__, __LINE__, 'not allowed to adopt: user blocked');
			$allowed = self::REASON_USER_BLOCKED;
		}

		if ( $user->getOption( 'AllowAdoption', 1 ) ) {
			Wikia::log(__METHOD__, __LINE__, 'not allowed to adopt: per user override set by staff');
			$allowed = self::REASON_USER_NOT_ELIGIBLE;
		}

		//user has adopted other wiki in the last 60 days
		$lastAdoption = $user->getOption('LastAdoptionDate', false);
		if (!isset($allowed) && ($lastAdoption !== false && time() - $lastAdoption < self::ADOPTION_DELAY)) {
			Wikia::log(__METHOD__, __LINE__, 'not allowed to adopt: adopted in 60 days');
			$allowed = self::REASON_ADOPTED_RECENTLY;
		}

		//user has less than 10 edits on this wiki
		if (!isset($allowed) && self::countUserEditsOnWiki($wikiId, $user) <= self::MIN_EDIT_COUNT) {
			Wikia::log(__METHOD__, __LINE__, 'not allowed to adopt: small contribution');
			$allowed = self::REASON_NOT_ENOUGH_EDITS;
		}

		//run out of checks - allowing user to adopt
		if (!isset($allowed)) {
			Wikia::log(__METHOD__, __LINE__, 'allowed to adopt: no negative checks');
			$allowed = self::USER_ALLOWED;
		}

		Wikia::log(__METHOD__, __LINE__, 'saving to memcache:' . $allowed);
		$wgMemc->set($memcKey, $allowed, 3600);

		wfProfileOut(__METHOD__);
		return $allowed;
	}

	/**
	 * adopt a wiki - set admin rights for passed user and remove bureacrat rights for current users
	 *
	 * @return boolean success/fail
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function adoptWiki($wikiId, $user) {
		wfProfileIn(__METHOD__);
		global $wgMemc;
		$dbr = wfGetDB(DB_SLAVE);
		//get all current admins of this wiki
		$res = $dbr->select(
			'user_groups',
			'ug_user',
			array('ug_group' => 'sysop'),
			__METHOD__
		);

		//group to remove
		$removedGroup = 'bureaucrat';
		//groups to add
		$addGroups = array('sysop', 'bureaucrat');

		$wiki_name = WikiFactory::IDtoDB($wikiId);

		//remove bureacrat for current admins
		while ($row = $dbr->fetchObject($res)) {
			$admin = User::newFromId($row->ug_user);
			if ($admin) {
				//get old groups - for log purpose
				$oldGroups = $admin->getGroups();
				//do not remove groups for staff or for user who is now adopting (he might be a bureaucrat)
				if (in_array('staff', $oldGroups) || $admin->getId() == $user->getId()) {
					continue;
				}
				//create new groups list - for log purpose
				$newGroups = array_diff($oldGroups, array($removedGroup));
				if ($oldGroups != $newGroups) {
					//remove group
					$admin->removeGroup($removedGroup);
					wfRunHooks( 'UserRights', array( &$admin, array(), array($removedGroup) ) );

					// get email params
					$magicwords = array('#WIKINAME' => $wiki_name);
					$admin_name = $admin->getName();
					$globalTitleUserRights = GlobalTitle::newFromText('UserRights', -1, $wikiId);
					$specialUserRightsUrl = $globalTitleUserRights->getFullURL();
					$globalTitlePreferences = GlobalTitle::newFromText('Preferences', -1, $wikiId);
					$specialPreferencesUrl = $globalTitlePreferences->getFullURL();

					//sent e-mail
					$admin->sendMail(
						strtr(wfMsgForContent("wikiadoption-mail-adoption-subject"), $magicwords),
						strtr(wfMsgForContent("wikiadoption-mail-adoption-content", $admin_name, $specialUserRightsUrl, $specialPreferencesUrl), $magicwords),
						null, //from
						null, //replyto
						'AutomaticWikiAdoption',
						strtr(wfMsgForContent("wikiadoption-mail-adoption-content-HTML", $admin_name, $specialUserRightsUrl, $specialPreferencesUrl), $magicwords)
					);
					//log
					self::addLogEntry($admin, $oldGroups, $newGroups);
					//Unset preference for receiving future adoption emails
					$admin->setOption("adoptionmails-$wikiId", 0);
					$admin->saveSettings();
				}
			}
		}

		//get old groups - for log purpose
		$oldGroups = $user->getGroups();
		//create new groups list - for log purpose
		$newGroups = array_unique(array_merge($oldGroups, $addGroups));
		if ($oldGroups != $newGroups) {
			//add groups to user who just adopted this wiki
			foreach ($addGroups as $addGroup) {
				$user->addGroup($addGroup);
			}
			wfRunHooks( 'UserRights', array( &$user, $addGroups, array() ) );
			//log
			self::addLogEntry($user, $oldGroups, $newGroups);
			WikiFactory::log(WikiFactory::LOG_STATUS, $user->getName()." adopted wiki ".  $wiki_name);
		}
		//set date of adoption - this will be used to check when next adoption is possible
		$user->setOption('LastAdoptionDate', time());
		//Set preference for receiving future adoption emails
		$user->setOption("adoptionmails-$wikiId", 1);
		$user->saveSettings();

		// Block user from seeing the adoption page again or adopting another wiki
		$memcKey = wfMemcKey($user->getId(), 'AutomaticWikiAdoption-user-allowed-to-adopt');
		$allowed = self::REASON_ADOPTED_RECENTLY;
		$wgMemc->set($memcKey, $allowed, 3600);
		// Block the wiki from being adopted again for 14 days
		$wgMemc->set( wfMemcKey("AutomaticWikiAdoption-WikiAdopted"), $allowed, 60*60*24*14 );

		//Reset the flags for this wiki
		self::dismissNotification();
		$flags = WikiFactory::FLAG_ADOPTABLE | WikiFactory::FLAG_ADOPT_MAIL_FIRST | WikiFactory::FLAG_ADOPT_MAIL_SECOND;
		WikiFactory::resetFlags($wikiId, $flags);
		wfProfileOut(__METHOD__);
		//TODO: log on central that wiki has been adopted (by who)
		//TODO: is there a way to check if user got sysop rights to return true/false as a result?
		return true;
	}

	/**
	 * check if provided wiki is adoptable - uses data gathered by maintenance script in the background
	 *
	 * @return boolean success/fail
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	private static function isWikiAdoptable($wikiId) {
		global $wgMemc, $wgExternalSharedDB;
		wfProfileIn(__METHOD__);

		$canAdopt = false;

		// Block this wiki from being adopted again for 14 days
		$recentlyAdopted = $wgMemc->get( wfMemcKey("AutomaticWikiAdoption-WikiAdopted") );
		if (!empty($recentlyAdopted)) {
			wfProfileOut(__METHOD__);
			return false;
		}

		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$row = $dbr->selectRow(
			'city_list',
			'city_flags',
			array('city_id' => $wikiId),
			__METHOD__
		);

		//this flag is set by maintenance script
		if ($row !== false && $row->city_flags & WikiFactory::FLAG_ADOPTABLE) {
			$canAdopt = true;
		}

		wfProfileOut(__METHOD__);
		return $canAdopt;
	}

	/**
	 * check if provided wiki is adoptable - uses data gathered by maintenance script in the background
	 *
	 * @return boolean success/fail
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	private static function countUserEditsOnWiki($wikiId, $user) {
		global $wgStatsDB, $wgStatsDBEnabled;
		wfProfileIn(__METHOD__);

		$result = 0;
		if ( !empty( $wgStatsDBEnabled ) ) {
			$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);

			$row = $dbr->selectRow(
				'specials.events_local_users',
				'edits',
				array('wiki_id' => $wikiId, 'user_id' => $user->getId()),
				__METHOD__
			);

			if ($row !== false) {
				$result = $row->edits;
			}
		}

		wfProfileOut(__METHOD__);
		return $result;
	}

	/**
	 * Add a rights log entry for an action.
	 * Partially copied from SpecialUserrights.php
	 *
	 * @param object $user User object
	 * @param boolean $addGroups adding or removing groups?
	 * @param array $groups names of groups
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	private static function addLogEntry($user, $oldGroups, $newGroups) {
		global $wgRequest;

		wfProfileIn(__METHOD__);
		$log = new LogPage('rights');

		$log->addEntry('rights',
			$user->getUserPage(),
			wfMsg('wikiadoption-log-reason'),
			array(
				implode(', ', $oldGroups),
				implode(', ', $newGroups)
			)
		);
		wfProfileOut(__METHOD__);
	}

	/**
	 * Hook handler
	 * Display notification
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function onSkinTemplateOutputPageBeforeExec(&$skin, &$tpl) {
		global $wgUser, $wgCityId, $wgScript, $wgSitename;
		wfProfileIn(__METHOD__);

		if ( F::app()->checkSkin( 'oasis' ) && (self::isAllowedToAdopt($wgCityId, $wgUser) == self::USER_ALLOWED )  && !self::getDismissNotificationState($wgUser)) {

			NotificationsController::addNotification(
				wfMsg( 'wikiadoption-notification',
						$wgSitename,
						Wikia::SpecialPageLink( 'WikiAdoption','wikiadoption-adopt-inquiry' ) ),
				array(
					'name' => 'AutomaticWikiAdoption',
					'dismissUrl' => $wgScript . '?action=ajax&rs=AutomaticWikiAdoptionAjax&method=dismiss',
			), NotificationsController::NOTIFICATION_CUSTOM );
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Hook handler
	 *
	 * @param User $user
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 * @author Hyun Lim
	 */
	public static function onGetPreferences($user, &$defaultPreferences) {
		wfProfileIn(__METHOD__);
		global $wgSitename, $wgCityId, $wgEnableUserPreferencesV2Ext;
		// Adoption preference is for wiki sysop and bureaucrat groups
		if (in_array('sysop', $user->getGroups()) || in_array('bureaucrat', $user->getGroups())) {
			if ( empty($wgEnableUserPreferencesV2Ext) ) {
				$section = 'personal/wikiemail';
				$prefVersion = '';
			} else {
				$section = 'emailv2/wikiemail';
				$prefVersion = '-v2';
			}

			$defaultPreferences["adoptionmails-label-$wgCityId"] = array(
				'type' => 'info',
				'label' => '',
				'help' => wfMsg('wikiadoption-pref-label', $wgSitename),
				'section' => $section,
			);
			$defaultPreferences["adoptionmails-$wgCityId"] = array(
				'type' => 'toggle',
				'label-message' => array('tog-adoptionmails'.$prefVersion, $wgSitename),
				'section' => $section,
			);
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Hook handler
	 *
	 * If a sysop makes an edit, unset any flags that have been set so far
	 * because the adoption clock starts over again
	 * @author Owen Davis
	 *
	 * @static
	 * @param Article $article
	 * @param User $user
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision
	 * @param $status
	 * @param $baseRevId
	 * @return bool
	 */
	static function onArticleSaveComplete(&$article, &$user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		global $wgCityId;
		if (in_array('sysop', $user->getGroups())) {
			WikiFactory::resetFlags($wgCityId, WikiFactory::FLAG_ADOPTABLE | WikiFactory::FLAG_ADOPT_MAIL_FIRST | WikiFactory::FLAG_ADOPT_MAIL_SECOND, true);
		}
		return true;
	}

	/**
	 * Dismisses notification about wiki adoption
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function dismissNotification() {
		wfProfileIn(__METHOD__);
		global $wgUser, $wgCityId, $wgExternalDatawareDB;

		if (!wfReadOnly()) {
			$dbw = wfGetDB(DB_MASTER, array(), $wgExternalDatawareDB);
			$dbw->insert('user_flags',
				array(
					'city_id' => $wgCityId,
					'user_id' => $wgUser->getID(),
					'type' => self::USER_FLAGS_AUTOMATIC_WIKI_ADOPTION,
					'data' => wfTimestamp(TS_DB)
				),
				__METHOD__,
				'IGNORE'
			);

			// fix for AJAX calls
			$dbw->commit();
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Get dismiss state of notification about wiki adoption
	 *
	 * @param User $user
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	private static function getDismissNotificationState($user) {
		global $wgCityId, $wgExternalDatawareDB;
		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);
		$dismissed = $dbr->selectField(
			'user_flags',
			'data',
			array('city_id' => $wgCityId, 'user_id' => $user->getID(), 'type' => self::USER_FLAGS_AUTOMATIC_WIKI_ADOPTION),
			__METHOD__
		);
		return $dismissed ? true : false;
	}
}
