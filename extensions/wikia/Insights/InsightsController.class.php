<?php

class InsightsController extends WikiaSpecialPageController {
	public $page;

	public function __construct() {
		parent::__construct('Insights', 'insights', true);
	}

	public function index() {
		wfProfileIn(__METHOD__);

		$this->page = $this->getInsightDataProvider( $this->getPar() );
		$this->wg->Out->setPageTitle( wfMessage( 'insights' )->escaped() );

		$this->response->addAsset('/extensions/wikia/Insights/styles/insights.scss');

		if ( !empty( $this->page ) ) {
			$this->categoryList();
		}

		wfProfileOut(__METHOD__);
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
