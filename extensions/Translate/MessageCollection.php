<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * An extension to ease the translation of Mediawiki
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2007-2009, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class MessageCollection implements ArrayAccess, Iterator, Countable {
	/**
	 * It is handy to store the language code here.
	 */
	public $code = null;

	// External stuff
	private $definitions = null; // MessageDefinitions
	private $infile = array();   // message key => translation

	// Keys and messages
	private $keys = null;     // message key => database key
	private $messages = null; // message key => ThinMessage

	// Database resources
	private $dbInfo = null; // existence, fuzzy
	private $dbData = null; // all translations

	// Tags, copied to thin messages
	private $tags = array(); // tagtype => keys

	protected $authors = array();
	
	// Constructors etc.
	//
	public function __construct( $code ) {
		$this->code = $code;
	}

	public static function newFromDefinitions( MessageDefinitions $definitions, $code ) {
		$collection = new self( $code );
		$collection->definitions = $definitions;
		$collection->resetForNewLanguage( $code );
		return $collection;
	}

	// Data setters
	//
	public function setInfile( array $messages ) {
		$this->infile = $messages;
	}

	public function setTags( $type, array $keys ) {
		$this->tags[$type] = $keys;
	}

	// Getters
	public function keys() {
		return $this->keys;
	}

	public function getTags( $type ) {
		return isset( $this->tags[$type] ) ? $this->tags[$type] : null;
	}

	public function getAuthors() {
		global $wgTranslateFuzzyBotName;

		$this->loadTranslations();

		$authors = array_flip( $this->authors );
		foreach ( $this->messages as $m ) {
			// Check if there is authors
			$author = $m->author();
			if ( $author === null ) continue;
			if ( !isset( $authors[$author] ) ) {
				$authors[$author] = 1;
			} else {
				$authors[$author]++;
			}
		}

		# arsort( $authors, SORT_NUMERIC );
		ksort( $authors );
		foreach ( $authors as $author => $edits ) {
			if ( $author !== $wgTranslateFuzzyBotName ) {
				$filteredAuthors[] = $author;
			}
		}
		return isset( $filteredAuthors ) ? $filteredAuthors : array();
	}

	public function addCollectionAuthors( /*list*/$authors, $mode = 'append' ) {
		switch( $mode ) {
		case 'append':
			$authors = array_merge( $this->authors, $authors );
			break;
		case 'set':
			break;
		default:
			throw new MWException( "Invalid mode $mode" );
		}

		$this->authors = array_unique( $authors );
	}

	// Data modifiers

	public function loadTranslations() {
		$this->loadData( $this->keys );
		$this->loadInfo( $this->keys );
		$this->initMessages();
	}

	/**
	 * Filters messages based on some condition. Some filters cause data to be
	 * loaded from the database. PAGEINFO: existence and fuzzy tags.
	 * TRANSLATIONS: translations for every message. It is recommended to first
	 * filter with messages that do not need those. It is recommended to add
	 * translations from file with addInfile, and it is needed for chagned
	 * filter to work.
	 *
	 * @param $type
	 *  fuzzy: messages with fuzzy tag (PAGEINFO)
	 *  optional: messages marked for optional.
	 *  ignored: messages which are not for translation.
	 *  hastranslation: messages which have translation (be if fuzzy or not) (PAGEINFO, *INFILE).
	 *  translated: messages which have translation which is not fuzzy (PAGEINFO, *INFILE).
	 *  changed: translation in database differs from infile. (INFILE, TRANSLATIONS)
	 * @param $condition True or false.
	 */
	public function filter( $type, $condition = true ) {
		switch( $type ) {
		case 'fuzzy':
		case 'optional':
		case 'ignored':
		case 'hastranslation':
		case 'changed':
		case 'translated':
			$this->applyFilter( $type, $condition );
			break;
		default:
			throw new MWException( "Unknown filter $type" );
		}
	}

	/**
	 * Some statistics scripts for example loop the same collection over every
	 * language. This is a shortcut which keeps tags and definitions.
	 */
	public function resetForNewLanguage( $code ) {
		$this->code = $code;

		$this->keys     = $this->fixKeys( array_keys( $this->definitions->messages ) );
		$this->dbInfo   = null;
		$this->dbData   = null;
		$this->messages = null;
		$this->infile   = array();
		$this->authors  = array();
		unset( $this->tags['fuzzy'] );
	}

	/**
	 * For paging messages. One can count messages before and after slice.
	 */
	public function slice( $offset, $limit ) {
		$this->keys = array_slice( $this->keys, $offset, $limit, true );
	}

	// Protected functions
	//
	protected function applyFilter( $filter, $condition ) {
		$keys = $this->keys;
		if ( $filter === 'fuzzy' ) {
			$keys = $this->filterFuzzy( $keys, $condition );
		} elseif ( $filter === 'hastranslation' ) {
			$keys = $this->filterHastranslation( $keys, $condition );
		} elseif ( $filter === 'translated' ) {
			$fuzzy = $this->filterFuzzy( $keys, false );
			$hastranslation = $this->filterHastranslation( $keys, false );
			// Fuzzy messages are not translated messages
			$translated = $this->filterOnCondition( $hastranslation, $fuzzy );
			$keys = $this->filterOnCondition( $keys, $translated, $condition );
		} elseif ( $filter === 'changed' ) {
			$keys = $this->filterChanged( $keys, $condition );
		} else { // Filter based on tags
			if ( !isset( $this->tags[$filter] ) ) {
				if ( $filter !== 'optional' && $filter !== 'ignored' ) {
					throw new MWException( "No tagged messages for custom filter $filter" );
				}
			} else {
				$taggedKeys = array_flip( $this->tags[$filter] );
				$keys = $this->filterOnCondition( $keys, $taggedKeys, $condition );
			}
		}
		$this->keys = $keys;
	}

	protected function filterOnCondition( array $keys, array $condKeys, $condition = true ) {
		if ( $condition === true ) {
			// Delete $condKeys from $keys
			foreach ( array_keys( $condKeys ) as $key ) {
				unset( $keys[$key] );
			}
		} else {
			// Keep the keys which are in $condKeys
			foreach ( array_keys( $keys ) as $key ) {
				if ( !isset( $condKeys[$key] ) ) {
					unset( $keys[$key] );
				}
			}
		}
		return $keys;
	}

	protected function filterFuzzy( array $keys, $condition ) {
		$this->loadInfo( $keys );

		if ( $condition === false ) $origKeys = $keys;

		$flipKeys = array_flip( $keys );
		foreach ( $this->dbInfo as $row ) {
			if ( $row->rt_type !== null ) {
				if ( !isset( $flipKeys[$row->page_title] ) ) continue;
				unset( $keys[$flipKeys[$row->page_title]] );
			}
		}

		if ( $condition === false ) $keys = array_diff( $origKeys, $keys );

		return $keys;
	}

	protected function filterHastranslation( array $keys, $condition ) {
		$this->loadInfo( $keys );

		if ( $condition === false ) $origKeys = $keys;

		$flipKeys = array_flip( $keys );
		foreach ( $this->dbInfo as $row ) {
			// Remove messages which have a translation from keys
			if ( !isset( $flipKeys[$row->page_title] ) ) continue;
			unset( $keys[$flipKeys[$row->page_title]] );
		}

		// Check also if there is something in the file that is not yet in the db
		foreach ( array_keys( $this->infile ) as $inf ) {
			unset( $keys[$inf] );
		}

		// Remove the messages which do not have a translation from the list
		if ( $condition === false ) $keys = array_diff( $origKeys, $keys );

		return $keys;
	}

	protected function filterChanged( array $keys, $condition ) {
		$this->loadData( $keys );

		if ( $condition === false ) $origKeys = $keys;
		$flipKeys = array_flip( $keys );
		foreach ( $this->dbData as $row ) {
			$realKey = $flipKeys[$row->page_title];
			if ( !isset( $this->infile[$realKey] ) ) continue;

			$text = Revision::getRevisionText( $row );
			if ( $this->infile[$realKey] === $text ) {
				// Remove changed messages from the list
				unset( $keys[$realKey] );
			}
		}

		// Remove the messages which have not changed from the list
		if ( $condition === false ) {
			$keys = $this->filterOnCondition( $keys, $origKeys, false );
		}

		return $keys;
	}

	protected function fixKeys( array $keys ) {
		$newkeys = array();
		$namespace = $this->definitions->namespace;
		$code = $this->code;
		foreach ( $keys as $key ) {
			$title = Title::makeTitleSafe( $namespace, $key . '/' . $code );
			if ( !$title ) {
				wfWarn( "Invalid title $namespace:$key/$code" );
				continue;
			}
			$newkeys[$key] = $title->getDBKey();
		}
		return $newkeys;
	}

	protected function loadInfo( array $keys ) {
		if ( $this->dbInfo !== null ) return;

		$this->dbInfo = array(); // Something iterable
		if ( !count( $keys ) ) return;

		$dbr = wfGetDB( DB_SLAVE );

		static $id = null;
		if ( $id === null )
			$id = $dbr->selectField( 'revtag_type', 'rtt_id', array( 'rtt_name' => 'fuzzy' ), __METHOD__ );

		$tables = array( 'page', 'revtag' );
		$fields = array( 'page_title', 'rt_type' );
		$conds  = array(
			'page_namespace' => $this->definitions->namespace,
			'page_title' => array_values( $keys ),
		);
		$joins = array( 'revtag' =>
			array(
				'LEFT JOIN',
				array( 'page_id=rt_page', 'page_latest=rt_revision', 'rt_type' => $id )
			)
		);

		$this->dbInfo = $dbr->select( $tables, $fields, $conds, __METHOD__, array(), $joins );
	}

	protected function loadData( $keys ) {
		if ( $this->dbData !== null ) return;
		
		$this->dbData = array(); // Something iterable
		if ( !count( $keys ) ) return;

		$dbr = wfGetDB( DB_SLAVE );

		$tables = array( 'page', 'revision', 'text' );
		$fields = array( 'page_title', 'rev_user_text', 'old_flags', 'old_text' );
		$conds  = array(
			'page_namespace' => $this->definitions->namespace,
			'page_title' => array_values( $keys ),
			'page_latest = rev_id',
			'old_id = rev_text_id',
		);

		$res = $dbr->select( $tables, $fields, $conds, __METHOD__ );

		$this->dbData = $res;
	}

	public function initMessages() {
		if ( $this->messages !== null ) return;
		$messages = array();

		foreach ( array_keys( $this->keys ) as $key ) {
			$messages[$key] = new ThinMessage( $key, $this->definitions->messages[$key] );
		}

		$flipKeys = array_flip( $this->keys );

		// Copy rows if any
		if ( $this->dbData !== null ) {
			foreach ( $this->dbData as $row ) {
				if ( !isset( $flipKeys[$row->page_title] ) ) continue;
				$key = $flipKeys[$row->page_title];
				$messages[$key]->setRow( $row );
			}
		}

		if ( $this->dbInfo !== null ) {
			$fuzzy = array();
			foreach ( $this->dbInfo as $row ) {
				if ( !isset( $flipKeys[$row->page_title] ) ) continue;
				if ( $row->rt_type !== null ) $fuzzy[] = $flipKeys[$row->page_title];
			}
			$this->setTags( 'fuzzy', $fuzzy );
		}

		// Copy tags if any
		foreach ( $this->tags as $type => $keys ) {
			foreach ( $keys as $key ) {
				if ( isset( $messages[$key] ) ) {
					$messages[$key]->setTag( $type );
				}
			}
		}

		// Copy infile if any
		foreach ( $this->infile as $key => $value ) {
			if ( isset( $messages[$key] ) ) {
				$messages[$key]->setInfile( $value );
			}
		}

		$this->messages = $messages;
	}

	// Interfaces etc.
	//
	/* ArrayAccess methods */
	public function offsetExists( $offset ) {
		return isset( $this->messages[$offset] );
	}

	public function offsetGet( $offset ) {
		return $this->messages[$offset];
	}

	public function offsetSet( $offset, $value ) {
		$this->messages[$offset] = $value;
	}

	public function offsetUnset( $offset ) {
		unset( $this->messages[$offset] );
	}

	/* Fail fast */
	public function __get( $name ) {
		throw new MWException( __METHOD__ . ": Trying to access unknown property $name" );
	}

	/* Fail fast */
	public function __set( $name, $value ) {
		throw new MWException( __METHOD__ . ": Trying to modify unknown property $name" );
	}

	/* Iterator methods */
	public function rewind() {
		reset( $this->messages );
	}

	public function current() {
		if ( !count( $this->messages ) ) return false;
		return current( $this->messages );
	}

	public function key() {
		return key( $this->messages );
	}

	public function next() {
		return next( $this->messages );
	}

	public function valid() {
		return $this->current() !== false;
	}

	public function count() {
		return count( $this->keys() );
	}

}

class MessageDefinitions {
	public $namespace;
	public $messages;
	public function __construct( $namespace, array $messages ) {
		$this->namespace = $namespace;
		$this->messages = $messages;
	}
}