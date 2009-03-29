<?php

class Loops_i18n {
    private static $words = array(
    // English
        'en' => array(
            'dowhile'         => array( 0, 'dowhile' ),
            'while'           => array( 0, 'while' ),
            'foreachnamedarg' => array( 0, 'foreachnamedarg' ),
        ),
    );

    private static $messages = array(
    // English
        'en' => array(
            'loops_max' => "Maximum number of loops have been performed",
        )
    );

    /**
     * Get translated magic words, if available
     *
     * @param string $lang Language code
     * @return array
     */
    public static function magicWords( $lang ) {
        // English is used as a fallback, and the English synonyms are
        // used if a translation has not been provided for a given word
        return ( $lang == 'en' || !isset( self::$words[$lang] ) ) ?
            self::$words['en'] :
            array_merge( self::$words['en'], self::$words[$lang] );
    }

    public static function getMessages() {
        return self::$messages;
    }
}
