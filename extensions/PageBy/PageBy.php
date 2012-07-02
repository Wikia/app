<?php
/**
 * PageBy extension - shows recent changes on a wiki page.
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'PageBy',
	'author' => 'Daniel Kinzler, brightbyte.de',
	'url' => 'http://mediawiki.org/wiki/Extension:PageBy',
	'descriptionmsg' => 'pageby-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['PageBy'] = $dir . 'PageBy.i18n.php';
$wgHooks['ParserFirstCallInit'][] = "wfPageBySetHooks";

$wgAutoloadClasses['PageByRenderer'] = $dir. 'PageByRenderer.php';

function wfPageBySetHooks( $parser ) {
	$parser->setHook( 'pageby', 'newsxRenderPageBy' );
	return true;
}

function newsxRenderPageBy( $page, $argv, $parser ) {
    $renderer = new PageByRenderer($page, $argv, $parser);
    return $renderer->renderPageBy();
}
