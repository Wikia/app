<?php

/**
 * Hides unneeded tags from view. Used to quickly cleanup after Social Tools removal.
 *
 * @date 2010-10-22
 * @author Lucast GArczewski <tor@wikia-inc.com>
 */

//Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
$wgHooks['ParserFirstCallInit'][] = 'efHideTagsSetup';

function efHideTagsSetup(&$parser) {
	$parser->setHook( 'vote', 'efHideTags' );
	$parser->setHook( 'comments', 'efHideTags' );
	/* copy above line and change tag name to hide additional tags */

	return true;
}

function efHideTags( $contents, $attributes, $parser ) {
	return '';
}
