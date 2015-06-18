<?php

class InfoboxApiController extends WikiaApiController {

	public function getDetails() {
		$pageid = $this->getRequiredParam( 'pageid' );
		$title = Title::newFromID( $pageid );

		$dataService = new PortableInfoboxDataService();
		$data = $dataService->getInfoboxDataByTitle( $title );
		$output = isset( $data ) && is_array( $data ) ?
			array_map( function ( $infobox ) {
				return isset( $infobox[ 'data' ] ) ? $infobox[ 'data' ] : $infobox;
			}, $data ) : [ ];

		$this->setResponseData( [ 'items' => $output ] );
	}
}