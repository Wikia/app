<?php

use Wikia\ContentReview\ContentReviewStatusesService;

class JsPagesSpecialController extends WikiaSpecialPageController {

	function __construct() {
		parent::__construct( 'JsPages', 'content-review-js-pages', true );
	}

	public function init() {
		$this->specialPage->setHeaders();

		\JSMessages::enqueuePackage( 'JsPagesSpecialPage', \JSMessages::EXTERNAL );
	}

	protected function checkAccess() {
		if( !$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed( 'content-review' ) ) {
			return false;
		}
		return true;
	}

	public function index() {
		$this->specialPage->setHeaders();

		if( !$this->checkAccess() ) {
			$this->displayRestrictionError();
			return false;
		}

		$this->getOutput()->setPageTitle( wfMessage( 'content-review-special-js-pages-title' )->plain() );

		$contentReviewStatusesService = new ContentReviewStatusesService();
		$this->jsPages = $contentReviewStatusesService->getJsPagesStatuses( $this->wg->CityId );
	}


}
