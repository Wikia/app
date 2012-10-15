<?php
class PlacesHooks extends WikiaObject{

	private static $modelToSave;

	function __construct(){
			parent::__construct();
			F::setInstance( __CLASS__, $this );
	}

	public function setModelToSave( PlaceModel $model ){
		self::$modelToSave = $model;
	}

	public function onPageHeaderIndexExtraButtons( $response ){
		$app = F::app();
		$extraButtons = $response->getVal('extraButtons');

		if (	( $app->wg->title->getNamespace() == NS_CATEGORY ) &&
			$app->wg->user->isAllowed('places-enable-category-geolocation') ){

			$isGeotaggingEnabled =
				F::build(
					'PlaceCategory',
					array( $app->wg->title->getFullText() ),
					'newFromTitle'
				)->isGeoTaggingEnabled();

			$commonClasses = 'secondary geoEnableButton';
			$extraButtons[] = F::app()->renderView( 'MenuButton',
				'Index',
				array(
					'action' => array(
						"href" => "#",
						"text" => wfMsg('places-category-switch')
					),
					'class' =>  !$isGeotaggingEnabled ? $commonClasses.' disabled': $commonClasses,
					'name' => 'places-category-switch-on'
				)
			);
			$extraButtons[] = F::app()->renderView('MenuButton',
				'Index',
				array(
					'action' => array(
						"href" => "#",
						"text" => wfMsg('places-category-switch-off')
					),
					'class' => $isGeotaggingEnabled ? $commonClasses.' disabled': $commonClasses,
					'name' => 'places-category-switch-off'
				)
			);
		}
		$response->setVal('extraButtons', $extraButtons);

		return true;
	}

	public function onParserFirstCallInit( Parser $parser ){
		$parser->setHook( 'place', 'PlacesParserHookHandler::renderPlaceTag' );
		$parser->setHook( 'places', 'PlacesParserHookHandler::renderPlacesTag' );

		return true;
	}

	public function onBeforePageDisplay( OutputPage $out, Skin $sk ){
		$this->wf->profileIn( __METHOD__ );

		$title = $out->getTitle();

		if ($title instanceof Title && $title->isContentPage()) {
			$storage = F::build('PlaceStorage', array($out->getTitle()), 'newFromTitle'); /* @var $storage PlaceStorage */
			$model = $storage->getModel(); /* @var $model PlaceModel */

			if ($model instanceof PlaceModel && !$model->isEmpty()) {
				$out->addMeta( 'geo.position', implode( ',', $model->getLatLon() ) );
			}
		}

		if ( ( $title instanceof Title ) && ( $title->getNamespace() == NS_CATEGORY ) ){
			$out->addScript( '<script src="' . F::app()->wg->extensionsPath . '/wikia/Places/js/GeoEnableButton.js"></script>' );
			$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/Places/css/GeoEnableButton.scss' ) );
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	public function onArticleSaveComplete( &$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ){
 		$this->wf->profileIn( __METHOD__ );

		$this->wf->Debug( __METHOD__ . "\n" );

		// store queued model or clear data for the article (if no model was passed)
		$storage = F::build( 'PlaceStorage', array( $article ), 'newFromArticle' ); /* @var $storage PlaceStorage */

		if ( self::$modelToSave instanceof PlaceModel ) {
			// use model from parser hook
			// self::$modelToSave is set in PlacesParserHookHandler::renderPlaceTag
			$storage->setModel( self::$modelToSave );
		}
		else {
			// no geo data fround - use an empty model
			$storage->setModel( F::build('PlaceModel') );
		}

		$storage->store();

		// purge autoplaceholdr position
		F::app()->sendRequest( 'Places', 'purgeGeoLocationButton' );

		$this->wf->profileOut( __METHOD__ );
		return true;
 	}

	public function onRTEUseDefaultPlaceholder( $name, $params, $frame, $wikitextIdx ) {
		if ( $name !== 'place' ) {
			return true;
		} else {
			// store metadata index to be used when rendering placeholder for RTE
			PlacesParserHookHandler::$lastWikitextId = $wikitextIdx;
			return false;
		}
	}

	/**
	 * Initialize edit page - load JS file and messages
	 *
	 * @param EditPage $editpage edit page instance
	 * @return bool true it's a hook
	 */
	public function onShowEditForm( EditPage $editpage ){
		// add edit toolbar button for adding places
		$src = AssetsManager::getInstance()->getOneCommonURL( 'extensions/wikia/Places/js/PlacesEditPage.js' );
		$this->wg->Out->addScript( "<script type=\"{$this->app->wg->JsMimeType}\" src=\"{$src}\"></script>" );

		// load JS messages
		F::build('JSMessages')->enqueuePackage('Places', JSMessages::EXTERNAL);
		F::build('JSMessages')->enqueuePackage('PlacesEditPageButton', JSMessages::INLINE);
		return true;
	}

	/**
	 * Prepends the geolocation button for adding coordinates to a page
	 */
	public function onOutputPageBeforeHTML( &$out, &$text ){

		if ( $this->app->wg->request->getVal('action', 'view') == true ) {
			$text = $this->app->sendRequest( 'Places', 'getGeolocationButton' )->toString() . $text;
		}
		return $out;
	}
}
