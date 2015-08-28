<?php

namespace Wikia\ContentReview;

use Wikia\ContentReview\Models\CurrentRevisionModel;
use Wikia\ContentReview\Models\ReviewModel;

class Hooks {

	public static function onGetRailModuleList( Array &$railModuleList ) {
		global $wgCityId, $wgTitle;

		if ( self::userCanEditJsPage() ) {
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

	public static function onMakeGlobalVariablesScript(&$vars) {
		$helper = new Helper();

		$vars['contentReviewExtEnabled'] = true;
		$vars['contentReviewTestModeEnabled'] = $helper::isContentReviewTestModeEnabled();
		$vars['contentReviewScriptsHash'] = $helper->getSiteJsScriptsHash();

		return true;

	}

	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( Helper::isContentReviewTestModeEnabled() || self::userCanEditJsPage() ) {
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
		global $wgCityId, $wgJsMimeType;

		$title = $rawAction->getTitle();

		if ( $title->inNamespace( NS_MEDIAWIKI )
			&& ( $title->isJsPage() || $rawAction->getContentType() == $wgJsMimeType )
		) {
			$pageId = $title->getArticleID();
			$latestRevId = $title->getLatestRevID();

			$latestReviewedRev = ( new CurrentRevisionModel() )->getLatestReviewedRevision( $wgCityId, $pageId );
			$isContentReviewTestMode = Helper::isContentReviewTestModeEnabled();

			if ( $latestReviewedRev['revision_id'] != $latestRevId
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

	public static function onUserLogoutComplete( \User $user, &$injected_html, $oldName) {
		$request = $user->getRequest();

		$key = \ContentReviewApiController::CONTENT_REVIEW_TEST_MODE_KEY;
		$wikis = $request->getSessionData( $key );

		if ( !empty( $wikis ) ) {
			$request->setSessionData( $key, null );
		}

		return true;
	}

	private static function userCanEditJsPage() {
		global $wgTitle, $wgUser;

		return $wgTitle->inNamespace( NS_MEDIAWIKI ) && $wgTitle->isJsPage() && $wgTitle->userCan( 'edit', $wgUser );
	}
}
