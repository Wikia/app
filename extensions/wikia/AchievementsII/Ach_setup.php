<?php
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

$dir = dirname(__FILE__).'/';

// SPECIAL PAGES
$wgSpecialPages['Platinum'] = 'SpecialPlatinum';
$wgSpecialPages['Leaderboard'] = 'SpecialLeaderboard';
$wgSpecialPages['AchievementsCustomize'] = 'SpecialAchievementsCustomize';

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

	wfProfileOut(__METHOD__);
}

function Ach_MastheadEditCounter(&$editCounter, $user) {
	if ($user instanceof User) {
		global $wgCityId, $wgExternalSharedDB;
		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$editCounter = $dbr->selectField('ach_user_score', 'score', array('wiki_id' => $wgCityId, 'user_id' => $user->getId()), __METHOD__);
		$editCounter = '<div id="masthead-achievements">' . wfMsg('achievements-masthead-points', $editCounter) . '</div>';
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

	if($wgUser->isLoggedIn()) {
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

	$userProfileService = new AchUserProfileService();
	$html = $userProfileService->getHTML();

	if($html) {
		$out['UserProfile1'] = $html;
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

}

##
## TESTING ONLY
##
$wgAjaxExportList[] = 'AchTest';
function AchTest() {
	global $wgUser, $wgExternalSharedDB;
	$article = Article::newFromID(113969);
	$flags = false;
	$revision = Revision::newFromId($article->getRevIdFetched());
	$status = new Status();
	Ach_ArticleSaveComplete($article, $wgUser, 'text', 'summary', false, false, false, $flags, $revision, $status, false);
	$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
	$dbw->commit();
	exit('exit');
}