<?php

$dir = dirname(__FILE__) . '/';
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
function wfSetupImageMap( Parser $parser ): bool {
	$parser->setHook( 'imagemap', [ 'ImageMap', 'render' ] );

	return true;
}
