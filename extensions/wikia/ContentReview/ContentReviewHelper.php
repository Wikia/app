<?php

namespace Wikia\ContentReview;

use Wikia\ContentReview\Models\CurrentRevisionModel;
use Wikia\ContentReview\Models\ReviewModel;

class Helper {

	const CONTENT_REVIEW_TOOLBAR_CACHE_KEY = 'contentReviewToolbar';
	const CONTENT_REVIEW_TOOLBAR_CACHE_VERSION = '1.0';
	const CONTENT_REVIEW_TOOLBAR_TEMPLATE_PATH = 'extensions/wikia/ContentReview/templates/ContentReviewToolbar.mustache';

	public function getSiteJsScriptsHash() {
		global $wgCityId;

		$maxTimestamp = 0;

		$currentRevisionModel = new Models\CurrentRevisionModel();
		$revisions = $currentRevisionModel->getLatestReviewedRevisionForWiki( $wgCityId );

		foreach ( $revisions as $revision ) {
			$maxTimestamp = max( $maxTimestamp, $revision['touched'] );
		}

		if ( empty( $maxTimestamp ) ) {
			return 0;
		}

		$datetime = new \DateTime( $maxTimestamp );
		$timestamp = $datetime->getTimestamp();

		return $timestamp;
	}

	public function getReviewedRevisionIdFromText( $pageName ) {
		global $wgCityId;

		$title = \Title::newFromText( $pageName );
		$pageId = $title->getArticleID();

		$currentRevisionModel = new Models\CurrentRevisionModel();
		$revision = $currentRevisionModel->getLatestReviewedRevision( $wgCityId, $pageId );

		if ( is_null( $revision['revision_id'] ) ) {
			return 0;
		}

		return $revision['revision_id'];
	}

	public static function getContentReviewTestModeWikis() {
		global $wgRequest;

		$key = \ContentReviewApiController::CONTENT_REVIEW_TEST_MODE_KEY;

		$wikiIds = $wgRequest->getSessionData( $key );

		if ( !empty( $wikiIds ) ) {
			$wikiIds = unserialize( $wikiIds );
		} else {
			$wikiIds = [];
		}

		return $wikiIds;
	}

	public static function setContentReviewTestMode() {
		global $wgCityId, $wgRequest;

		$key = \ContentReviewApiController::CONTENT_REVIEW_TEST_MODE_KEY;

		$wikiIds = self::getContentReviewTestModeWikis();

		if ( !in_array( $wgCityId, $wikiIds ) ) {
			$wikiIds[] = $wgCityId;
			$wgRequest->setSessionData( $key, serialize( $wikiIds ) );
		}
	}

	public static function disableContentReviewTestMode() {
		global $wgCityId, $wgRequest;

		$key = \ContentReviewApiController::CONTENT_REVIEW_TEST_MODE_KEY;

		$wikiIds = self::getContentReviewTestModeWikis();
		$wikiKey = array_search( $wgCityId, $wikiIds );

		if ( $wikiKey !== false ) {
			unset( $wikiIds[$wikiKey]);
			$wgRequest->setSessionData( $key, serialize( $wikiIds ) );
		}

	}

	public static function isContentReviewTestModeEnabled() {
		global $wgUser, $wgCityId;

		$contentReviewTestModeEnabled = false;

		if ( $wgUser->isLoggedIn() ) {
			$wikisIds = self::getContentReviewTestModeWikis();

			if ( !empty( $wikisIds ) && in_array( $wgCityId, $wikisIds ) ) {
				$contentReviewTestModeEnabled = true;
			}
		}

		return $contentReviewTestModeEnabled;
	}

	public static function isStatusAwaiting( $status ) {
		return in_array( (int) $status, [
				ReviewModel::CONTENT_REVIEW_STATUS_UNREVIEWED,
				ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW,
			]
		);
	}

	public function isDiffPageInReviewProcess( $wikiId, $pageId, $diff ) {

		$reviewModel = new ReviewModel();
		$reviewData = $reviewModel->getReviewedContent( $wikiId, $pageId, ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW );

		if ( !empty( $reviewData ) && (int)$reviewData['revision_id'] === $diff ) {
			return true;
		}
		return false;
	}

	public function hasPageApprovedId( $wikiId, $pageId, $oldid ) {

		$currentModel = new CurrentRevisionModel();
		$currentData = $currentModel->getLatestReviewedRevision( $wikiId, $pageId );

		if ( !empty( $currentData ) && (int)$currentData['revision_id'] === $oldid ) {
			return true;
		}
		return false;
	}

	public function getToolbarTemplate() {
		global $wgMemc, $wgCityId, $wgTitle;

		$key = wfMemcKey( self::CONTENT_REVIEW_TOOLBAR_CACHE_KEY, self::CONTENT_REVIEW_TOOLBAR_CACHE_VERSION );
		$template = $wgMemc->get( $key );

		if ( !$template ) {
			$template = \MustacheService::getInstance()->render(
				self::CONTENT_REVIEW_TOOLBAR_TEMPLATE_PATH,
				[
					'toolbarTitle' => wfMessage( 'content-review-diff-toolbar-title' )->plain(),
					'wikiId' => $wgCityId,
					'pageId' => $wgTitle->getArticleID(),
					'approveStatus' => ReviewModel::CONTENT_REVIEW_STATUS_APPROVED,
					'buttonApproveText' => wfMessage( 'content-review-diff-approve' )->plain(),
					'rejectStatus' => ReviewModel::CONTENT_REVIEW_STATUS_REJECTED,
					'buttonRejectText' => wfMessage( 'content-review-diff-reject' )->plain(),
					'talkpageUrl' => $wgTitle->getTalkPage()->getFullURL(),
					'talkpageLinkText' => wfMessage( 'content-review-diff-toolbar-talkpage' )->plain(),
					'guidelinesUrl' => wfMessage( 'content-review-diff-toolbar-guidelines-url' )->plain(),
					'guidelinesLinkText' => wfMessage( 'content-review-diff-toolbar-guidelines' )->plain(),
				]
			);

			$wgMemc->set( $key, $template, \WikiaResponse::CACHE_LONG );
		}

		return $template;
	}
}
