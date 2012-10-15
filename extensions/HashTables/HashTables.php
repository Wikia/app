<?php

/**
 * Defines a subset of parser functions to handle hash tables. Inspired by the ArrayExtension
 * (http://www.mediawiki.org/wiki/Extension:ArrayExtension).
 *
 * @version: 1.0 alpha
 * @author:  Daniel Werner < danweetz@web.de >
 * @license: ISC license
 * 
 * Documentation: http://www.mediawiki.org/wiki/Extension:HashTables
 * Support:       http://www.mediawiki.org/wiki/Extension_talk:HashTables
 * Source code:   http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/HashTables
 *
 * @file HashTables.php
 * @ingroup HashTables
 *
 * @ToDo:
 * ======
 * Thinking about:
 * - Sort function
 * - Search function
 */
 
if( ! defined( 'MEDIAWIKI' ) ) { die(); }

$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'HashTables',
	'descriptionmsg' => 'hashtables-desc',
	'version'        => ExtHashTables::VERSION,
	'author'         => '[http://www.mediawiki.org/wiki/User:Danwe Daniel Werner]',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:HashTables',
);

// language files:
$wgExtensionMessagesFiles['HashTables'     ] = ExtHashTables::getDir() . '/HashTables.i18n.php';
$wgExtensionMessagesFiles['HashTablesMagic'] = ExtHashTables::getDir() . '/HashTables.i18n.magic.php';

// hooks registration:
$wgHooks['ParserFirstCallInit'][] = 'ExtHashTables::init';
$wgHooks['ParserClearState'   ][] = 'ExtHashTables::onParserClearState';

// Include the settings file:
require_once ExtHashTables::getDir() . '/HashTables_Settings.php';


/**
 * Extension class with all the hash table functionality, also serves as store for hash tables per
 * Parser object and offers public accessors for interaction with HashTables extension.
 */
class ExtHashTables {

	/**
	 * Version of the 'HashTables' extension.
	 * 
	 * @since 0.6.1
	 * 
	 * @var string
	 */
	const VERSION = '1.0 alpha';

	/**
	 * @since 0.1
	 * 
	 * @var array
	 * @private
	 */
    var $mHashTables = array();
	
	/**
	 * Sets up parser functions
	 * 
	 * @since 1.0
	 */
	public static function init( Parser &$parser ) {
		/*
		 * store for hash tables per Parser object. This will solve several bugs related to
		 * 'ParserClearState' hook clearing all variables early in combination with certain
		 * other extensions. (since v1.0)
		 */
		$parser->mExtHashTables = new self();
		
		// SFH_OBJECT_ARGS available since MW 1.12
		self::initFunction( $parser, 'hashdefine' );
		self::initFunction( $parser, 'hashsize' );
		self::initFunction( $parser, 'hashvalue', SFH_OBJECT_ARGS );
		self::initFunction( $parser, 'hashkeyexists', SFH_OBJECT_ARGS );
		self::initFunction( $parser, 'hashprint', SFH_OBJECT_ARGS );
		self::initFunction( $parser, 'parameterstohash', SFH_OBJECT_ARGS );
		self::initFunction( $parser, 'hashtotemplate', SFH_OBJECT_ARGS );
		self::initFunction( $parser, 'hashinclude', SFH_OBJECT_ARGS );
		self::initFunction( $parser, 'hashexclude', SFH_OBJECT_ARGS );
		self::initFunction( $parser, 'hashreset', SFH_OBJECT_ARGS );
		self::initFunction( $parser, 'hashmerge', SFH_OBJECT_ARGS );
		self::initFunction( $parser, 'hashmix', SFH_OBJECT_ARGS );
		self::initFunction( $parser, 'hashdiff',  SFH_OBJECT_ARGS );
		self::initFunction( $parser, 'hashintersect', SFH_OBJECT_ARGS );

		// if array extension is available, rgister array-hash interactions:
		if( class_exists( 'ArrayExtension' ) || class_exists( 'ExtArrays' ) ) {
			self::initFunction( $parser, 'hashtoarray' );
			self::initFunction( $parser, 'arraytohash' );
		}
		
		return true;
	}
	private static function initFunction( Parser &$parser, $name, $flags = 0 ) {
		// all parser functions with prefix:
		$prefix = ( $flags & SFH_OBJECT_ARGS ) ? 'pfObj_' : 'pf_';
		$functionCallback = array( __CLASS__, $prefix . $name );
				
		$parser->setFunctionHook( $name, $functionCallback, $flags );
	}
	
