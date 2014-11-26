<?php

/**
 * Default message cache (based on MW Message Cache)
 * Stores messages from messaging.wikia.com
 */
class DefaultMessagesCache {
	// Holds loaded messages that are defined in MediaWiki namespace.
	var $mCache;

	var $mUseCache, $mDisable, $mExpiry;

	// Variable for tracking which variables are loaded
	var $mLoadedLanguages = array();

	var $mLocalMessageCache = false;
	var $mLocalMessageCacheSerialized = true;

	function __construct( &$memCached, $useDB, $expiry ) {
		global $wgLocalMessageCache;

		$this->mUseCache = !is_null( $memCached );
		$this->mMemc = &$memCached;
		$this->mDisable = !$useDB;
		$this->mExpiry = $expiry;

		if( $wgLocalMessageCache !== false ) {
			$this->mLocalMessageCache = $wgLocalMessageCache;
		}
	}

	private function memcKey( /*... */ ) {
		global $wgDefaultMessagesDB;
		$args = func_get_args();
		$key = $wgDefaultMessagesDB . ':' . implode( ':', $args );
		return $key;
	}

	/**
	 * Try to load the cache from a local file.
	 * Actual format of the file depends on the $wgLocalMessageCacheSerialized
	 * setting.
	 *
	 * @param $hash String: the hash of contents, to check validity.
	 * @param $code Mixed: Optional language code, see documenation of load().
	 * @return false on failure.
	 */
	function loadFromLocal( $hash, $code ) {
		global $wgDefaultMessagesDB;

		$filename = $this->mLocalMessageCache . '/' . substr( $wgDefaultMessagesDB, 0, 1 ) . '/' . $wgDefaultMessagesDB . "/messages-$code";

		# Check file existence
		wfSuppressWarnings();
		$file = fopen( $filename, 'r' );
		wfRestoreWarnings();
		if ( !$file ) {
			return false; // No cache file
		}

		if ( $this->mLocalMessageCacheSerialized ) {
			// Check to see if the file has the hash specified
			$localHash = fread( $file, 32 );
			if ( $hash === $localHash ) {
				// All good, get the rest of it
				$serialized = '';
				while ( !feof( $file ) ) {
					$serialized .= fread( $file, 100000 );
				}
				fclose( $file );
				return $this->setCache( unserialize( $serialized ), $code );
			} else {
				fclose( $file );
				return false; // Wrong hash
			}
		} else {
			$localHash=substr(fread($file,40),8);
			fclose($file);
			if ($hash!=$localHash) {
				return false; // Wrong hash
			}

			# Require overwrites the member variable or just shadows it?
			require( $filename );
			return $this->setCache( $this->mCache, $code );
		}
	}

	/**
	 * Save the cache to a local file.
	 */
	function saveToLocal( $serialized, $hash, $code ) {
		global $wgDefaultMessagesDB;

		$dirname = $this->mLocalMessageCache . '/' . substr( $wgDefaultMessagesDB, 0, 1 ) . '/' . $wgDefaultMessagesDB;
		$filename = "$dirname/messages-$code";
		wfMkdirParents( $dirname, 0777 ); // might fail

		wfSuppressWarnings();
		$file = fopen( $filename, 'w' );
		wfRestoreWarnings();

		if ( !$file ) {
			wfDebug( "Unable to open local cache file for writing\n" );
			return;
		}

		fwrite( $file, $hash . $serialized );
		fclose( $file );
		@chmod( $filename, 0666 );
	}

	function saveToScript( $array, $hash, $code ) {
		global $wgDefaultMessagesDB;

		$filename = $this->mLocalMessageCache . "/messages-$wgDefaultMessagesDB-$code";
		$tempFilename = $filename . '.tmp';
		wfMkdirParents( $this->mLocalMessageCache, 0777 ); // might fail

		wfSuppressWarnings();
		$file = fopen( $tempFilename, 'w');
		wfRestoreWarnings();

		if ( !$file ) {
			wfDebug( "Unable to open local cache file for writing\n" );
			return;
		}

		fwrite($file,"<?php\n//$hash\n\n \$this->mCache = array(");

		foreach ($array as $key => $message) {
			$key = $this->escapeForScript($key);
			$messages = $this->escapeForScript($message);
			fwrite($file, "'$key' => '$message',\n");
		}

		fwrite($file,");\n?>");
		fclose($file);
		rename($tempFilename, $filename);
	}

