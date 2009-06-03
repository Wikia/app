<?php
/**
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetWikiPage'] = array(
	'callback' => 'WidgetWikiPage',
	'title' => 'widget-title-wikipage',
	'desc' => 'widget-desc-wikipage',
	'params' => array(
		'name' => array(
			'type'    => 'text',
			'default' => 'Wiki Page',
			'msg'     => 'widget-wikipage-title',
		),
		'title' => array(
			'type'    => 'text',
			'default' => 'widgetwikipage',
			'msg'     => 'widget-wikipage-source',
		)
	),
    'closeable' => true,
    'editable' => true,
);


function WidgetWikiPage($id, $params) {

	global $wgTitle, $wgParser;

	wfProfileIn(__METHOD__);
	
	if ( !is_object($wgTitle) ) {
		$wgTitle = new Title();
	}
    
	$params['title'] = trim($params['title']);

	//
	// parse message and clean it up
	//

	 // fixes #2774
	if ( isset($params['_widgetTag']) ) {
		// work-around for WidgetTag
		$parser = new Parser();
	}
	else {
		$parser = & $wgParser;
	}
	
	$options = new ParserOptions();
	$options->setMaxIncludeSize(750);

	// get content of MediaWiki:<title>
	$article = WidgetFrameworkGetArticle($params['title'], NS_MEDIAWIKI);

	if ( $article == false || empty($params['title']) ) {
		// "no article" fallback
		$ret = $parser->parse( wfMsg('widgetwikipage', $params['title']), $wgTitle, $options )->getText();
	}
	else {
		$ret = $parser->parse( $article, $wgTitle, $options )->getText();
	}

	wfProfileOut(__METHOD__);
    
	return array('body' => $ret, 'title' => trim($params['name']) );
}
