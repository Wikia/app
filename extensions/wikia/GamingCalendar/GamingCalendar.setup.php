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
$wgAutoloadClasses['GamingCalendarController'] =  $dir . 'GamingCalendarController.class.php';
$wgAutoloadClasses['GamingCalendar'] =  $dir . 'GamingCalendar.class.php';
$wgAutoloadClasses['GamingCalendarEntry'] =  $dir . 'GamingCalendarEntry.class.php';
$wgAutoloadClasses['GamingCalendarRailController'] =  $dir . 'GamingCalendarRailController.class.php';
$wgAutoloadClasses['GamingCalendarSpecialPageController'] =  $dir . 'GamingCalendarSpecialPageController.class.php';

$wgExtensionMessagesFiles['GamingCalendar'] = "$dir/GamingCalendar.i18n.php";

// special pages
$wgSpecialPages['GamingCalendar'] = 'GamingCalendarSpecialPageController';

// permissions
$wgAvailableRights[] = 'specialgamingcalendar';
$wgGroupPermissions['staff']['specialgamingcalendar'] = true;
