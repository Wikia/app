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
			$pageStatus = \F::app()->sendRequest(
				'ContentReviewApiController',
				'getPageStatus',
				[
					'wikiId' => $wgCityId,
					'pageId' => $wgTitle->getArticleID(),
				],
				true
			)->getData();

			$railModuleList[1503] = [ 'ContentReviewModule', 'Render', [
				'pageStatus' => $pageStatus,
				'latestRevisionId' => $wgTitle->getLatestRevID(),
			] ];
		}

		return true;
	}

	public static function onMakeGlobalVariablesScript( &$vars ) {
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

		if ( $wgTitle->inNamespace( NS_MEDIAWIKI )
			&& $wgTitle->isJsPage()
			&& $wgTitle->userCan( 'content-review' )
		) {
			\Wikia::addAssetsToOutput( 'content_review_diff_page_js' );
			\JSMessages::enqueuePackage( 'ContentReviewDiffPage', \JSMessages::EXTERNAL );

			$output->prependHTML(
				\Xml::element( 'button',
					[
						'class' => 'content-review-diff-button',
						'data-wiki-id' => ( $wgCityId ),
						'data-page-id' => \Title::newFromText( $wgTitle->getArticleID() ),
						'data-status' => ReviewModel::CONTENT_REVIEW_STATUS_REJECTED
					],
					wfMessage( 'content-review-diff-reject' )->plain()
				)
			);

			$output->prependHTML(
				\Xml::element( 'button',
					[
						'class' => 'content-review-diff-button',
						'data-wiki-id' => ( $wgCityId ),
						'data-page-id' => \Title::newFromText( $wgTitle->getArticleID() ),
						'data-status' => ReviewModel::CONTENT_REVIEW_STATUS_APPROVED
					],
					wfMessage( 'content-review-diff-approve' )->plain()
				)
			);
		}

		return true;
	}
}
