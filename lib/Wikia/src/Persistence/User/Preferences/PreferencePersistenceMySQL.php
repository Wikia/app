<?php

namespace Wikia\Persistence\User\Preferences;

use Iterator;
use Wikia\Domain\User\Preference;

/**
 * @Injectable(lazy=true)
 */
class PreferencePersistenceMySQL implements PreferencePersistence {
	const USER_PREFERENCE_TABLE = 'user_properties';
	const UP_USER = 'up_user';
	const UP_PROPERTY = 'up_property';
	const UP_VALUE = 'up_value';
	
	const CONNECTION_MASTER = "user_preferences_mysql_persistence_master";
	const CONNECTION_SLAVE = "user_preferences_mysql_persistence_slave";
	const WHITE_LIST = "user_preferences_mysql_persistance_white_list";

	public static $UPSERT_SET_BLOCK = [ "up_user = VALUES(up_user)", "up_property = VALUES(up_property)", "up_value = VALUES(up_value)" ];

	private $master;
	private $slave;
	private $whiteList;

	/**
	 * @Inject({
	 *   Wikia\Persistence\User\Preferences\PreferencePersistenceMySQL::CONNECTION_MASTER,
	 *   Wikia\Persistence\User\Preferences\PreferencePersistenceMySQL::CONNECTION_SLAVE,
	 *   Wikia\Persistence\User\Preferences\PreferencePersistenceMySQL::WHITE_LIST})
	 * @param \DatabaseMysqli $master
	 * @param \DatabaseMysqli $slave
	 * @param array           $whiteList of user preference
	 */
	function __construct( \DatabaseMysqli $master, \DatabaseMysqli $slave, $whiteList = [ ] ) {
		$this->master = $master;
		$this->slave = $slave;
		$this->whiteList = $this->buildWhitelist( $whiteList );
	}

	/**
	 * @param array $whiteList
	 * @return array
     */
	private function buildWhitelist( $whiteList = [ ] ) {
		if ( empty( $whiteList ) ) {
			return [];
		}

		return [
			'literals' => $whiteList['literals'],
			'regex' => implode ( '|', $whiteList['regexes'] ),
		];
	}

	/**
	 * @param Preference[] $preferences
	 * @return Preference[]
	 */
	private function applyWhitelist( array $preferences ) {
		$whiteList = $this->whiteList;

		if ( empty( $whiteList )) {
			return $preferences;
		}

		$preferences =  array_reduce( $preferences, function ( $result, $item ) use ( $whiteList ) {
			/** @var Preference $item */
			$preference_name = $item->getName();

			if (
				in_array( $preference_name, $whiteList['literals'] ) ||
				preg_match( '/' . $whiteList['regex'] . '/', $preference_name )
			) {
				$result[] = $item;
			}

			return $result;
		}, [] );

		return $preferences;
	}

	public function save( $userId, array $preferences ) {
		// Filtering preferences against the whiteList if needed
		$preferences = $this->applyWhitelist( $preferences );

		if ( empty ( $preferences )) {
			return false;
		}

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
			$cond[] = '`' . self::UP_PROPERTY . '` IN (' . $this->slave->makeList($this->whiteList['literals']) . ') ' .
				'OR `' . self::UP_PROPERTY . "` REGEXP " . $this->slave->addQuotes($this->whiteList['regex']);
		}
		$result = $this->slave->select(
			self::USER_PREFERENCE_TABLE,
			[ self::UP_PROPERTY, self::UP_VALUE ],
			$cond,
			__METHOD__
		);

		return $this->userPropertiesResultToPreferenceArray( $result );
	}

	/**
	 * Convert a user_properties row into a Preference object.
	 *
	 * @param Iterator|array $result
	 * @return Preference[]
	 */
	public function userPropertiesResultToPreferenceArray( $result ) {
		$preferences = [];
		foreach ( $result as $index => $row ) {
			if ( isset( $row->up_property ) && isset( $row->up_value ) ) {
				$preferences[] = new Preference( $row->up_property, $row->up_value );
			}
		}

		return $preferences;
	}

}
