<?php

/**
 * This object contains caches and various items of processing context for 
 * SecurePoll. It manages instances of long-lived objects such as the 
 * SecurePoll_Store subclass.
 *
 * Long-lived data should be stored here, rather than in global variables or
 * static member variables.
 *
 * A context object is passed to almost all SecurePoll constructors. This class
 * provides factory functions for these objects, to simplify object creation 
 * and avoid having to use the SecurePoll_* prefixed class names.
 *
 * For debugging purposes, a var_dump() workalike which omits context objects 
 * is available as $context->varDump().
 */
class SecurePoll_Context {
	/** Language fallback sequence */
	public $languages = array( 'en' );

	/** Message text cache */
	var $messageCache = array();
	
	/** election cache */
	var $electionCache = array();

	/** 
	 * Which messages are loaded. 2-d array: language and entity ID, value arbitrary. 
	 */
	var $messagesLoaded = array();

	/** ParserOptions instance used for message parsing */
	var $parserOptions;

	/** The store class, for lazy loading */
	var $storeClass = 'SecurePoll_DBStore';

	/** The store object */
	var $store;

	/** The SecurePoll_Random instance */
	var $random;

	/** The Database instance */
	var $db;

	/**
	 * Create a new SecurePoll_Context with an XML file as the storage backend.
	 * Returns false if there was a problem with the file, like a parse error.
	 */
	static function newFromXmlFile( $fileName ) {
		$context = new self;
		$store = new SecurePoll_XMLStore( $fileName );
		$context->setStore( $store );
		$success = $store->readFile();
		if ( $success ) {
			return $context;
		} else {
			return false;
		}
	}

	/**
	 * Get the ParserOptions instance
	 * @return ParserOptions
	 */
	function getParserOptions() {
		if ( !$this->parserOptions ) {
			$this->parserOptions = new ParserOptions;
		}
		return $this->parserOptions;
	}

	/**
	 * Get the SecurePoll_Store instance
	 * @return SecurePoll_Store
	 */
	function getStore() {
		if ( !isset( $this->store ) ) {
			$this->store = new $this->storeClass;
		}
		return $this->store;
	}

	/** Get a Title object for Special:SecurePoll */
	function getSpecialTitle( $subpage = false ) {
		return SpecialPage::getTitleFor( 'SecurePoll', $subpage );
	}

	/** Set the store class */
	function setStoreClass( $class ) {
		$this->store = null;
		$this->messageCache = $this->messagesLoaded = array();
		$this->storeClass = $class;
	}

	/** Set the store object. Overrides any previous store class. */
	function setStore( $store ) {
		$this->messageCache = $this->messagesLoaded = array();
		$this->store = $store;
	}
	
	/** Get the type of a particular entity **/
	function getEntityType( $id ) {
		return $this->getStore()->getEntityType( $id );
	}

	/** 
	 * Get an election object from the store, with a given entity ID. Returns 
	 * false if it does not exist.
	 */
	function getElection( $id ) {
		if( !isset( $this->electionCache[$id] ) ) {
			$info = $this->getStore()->getElectionInfo( array( $id ) );
			if ( $info ) {
				$this->electionCache[$id] = $this->newElection( reset( $info ) );
			} else {
				$this->electionCache[$id] = false;
			}
		}
		return $this->electionCache[$id];
	}

	/**
	 * Get an election object from the store, with a given name. Returns false 
	 * if there is no such election.
	 */
	function getElectionByTitle( $name ) {
		$info = $this->getStore()->getElectionInfoByTitle( array( $name ) );
		if ( $info ) {
			return $this->newElection( reset( $info ) );
		} else {
			return false;
		}
	}

	/**
	 * Get an election object from a securepoll_elections DB row. This will fail
	 * if the current store class does not support database operations.
	 */
	function newElectionFromRow( $row ) {
		$info = $this->getStore()->decodeElectionRow( $row );
		return $this->newElection( $info );
	}

	/**
	 * Get a voter object from a securepoll_voters row
	 */
	function newVoterFromRow( $row ) {
		return SecurePoll_Voter::newFromRow( $this, $row );
	}

	/**
	 * Create a voter with the given parameters. Assumes the voter does not exist,
	 * and inserts it into the database.
	 *
	 * The row needs to be locked before this function is called, to avoid 
	 * duplicate key errors.
	 */
	function createVoter( $params ) {
		return SecurePoll_Voter::createVoter( $this, $params );
	}

	/**
	 * Create a voter object from the database
	 * @return SecurePoll_Voter or false if the ID is not valid
	 */
	function getVoter( $id ) {
		return SecurePoll_Voter::newFromId( $this, $id );
	}

	/**
	 * Get a SecurePoll_Random instance. This provides cryptographic random 
	 * number generation.
	 * @return SecurePoll_Random
	 */
	function getRandom() {
		if ( !$this->random ) {
			$this->random = new SecurePoll_Random;
		}
		return $this->random;
	}
	/**
	 * Set the global language fallback sequence. 
	 *
	 * @param $languages array A list of language codes. When a message is 
	 *     requested, the first code in the array will be tried first, followed
	 *     by the subsequent codes.
	 */
	function setLanguages( $languages ) {
		$this->languages = $languages;
	}

