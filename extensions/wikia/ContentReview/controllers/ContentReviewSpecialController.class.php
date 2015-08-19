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
		$reviews = $this->prepareReviewData( $reviews );
		$this->reviews = $reviews;
	}

	private function prepareReviewData( $reviews ) {
		foreach ( $reviews as $contentReviewId => $content ) {
			$title = GlobalTitle::newFromID( $content['page_id'], $content['wiki_id'] );

			$reviews[$contentReviewId]['url'] = $title->getFullURL();
			$reviews[$contentReviewId]['title'] = $title->getBaseText();
			$reviews[$contentReviewId]['wiki'] = $title->getDatabaseName();
			$reviews[$contentReviewId]['user'] = User::newFromId( $content['submit_user_id'] )->getName();

			$reviews[$contentReviewId]['diff'] = Linker::linkKnown(
				$title,
				wfMessage( 'content-review-icons-actions-diff' )->escaped(),
				array(
					'target' => '_blank',
					'class' => 'content-review-special-list-item-actions-diff  wikia-button primary',
				),
				array(
					'diff' => $reviews[$contentReviewId]['revision_id'],
					'oldid' => $reviews[$contentReviewId]['reviewed_id'],
				)
			);
		}
		return $reviews;
	}
}
