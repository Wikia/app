<?php

class AdminUploadReviewSpecialController extends ImageReviewSpecialController {
	const DEFAUL_IMAGE_SIZE = 320;

	public function __construct() {
		WikiaSpecialPageController::__construct('AdminUploadReview', 'adminuploaddirt', false /* $listed */);
	}

	protected function getPageTitle() {
		return 'Admin Upload Review tool';
	}

	public function index() {
		parent::index();
		$this->response->getView()->setTemplate('ImageReviewSpecialController', 'index');
	}

	public function stats() {
		parent::stats();
		$this->response->getView()->setTemplate('ImageReviewSpecialController', 'stats');
	}

	protected function getHelper() {
		return F::build( 'AdminUploadReviewHelper' );
	}

	protected function getBaseUrl() {
		return Title::newFromText('AdminUploadReview', NS_SPECIAL)->getFullURL();
	}

	protected function getToolName() {
		return 'Admin Upload Review';
	}

	protected function getStatsPageTitle() {
		return 'Admin Upload Review tool statistics';
	}

}
