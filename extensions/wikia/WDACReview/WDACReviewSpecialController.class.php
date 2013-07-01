<?php

class WDACReviewSpecialController extends WikiaSpecialPageController {

	const FLAG_APPROVE = 1;
	const FLAG_DISAPPROVE = -1;
	const FLAG_UNDETERMINED = 0;

	public function __construct() {
		parent::__construct('WDACReview', 'wdacreview', false /* $listed */);
	}

	protected function setGlobalDisplayVars() {
		// get more space for review list
		$this->wg->OasisFluid = true;
		$this->wg->SuppressSpotlights = true;
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressFooter = true;

		$this->wg->Out->setPageTitle($this->getToolName());

		$this->wg->Out->enableClientCache( false );
	}

	public function index() {
		$this->setGlobalDisplayVars();

		$this->accessReview = $this->wg->User->isAllowed( 'wdacreview' );
		if (!$this->specialPage->userCanExecute($this->wg->User)) {
			$this->specialPage->displayRestrictionError();
			return false;
		}

		$this->response->addAsset( 'extensions/wikia/WDACReview/js/WDACReview.js' );
		$this->response->addAsset( 'extensions/wikia/WDACReview/css/WDACReview.scss' );

		$helper = $this->getHelper();

		$this->fullUrl = $this->wg->Title->getFullUrl( );
		$this->baseUrl = $this->specialPage->getTitle()->getFullUrl();
		$this->toolName = $this->getToolName();
		$this->submitUrl = $this->baseUrl;

		if( $this->wg->request->wasPosted() ) {
			$data = $this->wg->request->getValues();
			if ( !empty($data) ) {
				$cities = $this->parseData($data);

				if ( count($cities) > 0 ) {
					$helper->updateWDACFlags( $cities );
					NotificationsController::addConfirmation( wfMessage('wdacreview-confirm-update')->plain() );
				}
			}
		}

		$this->aCities = $helper->getCitiesForReviewList();
	}


	protected function getHelper() {
		return new WDACReviewHelper();
	}

	protected function getToolName() {
		return wfMessage('wdacreview-tool-name')->escaped();
	}

	protected function parseData($data) {
		$cities = array();

		foreach( $data as $name => $value ) {
			if (preg_match('/city-(\d+)/', $name, $matches)) {
				if ( !empty($matches[1]) ) {
					$cities[$matches[1]] = $value;
				}
			}
		}

		return $cities;
	}
}
