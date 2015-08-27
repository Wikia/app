<?php

use Wikia\ContentReview\Models\CurrentRevisionModel;
use Wikia\ContentReview\Models\ReviewModel;
use Wikia\ContentReview\Helper;

class ContentReviewApiController extends WikiaApiController {

	const CONTENT_REVIEW_RESPONSE_ACTION_INSERT = 'insert';
	const CONTENT_REVIEW_RESPONSE_ACTION_UPDATE = 'update';
	const CONTENT_REVIEW_TEST_MODE_KEY = 'contentReviewTestMode';

	/**
	 * Check permissions and add page to review queue
	 *
	 * @throws BadRequestApiException
	 * @throws NotFoundApiException
	 * @throws PermissionsException
	 * @throws \FluentSql\Exception\SqlException
	 */
	public function submitPageForReview() {
		global $wgCityId;

		if ( !$this->request->wasPosted()
			|| !$this->wg->User->matchEditToken( $this->request->getVal( 'editToken' ) )
		) {
			throw new BadRequestApiException();
		}

		$pageId = $this->request->getInt( 'pageId' );

		$title = Title::newFromID( $pageId );
		if ( $title === null || !$title->isJsPage() ) {
			throw new NotFoundApiException( "JS page with ID {$pageId} does not exist");
		}

		$submitUserId = $this->wg->User->getId();
		if ( !$submitUserId > 0 || !$this->canUserSubmit( $pageId ) ) {
			throw new PermissionsException( 'edit' );
		}

		$revisionId = $title->getLatestRevID();
		$revisionData = $this->getLatestReviewedRevisionFromDB( $wgCityId, $pageId );

		if ( $revisionId == $revisionData['revision_id'] ) {
			throw new BadRequestApiException( 'Current revision is already reviewed');
		}

		( new ReviewModel() )->submitPageForReview( $wgCityId, $pageId,
			$revisionId, $submitUserId );

		$this->makeSuccessResponse();
	}

	/**
	 * Enable test mode
	 *
	 * @throws BadRequestApiException
	 * @throws NotFoundApiException
	 * @throws PermissionsException
	 */
	public function enableTestMode() {
		if ( !$this->request->wasPosted()
			|| !$this->wg->User->matchEditToken( $this->request->getVal( 'editToken' ) )
		) {
			throw new BadRequestApiException();
		}

		$pageId = $this->request->getInt( 'pageId' );

		$title = Title::newFromID( $pageId );
		if ( $title === null || !$title->isJsPage() ) {
			throw new NotFoundApiException( "JS page with ID {$pageId} does not exist");
		}

		$submitUserId = $this->wg->User->getId();
		if ( !$submitUserId > 0 || !$this->canUserSubmit( $pageId )	) {
			throw new PermissionsException( 'edit' );
		}

		Wikia\ContentReview\Helper::setContentReviewTestMode();
		$this->makeSuccessResponse();
	}

	/**
	 * Disable test mode
	 *
	 * @throws BadRequestApiException
	 */
	public function disableTestMode() {
		if ( !$this->request->wasPosted() ) {
			throw new BadRequestApiException();
		}

		Wikia\ContentReview\Helper::disableContentReviewTestMode();
		$this->makeSuccessResponse();
	}

	/**
	 * Update revison request status
	 *
	 * @throws BadRequestApiException
	 * @throws PermissionsException
	 */
	public function updateReviewsStatus() {
		if ( !$this->request->wasPosted()
			|| !$this->wg->User->matchEditToken( $this->request->getVal( 'editToken' ) )
		) {
			throw new BadRequestApiException();
		}

		if ( !$this->wg->User->isAllowed( 'content-review' ) ) {
			throw new PermissionsException( 'content-review' );
		}

		$pageId = $this->request->getInt( 'pageId' );
		$wikiId = $this->request->getInt( 'wikiId' );
		$oldStatus = $this->request->getInt( 'oldStatus' );
		$status = $this->request->getInt( 'status' );
		$reviewerId = $this->wg->User->getId();

		$model = new ReviewModel();
		$model->updateRevisionStatus( $wikiId, $pageId, $oldStatus, $status, $reviewerId );
	}

