<?php

/**
 * Get translated magic words, if available
 *
 * @param string $lang Language code
 * @return array
 */
function efVariablesWords( $lang ) {
        $words = array();

        /**
         * English
         */
        $words['en'] = array(
                'var'          => array( 0, 'var' ),
                'vardefine'    => array( 0, 'vardefine' ),
        );

        # English is used as a fallback, and the English synonyms are
        # used if a translation has not been provided for a given word
        return ( $lang == 'en' || !isset( $words[$lang] ) )
                ? $words['en']
                : array_merge( $words['en'], $words[$lang] );
}

?>