<?php

class MarketingToolboxController extends WikiaSpecialPageController {

	const FLASH_MESSAGE_SESSION_KEY = 'flash_message';

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

	/**
	 * Check access to this page
	 */
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

	/**
	 * Main action for this special page
	 */
	public function index() {
		$this->wf->ProfileIn(__METHOD__);

		$this->wg->Out->setPageTitle($this->wf->msg('marketing-toolbox-title'));

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

	/**
	 * dashboard action
	 * Here curator can select language, section, vertical and date
	 */
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

	protected function checkDate($date) {
		$datetime = new DateTime('@' . $date);
		if ($datetime->format('H') != 0 || $datetime->format('i') != 0 || $datetime->format('s') != 0) {
			$datetime->setTime(0, 0, 0);
			$url = $this->toolboxModel->getModuleUrl(
				$this->langCode,
				$this->sectionId,
				$this->verticalId,
				$datetime->getTimestamp(),
				$this->selectedModuleId
			);
			$this->response->redirect($url);
		}
	}

	/**
	 * Main action for editing hub modules
	 */
	public function editHubAction() {

		$this->retriveDataFromUrl();

		$this->checkDate($this->date);

		$this->flashMessage = $this->getFlashMessage();

		$modulesData = $this->toolboxModel->getModulesData(
			$this->langCode,
			$this->sectionId,
			$this->verticalId,
			$this->date,
			$this->selectedModuleId
		);
		$this->prepareLayoutData($this->selectedModuleId, $modulesData);

		$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/js/EditHub.js');
		$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/js/EditHubNavigation.js');
		$this->response->addAsset('/resources/jquery/jquery.validate.js');
		$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/js/jquery.MetaData.js');

		$selectedModuleData = array(
			'values' => $modulesData['moduleList'][$this->selectedModuleId]['data']
		);

		$module = MarketingToolboxModuleService::getModuleByName(
			$this->toolboxModel->getNotTranslatedModuleName($this->selectedModuleId),
			$this->langCode,
			$this->sectionId,
			$this->verticalId
		);

		$selectedModuleData['validationErrors'] = array();

		if ($this->request->wasPosted()) {
			$selectedModuleData['values'] = $this->request->getParams();

			$selectedModuleData['values'] = $module->filterData($selectedModuleData['values']);
			$selectedModuleData['validationErrors'] = $module->validate($selectedModuleData['values']);
			if (empty($selectedModuleData['validationErrors'])) {
				$this->toolboxModel->saveModule(
					$this->langCode,
					$this->sectionId,
					$this->verticalId,
					$this->date,
					$this->selectedModuleId,
					$selectedModuleData['values'],
					$this->wg->user->getId()
				);

				$this->putFlashMessage($this->wf->msg('marketing-toolbox-module-save-ok', $modulesData['activeModuleName']));
				// TODO last module (when we will know what to do after last module, maybe preview?)
				$nextUrl =  $this->toolboxModel->getModuleUrl(
					$this->langCode,
					$this->sectionId,
					$this->verticalId,
					$this->date,
					$this->selectedModuleId + 1
				);
				$this->response->redirect($nextUrl);
			} else {
				$this->errorMessage = $this->wf->msg('marketing-toolbox-module-save-error');
			}
		}

		$this->moduleName = $modulesData['activeModuleName'];
		$this->moduleContent = $module->renderEditor($selectedModuleData);

		$this->overrideTemplate('editHub');
	}

	protected function retriveDataFromUrl() {
		$this->langCode = $this->getVal('region');
		$this->verticalId = $this->getVal('verticalId');
		$this->sectionId = $this->getVal('sectionId');
		$this->date = $this->getVal('date');
		$this->selectedModuleId = $this->getVal('moduleId', 1);
	}

	/**
	 * Get data from url and it for header and left menu
	 *
	 * @param int $selectedModuleId selected module id
	 */
	protected function prepareLayoutData($selectedModuleId, $modulesData) {
		$this->prepareHeaderData($modulesData, $this->date);
		$this->prepareLeftMenuData($modulesData, $selectedModuleId);
	}

	/**
	 * Prepare data for header
	 */
	protected function prepareHeaderData($modulesData, $date) {
		$this->headerData = array(
			'date' => $date,
			'moduleName' => $modulesData['activeModuleName'],
			'lastEditor' => $modulesData['lastEditor'],
			'lastEditTime' => $modulesData['lastEditTime'],
			'sectionName' => $this->toolboxModel->getSectionName($this->sectionId),
			'verticalName' => $this->toolboxModel->getVerticalName($this->sectionId, $this->verticalId),
			'regionName' => Language::getLanguageName($this->langCode),
		);
	}

	/**
	 * Prepare date for left menu
	 */
	protected function prepareLeftMenuData($modulesData, $selectedModuleId) {
		$this->leftMenuItems = array();

		foreach ($modulesData['moduleList'] as $moduleId => $moduleData) {
			$this->leftMenuItems[] = array(
				'href' => $moduleData['href'],
				'selected' => ($moduleId == $selectedModuleId),
				'title' => $moduleData['name'],
				'anchor' => $moduleData['name'],
			);
		}
	}

	/**
	 * Small routing for this special page
	 *
	 * @return string request action
	 */
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
	 * Get calendar selected date range
	 *
	 * @param $timestamp (actual timestamp)
	 * @return array
	 */
	public function getCalendarData() {
		$langCode = $this->getVal('langCode');
		$verticalId = $this->getVal('verticalId');
		$beginTimestamp = $this->getVal('beginTimestamp', time());
		$endTimestamp = $this->getVal('endTimestamp', time());
		$this->calendarData = $this->toolboxModel->getData($langCode, $verticalId, $beginTimestamp, $endTimestamp);
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

	/**
	 * Render header module
	 */
	public function executeHeader($data) {
		$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/css/MarketingToolbox_Header.scss');

		$optionalDataKeys = array('date', 'moduleName', 'sectionName', 'verticalName',
			'regionName', 'lastEditor', 'lastEditTime');

		foreach ($optionalDataKeys as $key) {
			if (isset($data[$key])) {
				$this->$key = $data[$key];
			}
		}

		$this->dashboardHref = SpecialPage::getTitleFor('MarketingToolbox')->getLocalURL();
	}

	/**
	 * Render footer module
	 */
	public function executeFooter($data) {
		$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/css/MarketingToolbox_Footer.scss');
	}

	/**
	 * @desc Used by WMU to get the image url
	 * @todo: Let's add here rights check maybe... ;)
	 */
	public function getImageDetails() {
		$fileName = $this->getVal('fileHandler', false);
		if( $fileName ) {
			$model = new MarketingToolboxModel();
			$file = ImagesService::getLocalFile($fileName);
			$this->imageWidth = $file->getWidth();
			$this->imageHeight = $file->getHeight();
			$this->fileUrl = ImagesService::getLocalFileThumbUrl($file, $model->getThumbnailSize());
		}
	}

	public function getVideoDetails() {
		$html = $this->wf->MsgExt($this->getVal('wikiText', false), array('parse'));
		$this->fileName = $this->parseVideoHtml($html);
	}

	public function parseVideoHtml($html) {
		//TO-DO: remove mocked data and get <a>(...)</a> tags from $html
		$figureElement = '<a href="/wiki/File:Muppet_Show_Season_Two_(2007)_-_Clip_Kermit_and_Fozzie_-_What_Is_Friendship,_Post" class="image video" data-video-name="Muppet Show Season Two (2007) - Clip Kermit and Fozzie - What Is Friendship, Post" itemprop="video" itemscope="" itemtype="http://schema.org/VideoObject"><span class="Wikia-video-play-button mid" style="width: 180px; height: 101px;"></span><img alt="Muppet Show Season Two (2007) - Clip Kermit and Fozzie - What Is Friendship, Post" src="http://images.marcin.wikia-dev.com/__cb20120925182528/video151/images/thumb/7/72/Muppet_Show_Season_Two_%282007%29_-_Clip_Kermit_and_Fozzie_-_What_Is_Friendship%2C_Post/180px-Muppet_Show_Season_Two_%282007%29_-_Clip_Kermit_and_Fozzie_-_What_Is_Friendship%2C_Post.jpg" width="180" height="101" data-video="Muppet Show Season Two (2007) - Clip Kermit and Fozzie - What Is Friendship, Post" itemprop="thumbnail" class="Wikia-video-thumb thumbimage"></a>';
		return $figureElement;
	}

	// TODO extract this code somewhere
	protected function getFLashMessage() {
		$message = $this->request->getSessionData(self::FLASH_MESSAGE_SESSION_KEY);
		$this->request->setSessionData(self::FLASH_MESSAGE_SESSION_KEY, null);
		return $message;
	}

	protected function putFlashMessage($message) {
		$this->request->setSessionData(self::FLASH_MESSAGE_SESSION_KEY, $message);
	}

	public function executeFormField() {
		$this->inputData = $this->getVal('inputData');
	}
}