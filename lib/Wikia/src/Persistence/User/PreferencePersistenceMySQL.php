<?php

namespace Wikia\Persistence\User;

use Wikia\Service\User\PreferencePersistence;
use Wikia\Domain\User\Preference;

class PreferencePersistenceMySQL implements PreferencePersistence {

	private $master;
	private $slave;

	function __construct(\DatabaseMysqli $master, \DatabaseMysqli $slave) {
		$this->master = $master;
		$this->slave = $slave;
	}

	public function save( $userId, array $preferences ) {

	}

	public function get( $userId ) {
		$userId = intval($userId);
		$result = $this->slave->select(
			'user_properties',
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
