<?php
 
/**
 * Get translated magic words, if available
 *
 * @param string $lang Language code
 * @return array
 */
function efArrayExtensionWords( $lang ) {
        $words = array();
 
        /**
         * English
         */
        $words['en'] = array(
                'arraydefine'    => array( 0, 'arraydefine' ),

                'arrayprint'          => array( 0, 'arrayprint' ),
                'arraysize'         => array( 0,'arraysize' ),
                'arrayindex'         => array( 0,'arrayindex' ),
                'arraysearch'         => array( 0,'arraysearch' ),	
		
                'arrayunique'         => array( 0,'arrayunique' ),
                'arraysort'         => array( 0,'arraysort' ),
                'arrayreset'         => array( 0,'arrayreset' ),

                'arraymerge'         => array( 0,'arraymerge' ),
                'arrayslice'         => array( 0,'arrayslice' ),

                'arrayunion'         => array( 0,'arrayunion' ),
                'arrayintersect'         => array( 0,'arrayintersect' ),
                'arraydiff'         => array( 0,'arraydiff' ),	
        );
 
        # English is used as a fallback, and the English synonyms are
        # used if a translation has not been provided for a given word
        return ( $lang == 'en' || !isset( $words[$lang] ) )
                ? $words['en']
                : array_merge( $words['en'], $words[$lang] );
}
 
