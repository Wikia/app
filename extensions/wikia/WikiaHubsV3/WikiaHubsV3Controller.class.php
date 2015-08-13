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
	 * @var EditHubModel
	 */
	protected $editHubModelModel;

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
		global $wgCityId;

		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$verticalId = $wikiFactoryHub->getVerticalId($wgCityId);

		$currentHub = '';
		$allVerticals = $wikiFactoryHub->getAllVerticals();
		if ( isset( $allVerticals[$verticalId]['short'] ) ) {
			$currentHub = $allVerticals[$verticalId]['short'];
		}
		$this->setVal( 'currentHub', $currentHub );

		if (!$this->checkAccess()) {
			$titleText = $this->getContext()->getTitle()->getText();
			$titleTextSplit = explode('/', $titleText);
			$this->hubUrl = $titleTextSplit[0];
			$this->app->wg->Out->setStatusCode(404);
			$this->overrideTemplate('404');
			return;
		}
		$editHubModel = new EditHubModel();

		$this->modules = array();

		foreach($editHubModel->getModulesIds() as $moduleId) {
			$this->modules[$moduleId] = $this->renderModule(
				$editHubModel,
				$moduleId,
				$editHubModel->getNotTranslatedModuleName($moduleId)
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

	public function getArticleSuggestModal() {
		$templateData = [
			'urlLabel' => wfMessage('wikiahubs-v3-suggest-article-what-article')->text(),
			'reasonLabel' => wfMessage('wikiahubs-v3-suggest-article-reason')->text(),
			'successMessage' => wfMessage('wikiahubs-v3-suggest-article-success')->text()
		];

		$this->setVal( 'html', ( new Wikia\Template\MustacheEngine )
			->setPrefix( dirname( __FILE__ ) . '/templates' )
			->setData( $templateData )
			->render( 'WikiaHubsV3_suggestArticle.mustache' ) );

		$this->setVal( 'title', wfMessage('wikiahubs-v3-suggest-article-header')->escaped() );
		$this->setVal( 'labelSubmit', wfMessage( 'wikiahubs-v3-suggest-article-submit-button' )->escaped() );
		$this->setVal( 'labelCancel', wfMessage( 'wikiahubs-v3-suggest-article-close-button' )->escaped() );
	}

	/**
	 * Check if user has access to see hub page in future date
	 *
	 * @return bool
	 */
	protected function checkAccess() {
		return $this->hubTimestamp !== false
			&& ($this->hubTimestamp <= time()
				|| $this->wg->User->isLoggedIn() && $this->wg->User->isAllowed('edithub')
			);
	}

	/**
	 * Render one module with given data
	 *
	 * @param EditHubModel $editHubModel
	 * @param int $moduleId
	 * @param string  $moduleName
	 *
	 * @return string
	 */
	protected function renderModule( $editHubModel, $moduleId, $moduleName ) {
		$params = $this->getParams();

		$module = WikiaHubsModuleService::getModuleByName(
			$moduleName,
			$this->cityId
		);

		$moduleData = $module->loadData( $editHubModel, $params );
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
	 * @return EditHubModel
	 */
	protected function getEditHubModelModel() {
		if( !$this->editHubModelModel ) {
			$this->editHubModelModel = new EditHubModel($this->app);
		}

		return $this->editHubModelModel;
	}

	protected function initFormat() {
		$this->format = $this->request->getVal('format', 'html');
	}

	protected function initVertical() {
		global $wgCityId;
		$this->verticalId = HubService::getCanonicalCategoryId( WikiFactory::getCategory( $wgCityId )->cat_id );
		$this->cityId = $wgCityId;
		$this->verticalName = $this->getContext()->getTitle()->getText();
		$this->canonicalVerticalName = str_replace(' ', '', $this->model->getCanonicalVerticalNameById($this->cityId));
		$this->wg->out->setPageTitle($this->verticalName);

		// For the main page, overwrite the <title> element with the contents of 'pagetitle-view-mainpage'.
		if ( $this->getContext()->getTitle()->isMainPage() ) {
			$msg = wfMessage( 'pagetitle-view-mainpage' )->inContentLanguage();
			if ( !$msg->isDisabled() ) {
				$this->wg->out->setHTMLTitle( $msg->title( $this->getContext()->getTitle() ) );
			}
		}
	}

	protected function initModel() {
		$this->model = new WikiaHubsModel();
	}

	protected function initHubTimestamp() {
		$this->hubTimestamp = $this->getRequest()->getVal('hubTimestamp');
	}
}
