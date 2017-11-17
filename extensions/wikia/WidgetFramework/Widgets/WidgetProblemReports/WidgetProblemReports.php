<?php
/**
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetProblemReports'] = array(
	'callback' => 'WidgetProblemReports',
	'title' => 'widget-title-problemreports',
	'desc' => 'widget-desc-problemreports',
    	'params' => array(
		'limit' => array(
			'type' => 'text',
			'default' => 25
		),
		'show' => array(
			'type' => 'select',
			'values' => array
			(
			    0 => wfMsg('pr_view_all'),
			    1 => wfMsg('pr_view_archive'),
			    2 => wfMsg('pr_view_staff')
			),
			'default' => 0
		),
		'pr_table_problem_type' => array(
		    'type' => 'select',
		    'values' => array(
			-1 => wfMsg('pr_view_all'),
			0  => wfMsg('pr_what_problem_spam_short'),
			1  => wfMsg('pr_what_problem_vandalised_short'),
			2  => wfMsg('pr_what_problem_incorrect_content_short'),
			3  => wfMsg('pr_what_problem_software_bug_short'),
			4  => wfMsg('pr_what_problem_other_short')
		    ),
		    'default' => -1
		),
		'pr_raports_from_this_wikia' => array(
		    'type'    => 'checkbox',
		    'default' => 1
		)
	),
    'closeable' => true,
    'editable' => true,
);



function WidgetProblemReports($id, $params) {

    // check whether ProblemReports extension is enabled on this wiki
    global $wgProblemReportsEnable;

    if (!isset($wgProblemReportsEnable) || !$wgProblemReportsEnable) {
	    return '<em>Extension ProblemReports not enabled on this wiki</em>';	// fallback message
    }

    $params['limit'] = intval($params['limit']);

    $apiParams = array (
	'wkshowall'  => ( ($params['pr_raports_from_this_wikia'] == 0) && WikiaApiQueryProblemReports::userCanDoActions() ) ? 1 : NULL,
	'wktype'     => (intval($params['pr_table_problem_type']) >= 0) ? intval($params['pr_table_problem_type']) : NULL,
	'wkstaff'    => ($params['show'] == 2) ? 1 : NULL,
	'wkarchived' => ($params['show'] == 1) ? 1 : NULL,

	'wklimit'    => ($params['limit'] <= 0 || $params['limit'] > 50) ? 25 : $params['limit']
    );

    $apiParams['action'] = 'query';
    $apiParams['list']   = 'problemreports';

    //print_pre($apiParams);

    $data = WidgetFramework::callAPI( $apiParams );

    $count = intval($data['query']['reports']);

    if ($count == 0) {
	return array( 'title' => wfMsg('problemreports'), 'body' => wfMsg('pr_no_reports') );
    }

    $reports = $data['query']['problemreports'];

    $problemTypes = array (
	wfMsg('pr_what_problem_spam_short'),
	wfMsg('pr_what_problem_vandalised_short'),
	wfMsg('pr_what_problem_incorrect_content_short'),
	wfMsg('pr_what_problem_software_bug_short'),
	wfMsg('pr_what_problem_other_short'),
    );

    // list reports
    $items = array();

	//url used for linking to PR ids
    $baseUrl = Title::newFromText('ProblemReports', NS_SPECIAL)->getLocalURL();

	// build params for 'more' link based on this widget's settings
	$urlParams = array();

	if($params['show'] == 2)
	{
		$urlParams[] = 'staff=1';
	}
	elseif($params['show'] == 1)
	{
		$urlParams[] = 'archived=1';
	}

	if($apiParams['wkshowall'] == 1)
	{
		$urlParams[] = 'showall=1';
	}

	if($apiParams['wktype'] != NULL)
	{
		$urlParams[] = 'problem=' . $apiParams['wktype'];
	}

	// smush
	$urlParams = implode('&', $urlParams);

	// apply and build
    $moreUrl = Title::newFromText('ProblemReports', NS_SPECIAL)->getLocalURL($urlParams);

    foreach ( $reports as $problem ) {
    	$date = date('d m Y', strtotime($problem['date']));

	$items[] = array(
	    'href'  => $baseUrl.'/'.$problem['id'],
	    'title' => '#'.$problem['id'].' - '.wfMsg('pr_table_date_submitted'). ': ' . $date,
	    'name' => wfShortenText($problem['title'], 25 ) . ' ['.$problemTypes[$problem['type']].
		($apiParams['wkshowall'] == 1 ? ' | '.str_replace(array('http://', 'https://', '.wikia.com', '.wikia-inc.com'), '', $problem['server']) : '').']'
	);
    }

    return array('title' => wfMsg('problemreports') . ' (' . $count . ')',
                 'body' => WidgetFramework::wrapLinks($items) . WidgetFramework::moreLink($moreUrl) );
}
