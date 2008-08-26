<?php
if (!defined('MEDIAWIKI')) die();
/**
 * AJAX callbacks for ProblemReports
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Maciej Brencz <macbre@wikia.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */


// AJAX callback for sending problem reports dialog
function wfProblemReportsAjaxGetDialog($ns, $title)
{
	wfProfileIn(__METHOD__);

	global $wgUser, $wgOut;

	// load extension messages
   	wfLoadExtensionMessages( 'ProblemReports' );
    
	// use template
	$tpl = new EasyTemplate( dirname( __FILE__ )."/templates/" );
	
	$tpl->set_vars(array
	(
		'user'				=> & $wgUser,
		'url'				=> '',
		'pageTitle'			=> htmlspecialchars($title),
		'pageNamespace'			=> (int) $ns,
		'introductoryText'		=> $wgOut->parse(wfMsg('pr_introductory_text')),
		'what_problem_options' 		=> array('pr_what_problem_spam', 'pr_what_problem_vandalised','pr_what_problem_incorrect_content', 
					    		'pr_what_problem_software_bug', 'pr_what_problem_other')
	));

	// create AJAX response
	$response = new AjaxResponse( $tpl->execute('add_report') );
	$response->setContentType('text/plain; charset=utf-8');

	wfProfileOut(__METHOD__);
    
	return $response;
}


// AJAX callback for reporting a problem
function wfProblemReportsAjaxReport() {
		
	wfProfileIn(__METHOD__);
	
	global $wgOut, $wgRequest, $wgUser;

	// load extension messages
	wfLoadExtensionMessages( 'ProblemReports' );

	// parse request	
	$params = array (
		// get data from form fields
		'ns'       => (int) $wgRequest->getVal('pr_ns'),
		'title'    => urldecode( $wgRequest->getVal('pr_title') ),
		'cat'      => (int) $wgRequest->getVal('pr_cat'),
		'summary'  => urldecode( $wgRequest->getVal('pr_summary') ),
		'reporter' => urldecode( trim( $wgRequest->getVal('pr_reporter') ) ),
		'email'    => urldecode( trim( $wgRequest->getVal('pr_email') ) ),
		'browser'  => urldecode( $wgRequest->getVal('pr_browser') ),
	);
	
	// assume request is valid - required fields are filled
	$isRequestValid = true;
	$requestErrorMessages = '';
	
	// check for spam in report summary
	$isSpam = WikiaApiQueryProblemReports::checkForSpam($params['summary']);
	
	// check for empty problem description
	$isSummaryEmpty = trim($params['summary']) == '';
	
	// check for "empty" problem type (== '-')
	$isCatEmpty = !is_numeric($wgRequest->getVal('pr_cat'));
	
	// check for empty (not valid) email address
	$isEmailEmpty = !User::isValidEmailAddr($params['email']);
	
	
	// validate request
	if ($isSummaryEmpty) {
		$requestErrorMessages .= '<li>'.wfMsg('pr_empty_summary')."</li>\n";
		$isRequestValid = false;
	}
	
	if ($isSpam) {
		$requestErrorMessages .= '<li>'.wfMsg('pr_spam_found')."</li>\n";
		$isRequestValid = false;
	}

	if ($isCatEmpty) {
		$requestErrorMessages .= '<li>'.wfMsg('pr_what_problem_select')."</li>\n";
		$isRequestValid = false;
	}
	
	if ( $isEmailEmpty && $wgUser->isAnon() ) {
		$requestErrorMessages .= '<li>'.wfMsg('pr_empty_email')."</li>\n";
		$isRequestValid = false;
	}

	// #2821
	if ($wgUser->isBlocked()) {
		$isRequestValid = false;
	}
	
	
	if ($isRequestValid) {
		// send API request to add report
		$FauxRequest = new FauxRequest(array
		(
			'action'	=> 'insert',
			'list'	=> 'problemreports',
			
			'wktype'	=> $params['cat'],
			'wkns'	=> $params['ns'],
			'wktitle'	=> $params['title'],
			'wksummary'	=> $params['summary'],
			'wkreporter'=> $params['reporter'],
			'wkemail'	=> $params['email'],
			'wkbrowser'     => $params['browser'],
			
			'wktoken'   => WikiaApiQueryProblemReports::getToken($params['title'])
		));
		
		$api = new ApiMain($FauxRequest);
		$api->execute();
		$data =& $api->GetResultData();
		
		//print_pre($results);
		
		$id = intval($data['results']['report']['id']);
		
		$response = array
		(
			'valid'     => 1,
			'success'   => ($id > 0 ? 1 : 0),
			'caption'   => wfMsg('reportproblem'),
			'msg'       => $wgOut->parse(wfMsg( $id > 0 ?  'pr_thank_you' : 'pr_thank_you_error', $id)),
			'report_id' => $id
		);
	}
	else {
		// send error message and highlight invalid fields in problem report dialog
		$response = array
		(
		'valid'          => 0,
		'email_empty'    => $isEmailEmpty ? 1 : 0,
		'summary_empty'  => $isSummaryEmpty ? 1 : 0,
		'cat_empty'      => $isCatEmpty ? 1 : 0,
		'spam'           => $isSpam ? 1 : 0,
		'caption'        => wfMsg('reportproblem'),
		'msg'            => '<ul style="margin-left: 25px; list-style: none">'.$requestErrorMessages.'</ul>'
		);
	}			

	// return JSON encoded array
	$response = new AjaxResponse( Wikia::json_encode($response) );
	$response->setContentType('text/plain; charset=utf-8');

	wfProfileOut(__METHOD__);
	
	return $response;
}


// AJAX callback for updating problem reports
function wfProblemReportsAjaxAPI() {

	wfProfileIn(__METHOD__);

	global $wgRequest;
	
	// check whether user can do anything with problems
	if ( !WikiaApiQueryProblemReports::userCanDoActions() ) {
		wfProfileOut(__METHOD__);
		return '{success: 0, text: "error (please login)"}'; // logout fallback
	}

	// load extension messages
        wfLoadExtensionMessages( 'ProblemReports' );
	
	// parse query parameters
	$params = array (
		'id'       => (int) $wgRequest->getVal('id'),
		'type'     => ($wgRequest->getVal('type') != '')   ? (int) $wgRequest->getVal('type')   : NULL,
		'status'   => ($wgRequest->getVal('status') != '') ? (int) $wgRequest->getVal('status') : NULL
	);
	
	// update / remove report
	$FauxRequest = new FauxRequest(array
	(
		'action'	=> ($params['status'] != 10) ? 'update' : 'delete',
		'list'		=> 'problemreports',

		'wkstatus'	=> $params['status'],
		'wktype'    => $params['type'],
		'wkreport'	=> $params['id'],
		
		'wktoken'   => WikiaApiQueryProblemReports::getToken($params['id'])
	));

	// send API query
	$api = new ApiMain($FauxRequest);
	$api->execute();
	$data =& $api->GetResultData();
	
	$success = is_numeric($data['results']['report']['id']);

	if ( !empty($params['type']) ) {
		$response = array('success' => $success ? 1 : 0);
	}
	else {
		$response = array
		(
			'success'   => ($success ? 1 : 0),
			'text'      => wfMsg('pr_status_'.$params['status']),
			'reportID'  => $params['id'],
			'status'    => $params['status']
		);
	}
	
	// our response
	$response = new AjaxResponse( Wikia::json_encode($response) );
	$response->setContentType('text/plain; charset=utf-8');

	wfProfileOut(__METHOD__);

	return $response;
}
