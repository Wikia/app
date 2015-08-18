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
		$reviewData = $this->prepareReviewData( $reviews );
		$this->reviews = $reviews;
		$this->reviewData = $reviewData;
	}

	public function prepareReviewData( $reviews ) {
		$reviewData = [];
		foreach ( $reviews as $contentReviewId => $content ) {
			$reviewData['title'][$contentReviewId] = GlobalTitle::newFromID( $content['page_id'], $content['wiki_id'] );
			$reviewData['user'][$contentReviewId] = User::newFromId( $content['submit_user_id'] );
		}
	return $reviewData;
	}
}
