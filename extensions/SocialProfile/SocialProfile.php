<?php
/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die(
		'This is the setup file for the SocialProfile extension to MediaWiki.' .
		'Please see http://www.mediawiki.org/wiki/Extension:SocialProfile for' .
		' more information about this extension.'
	);
}

/**
 * This is the loader file for the SocialProfile extension. You should include
 * this file in your wiki's LocalSettings.php to activate SocialProfile.
 *
 * If you want to use the UserWelcome extension (bundled with SocialProfile),
 * the <topusers /> tag or the user levels feature, there are some other files
 * you will need to include in LocalSettings.php. The online manual has more
 * details about this.
 *
 * For more info about SocialProfile, please see http://www.mediawiki.org/wiki/Extension:SocialProfile.
 */
$dir = dirname( __FILE__ ) . '/';

// Internationalization files
$wgExtensionMessagesFiles['SocialProfileUserBoard'] = $dir . 'UserBoard/UserBoard.i18n.php';
$wgExtensionMessagesFiles['SocialProfileUserProfile'] = $dir . 'UserProfile/UserProfile.i18n.php';
$wgExtensionMessagesFiles['SocialProfileUserRelationship'] = $dir . 'UserRelationship/UserRelationship.i18n.php';
$wgExtensionMessagesFiles['SocialProfileUserStats'] = $dir . 'UserStats/UserStats.i18n.php';
$wgExtensionMessagesFiles['SocialProfileUserStatus'] = $dir . 'UserStatus/UserStatus.i18n.php';

$wgExtensionMessagesFiles['SocialProfileNamespaces'] = $dir . 'SocialProfile.namespaces.php';
$wgExtensionMessagesFiles['SocialProfileAlias'] = $dir . 'SocialProfile.alias.php';

// Classes to be autoloaded
$wgAutoloadClasses['GenerateTopUsersReport'] = $dir . 'UserStats/GenerateTopUsersReport.php';

$wgAutoloadClasses['SpecialAddRelationship'] = $dir . 'UserRelationship/SpecialAddRelationship.php';
$wgAutoloadClasses['SpecialBoardBlast'] = $dir . 'UserBoard/SpecialSendBoardBlast.php';
$wgAutoloadClasses['SpecialEditProfile'] = $dir . 'UserProfile/SpecialEditProfile.php';
$wgAutoloadClasses['SpecialPopulateUserProfiles'] = $dir . 'UserProfile/SpecialPopulateExistingUsersProfiles.php';
$wgAutoloadClasses['SpecialRemoveRelationship'] = $dir . 'UserRelationship/SpecialRemoveRelationship.php';
$wgAutoloadClasses['SpecialToggleUserPage'] = $dir . 'UserProfile/SpecialToggleUserPageType.php';
$wgAutoloadClasses['SpecialUpdateProfile'] = $dir . 'UserProfile/SpecialUpdateProfile.php';
$wgAutoloadClasses['SpecialUploadAvatar'] = $dir . 'UserProfile/SpecialUploadAvatar.php';
$wgAutoloadClasses['SpecialViewRelationshipRequests'] = $dir . 'UserRelationship/SpecialViewRelationshipRequests.php';
$wgAutoloadClasses['SpecialViewRelationships'] = $dir . 'UserRelationship/SpecialViewRelationships.php';
$wgAutoloadClasses['SpecialViewUserBoard'] = $dir . 'UserBoard/SpecialUserBoard.php';
$wgAutoloadClasses['SpecialUserStatus'] = $dir . 'UserStatus/SpecialUserStatus.php';
$wgAutoloadClasses['RemoveAvatar'] = $dir . 'UserProfile/SpecialRemoveAvatar.php';
$wgAutoloadClasses['UpdateEditCounts'] = $dir . 'UserStats/SpecialUpdateEditCounts.php';
$wgAutoloadClasses['UserBoard'] = $dir . 'UserBoard/UserBoardClass.php';
$wgAutoloadClasses['UserProfile'] = $dir . 'UserProfile/UserProfileClass.php';
$wgAutoloadClasses['UserProfilePage'] = $dir . 'UserProfile/UserProfilePage.php';
$wgAutoloadClasses['UserRelationship'] = $dir . 'UserRelationship/UserRelationshipClass.php';
$wgAutoloadClasses['UserLevel'] = $dir . 'UserStats/UserStatsClass.php';
$wgAutoloadClasses['UserStats'] = $dir . 'UserStats/UserStatsClass.php';
$wgAutoloadClasses['UserStatsTrack'] = $dir . 'UserStats/UserStatsClass.php';
$wgAutoloadClasses['UserSystemMessage'] = $dir . 'UserSystemMessages/UserSystemMessagesClass.php';
$wgAutoloadClasses['TopFansByStat'] = $dir . 'UserStats/TopFansByStat.php';
$wgAutoloadClasses['TopFansRecent'] = $dir . 'UserStats/TopFansRecent.php';
$wgAutoloadClasses['TopUsersPoints'] = $dir . 'UserStats/TopUsers.php';
$wgAutoloadClasses['wAvatar'] = $dir . 'UserProfile/AvatarClass.php';
$wgAutoloadClasses['UserStatusClass'] = $dir . 'UserStatus/UserStatusClass.php';

