<?php
if (!defined('MEDIAWIKI')) die();
/**
 * An extension to ease the translation of Mediawiki
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2007, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */


/**
 * MessageCollection is a collection of TMessages. It supports array accces of
 * TMessage object by message key. One collection can only have items for one
 * translation target language.
 */
class MessageCollection implements Iterator, ArrayAccess, Countable {
	/**
	 * Information of what type of MessageCollection this is.
	 */
	public $code = null;

	/**
	 * Messages are stored in an array.
	 */
	private $messages = array();

	/**
	 * Creates new empty messages collection.
	 *
	 * @param $code Language code
	 */
	public function __construct( $code ) {
		$this->code = $code;
	}

	public function __clone() {
		foreach ( $this->messages as $key => $obj ) {
			$this->messages[$key] = clone $obj;
		}
	}

	/* Iterator methods */
	public function rewind() {
		reset($this->messages);
	}

	public function current() {
		$messages = current($this->messages);
		return $messages;
	}

	public function key() {
		$messages = key($this->messages);
		return $messages;
	}

	public function next() {
		$messages = next($this->messages);
		return $messages;
	}

	public function valid() {
		$messages = $this->current() !== false;
		return $messages;
	}

	/* ArrayAccess methods */
	public function offsetExists( $offset ) {
		return isset($this->messages[$offset]);
	}

	public function offsetGet( $offset ) {
		return $this->messages[$offset];
	}

	public function offsetSet( $offset, $value ) {
		if ( !$value instanceof TMessage ) {
			throw new MWException( __METHOD__ . ": Trying to set member to invalid type" );
		}
		$this->messages[$offset] = $value;
	}

	public function offsetUnset( $offset ) {
		unset( $this->messages[$offset] );
	}

	/* Countable methods */
	/**
	 * Counts the number of items in this collection.
	 *
	 * @return Integer count of items.
	 */
	public function count() {
		return count( $this->messages );
	}


	/**
	 *  Adds new TMessage object to collection.
	 */
	public function add( TMessage $message ) {
		$this->messages[$message->key] = $message;
	}

	/**
	 * Adds array of TMessages to this collection.
	 *
	 * @param $messages Array of TMessage objects.
	 * @throws MWException
	 */
	public function addMany( Array $messages ) {
		foreach ( $messages as $message ) {
			if ( !$message instanceof TMessage ) {
				throw new MWException( __METHOD__ . ": Array contains something else than TMessage" );
			}
			$this->messages[$message->key] = $message;
		}
	}

	/**
	 * Provides an array of keys for safe iteration.
	 *
	 * @return Array of string keys.
	 */
	public function keys() {
		return array_keys( $this->messages );
	}

	/**
	 * Does array_slice to the messages.
	 *
	 * @param $offset Starting offset.
	 * @param $count Numer of items to slice.
	 */
	public function slice( $offset, $count ) {
		$this->messages = array_slice( $this->messages, $offset, $count );
	}

	/**
	 * PHP function array_intersect_key doesn't seem to like object-as-arrays, so
	 * have to do provide some way to do it. Does not change object state.
	 *
	 * @param $array List of keys for messages that should be returned.
	 * @return New MessageCollection.
	 */
	public function intersect_key( Array $array ) {
		$collection = new MessageCollection( $this->code );
		$collection->addMany( array_intersect_key( $this->messages, $array ) );
		return $collection;
	}

	/* Fail fast */
	public function __get( $name ) {
		throw new MWException( __METHOD__ . ": Trying to access unknown property $name" );
	}

	/* Fail fast */
	public function __set( $name, $value ) {
		throw new MWException( __METHOD__ . ": Trying to modify unknown property $name" );
	}

	public function getAuthors() {
		global $wgTranslateFuzzyBotName;

		$authors = array();
		foreach ( $this->keys() as $key ) {
			// Check if there is authors
			$_authors = $this->messages[$key]->authors;
			if ( !count($_authors) ) continue;

			foreach ( $_authors as $author ) {
				if ( !isset($authors[$author]) ) {
					$authors[$author] = 1;
				} else {
					$authors[$author]++;
				}
			}
		}

		arsort( $authors, SORT_NUMERIC );
		foreach ( $authors as $author => $edits ) {
			if ( $author !== $wgTranslateFuzzyBotName ) {
				$filteredAuthors[] = $author;
			}
		}
		return isset($filteredAuthors) ? $filteredAuthors : array();
	}

