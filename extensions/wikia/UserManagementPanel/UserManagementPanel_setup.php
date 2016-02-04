<?php

 // Extension credits
 $wgExtensionCredits['other'][] = array(
 	'name' => 'UserManagementPanel',
 	'author' => array( 'Lucas "TOR" Garczewski', 'Michał Roszka' ),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/UserManagementPanel',
	'descriptionmsg' => 'usermanagment-desc'
 );

$dir = dirname(__FILE__);

// autoloaded classes
$wgAutoloadClasses['SpecialUserManagementController'] =  $dir . '/SpecialUserManagementController.class.php' ;
$wgSpecialPages['UserManagement'] = 'SpecialUserManagementController';

// i18n
$wgExtensionMessagesFiles['UserManagementPanel'] = $dir.'/UserManagementPanel.i18n.php';

// hooks
$wgHooks['UserPagesHeaderModuleAfterGetTabs'][] = 'efUserManagementPanelAddTab';

/**
 * @param Array $tabs
 * @param $namespace
 * @param $userName
 * @return bool
 */
function efUserManagementPanelAddTab( &$tabs, $namespace, $userName ) {
	global $wgTitle, $wgUser;

	if ( !$wgUser->isAllowed( 'usermanagement' ) ) {
		return true;
	}

	$tabs[] = array(
		'link' => Wikia::link(SpecialPage::getTitleFor('UserManagement/' . $userName ), wfMsg('usermanagement-tab-label')),
		'selected' => ($wgTitle->isSpecial( 'UserManagement' )),
		'data-id' => 'usermanagment',
	);

	return true;
}
