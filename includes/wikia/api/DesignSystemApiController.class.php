<?php

class DesignSystemApiController extends WikiaApiController {
	const PARAM_PRODUCT = 'product';
	const PARAM_ID = 'id';
	const PARAM_LANG = 'lang';
	const PRODUCT_WIKIS = 'wikis';

	public function getFooter() {
		$params = $this->getRequestParameters();
		$footerModel = new DesignSystemGlobalFooterModel(
			$params[static::PARAM_PRODUCT],
			$params[static::PARAM_ID],
			$params[static::PARAM_LANG]
		);

		$this->setResponseData( $footerModel->getData() );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}

	public function getNavigation() {
		$params = $this->getRequestParameters();

		$this->setResponseData(
			( new DesignSystemGlobalNavigationModel( $params[ 'wikiId' ], $params[ 'lang' ] ) )->getData() );

		$this->addCachingHeaders();
	}

	/**
	 * return all possible elements of Design System API
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


		$this->setResponseData( [
			'global-footer' => $footerModel->getData(),
			'global-navigation' => $navigationModel->getData(),
		] );

		$this->addCachingHeaders();
	}

	private function getRequestParameters() {
		$id = $this->getRequiredParam( static::PARAM_ID );
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

		if ( $wgUser->isLoggedIn() ) {
			$this->response->setCachePolicy( WikiaResponse::CACHE_PRIVATE );
			$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
		} else {
			$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		}
	}
}
