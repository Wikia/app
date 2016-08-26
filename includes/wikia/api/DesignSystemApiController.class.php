<?php

class DesignSystemApiController extends WikiaApiController {
	public function getFooter() {
		$params = $this->checkRequestCompleteness();

		$footerModel = new DesignSystemGlobalFooterModel( $params[ 'wikiId' ], $params[ 'lang' ] );

		$this->setResponseData( $footerModel->getData() );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}

	public function getNavigation() {
		global $wgUser;
		$params = $this->checkRequestCompleteness();

		$navigationModel = new DesignSystemGlobalNavigationModel( $params[ 'wikiId' ], $params[ 'lang' ] );
		$this->setResponseData( $navigationModel->getData() );

		if ( $wgUser->isLoggedIn() ) {
			$this->response->setCachePolicy( WikiaResponse::CACHE_PRIVATE );
			$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
		} else {
			$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		}
	}

	private function checkRequestCompleteness() {
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
}
