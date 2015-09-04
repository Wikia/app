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
		if ( !$this->request->wasPosted()
			|| !$this->wg->User->matchEditToken( $this->request->getVal( 'editToken' ) )
		) {
			throw new BadRequestApiException();
		}

		$pageName = $this->request->getVal( 'pageName' );

		$title = Title::newFromText( $pageName );
		$pageId = $title->getArticleID();
		if ( $title === null || $pageId === 0 || !$title->isJsPage() ) {
			throw new NotFoundApiException( "JS page {$pageName} does not exist" );
		}

		$submitUserId = $this->wg->User->getId();
		if ( !$submitUserId > 0 || !$this->canUserSubmit( $pageId ) ) {
			throw new PermissionsException( 'edit' );
		}

		$revisionId = $title->getLatestRevID();
		$revisionData = $this->getLatestReviewedRevisionFromDB( $this->wg->CityId, $pageId );

		if ( $revisionId == $revisionData['revision_id'] ) {
			throw new BadRequestApiException( 'Current revision is already reviewed');
		}

		( new ReviewModel() )->submitPageForReview( $this->wg->CityId, $pageId,
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

		$helper = new Helper();
		$helper->setContentReviewTestMode();
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

		$helper = new Helper();
		$helper->disableContentReviewTestMode();
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


		if ( $helper->hasPageApprovedId( $wikiId, $pageId, $oldid  )
			&& $helper->isDiffPageInReviewProcess( $wikiId, $pageId, $diff ) )
		{
			$review = $reviewModel->getReviewedContent( $wikiId, $pageId, ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW );

			if ( empty( $review ) ) {
				throw new NotFoundApiException( 'Requested data not present in the database.' );
			}
			$reviewModel->backupCompletedReview( $review, $status, $reviewerId );

			if ( $status === ReviewModel::CONTENT_REVIEW_STATUS_APPROVED ) {
				$currentRevisionModel->approveRevision( $wikiId, $pageId, $review['revision_id'] );
				$this->notification = wfMessage( 'content-review-diff-approve-confirmation' )->parse();
			} elseif ( $status === ReviewModel::CONTENT_REVIEW_STATUS_REJECTED ) {
				$title = Title::newFromID( $pageId );
				$feedbackLink = $helper->prepareProvideFeedbackLink( $title );
				$this->notification = wfMessage( 'content-review-diff-reject-confirmation', $feedbackLink )->parse();
			}

			$reviewModel->updateCompletedReview( $wikiId, $pageId, $review['revision_id'], $status );
		}
		else {
			$this->notification = wfMessage( 'content-review-diff-already-done' )->escaped();
		}
	}

	public function getPageStatus() {
		$wikiId = $this->request->getInt( 'wikiId' );
		$pageId = $this->request->getInt( 'pageId' );

		$liveRevisionData = [
			'liveId' => $this->getLatestReviewedRevisionFromDB( $wikiId, $pageId )['revision_id'],
		];

		$reviewModel = new ReviewModel();
		$reviewData = $reviewModel->getPageStatus( $wikiId, $pageId );

		$currentPageData = array_merge( $liveRevisionData, $reviewData );

		$this->makeSuccessResponse( $currentPageData );
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
			[ 'class' => 'content-review-module-test-mode-disable', 'href' => '#' ],
			wfMessage( 'content-review-module-test-mode-disable' )->plain()
		);

		$this->notification = $notification;
	}

	/**
	 * Prepares parts for rendering status module
	 * Returns data required by ContentReviewModule.mustache
	 * @throws MWException
	 */
	public function renderStatusModal() {
		$pageName = $this->request->getVal( 'pageName' );
		/* Override global title to provide context */
		$this->wg->Title = Title::newFromText( $pageName );

		/* Get page status */
		$pageStatus = \F::app()->sendRequest(
			'ContentReviewApiController',
			'getPageStatus',
			[
				'wikiId' => $this->wg->CityId,
				'pageId' => $this->wg->Title->getArticleID(),
			],
			true
		)->getData();

		/* Render status module */
		$res = \F::app()->sendRequest(
			'ContentReviewModule',
			'executeRender',
			[
				'pageStatus' => $pageStatus,
				'latestRevisionId' => $this->wg->Title->getLatestRevID(),
			],
			true
		)->getData();

		/* Add link to help page to result */
		$helpTitle = Title::newFromText( wfMessage( 'content-review-module-help-article' )->escaped() );
		if ( $helpTitle ) {
			$res['helpUrl'] = $helpTitle->getFullURL();
			$res['helpTitle'] = wfMessage( 'content-review-module-help-text' )->escaped();
		}

		$this->setResponseData( $res );
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
