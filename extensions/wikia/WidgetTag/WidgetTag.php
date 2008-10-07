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
  'author'	=> '[http://pl.wikia.com/wiki/User:Macbre Maciej Brencz]', 
  'description'	=> 'Adds &lt;widget&gt; tag for dynamic embedding of Wikia widgets',
  'version'	=> 0.1
);


$wgExtensionFunctions[] = 'efWidgetTagSetup';
$wgAutoloadClasses['WidgetTagRenderer'] = dirname(__FILE__) . '/WidgetTag_class.php';

// setup parser hook
function efWidgetTagSetup() {
	global $wgParser;
	$wgParser->setHook( 'widget', 'efWidgetTagRender' );
}

function efWidgetTagRender( $input, $args, $parser ) {
	$widgetTagRenderer = & WidgetTagRenderer::getInstance();
	return $widgetTagRenderer->renderTag( $input, $args, $parser );
}

