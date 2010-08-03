<?php

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['ImageMap'] = $dir . 'ImageMap.i18n.php';
$wgAutoloadClasses['ImageMap'] = $dir . 'ImageMap_body.php';
if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'wfSetupImageMap';
} else {
	$wgExtensionFunctions[] = 'wfSetupImageMap';
}

$wgExtensionCredits['parserhook']['ImageMap'] = array(
	'name'           => 'ImageMap',
	'svn-date' => '$LastChangedDate: 2008-06-06 22:38:04 +0200 (ptk, 06 cze 2008) $',
	'svn-revision' => '$LastChangedRevision: 35980 $',
	'author'         => 'Tim Starling',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:ImageMap',
	'description'    => 'Allows client-side clickable image maps using <nowiki><imagemap></nowiki> tag.',
	'descriptionmsg' => 'imagemap_desc',
);

function wfSetupImageMap() {
	global $wgParser;
	$wgParser->setHook( 'imagemap', array( 'ImageMap', 'render' ) );
	return true;
}
