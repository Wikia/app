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
		$oTitle = Title::newFromText( $sParam );
		if ( !empty( $oTitle ) && $oTitle->exists() ){
			if ( $oTitle->getNamespace() == NS_CATEGORY ){
				$this->markers = $this->placesForCategory( $oTitle );
			} else {
				$oMarker = PlaceStorage::newFromTitle( $oTitle )->getModel();
				$this->center = $oMarker->getForMap();
				$this->markers = $this->allPlaces();
			}
		} else {
			$this->markers = $this->allPlaces();
		}

		$this->wg->Out->setSubtitle(wfMsgExt('places-on-map', array('parsemag'), count($this->markers)));

		// use Places controller to render interactive map
		$this->request->setVal('center', $this->center);
		$this->request->setVal('markers', $this->markers);
		$this->request->setVal('height', 500);

		$this->forward('Places', 'renderMarkers');
	}

	protected function placesForCategory( Title $oTitle ){
		$placesModel = (new PlacesModel);
		$categoryName = $oTitle->getText();

		$this->wg->Out->setPageTitle(wfMsg('places-in-category', $categoryName));

		return $placesModel->getFromCategories( $categoryName );
	}

	protected function allPlaces(){
		$placesModel = new PlacesModel();
		return $placesModel->getAll(500); // limit number of places for special pages
	}
}