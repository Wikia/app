<?php
/**
 * Gaming Calendar
 * 
 * A notification module for gaming wikis that allows users to quickly review a snapshot of upcoming game releases.
 * 
 * @author Michał Roszka <michal@wikia-inc.com>
 * @author William Lee <wlee@wikia-inc.com>
 */
$wgExtensionCredits['other'][] = array(
    'name'        => 'Gaming Calendar',
    'description' => 'A notification module for gaming wikis that allows users to quickly review a snapshot of upcoming game releases.',
    'version'     => '1.0',
    'author'      => array( 'Michał Roszka', 'William Lee' )
);

$dir = dirname( __FILE__ ) . '/';
$app = F::app();
//classes
$app->registerClass('GamingCalendarController', $dir . 'GamingCalendarController.class.php');
$app->registerClass('GamingCalendar', $dir . 'GamingCalendar.class.php');
$app->registerClass('GamingCalendarEntry', $dir . 'GamingCalendarEntry.class.php');
$app->registerClass('GamingCalendarRailController', $dir . 'GamingCalendarRailController.class.php');
$app->registerClass('GamingCalendarSpecialPageController', $dir . 'GamingCalendarSpecialPageController.class.php');

$wgExtensionMessagesFiles['GamingCalendar'] = "$dir/GamingCalendar.i18n.php";

// special pages
$app->registerSpecialPage('GamingCalendar', 'GamingCalendarSpecialPageController');

// permissions
$wgAvailableRights[] = 'specialgamingcalendar';
$wgGroupPermissions['staff']['specialgamingcalendar'] = true;
