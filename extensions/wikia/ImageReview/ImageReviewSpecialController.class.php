<?php

use \Wikia\Logger\WikiaLogger;

class ImageReviewSpecialController extends WikiaSpecialPageController {
	public function index() {

		$this->getHelper();

		$this->helper->getUserTsKey();
		$this->helper->refetchImageListByTimestamp( $this->ts );
		ImageReviewHelper::LIMIT_IMAGES ) {
		$this->logImageListCompleteness( 'warning' );
		ImageReviewStatuses
		$this->helper->getImageList( $this->ts, $do[ $this->action ], $this->order );
		$this->helper->getImageCount();
		$this->setVariables();

	}

	public function stats() {
		$helper = $this->getHelper();

		$stats = $helper->getStatsData( $startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay );
	}

	public function csvStats() {
		$helper = $this->getHelper();

		$stats = $helper->getStatsData( $startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay );
	}

	protected function getPageTitle() {
		return 'Image Review tool';
	}

	protected function getHelper() {
		return new ImageReviewHelper();
	}

	protected function getBaseUrl() {
		return Title::newFromText('ImageReview', NS_SPECIAL)->getFullURL();
	}

	protected function getToolName() {
		return 'Image Review';
	}

	protected function getStatsPageTitle() {
		return 'Image Review tool statistics';
	}

	private function setVariables() {
		$query = ( empty( $this->action ) ) ? '' : '/'. $this->action;

		$this->response->setJsVar('wgImageReviewAction', $this->action);

		$this->response->setVal( 'action', $this->action );
		$this->response->setVal( 'order', $this->order );
		$this->response->setVal( 'imageList', $this->imageList );
		$this->response->setVal( 'imageCount', $this->imageCount );

		$this->response->setVal( 'accessQuestionable', $this->accessQuestionable );
		$this->response->setVal( 'accessStats', $this->wg->User->isAllowed( 'imagereviewstats' ) );
		$this->response->setVal( 'accessControls', $this->wg->user->isAllowed( 'imagereviewcontrols' ) );
		$this->response->setVal( 'modeMsgSuffix', empty( $this->action ) ? '' : '-' . $this->action );
		$this->response->setVal( 'order', $this->order );
		$this->response->setVal( 'fullUrl', $this->wg->Title->getFullUrl() );
		$this->response->setVal( 'baseUrl', $this->getBaseUrl() );
		$this->response->setVal( 'toolName', $this->getToolName() );
		$this->response->setVal( 'submitUrl' ,$this->baseUrl . $query );
	}

	private function logImageListCompleteness( $severity ) {
		WikiaLogger::instance()->debug(
			'SUS-541',
			[
				'severity' => $severity,
				'imageList' => $this->imageList,
				'exception' => new Exception
			]
		);
	}


}
