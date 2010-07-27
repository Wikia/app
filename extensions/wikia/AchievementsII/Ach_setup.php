<?php
define('ACHIEVEMENTS_ENABLED', true);

// BADGE LEVELS
define('BADGE_LEVEL_BRONZE', 1);
define('BADGE_LEVEL_SILVER', 2);
define('BADGE_LEVEL_GOLD', 3);
define('BADGE_LEVEL_PLATINUM', 4);

// BADGE TYPE ID's
define('BADGE_WELCOME', -1);
define('BADGE_INTRODUCTION', -2);
define('BADGE_SAYHI', -3);
define('BADGE_CREATOR', -4);
define('BADGE_POUNCE', -5);
define('BADGE_CAFFEINATED', -6);
define('BADGE_LUCKYEDIT', -7);
define('BADGE_EDIT', -8);
define('BADGE_PICTURE', -9);
define('BADGE_CATEGORY', -10);
define('BADGE_BLOGPOST', -11);
define('BADGE_BLOGCOMMENT', -12);
define('BADGE_LOVE', -13);

define('BADGE_TYPE_INTRACKEDITPLUSCATEGORY', 1); // EDIT+CATEGORY
define('BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM', 2); // COMMUNITY CUSTOM
define('BADGE_TYPE_NOTINTRACKSTATIC', 3); // STATIC IN TRACK
define('BADGE_TYPE_INTRACKSTATIC', 4); // STATIC NOT IN TRACK

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'AchievementsII',
	'author'         => 'Wikia',
	'descriptionmsg' => 'achievementsii-desc',
);

$dir = dirname(__FILE__).'/';

// SPECIAL PAGES
$wgSpecialPages['Platinum'] = 'SpecialPlatinum';
$wgSpecialPages['Leaderboard'] = 'SpecialLeaderboard';
$wgSpecialPages['AchievementsCustomize'] = 'SpecialAchievementsCustomize';

$wgExtensionAliasesFiles ['AchievementsII'] = $dir.'AchievementsII.alias.php' ;

// RIGHTS
$wgAvailableRights[] = 'platinum';
$wgGroupPermissions['*']['platinum'] = false;
$wgGroupPermissions['staff']['platinum'] = true;
$wgGroupPermissions['helper']['platinum'] = true;

// AUTOLOADS

// config
$wgAutoloadClasses['AchConfig'] = $dir.'AchConfig.class.php';

// specials
$wgAutoloadClasses['SpecialPlatinum'] = $dir.'specials/SpecialPlatinum.class.php';
$wgAutoloadClasses['SpecialLeaderboard'] = $dir.'specials/SpecialLeaderboard.class.php';
$wgAutoloadClasses['SpecialAchievementsCustomize'] = $dir.'specials/SpecialAchievementsCustomize.class.php';

// services
$wgAutoloadClasses['AchAwardingService'] = $dir.'services/AchAwardingService.class.php';
$wgAutoloadClasses['AchUserCountersService'] = $dir.'services/AchUserCountersService.class.php';
$wgAutoloadClasses['AchImageUploadService'] = $dir.'services/AchImageUploadService.class.php';
$wgAutoloadClasses['AchPlatinumService'] = $dir.'services/AchPlatinumService.class.php';
$wgAutoloadClasses['AchRankingService'] = $dir.'services/AchRankingService.class.php';
$wgAutoloadClasses['AchAjaxService'] = $dir.'services/AchAjaxService.class.php';
$wgAutoloadClasses['AchUserProfileService'] = $dir.'services/AchUserProfileService.class.php';
$wgAutoloadClasses['AchNotificationService'] = $dir.'services/AchNotificationService.class.php';

// models
$wgAutoloadClasses['AchRankedUser'] = $dir.'AchRankedUser.class.php';
$wgAutoloadClasses['AchBadge'] = $dir.'AchBadge.class.php';

// I18N
$wgExtensionMessagesFiles['AchievementsII'] = $dir.'i18n/AchievementsII.i18n.php';

// SETUP
$wgExtensionFunctions[] = 'Ach_Setup';

// AJAX
$wgAjaxExportList[] = 'AchAjax';

