<?php

namespace Wikia\ContentReview;

use Wikia\ContentReview\Models\ReviewModel;

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

	public static function onMakeGlobalVariablesScript(&$vars) {
		$vars['contentReviewTestModeEnabled'] = Helper::isContentReviewTestModeEnabled();

		return true;

	}

	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( Helper::isContentReviewTestModeEnabled() ) {
			\Wikia::addAssetsToOutput( 'content_review_test_mode_js' );
			\JSMessages::enqueuePackage( 'ContentReviewTestMode', \JSMessages::EXTERNAL );
		}

		return true;
	}

	public static function onArticleContentOnDiff( $diffEngine, \OutputPage $output ) {
		global $wgTitle, $wgCityId;

		\Wikia::addAssetsToOutput('content_review_diff_page_js');
		\JSMessages::enqueuePackage( 'ContentReviewDiffPage', \JSMessages::EXTERNAL );

		if ( $wgTitle->inNamespace( NS_MEDIAWIKI )
			&& $wgTitle->isJsPage()
			&& $wgTitle->userCan( 'content-review')	) {
			$output->prependHTML(\Linker::link(
				$wgTitle,
				wfMessage('content-review-diff-reject'),
				[
					'class' => 'content-review-diff-reject  wikia-button primary',
					'data-wiki-id' => ($wgCityId),
					'data-page-id' => \Title::newFromText($wgTitle->getArticleID()),
					'data-status' => ReviewModel::CONTENT_REVIEW_STATUS_REJECTED
				]

			));
			$output->prependHTML(\Linker::link(
				$wgTitle,
				wfMessage('content-review-diff-approve'),
				[
					'class' => 'content-review-diff-approve  wikia-button primary',
					'data-wiki-id' => ($wgCityId),
					'data-page-id' => \Title::newFromText($wgTitle->getArticleID()),
					'data-status' => ReviewModel::CONTENT_REVIEW_STATUS_APPROVED
				]

			));

		}
	return true;
	}
}
