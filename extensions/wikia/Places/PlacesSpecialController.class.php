<?php

/**
 * Places Special Page
 * @author Jakub
 * @author Macbre
 */
class PlacesSpecialController extends WikiaSpecialPageController {

	private $center = null;
	private $markers = array();

	public function __construct() {
		parent::__construct('Places');

		// allow Special:Places to be included in article content
		// use {{Special:Places}}
		$this->includable(true);
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

		$this->wg->Out->setSubtitle($this->wf->MsgExt('places-on-map', array('parsemag'), count($this->markers)));
	}

	protected function placesForCategory( Title $oTitle ){
		$placesModel = F::build( 'PlacesModel' );
		$categoryName = $oTitle->getText();

		$this->prepareMarkers( $placesModel->getFromCategories( $categoryName ) );

		$this->wg->Out->setPageTitle(wfMsg('places-in-category', $categoryName));
	}

	protected function allPlaces(){
		$placesModel = F::build( 'PlacesModel' );
		$this->prepareMarkers( $placesModel->getAll() );
	}

	protected function prepareMarkers( Array $aMarkers ) {
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
		$sCategoriesText = $this->getVal('category', '');

		$oTitle = F::build( 'Title', array( $sTitle ), 'newFromText' );
		if ( $oTitle instanceof Title ){
			$oPlacesModel = F::build('PlacesModel');
			$oMarker = F::build( 'PlaceStorage', array( $oTitle ), 'newFromTitle' )->getModel();
			$oMarker->setCategories( $sCategoriesText );

			if( !empty( $sCategoriesText ) ){
				$aMarkers = $oPlacesModel->getFromCategories( $oMarker->getCategories() );
			} else {
				$aMarkers = $oPlacesModel->getFromCategoriesByTitle( $oTitle );
			}
			$oMarker = F::build( 'PlaceStorage', array( $oTitle ), 'newFromTitle' )->getModel();
			$this->setVal( 'center', $oMarker->getForMap() );
			$this->prepareMarkers( $aMarkers );
			$this->setVal( 'markers', $this->markers );

			// generate modal caption
			$this->setVal('caption', $this->wf->msgExt('places-modal-go-to-special', array('parseinline', 'parsemag'), count($this->markers)));
		}
	}
}