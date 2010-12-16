<?php
/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) )
	die();

/**
 * This is the *main* (but certainly not the only) loader file for SocialProfile extension.
 *
 * For more info about SocialProfile, please see the README file that was included with SocialProfile.
 */
$dir = dirname( __FILE__ ) . '/';

// Internationalization files
$wgExtensionMessagesFiles['SocialProfileUserBoard'] = $dir . 'UserBoard/UserBoard.i18n.php';
$wgExtensionMessagesFiles['SocialProfileUserProfile'] = $dir . 'UserProfile/UserProfile.i18n.php';
$wgExtensionMessagesFiles['SocialProfileUserRelationship'] = $dir . 'UserRelationship/UserRelationship.i18n.php';
$wgExtensionMessagesFiles['SocialProfileUserStats'] = $dir . 'UserStats/UserStats.i18n.php';

$wgExtensionAliasesFiles['SocialProfile'] = $dir . 'SocialProfile.alias.php';

// Classes to be autoloaded
$wgAutoloadClasses['SpecialAddRelationship'] = $dir . 'UserRelationship/SpecialAddRelationship.php';
$wgAutoloadClasses['SpecialBoardBlast'] = $dir . 'UserBoard/SpecialSendBoardBlast.php';
$wgAutoloadClasses['SpecialPopulateUserProfiles'] = $dir . 'UserProfile/SpecialPopulateExistingUsersProfiles.php';
$wgAutoloadClasses['SpecialRemoveRelationship'] = $dir . 'UserRelationship/SpecialRemoveRelationship.php';
$wgAutoloadClasses['SpecialToggleUserPage'] = $dir . 'UserProfile/SpecialToggleUserPageType.php';
$wgAutoloadClasses['SpecialUpdateProfile'] = $dir . 'UserProfile/SpecialUpdateProfile.php';
$wgAutoloadClasses['SpecialUploadAvatar'] = $dir . 'UserProfile/SpecialUploadAvatar.php';
$wgAutoloadClasses['SpecialViewRelationshipRequests'] = $dir . 'UserRelationship/SpecialViewRelationshipRequests.php';
$wgAutoloadClasses['SpecialViewRelationships'] = $dir . 'UserRelationship/SpecialViewRelationships.php';
$wgAutoloadClasses['SpecialViewUserBoard'] = $dir . 'UserBoard/SpecialUserBoard.php';

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

// New special pages
$wgSpecialPages['AddRelationship'] = 'SpecialAddRelationship';
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

// What to display on social profile pages by default?
$wgUserProfileDisplay['board'] = true;
$wgUserProfileDisplay['foes'] = true;
$wgUserProfileDisplay['friends'] = true;

// Should we display UserBoard-related things on social profile pages?
$wgUserBoard = true;

// Whether to enable friending or not -- this doesn't do very much actually, so don't rely on it
$wgFriendingEnabled = true;

// Extension credits that show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'SocialProfile',
	'author' => array( 'Aaron Wright', 'David Pean', 'Jack Phoenix' ),
	'version' => '1.4',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A set of Social Tools for MediaWiki',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'TopUsers',
	'author' => 'David Pean',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'Adds a special page for viewing the list of users with the most points.',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'UploadAvatar',
	'author' => 'David Pean',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for uploading Avatars',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'RemoveAvatar',
	'author' => 'David Pean',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for removing users\' avatars',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'PopulateExistingUsersProfiles',
	'author' => 'David Pean',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for initializing social profiles for existing wikis',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'ToggleUserPage',
	'author' => 'David Pean',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for updating a user\'s userpage preference',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'UpdateProfile',
	'author' => 'David Pean',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page to allow users to update their social profile',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'SendBoardBlast',
	'author' => 'David Pean',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => ' A special page to allow users to send a mass board message by selecting from a list of their friends and foes',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'UserBoard',
	'author' => 'David Pean',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'Display User Board messages for a user',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'AddRelationship',
	'author' => 'David Pean',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for adding friends/foe requests for existing users in the wiki',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'RemoveRelationship',
	'author' => 'David Pean',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for removing existing friends/foes for the current logged in user',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'ViewRelationshipRequests',
	'author' => 'David Pean',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for viewing open relationship requests for the current logged in user',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'ViewRelationships',
	'author' => 'David Pean',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for viewing all relationships by type',
);

// Some paths used by the extensions
$wgUserProfileDirectory = "$IP/extensions/SocialProfile/UserProfile";

$wgUserBoardScripts = "$wgScriptPath/extensions/SocialProfile/UserBoard";
$wgUserProfileScripts = "$wgScriptPath/extensions/SocialProfile/UserProfile";
$wgUserRelationshipScripts = "$wgScriptPath/extensions/SocialProfile/UserRelationship";

// Loader files
require_once( "$IP/extensions/SocialProfile/YUI/YUI.php" ); // YUI stand-alone library
require_once( "{$wgUserProfileDirectory}/UserProfile.php" ); // Profile page configuration loader file
require_once( "$IP/extensions/SocialProfile/UserGifts/Gifts.php" ); // UserGifts (user-to-user gifting functionality) loader file
require_once( "$IP/extensions/SocialProfile/SystemGifts/SystemGifts.php" ); // SystemGifts (awards functionality) loader file
require_once( "$IP/extensions/SocialProfile/UserActivity/UserActivity.php" ); // UserActivity - recent social changes

# Schema changes
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efSocialProfileSchemaUpdates';

function efSocialProfileSchemaUpdates() {
	global $wgExtNewTables, $wgDBtype;
	$dir = dirname( __FILE__ );
	if( $wgDBtype == 'mysql' ) {
		// Initial install tables
		$wgExtNewTables[] = array( 'user_board', "$dir/UserBoard/user_board.sql" );
		$wgExtNewTables[] = array( 'user_profile', "$dir/UserProfile/user_profile.sql" );
		$wgExtNewTables[] = array( 'user_stats', "$dir/UserStats/user_stats.sql" );
		$wgExtNewTables[] = array( 'user_relationship',	"$dir/UserRelationship/user_relationship.sql" );
		$wgExtNewTables[] = array( 'user_relationship_request', "$dir/UserRelationship/user_relationship.sql" );
		$wgExtNewTables[] = array( 'user_system_gift', "$dir/SystemGifts/systemgifts.sql" );
		$wgExtNewTables[] = array( 'system_gift', "$dir/SystemGifts/systemgifts.sql" );
		$wgExtNewTables[] = array( 'user_gift', "$dir/UserGifts/usergifts.sql" );
		$wgExtNewTables[] = array( 'gift', "$dir/UserGifts/usergifts.sql" );
		$wgExtNewTables[] = array( 'user_system_messages', "$dir/UserSystemMessages/user_system_messages.sql" );
	}
	return true;
}