	/**
	 * Returns the extensions base installation directory.
	 *
	 * @since 1.0
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
	
	/**
	 * Define a hash by a list of 'values' deliminated by 'itemsDelimiter'.
	 * Hash keys and their values are deliminated by 'innerDelimiter'.
	 * Both delimiters can be perl regular expression patterns.
	 * Syntax: {{#hashdefine:hashId |values |itemsDelimiter |innerDelimiter}}
	 */
    static function pf_hashdefine( Parser &$parser, $hashId, $value = '', $itemsDelimiter = '/\s*,\s*/', $innerDelimiter = '/\s*;\s*/' ) {
		if( ! isset( $hashId ) ) {
			return '';
		}
		$store = self::get( $parser );
				
		$store->setHash( $hashId );
		
        if( $value !== '' ) {
			// Build delimiters:
            if( ! self::isValidRegEx($itemsDelimiter,'/') ) {
                $itemsDelimiter = '/\s*' . preg_quote( $itemsDelimiter, '/' ) . '\s*/';
			}
			
            if( ! self::isValidRegEx($innerDelimiter,'/') ) {
                $innerDelimiter = '/\s*' . preg_quote( $innerDelimiter, '/' ) . '\s*/';
			}
			
			$items = preg_split( $itemsDelimiter, $value ); // All hash Items
			
			foreach( $items as $item ) {
				$hashPair = preg_split( $innerDelimiter, $item, 2 );
				
				if( count($hashPair) < 2 ) {
					// only hash-Name given, could be even '', no value
					$store->setHashValue( $hashId, $item, '' );
				} else {
					$store->setHashValue( $hashId, $hashPair[0], $hashPair[1] );
				}
			}
        }
                
        return '';
    }
	
	/**
	 * Returns the value of the hash table item identified by a given item name.
	 */
	static function pfObj_hashvalue( Parser &$parser, PPFrame $frame, $args ) {
		// Get Parameters:
		if( ! isset( $args[1] ) ) {
			return '';
		}
		$key = trim( $frame->expand( $args[1] ) );
		$hashId = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		
		// Get value from index:
        $value = self::get( $parser )->getHashValue( $hashId, $key, '' );
		
		if( $value === '' ) {
			// hash or value doesn't exist or is empty ''
			// only expand default when needed!
			$value = isset( $args[2] ) ? trim( $frame->expand( $args[2] ) ) : '';
		}
		
		return $value;
    }
	
	/**
	 * Returns the size of a hash table. Returns '' if the table doesn't exist.
	 */
    static function pf_hashsize( Parser &$parser, $hashId) {
		$store = self::get( $parser );
		
		/*
		 * in old ArrayExtension tradition, return '' if hash doesn't exist.
		 * Though it might be a bit confusing in the beginning, we won't need any '#hashexists' function
		 */
		if( ! isset( $hashId ) || ! $store->hashExists( $hashId ) ) {
			return '';
        }
		$hash = $store->getHash( $hashId );
        return count( $hash );
    }
	
	/**
	 * Returns "1" or the third parameter (if set) if the hash item key 'key' exists inside the hash
	 * table 'hashId'. Otherwise the output will be a void string or the fourth (if set).
	 */
    static function pfObj_hashkeyexists( Parser &$parser, PPFrame $frame, $args ) {
        $hashId = trim( $frame->expand( $args[0] ) );
        $key = isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';
				
		// only expand the one argument needed:
		if( self::get( $parser )->getHashValue( $hashId, $key ) !== null ) {
			return isset( $args[2] ) ? trim( $frame->expand( $args[2] ) ) : '1'; // true '1'
		}
		else {
			return isset( $args[3] ) ? trim( $frame->expand( $args[3] ) ) : ''; // false ''
		}
    }
	
