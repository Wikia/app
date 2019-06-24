<?php

/**
 * Wiki Features Special Page
 * @author Hyun
 * @author Owen
 * @author Saipetch
 */
class WikiFeaturesSpecialController extends WikiaSpecialPageController {
	use PreventBlockedUsersThrowsErrorTrait;

	public function __construct() {
		parent::__construct('WikiFeatures', 'wikifeaturesview');
	}
	
	public function index() {
		$this->wg->Out->setPageTitle(wfMsg('wikifeatures-title'));
		if (!$this->wg->User->isAllowed('wikifeaturesview')) {	// show this feature to logged in users only regardless of their rights
			$this->displayRestrictionError();
			return false;  // skip rendering
		}

		JSMessages::enqueuePackage('WikiFeatures', JSMessages::EXTERNAL);

		$this->response->addAsset('extensions/wikia/WikiFeatures/css/WikiFeatures.scss');
		$this->response->addAsset('extensions/wikia/WikiFeatures/js/modernizr.transform.js');
		$this->response->addAsset('extensions/wikia/WikiFeatures/js/WikiFeatures.js');

		if($this->getVal('simulateNewLabs', false)) { // debug code
			WikiFeaturesHelper::$release_date = array (
				'wgEnableChat' => '2032-09-01'
			);
		}

		$this->features = WikiFeaturesHelper::getInstance()->getFeatureNormal();
		$this->labsFeatures = WikiFeaturesHelper::getInstance()->getFeatureLabs();

		$this->editable = $this->wg->User->isAllowed('wikifeatures') ? true : false ;	// only those with rights can make edits

		if($this->getVal('simulateEmptyLabs', false)) {	// debug code
			$this->labsFeatures = array();
		}
	}

	/**
	 * @desc enable/disable feature
	 * @requestParam string enabled [true/false]
	 * @requestParam string feature	(extension variable)
	 * @responseParam string result [OK/error]
	 * @responseParam string error (error message)
	 */
	public function toggleFeature() {
		try {
			$this->checkWriteRequest();
		} catch ( BadRequestException $e ) {
			$this->setVal( 'result', 'error' );
			$this->setVal( 'error', wfMessage( 'sessionfailure' )->escaped() );
			return;
		}

		$enabled = $this->getVal('enabled', null);
		$feature = $this->getVal('feature', null);

		Hooks::run( 'WikiFeatures::onToggleFeature', [
			'name' => $feature,
			'enabled' => $enabled
		] );

		// check user permission
		if(!$this->wg->User->isAllowed( 'wikifeatures' )) {
			$this->setVal( 'result', 'error' );
			$this->setVal( 'error', wfMessage( 'wikifeatures-error-permission' )->escaped() );
			return;
		}

		// check if feature given is actually something we allow setting
		if ( !in_array( $feature, $this->wg->WikiFeatures['normal'] ) && !in_array( $feature, $this->wg->WikiFeatures['labs'] ) ) {
			$this->setVal( 'result', 'error' );
			$this->setVal( 'error', wfMessage( 'wikifeatures-error-invalid-parameter', $feature )->escaped() );
			return;
		}

		// validate feature: valid value ($enabled and $feature), check if Feature exists ($wgVarId)
		$wgVarId = WikiFactory::getVarIdByName( $feature, true );

		if ( ( $enabled != 'true' && $enabled != 'false' ) || empty( $feature ) || empty( $wgVarId ) ) {
			$this->setVal( 'result', 'error' );
			$this->setVal( 'error', wfMessage( 'wikifeatures-error-invalid-parameter', $feature )->escaped() );
			return;
		}

		$enabled = ( $enabled == 'true' );

		$logMsg = "set extension option: $feature = " . var_export( $enabled, true );
		$log = new LogPage( 'wikifeatures' );
		$log->addEntry( 'wikifeatures', SpecialPage::getTitleFor('WikiFeatures'), $logMsg, array() );
		WikiFactory::setVarByName( $feature, $this->wg->CityId, $enabled, 'WikiFeatures' );

		// clear cache for active wikis
		WikiFactory::clearCache( $this->wg->CityId );
		$this->wg->Memc->delete( WikiFeaturesHelper::getInstance()->getMemcKeyNumActiveWikis( $feature ) );

		Hooks::run( 'WikiFeatures::afterToggleFeature', [ $feature, $enabled ] );

		$this->setVal( 'result', 'ok' );
	}


