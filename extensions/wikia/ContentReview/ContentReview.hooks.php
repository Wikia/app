<?php

namespace Wikia\ContentReview;

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
		\Hooks::register( 'ArticleDeleteComplete', [ $hooks, 'onArticleDeleteComplete' ] );
		\Hooks::register( 'ArticleUndelete', [ $hooks, 'onArticleUndelete' ] );
		\Hooks::register( 'ShowDiff', [ $hooks, 'onShowDiff' ] );
		\Hooks::register( 'UserRights::groupCheckboxes', [ $hooks, 'onUserRightsGroupCheckboxes' ] );
		\Hooks::register( 'UserAddGroup', [ $hooks, 'onUserAddGroup' ] );
	}

	public function onGetRailModuleList( Array &$railModuleList ) {
		global $wgCityId, $wgTitle, $wgUser;

		if ( $wgTitle->isJsPage() && $wgUser->isLoggedIn() ) {
			$railModuleList[1403] = [ 'ContentReviewModule', 'Render', [
				'wikiId' => $wgCityId,
				'pageId' => $wgTitle->getArticleID(),
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

			$revisionId = $helper->getCurrentlyReviewedRevisionId( $output->getRequest() );
			$output->prependHTML( $helper->getToolbarTemplate( $revisionId ) );
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
		$text = $helper->replaceWithLastApproved( $title, $rawAction->getContentType(), $text );
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

	/**
	 * This method hooks into the Publish process of an article and purges the cached timestamp
	 * of the latest revision made to JS pages. It also handles the auto-approval mechanism for reviewers.
	 * @param \WikiPage $article
	 * @param \User $user
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision
	 * @param $status
	 * @param $baseRevId
	 * @return bool
	 * @throws PermissionsException
	 */
	public function onArticleSaveComplete( \WikiPage &$article, \User &$user, $text, $summary,
			$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId
	) {
		global $wgCityId;

		/**
		 * If no new revision has been created we can quit early.
		 */
		if ( $revision === null ) {
			return true;
		}

		$title = $article->getTitle();

		if ( !is_null( $title )	&&  $title->isJsPage() ) {
			$this->purgeContentReviewData();

			if ( ( new Helper() )->userCanAutomaticallyApprove( $user ) ) {
				( new ContentReviewService() )
					->automaticallyApproveRevision( $user, $wgCityId, $title->getArticleID(), $revision->getId() );
			}
		}

		return true;
	}

	/**
	 * Purges JS pages data
	 *
	 * @param \WikiPage $article
	 * @param \User $user
	 * @param $reason
	 * @param $id
	 */
	public function onArticleDeleteComplete( \WikiPage &$article, \User &$user, $reason, $id ) {
		$title = $article->getTitle();

		if ( !is_null( $title )	&&  $title->isJsPage() ) {
			$this->purgeContentReviewData();
		}

		return true;
	}

	/**
	 * Purges JS pages data
	 *
	 * @param \Title $title
	 * @param $created
	 * @param $comment
	 * @return bool
	 */
	public function onArticleUndelete( \Title $title, $created, $comment ) {
		if ( !is_null( $title )	&&  $title->isJsPage() ) {
			$this->purgeContentReviewData();
		}

		return true;
	}

	/**
	 * Overwrites a message key used instead of a diff view when no `oldid` for comparison is provided.
	 * @param \DifferenceEngine $diff
	 * @param string $notice
	 * @return bool
	 */
	public function onShowDiff( \DifferenceEngine $diff, &$notice ) {
		if ( $diff->getTitle()->inNamespace( NS_MEDIAWIKI )
			&& $diff->getRequest()->getBool( Helper::CONTENT_REVIEW_PARAM )
			&& !$diff->getRequest()->getBool( 'oldid' )
		) {
			$notice = \HTML::rawElement(
				'div',
				[ 'class' => 'content-review-diff-hidden-notice' ],
				wfMessage( 'content-review-diff-hidden' )->escaped()
			);
			return false;
		}
		return true;
	}

	public function onUserRightsGroupCheckboxes( $group, &$disabled, &$irreversible ) {
		global $wgUser;

		if ( $group === 'content-reviewer' && ( !$wgUser->isAllowed( 'content-review' ) || !$wgUser->isStaff() ) ) {
			$disabled = true;
		}

		return true;
	}

	public function onUserAddGroup( \User $user, $group ) {
		global $wgUser;

		if ( $group === 'content-reviewer' && ( !$wgUser->isAllowed( 'content-review' ) || !$wgUser->isStaff() ) ) {
			return false;
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

	private function purgeContentReviewData() {
		$helper = new Helper();
		$helper->purgeCurrentJsPagesTimestamp();

		ContentReviewStatusesService::purgeJsPagesCache();
	}
}
