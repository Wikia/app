<?php

/**
 * Wiki Features Special Page
 * @author Hyun
 * @author Owen
 *
 */
class WikiFeaturesSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		wfLoadExtensionMessages('WikiFeatures');
		parent::__construct('WikiFeatures', '', false);
	}
	
	public function init() {
		$this->response->addAsset('extensions/wikia/WikiFeatures/js/WikiFeatures.js');
	}
	
	public function index() {
		
	}

	// TODO: flag this as an internal dispatch function only
	public function beforeEnableDisable() {
		
		$caller = $this->getVal("caller");
		$this->error = false;
		if(!$this->wg->User->isAllowed( 'wikifeatures' )) {
			$this->error = true;
			$this->errorMsg = $this->wf->Msg('wikifeatures-permission-error');
			return;
		}

		// TODO: lots of checking to make sure this extension is in our list of features, etc
		// For now, just check for null
		$feature = $this->getVal('feature', null);
		if (!$feature) {
			$this->error = true;
			$this->errorMsg = $this->wf->Msg('wikifeatures-missing-parameter-error');
			return;
		}
		// tells the caller the feature is ok/validated
		$this->feature = $feature;

		// Full message string contains enabled/disabled string
		$logMsg = F::app()->wf->msgForContent( "wikifeatures-log-$caller-extension", $feature );
		$log = WF::build( 'LogPage', array( 'wikifeatures' ) );
        $log->addEntry( 'wikifeatures', SpecialPage::getTitleFor( 'WikiFeatures'), $logMsg, array() );
		
	}
	
	public function enable() {

		// do universal validation stuff first
		$response = $this->sendSelfRequest('beforeEnableDisable', array('caller' => 'enable'));
		if ($response->getVal('error') == false) {
			$feature = $response->getVal('feature');
			WikiFactory::setVarByName ($feature, $this->wg->CityId, true, "WikiFeatures" );
		} else {
			$this->errorMsg = $response->getVal('errorMsg');
		}
	}
	
	public function disable() {

		// do universal validation stuff first
		$response = $this->sendSelfRequest('beforeEnableDisable', array('caller' =>'disable'));

		if ($response->getVal('error') == false) {
			$feature = $response->getVal('feature');
			WikiFactory::setVarByName ($feature, $this->wg->CityId, true, "WikiFeatures" );
		} else {
			$this->errorMsg = $response->getVal('errorMsg');
		}
		
	}
	
		
}
