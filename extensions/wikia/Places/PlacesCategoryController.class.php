<?php

class PlacesCategoryController extends WikiaController {

	public function __construct( WikiaApp $app ) {
		$this->app = $app;
	}
	public function makeGeoTaggable(){

		$title = $this->getVal( 'pageName', null );

	}
	public function enableGeoTagging(){

		// TODO: Add privilage check;
		$sTitle = $this->getVal( 'pageName', null );
		if ( !empty( $sTitle ) ){
			$oPlacesCategory = F::build( 'PlaceCategory', array( $sTitle ), 'newFromTitle' );
			$oPlacesCategory->enableGeoTagging();
			$this->setVal( 'error', 0 );
		} else {
			$this->setVal( 'error', 1 );
		}
	}
	public function disableGeoTagging(){

		// TODO: Add privilage check;
		$sTitle = $this->getVal( 'pageName', null );
		if ( !empty( $sTitle ) ){
			$oPlacesCategory = F::build( 'PlaceCategory', array( $sTitle ), 'newFromTitle' );
			$oPlacesCategory->disableGeoTagging();
			$this->setVal( 'error', 0 );
		} else {
			$this->setVal( 'error', 1 );
		}
	}
}
