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
		$rteData = $this->getVal('rteData', false);

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
		$this->setVal( 'rteData', $rteData );
	}

	public function saveNewPlaceToArticle(){

		$oPlaceModel = F::build('PlaceModel');
		$oPlaceModel->setPageId( $this->getVal( 'articleId', 0 ) );
		
		if ( $oPlaceModel->getPageId() == 0 ){
			$this->setVal( 'error', wfMsg( 'places-error-no-article' ) );
			$this->setVal( 'success', false );
		} else {
			$oStorage = PlaceStorage::newFromId( $oPlaceModel->getPageId() );
			if ( $oStorage->getModel()->isEmpty() == false ){
				$this->setVal( 'error', wfMsg( 'places-error-place-already-exists' ) );
				$this->setVal( 'success', false );
			} else {
				$oPlaceModel->setAlign( $this->getVal( 'align', false ) );
				$oPlaceModel->setWidth( $this->getVal( 'width', false ) );
				$oPlaceModel->setHeight( $this->getVal( 'height', false ) );
				$oPlaceModel->setLat( $this->getVal( 'lat', false ) );
				$oPlaceModel->setLon( $this->getVal( 'lon', false ) );
				$oPlaceModel->setZoom( $this->getVal( 'zoom', false ) );

				$sText = $this->sendRequest(
					'PlacesController',
					'getPlaceWikiTextFromModel',
					array(
					    'model' => $oPlaceModel
					)
				)->toString();

				$oTitle = Title::newFromID( $oPlaceModel->getPageId() );

				if ( ($oTitle instanceof Title ) && $oTitle->exists() ) {
					$oArticle = F::build( 'Article', array( $oTitle ) );
					$sNewContent = $sText . $oArticle->getContent();
					$status =
						$oArticle->doEdit(
							$sNewContent,
							wfMsg( 'places-updated-geolocation' ),
							EDIT_UPDATE
						);
					$this->setVal( 'success', true );
				} else {
					$this->setVal( 'error', wfMsg( 'places-error-no-article' ) );
					$this->setVal( 'success', false );
				}
			}
		}
	}

	public function getPlaceWikiTextFromModel(){
		
		$oPlaceModel = $this->getVal( 'model', null );

		if ( empty( $oPlaceModel ) || !( $oPlaceModel instanceof PlaceModel ) ) {
			$oPlaceModel = F::build('PlaceModel');
		}

		$this->setVal( 'oEmptyPlaceModel', F::build('PlaceModel') );
		$this->setVal( 'oPlaceModel', $oPlaceModel );
	}

	/**
	 * Renders the geolocation button for adding coordinates to a page
	 */
	public function getGeolocationButton(){
		
		if (	!$this->app->wg->title->isContentPage() &&
			F::build(
				'PlaceStorage',
				array( $this->app->wg->title ),
				'newFromTitle'
			)->getModel()->isEmpty() &&
			!F::build(
				'PlaceCategory',
				array( $this->app->wg->title->getFullText() ),
				'newFromTitle'
			)->isGeoTaggingEnabledForArticle( $this->app->wg->title )
		){
			$this->skipRendering();
		} else {
			$this->response->setVal( 'jsSnippet', PlacesParserHookHandler::getJSSnippet() );
			F::build( 'JSMessages' )->enqueuePackage( 'PlacesGeoLocationModal', JSMessages::INLINE );
		}
	}
}
