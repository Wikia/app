<?php
/**
 * User Profile Page Extension - provides a user page that is fun and easy to update
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Garth Webb <garth(at)wikia-inc.com>
 */

if(!defined('MEDIAWIKI')) {
	die();
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'User Profile Page',
	'author' => 'Adrian \'ADi\' Wieczorek, Garth Webb, Federico "Lox" Lucignano',
	'url' => 'http://www.wikia.com' ,
	'description' => 'provides a user page that is fun and easy to update',
	'descriptionmsg' => 'userprofilepage-desc'
);

/**
 * setup functions
 */
$wgExtensionFunctions[] = 'wfUserProfilePageInit';

$wgUserProfilePagesNamespaces = array();


/**
 * message file
 */
$wgExtensionMessagesFiles['UserProfilePage'] = dirname(__FILE__) . '/UserProfilePage.i18n.php';
//$wgExtensionMessagesFiles['MyHome'] = dirname($dir) . '/MyHome/MyHome.i18n.php';


function wfUserProfilePageInit() {
	global $wgHooks, $wgAutoloadClasses, $wgAjaxExportList, $wgUserProfilePagesNamespaces;

	$dir = dirname(__FILE__) . '/';

	/**
	 * hooks
	 */
	$wgHooks[ 'SkinTemplateOutputPageBeforeExec' ][] = 'UserProfilePageHelper::onSkinTemplateOutputPageBeforeExec';
	$wgHooks[ 'AlternateEdit' ][] = 'UserProfilePageHelper::onAlternateEdit';
	$wgHooks[ 'GetRailModuleList' ][] = 'UserProfilePageHelper::onGetRailModuleList';
	$wgHooks[ 'ArticleSaveComplete' ][] = 'UserProfilePageHelper::onArticleSaveComplete';
	$wgHooks[ 'ArticleDeleteComplete' ][] = 'UserProfilePageHelper::onArticleDeleteComplete';
	$wgHooks[ 'SpecialMovepageAfterMove' ][] = 'UserProfilePageHelper::onSpecialMovepageAfterMove';

	/**
	 * classes
	 */
	$wgAutoloadClasses['UserProfilePage'] = $dir . 'UserProfilePage.class.php';
	$wgAutoloadClasses['UserProfilePageHelper'] = $dir . 'UserProfilePageHelper.class.php';
	$wgAutoloadClasses['UserProfilePageModule'] = $dir . 'UserProfilePageModule.class.php';
	$wgAutoloadClasses['UserProfileRailModule'] = $dir . 'UserProfileRailModule.class.php';

	/**
	 * ajax
	 */
	$wgAjaxExportList[] = 'UserProfilePageHelper::doAction';

	$wgUserProfilePagesNamespaces[] = NS_USER_TALK;
	$wgUserProfilePagesNamespaces[] = NS_USER;

	if( defined( 'NS_BLOG_ARTICLE' ) ) {
		$wgUserProfilePagesNamespaces[] = NS_BLOG_ARTICLE;
	}

}

/**
 * rights
 */
/* NOTE: These have to be defined outside of that hooked init function.
	I'm not entirely sure why, but it wasnt working how it was.
	The ->isAllowed('editprofile') checks were all failing to acknowledge the editing person had this right.
	It was listed in the group permission array, but not in the wgUser object.
	Much debugging was done. Verified this works in all cases/groups. --Uberfuzzy */

global $wgAvailableRights, $wgGroupPermissions;
$wgAvailableRights[] = 'editprofile';
$wgGroupPermissions['*']['editprofile'] = false;
$wgGroupPermissions['sysop']['editprofile'] = true;
$wgGroupPermissions['staff']['editprofile'] = true;
$wgGroupPermissions['helper']['editprofile'] = true;
$wgGroupPermissions['vstf']['editprofile'] = true;
