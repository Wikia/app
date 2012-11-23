<?php

class MarketingToolboxController extends WikiaSpecialPageController {

	protected $toolboxModel;

	public function __construct() {
		parent::__construct('MarketingToolbox', 'marketingtoolbox', true);
	}

	public function isRestricted() {
		return true;
	}

	public function init() {
        $this->toolboxModel = new MarketingToolboxModel();
	}

	protected function checkAccess() {
		$this->wf->ProfileIn(__METHOD__);

		if( !$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed('marketingtoolbox') ) {
			$this->wf->ProfileOut(__METHOD__);
			$this->specialPage->displayRestrictionError();
			return false;
		}

		$this->wf->ProfileOut(__METHOD__);
		return true;
	}

	public function index() {
		$this->wf->ProfileIn(__METHOD__);

		$this->wg->Out->setPageTitle(wfMsg('marketing-toolbox-title'));

		if( $this->checkAccess() ) {
			$this->wg->SuppressSpotlights = true;
			$this->wg->SuppressWikiHeader = true;
			$this->wg->SuppressPageHeader = true;
			$this->wg->SuppressFooter = true;
			$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/css/MarketingToolbox.scss');

			$action = $this->getRequestedAction();

			F::build('JSMessages')->enqueuePackage('MarketingToolbox', JSMessages::EXTERNAL);

			switch($action) {
				case 'editHub':
					$this->forward(__CLASS__, 'editHubAction');
					break;
				case 'index':
				default:
					$this->forward(__CLASS__, 'dashboardAction');
					break;
			}
		}

		$this->wf->ProfileOut(__METHOD__);
	}

	public function dashboardAction() {
		$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/css/MarketingToolbox_Dashboard.scss');
		$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/js/MarketingToolbox.js');
		$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/js/DatepickerModel.js');

		$this->corporateWikisLanguages = $this->toolboxModel->getCorporateWikisLanguages();
		$this->sections = $this->toolboxModel->getAvailableSections();
		$this->verticals = $this->getVerticals(MarketingToolboxModel::SECTION_HUBS);

		$userPreferendesHandler = new MarketingToolboxUserPropertiesHandler();
		$this->selectedLanguage = $userPreferendesHandler->getMarketingToolboxRegion();
		$this->selectedVertical = $userPreferendesHandler->getMarketingToolboxVertical();

		$this->overrideTemplate('dashboard');
	}

	public function editHubAction() {
		$langId = $this->getVal('region');
		$verticalId = $this->getVal('verticalId');
		$date = $this->getVal('date');

		$modulesData = $this->toolboxModel->getModulesData($langId, $verticalId, $date);

		$this->headerData = array(
			'date' => $this->getVal('date'),
			'moduleName' => $modulesData['activeModuleName'],
			'lastEditor' => $modulesData['lastEditor'],
			'lastEditTime' => $modulesData['lastEditTime'],
		);

		$this->leftMenuItems = array(
			array(
				'href' => 'asd',
				'selected' => false,
				'title' => 'title',
				'anchor' => 'anchor'
			),
			array(
				'href' => 'asd',
				'selected' => true,
				'title' => 'title',
				'anchor' => 'anchor'
			),
			array(
				'href' => 'asd',
				'selected' => false,
				'title' => 'title',
				'anchor' => 'anchor'
			),
			array(
				'href' => 'asd',
				'selected' => false,
				'title' => 'title',
				'anchor' => 'anchor'
			),
		);
		$this->overrideTemplate('editHub');
	}

	protected function getRequestedAction() {
		$urlParam = $this->getPar();
		$urlElements = explode('/', $urlParam);
		if (!empty($urlElements[0])) {
			$action = $urlElements[0];
		} else {
			$action = 'index';
		}
		return $action;
	}

	/**
	 * Get calendar for actual and following 2 months
	 *
	 * @param $timestamp (actual timestamp)
	 * @return array
	 */
	public function getCalendarData() {
		$langId = $this->getVal('langId');
		$verticalId = $this->getVal('verticalId');
		$beginTimestamp = $this->getVal('beginTimestamp', time());
		$endTimestamp = $this->getVal('endTimestamp', time());
		$this->calendarData = $this->toolboxModel->getData($langId, $verticalId, $beginTimestamp, $endTimestamp);
	}

	/**
	 * Get available verticals for selected Section
	 *
	 * @param int $sectionId
	 * @return array
	 */
	public function getVerticals($sectionId) {
		return $this->toolboxModel->getAvailableVerticals(MarketingToolboxModel::SECTION_HUBS);
	}

	public function executeHeader($data) {
		$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/css/MarketingToolbox_Header.scss');

		$this->date = (isset($data['date'])) ? $data['date'] : null;
		$this->moduleName = (isset($data['moduleName'])) ? $data['moduleName'] : null;
		$this->lastEditor = (isset($data['lastEditor'])) ? $data['lastEditor']: null;
		$this->lastEditTime = (isset($data['lastEditTime'])) ? $data['lastEditTime']: null;
	}

	public function executeFooter($data) {
		$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/css/MarketingToolbox_Footer.scss');
	}
}
