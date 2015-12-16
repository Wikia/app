<?php

class ImageReviewMercuryController extends WikiaSpecialPageController {

	/**
	 * Constructor method. Overrides the original Special:ImageReviewMercury page.
	 */
	public function __construct() {
		parent::__construct( 'ImageReviewMercury' );
	}

	public function index() {
		$this->wg->Title = 'Image Review Mercury';
		$this->specialPage->setHeaders();
	}
}
