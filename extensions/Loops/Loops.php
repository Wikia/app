<?php

/**
 * 'Loops' is a MediaWiki extension expanding the parser with loops functions
 * 
 * Documentation: http://www.mediawiki.org/wiki/Extension:Loops
 * Support:       http://www.mediawiki.org/wiki/Extension_talk:Loops
 * Source code:   http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/Loops
 * 
 * @version: 0.4
 * @license: GNU GPL v2 or higher
 * @author:  David M. Sledge
 * @author:  Daniel Werner < danweetz@web.de >
 *
 * @file Loops.php
 * @ingroup Loops
 */

if ( ! defined( 'MEDIAWIKI' ) ) { die( ); }
 
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'author'         => array( 'David M. Sledge', '[http://www.mediawiki.org/wiki/User:Danwe Daniel Werner]' ),
	'name'           => 'Loops',
	'version'        => ExtLoops::VERSION,
	'descriptionmsg' => 'loops-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Loops',
);

// language files:
$wgExtensionMessagesFiles['Loops'     ] = ExtLoops::getDir() . '/Loops.i18n.php';
$wgExtensionMessagesFiles['LoopsMagic'] = ExtLoops::getDir() . '/Loops.i18n.magic.php';

// hooks registration:
$wgHooks['ParserFirstCallInit'][] = 'ExtLoops::init';
$wgHooks['ParserLimitReport'  ][] = 'ExtLoops::onParserLimitReport';
$wgHooks['ParserClearState'   ][] = 'ExtLoops::onParserClearState';

// Include the settings file:
require_once ExtLoops::getDir() . '/Loops_Settings.php';


/**
 * Class representing extension 'Loops', containing all parser functions and other
 * extension logic stuff.
 */
class ExtLoops {
		
	const VERSION = '0.4';
	
	/**
	 * Configuration variable defining maximum allowed number of loops ('-1' => no limit).
	 * '#forargs' and '#fornumargs' are not limited by this.
	 * 
	 * @var int
	 */
	public static $maxLoops = 100;

	/**
	 * Returns the extensions base installation directory.
	 *
	 * @since 0.4
	 * 
	 * @return boolean
	 */
	public static function getDir() {
		static $dir = null;

		if( $dir === null ) {
			$dir = dirname( __FILE__ );
		}
		return $dir;
	}

	/**
	* Sets up parser functions
	* 
	* @since 0.4
	*/
	public static function init( Parser &$parser ) {
		
		if( ! class_exists( 'ExtVariables' ) ) {
			/*
			 * If Variables extension not defined, we can't use certain functions.
			 * Make sure they are disabled:
			 */
			global $egLoopsEnabledFunctions;
			$disabledFunctions = array( 'loop', 'forargs', 'fornumargs' );
			$egLoopsEnabledFunctions = array_diff( $egLoopsEnabledFunctions, $disabledFunctions );
		}
		
		/*
		 * store for loops count per parser object. This will solve several bugs related to
		 * 'ParserClearState' hook resetting the count early in combination with certain
		 * other extensions or special page inclusion. (since v0.4)
		 */
		$parser->mExtLoopsCounter = 0;

		self::initFunction( $parser, 'while' );
		self::initFunction( $parser, 'dowhile' );
		self::initFunction( $parser, 'loop' );
		self::initFunction( $parser, 'forargs' );
		self::initFunction( $parser, 'fornumargs' );
		
		return true;
	}
	private static function initFunction( Parser &$parser, $name ) {
		global $egLoopsEnabledFunctions;
		
		// don't register parser function if disabled by configuration:
		if( ! in_array( $name, $egLoopsEnabledFunctions ) ) {
			return;
		}
		
		$functionCallback = array( __CLASS__, 'pfObj_' . $name );
		$parser->setFunctionHook( $name, $functionCallback, SFH_OBJECT_ARGS );
	}
	
	
	####################
	# Parser Functions #
	####################

	public static function pfObj_while( Parser &$parser, $frame, $args ) {
		return self::perform_while( $parser, $frame, $args, false );
	}
	
	public static function pfObj_dowhile( Parser &$parser, $frame, $args ) {
		return self::perform_while( $parser, $frame, $args, true );
	}
	
