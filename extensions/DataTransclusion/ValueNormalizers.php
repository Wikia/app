<?php
/**
 * Collection of normalization functions to be applied to data values.
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler for Wikimedia Deutschland
 * @copyright © 2010 Wikimedia Deutschland (Author: Daniel Kinzler)
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

/**
 */
abstract class ValueNormalizers {
	static function trim( $v ) {
		return trim( $v );
	}

	static function strip_punctuation( $v ) {
		$w = preg_replace( '/[^a-zA-Z0-9]+/', '', $v );
		return $w;
	}
}

