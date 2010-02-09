<?php

class Loops_i18n
{
    private $words = array(
    // English
        'en' => array(
            'dowhile'    => array( 0, 'dowhile' ),
            'while'      => array( 0, 'while' ),
            'forargs'    => array( 0, 'forargs' ),
            'fornumargs' => array( 0, 'fornumargs' ),
            'loop'       => array( 0, 'loop' ),
        ),
    );

    private $messages = array(
    // English
        'en' => array(
            'loops_max' => "Maximum number of loops have been performed",
        )
    );

    private static $instance = null;

    public static function getInstance()
    {
        // create the singleton if needed
        if ( self::$instance === null )
            self::$instance = new self();

        return self::$instance;
    }

    /**
     * limited-access constructor to insure singleton
     */
    protected function __construct()
    {
    }

    /**
     * Get translated magic words, if available
     *
     * @param string $lang Language code
     * @return array
     */
    public function magicWords( $lang )
    {
        // English is used as a fallback, and the English synonyms are
        // used if a translation has not been provided for a given word
        return ( $lang == 'en' || !isset( $this->words[ $lang ] ) ) ?
            $this->words[ 'en' ] :
            array_merge( $this->words[ 'en' ], $this->words[ $lang ] );
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
