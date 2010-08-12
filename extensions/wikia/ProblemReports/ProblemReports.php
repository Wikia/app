<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Loader of ProblemReports extension
 *
 * Extension allows users/anons to report problems with wiki-articles and admin/staff members to view and resolve them
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'ProblemReports',
	'url' => 'http://help.wikia.com/wiki/Help:ProblemReports',
	'version' => '2.46',
	'description' => 'Allows users to report problems with wiki-articles and helpers/sysops/janitors/staff to view & resolve them',
	'author' => 'Maciej Brencz'
);

// extension setup function
$wgExtensionFunctions[] = 'wfProblemReports';

// messages
$wgExtensionMessagesFiles['ProblemReports'] = $IP . '/extensions/wikia/ProblemReports/ProblemReports.i18n.php';

// load files
require( "$IP/extensions/wikia/ProblemReports/ProblemReportsDialog.php" );
require( "$IP/extensions/wikia/ProblemReports/ProblemReportsAjax.php" );

// special page
$wgSpecialPages['ProblemReports'] = 'SpecialProblemReports';
$wgAutoloadClasses['SpecialProblemReports'] = $IP . '/extensions/wikia/ProblemReports/SpecialProblemReports_body.php';
$wgSpecialPageGroups['ProblemReports'] = 'maintenance';

// setup rights
// -local actions
$wgAvailableRights[] = 'problemreports_action';
$wgGroupPermissions['sysop']['problemreports_action'] = true;

// -global actions
$wgAvailableRights[] = 'problemreports_global';
$wgGroupPermissions['staff']['problemreports_global'] = true;
$wgGroupPermissions['vstf']['problemreports_global'] = true;
$wgGroupPermissions['helper']['problemreports_global'] = true;

// extension setup (install hooks, load WikiaAPI modules)
function wfProblemReports()
{
	global $wgLogTypes, $wgLogNames, $wgLogActions, $wgLogHeaders, $wgProblemReportsEnable, $wgHooks, $wgServer;

	// add hooks & messages if problem reporting is enabled
	if (!empty($wgProblemReportsEnable)) {
		global $wgOut, $wgExtensionsPath, $wgStyleVersion;

		// add "Report a problem" link and return html of "Report a problem" dialog
		$wgHooks['SkinTemplateContentActions'][] = 'wfProblemReportsAddLink';
		$wgHooks['MakeGlobalVariablesScript'][] = 'wfProblemReportsSetupVars';
	}

	// setup for Special:Log
	$wgLogTypes[] = 'pr_rep_log';
	$wgLogHeaders['pr_rep_log'] = 'prlogheader';
	$wgLogNames['pr_rep_log']  = 'prlogtext';

	$wgLogNames['prl_rep']  = 'prlog_reported';
	$wgLogNames['prl_chn']  = 'prlog_changed';
	$wgLogNames['prl_typ']  = 'prlog_type';
	$wgLogNames['prl_fix']  = 'prlog_fixed';
	$wgLogNames['prl_rem']  = 'prlog_removed';
	$wgLogNames['prl_eml']  = 'prlog_emailed';

	$wgLogActions['pr_rep_log/prl_rep'] = 'prlog_reportedentry';
	$wgLogActions['pr_rep_log/prl_chn'] = 'prlog_changedentry';
	$wgLogActions['pr_rep_log/prl_typ'] = 'prlog_typeentry';
	$wgLogActions['pr_rep_log/prl_rem'] = 'prlog_removedentry';
	$wgLogActions['pr_rep_log/prl_eml'] = 'prlog_emailedentry';

	// set secret string for token generation
	global $wgProblemReportsSecret;
	$wgProblemReportsSecret = md5($wgServer . 'saltyWikiaSalt');

	// setup API module
	global $wgAutoloadClasses, $wgAPIListModules;

	$wgAutoloadClasses["WikiaApiQueryProblemReports"]  = "extensions/wikia/ProblemReports/WikiaApiQueryProblemReports.php";
	$wgAPIListModules["problemreports"] = "WikiaApiQueryProblemReports";

	// setup ajax interface wrapper
	global $wgAjaxExportList;

	$wgAjaxExportList[] = 'wfProblemReportsAjaxGetDialog';
	$wgAjaxExportList[] = 'wfProblemReportsAjaxAPI';
	$wgAjaxExportList[] = 'wfProblemReportsAjaxReport';

	// fixes #2791
	global $wgRequest;

	if ( ($wgRequest->getVal('rs') == 'WidgetFrameworkAjax') && ($wgRequest->getVal('actionType') == 'editform') ) {
		// load messages when creating widget editor form
		wfLoadExtensionMessages('ProblemReports');
	}
}

function wfProblemReportsSetupVars($vars) {

        $vars['pr_msg_exceeded'] = wfMsg('pr_msg_exceeded');
        $vars['pr_msg_exchead'] = wfMsg('pr_msg_exchead') ;

        return true;
}

$wgHooks['UserRename::Global'][] = "ProblemReportsUserRenameGlobal";

function ProblemReportsUserRenameGlobal( $dbw, $uid, $oldusername, $newusername, $process, &$tasks ) {
	$tasks[] = array(
		'table' => 'problem_reports',
		'username_column' => 'pr_reporter',
	);
	return true;
}
