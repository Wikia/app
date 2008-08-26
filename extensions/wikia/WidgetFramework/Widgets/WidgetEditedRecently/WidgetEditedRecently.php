<?php
/**
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetEditedRecently'] = array(
	'callback' => 'WidgetEditedRecently',
	'title' => array(
		'en' => 'Recently edited by',
		'pl' => 'Ostatnio zmieniane przez'
	),
	'desc' => array(
		'en' => 'Displays a list of recent editors for any article you visit',
		'pl' => 'Lista ostatnich edytorów tej strony'
    ),
    	'params' => array(
		'limit' => array(
			'type' => 'text',
			'default' => 5
		),
	),
    'closeable' => true,
    'editable' => true,
);

function WidgetEditedRecently($id, $params) {
    	wfProfileIn( __METHOD__ );
    	global $wgTitle, $wgRequest;

	if ( (!is_object($wgTitle) || ($wgTitle->mArticleID == -1)) && ($wgRequest->getVal('actionType') == 'add') ) {
		// ask for page refresh
		return wfMsg('refreshpage') . '<br /><br /><button onclick="window.location.reload()">' . wfMsg('go') . '</button>';
	}

	$limit = intval($params['limit']);
	$limit = ($limit <=0 || $limit > 50) ? 15 : $limit;

	$title = ( ($wgTitle->getNamespace() != NS_MAIN) ? ($wgTitle->getNsText().':') : '' ) . $wgTitle->getText();

	$res = WidgetFrameworkCallAPI(array(
		'action' => 'query',
		'prop' => 'revisions',
		'titles' => $title,
		'rvprop' => 'user',
		'rvlimit' =>  $limit
	));

	// create list of recent contributors
	$items = array();

	if( !empty($res['query']['pages']) ) {

	    $contribs = array_shift($res['query']['pages']);

	    if ( !empty($contribs['revisions']) ) {
		foreach ($contribs['revisions'] as $contrib) {
		    $is_anon = isset($contrib['anon']);

		    // don't show anon edits - requested by JohnQ
		    if ($is_anon)
			continue;

		    $author = $contrib['user'];

		    if ($is_anon) {
			$link = Title::newFromText( 'Contributions/'.$author, NS_SPECIAL );
		    }
		    else {
			$link = Title::newFromText( $author , NS_USER );
		    }

		    $items[$author] = array('href' => $link->getLocalURL(), 'name' => $author);
		}
	    }
	}

	wfProfileOut( __METHOD__ );

	if ( count($items) > 0 ) {
	    return WidgetFrameworkWrapLinks($items) . WidgetFrameworkMoreLink( $wgTitle->getLocalURL('action=history') );
	}
	else {
	    return wfMsg('nocontributors');
	}

}
