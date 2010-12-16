<?php

if( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Extension that use the PHP syntax highlighter (php -s)
 *
 * @author Alexandre Emsenhuber
 * @license GPL v.2 or higher
 */

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'PHP highlight',
	'url' => 'http://www.mediawiki.org/wiki/Extension:PhpHighlight',
	'author' => 'Alexandre Emsenhuber',
	'description' => 'Adds a <code>&lt;php&gt;</code> tag to use the PHP syntax highlighter',
);

$wgHooks['ParserFirstCallInit'][] = 'efSetPhp';

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
