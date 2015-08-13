<?php

/**
 * Created by PhpStorm.
 * User: mariusz
 * Date: 13.08.15
 * Time: 16:22
 */
class SpecialContentReviewController extends WikiaSpecialPageController {

	function __construct() {
		parent::__construct( 'ContentReview', 'ContentReview', true );
	}

	public function index() {
		$this->wg->Out->setPageTitle( wfMessage( 'content-review-special-title' )->escaped() );

	}
}