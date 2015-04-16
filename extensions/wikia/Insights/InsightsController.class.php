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
	 * Setup method for Insights_LoopNotification.mustache template
	 */
	public function LoopNotification() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->response->setVal( 'notificationMessage', wfMessage( 'insights-notification-message' )->escaped() );
		$this->response->setVal( 'insightsPageButton', wfMessage( 'insights-notification-list-button' )->escaped() );
		$this->response->setVal( 'nextArticleButton', wfMessage( 'insights-notification-next-item-button' )->escaped() );
		// TODO add generate below links
		$this->response->setVal( 'insightsPageLink', '#' );
		$this->response->setVal( 'nextArticleLink', '#' );
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
