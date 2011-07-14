<?php
/**
 * Gaming Calendar
 * 
 * A notification module for gaming wikis that allows users to quickly review a snapshot of upcoming game releases.
 * 
 * @author Michał Roszka <michal@wikia-inc.com>
 */
$wgExtensionCredits['other'][] = array(
    'name'        => 'Gaming Calendar',
    'description' => 'A notification module for gaming wikis that allows users to quickly review a snapshot of upcoming game releases.',
    'version'     => '1.0',
    'author'      => array( 'Michał Roszka' )
);

$dir = dirname( __FILE__ );

$wgAutoloadClasses['GamingCalendar'] = "$dir/GamingCalendar.class.php";
$wgExtensionMessagesFiles['GamingCalendar'] = "$dir/GamingCalendar.i18n.php";

$wgAutoloadClasses['GamingCalendarModule'] = 'skins/oasis/modules/GamingCalendarModule.php';