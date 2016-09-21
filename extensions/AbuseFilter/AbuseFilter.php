<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

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

$wgExtensionCredits[version_compare($wgVersion, '1.17alpha', '>=') ? 'antispam' : 'other'][] = array(
	'path' => __FILE__,
	'name' => 'Abuse Filter',
	'author' => array( 'Andrew Garrett', 'River Tarnell', 'Victor Vasiliev' ),
	'descriptionmsg' => 'abusefilter-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:AbuseFilter',
);

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['AbuseFilter'] =  "$dir/AbuseFilter.i18n.php";
$wgExtensionMessagesFiles['AbuseFilterAliases'] = "$dir/AbuseFilter.alias.php";

$wgAutoloadClasses['AbuseFilter'] = "$dir/AbuseFilter.class.php";
$wgAutoloadClasses['AbuseFilterParser'] = "$dir/AbuseFilter.parser.php";
$wgAutoloadClasses['AbuseFilterHooks'] = "$dir/AbuseFilter.hooks.php";
$wgAutoloadClasses['SpecialAbuseLog'] = "$dir/special/SpecialAbuseLog.php";
$wgAutoloadClasses['SpecialAbuseFilter'] = "$dir/special/SpecialAbuseFilter.php";

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

$wgAutoloadClasses['ApiQueryAbuseLog'] = "$dir/api/ApiQueryAbuseLog.php";
$wgAPIListModules['abuselog'] = 'ApiQueryAbuseLog';
$wgAutoloadClasses['ApiQueryAbuseFilters'] = "$dir/api/ApiQueryAbuseFilters.php";
$wgAPIListModules['abusefilters'] = 'ApiQueryAbuseFilters';
$wgAutoloadClasses['ApiAbuseFilterCheckSyntax'] = "$dir/api/ApiAbuseFilterCheckSyntax.php";
$wgAPIModules['abusefilterchecksyntax'] = 'ApiAbuseFilterCheckSyntax';
$wgAutoloadClasses['ApiAbuseFilterEvalExpression'] = "$dir/api/ApiAbuseFilterEvalExpression.php";
$wgAPIModules['abusefilterevalexpression'] = 'ApiAbuseFilterEvalExpression';
$wgAutoloadClasses['ApiAbuseFilterUnblockAutopromote'] = "$dir/api/ApiAbuseFilterUnblockAutopromote.php";
$wgAPIModules['abusefilterunblockautopromote'] = 'ApiAbuseFilterUnblockAutopromote';
$wgAutoloadClasses['ApiAbuseFilterCheckMatch'] = "$dir/api/ApiAbuseFilterCheckMatch.php";
$wgAPIModules['abusefiltercheckmatch'] = 'ApiAbuseFilterCheckMatch';

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
$wgHooks['MakeGlobalVariablesScript'][] = 'AbuseFilterHooks::onMakeGlobalVariablesScript';
$wgHooks['UserRename::Local'][] = 'AbuseFilterHooks::onUserRenameLocal';
$wgHooks['UserRename::LocalIP'][] = 'AbuseFilterHooks::onUserRenameLocalIP';

$wgLogTypes[] = 'abusefilter';
$wgLogNames['abusefilter']          = 'abusefilter-log-name';
$wgLogHeaders['abusefilter']        = 'abusefilter-log-header';
$wgLogActionsHandlers['abusefilter/modify'] = array( 'AbuseFilter', 'modifyActionText' );
$wgLogActions['suppress/hide-afl'] = 'abusefilter-logentry-suppress';
$wgLogActions['suppress/unhide-afl'] = 'abusefilter-logentry-unsuppress';

$commonModuleInfo = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'AbuseFilter/modules',
);

$wgResourceModules['ext.abuseFilter'] = array(
	'styles' => 'ext.abuseFilter.css',
) + $commonModuleInfo;

$wgResourceModules['ext.abuseFilter.edit'] = array(
	'scripts' => 'ext.abuseFilter.edit.js',
	'messages' => array(
		'abusefilter-edit-syntaxok',
		'abusefilter-edit-syntaxerr',
		'unknown-error',
	),
	'dependencies' => array(
		'jquery.textSelection',
		'jquery.spinner',
	),
) + $commonModuleInfo;

$wgResourceModules['ext.abuseFilter.tools'] = array(
	'scripts' => 'ext.abuseFilter.tools.js',
	'messages' => array(
		'abusefilter-reautoconfirm-notallowed',
		'abusefilter-reautoconfirm-none',
		'abusefilter-reautoconfirm-done',
	),
	'dependencies' => array(
		'jquery.spinner'
	),
) + $commonModuleInfo;

$wgResourceModules['ext.abuseFilter.examine'] = array(
	'scripts' => 'ext.abuseFilter.examine.js',
	'messages' => array(
		'abusefilter-examine-match',
		'abusefilter-examine-nomatch',
		'abusefilter-examine-syntaxerror',
		'abusefilter-examine-notfound',
	),
) + $commonModuleInfo;

$wgAbuseFilterAvailableActions = array( 'flag', 'throttle', 'warn', 'disallow', 'blockautopromote', 'block', 'degroup', 'tag' );

$wgAbuseFilterConditionLimit = 1000;

// Disable filters if they match more than X edits, constituting more than Y% of the last Z edits, if they have been changed in the last S seconds
$wgAbuseFilterEmergencyDisableThreshold = 0.05;
$wgAbuseFilterEmergencyDisableCount = 2;
$wgAbuseFilterEmergencyDisableAge = 86400; // One day.

// Abuse filter parser class
$wgAbuseFilterParserClass = 'AbuseFilterParser';

$wgAbuseFilterRestrictedActions = array( 'block', 'degroup' );

// UDP configuration
$wgAbuseFilterUDPPrefix = 'abusefilter:';
$wgAbuseFilterUDPAddress = null;
$wgAbuseFilterUDPPort = null;

// Centralised filters
$wgAbuseFilterCentralDB = null;
$wgAbuseFilterIsCentral = false;

// Callback functions for custom actions
$wgAbuseFilterCustomActionsHandlers = array();