	/**
	 * @throws BadRequestApiException
	 * @throws PermissionsException
	 */
	public function removeCompletedAndUpdateLogs() {
		if ( !$this->request->wasPosted()
			|| !$this->wg->User->matchEditToken( $this->request->getVal( 'editToken' ) )
		) {
			throw new BadRequestApiException();
		}

		if ( !$this->wg->User->isAllowed( 'content-review' ) ) {
			throw new PermissionsException( 'content-review' );
		}

		$currentRevisionModel = new CurrentRevisionModel();
		$reviewModel = new ReviewModel();
		$helper = new Helper();

		$reviewerId = $this->wg->User->getId();
		$pageId = $this->request->getInt( 'pageId' );
		$wikiId = $this->request->getInt( 'wikiId' );
		$status = $this->request->getInt( 'status' );
		$diff = $this->request->getInt( 'diff' );
		$oldid = $this->request->getInt( 'oldid' );


		if ( $helper->hasPageApprovedId( $wikiId, $pageId, $oldid  ) && $helper->isDiffPageInReviewProcess( $wikiId, $pageId, $diff ) ) {
			$review = $reviewModel->getReviewedContent( $wikiId, $pageId, ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW );

			if ( empty( $review ) ) {
				throw new NotFoundApiException( 'Requested data not present in the database.' );
			}
			$reviewModel->backupCompletedReview( $review, $status, $reviewerId );

			if ( $status === ReviewModel::CONTENT_REVIEW_STATUS_APPROVED ) {
				$currentRevisionModel->approveRevision( $wikiId, $pageId, $review['revision_id'] );
				$this->notification = wfMessage( 'content-review-diff-approve-confirmation' )->escaped();
			} elseif ( $status === ReviewModel::CONTENT_REVIEW_STATUS_REJECTED ) {
				$this->notification = wfMessage( 'content-review-diff-reject-confirmation' )->escaped();
			}
			$reviewModel->removeCompletedReview( $wikiId, $pageId );
		}
		else {
			$this->notification = wfMessage( 'content-review-diff-already-done' )->escaped();
		}
	}

	public function getCurrentPageData() {
		$wikiId = $this->request->getInt( 'wikiId' );
		$pageId = $this->request->getInt( 'pageId' );

		$revisionData = $this->getLatestReviewedRevisionFromDB( $wikiId, $pageId );

		$reviewModel = new ReviewModel();
		$reviewData = $reviewModel->getPageStatus( $wikiId, $pageId );

		$data = [
			'reviewedRevisionId' => $revisionData['revision_id'],
			'touched' => $revisionData['touched'],
			'revisionInReviewId' => $reviewData['revision_id'],
			'reviewStatus' => $reviewData['status'],
		];
		$this->makeSuccessResponse( $data );
	}

	public function getLatestReviewedRevision() {
		$wikiId = $this->request->getInt( 'wikiId' );
		$pageId = $this->request->getInt( 'pageId' );

		$revisionData = $this->getLatestReviewedRevisionFromDB( $wikiId, $pageId );

		$this->makeSuccessResponse( $revisionData );
	}

	public function showTestModeNotification() {
		$notification = wfMessage( 'content-review-test-mode-enabled' )->escaped();
		$notification.= Xml::element(
			'a',
			[ 'class' => 'content-review-test-mode-disable', 'href' => '#' ],
			wfMessage( 'content-review-test-mode-disable' )->plain()
		);

		$this->notification = $notification;
	}

	private function getLatestReviewedRevisionFromDB( $wikiId, $pageId ) {
		return ( new CurrentRevisionModel() )->getLatestReviewedRevision( $wikiId, $pageId );
	}

	private function canUserSubmit( $pageId ) {
		$title = Title::newFromID( $pageId );
		return $title->userCan( 'edit' );
	}

	private function makeSuccessResponse( Array $data = [] ) {
		$this->setVal( 'status', true );

		foreach ( $data as $key => $value ) {
			$this->setVal( $key, $value );
		}
	}
}
