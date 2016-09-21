<?php

use Swagger\Client\TemplateClassification\Storage\Api\TCSStatsApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;

class TemplateClassificationStatsService {

	private $apiClient = null;

	/**
	 * Get number of classified templates at all wikis
	 *
	 * @return int
	 * @throws Exception
	 * @throws \Swagger\Client\ApiException
	 */
	public function getClassifiedTemplatesCount() {
		$count = 0;

		$typeStats = $this->getApiClient()->getClassifiedTemplatesCount();

		if ( !is_null( $typeStats ) ) {
			$count = $typeStats->getCount();
		}

		return $count;
	}

	/**
	 * Get number of classified templates on given wiki
	 *
	 * @param int $wikiId
	 * @return int
	 * @throws Exception
	 * @throws \Swagger\Client\ApiException
	 */
	public function getClassifiedTemplatesOnWikiCount( $wikiId ) {
		$count = 0;

		$typeStats = $this->getApiClient()->getClassifiedTemplatesOnWikiCount( $wikiId );

		if ( !is_null( $typeStats ) ) {
			$count = $typeStats->getCount();
		}

		return $count;
	}

	/**
	 * Get number of classified templates by given provider on all wikis
	 *
	 * @param string $provider
	 * @return int
	 * @throws Exception
	 * @throws \Swagger\Client\ApiException
	 */
	public function getClassifiedTemplatesByProviderCount( $provider ) {
		$count = 0;

		$typeStats = $this->getApiClient()->getClassifiedTemplatesByProviderCount( $provider );

		if ( !is_null( $typeStats ) ) {
			$count = $typeStats->getCount();
		}

		return $count;
	}

	/**
	 * Get number of classified templates by given provider on given wiki
	 *
	 * @param int $wikiId
	 * @param string $provider
	 * @return int
	 * @throws Exception
	 * @throws \Swagger\Client\ApiException
	 */
	public function getClassifiedTemplatesByProviderOnWikiCount( $wikiId, $provider ) {
		$count = 0;

		$typeStats = $this->getApiClient()->getClassifiedTemplatesByProviderOnWikiCount( $wikiId, $provider );

		if ( !is_null( $typeStats ) ) {
			$count = $typeStats->getCount();
		}

		return $count;
	}

	/**
	 * Get Swagger-generated API client
	 *
	 * @return TCSStatsApi
	 */
	private function getApiClient() {
		if ( is_null( $this->apiClient ) ) {
			$this->apiClient = $this->createApiClient();
		}

		return $this->apiClient;
	}

	/**
	 * Create Swagger-generated API client
	 *
	 * @return TCSStatsApi
	 */
	private function createApiClient() {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get(ApiProvider::class);
		return $apiProvider->getApi( TemplateClassificationService::SERVICE_NAME, TCSStatsApi::class );
	}

}
