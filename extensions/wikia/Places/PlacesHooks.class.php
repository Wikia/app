<?php
class PlacesHooks {

	private static $modelToSave;

	static public function setModelToSave( PlaceModel $model ){
		self::$modelToSave = $model;
	}

	static public function onPageHeaderIndexExtraButtons( $response ){
		$app = F::app();
		$extraButtons = $response->getVal('extraButtons');

		if (	( $app->wg->title->getNamespace() == NS_CATEGORY ) &&
			$app->wg->user->isAllowed('places-enable-category-geolocation') ){

			$isGeotaggingEnabled =
				PlaceCategory::newFromTitle($app->wg->title->getFullText() )->isGeoTaggingEnabled();

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

	static public function onParserFirstCallInit( Parser $parser ){
		$parser->setHook( 'place', 'PlacesParserHookHandler::renderPlaceTag' );
		$parser->setHook( 'places', 'PlacesParserHookHandler::renderPlacesTag' );

		return true;
	}

	static public function onBeforePageDisplay( OutputPage $out, Skin $sk ){
		wfProfileIn( __METHOD__ );

		$title = $out->getTitle();

		if ($title instanceof Title && $title->isContentPage()) {
			$storage = PlaceStorage::newFromTitle($out->getTitle());
			$model = $storage->getModel(); /* @var $model PlaceModel */

			if ($model instanceof PlaceModel && !$model->isEmpty()) {
				$out->addMeta( 'geo.position', implode( ',', $model->getLatLon() ) );
			}
		}

		if ( ( $title instanceof Title ) && ( $title->getNamespace() == NS_CATEGORY ) ){
			$out->addScript( '<script src="' . F::app()->wg->extensionsPath . '/wikia/Places/js/GeoEnableButton.js"></script>' );
			$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/Places/css/GeoEnableButton.scss' ) );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onArticleSaveComplete( &$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ){
 		wfProfileIn( __METHOD__ );

		wfDebug( __METHOD__ . "\n" );

		// store queued model or clear data for the article (if no model was passed)
		$storage = PlaceStorage::newFromArticle( $article );

		if ( self::$modelToSave instanceof PlaceModel ) {
			// use model from parser hook
			// self::$modelToSave is set in PlacesParserHookHandler::renderPlaceTag
			$storage->setModel( self::$modelToSave );
		}
		else {
			// no geo data fround - use an empty model
			$storage->setModel( (new PlaceModel) );
		}

		$storage->store();

		// purge autoplaceholdr position
		F::app()->sendRequest( 'Places', 'purgeGeoLocationButton' );

		wfProfileOut( __METHOD__ );
		return true;
 	}

	static public function onRTEUseDefaultPlaceholder( $name, $params, $frame, $wikitextIdx ) {
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
	static public function onShowEditForm( EditPage $editpage ){
		global $wgJsMimeType;
		// add edit toolbar button for adding places
		$src = AssetsManager::getInstance()->getOneCommonURL( 'extensions/wikia/Places/js/PlacesEditPage.js' );
		F::app()->wg->Out->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$src}\"></script>" );

		// load JS messages
		JSMessages::enqueuePackage('Places', JSMessages::EXTERNAL);
		JSMessages::enqueuePackage('PlacesEditPageButton', JSMessages::INLINE);
		return true;
	}

	/**
	 * Prepends the geolocation button for adding coordinates to a page
	 */
	static public function onOutputPageBeforeHTML( &$out, &$text ){
		$app = F::app();
		if ( $app->wg->request->getVal('action', 'view') == true ) {
			$text = $app->sendRequest( 'Places', 'getGeolocationButton' )->toString() . $text;
		}
		return $out;
	}
}
