<?php
define('ACHIEVEMENTS_ENABLED', true);

define('ACHIEVEMENTS_BADGE_PREFIX', 'badge-');
define('ACHIEVEMENTS_HOVER_PREFIX', 'achievements-badge-hover-');

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
define('BADGE_SHARING', -14);

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

// Michał Roszka (Mix) <michal@wikia-inc.com>
// BugId:13865
//
// Due to the fix of BugId:10474 (find below) I had to do the same thing
// to disable special pages and remove them from Special:SpecialPages.
if( !empty( $wgEnableAchievementsExt ) ) {
    // SPECIAL PAGES
    $wgSpecialPages['Platinum'] = 'SpecialPlatinum';
    $wgSpecialPages['Leaderboard'] = 'SpecialLeaderboard';
    $wgSpecialPages['AchievementsCustomize'] = 'SpecialAchievementsCustomize';
    $wgSpecialPages['AchievementsSharing'] = 'SpecialAchievementsSharing';
}

// AUTOLOADS

// config
$wgAutoloadClasses['AchConfig'] = $dir.'AchConfig.class.php';

// specials
$wgAutoloadClasses['SpecialPlatinum'] = $dir.'specials/SpecialPlatinum.class.php';
$wgAutoloadClasses['SpecialLeaderboard'] = $dir.'specials/SpecialLeaderboard.class.php';
$wgAutoloadClasses['SpecialAchievementsCustomize'] = $dir.'specials/SpecialAchievementsCustomize.class.php';
$wgAutoloadClasses['SpecialAchievementsSharing'] = $dir.'specials/SpecialAchievementsSharing.class.php';

// services
$wgAutoloadClasses['AchAwardingService'] = $dir.'services/AchAwardingService.class.php';
$wgAutoloadClasses['AchUserCountersService'] = $dir.'services/AchUserCountersService.class.php';
$wgAutoloadClasses['AchImageUploadService'] = $dir.'services/AchImageUploadService.class.php';
$wgAutoloadClasses['AchPlatinumService'] = $dir.'services/AchPlatinumService.class.php';
$wgAutoloadClasses['AchRankingService'] = $dir.'services/AchRankingService.class.php';
$wgAutoloadClasses['AchAjaxService'] = $dir.'services/AchAjaxService.class.php';
$wgAutoloadClasses['AchUserProfileService'] = $dir.'services/AchUserProfileService.class.php';
$wgAutoloadClasses['AchNotificationService'] = $dir.'services/AchNotificationService.class.php';
$wgAutoloadClasses['AchUsersService'] = $dir.'services/AchUsersService.class.php';
$wgAutoloadClasses['AchUser'] = $dir.'services/AchUser.class.php';

// models
$wgAutoloadClasses['AchRankedUser'] = $dir.'AchRankedUser.class.php';
$wgAutoloadClasses['AchBadge'] = $dir.'AchBadge.class.php';

//dependencies
$wgAutoloadClasses[ 'UploadAchievementsFromFile' ] = "{$dir}UploadAchievementsFromFile.class.php";
$wgAutoloadClasses[ 'WikiaPhotoGalleryUpload' ] = "{$dir}../WikiaPhotoGallery/WikiaPhotoGalleryUpload.class.php";

// I18N
$wgExtensionMessagesFiles['AchievementsII'] = $dir.'AchievementsII.i18n.php';
$wgExtensionMessagesFiles['AchievementsIIAliases'] = $dir.'AchievementsII.alias.php' ;

// Michał Roszka (Mix) <michal@wikia-inc.com>
// BugId:10474
// I want the code of the extension to be included regardless of the $wgEnableAchievementsExt.
// The effective execution still depends on $wgEnableAchievementsExt's value.
// Also: grep CommonExtensions.php for BugId:10474
if( !empty( $wgEnableAchievementsExt ) ) {
    // SETUP
    $wgExtensionFunctions[] = 'Ach_Setup';
}
// AJAX
$wgAjaxExportList[] = 'AchAjax';

function Ach_Setup() {
	wfProfileIn(__METHOD__);

	global $wgHooks;
	$wgHooks['ArticleSaveComplete'][] = 'Ach_ArticleSaveComplete';
	$wgHooks['GetHTMLAfterBody'][] = 'Ach_GetHTMLAfterBody';
	$wgHooks['UploadVerification'][] = 'Ach_UploadVerification';

	//hooks for user preferences
	$wgHooks['GetPreferences'][] = 'Ach_UserPreferences';
	$wgHooks['MonacoSidebarGetMenu'][] = 'Ach_GetMenu';

	//hook for purging Achievemets-related cache
	$wgHooks['AchievementsInvalidateCache'][] = 'Ach_InvalidateCache';

	wfProfileOut(__METHOD__);
}