	/**
	 * Generic function handling '#while' and '#dowhile' as one
	 */
	protected static function perform_while( Parser &$parser, $frame, $args, $dowhile = false ) {
		// #(do)while: | condition | code
		$rawCond = isset( $args[1] ) ? $args[1] : ''; // unexpanded condition
		$rawCode = isset( $args[2] ) ? $args[2] : ''; // unexpanded loop code
		
		if(
			$dowhile === false
			&& trim( $frame->expand( $rawCond ) ) === ''
		) {
			// while, but condition not fullfilled from the start
			return '';
		}
		
		$output = '';
		
		do {
			// limit check:
			if( ! self::incrCounter( $parser ) ) {
				return self::msgLoopsLimit( $output );
			}
			$output .= trim( $frame->expand( $rawCode ) );
			
		} while( trim( $frame->expand( $rawCond ) ) );
		
		return $output;
	}
	
	public static function pfObj_loop( Parser &$parser, PPFrame $frame, $args ) {
		// #loop: var | start | count | code
		$varName  = isset( $args[0] ) ?      trim( $frame->expand( $args[0] ) ) : '';
		$startVal = isset( $args[1] ) ? (int)trim( $frame->expand( $args[1] ) ) : 0;
		$loops    = isset( $args[2] ) ? (int)trim( $frame->expand( $args[2] ) ) : 0;
		$rawCode  = isset( $args[3] ) ? $args[3] : ''; // unexpanded loop code
		
		if( $loops === 0 ) {
			// no loops to perform
			return '';
		}
				
		$output = '';
		$endVal = $startVal + $loops;
		$i = $startVal;
		
		while( $i !== $endVal ) {
			// limit check:
			if( ! self::incrCounter( $parser ) ) {
				return self::msgLoopsLimit( $output );
			}
			
			// set current position as variable:
			self::setVariable( $parser, $varName, (string)$i );
			
			$output .= trim( $frame->expand( $rawCode ) );
			
			// in-/decrease loop count (count can be negative):
			( $i < $endVal ) ? $i++ : $i--;
		}
		return $output;
	}
	
	/**
	 * #forargs: filter | keyVarName | valVarName | code
	 */
	public static function pfObj_forargs( Parser &$parser, $frame, $args ) {		
		// The first arg is already expanded, but this is a good habit to have...
		$filter = array_shift( $args );
		$filter = $filter !== null ? trim( $frame->expand( $filter ) ) : '';
		
		// if prefix contains numbers only or isn't set, get all arguments, otherwise just non-numeric
		$tArgs = ( preg_match( '/^([1-9][0-9]*)?$/', $filter ) > 0 )
				? $frame->getArguments()
				: $frame->getNamedArguments();
		
		return self::perform_forargs( $parser, $frame, $args, $tArgs, $filter );
	}
	
	/**
	 * #fornumargs: keyVarName | valVarName | code
	 * or (since 0.4 for more consistency)
	 * #fornumargs: | keyVarName | valVarName | code
	 */
	public static function pfObj_fornumargs( Parser &$parser, $frame, $args ) {
		/*
		 * get numeric arguments, don't use PPFrame::getNumberedArguments because it would
		 * return explicitely numbered arguments only.
		 */
		$tNumArgs = $frame->getArguments();
		foreach( $tNumArgs as $argKey => $argVal ) {
			// allow all numeric, including negative values!
			if( is_string( $argKey ) ) {
				unset( $tNumArgs[ $argKey ] );
			}
		}
		ksort( $tNumArgs ); // sort from lowest to highest
		
		if( count( $args ) > 3 ) {
			// compatbility to pre 0.4 but consistency with other Loop functions.
			// this way the first argument can be ommitted like '#fornumargs: |varKey |varVal |code'
			array_shift( $args );
		}
		
		return self::perform_forargs( $parser, $frame, $args, $tNumArgs, '' );
	}
	
