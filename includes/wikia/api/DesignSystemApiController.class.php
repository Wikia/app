<?php

class DesignSystemApiController extends WikiaApiController {
	public function getFooter() {
		$wikiId = $this->request->getInt( 'wikiId' );
		$lang = $this->request->getVal( 'lang' );
		$fandom = $this->request->getVal( 'fandom' );

		if ( empty( $lang ) ) {
			throw new MissingParameterApiException( 'lang' );
		}

		if ( $fandom ) {
			$footerModel = new DesignSystemGlobalFooterFandomModel( $fandom, $lang );
		} else {
			if ( WikiFactory::IDtoDB( $wikiId ) === false ) {
				throw new NotFoundApiException( "Unable to find wiki with ID {$wikiId}" );
			}

			$footerModel = new DesignSystemGlobalFooterWikiModel( $wikiId, $lang );
		}

		$this->setResponseData( $footerModel->getData() );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}
}
