<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Wikia\Logger\WikiaLogger;
use function GuzzleHttp\Psr7\build_query;

class DesignSystemApiController extends WikiaApiController {
	const PARAM_PRODUCT = 'product';
	const PARAM_ID = 'id';
	const PARAM_LANG = 'lang';
	const PRODUCT_WIKIS = 'wikis';
	const MEMC_PREFIX_FANDOM_STORE = 'DesignSystemCommunityHeaderModelClass::doApiRequest';
	const FANDOM_STORE_ERROR_MESSAGE = 'Failed to get data from Fandom Store';
	const TTL_INFINITE = 0; // setting to 0 never expires

	protected $cors;

	public function __construct() {
		parent::__construct();
		$this->cors = new CrossOriginResourceSharingHeaderHelper();
		$this->cors->allowWhitelistedOrigins();
		$this->cors->setAllowCredentials( true );
	}

	/**
	 * @throws InvalidParameterApiException
	 * @throws NotFoundApiException
	 */
	public function getFooter() {
		$params = $this->getRequestParameters();
		$version = $this->getVal('footer_version', '1');

		$footerModel = $version === '2'
			? new DesignSystemGlobalFooterModelV2(
				$params[static::PARAM_PRODUCT],
				$params[static::PARAM_ID],
				$this->isWikiaOrgCommunity(),
				$params[static::PARAM_LANG]
			)
			: new DesignSystemGlobalFooterModel(
				$params[static::PARAM_PRODUCT],
				$params[static::PARAM_ID],
				$this->isWikiaOrgCommunity(),
				$params[static::PARAM_LANG]
			);

		$this->cors->setHeaders( $this->response );
		$this->setResponseData( $footerModel->getData() );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}

	/**
	 * @throws InvalidParameterApiException
	 * @throws NotFoundApiException
	 */
	public function getNavigation() {
		$params = $this->getRequestParameters();
		// TODO: remove after full rollout of XW-4947
		$version = $this->getVal('version', '1');
		$navigationModel = $version === '2'
			? new DesignSystemGlobalNavigationModelV2(
				$params[static::PARAM_PRODUCT],
				$params[static::PARAM_ID],
				$this->isWikiaOrgCommunity(),
				$params[static::PARAM_LANG]
			)
			: new DesignSystemGlobalNavigationModel(
				$params[static::PARAM_PRODUCT],
				$params[static::PARAM_ID],
				$this->isWikiaOrgCommunity(),
				$params[static::PARAM_LANG]
			);

		$this->cors->setHeaders( $this->response );
		$this->setResponseData( $navigationModel->getData() );
		$this->addCachingHeaders();
	}

	/**
	 * @throws InvalidParameterApiException
	 * @throws NotFoundApiException
	 */
	public function getCommunityHeader() {
		$params = $this->getRequestParameters();
		$communityHeaderModel = new DesignSystemCommunityHeaderModel( $params[static::PARAM_LANG] );

		$this->cors->setHeaders( $this->response );
		$this->setResponseData( $communityHeaderModel->getData() );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}

	/**
	 * return all possible elements of Design System API
	 *
	 * @throws InvalidParameterApiException
	 * @throws NotFoundApiException
	 */
	public function getAllElements() {
		$params = $this->getRequestParameters();
		$isWikiaOrgCommunity = $this->isWikiaOrgCommunity();

		$version = $this->getVal('footer_version', '1');
		$footerModel = $version === '2'
			? new DesignSystemGlobalFooterModelV2(
				$params[static::PARAM_PRODUCT],
				$params[static::PARAM_ID],
				$isWikiaOrgCommunity,
				$params[static::PARAM_LANG]
			)
			: new DesignSystemGlobalFooterModel(
				$params[static::PARAM_PRODUCT],
				$params[static::PARAM_ID],
				$isWikiaOrgCommunity,
				$params[static::PARAM_LANG]
			);

		// TODO: remove after full rollout of XW-4947
		$version = $this->getVal('version', '1');
		$navigationModel = $version === '2'
			? new DesignSystemGlobalNavigationModelV2(
				$params[static::PARAM_PRODUCT],
				$params[static::PARAM_ID],
				$isWikiaOrgCommunity,
				$params[static::PARAM_LANG]
			)
			: new DesignSystemGlobalNavigationModel(
				$params[static::PARAM_PRODUCT],
				$params[static::PARAM_ID],
				$isWikiaOrgCommunity,
				$params[static::PARAM_LANG]
			);

		$this->cors->setHeaders( $this->response );

		$responseData = [
			'global-footer' => $footerModel->getData(),
			'global-navigation' => $navigationModel->getData(),
		];

		if (
			$params[static::PARAM_PRODUCT] === self::PRODUCT_WIKIS &&
			// There is no local content on language wikis index
			!WikiFactory::isLanguageWikisIndexOrClosed( $params[static::PARAM_ID] )
		) {
			$communityHeaderModel = new DesignSystemCommunityHeaderModel( $params[static::PARAM_LANG] );

			$responseData['community-header'] = $communityHeaderModel->getData();
		}

		$this->setResponseData( $responseData );

		$this->addCachingHeaders();
	}

