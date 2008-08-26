<?php
/**
 * Main file for the Wikiwyg extension that loads all other stuff
 *
 * @ingroup Extensions
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

require("$IP/extensions/wikiwyg/share/MediaWiki/extensions/MediaWikiWyg.php");
require("$IP/extensions/wikiwyg/share/MediaWiki/extensions/WikiwygEditing/WikiwygEditing.php");
require("$IP/extensions/wikia/CreatePage/SpecialCreatePage.php");
require("$IP/extensions/wikia/CreatePage/CreatePageCore.php");

$dir = dirname(__FILE__);
$wgExtensionMessagesFiles['Wikiwyg'] = $dir . '/Wikiwyg.i18n.php';
