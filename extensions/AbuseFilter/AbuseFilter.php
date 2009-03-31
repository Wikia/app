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
	'author'         => array('Andrew Garrett','River Tarnell'),
	'svn-date'       => '$LastChangedDate: 2008-06-08 20:48:19 +1000 (Sun, 08 Jun 2008) $',
	'svn-revision'   => '$LastChangedRevision: 36018 $',
	'description'    => 'Applies automatic heuristics to edits.',
	'descriptionmsg' => 'abusefilter-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:AbuseFilter',
);

$wgExtensionMessagesFiles['AbuseFilter'] =  "$dir/AbuseFilter.i18n.php";
$wgExtensionAliasesFiles['AbuseFilter'] = "$dir/AbuseFilter.alias.php";

$wgAutoloadClasses['AbuseFilter'] = "$dir/AbuseFilter.class.php";
$wgAutoloadClasses['AbuseFilterParser'] = "$dir/AbuseFilter.parser.php";
$wgAutoloadClasses['AbuseFilterParserNative'] = "$dir/AbuseFilter.nativeparser.php";
$wgAutoloadClasses['AbuseFilterHooks'] = "$dir/AbuseFilter.hooks.php";
$wgAutoloadClasses['SpecialAbuseLog'] = "$dir/SpecialAbuseLog.php";
$wgAutoloadClasses['SpecialAbuseFilter'] = "$dir/SpecialAbuseFilter.php";

$wgSpecialPages['AbuseLog'] = 'SpecialAbuseLog';
$wgSpecialPages['AbuseFilter'] = 'SpecialAbuseFilter';

$wgHooks['EditFilter'][] = 'AbuseFilterHooks::onEditFilter';
$wgHooks['GetAutoPromoteGroups'][] = 'AbuseFilterHooks::onGetAutoPromoteGroups';
$wgHooks['AbortMove'][] = 'AbuseFilterHooks::onAbortMove';
$wgHooks['AbortNewAccount'][] = 'AbuseFilterHooks::onAbortNewAccount';
$wgHooks['ArticleDelete'][] = 'AbuseFilterHooks::onArticleDelete';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'AbuseFilterHooks::onSchemaUpdate';
$wgHooks['AbortDeleteQueueNominate'][] = 'AbuseFilterHooks::onAbortDeleteQueueNominate';

$wgAvailableRights[] = 'abusefilter-modify';
$wgAvailableRights[] = 'abusefilter-log-detail';
$wgAvailableRights[] = 'abusefilter-view';
$wgAvailableRights[] = 'abusefilter-log';
$wgAvailableRights[] = 'abusefilter-private';

$wgAbuseFilterAvailableActions = array( 'flag', 'throttle', 'warn', 'disallow', 'blockautopromote', 'block', 'degroup', 'rangeblock' );

// Conditions take about 4ms to check, so 100 conditions would take 400ms
// Currently, has no effect.
// $wgAbuseFilterConditionLimit = 1000;

// Disable filters if they match more than X edits, constituting more than Y% of the last Z edits, if they have been changed in the last S seconds
$wgAbuseFilterEmergencyDisableThreshold = 0.05;
$wgAbuseFilterEmergencyDisableCount = 2;
$wgAbuseFilterEmergencyDisableAge = 86400; // One day.

// Abuse filter parser class
$wgAbuseFilterParserClass = 'AbuseFilterParser';
$wgAbuseFilterNativeParser = "$dir/parser_native/af_parser";
$wgAbuseFilterNativeSyntaxCheck = "$dir/parser_native/syntax_check";
$wgAbuseFilterNativeExpressionEvaluator = "$dir/parser_native/af_expr";

$wgAjaxExportList[] = 'AbuseFilter::ajaxCheckSyntax';
$wgAjaxExportList[] = 'AbuseFilter::ajaxEvaluateExpression';
$wgAjaxExportList[] = 'AbuseFilter::ajaxReAutoconfirm';