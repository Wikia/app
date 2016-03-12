<?php
/**
 * AdminDashboard
 *
 * @author Hyun Lim
 *
 */

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'Admin Dashboard',
	'author' => 'Wikia',
	'descriptionmsg' => 'admindashboard-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AdminDashboard',
);

//classes
$wgAutoloadClasses['AdminDashboardSpecialPageController'] =  $dir . 'AdminDashboardSpecialPageController.class.php';
$wgAutoloadClasses['AdminDashboardController'] =  $dir . 'AdminDashboardController.class.php';
$wgAutoloadClasses['AdminDashboardLogic'] =  $dir . 'AdminDashboardLogic.class.php';
$wgAutoloadClasses['QuickStatsController'] =  $dir . 'QuickStatsController.class.php';

// hooks
$wgHooks['BeforeToolbarMenu'][] = 'AdminDashboardLogic::onBeforeToolbarMenu';
$wgHooks['WikiaHtmlTitleExtraParts'][] = 'AdminDashboardLogic::onWikiaHtmlTitleExtraParts';

// i18n mapping
$wgExtensionMessagesFiles['AdminDashboard'] = $dir . 'AdminDashboard.i18n.php';
$wgExtensionMessagesFiles['QuickStats'] = $dir . 'QuickStats.i18n.php';
$wgExtensionMessagesFiles['AdminDashboardAliases'] = $dir . 'AdminDashboard.alias.php';

// special pages
$wgSpecialPages[ 'AdminDashboard'] = 'AdminDashboardSpecialPageController';

// register messages package for JS (BugId:41451)
JSMessages::registerPackage('AdminDashboard', array(
	'admindashboard-loading',
));
