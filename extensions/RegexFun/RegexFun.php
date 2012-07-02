<?php

/**
 * 'Regex Fun' is a MediaWiki extension which adds parser functions for performing regular
 * expression searches and replacements.
 * 
 * Documentation: http://www.mediawiki.org/wiki/Extension:Regex_Fun
 * Support:       http://www.mediawiki.org/wiki/Extension_talk:Regex_Fun
 * Source code:   http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/RegexFun
 * 
 * @version: 1.1
 * @license: ISC license
 * @author:  Daniel Werner < danweetz@web.de >
 *
 * @file RegexFun.php
 * @ingroup RegexFun
 */

if ( ! defined( 'MEDIAWIKI' ) ) { die( ); }


/**** extension info ****/ 

$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'Regex Fun',
	'descriptionmsg' => 'regexfun-desc',
	'version'        => ExtRegexFun::VERSION,
	'author'         => '[http://www.mediawiki.org/wiki/User:Danwe Daniel Werner]',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Regex_Fun',
);

// language files:
$wgExtensionMessagesFiles['RegexFun'     ] = ExtRegexFun::getDir() . '/RegexFun.i18n.php';
$wgExtensionMessagesFiles['RegexFunMagic'] = ExtRegexFun::getDir() . '/RegexFun.i18n.magic.php';

// hooks registration:
$wgHooks['ParserFirstCallInit'][] = 'ExtRegexFun::init';
$wgHooks['ParserClearState'   ][] = 'ExtRegexFun::onParserClearState';
$wgHooks['ParserLimitReport'  ][] = 'ExtRegexFun::onParserLimitReport';

// Include the settings file:
require_once ExtRegexFun::getDir() . '/RegexFun_Settings.php';


/**
 * Extension class with all the regex functions functionality
 * 
 * @since 1.0
 */
class ExtRegexFun {
	
	/**
	 * Version of the 'RegexFun' extension.
	 * 
	 * @since 1.0
	 * 
	 * @var string
	 */
	const VERSION = '1.1';
	
	/**
	 * Sets up parser functions
	 */
	public static function init( Parser &$parser ) {
		self::initFunction( $parser, 'regex', SFH_OBJECT_ARGS );
		self::initFunction( $parser, 'regex_var', SFH_OBJECT_ARGS );
		self::initFunction( $parser, 'regexquote' );
		self::initFunction( $parser, 'regexall' );
		
		return true;		
	}	
	private static function initFunction( Parser &$parser, $name, $flags = 0 ) {		
		global $egRegexFunDisabledFunctions;
		
		// only register function if not disabled by configuration
		if( ! in_array( $name, $egRegexFunDisabledFunctions ) ) {
			// all parser functions with prefix:
			$prefix = ( $flags & SFH_OBJECT_ARGS ) ? 'pfObj_' : 'pf_';
			$functionCallback = array( __CLASS__, $prefix . $name );			
			$parser->setFunctionHook( $name, $functionCallback, $flags );
		}
	}
	
	/**
	 * Returns the extensions base installation directory.
	 *
	 * @since 1.0
	 * 
	 * @return string
	 */
	public static function getDir() {		
		static $dir = null;
		
		if( $dir === null ) {
			$dir = dirname( __FILE__ );
		}
		return $dir;
	}
	
	
	const FLAG_NO_REPLACE_NO_OUT = 'r';
	const FLAG_REPLACEMENT_PARSE = 'e'; // overwrites php 'e' flag
	
