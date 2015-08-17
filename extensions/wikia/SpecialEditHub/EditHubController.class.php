<?php

class EditHubController extends WikiaSpecialPageController {
	/**
	 * @var EditHubModel $editHubModel
	 */
	protected $editHubModel;
	/**
	 * @var WikiaHubsServicesHelper
	 */
	private $hubsServicesHelper;

	public function __construct() {
		parent::__construct('EditHub', 'edithub', true);
	}

	public function isRestricted() {
		return true;
	}

	public function init() {
		$this->editHubModel = new EditHubModel();
	}

	/**
	 * Check access to this page
	 */
	protected function checkAccess() {
		wfProfileIn(__METHOD__);

		if (!$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed('edithub')) {
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

		$this->wg->Out->setPageTitle(wfMessage('edit-hub-title')->text());

		if ($this->checkAccess()) {
			$this->wg->SuppressSpotlights = true;
			$this->wg->SuppressWikiHeader = true;
			$this->wg->SuppressPageHeader = true;
			$this->wg->SuppressFooter = true;
			$this->response->addAsset('/extensions/wikia/SpecialEditHub/css/EditHub.scss');
			$this->response->addAsset('/skins/oasis/css/modules/CorporateDatepicker.scss');

			$action = $this->getRequestedAction();

			JSMessages::enqueuePackage('EditHub', JSMessages::EXTERNAL);

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
	 * Here curator can select date
	 */
	public function dashboardAction() {
		if (!$this->checkAccess()) {
			return false;
		}

		$this->response->addAsset('/extensions/wikia/SpecialEditHub/css/EditHub_Dashboard.scss');
		$this->response->addAsset('/extensions/wikia/SpecialEditHub/js/EditHubDashboard.js');
		$this->response->addAsset('/extensions/wikia/SpecialEditHub/js/DatepickerModel.js');

		$this->overrideTemplate('dashboard');
	}

	protected function checkDate($date) {
		global $wgCityId;

		$datetime = new DateTime('@' . $date);
		if ($datetime->format('H') != 0 || $datetime->format('i') != 0 || $datetime->format('s') != 0) {
			$datetime->setTime(0, 0, 0);
			$url = $this->editHubModel->getModuleUrl(
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
		global $wgCityId;

		if (!$this->checkAccess()) {
			return false;
		}

		$this->retriveDataFromUrl();

		$this->wg->Out->addJsConfigVars([
			'wgEditHubModuleIdSelected' => $this->selectedModuleId,
			'wgEditHubModuleIdPopularVideos' => WikiaHubsModulePopularvideosService::MODULE_ID,
			'wgEditHubModuleIdFeaturedVideo' => WikiaHubsModuleFeaturedvideoService::MODULE_ID
		]);

		$this->checkDate($this->date);

		$this->flashMessage = FlashMessages::pop();

		$modulesData = $this->editHubModel->getModulesData(
			$wgCityId,
			$this->date,
			$this->selectedModuleId
		);

		$this->prepareLayoutData($this->selectedModuleId, $modulesData);

		$this->response->addAsset('resources/jquery/jquery.validate.js');
		$this->response->addAsset('/extensions/wikia/SpecialEditHub/js/EditHub.js');
		$this->response->addAsset('/extensions/wikia/SpecialEditHub/js/EditHubNavigation.js');
		$this->response->addAsset('/extensions/wikia/SpecialEditHub/js/jquery.MetaData.js');

		$selectedModuleValues = $modulesData['moduleList'][$this->selectedModuleId]['data'];

		$module = WikiaHubsModuleService::getModuleByName(
			$this->editHubModel->getNotTranslatedModuleName($this->selectedModuleId),
			$wgCityId
		);

		$form = new FormBuilderService(EditHubModel::FORM_FIELD_PREFIX);
		$form->setFields($module->getFormFields());

		if ($this->request->wasPosted()) {
			$selectedModuleValues = $this->request->getParams();
			$selectedModuleValues = $module->filterData($selectedModuleValues);

			$isValid = $form->validate($selectedModuleValues);
			if ($isValid) {
				$this->editHubModel->saveModule(
					[
						// TODO remove lang and vertical after HubsV2 removal
						'cityId' => $wgCityId,
						'langCode' => $this->wg->ContLang->getCode(),
						'verticalId' => WikiFactoryHub::getInstance()->getCategoryId($wgCityId)
					],
					$this->date,
					$this->selectedModuleId,
					$selectedModuleValues,
					$this->wg->user->getId()
				);

				$this->purgeCache( $module );

				FlashMessages::put(wfMessage('edit-hub-module-save-ok', $modulesData['activeModuleName'])->escaped());

				$nextUrl = $this->getNextModuleUrl();
				$this->response->redirect($nextUrl);
			} else {
				$this->errorMessage = wfMessage('edit-hub-module-save-error')->escaped();
			}
		}
		$form->setFieldsValues($selectedModuleValues);
		$this->moduleName = $modulesData['activeModuleName'];
		$this->moduleContent = $module->renderEditor(['form' => $form]);

		$this->overrideTemplate('editHub');
	}

	public function publishHub() {
		global $wgCityId, $wgDisableWAMOnHubs;

		if (!$this->checkAccess()) {
			return false;
		}

		if ($this->request->wasPosted()) {
			$this->retriveDataFromUrl();

			$result = $this->editHubModel->publish(
				$wgCityId,
				$this->date
			);

			$this->success = $result->success;
			if ($this->success) {
				$date = new DateTime('@' . $this->date);

				$this->hubUrl = Title::newMainPage()->getFullURL() . '/' . $date->format('Y-m-d');
				$this->successText = wfMessage('edit-hub-module-publish-success', $this->wg->lang->date($this->date))->escaped();

				if ( !$wgDisableWAMOnHubs // disable for Corporate/WAM Hybrids
					&& ($this->date == $this->editHubModel->getLastPublishedTimestamp( $wgCityId, null, true ) ) ) {
					$this->purgeWikiaHomepageHubs();
				}
			} else {
				$this->errorMsg = $result->errorMsg;
			}
		}
	}

	private function getNextModuleUrl() {
		global $wgCityId;

		$moduleIds = $this->editHubModel->getEditableModulesIds();

		$actualModuleIndex = array_search($this->selectedModuleId, $moduleIds);

		if (isset($moduleIds[$actualModuleIndex + 1])) {
			$nextModuleId = $moduleIds[$actualModuleIndex + 1];
		} else {
			$nextModuleId = $moduleIds[$actualModuleIndex];
		}

		$nextUrl = $this->editHubModel->getModuleUrl(
			$this->date,
			$nextModuleId
		);
		return $nextUrl;
	}

	protected function retriveDataFromUrl() {
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
		$this->prepareFooterData($this->date);
	}

	/**
	 * Prepare data for header
	 */
	protected function prepareHeaderData($modulesData, $date) {
		global $wgCityId;

		$this->headerData = array(
			'date' => $date,
			'moduleName' => $modulesData['activeModuleName'],
			'lastEditor' => $modulesData['lastEditor'],
			'lastEditTime' => $modulesData['lastEditTime'],
			'hubName' => WikiFactory::getWikiByID($wgCityId)->city_title,
			'hubLang' => $this->wg->Lang->getLanguageName($this->wg->ContLang->getCode())
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

	protected  function prepareFooterData($timestamp) {
		global $wgCityId;

		$this->footerData = array(
			'allModulesSaved' => $this->editHubModel->checkModulesSaved($wgCityId, $timestamp)
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
		global $wgCityId;

		$beginTimestamp = $this->getVal('beginTimestamp', time());
		$endTimestamp = $this->getVal('endTimestamp', time());
		$this->calendarData = $this->editHubModel->getCalendarData($wgCityId, $beginTimestamp, $endTimestamp);
	}


	/**
	 * Render header module
	 */
	public function executeHeader($data) {
		$this->response->addAsset('/extensions/wikia/SpecialEditHub/css/EditHub_Header.scss');

		$optionalDataKeys = array('date', 'moduleName', 'hubName', 'hubLang', 'lastEditor', 'lastEditTime');

		foreach ($optionalDataKeys as $key) {
			if (isset($data[$key])) {
				$this->$key = $data[$key];
			}
		}

		$this->dashboardHref = SpecialPage::getTitleFor('EditHub')->getLocalURL();
	}

	/**
	 * Render footer module
	 */
	public function executeFooter($data) {
		$this->response->addAsset('/extensions/wikia/SpecialEditHub/css/EditHub_Footer.scss');
		$this->allModulesSaved = $data['allModulesSaved'] ? '' : 'disabled="disabled"' ;
	}

	/**
	 * @desc Used by WMU to get the image url
	 */
	public function getImageDetails() {
		if (!$this->checkAccess()) {
			return false;
		}

		wfProfileIn(__METHOD__);

		$fileName = $this->getVal('fileHandler', false);
		if ($fileName) {
			$imageData = ImagesService::getLocalFileThumbUrlAndSizes($fileName, $this->editHubModel->getThumbnailSize(), ImagesService::EXT_JPG);
			$this->fileUrl = $imageData->url;
			$this->imageWidth = $imageData->width;
			$this->imageHeight = $imageData->height;
			$this->fileTitle = $imageData->title;
		}

		wfProfileOut(__METHOD__);
	}

	public function uploadAndGetVideo() {
		if (!$this->checkAccess()) {
			return false;
		}

		$url = $this->getVal('url');

		$response = $this->sendRequest('VideosController', 'addVideo', array( 'url' => $url ) );

		$error = $response->getVal('error');
		if( $error ) {
			$this->error = $error;
			return;
		}

		$videoInfo = $response->getVal('videoInfo');
		$fileName = $videoInfo[0]->getText();

		$this->videoData = $this->editHubModel->getVideoData(
			$fileName,
			$this->editHubModel->getThumbnailSize()
		);
		$this->videoFileName = $fileName;
		$this->videoUrl = $url;
	}

	/**
	 * @param $module WikiaHubsModuleService
	 */
	private function purgeCache($module) {
		global $wgCityId, $wgDisableWAMOnHubs;

		$module->purgeMemcache($this->date);
		$this->getHubsServicesHelper()->purgeHubV3Varnish($wgCityId);

		if( !$wgDisableWAMOnHubs // disable for Corporate/WAM Hybrids
			&& $this->selectedModuleId == WikiaHubsModuleSliderService::MODULE_ID
			&& ( $this->date == $this->editHubModel->getLastPublishedTimestamp( $wgCityId, null ) ) ) {
				$this->purgeWikiaHomepageHubs();
		}
	}

	private function purgeWikiaHomepageHubs() {
		$lang = $this->wg->ContLang->getCode();
		WikiaDataAccess::cachePurge( WikiaHomePageHelper::getHubSlotsMemcacheKey($lang) );
		$this->getHubsServicesHelper()->purgeHomePageVarnish($lang);
	}

	private function getHubsServicesHelper() {
		if(empty($this->hubsServicesHelper)) {
			$this->hubsServicesHelper = new WikiaHubsServicesHelper();
		}
		return $this->hubsServicesHelper;
	}
}
