<?php

namespace Wikia\ContentReview;

use Wikia\ContentReview\Models\ReviewModel;

class Helper {

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

	public function isDiffPageInReviewProcess() {
		global $wgTitle, $wgCityId, $wgRequest;

		$reviewModel = new ReviewModel();
		$reviewData = $reviewModel->getReviewedContent( $wgCityId, $wgTitle->getArticleID(), ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW );
		$diff = $wgRequest->getInt( 'diff' );

		if ( !empty( $reviewData ) && (int)$reviewData['revision_id'] === $diff ) {
			return true;
		}
		return false;
	}
}
