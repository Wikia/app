<?php

namespace Wikia\ContentReview;

class Hooks {

	public static function onGetRailModuleList( Array &$railModuleList ) {
		global $wgCityId, $wgTitle, $wgUser;

		if ( $wgTitle->inNamespace( NS_MEDIAWIKI )
			&& $wgTitle->isJsPage()
			&& $wgTitle->userCan( 'edit', $wgUser )
		) {
			$currentPageData = \F::app()->sendRequest(
				'ContentReviewApiController',
				'getCurrentPageData',
				[
					'wikiId' => $wgCityId,
					'pageId' => $wgTitle->getArticleID(),
				],
				true
			)->getData();

			$latestRevId = $wgTitle->getLatestRevID();

			/**
			 * 1. If the latest rev_id is equal to the current reviewed one - do nothing
			 */
			if ( intval( $currentPageData['reviewedRevisionId'] ) !== $latestRevId ) {
				/**
				 * 2. If there is no revision in review - display the module with a submit call.
				 */
				if ( $currentPageData['revisionInReviewId'] === null ) {
					$railModuleList[1503] = [ 'ContentReviewModule', 'Render', [
						'moduleType' => \ContentReviewModuleController::MODULE_TYPE_UNREVIEWED,
					] ];
				/**
				 * 3. If the latest rev_id is equal to the one that is already in review -
				 * display the module without an action call.
				 */
				} elseif ( intval( $currentPageData['revisionInReviewId'] ) === $latestRevId ) {
					$railModuleList[1503] = [ 'ContentReviewModule', 'Render', [
						'moduleType' => \ContentReviewModuleController::MODULE_TYPE_CURRENT,
					] ];
				/**
				 * 4. If the latest rev_id is not equal to the one that is already in review -
				 * display the module with an update action call.
				 */
				} elseif ( intval( $currentPageData['revisionInReviewId'] ) !== $latestRevId ) {
					$railModuleList[1503] = [ 'ContentReviewModule', 'Render', [
						'moduleType' => \ContentReviewModuleController::MODULE_TYPE_IN_REVIEW,
					] ];
				}
			}
		}

		return true;
	}
}
