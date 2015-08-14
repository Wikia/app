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

			// TODO: Make exceptions more specific
			$submitUserId = $this->wg->User->getId();
			if ( !$submitUserId > 0 || !$this->canUserSubmit( $pageId )	) {
				throw new Exception( 'Invalid user' );
			}

			$title = Title::newFromID( $pageId );
			if ( $title === null ) {
				throw new Exception( 'Invalid page' );
			}

			$revisionId = $title->getLatestRevID();

			$reviewModel= new ReviewModel();
			$reviewStatus = $reviewModel->submitPageForReview( $wikiId, $pageId,
				$revisionId, $submitUserId );

			if ( $reviewStatus['status'] ) {
				$this->makeSuccessResponse();
			} else {
				$this->makeFailureResponse();
			}
		} catch ( Exception $e ) {
			$this->makeExceptionResponse( $e );
		}
	}

	public function getCurrentPageData() {
		try {
			$wikiId = $this->request->getInt( 'wikiId' );
			$pageId = $this->request->getInt( 'pageId' );

			$revisionModel = new CurrentRevisionModel();
			$revisionData = $revisionModel->getLatestReviewedRevision( $wikiId, $pageId );

			$reviewModel = new ReviewModel();
			$reviewData = $reviewModel->getPageStatus( $wikiId, $pageId );

			$data = [
				'currentRevisionId' => $revisionData['revision_id'],
				'touched' => $revisionData['touched'],
				'revisionInReviewId' => $reviewData['revision_id'],
				'reviewStatus' => $reviewData['status'],
			];
			$this->makeSuccessResponse( $data );
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
