<?php

use Wikia\ContentReview\Models\CurrentRevisionModel;
use Wikia\ContentReview\Models\ReviewModel;

class ContentReviewApiController extends WikiaApiController {

	const CONTENT_REVIEW_RESPONSE_ACTION_INSERT = 'insert';
	const CONTENT_REVIEW_RESPONSE_ACTION_UPDATE = 'update';

	public function submitPageForReview() {
		try {
			if ( !$this->request->wasPosted()
				|| !$this->wg->User->matchEditToken( $this->request->getVal( 'editToken' ) )
			) {
				throw new BadRequestApiException();
			}

			$wikiId = $this->request->getInt( 'wikiId' );
			$pageId = $this->request->getInt( 'pageId' );

			$submitUserId = $this->wg->User->getId();

			// TODO: Make exceptions more specific
			// TODO: Check permissions!!!
			if ( !$submitUserId > 0
				|| !$this->canUserSubmit( $pageId )
			) {
				throw new Exception( 'Invalid user' );
			}

			$wikiPage = WikiPage::newFromID( $pageId );
			if ( $wikiPage === null ) {
				throw new Exception( 'Invalid page' );
			}

			$revisionId = $wikiPage->getLatest();

			$reviewModel= new ReviewModel();
			$currentUnreviewedId = $reviewModel->getCurrentUnreviewedId( $wikiId, $pageId );

			if ( $currentUnreviewedId === null ) {
				$reviewId = $reviewModel->markPageAsUnreviewed( $wikiId, $pageId, $revisionId, $submitUserId );
				$responseAction = self::CONTENT_REVIEW_RESPONSE_ACTION_INSERT;
			} else {
				$reviewId = $reviewModel->updateReviewById( $currentUnreviewedId, $revisionId, $submitUserId );
				$responseAction = self::CONTENT_REVIEW_RESPONSE_ACTION_UPDATE;
			}

			if ( $reviewId > 0 ) {
				$this->makeSuccessResponse( [
					'reviewId' => $reviewId,
					'action' => $responseAction
				] );
			} else {
				$this->makeFailureResponse( [
					'action' => $responseAction
				] );
			}
		} catch ( Exception $e ) {
			$this->makeExceptionResponse( $e );
		}
	}

	public function getLatestReviewedRevision() {
		try {
			$wikiId = $this->request->getInt( 'wikiId' );
			$pageId = $this->request->getInt( 'pageId' );

			$revisionModel = new CurrentRevisionModel();
			$revisionData = $revisionModel->getLatestReviewedRevision( $wikiId, $pageId );

			if ( !empty( $revisionData ) ) {
				$this->makeSuccessResponse( $revisionData );
			} else {
				$this->makeFailureResponse();
			}
		} catch ( Exception $e ) {
			$this->makeExceptionResponse( $e );
		}
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

	private function makeFailureResponse( Array $data = [] ) {
		$this->response->setVal( 'status', false );

		foreach ( $data as $key => $value ) {
			$this->setVal( $key, $value );
		}
	}

	private function makeExceptionResponse( \Exception $e ) {
		$this->response->setVal( 'status', false );
		$this->response->setVal( 'exception', $e->getMessage() );
	}
}
