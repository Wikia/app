<?php

/**
 * Class for cooperative locking of web resources
 *
 * Each resource is identified by a combination of the "resource type" (the application, the
 * type of content, etc), and the resource's primary key or some other unique numeric ID.
 *
 * Currently, a resource can only be checked out by a single user. Other attempts to check it
 * out result in the checkout failing. In the future, an option for multiple simulataneous
 * checkouts could be added without much trouble.
 *
 * This could be done with named locks, except then it would be impossible to build a list of
 * all the resources currently checked out for a given application. There's no good way to
 * construct a query that answers the question, "What locks do you have starting with [foo]"
 * This could be done really well with a concurrent, reliable, distributed key/value store,
 * but we don't have one of those right now.
 *
 * @author Ian Baker <ian@wikimedia.org>
 */
class ConcurrencyCheck {
	protected $expirationTime;

	/**
	 * @var User
	 */
	protected $user;

	/**
	 * Constructor
	 *
	 * @var $resourceType String The calling application or type of resource, conceptually like a namespace
	 * @var $user User object, the current user
	 * @var $expirationTime Integer (optional) How long should a checkout last, in seconds
	 */
	public function __construct( $resourceType, $user, $expirationTime = null ) {

		// All database calls are to the master, since the whole point of this class is 
		// maintaining concurrency. Most reads should come from cache anyway.
		$this->dbw = wfGetDb( DB_MASTER );

		$this->user = $user;
		// TODO: create a registry of all valid resourceTypes that client app can add to.
		$this->resourceType = $resourceType;
		$this->setExpirationTime( $expirationTime );
		$this->lastCheckout = array();
	}

	/**
	 * Check out a resource.  This establishes an atomically generated, cooperative lock
	 * on a key.  The lock is tied to the current user.
	 *
	 * @var $record Integer containing the record id to check out
	 * @var $override Boolean (optional) describing whether to override an existing checkout
	 * @return boolean
	 */
	public function checkout( $record, $override = null ) {
		global $wgMemc;
		$this->validateId( $record );
		$dbw = $this->dbw;
		$userId = $this->user->getId();
		$cacheKey = wfMemcKey( 'concurrencycheck', $this->resourceType, $record );

		global $wgInterfaceConcurrencyConfig;
		
		// check the cache first.
		$cached = $wgMemc->get( $cacheKey );
		if ( $cached ) {
			if ( 
				!$override && 
				$cached['userId'] != $userId && 
				$cached['expiration'] > time()
			) {
				// this is already checked out.
				$this->checkoutResult( $cached );
				return false;
			}
		}

		// attempt an insert, check success
		$insertError = null;
		$expiration = time() + $this->expirationTime;
		$dbw->insert(
			'concurrencycheck',
			array(
				'cc_resource_type' => $this->resourceType,
				'cc_record' => $record,
				'cc_user' => $userId,
				'cc_expiration' => $dbw->timestamp( $expiration ),
			),
			__METHOD__,
			array( 'IGNORE' )
		);

		// if the insert succeeded, checkout is done.
		if ( $dbw->affectedRows() === 1 ) {
			// "By default, MediaWiki opens a transaction at the first query, and commits
			// it before the output is sent."
			// set the cache key, since this is inside an implicit transaction.
			$toCache = array(
				'userId' => $userId,
				'expiration' => $expiration,				
			);
			
			$wgMemc->set( $cacheKey, $toCache, $this->expirationTime );
			
			$dbw->commit( __METHOD__ );
			$this->checkoutResult( $toCache );
			return true;
		}

		// the insert failed, which means there's an existing row.
		$row = $dbw->selectRow(
			'concurrencycheck',
			array( '*' ),
			array(
				'cc_resource_type' => $this->resourceType,
				'cc_record' => $record,
			),
			__METHOD__,
			array()
		);

		// checked out by current user, checkout is unexpired, override is unset
		if (
			$row &&
			$row->cc_user != $userId &&
			wfTimestamp( TS_UNIX, $row->cc_expiration ) > time() &&
			! $override 
		) {			
			// this was a cache miss.  populate the cache with data from the db.
			// cache is set to expire at the same time as the checkout, since it'll become 
			// invalid then anyway.
			// inside this transaction, a row-level lock is established which ensures cache
			// concurrency
			$toCache = array(
				'userId' => $row->cc_user,
				'expiration' => wfTimestamp( TS_UNIX, $row->cc_expiration )
			);
			
			$wgMemc->set(
				$cacheKey,
				$toCache,
				wfTimestamp( TS_UNIX, $row->cc_expiration ) - time()
			);
			
			$dbw->rollback( __METHOD__ );
			$this->checkoutResult( $toCache );
			return false;
		}

		// replace is used here to support the override parameter
		$res = $dbw->replace(
			'concurrencycheck',
			array( 'cc_resource_type', 'cc_record' ),
			array(
				'cc_resource_type' => $this->resourceType,
				'cc_record' => $record,
				'cc_user' => $userId,
				'cc_expiration' => $dbw->timestamp( $expiration ),
			),
			__METHOD__
		);

		$toCache = array( 'userId' => $userId, 'expiration' => $expiration );

		// cache the result.
		$wgMemc->set( 
			$cacheKey,
			$toCache,
			$this->expirationTime
		);

		$dbw->commit( __METHOD__ );
		$this->checkoutResult( $toCache );
		return true;
	}

