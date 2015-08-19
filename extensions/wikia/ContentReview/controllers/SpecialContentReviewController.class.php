<?php
use  Wikia\ContentReview\Models\ReviewModel;

class SpecialContentReviewController extends WikiaSpecialPageController {

	public static $status = [
		ReviewModel::CONTENT_REVIEW_STATUS_UNREVIEWED => 'content-review-status-unreviewed',
		ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW => 'content-review-status-in-review',
		ReviewModel::CONTENT_REVIEW_STATUS_APPROVED => 'content-review-status-approved',
		ReviewModel::CONTENT_REVIEW_STATUS_REJECTED => 'content-review-status-rejected'
	];

	function __construct() {
		parent::__construct( 'ContentReview', 'ContentReview', true );
	}

	public function index() {
		$this->wg->Out->setPageTitle( wfMessage( 'content-review-special-title' )->escaped() );
		$model = new ReviewModel();
		$reviews = $model->getContentToReviewFromDatabase();
		$reviews = $this->prepareReviewData( $reviews );
		$this->reviews = $reviews;
	}

	public function prepareReviewData( $reviews ) {
		foreach ( $reviews as $contentReviewId => $content ) {
			$reviews[$contentReviewId]['url'] = GlobalTitle::newFromID( $content['page_id'], $content['wiki_id'] )->getFullURL();
			$reviews[$contentReviewId]['title'] = GlobalTitle::newFromID( $content['page_id'], $content['wiki_id'] )->getBaseText();
			$reviews[$contentReviewId]['wiki'] = GlobalTitle::newFromID( $content['page_id'], $content['wiki_id'] )->getDatabaseName();
			$reviews[$contentReviewId]['user'] = User::newFromId( $content['submit_user_id'] )->getName();
		}
	return $reviews;
	}
}
