<?php
/**
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetAncientPages'] = array(
	'callback' => 'WidgetAncientPages',
	'title' => array(
		'en' => 'Stale pages',
		'pl' => 'Najstarsze strony'
	),
	'desc' => array(
		'en' => 'See a list of pages that have not been edited in a long time', 
		'pl' => 'Lista stron nieedytowanych przez dłuższy czas'
    ),
	'params' => array(
		'limit' => array(
			'type' => 'text',
			'default' => 10
		),
	),
    'closeable' => true,
    'editable' => true,
);

function WidgetAncientPages($id, $params) {
	wfProfileIn(__METHOD__);
	
	global $wgTitle, $wgLang, $wgOut;

	// load class if it's not loaded yet...
	if (!class_exists('AncientPagesPage'))
	{
		require_once($IP.'includes/SpecialAncientpages.php');
	}

	if ( !is_object($wgTitle) ){
		$wgTitle = Title::newFromText( "Main_Page" );
	}

	$limit = intval($params['limit']);
	$limit = ($limit <=0 || $limit > 50) ? 10 : $limit;

	$pages = array();
	
	// query the special page object
	$app = new AncientPagesPage();

	// grab results (copied from QueryPage::doFeed()
	$dbr = wfGetDB( DB_SLAVE );
	$sql = $app->getSQL() . $app->getOrder();
	$sql = $dbr->limitResult( $sql, $limit, 0 );
	$res = $dbr->query( $sql, 'QueryPage::doFeed' );
	while( $obj = $dbr->fetchObject( $res ) ) {
		$pages[] = $obj;
	}

	$items = array();

	foreach($pages as $edit)
	{
		$date = $wgLang->sprintfDate('j M Y', date('YmdHis', $edit->value));
		
		$title = Title::newFromText($edit->title, $edit->namespace);

		$items[] = array('name'  => $title->getText(), 
		                 'href'  => $title->getLocalURL(),
				 'title' => wfMsg('lastmodifiedat', date('H:i', $edit->value), $date));
	}
	
	    
    wfProfileOut( __METHOD__ );
    return WidgetFrameworkWrapLinks($items) . WidgetFrameworkMoreLink( Title::newFromText('Ancientpages', NS_SPECIAL)->getLocalURL() );
}