	/**
	 * helper store for transmitting some values to a preg_replace_callback function
	 * 
	 * @var array
	 */
	private static $tmpRegexCB;
	
	
	/**
	 * Checks whether the given regular expression is valid or would cause an error.
	 * Also alters the pattern in case it would be a security risk and communicates
	 * about special flags which have no or different meaning in PHP. These will be
	 * removed from the original regex string but put into the &$specialFlags array.
	 * 
	 * @since 1.0
	 * 
	 * @param &$pattern String
	 * @param &$specialFlags array will contain all special flags the $pattern contains
	 * 
	 * @return Boolean
	 */
	public static function validateRegex( &$pattern, &$specialFlags = array() ) {		
		
		$specialFlags = array();
		
		if( strlen( $pattern ) < 2 ) {			
			return false;
		}
		
		$delimiter = substr( trim( $pattern ), 0, 1 );
		$delimiterQuoted = preg_quote( $delimiter, '/' );
		
		// two parts, split by the last delimiter
		$parts = preg_split( "/{$delimiterQuoted}(?=[^{$delimiterQuoted}]*$)/", $pattern, 2 );
		
		$mainPart  = $parts[0] . $delimiter; // delimiter to delimiter without flags
		$flagsPart = $parts[1];
		
		// remove 'e' modifier from final regex since it's a huge security risk with user input!
		self::regexSpecialFlagsHandler( $flagsPart, self::FLAG_REPLACEMENT_PARSE, $specialFlags );
		
		// marks #regex with replacement will output '' in case of no replacement
		self::regexSpecialFlagsHandler( $flagsPart, self::FLAG_NO_REPLACE_NO_OUT, $specialFlags );
		
		// put purified regex back together:
		$newPattern = $mainPart . $flagsPart;
		
		if( ! self::isValidRegex( $newPattern ) ) {
			// no modification to $pattern done!
			$specialFlags = array();
			return false;
		}
		$pattern = $newPattern; // remember reference!
		return true;
	}
	
	/**
	 * Returns whether the regular expression would be a valid one or not.
	 * 
	 * @since 1.0
	 * 
	 * @param $pattern string
	 * 
	 * @return boolean
	 */
	public static function isValidRegex( $pattern ) {
		//return (bool)preg_match( '/^([\\/\\|%]).*\\1[imsSuUx]*$/', $pattern );
		/*
		 * Testing of the pattern in a very simple way:
		 * This takes care of all invalid regular expression use and the ugly php notices
		 * which some other regex extensions for MW won't handle right.
		 */
		wfSuppressWarnings(); // instead of using the evil @ operator!
		$isValid = false !== preg_match( $pattern, ' ' ); // preg_match returns false on error
		wfRestoreWarnings();
		
		return $isValid;
	}
	
	/**
	 * Helper function to check a string of flags for a certain flag and set it as an array key
	 * in a special flags collecting array.
	 */
	private static function regexSpecialFlagsHandler( &$modifiers, $flag, &$specialFlags ) {
		$count = 0;
		$modifiers = preg_replace( "/{$flag}/", '', $modifiers, -1, $count );
		if( $count > 0 ) {
			$specialFlags[ $flag ] = true;
			return true;
		}
		return false;
	}
	
	private static function limitHandler( Parser &$parser ) {		
		// is the limit exceeded for this parsers parse() process?
		if( self::limitExceeded( $parser ) ) {
			return false;
		}		
		self::increaseRegexCount( $parser );
		return true;
	}
	
	/**
	 * Returns a valid parser function output that the given pattern is not valid for a regular
	 * expression. The message can be displayed in the wiki and is wrapped in an error-class span
	 * which can be recognized by #iferror
	 * 
	 * @param $pattern String the invalid regular expression
	 * 
	 * @return Array
	 */
	protected static function msgInvalidRegex( $pattern ) {
		$msg = '<span class="error">' . wfMsgForContent( 'regexfun-invalid', "<tt><nowiki>$pattern</nowiki></tt>" ). '</span>';
		return array( $msg, 'noparse' => false, 'isHTML' => false ); // 'noparse' true for <nowiki>, 'isHTML' false for #iferror!
	}
	
	protected static function msgLimitExceeded() {
		global $egRegexFunMaxRegexPerParse, $wgContLang;
		$msg = '<span class="error">' . wfMsgForContent( 'regexfun-limit-exceed', $wgContLang->formatNum( $egRegexFunMaxRegexPerParse ) ) . '</span>';
		return array( $msg, 'noparse' => true, 'isHTML' => false ); // 'isHTML' must be false for #iferror!
	}
	
