<?php
/**
 * PageBy extension - shows recent changes on a wiki page.
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */


if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array( 
	'name' => 'PageBy', 
	'author' => 'Daniel Kinzler, brightbyte.de', 
	'url' => 'http://mediawiki.org/wiki/Extension:PageBy',
	'description' => 'shows contributors inline on a wiki page',
);

$wgExtensionFunctions[] = "wfPageByExtension";

$wgAutoloadClasses['PageByRenderer'] = dirname( __FILE__ ) . '/PageByRenderer.php';

function wfPageByExtension() {
    global $wgParser;
    $wgParser->setHook( "pageby", "newsxRenderPageBy" );
}


function newsxRenderPageBy( $page, $argv, &$parser ) {
    $renderer = new PageByRenderer($page, $argv, $parser);
    return $renderer->renderPageBy();
}

/**
* load the PageBy internationalization file
*/
function loadPageByI18n() {
	global $wgContLang, $wgMessageCache;

	#TODO: optionally disable caching and use user language?
	#      or always use user language, because it's in the parser-cache-key? is it?

	static $initialized = false;

	if ( $initialized ) return;

	$messages= array();
	
	$f= dirname( __FILE__ ) . '/PageBy.i18n.php';
	include( $f );
	
	$f= dirname( __FILE__ ) . '/PageBy.i18n.' . $wgContLang->getCode() . '.php';
	if ( file_exists( $f ) ) include( $f );
	
	$initialized = true;
	$wgMessageCache->addMessages( $messages );
}


?>