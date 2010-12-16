<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();

/**
 * Automatically applies heuristics to edits.
 *
 * @file
 * @ingroup Extensions
 * @author Andrew Garrett <andrew@epstone.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * Includes GFDL-licensed images retrieved from http://commons.wikimedia.org/wiki/File:Yes_check.svg
 * and http://commons.wikimedia.org/wiki/File:Red_x.svg -- both have been downsampled and converted to PNG.
 * @link http://www.mediawiki.org/wiki/Extension:AbuseFilter Documentation
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Abuse Filter',
	'author' => array( 'Andrew Garrett', 'River Tarnell', 'Victor Vasiliev' ),
	'description' => 'Applies automatic heuristics to edits.',
	'descriptionmsg' => 'abusefilter-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:AbuseFilter',
);

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['AbuseFilter'] =  "$dir/AbuseFilter.i18n.php";
$wgExtensionAliasesFiles['AbuseFilter'] = "$dir/AbuseFilter.alias.php";

$wgAutoloadClasses['AbuseFilter'] = "$dir/AbuseFilter.class.php";
$wgAutoloadClasses['AbuseFilterParser'] = "$dir/AbuseFilter.parser.php";
$wgAutoloadClasses['AbuseFilterHooks'] = "$dir/AbuseFilter.hooks.php";
$wgAutoloadClasses['SpecialAbuseLog'] = "$dir/SpecialAbuseLog.php";
$wgAutoloadClasses['SpecialAbuseFilter'] = "$dir/SpecialAbuseFilter.php";

$wgAutoloadClasses['AbuseFilterViewList'] = "$dir/Views/AbuseFilterViewList.php";
$wgAutoloadClasses['AbuseFilterView'] = "$dir/Views/AbuseFilterView.php";
$wgAutoloadClasses['AbuseFilterViewEdit'] = "$dir/Views/AbuseFilterViewEdit.php";
$wgAutoloadClasses['AbuseFilterViewTools'] = "$dir/Views/AbuseFilterViewTools.php";
$wgAutoloadClasses['AbuseFilterViewHistory'] = "$dir/Views/AbuseFilterViewHistory.php";
$wgAutoloadClasses['AbuseFilterViewRevert'] = "$dir/Views/AbuseFilterViewRevert.php";
$wgAutoloadClasses['AbuseFilterViewTestBatch'] = "$dir/Views/AbuseFilterViewTestBatch.php";
$wgAutoloadClasses['AbuseFilterViewExamine'] = "$dir/Views/AbuseFilterViewExamine.php";
$wgAutoloadClasses['AbuseFilterChangesList'] = "$dir/Views/AbuseFilterViewExamine.php";
$wgAutoloadClasses['AbuseFilterViewDiff'] = "$dir/Views/AbuseFilterViewDiff.php";
$wgAutoloadClasses['AbuseFilterViewImport'] = "$dir/Views/AbuseFilterViewImport.php";

$wgAutoloadClasses['AbuseFilterVariableHolder'] = "$dir/AbuseFilterVariableHolder.php";
$wgAutoloadClasses['AFComputedVariable'] = "$dir/AbuseFilterVariableHolder.php";
$wgAutoloadClasses['AFPData'] = "$dir/AbuseFilter.parser.php";

$wgSpecialPages['AbuseLog'] = 'SpecialAbuseLog';
$wgSpecialPages['AbuseFilter'] = 'SpecialAbuseFilter';
$wgSpecialPageGroups['AbuseLog'] = 'changes';
$wgSpecialPageGroups['AbuseFilter'] = 'wiki';

$wgAutoloadClasses['ApiQueryAbuseLog'] = "$dir/ApiQueryAbuseLog.php";
$wgAPIListModules['abuselog'] = 'ApiQueryAbuseLog';
$wgAutoloadClasses['ApiQueryAbuseFilters'] = "$dir/ApiQueryAbuseFilters.php";
$wgAPIListModules['abusefilters'] = 'ApiQueryAbuseFilters';

$wgHooks['EditFilterMerged'][] = 'AbuseFilterHooks::onEditFilterMerged';
$wgHooks['GetAutoPromoteGroups'][] = 'AbuseFilterHooks::onGetAutoPromoteGroups';
$wgHooks['AbortMove'][] = 'AbuseFilterHooks::onAbortMove';
$wgHooks['AbortNewAccount'][] = 'AbuseFilterHooks::onAbortNewAccount';
$wgHooks['ArticleDelete'][] = 'AbuseFilterHooks::onArticleDelete';
$wgHooks['RecentChange_save'][] = 'AbuseFilterHooks::onRecentChangeSave';
$wgHooks['ListDefinedTags'][] = 'AbuseFilterHooks::onListDefinedTags';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'AbuseFilterHooks::onLoadExtensionSchemaUpdates';
$wgHooks['ContributionsToolLinks'][] = 'AbuseFilterHooks::onContributionsToolLinks';
$wgHooks['UploadVerification'][] = 'AbuseFilterHooks::onUploadVerification';

$wgAvailableRights[] = 'abusefilter-modify';
$wgAvailableRights[] = 'abusefilter-log-detail';
$wgAvailableRights[] = 'abusefilter-view';
$wgAvailableRights[] = 'abusefilter-log';
$wgAvailableRights[] = 'abusefilter-private';
$wgAvailableRights[] = 'abusefilter-modify-restricted';
$wgAvailableRights[] = 'abusefilter-revert';
$wgAvailableRights[] = 'abusefilter-view-private';

$wgLogTypes[] = 'abusefilter';
$wgLogNames['abusefilter']          = 'abusefilter-log-name';
$wgLogHeaders['abusefilter']        = 'abusefilter-log-header';
$wgLogActionsHandlers['abusefilter/modify'] = array( 'AbuseFilter', 'modifyActionText' );

$wgAbuseFilterAvailableActions = array( 'flag', 'throttle', 'warn', 'disallow', 'blockautopromote', 'block', 'degroup', 'tag' );

$wgAbuseFilterConditionLimit = 1000;

// Disable filters if they match more than X edits, constituting more than Y% of the last Z edits, if they have been changed in the last S seconds
$wgAbuseFilterEmergencyDisableThreshold = 0.05;
$wgAbuseFilterEmergencyDisableCount = 2;
$wgAbuseFilterEmergencyDisableAge = 86400; // One day.

// Abuse filter parser class
$wgAbuseFilterParserClass = 'AbuseFilterParser';

$wgAjaxExportList[] = 'AbuseFilter::ajaxCheckSyntax';
$wgAjaxExportList[] = 'AbuseFilter::ajaxEvaluateExpression';
$wgAjaxExportList[] = 'AbuseFilter::ajaxReAutoconfirm';
$wgAjaxExportList[] = 'AbuseFilter::ajaxGetFilter';
$wgAjaxExportList[] = 'AbuseFilter::ajaxCheckFilterWithVars';

// Bump the version number every time you change any of the .css/.js files
$wgAbuseFilterStyleVersion = 9;

$wgAbuseFilterRestrictedActions = array( 'block', 'degroup' );

// UDP configuration
$wgAbuseFilterUDPPrefix = 'abusefilter:';
$wgAbuseFilterUDPAddress = null;
$wgAbuseFilterUDPPort = null;

// Centralised filters
$wgAbuseFilterCentralDB = null;
$wgAbuseFilterIsCentral = false;

// Block duration
$wgAbuseFilterBlockDuration = 'indefinite';
