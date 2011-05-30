<?php
/**
 * This file contains classes that implements message collections.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2007-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Core message collection class.
 *
 * Message group is collection of messages of one message group in one
 * language. It handles loading of the messages in one huge batch, and also
 * stores information that can be used to filter the collection in different
 * ways.
 */
class MessageCollection implements ArrayAccess, Iterator, Countable {
	/// \string Language code.
	public $code;

	/// \type{MessageDefinitions}
	protected $definitions = null;

	/// \arrayof{String,String} %Message key => translation.
	protected $infile = array();

	// Keys and messages.

	/// \arrayof{String,String} %Message display key => database key.
	protected $keys = null;

	/// \arrayof{String,TMessage} %Message key => messages.
	protected $messages = null;

	// Database resources

	/// \type{Database Result Resource} Stored message existence and fuzzy state.
	protected $dbInfo = null;

	/// \type{Database Result Resource} Stored translations in database.
	protected $dbData = null;

	/**
	 * Tags, copied to thin messages
	 * tagtype => keys
	 */
	protected $tags = array(); //

	/// \list{String} Authors.
	protected $authors = array();

	/**
	 * Constructors. Use newFromDefinitions() instead.
	 * @param $code \string Language code.
	 */
	public function __construct( $code ) {
		$this->code = $code;
	}

	/**
	 * Construct a new message collection from definitions.
	 * @param $definitions \type{MessageDefinitions}
	 * @param $code \string Language code.
	 * @return \type{MessageCollection}
	 */
	public static function newFromDefinitions( MessageDefinitions $definitions, $code ) {
		$collection = new self( $code );
		$collection->definitions = $definitions;
		$collection->resetForNewLanguage( $code );
		return $collection;
	}

	/**
	 * Constructs a new empty message collection. Suitable for example for testing.
	 * @param $code \string Language Code.
	 * @return \type{MessageCollection}
	 */
	public static function newEmpty( $code ) {

	}

	// Data setters

	/**
	 * Set translation from file, as opposed to translation which only exists
	 * in the wiki because they are not exported and committed yet.
	 * @param $messages \arrayof{String,String} Array of translations indexed
	 * by display key.
	 */
	public function setInfile( array $messages ) {
		$this->infile = $messages;
	}

	/**
	 * Set message tags.
	 * @param $type \string Tag type, usually ignored or optional.
	 * @param $keys \list{String} List of display keys.
	 */
	public function setTags( $type, array $keys ) {
		$this->tags[$type] = $keys;
	}

	/**
	 * Returns list of available message keys. This is affected by filtering.
	 * @return \arrayof{String,String} List of database keys indexed by display keys.
	 */
	public function keys() {
		return $this->keys;
	}

	/**
	 * Returns stored message tags.
	 * @param $type \string Tag type, usually optional or ignored.
	 * @return \types{\list{String},\null} List of keys or null if no tags.
	 * @todo Return empty array instead?
	 */
	public function getTags( $type ) {
		return isset( $this->tags[$type] ) ? $this->tags[$type] : null;
	}