	/**
	 * Generic function handling '#forargs' and '#fornumargs' as one
	 */
	protected static function perform_forargs( Parser &$parser, PPFrame $frame, array $funcArgs, array $templateArgs, $prefix = '' ) {
		// if not called within template instance:
		if( !( $frame->isTemplate() ) ) {
			return '';
		}
		
		// name of the variable to store the argument name:
		$keyVar  = array_shift( $funcArgs );
		$keyVar  = $keyVar  !== null ? trim( $frame->expand( $keyVar ) )  : '';
		// name of the variable to store the argument value:
		$valVar  = array_shift( $funcArgs );
		$valVar  = $valVar  !== null ? trim( $frame->expand( $valVar ) )  : '';
		// unexpanded code:
		$rawCode = array_shift( $funcArgs );
		$rawCode = $rawCode !== null ? $rawCode : '';
				
		$output = '';
		
		// if prefix contains numbers only or isn't set, get all arguments, otherwise just non-numeric
		$tArgs = preg_match( '/^([1-9][0-9]*)?$/', $prefix ) > 0
				? $frame->getArguments() : $frame->getNamedArguments();
		
		foreach( $templateArgs as $argName => $argVal ) {
			// if no filter or prefix in argument name:
			if( $prefix !== '' && strpos( $argName, $prefix ) !== 0 ) {		
				continue;
			}
			if ( $keyVar !== $valVar ) {
				// variable with the argument name without prefix as value:
				self::setVariable( $parser, $keyVar, substr( $argName, strlen( $prefix ) ) );
			}
			// variable with the arguments value:
			self::setVariable( $parser, $valVar, $argVal );

			// expand current run:
			$output .= trim( $frame->expand( $rawCode ) );			
		}
		
		return $output;
	}
	
	/**
	 * Connects to 'Variables' extension and sets a variable. Handles different versions of
	 * 'Variables' extension since there have changed some things along the way.
	 * 
	 * @param Parser $parser
	 * @param string $varName
	 * @param string $varValue
	 */
	private static function setVariable( Parser &$parser, $varName, $varValue ) {
		global $wgExtVariables;
		
		static $newVersion = null;
		if( $newVersion === null ) {
			// find out whether local wiki is using variables extension 2.0 or higher
			$newVersion = ( defined( 'ExtVariables::VERSION' ) && version_compare( ExtVariables::VERSION, '1.9999', '>' ) );
		}
		
		if( $newVersion ) {
			// clean way since Variables 2.0:
			ExtVariables::get( $parser )->setVarValue( $varName, $varValue );
		}
		else {
			// make sure to trim values and convert them to string since old versions of Variables extension won't do this.
			$wgExtVariables->vardefine( $parser, trim( $varName ), trim( $varValue ) );
		}
	}
	
	
	###############
	# Loops Count #
	###############
	
	/**
	 * Returns how many loops have been performed for a given Parser instance.
	 * 
	 * @since 0.4
	 * 
	 * @param Parser $parser
	 * @return int
	 */
	public static function getLoopsCount( Parser &$parser ) {
		return $parser->mExtLoopsCounter;
	}
	
	/**
	 * Returns whether the maximum number of loops for the given Parser instance have
	 * been performed already.
	 * 
	 * @since 0.4
	 * 
	 * @param Parser $parser
	 * @return bool 
	 */
	public static function maxLoopsPerformed( Parser &$parser ) {
		$count = $parser->mExtLoopsCounter;
		return $count > -1 && $count >= self::$maxLoops;
	}
	
	/**
	 * If limit has not been exceeded already, this will increase the counter. If
	 * exceeded false will be returned, otherwise the new counter value
	 * 
	 * @return false|int
	 */
	protected static function incrCounter( Parser &$parser ) {
		if( self::maxLoopsPerformed( $parser ) ) {
			return false;
		}
		return ++$parser->mExtLoopsCounter;
	}
	
	/**
	 * div wrapped error message stating maximum number of loops have been performed.
	 */
	protected static function msgLoopsLimit( $output = '' ) {
		if( trim( $output ) !== '' ) {
			$output .= "\n";
		}
		return $output .= '<div class="error">' . wfMsgForContent( 'loops_max' ) . '</div>';
	}
	
	
	##################
	# Hooks handling #
	##################
	
	public static function onParserClearState( Parser &$parser ) {
		// reset loops counter since the parser process finished one page
		$parser->mExtLoopsCounter = 0;
		return true;
	}
	
	public static function onParserLimitReport( $parser, &$report ) {
		// add performed loops to limit report:
		$report .= 'ExtLoops count: ' . self::getLoopsCount( $parser );
		
		if( self::$maxLoops > -1 ) {
			// if limit is set, communicate the limit as well:
			$report .= '/' . self::$maxLoops;
		}
		$report .= "\n";
		
		return true;
	}
	
}