	/**
	 * Helper function. Validates regex and takes care of security risks in pattern which is why
	 * the pattern is taken by reference!
	 */
	protected static function validateRegexCall( PPFrame &$frame, $subject, &$pattern, &$specialFlags, $resetLastRegex = false ) {
		if( $resetLastRegex ) {
			//reset last matches for the case anything goes wrong
			self::setLastMatches( $frame , null );
		}        
        if( ! self::validateRegex( $pattern, $specialFlags ) ) {			
			return false;
		}
		if( $resetLastRegex ) {
			// store infos for this regex for '#regex_var'
			self::initLastRegex( $frame, $pattern, $subject );
		}
		return true;
	}
	
    /**
	 * Performs a regular expression search or replacement
	 * Syntax:
	 * {{#regex: subject |pattern |replacement |limit }}
	 * 
	 * subject: input string to evaluate
	 * pattern: regular expression pattern - can use any valid preg delimiter, e.g. /, | or % and various modifiers
	 * replacement: regular expression replacement (optional)
	 * limit: max number of how many matches should be replaced (optional)
	 * 
	 * @return String Result of replacing pattern with replacement in string, or matching text if replacement was omitted
	 */
    //public static function pf_regex( Parser &$parser, $subject = '', $pattern = '', $replacement = null, $limit = -1 ) {		
	public static function pfObj_regex( Parser &$parser, PPFrame $frame, array $args ) {
		// Get Parameters
		$subject     = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		$pattern     = isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';
		$replacement = isset( $args[2] ) ? $args[2] : null; // unexpanded replacement in case 'e' flag is used
		$limit       = isset( $args[3] ) ? trim( $frame->expand( $args[3] ) ) : -1;
		
		// check whether limit exceeded:
		if( self::limitExceeded( $parser ) ) {
			return self::msgLimitExceeded();
		}
		self::increaseRegexCount( $parser );
		
		if( $replacement === null ) {
			// search mode:
			
			// validate, initialise and check for wrong input:
			$continue = self::validateRegexCall( $frame, $subject, $pattern, $specialFlags, true );
			if( ! $continue ) {
				return self::msgInvalidRegex( $pattern );
			}
			
			$lastMatches = self::getLastMatches( $frame );
            $output = ( preg_match( $pattern, $subject, $lastMatches ) ? $lastMatches[0] : '' );
			self::setLastMatches( $frame, $lastMatches );
        }
		else {
			// replace mode:			
			$limit = (int)$limit;
			
			// set last matches to 'false' and get them on demand instead since preg_replace won't communicate them			
			self::setLastMatches( $frame, false );
			
			// do the regex plus all handling of special flags and validation
			$output = self::doPregReplace( $pattern, $replacement, $subject, $limit, $parser, $frame );
			
			if( $output === false ) {
				// invalid regex, don't store any infor for '#regex_var'
				self::setLastMatches( $frame , null );
				return self::msgInvalidRegex( $pattern );
			}
			
			// set these infos only if valid, pattern still contains special flags though
			self::setLastPattern( $frame, $pattern );
			self::setLastSubject( $frame, $subject );
        }
		
		return $output;
    }
	
