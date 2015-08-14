<?php

class ContentReviewModuleController extends WikiaController {

	/**
	 * Executed when a page has unreviewed changes and has not yet been submitted for review
	 * @param $params
	 */
	public function executeUnreviewed( $params ) {
		Wikia::addAssetsToOutput( 'content_review_module_js' );
		JSMessages::enqueuePackage( 'ContentReviewModule' );
	}

	public function executeInReview( $params ) {
		Wikia::addAssetsToOutput( 'content_review_module_js' );
		JSMessages::enqueuePackage( 'ContentReviewModule' );
	}
}
