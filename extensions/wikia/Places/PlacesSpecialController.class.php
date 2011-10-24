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
				$this->forward( 'PlacesSpecial', 'placesForCategory');
			} else {
				$this->center = $oTitle;
				$this->forward( 'PlacesSpecial', 'allPlaces');
			}
		} else {
			$this->forward( 'PlacesSpecial', 'allPlaces');
		}
	}

	public function placesForCategory(){
		$this->markers = array();
		$this->forward( 'PlacesSpecial', 'displayMap');
	}

	public function allPlaces(){
		$this->markers = array();
		$this->forward( 'PlacesSpecial', 'displayMap');
	}

	public function displayMap(){
		$this->setVal( 'center', $this->center );
		$this->setVal( 'markers', $this->markers );
	}
}