	/**
	 * Filters messages based on some condition.
	 *
	 * @param $type Any accessible value of TMessage.
	 * @param $condition What the value is compared to.
	 */
	public function filter( $type, $condition = true ) {
		foreach ( $this->keys() as $key ) {
			if ( $this->messages[$key]->$type == $condition ) {
				unset( $this->messages[$key] );
			}
		}
	}

}

class TMessage {
	/**
	 * String that uniquely identifies this message.
	 */
	public $key = null;

	/**
	 * The definition of this message - usually in English.
	 */
	public $definition = null;

	// Following properties are lazy declared to save memory

	/**
	 * Authors who have taken part in translating this message.
	 */
	//protected $authors;

	/**
	 * External translation.
	 */
	//protected $infile   = null;

	/**
	 * Translation in local database, may differ from above.
	 */
	//private $database = null;

	/**
	 * Metadata about the message.
	 */
	//protected $optional, $pageExists, $talkExists;

	// Values that can be accessed with $message->value syntax
	protected static $callable = array(
		// Basic values
		'infile', 'database', 'optional', 'pageExists', 'talkExists',
		// Derived values
		'authors', 'changed', 'translated', 'translation', 'fuzzy',
	);

	protected static $writable = array(
		'infile', 'database', 'optional', 'pageExists', 'talkExists',
		// Ugly.. maybe I'm trying to be to clever here
		'authors',
	);

	/**
	 * Creates new message object.
	 *
	 * @param $key Uniquer key identifying this message.
	 * @param $definition The authoritave definition of this message.
	 */
	public function __construct( $key, $definition ) {
		$this->key = $key;
		$this->definition = $definition;
	}

	// Getters for basic values
	public function key() { return $this->key; }
	public function definition() { return $this->definition; }

	public function infile() { return @$this->infile; }
	public function database() { return @$this->database; }

	public function optional() { return !!@$this->optional; }
	public function pageExists() { return !!@$this->pageExists; }
	public function talkExists() { return !!@$this->talkExists; }

	// Getters for derived values
	/** Returns authors added for this message. */
	public function authors() {
		return @$this->authors ? $this->authors : array();
	}

	/** Determines if this message has uncommitted changes. */
	public function changed() {
		return !!@$this->pageExists && ( @$this->infile !== @$this->database );
	}

	/** Determies if this message has a proper translation. */
	public function translated() {
		if ( @$this->translation === null || $this->fuzzy() ) return false;
		$optionalSame = !!@$this->optional && (@$this->translation === @$this->definition);
		return !$optionalSame;
	}

	/**
	 * Returns the current translation of message. Translation in database are
	 * preferred over those in source files.
	 *
	 * @return Translated string or null if there isn't translation.
	 */
	public function translation() {
		return (@$this->database !== null) ? @$this->database : @$this->infile;
	}

	/**
	 * Determines if the current translation in database (if any) is marked as
	 * fuzzy.
	 *
	 * @return true or false
	 */
	public function fuzzy() {
		if ( @$this->translation !== null ) {
			return strpos($this->translation, TRANSLATE_FUZZY) !== false;
		} else {
			return false;
		}
	}

	// Complex setters
	public function addAuthor( $author ) {
		$authors = $this->authors();
		$authors[] = $author;
		$this->authors = $authors;
	}

	// Code for PHP syntax magic to hide the difference between functions and values
	public function __get( $name ) {
		if ( in_array( $name, self::$callable ) ) {
			return $this->$name();
		}
		throw new MWException( __METHOD__ . ": Trying to access unknown property $name" );
	}

	public function __set( $name, $value ) {
		if ( in_array( $name, self::$writable ) ) {
			if ( gettype($this->$name) === gettype($value) || $this->$name === null && is_string($value) ) {
				$this->$name = $value;
			} else {
				$type = gettype($value);
				throw new MWException( __METHOD__ . ": Trying to set the value of property $name to illegal data type $type" );
			}
		} else {
			throw new MWException( __METHOD__ . ": Trying to set unknown property $name with value $value" );
		}
	}

	public function __isset( $name ) {
		return @$this->$name !== null;
	}

}