function Ach_GetMenu( array &$nodes ): bool {
	$nodes[0]['children'][] = count($nodes);
	$nodes[] = [
		//the message is stored in /languages/messages/wikia/MessagesEn.php to avoid loading the i18n for the extension
		'text' => wfMsg( 'achievements-leaderboard-navigation-item' ),
		'href' => Skin::makeSpecialUrl( "Leaderboard" ),
	];

	return true;
}

function Ach_UploadVerification($destName, $tempPath, &$error) {
	if (Ach_isBadgeImage($destName, true /* check user right to upload sponsored badge */ )) {

		$error = wfMessage('achievements-upload-not-allowed' )->parse();
		return false;
	}
	return true;
}

function Ach_ArticleSaveComplete(
	WikiPage $article, User $user, $text, $summary, $minoredit, $watchthis, $sectionanchor, $flags,
	$revision, Status &$status, $baseRevId
): bool {
	wfProfileIn(__METHOD__);

	if ( $status->isOK() && $revision instanceof Revision ) {
		// handle only successful edits and page creations

		$awardingService = new AchAwardingService();
		$awardingService->processSaveComplete($article, $user, $revision, $status);
	}

	wfProfileOut(__METHOD__);
	return true;
}

function Ach_GetHTMLAfterBody( Skin $skin, &$html ): bool {
	wfProfileIn(__METHOD__);

	$user = $skin->getUser();

	if ($user->isLoggedIn() && !( $user->getGlobalPreference( 'hidepersonalachievements' ) ) ) {
		if( $skin->getTitle()->isSpecial( 'MyHome' ) ) {
			$awardingService = new AchAwardingService();
			$awardingService->awardCustomNotInTrackBadge( $user, BADGE_WELCOME );
		}

		if ( ( !empty( $_SESSION['achievementsNewBadges'] ) || 5 == rand( 1, 20 ) ) && $skin->getSkinName() !== 'monobook' ) {
			// this works only for Wikia and only in current varnish configuration
			if (!headers_sent()) {
				header('X-Pass-Cache-Control: no-store, private, no-cache, must-revalidate');
			}

			$notificationService = new AchNotificationService( $user );
			$skin->getOutput()->addHTML($notificationService->getNotificationHTML());
			if( isset($_SESSION['achievementsNewBadges']) )
				unset($_SESSION['achievementsNewBadges']);
		}
	}

	wfProfileOut(__METHOD__);
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


function Ach_UserPreferences( User $user, array &$preferences ): bool {
	global $wgEnableUserPreferencesV2Ext;
	$section = (!empty($wgEnableUserPreferencesV2Ext)) ? 'under-the-hood/advanced-displayv2' : 'misc';

	if( $user->isLoggedIn() ) {
		$preferences['hidepersonalachievements'] = array(
			'type' => 'toggle',
			'label-message' => 'achievements-toggle-hide', // a system message
			'section' => $section
		);
	}

	return true;
}

/**
 * Checks whether provided image name matches badge naming schema (RT #90607)
 *
 * @author Macbre
 */
function Ach_isBadgeImage($destName, $checkUserRights = false) {
	global $wgUser;

	$isBadge = strlen($destName) > strlen( ACHIEVEMENTS_BADGE_PREFIX ) && stripos($destName, ACHIEVEMENTS_BADGE_PREFIX) === 0;
	$isSponsoredBadge = strlen($destName) > strlen( ACHIEVEMENTS_HOVER_PREFIX ) && stripos($destName, ACHIEVEMENTS_HOVER_PREFIX) === 0;

	if ($checkUserRights) {
		$matches = ( $isBadge && !( $wgUser->isAllowed( 'platinum' ) || $wgUser->isAllowed( 'editinterface' ) ) ) ||
			( $isSponsoredBadge && !$wgUser->isAllowed( 'sponsored-achievements' ) );
	}
	else {
		$matches = $isBadge || $isSponsoredBadge;
	}

	return $matches;
}

function Ach_InvalidateCache( User $user ) {
	wfProfileIn( __METHOD__ );
	global $wgMemc;

	$rankingCacheKeys = array(
		//used in AchRankingService::getUserRankingPosition()
		AchRankingService::getRankingCacheKey( 1000, false ),
		//used in SpecialLeaderboard
		AchRankingService::getRankingCacheKey(20, true)
	);

	foreach( $rankingCacheKeys as $key ) {
		$wgMemc->delete( $key );
	}

	wfProfileOut( __METHOD__ );

	return true;
}
