<?php

class PlacesController extends WikiaController {

	// avoid having interactive maps with the same ID
	private static $mapId = 1;

	/**
	 * Render static map from given set of attributes
	 *
	 * Used to render <place> parser hook
	 */
	public function placeFromAttributes(){
		$attributes = $this->getVal('attributes', array());
		$oPlaceModel = PlaceModel::newFromAttributes( $attributes );

		$this->request->setVal('model', $oPlaceModel);
		$this->forward( 'Places', 'placeFromModel');
	}

	/**
	 * Render static map for given place model
	 */
	public function placeFromModel(){
		$oPlaceModel = $this->getVal('model', null);
		$rteData = $this->getVal('rteData', false);

		if ( empty( $oPlaceModel ) ){
			$oPlaceModel = new PlaceModel();
		}
		$this->setVal( 'url', $oPlaceModel->getStaticMapUrl() );
		$this->setVal( 'align', $oPlaceModel->getAlign() );
		$this->setVal( 'width', $oPlaceModel->getWidth() );
		$this->setVal( 'height', $oPlaceModel->getHeight() );
		$this->setVal( 'lat', $oPlaceModel->getLat() );
		$this->setVal( 'lon', $oPlaceModel->getLon() );
		$this->setVal( 'zoom', $oPlaceModel->getZoom() );
		$this->setVal( 'categories', $oPlaceModel->getCategoriesAsText() );
		$this->setVal( 'caption', $oPlaceModel->getCaption() );
		$this->setVal( 'rteData', $rteData );
	}

	/**
	 * Render interactive map for given set of points
	 *
	 * Map center can be specified
	 */
	public function renderMarkers() {
		$this->setVal('markers', $this->prepareMarkers($this->getVal('markers')));
		$this->setVal('center', $this->getVal('center'));
		$this->setVal('mapId', 'places-map-' . self::$mapId++);
		$this->setVal('height', $this->getVal('height', 500));
		$this->setVal('options', $this->getVal('options', array()));
	}

	/**
	 * Get markers from articles "related" to a given article
	 *
	 * Returns data to be rendered on the client-side
	 */
	public function getMarkersRelatedToCurrentTitle() {
		$sTitle = $this->getVal('title', '');
		$sCategoriesText = $this->getVal('category', '');

		$oTitle = Title::newFromText( $sTitle );
		if ( $oTitle instanceof Title ){
			$oPlacesModel = new PlacesModel();
			$oMarker = PlaceStorage::newFromTitle( $oTitle )->getModel();
			$oMarker->setCategories( $sCategoriesText );

			if( !empty( $sCategoriesText ) ){
				$aMarkers = $oPlacesModel->getFromCategories( $oMarker->getCategories() );
			} else {
				$aMarkers = $oPlacesModel->getFromCategoriesByTitle( $oTitle );
			}
			$oMarker = PlaceStorage::newFromTitle( $oTitle )->getModel();

			$this->setVal('center', $oMarker->getForMap());
			$this->setVal('markers', $this->prepareMarkers($aMarkers));

			// generate modal caption
			$this->setVal('caption', wfMessage('places-modal-go-to-special',
					count($this->markers))->parse());
		}
	}

	/**
	 * Internal method used to render tooltip for each marker
	 *
	 * @param PlaceModel[] $aMarkers
	 * @return array
	 */
	protected function prepareMarkers( Array $aMarkers ) {
		$markers = array();

		foreach( $aMarkers as $oMarker ){
			$aMapParams = $oMarker->getForMap();
			if ( !empty( $aMapParams ) ) {
				// render tooltip bubble for each marker
				$aMapParams['tooltip'] = $this->sendRequest(
					'Places',
					'getMapSnippet',
					array(
					    'data' => $aMapParams
					)
				)->toString();

				// no need to emit everything in HTML
				unset($aMapParams['articleUrl']);
				unset($aMapParams['imageUrl']);
				unset($aMapParams['textSnippet']);

				$markers[] = $aMapParams;
			}
		}

		return $markers;
	}

	/**
	 * Render marker tooltip
	 */
	public function getMapSnippet() {
		$data = $this->getVal( 'data' );
		$this->setVal( 'imgUrl', isset( $data['imageUrl'] ) ? $data['imageUrl'] : '' );
		$this->setVal( 'title', isset( $data['label'] ) ? $data['label'] : '' );
		$this->setVal( 'url', isset( $data['articleUrl'] ) ? $data['articleUrl'] : '' );
		$this->setVal( 'textSnippet', isset( $data['textSnippet'] ) ? $data['textSnippet'] : '' );
	}

