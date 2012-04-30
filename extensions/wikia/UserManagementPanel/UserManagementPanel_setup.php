<?php
 
 /**
  * FooAndBar
  *
  * A short description of the FooAndBar extention
  *
  * @author Author Name <author-email@wikia-inc.com>
  * @date 2010-01-09
  * @copyright Copyright (C) 2010 Wikia Inc.
  * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
  * @package MediaWiki
  *
  */
 
 // Extension credits
 $wgExtensionCredits['other'][] = array(
 	'name' => 'FooAndBar',
 	'author' => array( 'Lucas "TOR" Garczewski', 'Michał Roszka' ),
 );
 
 $dir = dirname(__FILE__);
 
 // autoloaded classes
$app->registerClass('SpecialUserManagementController', $dir . '/SpecialUserManagementController.class.php' );
$app->registerSpecialPage('UserManagement', 'SpecialUserManagementController');
 
 // i18n
 $wgExtensionMessagesFiles['UserManagementPanel'] = $dir.'/UserManagementPanel.i18n.php';
 
 // hooks
 $wgHooks['UserPagesHeaderModuleAfterGetTabs'][] = 'efUserManagementPanelAddTab';

// user rights
$wgAvailableRights[] = 'usermanagement';
$wgGroupPermissions['util']['usermanagement'] = true;

function efUserManagementPanelAddTab( $tabs, $namespace, $userName ) {
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
