<?php

use Wikia\ContentReview\Helper;
use Wikia\ContentReview\Models\ReviewModel;

class ContentReviewModuleController extends WikiaController {

	const STATUS_NONE = 'none';
	const STATUS_LIVE = 'live';
	const STATUS_AWAITING = 'awaiting';
	const STATUS_REJECTED = 'rejected';
	const STATUS_APPROVED = 'approved';
	const STATUS_UNSUBMITTED = 'unsubmitted';

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

		$this->setVal( 'isTestModeEnabled', ( new Helper() )->isContentReviewTestModeEnabled() );

		/*
		 * This part allows fetches required params if not set. This allows direct usage via API
		 * (not needed in standard flow via $railModuleList loaded modules)
		 */
		if ( empty( $params ) ) {
			$params = [
				'pageStatus' => $this->getVal( 'pageStatus' ),
				'latestRevisionId' => $this->getVal( 'latestRevisionId' )
			];
		}

		/**
		 * Latest revision status
		 */
		$latestStatus = $this->getLatestRevisionStatusHtml( (int)$params['latestRevisionId'], $params['pageStatus'] );
		$this->setVal( 'latestStatus', MustacheService::getInstance()->render(
			self::STATUS_TEMPLATE_PATH, $latestStatus
		) );

		/* Set displaySubmit */
		$this->setVal( 'displaySubmit', $latestStatus['statusKey'] === self::STATUS_UNSUBMITTED );

		/**
		 * Last reviewed status
		 */
		$lastStatus = $this->getLastRevisionStatus( $params['pageStatus'] );
		$this->setVal( 'lastStatus', MustacheService::getInstance()->render(
			self::STATUS_TEMPLATE_PATH, $lastStatus
		) );

		/**
		 * Live revision status
		 */
		$liveStatus = $this->getLiveRevisionStatus( $params['pageStatus'] );
		$this->setVal( 'liveStatus', MustacheService::getInstance()->render(
			self::STATUS_TEMPLATE_PATH, $liveStatus
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
	}

	public function isWithReason( $latestRevisionId, $pageStatus ) {
		return ( $latestRevisionId === (int)$pageStatus['lastReviewedId']
			&& (int)$pageStatus['lastReviewedStatus'] === ReviewModel::CONTENT_REVIEW_STATUS_REJECTED
		);
	}

	public function getLatestRevisionStatus( $latestRevisionId, array $pageStatus ) {
		if ( $latestRevisionId === 0 ) {
			$latestStatus = \ContentReviewModuleController::STATUS_NONE;
		} elseif ( $latestRevisionId === (int)$pageStatus['liveId'] ) {
			$latestStatus = \ContentReviewModuleController::STATUS_LIVE;
		} elseif ( $latestRevisionId === (int)$pageStatus['latestId']
			&& Helper::isStatusAwaiting( $pageStatus['latestStatus'] )
		) {
			$latestStatus = \ContentReviewModuleController::STATUS_AWAITING;
		} elseif ( $latestRevisionId === (int)$pageStatus['lastReviewedId']
			&& (int)$pageStatus['lastReviewedStatus'] === ReviewModel::CONTENT_REVIEW_STATUS_REJECTED
		) {
			$latestStatus = \ContentReviewModuleController::STATUS_REJECTED;
		} elseif ( $latestRevisionId > (int)$pageStatus['liveId']
			&& $latestRevisionId > (int)$pageStatus['latestId']
			&& $latestRevisionId > (int)$pageStatus['lastReviewedId']
		) {
			$latestStatus = \ContentReviewModuleController::STATUS_UNSUBMITTED;
		}

		return $latestStatus;
	}

	public function getLatestRevisionStatusHtml( $latestRevisionId, $pageStatus ) {
		$latestStatus = $this->getLatestRevisionStatus( $latestRevisionId, $pageStatus );
		$withReason = $this->isWithReason( $latestRevisionId, $pageStatus );

		$latestStatusHtml = $this->prepareTemplateData( $latestStatus, $latestRevisionId, $withReason );
		return $latestStatusHtml;
	}

	public function getLastRevisionStatus( array $pageStatus ) {
		if ( is_null( $pageStatus['lastReviewedId'] ) ) {
			$lastStatus = $this->prepareTemplateData( self::STATUS_NONE );
		} elseif ( (int) $pageStatus['lastReviewedStatus'] === ReviewModel::CONTENT_REVIEW_STATUS_APPROVED ) {
			$lastStatus = $this->prepareTemplateData( self::STATUS_APPROVED, $pageStatus['lastReviewedId'] );
		} elseif ( (int) $pageStatus['lastReviewedStatus'] === ReviewModel::CONTENT_REVIEW_STATUS_REJECTED ) {
			$lastStatus = $this->prepareTemplateData( self::STATUS_REJECTED, $pageStatus['lastReviewedId'], true );
		}

		return $lastStatus;
	}

	public function getLiveRevisionStatus( array $pageStatus ) {
		if ( !is_null( $pageStatus['liveId'] ) ) {
			$liveStatus = $this->prepareTemplateData( self::STATUS_LIVE, $pageStatus['liveId'] );
		} else {
			$liveStatus = $this->prepareTemplateData( self::STATUS_NONE );
		}

		return $liveStatus;
	}

	protected function prepareTemplateData( $status, $revisionId = null, $withReason = false ) {
		$templateData = [
			'statusKey' => $status,
			'message' => wfMessage( "content-review-module-status-{$status}" )->escaped(),
		];

		if ( !empty( $revisionId ) ) {
			$templateData['diffLink'] = $this->createRevisionLink( $revisionId );
			if ( $withReason ) {
				$templateData['reasonLink'] = $this->createRevisionTalkpageLink( $revisionId );
			}
		}

		return $templateData;
	}

	protected function createRevisionLink( $revisionId ) {
		return Linker::linkKnown(
			$this->wg->Title,
			"#{$revisionId}",
			[],
			[
				'diff' => $revisionId,
			]
		);
	}

	protected function createRevisionTalkpageLink() {
		return Linker::linkKnown(
			$this->wg->Title->getTalkPage(),
			wfMessage( 'content-review-rejection-reason-link' )->escaped()
		);
	}
}
