<?php
/**
 * NewSignupPage extension for MediaWiki -- enhances the default signup form
 *
 * @file
 * @ingroup Extensions
 * @version 0.4.1
 * @author Jack Phoenix <jack@countervandalism.net>
 * @copyright Copyright © 2008-2011 Jack Phoenix
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @note Uses GPL-licensed code from LoginReg extension (functions
 * fnRegisterAutoAddFriend and fnRegisterTrack)
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'New Signup Page',
	'author' => 'Jack Phoenix',
	'version' => '0.4.1',
	'url' => 'https://www.mediawiki.org/wiki/Extension:NewSignupPage',
	'description' => 'Adds new features to [[Special:UserLogin/signup|signup form]]',
);

// Internationalization file
$wgExtensionMessagesFiles['NewSignupPage'] = dirname( __FILE__ ) . '/NewSignupPage.i18n.php';

// New user right, allows bypassing the ToS check on signup form
$wgAvailableRights[] = 'bypasstoscheck';

// Hooked functions
$wgHooks['AbortNewAccount'][] = 'efTermsOfServiceAbortNewAccount';
$wgHooks['UserCreateForm'][] = 'efTermsOfServiceOnSignup';

// Function that conditionally enables some hooks
$wgExtensionFunctions[] = 'efHandleSocialTools';

# Configuration
// Should we track new user registration? Requires that the user_register_track table exists in the DB.
$wgRegisterTrack = false;
// If the new user was referred to the site by an existing user, should we make them friends automatically?
$wgAutoAddFriendOnInvite = false;
// Initialize the extension, even if InviteEmail or UserRelationship classes do
// not exist? Useful for testing.
$wgForceNewSignupPageInitialization = false;

// Checks if InviteContacts extension and social tools' core are both loaded and enables two hooked functions if so
function efHandleSocialTools() {
	global $wgForceNewSignupPageInitialization;
	if(
		class_exists( 'InviteEmail' ) && class_exists( 'UserRelationship' ) ||
		$wgForceNewSignupPageInitialization
	)
	{
		global $wgHooks;
		$wgHooks['AddNewAccount'][] = 'fnRegisterTrack';
		$wgHooks['AddNewAccount'][] = 'fnRegisterAutoAddFriend';
	}
}

/**
 * Adds the checkbox into Special:UserLogin/signup
 *
 * @param $template QuickTemplate instance
 * @return Boolean: true
 */
function efTermsOfServiceOnSignup( &$template ) {
	global $wgRequest;

	// Terms of Service box
	$template->addInputItem( 'wpTermsOfService', ''/*do *not* have this checked by default!*/, 'checkbox', 'shoutwiki-loginform-tos' );

	// Referrer stuff for social wikis
	$template->addInputItem( 'from', $wgRequest->getInt( 'from' ), 'hidden', '' );
	$template->addInputItem( 'referral', $wgRequest->getVal( 'referral' ), 'hidden', '' );

	return true;
}

/**
 * Abort the creation of the new account if the user hasn't checked the checkbox
 *
 * @param $user Object: the User object about to be created (read-only, incomplete)
 * @param $message String: error message to be displayed to the user, if any
 * @return Boolean: false by default, true if user has checked the checkbox or has 'bypasstoscheck' right
 */
function efTermsOfServiceAbortNewAccount( $user, $message ) {
	global $wgRequest, $wgUser;

	if(
		$wgRequest->getCheck( 'wpTermsOfService' ) ||
		$wgUser->isAllowed( 'bypasstoscheck' )
	)
	{
		return true;
	} else {
		$message = wfMsg( 'shoutwiki-must-accept-tos' );
		return false;
	}

	return false; // since the checkbox isn't checked by default either
}

/**
 * Automatically make the referring user and the newly-registered user friends
 * if $wgAutoAddFriendOnInvite is set to true.
 *
 * @param $user Object: the User object representing the newly-created user
 * @return Boolean: true
 */
function fnRegisterAutoAddFriend( $user ) {
	global $wgRequest, $wgAutoAddFriendOnInvite;

	if( $wgAutoAddFriendOnInvite ) {
		$referral_user = $wgRequest->getVal( 'referral' );
		if( $referral_user ) {
			$user_id_referral = User::idFromName( $referral_user );
			if( $user_id_referral ) {
				// need to create fake request first
				$rel = new UserRelationship( $referral_user );
				$request_id = $rel->addRelationshipRequest(
					$user->getName(), 1, '', false
				);

				// clear the status
				$rel->updateRelationshipRequestStatus( $request_id, 1 );

				// automatically add relationhips
				$rel = new UserRelationship( $user->getName() );
				$rel->addRelationship( $request_id, true );
			}
		}
	}
	return true;
}

/**
 * Track new user registrations to the user_register_track database table if
 * $wgRegisterTrack is set to true.
 *
 * @param $user Object: the User object representing the newly-created user
 * @return Boolean: true
 */
function fnRegisterTrack( $user ) {
	global $wgRequest, $wgRegisterTrack, $wgMemc;

	if( $wgRegisterTrack ) {
		$wgMemc->delete( wfMemcKey( 'users', 'new', '1' ) );

		// How the user registered (via email from friend, just on the site etc.)?
		$from = $wgRequest->getInt( 'from' );
		if( !$from ) {
			$from = 0;
		}

		// Track if the user clicked on email from friend
		$user_id_referral = 0;
		$user_name_referral = '';
		$referral_user = $wgRequest->getVal( 'referral' );
		if( $referral_user ) {
			$user_registering_title = Title::makeTitle( NS_USER, $user->getName() );
			$user_title = Title::newFromDBkey( $referral_user );
			$user_id_referral = User::idFromName( $user_title->getText() );
			if( $user_id_referral ) {
				$user_name_referral = $user_title->getText();
			}

			$stats = new UserStatsTrack( $user_id_referral, $user_title->getText() );
			$stats->incStatField( 'referral_complete' );

			if( class_exists( 'UserSystemMessage' ) ) {
				$m = new UserSystemMessage();
				// Nees to be forContent because addMessage adds this into a
				// database table - we don't want to display Japanese text
				// to English users
				$message = wfMsgForContent(
					'login-reg-recruited',
					$user_registering_title->getFullURL(),
					$user->getName()
				);
				$m->addMessage( $user_title->getText(), 1, $message );
			}
		}

		// Track registration
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			'user_register_track',
			array(
				'ur_user_id' => $user->getID(),
				'ur_user_name' => $user->getName(),
				'ur_user_id_referral' => $user_id_referral,
				'ur_user_name_referral' => $user_name_referral,
				'ur_from' => $from,
				'ur_date' => date( 'Y-m-d H:i:s' )
			),
			__METHOD__
		);
		$dbw->commit(); // Just in case...
	}
	return true;
}