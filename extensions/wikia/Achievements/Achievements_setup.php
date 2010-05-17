<?php
/**
 * @author: Inez Korczyński (korczynski@gmail.com)
 */

// one time without counters
define('BADGE_WELCOME', 1);
define('BADGE_INTRODUCTION', 2);
define('BADGE_SAYHI', 3);
define('BADGE_CREATOR', 4);

// one time with counters
define('BADGE_POUNCE', 5);
define('BADGE_CAFFEINATED', 6);

// many times without counter
define('BADGE_LUCKYEDIT', 7);

// in track with counters
define('BADGE_EDIT', 8);
define('BADGE_PICTURE', 9);
define('BADGE_CATEGORY', 10);
define('BADGE_BLOGPOST', 11);
define('BADGE_BLOGCOMMENT', 12);
define('BADGE_LOVE', 13);

// badge levels
define('BADGE_LEVEL_BRONZE', 1);
define('BADGE_LEVEL_SILVER', 2);
define('BADGE_LEVEL_GOLD', 3);
define('BADGE_LEVEL_PLATINUM', 4);

// ranking user display limit
define('BADGE_RANKING_LIMIT', 99);

$dir = dirname(__FILE__).'/';

// special pages
$wgSpecialPages['Leaderboard'] = 'SpecialLeaderboard';
$wgSpecialPages['AchievementsCustomize'] = 'SpecialAchievementsCustomize';

// autoloads
$wgAutoloadClasses['AchProcessor'] = $dir.'AchProcessor.class.php';
$wgAutoloadClasses['AchStatic'] = $dir.'AchStatic.class.php';
$wgAutoloadClasses['AchHelper'] = $dir.'AchHelper.class.php';
$wgAutoloadClasses['AchNotification'] = $dir.'AchNotification.class.php';
$wgAutoloadClasses['AchUserProfile'] = $dir.'AchUserProfile.class.php';
$wgAutoloadClasses['AchAjax'] = $dir.'AchAjax.class.php';

$wgAutoloadClasses['SpecialLeaderboard'] = $dir.'specials/SpecialLeaderboard.class.php';
$wgAutoloadClasses['SpecialAchievementsCustomize'] = $dir.'specials/SpecialAchievementsCustomize.class.php';


// i18n
$wgExtensionMessagesFiles['Achievements'] = $dir.'i18n/Achievements.i18n.php';

// setup
$wgExtensionFunctions[] = 'Achievements_Setup';

// ajax
$wgAjaxExportList[] = 'Ach';

function Achievements_Setup() {
	global $wgHooks;
	$wgHooks['ArticleSaveComplete'][] = 'Achievements_ArticleSaveComplete';
	$wgHooks['GetHTMLAfterBody'][] = 'Achievements_GetHTMLAfterBody';
	$wgHooks['AddToUserProfile'][] = 'Achievements_AddToUserProfile';
	$wgHooks['UploadVerification'][] = 'Achievements_UploadVerification';
	$wgHooks['Masthead::editCounter'][] = 'Achievements_MastheadEditCounter';
}

function Achievements_UploadVerification($destName, $tempPath, &$error) {
	if(strlen($destName) > 6 && substr(strtolower($destName), 0, 6) == 'badge-') {
		$error = wfMsgExt('achievements-upload-not-allowed', array('parse'));
		return false;
	}
	return true;
}

function Ach() {
	global $wgRequest;

	$ret = array();

	$method = $wgRequest->getVal('method');

	if($method == 'uploadBadge') {
		wfLoadExtensionMessages('Achievements');

		ob_start();
		$out = AchAjax::uploadBadge();
		ob_end_clean();
		if(!$out) {
			$ret = array('error' => wfMsg('achievements-upload-error'));
		} else {
			$ret = array('url' => $out);
		}
	} else if($method == 'revert') {
		wfLoadExtensionMessages('Achievements');

		ob_start();
		$out = AchAjax::revert();
		ob_end_clean();
		$ret = array('url' => $out, 'message' => wfMsg('achievements-reverted'));
	}



	$ar = new AjaxResponse(Wikia::json_encode($ret));
	$ar->setContentType('text/html; charset=utf-8');
	return $ar;
}

function Achievements_ArticleSaveComplete(&$article, &$user, $text, $summary, &$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {

	if($status instanceof Status && $status->ok == true && count($status->errors) == 0) {

		// process only successful edits
		$ap = new AchProcessor();
		$ap->processSaveComplete($article, $user, $revision, $status);

	}

	return true;
}

function Achievements_GetHTMLAfterBody($skin, &$html) {
	global $wgOut, $wgTitle, $wgUser;

	if ($wgUser->isLoggedIn()) {
		if ($wgTitle->getNamespace() == NS_SPECIAL && SpecialPage::resolveAlias($wgTitle->getDBkey()) == 'MyHome') {
			$ap = new AchProcessor();
			$ap->giveCustomBadge($wgUser, BADGE_WELCOME);
		}

		if(!empty($_SESSION['achievementsNewBadges']) && get_class($wgUser->getSkin()) == 'SkinMonaco') {
			$wgOut->addHTML(AchNotification::getNotifcationHTML());
			unset($_SESSION['achievementsNewBadges']);
		}
	}
	return true;
}

function Achievements_AddToUserProfile(&$out) {
	wfLoadExtensionMessages('Achievements');
	$html = AchUserProfile::getHTML();
	if($html) {
		$out['UserProfile1'] = $html;
	}
	return true;
}

/**
 * hook handler
 * replace Masthead counter with achievement score
 *
 * @author Marooned
 */
function Achievements_MastheadEditCounter(&$editCounter, $user) {
	if ($user instanceof User) {
		$userId = $user->getId();
		$editCounter = AchHelper::getScoreForUser($userId);
		$editCounter = '<div id="masthead-achievements">' . wfMsg('achievements-masthead-points', $editCounter) . '</div>';
	} else {
		$editCounter = '';
	}
	return true;
}
