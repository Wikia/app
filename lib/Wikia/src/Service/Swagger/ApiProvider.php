<?php

namespace Wikia\Service\Swagger;

use Swagger\Client\ApiClient;
use Swagger\Client\Configuration;
use Wikia\Service\Gateway\UrlProvider;

class ApiProvider {
	const AUTH_KEY = 'X-Wikia-UserId';

	/** @var UrlProvider */
	private $urlProvider;

	public function __construct(UrlProvider $urlProvider) {
		$this->urlProvider = $urlProvider;
	}

	public function getApi($serviceName, $apiClass) {
		$apiClient = $this->getApiClient($serviceName);
		return new $apiClass($apiClient);
	}

	public function getAuthenticatedApi($serviceName, $userId, $apiClass) {
		$apiClient = $this->getApiClient($serviceName);
		$apiClient->getConfig()->setApiKey(self::AUTH_KEY, $userId);

		return new $apiClass($apiClient);
	}

	private function getApiClient($serviceName) {
		$config = (new Configuration())
			->setHost($this->urlProvider->getUrl($serviceName));

		return new ApiClient($config);
	}
}
