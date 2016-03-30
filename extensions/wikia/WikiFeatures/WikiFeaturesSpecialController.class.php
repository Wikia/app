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

	public function init() {

	}

	public function getFeedbackModal() {
		if( !$this->wg->User->isLoggedIn() ) {
			$this->setVal('errorMessage', wfMessage('wikifeatures-error-permission')->text() );
		}

		$title = wfMessage('wikifeatures-feedback-heading')->plain();

		if (strlen($featureName = $this->getVal('featureName', ''))) {
			$title .= ' - ' . $featureName;
		}

		$templateData = [
			'featureName' => $featureName,
			'featureImageUrl' => $this->getVal('featureImageUrl', $this->wg->BlankImgUrl),
			'description' => wfMessage('wikifeatures-feedback-description')->text(),
			'typeLabel' => wfMessage('wikifeatures-feedback-type-label')->plain(),
			'commentLabel' => wfMessage('wikifeatures-feedback-comment-label')->plain(),
			'typeOptions' => [],
		];

		foreach (WikiFeaturesHelper::$feedbackCategories as $i => $cat) {
			$templateData['typeOptions'][] = [
				'label' => wfMessage($cat['msg'])->text(),
				'value' => $i,
			];
		}

		$this->setVal( 'html', ( new Wikia\Template\MustacheEngine )
			->setPrefix( dirname( __FILE__ ) . '/templates' )
			->setData( $templateData )
			->render( 'WikiFeaturesSpecial_feedback.mustache' ) );

		$this->setVal( 'title', $title );
		$this->setVal( 'labelSubmit', wfMessage( 'wikifeatures-feedback-submit-button' )->plain() );
		$this->setVal( 'labelCancel', wfMessage( 'wikifeatures-feedback-cancel-button' )->plain() );
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

	public function notOasis() {
		// empty method
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

		wfRunHooks( 'WikiFeatures::onToggleFeature', [
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

		if ( $feature == 'wgShowTopListsInCreatePage' ) {
			WikiFactory::setVarByName( 'wgEnableTopListsExt', $this->wg->CityId, $enabled, 'WikiFeatures' );
		}

		// clear cache for active wikis
		WikiFactory::clearCache( $this->wg->CityId );
		$this->wg->Memc->delete( WikiFeaturesHelper::getInstance()->getMemcKeyNumActiveWikis( $feature ) );

		wfRunHooks( 'WikiFeatures::afterToggleFeature', [ $feature, $enabled ] );

		$this->setVal( 'result', 'ok' );
	}

	/**
	 * Does some validation and hands user's feedback over so we had a chance to know it.
	 * @requestParam type $category
	 * @requestParam type $message
	 * @responseParam string result [OK/error]
	 * @responseParam string error (error message)
	 */
	public function saveFeedback() {
		try {
			$this->checkWriteRequest();
		} catch ( BadRequestException $e ) {
			$this->setVal( 'result', 'error' );
			$this->setVal( 'error', wfMessage( 'sessionfailure' )->escaped() );
			return;
		}

		$user = $this->wg->User;
		$feature = $this->getVal( 'feature' );
		$category = $this->getVal( 'category' );
		$message = $this->getVal( 'message' );

		if ( !$user->isLoggedIn() ) {
			$this->result = 'error';
			$this->error = wfMessage( 'wikifeatures-error-permission' )->escaped();
			return;
		}

		// TODO: validate feature_id
		if ( !array_key_exists( $feature, WikiFeaturesHelper::$feedbackAreaIDs ) ) {
			$this->result = 'error';
			$this->error = wfMessage( 'wikifeatures-error-invalid-parameter', 'feature' )->escaped();
		} elseif ( !array_key_exists( $category, WikiFeaturesHelper::$feedbackCategories ) || $category == 0 ) {
			$this->result = 'error';
			$this->error = wfMessage( 'wikifeatures-error-invalid-category' )->escaped();
		} elseif ( !$message || strlen( $message ) < 10 || strlen( $message ) > 1000 ) {
			$this->result = 'error';
			$this->error = wfMessage( 'wikifeatures-error-message' )->escaped();
		} elseif ( WikiFeaturesHelper::getInstance()->isSpam( $user->getName(), $feature ) ) {
			$this->result = 'error';
			$this->error = wfMessage( 'wikifeatures-error-spam-attempt' )->escaped();
		}

		// Passed validations, actually do something useful
		if ( is_null( $this->error ) ) {
			$this->result = 'ok';
			$bugzdata = WikiFeaturesHelper::getInstance()->sendFeedback( $feature, $user, $message, $category );
			$this->msg = wfMessage( 'wikifeatures-feedback-success' )->escaped();
		}
	}

}
