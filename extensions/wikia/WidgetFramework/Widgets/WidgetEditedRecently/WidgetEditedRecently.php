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
	'title' => 'widget-title-editedrecently',
	'desc' => 'widget-desc-editedrecently',
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
		wfProfileOut( __METHOD__ );
		return wfMsg('refreshpage') . '<br /><br /><button onclick="window.location.reload()">' . wfMsg('go') . '</button>';
	}

	$limit = intval($params['limit']);
	$limit = ($limit <=0 || $limit > 50) ? 15 : $limit;

	$title = ( ($wgTitle->getNamespace() != NS_MAIN) ? ($wgTitle->getNsText().':') : '' ) . $wgTitle->getText();

	$res = WidgetFramework::callAPI(array(
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
				$author = $contrib['user'];

				if ($is_anon) {
					// don't show anon edits - requested by JohnQ
					continue;
				} else {
					$oUser = User::newFromName( $author );
					if ( ( $oUser instanceof User ) &&
						 ( !$oUser->isBlocked( true, false ) )
					) {
						$userPage = $oUser->getUserPage();
						if ( ($userPage instanceof Title) && ($userPage->exists()) ) {
							$items[$author] = array('href' => $userPage->getLocalURL(), 'name' => $author);
						}
					}
				}
			}
	    }
	}

	wfProfileOut( __METHOD__ );

	if ( count($items) > 0 ) {
	    return WidgetFramework::wrapLinks($items) . WidgetFramework::moreLink( $wgTitle->getLocalURL('action=history') );
	}
	else {
	    return wfMsg('nocontributors');
	}

}