	/**
	 * 'preg_replace'-like function but can handle special modifiers 'e' and 'r'.
	 * 
	 * @since 1.1
	 * 
	 * @param string  &$pattern
	 * @param PPNode|string  $replacement should be a PPNode in case 'e' flag might be used since in that
	 *                case the string will be expanded after back-refs are inserted. Otherwise string is ok.
	 * @param string  $subject
	 * @param int     $limit
	 * @param Parser  &$parser if 'e' flag should be allowed, a parser object for parsing is required.
	 * @param PPFrame $frame which keeps template parameters which should be used in case 'e' flag is set.
	 * @param array   $allowedSpecialFlags all special flags that should be handled, by default 'e' and 'r'.
	 */
	public static function doPregReplace(
			$pattern, // not by value in here!
			$replacement,
			$subject,
			$limit = -1,
			&$parser = null,
			$frame = null,
			array $allowedSpecialFlags = array(
				self::FLAG_REPLACEMENT_PARSE,
				self::FLAG_NO_REPLACE_NO_OUT,
			)
	) {
		static $lastPattern = null;
		static $activePattern = null;
		static $specialFlags = null;
		
		/*
		 * cache validated pattern and use it as long as nothing has changed, this makes things
		 * faster in case we do a lot of stuff with the same regex.
		 */
		if( $lastPattern === null || $lastPattern !== $pattern ) {
			// remember pattern without validation
			$lastPattern = $pattern;
			
			// if allowed special flags change, we have to validate again^^
			$lastFlags = implode( ',', $allowedSpecialFlags );
			
			// validate regex and get special flags 'e' and 'r' if given:
			if( ! self::validateRegex( $pattern, $specialFlags ) ) {
				// invalid regex!
				$lastPattern = null;
				return false;
			}
			// set validated pattern as active one
			$activePattern = $pattern;
			
			// filter unwanted special flags:
			$allowedSpecialFlags = array_flip( $allowedSpecialFlags );			
			$specialFlags = array_intersect_key( $specialFlags, $allowedSpecialFlags );
		}
		else {
			// set last validated pattern without flags 'e' and 'r'
			$pattern = $activePattern;
		}
		
		// make sure we have a frame to expand the $replacement (necessary for 'e' flag support!)
		if( $frame === null ) {
			// new frame without template parameters then
			$frame = $parser->getPreprocessor()->newCustomFrame( array() );
		}
		
		// FLAG 'e' (parse replace after match) handling:
		if( ! empty( $specialFlags[ self::FLAG_REPLACEMENT_PARSE ] ) ) {
			
			// 'e' requires a Parser for parsing!
			if( ! ( $parser instanceof Parser ) ) {
				// no valid Parser object, without, we can't parse anything!
				throw new MWException( "Regex Fun 'e' flag discovered but no Parser object given!" );
			}
			
			// if 'e' flag is set, each replacement has to be parsed after matches are inserted but before replacing!
			self::$tmpRegexCB = array(
				'replacement' => $replacement,
				'parser'      => &$parser,
				'frame'       => $frame,
				'internal'    => isset( $parser->mExtRegexFun['lastMatches'] ) && $parser->mExtRegexFun['lastMatches'] === false
			);
			
			// do the actual replacement with special 'e' flag handling
			$output = preg_replace_callback( $pattern, array( __CLASS__, 'doPregReplace_eFlag_callback' ), $subject, $limit, $count );
		}
		else {
			$replacement = trim( $frame->expand( $replacement ) );
			// no 'e' flag, we can perform the standard function
			$output = preg_replace( $pattern, $replacement, $subject, $limit, $count );
		}
		

		// FLAG 'r' (no replacement - no output) handling:
		if( ! empty( $specialFlags[ self::FLAG_NO_REPLACE_NO_OUT ] ) ) {				
			/*
			 *  only output replacement result if there actually was a match and therewith a replacement happened
			 * (otherwise the input string would be returned)
			 */
			if( $count < 1 ) {
				return '';
			}
		}
		
		return $output;
	}
	
