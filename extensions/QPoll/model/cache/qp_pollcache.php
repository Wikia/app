<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Single row cache for poll descriptions.
 * Also, it's a base class for multi-row caches.
 */
class qp_PollCache {

	# an instance of qp_PollStore
	static $store;
	# instance of DB_MASTER to cache
	static $db;

	# DB table name
	protected $tableName = 'qp_poll_desc';
	# DB index for replace
	protected $replaceIndex = array( 'poll', 'article_poll' );
	# DB table fields to select / replace
	protected $fields = array( 'pid', 'order_id', 'dependance', 'interpretation_namespace', 'interpretation_title', 'random_question_count' );

	# iterable database result object when data was loaded from DBMS
	protected $dbres;
	# single-row replace 2d associative keys array for
	# Database::replace using $this->replaceIndex
	# it should have both $this->fields keys and replace index keys
	# inherited multi-row caches use 3d array with multiple rows instead
	protected $replace;
	# whether new rows should be inserted when there is no row specified by $this->replaceIndex in $this->tableName
	protected $createNewRows = false;
	# final result of load (either from DBMS or from memory cache)
	# stdClass which has $this->fields as keys
	# inherited multi-row caches use array( stdClass, stdClass, ...) instead
	var $rows;
	# single-row 2d numeric keys array for memory cache storage
	# it is more compact than $this->replace,
	# it has only integer keys to minimize memory cache RAM usage
	# inherited multi-row caches use similar 3d array instead
	protected $memc_rows;

	/**
	 * Use store for this class and it's ancestors
	 * @param  $store  an instance of qp_PollStore
	 */
	static function setStore( qp_PollStore $store ) {
		self::$store = $store;
	}

	/**
	 * Loads $this->rows either from DB or from memory cache.
	 * When memory cache is empty, fills it with data got from DB.
	 * @param  $db  instance of DB_MASTER
	 * @param  $className  name of current class or it's ancestors.
	 *         It is required because PHP 5.2 has no late static binding.
	 *         $create  boolean  true, insert new DB row(s), when DB row(s)
	 *         with specified $this->replaceIndex key does not exists.
	 */
	static function load( $db, $className = __CLASS__, $create = false ) {
		global $wgMemc;
		self::$db = $db;
		# poor man way of emulating late static binding
		$self = new $className();
		if ( !($self instanceof self ) ) {
			throw new MWException( 'className parameter has to be a name of ' . __CLASS__ . ' or it\'s ancestors in ' . __METHOD__ );
		}
		$self->createNewRows = $create;
		# try to get $self->rows from memory cache
		if ( ( $self->rows = $wgMemc->get( $self->getMemcKey() ) ) !== false &&
				( count( $self->rows ) > 0 || !$self->createNewRows ) ) {
			# memory cache hit
			# zero-rows cache read is considered to be a cache hit only when
			# $self->createNewRows === false; otherwise self::create() will fail
			# after self::load() "probe" for yet non-existing poll.
			$self->numRowsToAssocRows();
			return $self->rows;
		}
		# memory cache miss
		# try to load from DB (get $this->dbres)
		$self->loadFromDB();
		# update self-state from $this->dbres
		$self->rows = array();
		$self->memc_rows = array();
		# _try_ to update self-state from $this->dbres
		$self->updateFromDBres();
		if ( count( $self->rows ) === 0 ) {
			# DB miss
			if ( $self->createNewRows ) {
				$self->insertRows();
				# update self from qp_PollStore properties
				# (prepare for memory cache update)
				$self->updateFromPollStore();
			}
		}
		$self->setMemc();
		# note: no need to perform intval() on the selected fields in caller,
		# it's already been done in $this->convertFromString()
		return $self->rows;
	}

	/**
	 * The same as self::load(), but with $create parameter set to true
	 * by default.
	 */
	static function create( $db, $className = __CLASS__ ) {
		return self::load( $db, $className, true );
	}

	/**
	 * Stores data from current qp_PollStore instance to memory cache,
	 * and optionally to DB.
	 * @param $db  null - will store only to memory cache (assumes that
	 *             DB is already in sync with qp_PollStore, thus only
	 *             the memory cache has to be set);
	 *             instance of DB_MASTER - will store to DB as well;
	 * @param $className1, ... $classNameN - one or more PHP class names
	 *             that will be instantiated to store their partial data from
	 *             current qp_PollStore;
	 *
	 */
	static function store( /* $db, $className1, ... $classNameN */ ) {
		$args = func_get_args();
		self::$db = array_shift( $args );
		foreach ( $args as $className ) {
			$self = new $className();
			if ( !($self instanceof self ) ) {
				throw new MWException( 'className parameter has to be a name of ' . __CLASS__ . ' or it\'s ancestors in ' . __METHOD__ );
			}
			if ( self::$db === null ) {
				## store only to memory cache, DB is assumed to be already
				## in sync with self::$store
				# update self from qp_PollStore properties
				# (prepare for memory cache update)
				$self->updateFromPollStore();
				# store $this->memc_rows into memory cache
				$self->setMemc();
			} else {
				# store both to DB and to memory cache
				$self->storePolymorph();
			}
		}
	}

	/**
	 * Convert numeric key array $this->rows to
	 * $this->rows stdClass with associative keys
	 */
	protected function numRowsToAssocRows() {
		# build DBMS-like object row from array row
		if ( count( $this->rows ) > 0 ) {
			$this->rows = (object) array_combine( $this->fields, $this->rows );
		}
	}

