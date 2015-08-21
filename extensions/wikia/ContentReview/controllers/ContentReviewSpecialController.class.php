<?php
use  Wikia\ContentReview\Models\ReviewModel;

class ContentReviewSpecialController extends WikiaSpecialPageController {

	public static $status = [
		ReviewModel::CONTENT_REVIEW_STATUS_UNREVIEWED => 'content-review-status-unreviewed',
		ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW => 'content-review-status-in-review',
		ReviewModel::CONTENT_REVIEW_STATUS_APPROVED => 'content-review-status-approved',
		ReviewModel::CONTENT_REVIEW_STATUS_REJECTED => 'content-review-status-rejected'
	];

	function __construct() {
		parent::__construct( 'ContentReview', 'content-review', true );
	}

	public function init() {
		$this->specialPage->setHeaders();

		\Wikia::addAssetsToOutput('content_review_special_page_js');
		\JSMessages::enqueuePackage( 'ContentReviewSpecialPage', \JSMessages::EXTERNAL );
	}

	public function index() {
		$model = new ReviewModel();
		$reviews = $model->getContentToReviewFromDatabase();
		$this->reviews = $this->prepareReviewData( $reviews );
	}

	private function prepareReviewData( $reviews ) {
		foreach ( $reviews as &$review ) {
			$title = GlobalTitle::newFromID( $review['page_id'], $review['wiki_id'] );
			$review['url'] = $title->getFullURL();
			$review['title'] = $title->getBaseText();
			$review['wiki'] = $title->getDatabaseName();
			$review['user'] = User::newFromId( $review['submit_user_id'] )->getName();
			$review['diff'] = $title->getFullURL( [
				'diff' => $review['revision_id'],
				'oldid' => $review['reviewed_id']
			] );
			$review['diffText'] = $review['status'] == ReviewModel::CONTENT_REVIEW_STATUS_UNREVIEWED
				? wfMessage( 'content-review-start-review' )->escaped()
				: wfMessage( 'content-review-continue-review' )->escaped();
		}
		return $reviews;
	}
}
