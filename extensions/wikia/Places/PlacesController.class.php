<?php

class PlacesController extends WikiaController {

	public function __construct( WikiaApp $app ) {
		$this->app = $app;
	}

	public function placeFromAttributes(){
		$attributes = $this->getVal('attributes', array());
		$oPlaceModel = F::build( 'PlaceModel', array( $attributes ), 'newFromAttributes' );

		$this->request->setVal('model', $oPlaceModel);
		$this->forward( 'Places', 'placeFromModel');
	}

	public function placeFromModel(){
		$oPlaceModel = $this->getVal('model', null);

		if ( empty( $oPlaceModel ) ){
			$oPlaceModel = F::build('PlaceModel');
		}

		$this->setVal( 'url', $oPlaceModel->getStaticMapUrl() );
		$this->setVal( 'align', $oPlaceModel->getAlign() );
		$this->setVal( 'width', $oPlaceModel->getWidth() );
		$this->setVal( 'height', $oPlaceModel->getHeight() );
		$this->setVal( 'lat', $oPlaceModel->getLat() );
		$this->setVal( 'lon', $oPlaceModel->getLon() );
		$this->setVal( 'zoom', $oPlaceModel->getZoom() );
	}
}
