<?php

/**
 * Hubs V2 Controller
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */
class SpecialWikiaHubsV2Controller extends WikiaSpecialPageController {
	const CACHE_VALIDITY_BROWSER = 86400;
	const CACHE_VALIDITY_VARNISH = 86400;

	/**
	 * @var WikiaHubsV2Model
	 */
	protected $model;
	
	/**
	 * @var MarketingToolboxModel
	 */
	protected $marketingToolboxModel;

	protected $format;
	protected $verticalId;
	protected $verticalName;

	public function __construct() {
		parent::__construct('WikiaHubsV2', '', false);
	}

	/**
	 * Main method for displaying hub pages
	 */
	public function index() {
		if (!$this->checkAccess()) {
			$titleText = $this->getContext()->getTitle()->getText();
			$titleTextSplit = explode('/', $titleText);
			$this->hubUrl = $titleTextSplit[0];
			$this->app->wg->Out->setStatusCode(404);
			$this->overrideTemplate('404');
			return;
		}

		$toolboxModel = new MarketingToolboxModel();
		$modulesData = $toolboxModel->getPublishedData(
			$this->wg->ContLang->getCode(),
			MarketingToolboxModel::SECTION_HUBS,
			$this->verticalId,
			$this->hubTimestamp
		);

		$this->modules = array();

		$enabledModules = array(
			MarketingToolboxModuleExploreService::MODULE_ID,
			MarketingToolboxModulePollsService::MODULE_ID,
			MarketingToolboxModuleWikiaspicksService::MODULE_ID,
			MarketingToolboxModuleSliderService::MODULE_ID,
			MarketingToolboxModulePopularvideosService::MODULE_ID,
			MarketingToolboxModuleFeaturedvideoService::MODULE_ID,
			MarketingToolboxModuleWAMService::MODULE_ID
		);

		foreach ($toolboxModel->getEditableModulesIds() as $moduleId) {
			// TODO remove this if when other modules would be ready
			if (in_array($moduleId, $enabledModules)) {
				if (!empty($modulesData[$moduleId]['data'])) {
					$this->modules[$moduleId] = $this->renderModule(
						$this->wg->ContLang->getCode(),
						$this->verticalId,
						$toolboxModel->getNotTranslatedModuleName($moduleId),
						$modulesData[$moduleId]['data']
					);
				} else {
					// TODO think about it what should we render if we don't have data
					$this->modules[$moduleId] = $toolboxModel->getNotTranslatedModuleName($moduleId) . ' <-- no data';
				}
			}
		}

		foreach ($toolboxModel->getNonEditableModulesIds() as $moduleId) {
			$this->modules[$moduleId] = $this->renderModule(
				$this->wg->ContLang->getCode(),
				$this->verticalId,
				$toolboxModel->getNotTranslatedModuleName($moduleId),
				null
			);
		}

		$this->response->addAsset('wikiahubs_v2');
		$this->response->addAsset('wikiahubs_v2_modal');
		$this->response->addAsset('wikiahubs_v2_scss');
		$this->response->addAsset('wikiahubs_v2_scss_mobile');
		
		//TODO: remove after releasing WikiaHubsV2 and removing WikiaHubs extension
		$this->wg->Out->addJsConfigVars([
			'isWikiaHubsV2Page' => true,
		]);

		if (F::app()->checkSkin('wikiamobile')) {
			$this->overrideTemplate('wikiamobileindex');
		}
	}

	/**
	 * Check if user has access to see hub page in future date
	 *
	 * @return bool
	 */
	protected function checkAccess() {
		return $this->hubTimestamp !== false
			&& ($this->hubTimestamp <= time()
				|| $this->wg->User->isLoggedIn() && $this->wg->User->isAllowed('marketingtoolbox')
			);
	}

	/**
	 * Render one module with given data
	 *
	 * @param string $langCode
	 * @param int    $verticalId
	 * @param string $moduleName
	 * @param array  $moduleData
	 *
	 * @return string
	 */
	protected function renderModule($langCode, $verticalId, $moduleName, $moduleData) {
		$module = MarketingToolboxModuleService::getModuleByName(
			$moduleName,
			$langCode,
			MarketingToolboxModel::SECTION_HUBS,
			$verticalId
		);

		if( $module instanceof MarketingToolboxModuleNonEditableService ) {
			$moduleData = $module->loadData($this->getMarketingToolboxModel(), $module->prepareParameters([
				'lang' => $langCode,
				'vertical_id' => $verticalId,
				'ts' => $this->hubTimestamp,
			]));
		} else {
			$moduleData = $module->getStructuredData($moduleData);
		}

		return $module->render($moduleData);
	}

	public function fromthecommunity() {
		$fromTheCommunityData = $this->model->getDataForModuleFromTheCommunity();
		$this->headline = $fromTheCommunityData['headline'];
		$this->entries = $fromTheCommunityData['entries'];
	}

	public function init() {
		parent::init();
		$this->initCacheValidityTimes();
		$this->initFormat();
		$this->initModel();
		$this->initVertical();
		$this->initVerticalSettings();
		$this->initHubTimestamp();
	}

	protected function initCacheValidityTimes() {
		$this->response->setCacheValidity(
			self::CACHE_VALIDITY_BROWSER,
			self::CACHE_VALIDITY_VARNISH,
			array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH)
		);
	}

	/**
	 * @return WikiaHubsV2Model
	 */
	protected function getModel() {
		if (!$this->model) {
			$this->initModel();
		}
		return $this->model;
	}

	/**
	 * @return MarketingToolboxModel
	 */
	protected function getMarketingToolboxModel() {
		if( !$this->marketingToolboxModel ) {
			$this->marketingToolboxModel = new MarketingToolboxModel($this->app);
		}
		
		return $this->marketingToolboxModel;
	}

	protected function initFormat() {
		$this->format = $this->request->getVal('format', 'html');
	}

	protected function initVertical() {
		$this->verticalId = $this->getRequest()->getVal('verticalid', WikiFactoryHub::CATEGORY_ID_GAMING);
		$this->verticalName = $this->model->getVerticalName($this->verticalId);
		$this->canonicalVerticalName = $this->model->getCanonicalVerticalName($this->verticalId);
	}

	protected function initModel() {
		$this->model = F::build('WikiaHubsV2Model');
		$date = $this->getRequest()->getVal('date', date('Y-m-d'));
		$lang = $this->getRequest()->getVal('cityId', $this->wg->cityId);
		$this->model->setDate($date);
		$this->model->setLang($lang);
		$this->model->setVertical($this->verticalId);
	}

	/**
	 * @desc Sets hubs specific settings: page title, hub type, vertical body class
	 */
	protected function initVerticalSettings() {
		$this->wg->out->setPageTitle($this->verticalName);
		if ($this->format != 'json') {
			$this->wgWikiaHubType = $this->verticalName;
		}
		RequestContext::getMain()->getRequest()->setVal('vertical', $this->verticalName);
		RequestContext::getMain()->getRequest()->setVal('verticalid', $this->verticalId);
		OasisController::addBodyClass('WikiaHubs' . mb_ereg_replace(' ', '', $this->canonicalVerticalName));
	}

	protected function initHubTimestamp() {
		$this->hubTimestamp = $this->getRequest()->getVal('hubTimestamp');
	}
}
