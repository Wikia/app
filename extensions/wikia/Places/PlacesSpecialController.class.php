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
		parent::__construct('Places');
	}

	public function index(){
		$this->wg->Out->setPageTitle(wfMsg('places'));
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
				$tmpArray = array();
				$tmpArray = $oMarker->getForMap();
				$tmpArray['tooltip'] = $this->sendRequest(
					'PlacesSpecialController',
					'getMapSnippet',
					array(
					    'data' => $tmpArray
					)
				)->toString();
				$this->markers[] = $tmpArray;
			}
		}
	}

	public function getMapSnippet(){
		$data = $this->getVal( 'data' );
		$this->setVal( 'imgUrl', isset( $data['imageUrl'] ) ? $data['imageUrl'] : '' );
		$this->setVal( 'title', isset( $data['label'] ) ? $data['label'] : '' );
		$this->setVal( 'url', isset( $data['articleUrl'] ) ? $data['articleUrl'] : '' );
	}

	public function getMarkersRelatedToCurrentTitle(){
		$sTitle = $this->getVal('title', '');
		$oTitle = F::build( 'Title', array( $sTitle ), 'newFromText' );
		$oPlacesModel = F::build('PlacesModel');
		$aMarkers = $oPlacesModel->getFromCategoriesByTitle( $oTitle );
		$oMarker = F::build( 'PlaceStorage', array( $oTitle ), 'newFromTitle' )->getModel();
		$this->setVal( 'center', $oMarker->getForMap() );
		$this->prepareMarkers( $aMarkers );
		$this->setVal( 'markers', $this->markers );
	}
}