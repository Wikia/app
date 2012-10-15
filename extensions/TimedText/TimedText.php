<?php
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}
 
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Add TimedText editing',
	'author' => 'MediaBot',
	'version' => '0.1',
#	'url' => 'http://www.example.com',
	'description' => 'load custom javascript on TimedText edit pages.',
);

$wgHooks['EditPageBeforeEditToolbar'][] = 'wfAddTimedTextJs';
$wgExtraNamespaces[102] = "TimedText";

function wfAddTimedTextJs( &$toolabar ) {
	global $wgOut, $wgTitle, $wgRequest, $wgScriptPath;
	$name = $wgTitle->getPrefixedDBKey();
	$action = $wgRequest->getVal( 'action' );
	if( $action == 'edit' && substr( $name, 0, 10 ) == 'TimedText:' ) {
		//$wgOut->addScriptClass( 'mvTimedTextEdit' );
		$wgOut->addScriptFile( $wgScriptPath. '/js2/mwEmbed/libTimedText/mvTimeTextEdit.js' );
	}
	return true;
}

