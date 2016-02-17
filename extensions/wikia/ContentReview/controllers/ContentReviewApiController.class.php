<?php

use Wikia\ContentReview\Models\CurrentRevisionModel;
use Wikia\ContentReview\Models\ReviewModel;
use Wikia\ContentReview\Models\ReviewLogModel;
use Wikia\ContentReview\Helper;
use Wikia\ContentReview\ContentReviewService;
use Wikia\ContentReview\ContentReviewStatusesService;

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
		$this->isValidPostRequest( $this->request, $this->wg->User );

		$pageName = $this->request->getVal( 'pageName' );
		$title = $this->getTitle( $pageName );

		if ( $title === null ) {
			throw new NotFoundApiException( "JS page {$pageName} does not exist" );
		}

		$pageId = $title->getArticleID();
		if ( $pageId === 0 || !$title->isJsPage() ) {
			throw new NotFoundApiException( "JS page {$pageName} does not exist" );
		}

		$submitUserId = $this->wg->User->getId();
		if ( !$submitUserId > 0 || !$this->canUserSubmit( $title ) ) {
			throw new PermissionsException( 'edit' );
		}

		$revisionId = $title->getLatestRevID();
		$revisionData = $this->getLatestReviewedRevisionFromDB( $this->wg->CityId, $pageId );

		if ( $revisionId == $revisionData['revision_id'] ) {
			throw new BadRequestApiException( 'Current revision is already reviewed');
		}

		( new ReviewModel() )->submitPageForReview( $this->wg->CityId, $pageId,
			$revisionId, $submitUserId );

		ContentReviewStatusesService::purgeJsPagesCache();

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
		$this->isValidPostRequest( $this->request, $this->wg->User );

		if ( !$this->wg->User->isAllowed( 'content-review-test-mode' ) ) {
			throw new PermissionsException( 'content-review-test-mode' );
		}

		$this->getHelper()->setContentReviewTestMode( $this->wg->CityId );
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
		$helper->disableContentReviewTestMode( $this->wg->CityId );
		$this->makeSuccessResponse();
	}

	/**
	 * Update revison request status
	 *
	 * @throws BadRequestApiException
	 * @throws PermissionsException
	 */
	public function updateReviewsStatus() {
		$this->isValidPostRequest( $this->request, $this->wg->User );

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

		ContentReviewStatusesService::purgeJsPagesCache();
	}

	/**
	 * @throws BadRequestApiException
	 * @throws PermissionsException
	 */
	public function removeCompletedAndUpdateLogs() {
		$this->isValidPostRequest( $this->request, $this->wg->User );

		if ( !$this->wg->User->isAllowed( 'content-review' ) ) {
			throw new PermissionsException( 'content-review' );
		}

		$currentRevisionModel = $this->getCurrentRevisionModel();
		$helper = $this->getHelper();
		$reviewModel = $this->getReviewModel();

		$reviewerId = $this->wg->User->getId();
		$pageId = $this->request->getInt( 'pageId' );
		$wikiId = $this->request->getInt( 'wikiId' );
		$status = $this->request->getInt( 'status' );
		$diff = $this->request->getInt( 'diff' );
		$oldid = $this->request->getInt( 'oldid' );

		if ( $helper->hasPageApprovedId( $currentRevisionModel, $wikiId, $pageId, $oldid )
			&& $helper->isDiffPageInReviewProcess( $this->request, $reviewModel, $wikiId, $pageId, $diff ) )
		{
			$review = $reviewModel->getReviewOfPageByStatus( $wikiId, $pageId, ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW );

			if ( empty( $review ) ) {
				throw new NotFoundApiException( 'There is no revision that is currently in review.' );
			}
			$this->getReviewLogModel()->backupCompletedReview( $review, $status, $reviewerId );

			if ( $status === ReviewModel::CONTENT_REVIEW_STATUS_APPROVED ) {
				$currentRevisionModel->approveRevision( $wikiId, $pageId, $review['revision_id'] );
				$helper->purgeReviewedJsPagesTimestamp();
				$this->notification = wfMessage( 'content-review-diff-approve-confirmation' )->parse();
			} elseif ( $status === ReviewModel::CONTENT_REVIEW_STATUS_REJECTED ) {
				$title = Title::newFromID( $pageId );
				$feedbackLink = $helper->prepareProvideFeedbackLink( $title, $diff );
				$this->notification = wfMessage( 'content-review-diff-reject-confirmation', $feedbackLink )->parse();
			}

			$reviewModel->updateCompletedReview( $wikiId, $pageId, $review['revision_id'], $status );

			ContentReviewStatusesService::purgeJsPagesCache();
		} else {
			$this->notification = wfMessage( 'content-review-diff-already-done' )->escaped();
		}
	}

	public function escalateReview() {
		$this->isValidPostRequest( $this->request, $this->wg->User );

		if ( !$this->wg->User->isAllowed( 'content-review' ) ) {
			throw new PermissionsException( 'content-review' );
		}

		$wikiId = $this->request->getInt( 'wikiId' );
		$pageId = $this->request->getInt( 'pageId' );
		$diff = $this->request->getInt( 'diff' );
		$oldid = $this->request->getInt( 'oldid' );

		$service = new ContentReviewService();
		if ( $service->escalateReview( $wikiId, $pageId, $diff, $oldid ) ) {
			$this->notification = wfMessage( 'content-review-diff-escalate-confirmation' )->escaped();
		}
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

		/* Render status module */
		$res = $this->app->sendRequest(
			'ContentReviewModule',
			'Render',
			[
				'wikiId' => $this->wg->CityId,
				'pageId' => $this->wg->Title->getArticleID(),
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

	/**
	 * @param $pageName
	 * @return Title
	 * @throws MWException
	 */
	protected function getTitle( $pageName ) {
		return Title::newFromText( $pageName );
	}

	/**
	 * @return Wikia\ContentReview\Helper
	 */
	protected function getHelper() {
		return new Helper();
	}

	/**
	 * @return Wikia\ContentReview\Models\CurrentRevisionModel
	 */
	protected function getCurrentRevisionModel() {
		return new CurrentRevisionModel();
	}

	/**
	 * @return Wikia\ContentReview\Models\ReviewModel
	 */
	protected function getReviewModel() {
		return new ReviewModel();
	}

	/**
	 * @return Wikia\ContentReview\Models\ReviewLogModel
	 */
	protected function getReviewLogModel() {
		return new ReviewLogModel();
	}

	private function isValidPostRequest( WikiaRequest $request, User $user ) {
		if ( !$request->wasPosted() || !$user->matchEditToken( $request->getVal( 'editToken' ) ) ) {
			throw new BadRequestApiException();
		}
		return true;
	}

	private function getLatestReviewedRevisionFromDB( $wikiId, $pageId ) {
		return ( new CurrentRevisionModel() )->getLatestReviewedRevision( $wikiId, $pageId );
	}

	protected function canUserSubmit( Title $title ) {
		return $title->userCan( 'edit' );
	}

	private function makeSuccessResponse( Array $data = [] ) {
		$this->setVal( 'status', true );

		foreach ( $data as $key => $value ) {
			$this->setVal( $key, $value );
		}
	}
}
