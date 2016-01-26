<?php

class ImageReviewMercuryController extends WikiaSpecialPageController {

	private $imageReview;
	public function __construct() {

		$this->imageReview = (new ImageReviewMercury);
		parent::__construct( 'ImageReviewMercury' );
	}

	public function index() {
		$title = Title::newFromText( 'ImageReviewMercury', NS_SPECIAL );

		$this->wg->Title = $title;
		$this->specialPage->setHeaders();
	}
}
