<?php

/**
 * SpecialPage controller
 * @author Marooned
 */
class UserPreferencesStatsSpecialController extends WikiaSpecialPageController {

	private $businessLogic = null;

	public function __construct() {
		// standard SpecialPage constructor call
		parent::__construct( 'UserPreferencesStats', '', false );
	}

	public function init() {
		$this->businessLogic = new UserPreferencesStats( $this->app->wg->Title );
	}

	/**
	 * this is default method, adding necessary files, passing data to the template
	 * @author Marooned
	 */
	public function index() {
		wfProfileIn( __METHOD__ );

		$this->wg->Out->setPageTitle( wfMsg( 'userpreferencesstats-specialpage-title' ) );
		$this->response->addAsset( 'extensions/wikia/hacks/UserPreferencesStats/css/UserPreferencesStats_Oasis.scss' );
		$this->response->addAsset( 'extensions/wikia/hacks/UserPreferencesStats/js/UserPreferencesStats.js' );
		$this->response->addAsset( 'resources/wikia/libraries/jquery/flot/jquery.flot.js' );
		$this->response->addAsset( 'resources/wikia/libraries/jquery/flot/jquery.flot.pie.js' );

		// setting response data
		$this->setVal( 'header', wfMsg('userpreferencesstats-hello-msg') );
		$this->setVal( 'wikiData', $this->businessLogic->getProperties() );

		$props = $this->wg->Request->getArray( 'prop' );
		if ( $props ) {
			$data = $this->businessLogic->getDataForProps( $props );
			$this->setVal( 'selectedProps', $props );
			$this->setVal( 'data', $data );
		}

		wfProfileOut( __METHOD__ );
	}
}
