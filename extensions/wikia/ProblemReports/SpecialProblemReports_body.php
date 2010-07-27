<?php

class SpecialProblemReports extends SpecialPage {
	var $problemTypes;
	var $problemColors;

	function SpecialProblemReports() {
		SpecialPage::SpecialPage( 'ProblemReports' );

		// load messages
		wfLoadExtensionMessages( 'ProblemReports' );

		// types of problems ...
		$this->problemTypes = array (
			wfMsg( 'pr_what_problem_spam_short' ),
			wfMsg( 'pr_what_problem_vandalised_short' ),
			wfMsg( 'pr_what_problem_incorrect_content_short' ),
			wfMsg( 'pr_what_problem_software_bug_short' ),
			wfMsg( 'pr_what_problem_other_short' ),
		);

		// ... and their colors
		$this->problemColors = array (
			'6B8E23',
			'DC143C',
			'483D8B',
			'87CEEB',
			'C0C0C0'
		);
	}

	// create feed (RSS/Atom) from given reports array
	function makeFeed( $type, &$reports ) {
		wfProfileIn( __METHOD__ );

		global $wgOut, $wgFeedClasses, $wgSitename, $wgServer;

		if ( isset( $wgFeedClasses[$type] ) )
		{
			$feed = new $wgFeedClasses[$type]
			(
				wfMsg( 'problemreports' ) . ' - ' . $wgSitename,
				'',
				Title::makeTitle( NS_SPECIAL, 'ProblemReports' )->escapeFullURL()
			);

			$feed->outHeader();

			foreach ( $reports as $problem )
			{
				$url = Title::makeTitle( NS_SPECIAL, 'ProblemReports/' . $problem['id'] )->escapeFullURL();

				// user / anon reporter page
				if ( !$problem['anon'] ) {
					$user_url = htmlspecialchars( Title::makeTitle( NS_USER, $problem['reporter'] )->escapeFullURL() );
				} else {
					$user_url = htmlspecialchars( Title::makeTitle( NS_SPECIAL, 'Contributions/' . $problem['ip'] )->escapeFullURL() );
					$problem['reporter'] .= ' (' . $problem['ip'] . ')';
				}

				$problemTitle = Title::newFromText( $problem['title'] )->getFullText();

				// format date
				$item = new FeedItem
				(
					$problemTitle . ' - ' . str_replace( 'http://', '', $problem['server'] ),
					'<a href="' . $user_url . '">' . htmlspecialchars( trim( $problem['reporter'] ) ) . '</a>: ' . wfMsg( 'pr_table_problem_type' ) . ' - ' . $this->problemTypes[$problem['type']] .
						$wgOut->parse( $problem['summary'] ),
					$url,
					$problem['date']
				);

				$feed->outItem( $item );
			}

			$feed->outFooter();

			wfProfileOut( __METHOD__ );

			return true;
		} else
		{
			wfProfileOut( __METHOD__ );
			return false;
		}
	}

