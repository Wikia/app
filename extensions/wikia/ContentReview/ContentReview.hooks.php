<?php

namespace Wikia\ContentReview;

use Wikia\ContentReview\Helper;
use Wikia\ContentReview\Models\CurrentRevisionModel;
use Wikia\ContentReview\Models\ReviewModel;

class Hooks {
	const CONTENT_REVIEW_MONOBOOK_DROPDOWN_ACTION = 'content-review';

	public static function register() {
		$hooks = new self();
		\Hooks::register( 'GetRailModuleList', [ $hooks, 'onGetRailModuleList' ] );
		\Hooks::register( 'MakeGlobalVariablesScript', [ $hooks, 'onMakeGlobalVariablesScript' ] );
		\Hooks::register( 'BeforePageDisplay', [ $hooks, 'onBeforePageDisplay' ] );
		\Hooks::register( 'ArticleContentOnDiff', [ $hooks, 'onArticleContentOnDiff' ] );
		\Hooks::register( 'RawPageViewBeforeOutput', [ $hooks, 'onRawPageViewBeforeOutput' ] );
		\Hooks::register( 'SkinTemplateNavigation', [ $hooks, 'onSkinTemplateNavigation' ] );
		\Hooks::register( 'UserLogoutComplete', [ $hooks, 'onUserLogoutComplete' ] );
		\Hooks::register( 'ArticleSaveComplete', [ $hooks, 'onArticleSaveComplete' ] );
	}

	public function onGetRailModuleList( Array &$railModuleList ) {
		global $wgCityId, $wgTitle, $wgUser;

		if ( ( new Helper() )->userCanEditJsPage( $wgTitle, $wgUser ) ) {
			$pageStatus = \F::app()->sendRequest(
				'ContentReviewApiController',
				'getPageStatus',
				[
					'wikiId' => $wgCityId,
					'pageId' => $wgTitle->getArticleID(),
				],
				true
			)->getData();

			$railModuleList[1403] = [ 'ContentReviewModule', 'Render', [
				'pageStatus' => $pageStatus,
				'latestRevisionId' => $wgTitle->getLatestRevID(),
			] ];
		}

		return true;
	}

	public function onMakeGlobalVariablesScript( &$vars ) {
		$helper = new Helper();

		$vars['wgContentReviewExtEnabled'] = true;
		$vars['wgContentReviewTestModeEnabled'] = $helper->isContentReviewTestModeEnabled();
		$vars['wgReviewedScriptsTimestamp'] = $helper->getReviewedJsPagesTimestamp();
		$vars['wgScriptsTimestamp'] = $helper->getJsPagesTimestamp();

		return true;

	}

	public function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$helper = new Helper();
		$title = $out->getTitle();
		$user = $out->getContext()->getUser();

		/* Add assets for custom JS test mode */
		if ( $helper->isContentReviewTestModeEnabled() || $helper->userCanEditJsPage( $title, $user ) ) {
			\Wikia::addAssetsToOutput( 'content_review_test_mode_js' );
			\JSMessages::enqueuePackage( 'ContentReviewTestMode', \JSMessages::EXTERNAL );
		}

		/* Add Content Review Module assets for Monobook  */
		if ( $helper->userCanEditJsPage( $title, $user ) ) {
			\Wikia::addAssetsToOutput('content_review_module_monobook_js');
			\Wikia::addAssetsToOutput('content_review_module_monobook_scss');
		}

		return true;
	}

	public function onArticleContentOnDiff( $diffEngine, \OutputPage $output ) {
		$helper = new Helper();

		if ( $helper->shouldDisplayReviewerToolbar() ) {
			\Wikia::addAssetsToOutput( 'content_review_diff_page_js' );
			\Wikia::addAssetsToOutput( 'content_review_diff_page_scss' );
			\JSMessages::enqueuePackage( 'ContentReviewDiffPage', \JSMessages::EXTERNAL );

			$output->prependHTML( $helper->getToolbarTemplate() );
		}

		return true;
	}

	/**
	 * Replace content shown on raw action for JS pages with last approved revision
	 * @param \RawAction $rawAction
	 * @param $text
	 * @return bool
	 */
	public function onRawPageViewBeforeOutput( \RawAction $rawAction, &$text ) {
		$title = $rawAction->getTitle();
		$helper = new Helper();
		$helper->replaceWithLastApproved( $title, $rawAction->getContentType(), $text );
		return true;
	}

	/*
	 * Adds review status item to top nav tabs in Monobook skin.
	 * This is an entrypoint for checking review status and submitting changes for review/
	 * This is attached to the MediaWiki 'SkinTemplateNavigation' hook.
	 * @param SkinTemplate $skin Object of specific skin class that extends SkinTemplate
	 * @param array $links Navigation links
	 * @return bool true
	 */
	public function onSkinTemplateNavigation( \SkinTemplate $skin, &$links ) {
		global $wgCityId;

		$title = $skin->getTitle();
		$user = $skin->getContext()->getUser();

		if ( !in_array( $skin->getSkinName(), [ 'monobook', 'uncyclopedia' ] )
			|| !( new Helper() )->userCanEditJsPage( $title, $user ) )
		{
			return true;
		}

		$latestRevisionId = $title->getLatestRevID();
		$revisionModel = new ReviewModel();
		$revisionInfo = $revisionModel->getRevisionInfo( $wgCityId, $title->getArticleID(), $latestRevisionId );
		$latestStatusName = $revisionModel->getStatusName( $revisionInfo['status'], $latestRevisionId );

		/* Add link to nav tabs customized with status class name */
		$links['views'][self::CONTENT_REVIEW_MONOBOOK_DROPDOWN_ACTION] = [
			'href' => '#',
			'text' => wfMessage( 'content-review-status-link-text' )->escaped(),
			'class' => 'content-review-status ' . 'content-review-cactions-status-' . $latestStatusName,
		];

		return true;
	}

	public function onUserLogoutComplete( \User $user, &$injected_html, $oldName) {
		$request = $user->getRequest();
		$this->disableTestMode( $request );

		return true;
	}

	public function onArticleSaveComplete( \WikiPage &$article, &$user, $text, $summary,
			$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId
	) {
		global $wgRequest;

		$title = $article->getTitle();

		if ( !is_null( $title )	&&  $title->isJsPage() ) {
			( new Helper() )->purgeCurrentJsPagesTimestamp();

			if ( $user->isAllowed( 'content-review' ) && $wgRequest->getBool( 'wpApproved' ) ) {
				//TODO: Add data
				$data = [];

				\F::app()->sendRequest(
					'ContentReviewApiController',
					'getPageStatus',
					$data,
					true
				);
			}
		}

		return true;
	}

	private function disableTestMode( \WebRequest $request ) {
		$key = \ContentReviewApiController::CONTENT_REVIEW_TEST_MODE_KEY;

		$wikis = $request->getSessionData( $key );
		if ( !empty( $wikis ) ) {
			$request->setSessionData( $key, null );
		}
	}
}