	/**
	 * Check in a resource. Only works if the resource is checked out by the current user.
	 *
	 * @var $record Integer containing the record id to checkin
	 * @return Boolean
	 */
	public function checkin( $record ) {
		global $wgMemc;
		$this->validateId( $record );
		$dbw = $this->dbw;
		$userId = $this->user->getId();
		$cacheKey = wfMemcKey( 'concurrencycheck', $this->resourceType, $record );

		$dbw->delete(
			'concurrencycheck',
			array(
				'cc_resource_type' => $this->resourceType,
				'cc_record' => $record,
				'cc_user' => $userId,  // only the owner can perform a checkin
			),
			__METHOD__,
			array()
		);

		// check row count (this is atomic since the dml establishes a lock, select would 
		// not be). not that it matters too much, since cache deletes can happen w/o atomicity
		if ( $dbw->affectedRows() === 1 ) {
			$wgMemc->delete( $cacheKey );
			$dbw->commit( __METHOD__ );
			return true;
		}

		$dbw->commit( __METHOD__ );
		return false;
	}

	/**
	 * Remove all expired checkouts.
	 *
	 * @return Integer describing the number of records expired.
	 */
	public function expire() {
		// TODO: run this in a few other places that db access happens, to make sure the db
		// stays non-crufty.
		$dbw = $this->dbw;

		// remove the rows from the db.  trust memcached to expire the cache.
		$dbw->delete(
			'concurrencycheck',
			array(
				'cc_expiration <= ' . $dbw->addQuotes( $dbw->timestamp() ),
			),
			__METHOD__,
			array()
		);

		$rowCount = $dbw->affectedRows();
		$dbw->commit( __METHOD__ );

		// if I'm going to assume an implicit transaction, best not to contradict that
		// assumption.
		// expire() is called internally.
		$dbw->begin( __METHOD__ );

		return $rowCount;
	}

	/**
	 * Get the status of a set of known keys
	 *
	 * @param $keys array
	 * @return array
	 */
	public function status( $keys ) {
		global $wgMemc, $wgDBtype;
		$dbw = $this->dbw;
		$now = time();

		$checkouts = array();
		$toSelect = array();

		// validate keys, attempt to retrieve from cache.
		foreach ( $keys as $key ) {
			$this->validateId( $key );

			$cached = $wgMemc->get( wfMemcKey( 'concurrencycheck', $this->resourceType, $key ) );
			if ( $cached && $cached['expiration'] > $now ) {
				$checkouts[$key] = array(
					'status' => 'valid',
					'cc_resource_type' => $this->resourceType,
					'cc_record' => $key,
					'cc_user' => $cached['userId'],
					'cc_expiration' => $dbw->timestamp( $cached['expiration'] ),
					'cache' => 'cached',
				);
			} else {
				$toSelect[] = $key;
			}
		}

		// if there were cache misses...
		if ( $toSelect ) {
			// If it's time to go to the database, go ahead and expire old rows.
			$this->expire();

			// Why LOCK IN SHARE MODE, you might ask?  To avoid a race condition: Otherwise, it's
			// possible for a checkin and/or checkout to occur between this select and the value
			// being stored in cache, which makes for an incorrect cache.  This, in turn, could
			// make checkout() above (which uses the cache) function incorrectly.
			//
			// With LOCK IN SHARE MODE on, a concurrent INSERT call in checkout() will make this
            // select wait, and this query will wait for the transaction in checkout().
			//
			// Another option would be to run the select, then check each row in-turn before
            // setting the cache key using either SELECT (with LOCK IN SHARE MODE) or UPDATE
            // that checks a timestamp (and which would establish the same lock). That method
            // would mean smaller, quicker locks, but more overall database overhead.
			$queryParams = array();
			if ( $wgDBtype === 'mysql' ) {
				$queryParams[] = 'LOCK IN SHARE MODE';
			}

			$res = $dbw->select(
				'concurrencycheck',
				array( '*' ),
				array(
					'cc_resource_type' => $this->resourceType,
					'cc_record' => $toSelect,
					'cc_expiration > ' . $dbw->addQuotes( $dbw->timestamp() ),
				),
				__METHOD__,
				$queryParams
			);

			while ( $res && $record = $res->fetchRow() ) {
				$record['status'] = 'valid';
				$checkouts[ $record['cc_record'] ] = $record;

				// TODO: implement strategy #2 above, determine which DBMSes need which method.
				// for now, disable adding to cache here for databases that don't support read
				// locking
				if ( $wgDBtype !== 'mysql' ) {
					// safe to store values since this is inside the transaction
					$wgMemc->set(
						wfMemcKey( 'concurrencycheck', $this->resourceType, $record['cc_record'] ),
						array(
							'userId' => $record['cc_user'],
							'expiration' => wfTimestamp( TS_UNIX, $record['cc_expiration'] )
						),
						wfTimestamp( TS_UNIX, $record['cc_expiration'] ) - time()
					);
				}
			}

			if ( $wgDBtype === 'mysql' ) {
				// end the transaction.
				$dbw->rollback( __METHOD__ );
			}
		}

		// if a key was passed in but has no (unexpired) checkout, include it in the
		// result set to make things easier and more consistent on the client-side.
		foreach ( $keys as $key ) {
			if ( ! array_key_exists( $key, $checkouts ) ) {
				$checkouts[$key]['status'] = 'invalid';
			}
		}

		return $checkouts;
	}

