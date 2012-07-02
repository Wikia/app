<?php

/**
 * 'Variables' introduces parser functions for defining page-scoped variables within
 * wiki pages.
 * 
 * Documentation: https://www.mediawiki.org/wiki/Extension:Variables
 * Support:       https://www.mediawiki.org/wiki/Extension_talk:Variables
 * Source code:   https://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/Variables
 * 
 * @version: 2.0
 * @license: ISC License
 * @author: Rob Adams
 * @author: Tom Hempel
 * @author: Xiloynaha
 * @author: Daniel Werner < danweetz@web.de >
 *
 * @file Variables.php
 * @ingroup Variables
 */

if ( ! defined( 'MEDIAWIKI' ) ) { die(); }
 
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'Variables',
	'descriptionmsg' => 'variables-desc',
	'version'        => ExtVariables::VERSION,
	'author'         => array( 'Rob Adams', 'Tom Hempel', 'Xiloynaha', '[https://www.mediawiki.org/wiki/User:Danwe Daniel Werner]' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Variables',
);

// language files:
$wgExtensionMessagesFiles['Variables'     ] = ExtVariables::getDir() . '/Variables.i18n.php';
$wgExtensionMessagesFiles['VariablesMagic'] = ExtVariables::getDir() . '/Variables.i18n.magic.php';

// hooks registration:
$wgHooks['ParserFirstCallInit'     ][] = 'ExtVariables::init';
$wgHooks['ParserClearState'        ][] = 'ExtVariables::onParserClearState';
$wgHooks['InternalParseBeforeLinks'][] = 'ExtVariables::onInternalParseBeforeLinks';

// Include the settings file:
require_once ExtVariables::getDir() . '/Variables_Settings.php';


/**
 * Extension class with basic extension information. This class serves as static
 * class with the static parser functions but also als variables store instance
 * as object assigned to a Parser object.
 */
class ExtVariables {
	
	/**
	 * Version of the 'Variables' extension.
	 * 
	 * @since 1.4
	 * 
	 * @var string
	 */
	const VERSION = '2.0';
	
	/**
	 * Internal store for variable values
	 * 
	 * @private
	 * @var array
	 */
    var $mVariables = array();
	
	/**
	 * Array with all names of variables requested by '#var_final'. Key of the values is the
	 * stripSateId of the strip-item placed where the final var should appear.
	 * 
	 * @since 2.0
	 * 
	 * @private
	 * @var Array
	 */
	var $mFinalizedVars = array();
	
	/**
	 * Variables extensions own private StripState manager to manage '#final_var' placeholders
	 * and their replacement with the final var value or a defined default.
	 * 
	 * @since 2.0
	 * 
	 * @private
	 * @var StripState
	 */
	var $mFinalizedVarsStripState;
	
	/**
	 * Sets up parser functions
	 * 
	 * @since 1.4
	 */
	public static function init( Parser &$parser ) {
		
		/*
		 * store for variables per parser object. This will solve several bugs related to
		 * 'ParserClearState' hook clearing all variables early in combination with certain
		 * other extensions. (since v2.0)
		 */
		$parser->mExtVariables = new self();
		
		// SFH_OBJECT_ARGS available since MW 1.12
		self::initFunction( $parser, 'var', array( __CLASS__, 'pfObj_var' ), SFH_OBJECT_ARGS );		
		self::initFunction( $parser, 'var_final' );
		self::initFunction( $parser, 'vardefine' );
		self::initFunction( $parser, 'vardefineecho' );
		self::initFunction( $parser, 'varexists' );
		
		return true;
	}
	private static function initFunction( Parser &$parser, $name, $functionCallback = null, $flags = 0 ) {
		if( $functionCallback === null ) {
			// prefix parser functions with 'pf_'
			$functionCallback = array( __CLASS__, 'pf_' . $name );
		}		
		global $egVariablesDisabledFunctions;
		
		// register function only if not disabled by configuration:
		if( ! in_array( $name, $egVariablesDisabledFunctions ) ) {			
			$parser->setFunctionHook( $name, $functionCallback, $flags );
		}
	}
	
