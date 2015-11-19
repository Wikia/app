<?php

use Wikia\ContentReview\Helper;
use Wikia\ContentReview\ContentReviewStatusesService;

class ContentReviewModuleController extends WikiaController {
	const STATUS_TEMPLATE_PATH = 'extensions/wikia/ContentReview/templates/ContentReviewModuleStatus.mustache';
	const STATUS_MODULE_TEMPLATE_PATH =
		'extensions/wikia/ContentReview/controllers/templates/ContentReviewModule.mustache';

	/**
	 * Executed when a page has unreviewed changes.
	 * @param $params
	 */
	public function executeRender( $params ) {
		Wikia::addAssetsToOutput( 'content_review_module_js' );
		Wikia::addAssetsToOutput( 'content_review_module_scss' );
		JSMessages::enqueuePackage( 'ContentReviewModule', JSMessages::EXTERNAL );

		$helper = new Helper();

		$this->setVal( 'isTestModeEnabled', $helper->isContentReviewTestModeEnabled() );

		$contentReviewStatusesService = new ContentReviewStatusesService();
		$pageStatus = $contentReviewStatusesService->getJsPageStatus( $params['wikiId'], $params['pageId'] );

		/**
		 * Latest revision status
		 */
		$this->setVal( 'latestStatus', MustacheService::getInstance()->render(
			self::STATUS_TEMPLATE_PATH, $pageStatus['latestRevision']
		) );
		$this->setVal(
			'displaySubmit',
			$pageStatus['latestRevision']['statusKey'] === ContentReviewStatusesService::STATUS_UNSUBMITTED
				&& $helper->userCanEditJsPage( $this->wg->Title, $this->wg->User )
		);
		$this->setVal( 'pageName', $pageStatus['pageName'] );

		/**
		 * Last reviewed status
		 */
		$this->setVal( 'lastStatus', MustacheService::getInstance()->render(
			self::STATUS_TEMPLATE_PATH, $pageStatus['latestReviewed']
		) );

		/**
		 * Live revision status
		 */
		$this->setVal( 'liveStatus', MustacheService::getInstance()->render(
			self::STATUS_TEMPLATE_PATH, $pageStatus['liveRevision']
		) );

		/* Use mustache status template from ContentReview extension  */
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->response->getView()->setTemplatePath( self::STATUS_MODULE_TEMPLATE_PATH );

		/* Set messages */
		$this->setVal( 'headerLatest', wfMessage( 'content-review-module-header-latest' )->plain() );
		$this->setVal( 'headerLast', wfMessage( 'content-review-module-header-last' )->plain() );
		$this->setVal( 'headerLive', wfMessage( 'content-review-module-header-live' )->plain() );
		$this->setVal( 'submit', wfMessage( 'content-review-module-submit' )->plain() );
		$this->setVal( 'disableTestMode', wfMessage( 'content-review-module-test-mode-disable' )->plain() );
		$this->setVal( 'enableTestMode', wfMessage( 'content-review-module-test-mode-enable' )->plain() );
		$this->setVal( 'title', wfMessage( 'content-review-module-title' )->plain() );
		$this->setVal( 'help', wfMessage( 'content-review-module-help' )->parse() );
		$this->setVal( 'jsPagesUrl', SpecialPage::getTitleFor( 'JSPages' )->getLocalURL() );
		$this->setVal( 'jsPagesTitle', wfMessage( 'content-review-module-jspages' )->plain() );
	}
}