	function escapeForScript($string) {
		$string = str_replace( '\\', '\\\\', $string );
		$string = str_replace( '\'', '\\\'', $string );
		return $string;
	}

	/**
	 * Set the cache to $cache, if it is valid. Otherwise set the cache to false.
	 */
	function setCache( $cache, $code ) {
		if ( isset( $cache['VERSION'] ) && $cache['VERSION'] == MSG_CACHE_VERSION ) {
			$this->mCache[$code] = $cache;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Loads messages from caches or from database in this order:
	 * (1) local message cache (if $wgLocalMessageCache is enabled)
	 * (2) memcached
	 * (3) from the database.
	 *
	 * When succesfully loading from (2) or (3), all higher level caches are
	 * updated for the newest version.
	 *
	 * Nothing is loaded if  member variable mDisabled is true, either manually
	 * set by calling code or if message loading fails (is this possible?).
	 *
	 * Returns true if cache is already populated or it was succesfully populated,
	 * or false if populating empty cache fails. Also returns true if MessageCache
	 * is disabled.
	 *
	 * @param $code String: language to which load messages
	 */
	function load( $code = false, $useDB = true ) {
		if ( !$this->mUseCache ) {
			return true;
		}

		if( !is_string( $code ) ) {
			# This isn't really nice, so at least make a note about it and try to
			# fall back
			wfDebug( __METHOD__ . " called without providing a language code\n" );
			$code = 'en';
		}

		# Don't do double loading...
		if ( isset($this->mLoadedLanguages[$code]) ) return true;

		# 8 lines of code just to say (once) that message cache is disabled
		if ( $this->mDisable ) {
			static $shownDisabled = false;
			if ( !$shownDisabled ) {
				wfDebug( __METHOD__ . ": disabled\n" );
				$shownDisabled = true;
			}
			return true;
		}

		# Loading code starts
		wfProfileIn( __METHOD__ );
		$success = false; # Keep track of success
		$where = array(); # Debug info, delayed to avoid spamming debug log too much
		$cacheKey = $this->memcKey( 'messages', $code ); # Key in memc for messages


		# (1) local cache
		# Hash of the contents is stored in memcache, to detect if local cache goes
		# out of date (due to update in other thread?)
		if ( $this->mLocalMessageCache !== false ) {
			wfProfileIn( __METHOD__ . '-fromlocal' );

			$hash = $this->mMemc->get( $this->memcKey( 'messages', $code, 'hash' ) );
			if ( $hash ) {
				$success = $this->loadFromLocal( $hash, $code );
				if ( $success ) $where[] = 'got from local cache';
			}
			wfProfileOut( __METHOD__ . '-fromlocal' );
		}

		# (2) memcache
		# Fails if nothing in cache, or in the wrong version.
		if ( !$success ) {
			wfProfileIn( __METHOD__ . '-fromcache' );
			$cache = $this->mMemc->get( $cacheKey );
			$success = $this->setCache( $cache, $code );
			if ( $success ) {
				$where[] = 'got from global cache';
				$this->saveToCaches( $cache, false, $code );
			}
			wfProfileOut( __METHOD__ . '-fromcache' );
		}


		# (3)
		# Nothing in caches... so we need create one and store it in caches
		if ( !$success && $useDB) {
			$where[] = 'cache is empty';
			$where[] = 'loading from database';

			$this->lock($cacheKey);

			$cache = $this->loadFromDB( $code );
			$success = $this->setCache( $cache, $code );
			if ( $success ) {
				$this->saveToCaches( $cache, true, $code );
			}

			$this->unlock($cacheKey);
		}

		if ( !$success ) {
			# Bad luck... this should not happen
			$where[] = 'loading FAILED - cache is disabled';
			$info = implode( ', ', $where );
			wfDebug( __METHOD__ . ": Loading $code... $info\n" );
			$this->mDisable = true;
			$this->mCache = false;
		} else {
			# All good, just record the success
			$info = implode( ', ', $where );
			wfDebug( __METHOD__ . ": Loading $code... $info\n" );
			$this->mLoadedLanguages[$code] = true;
		}
		wfProfileOut( __METHOD__ );
		return $success;
	}

	/**
	 * Loads cacheable messages from the database. Messages bigger than
	 * $wgMaxMsgCacheEntrySize are assigned a special value, and are loaded
	 * on-demand from the database later.
	 *
	 * @param $code Optional language code, see documenation of load().
	 * @return Array: Loaded messages for storing in caches.
	 */
	function loadFromDB( $code = false ) {
		wfProfileIn( __METHOD__ );
		global $wgMaxMsgCacheEntrySize;
		global $wgDefaultMessagesDB;
		$dbr = wfGetDB( DB_SLAVE, array(), $wgDefaultMessagesDB );
		$cache = array();

		# Common conditions
		$conds = array(
			'page_is_redirect' => 0,
			'page_namespace' => NS_MEDIAWIKI,
		);

		if ( $code ) {
			# Is this fast enough. Should not matter if the filtering is done in the
			# database or in code.
			if ( $code !== 'en' ) {
				# Messages for particular language
				$conds[] = "page_title" . $dbr->buildLike( $dbr->anyString(), "/$code" );
			} else {
				# Effectively disallows use of '/' character in NS_MEDIAWIKI for uses
				# other than language code.
				$conds[] = "(page_title not like '%%/%%') OR (page_title like '%%/en')";
			}
		}

		# Conditions to fetch oversized pages to ignore them
		$bigConds = $conds;
		$bigConds[] = 'page_len > ' . intval( $wgMaxMsgCacheEntrySize );

		# Load titles for all oversized pages in the MediaWiki namespace
		$res = $dbr->select( "page", 'page_title', $bigConds, __METHOD__ );
		while ( $row = $dbr->fetchObject( $res ) ) {
			$cache[$row->page_title] = '!TOO BIG';
		}
		$dbr->freeResult( $res );

		# Conditions to load the remaining pages with their contents
		$smallConds = $conds;
		$smallConds[] = 'page_latest=rev_id';
		$smallConds[] = 'rev_text_id=old_id';
		$smallConds[] = 'page_len <= ' . intval( $wgMaxMsgCacheEntrySize );

		$res = $dbr->select( array( "page", "revision", "text" ),
			array( 'page_title', 'old_text', 'old_flags' ),
			$smallConds, __METHOD__ );

		while ( $row = $dbr->fetchObject( $res ) ) {
			$cache[$row->page_title] = ' ' . Revision::getRevisionText( $row );
		}
		$dbr->freeResult( $res );

		$cache['VERSION'] = MSG_CACHE_VERSION;
		wfProfileOut( __METHOD__ );
		return $cache;
	}

	/**
	 * Shortcut to update caches.
	 *
	 * @param $cache Array: cached messages with a version.
	 * @param $cacheKey String: Identifier for the cache.
	 * @param $memc Bool: Wether to update or not memcache.
	 * @param $code String: Language code.
	 * @return False on somekind of error.
	 */
	protected function saveToCaches( $cache, $memc = true, $code = false ) {
		wfProfileIn( __METHOD__ );

		if ( F::app()->wg->AllowMemcacheDisable && ( F::app()->wg->AllowMemcacheWrites == false ) ) {
			return true;
		}

		$cacheKey = $this->memcKey( 'messages', $code );
		$statusKey = $this->memcKey( 'messages', $code, 'status' );

		$success = $this->mMemc->add( $statusKey, 'loading', MSG_LOAD_TIMEOUT );
		if ( !$success ) {
			wfProfileOut( __METHOD__ );
			return true; # Other process should be updating them now
		}

		$i = 0;
		if ( $memc ) {
			# Save in memcached
			# Keep trying if it fails, this is kind of important

			for ($i=0; $i<20 &&
				!$this->mMemc->set( $cacheKey, $cache, $this->mExpiry );
				$i++ ) {
				usleep(mt_rand(500000,1500000));
			}
		}

		# Save to local cache
		if ( $this->mLocalMessageCache !== false ) {
			$serialized = serialize( $cache );
			$hash = md5( $serialized );
			$this->mMemc->set( $this->memcKey( 'messages', $code, 'hash' ), $hash, $this->mExpiry );
			if ($this->mLocalMessageCacheSerialized) {
				$this->saveToLocal( $serialized, $hash, $code );
			} else {
				$this->saveToScript( $cache, $hash, $code );
			}
		}

		if ( $i == 20 ) {
			$this->mMemc->set( $statusKey, 'error', 60*5 );
			wfDebug( "MemCached set error in MessageCache: restart memcached server!\n" );
			$success = false;
		} else {
			$this->mMemc->delete( $statusKey );
			$success = true;
		}
		wfProfileOut( __METHOD__ );
		return $success;
	}

	/**
	 * Returns success
	 * Represents a write lock on the messages key
	 */
	function lock($key) {
		if ( !$this->mUseCache ) {
			return true;
		}

		$lockKey = $key . ':lock';
		for ($i=0; $i < MSG_WAIT_TIMEOUT && !$this->mMemc->add( $lockKey, 1, MSG_LOCK_TIMEOUT ); $i++ ) {
			sleep(1);
		}

		return $i >= MSG_WAIT_TIMEOUT;
	}

	function unlock($key) {
		if ( !$this->mUseCache ) {
			return;
		}

		$lockKey = $key . ':lock';
		$this->mMemc->delete( $lockKey );
	}

	/**
	 * Get a message from the MediaWiki namespace, with caching. The key must
	 * first be converted to two-part lang/msg form if necessary.
	 *
	 * @param $title String: Message cache key with initial uppercase letter.
	 * @param $code String: code denoting the language to try.
	 */
	function get( $title, $code, $useDB=true ) {
		$type = false;
		$message = false;

		if ( $this->mUseCache ) {
			$this->load( $code, $useDB );
			if (isset( $this->mCache[$code][$title] ) ) {
				$entry = $this->mCache[$code][$title];
				$type = substr( $entry, 0, 1 );
				if ( $type == ' ' ) {
					return substr( $entry, 1 );
				}
			}
		}

		# If there is no cache entry and no placeholder, it doesn't exist
		if ( $type !== '!' ) {
			return false;
		}

		$titleKey = $this->memcKey( 'messages', 'individual', $title );

		# Try the individual message cache
		if ( $this->mUseCache ) {
			$entry = $this->mMemc->get( $titleKey );
			if ( $entry ) {
				$type = substr( $entry, 0, 1 );

				if ( $type === ' ' ) {
					# Ok!
					$message = substr( $entry, 1 );
					$this->mCache[$code][$title] = $entry;
					return $message;
				} elseif ( $entry === '!NONEXISTENT' ) {
					return false;
				} else {
					# Corrupt/obsolete entry, delete it
					$this->mMemc->delete( $titleKey );
				}

			}
		}

		if( $useDB ) {
			// Try loading it from the DB
			global $wgDefaultMessagesDB;
			$t = Title::makeTitle( NS_MEDIAWIKI, $title );
			$db = wfGetDB( DB_SLAVE, array(), $wgDefaultMessagesDB );
			$row = $db->selectRow( array( "page", "revision", "text" ),
					array( '*' ),
					array(
						'page_namespace' => $t->getNamespace(),
						'page_title' => $t->getDBkey(),
						'page_latest = rev_id',
						'old_id = rev_text_id'
					     ) );
			if( $row ) {
				$message = Revision::getRevisionText( $row );
				if ($this->mUseCache) {
					$this->mCache[$code][$title] = ' ' . $message;
					$this->mMemc->set( $titleKey, $message, $this->mExpiry );
				}
			} else {
				// Negative caching
				// Use some special text instead of false, because false gets converted to '' somewhere
				$this->mMemc->set( $titleKey, '!NONEXISTENT', $this->mExpiry );
				$this->mCache[$code][$title] = false;
			}
		}
		return $message;
	}

	function disable() { $this->mDisable = true; }
	function enable() { $this->mDisable = false; }

	/**
	 * Clear all stored messages. Mainly used after a mass rebuild.
	 */
	function clear() {
		if( $this->mUseCache ) {
			$langs = Language::getLanguageNames( false );
			foreach ( array_keys($langs) as $code ) {
				# Global cache
				$this->mMemc->delete( $this->memcKey( 'messages', $code ) );
				# Invalidate all local caches
				$this->mMemc->delete( $this->memcKey( 'messages', $code, 'hash' ) );
			}
		}
	}

}
