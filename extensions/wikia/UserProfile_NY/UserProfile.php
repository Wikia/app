<?php
//GLOBAL VIDEO NAMESPACE REFERENCE
define( 'NS_USER_PROFILE', 202 );
define( 'NS_USER_WIKI', 200 );

/**
 * localized ns - proof of concept aka quick hack
 *
 * @see SMW includes/SMW_GlobalFunctions.php::smwfInitNamespaces
 * FIXME generalize
 */

if ('de' == $wgLanguageCode) {
	// make en ns point (alias) to "main ns" - at this point themselves
	foreach (array(200, 201, 202) as $ns) {
		$wgNamespaceAliases[$wgExtraNamespaces[$ns]] = $ns;
	}
	// translate "main ns" into de
	$wgExtraNamespaces[200] = 'BenutzerWiki';
	$wgExtraNamespaces[201] = 'BenutzerWiki_Diskussion';
	$wgExtraNamespaces[202] = 'Benutzerprofil';
	// the end: de name is the "main ns", en is just an alias (redirect)
}

if( empty($wgSocialUserPage) ){
	$wgSocialUserPage = true;
}

//setup special pages
$wgAutoloadClasses['ToggleUserPage'] = "{$wgUserProfileDirectory}/SpecialToggleUserPageType.php";
$wgSpecialPages['ToggleUserPage'] = 'ToggleUserPage';

$wgAutoloadClasses['UpdateProfile'] = "{$wgUserProfileDirectory}/SpecialUpdateProfile.php";
$wgSpecialPages['UpdateProfile'] = 'UpdateProfile';

$wgAutoloadClasses['UploadAvatar'] = "{$wgUserProfileDirectory}/SpecialUploadAvatar.php";
$wgSpecialPages['UploadAvatar'] = 'UploadAvatar';

$wgAutoloadClasses['RemoveAvatar'] = "{$wgUserProfileDirectory}/SpecialRemoveAvatar.php";
$wgSpecialPages['RemoveAvatar'] = 'RemoveAvatar';
$wgSpecialPageGroups['RemoveAvatar'] = 'users';

//default setup for displaying sections
$wgUserProfileDisplay['friends'] = true;
$wgUserProfileDisplay['foes'] = true;
$wgUserProfileDisplay['gifts'] = true;
$wgUserProfileDisplay['awards'] = true;
$wgUserProfileDisplay['activity'] = true;
$wgUserProfileDisplay['profile'] = true;
$wgUserProfileDisplay['board'] = true;
$wgUserProfileDisplay['pictures'] = false;
$wgUserProfileDisplay['games'] = true;
$wgUserProfileDisplay['stats'] = true;
$wgUserProfileDisplay['interests'] = true;
$wgUserProfileDisplay['custom'] = true;
$wgUserProfileDisplay['articles'] = true;
$wgUserProfileDisplay['personal'] = true;
$wgUserProfileDisplay['userboxes'] = true;

$wgUpdateProfileInRecentChanges = false;
$wgUploadAvatarInRecentChanges = false;

$wgAvailableRights[] = 'avatarremove';
$wgGroupPermissions['staff']['avatarremove'] = true;
$wgGroupPermissions['sysop']['avatarremove'] = true;

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
	global $wgUser, $wgRequest, $IP, $wgOut, $wgTitle, $wgSupressPageTitle,$wgSupressSubTitle, $wgMemc,
	$wgSocialUserPage, $wgUserPageChoice, $wgParser, $wgUserProfileDirectory, $wgUserProfileScripts;

	if( !$wgSocialUserPage ){
		return false;
	}

	if( NS_USER_WIKI == $title->getNamespace() ){
		global $wgShowAds;
		$wgShowAds = false;
	}

	$show_user_page = false;
	if ( strpos( $title->getText(), "/" ) === false && ( NS_USER == $title->getNamespace() || NS_USER_PROFILE == $title->getNamespace() ) ) {
		if( !$wgRequest->getVal("action") ){
			$wgSupressPageTitle = true;
		}

		$wgSupressPageTitle = true;
		require_once( "{$wgUserProfileDirectory}/UserProfilePage.php" );

		if( $wgUserPageChoice ){

			$profile = new UserProfile( $title->getText() );
			$profile_data = $profile->getProfile();

			//If they want regular page, ignore this hook
			if( isset($profile_data) && $profile_data["user_id"] && $profile_data["user_page_type"] == 0 ){
				$show_user_page = true;
			}
		}

		if( ! $show_user_page ){
			//prevents editing of userpage
			if( $wgRequest->getVal("action") == "edit" ){
				if(  $wgTitle->getText() == $wgUser->getName() ){
					$wgOut->redirect( Title::makeTitle(NS_SPECIAL, "UpdateProfile")->getFullURL() );
				}else{
					$wgOut->redirect( Title::makeTitle(NS_USER, $wgTitle->getText() )->getFullURL() );
				}
			}
		}else{
			$wgOut->enableClientCache(false);
			$wgParser->disableCache();
		}
		global $wgHooks;

		//$wgHooks['SkinTemplateOutputPageBeforeExec'][] = array(&$wgOut->template, 'wfAddProfileCSS');
		//$wgHooks["SkinTemplateOutputPageBeforeExec"][] = "wfAddProfileCSS";
		$wgHooks["GetHTMLAfterBody"][] = "wfAddProfileCSS";

		$article = new UserProfilePage($title);

	}

	return true;
}

function wfAddProfileCSS($skin, &$html){
	global $wgOut, $wgUserProfileScripts, $wgStyleVersion, $wgStylePath;
	$html .= "<link rel='stylesheet' type='text/css' href=\"{$wgUserProfileScripts}/UserProfile.css?{$wgStyleVersion}\"/>\n";

	return true;
}

/*
//testing new hooks
$wgHooks['UserProfileBeginLeft'][] = 'wfUserProfileBeginTest';
function wfUserProfileBeginTest($user_profile) {
	global $wgOut;
	//$wgOut->addHTML("Cosby kids");
	return true;
}

$wgHooks['UserProfileBeginLeft'][] = 'wfUserProfilePoop';
function wfUserProfilePoop($user_profile) {
	global $wgOut;
	//$wgOut->addHTML("dropped off");
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
	global $wgMessageCache, $IP;
	require_once ( "UserProfile.i18n.php" );
	foreach( efWikiaUserProfile() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
}

$wgHooks['UserRename::Local'][] = "UserProfileUserRenameLocal";

function UserProfileUserRenameLocal( $dbw, $uid, $oldusername, $newusername, $process, $cityId, &$tasks ) {
	$tasks[] = array(
		'table' => 'user_mailing_list',
		'userid_column' => 'um_user_id',
		'username_column' => 'um_user_name',
	);
	$tasks[] = array(
		'table' => 'user_points_archive',
		'userid_column' => 'up_user_id',
		'username_column' => 'up_user_name',
	);
	$tasks[] = array(
		'table' => 'user_points_monthly',
		'userid_column' => 'up_user_id',
		'username_column' => 'up_user_name',
	);
	$tasks[] = array(
		'table' => 'user_points_weekly',
		'userid_column' => 'up_user_id',
		'username_column' => 'up_user_name',
	);
	return true;
}


?>
