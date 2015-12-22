<?php

/**
 * Hides unneeded tags from view. Used to quickly cleanup after Social Tools removal.
 *
 * @date 2010-10-22
 * @author Lucast GArczewski <tor@wikia-inc.com>
 */

//Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
$wgHooks['ParserFirstCallInit'][] = 'efHideTagsSetup';

function efHideTagsSetup(Parser $parser) {
	global $wgEnableVerbatimExt, $wgEnableFlashmp3whitelistExt;

	if ( empty( $wgEnableVerbatimExt ) ) {
		$parser->setHook( 'verbatim', 'efHideTags' );
	}

	// CE-2809
	if ( !empty( $wgEnableFlashmp3whitelistExt ) ) {
		$parser->setHook( 'mp3', 'efHideTags' );
	}

	$parser->setHook( 'vote', 'efHideTags' );
	$parser->setHook( 'comments', 'efHideTags' );
	$parser->setHook( 'rhtml', 'efHideTags' );
	$parser->setHook( 'pageby', 'efHideTags' );
	$parser->setHook( 'pageTools', 'efHideTags' );
	/* copy above line and change tag name to hide additional tags */

	$parser->setHook( 'loggedin', 'efJustPrintTags' );
	$parser->setHook( 'loggedout', 'efJustPrintTags' );
	/* copy above line and change tag name to just print additional tags */

	return true;
}

function efHideTags( $contents, $attributes, $parser ) {
	return '';
}

function efJustPrintTags( $contents, $attributes, $parser ) {
	return htmlspecialchars( $contents );
}
