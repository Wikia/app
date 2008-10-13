<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Dialog design and hooks for ProblemReports extension
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// add link to content actions array in skin
function wfProblemReportsAddLink(&$content_actions) {
	wfProfileIn(__METHOD__);

	// where are we? on article page?
	global $wgUser, $wgTitle, $wgOut, $wgRequest, $wgProblemReportsEnableAnonReports;

	// are we on page with editable content? (check taken from Monaco.php)
	$onContentPage = $wgTitle->exists() && $wgTitle->isContentPage() && !$wgTitle->isTalkPage() && $wgOut->isArticle();

	if (!$onContentPage) {
		wfDebug("ProblemReports: not a content page - leaving...\n");
		wfProfileOut(__METHOD__);
		return true;
	}

	// do nothing when anon users can't report problems
	if ( isset($wgProblemReportsEnableAnonReports) && $wgProblemReportsEnableAnonReports == false && $wgUser->isAnon() ) {
	    wfDebug("ProblemReports: anons can't add reports - leaving...\n");
	    wfProfileOut(__METHOD__);
	    return true;
	}

	wfDebug("ProblemReports: adding problem reports action tab & reporting dialog\n");

	// load messages
	wfLoadExtensionMessages( 'ProblemReports' );

	// add action tab in monobook
	$content_actions['report-problem'] = array(
		'class' => '',
		'text' => wfMsg('reportproblem'),
		'href' => '#' ,
	);

	wfProfileOut(__METHOD__);
	
	return true;
}
