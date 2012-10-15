<?php

///Add-on to Contributions Extension by Rob Church
/**
 * The Contributions extension MUST be installed for 
 * this Extension to function.  This extension adds
 * JS popup DIVs when the user moves their mouse over
 * the "Main Contributors" link.
 *
 * @file
 * @ingroup Extensions
 * @author Tim Laqua <t.laqua@gmail.com>
 */
 
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'ContributorsAddon',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ContributorsAddon',
	'author' => 'Tim Laqua',
	'descriptionmsg' => 'contributorsaddon-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['ContributorsAddon'] = $dir . 'ContributorsAddon.i18n.php';
$wgAutoloadClasses['SpecialContributorsAddon'] = $dir . 'ContributorsAddonClass.php';

$wgHooks['OutputPageParserOutput'][] = 'efContributorsAddonSetup';

function efContributorsAddonSetup( &$out, $parseroutput ) {
	global $wgScriptPath;
	$out->addScript( '<link rel="stylesheet" type="text/css" href="' . $wgScriptPath . '/extensions/ContributorsAddon/ContributorsAddon.css" />' );
	$out->addScript( '<script type="text/javascript" src="' . $wgScriptPath . '/extensions/ContributorsAddon/ContributorsAddon.js"><!-- ContributorsAddon js --></script>' );
	$spContribAddon = new SpecialContributorsAddon;
	$out->addScript( "\n<script type=\"text/javascript\">\nvar contributorsText = \"".  $spContribAddon->getContributorsText( $out->getTitle() ) . "\";\n</script>\n" );
	return true;
}

