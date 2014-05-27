<?php
/**
 * This file contains classes that implements message collections.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2007-2011, Niklas Laxström
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

	/// Array
	protected $reverseMap;

	// Database resources

	/// \type{Database Result Resource} Stored message existence and fuzzy state.
	protected $dbInfo = null;

	/// \type{Database Result Resource} Stored translations in database.
	protected $dbData = null;

	/// \type{Database Result Resource} Stored reviews in database.
	protected $dbReviewData = null;

	/**
	 * Tags, copied to thin messages
	 * tagtype => keys
	 */
	protected $tags = array();

	/**
	 * Properties, copied to thin messages
	 */
	protected $properties = array();

	/// \list{String} Authors.
	protected $authors = array();

	/// bool Whether review info is loaded
	protected $reviewMode = false;

	/**
	 * Constructors. Use newFromDefinitions() instead.
	 * @param $code \string Language code.
	 */
	public function __construct( $code ) {
		$this->code = $code;
	}

	/**
	 * Construct a new message collection from definitions.
	 * @param $definitions MessageDefinitions
	 * @param $code string Language code.
	 * @return MessageCollection
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

	/// @return String
	public function getLanguage() {
		return $this->code;
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
	 * Returns list of titles of messages that are used in this collection after filtering.
	 * @return \list{Title}
	 * @since 2011-12-28
	 */
	public function getTitles() {
		return array_values( $this->keys );
	}

	/**
	 * Returns list of message keys that are used in this collection after filtering.
	 * @return \list{String}
	 * @since 2011-12-28
	 */
	public function getMessageKeys() {
		return array_keys( $this->keys );
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
		$fuzzyBot = FuzzyBot::getName();
		foreach ( $authors as $author => $edits ) {
			if ( $author !== $fuzzyBot ) {
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

	/**
	 * Call this to load list of reviewers for each message.
	 * Can be accessed from TMessage::getReviewers().
	 */
	public function setReviewMode( $value = true  ) {
		$this->reviewMode = $value;
	}

	// Data modifiers

	/**
	 * Loads all message data. Must be called before accessing the messages
	 * with ArrayAccess or iteration. Must be called before filtering for
	 * $dbtype to have an effect.
	 * @param $dbtype One of DB_* constants.
	 */
	public function loadTranslations( $dbtype = DB_SLAVE ) {
		$this->loadData( $this->keys, $dbtype );
		$this->loadInfo( $this->keys, $dbtype );
		if ( $this->reviewMode ) {
			$this->loadReviewInfo( $this->keys, $dbtype );
		}
		$this->initMessages();
	}

	/**
	 * Some statistics scripts for example loop the same collection over every
	 * language. This is a shortcut which keeps tags and definitions.
	 * @param $code
	 */
	public function resetForNewLanguage( $code ) {
		$this->code     = $code;
		$this->keys     = $this->fixKeys();
		$this->dbInfo   = null;
		$this->dbData   = null;
		$this->dbReviewData = null;
		$this->messages = null;
		$this->infile   = array();
		$this->authors  = array();

		unset( $this->tags['fuzzy'] );
		$this->reverseMap = null;
	}

	/**
	 * For paging messages. One can count messages before and after slice.
	 * @param $offset
	 * @param $limit
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
	 * @param $value Mixed Value for properties filtering.
	 * @throws \type{MWException} If given invalid filter name.
	 */
	public function filter( $type, $condition = true, $value = null ) {
		if ( !in_array( $type, self::getAvailableFilters(), true ) ) {
			throw new MWException( "Unknown filter $type" );
		}
		$this->applyFilter( $type, $condition, $value );
	}

	/**
	 * @return array
	 */
	public static function getAvailableFilters() {
		return array(
			'fuzzy',
			'optional',
			'ignored',
			'hastranslation',
			'changed',
			'translated',
			'reviewer',
			'last-translator',
		);
	}

	/**
	 * Really apply a filter. Some filters need multiple conditions.
	 * @param $filter \string Filter name.
	 * @param $condition \bool Whether to return messages which do not satisfy
	 * @param $value Mixed Value for properties filtering.
	 * the given filter condition (true), or only which do (false).
	 */
	protected function applyFilter( $filter, $condition, $value ) {
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
		} elseif ( $filter === 'reviewer' ) {
			$keys = $this->filterReviewer( $keys, $condition, $value );
		} elseif ( $filter === 'last-translator' ) {
			$keys = $this->filterLastTranslator( $keys, $condition, $value );
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

		foreach ( $this->dbInfo as $row ) {
			if ( $row->rt_type !== null ) {
				unset( $keys[$this->rowToKey( $row )] );
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

		foreach ( $this->dbInfo as $row ) {
			unset( $keys[$this->rowToKey( $row )] );
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

		foreach ( $this->dbData as $row ) {
			$mkey = $this->rowToKey( $row );
			if ( !isset( $this->infile[$mkey] ) ) {
				continue;
			}

			$text = Revision::getRevisionText( $row );
			if ( $this->infile[$mkey] === $text ) {
				// Remove unchanged messages from the list
				unset( $keys[$mkey] );
			}
		}

		// Remove the messages which have not changed from the list
		if ( $condition === false ) {
			$keys = $this->filterOnCondition( $keys, $origKeys, false );
		}

		return $keys;
	}


	/**
	 * Filters list of keys according to whether the user has accepted them.
	 * @param $keys \list{String} List of keys to filter.
	 * @param $condition \bool True to remove translatations $user has accepted,
	 * false to get only translations accepted by $user.
	 * @param $user \int Userid
	 * @return \list{String} Filtered keys.
	 */
	protected function filterReviewer( array $keys, /*bool*/ $condition, /*int*/ $user ) {
		$this->loadReviewInfo( $keys );
		$origKeys = $keys;

		/* This removes messages from the list which have certain
		 * reviewer (among others) */
		$user = intval( $user );
		foreach ( $this->dbReviewData as $row ) {
			if ( intval( $row->trr_user ) === $user ) {
				unset( $keys[$this->rowToKey( $row )] );
			}
		}

		if ( $condition === false ) {
			$keys = array_diff( $origKeys, $keys );
		}

		return $keys;
	}

	/**
	 * @param $keys \list{String} List of keys to filter.
	 * @param $condition \bool True to remove translatations where last translator is $user
	 * false to get only last translations done by others.
	 * @param $user \int Userid
	 * @return \list{String} Filtered keys.
	 */
	protected function filterLastTranslator( array $keys, /*bool*/ $condition, /*int*/ $user ) {
		$this->loadData( $keys );
		$origKeys = $keys;

		$user = intval( $user );
		foreach ( $this->dbData as $row ) {
			if ( intval( $row->rev_user ) === $user ) {
				unset( $keys[$this->rowToKey( $row )] );
			}
		}

		if ( $condition === false ) {
			$keys = array_diff( $origKeys, $keys );
		}

		return $keys;
	}

	/**
	 * Takes list of keys and converts them into database format.
	 * @param $keys \list{String} List of keys in display format.
	 * @return \arrayof{String,String} Array of keys in database format indexed by display format.
	 */
	protected function fixKeys() {
		$newkeys = array();
		// array( namespace, pagename )
		$pages = $this->definitions->getPages();
		$code = $this->code;

		foreach ( $pages as $key => $page ) {
			list ( $namespace, $pagename ) = $page;
			$title = Title::makeTitleSafe( $namespace, "$pagename/$code" );
			if ( !$title ) {
				wfWarn( "Invalid title $namespace:$pagename/$code" );
				continue;
			}
			$newkeys[$key] = $title;
		}
		return $newkeys;
	}

	/**
	 * Loads existence and fuzzy state for given list of keys.
	 * @param $keys \list{String} List of keys in database format.
	 * @param $dbtype One of DB_* constants.
	 */
	protected function loadInfo( array $keys, $dbtype = DB_SLAVE ) {
		if ( $this->dbInfo !== null ) {
			return;
		}

		$this->dbInfo = array();

		if ( !count( $keys ) ) {
			return;
		}

		$dbr = wfGetDB( $dbtype );
		$tables = array( 'page', 'revtag' );
		$fields = array( 'page_namespace', 'page_title', 'rt_type' );
		$conds  = $this->getTitleConds( $dbr );
		$joins  = array( 'revtag' =>
			array(
				'LEFT JOIN',
				array( 'page_id=rt_page', 'page_latest=rt_revision', 'rt_type' => RevTag::getType( 'fuzzy' ) )
			)
		);

		$this->dbInfo = $dbr->select( $tables, $fields, $conds, __METHOD__, array(), $joins );
	}

	/**
	 * Loads reviewers for given messages.
	 * @param $keys \list{String} List of keys in database format.
	 * @param $dbtype One of DB_* constants.
	 */
	protected function loadReviewInfo( array $keys, $dbtype = DB_SLAVE ) {
		if ( $this->dbReviewData !== null ) {
			return;
		}

		$this->dbReviewData = array();

		if ( !count( $keys ) ) {
			return;
		}

		$dbr = wfGetDB( $dbtype );
		$tables = array( 'page', 'translate_reviews' );
		$fields = array( 'page_namespace', 'page_title', 'trr_user' );
		$conds  = $this->getTitleConds( $dbr );
		$joins  = array( 'translate_reviews' =>
			array(
				'JOIN',
				array( 'page_id=trr_page', 'page_latest=trr_revision' )
			)
		);

		$this->dbReviewData = $dbr->select( $tables, $fields, $conds, __METHOD__, array(), $joins );
	}

	/**
	 * Loads translation for given list of keys.
	 * @param $keys \list{String} List of keys in database format.
	 * @param $dbtype One of DB_* constants.
	 */
	protected function loadData( $keys, $dbtype = DB_SLAVE ) {
		if ( $this->dbData !== null ) {
			return;
		}

		$this->dbData = array();

		if ( !count( $keys ) ) {
			return;
		}

		$dbr = wfGetDB( $dbtype );

		$tables = array( 'page', 'revision', 'text' );
		$fields = array( 'page_namespace', 'page_title', 'page_latest', 'rev_user', 'rev_user_text', 'old_flags', 'old_text' );
		$conds  = array(
			'page_latest = rev_id',
			'old_id = rev_text_id',
		);
		$conds[] = $this->getTitleConds( $dbr );

		$res = $dbr->select( $tables, $fields, $conds, __METHOD__ );

		$this->dbData = $res;
	}

	/**
	 * Of the current set of keys, construct database query conditions.
	 * @since 2011-12-28
	 */
	protected function getTitleConds( $db ) {
		// Array of array( namespace, pagename )
		$byNamespace = array();
		foreach ( $this->getTitles() as $title ) {
			$namespace = $title->getNamespace();
			$pagename = $title->getDBKey();
			$byNamespace[$namespace][] = $pagename;
		}

		$conds = array();
		foreach ( $byNamespace as $namespaces => $pagenames ) {
			$cond = array(
				'page_namespace' => $namespaces,
				'page_title' => $pagenames,
			);

			$conds[] = $db->makeList( $cond, LIST_AND );
		}
		return $db->makeList( $conds, LIST_OR );
	}

	/**
	 * Given two-dimensional map of namespace and pagenames, this uses
	 * database fields page_namespace and page_title as keys and returns
	 * the value for those indexes.
	 * @since 2011-12-23
	 */
	protected function rowToKey( $row ) {
		$map = $this->getReverseMap();
		if ( isset( $map[$row->page_namespace][$row->page_title] ) ) {
			return $map[$row->page_namespace][$row->page_title];
		} else {
			wfWarn( "Got unknown title from the database: {$row->page_namespace}:{$row->page_title}" );
			return null;
		}
	}

	/**
	 * Creates a two-dimensional map of namespace and pagenames.
	 * @since 2011-12-23
	 */
	public function getReverseMap() {
		if ( isset( $this->reverseMap ) ) {
			return $this->reverseMap;
		}

		$map = array();
		foreach ( $this->keys as $mkey => $title ) {
			$map[$title->getNamespace()][$title->getDBKey()] = $mkey;
		}
		return $this->reverseMap = $map;
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
		$definitions = $this->definitions->getDefinitions();
		foreach ( array_keys( $this->keys ) as $mkey ) {
			$messages[$mkey] = new ThinMessage( $mkey, $definitions[$mkey] );
		}

		// Copy rows if any.
		if ( $this->dbData !== null ) {
			foreach ( $this->dbData as $row ) {
				$mkey = $this->rowToKey( $row );
				if ( !isset( $messages[$mkey] ) ) {
					continue;
				}
				$messages[$mkey]->setRow( $row );
				$messages[$mkey]->setProperty( 'revision', $row->page_latest );
			}
		}

		if ( $this->dbInfo !== null ) {
			$fuzzy = array();
			foreach ( $this->dbInfo as $row ) {
				if ( $row->rt_type !== null ) {
					$fuzzy[] = $this->rowToKey( $row );
				}
			}

			$this->setTags( 'fuzzy', $fuzzy );
		}

		// Copy tags if any.
		foreach ( $this->tags as $type => $keys ) {
			foreach ( $keys as $mkey ) {
				if ( isset( $messages[$mkey] ) ) {
					$messages[$mkey]->setTag( $type );
				}
			}
		}

		// Copy properties if any.
		foreach ( $this->properties as $type => $keys ) {
			foreach ( $keys as $mkey => $value ) {
				if ( isset( $messages[$mkey] ) ) {
					$messages[$mkey]->setProperty( $type, $value );
				}
			}
		}

		// Copy infile if any.
		foreach ( $this->infile as $mkey => $value ) {
			if ( isset( $messages[$mkey] ) ) {
				$messages[$mkey]->setInfile( $value );
			}
		}

		if ( $this->dbReviewData !== null ) {
			foreach ( $this->dbReviewData as $row ) {
				$mkey = $this->rowToKey( $row );
				if ( !isset( $messages[$mkey] ) ) {
					continue;
				}
				$messages[$mkey]->appendProperty( 'reviewers', $row->trr_user );
			}
		}

		$this->messages = $messages;
	}

	/**
	 * ArrayAccess methods. @{
	 * @param $offset
	 * @return bool
	 */
	public function offsetExists( $offset ) {
		return isset( $this->keys[$offset] );
	}

	/**
	 * @param $offset
	 * @return
	 */
	public function offsetGet( $offset ) {
		return $this->messages[$offset];
	}

	/**
	 * @param $offset
	 * @param $value
	 */
	public function offsetSet( $offset, $value ) {
		$this->messages[$offset] = $value;
	}

	/**
	 * @param $offset
	 */
	public function offsetUnset( $offset ) {
		unset( $this->keys[$offset] );
	}
	/** @} */

	/**
	 * Fail fast if trying to access unknown properties. @{
	 * @param $name
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
 *
 * API totally changed in 2011-12-28
 */
class MessageDefinitions {
	protected $namespace;
	protected $messages;

	public function __construct( array $messages, $namespace = false ) {
		$this->namespace = $namespace;
		$this->messages = $messages;
	}

	public function getDefinitions() {
		return $this->messages;
	}

	/**
	 * @return Array of Array( namespace, pagename )
	 */
	public function getPages() {
		$namespace = $this->namespace;
		$pages = array();
		foreach ( array_keys( $this->messages ) as $key ) {
			if ( $namespace === false ) {
				// pages are in format ex. "8:jan"
				$pages[$key] = explode( ':', $key, 2 );
			} else {
				$pages[$key] = array( $namespace, $key );
			}
		}
		return $pages;
	}
}
