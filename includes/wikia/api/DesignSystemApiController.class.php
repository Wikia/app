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

	public function getFooter() {
		$params = $this->getRequestParameters();
		$footerModel = new DesignSystemGlobalFooterModel(
			$params[static::PARAM_PRODUCT],
			$params[static::PARAM_ID],
			$params[static::PARAM_LANG]
		);

		$this->cors->setHeaders( $this->response );
		$this->setResponseData( $footerModel->getData() );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}

	public function getNavigation() {
		$params = $this->getRequestParameters();
		$navigationModel = new DesignSystemGlobalNavigationModel(
			$params[static::PARAM_PRODUCT],
			$params[static::PARAM_ID],
			$params[static::PARAM_LANG]
		);

		$this->cors->setHeaders( $this->response );
		$this->setResponseData( $navigationModel->getData() );
		$this->addCachingHeaders();
	}

	public function getCommunityHeader() {
		$params = $this->getRequestParameters();
		$communityHeaderModel = new DesignSystemCommunityHeaderModel(
			$params[static::PARAM_ID],
			$params[static::PARAM_LANG]
		);

		$this->cors->setHeaders( $this->response );
		$this->setResponseData( $communityHeaderModel->getData() );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}

	/**
	 * return all possible elements of Design System API
	 *
	 * @throws \NotFoundApiException
	 */
	public function getAllElements() {
		$params = $this->getRequestParameters();

		$footerModel = new DesignSystemGlobalFooterModel(
			$params[static::PARAM_PRODUCT],
			$params[static::PARAM_ID],
			$params[static::PARAM_LANG]
		);

		$navigationModel = new DesignSystemGlobalNavigationModel(
			$params[static::PARAM_PRODUCT],
			$params[static::PARAM_ID],
			$params[static::PARAM_LANG]
		);

		$communityHeaderModel = new DesignSystemCommunityHeaderModel(
			$params[static::PARAM_ID],
			$params[static::PARAM_LANG]
		);

		$this->cors->setHeaders( $this->response );
		$this->setResponseData(
			[
				'global-footer' => $footerModel->getData(),
				'global-navigation' => $navigationModel->getData(),
				'community-header' => $communityHeaderModel->getData()
			]
		);

		$this->addCachingHeaders();
	}

	private function getRequestParameters() {
		$id = intval( $this->getRequiredParam( static::PARAM_ID ) );
		$product = $this->getRequiredParam( static::PARAM_PRODUCT );
		$lang = $this->getRequiredParam( static::PARAM_LANG );

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
}
