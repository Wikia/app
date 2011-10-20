<?php

class PlaceController extends WikiaController {

	public function __construct( WikiaApp $app ) {
		$this->app = $app;
	}

	public function placeFromAttributes( $attributes ){

		$oPlaceModel = F::build( 'PlaceModel', $attributes, 'newFromAttributes' );
		$this->app->renderView( 'Places', 'placeFromModel', array( 'model' => $oPlaceModel ) );
	}

	public function placeFromModel( $oPlaceModel ){
		$this->setVal( 'url', $oPlaceModel->getApiString() );
		$this->setVal( 'align', $oPlaceModel->getAlign() );
		$this->setVal( 'width', $oPlaceModel->getWidth() );
		$this->setVal( 'height', $oPlaceModel->getHeight() );
	}
}