	// sends emails from mailer form
	function handleMailer() {
		global $wgRequest, $wgUser, $wgOut, $wgServerName;

		// check user permission to send emails (RT #13150)
		if ( !WikiaApiQueryProblemReports::userCanDoActions() ) {
			$wgOut->showPermissionsErrorPage( array( 'permissionserrors' ) );
			return;
		}

		// maybe your email is empty
		if ( $wgUser->getEmail() == '' ) {
			$wgOut->showPermissionsErrorPage( array( 'mailnologintext' ) );
			return;
		}

		wfProfileIn( __METHOD__ );

		// get email params
		$params = array(
			'id'      => (int) $wgRequest->getVal( 'mailer-id' ),
			'subject' => $wgRequest->getVal( 'mailer-subject' ),
			'message' => $wgRequest->getVal( 'mailer-message' ),
			'cc'      => ( $wgRequest->getVal( 'mailer-ccme' ) == 'on' ) ? true : false,
		);

		// get problem report data from API
		$apiCall['wkid']    = $params['id'];
		$apiCall['wktoken'] = WikiaApiQueryProblemReports::getToken( $wgServerName );
		$apiCall['action']  = 'query';
		$apiCall['list']    = 'problemreports';

		// call API
		$FauxRequest = new FauxRequest( $apiCall );
		$api = new ApiMain( $FauxRequest );
		$api->execute();
		$data =& $api->GetResultData();

		$report = $data['query']['problemreports'][$params['id']];

		// add email headers to params
		$params['from'] = $wgUser->getEmail();
		$params['to']   = $report['email'];

		// parse message as it can contain {{templates}} and remove any HTML inside it
		$params['message'] = strip_tags( $wgOut->parse( $params['message'] ) );

		// send emails using UserMailer class
		wfDebug( 'ProblemReports: sending email to <' . $params['to'] . '> on behalf of <' . $params['from'] . ">\n" );

		// create MailAddress objects
		$to   = new MailAddress( $params['to'],   $report['reporter'] );
		$from = new MailAddress( $params['from'], $wgUser->getName() );

		// send email (at least try)
		$mailResult = UserMailer::send( $to, $from, $params['subject'], $params['message'], null, null, 'ProblemReport' );

		$success = !WikiError::isError( $mailResult );

		if ( $params['cc'] ) {
			// send me a copy
			wfDebug( "ProblemReports: sending copy to sender...\n" );
			$mailResult = UserMailer::send( $from, $from, $params['subject'], $params['message'], null, null, 'ProblemReport' );

			$success = !WikiError::isError( $mailResult ) && $success;
		}

		// log into Special:Log / Special:Recentchanges of given wiki
		if ( $success ) {
			global $wgDBname;

			$dbw =& wfGetDB( DB_MASTER );

			// switch to DB of wikia report was made from
			$dbw->selectDB( $report['db'] );

			// add the log entry for problem reports
			$log = new LogPage( 'pr_rep_log', true ); // true: also add entry to Special:Recentchanges

			$reportedTitle = Title::newFromText( $report['title'], $report['ns'] );

			$log->addEntry( 'prl_eml', $reportedTitle, '', array
			(
				$reportedTitle,
				$wgUser->getName(),
				$report['reporter'],
				$params['id']
			) );

			$dbw->immediateCommit();

			// return to current wiki DB
			$dbw->selectDB( $wgDBname );
		} else {
			wfDebug( 'ProblemReports: error sending email - ' . $mailResult->getMessage() . "\n" );
		}

		// finish...
		wfDebug( 'ProblemReports: sending email to <' . $params['to'] . '> - ' . ( $success ? 'sent!' : 'failed' ) . "\n" );

		wfProfileOut( __METHOD__ );

		// redirect with message
		if ( $success ) {
			$wgOut->redirect( Title::newFromText( 'ProblemReports/' . $params['id'], NS_SPECIAL )->getFullURL( 'success=1' ) );
		} else {
			$wgOut->redirect( Title::newFromText( 'ProblemReports/' . $params['id'], NS_SPECIAL )->getFullURL( 'success=0&msg=' . urlencode( $mailResult->getMessage() ) ) );
		}
	}

	static function makeEmailTitle( $city ) {
		global $wgSitename;

		$msg =  wfMsg( 'defemailsubject' );
		$citySitename = WikiaApiQueryProblemReports::getCitySitename( $city );
		$citySitename = str_replace( '"', "'", $citySitename );
		return str_replace( $wgSitename, $citySitename, $msg );
	}

