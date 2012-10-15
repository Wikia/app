<?php

/**
 * PlaceCategory
 */

class PlaceCategory {

	const WPP_TABLE = 'page_wikia_props';
	const CACHE_TTL = 604800; // a week

	private $app;
	private $memc;

	// ID of page model is stored for
	private $pageId;
	private $sTitle;
	private $isEnabled = false;

	/**
	 * Construct PlaceStorage model instance
	 *
	 * @param WikiaApp $app Nirvava application instance
	 * @param string $sTitle title text
	 */
	public function __construct( WikiaApp $app, $sTitle ) {
		$this->app = $app;
		$this->memc = $this->app->wg->Memc;
		$this->sTitle = $sTitle;
	}

	/**
	 * Return PlaceStorage model for article with given ID
	 *
	 * @param string $sTitle title text
	 * @return PlaceStorage model object
	 */
	public static function newFromTitle( $sTitle ) {
		// include title to article ID logic

		$instance = F::build(
			'PlaceCategory',
			array(
				'app' => F::app(),
				'sTitle' => $sTitle
			)
		);

		// read data from database
		$instance->read();
		return $instance;
	}

	public function isGeoTaggingEnabled(){
		return !empty( $this->isEnabled );
	}

	public function isGeoTaggingEnabledForArticle( Title $oTitle ){

		$oArticle =	$this->app->wg->article;
		if ( is_object( $oArticle ) && is_object( $oArticle->mParserOutput ) && is_object( $oArticle->mParserOutput->mCategories ) ){
			$aCategories = $oArticle->mParserOutput->mCategories;
		} else {
			return false;
		}

		if ( !empty( $aCategories ) ){
			$aCategories = array_keys( $aCategories );
			foreach ( $aCategories as $sCategory ){
				$oTmpTitle = Title::newFromText( $sCategory, NS_CATEGORY );
				if ( F::build('PlaceCategory', array( $oTmpTitle->getFullText() ), 'newFromTitle' )->isGeoTaggingEnabled() ){
					return true;
				};
			}
		}

		return false;
	}

	public function enableGeoTagging(){
		$this->isEnabled = 1;
		$this->store();
	}

	public function disableGeoTagging(){
		$this->isEnabled = 0;
		$this->store();
	}

	private function read() {
		wfProfileIn(__METHOD__);

		$this->isEnabled = 0;
		$oTitle = F::build( 'Title', array( $this->sTitle ), 'newFromText' );
		if ( is_object( $oTitle ) && ( $oTitle instanceof Title ) ){
			$oTitle->exists();
			$this->pageId = $oTitle->getArticleID();
			if ( empty( $this->pageId ) ){
				wfProfileOut(__METHOD__);
				return false;
			}
		} else {
			wfProfileOut(__METHOD__);
			return false;
		}

		$this->isEnabled = $this->memc->get( $this->getMemcKey() );

		// if memc was empty
		if ( $this->isEnabled === false ) {
			$this->app->wf->Debug(__METHOD__ . " - memcache miss for #{$this->pageId}\n");
			$this->isEnabled = $this->app->wf->GetWikiaPageProp( WPP_PLACES_CATEGORY_GEOTAGGED, $this->pageId );
			$this->memc->set( $this->getMemcKey(), $this->isEnabled, self::CACHE_TTL );
		} else {
			$this->app->wf->Debug(__METHOD__ . " - memcache hit for #{$this->pageId}\n");
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	public function store() {
		wfProfileIn(__METHOD__);

		if ( $this->isEnabled !== false ){

			$oTitle = F::build( 'Title', array( $this->sTitle ), 'newFromText' );
			if ( $oTitle instanceof Title ){
				$oTitle->exists();
				$this->pageId = $oTitle->getArticleID();

				if ( $this->pageId == 0 ){
					$oArticle = new Article( $oTitle );
					$oArticle->doEdit(
						'',
						wfMsg( 'places-updated-geolocation' ),
						EDIT_NEW
					);
					$this->pageId = $oArticle->getID();
				}

				$this->app->wf->setWikiaPageProp(
					WPP_PLACES_CATEGORY_GEOTAGGED,
					$this->pageId,
					(int)$this->isEnabled
				);

				// update the cache
				$this->memc->set($this->getMemcKey(), $this->isEnabled, self::CACHE_TTL);
			}
		}
		wfProfileOut(__METHOD__);
	}

	private function getDB($type = DB_SLAVE) {
		return $this->app->wf->GetDB($type, array(), $this->app->wg->DBname);
	}

	private function getMemcKey() {
		return $this->app->wf->MemcKey("placeCategoryGeoTag::{$this->pageId}");
	}
}
