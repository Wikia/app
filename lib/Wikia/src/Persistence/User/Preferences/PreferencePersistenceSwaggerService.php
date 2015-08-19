<?php

namespace Wikia\Persistence\User\Preferences;

use Swagger\Client\ApiException;
use Swagger\Client\User\Preferences\Api\UserPreferencesApi;
use Wikia\Domain\User\Preference;
use Wikia\Service\NotFoundException;
use Wikia\Service\PersistenceException;
use Wikia\Service\Swagger\ApiProvider;
use Wikia\Service\UnauthorizedException;

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
	 * @return true success, false or exception otherwise
	 * @throws PersistenceException
	 * @throws UnauthorizedException
	 */
	public function save($userId, array $preferences) {
		$prefs = [];
		foreach ($preferences as $p) {
			$prefs[] = (new \Swagger\Client\User\Preferences\Models\Preference())
				->setName($p->getName())
				->setValue($p->getValue());
		}

		try {
			$this->getApi($userId)->updateUserPreferences($userId, $prefs);
			return true;
		} catch (ApiException $e) {
			$this->handleApiException($e);
			return false;
		}
	}

	/**
	 * Get the users preferences.
	 *
	 * @param int $userId
	 * @return array of Preference objects
	 * @throws UnauthorizedException
	 * @throws PersistenceException
	 */
	public function get($userId) {
		$prefs = [];

		try {
			foreach ($this->getApi($userId)->getUserPreferences($userId) as $p) {
				$prefs[] = new Preference($p->getName(), $p->getValue());
			}
		} catch (ApiException $e) {
			$this->handleApiException($e);
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

	/**
	 * @param ApiException $e
	 * @throws UnauthorizedException
	 * @throws NotFoundException
	 * @throws PersistenceException
	 */
	private function handleApiException(ApiException $e) {
		switch ($e->getCode()) {
			case UnauthorizedException::CODE:
				throw new UnauthorizedException();
				break;
			case NotFoundException::CODE:
				break;
			default:
				throw new PersistenceException($e->getMessage());
				break;
		}
	}
}
