<?php

class InsightsLoopController extends WikiaController {
	const
		FLOW_STATUS_INPROGRESS = 'inprogress',
		FLOW_STATUS_ALLDONE = 'alldone',
		FLOW_STATUS_FIXED = 'fixed',
		FLOW_STATUS_NOTFIXED = 'notfixed';

	/**
	 * Setup method for Insights_loopNotification.mustache template
	 */
	public function loopNotification() {
		$subpage = $this->request->getVal( 'insight', null );
		if ( InsightsHelper::isInsightPage( $subpage ) ) {
			$model = InsightsHelper::getInsightModel( $subpage );
			if ( $model->getConfig()->displayFixItMessage() ) {
				if ( $model instanceof InsightsQueryPageModel ) {
					$params = [ ];
					$type = '';
					$isFixed = false;
					$articleName = $this->getVal( 'article', null );
					$title = Title::newFromText( $articleName );
					$next = $model->getNextItem( $model->getConfig()->getInsightType(), $articleName );

					$isEdit = $this->request->getBool( 'isEdit', false );

					if ( !$isEdit ) {
						$isFixed = $model->isItemFixed( $title );
						if ( $isFixed ) {
							( new InsightsCache( $model->getConfig() ) )->updateInsightsCache( $title->getArticleId() );
						}
					}

					if ( $isEdit ) {
						$params = $this->getInProgressNotificationParams( $subpage, $model );
						$type = self::FLOW_STATUS_INPROGRESS;
					} elseif ( !$isFixed ) {
						$params = $this->getNotFixedNotificationParams( $subpage, $title, $model );
						$type = self::FLOW_STATUS_NOTFIXED;
					} elseif ( $isFixed && empty( $next ) ) {
						$params = $this->getCongratulationsNotificationParams();
						$type = self::FLOW_STATUS_ALLDONE;
					} elseif ( $isFixed ) {
						$params = $this->getInsightFixedNotificationParams( $subpage, $next );
						$type = self::FLOW_STATUS_FIXED;
					}

					$this->setMustacheParams( $params, $isFixed, $type );

				} elseif ( $model instanceof InsightsPageModel ) {
					$isFixed = false;
					$isEdit = $this->request->getBool( 'isEdit', false );
					/* Show in progress notification when in view mode of article */
					if ( !$isEdit ) {
						$params = $model->getInProgressNotificationParams();
						if ( is_array( $params ) ) {
							$type = self::FLOW_STATUS_NOTFIXED;
							$this->setMustacheParams( $params, $isFixed, $type );
						}
					}
				}
			}
		}
	}

	/**
	 *  Set mustache template
	 * @param Array $params
	 * @param bool $isFixed
	 * @param String $type
	 */
	private function setMustacheParams( $params, $isFixed, $type ) {
		$html = MustacheService::getInstance()->render(
			'extensions/wikia/InsightsV2/templates/Insights_loopNotification.mustache',
			$params
		);

		$this->response->setData([
			'html' => $html,
			'isFixed' => $isFixed,
			'notificationType' => $type
		]);
	}


	/**
	 * Get params for notification template shown in edit mode
	 *
	 * @param string $subpage Insights subpage
	 * @param InsightsQueryPageModel $model
	 * @return array
	 */
	private function getInProgressNotificationParams( $subpage, InsightsQueryPageModel $model ) {
		$params = $this->getInsightListLinkParams( $subpage );
		$params['notificationMessage'] = wfMessage( InsightsHelper::INSIGHT_INPROGRESS_MSG_PREFIX . $subpage )->plain();

		if ( $model->getConfig()->displayFixItMessage() ) {
			$params['fixItMessage'] = wfMessage( 'insights-notification-message-fixit' )->plain();
		}

		return $params;
	}

	/**
	 * Get params for notification template shownwhen user dont fix an issue
	 *
	 * @param string $subpage Insights subpage
	 * @param Title $title
	 * @param InsightsQueryPageModel $model
	 * @return array
	 */
	private function getNotFixedNotificationParams( $subpage, Title $title, InsightsQueryPageModel $model ) {
		$params = $this->getInsightListLinkParams( $subpage );

		if ( $model->getConfig()->displayFixItMessage() ) {
			$params = array_merge( $params, $this->getInsightFixItParams( $title, $model ) );
		}

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
	 * @param string $subpage Insights subpage
	 * @param array $next An array with a url and text for a link to the next item
	 * @return array
	 */
	private function getInsightFixedNotificationParams( $subpage, $next ) {
		$params = $this->getInsightNextLinkParams( $subpage, $next );
		$params = array_merge( $params, $this->getInsightListLinkParams( $subpage ));
		$params['notificationMessage'] = wfMessage( InsightsHelper::INSIGHT_FIXED_MSG_PREFIX . $subpage )->plain();

		return $params;
	}

	/**
	 * Get params to generate next item link in notification template
	 *
	 * @param String $subpage Insights subpage
	 * @param array $next An array with a url and text for a link to the next item
	 * @return array
	 */
	private function getInsightNextLinkParams( $subpage, $next ) {
		return [
			'nextArticleText' => wfMessage( InsightsHelper::INSIGHT_NEXT_MSG_PREFIX . $subpage )->plain(),
			'nextArticleTitle' => $next['link']['text'],
			'nextArticleLink' => $next['link']['url']
		];
	}

	/**
	 * Get params to generate link back to edit mode
	 *
	 * @param Title $title
	 * @param InsightsQueryPageModel $model
	 * @return array
	 */
	private function getInsightFixItParams( Title $title, InsightsQueryPageModel $model ) {
		$link = InsightsHelper::getTitleLink( $title, $model->getUrlParams() );

		return [
			'editPageText' => wfMessage( 'insights-notification-message-fixit' )->plain(),
			'editPageLink' => $link['url']
		];
	}

	/**
	 * Get params to generate link to insight main page in notification template
	 */
	private function getInsightLinkParams() {
		return [
			'insightsPageText' => wfMessage( 'insights-notification-see-more' )->plain(),
			'insightsPageLink' => SpecialPage::getTitleFor( 'Insights' )->getFullURL()
		];
	}

	/**
	 * Get params to generate link to insight list in notification template
	 *
	 * @param String $subpage Insights subpage
	 * @return array
	 */
	public function getInsightListLinkParams( $subpage ) {
		return [
			'insightsPageText' => wfMessage( 'insights-notification-list-button' )->plain(),
			'insightsPageLink' => InsightsHelper::getSubpageLocalUrl( $subpage )
		];
	}
}
