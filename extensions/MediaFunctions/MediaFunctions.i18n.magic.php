<?php

/**
 * Internationalisation file for the MediaFunctions extension
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @version 1.1
 */

/**
 * Get translated magic words, if available
 *
 * @param string $lang Language code
 * @return array
 */
function efMediaFunctionsWords( $lang ) {
	$words = array();

	/**
	 * English
	 */
	$words['en'] = array(
		'mediamime' 		=> array( 0, 'mediamime' ),
		'mediasize' 		=> array( 0, 'mediasize' ),
		'mediaheight' 		=> array( 0, 'mediaheight' ),
		'mediawidth' 		=> array( 0, 'mediawidth' ),
		'mediadimensions'	=> array( 0, 'mediadimensions' ),
		'mediaexif'		=> array( 0, 'mediaexif' ),
	);

	/**
	 * Dutch
	 */
	$words['nl'] = array(
		'mediamime' 		=> array( 0, 'mediamime' ),
		'mediasize' 		=> array( 0, 'mediagrootte', 'mediasize' ),
		'mediaheight' 		=> array( 0, 'mediahoogte', 'mediaheight' ),
		'mediawidth' 		=> array( 0, 'mediabreedte', 'mediawidth' ),
		'mediadimensions'	=> array( 0, 'mediaafmetingen', 'mediadimensions' ),
		'mediaexif'		=> array( 0, 'mediaexif' ),
	);

	# English is used as a fallback, and the English synonyms are
	# used if a translation has not been provided for a given word
	return ( $lang == 'en' || !isset( $words[$lang] ) )
		? $words['en']
		: array_merge( $words['en'], $words[$lang] );
}
