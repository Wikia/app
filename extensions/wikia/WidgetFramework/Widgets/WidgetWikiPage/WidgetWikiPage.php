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
		'source' => array(
			'type'    => 'text',
			'default' => '',
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
    
	// clean up inputs
	$params['source'] = trim($params['source']);
	$params['name'] = trim($params['name']);

	//stopgap for 67038
	$source = Title::newFromText( $params['source'] );
	if( !$source->userCanRead() )
	{
		return array('body' => '', 'title' => $params['name'] );
	}
	unset($source);
	
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
	$options->setMaxIncludeSize(2048);

	if( empty($params['source']) ) {
		// blank source pagename, use default message
		$ret = $parser->parse( wfMsg('widgetwikipage', $params['source']), $wgTitle, $options )->getText();
	}
	else {
		// has a source value
		
		// get contents
		$article = WidgetFrameworkGetArticle($params['source']);
	
		if ( $article == false ) {
			// failed to get text, show error message, failed pagename is in $1
			$ret = $parser->parse( '<span class="widget-error-wikipage-missing">' . wfMsg('widgetwikipagemissing', $params['source']) . '</span>' , $wgTitle, $options )->getText();
			// TODO: change title if page missing?
		}
		else {
			// got text, parse it!
			$ret = $parser->parse( $article, $wgTitle, $options )->getText();
		}
	}

	wfProfileOut(__METHOD__);
    
	return array('body' => $ret, 'title' => $params['name'] );
}