	/**
	 * Allows to print all entries of a hash table seperated by a delimiter.
	 * Syntax:
	 *   {{#hashprint:hashID |seperator |keyPattern |valuePattern |subject |printOrderArrayId}}
	 */
    static function pfObj_hashprint( Parser &$parser, PPFrame $frame, $args ) {
        $hashId = trim( $frame->expand( $args[0] ) );
		$hash = self::get( $parser )->getHash( $hashId );
		
		if( $hash === null ) {
			// hash to print doesn't exist!
			return '';
		}
		
		// parameter validation:
		
		global $wgLang;
        $seperator = isset( $args[1] )
				? trim( $frame->expand( $args[1] ) )
				: $wgLang->getMessageFromDB( 'comma-separator' ); // use local languages default, for English ', '
		/*
		 * PPFrame::NO_ARGS and PPFrame::NO_TEMPLATES for expansion make a lot of sense here since the patterns getting replaced
		 * in $subject before $subject is being parsed. So any template or argument influence in the patterns wouldn't make any
		 * sense in any sane scenario.
		 */
        $keyPattern =        isset( $args[2] ) ? trim( $frame->expand( $args[2], PPFrame::NO_ARGS | PPFrame::NO_TEMPLATES ) ) : '';
        $valuePattern =      isset( $args[3] ) ? trim( $frame->expand( $args[3], PPFrame::NO_ARGS | PPFrame::NO_TEMPLATES ) ) : '';
        $subject =           isset( $args[4] ) ? trim( $frame->expand( $args[4], PPFrame::NO_ARGS | PPFrame::NO_TEMPLATES ) ) : null;
		$printOrderArrayId = isset( $args[5] ) ? trim( $frame->expand( $args[5] ) ) : null;
		
		
		if( $subject === null ) {
			// if there is no subject, there is no point in expanding. Faster!
			return implode( $seperator, $hash );
		}
		
		if( $printOrderArrayId !== null ) {
			// get print order array
			$printOrderArray = self::getArrayExtensionArray( $parser, $printOrderArrayId );
			
			// if array with print order doesn't exist or is empty
			if( empty( $printOrderArray ) ) {
				return '';
			}
		}
		else {
			// No print order given, copy hash keys in print order array
			$printOrderArray = array_keys( $hash );
		}
		
        $renderedResults = array();
		
		foreach( $printOrderArray as $itemKey ) {
			if( ! array_key_exists( $itemKey, $hash ) ) {
				continue;
			}
			$itemVal = $hash[ $itemKey ]; // get value of the current print item from the values array			
			$rawResult = $subject;
			
			if( $keyPattern !== '' ) {
				// escape special chars in hash key and insert it into subject placeholders
				$itemKey = self::escapeForExpansion( $itemKey );
				$rawResult = str_replace( $keyPattern, $itemKey, $rawResult );
			}
			if( $valuePattern !== '' ) {
				// escape special chars in hash value and insert it into subject placeholders
				$itemVal = self::escapeForExpansion( $itemVal );
				$rawResult = str_replace( $valuePattern, $itemVal, $rawResult );
			}
			
			// parse the statement, check for template context to handle noinclude/includeonly the right way
			$rawResult = $parser->preprocessToDom( $rawResult, $frame->isTemplate() ? Parser::PTD_FOR_INCLUSION : 0 );
			$rawResult = trim( $frame->expand( $rawResult ) );
			
			$renderedResults[] = $rawResult ;
        }
		
        $output = implode( $seperator, $renderedResults );
		unset( $renderedResults );
		
		global $egHashTablesExpansionEscapeTemplates;
		if( $egHashTablesExpansionEscapeTemplates === null ) {
			// COMPATIBLITY-MODE - old behavior was to parse everything twice, following the old 'ArrayExtension'
			/*
			 * don't leave the final parse to Parser::braceSubstitution() since there are some special cases where it
			 * would produce unexpected output (it uses a new child frame and ignores whether the frame is a template!)
			 */
			$output = $parser->preprocessToDom( $output, $frame->isTemplate() ? Parser::PTD_FOR_INCLUSION : 0 );
			$output = $frame->expand( $output );
		}
		
        return trim( $output );
    }
	
