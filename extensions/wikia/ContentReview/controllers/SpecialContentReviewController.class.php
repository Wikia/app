<?php
use  Wikia\ContentReview\Models\ReviewModel;

class SpecialContentReviewController extends WikiaSpecialPageController {

	function __construct() {
		parent::__construct( 'ContentReview', 'ContentReview', true );
	}

	public function index() {
		$this->wg->Out->setPageTitle( wfMessage( 'content-review-special-title' )->escaped() );

		$this->reviewStatus = [];
		$this->status = [];
		$model = new ReviewModel();
		$this->reviewStatus = $model->getContentToReviewFromDatabase();

		$this->status[1] = wfMessage( 'content-review-status-unreviewed' );
		$this->status[2] = wfMessage( 'content-review-status-in-review' );
		$this->status[3] = wfMessage( 'content-review-status-approved' );
		$this->status[4] = wfMessage( 'content-review-status-rejected' );
	}

}
