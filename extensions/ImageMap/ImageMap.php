<?php

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['ImageMap'] = $dir . 'ImageMap.i18n.php';
$wgAutoloadClasses['ImageMap'] = $dir . 'ImageMap_body.php';
$wgHooks['ParserFirstCallInit'][] = 'wfSetupImageMap';

$wgExtensionCredits['parserhook']['ImageMap'] = array(
	'path'           => __FILE__,
	'name'           => 'ImageMap',
	'author'         => 'Tim Starling',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:ImageMap',
	'description'    => 'Allows client-side clickable image maps using <nowiki><imagemap></nowiki> tag.',
	'descriptionmsg' => 'imagemap_desc',
);

function wfSetupImageMap( &$parser ) {
	$parser->setHook( 'imagemap', array( 'ImageMap', 'render' ) );
	return true;
}