	/**
	 * Define an hash filled with all given parameters of the current template.
	 * In case there are no parameters, the hash will be void.
	 */
    static function pfObj_parameterstohash( &$parser, PPFrame $frame, $args) {
		if( ! isset( $args[0] ) ) {
			return '';
		}
		$store = self::get( $parser );
		
		$hashId = trim( $frame->expand( $args[0] ) );
		$store->setHash( $hashId );  // create empty hash table

		// in case the page is not used as template i.e. when displayed on its own
		if( ! $frame->isTemplate() ) {
			return '';
		}

		$templateArgs = $frame->getArguments();

		foreach( $templateArgs as $argName => $argVal ) {
			// one hash value for each parameter
			$store->setHashValue( $hashId, $argName, $argVal );
		}
		return '';
    }

	/**
	 * Resets the hashes given in parameter 1 to n. If there are no parameters given,
	 * the function will reset all hashes.
	 */
	static function pfObj_hashreset( &$parser, $frame, $args) {
		$store = self::get( $parser );
		
		// reset all hash tables if no specific tables are given:
		if( ! isset( $args[0] ) || ( $args[0] === '' && count( $args ) == 1 ) ) {
			$store->mHashTables = array();
		}
		else {
			// reset specific hash tables:
			foreach( $args as $arg ) {
				$hashId = trim( $frame->expand( $arg ) );
				$store->unsetHash( $hashId );
			}
		}
		return '';
    }
	
	/**
	 * Adds new keys and values to a hash table. This function can also be used as alternative
	 * way to create hash tables.
	 * Syntax:
	 *   {{#hashinclude:hashID |key1=val1 |key2=val2 |... |key n=val n}}
	 */
	static function pfObj_hashinclude( &$parser, $frame, $args) {
		// get hash table ID from first parameter:
		$hashId = trim( $frame->expand( $args[0] ) );
		unset( $args[0] );
		
		$store = self::get( $parser );
		
		if( ! $store->hashExists($hashId) ) {
			$store->setHash( $hashId );
		}
		
		// all following parameters contain hash table keys and values '|key=value'
		foreach ( $args as $arg ) {
			$argString = $frame->expand($arg);
			$argItem = explode( '=', $argString, 2 );
			$argName = $argItem[0];
			$argVal = ( count( $argItem ) > 1 ) ? $argItem[1] : '';
			
			// set the value (this will trim the values as well)
			$store->setHashValue( $hashId, $argName, $argVal );
		}
		return '';
	}

	/**
	 * Removes certain given keys from a hash table.
	 * Syntax:
	 *   {{#hashexclude:hashID |key1 |key2 |... |key n}}
	 */
	static function pfObj_hashexclude( &$parser, $frame, $args) {
		// get hash table ID from first parameter:
		$hashId = trim( $frame->expand($args[0]) );
		unset( $args[0] );
		
		$store = self::get( $parser );
		
		if( ! $store->hashExists( $hashId ) ) {
			return'';
		}
		
		// all following parameters contain hash table keys and values '|key=value'
		foreach ( $args as $arg ) {
			$argName = trim( $frame->expand($arg) );
			$store->unsetHashValue( $hashId, $argName );
		}
		return '';
	}
	
	/**
	 * Merge two or more hash tables like the php function 'array_merge' would merge them.
	 * Operated on just one hash, this will just re-organize numeric keys.
	 * Syntax:
	 *   {{#hashmerge:hashID |hash1 |hash2 |... |hash n}}
	 */
	static function pfObj_hashmerge( &$parser, $frame, $args) {
		self::get( $parser )->multiHashOperation( $frame, $args, __FUNCTION__, true );
		return '';
	}
	private function multi_hashmerge( $hash1, $hash2 = array() ) {
		return array_merge( $hash1, $hash2 );
	}
	
	/**
	 * Mix two or more hash tables. For the most part this function works like 'hashmerge' with one exception:
	 * Numeric hash table keys will be treated like string keys.
	 * Syntax:
	 *   {{#hashmix:hashID |hash1 |hash2 |... |hash n}}
	 */
	static function pfObj_hashmix( &$parser, $frame, $args) {
		self::get( $parser )->multiHashOperation( $frame, $args, __FUNCTION__, false );
		return '';
	}
	private function multi_hashmix( $hash1, $hash2 ) {
		// copy all entries from hash2 to hash1
		foreach($hash2 as $key => $value) {
			$hash1[ $key ] = $value;
		}
		return $hash1;
	}
	
