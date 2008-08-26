<?php
//Global profile namespace reference
define( 'NS_USER_PROFILE', 202 );
define( 'NS_USER_WIKI', 200 );

//default setup for displaying sections
$wgUserPageChoice = true;
$wgUserProfileDisplay['friends'] = false;
$wgUserProfileDisplay['foes'] = false;
$wgUserProfileDisplay['profile'] = true;
$wgUserProfileDisplay['board'] = false;
$wgUserProfileDisplay['stats'] = false; //Display statistics on user profile pages?
$wgUserProfileDisplay['interests'] = true;
$wgUserProfileDisplay['custom'] = true;
$wgUserProfileDisplay['personal'] = true;

$wgUpdateProfileInRecentChanges = false; // Show a log entry in recent changes whenever a user updates their profile?
$wgUploadAvatarInRecentChanges = false; //Same as above, but for avatar uploading

$wgAvailableRights[] = 'avatarremove';
$wgGroupPermissions['staff']['avatarremove'] = true;
$wgGroupPermissions['sysop']['avatarremove'] = true;
$wgGroupPermissions['janitor']['avatarremove'] = true;

# Add a new log type
global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
$wgLogTypes[]                      = 'profile';
$wgLogNames['profile']            = 'profilelogpage';
$wgLogHeaders['profile']          = 'profilelogpagetext';
$wgLogActions['profile/profile'] = 'profilelogentry';

$wgLogTypes[]                      = 'avatar';
$wgLogNames['avatar']            = 'avatarlogpage';
$wgLogHeaders['avatar']          = 'avatarlogpagetext';
$wgLogActions['avatar/avatar'] = 'avatarlogentry';

$wgHooks['ArticleFromTitle'][] = 'wfUserProfileFromTitle';

//ArticleFromTitle
//Calls UserProfilePage instead of standard article
function wfUserProfileFromTitle( &$title, &$article ){
	global $wgUser, $wgRequest, $IP, $wgOut, $wgTitle, $wgSupressPageTitle, $wgSupressSubTitle, $wgMemc,
	$wgUserPageChoice, $wgParser, $wgUserProfileDirectory, $wgUserProfileScripts, $wgStyleVersion;

	if ( strpos( $title->getText(), "/" ) === false && ( NS_USER == $title->getNamespace() || NS_USER_PROFILE == $title->getNamespace() ) ) {

		require_once( "{$wgUserProfileDirectory}/UserProfilePage.php" );

		$show_user_page = false;
		if( $wgUserPageChoice ){
			$profile = new UserProfile( $title->getText() );
			$profile_data = $profile->getProfile();

			//If they want regular page, ignore this hook
			if( isset( $profile_data["user_id"] ) && $profile_data["user_id"] && $profile_data["user_page_type"] == 0 ){
				$show_user_page = true;
			}
		}

		if(  ! $show_user_page ){
			//prevents editing of userpage
			if( $wgRequest->getVal("action") == "edit" ){
				$wgOut->redirect( $title->getFullURL() );
			}
		} else {
			$wgOut->enableClientCache(false);
			$wgParser->disableCache();
		}

		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgUserProfileScripts}/UserProfile.css?{$wgStyleVersion}\"/>\n");

		$article = new UserProfilePage( $title );
	}
	return true;
}

/*
//testing new hooks
$wgHooks['UserProfileBeginLeft'][] = 'wfUserProfileBeginTest';
function wfUserProfileBeginTest($user_profile) {
	global $wgOut;
	//$wgOut->addHTML("this was inserted at the left beginning from the hook [profile:{$user_profile->user_name}]");
	return true;
}

//testing new hooks
$wgHooks['UserProfileEndLeft'][] = 'wfUserProfileBeginTest2';
function wfUserProfileBeginTest2($user_profile) {
	global $wgOut;
	//$wgOut->addHTML("this was inserted at the left end from the hook [profile:{$user_profile->user_name}]");
	return true;
}
//testing new hooks
$wgHooks['UserProfileBeginRight'][] = 'wfUserProfileBeginTest3';
function wfUserProfileBeginTest3($user_profile) {
	global $wgOut;
	//$wgOut->addHTML("this was inserted at the right beginning from the hook [profile:{$user_profile->user_name}]");
	return true;
}
//testing new hooks
$wgHooks['UserProfileEndRight'][] = 'wfUserProfileBeginTest4';
function wfUserProfileBeginTest4($user_profile) {
	global $wgOut;
	//$wgOut->addHTML("this was inserted at the right end from the hook [profile:{$user_profile->user_name}]");
	return true;
}
*/

$wgExtensionFunctions[] = 'wfUserProfileReadLang';

//read in localisation messages
function wfUserProfileReadLang(){
	wfLoadExtensionMessages( 'SocialProfileUserProfile' );
}