	/**
	 * Lists all translators that have contributed to the latest revisions of
	 * each translation. Causes translations to be loaded from the database.
	 * Is not affected by filters.
	 * @return \list{String} List of usernames.
	 */
	public function getAuthors() {
		global $wgTranslateFuzzyBotName;

		$this->loadTranslations();

		$authors = array_flip( $this->authors );

		foreach ( $this->messages as $m ) {
			// Check if there are authors
			$author = $m->author();

			if ( $author === null ) {
				continue;
			}

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

	/**
	 * Add external authors (usually from the file).
	 * @param $authors \list{String} List of authors.
	 * @param $mode \string Either append or set authors.
	 * @throws MWException If invalid $mode given.
	 */
	public function addCollectionAuthors( $authors, $mode = 'append' ) {
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

	/**
	 * Loads all message data. Must be called before accessing the messages
	 * with ArrayAccess or iteration.
	 */
	public function loadTranslations() {
		$this->loadData( $this->keys );
		$this->loadInfo( $this->keys );
		$this->initMessages();
	}

	/**
	 * Some statistics scripts for example loop the same collection over every
	 * language. This is a shortcut which keeps tags and definitions.
	 */
	public function resetForNewLanguage( $code ) {
		$this->code     = $code;
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

	/**
	 * Filters messages based on some condition. Some filters cause data to be
	 * loaded from the database. PAGEINFO: existence and fuzzy tags.
	 * TRANSLATIONS: translations for every message. It is recommended to first
	 * filter with messages that do not need those. It is recommended to add
	 * translations from file with addInfile, and it is needed for changed
	 * filter to work.
	 *
	 * @param $type \string
	 *  - fuzzy: messages with fuzzy tag (PAGEINFO)
	 *  - optional: messages marked for optional.
	 *  - ignored: messages which are not for translation.
	 *  - hastranslation: messages which have translation (be if fuzzy or not)
	 *    (PAGEINFO, *INFILE).
	 *  - translated: messages which have translation which is not fuzzy
	 *    (PAGEINFO, *INFILE).
	 *  - changed: translation in database differs from infile.
	 *    (INFILE, TRANSLATIONS)
	 * @param $condition \bool Whether to return messages which do not satisfy
	 * the given filter condition (true), or only which do (false).
	 * @throws \type{MWException} If given invalid filter name.
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

	public static function getAvailableFilters() {
		return array(
			'fuzzy',
			'optional',
			'ignored',
			'hastranslation',
			'changed',
			'translated',
		);
	}

	/**
	 * Really apply a filter. Some filters need multiple conditions.
	 * @param $filter \string Filter name.
	 * @param $condition \bool Whether to return messages which do not satisfy
	 * the given filter condition (true), or only which do (false).
	 */
	protected function applyFilter( $filter, $condition ) {
		$keys = $this->keys;
		if ( $filter === 'fuzzy' ) {
			$keys = $this->filterFuzzy( $keys, $condition );
		} elseif ( $filter === 'hastranslation' ) {
			$keys = $this->filterHastranslation( $keys, $condition );
		} elseif ( $filter === 'translated' ) {
			$fuzzy = $this->filterFuzzy( $keys, false );
			$hastranslation = $this->filterHastranslation( $keys, false );
			// Fuzzy messages are not counted as translated messages
			$translated = $this->filterOnCondition( $hastranslation, $fuzzy );
			$keys = $this->filterOnCondition( $keys, $translated, $condition );
		} elseif ( $filter === 'changed' ) {
			$keys = $this->filterChanged( $keys, $condition );
		} else {
			// Filter based on tags.
			if ( !isset( $this->tags[$filter] ) ) {
				if ( $filter !== 'optional' && $filter !== 'ignored' ) {
					throw new MWException( "No tagged messages for custom filter $filter" );
				}
				$keys = $this->filterOnCondition( $keys, array(), $condition );
			} else {
				$taggedKeys = array_flip( $this->tags[$filter] );
				$keys = $this->filterOnCondition( $keys, $taggedKeys, $condition );
			}
		}

		$this->keys = $keys;
	}

	/**
	 * Filters list of keys with other list of keys according to the condition.
	 * In other words, you have a list of keys, and you have determined list of
	 * keys that have some feature. Now you can either take messages that are
	 * both in the first list and the second list OR are in the first list but
	 * are not in the second list (conditition = true and false respectively).
	 * What makes this more complex is that second list of keys might not be a
	 * subset of the first list of keys.
	 * @param $keys \list{String} List of keys to filter.
	 * @param $condKeys \list{String} Second list of keys for filtering.
	 * @param $condition \bool True (default) to return keys which are on first
	 * and second list, false to return keys which are on the first but not on
	 * second.
	 * @return \list{String} Filtered keys.
	 */
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

	/**
	 * Filters list of keys according to whether the translation is fuzzy.
	 * @param $keys \list{String} List of keys to filter.
	 * @param $condition \bool True to filter away fuzzy translations, false
	 * to filter non-fuzzy translations.
	 * @return \list{String} Filtered keys.
	 */
	protected function filterFuzzy( array $keys, $condition ) {
		$this->loadInfo( $keys );

		if ( $condition === false ) {
			$origKeys = $keys;
		}

		$flipKeys = array_flip( $keys );

		foreach ( $this->dbInfo as $row ) {
			if ( $row->rt_type !== null ) {
				if ( !isset( $flipKeys[$row->page_title] ) ) {
					continue;
				}

				unset( $keys[$flipKeys[$row->page_title]] );
			}
		}

		if ( $condition === false ) {
			$keys = array_diff( $origKeys, $keys );
		}

		return $keys;
	}

	/**
	 * Filters list of keys according to whether they have a translation.
	 * @param $keys \list{String} List of keys to filter.
	 * @param $condition \bool True to filter away translated, false
	 * to filter untranslated.
	 * @return \list{String} Filtered keys.
	 */
	protected function filterHastranslation( array $keys, $condition ) {
		$this->loadInfo( $keys );

		if ( $condition === false ) {
			$origKeys = $keys;
		}

		$flipKeys = array_flip( $keys );

		foreach ( $this->dbInfo as $row ) {
			// Remove messages which have a translation from keys
			if ( !isset( $flipKeys[$row->page_title] ) ) {
				continue;
			}

			unset( $keys[$flipKeys[$row->page_title]] );
		}

		// Check also if there is something in the file that is not yet in the database
		foreach ( array_keys( $this->infile ) as $inf ) {
			unset( $keys[$inf] );
		}

		// Remove the messages which do not have a translation from the list
		if ( $condition === false ) {
			$keys = array_diff( $origKeys, $keys );
		}

		return $keys;
	}

	/**
	 * Filters list of keys according to whether the current translation
	 * differs from the commited translation.
	 * @param $keys \list{String} List of keys to filter.
	 * @param $condition \bool True to filter changed translations, false
	 * to filter unchanged translations.
	 * @return \list{String} Filtered keys.
	 */
	protected function filterChanged( array $keys, $condition ) {
		$this->loadData( $keys );

		if ( $condition === false ) {
			$origKeys = $keys;
		}

		$flipKeys = array_flip( $keys );

		foreach ( $this->dbData as $row ) {
			$realKey = $flipKeys[$row->page_title];
			if ( !isset( $this->infile[$realKey] ) ) {
				continue;
			}

			$text = Revision::getRevisionText( $row );
			if ( $this->infile[$realKey] === $text ) {
				// Remove unchanged messages from the list
				unset( $keys[$realKey] );
			}
		}

		// Remove the messages which have not changed from the list
		if ( $condition === false ) {
			$keys = $this->filterOnCondition( $keys, $origKeys, false );
		}

		return $keys;
	}
	/** @} */

	/**
	 * Takes list of keys and converts them into database format.
	 * @param $keys \list{String} List of keys in display format.
	 * @return \arrayof{String,String} Array of keys in database format indexed by display format.
	 */
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

	/**
	 * Loads existence and fuzzy state for given list of keys.
	 * @param $keys \list{String} List of keys in database format.
	 */
	protected function loadInfo( array $keys ) {
		if ( $this->dbInfo !== null ) {
			return;
		}

		$this->dbInfo = array();

		if ( !count( $keys ) ) {
			return;
		}

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

	/**
	 * Loads translation for given list of keys.
	 * @param $keys \list{String} List of keys in database format.
	 */
	protected function loadData( $keys ) {
		if ( $this->dbData !== null ) {
			return;
		}

		$this->dbData = array();

		if ( !count( $keys ) ) {
			return;
		}

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

	/**
	 * Constructs all TMessages from the data accumulated so far.
	 * Usually there is no need to call this method directly.
	 */
	public function initMessages() {
		if ( $this->messages !== null ) {
			return;
		}

		$messages = array();

		foreach ( array_keys( $this->keys ) as $key ) {
			$messages[$key] = new ThinMessage( $key, $this->definitions->messages[$key] );
		}

		$flipKeys = array_flip( $this->keys );

		// Copy rows if any.
		if ( $this->dbData !== null ) {
			foreach ( $this->dbData as $row ) {
				if ( !isset( $flipKeys[$row->page_title] ) ) {
					continue;
				}

				$key = $flipKeys[$row->page_title];
				$messages[$key]->setRow( $row );
			}
		}

		if ( $this->dbInfo !== null ) {
			$fuzzy = array();
			foreach ( $this->dbInfo as $row ) {
				if ( !isset( $flipKeys[$row->page_title] ) ) {
					continue;
				}

				if ( $row->rt_type !== null ) {
					$fuzzy[] = $flipKeys[$row->page_title];
				}
			}

			$this->setTags( 'fuzzy', $fuzzy );
		}

		// Copy tags if any.
		foreach ( $this->tags as $type => $keys ) {
			foreach ( $keys as $key ) {
				if ( isset( $messages[$key] ) ) {
					$messages[$key]->setTag( $type );
				}
			}
		}

		// Copy infile if any.
		foreach ( $this->infile as $key => $value ) {
			if ( isset( $messages[$key] ) ) {
				$messages[$key]->setInfile( $value );
			}
		}

		$this->messages = $messages;
	}

	/**
	 * ArrayAccess methods. @{
	 */
	public function offsetExists( $offset ) {
		return isset( $this->keys[$offset] );
	}

	public function offsetGet( $offset ) {
		return $this->messages[$offset];
	}

	public function offsetSet( $offset, $value ) {
		$this->messages[$offset] = $value;
	}

	public function offsetUnset( $offset ) {
		unset( $this->keys[$offset] );
	}
	/** @} */

	/**
	 * Fail fast if trying to access unknown properties. @{
	 */
	public function __get( $name ) {
		throw new MWException( __METHOD__ . ": Trying to access unknown property $name" );
	}

	public function __set( $name, $value ) {
		throw new MWException( __METHOD__ . ": Trying to modify unknown property $name" );
	}
	/** @} */

	/**
	 * Iterator method. @{
	 */
	public function rewind() {
		reset( $this->keys );
	}

	public function current() {
		if ( !count( $this->keys ) ) {
			return false;
		}

		return $this->messages[key( $this->keys )];
	}

	public function key() {
		return key( $this->keys );
	}

	public function next() {
		return next( $this->keys );
	}

	public function valid() {
		return isset( $this->messages[key( $this->keys )] );
	}

	public function count() {
		return count( $this->keys() );
	}
	/** @} */

}

/**
 * Wrapper for message definitions, just to beauty the code.
 * This is one reason why message collections and thus message groups are
 * restricted into single namespace.
 */
class MessageDefinitions {
	public $namespace;
	public $messages;
	public function __construct( $namespace, array $messages ) {
		$this->namespace = $namespace;
		$this->messages = $messages;
	}
}