	/**
	 * Returns the extensions base installation directory.
	 *
	 * @since 2.0
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
	
	
	####################
	# Parser Functions #
	####################
	
    static function pf_varexists( Parser &$parser, $varName = '', $exists=true, $noexists=false ) {
        if( self::get( $parser )->varExists( $varName ) ) {
			return $exists;
		} else {
			return $noexists;
		}
    }
	
    static function pf_vardefine( Parser &$parser, $varName = '', $value = '' ) {
        self::get( $parser )->setVarValue( $varName, $value );
        return '';
    }
 
    static function pf_vardefineecho( Parser &$parser, $varName = '', $value = '' ) {
        self::get( $parser )->setVarValue( $varName, $value );
        return $value;
    }
		
    static function pfObj_var( Parser &$parser, $frame, $args) {
		$varName = trim( $frame->expand( $args[0] ) ); // first argument expanded already but lets do this anyway
		$varVal = self::get( $parser )->getVarValue( $varName, null );
		
		// default applies if var doesn't exist but also in case it is an empty string!
		if( $varVal === null || $varVal === '' ) {
			// only expand argument when needed:
			$defaultVal = isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';
			return $defaultVal;
		}
		return $varVal;
    }
	
	static function pf_var_final( Parser &$parser, $varName, $defaultVal = '' ) {
		$varStore = self::get( $parser );
		
		return self::get( $parser )->requestFinalizedVar( $parser, $varName, $defaultVal );
	}
	
	
	##############
	# Used Hooks #
	##############
	
	static function onInternalParseBeforeLinks( Parser &$parser, &$text ) {
		
		$varStore = self::get( $parser );
		
		// only do this if '#var_final' was used
		if( $varStore->mFinalizedVarsStripState === null ) {
			return true;
		}
				
		/*
		 * all vars are final now, check whether requested vars can be inserted for '#final_var' or
		 * if the default has to be inserted. In any case, adjust the strip item value
		 */
		foreach( $varStore->mFinalizedVars as $stripStateId => $varName ) {
			
			$varVal = $varStore->getVarValue( $varName, '' );
			if( $varVal !== '' ) {
				// replace strip item value with final variables value or registered default:
				//$varStore->mFinalizedVarsStripState->general->setPair( $stripStateId, $varVal );
				
				$varStore->stripStatePair( $stripStateId, $varVal );
			}
		}
		
		/**
		 * Unstrip all '#var_final' strip-markers with their final '#var' or default values.
		 * This HAS to be done here and can't be done thru the normal unstrip process of MW.
		 * This because the default value as well as the variables value stil have to be rendered properly since they
		 * may contain links or even category links. On the other hand, they can't be parsed with Parser::recursiveTagParse()
		 * since this would parse wiki templates and functions which are intended as normal text, kind of similar to
		 * returning a parser functions value with 'noparse' => true.
		 * Also, there is no way to expand the '#var_final' default value here, just if needed, since the output could be an
		 * entirely different, e.g. if variables are used.
		 * This method also takes care of recursive '#var_final' calls (within the default value) quite well.
		 */
		$text = $varStore->mFinalizedVarsStripState->unstripGeneral( $text );
		
