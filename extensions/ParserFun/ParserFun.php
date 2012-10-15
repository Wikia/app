<?php

/**
 * 'Parser Fun' adds a parser function '#parse' for parsing wikitext and introduces the
 * 'THIS:' prefix for page information related magic variables
 * 
 * Documentation: http://www.mediawiki.org/wiki/Extension:Parser_Fun
 * Support:       http://www.mediawiki.org/wiki/Extension_talk:Parser_Fun
 * Source code:   http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/ParserFun
 * 
 * @version: 0.2
 * @license: ISC license
 * @author:  Daniel Werner < danweetz@web.de >
 *
 * @file ParserFun.php
 * @ingroup Parse
 */
 
if( !defined( 'MEDIAWIKI' ) ) {
    die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

// Include the Validator extension if not loaded already:
if ( ! defined( 'Validator_VERSION' ) ) {
	@include_once( dirname( __FILE__ ) . '/../Validator/Validator.php' );
}

// Only initialize the extension when Validator extension is present:
if ( ! defined( 'Validator_VERSION' ) ) {
	die( '<p><b>Error:</b> You need to have <a href="http://www.mediawiki.org/wiki/Extension:Validator">Validator</a> installed in order to use <a href="http://www.mediawiki.org/wiki/Extension:Parse">Parse</a>.</p>' );
}


// Extension info & credits:
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'Parser Fun',
	'descriptionmsg' => 'parserfun-desc',
	'version'        => ExtParserFun::VERSION,
	'author'         => '[http://www.mediawiki.org/wiki/User:Danwe Daniel Werner]',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Parser_Fun',
);


// Include the settings file:
require_once ExtParserFun::getDir() . '/ParserFun_Settings.php';


// magic words and message files:
$wgExtensionMessagesFiles['ParserFun'     ] = ExtParserFun::getDir() . '/ParserFun.i18n.php';
$wgExtensionMessagesFiles['ParserFunMagic'] = ExtParserFun::getDir() . '/ParserFun.i18n.magic.php';


$wgHooks['ParserFirstCallInit'   ][] = 'ExtParserFun::init';

// for magic word 'THISPAGENAME':
$wgHooks['MagicWordwgVariableIDs'      ][] = 'ExtParserFun::onMagicWordwgVariableIDs';
$wgHooks['ParserGetVariableValueSwitch'][] = 'ExtParserFun::onParserGetVariableValueSwitch';


// Parser function initializations:
$wgAutoloadClasses['ParserFunThis'  ] = ExtParserFun::getDir() . '/includes/PFun_This.php';
$wgAutoloadClasses['ParserFunParse' ] = ExtParserFun::getDir() . '/includes/PFun_Parse.php';
$wgAutoloadClasses['ParserFunCaller'] = ExtParserFun::getDir() . '/includes/PFun_Caller.php';

$wgHooks['ParserFirstCallInit'][] = 'ParserFunParse::staticInit';
$wgHooks['ParserFirstCallInit'][] = 'ParserFunCaller::staticInit';

/**
 * Extension class of the 'Parser Fun' extension.
 * Handling the functionality around the 'THIS' magic word feature.
 */
class ExtParserFun {
	/**
	 * Version of the 'Parser Fun' extension.
	 * 
	 * @since 0.1
	 * 
	 * @var string
	 */
	const VERSION = '0.3';

	static function init( Parser &$parser ) {
		if( self::isEnabledFunction( 'this' ) ) {
			// only register function if not disabled by configuration
			$parser->setFunctionHook( 'this', array( 'ParserFunThis', 'pfObj_this' ), SFH_NO_HASH | SFH_OBJECT_ARGS );
		}
		return true;
	}
	
	/**
	 * returns whether a certain variable/parser function is active by the local wiki configuration.
	 * 
	 * @since 0.2
	 * 
	 * @param type $word
	 * @return bool
	 */
	static function isEnabledFunction( $word ) {
		global $egParserFunEnabledFunctions;
		return in_array( $word, $egParserFunEnabledFunctions );
	}
	
	/**
	 * Returns the extensions base installation directory.
	 *
	 * @since 0.1
	 * 
	 * @return boolean
	 */
	static function getDir() {		
		static $dir = null;
		if( $dir === null ) {
			$dir = dirname( __FILE__ );
		}
		return $dir;
	}
	
	
	##################
	# Hooks Handling #
	##################
	
	static function onParserGetVariableValueSwitch( Parser &$parser, &$cache, &$magicWordId, &$ret, $frame = null ) {
		if( $frame === null ) {
			// unsupported MW version
			return true;
		}
		switch( $magicWordId ) {
			/** THIS **/
			case 'this':
				$ret = ParserFunThis::pfObj_this( $parser, $frame, null );
				break;
			
			/** CALLER **/
			case 'caller':
				$ret = ParserFunCaller::getCallerVar( $frame );
				break;
		}
		return true;
	}
	
	static function onMagicWordwgVariableIDs( &$variableIds ) {		
		// only register variables if not disabled by configuration
		if( self::isEnabledFunction( 'this' ) ) {
			$variableIds[] = 'this';
		}
		if( self::isEnabledFunction( 'caller' ) ) {
			$variableIds[] = 'caller';
		}
		return true;
	}
	
}
