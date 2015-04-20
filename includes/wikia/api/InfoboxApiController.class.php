<?php

class InfoboxApiController extends WikiaApiController {

	public function getDetails() {
		$pageid = $this->getRequiredParam( 'pageid' );
		$title = Title::newFromID( $pageid );
		$data = [ ];
		if ( $title && $title->exists() ) {
			$data = Article::newFromTitle( $title, RequestContext::getMain() )
				->getParserOutput()
				->getProperty( PortableInfoboxParserTagController::INFOBOXES_PROPERTY_NAME );
		}

		$this->setResponseData( [ 'items' => $data ] );
	}
}