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
  'url'		=> 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WidgetTag',
  'author'	=> 'Maciej Brencz',
  'description'	=> 'widgettag-desc',
  'version'	=> 0.2
);

$wgHooks['ParserFirstCallInit'][] = 'efWidgetTagSetup';

$wgAutoloadClasses['WidgetTagRenderer'] = dirname(__FILE__) . '/WidgetTagRenderer.class.php';

//i18n
$wgExtensionMessagesFiles['WidgetTag'] = __DIR__ . '/WidgetTag.i18n.php';

/**
 * Setup parser hook
 *
 * @param Parser $parser
 * @return bool
 */
function efWidgetTagSetup( Parser $parser ): bool {
	global $wgHooks;
	$parser->setHook( 'widget', 'efWidgetTagRender' );
	$wgHooks['ParserAfterTidy'][] = 'efWidgetTagReplaceMarkers';
	return true;
}

function efWidgetTagRender( $input, $args, $parser ) {
	$widgetTagRenderer = WidgetTagRenderer::getInstance();
	return $widgetTagRenderer->renderTag( $input, $args, $parser );
}

function efWidgetTagReplaceMarkers( Parser $parser, string &$text ): bool {
	$widgetTagRenderer = WidgetTagRenderer::getInstance();
	$text = $widgetTagRenderer->replaceMarkers($text);
	return true;
}