		/*
		 * Sanitize the whole thing, otherwise HTML and JS code injection would be possible.
		 * Basically the same is happening in Parser::internalParse() right before 'InternalParseBeforeLinks' hook is called.
		 */
		$text = Sanitizer::removeHTMLtags(
				$text,
				array( &$parser, 'attributeStripCallback' ),
				false,
				array_keys( $parser->mTransparentTagHooks )
		);
		return true;
	}
		
	/**
	 * This will clean up the variables store after parsing has finished. It will prevent strange things to happen
	 * for example during import of several pages or job queue is running for multiple pages. In these cases variables
	 * would become some kind of superglobals, being passed from one page to the other.
	 */
	static function onParserClearState( Parser &$parser ) {
		/**
		 * MessageCaches Parser clone will mess things up if we don't reset the entire object.
		 * Only resetting the array would unset it in the original object as well! This instead
		 * will break the entire reference to the object
		 */
		$parser->mExtVariables = new self();
		return true;
	}
	
	
	##################
	# Private Helper #
	##################
	
	/**
	 * Takes care of setting a strip state pair in MW 1.18 as well as in previous versions
	 */
	protected function stripStatePair( $marker, $value ) {
		global $wgVersion;		
		if( version_compare( $wgVersion, '1.17.99', '>' ) ) {
			// MW 1.18alpha+
			$this->mFinalizedVarsStripState->addGeneral( $marker, $value );
		} else {
			$this->mFinalizedVarsStripState->general->setPair( $marker, $value );
		}
	}
	
	
	####################################
	# Public functions for interaction #
	####################################
	#
	# public non-parser functions, accessible for
	# other extensions doing interactive stuff
	# with 'Variables' (like Extension:Loops)
	#
	
	/**
	 * Convenience function to return the 'Variables' extensions variables store connected
	 * to a certain Parser object. Each parser has its own store which will be reset after
	 * a parsing process [Parser::parse()] has finished.
	 * 
	 * @param Parser &$parser
	 * 
	 * @return ExtVariables by reference so we still have the right object after 'ParserClearState'
	 */
	public static function &get( Parser &$parser ) {
		return $parser->mExtVariables;
	}
	
	/**
	 * Defines a variable, accessible by getVarValue() or '#var' parser function. Name and
	 * value will be trimmed and converted to string.
	 * 
	 * @param string $varName
	 * @param string $value will be converted to string if no string is given
	 */
	public function setVarValue( $varName, $value = '' ) {
		$this->mVariables[ trim( $varName ) ] = trim( $value );
	}
	
	/**
	 * Returns a variables value or null if it doesn't exist.
	 * 
	 * @param string $varName
	 * @param mixed $defaultVal
	 * 
	 * @return string or mixed in case $defaultVal is being returned and not of type string
	 */
	public function getVarValue( $varName, $defaultVal = null ) {
		$varName = trim( $varName );
        if ( $this->varExists( $varName ) ) {
            return $this->mVariables[ $varName ];
        } else {
            return $defaultVal;
        }
    }
	
	/**
	 * Checks whether a variable exists within the scope.
	 * 
	 * @param string $varName
	 * 
	 * @return boolean
	 */
    public function varExists( $varName ) {
		$varName = trim( $varName );
        return array_key_exists( $varName, $this->mVariables );
    }
	
	/**
	 * Allows to unset a certain variable
	 * 
	 * @param type $varName
	 */
	public function unsetVar( $varName ) {
		unset( $this->mVariables[ $varName ] );
	}
	
	/**
	 * Allows to register the usage of '#var_final'. Meaning a variable can be set as well
	 * as a default value. The return value, a strip-item then can be inserted into any
	 * wikitext processed by the same parser. Later that strip-item will be replaced with
	 * the final var text.
	 * Note: It's not possible to use the returned strip-item within other stripped text
	 *       since 'Variables' unstripping will happen before the general unstripping!
	 * 
	 * @param Parser $parser
	 * @param string $varName
	 * @param string $defaultVal
	 *
	 * @return string strip-item
	 */
	function requestFinalizedVar( Parser &$parser, $varName, $defaultVal = '' ) {
		if( $this->mFinalizedVarsStripState === null ) {
			$this->mFinalizedVarsStripState = new StripState( $parser->mUniqPrefix );
		}
		$id = count( $this->mFinalizedVars );		
		/*
		 * strip-item which will be unstripped in self::onInternalParseBeforeLinks()
		 * In case the requested final variable has a value in the end, this strip-item
		 * value will be replaced with that value before unstripping.
		 */
		$rnd = "{$parser->mUniqPrefix}-finalizedvar-{$id}-" . Parser::MARKER_SUFFIX;
		
		$this->stripStatePair( $rnd, trim( $defaultVal ) );		
		$this->mFinalizedVars[ $rnd ] = trim( $varName );
		
		return $rnd;
	}
	
}
