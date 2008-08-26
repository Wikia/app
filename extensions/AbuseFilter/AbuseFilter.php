<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

/**#@+
 * Automatically applies heuristics to edits.
 * @addtogroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:AbuseFilter Documentation
 *
 *
 * @author Andrew Garrett <andrew@epstone.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$dir = dirname(__FILE__);
$wgExtensionCredits['other'][] = array(
	'name'           => 'Abuse Filter',
	'author'         => 'Andrew Garrett',
	'svn-date'       => '$LastChangedDate: 2008-06-08 20:48:19 +1000 (Sun, 08 Jun 2008) $',
	'svn-revision'   => '$LastChangedRevision: 36018 $',
	'description'    => 'Applies automatic heuristics to edits.',
	'descriptionmsg' => 'abusefilter-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:AbuseFilter',
);

$wgExtensionMessagesFiles['AbuseFilter'] =  "$dir/AbuseFilter.i18n.php";

$wgAutoloadClasses[ 'AbuseFilter' ] = "$dir/AbuseFilter.class.php";
$wgAutoloadClasses[ 'AbuseFilterHooks' ] = "$dir/AbuseFilter.hooks.php";
$wgAutoloadClasses['SpecialAbuseLog'] = "$dir/SpecialAbuseLog.php";
$wgAutoloadClasses['SpecialAbuseFilter'] = "$dir/SpecialAbuseFilter.php";

$wgSpecialPages['AbuseLog'] = 'SpecialAbuseLog';
$wgSpecialPages['AbuseFilter'] = 'SpecialAbuseFilter';

$wgHooks['EditFilter'][] = 'AbuseFilterHooks::onEditFilter';
$wgHooks['GetAutoPromoteGroups'][] = 'AbuseFilterHooks::onGetAutoPromoteGroups';
$wgHooks['AbortMove'][] = 'AbuseFilterHooks::onAbortMove';
$wgHooks['AbortNewAccount'][] = 'AbuseFilterHooks::onAbortNewAccount';
$wgHooks['ArticleDelete'][] = 'AbuseFilterHooks::onArticleDelete';

$wgAvailableRights[] = 'abusefilter-modify';
$wgAvailableRights[] = 'abusefilter-log-detail';
$wgAvailableRights[] = 'abusefilter-view';
$wgAvailableRights[] = 'abusefilter-log';
$wgAvailableRights[] = 'abusefilter-private';

$wgAbuseFilterAvailableActions = array( 'flag', 'throttle', 'warn', 'disallow', 'blockautopromote', 'block', 'degroup' );

// Conditions take about 4ms to check, so 100 conditions would take 400ms
$wgAbuseFilterConditionLimit = 1000;

// Disable filters if they match more than X edits, constituting more than Y% of the last Z edits
$wgAbuseFilterEmergencyDisableThreshold = 0.05;
$wgAbuseFilterEmergencyDisableCount = 5;