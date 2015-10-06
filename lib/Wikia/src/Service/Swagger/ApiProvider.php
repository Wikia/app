<?php

namespace Wikia\Service\Swagger;

use Swagger\Client\ApiClient;
use Swagger\Client\Configuration;
use Wikia\Service\Gateway\UrlProvider;
use Wikia\Service\Constants;

class ApiProvider {
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
		$apiClient->getConfig()->setApiKey(Constants::HELIOS_AUTH_HEADER, $userId);

		return new $apiClass($apiClient);
	}

	private function getApiClient($serviceName) {
		$config = (new Configuration())
			->setHost($this->urlProvider->getUrl($serviceName));

		return new ApiClient($config);
	}
}
