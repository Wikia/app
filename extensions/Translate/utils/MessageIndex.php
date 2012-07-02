<?php
/**
 * Contains classes for handling the message index.
 *
 * @file
 * @author Niklas Laxstrom
 * @copyright Copyright © 2008-2011, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Creates a database of keys in all groups, so that namespace and key can be
 * used to get the groups they belong to. This is used as a fallback when
 * loadgroup parameter is not provided in the request, which happens if someone
 * reaches a messages from somewhere else than Special:Translate. Also used
 * by Special:TranslationStats and alike which need to map lots of titles
 * to message groups.
 */
abstract class MessageIndex {
	/// @var MessageIndex
	protected static $instance;

	/**
	 * @return MessageIndex
	 */
	public static function singleton() {
		if ( self::$instance === null ) {
			global $wgTranslateMessageIndex;
			$params = $wgTranslateMessageIndex;
			$class = array_shift( $params );
			self::$instance = new $class( $params );
		}
		return self::$instance;
	}


	/**
	 * @since 2012-01-04
	 * @return array
	 */
	public static function getGroupIds( MessageHandle $handle ) {
		$namespace = $handle->getTitle()->getNamespace();
		$key = $handle->getKey();
		$normkey = strtr( strtolower( "$namespace:$key" ), " ", "_"  );

		$index = self::singleton()->retrieve();
		if ( isset( $index[$normkey] ) ) {
			return (array) $index[$normkey];
		} else {
			return array();
		}
	}

	/**
	 * @since 2012-01-04
	 * @return MessageGroup|null
	 */
	public static function getPrimaryGroupId( MessageHandle $handle ) {
		$groups = self::getGroupIds( $handle );
		return count( $groups ) ? array_shift( $groups ) : null;
	}

	/** @return array */
	abstract public function retrieve();
	abstract protected function store( array $array );

	public function rebuild( /*bool*/ $scratch = false ) {
		$groups = MessageGroups::singleton()->getGroups();

		$new = $old = array();
		if ( !$scratch ) {
			// To avoid inifinite recursion
			$old = $this->retrieve();
		}
		$postponed = array();

		STDOUT( "Working with ", 'main' );

		foreach ( $groups as $g ) {
			if ( !$g->exists() ) {
				continue;
			}

			# Skip meta thingies
			if ( $g->isMeta() ) {
				$postponed[] = $g;
				continue;
			}

			$this->checkAndAdd( $new, $g );
		}

		foreach ( $postponed as $g ) {
			$this->checkAndAdd( $new, $g, true );
		}

		$this->store( $new );
		$this->clearMessageGroupStats( $old, $new );
		return $new;
	}

	/**
	 * Purge message group stats when set of keys have changed.
	 * @param $old array
	 * @param $new array
	 */
	protected function clearMessageGroupStats( array $old, array $new ) {
		$changes = array();
		foreach ( array_diff_assoc( $new, $old ) as $groups ) {
			foreach ( (array) $groups as $group ) $changes[$group] = true;
		}

		foreach ( array_diff_assoc( $old, $new ) as $groups ) {
			foreach ( (array) $groups as $group ) $changes[$group] = true;
		}

		MessageGroupStats::clearGroup( array_keys( $changes ) );
	}

	/**
	 * @param $hugearray array
	 * @param $g
	 * @param $ignore bool
	 */
	protected function checkAndAdd( &$hugearray, $g, $ignore = false ) {
		if ( $g instanceof MessageGroupBase ) {
			$cache = new MessageGroupCache( $g );

			if ( $cache->exists() ) {
				$keys = $cache->getKeys();
			} else {
				$keys = array_keys( $g->getDefinitions() );
			}
		} else {
			$messages = $g->getDefinitions();

			if ( !is_array( $messages ) ) {
				return;
			}

			$keys = array_keys( $messages );
		}

		$id = $g->getId();

		STDOUT( "$id ", 'main' );

		$namespace = $g->getNamespace();

		foreach ( $keys as $key ) {
			# Force all keys to lower case, because the case doesn't matter and it is
			# easier to do comparing when the case of first letter is unknown, because
			# mediawiki forces it to upper case
			$key = TranslateUtils::normaliseKey( $namespace, $key );
			if ( isset( $hugearray[$key] ) ) {
				if ( !$ignore ) {
					$to = implode( ', ', (array)$hugearray[$key] );
					STDERR( "Key $key already belongs to $to, conflict with $id" );
				}

				if ( is_array( $hugearray[$key] ) ) {
					// Hard work is already done, just add a new reference
					$hugearray[$key][] = &$id;
				} else {
					// Store the actual reference, then remove it from array, to not
					// replace the references value, but to store a array of new
					// references instead. References are hard!
					$value = &$hugearray[$key];
					unset( $hugearray[$key] );
					$hugearray[$key] = array( &$value, &$id );
				}
			} else {
				$hugearray[$key] = &$id;
			}
		}
		unset( $id ); // Disconnect the previous references to this $id
	}
}

/**
 * Storage on serialized file.
 */
class FileCachedMessageIndex extends MessageIndex {
	/// @var array
	protected $index;

	protected $filename = 'translate_messageindex.ser';

	/** @return array */
	public function retrieve() {
		if ( $this->index !== null ) {
			return $this->index;
		}

		$file = TranslateUtils::cacheFile( $this->filename );
		if ( file_exists( $file ) ) {
			return $this->index = unserialize( file_get_contents( $file ) );
		} else {
			return $this->index = $this->rebuild( 'empty' );
		}
	}

	protected function store( array $array ) {
		$file = TranslateUtils::cacheFile( $this->filename );
		file_put_contents( $file, serialize( $array ) );
	}

}

/**
 * Storage on ObjectCache.
 */
class CachedMessageIndex extends MessageIndex {
	protected $key = 'translate-messageindex';
	protected $cache;

	/// @var array
	protected $index;

	protected function __construct( array $params ) {
		$this->cache = wfGetCache( CACHE_ANYTHING );
	}

	/** @return array */
	public function retrieve() {
		if ( $this->index !== null ) {
			return $this->index;
		}

		$key = wfMemckey( $this->key );
		$data = $this->cache->get( $key );
		if ( is_array( $data ) ) {
			return $this->index = $data;
		} else {
			return $this->index = $this->rebuild( 'empty' );
		}
	}

	protected function store( array $array ) {
		$key = wfMemckey( $this->key );
		$this->cache->set( $key, $array );
	}

}
