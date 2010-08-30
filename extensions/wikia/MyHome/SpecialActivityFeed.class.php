<?php

class SpecialActivityFeed extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages('MyHome');
		parent::__construct('ActivityFeed', '' /* no restriction */, true /* listed */);
	}

	function execute($par) {
		wfProfileIn(__METHOD__);
		global $wgOut, $wgUser, $wgTitle;
		$this->setHeaders();

		// not available for skins different then monaco / answers
		$skinName = get_class($wgUser->getSkin());

		// For oasis redirect to WikiActivity
		if ($skinName == 'SkinOasis') {
			$wgOut->redirect(SpecialPage::getTitleFor('WikiActivity')->getLinkUrl());
			return;
		}

		if (!in_array($skinName, array('SkinMonaco', 'SkinAnswers'))) {
			$wgOut->addWikiMsg( 'myhome-switch-to-monaco' );
			wfProfileOut(__METHOD__);
			return;
		}

		$feedProxy = new ActivityFeedAPIProxy();
		$feedProvider = new DataFeedProvider($feedProxy);

		$data = $feedProvider->get(60);
		
		global $wgEnableAchievementsInActivityFeed, $wgEnableAchievementsExt;
		if((!empty($wgEnableAchievementsInActivityFeed)) && (!empty($wgEnableAchievementsExt))){
			$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/AchievementsII/css/achievements_sidebar.css?{$wgStyleVersion}");

			// Could add this to the selector in JS: ", .achievement-in-activity-feed a.achievement-image-link" but the popup hides behind the menu.
			// For now, just skipping the JS hovers.
			//$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/AchievementsII/js/achievements.js?{$wgStyleVersion}\"></script>\n");

			//self::debug_makeEdits(); // just to be used when testing (makes edits).
		}

		// hide page title
		global $wgSupressPageTitle;
		$wgSupressPageTitle = true;

		// use message from MyHome as special page title
		$wgOut->setPageTitle(wfMsg('myhome-activity-feed'));

		// load dependencies (CSS and JS)
		global $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/MyHome/MyHome.css?{$wgStyleVersion}");

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/MyHome/MyHome.js?{$wgStyleVersion}\"></script>\n");

		######
		### Prepare HTML for ActivityFeed
		######

		// render ActivityFeed
		$feedRenderer = new ActivityFeedForAnonsRenderer();
		$feedHTML = $feedRenderer->render($data);
		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set('feedHTML', $feedHTML);

		$wgOut->addHTML($template->render('activityfeed'));

		wfProfileOut(__METHOD__);
	}

	/**
	 * A helper function for doing page-edits automatically to help bump things onto the ActivityFeed
	 * or allow the automatic earning of achievements. 
	 *
	 * To force a user to get an achievement on a devbox, connect to DEV-DB-A1 (not production!) wikicities
	 * and run this pair of queries (with the user's user_id filled in).
	 * 		DELETE FROM ach_user_badges WHERE user_id='USER_ID_HERE';DELETE FROM ach_user_counters WHERE user_id='USER_ID_HERE';
	 */
	public static function debug_makeEdits(){
		global $wgEnableAchievementsInActivityFeed, $wgEnableAchievementsExt;
		$NUM_EDITS_TO_MAKE = 1;
		if((!empty($wgEnableAchievementsInActivityFeed)) && (!empty($wgEnableAchievementsExt))){
			global $wgExternalSharedDB, $wgUser;
			$flags = false;
			for($i = 0; $i < $NUM_EDITS_TO_MAKE; $i++){
				$title = Title::newFromText('CArticle_I'.$i);
				$article = new Article($title);
				$content = date("H:i:s");
				$article->doEdit($content, 'test summary');
				$revision = Revision::newFromId($article->getRevIdFetched());
				$status = new Status();
				Ach_ArticleSaveComplete($article, $wgUser, 'text', 'summary', false, false, false, $flags, $revision, $status, false);
			}
			$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
			$dbw->commit();
		}
	}

	/**
	 * When the notification to the user is called (at the bottom of the page), attach the
	 * achievement-earning to our best guess at what the associated RecentChange is.
	 *
	 * To account for race-conditions between RecentChanges and Achievements: currently, this
	 * is done by recording when an RC is saved. If it happens on this page before this
	 * function is called, then this function will load that RC by id.  If this function gets
	 * called before any RCs have been recorded, then a serialized copy of the badge is stored
	 * and can be inserted later (when the RC actually does get saved).
	 */
	public static function attachAchievementToRc(&$user, &$badge ){
		global $wgEnableAchievementsInActivityFeed, $wgEnableAchievementsExt, $wgWikiaForceAIAFdebug;
		wfProfileIn( __METHOD__ );

		// If user has 'hidepersonalachievements' set, then they probably don't want to play.
		// Also, other users may see that someone won, then click the username and look around for a way to see what achievements a user has...
		// then when they can't find it (since users with this option won't have theirs displayed), they might assume that there is no way to see
		// achievements.  It would be better to do this check at display-time rather than save-time, but we don't have access to the badge's user
		// at that point.
		Wikia::log(__METHOD__, "", "Noticed an achievement", $wgWikiaForceAIAFdebug);
		if( ($badge->getTypeId() != BADGE_WELCOME) && (!$user->getOption('hidepersonalachievements')) ){
			Wikia::log(__METHOD__, "", "Attaching badge to recent change...", $wgWikiaForceAIAFdebug);

			// Make sure this Achievement gets added to its corresponding RecentChange (whether that has
			// been saved already during this pageload or is still pending).
			global $wgARecentChangeHasBeenSaved, $wgAchievementToAddToRc;
			Wikia::log(__METHOD__, "", "About to see if there is an existing RC. RC: ".print_r($wgARecentChangeHasBeenSaved, true), $wgWikiaForceAIAFdebug);
			if(!empty($wgARecentChangeHasBeenSaved)){
				// Due to slave-lag, instead of storing the rc_id and looking it up (which didn't always work, even with a retry-loop), store entire RC.
				Wikia::log(__METHOD__, "", "Attaching badge to existing RecentChange from earlier in pageload.", $wgWikiaForceAIAFdebug);
				$rc = $wgARecentChangeHasBeenSaved;
				if($rc){
					Wikia::log(__METHOD__, "", "Found recent change to attach to.", $wgWikiaForceAIAFdebug);
					// Add the (serialized) badge into the rc_params field.
					$additionalData = array('Badge' => serialize($badge));
					MyHome::storeInRecentChanges($rc, $additionalData);
					$originalRcId = $rc->getAttribute('rc_id');
					$rc->save();

					// Since rc->save is actually only an insert (never an update), make sure to delete the original rc by originalRcId.
					$dbw = &wfGetDB(DB_MASTER);
					$dbw->delete("recentchanges", array("rc_id" => $originalRcId), __METHOD__ );
				}
			} else {
				// Spool this achievement for when its corresponding RecentChange shows up (later in this pageload).
				$wgAchievementToAddToRc = serialize($badge);
				Wikia::log(__METHOD__, "", "RecentChange hasn't been saved yet, storing the badge for later.", $wgWikiaForceAIAFdebug);
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	} // end attachAchievementToRc()
	
	/**
	 * Hook that's called when a RecentChange is saved.  This prevents any problems from race-conditions between
	 * the creation of a RecentChange and the awarding of its corresponding Achievement (they occur on the same
	 * page-load, but one isn't guaranteed to be before the other).
	 */
	public static function savingAnRc(&$rc){
		global $wgAchievementToAddToRc, $wgWikiaForceAIAFdebug;
		wfProfileIn( __METHOD__ );
		
		// If an achievement is spooled from earlier in the pageload, stuff it into this RecentChange.
		Wikia::log(__METHOD__, "", "RecentChange has arrived.", $wgWikiaForceAIAFdebug);
		if(!empty($wgAchievementToAddToRc)){
			Wikia::log(__METHOD__, "", "RecentChange arrived. Storing achievement that we've already seen.", $wgWikiaForceAIAFdebug);
			$additionalData = array('Badge' => $wgAchievementToAddToRc);
			MyHome::storeInRecentChanges($rc, $additionalData);
			unset($wgAchievementToAddToRc);
		}

		wfProfileOut( __METHOD__ );
		return true;
	} // end savingAnRc()
	
	/**
	 * Called upon the successful save of a RecentChange.
	 */
	public static function savedAnRc(&$rc){
		global $wgARecentChangeHasBeenSaved, $wgWikiaForceAIAFdebug;
		wfProfileIn( __METHOD__ );

		// Mark the global indicating that an RC has been saved on this pageload (and which RC it was).
		// Due to slave-lag, instead of storing the rc_id and looking it up (which didn't always work, even with a retry-loop), store entire RC.
		$wgARecentChangeHasBeenSaved = $rc;
		Wikia::log(__METHOD__, "", "RecentChange has been saved (presumably no achievement yet). RC: ".print_r($wgARecentChangeHasBeenSaved, true), $wgWikiaForceAIAFdebug);

		wfProfileOut( __METHOD__ );
		return true;
	}

}