	function buildSubtitleAndLocalURL( $title, $params ) {
		wfProfileIn( __METHOD__ );

		global $wgSitename, $wgRequest;

		$subtitle = '';
		$localUrl = '';

		$cityId = WikiaApiQueryProblemReports::getCityID();

		// show from this wikia only
		if ( isset( $params['wkwikia'] ) &&  $params['wkwikia'] > 0 && !isset( $params['wkshowall'] ) ) {
			$sitename = WikiaApiQueryProblemReports::getCitySitename( $params['wkwikia'] );
			$sitenameUrl = '<a href="' . $title->escapeLocalURL( 'city=' . $params['wkwikia'] ) . '">' . $sitename . '</a>';
			$subtitle .= wfMsg( 'pr_reports_from', $sitenameUrl );
			$localUrl  .= '&city=' . $params['wkwikia'];
		}
		else {
			$sitenameUrl = '<a href="' . $title->escapeLocalURL( 'city=' . $cityId ) . '" title="' . wfMsg( 'pr_raports_from_this_wikia' ) . '">' . $wgSitename . '</a>'
			$subtitle .= wfMsg( 'pr_reports_from', $sitenameUrl );
			$localUrl  .= '&city=' . $cityId;
		}

		// problem type
		if ( isset( $params['wktype'] ) && $params['wktype'] > -1 ) {
			$localUrl .= '&problem=' . $params['wktype'];
		}

		// language filter
		if ( !empty( $params['wklang'] ) ) {
			$localUrl .= '&lang=' . $params['wklang'];
		}

		// show all?
		if ( isset( $params['wkshowall'] ) ) {
		    $localUrl .= '&showall=1';
		} else {
			$subtitle .= ' | <a href="' . $title->escapeLocalURL( 'showall=1' . $localUrl ) . '">' . wfMsg( 'pr_view_all' ) . '</a>';
		}

		// show archived
		if ( !isset( $params['wkarchived'] ) ) {
			$subtitle .= ' | <a href="' . $title->escapeLocalURL( 'archived=1' . $localUrl ) . '">' . wfMsg( 'pr_view_archive' ) . '</a>';
		} else {
			$localUrl .= '&archived=1';
		}

		// show problems which need staff help
		if ( !isset( $params['wkstaff'] ) ) {
			$subtitle .= ' | <a href="' . $title->escapeLocalURL( 'staff=1' . $localUrl ) . '">' . wfMsg( 'pr_view_staff' ) . '</a>';
		} else {
			$localUrl .= '&staff=1';
		}

		// RSS link
		$subtitle .= ' | <a href="' . htmlspecialchars( $wgRequest->appendQuery( 'feed=rss' ) ) . '">RSS</a>';


		// link to Special:Log/pr_rep_log
		if ( ( isset( $params['wkwikia'] ) &&  $cityId != $params['wkwikia'] ) && !$params['wkshowall'] ) {
			$host = WikiaApiQueryProblemReports::getCityURL( $params['wkwikia']  );
		} else {
			$host = '';
		}

		$subtitle .= ' | <a href="' . $host . Title::newFromText( 'Log', NS_SPECIAL )->escapeLocalURL() . '/pr_rep_log">' . wfMsg( 'log' ) . '</a>';

		wfProfileOut( __METHOD__ );

		return array( $subtitle, $localUrl );
	}

	function buildProblemsSelector( $title, $params ) {
		wfProfileIn( __METHOD__ );

		// URL parameters we're using
		$url_params =  'showall=' . ( isset( $params['wkshowall'] ) ? 1 : 0 ) .
			'&archived=' . ( isset( $params['wkarchived'] ) ? 1 : 0 ) .
			'&staff=' . ( isset( $params['wkstaff'] ) ? 1 : 0 ) .
			( isset( $params['wkwikia'] ) ? '&city=' . $params['wkwikia'] : '' ) .
			( !empty( $params['wklang'] ) ? '&lang=' . $params['wklang'] : '' );

		// build HTML
		$problems_selector = '<div><span style="float: left">' . wfMsg( 'pr_table_problem_type' ) . "\n\n" . '</span><dl class="problemReportsCategoriesLegend">';

		foreach ( $this->problemTypes as $id => $problemType )
		{
			$problems_selector .= "\n\t" . '<dt style="background-color: #' . $this->problemColors[$id] . '"></dt>' .
				"\n\t\t" . '<dd><a href="' . $title->escapeLocalURL( $url_params . '&problem=' . $id ) .
				'">' . htmlspecialchars( $problemType ) . '</a></dd>';
		}

		// add "unfilter" link (#2489)
		$problems_selector .= '<dt style="border: solid 1px #000; margin-left: 20px"></dt>' .
			'<dd><a href="' . $title->escapeLocalURL( $url_params ) . '">' . wfMsg( 'pr_what_problem_unselect' ) . '</a></dd>';

		$problems_selector .= "\n</dl></div>\n\n";

		wfProfileOut( __METHOD__ );

		return $problems_selector;
	}

	function getProblemLog( $report ) {
		wfProfileIn( __METHOD__ );

		global $wgDBname, $wgOut, $wgUser;

		$dbr =& wfGetDB( DB_SLAVE );

		// switch to DB of wikia report was made from
		$dbr->selectDB( $report['db'] );

		// setup classes for log
		$loglist = new LogEventsList( $wgUser->getSkin(), $wgOut );
		$pager = new LogPager( $loglist, 'pr_rep_log' );

		// show logs only for given report
		$pager->mConds[] = "log_params LIKE '%\n{$report['id']}%'";

		// get logs
		$logs = $pager->getBody();

		// switch back to our DB
		$dbr->selectDB( $wgDBname );

		wfProfileOut( __METHOD__ );

		return $logs;
	}