	private static function doPregReplace_eFlag_callback( $matches ) {
		
		/** Don't cache this since it could contain dynamic content like #var which should be parsed */
		
		$replace  = self::$tmpRegexCB['replacement'];
		$parser   = self::$tmpRegexCB['parser'];
		$frame    = self::$tmpRegexCB['frame'];
		$internal = self::$tmpRegexCB['internal']; // whether doPregReplace() is called as part of a parser function
		
		/*
		 * only do this if set to false before, internally, so we won't destroy things if
		 * doPregReplace() was called from outside 'Regex Fun'
		 */
		if( $internal ) {
			// last matches in #regex replace mode were set to false before, set them now:
			self::setLastMatches( $parser, $matches );
		}
		// replace backrefs with their actual values:
		$replace = trim( $frame->expand( $replace, PPFrame::NO_ARGS | PPFrame::NO_TEMPLATES ) );
		$replace = self::regexVarReplace( $replace, $matches, true );
		
		// parse the replacement after matches are inserted
		$replace = $parser->preprocessToDom( $replace, $frame->isTemplate() ? Parser::PTD_FOR_INCLUSION : 0 );
		$replace = trim( $frame->expand( $replace ) );
				
		return $replace;
	}
	
	/**
	* Performs regular expression searches and returns ALL matches separated
	* 
	* @param $parser Parser instance of running Parser
	* @param $subject String input string to evaluate
	* @param $pattern String regular expression pattern - must use /, | or % as delimiter
	* @param $separator String to separate all the matches
	* @param $offset Integer first match to print out. Negative values possible: -1 means last match.
	* @param $length Integer maximum matches for print out
	 * 
	* @return String result of all matching text parts separated by a string
	*/
	public static function pf_regexall( &$parser , $subject = '' , $pattern = '' , $separator = ', ' , $offset = 0 , $length = '' ) {
		// check whether limit exceeded:
		if( self::limitExceeded( $parser ) ) {
			return self::msgLimitExceeded();
		}
		self::increaseRegexCount( $parser );
		
		// validate and check for wrong input (no effect on #regex_var):
		if( ! self::validateRegex( $pattern, $specialFlags ) ) {
			return self::msgInvalidRegex( $pattern );;
		}
		
		// adjust default values:
		$offset = (int)$offset;
		
		if( trim( $length ) === '' ) {
			$length = null;
		} else {
			$length = (int)$length;
		}

		if( preg_match_all( $pattern, $subject, $matches, PREG_SET_ORDER ) ) {
			
			$matches = array_slice( $matches, $offset, $length );								
			$output = ''; //$end = ($end or ($end >= count($matches)) ? $end : count($matches) );

			for( $count = 0; $count < count( $matches ); $count++ ) {
				if( $count > 0 ) {
					$output .=  $separator;
				}
				$output .= trim( $matches[ $count ][0] );
			}
			return $output;
		}
		return '';
    }
	
	/**
	 * Returns a value from the last performed regex match
	 * 
	 * @index $parser Parser instance of running Parser
	 * @param $index Integer index of the last match which should be returnd or a string containing $n as indexes to be replaced
	 * @param $defaultVal Integer default value which will be returned when the result with the given index doesn't exist or is a void string
	 */
	public static function pfObj_regex_var( Parser &$parser, PPFrame $frame, array $args ) {		
		$index      = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : 0;
		$defaultVal = isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';
		
		// get matches from last #regex
		$lastMatches = self::getLastMatches( $frame );
		
		if( $lastMatches === null ) { // last regex was invalid or none executed yet
			return $defaultVal;
		}
				
		// if requested index is numerical:
		if (preg_match( '/^\d+$/', $index ) ) {
			// if requested index is in matches and isn't '':
			if( array_key_exists( $index, $lastMatches ) && $lastMatches[$index] !== '' )
				return $lastMatches[ $index ];
			else {
				// no match! Return just the default value:
				return $defaultVal;
			}
		} else {
			// complex string is given, something like "$1, $2 and $3":			
			
			// limit check, only in complex mode:
			if( self::limitExceeded( $parser ) ) {
				return self::msgLimitExceeded();
			}
			self::increaseRegexCount( $parser );
			
			// do the actual transformation:
			return self::regexVarReplace( $index, $lastMatches, false );
		}
	}
	
