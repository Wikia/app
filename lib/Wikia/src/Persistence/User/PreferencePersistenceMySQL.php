<?php

namespace Wikia\Persistence\User;

use Wikia\Domain\User\Preference;

class PreferencePersistenceMySQL implements PreferencePersistence {
	const USER_PREFERENCE_TABLE = 'user_properties';
	const UP_USER = 'up_user';
	const UP_PROPERTY = 'up_property';
	const UP_VALUE = 'up_value';
	
	const CONNECTION_MASTER = "user_preferences_mysql_persistence_master";
	const CONNECTION_SLAVE = "user_preferences_mysql_persistence_slave";

	public static $UPSERT_SET_BLOCK = [ "up_user = VALUES(up_user)", "up_property = VALUES(up_property)", "up_value = VALUES(up_value)" ];

	private $master;
	private $slave;
	private $whiteList;

	/**
	 * @Inject({
	 *   Wikia\Persistence\User\PreferencePersistenceMySQL::CONNECTION_MASTER,
	 *   Wikia\Persistence\User\PreferencePersistenceMySQL::CONNECTION_SLAVE})
	 * @param \DatabaseMysqli $master
	 * @param \DatabaseMysqli $slave
	 * @param array           $whiteList of user preference
	 */
	function __construct( \DatabaseMysqli $master, \DatabaseMysqli $slave, $whiteList = [ ] ) {
		$this->master = $master;
		$this->slave = $slave;
		$this->whiteList = $whiteList;
	}

	public function save( $userId, array $preferences ) {
		$tuples = $this->createTuplesFromPreferences( $userId, $preferences );
		return $this->master->upsert( self::USER_PREFERENCE_TABLE, $tuples, [ ], self::$UPSERT_SET_BLOCK );
	}

	public static function createTuplesFromPreferences( $userId, array $preferences ) {
		$userId = intval( $userId );
		return array_map( function ( Preference $e ) use ( $userId ) {
			return [
				self::UP_USER => $userId,
				self::UP_PROPERTY => $e->getName(),
				self::UP_VALUE => $e->getValue()
			];
		}, $preferences );
	}

	public function get( $userId ) {
		$userId = intval( $userId );
		$cond = [ self::UP_USER => $userId ];
		if ( !empty( $this->whiteList ) ) {
			$cond[ self::UP_PROPERTY ] = $this->whiteList;
		}
		$result = $this->slave->select(
			self::USER_PREFERENCE_TABLE,
			[ self::UP_PROPERTY, self::UP_VALUE ],
			$cond,
			__METHOD__
		);

		$preferences = [ ];
		if ( is_array( $result ) && !empty( $result ) ) {
			$preferences = $this->userPropertiesResultToPreferenceArray( $result );
		}

		return $preferences;
	}

	/**
	 * Convert a user_properties row into a Preference object.
	 *
	 * @param array of ['up_user', 'up_property', 'up_value'] tuples
	 * @return Preference[]
	 */
	public function userPropertiesResultToPreferenceArray( array $result ) {
		$preferences = [ ];
		foreach ( $result as $index => $row ) {
			if ( isset( $row[ "up_property" ] ) && isset( $row[ "up_value" ] ) ) {
				$preferences[ ] = new Preference( $row[ "up_property" ], $row[ "up_value" ] );
			}
		}

		return $preferences;
	}

}
