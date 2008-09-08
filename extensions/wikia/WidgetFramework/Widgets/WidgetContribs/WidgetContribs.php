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
	'params' => array(
		'limit' => array(
			'type'    => 'text',
			'default' => 10,
			'msg' => 'widget-contribs-limit'
		)
        ),
	'closeable' => true,
	'editable' => true,
);

function WidgetContribs($id, $params) {
	wfProfileIn(__METHOD__);

	global $wgUser;

	// limit amount of messages
	$limit = intval($params['limit']);
	$limit = ($limit <=0 || $limit > 50) ? 10 : $limit;

	// get last edits from API
	$results = WidgetFrameworkCallAPI(array
	(
		'action'	=> 'query',
		'list'		=> 'usercontribs',
		'ucuser'	=> $wgUser->getName(),
		'uclimit'	=> $limit
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

		// 'more' link...
		$more = Title::newFromText('Contributions/' . $wgUser->getName(), NS_SPECIAL)->getLocalURL();
		$ret .= WidgetFrameworkMoreLink($more);
	}
	else {
	    $ret = wfMsg('widget-contribs-empty');
	}

	wfProfileOut(__METHOD__);

	return  $ret;
}
