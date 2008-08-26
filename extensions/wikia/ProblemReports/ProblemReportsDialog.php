<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Dialog design and hooks for ProblemReports extension
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Maciej Brencz <macbre@wikia.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// add link to content actions array in skin
function wfProblemReportsAddLink(&$content_actions)
{
	wfProfileIn(__METHOD__);

	// where are we? on article page?
	global $wgUser, $wgTitle, $wgRequest, $wgProblemReportsEnableAnonReports;

	// do nothing when anon users can't report problems or
	// we're not on article page (main namespace) or we're on printable page version
	if (
	     ( $wgUser->isAnon() && empty($wgProblemReportsEnableAnonReports) ) ||
	     ( $wgTitle->getNamespace() != 0 ) ||
	     ( $wgRequest->getVal('printable') != '' )
	   )
	{

	    wfDebug("ProblemReports: leaving without adding dialog\n".
	            'ProblemReportsEnableAnonReports: '.($wgProblemReportsEnableAnonReports ? 'yes' : 'no')."\n");

	    wfProfileOut(__METHOD__);
	    return true;
	}

	wfDebug("ProblemReports: adding problem reports action tab & reporting dialog\n");

	// load messages
	wfLoadExtensionMessages( 'ProblemReports' );

	$content_actions['report-problem'] = array
	(
		'class' => '',
		'text' => wfMsg('reportproblem'),
		'href' => '#' ,
	);

	wfProfileOut(__METHOD__);
	
	return true;
}
