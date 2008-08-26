<?php

///Add-on to Contributions Extension by Rob Church
/**
 * The Contributions extension MUST be installed for 
 * this Extension to function.  This extension adds
 * JS popup DIVs when the user moves their mouse over
 * the "Main Contributors" link.
 * 
 * @addtogroup Extensions
 * @author Tim Laqua <t.laqua@gmail.com>
 */
 
if( defined( 'MEDIAWIKI' ) ) {
	$wgExtensionFunctions[] = 'efContributorsAddon';
	$wgExtensionCredits['other'][] = array(
		'name' => 'ContributorsAddon',
		'url' => 'http://www.mediawiki.org/wiki/Extension:ContributorsAddon',
		'author' => 'Tim Laqua',
		'description' => 'Adds JS onMouseOver popups to "Main Contributors" links',
		'descriptionmsg' => 'contributorsaddon-desc',
	);

	$dir = dirname(__FILE__) . '/';
	$wgExtensionMessagesFiles['ContributorsAddon'] = $dir . 'ContributorsAddon.i18n.php';
	$wgAutoloadClasses['SpecialContributorsAddon'] = $dir . 'ContributorsAddonClass.php';

	function efContributorsAddon() {
		global $wgHooks;
		$wgHooks['OutputPageParserOutput'][] = 'efContributorsAddonSetup';
		return true;
	}
	
	function efContributorsAddonSetup(&$out, &$parseroutput) {
		global $wgScriptPath;
		$out->addScript( '<link rel="stylesheet" type="text/css" href="' . $wgScriptPath . '/extensions/ContributorsAddon/ContributorsAddon.css" />' );
		$out->addScript( '<script type="text/javascript" src="' . $wgScriptPath . '/extensions/ContributorsAddon/ContributorsAddon.js"><!-- ContributorsAddon js --></script>' );
		$spContribAddon = new SpecialContributorsAddon;
		$out->addScript( "\n<script type=\"text/javascript\">\nvar contributorsText = \"".  $spContribAddon->getContributorsText() . "\";\n</script>\n" );
		return true;
	}

} else {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}