// New special pages
$wgSpecialPages['AddRelationship'] = 'SpecialAddRelationship';
$wgSpecialPages['EditProfile'] = 'SpecialEditProfile';
$wgSpecialPages['GenerateTopUsersReport'] = 'GenerateTopUsersReport';
$wgSpecialPages['PopulateUserProfiles'] = 'SpecialPopulateUserProfiles';
$wgSpecialPages['RemoveAvatar'] = 'RemoveAvatar';
$wgSpecialPages['RemoveRelationship'] = 'SpecialRemoveRelationship';
$wgSpecialPages['SendBoardBlast'] = 'SpecialBoardBlast';
$wgSpecialPages['TopFansByStatistic'] = 'TopFansByStat';
$wgSpecialPages['TopUsers'] = 'TopUsersPoints';
$wgSpecialPages['TopUsersRecent'] = 'TopFansRecent';
$wgSpecialPages['ToggleUserPage'] = 'SpecialToggleUserPage';
$wgSpecialPages['UpdateEditCounts'] = 'UpdateEditCounts';
$wgSpecialPages['UpdateProfile'] = 'SpecialUpdateProfile';
$wgSpecialPages['UploadAvatar'] = 'SpecialUploadAvatar';
$wgSpecialPages['UserBoard'] = 'SpecialViewUserBoard';
$wgSpecialPages['ViewRelationshipRequests'] = 'SpecialViewRelationshipRequests';
$wgSpecialPages['ViewRelationships'] = 'SpecialViewRelationships';
$wgSpecialPages['UserStatus'] = 'SpecialUserStatus';

// Special page groups for MW 1.13+
$wgSpecialPageGroups['AddRelationship'] = 'users';
$wgSpecialPageGroups['RemoveAvatar'] = 'users';
$wgSpecialPageGroups['RemoveRelationship'] = 'users';
$wgSpecialPageGroups['UserBoard'] = 'users';
$wgSpecialPageGroups['ViewRelationshipRequests'] = 'users';
$wgSpecialPageGroups['ViewRelationships'] = 'users';

// Necessary AJAX functions
require_once( "$IP/extensions/SocialProfile/UserBoard/UserBoard_AjaxFunctions.php" );
require_once( "$IP/extensions/SocialProfile/UserRelationship/Relationship_AjaxFunctions.php" );
require_once( "$IP/extensions/SocialProfile/UserStatus/UserStatus_AjaxFunctions.php" );

// What to display on social profile pages by default?
$wgUserProfileDisplay['board'] = true;
$wgUserProfileDisplay['foes'] = true;
$wgUserProfileDisplay['friends'] = true;

// Should we display UserBoard-related things on social profile pages?
$wgUserBoard = true;

// Whether to enable friending or not -- this doesn't do very much actually, so don't rely on it
$wgFriendingEnabled = true;

