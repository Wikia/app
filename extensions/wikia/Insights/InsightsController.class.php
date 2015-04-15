<?php

class InsightsController extends WikiaSpecialPageController {
	public $page;

	public function __construct() {
		parent::__construct('Insights', 'insights', true);
	}

	public function index() {
		wfProfileIn(__METHOD__);

		$this->key = $this->getPar();
		$this->page = $this->getInsightDataProvider( $this->key );
		$this->wg->Out->setPageTitle( wfMessage( 'insights' )->escaped() );

		$this->response->addAsset('/extensions/wikia/Insights/styles/insights.scss');

		if ( !empty( $this->key ) ) {
			$this->renderSubpage();
		}

		wfProfileOut(__METHOD__);
	}

	public function renderSubpage() {
		$model = new QueryPagesModel( $this->page, $this->wg->CityId );

		$this->iconUrl = 'https://pbs.twimg.com/profile_images/583867858683166720/netMDLKF.png';
		$this->subtitle = wfMessage( 'insights-list-' . $this->key . '-subtitle' )->parse();
		$this->description = wfMessage( 'insights-list-' . $this->key . '-description' )->parse();
		$this->list = $model->getList();
		$this->offset = 0;

		$this->overrideTemplate( 'subpageList' );
	}

	public function categoryList() {
		$model = new QueryPagesModel( $this->page, $this->wg->CityId );

		$this->list = $model->getList();
		$this->offset = 0;

		$this->overrideTemplate('categoryList');
	}

	/**
	 * Returns specific data provider
	 *
	 * @param $par
	 * @return mixed
	 */
	public function getInsightDataProvider( $par ) {
		if ( empty ( $par ) ) {
			return null;
		} elseif ( !empty( $par ) && isset( InsightsModel::$insightsPages[$par] ) ) {
			return InsightsModel::$insightsPages[$par];
		} else {
			$this->response->redirect( $this->specialPage->getTitle()->getFullURL() );
		}
	}
} 
