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

	/**
	 * Executed when a page has unreviewed changes.
	 * @param $params
	 */
	public function executeRender( $params ) {
		Wikia::addAssetsToOutput( 'content_review_module_js' );
		Wikia::addAssetsToOutput( 'content_review_module_scss' );
		JSMessages::enqueuePackage( 'ContentReviewModule', JSMessages::EXTERNAL );

		$this->setVal( 'isTestModeEnabled', Helper::isContentReviewTestModeEnabled() );

		/*
		 * This part allows fetches required params if not set. This allows direct usage via API
		 * (not needed in standard flow via $railModuleList loaded modules)
		 * @TODO Probably this part should be moved to ContentReview Ext
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
		$latestStatus = $this->getLatestRevisionStatus( (int) $params['latestRevisionId'], $params['pageStatus'] );
		$this->setVal( 'latestStatus', MustacheService::getInstance()->render(
			self::STATUS_TEMPLATE_PATH, $latestStatus
		) );
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
	}

	public function getLatestRevisionStatus( $latestRevisionId, array $pageStatus ) {
		$latestRevisionId = (int) $latestRevisionId;
		if ( $latestRevisionId === 0 ) {
			$latestStatus = $this->prepareTemplateData( self::STATUS_NONE );
		} elseif ( $latestRevisionId === (int) $pageStatus['liveId'] ) {
			$latestStatus = $this->prepareTemplateData( self::STATUS_LIVE, $latestRevisionId );
		} elseif ( $latestRevisionId === (int) $pageStatus['latestId']
			&& Helper::isStatusAwaiting( $pageStatus['latestStatus'] ) )
		{
			$latestStatus = $this->prepareTemplateData( self::STATUS_AWAITING, $latestRevisionId );
		} elseif ( $latestRevisionId === (int) $pageStatus['lastReviewedId']
			&& (int) $pageStatus['lastReviewedStatus'] === ReviewModel::CONTENT_REVIEW_STATUS_REJECTED )
		{
			$latestStatus = $this->prepareTemplateData( self::STATUS_REJECTED, $latestRevisionId, true );
		} elseif ( $latestRevisionId > (int) $pageStatus['liveId']
			&& $latestRevisionId > (int) $pageStatus['latestId']
			&& $latestRevisionId > (int) $pageStatus['lastReviewedId'] ) {
			$latestStatus = $this->prepareTemplateData( self::STATUS_UNSUBMITTED, $latestRevisionId );
		}

		return $latestStatus;
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

	public function prepareTemplateData( $status, $revisionId = null, $withReason = false ) {
		$templateData = [
			'statusKey' => $status,
			'message' => wfMessage( "content-review-module-status-{$status}" )->escaped(),
		];

		if ( !is_null( $revisionId ) ) {
			$templateData['diffLink'] = $this->createRevisionLink( $revisionId );
			if ( $withReason ) {
				$templateData['reasonLink'] = $this->createRevisionTalkpageLink( $revisionId );
			}
		}

		return $templateData;
	}

	public function createRevisionLink( $revisionId ) {
		return Linker::linkKnown(
			$this->getContext()->getTitle(),
			"#{$revisionId}",
			[
				'target' => '_blank'
			],
			[
				'diff' => $revisionId,
			]
		);
	}

	public function createRevisionTalkpageLink( $revisionId ) {
		return Linker::linkKnown(
			$this->getContext()->getTitle()->getTalkPage(),
			wfMessage( 'content-review-rejection-reason-link' )->escaped(),
			[
				'target' => '_blank'
			]
		);
	}
}