function Ach_Setup() {
	wfProfileIn(__METHOD__);

	global $wgHooks;
	$wgHooks['ArticleSaveComplete'][] = 'Ach_ArticleSaveComplete';
	$wgHooks['GetHTMLAfterBody'][] = 'Ach_GetHTMLAfterBody';
	$wgHooks['AddToUserProfile'][] = 'Ach_AddToUserProfile';
	$wgHooks['UploadVerification'][] = 'Ach_UploadVerification';
	$wgHooks['Masthead::editCounter'][] = 'Ach_MastheadEditCounter';
	
	//hooks for user preferences
	$wgHooks['UserToggles'][] = 'Ach_UserToggles';
	$wgHooks['MonacoSidebarGetMenu'][] = 'Ach_GetMenu';
	wfProfileOut(__METHOD__);
}

function Ach_GetMenu(&$nodes) {
	global $wgScript;
	
	$nodes[0]['children'][] = count($nodes);
	$nodes[] = array(
		//'original' => 'achievementsleaderboard',
		//the message is stored in /languages/messages/wikia/MessagesEn.php to avoid loading the i18n for the extension
		'text' => wfMsg('achievements-leaderboard-navigation-item'),
		'href' => Skin::makeSpecialUrl("Leaderboard"),
  		//'depth' => 1,
		//'parentIndex' => 0
	);
		
	return true;
}

function Ach_MastheadEditCounter(&$editCounter, $user) {
	if ($user instanceof User) {
		global $wgUser;
		
		if(!($wgUser->getId() == $user->getId() && $wgUser->getOption('hidepersonalachievements'))) {
			global $wgCityId, $wgExternalSharedDB;
			
			$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
			$editCounter = $dbr->selectField('ach_user_score', 'score', array('wiki_id' => $wgCityId, 'user_id' => $user->getId()), __METHOD__);
			$editCounter = '<div id="masthead-achievements">' . wfMsg('achievements-masthead-points', number_format($editCounter)) . '</div>';
		}
	} else {
		$editCounter = '';
	}
	return true;
}

function Ach_UploadVerification($destName, $tempPath, &$error) {
	if(strlen($destName) > 6 && stripos($destName, 'badge-') === 0) {
		$error = wfMsgExt('achievements-upload-not-allowed', array('parse'));
		return false;
	}
	return true;
}

function Ach_ArticleSaveComplete(	&$article, &$user, $text,
					$summary, $minoredit, $watchthis,
					$sectionanchor, &$flags, $revision,
					&$status, $baseRevId) {
	wfProfileIn(__METHOD__);

	if($status instanceof Status && $status->ok == true && count($status->errors) == 0) {
		// handle only successful edits and page creations

		$awardingService = new AchAwardingService();
		$awardingService->processSaveComplete($article, $user, $revision, $status);
	}

	wfProfileOut(__METHOD__);
	return true;
}

function Ach_GetHTMLAfterBody($skin, &$html) {
	wfProfileIn(__METHOD__);

	global $wgOut, $wgTitle, $wgUser;

	if($wgUser->isLoggedIn() && !($wgUser->getOption('hidepersonalachievements'))) {
		if ($wgTitle->getNamespace() == NS_SPECIAL && SpecialPage::resolveAlias($wgTitle->getDBkey()) == 'MyHome') {
			$awardingService = new AchAwardingService();
			$awardingService->awardCustomNotInTrackBadge($wgUser, BADGE_WELCOME);
		}

		if((!empty($_SESSION['achievementsNewBadges']) || 5 == rand(1, 20)) && get_class($wgUser->getSkin()) == 'SkinMonaco') {
			// this works only for Wikia and only in current varnish configuration
			header('X-Pass-Cache-Control: no-store, private, no-cache, must-revalidate');
			$notificationService = new AchNotificationService();
			$wgOut->addHTML($notificationService->getNotifcationHTML($wgUser));
			unset($_SESSION['achievementsNewBadges']);
		}
	}

	wfProfileOut(__METHOD__);
	return true;
}

