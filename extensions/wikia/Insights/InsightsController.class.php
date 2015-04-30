<?php

class InsightsController extends WikiaSpecialPageController {

	const
		FLOW_STATUS_INPROGRESS = 'inprogress',
		FLOW_STATUS_ALLDONE = 'alldone',
		FLOW_STATUS_FIXED = 'fixed',
		FLOW_STATUS_NOTFIXED = 'notfixed';

	private $model;

	public function __construct() {
		parent::__construct( 'Insights', 'insights', true );
	}

	/**
	 * The main, initializing function
	 * @throws MWException
	 */
	public function index() {
		wfProfileIn( __METHOD__ );
		$this->wg->Out->setPageTitle( wfMessage( 'insights' )->escaped() );
		$this->addAssets();

		/**
		 * @var A slug of a subpage
		 */
		$this->subpage = $this->getPar();
		$this->themeClass = SassUtil::isThemeDark() ? 'insights-dark' : 'insights-light';

		/**
		 * Check if a user requested a subpage. If the requested subpage
		 * is unknown redirect them to the landing page.
		 */
		if ( InsightsHelper::isInsightPage( $this->subpage ) ) {
			$this->renderSubpage();
		} elseif ( !empty( $this->subpage ) ) {
			$this->response->redirect( $this->getSpecialInsightsUrl() );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Collects all necessary data used for rendering a subpage
	 * @throws MWException
	 */
	private function renderSubpage() {
		$this->model = InsightsHelper::getInsightModel( $this->subpage );
		/**
		 * A model for insights should implement at least 3 methods:
		 * - getContent() - returning all the visible data
		 * - getData() - returning all the helping data
		 * - getTemplate() - returning an overriding template
		 */
		if ( $this->model instanceof InsightsModel ) {
			$params = $this->request->getParams();
			$this->content = $this->model->getContent( $params );
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
		$subpage = $this->request->getVal( 'insight', null );

		if ( InsightsHelper::isInsightPage( $subpage ) ) {
			$model = InsightsHelper::getInsightModel( $subpage );
			if ( $model instanceof InsightsModel ) {
				$params = [];
				$type = '';
				$isFixed = false;
				$articleName = $this->getVal( 'article', null );
				$title = Title::newFromText( $articleName );

				$isEdit = $this->request->getBool( 'isEdit', false );

				if( !$isEdit ) {
					$isFixed = $model->isItemFixed( $title );
				}

				if ( $isEdit ) {
					$params = $this->getInProgressNotificationParams( $subpage );
					$type = self::FLOW_STATUS_INPROGRESS;
				} elseif ( !$isFixed ) {
					$params = $this->getNotFixedNotificationParams( $subpage, $title, $model );
					$type = self::FLOW_STATUS_NOTFIXED;
				} elseif ( $isFixed && empty( $next ) ) {
					$params = $this->getCongratulationsNotificationParams( $subpage );
					$type = self::FLOW_STATUS_ALLDONE;
				} elseif ( $isFixed ) {
					$params = $this->getInsightFixedNotificationParams( $subpage, $articleName, $model );
					$type = self::FLOW_STATUS_FIXED;
				}

				$html = \MustacheService::getInstance()->render(
					'extensions/wikia/Insights/templates/Insights_loopNotification.mustache',
					$params
				);

				$this->response->setData([
					'html' => $html,
					'isFixed' => $isFixed,
					'notificationType' => $type
				]);
			}
		}
	}

	/**
	 * Get params for notification template shown in edit mode
	 */
	private function getInProgressNotificationParams( $subpage ) {
		$params = $this->getInsightListLinkParams( $subpage );
		$params['notificationMessage'] = wfMessage( InsightsHelper::INSIGHT_INPROGRESS_MSG_PREFIX . $subpage )->plain()
			. wfMessage( 'insights-notification-message-fixit' )->plain();

		return $params;
	}

	/**
	 * Get params for notification template shownwhen user dont fix an issue
	 */
	private function getNotFixedNotificationParams( $subpage, $title, $model ) {
		$params = $this->getInsightFixItParams( $title, $model );
		$params = array_merge( $params, $this->getInsightListLinkParams( $subpage ) );
		$params['notificationMessage'] = wfMessage( InsightsHelper::INSIGHT_INPROGRESS_MSG_PREFIX . $subpage )->plain();

		return $params;
	}

	/**
	 * Get params for notification template shown when user fix all issues in given insight type
	 */
	private function getCongratulationsNotificationParams() {
		$params = $this->getInsightLinkParams();
		$params['notificationMessage'] = wfMessage( 'insights-notification-message-alldone' )->plain();

		return $params;
	}

	/**
	 * Get params for notification template shown when user fix one issue from the insights list
	 *
	 * @param $next Array data about item from insight list
	 * @param $params String params to be added to url
	 */
	private function getInsightFixedNotificationParams( $subpage, $articleName, $model ) {
		$params = $this->getInsightNextLinkParams( $subpage, $articleName, $model );
		$params = array_merge( $params, $this->getInsightListLinkParams( $subpage ));
		$params['notificationMessage'] = wfMessage( InsightsHelper::INSIGHT_FIXED_MSG_PREFIX . $subpage )->plain();

		return $params;
	}

	/**
	 * Get params to generate next item link in notification template
	 *
	 * @param $next Array data about item from insight list
	 * @param $params String params to be added to url
	 */
	private function getInsightNextLinkParams( $subpage, $articleName, $model ) {
		$next = $model->getNextItem( $model->getInsightType(), $articleName );

		return [
			'nextArticleText' => wfMessage( 'insights-notification-next-item-' . $subpage )->plain(),
			'nextArticleTitle' => $next['link']['text'],
			'nextArticleLink' => $next['link']['url']
		];
	}

	/**
	 * Get params to generate link back to edit mode
	 */
	private function getInsightFixItParams( $title, $model ) {
		$link = InsightsHelper::getTitleLink( $title, $model->getUrlParams() );

		return [
			'editPageText' => wfMessage( 'insights-notification-message-fixit' )->plain(),
			'editPageLink' => $link['url']
		];
	}

	/**
	 * Get params to generate link to insight list in notification template
	 */
	private function getInsightListLinkParams( $subpage ) {
		return [
			'insightsPageText' => wfMessage( 'insights-notification-list-button' )->plain(),
			'insightsPageLink' => $this->getSpecialInsightsUrl( $subpage )
		];
	}

	/**
	 * Get params to generate link to insight main page in notification template
	 */
	private function getInsightLinkParams() {
		return [
			'insightsPageText' => wfMessage( 'insights-notification-see-more' )->plain(),
			'insightsPageLink' => $this->getSpecialInsightsUrl()
		];
	}

	private function addAssets() {
		$this->response->addAsset( '/extensions/wikia/Insights/styles/insights.scss' );
		$this->response->addAsset( '/extensions/wikia/Insights/scripts/InsightsPageTracking.js' );
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
