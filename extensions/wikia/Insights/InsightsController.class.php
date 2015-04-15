<?php

class InsightsController extends WikiaSpecialPageController {
	public $page;

	public function __construct() {
		parent::__construct('Insights', 'insights', true);
	}

	public function index() {
		wfProfileIn(__METHOD__);

		$this->par = $this->getPar();
		$this->page = $this->getInsightDataProvider( $this->par );
		$this->wg->Out->setPageTitle( wfMessage( 'insights' )->escaped() );

		$this->response->addAsset('/extensions/wikia/Insights/styles/insights.scss');

		if ( !empty( $this->par ) ) {
			$this->renderSubpage();
		}

		wfProfileOut(__METHOD__);
	}

	public function renderSubpage() {
		$model = new QueryPagesModel( $this->page, $this->wg->CityId );

		$this->messageKeys = InsightsHelper::$insightsMessageKeys;
		$this->list = $model->getList();
		$this->offset = 0;

		$this->overrideTemplate( 'subpageList' );
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
			// redirect
			//$this->response->redirect();
		}
	}
} 
