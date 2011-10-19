<?php

/**
 * Get translated magic words, if available
 *
 * @param string $lang Language code
 * @return array
 */
function efImageSizeInfoFunctionsWords( $lang ) {
	$words = array();

	/**
	 * English
	 */
	$words['en'] = array(
			'imgw' 		=> array( 0, 'imgw' ),	
			'imgh' 		=> array( 0, 'imgh' ),			
			);

# English is used as a fallback, and the English synonyms are
# used if a translation has not been provided for a given word
	return ( $lang == 'en' || !isset( $words[$lang] ) )
		? $words['en']
		: array_merge( $words['en'], $words[$lang] );
}

/**
 * Get extension messages
 *
 * @return array
 */
function efImageSizeInfoFunctionsMessages() {
	$messages = array(

			/* English */
			'en' => array(
				'ifunc_error'             => 'Error',
				),

			/* German */
			'de' => array(
				'ifunc_error'             => 'Fehler',
				),

			/* French */
			'fr' => array(
				'ifunc_error'            => 'Erreur',
				),

			/* Hebrew */
			'he' => array(
				'ifunc_error'             => '×©×’×•×™',
				),

			/* Dutch */
			'nl' => array(
					'ifunc_error'             => 'Fout',
				     ),

			/* Italian */
			'it' => array(
					'ifunc_error'             => 'Errore',
				     ),

			);

	return $messages ;
}
