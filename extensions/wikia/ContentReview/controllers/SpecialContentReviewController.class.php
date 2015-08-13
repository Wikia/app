<?php

class SpecialContentReviewController extends WikiaSpecialPageController {

	function __construct() {
		parent::__construct( 'ContentReview', 'ContentReview', true );
	}

	public function index() {
		$this->wg->Out->setPageTitle( wfMessage( 'content-review-special-title' )->escaped() );

	}
}
