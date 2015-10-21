<?php

use Wikia\Service\Gateway\ConsulUrlProvider;
use Wikia\Service\Swagger\ApiProvider;
use Swagger\Client\TemplateClassification\Storage\Api\TCSApi;
use Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeProvider;

class TemplateClassificationService {

	const SERVICE_NAME = 'template-classification-storage';
	const USER_PROVIDER = 'user';

	private $apiClient = null;

	/**
	 * Get template type
	 *
	 * Type can be provided by user or automatic script, but user classification overrides automatic generated type
	 *
	 * @param int $wikiId
	 * @param int $pageId
	 * @return string template type
	 * @throws Exception
	 * @throws \Swagger\Client\ApiException
	 */
	public function getType( $wikiId, $pageId ) {
		$templateType = '';

		$type = $this->getApiClient()->getTemplateType( $wikiId, $pageId );
		if ( !is_null( $type ) ) {
			$templateType = $type->getType();
		}

		return $templateType;
	}

	/**
	 * Get details about template type (provider, origin)
	 *
	 * @param int $wikiId
	 * @param int $pageId
	 * @return array
	 * @throws Exception
	 * @throws \Swagger\Client\ApiException
	 */
	public function getDetails( $wikiId, $pageId ) {
		$templateDetails = [];

		$details = $this->getApiClient()->getTemplateDetails( $wikiId, $pageId );

		if ( !is_null( $details ) ) {
			$providers = $details->getProviders();
			$templateDetails = $this->prepareTemplateDetails( $providers );
		}

		return $templateDetails;
	}

	/**
	 * Classify template type
	 *
	 * @param int $wikiId
	 * @param int $pageId
	 * @param string $templateType
	 * @param int $userId
	 * @throws Exception
	 * @throws \Swagger\Client\ApiException
	 */
	public function classifyTemplate( $wikiId, $pageId, $templateType, $userId ) {
		$details = [
			'provider' => self::USER_PROVIDER,
			'origin' => $userId,
			'types' => [ $templateType ]
		];
		$templateTypeProvider = new TemplateTypeProvider( $details );

		$this->getApiClient()->insertTemplateDetails( $wikiId, $pageId, $templateTypeProvider );
	}

	/**
	 * Prepare template details output
	 *
	 * @param TemplateTypeProvider[] $providers
	 * @return array
	 */
	private function prepareTemplateDetails( $providers ) {
		$templateDetails = [];

		foreach ( $providers as $provider ) {
			$templateDetails[$provider->getProvider()] = [
				'provider' => $provider->getProvider(),
				'origin' => $provider->getOrigin(),
				'types' => $provider->getTypes()
			];
		}

		return $templateDetails;
	}

	/**
	 * Get Swagger-generated API client
	 *
	 * @return TCSApi
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
	 * @return TCSApi
	 */
	private function createApiClient() {
		global $wgConsulUrl, $wgConsulServiceTag;
		$urlProvider = new ConsulUrlProvider( $wgConsulUrl, $wgConsulServiceTag );
		$apiProvider = new ApiProvider( $urlProvider );
		return $apiProvider->getApi( self::SERVICE_NAME, TCSApi::class );
	}

}