<?php

class InsightsController extends WikiaSpecialPageController {
	private $model;

	public function __construct() {
		parent::__construct( 'Insights', 'insights', true );
	}

	public function index() {
		wfProfileIn( __METHOD__ );
		$this->wg->Out->setPageTitle( wfMessage( 'insights' )->escaped() );
		$this->addAssets();

		$this->subpage = $this->getPar();
		if ( !empty( $this->subpage ) ) {
			$this->renderSubpage();
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Render an insight subpage
	 */
	public function renderSubpage() {
		$model = new QueryPagesModel( $this->page, $this->wg->CityId );

		$this->messageKeys = InsightsHelper::$insightsMessageKeys;
		$this->offset = 0;
		$this->list = $model->getList();

		$this->overrideTemplate( 'subpageList' );
	}

	/**
	 * Setup method for Insights_loopNotification.mustache template
	 */
	public function loopNotification() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$subpage = $this->request->getVal( 'insight', null );

		if ( !empty( $subpage ) && InsightsHelper::isInsightPage( $subpage ) ) {
			$page = $this->getInsightDataProvider( $subpage );
			$model = new QueryPagesModel( $page, $this->wg->CityId );
			$next = $model->getNext();

			$this->response->setVal( 'notificationMessage', wfMessage( 'insights-notification-message' )->escaped() );
			$this->response->setVal( 'insightsPageButton', wfMessage( 'insights-notification-list-button' )->escaped() );
			$this->response->setVal( 'nextArticleButton', wfMessage( 'insights-notification-next-item-button' )->escaped() );

			$this->response->setVal( 'insightsPageLink', $this->getSpecialInsightsUrl() );
			$this->response->setVal( 'nextArticleTitle', $next['title'] );
			$this->response->setVal( 'nextArticleLink', $next['link'] . '?action=edit&insights=' . $subpage );
		}
	}

	/**
	 * Returns specific data provider
	 * If it doesn't exists redirect to Special:Insights main page
	 *
	 * @param $subpage Insights subpage name
	 * @return mixed
	 */
	public function getInsightDataProvider( $subpage ) {
		if ( empty ( $subpage ) ) {
			return null;
		} elseif ( !empty( $subpage ) && InsightsHelper::isInsightPage( $subpage ) ) {
			return InsightsModel::$insightsPages[$subpage];
		} else {
			$this->response->redirect( $this->getSpecialInsightsUrl() );
		}
	}

	private function addAssets() {
		$this->response->addAsset( '/extensions/wikia/Insights/styles/insights.scss' );
	}

	public function renderSubpage() {
		switch ( $this->subpage ) {
			case 'uncategorized':
				$this->model = new InsightsUncategorizedModel();
				break;
			case 'withoutimages':
				$this->model = new InsightsWithoutimagesModel();
				break;
			case 'wantedpages':
				$this->model = new InsightsWantedpagesModel();
				break;
			default:
				$this->response->redirect( $this->specialPage->getTitle()->getFullURL() );
		}
		if ( $this->model instanceof InsightsModel ) {
			$this->content = $this->model->getContent();
			$this->data = $this->model->getData();
			$this->overrideTemplate($this->model->getTemplate());
		} else {
			throw new MWException( 'An Insights subpage should implement the InsightsModel interface.' );
		}
	}

	/**
	 * Get Special:Insights full url
	 *
	 * @return string
	 */
	private function getSpecialInsightsUrl() {
		return $this->specialPage->getTitle()->getFullURL();
	}
}