// Should we enable UserStatus feature (currently is under development)
$wgEnableUserStatus = false;
// Permission to delete other Users' Status Messages
$wgGroupPermissions['sysop']['delete-status-update'] = true;
// Extension credits that show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'SocialProfile',
	'author' => array( 'Aaron Wright', 'David Pean', 'Jack Phoenix' ),
	'version' => '1.5',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A set of Social Tools for MediaWiki',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'TopUsers',
	'author' => 'David Pean',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'Adds a special page for viewing the list of users with the most points.',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'UploadAvatar',
	'author' => 'David Pean',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for uploading Avatars',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'RemoveAvatar',
	'author' => 'David Pean',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for removing users\' avatars',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'PopulateExistingUsersProfiles',
	'author' => 'David Pean',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for initializing social profiles for existing wikis',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'ToggleUserPage',
	'author' => 'David Pean',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for updating a user\'s userpage preference',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'UpdateProfile',
	'author' => 'David Pean',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page to allow users to update their social profile',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'SendBoardBlast',
	'author' => 'David Pean',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => ' A special page to allow users to send a mass board message by selecting from a list of their friends and foes',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'UserBoard',
	'author' => 'David Pean',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'Display User Board messages for a user',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'AddRelationship',
	'author' => 'David Pean',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for adding friends/foe requests for existing users in the wiki',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'RemoveRelationship',
	'author' => 'David Pean',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for removing existing friends/foes for the current logged in user',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'ViewRelationshipRequests',
	'author' => 'David Pean',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for viewing open relationship requests for the current logged in user',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'ViewRelationships',
	'author' => 'David Pean',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for viewing all relationships by type',
);

// Some paths used by the extensions
$wgUserProfileDirectory = "$IP/extensions/SocialProfile/UserProfile";

$wgUserBoardScripts = "$wgScriptPath/extensions/SocialProfile/UserBoard";
$wgUserProfileScripts = "$wgScriptPath/extensions/SocialProfile/UserProfile";
$wgUserRelationshipScripts = "$wgScriptPath/extensions/SocialProfile/UserRelationship";

// Loader files
require_once( "{$wgUserProfileDirectory}/UserProfile.php" ); // Profile page configuration loader file
require_once( "$IP/extensions/SocialProfile/UserGifts/Gifts.php" ); // UserGifts (user-to-user gifting functionality) loader file
require_once( "$IP/extensions/SocialProfile/SystemGifts/SystemGifts.php" ); // SystemGifts (awards functionality) loader file
require_once( "$IP/extensions/SocialProfile/UserActivity/UserActivity.php" ); // UserActivity - recent social changes

// Hooked functions
$wgHooks['CanonicalNamespaces'][] = 'wfSocialProfileRegisterCanonicalNamespaces';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efSocialProfileSchemaUpdates';

/**
 * Register the canonical names for our custom namespaces and their talkspaces.
 *
 * @param $list Array: array of namespace numbers with corresponding
 *                     canonical names
 * @return Boolean: true
 */
function wfSocialProfileRegisterCanonicalNamespaces( &$list ) {
	$list[NS_USER_WIKI] = 'UserWiki';
	$list[NS_USER_WIKI_TALK] = 'UserWiki_talk';
	$list[NS_USER_PROFILE] = 'User_profile';
	$list[NS_USER_PROFILE_TALK] = 'User_profile_talk';
	return true;
}

// Schema changes
function efSocialProfileDBUpdate( $updater, $label, $file ) {
	if ( $updater === null ) {
		global $wgExtNewTables;

		$wgExtNewTables[] = array( $label, $file );
	} else {
		$updater->addExtensionUpdate( array( 'addTable', $label, $file, true ) );
	}
}

