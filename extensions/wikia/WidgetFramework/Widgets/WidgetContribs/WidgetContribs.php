<?php
/**
 * @author Lucas 'TOR' Garczewski <tor@wikia-inc.com>
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetContribs'] = array(
	'callback' => 'WidgetContribs',
	'title' => array(
		'en' => 'Contributions',
		'pl' => 'Wkład'
	),
	'desc' => array(
		'en' => 'Handy way to view your contributions', 
		'pl' => 'Pomocna lista ostatnich edycji'
	),
	'closeable' => true,
	'editable' => false,
);

function WidgetContribs($id, $params) {
	wfProfileIn(__METHOD__);

	global $wgUser;

	// get last edits from API
	$results = WidgetFrameworkCallAPI(array
	(
		'action'	=> 'query',
		'list'		=> 'usercontribs',
		'ucuser'	=> $wgUser->getName(),
		'uclimit'	=> 10
	));

	$ret = '';

	if ( !empty($results['query']['usercontribs']) ) {
	
	    $list = array();
	
	    foreach($results['query']['usercontribs'] as $contrib) {
		$title = Title::newFromText( $contrib['title'], $contrib['ns'] );

		$list[] = array
		(
		    'href'  => $title->getLocalURL(), 
		    'name'  => $contrib['title']
		);
	    }
	    
	    $ret = WidgetFrameworkWrapLinks($list);
	}
	else {
	    $ret = wfMsg('nocontribs');
	}

	// 'more' link...
	$more = Title::newFromText('Contributions/' . $wgUser->getName(), NS_SPECIAL)->getLocalURL();

	$ret .= WidgetFrameworkMoreLink($more);

	wfProfileOut(__METHOD__);

	return  $ret;
}
