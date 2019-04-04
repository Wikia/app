<?php

class DesignSystemApiController extends WikiaApiController {
	const PARAM_PRODUCT = 'product';
	const PARAM_ID = 'id';
	const PARAM_LANG = 'lang';
	const PRODUCT_WIKIS = 'wikis';

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
		$footerModel = new DesignSystemGlobalFooterModel(
			$params[static::PARAM_PRODUCT],
			$params[static::PARAM_ID],
			$params[static::PARAM_LANG]
		);

		$this->cors->setHeaders( $this->response );
		$this->setResponseData( $footerModel->getData( $this->isWikiaOrgCommunity() ) );
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
				$params[static::PARAM_LANG]
			)
			: new DesignSystemGlobalNavigationModel(
				$params[static::PARAM_PRODUCT],
				$params[static::PARAM_ID],
				$params[static::PARAM_LANG]
			);

		$this->cors->setHeaders( $this->response );
		$this->setResponseData( $navigationModel->getData($this->isWikiaOrgCommunity()) );
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

		$footerModel = new DesignSystemGlobalFooterModel(
			$params[static::PARAM_PRODUCT],
			$params[static::PARAM_ID],
			$params[static::PARAM_LANG]
		);

		// TODO: remove after full rollout of XW-4947
		$version = $this->getVal('version', '1');
		$navigationModel = $version === '2'
			? new DesignSystemGlobalNavigationModelV2(
				$params[static::PARAM_PRODUCT],
				$params[static::PARAM_ID],
				$params[static::PARAM_LANG]
			)
			: new DesignSystemGlobalNavigationModel(
				$params[static::PARAM_PRODUCT],
				$params[static::PARAM_ID],
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
		global $wgServer;

		$wikiaOrgDomainsWhitelist = ['wikia.org', 'fandom-dev.pl'];
		$domainSegments = explode('.', $wgServer);
		$sizeOfDomainSegments = sizeof($domainSegments);
		$lastTwoSegmentsOfDomain = $domainSegments[$sizeOfDomainSegments - 2] . '.' . $domainSegments[$sizeOfDomainSegments - 1];

		return !empty(array_search($lastTwoSegmentsOfDomain, $wikiaOrgDomainsWhitelist));
	}
}