	function execute( $par ) {
		wfProfileIn( __METHOD__ );

		global $wgOut, $wgRequest, $wgServer, $wgServerName, $wgLang, $wgTitle, $wgCityId, $wgHooks, $wgStylePath, $wgStyleVersion, $wgExtensionsPath, $wgUser;

		$this->setHeaders();

		// perform actions related to emailing from report subpage
		if ( $par == 'mailer' )  {
			wfProfileOut( __METHOD__ );
			return $this->handleMailer();
		}

		// add CSS (from static file)
		$wgOut->addScript(
			'<link rel="stylesheet" type="text/css" href="' . $wgExtensionsPath . '/wikia/ProblemReports/css/SpecialProblemReports.css?' . $wgStyleVersion . '" />' .
			"\n\t\t" . '<!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="' . $wgExtensionsPath . '/wikia/ProblemReports/css/SpecialProblemReports.ieFixes.css?' . $wgStyleVersion . '" /><![endif]-->' .
			"\n\t\t" . '<script type="text/javascript" src="' . $wgExtensionsPath . '/wikia/ProblemReports/js/SpecialProblemReports.js?' . $wgStyleVersion . '" ></script>' .
			"\n"
		);

		// should we show just problem reports with given ID?
		$showProblemReportID = isset( $par ) && is_numeric( $par ) ? (int) $par : false;

		if ( $showProblemReportID ) {
			$params = array(
				'wkid'     => $showProblemReportID,
				'wkoffset' => 0,
				'wklimit'  => 1,
				'wktoken'  => WikiaApiQueryProblemReports::getToken( $wgServerName )
			);
		} else {
			// create params table from request variables
			$params = array(
				'wklimit'   => intval( $wgRequest->getVal( 'limit' ) )  ? $wgRequest->getVal( 'limit' ) : 25,
				'wkoffset'  => intval( $wgRequest->getVal( 'offset' ) ) ? $wgRequest->getVal( 'offset' ) : 0,
				'wkwikia'   => intval( $wgRequest->getVal( 'city' ) )   ? $wgRequest->getVal( 'city' ) : NULL,

				// allow only helpers/janitors/staff to view&edit problems across wikis (#1970)
				'wkshowall' => $wgRequest->getVal( 'showall' ) == 1 ? 1 : NULL,
				'wktype'    => $wgRequest->getVal( 'problem' ) > -1 ? $wgRequest->getVal( 'problem' ) : NULL,
				'wkstaff'   => $wgRequest->getVal( 'staff' ) == 1 ? 1 : NULL,
				'wkarchived' => ( $wgRequest->getVal( 'archived' ) > 0 && $wgRequest->getVal( 'staff' ) != 1 ) ? 1 : NULL,

				// token is used to grab emails (by default API doesn't return them)
				'wktoken' =>  WikiaApiQueryProblemReports::getToken( $wgServerName ),

				// filter by language
				'wklang'  => $wgRequest->getVal( 'lang' ) != '' ? $wgRequest->getVal( 'lang' ) : NULL
			);
		}

		// send API request to get reports list
		//
		$apiCall = $params;
		$apiCall['action'] = 'query';
		$apiCall['list'] = 'problemreports';

		$FauxRequest = new FauxRequest( $apiCall );

		$api = new ApiMain( $FauxRequest );
		$api->execute();
		$data =& $api->GetResultData();

		// results
		//
		$count   = intval( $data['query']['reports'] );
		$reports = $data['query']['problemreports'];

		// create RSS feed icon for special page
		//
		$wgOut->setSyndicated( true );

		// make feed (RSS/Atom) if requested
		if ( $wgRequest->getVal( 'feed' ) != '' ) {
			return $this->makeFeed( $wgRequest->getVal( 'feed' ), $reports );
		}

		$title = Title::makeTitle( NS_SPECIAL, 'ProblemReports' );
		$localUrl = '';

		// build subtitle and local url
		//
		list( $subtitle, $localUrl ) = $this->buildSubtitleAndLocalURL( $title, $params );

		// count all problem reports in current view
		$subtitle = wfMsg( 'pr_total_number' ) . ': ' . number_format( $count, 0, ' ', ' ' ) . '<br />' . $subtitle;

		// problems selector
		//
		$problems_selector = $this->buildProblemsSelector( $title, $params );

		// pager
		//
		global $wgContLang;

		$pager = wfViewPrevNext(
		    $params['wkoffset'],
		    $params['wklimit'],
		    $wgContLang->specialpage( 'ProblemReports' ),
		    trim( $localUrl, '&' ),
		    $count < ( $params['wklimit'] + $params['wkoffset'] + 1 )
		);

		// action icons (for sysops / staff / janitors / helpers only)
		//
		$action_icons = array(
			1 => 'problemReportsActionFixed',
			2 => 'problemReportsActionNotAProblem',
			3 => 'problemReportsActionNeedStaffHelp',
			10 => 'problemReportsActionRemove',
			0 => 'problemReportsActionUndo'
		);

		// can we "do actions" - send emails, mark reports...?
		//
		$can_do_actions = isset( $params['wkshowall'] ) ? WikiaApiQueryProblemReports::userCanDoCrossWikiActions() : WikiaApiQueryProblemReports::userCanDoActions();

		// messages for table header row (<th> elements)
		//
		$th = array (
			'pr_table_problem_id', 'pr_table_wiki_name', 'pr_table_problem_type', 'pr_table_page_link', 'pr_table_date_submitted',
			'pr_table_reporter_name', /* 'pr_table_comments', */ 'pr_table_status', 'pr_table_actions'
		);

		// remove actions column if user can't "action" reports
		if ( !$can_do_actions ) {
			array_pop( $th );
		}

		// set page subtitle
		//
		if ( !$showProblemReportID ) {
		    $wgOut->setSubtitle( $subtitle );
		} else {
			$subtitle = wfMsg( 'pr_total_number' ) . ': ' . number_format( $count, 0, ' ', ' ' ) . ' | ';
			$subtitle .= '<a href="' . $title->escapeLocalURL() . '">' . wfMsg( 'pr_view_all' ) . '</a>';
			$subtitle .= ' | <a href="' . $reports[$showProblemReportID]['server'] . Title::newFromText( 'Log', NS_SPECIAL )->escapeLocalURL() . '/pr_rep_log">' . wfMsg( 'log' ) . '</a>';

			$wgOut->setPageTitle( wfMsg( 'problemreports' ) . ' - #' . $showProblemReportID );
			$wgOut->setSubtitle( $subtitle );
		}


		// get log of actions with given report ID
		//
		if ( ( $showProblemReportID > 0 ) &&  $can_do_actions && isset( $reports[$showProblemReportID] ) ) {
		    $logs = $this->getProblemLog( $reports[$showProblemReportID] );
		} else {
			$logs = false;
		}


		// so we're done ;)
		//
		if ( count( $reports ) == 0 ) {
		    $wgOut->addHTML( '<h3>' . wfMsg( 'pr_no_reports' ) . '</h3>' );
		}
		else {
			// render template
			//
			$tpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

			$mailer_success = $wgRequest->getVal( 'success' );

			$tpl->set_vars( array (
				'can_do_actions'    	=> $can_do_actions,
				'can_do_actions_cross'	=> WikiaApiQueryProblemReports::userCanDoCrossWikiActions(),
				'can_do_actions_here'	=> WikiaApiQueryProblemReports::userCanDoActions(),

				'can_remove'		=> WikiaApiQueryProblemReports::userCanRemove(),
				'isStaff'           	=> WikiaApiQueryProblemReports::isStaff(),
				'userGroups'        	=> $wgUser->getGroups(),

				'th'			=> $th,
				'colors'		=> $this->problemColors,
				'problemTypes'		=> $this->problemTypes,

				'action_icons'		=> $action_icons,

				'pager' 		=> $showProblemReportID ? '' : $pager,
				'problems_selector' 	=> $showProblemReportID ? '' : $problems_selector,
				'reports' 		=> $reports,
				'count'			=> $count,
				'showall'           	=> isset( $params['wkshowall'] ) ? 1 : 0,
				'single_report' 	=> is_numeric( $showProblemReportID ),

				'show_mailer'       	=> $can_do_actions && ( $showProblemReportID > 0 ),
				'mailer_from'       	=> $wgUser->getName() . ' <' . $wgUser->getEmail() . '>',
				'mailer_result'     	=> is_numeric( $mailer_success ) ? ( $mailer_success ? wfMsg( 'emailsent' ) : wfMsg( 'usermailererror' )  ) : false,
				'mailer_message'	=> $wgRequest->getVal( 'msg' ),

				'logs'			=> $logs,

				'is_readonly'		=> wfReadOnly(),
				'is_blocked'	=>	$wgUser->isBlocked()
			) );

			$wgOut->addHTML( $tpl->execute( 'reports_list' ) );
		}

		wfProfileOut( __METHOD__ );

		return;
	}
}
