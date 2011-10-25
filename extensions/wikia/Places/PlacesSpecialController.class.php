<?php

/**
 * PLaces Special Page
 * @author Jakub
 * @author Macbre
 */
class PlacesSpecialController extends WikiaSpecialPageController {

	public $center = null;
	public $markers = array();
	
	public function __construct() {
		wfLoadExtensionMessages('Places');
		parent::__construct('Places');
	}

	public function index(){
		$this->response->addAsset('extensions/wikia/Places/js/Places.js');
		$sParam = $this->getPar();
		$oTitle = F::build( 'Title', array( $sParam ), 'newFromText' );
		if ( !empty( $oTitle ) && $oTitle->exists() ){
			if ( $oTitle->getNamespace() == NS_CATEGORY ){
				$this->placesForCategory( $oTitle );
			} else {
				$oMarker = F::build( 'PlaceStorage', array( $oTitle ), 'newFromTitle' )->getModel();
				$this->center = $oMarker->getForMap();
				$this->allPlaces();
			}
		} else {
			$this->allPlaces();
		}

		$this->setVal( 'center', $this->center );
		$this->setVal( 'markers', $this->markers );
	}

	protected function placesForCategory( $oTitle ){
		$placesModel = F::build( 'PlacesModel' );
		$this->prepareMarkers( $placesModel->getFromCategories( $oTitle->getText() ) );
	}

	protected function allPlaces(){
		$placesModel = F::build( 'PlacesModel' );
		$this->prepareMarkers( $placesModel->getAll() );
	}

	protected function prepareMarkers( $aMarkers ) {
		foreach( $aMarkers as $oMarker ){
			$aMapParams = $oMarker->getForMap();
			if ( !empty( $aMapParams ) ){
				$this->markers[] = $oMarker->getForMap();
			}
		}
	}
}