function efSocialProfileSchemaUpdates( $updater = null ) {
	global $wgDBtype;

	$dir = dirname( __FILE__ );
	$dbExt = '';

	if ( $wgDBtype == 'postgres' ) {
		$dbExt = '.postgres';
	}

	efSocialProfileDBUpdate( $updater, 'user_board', "$dir/UserBoard/user_board$dbExt.sql" );
	efSocialProfileDBUpdate( $updater, 'user_profile', "$dir/UserProfile/user_profile$dbExt.sql" );
	efSocialProfileDBUpdate( $updater, 'user_stats', "$dir/UserStats/user_stats$dbExt.sql" );
	efSocialProfileDBUpdate( $updater, 'user_relationship',	"$dir/UserRelationship/user_relationship$dbExt.sql" );
	efSocialProfileDBUpdate( $updater, 'user_relationship_request', "$dir/UserRelationship/user_relationship$dbExt.sql" );
	efSocialProfileDBUpdate( $updater, 'user_system_gift', "$dir/SystemGifts/systemgifts$dbExt.sql" );
	efSocialProfileDBUpdate( $updater, 'system_gift', "$dir/SystemGifts/systemgifts$dbExt.sql" );
	efSocialProfileDBUpdate( $updater, 'user_gift', "$dir/UserGifts/usergifts$dbExt.sql" );
	efSocialProfileDBUpdate( $updater, 'gift', "$dir/UserGifts/usergifts$dbExt.sql" );
	efSocialProfileDBUpdate( $updater, 'user_system_messages', "$dir/UserSystemMessages/user_system_messages$dbExt.sql" );
	efSocialProfileDBUpdate( $updater, 'user_status', "$dir/UserStatus/userstatus$dbExt.sql" );
	efSocialProfileDBUpdate( $updater, 'user_status_history', "$dir/UserStatus/userstatus$dbExt.sql" );
	efSocialProfileDBUpdate( $updater, 'user_status_likes', "$dir/UserStatus/userstatus$dbExt.sql" );

	return true;
}

/*
// For Renameuser extension
$wgHooks['RenameUserSQL'][] = 'efSystemGiftsOnUserRename';
$wgHooks['RenameUserSQL'][] = 'efUserBoardOnUserRename';
$wgHooks['RenameUserSQL'][] = 'efUserGiftsOnUserRename';
$wgHooks['RenameUserSQL'][] = 'efUserRelationshipOnUserRename';
$wgHooks['RenameUserSQL'][] = 'efUserStatsOnUserRename';
$wgHooks['RenameUserSQL'][] = 'efUserSystemMessagesOnUserRename';

function efSystemGiftsOnUserRename( $renameUserSQL ) {
	$renameUserSQL->tables['user_system_gift'] = array( 'sg_user_name', 'sg_user_id' );
	return true;
}

function efUserBoardOnUserRename( $renameUserSQL ) {
	$renameUserSQL->tables['user_board'] = array( 'ub_user_name_from', 'ub_user_id_from' );
	return true;
}

function efUserGiftsOnUserRename( $renameUserSQL ) {
	$renameUserSQL->tables['user_gift'] = array( 'ug_user_name_to', 'ug_user_id_to' );
	$renameUserSQL->tables['gift'] = array( 'gift_creator_user_name', 'gift_creator_user_id' );
	return true;
}

function efUserRelationshipOnUserRename( $renameUserSQL ) {
	// <fixme> This sucks and only updates half of the rows...wtf?
	$renameUserSQL->tables['user_relationship'] = array( 'r_user_name_relation', 'r_user_id_relation' );
	$renameUserSQL->tables['user_relationship'] = array( 'r_user_name', 'r_user_id' );
	// </fixme>
	$renameUserSQL->tables['user_relationship_request'] = array( 'ur_user_name_from', 'ur_user_id_from' );
	return true;
}

function efUserStatsOnUserRename( $renameUserSQL ) {
	$renameUserSQL->tables['user_stats'] = array( 'stats_user_name', 'stats_user_id' );
	return true;
}

function efUserSystemMessagesOnUserRename( $renameUserSQL ) {
	$renameUserSQL->tables['user_system_messages'] = array( 'um_user_name', 'um_user_id' );
	return true;
}
*/

if( !defined( 'NS_USER_WIKI' ) ) {
	define( 'NS_USER_WIKI', 200 );
}

if( !defined( 'NS_USER_WIKI_TALK' ) ) {
	define( 'NS_USER_WIKI_TALK', 201 );
}

if( !defined( 'NS_USER_PROFILE' ) ) {
	define( 'NS_USER_PROFILE', 202 );
}

if( !defined( 'NS_USER_PROFILE_TALK' ) ) {
	define( 'NS_USER_PROFILE_TALK', 203 );
}