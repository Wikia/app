<?php
/**
 * AdminDashboard
 *
 * @author Hyun Lim
 *
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();
//classes
$app->registerClass('AdminDashboardSpecialPageController', $dir . 'AdminDashboardSpecialPageController.class.php');
$app->registerClass('AdminDashboardController', $dir . 'AdminDashboardController.class.php');
$app->registerClass('AdminDashboardLogic', $dir . 'AdminDashboardLogic.class.php');
$app->registerClass('QuickStatsController', $dir . 'QuickStatsController.class.php');

$app->registerHook('BeforeToolbarMenu', 'AdminDashboardLogic', 'onBeforeToolbarMenu');

// i18n mapping
$wgExtensionMessagesFiles['AdminDashboard'] = $dir . 'AdminDashboard.i18n.php';
$wgExtensionMessagesFiles['QuickStats'] = $dir . 'QuickStats.i18n.php';

// special pages
$app->registerSpecialPage('AdminDashboard', 'AdminDashboardSpecialPageController');

$wgAvailableRights[] = 'admindashboard';

$wgGroupPermissions['*']['admindashboard'] = false;
$wgGroupPermissions['staff']['admindashboard'] = true;
$wgGroupPermissions['sysop']['admindashboard'] = true;
$wgGroupPermissions['bureaucrat']['admindashboard'] = true;
$wgGroupPermissions['helper']['admindashboard'] = true;

// register messages package for JS (BugId:41451)
F::build('JSMessages')->registerPackage('AdminDashboard', array(
	'admindashboard-loading',
));
