<?php

class MarketingToolboxController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('MarketingToolbox', 'marketingtoolbox', true);
	}

	public function isRestricted() {
		return true;
	}

	public function init() {
	}

	protected function checkAccess() {
		$this->wf->ProfileIn(__METHOD__);

		if( !$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed('marketingtoolbox') ) {
			$this->wf->ProfileOut(__METHOD__);
			$this->specialPage->displayRestrictionError();
			return false;
		}

		$this->response->addAsset('/extensions/wikia/MarketingToolbox/css/MarketingToolbox.scss');
		$this->response->addAsset('/extensions/wikia/MarketingToolbox/js/MarketingToolbox.js');

		$this->wf->ProfileOut(__METHOD__);
		return true;
	}

	public function index() {
		$this->wf->ProfileIn(__METHOD__);
		$this->wg->Out->setPageTitle(wfMsg('marketing-toolbox-title'));

		if( $this->checkAccess() ) {

		}
	}

	/**
	 * @param $timestamp (of start date)
	 * @return array
	 */
	public function getCalendarData($timestamp = null) {
		if(empty($timestamp)) {
			$timestamp = time();
		}
		$toolboxModel = new MarketingToolboxModel();
		$this->calendarData = $toolboxModel->getData($timestamp);
	}
}