	/**
	 * @return array
	 * @throws InvalidParameterApiException
	 * @throws NotFoundApiException
	 */
	private function getRequestParameters() {
		global $wgCityId;

		$product = $this->getRequiredParam( static::PARAM_PRODUCT );
		$lang = $this->getRequiredParam( static::PARAM_LANG );

		if ($product === static::PRODUCT_WIKIS) {
			$id = intval( $this->getVal(static::PARAM_ID, $wgCityId));
		} else {
			$id = intval( $this->getRequiredParam( static::PARAM_ID ) );
		}

		if ( $product === static::PRODUCT_WIKIS && WikiFactory::IDtoDB( $id ) === false ) {
			throw new NotFoundApiException( "Unable to find wiki with ID {$id}" );
		}

		return [
			static::PARAM_PRODUCT => $product,
			static::PARAM_ID => $id,
			static::PARAM_LANG => $lang
		];
	}

	/**
	 * add response headers for requests that require differing for anons
	 * and logged in users
	 */
	private function addCachingHeaders() {
		global $wgUser;

		$this->response->setHeader( 'Vary', 'Accept-Encoding,Cookie' );

		if ( $wgUser->isLoggedIn() ) {
			$this->response->setCachePolicy( WikiaResponse::CACHE_PRIVATE );
			$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
		} else {
			$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		}
	}

	private function isWikiaOrgCommunity() {
		global $wgServer, $wgWikiaOrgBaseDomain;

		return wfGetBaseDomainForHost( parse_url( $wgServer, PHP_URL_HOST ) ) === $wgWikiaOrgBaseDomain;
	}


	/**
	 * External API request to IntentX
	 */
	public function getFandomShopDataFromIntentX() {
		global $wgCityId, $wgMemc, $wgFandomStoreMap;

		// don't make api call if not fandom store community
		if ( !array_key_exists( $wgCityId, $wgFandomStoreMap ) ) {
			return null;
		}

		// api for fandom store
		$uri = 'http://138.201.119.29:9420/ix/api/seo/v1/footer'; // https://shop.fandom.com/ix/api/seo/v1/footer 500 - Internal Server Error
		$memcKey = wfMemcKey( self::MEMC_PREFIX_FANDOM_STORE, $wgCityId );

		// do api request
		$client = new Client( [
			'base_uri' => $uri,
			'timeout' => 30.0
		] );
		$params = [
			'clientId' => 'fandom',
			'relevanceKey' => $wgFandomStoreMap[ $wgCityId ],
		];

		try {
			$response = $client->get( '', [
				'query' => build_query( $params, PHP_QUERY_RFC1738 ),
			] );
			$data = json_decode( $response->getBody() );
			// store in cache indefinitely
			$wgMemc->set( $memcKey, $data, self::TTL_INFINITE );
			return $data;
		}
		catch ( ClientException $e ) {
			WikiaLogger::instance()->error( self::FANDOM_STORE_ERROR_MESSAGE, [
				'error_message' => $e->getMessage(),
				'status_code' => $e->getCode(),
			] );

			return null;
		}
		return null;
	}
}
