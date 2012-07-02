<?php

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['ImageMap'] = $dir . 'ImageMap.i18n.php';
$wgAutoloadClasses['ImageMap'] = $dir . 'ImageMap_body.php';
$wgHooks['ParserFirstCallInit'][] = 'wfSetupImageMap';

$wgExtensionCredits['parserhook']['ImageMap'] = array(
	'path'           => __FILE__,
	'name'           => 'ImageMap',
	'author'         => 'Tim Starling',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:ImageMap',
	'descriptionmsg' => 'imagemap_desc',
);

/**
 * @param $parser Parser
 * @return bool
 */
function wfSetupImageMap( &$parser ) {
	$parser->setHook( 'imagemap', array( 'ImageMap', 'render' ) );
	return true;
}
