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
  'version'	=> 0.2
);

$wgHooks['ParserFirstCallInit'][] = 'efWidgetTagSetup';

$wgAutoloadClasses['WidgetTagRenderer'] = dirname(__FILE__) . '/WidgetTagRenderer.class.php';

/**
 * Setup parser hook
 *
 * @param Parser $parser
 * @return bool
 */
function efWidgetTagSetup(Parser $parser) {
	global $wgHooks;
	$parser->setHook( 'widget', 'efWidgetTagRender' );
	$wgHooks['ParserAfterTidy'][] = 'efWidgetTagReplaceMarkers';
	return true;
}

function efWidgetTagRender( $input, $args, $parser ) {
	$widgetTagRenderer = WidgetTagRenderer::getInstance();
	return $widgetTagRenderer->renderTag( $input, $args, $parser );
}

function efWidgetTagReplaceMarkers(&$parser, &$text) {
	$widgetTagRenderer = WidgetTagRenderer::getInstance();
	$text = $widgetTagRenderer->replaceMarkers($text);
	return true;
}
