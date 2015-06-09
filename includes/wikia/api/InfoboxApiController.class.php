<?php

class InfoboxApiController extends WikiaApiController {

	public function getDetails() {
		$pageid = $this->getRequiredParam( 'pageid' );
		$title = Title::newFromID( $pageid );

		$dataService = new PortableInfoboxDataService();
		$data = $dataService->getInfoboxDataByTitle( $title );

		$this->setResponseData( [ 'items' => $data ] );
	}
}