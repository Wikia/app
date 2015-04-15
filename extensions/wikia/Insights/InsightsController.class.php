<?php

class InsightsController extends WikiaSpecialPageController {
	public $page;

	public function __construct() {
		parent::__construct( 'Insights', 'insights', true );
	}

	public function index() {
		wfProfileIn( __METHOD__ );

		$this->subpage = $this->getPar();
		$this->page = $this->getInsightDataProvider( $this->subpage );
		$this->wg->Out->setPageTitle( wfMessage( 'insights' )->escaped() );

		$this->response->addAsset( '/extensions/wikia/Insights/styles/insights.scss' );

		if ( !empty( $this->subpage ) ) {
			$this->renderSubpage();
		}

		wfProfileOut( __METHOD__ );
	}

	public function renderSubpage() {
		$model = new QueryPagesModel( $this->page, $this->wg->CityId );

		$this->messageKeys = InsightsHelper::$insightsMessageKeys;
		$this->offset = 0;
		$this->list = $model->getList();

		$this->overrideTemplate( 'subpageList' );
	}

	/**
	 * Returns specific data provider
	 *
	 * @param $subpage Insights subpage name
	 * @return mixed
	 */
	public function getInsightDataProvider( $subpage ) {
		if ( empty ( $subpage ) ) {
			return null;
		} elseif ( !empty( $subpage ) && isset( InsightsModel::$insightsPages[$subpage] ) ) {
			return InsightsModel::$insightsPages[$subpage];
		} else {
			$this->response->redirect( $this->specialPage->getTitle()->getFullURL() );
		}
	}
} 
