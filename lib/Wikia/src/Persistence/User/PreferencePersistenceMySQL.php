<?php

namespace Wikia\Persistence\User;

use Wikia\Service\User\PreferencePersistence;
use Wikia\Domain\User\Preference;

class PreferencePersistenceMySQL implements PreferencePersistence {

	const USER_PREFERENCE_TABLE = 'user_properties';
	public static $UPSERT_SET_BLOCK = ["up_user = VALUES(up_user)", "up_property = VALUES(up_property)", "up_value = VALUES(up_value)"];

	private $master;
	private $slave;

	function __construct(\DatabaseMysqli $master, \DatabaseMysqli $slave) {
		$this->master = $master;
		$this->slave = $slave;
	}

	public function save( $userId, array $preferences ) {
		$tuples = $this->createTuplesFromPreferences($userId, $preferences);
		return $this->master->upsert(self::USER_PREFERENCE_TABLE, $tuples, [], self::$UPSERT_SET_BLOCK);
	}

	public static function createTuplesFromPreferences($userId, array $preferences) {
		$userId = intval($userId);
		return array_map(function(Preference $e) use ($userId) {
			return [
				'up_user' =>  $userId,
				'up_property' => $e->getName(),
				'up_value' => $e->getValue()
				];
		}, $preferences);
	}

	public function get( $userId ) {
		$userId = intval($userId);
		$result = $this->slave->select(
			self::USER_PREFERENCE_TABLE,
			'*',
			array( 'up_user' => $userId ),
			__METHOD__
		);

		$preferences = [];
		if (is_array($result) && !empty($result)) {
			$preferences = $this->userPropertiesResultToPreferenceArray($result);
		}

		return $preferences;
	}

	/**
	 * Convert a user_properties row into a Preference object.
	 *
	 * @param array of ['up_user', 'up_property', 'up_value'] tuples
	 * @return Preference[]
	 */
	public function userPropertiesResultToPreferenceArray(array $result) {
		$preferences = [];
		foreach( $result as $index => $row ) {
			if (isset($row["up_property"]) && isset($row["up_value"])) {
				$preferences[] = new Preference($row["up_property"], $row["up_value"]);
			}
		}

		return $preferences;
	}

}