	/**
	 * Get string key associated to replaced DB fields
	 */
	protected function getMemcKey() {
		if ( self::$store->mArticleId === null ) {
			throw new MWException( "article_id should be set in " . __METHOD__ );
		}
		if ( self::$store->mPollId === null ) {
			throw new MWException( "poll_id should be set in " . __METHOD__ );
		}
		# pd means poll_desc
		return wfMemcKey( 'qpoll', 'pd', self::$store->mArticleId, self::$store->mPollId );
	}

	/**
	 * Select one or more row(s) from DB to $this->dbres
	 */
	protected function loadFromDB() {
		$this->dbres = self::$db->select( $this->tableName,
			$this->fields,
			array( 'article_id' => self::$store->mArticleId, 'poll_id' => self::$store->mPollId ),
			__METHOD__
		);
	}

	/**
	 *	Set non-string DB row properties to their original types.
	 *	Without that, cache hit check will fail: integer value will not match string value
	 *	from DB. Database class returns string values even for integer fields, however
	 *	qp_PollStore always uses integers for integer properties.
	 */
	protected function convertFromString( $row ) {
		$row->pid = intval( $row->pid );
		$row->order_id = intval( $row->order_id );
		$row->interpretation_namespace = intval( $row->interpretation_namespace );
		$row->random_question_count = intval( $row->random_question_count );
	}

	/**
	 * Makes self-state to be in sync with $this->dbres (DB result).
	 * That will allow to synchronize memory cache in the next step.
	 */
	protected function updateFromDBres() {
		# Populate $this->rows and $this->memc_rows with DB data
		# from $this->dbres.
		# we cannot use Database::fetchRow() because it will set both
		# numeric and associative keys (x2 fields)
		if ( ( $row = self::$db->fetchObject( $this->dbres ) ) !== false ) {
			$this->convertFromString( $row );
			$this->memc_rows = array_values( (array)$row );
			$this->rows = (object) $row;
		}
	}

	/**
	 * Makes self-state to be in sync with qp_PollStore properties.
	 * That will allow to synchronize memory cache in the next step.
	 */
	protected function updateFromPollStore() {
		# multi-row ancestors should take in account that $this->memc_rows
		# might be uninitialized when this method was called
		# $this->memc_rows = array();
		# $this->rows = array();
		# update $this->memc_rows from store
		$this->memc_rows = array(
			self::$store->pid,
			self::$store->mOrderId,
			self::$store->dependsOn,
			self::$store->interpNS,
			self::$store->interpDBkey,
			self::$store->randomQuestionCount
		);
		# update $this->rows from store
		$this->rows = (object) array_combine( $this->fields, $this->memc_rows );
	}

	/**
	 * Insert new DB row(s) when row(s) with current $this->replaceIndex is
	 * not present in DB.
	 */
	protected function insertRows() {
		self::$db->insert( $this->tableName,
			array(
				'article_id' => self::$store->mArticleId,
				'poll_id' => self::$store->mPollId,
				'order_id' => self::$store->mOrderId,
				'dependance' => self::$store->dependsOn,
				'interpretation_namespace' => self::$store->interpNS,
				'interpretation_title' => self::$store->interpDBkey,
				'random_question_count' => self::$store->randomQuestionCount
			),
			__METHOD__
		);
		# update current instance of qp_PollStore so it will be in sync with DB state
		self::$store->pid = self::$db->insertId();
	}

	/**
	 * Populates memory cache object with $this->memc_rows
	 */
	protected function setMemc() {
		global $wgMemc;
		/*
		if ( count( $this->memc_rows ) > 0 ) {
			$wgMemc->set( $this->getMemcKey(), $this->memc_rows );
		} else {
			$wgMemc->delete( $this->getMemcKey() );
		} */
		# Always store the result, even for empty sets to minimize
		# number of DB queries. Empty sets are possible because
		# poll structures are not stored during page view (GET).
		# They will be properly updated during POST by self::store()
		# Only randomized poll description row is stored during GET,
		# as an exception.
		$wgMemc->set( $this->getMemcKey(), $this->memc_rows );
	}

	/**
	 * Store row(s) both to DB and to memory cache.
	 */
	protected function storePolymorph() {
		global $wgMemc;
		$this->replace = array();
		$this->buildReplaceRows();
		# Update self from qp_PollStore properties
		# (prepare for memory cache update).
		# Otherwise $this->memc_rows will not be in sync
		$this->updateFromPollStore();
		if ( count( $this->replace ) < 1 ) {
			# this cannot happen here; however it can happen in ancestor classes
			throw new MWException( "zero rows replace in " . __METHOD__ );
		}
		$replaceRows = ( $curr_cache_rows = $wgMemc->get( $this->getMemcKey() ) ) === false ||
			serialize( $curr_cache_rows ) !== serialize( $this->memc_rows );
		# replace into DB only when current state does not match memory cache
		if ( $replaceRows ) {
			# update DB
			self::$db->replace( $this->tableName,
				array( $this->replaceIndex ),
				$this->replace,
				__METHOD__
			);
			# update memory cache
			$this->setMemc();
		}
	}

	/**
	 * Initializes DB row(s) for Database::replace() operation into
	 * $this->replace
	 * Also, should keep $this->memc_rows in sync.
	 */
	protected function buildReplaceRows() {
		global $wgContLang;
		$this->replace = array(
			'pid' => self::$store->pid,
			'article_id' => self::$store->mArticleId,
			'poll_id' => self::$store->mPollId,
			'order_id' => self::$store->mOrderId,
			'dependance' => self::$store->dependsOn,
			'interpretation_namespace' => self::$store->interpNS,
			'interpretation_title' => self::$store->interpDBkey,
			'random_question_count' => self::$store->randomQuestionCount
		);
	}

} /* end of qp_PollCache class */
