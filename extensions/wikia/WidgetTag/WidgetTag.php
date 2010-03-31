<?php

/**
 * This extension renders <widget> tag
 * written by Maciej Brencz <macbre(at)no-spam-wikia.com>
 *
 * To activate the functionality of this extension include the following in your
 * LocalSettings.php file:
 * require_once("$IP/extensions/wikia/WidgetTag/WidgetTag.php");
 */


$wgExtensionCredits['parserhook'][] = array(
  'name'	=> 'WidgetTag',
  'url'		=> 'http://help.wikia.com/wiki/Help:WidgetTag',
  'author'	=> 'Maciej Brencz',
  'description'	=> 'Adds &lt;widget&gt; tag for dynamic embedding of Wikia widgets',
  'version'	=> 0.1
);

//Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'efWidgetTagSetup';
}
else {
	$wgExtensionFunctions[] = 'efWidgetTagSetup';
}

$wgAutoloadClasses['WidgetTagRenderer'] = dirname(__FILE__) . '/WidgetTag_class.php';

// setup parser hook
function efWidgetTagSetup(&$parser) {
	global $wgHooks;
	$parser->setHook( 'widget', 'efWidgetTagRender' );
	$wgHooks['ParserAfterTidy'][] = 'efWidgetTagReplaceMarkers';
	return true;
}

function efWidgetTagRender( $input, $args, $parser ) {
	$widgetTagRenderer = & WidgetTagRenderer::getInstance();
	return $widgetTagRenderer->renderTag( $input, $args, $parser );
}

function efWidgetTagReplaceMarkers(&$parser, &$text) {
	$widgetTagRenderer = & WidgetTagRenderer::getInstance();
	$text = $widgetTagRenderer->replaceMarkers($text);
	return true;
}
