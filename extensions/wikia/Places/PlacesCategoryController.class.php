<?php

class PlacesCategoryController extends WikiaController {

	public function __construct() {
		$this->app = F::app();
	}
	public function makeGeoTaggable(){

		$title = $this->getVal( 'pageName', null );

	}
	public function enableGeoTagging(){

		if ( !wfReadOnly() && $this->app->wg->user->isAllowed('places-enable-category-geolocation') ){
			$sTitle = $this->getVal( 'pageName', null );
			if ( !empty( $sTitle ) ){
				$oPlacesCategory = PlaceCategory::newFromTitle( $sTitle );
				$oPlacesCategory->enableGeoTagging();
				$this->setVal( 'error', 0 );
			} else {
				$this->setVal( 'error', 1 );
			}
		} else {
			$this->setVal( 'error', 1 );
		}
	}
	public function disableGeoTagging(){

		if ( !wfReadOnly() && $this->app->wg->user->isAllowed('places-enable-category-geolocation') ){
			$sTitle = $this->getVal( 'pageName', null );
			if ( !empty( $sTitle ) ){
				$oPlacesCategory = PlaceCategory::newFromTitle( $sTitle );
				$oPlacesCategory->disableGeoTagging();
				$this->setVal( 'error', 0 );
			} else {
				$this->setVal( 'error', 1 );
			}
		} else {
			$this->setVal( 'error', 1 );
		}

	}
}