	/**
	 * Compare two or more hash tables like the php function 'array_diff_key' would compare them.
	 * All items contained in the first array but in none of the other ones will end up in the
	 * new hash table.
	 * Syntax:
	 *   {{#hashdiff:hashID |hash1 |hash2 |... |hash n}}
	 */
	static function pfObj_hashdiff( &$parser, $frame, $args) {
		self::get( $parser )->multiHashOperation( $frame, $args, __FUNCTION__, false );
		return '';
	}
	private function multi_hashdiff( $hash1, $hash2 ) {
		return array_diff_key( $hash1, $hash2 );
	}

	/**
	 * Compare two or more hash tables like the php function 'array_intersect_key' would compare them.
	 * Creates a new hash table containing all entries of 'hash1' which are present in the other
	 * hash tables given in parameters 3 to n.
	 * Syntax:
	 *   {{#hashintersect:hashID |hash1 |hash2 |... |hash n}}
	 */
	static function pfObj_hashintersect( &$parser, $frame, $args) {
		self::get( $parser )->multiHashOperation( $frame, $args, __FUNCTION__, false );
		return '';
	}
	private function multi_hashintersect( $hash1, $hash2 ) {
		return array_intersect_key( $hash1, $hash2 );
	}
	
	/**
	 * Create an array from a hash tables values. Optional a seccond array with the keys. If the 'valArrayID'
	 * equals the 'keyArrayID', the array will contain only the key names and not the values.
	 * Syntax:
	 *   {{#hashtoarray:valArrayID |hashID |keyArrayID}}
	 */
	static function pf_hashtoarray( Parser &$parser, $valArrayId, $hashId = null, $keyArrayId = null) {
		if( ! isset( $hashId ) ) {
			return '';
		}
		
		// create void arrays in case hash doesn't exist
		$valArray = array();
		$keyArray = array();
		
		$hash = self::get( $parser )->getHash( $hashId );
		
		if( $hash !== null ) {
			foreach( $hash as $hashKey => $hashVal ) {
				$valArray[] = $hashVal;
				if( $keyArrayId !== null ) {
					// for additional array with keys
					$keyArray[] = $hashKey;
				}
			}
		}
		
		// set value array:
		self::setArrayExtensionArray( $parser, $valArrayId, $valArray );
				
		if( $keyArrayId !== null ) {
			// additional array for hash keys:
			self::setArrayExtensionArray( $parser, $keyArrayId, $keyArray );
		}
		return '';
	}
	
