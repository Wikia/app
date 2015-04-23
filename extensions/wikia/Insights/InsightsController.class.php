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
		$this->themeClass = SassUtil::isThemeDark() ? 'insights-dark' : 'insights-light';

		if ( InsightsHelper::isInsightPage( $this->subpage ) ) {
			$this->renderSubpage();
		} elseif ( !empty( $this->subpage ) ) {
			$this->response->redirect( $this->getSpecialInsightsUrl() );
		}

		wfProfileOut( __METHOD__ );
	}

	private function renderSubpage() {
		$this->model = InsightsHelper::getInsightModel( $this->subpage );
		if ( $this->model instanceof InsightsModel ) {
			$this->content = $this->model->getContent();
			$this->data = $this->model->getData();
			$this->overrideTemplate( $this->model->getTemplate() );
		} else {
			throw new MWException( 'An Insights subpage should implement the InsightsModel interface.' );
		}
	}

	/**
	 * Setup method for Insights_loopNotification.mustache template
	 */
	public function loopNotification() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$subpage = $this->request->getVal( 'insight', null );

		if ( InsightsHelper::isInsightPage( $subpage ) ) {
			$model = InsightsHelper::getInsightModel( $subpage );
			if ( $model instanceof InsightsModel ) {
				$next = $model->getNext();
				$isFixed = $this->request->getVal('isFixed', null);

				if ( $this->request->getBool('isEdit', false ) || $isFixed == 'notfixed' ) {
					$this->setInProgressNotification( $subpage );
				} elseif ( $isFixed == 'fixed' && empty( $next ) ) {
					$this->setCongratulationsNotification( $subpage );
				} elseif ( $isFixed == 'fixed' ) {
					$this->setInsightFixedNotification( $next, $subpage );
				}
			}
		}
	}

	/**
	 * Sets values for notification shown in edit mode or if issue is not fixed
	 */
	private function setInProgressNotification( $subpage ) {
		$this->response->setVal(
			'notificationMessage',
			wfMessage( InsightsHelper::INSIGHT_INPROGRESS_MSG_PREFIX . $subpage )->escaped()
		);
		$this->setInsightListLink( $subpage );
	}

	/**
	 * Sets values for notification shown when user fix all issues in given insight type
	 */
	private function setCongratulationsNotification() {
		$this->response->setVal( 'notificationMessage', wfMessage( 'insights-notification-message-alldone' )->escaped() );
		$this->setInsightLink();
	}

	/**
	 * Sets values for notification shown when user fix one issue from the insights list
	 *
	 * @param $next Array data about item from insight list
	 * @param $params String params to be added to url
	 */
	private function setInsightFixedNotification( $next, $subpage ) {
		$this->response->setVal(
			'notificationMessage',
			wfMessage( InsightsHelper::INSIGHT_FIXED_MSG_PREFIX . $subpage )->escaped()
		);
		$this->setInsightNextLink( $next, $subpage );
		$this->setInsightListLink( $subpage );
	}

	/**
	 * Sets values for next item link in notification
	 *
	 * @param $next Array data about item from insight list
	 * @param $params String params to be added to url
	 */
	private function setInsightNextLink( $next, $subpage ) {
		$this->response->setVal( 'nextArticleButton', wfMessage( 'insights-notification-next-item-' . $subpage )->escaped() );
		$this->response->setVal( 'nextArticleTitle', $next['link']['text'] );
		$this->response->setVal( 'nextArticleLink', $next['link']['url'] );
	}

	/**
	 * Sets values for link to insight list
	 */
	private function setInsightListLink( $subpage ) {
		$this->response->setVal( 'insightsPageButton', wfMessage( 'insights-notification-list-button' )->escaped() );
		$this->response->setVal( 'insightsPageLink', $this->getSpecialInsightsUrl( $subpage ) );
	}

	/**
	 * Sets values for link to insight main page
	 */
	private function setInsightLink() {
		$this->response->setVal( 'insightsPageButton', wfMessage( 'insights-notification-see-more' )->escaped() );
		$this->response->setVal( 'insightsPageLink', $this->getSpecialInsightsUrl() );
	}

	private function addAssets() {
		$this->response->addAsset( '/extensions/wikia/Insights/styles/insights.scss' );
	}

	/**
	 * Get Special:Insights full url
	 *
	 * @return string
	 */
	private function getSpecialInsightsUrl( $subpage = false ) {
		return $this->specialPage->getTitle( $subpage )->getFullURL();
	}
}
