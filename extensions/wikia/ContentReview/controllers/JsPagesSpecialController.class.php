<?php

use Wikia\ContentReview\ContentReviewStatusesService;

class JsPagesSpecialController extends WikiaSpecialPageController {

	function __construct() {
		parent::__construct( 'JsPages', 'content-review-js-pages', true );
	}

	public function init() {
		$this->specialPage->setHeaders();

		Wikia::addAssetsToOutput( 'content_review_module_scss' );
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
		$jsPages = $contentReviewStatusesService->getJsPagesStatuses( $this->wg->CityId );
		$this->jsPages = $this->formatMessages( $jsPages );

		$this->submit = wfMessage( 'content-review-module-submit' )->escaped();
	}

	private function formatMessages( $jsPages ) {
		foreach ( $jsPages as &$jsPage ) {
			$jsPage['latestRevision']['statusMessage'] = $this->formatMessage( $jsPage['latestRevision'] );
			$jsPage['latestReviewed']['statusMessage'] = $this->formatMessage( $jsPage['latestReviewed'] );
			$jsPage['liveRevision']['statusMessage'] = $this->formatMessage( $jsPage['liveRevision'] );
		}

		return $jsPages;
	}

	private function formatMessage( $jsPage ) {
		$statusMessage = '';

		if ( !empty( $jsPage['diffLink'] ) ) {
			$statusMessage .= '<span class="content-review-status content-review-status-' . $jsPage['statusKey'] . '">'
				. $jsPage['diffLink'] . '</span>' . $jsPage['message'];

			if ( !empty( $jsPage['reasonLink'] ) ) {
				$statusMessage .= $jsPage['reasonLink'];
			}
		} else {
			$statusMessage .= '<span class="content-review-status content-review-status-' . $jsPage['statusKey'] . '">'
				. $jsPage['message'] . '</span>';
		}

		return $statusMessage;
	}




}
