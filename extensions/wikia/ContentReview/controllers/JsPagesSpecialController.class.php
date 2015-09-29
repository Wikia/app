<?php

use Wikia\ContentReview\Helper;
use Wikia\ContentReview\Models;

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

		$helper = new Helper();
		$jsPages = $helper->getJsPages();

		$reviewModel = new Models\ReviewModel();
		$statuses = $reviewModel->getPagesStatuses($this->wg->CityId);

		$currentRevision = new Models\CurrentRevisionModel();
		$lastReviewed = $currentRevision->getLatestReviewedRevisionForWiki($this->wg->CityId);

		$this->jsPages = $this->prepareData( $jsPages, $statuses, $lastReviewed );
	}

	private function prepareData( $jsPages, $statuses, $lastReviewed ) {
		if ( !empty( $statuses ) || !empty( $lastReviewed ) ) {
			foreach ( $jsPages as $pageId => &$page ) {
				$page += $this->initPageData();

				if ( isset( $statuses[$pageId] ) ) {
					foreach( $statuses[$pageId] as $status => $revId ) {
						if ( Helper::isStatusAwaiting( $status ) && empty( $page['latestRevision'] ) ) {
							$page['latestRevision']['revId'] = $revId;
							$page['latestRevision']['status'] = $status;
						} elseif ( Helper::isStatusCompleted( $status ) ) {
							if ( empty( $page['latestRevision'] ) ) {
								$page['latestRevision']['revId'] = $revId;
								$page['latestRevision']['status'] = $status;
							}

							if ( empty( $page['latestReviewed'] ) ) {
								$page['latestReviewed']['revId'] = $revId;
								$page['latestReviewed']['status'] = $status;
							}
						}
					}
				}

				if ( isset( $lastReviewed[$pageId]['revision_id'] ) ) {
					if ( empty( $page['latestReviewed'] ) ) {
						$page['latestReviewed']['revId'] = $lastReviewed[$pageId]['revision_id'];
						$page['latestReviewed']['status'] = Models\ReviewModel::CONTENT_REVIEW_STATUS_APPROVED;
					}

					$page['liveRevision'] = $lastReviewed[$pageId]['revision_id'];
				}

				if ( $page['page_latest'] != $page['latestRevision']['revId'] ) {
					$page['latestRevision']['revId'] = $page['page_latest'];
					$page['latestRevision']['status'] = 0;
				}
			}
		}

		return $jsPages;
	}

	private function initPageData() {
		return [
			'latestRevision' => [],
			'latestReviewed' => [],
			'liveRevision' => null
		];
	}
}