function Ach_AddToUserProfile(&$out) {
	global $wgOut, $wgScriptPath;

	$userProfileService = new AchUserProfileService();
	$html = $userProfileService->getHTML();

	if($html) {
		$out['achievementsII'] = $html;
		$wgOut->addStyle('../..' . $wgScriptPath . '/extensions/wikia/AchievementsII/css/achievements_sidebar.css');
	}

	return true;
}

function AchAjax() {
	global $wgRequest;

	$method = $wgRequest->getVal('method');

	if ($method && method_exists('AchAjaxService', $method)) {
		$response = new AjaxResponse(AchAjaxService::$method());
		$response->setContentType('text/html; charset=utf-8');
		return $response;
	}
	elseif ($method == 'takeRankingSnapshot') {
		ob_start();
		Ach_TakeRankingSnapshot($wgRequest->getVal('force'));
		$result = ob_get_clean();
		
		$response = new AjaxResponse($result);
		$response->setContentType('text/html; charset=utf-8');
		return $response;
	}

}

function Ach_UserToggles(&$toggles) {
	$toggles[] = 'hidepersonalachievements';
	return true;
}

/*
 * Used in the mantainance/wikia/takeAchievementsRankingSnapshot.php script
 */
function Ach_TakeRankingSnapshot($force = false) {
	global $wgCityId;
	$dbw = WikiFactory::db( DB_MASTER );

	$res = $dbw->select('ach_ranking_snapshots', array('date'), array('wiki_id' => $wgCityId));
	$rankingService = new AchRankingService();

	if($row = $dbw->fetchObject($res)) {
		if(strtotime($row->date) <= (time() - (60*60*24)) || $force) {
			$dbw->update('ach_ranking_snapshots', array('date' => date('Y-m-d H:i:s'), 'data' => $rankingService->serialize()), array('wiki_id' => $wgCityId));
			echo("\t* Snapshot for the wiki with ID {$wgCityId} has been updated\n");
			$dbw->commit();
		}
			else {
			echo("\t* A user ranking snapshot already exists for the wiki with ID {$wgCityId} and is still valid (taken on {$row->date})\n");
		}
	}
	else {
		$dbw->insert('ach_ranking_snapshots', array('wiki_id' => $wgCityId, 'date' => date('Y-m-d H:m:s'), 'data' => $rankingService->serialize()));
		echo("\t* Snapshot for the wiki with ID {$wgCityId} has been taken\n");
		$dbw->commit();
	}

	$dbw->freeResult($res);
}

##
## TESTING ONLY
##
//$wgAjaxExportList[] = 'AchTest';
function AchTest() {

	global $wgUser, $wgExternalSharedDB;

	set_time_limit(5000);

		// test 1
		// Expect: badges for edits, categoris, pictues, at least one lucky edit and eventually welcome

		// 2000 edits
		for($i = 0; $i < 500; $i++) {

			$content = date('H:i:s');

			// 2000 category edits
			$content .= '[[Category:cat'.$i.']]';
			$content .= '[[Category:Moja testowa]]';

			// 1000 picture uploads
			if($i % 2 == 0) {
				$content .= '[[Image:Wiki.png]]';
			}

			$title = Title::newFromText('CArticle_'.$i);
			$article = new Article($title);
			$article->doEdit($content, 'test summary');
		}

		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		$dbw->commit();

		$dbw = wfGetDB(DB_MASTER);
		$dbw->commit();


/*
		// test 2
		// Expect: badges for blogposts

		// 2000 edits
		for($i = 0; $i < 2000; $i++) {
			$content = date('H:i:s');

			$title = Title::newFromText('AArticle_'.$i);
			$article = new Article($title);
			$article->doEdit($content, 'test summary');
		}

		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		$dbw->commit();

		$dbw = wfGetDB(DB_MASTER);
		$dbw->commit();
*/


	//
	//
	/*
	$flags = false;
	$revision = Revision::newFromId($article->getRevIdFetched());
	$status = new Status();
	Ach_ArticleSaveComplete($article, $wgUser, 'text', 'summary', false, false, false, $flags, $revision, $status, false);
	$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
	$dbw->commit();
	exit('exit');
	*/
}