	/**
	 * Replaces all backref variables within a replacement string with the backrefs actual
	 * values just like preg_replace would do it.
	 * 
	 * @param string $replacement
	 * @param array  $matches
	 * @param bool   $forExpansion has to be set in case the 'e' flag should be handled
	 */
	private static function regexVarReplace( $replacement, array $matches, $forExpansion = false ) {
		/*
		 * replace all back-references with their number increased by 1!
		 * this way we can also handle $0 in the right way!
		 */
		$replacement = preg_replace_callback(
				'%(?<!\\\)(?:\$(?:(\d+)|\{(\d+)\})|\\\(\d+))%',
				array( __CLASS__, 'regexVarReplace_increaseBackrefs_callback' ),
				$replacement
		);
		/*
		 * build a helper regex matching all the last matches to use preg_replace
		 * which will handle all the replace-escaping handling correct
		 */
		$regEx = '';
		foreach( $matches as &$match ) {
			if( $forExpansion ) {
				/*
				 * if this is for 'e' flag, we have to escape the matches so they won't break wiki markup
				 * within the replacement in case they contain characters like '|'.
				 */
				$match = self::escapeForExpansion( $match );
			}
			$regEx .= '(' . preg_quote( $match, '/' ) . ')';
		}
		
		$regEx = "/^{$regEx}$/";
		
		return preg_replace( $regEx, $replacement, implode( '', $matches ) );
	}
	
	/**
	 * only used by 'preg_replace_callback' in 'regexVarReplace'
	 */
	private static function regexVarReplace_increaseBackrefs_callback( $matches ) {	
		// find index:
		$index = false;
		$full = $matches[0];
		for( $i = 1; $index === false || $index === '' ; $i++ ) {
			// $index can be false (shouldn't happen), '' or any number (including 0 !)
			if( array_key_exists( $i, $matches ) ) {
				$index = $matches[ $i ];
			} else {
				$index = false;
			}
		}
		return preg_replace( '%\d+%', (int)$index + 1, $full );	
	}	

	/**
	 * takes $str and puts a backslash in front of each character that is part of the regular expression syntax
	 * 
	 * @param $parser Parser instance of running Parser
	 * @param $str String input string to change
	 * @param $delimiter String delimiter which also will be escaped within $str (default is set to '/')
	 * 
	 * @return String Returns the quoted string
	 */
	public static function pf_regexquote( &$parser, $str = null, $delimiter = '/' ) {		
		if( $str === null ) {
			return '';
		}		
		if( $delimiter === '' ) {
			$delimiter = null;
		}
		// do this first! otherwise leading '\' from '\x..' would be doubled!
		$str = preg_quote( $str, $delimiter );
		
		/*
		 * take care of characters that will mess things up if returned as first ones in a string
		 * because they have some special meaning in mediawiki
		 */
		$firstChar = substr( $str, 0, 1 );
		switch( $firstChar ) {
			// '*' and ':' is taken care of by preg_quote already
			case '#':
			case ';':
				// e.g. first char as '\x23' in case of '#'
				$str = '\\x' . dechex( ord( $firstChar ) ) . substr( $str, 1 );
				break;
		}
		return $str;
	}
	
    public static function onParserLimitReport( $parser, &$report ) {
		global $egRegexFunMaxRegexPerParse;
		$count = self::getLimitCount( $parser );
		
		$report .= 'ExtRegexFun count: ';
		
		if( $egRegexFunMaxRegexPerParse !== -1 ) {
			$report .= "{$count}/{$egRegexFunMaxRegexPerParse}\n";
		}
		else {
			$report .= "{$count}\n";
		}
        return true;
    }
	
	
	/**
	 * Escapes a string so it can be used within PPFrame::expand() expansion without actually being
	 * changed because of special characters.
	 * Respects the configuration variable '$egRegexFunExpansionEscapeTemplates'.
	 * 
	 * This is a workaround for bug #32829
	 * 
	 * @since 1.1
	 * 
	 * @param string $string
	 * @return string
	 */
	public static function escapeForExpansion( $string ) {
		global $egRegexFunExpansionEscapeTemplates;
		
		if( $egRegexFunExpansionEscapeTemplates === null ) {
			return $string;
		}
		
		$string = strtr(
			$string,
			$egRegexFunExpansionEscapeTemplates		
		);
		
		return $string;
	}
	
	
	/***********************************
	 ****   HELPER - For store of   ****
	 **** regex stuff within Parser ****
	 ***********************************
	 ****
	 **
	 * Adding the info to each Parser object makes it invulnerable to new Parser objects being created
	 * and destroyed throughout main parsing process. Only the one parser, 'ParserClearState' is called
	 * on will losse its data since the parsing process has been declared finished and the data won't be
	 * needed anymore.
	 **
	 ***/
	
