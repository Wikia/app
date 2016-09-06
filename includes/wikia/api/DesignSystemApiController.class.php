<?php

class DesignSystemApiController extends WikiaApiController {
	public function getFooter() {
		$params = $this->getRequestParameters();

		$this->setResponseData(
			( new DesignSystemGlobalFooterModel( $params[ 'wikiId' ], $params[ 'lang' ] ) )->getData() );
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

		$this->setResponseData( [
			'global_footer' => ( new DesignSystemGlobalFooterModel( $params[ 'wikiId' ], $params[ 'lang' ] ) )->getData(),
			'global_navigation' => ( new DesignSystemGlobalNavigationModel( $params[ 'wikiId' ], $params[ 'lang' ] ) )->getData()
		] );

		$this->addCachingHeaders();
	}

	private function getRequestParameters() {
		$wikiId = $this->getRequiredParam( 'wikiId' );
		$lang = $this->getRequiredParam( 'lang' );

		if ( WikiFactory::IDtoDB( $wikiId ) === false ) {
			throw new NotFoundApiException( "Unable to find wiki with ID {$wikiId}" );
		}

		return [
			'wikiId' => $wikiId,
			'lang' => $lang
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
