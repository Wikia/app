<?php
/**
 * UserWelcome extension
 * Adds <welcomeUser/> tag to display user-specific social information
 *
 * @file
 * @ingroup Extensions
 * @author David Pean <david.pean@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @version 1.2
 * @link http://www.mediawiki.org/wiki/Extension:UserWelcome Documentation
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'UserWelcome',
	'version' => '1.2',
	'author' => array( 'David Pean', 'Jack Phoenix' ),
	'description' => 'Adds <tt>&lt;welcomeUser&gt;</tt> tag to display user-specific social info to logged-in users',
	'descriptionmsg' => 'userwelcome-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:UserWelcome',
);

$wgHooks['ParserFirstCallInit'][] = 'wfWelcomeUser';
/**
 * Register <welcomeUser /> tag with the parser
 * @param $parser Object: instance of Parser
 * @return true
 */
function wfWelcomeUser( &$parser ) {
	$parser->setHook( 'welcomeUser', 'getWelcomeUser' );
	return true;
}

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['UserWelcome'] = $dir . 'UserWelcome.i18n.php';

function getWelcomeUser( $input, $args, $parser ) {
	$parser->disableCache();
	$output = getWelcome();

	return $output;
}

function getWelcome() {
	global $wgUser, $wgOut, $wgScriptPath, $wgUploadPath;
	wfLoadExtensionMessages( 'UserWelcome' );

	// Add CSS
	$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/SocialProfile/UserWelcome/UserWelcome.css' );

	// Get stats and user level
	$stats = new UserStats( $wgUser->getID(), $wgUser->getName() );
	$stats_data = $stats->getUserStats();
	$user_level = new UserLevel( $stats_data['points'] );

	// Safe links
	$level_link = Title::makeTitle( NS_HELP, wfMsgHtml( 'mp-userlevels-link' ) );
	$avatar_link = SpecialPage::getTitleFor( 'UploadAvatar' );
	$invite_link = Title::makeTitle( NS_SPECIAL, 'InviteContacts' );

	// Make an avatar
	$avatar = new wAvatar( $wgUser->getID(), 'l' );

	// Profile top images/points
	$output = '<div class="mp-welcome-logged-in">
	<h2>' . wfMsg( 'mp-welcome-logged-in', $wgUser->getName() ) . '</h2>
	<div class="mp-welcome-image">
	<a href="' . $wgUser->getUserPage()->escapeFullURL() . '" rel="nofollow"><img src="' . $wgUploadPath . '/avatars/' . $avatar->getAvatarImage() . '" alt="" border="0"/></a>';
	if ( strpos( $avatar->getAvatarImage(), 'default_' ) !== false ) {
		$output .= '<div><a href="' . $avatar_link->escapeFullURL() . '" rel="nofollow">' . wfMsg( 'mp-welcome-upload' ) . '</a></div>';
	} else {
		$output .= '<div><a href="' . $avatar_link->escapeFullURL() . '" rel="nofollow">' . wfMsg( 'mp-welcome-edit' ) . '</a></div>';
	}
	$output .= '</div>';

	global $wgUserLevels;
	if ( $wgUserLevels ) {
		$output .= '<div class="mp-welcome-points">
			<div class="points-and-level">
				<div class="total-points">' . wfMsgExt( 'mp-welcome-points', 'parsemag', $stats_data['points'] ) . '</div>
				<div class="honorific-level"><a href="' . $level_link->escapeFullURL() . '">(' . $user_level->getLevelName() . ')</a></div>
			</div>
			<div class="cleared"></div>
			<div class="needed-points">
				<br />
				' . wfMsgExt( 'mp-welcome-needed-points', 'parsemag', $level_link->escapeFullURL(),
					$user_level->getNextLevelName(), $user_level->getPointsNeededToAdvance() ) . '
			</div>
		</div>';
	}

	$output .= '<div class="cleared"></div>';
	$output .= getRequests();
	$output .= '</div>';

	return $output;
}

