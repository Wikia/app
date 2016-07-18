<?php

class DesignSystemApiController extends WikiaApiController {
	public function getFooter() {
		$wikiId = $this->request->getInt( 'wikiId' );

		if ( WikiFactory::IDtoDB( $wikiId ) === false ) {
			throw new NotFoundApiException( "Unable to find wiki with ID {$wikiId}" );
		}

		$footerModel = new DesignSystemGlobalFooterModel( $wikiId );

		$this->setResponseData( $footerModel->getData() );
	}
}