	/**
	 * Create a hash table from an array.
	 * Syntax:
	 *   {{#arraytohash:hashID |valuesArrayID |keysArrayID}}
	 *
	 * The 'keysArrayID' is optional. If set the items in this array will end up as keys in
	 * the new hash table.
	 */
	static function pf_arraytohash( Parser &$parser, $hashId, $valArrId = null, $keyArrId = null) {
		if( $valArrId === null ) {
			self::get( $parser )->setHash( $hashId );
			return '';
		}
		
		global $wgArrayExtension;
		
		// get array with values:
		$valArray = self::getArrayExtensionArray( $parser, $valArrId );
		if( $valArray === null ) {
			$valArray = array();
		}
		// get array with keys for hash:
		if( $keyArrId !== null ) {
			$keyArray = self::getArrayExtensionArray( $parser, $keyArrId );
		} else {
			$keyArray = null;
		}
						
		// if no key array is given OR the key array doesn't exist
		if( $keyArray === null )
		{
			// Copy the whole array. Result will be a hash with numeric keys
			$newHash = $valArray;
		}
		else
		{
			$newHash = array();
			
			for( $i=0; $i < count( $keyArray ); $i++ ) {
				$currVal = array_key_exists( $i, $valArray ) ? trim( $valArray[ $i ] ) : '';
				$currKey = trim( $keyArray[ $i ] );
				$newHash[ $currKey ] = $currVal;
			}
		}
			
		self::get( $parser )->setHash( $hashId, $newHash );
		return '';
	}
	
	
	/**
	 * Allows to call a template with keys of a hash table as parameters and their values as parameter values.
	 * The pipe-replace parameter allows to define a string which will replace '|' pipes. Can be useful to preserve
	 * links. Default replacement string is '&#124;'. '{{((}}!{{))}}' could be useful in case those templates exist.
	 * Syntax:
	 *   {{#hashtotemplate:template |hash |pipe-replacer}}
	 */
    static function pfObj_hashtotemplate( Parser &$parser, $frame, $args ) {
		if( ! isset( $args[0] ) || ! isset( $args[1] ) ) {
			return '';
		}
		
		global $egHashTablesExpansionEscapeTemplates;
		$store = self::get( $parser );
		
        $template = trim( $frame->expand($args[0] ) );
        $hashId   = trim( $frame->expand($args[1] ) );
		if( $egHashTablesExpansionEscapeTemplates === null ) {
			// COMPATIBILITY-MODE
			// third parameter is depreciated since 1.0 in case we can auto-escape
			$pipeReplacer = isset($args[2]) ? trim( $frame->expand( $args[2] ) ) : '&#124;';
		}
		
		if( ! $store->hashExists( $hashId ) ) {
			return '';
		}
		
        $params = $store->getHash( $hashId );
		$templateCall = '{{' . $template;		
		
		foreach( $params as $paramKey => $paramValue ){			
			if( $egHashTablesExpansionEscapeTemplates !== null ) {
				// escape all special chars so template call won't get destroyed by user values
				$paramKey   = self::escapeForExpansion( $paramKey );
				$paramValue = self::escapeForExpansion( $paramValue );
			} else {
				// COMPATIBILITY-MODE
				$replacedValues = str_replace(
						array( '{', '}', '|' ),
						array( '&#123;', '&#125;', $pipeReplacer ),
						array( $paramKey, $paramValue )
				);
				$paramKey   = $replacedValues[0];
				$paramValue = $replacedValues[1];
			}
			$templateCall .= "|$paramKey=$paramValue";
		}
		$templateCall .= '}}';
		
		// parse template call:
		$result = $parser->preprocessToDom( $templateCall, $frame->isTemplate() ? Parser::PTD_FOR_INCLUSION : 0 );
		$result = trim( $frame->expand( $result ) );
		
		// we don't have to set 'noparse' to false since parsing is done above
		return array( $result , 'noparse' => true, 'isHTML' => false );
	}
	
	
	##################
	# Private Helper #
	##################
	
	/**
	 * Gets an array from ArrayExtension, returns null if the extension wasn't found or
	 * the array doesn't exist.
	 * Handles different versions of ArrayExtension.
	 * 
	 * @since 1.0
	 * 
	 * @return array|null
	 */
	protected static function getArrayExtensionArray( $parser, $arrayId ) {
		// null will be retunded if no array found
		$array = null;
		
		if( class_exists( 'ExtArrays' ) ) {
			// ArrayExtension 2.0+
			$array = ExtArrays::get( $parser )->getArray( $arrayId );
		}
		elseif( isset( $wgArrayExtension ) && isset( $wgArrayExtension->mArrayExtension ) ) {
			// ArrayExtension before 2.0
			if( array_key_exists( $arrayId, $wgArrayExtension->mArrayExtension ) ) {
				// array exist
				$array = $wgArrayExtension->mArrayExtension[ $arrayId ];
			}
		}
		
		return $array;
	}
	
	/**
	 * Sends an array to ArrayExtension and stores it. Takes care of different ArrayExtension versions.
	 * The array should be sanitized in case ArrayExtension before 2.0 is being used.
	 * 
	 * @since 1.0
	 * 
	 * @return boolean whether array was sent to ArrayExtension successful
	 */
	protected static function setArrayExtensionArray( $parser, $arrayId, $array = array() ) {
		if( class_exists( 'ExtArrays' ) ) {
			// ArrayExtension 2.0+
			ExtArrays::get( $parser )->createArray( $arrayId, $array );
			return true;
		}
		elseif( isset( $wgArrayExtension ) && isset( $wgArrayExtension->mArrayExtension ) ) {
			// ArrayExtension before 2.0
			if( array_key_exists( $arrayId, $wgArrayExtension->mArrayExtension ) ) {
				// array exist
				$array = $wgArrayExtension->mArrayExtension[ $arrayId ];
			} else {
				$array = array();
			}
		}
		return false;
	}
	