	/**
	 * Get a list of all the currently checked out records
	 *
	 * This information can be stale by up to $wgInterfaceConcurrencyConfig['ListMaxAge']
	 *
	 * @return Array describing existing checkouts
	 */
	public function listCheckouts() {
		global $wgMemc, $wgInterfaceConcurrencyConfig;
		$dbw = $this->dbw;
		$userId = $this->user->getId();
		$cacheKey = wfMemcKey( 'concurrencycheck', $this->resourceType, 'currentCheckouts' );

		$checkouts = $wgMemc->get($cacheKey);

		// not cached? fetch from the db
		if( ! $checkouts ) {
			// when going to the db, remove expired rows.
			$this->expire();

			$res = $dbw->select(
				'concurrencycheck',
				array( '*' ),
				array(
					'cc_resource_type' => $this->resourceType,
					),
				__METHOD__,
				array()
			);

			while ( $res && $record = $res->fetchRow() ) {
				$checkouts[$record['cc_record']] = $record;
			}
			
			$wgMemc->set( $cacheKey, $checkouts, $wgInterfaceConcurrencyConfig['ListMaxAge'] );
		}
		
		$checkoutsReturn = $checkouts;
		foreach( $checkouts as $record => $values ) {
			// does this checkout belong to the current user?
			if( $values['cc_user'] == $userId ) {
				$checkoutsReturn[$record]['mine'] = true;
			} else {
				$checkoutsReturn[$record]['mine'] = false;
			}
		}

		return $checkoutsReturn;
		
	}

	/**
	 * Return information about the owner of the record on which a checkout was last
	 * attempted.
	 * 
	 * @param $checkoutInfo array (optional) of checkout information to store
	 * @return array
	 */
	public function checkoutResult( $checkoutInfo = null ) {
		if( isset( $checkoutInfo ) ) { // true on empty array
			$this->lastCheckout = $checkoutInfo;
		}
		return $this->lastCheckout;
	}

	/**
	 * Setter for user.
	 *
	 * @param $user user
	 */
	public function setUser( $user ) {
		$this->user = $user;
	}

	/**
	 * Setter for expirationTime
	 *
	 * @param $expirationTime int|null
	 */
	public function setExpirationTime( $expirationTime = null ) {
		global $wgInterfaceConcurrencyConfig;

		// check to make sure the time is a number
		// negative number are allowed, though mostly only used for testing
		if ( $expirationTime && (int) $expirationTime == $expirationTime ) {
			if ( $expirationTime > $wgInterfaceConcurrencyConfig['ExpirationMax'] ) {
				// if the number is too high, limit it to the max value.
				$this->expirationTime = $wgInterfaceConcurrencyConfig['ExpirationMax'];
			} elseif ( $expirationTime < $wgInterfaceConcurrencyConfig['ExpirationMin'] ) {
				// low limit, default -1 min
				$this->expirationTime = $wgInterfaceConcurrencyConfig['ExpirationMin'];
			} else {
				// the amount of time before a checkout expires.
				$this->expirationTime = $expirationTime;
			}
		} else {
			// global default is generally 15 mins.
			$this->expirationTime = $wgInterfaceConcurrencyConfig['ExpirationDefault'];
		}
	}

	/**
	 * Check to make sure a record ID is numeric, throw an exception if not.
	 *
	 * @param $record Integer
	 * @throws ConcurrencyCheckBadRecordIdException
	 * @return boolean
	 */
	private static function validateId ( $record ) {
		if ( (int) $record !== $record || $record <= 0 ) {
			throw new ConcurrencyCheckBadRecordIdException(
				'Record ID ' . $record . ' must be a positive integer'
			);
		}

		// TODO: add a hook here for client-side validation.
		return true;
	}
}

class ConcurrencyCheckBadRecordIdException extends MWException {}
