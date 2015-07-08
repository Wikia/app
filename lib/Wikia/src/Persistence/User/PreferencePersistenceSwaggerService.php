<?php
/**
 * PreferencePersistenceSwaggerService
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Persistence\User;

use Swagger\Client\ApiClient;
use Swagger\Client\Configuration;
use Swagger\Client\User\Preferences\Api\UserPreferencesApi;
use Wikia\Domain\User\Preference;
use Wikia\Service\Gateway\UrlProvider;

class PreferencePersistenceSwaggerService implements PreferencePersistence {
	const SERVICE_NAME = "user-preference";

	/** @var UrlProvider */
	private $urlProvider;

	public function __construct(UrlProvider $urlProvider) {
		$this->urlProvider = $urlProvider;
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
		// TODO: separate out to own service (swagger service provider)
		$config = (new Configuration())
			->setHost($this->urlProvider->getUrl(self::SERVICE_NAME))
			->setApiKey('X-Wikia-UserId', $userId);
		$apiClient = new ApiClient($config);
		return new UserPreferencesApi($apiClient);
	}
}
