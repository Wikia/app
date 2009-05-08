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
		'pl' => 'Najstarsze strony',
		'hu' => 'Elhagyott oldalak'
	),
	'desc' => array(
		'en' => 'See a list of pages that have not been edited in a long time', 
		'pl' => 'Lista stron nieedytowanych przez dłuższy czas',
		'hu' => 'Nézd meg a legrégebben szerkesztett szócikkeket.'
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
	if (!class_exists('AncientPagesPage')) {
		require_once($IP.'includes/SpecialAncientpages.php');
	}

	if ( !is_object($wgTitle) ) {
		$wgTitle = Title::newFromText( "Main_Page" );
	}

	$offset = 0;
	$limit = intval($params['limit']);
	$limit = ($limit <=0 || $limit > 50) ? 10 : $limit;

	$pages = array();
	
	// query the special page object
	$showSpecial = false;
	$app = new WidgetAncientPagesPage($showSpecial);
	$app->setListoutput(TRUE);
	$app->doQuery($offset, $limit, $showSpecial);
	
	$items = array();
	$aRows = $app->getResult();
	if ( !empty($aRows) && is_array($aRows) ) {
		foreach($aRows as $sTitle => $sTimestamp) {
			$date = $wgLang->sprintfDate('j M Y', date('YmdHis', $sTimestamp));
			$oTitle = Title::newFromText($sTitle, NS_MAIN);
			if ( $oTitle instanceof Title ) {
				$items[] = array(
					'name'  => $oTitle->getText(), 
					'href'  => $oTitle->getLocalURL(),
					'title' => wfMsg('lastmodifiedat', date('H:i', $sTimestamp), $date)
				);
			}
		}
	}	
	    
    wfProfileOut( __METHOD__ );
    return WidgetFrameworkWrapLinks($items) . WidgetFrameworkMoreLink( Title::newFromText('Ancientpages', NS_SPECIAL)->getLocalURL() );
}

class WidgetAncientPagesPage extends AncientPagesPage {
	var $data = array();
	var $show = false;

	function __construct($show = false) { $this->show = $show; }
	function getResult() { return $this->data; }
	function formatResult( $skin, $result ) {
		if (empty($this->show)) {
			$this->data[$result->title] = $result->value;
			return false;
		} else {
			return parent::formatResult( $skin, $result);
		}
	}
}