	/**
	 * Create a new place based on geo data provided and store it in the database
	 */
	public function saveNewPlaceToArticle(){
		$oPlaceModel = new PlaceModel();
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
					$oArticle = new Article( $oTitle );
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

	/**
	 * Render wikitext of <place> tag for given model
	 *
	 * TODO: move the logic to the controler's PHP and use Xml::element helper method
	 */
	public function getPlaceWikiTextFromModel(){
		$oPlaceModel = $this->getVal( 'model', null );

		if ( empty( $oPlaceModel ) || !( $oPlaceModel instanceof PlaceModel ) ) {
			$oPlaceModel = new PlaceModel();
		}

		$this->setVal( 'oEmptyPlaceModel', (new PlaceModel) );
		$this->setVal( 'oPlaceModel', $oPlaceModel );
	}

	/**
	 * Renders the geolocation button for adding coordinates to a page
	 */
	public function getGeolocationButton(){

		if (	$this->app->wg->title->isContentPage() &&
			PlaceStorage::newFromTitle( $this->app->wg->title )->getModel()->isEmpty() &&
			PlaceCategory::newFromTitle( $this->app->wg->title->getFullText() )->isGeoTaggingEnabledForArticle( $this->app->wg->title )
		){

			$this->setVal(
				'geolocationParams',
				$this->getGeolocationButtonParams()
			);
			$this->response->setVal(
				'jsSnippet',
				PlacesParserHookHandler::getJSSnippet()
			);
			(new JSMessages)
				->enqueuePackage(
					'PlacesGeoLocationModal',
					JSMessages::INLINE
				);
		} else {
			$this->skipRendering();
		}
	}

	/**
	 * Purge geolocationplaceholder cache
	 */
	public function purgeGeoLocationButton(){
		if ($this->wg->Title instanceof Title) {
			$this->getGeolocationButtonParams( true );
		}

		$this->skipRendering();
	}

	/**
	 * Returns geolocation button params
	 */
	private function getGeolocationButtonParams( $refreshCache = false ){
		$sMemcKey = wfMemcKey(
			$this->app->wg->title->getText(),
			$this->app->wg->title->getNamespace(),
			'GeolocationButtonParams'
		);

		// use user default
		if ( empty( $iWidth ) ){
			$wopt = $this->app->wg->user->getGlobalPreference( 'thumbsize' );
			if( !isset( $this->app->wg->thumbLimits[ $wopt ] ) ) {
				$wopt = User::getDefaultOption( 'thumbsize' );
			}
			$iWidth = $this->app->wg->thumbLimits[ $wopt ];
		}

		$aResult = array(
			'align' => 'right',
			'width' => $iWidth
		);

		$aMemcResult = $this->app->wg->memc->get( $sMemcKey );
		$refreshCache = true; // FIXME
		if ( $refreshCache || empty( $aMemcResult ) ){
			$oArticle = new Article( $this->app->wg->title );
			$sRawText = $oArticle->getRawText();
			$aMatches = array();
			$string = $this->app->wg->contLang->getNsText( NS_IMAGE ) . '|' . MWNamespace::getCanonicalName(NS_IMAGE);
			$iFound = preg_match (
				'#\[\[('.$string.'):[^\]]*|thumb[^\]]*\]\]#',
				$sRawText,
				$aMatches
			);
			if ( !empty( $iFound ) ){
				reset( $aMatches );
				$sMatch = current( $aMatches );
				$sMatch = str_replace( '[[', '', $sMatch );
				$sMatch = str_replace( ']]', '', $sMatch );
				$aMatch = explode( '|', $sMatch );
				foreach( $aMatch as $element ){
					if ( $element == 'left' ){ $aResult['align'] = $element; }
					if ( substr( $element, -2 ) == 'px' && (int)substr( $element, 0, -2 ) > 0 ){
						$aResult['width'] = (int)substr( $element, 0, -2 );
					}
				}
			}
			$iExpires = 60*60*24;
			$this->app->wg->memc->set(
				$sMemcKey,
				$aResult,
				$iExpires
			);
		} else {
			$aResult[ 'align' ] = $aMemcResult[ 'align' ];
			if ( !empty( $aMemcResult['width'] ) ){
				$aResult[ 'width' ] = $aMemcResult[ 'width' ];
			}
		}

		// get default image width
		return $aResult;
	}
}
