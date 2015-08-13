<?php

use Wikia\ContentReview\Models\ReviewModel;

class ContentReviewApiController extends WikiaApiController {

	const CONTENT_REVIEW_RESPONSE_ACTION_INSERT = 'insert';
	const CONTENT_REVIEW_RESPONSE_ACTION_UPDATE = 'update';

	public function submitPageForReview() {
		try {
			$wikiId = $this->request->getInt( 'wikiId' );
			$pageId = $this->request->getInt( 'pageId' );

			$submitUserId = $this->wg->User->getId();

			// TODO: Make exceptions more specific
			// TODO: Check permissions!!!
			if ( !$submitUserId > 0 ) {
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
