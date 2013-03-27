<?php

class WAMPageController extends WikiaController
{
	protected $model;

	public function __construct() {
		parent::__construct( 'WAMPage', '', false );

		$this->model = new WAMPageModel();
	}

	public function init() {
		$this->response->addAsset('wampage_scss');
		$this->response->addAsset('wampage_js');
	}

	public function index() {
		$this->faqPage = !empty($this->app->wg->WAMPageConfig['faqPageName']) ? $this->app->wg->WAMPageConfig['faqPageName'] : '#';

		$lastDay = strtotime('00:00 -1 day');

		$params = [
			'wam_day' => $lastDay,
			'wam_previous_day' => strtotime('-1 day', $lastDay),
			'wiki_lang' => $this->wg->ContLang->getCode(),
			'limit' => $this->model->getVisualizationItemsCount(),
			'sort_column' => 'wam_index',
			'sort_direction' => 'DESC',
		];

		$this->visualizationWikis = $this->app->sendRequest('WAMApi', 'getWAMIndex', $params)->getData();
	}
	
	public function faq() {
		//just for the template now...
	}
}