	protected static function initLastRegex( PPFrame $frame, $pattern, $subject ) {
		self::setLastMatches( $frame, array() );
		self::setLastPattern( $frame, $pattern );
		self::setLastSubject( $frame, $subject );
	}
	
	public static function onParserClearState( &$parser ) {
		//cleanup to avoid conflicts with job queue or Special:Import
		/*
		$parser->mExtRegexFun = array();
		self::setLastMatches( $parser, null );
		self::setLastPattern( $parser, '' );
		self::setLastSubject( $parser, '' );		
		*/
		$parser->mExtRegexFun['counter'] = 0;
		
		return true;
	}
	
	/**
	 * Returns whether the maximum limit of regular expression has been exceeded
	 * for the given parser objects current Parser::parse() process.
	 * 
	 * @return boolean
	 */
	public static function limitExceeded( Parser &$parser ) {		
		global $egRegexFunMaxRegexPerParse;
		return (
			$egRegexFunMaxRegexPerParse !== -1
			&& $parser->mExtRegexFun['counter'] >= $egRegexFunMaxRegexPerParse
		);
	}
	
	public static function getLimitCount( Parser &$parser ) {
		if( isset( $parser->mExtRegexFun['counter'] ) ) {
			return $parser->mExtRegexFun['counter'];
		}
		return 0;
	}
	
	private static function increaseRegexCount( Parser &$parser ) {
		$parser->mExtRegexFun['counter']++;		
	}
	
	/**
	 * Returns the last regex matches done by #regex in the context of the same frame.
	 * 
	 * @param PPFrame $frame
	 * @return array|null
	 */
	public static function getLastMatches( PPFrame $frame ) {
				
		if( isset( $frame->mExtRegexFun['lastMatches'] ) ) {
			
			// last matches are set to false in case last regex was in replace mode! Get them on demand:
			if( $frame->mExtRegexFun['lastMatches'] === false ) {
				// first, validate pattern to remove special flags!
				$pattern = self::getLastPattern( $frame );
				self::validateRegex( $pattern );
				preg_match(
						$pattern,
						self::getLastSubject( $frame ),
						$frame->mExtRegexFun['lastMatches']
				);
			}			
			return $frame->mExtRegexFun['lastMatches'];
		}
		return null;
	}	
	protected static function setLastMatches( PPFrame $frame, $value ) {
		$frame->mExtRegexFun['lastMatches'] = $value;
	}
	
	public static function getLastPattern( PPFrame $frame ) {
		if( isset( $frame->mExtRegexFun['lastPattern'] ) ) {
			return $frame->mExtRegexFun['lastPattern'];
		}
		return '';
	}
	protected static function setLastPattern( PPFrame $frame, $value ) {
		$frame->mExtRegexFun['lastPattern'] = $value;
	}
	
	public static function getLastSubject( PPFrame $frame ) {
		if( isset( $frame->mExtRegexFun['lastSubject'] ) ) {
			return $frame->mExtRegexFun['lastSubject'];
		}
		return '';
	}
	protected static function setLastSubject( PPFrame $frame, $value ) {
		$frame->mExtRegexFun['lastSubject'] = $value;
	}
	
}