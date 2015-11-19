<?php

use Wikia\Service\Gateway\ConsulUrlProvider;
use Wikia\Service\Swagger\ApiProvider;
use Swagger\Client\TemplateClassification\Storage\Api\TCSApi;
use Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeProvider;
use Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeHolder;

class TemplateClassificationService {

	const SERVICE_NAME = 'template-classification-storage';
	const USER_PROVIDER = 'user';
	const AUTO_PROVIDER = 'auto';

	// TODO: Move types used for manual classification outside of Template Classification Service
	// TODO: https://wikia-inc.atlassian.net/browse/CE-3017
	const TEMPLATE_CUSTOM_INFOBOX = 'custom-infobox';
	const TEMPLATE_DATA = 'data';
	const TEMPLATE_DESIGN = 'design';
	const TEMPLATE_INFOBOX = 'infobox';
	const TEMPLATE_MEDIA = 'media';
	const TEMPLATE_NAVBOX = 'navbox';
	const TEMPLATE_NAV = 'navigation';
	const TEMPLATE_NOT_ART = 'nonarticle';
	const TEMPLATE_FLAG = 'notice';
	const TEMPLATE_QUOTE = 'quote';
	const TEMPLATE_REFERENCES = 'reference';
	const TEMPLATE_UNKNOWN = 'unknown';
	const TEMPLATE_UNCLASSIFIED = '' ;

	const NOT_AVAILABLE = 'not-available';

	/**
	 * Allowed types of templates stored in an array to make a validation process easier.
	 *
	 * The order of types in this array determines the order of the types displayed in the
	 * classification dialog.
	 *
	 * @var array
	 */
	static $templateTypes = [
		self::TEMPLATE_INFOBOX,
		self::TEMPLATE_QUOTE,
		self::TEMPLATE_NAVBOX,
		self::TEMPLATE_FLAG,
		self::TEMPLATE_REFERENCES,
		self::TEMPLATE_MEDIA,
		self::TEMPLATE_DATA,
		self::TEMPLATE_DESIGN,
		self::TEMPLATE_NAV,
		self::TEMPLATE_NOT_ART,
		self::TEMPLATE_UNKNOWN,
	];

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
		$templateType = self::TEMPLATE_UNCLASSIFIED;

		$type = $this->getApiClient()->getTemplateType( $wikiId, $pageId );
		if ( !is_null( $type ) ) {
			$templateType = $type->getType();
		}

		return $templateType;
	}

	/**
	 * Quick fix
	 * Permanent change will be needed from the Services team.
	 * Fallback to empty type that means no classification.
	 *
	 * @param $wikiId
	 * @param $pageId
	 * @return string template type
	 * @throws Exception
	 * @throws \Swagger\Client\ApiException
	 */
	public function getUserDefinedType( $wikiId, $pageId ) {
		$templateType = $this->getType( $wikiId, $pageId );

		if ( !in_array( $templateType, self::$templateTypes ) ) {
			$templateType = self::TEMPLATE_UNCLASSIFIED;
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

		$providers = $this->getApiClient()->getTemplateDetails( $wikiId, $pageId );

		if ( !is_null( $providers ) ) {
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
	 * @param string $provider
	 * @param int $origin
	 * @throws Exception
	 * @throws \Swagger\Client\ApiException
	 */
	public function classifyTemplate( $wikiId, $pageId, $templateType, $provider, $origin ) {
		$details = [
			'provider' => $provider,
			'origin' => $origin,
			'types' => [ $templateType ]
		];
		$templateTypeProvider = new TemplateTypeProvider( $details );

		$this->getApiClient()->insertTemplateDetails( $wikiId, $pageId, $templateTypeProvider );
	}

	/**
	 * Get all classified template types on given wiki with their page id as a key
	 *
	 * @param int $wikiId
	 * @return array
	 * @throws Exception
	 * @throws \Swagger\Client\ApiException
	 */
	public function getTemplatesOnWiki( $wikiId ) {
		$templateTypes = [];

		$types = $this->getApiClient()->getTemplateTypesOnWiki( $wikiId );

		if ( !is_null( $types ) ) {
			$templateTypes = $this->prepareTypes( $types );
		}

		return $templateTypes;
	}

	/**
	 * Prepare template details output
	 *
	 * @param TemplateTypeProvider[] $details
	 * @return array
	 */
	private function prepareTemplateDetails( $details ) {
		$templateDetails = [];

		foreach ( $details as $detail ) {
			$templateDetails[$detail->getProvider()] = [
				'provider' => $detail->getProvider(),
				'origin' => $detail->getOrigin(),
				'types' => $detail->getTypes()
			];
		}

		return $templateDetails;
	}

	/**
	 * @param TemplateTypeHolder[] $types
	 * @return array
	 */
	private function prepareTypes( $types ) {
		$templateTypes = [];

		foreach ( $types as $type ) {
			$templateTypes[$type->getPageId()] = $type->getType();
		}

		return $templateTypes;
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
		$api = $apiProvider->getApi( self::SERVICE_NAME, TCSApi::class );

		// default CURLOPT_TIMEOUT for API client is set to 0 which means no timeout.
		// Overwriting to minimal value which is 1.
		// cURL function is allowed to execute not longer than 1 second
		$api->getApiClient()
				->getConfig()
				->setCurlTimeout(1);

		return $api;
	}

}
