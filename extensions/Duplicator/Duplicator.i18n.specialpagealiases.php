<?php
/**
 * Internationalisation file for extension Duplicator.
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

/**
 * Get an array of special page aliases
 *
 * @param string $lang Language code
 * @return array
 */
function efDuplicatorAliases( $lang ) {
	$aliases = array(

		/**
		 * English
		 */
		'en' => array(
			'Duplicator',
			'Duplicate',
		),
		
		'de' => array(
			'Seiten_duplizieren',
			'Duplizieren',
		),
		
		'fi' => array(
			'Monista',
		),

		'nl' => array(
			'Kopieren',
		),
	);
	return isset( $aliases[$lang] ) && $lang != 'en'
		? array_merge( $aliases[$lang], $aliases['en'] )
		: $aliases['en'];
}
