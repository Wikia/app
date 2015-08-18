<?php

class ContentReviewModuleController extends WikiaController {

	const MODULE_TYPE_UNREVIEWED = 'unreviewed';
	const MODULE_TYPE_IN_REVIEW = 'inreview';
	const MODULE_TYPE_CURRENT = 'current';

	/**
	 * Executed when a page has unreviewed changes.
	 * @param $params
	 */
	public function executeRender( $params ) {
		Wikia::addAssetsToOutput( 'content_review_module_js' );
		JSMessages::enqueuePackage( 'ContentReviewModule', JSMessages::EXTERNAL );


		$this->moduleType = $params['moduleType'];
		$this->isTestModeEnabled = Wikia\ContentReview\Helper::isContentReviewTestModeEnabled();
	}
}
