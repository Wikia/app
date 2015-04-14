<?php

class InsightsController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('Insights', 'insights', true);
	}

	public function index() {
		wfProfileIn(__METHOD__);

		$page = $this->getInsightDataProvider( $this->getPar() );

		$model = new QueryPagesModel( $page, $this->wg->CityId );

		$this->wg->Out->setPageTitle( wfMessage( 'insights' )->escaped() );

		$this->list = $model->getList();
		$this->offset = 0;

		$this->response->addAsset('/extensions/wikia/Insights/styles/insights.scss');

		wfProfileOut(__METHOD__);
	}

	/**
	 * Returns specific data provider
	 *
	 * @param $par
	 * @return mixed
	 */
	public function getInsightDataProvider( $par ) {
		if ( !empty( $par ) && isset( InsightsModel::$insightsPages[$par] ) ) {
			return InsightsModel::$insightsPages[$par];
		} else {
			return array_pop( InsightsModel::$insightsPages );
		}
	}
} 
