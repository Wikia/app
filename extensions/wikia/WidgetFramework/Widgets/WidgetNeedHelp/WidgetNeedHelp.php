<?php
/**
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetNeedHelp'] = array(
	'callback' => 'WidgetNeedHelp',
	'title' => array(
		'en' => 'Help needed',
		'pl' => 'Potrzebna pomoc'
	),
	'desc' => array(
		'en' => 'Displays articles that have been marked as needing help', 
		'pl' => 'Wyświetla artykuły wymagające dopracowania'
    ),
    'closeable' => true,
    'editable' => false,
);

function WidgetNeedHelp($id, $params) {

	global $wgOut;

	wfProfileIn(__METHOD__);
	
	// get content of MediaWiki:NeedHelp
	$article = WidgetFrameworkGetArticle('Needhelp', NS_MEDIAWIKI);
    
	if ( $article == false ) {
	    // "no article" fallback
	    $ret = $wgOut->parse( wfMsg('Needhelp') );
	}
	else {
	    $ret = $wgOut->parse($article);
	}

	wfProfileOut(__METHOD__);
	
	return $ret;
}
