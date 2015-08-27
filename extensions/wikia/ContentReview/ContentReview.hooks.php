<?php

namespace Wikia\ContentReview;

use Wikia\ContentReview\Models\CurrentRevisionModel;
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
		global $wgTitle, $wgCityId, $wgRequest;
		$diff = $wgRequest->getInt( 'diff' );
		$oldid = $wgRequest->getInt( 'oldid' );

		$helper = new Helper();
		if ( $wgTitle->inNamespace( NS_MEDIAWIKI )
			&& $wgTitle->isJsPage()
			&& $wgTitle->userCan( 'content-review' )
			&& $helper->isDiffPageInReviewProcess( $wgCityId, $wgTitle->getArticleID(), $diff )
			&& $helper->hasPageApprovedId( $wgCityId, $wgTitle->getArticleID(), $oldid )

		) {
			\Wikia::addAssetsToOutput( 'content_review_diff_page_js' );
			\JSMessages::enqueuePackage( 'ContentReviewDiffPage', \JSMessages::EXTERNAL );

			$output->prependHTML(
				\Xml::element( 'button',
					[
						'class' => 'content-review-diff-button',
						'data-wiki-id' => $wgCityId,
						'data-page-id' => $wgTitle->getArticleID(),
						'data-status' => ReviewModel::CONTENT_REVIEW_STATUS_REJECTED
					],
					wfMessage( 'content-review-diff-reject' )->plain()
				)
			);

			$output->prependHTML(
				\Xml::element( 'button',
					[
						'class' => 'content-review-diff-button',
						'data-wiki-id' => $wgCityId,
						'data-page-id' => $wgTitle->getArticleID(),
						'data-status' => ReviewModel::CONTENT_REVIEW_STATUS_APPROVED
					],
					wfMessage( 'content-review-diff-approve' )->plain()
				)
			);

		}

		return true;
	}

	public static function onRawPageViewBeforeOutput( \RawAction $rawAction, &$text ) {
		global $wgCityId;

		$title = $rawAction->getTitle();

		if ( $title->inNamespace( NS_MEDIAWIKI ) && $title->isJsPage() ) {
			$pageId = $title->getArticleID();
			$latestRevId = $title->getLatestRevID();

			$latestReviewedRev = ( new CurrentRevisionModel() )->getLatestReviewedRevision( $wgCityId, $pageId );
			$isContentReviewTestMode = Helper::isContentReviewTestModeEnabled();

			if ( !empty( $latestReviewedRev['revision_id'] )
				&& $latestReviewedRev['revision_id'] != $latestRevId
				&& !$isContentReviewTestMode
			) {
				$revision = \Revision::newFromId( $latestReviewedRev['revision_id'] );

				if ( $revision ) {
					$text = $revision->getRawText();
				} else {
					$text = '';
				}
			}
		}

		return true;
	}
}
