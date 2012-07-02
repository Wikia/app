<?php
/**
 * Internationalization file for extension.
 *
 * Add the "lossy"-parameter to image link.
 * Usage:
 *  lossy=true|false
 *  lossy=1|0
 *  lossy=lossy|lossless
 * E.g. [[Image:Test.tif|lossy=1]]
 *
 * @file
 * @ingroup Extensions
 */

$magicWords = array();

/** English (English) */
$magicWords['en'] = array(
	'img_lossy' => array( 0, "lossy=$1" ),
);
