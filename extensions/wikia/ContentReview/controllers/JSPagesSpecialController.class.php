<?php

use Wikia\ContentReview\ContentReviewStatusesService;
use Wikia\ContentReview\Helper;

class JSPagesSpecialController extends WikiaSpecialPageController {

	private static $topJsPages = [
		'Wikia.js', 'Common.js'
	];

	function __construct() {
		parent::__construct( 'JSPages', 'content-review-js-pages', true );
	}

	public function init() {
		$this->specialPage->setHeaders();

		\Wikia::addAssetsToOutput( 'content_review_module_scss' );
		\Wikia::addAssetsToOutput( 'content_review_module_js' );
		\Wikia::addAssetsToOutput( 'content_review_test_mode_js' );
		\JSMessages::enqueuePackage( 'JSPagesSpecialPage', \JSMessages::EXTERNAL );
	}

	protected function checkAccess() {
		if( !$this->wg->User->isLoggedIn() ) {
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
		$this->jsPages = $this->preparePages( $jsPages );

		$this->submit = wfMessage( 'content-review-module-submit' )->escaped();
		$this->isTestModeEnabled = ( new Helper() )->isContentReviewTestModeEnabled();
	}

	private function preparePages( $jsPages ) {
		$pagesOnTop = [];

		foreach ( $jsPages as $pageId => &$jsPage ) {
			$jsPage['latestRevision']['statusMessage'] = $this->formatMessage( $jsPage['latestRevision'] );
			$jsPage['latestReviewed']['statusMessage'] = $this->formatMessage( $jsPage['latestReviewed'] );
			$jsPage['liveRevision']['statusMessage'] = $this->formatMessage( $jsPage['liveRevision'] );

			if ( in_array( $jsPage['page_title'], self::$topJsPages ) ) {
				$pagesOnTop[$pageId] = $jsPage;
			}
		}

		$jsPages = $pagesOnTop + $jsPages;

		return $jsPages;
	}

	private function formatMessage( $jsPage ) {
		$statusMessage = '';

		$statusKey = Sanitizer::encodeAttribute( $jsPage['statusKey'] );

		if ( !empty( $jsPage['diffLink'] ) ) {
			$statusMessage .= '<span class="content-review-status content-review-status-' . $statusKey . '">'
				. $jsPage['diffLink'] . '</span> ' . $jsPage['message'];

			if ( !empty( $jsPage['reasonLink'] ) ) {
				$statusMessage .= ' ' . $jsPage['reasonLink'];
			}
		} else {
			$statusMessage .= '<span class="content-review-status content-review-status-' . $statusKey . '">'
				. $jsPage['message'] . '</span>';
		}

		return $statusMessage;
	}




}
