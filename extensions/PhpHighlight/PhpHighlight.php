<?php

if( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Extension that use the PHP syntax highlighter (php -s)
 *
 * @author Alexandre Emsenhuber
 * @license GPL v.2 or higher
 */

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'PHP highlight',
	'url' => 'http://www.mediawiki.org/wiki/Extension:PhpHighlight',
	'svn-date' => '$LastChangedDate: 2008-08-09 01:16:06 +0200 (sob, 09 sie 2008) $',
	'svn-revision' => '$LastChangedRevision: 38965 $',
	'author' => 'Alexandre Emsenhuber',
	'description' => 'Adds a <code>&lt;php&gt;</code> tag to use the PHP syntax highlighter',
);

if( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) )
	$wgHooks['ParserFirstCallInit'][] = 'efSetPhp';
else
	$wgExtensionFunctions[] = 'efSetPhpOld';

function efSetPhpOld(){
	global $wgParser;
	efSetPhp( $wgParser );
}

function efSetPhp( &$parser ){
	$parser->setHook( 'php', 'efRenderPhp' );
	return true;
}

/**
 * Call back
 */
function efRenderPhp( $text ){
	$html = highlight_string( $text, true );
	return str_replace( '<br />', "<br />\n", $html );
}
