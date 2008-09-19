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
  create table problem_reports (
    pr_id int not null auto_increment primary key,
    pr_cat varchar(32) not null,
    pr_summary varchar(512),
    pr_ns int not null,
    pr_title varchar(255) not null,
    pr_city_id int,
    pr_server varchar(128),
    pr_anon_reporter int(1),
    pr_reporter varchar(128),
    pr_ip int(32) unsigned not null,
    pr_email varchar(128),
    pr_browser varhar(256),
    pr_date datetime not null,
    pr_status int(8)
 );
  *
  
  settings:
  
  $wgProblemReportsEnable (boolean)		// turn on "ProblemReports" extension
  $wgProblemReportsEnableAnonReports (boolean)	// allow anons to report a problems
  
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'ProblemReports',
	'url' => 'http://help.wikia.com/wiki/Help:ProblemReports',
	'version' => '2.3',
	'description' => 'Allows users to report problems with wiki-articles and helpers/sysops/janitors/staff to view & resolve them',
	'author' => '[http://pl.wikia.com/wiki/User:Macbre Maciej Brencz]'
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

// extension setup (install hooks, load WikiaAPI modules)
function wfProblemReports()
{
	global $wgLogTypes, $wgLogNames, $wgLogActions, $wgLogHeaders, $wgProblemReportsEnable, $wgHooks, $wgServer;
	
	// add hooks & messages if problem reporting is enabled
	if (!empty($wgProblemReportsEnable)) {
		global $wgOut, $wgExtensionsPath, $wgStyleVersion;
	
		// add "Report a problem" link and return html of "Report a problem" dialog
		$wgHooks['SkinTemplateContentActions'][] = 'wfProblemReportsAddLink';
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
	global $wgAutoloadClasses, $wgApiQueryListModules;
	
	$wgAutoloadClasses["WikiaApiQueryProblemReports"]  = "extensions/wikia/ProblemReports/WikiaApiQueryProblemReports.php";
	$wgApiQueryListModules["problemreports"] = "WikiaApiQueryProblemReports";

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