	/**
	 * Get some messages from the backend store or the cache. 
	 * This is an internal interface for SecurePoll_Entity, generally you 
	 * should use SecurePoll_Entity::getMessage() instead.
	 *
	 * @param $lang Language code
	 * @param $ids Entity IDs
	 */
	function getMessages( $lang, $ids ) {
		if ( isset( $this->messagesLoaded[$lang] ) ) {
			$cacheRow = $this->messagesLoaded[$lang];
			$uncachedIds = array_flip( $ids );
			foreach ( $uncachedIds as $id => $unused ) {
				if ( isset( $cacheRow[$id] ) ) {
					unset( $uncachedIds[$id] );
				}
			}
			if ( count( $uncachedIds ) ) {
				$messages = $this->getStore()->getMessages( $lang, array_keys( $uncachedIds ) );
				$this->messageCache[$lang] = $this->messageCache[$lang] + $messages;
				$this->messagesLoaded[$lang] = $this->messagesLoaded[$lang] + $uncachedIds;
			}
			return array_intersect_key( $this->messageCache[$lang], array_flip( $ids ) );
		} else {
			$this->messagesLoaded[$lang] = $ids;
			$this->messageCache[$lang] = $this->getStore()->getMessages( $lang, $ids );
			return $this->messageCache[$lang];
		}
	}

	/**
	 * Get a particular message.
	 * This is an internal interface for SecurePoll_Entity, generally you 
	 * should use SecurePoll_Entity::getMessage() instead.
	 *
	 * @param $lang Language code
	 * @param $id Entity ID
	 * @param $key Message key
	 */
	function getMessage( $lang, $id, $key ) {
		if ( !isset( $this->messagesLoaded[$lang][$id] ) ) {
			$this->getMessages( $lang, array( $id ) );
		}
		if ( isset( $this->messageCache[$lang][$id][$key] ) ) {
			return $this->messageCache[$lang][$id][$key];
		} else {
			return false;
		}
	}

	/**
	 * Get a database object, or throw an exception if the current store object 
	 * does not support database operations.
	 * @return DatabaseBase
	 */
	function getDB() {
		if ( !isset( $this->db ) ) {
			$this->db = $this->getStore()->getDB();
		}
		return $this->db;
	}

	function newElection( $info ) {
		return new SecurePoll_Election( $this, $info );
	}

	function newQuestion( $info ) {
		return new SecurePoll_Question( $this, $info );
	}

	function newOption( $info ) {
		return new SecurePoll_Option( $this, $info );
	}

	function newCrypt( $type, $election ) {
		return SecurePoll_Crypt::factory( $this, $type, $election );
	}

	function newTallier( $type, $electionTallier, $question ) {
		return SecurePoll_Tallier::factory( $this, $type, $electionTallier, $question );
	}

	function newBallot( $type, $election ) {
		return SecurePoll_Ballot::factory( $this, $type, $election );
	}

	function newAuth( $type ) {
		return SecurePoll_Auth::factory( $this, $type );
	}

	function newVoter( $params ) {
		return new SecurePoll_Voter( $this, $params );
	}	

	function newElectionTallier( $election ) {
		return new SecurePoll_ElectionTallier( $this, $election );
	}

	/**
	 * Debugging function to output a representation of a mixed-type variable,
	 * but omitting the $obj->context member variables for brevity.
	 *
	 * @param $var mixed
	 * @param $return True to return the text instead of echoing
	 * @param $level Recursion level, leave this as zero when calling.
	 */
	function varDump( $var, $return = false, $level = 0 ) {
		$tab = '    ';
		$indent = str_repeat( $tab, $level );
		if ( is_array( $var ) ) {
			$s = "array(\n";
			foreach ( $var as $key => $value ) {
				$s .= "$indent$tab" . $this->varDump( $key, true, $level + 1 ) . " => " . 
					$this->varDump( $value, true, $level + 1 ) . ",\n";
			}
			$s .= "{$indent})";
		} elseif ( is_object( $var ) ) {
			$props = (array)$var;
			$s = get_class( $var ) . " {\n";
			foreach ( $props as $key => $value ) {
				$s .= "$indent$tab" . $this->varDump( $key, true, $level + 1 ) . " => ";
				if ( $key === 'context' ) {
					$s .= "[CONTEXT],\n";
				} else {
					$s .= $this->varDump( $value, true, $level + 1 ) . ",\n";
				}
			}
			$s .= "{$indent}}";
		} else {
			$s = var_export( $var, true );
		}
		if ( $level == 0 ) {
			$s .= "\n";
		}
		if ( $return ) {
			return $s;
		} else {
			echo $s;
		}
	}

	function getResourceUrl( $resource ) {
		global $wgScriptPath;
		return "$wgScriptPath/extensions/SecurePoll/resources/$resource";
	}	
}
