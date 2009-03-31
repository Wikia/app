<?php
/**
 * UserWelcome extension
 * Adds <welcomeUser/> tag to display user-specific social information
 * Intended to use with SocialProfile extension version 1.3 or later, will fail without it
 * or if you have an older version of SocialProfile than 1.3.
 *
 * @author Wikia, Inc.
 * @version 1.0
 * @link http://www.mediawiki.org/wiki/Extension:UserWelcome Documentation
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'wfWelcomeUser';
} else {
	$wgExtensionFunctions[] = 'wfWelcomeUser';
}

// Extension credits that show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'name'            => 'UserWelcome',
	'version'         => '1.0.1',
	'description'     => 'Adds <tt>&lt;welcomeUser&gt;</tt> tag to display user-specific social info to logged-in users',
	'description-msg' => 'userwelcome-desc',
	'author'          => 'Wikia New York Team',
	'url'             => 'http://www.mediawiki.org/wiki/Extension:UserWelcome',
);

function wfWelcomeUser() {
    global $wgParser;
    $wgParser->setHook( 'welcomeUser', 'getWelcomeUser' );
	return true;
}

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['UserWelcome'] = $dir . 'UserWelcome.i18n.php';

function getWelcomeUser( $input, $args, $parser ){

	$parser->disableCache();
	$output = "";
	$output .= getWelcome();

	return $output;
}

function getWelcome(){
	global $wgUser, $IP, $wgUploadPath;
	wfLoadExtensionMessages('UserWelcome');

	// Get stats and user level
	$stats = new UserStats($wgUser->getID(), $wgUser->getName());
	$stats_data = $stats->getUserStats();
	$user_level = new UserLevel($stats_data["points"]);

	// Safe links
	$level_link = Title::makeTitle(NS_HELP, wfMsgHtml('mp-userlevels-link'));
	$avatar_link = Title::makeTitle(NS_SPECIAL, 'UploadAvatar');
	$invite_link = Title::makeTitle(NS_SPECIAL, 'InviteContacts');

	// Make an avatar
	$avatar = new wAvatar($wgUser->getID(), "l");

	$output = "";

	// Profile top images/points
	$output .= "<div class=\"mp-welcome-logged-in\">
	<h2>".wfMsg('mp-welcome-logged-in', $wgUser->getName())."</h2>
	<div class=\"mp-welcome-image\">
	<a href=\"". $wgUser->getUserPage()->escapeFullURL(). "\" rel=\"nofollow\"><img src=\"{$wgUploadPath}/avatars/" . $avatar->getAvatarImage() . "\" alt=\"\" border=\"0\"/></a>";
	if( strpos($avatar->getAvatarImage(), 'default_') !== false ) {
		$output .= "<div><a href=\"".$avatar_link->escapeFullURL()."\" rel=\"nofollow\">".wfMsg('mp-welcome-upload')."</a></div>";
	} else {
		$output .= "<div><a href=\"".$avatar_link->escapeFullURL()."\" rel=\"nofollow\">".wfMsg('mp-welcome-edit')."</a></div>";
	}
	$output .= "</div>";

	global $wgUserLevels;
	if( $wgUserLevels ){
		$output .= "<div class=\"mp-welcome-points\">
			<div class=\"points-and-level\">
				<div class=\"total-points\">".wfMsgExt( 'mp-welcome-points', array( 'parsemag' ), $stats_data["points"] )."</div>
				<div class=\"honorific-level\"><a href=\"".$level_link->escapeFullURL()."\">({$user_level->getLevelName()})</a></div>
			</div>
			<div class=\"cleared\"></div>
			<div class=\"needed-points\">
				" . wfMsgExt( 'mp-welcome-needed-points', array( 'parsemag' ), $level_link->escapeFullURL(),
					$user_level->getNextLevelName(), $user_level->getPointsNeededToAdvance() ) . "
			</div>
		</div>";
	}

	$output .= "<div class=\"cleared\"></div>";
	$output .= getRequests();
	$output .= "</div>";

	return $output;
}

function getRequests(){
	wfLoadExtensionMessages('UserWelcome');

	//get requests
	$requests = getNewMessagesLink() . getRelationshipRequestLink() . getNewGiftLink() . getNewSystemGiftLink();

	$output = '';
	if( $requests ){

		$output .= "<div class=\"mp-requests\">
			<h3>".wfMsg('mp-requests-title')."</h3>
			<div class=\"mp-requests-message\">
				".wfMsg('mp-requests-message')."
			</div>
			$requests
		</div>";

	}

	return $output;
}

function getRelationshipRequestLink(){
	global $wgUser, $IP, $wgUploadPath;
	wfLoadExtensionMessages('UserWelcome');
	require_once("$IP/extensions/SocialProfile/UserRelationship/UserRelationshipClass.php");
	$friend_request_count = UserRelationship::getOpenRequestCount($wgUser->getID(), 1);
	$foe_request_count = UserRelationship::getOpenRequestCount($wgUser->getID(), 2);
	$relationship_request_link = Title::makeTitle(NS_SPECIAL, 'ViewRelationshipRequests');

	$rel_title = Title::makeTitle(NS_SPECIAL, 'ViewRelationshipRequests');
	$output = "";

	if( $friend_request_count ){
		$output .= "<p>
			<img src=\"{$wgUploadPath}/common/addedFriendIcon.png\" alt=\"\" border=\"0\"/>
			<a href=\"".$relationship_request_link->escapeFullURL()."\" rel=\"nofollow\">".wfMsgExt('mp-request-new-friend', 'parsemag', $friend_request_count)."</a>
		</p>";
	}

	if( $foe_request_count ){
		  $output .= "<p>
			<img src=\"{$wgUploadPath}/common/addedFoeIcon.png\" alt=\"\" border=\"0\"/>
			<a href=\"".$relationship_request_link->escapeFullURL()."\" rel=\"nofollow\">".wfMsgExt('mp-request-new-foe', 'parsemag', $foe_request_count)."</a>
		</p>";
	 }
	return $output;
}

function getNewGiftLink(){
	global $wgUser, $IP, $wgUploadPath;
	wfLoadExtensionMessages('UserWelcome');
	require_once("$IP/extensions/SocialProfile/UserGifts/UserGiftsClass.php");
	$gift_count = UserGifts::getNewGiftCount($wgUser->getID());
	$gifts_title = Title::makeTitle(NS_SPECIAL, 'ViewGifts');
	$output = "";
	if( $gift_count ){
		$output .= "<p>
			<img src=\"{$wgUploadPath}/common/icon_package_get.gif\" alt=\"\" border=\"0\"/>
			<a href=\"".$gifts_title->escapeFullURL()."\" rel=\"nofollow\">".wfMsgExt('mp-request-new-gift', 'parsemag', $gift_count)."</a>
		</p>";
	}
	return $output;
}

function getNewSystemGiftLink(){
	global $wgUser, $IP, $wgUploadPath;
	wfLoadExtensionMessages('UserWelcome');
	require_once("$IP/extensions/SocialProfile/SystemGifts/UserSystemGiftsClass.php");
	$gift_count = UserSystemGifts::getNewSystemGiftCount($wgUser->getID());
	$gifts_title = Title::makeTitle(NS_SPECIAL, 'ViewSystemGifts');
	$output = "";

	if( $gift_count ){
		$output .= "<p>
			<img src=\"{$wgUploadPath}/common/awardIcon.png\" alt=\"\" border=\"0\"/>
			<a href=\"".$gifts_title->escapeFullURL()."\" rel=\"nofollow\">".wfMsgExt('mp-request-new-award', 'parsemag', $gift_count)."</a>
		</p>";
	}

	return $output;
}

function getNewMessagesLink(){
	global $wgUser, $wgUploadPath;
	wfLoadExtensionMessages('UserWelcome');
	$new_messages = UserBoard::getNewMessageCount($wgUser->getID());
	$output = '';
	if( $new_messages ){
		$board_link = Title::makeTitle(NS_SPECIAL, 'UserBoard');
		$output .= "<p>
			<img src=\"{$wgUploadPath}/common/emailIcon.gif\" alt=\"email icon\" border=\"\"/>
			<a href=\"".$board_link->escapeFullURL()."\" rel=\"nofollow\">".wfMsg('mp-request-new-message')."</a>
		</p>";
	}
	return $output;
}
