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
		$oTitle = F::build( 'Title', array( $sParam ) );
		if ( !empty( $oTitle ) && $oTitle->exists() ){
			if ( $oTitle->getNamespace() == NS_CATEGORY ){
				$this->placesForCategory();
			} else {
				$this->center = $oTitle;
				$this->allPlaces();
			}
		} else {
			$this->allPlaces();
		}

		$this->setVal( 'center', $this->center );
		$this->setVal( 'markers', $this->markers );
	}

	protected function placesForCategory(){
		$this->markers = array();
	}

	protected function allPlaces(){
		$placesModel = F::build( 'PlacesModel' );
		$markers = $placesModel->getAll();
		foreach( $markers as $oMarker ){
			$aMapParams = $oMarker->getForMap();
			if ( !empty( $aMapParams ) ){
				$this->markers[] = $oMarker->getForMap();
			}
		}
	}
}