function getRequests() {
	wfLoadExtensionMessages( 'UserWelcome' );

	// Get requests
	$requests = getNewMessagesLink() . getRelationshipRequestLink() . getNewGiftLink() . getNewSystemGiftLink();

	$output = '';
	if ( $requests ) {
		$output .= '<div class="mp-requests">
			<h3>' . wfMsg( 'mp-requests-title' ) . '</h3>
			<div class="mp-requests-message">
				' . wfMsg( 'mp-requests-message' ) . "
			</div>
			$requests
		</div>";
	}

	return $output;
}

function getRelationshipRequestLink() {
	global $wgUser, $wgScriptPath;
	wfLoadExtensionMessages( 'UserWelcome' );
	$friend_request_count = UserRelationship::getOpenRequestCount( $wgUser->getID(), 1 );
	$foe_request_count = UserRelationship::getOpenRequestCount( $wgUser->getID(), 2 );
	$relationship_request_link = SpecialPage::getTitleFor( 'ViewRelationshipRequests' );

	$rel_title = SpecialPage::getTitleFor( 'ViewRelationshipRequests' );
	$output = '';

	if ( $friend_request_count ) {
		$output .= '<p>
			<img src="' . $wgScriptPath . '/extensions/SocialProfile/images/addedFriendIcon.png" alt="" border="0" />
			<a href="' . $relationship_request_link->escapeFullURL() . '" rel="nofollow">'
			. wfMsgExt( 'mp-request-new-friend', 'parsemag', $friend_request_count ) . '</a>
		</p>';
	}

	if ( $foe_request_count ) {
		  $output .= '<p>
			<img src="' . $wgScriptPath . '/extensions/SocialProfile/images/addedFoeIcon.png" alt="" border="0" />
			<a href="' . $relationship_request_link->escapeFullURL() . '" rel="nofollow">'
			. wfMsgExt( 'mp-request-new-foe', 'parsemag', $foe_request_count ) . '</a>
		</p>';
	}

	return $output;
}

function getNewGiftLink() {
	global $wgUser, $wgScriptPath;
	wfLoadExtensionMessages( 'UserWelcome' );
	$gift_count = UserGifts::getNewGiftCount( $wgUser->getID() );
	$gifts_title = SpecialPage::getTitleFor( 'ViewGifts' );
	$output = '';
	if ( $gift_count ) {
		$output .= '<p>
			<img src="' . $wgScriptPath . '/extensions/SocialProfile/images/icon_package_get.gif" alt="" border="0" />
			<a href="' . $gifts_title->escapeFullURL() . '" rel="nofollow">' . wfMsgExt( 'mp-request-new-gift', 'parsemag', $gift_count ) . '</a>
		</p>';
	}
	return $output;
}

function getNewSystemGiftLink() {
	global $wgUser, $wgScriptPath;
	wfLoadExtensionMessages( 'UserWelcome' );
	$gift_count = UserSystemGifts::getNewSystemGiftCount( $wgUser->getID() );
	$gifts_title = SpecialPage::getTitleFor( 'ViewSystemGifts' );
	$output = '';

	if ( $gift_count ) {
		$output .= '<p>
			<img src="' . $wgScriptPath . '/extensions/SocialProfile/images/awardIcon.png" alt="" border="0" />
			<a href="' . $gifts_title->escapeFullURL() . '" rel="nofollow">' . wfMsgExt( 'mp-request-new-award', 'parsemag', $gift_count ) . '</a>
		</p>';
	}

	return $output;
}

function getNewMessagesLink() {
	global $wgUser, $wgScriptPath;
	wfLoadExtensionMessages( 'UserWelcome' );
	$new_messages = UserBoard::getNewMessageCount( $wgUser->getID() );
	$output = '';
	if ( $new_messages ) {
		$board_link = SpecialPage::getTitleFor( 'UserBoard' );
		$output .= '<p>
			<img src="' . $wgScriptPath . '/extensions/SocialProfile/images/emailIcon.gif" alt="email icon" border="" />
			<a href="' . $board_link->escapeFullURL() . '" rel="nofollow">' . wfMsg( 'mp-request-new-message' ) . '</a>
		</p>';
	}
	return $output;
}
