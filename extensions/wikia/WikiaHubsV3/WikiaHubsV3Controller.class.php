<?php

/**
 * Hubs V3 Controller
 *
 * @author Bartosz "V" Bentkowski
 * @author Damian Jóźwiak
 * @author Łukasz Konieczny
 * @author Sebastian Marzjan
 *
 */
class WikiaHubsV3Controller extends WikiaController {
	const CACHE_VALIDITY_BROWSER = 86400;
	const CACHE_VALIDITY_VARNISH = 86400;

	const HUBS_VERSION = 3;

	/**
	 * @var WikiaHubsModel
	 */
	protected $model;
	
	/**
	 * @var MarketingToolboxModel
	 */
	protected $marketingToolboxModel;

	protected $format;
	protected $verticalId;
	protected $cityId;

	public function __construct() {
		parent::__construct('WikiaHubsV3', '', false);
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
		$toolboxModel = new MarketingToolboxV3Model();

		$this->modules = array();

		foreach($toolboxModel->getModulesIds() as $moduleId) {
			$this->modules[$moduleId] = $this->renderModule(
				$toolboxModel,
				$moduleId,
				$toolboxModel->getNotTranslatedModuleName($moduleId)
			);
		}

		$this->response->addAsset('wikiahubs_v3');
		$this->response->addAsset('wikiahubs_v3_modal');
		$this->response->addAsset('wikiahubs_v3_scss');
		$this->response->addAsset('wikiahubs_v3_scss_mobile');
		
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
	 * @param MarketingToolboxV3Model $toolboxModel
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
			MarketingToolboxV3Model::SECTION_HUBS,
			$this->verticalId,
			$this->cityId,
			self::HUBS_VERSION
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
		$this->initHubTimestamp();
	}

	protected function initCacheValidityTimes() {
		$this->response->setCacheValidity(self::CACHE_VALIDITY_VARNISH, self::CACHE_VALIDITY_BROWSER);
	}

	/**
	 * @return WikiaHubsModel
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
			$this->marketingToolboxModel = new MarketingToolboxV3Model($this->app);
		}
		
		return $this->marketingToolboxModel;
	}

	protected function initFormat() {
		$this->format = $this->request->getVal('format', 'html');
	}

	protected function initVertical() {
		global $wgCityId;
		$this->verticalId = HubService::getCanonicalCategoryId($wgCityId);
		$this->cityId = $wgCityId;
		$this->verticalName = $this->getContext()->getTitle()->getText();
		$this->canonicalVerticalName = str_replace(' ', '', $this->model->getCanonicalVerticalNameById($this->cityId));
		$this->wg->out->setPageTitle($this->verticalName);
	}

	protected function initModel() {
		$this->model = new WikiaHubsModel();
	}


	protected function initHubTimestamp() {
		$this->hubTimestamp = $this->getRequest()->getVal('hubTimestamp');
	}
}
