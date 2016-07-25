<?php

class DesignSystemApiController extends WikiaApiController {
	public function getFooter() {
		$wikiId = $this->request->getInt( 'wikiId' );
		$lang = $this->request->getVal( 'lang' );

		if ( WikiFactory::IDtoDB( $wikiId ) === false ) {
			throw new NotFoundApiException( "Unable to find wiki with ID {$wikiId}" );
		}

		$footerModel = new DesignSystemGlobalFooterModel( $wikiId, $lang );

		$this->setResponseData( $footerModel->getData() );
	}
}