	/**
	 * Base function for operations with multiple hashes given thru n parameters
	 * $operationFunc expects a function name prefix (suffix 'multi_') with two parameters
	 * $hash1 and $hash2 which will perform an action between $hash1 and hash2 which will
	 * result into a new $hash1. There can be 1 to n $hash2 in the whole process.
	 * 
	 * @param $frame PPFrame
	 * @param $args array
	 * @param $operationFunc string name of the function calling this. There must be a counterpart
	 *        function with prefix 'multi_' which should have two parameters. Both parameters
	 *        will receive a hash (array), the function must return the result hash of the
	 *        processing.
	 * @param $runFuncOnSingleHash boolean whether the $operationFunc function should be run in case
	 *        only one hash table id is given. If not, the original hash will end up in the new hash.
	 */
	protected function multiHashOperation( PPFrame $frame, array $args, $operationFunc, $runFuncOnSingleHash = true ) {
		$lastHash = null;
		$operationRan = false;
		$finalHashId = trim( $frame->expand( $args[0] ) );
		$operationFunc = 'multi_' . preg_replace( '/^pfObj_/', '', $operationFunc );
		
		// For all hashes given in parameters 2 to n (ignore 1 because this is the name of the new hash)
		for( $i = 1; $i < count( $args ); $i++ ) {
			// just make sure we don't fall into gaps of given arguments:
			if( ! array_key_exists( $i, $args ) )  {
				continue;
			}
			$argHashId = trim( $frame->expand( $args[ $i ] ) );
			
			// ignore all tables which do not exist
			if( $this->hashExists( $argHashId ) ) {
				$argHash = $this->getHash( $argHashId );
				if( $lastHash === null ) {
					// first valid hash table, process together with second...
					$lastHash = $argHash;
				}
				else {
					// second or later hash table, process with previous:
					$lastHash = $this->{ $operationFunc }( $lastHash, $argHash ); // perform action between last and current hash
					$operationRan = true;
				}
			}
		}
		
		// in case no hash was given at all:
		if( $lastHash === null ) {
			$lastHash = array();
		}
		
		// if the operation didn't run because there was only one or no array:
		if( ! $operationRan && $runFuncOnSingleHash ) {
			$lastHash = $this->{ $operationFunc }( $lastHash );
		}
				
		$this->setHash( $finalHashId, $lastHash );
	}
	
	
	##############
	# Used Hooks #
	##############
	
	/**
	 * This will clean up the hash table store after parsing has finished. It will prevent strange things to happen
	 * for example during import of several pages or job queue is running for multiple pages. In these cases hashes
	 * would become some kind of superglobals, being passed from one page to the other.
	 */
	static function onParserClearState( Parser &$parser ) {
		/**
		 * MessageCaches Parser clone will mess things up if we don't reset the entire object.
		 * Only resetting the array would unset it in the original object as well! This instead
		 * will break the entire reference to the object
		 */
		$parser->mExtHashTables = new self();
		return true;
	}
	
	
	####################################
	# Public functions for interaction #
	####################################
	#
	# public non-parser functions, accessible for
	# other extensions doing interactive stuff
	# with 'HashTables' extension.
	#
	
	/**
	 * Convenience function to return the 'HashTables' extensions hash table store connected
	 * to a certain Parser object. Each parser has its own store which will be reset after
	 * a parsing process [Parser::parse()] has finished.
	 * 
	 * @since 1.0
	 * 
	 * @param Parser &$parser
	 * 
	 * @return ExtHashTables by reference so we still have the right object after 'ParserClearState'
	 */
	public static function &get( Parser &$parser ) {
		return $parser->mExtHashTables;
	}
	
	/**
	 * Returns an hash identified by $hashId. If it doesn't exist this will return null.
	 * 
	 * @since 0.6
	 * 
	 * @param string $hashId
	 * 
	 * @return array|null
	 */
    public function getHash( $hashId ) {
		$hashId = trim( $hashId );
		if( $this->hashExists( $hashId ) ) {
			return $this->mHashTables[ $hashId ];
		}
		return null;
    }
	
