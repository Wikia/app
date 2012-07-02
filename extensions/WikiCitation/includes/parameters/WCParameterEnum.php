<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * A WCEnum with each enumerated value keyed to a magic word.
 * Each enumerated value may be traversible among zero or more substitute
 * enumerated values.
 */
abstract class WCParameterEnum extends WCEnum implements Iterator {

	/**
	 * Array of magic word keys.
	 * @var array
	 */
	public static $magicWordKeys = array();

	/**
	 * Array of substitute parameters.
	 * This array contains fallback elements. If the editor has not supplied
	 * the information, and it is needed, the scopes will be tried in the order
	 * of the array.
	 * @var array
	 */
	public static $substitutes = array();

	/**
	 * MagicWordArray object.
	 * Must be initalized statically by ::init().
	 * @var MagicWordArray
	 */
	public static $magicWordArray;

	/**
	 * A flipped version of $magicWordKeys.
	 * Must be initalized statically by ::init().
	 * @var array
	 */
	public static $flipMagicWordKeys;

	/**
	 * An array of substitute enumerated values for $this->value.
	 * Initialized by the constructor.
	 * @var array
	 */
	protected $substituteArray;

	/**
	 * Static initializer.
	 * Delete extra parameters and convert to "static::" keyword when moving to PHP 3.3.
	 */
	public static function init( array $magicWordKeys, array $substitutes,
			&$magicWordArray, array &$flipMagicWordKeys ) {
		/*static::*/$magicWordArray = new MagicWordArray( /*static::*/$magicWordKeys );
		/*static::*/$flipMagicWordKeys = array_flip( /*static::*/$magicWordKeys );
	}

	public function __construct( $key = self::__default ) {
		parent::__construct( $key );
		/* Uncomment the following when moving to PHP 3.3:
		$subs = &static::$substitutes[ $this->key ];
		if ( $subs ) {
			$this->substituteArray = $subs;
		}*/
	}

	/**
	 * Use these functions, with late static binding, when moving to PHP 3.3.
	 */
	public static function match( $parameterText ) {
/*		$id = static::$magicWordArray->matchStartToEnd( $parameterText );
		if ( $id ) {
			return new self( static::$flipMagicWordKeys[ $id ] );
		} else {
			return Null;
		}
*/	}

	public static function matchVariable( $parameterText ) {
/*		list( $id, $var ) = static::$magicWordArray->matchVariableStartToEnd( $parameterText );
		if ( $id ) {
			return array( new self( static::$flipMagicWordKeys[ $id ] ), $var );
		} else {
			return Null;
		}
*/	}

	/**
	 * Match to a magic word prefix.
	 * Returns the remainder in the second element of the array.
	 * @param string $parameterText
	 * @return array Array of ( enum key of the prefix, remainder string)
	 */
	public static function matchPrefix( $parameterText ) {
/*		$id = static::$magicWordArray->matchStartAndRemove( $parameterText );
		if ( $id ) {
			# Remove any initial punctuation or spaces
			$parameterText = preg_replace( '/^[\p{P}\p{Z}\p{C}]+/u', '', $parameterText );
			return array( new self( static::$flipMagicWordKeys[ $id ] ), $parameterText );
		} else {
			return array( Null, $parameterText );
		}
*/	}


	public static function matchPartAndNumber( $parameterText ) {
/*		# Extract number and remove number, white spaces and punctuation.
		if ( preg_match( '/\d+/u', $parameterText, $matches ) ) {
			$numString = $matches[0];
			$num = (int) $numString;
			$parameterText = preg_replace( '/' . $numString . '|[\p{P}\p{Z}\p{C}]+/uS', '', $parameterText );
		} else {
			$num = 1;
		}
		# Match what remains.
		$id = static::$magicWordArray->matchStartToEnd( $parameterText );
		if ( $id ) {
			return array( new self( static::$flipMagicWordKeys[ $id ] ), $num );
		} else {
			return array( Null, $num );
		}
*/	}


/*	public function __toString() {
		$magicWordID = static::$magicWordKeys[ $this->key ];
		return MagicWord::get( $magicWordID )->getSynonym( 0 );
	}
*/
	/**
	 * Get the magic word key for this enumerated parameter.
	 *
	public function getMagicWordKey() {
		return static::$magicWordKeys[ $this->key ];
	}*/

	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function key() {
		return key( $this->substituteArray );
	}

	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function current() {
		return current( $this->substituteArray );
	}

	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function next() {
		return next( $this->substituteArray );
	}

	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function valid() {
		return ! ( current( $this->substituteArray ) === False );
	}

	/**
	 * Implements Iterator interface method.
	 * @return type
	 */
	public function rewind() {
		return reset( $this->substituteArray );
	}

	/**
	 * Tests if a string is a localized version of a magic word.
	 *
	 * As of this coding, MagicWord.php has no MagicWord::matchStartToEnd()
	 * function yet to do this simple task efficiently.
	 *
	 * @param string $text = the text to be tested
	 * @param string $magicWordID = the magic word ID
	 * @return boolean
	 */
	final protected static function isMagicWord( $text, $magicWordID ) {
		$magicWordObject = MagicWord::get( $magicWordID );
		$synonyms = $magicWordObject->getSynonyms();
		foreach( $synonyms as $synonym ) {
			if ( !$magicWordObject->isCaseSensitive() ) {
				$synonym = mb_strtolower( $synonym );
				$text = mb_strtolower( $text );
			}
			if ( $synonym === $text ) {
				return True;
			}
		}
		return False;
	}

}
