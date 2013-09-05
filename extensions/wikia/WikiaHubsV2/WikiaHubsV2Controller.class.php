<?php

/**
 * Hubs V2 Controller
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */
class WikiaHubsV2Controller extends WikiaController {
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

		$this->modules = array();

		foreach($toolboxModel->getModulesIds() as $moduleId) {
			$this->modules[$moduleId] = $this->renderModule(
				$toolboxModel,
				$moduleId,
				$toolboxModel->getNotTranslatedModuleName($moduleId)
			);
		}

		$this->response->addAsset('wikiahubs_v2');
		$this->response->addAsset('wikiahubs_v2_modal');
		$this->response->addAsset('wikiahubs_v2_scss');
		$this->response->addAsset('wikiahubs_v2_scss_mobile');
		
		$this->wg->Out->addJsConfigVars([
			'wgWikiaHubsVerticalId' => $this->verticalId
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
	protected function renderModule( $toolboxModel, $moduleId, $moduleName ) {
		$params = $this->getParams();

		$module = MarketingToolboxModuleService::getModuleByName(
			$moduleName,
			$this->wg->ContLang->getCode(),
			MarketingToolboxModel::SECTION_HUBS,
			$this->verticalId
		);

		$moduleData = $module->loadData( $toolboxModel, $params );

		if (!empty($moduleData)) {
			return $module->render( $moduleData );
		} else {
			Wikia::log(
				__METHOD__,
				'',
				'no module data for day: ' . $this->wg->lang->date($this->hubTimestamp)
					. ', lang: ' . $this->wg->ContLang->getCode()
					. ', vertical: ' . $this->verticalId
					. ', moduleId: ' . $moduleId
			);
			return null;
		}
	}

	protected function getParams() {
		return [
			'ts' => $this->hubTimestamp
		];
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
		$this->model = new WikiaHubsV2Model();
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
		OasisController::addBodyClass('WikiaHubs' . mb_ereg_replace(' ', '', $this->canonicalVerticalName));
	}

	protected function initHubTimestamp() {
		$this->hubTimestamp = $this->getRequest()->getVal('hubTimestamp');
	}
}
