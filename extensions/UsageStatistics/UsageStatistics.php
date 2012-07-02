<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * A Special Page extension to display user statistics
 *
 * @file
 * @ingroup Extensions
 *
 * @author Paul Grinberg <gri6507@yahoo.com>
 * @copyright Copyright © 2007, Paul Grinberg
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'UserStats',
	'version'        => 'v1.12.0',
	'author'         => 'Paul Grinberg',
	'email'          => 'gri6507 at yahoo dot com',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Usage_Statistics',
	'descriptionmsg' => 'usagestatistics-desc',
);

# By default, the graphs are generated using the gnuplot extension.
# However, the user can optionally use Google Charts to generate the
# graphs instead. To do so, set the following to 1
$wgUserStatsGoogleCharts = 0;

$wgUserStatsGlobalRight = 'viewsystemstats';
$wgAvailableRights[] = 'viewsystemstats';

# define the permissions to view systemwide statistics
$wgGroupPermissions['*'][$wgUserStatsGlobalRight] = false;
$wgGroupPermissions['manager'][$wgUserStatsGlobalRight] = true;
$wgGroupPermissions['sysop'][$wgUserStatsGlobalRight] = true;

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['UserStats'] = $dir . '/UsageStatistics.i18n.php';
$wgExtensionMessagesFiles['UserStatsAlias'] = $dir . 'UsageStatistics.alias.php';
$wgAutoloadClasses['SpecialUserStats'] = $dir . '/UsageStatistics_body.php';
$wgSpecialPages['SpecialUserStats'] = 'SpecialUserStats';
$wgSpecialPageGroups['SpecialUserStats'] = 'wiki';
