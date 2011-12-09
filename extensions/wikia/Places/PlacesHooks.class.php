<?php
class PlacesHooks extends WikiaObject{

	private $modelToSave;

	function __construct(){
			parent::__construct();
			F::setInstance( __CLASS__, $this );
	}

	public function setModelToSave( PlaceModel $model ){
		$this->modelToSave = $model;
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
			$storage = F::build('PlaceStorage', array($out->getTitle()), 'newFromTitle');
			$model = $storage->getModel();

			if ($model instanceof PlaceModel && !$model->isEmpty()) {
				$out->addMeta( 'geo.position', implode( ',', $model->getLatLon() ) );
			}
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	public function onArticleSaveComplete( &$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ){
 		$this->wf->profileIn( __METHOD__ );

		$this->wf->Debug( __METHOD__ . "\n" );

		// store queued model or clear data for the article (if no model was passed)
		$storage = F::build( 'PlaceStorage', array( $article ), 'newFromArticle' );

		if ( self::$modelToSave instanceof PlaceModel ) {
			// use model from parser hook
			// self::$modelToSave is set in PlacesParserHookHandler::renderPlaceTag
			$storage->setModel( $this->modelToSave );
		}
		else {
			// no geo data fround - use an empty model
			$storage->setModel( F::build('PlaceModel') );
		}

		$storage->store();

		$this->wf->profileOut( __METHOD__ );
		return true;
 	}

	public function onRTEUseDefaultPlaceholder( $name, $params, $frame, $wikitextIdx ) {
		if ($name !== 'place') {
			return true;
		} else {
			// store metadata index to be used when rendering placeholder for RTE
			PlacesParserHookHandler::$lastWikitextId = $wikitextIdx;
			return false;
		}
	}

	/**
	 * Add Google Maps API key to the <head> section of the edit page
	 *
	 * @param mixed $vars key/value list of JS global variables
	 * @return true it's a hook
	 */
	public function onEditPageMakeGlobalVariablesScript( $vars ){
		$vars['wgGoogleMapsKey'] = $this->wg->GoogleMapsKey;
		return true;
	}

	/**
	 * Initialize edit page - load JS file and messages
	 *
	 * @param EditPage $editpage edit page instance
	 * @return true it's a hook
	 */
	public function onShowEditForm( EditPage $editpage ){
		// add edit toolbar button for adding places
		$src = AssetsManager::getInstance()->getOneCommonURL( 'extensions/wikia/Places/js/PlacesEditPage.js' );
		$this->wg->Out->addScript( "<script type=\"{$app->wg->JsMimeType}\" src=\"{$src}\"></script>" );

		// load JS messages
		F::build( 'JSMessages' )->enqueuePackage( 'Places', JSMessages::INLINE );
		return true;
	}
	
	public function onOutputPageBeforeHTML( &$out, &$text ){
		return $out;
	}
}
