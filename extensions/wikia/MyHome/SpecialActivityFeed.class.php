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
		if (!in_array($skinName, array('SkinMonaco', 'SkinAnswers'))) {
			$wgOut->addWikiMsg( 'myhome-switch-to-monaco' );
			wfProfileOut(__METHOD__);
			return;
		}

		// load dependencies (CSS and JS)
		global $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/MyHome/MyHome.css?{$wgStyleVersion}");

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/MyHome/MyHome.js?{$wgStyleVersion}\"></script>\n");

		// hide page title
		global $wgSupressPageTitle;
		$wgSupressPageTitle = true;

		// use message from MyHome as special page title
		$wgOut->setPageTitle(wfMsg('myhome-activity-feed'));

		######
		### Prepare HTML for ActivityFeed
		######

		$feedProxy = new ActivityFeedAPIProxy();
		$feedRenderer = new ActivityFeedForAnonsRenderer();

		$feedProvider = new DataFeedProvider($feedProxy);
		// render ActivityFeed
		$feedHTML = $feedRenderer->render($feedProvider->get(60));

		######
		### Show HTML
		######

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
	public static function debug_makeAnEdit(){
		global $wgEnableAchievementsInActivityFeed, $wgEnableAchievementsExt;
		$numEditsToMake = 0;
		if((!empty($wgEnableAchievementsInActivityFeed)) && (!empty($wgEnableAchievementsExt))){
			global $wgExternalSharedDB;
			$flags = false;
			for($i = 0; $i < $numEditsToMake; $i++){
				$title = Title::newFromText('CArticle_'.$i);
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
		global $wgEnableAchievementsInActivityFeed, $wgEnableAchievementsExt;
		wfProfileIn( __METHOD__ );

		if( $badge->getTypeId() != BADGE_WELCOME ) {
			// Make sure this Achievement gets added to its corresponding RecentChange (whether that has
			// been saved already during this pageload or is still pending).
			global $wgARecentChangeHasBeenSaved, $wgAchievementToAddToRc;
			if(!empty($wgARecentChangeHasBeenSaved)){
				// Find the RC that was saved (since there may be slave-lag, look for it by id rather than timestamp).
				// Alternatively, we could just force a read from the master, but that would involve hacking RecentChanges::newFromId (which is core) to allow that.
				$rc = RecentChange::newFromId($wgARecentChangeHasBeenSaved);
				if(!$rc){
					// Due to slave-lag, give this a little time to catch up.
					$MAX_RETRIES = 4;
					$sleepInMicros = 1000 * 500; // second number is milliseconds
					$numRetries = 0;

					// Does this help?
					//$dbw = &wfGetDB(DB_MASTER);
					//$dbw->commit(); // make sure the previous transaction was committed.

					while((!$rc) && ($numRetries < $MAX_RETRIES)){
						$numRetries++;
						usleep($sleepInMicros);
						$rc = RecentChange::newFromId($wgARecentChangeHasBeenSaved);
					}
					
					// Fallback to most recent RC.
					if(!$rc){
						// For now, skip the fallback.  It's probably more confusing to use the wrong RecentChange than to not display the Achievement at all.
						//$rc = RecentChange::newFromConds("rc_user = {$user->getId()} ORDER BY rc_timestamp DESC");
					}
				}

				if($rc){
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
		global $wgAchievementToAddToRc;
		wfProfileIn( __METHOD__ );
		
		// If an achievement is spooled from earlier in the pageload, stuff it into this RecentChange.
		if(!empty($wgAchievementToAddToRc)){
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
	public static function savedAnRc($rc){
		global $wgARecentChangeHasBeenSaved;
		wfProfileIn( __METHOD__ );

		// Mark the global indicating that an RC has been saved on this pageload (and which RC it was).
		$wgARecentChangeHasBeenSaved = $rc->getAttribute('rc_id');

		wfProfileOut( __METHOD__ );
		return true;
	}

}
