<?php

class InfoboxApiController extends WikiaApiController {

	public function getDetails() {
		$pageid = $this->getRequiredParam( 'pageid' );
		$title = Title::newFromID( $pageid );
		if ( $title && $title->exists() ) {
			$data = Article::newFromTitle( $title, RequestContext::getMain() )
				//on empty parser cache this should be regenerated, see WikiPage.php:2996
				->getParserOutput()
				->getProperty( PortableInfoboxParserTagController::INFOBOXES_PROPERTY_NAME );
		}
		$output = isset( $data ) && is_array( $data ) ?
			array_map( function ( $infobox ) {
				return isset( $infobox[ 'data' ] ) ? $infobox[ 'data' ] : $infobox;
			}, $data ) : [ ];

		$this->setResponseData( [ 'items' => $output ] );
	}
}