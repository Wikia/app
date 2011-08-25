<?php

/**
 * Wiki Features Special Page
 * @author Hyun
 * @author Owen
 * @author Saipetch
 */
class WikiFeaturesSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		wfLoadExtensionMessages('WikiFeatures');
		parent::__construct('WikiFeatures', '', false);
	}
	
	public function init() {
		
	}
	
	public function index() {
		$this->response->addAsset('extensions/wikia/WikiFeatures/css/WikiFeatures.scss');
		$this->response->addAsset('extensions/wikia/WikiFeatures/js/WikiFeatures.js');
		//$this->wg->Out->addScriptFile($this->wg->ExtensionsPath . '/wikia/WikiFeatures/js/WikiFeatures.js');
		
		$this->normal = WikiFeaturesHelper::getInstance()->getFeatureNormal();
		$this->labs = WikiFeaturesHelper::getInstance()->getFeatureLabs();
	}

	/**
	 * @desc enable/disable feature
	 * @requestParam string enabled [true/false/0/1]
	 * @requestParam string feature	(extension variable)
	 * @responseParam string result [OK/error]
	 * @responseParam string error (error message)
	 */
	public function toggleFeature() {
		$enabled = $this->getVal('enabled', null);
		$feature = $this->getVal('feature', null);
		
		// check user permission
		if(!$this->wg->User->isAllowed( 'wikifeatures' )) {
			$this->setVal('result', 'error');
			$this->setVal('error', $this->wf->Msg('wikifeatures-error-permission'));
			return;
		}

		// validate feature
		if (is_null($enabled) || !$feature || !isset($this->wg->{str_replace('wg', '', $feature)})) {
			$this->setVal('result', 'error');
			$this->setVal('error', $this->wf->Msg('wikifeatures-error-invalid-parameter'));
			return;
		}
		
		$logMsg = "set extension option: $feature = $enabled.";
		$log = WF::build( 'LogPage', array( 'wikifeatures' ) );
		$log->addEntry( 'wikifeatures', SpecialPage::getTitleFor( 'WikiFeatures'), $logMsg, array() );
		
		$enabled = (bool) $enabled;
		WikiFactory::setVarByName($feature, $this->wg->CityId, $enabled, "WikiFeatures");
		
		// clear cache for active wikis
		$this->wg->Memc->delete(WikiFeaturesHelper::getInstance()->getMemcKeyNumActiveWikis($feature));
			
		$this->setVal('result', 'OK');
	}
	
}
