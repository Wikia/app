<?php

/**
 * Caches user genders when needed to use correct namespace aliases.
 * @author Niklas Laxström
 * @since 1.18
 */
class GenderCache {
	protected $cache = array();
	protected $default;
	protected $misses = 0;
	protected $missLimit = 1000;

	/**
	 * @return GenderCache
	 */
	public static function singleton() {
		static $that = null;
		if ( $that === null ) {
			$that = new self();
		}
		return $that;
	}

	protected function __construct() {}

	/**
	 * Returns the default gender option in this wiki.
	 * @return String
	 */
	protected function getDefault() {
		if ( $this->default === null ) {
			$this->default = User::getDefaultOption( 'gender' );
		}
		return $this->default;
	}

	/**
	 * Returns the gender for given username.
	 * @param $username String: username
	 * @param $caller String: the calling method
	 * @return String
	 */
	public function getGenderOf( $username, $caller = '' ) {
		global $wgUser;

		$username = strtr( $username, '_', ' ' );
		if ( !isset( $this->cache[$username] ) ) {

			if ( $this->misses >= $this->missLimit && $wgUser->getName() !== $username ) {
				if( $this->misses === $this->missLimit ) {
					$this->misses++;
					wfDebug( __METHOD__ . ": too many misses, returning default onwards\n" );
				}
				return $this->getDefault();

			} else {
				$this->misses++;
				if ( !User::isValidUserName( $username ) ) {
					$this->cache[$username] = $this->getDefault();
				} else {
					$this->doQuery( $username, $caller );
				}
			}

		}

		/* Undefined if there is a valid username which for some reason doesn't
		 * exist in the database.
		 */
		return isset( $this->cache[$username] ) ? $this->cache[$username] : $this->getDefault();
	}

	/**
	 * Wrapper for doQuery that processes raw LinkBatch data.
	 *
	 * @param $data
	 * @param $caller
	 */
	public function doLinkBatch( $data, $caller = '' ) {
		$users = array();
		foreach ( $data as $ns => $pagenames ) {
			if ( !MWNamespace::hasGenderDistinction( $ns ) ) continue;
			foreach ( array_keys( $pagenames ) as $username ) {
				if ( isset( $this->cache[$username] ) ) continue;
				$users[$username] = true;
			}
		}

		$this->doQuery( array_keys( $users ), $caller );
	}

	/**
	 * Preloads genders for given list of users.
	 * @param $users array|String: userNames
	 * @param $caller String: the calling method
	 */
	public function doQuery( $users, $caller = '' ) {
		$default = $this->getDefault();

		// SUS-2779
		$users = $this->filterListOfUsers($users, $default);

		if ( count( $users ) === 0 ) {
			return;
		}

		// Wikia change - SUS-2979
		foreach ( $this->getGenderOfUsersFromDB($users, $caller) as $user_name => $value ) {
			$this->cache[$user_name] = $value ?: $default;
		}
	}

	private function filterListOfUsers( $users, $default ) {
		foreach ( (array)$users as $index => $value ) {
			$name = strtr( $value, '_', ' ' );
			if ( isset( $this->cache[$name] ) ) {
				// Skip users whose gender setting we already know
				unset( $users[$index] );
			} elseif ( !User::isValidUserName( $name ) ) {
				// SUS-3215 - do not perform queries for IP addresses
				unset( $users[$index] );
			} else {
				$users[$index] = $name;
				// For existing users, this value will be overwritten by the correct value
				$this->cache[$name] = $default;
			}
		}

		return $users;
	}

	/**
	 * @param $userNames
	 * @param $caller
	 * @return array user_name => gender hash
	 */
	private function getGenderOfUsersFromDB( $userNames, $caller ): array {
		global $wgExternalSharedDB;
		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		// Wikia change - SUS-2979
		if ( is_string( $userNames ) ) {
			$userNames = [ $userNames ];
		}

		// map user IDs to user names
		// in 97% of cases this method is called with a single user name provided
		// use heavily cached User::idFromName to get it
		$userIdsToNames = [];
		foreach($userNames as $userName) {
			$userIdsToNames[User::idFromName( $userName )] = $userName;
		}

		$table = 'user_properties';
		$fields = [ 'up_user', 'up_value' ];
		$conds = [ 'up_user' => array_keys( $userIdsToNames ), 'up_property' => 'gender' ];

		$comment = __METHOD__;
		if ( strval( $caller ) !== '' ) {
			$comment .= "/$caller";
		}

		$ret = [];
		$res = $dbr->select( $table, $fields, $conds, $comment );

		foreach( $res as $row ) {
			// map user IDs back to user names
			$ret[ $userIdsToNames[$row->up_user] ] = $row->up_value;
		}

		return $ret;
	}
}
