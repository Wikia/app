<?php

class ContentReviewModuleController extends WikiaController {

	/**
	 * Controller method for a module that allows sending a page to a review
	 * @param $params
	 */
	public function executeUnreviewed( $params ) {
		Wikia::addAssetsToOutput( 'content_review_module_js' );
	}
}
