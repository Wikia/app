<?php
/**
 * AdminDashboard
 *
 * @author Hyun Lim
 *
 */

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['AdminDashboardSpecialPageController'] =  $dir . 'AdminDashboardSpecialPageController.class.php';
$wgAutoloadClasses['AdminDashboardController'] =  $dir . 'AdminDashboardController.class.php';
$wgAutoloadClasses['AdminDashboardLogic'] =  $dir . 'AdminDashboardLogic.class.php';
$wgAutoloadClasses['QuickStatsController'] =  $dir . 'QuickStatsController.class.php';

$wgHooks['BeforeToolbarMenu'][] = 'AdminDashboardLogic::onBeforeToolbarMenu';

// i18n mapping
$wgExtensionMessagesFiles['AdminDashboard'] = $dir . 'AdminDashboard.i18n.php';
$wgExtensionMessagesFiles['QuickStats'] = $dir . 'QuickStats.i18n.php';
$wgExtensionMessagesFiles['AdminDashboardAliases'] = $dir . 'AdminDashboard.alias.php';

// special pages
$wgSpecialPages[ 'AdminDashboard'] = 'AdminDashboardSpecialPageController';

$wgAvailableRights[] = 'admindashboard';

$wgGroupPermissions['*']['admindashboard'] = false;
$wgGroupPermissions['staff']['admindashboard'] = true;
$wgGroupPermissions['sysop']['admindashboard'] = true;
$wgGroupPermissions['bureaucrat']['admindashboard'] = true;
$wgGroupPermissions['helper']['admindashboard'] = true;

// register messages package for JS (BugId:41451)
JSMessages::registerPackage('AdminDashboard', array(
	'admindashboard-loading',
));
