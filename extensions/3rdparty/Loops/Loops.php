<?php

/**
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:Loops Documentation
 *
 * @author David M. Sledge
 * @copyright Copyright © 2008 David M. Sledge
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0
 *     or later
 * @version 0.1.0
 *     initial creation.
 * @version 0.2.0
 *     #foreachnamedarg added
 *
 * @todo allow other functions in the extension to work without
 *     VariablesExtension.
 * @todo #foreacharg and #foreachnumarg
 * @todo inline documentation
 */

if ( !defined( "MEDIAWIKI" ) ) {
    die( "This file is a MediaWiki extension, it is not a valid entry point" );
}

$wgHooks['ParserFirstCallInit'][] = "ExtLoops::setup";
$wgExtensionCredits['parserhook'][] = array(
    'author'      => 'David M. Sledge',
    'name'        => 'Loops',
    'version'     => ExtLoops::VERSION,
    'description' => 'Parser functions for performing loops',
    'url'         => 'http://www.mediawiki.org/wiki/Extension:Loops',
);

$wgHooks['LanguageGetMagic'][]  = 'ExtLoops::languageGetMagic';
$wgHooks['ParserLimitReport'][] = 'ExtLoops::parserLimitReport';

class ExtLoops {
    const VERSION = "0.2.0";
    private static $parserFunctions = array(
        'dowhile'         => 'dowhile',
        'while'           => 'whileHook',
        'foreachnamedarg' => 'foreachNamedArg',
    );
    public static $maxLoops = 100;  // maximum number of loops allowed
                                    // (-1 = no limit).  #foreachnamedarg is
                                    // not limited by this.

    public static function setup( &$parser ) {
        global $wgMessageCache, $wgHooks;

        // These functions accept DOM-style arguments
        foreach( self::$parserFunctions as $hook => $function )
            $parser->setFunctionHook( $hook,
                array( __CLASS__, $function ), SFH_OBJECT_ARGS );

        require_once( dirname( __FILE__ ) . '/Loops.i18n.php' );

        foreach( Loops_i18n::getMessages() as $lang => $messages )
            $wgMessageCache->addMessages( $messages, $lang );

        $wgHooks['ParserClearState'][] = __CLASS__ . '::parserClearState';

        return true;
    }

    public static function languageGetMagic( &$magicWords, $langCode ) {
        require_once( dirname( __FILE__ ) . '/Loops.i18n.php' );

        foreach( Loops_i18n::magicWords( $langCode ) as $word => $trans )
            $magicWords[$word] = $trans;

        return true;
    }

    public static function parserLimitReport( $parser, &$report ) {
        if ( isset( $parser->loops_count ) ) {
            $report .= "#(do)while count: {$parser->loops_count}/" .
                self::$maxLoops . "\n";
        }

        return true;
    }

    public static function whileHook( &$parser, $frame, $args ) {
        // bug 12842:  first argument is automatically
        //   expanded, so we ignore this one
        array_shift( $args );
        $test = array_shift( $args );
        $loopStatement = array_shift( $args );
        $output = '';

        while ( isset( $test ) && trim( $frame->expand( $test ) ) !== '' ) {
            if ( self::$maxLoops >= 0 &&
                ++$parser->loops_count > self::$maxLoops )
                return wfMsgForContent( 'loops_max' );

            $output .= isset( $loopStatement ) ?
                trim( $frame->expand( $loopStatement ) ) : '';
        }

        //return '<pre><nowiki>'. $output . '</nowiki></pre>';
        return $output;
    }

    public static function dowhile( &$parser, $frame, $args ) {
        // bug 12842:  first argument is automatically
        //   expanded, so we ignore this one
        array_shift( $args );
        $test = array_shift( $args );
        $loopStatement = array_shift( $args );
        $output = '';

        do {
            if ( self::$maxLoops >= 0 &&
                ++$parser->loops_count > self::$maxLoops )
                return wfMsgForContent( 'loops_max' );

            $output .= isset( $loopStatement ) ?
                trim( $frame->expand( $loopStatement ) ) : '';
        }
        while ( isset( $test ) && trim( $frame->expand( $test ) ) !== '' );

        //return '<pre><nowiki>'. $output . '</nowiki></pre>';
        return $output;
    }

    public static function foreachNamedArg( &$parser, $frame, $args ) {
        global $wgExtVariables;

        // The first arg is already expanded, but this is a good habit to have.
        $filter = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
        // name of the variable to store the argument name.  this
        // will be accessed in the loop by using {{#var:}}
        $keyVarName = isset( $args[1] ) ?
            trim( $frame->expand( $args[1] ) ) : '';
        // name of the variable to store the argument value.
        $valueVarName = isset( $args[2] ) ?
            trim( $frame->expand( $args[2] ) ) : '';
        $loopStatement = isset( $args[3] ) ? $args[3] : '';
        $output = '';

        foreach ( array_keys( $frame->namedArgs ) as $argName ) {
            if ( $filter == '' || strpos( $argName, $filter ) === 0 )
            {
                if ( $keyVarName !== $valueVarName )
                    $wgExtVariables->vardefine( $parser, $keyVarName,
                        substr( $argName, strlen( $filter ) ) );

                $argVal = $frame->getNamedArgument( $argName );
                $wgExtVariables->vardefine( $parser, $valueVarName, $argVal );
                $output .= trim( $frame->expand( $loopStatement ) );
            }
        }

        return $output;
    }

    public static function parserClearState( &$parser ) {
        $parser->loops_count = 0;

        return true;
    }
}
