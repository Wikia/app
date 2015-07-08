<?php

namespace Wikia\Persistence\User\Preferences;

use Swagger\Client\User\Preferences\Api\UserPreferencesApi;
use Wikia\Domain\User\Preference;
use Wikia\Service\Swagger\ApiProvider;

class PreferencePersistenceSwaggerService implements PreferencePersistence {
	const SERVICE_NAME = "user-preference";

	/** @var ApiProvider */
	private $apiProvider;

	public function __construct(ApiProvider $apiProvider) {
		$this->apiProvider = $apiProvider;
	}

	/**
	 * @param int $userId
	 * @param Preference[] $preferences
	 * @throws \Exception
	 * @throws \Swagger\Client\ApiException
	 * @return true success, false or exception otherwise
	 */
	public function save($userId, array $preferences) {
		$prefs = [];
		foreach ($preferences as $p) {
			$prefs[] = (new \Swagger\Client\User\Preferences\Models\Preference())
				->setName($p->getName())
				->setValue($p->getValue());
		}

		$this->getApi($userId)->updateUserPreferences($userId, $prefs);
		return true;
	}

	public function get($userId) {
		$prefs = [];
		foreach ($this->getApi($userId)->getUserPreferences($userId) as $p) {
			$prefs[] = new Preference($p->getName(), $p->getValue());
		}

		return $prefs;
	}

	/**
	 * @param $userId
	 * @return UserPreferencesApi
	 */
	private function getApi($userId) {
		return $this->apiProvider->getAuthenticatedApi(self::SERVICE_NAME, $userId, UserPreferencesApi::class);
	}
}
