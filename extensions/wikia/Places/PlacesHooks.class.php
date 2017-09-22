<?php
class PlacesHooks {

	private static $modelToSave;

	static public function setModelToSave( PlaceModel $model ){
		self::$modelToSave = $model;
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

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onArticleSaveComplete(
		WikiPage $article, User $user, $text, $summary, $minoredit, $watchthis,
		$sectionanchor, $flags, $revision, Status &$status, $baseRevId
	): bool {
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
	 * @param OutputPage $out
	 * @param string $text
	 * @return bool
	 */
	static public function onOutputPageBeforeHTML( OutputPage $out, string &$text ): bool {

		if ( $out->getRequest()->getVal('action', 'view') == true ) {
			$text = F::app()->sendRequest( 'Places', 'getGeolocationButton' )->toString() . $text;
		}

		return true;
	}
}
