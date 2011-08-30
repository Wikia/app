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
		if (!$this->wg->User->isAllowed( 'wikifeatures' )) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}
		$this->response->addAsset('extensions/wikia/WikiFeatures/css/WikiFeatures.scss');
		$this->response->addAsset('extensions/wikia/WikiFeatures/js/WikiFeatures.js');
		
		$this->features = WikiFeaturesHelper::getInstance()->getFeatureNormal();
		$this->labsFeatures = WikiFeaturesHelper::getInstance()->getFeatureLabs();
	}

	/**
	 * @desc enable/disable feature
	 * @requestParam string enabled [true/false]
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
		if (($enabled != 'true' && $enabled != 'false') || !$feature || !isset($this->wg->{str_replace('wg', '', $feature)})) {
			$this->setVal('result', 'error');
			$this->setVal('error', $this->wf->Msg('wikifeatures-error-invalid-parameter'));
			return;
		}
		
		$enabled = ($enabled=='true');
		
		$logMsg = "set extension option: $feature = ".var_export($enabled, TRUE);
		$log = WF::build( 'LogPage', array( 'wikifeatures' ) );
		$log->addEntry( 'wikifeatures', SpecialPage::getTitleFor('WikiFeatures'), $logMsg, array() );
		WikiFactory::setVarByName($feature, $this->wg->CityId, $enabled, "WikiFeatures");
		
		if ($feature == 'wgEnableTopListsExt')
			WikiFactory::setVarByName('wgShowTopListsInCreatePage', $this->wg->CityId, $enabled, "WikiFeatures");
		
		// clear cache for active wikis
		$this->wg->Memc->delete(WikiFeaturesHelper::getInstance()->getMemcKeyNumActiveWikis($feature));
			
		$this->setVal('result', 'ok');
	}

/**
 * Save a fogbugz ticket
 * @requestParam type $rating
 * @requestParam type $category
 * @requestParam type $message
 * @responseParam string result [OK/error]
 * @responseParam string error (error message)
 */
	
	public function saveFeedback() {
		
		$user = $this->wg->User;
		$feature = $this->getVal('feature');
		$rating = $this->getVal('rating', 0);
		$category = $this->getVal('category');
		$message = $this->getVal('message');
	
		if( !$user->isAllowed( 'wikifeatures' ) ) {
			$this->result = 'error';
			$this->error = $this->wf->Msg('wikifeatures-error-permission');
		}
		
		// TODO: validate feature_id
		if ( !array_key_exists($feature, WikiFeaturesHelper::$feedbackAreaIDs) ) {
			$this->result = 'error';
			$this->error = $this->wf->Msg('wikifeatures-error-invalid-parameter', 'feature');
		}
		
		if ( !array_key_exists($category, WikiFeaturesHelper::$feedbackCategories) ) {
			$this->result = 'error';
			$this->error = $this->wf->Msg('wikifeatures-error-invalid-parameter', 'category');
		}
		
		// Rating is optional, 0 is the default if not entered
		if ( $rating != 0 && ( $rating < 1 || $rating > 5) ) {
			$this->result = 'error';
			$this->error = $this->wf->Msg('wikifeatures-error-invalid-parameter', 'rating');
		} else {
			// save rating not implemented yet
			// $project->updateRating( $user->getId(), $rating );
		}

		if ( !$message || strlen($message) < 10 || strlen($message) > 1000 ) {
			$this->result = 'error';
			$this->error = $this->wf->Msg('wikifeatures-error-invalid-parameter', 'message');
		}
								
		if( WikiFeaturesHelper::getInstance()->isSpam($user->getName(), $feature) ) {
			$this->result = 'error';
			$this->error = $this->wf->Msg('wikifeatures-error-spam-attempt');
		}

		// Passed validations, actually do something useful
		if( is_null($this->error) ) {
			$this->result = 'ok';
			$bugzdata = WikiFeaturesHelper::getInstance()->saveFeedbackInFogbugz( $feature, $user->getEmail(), $user->getName(), $message, $category );
			$this->caseId = $bugzdata['caseId'];
		}
	}
	
}
