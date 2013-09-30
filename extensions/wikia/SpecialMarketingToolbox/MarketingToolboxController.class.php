<?php

class MarketingToolboxController extends WikiaSpecialPageController {

	const FLASH_MESSAGE_SESSION_KEY = 'flash_message';

	protected $toolboxModel;
	private $hubsServicesHelper;

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
		wfProfileIn(__METHOD__);

		if (!$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed('marketingtoolbox')) {
			wfProfileOut(__METHOD__);
			$this->app->wg->Out->setStatusCode ( 403 );
			$this->specialPage->displayRestrictionError();
			return false;
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Main action for this special page
	 */
	public function index() {
		wfProfileIn(__METHOD__);

		$this->wg->Out->setPageTitle(wfMsg('marketing-toolbox-title'));

		if ($this->checkAccess()) {
			$this->wg->SuppressSpotlights = true;
			$this->wg->SuppressWikiHeader = true;
			$this->wg->SuppressPageHeader = true;
			$this->wg->SuppressFooter = true;
			$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/css/MarketingToolbox.scss');
			$this->response->addAsset('/skins/oasis/css/modules/CorporateDatepicker.scss');

			$action = $this->getRequestedAction();

			JSMessages::enqueuePackage('MarketingToolbox', JSMessages::EXTERNAL);

			switch ($action) {
				case 'editHub':
					$this->forward(__CLASS__, 'editHubAction');
					break;
				case 'index':
				default:
					$this->forward(__CLASS__, 'dashboardAction');
					break;
			}
		}

		wfProfileOut(__METHOD__);
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

		$this->wg->Out->addJsConfigVars([
			'wgMarketingToolboxModuleIdSelected' => $this->selectedModuleId,
			'wgMarketingToolboxModuleIdPopularVideos' => MarketingToolboxModulePopularvideosService::MODULE_ID,
			'wgMarketingToolboxModuleIdFeaturedVideo' => MarketingToolboxModuleFeaturedvideoService::MODULE_ID
		]);

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
		$this->response->addAsset('resources/jquery/jquery.validate.js');
		$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/js/jquery.MetaData.js');

		$selectedModuleValues = $modulesData['moduleList'][$this->selectedModuleId]['data'];

		$module = MarketingToolboxModuleService::getModuleByName(
			$this->toolboxModel->getNotTranslatedModuleName($this->selectedModuleId),
			$this->langCode,
			$this->sectionId,
			$this->verticalId
		);

		$form = new FormBuilderService(MarketingToolboxModel::FORM_FIELD_PREFIX);
		$form->setFields($module->getFormFields());

		if ($this->request->wasPosted()) {
			$selectedModuleValues = $this->request->getParams();
			$selectedModuleValues = $module->filterData($selectedModuleValues);

			$isValid = $form->validate($selectedModuleValues);
			if ($isValid) {
				$this->toolboxModel->saveModule(
					$this->langCode,
					$this->sectionId,
					$this->verticalId,
					$this->date,
					$this->selectedModuleId,
					$selectedModuleValues,
					$this->wg->user->getId()
				);

				$this->purgeCache( $module );

				$this->putFlashMessage(wfMsg('marketing-toolbox-module-save-ok', $modulesData['activeModuleName']));

				// send request to add popular/featured videos
				if ( $module->isVideoModule() ) {
					$response = WikiaHubsServicesHelper::addVideoToHubsV2Wikis( $module, $selectedModuleValues  );
				}

				$nextUrl = $this->getNextModuleUrl();
				$this->response->redirect($nextUrl);
			} else {
				$this->errorMessage = wfMsg('marketing-toolbox-module-save-error');
			}
		}
		$form->setFieldsValues($selectedModuleValues);
		$this->moduleName = $modulesData['activeModuleName'];
		$this->moduleContent = $module->renderEditor(['form' => $form]);

		$this->overrideTemplate('editHub');
	}

	public function publishHub() {
		if ($this->request->wasPosted()) {
			$this->retriveDataFromUrl();

			$result = $this->toolboxModel->publish(
				$this->langCode,
				$this->sectionId,
				$this->verticalId,
				$this->date
			);

			$this->success = $result->success;
			if ($this->success) {
				$date = new DateTime('@' . $this->date);

				$this->hubUrl = $this->toolboxModel->getHubUrl($this->langCode, $this->verticalId)
					. '/' . $date->format('Y-m-d');
				$this->successText = wfMsg('marketing-toolbox-module-publish-success', $this->wg->lang->date($this->date));
				if( $this->date == $this->toolboxModel->getLastPublishedTimestamp( $this->langCode, $this->sectionId, $this->verticalId, null, true)) {
					$this->purgeWikiaHomepageHubs();
				}
			} else {
				$this->errorMsg = $result->errorMsg;
			}
		}
	}

	private function getNextModuleUrl() {
		$moduleIds = $this->toolboxModel->getEditableModulesIds();

		$actualModuleIndex = array_search($this->selectedModuleId, $moduleIds);

		if (isset($moduleIds[$actualModuleIndex + 1])) {
			$nextModuleId = $moduleIds[$actualModuleIndex + 1];
		} else {
			$nextModuleId = $moduleIds[$actualModuleIndex];
		}

		$nextUrl = $this->toolboxModel->getModuleUrl(
			$this->langCode,
			$this->sectionId,
			$this->verticalId,
			$this->date,
			$nextModuleId
		);
		return $nextUrl;
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
		$this->prepareFooterData($this->langCode, $this->verticalId, $this->date);
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

	protected  function prepareFooterData($langCode, $verticalId, $timestamp) {
		$this->footerData = array(
			'allModulesSaved' => $this->toolboxModel->checkModulesSaved($langCode, $verticalId, $timestamp)
		);
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
		$this->calendarData = $this->toolboxModel->getCalendarData($langCode, $verticalId, $beginTimestamp, $endTimestamp);
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
		$this->allModulesSaved = $data['allModulesSaved'] ? '' : 'disabled="disabled"' ;
	}

	/**
	 * @desc Used by WMU to get the image url
	 */
	public function getImageDetails() {
		if (!$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed('marketingtoolbox')) {
			$this->specialPage->displayRestrictionError();
			return false;
		}

		wfProfileIn(__METHOD__);

		$fileName = $this->getVal('fileHandler', false);
		if ($fileName) {
			$imageData = ImagesService::getLocalFileThumbUrlAndSizes($fileName, $this->toolboxModel->getThumbnailSize(), ImagesService::EXT_JPG);
			$this->fileUrl = $imageData->url;
			$this->imageWidth = $imageData->width;
			$this->imageHeight = $imageData->height;
			$this->fileTitle = $imageData->title;
		}

		wfProfileOut(__METHOD__);
	}

	public function getVideoDetails() {
		$url = $this->getVal('url');

		$response = $this->sendRequest('VideosController', 'addVideo', array( 'url' => $url ) );

		$error = $response->getVal('error');
		if( $error ) {
			$this->error = $error;
			return;
		}

		$videoInfo = $response->getVal('videoInfo');
		$fileName = $videoInfo[0]->getText();

		$this->videoData = $this->toolboxModel->getVideoData(
			$fileName,
			$this->toolboxModel->getThumbnailSize()
		);
		$this->videoFileName = $fileName;
		$this->videoUrl = $url;
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

	public function sponsoredImage() {
		$this->form = $this->request->getVal('form');
		$this->fieldName = $this->request->getVal('fieldName');
		$this->fileUrl = $this->request->getVal('fileUrl', '');
		$this->imageWidth = $this->request->getVal('imageWidth', '');
		$this->imageHeight = $this->request->getVal('imageHeight', '');
	}

	private function purgeCache($module) {
		$module->purgeMemcache($this->date);
		$this->getHubsServicesHelper()->purgeHubVarnish($this->langCode, $this->verticalId);

		if( $this->selectedModuleId == MarketingToolboxModuleSliderService::MODULE_ID
			&& $this->date == $this->toolboxModel->getLastPublishedTimestamp( $this->langCode, $this->sectionId, $this->verticalId, null )) {
				$this->purgeWikiaHomepageHubs();
		}
	}

	private function purgeWikiaHomepageHubs() {
		WikiaDataAccess::cachePurge( WikiaHubsServicesHelper::getWikiaHomepageHubsMemcacheKey($this->langCode) );
		$this->getHubsServicesHelper()->purgeHomePageVarnish($this->langCode);
	}

	private function getHubsServicesHelper() {
		if(empty($this->hubsServicesHelper)) {
			$this->hubsServicesHelper = new WikiaHubsServicesHelper();
		}
		return $this->hubsServicesHelper;
	}
}
