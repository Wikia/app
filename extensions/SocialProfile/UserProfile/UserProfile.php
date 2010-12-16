<?php
// Global profile namespace reference
define( 'NS_USER_PROFILE', 202 );
define( 'NS_USER_WIKI', 200 );

// Default setup for displaying sections
$wgUserPageChoice = true;

$wgUserProfileDisplay['friends'] = false;
$wgUserProfileDisplay['foes'] = false;
$wgUserProfileDisplay['gifts'] = true;
$wgUserProfileDisplay['awards'] = true;
$wgUserProfileDisplay['profile'] = true;
$wgUserProfileDisplay['board'] = false;
$wgUserProfileDisplay['stats'] = false; // Display statistics on user profile pages?
$wgUserProfileDisplay['interests'] = true;
$wgUserProfileDisplay['custom'] = true;
$wgUserProfileDisplay['personal'] = true;
$wgUserProfileDisplay['activity'] = false; // Display recent social activity?
$wgUserProfileDisplay['userboxes'] = false; // If FanBoxes extension is installed, setting this to true will display the user's fanboxes on their profile page

$wgUpdateProfileInRecentChanges = false; // Show a log entry in recent changes whenever a user updates their profile?
$wgUploadAvatarInRecentChanges = false; // Same as above, but for avatar uploading

$wgAvailableRights[] = 'avatarremove';
$wgGroupPermissions['sysop']['avatarremove'] = true;

# Add new log types for profile edits and avatar uploads
global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
$wgLogTypes[]                    = 'profile';
$wgLogNames['profile']           = 'profilelogpage';
$wgLogHeaders['profile']         = 'profilelogpagetext';
$wgLogActions['profile/profile'] = 'profilelogentry';

$wgLogTypes[]                    = 'avatar';
$wgLogNames['avatar']            = 'avatarlogpage';
$wgLogHeaders['avatar']          = 'avatarlogpagetext';
$wgLogActions['avatar/avatar'] = 'avatarlogentry';

$wgHooks['ArticleFromTitle'][] = 'wfUserProfileFromTitle';

/**
 * Called by ArticleFromTitle hook
 * Calls UserProfilePage instead of standard article
 *
 * @param &$title Title object
 * @param &$article Article object
 * @return true
 */
function wfUserProfileFromTitle( &$title, &$article ) {
	global $wgRequest, $wgOut, $wgHooks, $wgUserPageChoice, $wgUserProfileScripts;

	if ( strpos( $title->getText(), '/' ) === false &&
		( NS_USER == $title->getNamespace() || NS_USER_PROFILE == $title->getNamespace() )
	) {
		$show_user_page = false;
		if ( $wgUserPageChoice ) {
			$profile = new UserProfile( $title->getText() );
			$profile_data = $profile->getProfile();

			// If they want regular page, ignore this hook
			if ( isset( $profile_data['user_id'] ) && $profile_data['user_id'] && $profile_data['user_page_type'] == 0 ) {
				$show_user_page = true;
			}
		}

		if ( !$show_user_page ) {
			// Prevents editing of userpage
			if ( $wgRequest->getVal( 'action' ) == 'edit' ) {
				$wgOut->redirect( $title->getFullURL() );
			}
		} else {
			$wgOut->enableClientCache( false );
			$wgHooks['ParserLimitReport'][] = 'wfUserProfileMarkUncacheable';
		}

		$wgOut->addExtensionStyle( $wgUserProfileScripts . '/UserProfile.css' );

		$article = new UserProfilePage( $title );
	}
	return true;
}

/**
 * Mark page as uncacheable
 *
 * @param $parser Parser object
 * @param &$limitReport String: unused
 * @return true
 */
function wfUserProfileMarkUncacheable( $parser, &$limitReport ) {
	$parser->disableCache();
	return true;
}