	/**
	 * This will add a new hash or overwrite an existing one. Values should be delliverd as array
	 * values in form of a string. All values will be converted to strings, trim() will iterate
	 * over them.
	 * 
	 * @since 1.0
	 * 
	 * @param string $hashId
	 * @param array  $hashTable
	 */
	public function createHash( $hashId, array $hashTable = array() ) {
		$hashTable = array_map( 'trim', $hashTable ); // make it all string and trim
		$this->mHashTables[ trim( $hashId ) ] = $hashTable;
	}
	
	/**
	 * Same as public setHash() but without sanitizing the input array first (faster).
	 */
	protected function setHash( $hashId, array $hashTable = array() ) {
		$this->mHashTables[ trim( $hashId ) ] = $hashTable;
	}
	
	/**
	 * Returns a value within a hash. If key or hash do not exist, this will return null
	 * or another predefined default.
	 * 
	 * @since 0.7
	 * 
	 * @param string $hashId
	 * @param string $key
	 * @param mixed  $default value to return in case the value doesn't exist. null by default.
	 * 
	 * @return string
	 */
    public function getHashValue( $hashId, $key, $default = null ) {
		$hashId = trim( $hashId );
		if( $this->hashExists( $hashId )
			&& array_key_exists( $key, $this->mHashTables[ $hashId ] )
		) {
			return $this->mHashTables[ $hashId ][ $key ];
		} else {
			return $default;
		}
    }
	
	/**
	 * Rest a specific hash tables entry.
	 * 
	 * @since 1.0
	 * 
	 * @param type $hashId
	 * @param type $key 
	 */
	public function unsetHashValue( $hashId, $key ) {
		unset( $this->mHashTables[ trim( $hashId ) ][ trim( $key ) ] );
	}
	
	/**
	 * Set a value of a hash table to a specific value. If the hash table doesn't exist already,
	 * it will be created.
	 * 
	 * @since 1.0
	 * 
	 * @param string $hashId
	 * @param array  $hashTable
	 */
    public function setHashValue( $hashId, $key, $value ) {
		$this->mHashTables[ trim( $hashId ) ][ trim( $key ) ] = trim( $value );
    }
		
	/**
	 * Returns whether a hash exists within the page scope.
	 * 
	 * @since 0.6
	 * 
	 * @param string $hashId
	 * 
	 * @return boolean
	 */
	public function hashExists( $hashId ) {
		return array_key_exists( trim( $hashId ), $this->mHashTables );
	}
	
	/**
	 * Allows to unset a certain hash. Returns whether the hash existed or not.
	 * 
	 * @since 1.0
	 * 
	 * @param string $varName
	 * 
	 * @return boolean
	 */
	public function unsetHash( $hashId ) {
		$hashId = trim( $hashId );
		if( $this->hashExists( $hashId ) ) {
			unset( $this->mHashTables[ $hashId ] );
			return true;
		}
		return false;
	}
	
	/**
	 * Escapes a string so it can be used within PPFrame::expand() expansion without actually being
	 * changed because of special characters.
	 * Respects the configuration variable '$egHashTablesExpansionEscapeTemplates'.
	 * 
	 * @since 1.0
	 * 
	 * @param string $string
	 * @return string
	 */
	public static function escapeForExpansion( $string ) {
		global $egHashTablesExpansionEscapeTemplates;
		
		if( $egHashTablesExpansionEscapeTemplates === null ) {
			return $string;
		}
		
		$string = strtr(
			$string,
			$egHashTablesExpansionEscapeTemplates		
		);
		
		return $string;
	}
	
	/**
	 * Decides for the given $pattern whether its a valid regular expression acceptable for
	 * HashTables parser functions or not.
	 * 
	 * @param string $pattern regular expression including delimiters and optional flags
	 * @return boolean
	 */
	static function isValidRegEx( $pattern ) {
		if( ! preg_match( '/^([\\/\\|%]).*\\1[imsSuUx]*$/', $pattern ) ) {
			return false;
		}
		wfSuppressWarnings(); // instead of using the evil @ operator!
		$isValid = false !== preg_match( $pattern, ' ' ); // preg_match returns false on error
		wfRestoreWarnings();
		return $isValid;
	}
	
}
