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

	public function index() {
		$this->specialPage->setHeaders();
		$model = new ReviewModel();
		$reviews = $model->getContentToReviewFromDatabase();
		$this->reviews = $this->prepareReviewData( $reviews );
		$this->inReview = ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW;
		\Wikia::addAssetsToOutput('content_review_special_page_js');
		\JSMessages::enqueuePackage( 'ContentReviewSpecialPage', \JSMessages::EXTERNAL );
	}

	private function prepareReviewData( $reviews ) {
		foreach ( $reviews as $contentReviewId => $content ) {
			$title = GlobalTitle::newFromID( $content['page_id'], $content['wiki_id'] );
			$reviews[$contentReviewId]['url'] = $title->getFullURL();
			$reviews[$contentReviewId]['title'] = $title->getBaseText();
			$reviews[$contentReviewId]['wiki'] = $title->getDatabaseName();
			$reviews[$contentReviewId]['user'] = User::newFromId( $content['submit_user_id'] )->getName();
			$reviews[$contentReviewId]['diff'] = $title->getFullURL( [
				'diff' => $reviews[$contentReviewId]['revision_id'],
				'oldid' => $reviews[$contentReviewId]['reviewed_id']
			] );
		}
		return $reviews;
	}

	/**
	 * TODO add permissions
	 */
	public function updateReviewsStatus() {

		$pageId = $this->request->getInt( 'pageId' );
		$wikiId = $this->request->getInt( 'wikiId' );
		$status = $this->request->getInt( 'status' );

		$model = new ReviewModel();
		$model->updateRevisionStatus( $wikiId, $pageId, $status );

	}
}
