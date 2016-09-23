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
		\Hooks::register( 'SkinAfterBottomScripts', [ $hooks, 'onSkinAfterBottomScripts' ] );
		\Hooks::register( 'ArticleNonExistentPage', [ $hooks, 'onArticleNonExistentPage' ] );
		\Hooks::register( 'OutputPageBeforeHTML', [ $hooks, 'onOutputPageBeforeHTML' ] );
	}

	/**
	 * Add description how to import scripts on view page
	 *
	 * @param \OutputPage $out
	 * @param $content
	 * @return bool
	 */
	public function onOutputPageBeforeHTML( \OutputPage $out, &$content ) {
		$title = $out->getTitle();

		if ( $title->exists() ) {
			if ( ImportJS::isImportJSPage( $title ) ) {
				$message = ImportJS::getImportJSDescriptionMessage();
				$content = $this->prepareContent( $title, $content, $message );
			} elseif ( ProfileTags::isProfileTagsPage( $title ) ) {
				$message = ProfileTags::getProfileTagsDescriptionMessage();
				$content = $this->prepareContent( $title, $content, $message );
			}
		}

		return true;
	}

	/**
	 * Add description how to import scripts on non existing page
	 *
	 * @param \Article $article
	 * @param String $content
	 * @return bool
	 */
	public function onArticleNonExistentPage( \Article $article, \OutputPage $out, &$content ) {
		$title = $article->getTitle();

		if ( ImportJS::isImportJSPage( $title ) ) {
			$message = ImportJS::getImportJSDescriptionMessage();
			$content = $this->prepareContent( $title, $content, $message, false );
		} elseif ( ProfileTags::isProfileTagsPage( $title ) ) {
			$message = ProfileTags::getProfileTagsDescriptionMessage();
			$content = $this->prepareContent( $title, $content, $message, false );
		}

		return true;
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

	/**
	 * Add script to load safe imports
	 *
	 * @param $skin
	 * @param String $bottomScripts
	 * @return bool
	 * @throws \MWException
	 */
	public function onSkinAfterBottomScripts( $skin, &$bottomScripts ) {
		global $wgUseSiteJs;

		if ( !empty( $wgUseSiteJs ) ) {
			$bottomScripts .= ( new ImportJS() )->getImportScripts();
		}

		return true;
	}

	/**
	 * Initiates a diff page Content Review controller and renders a reviewer's toolbar.
	 * @param $diffEngine
	 * @param \OutputPage $output
	 * @return bool
	 */
	public function onArticleContentOnDiff( $diffEngine, \OutputPage $output ) {
		$title = $output->getTitle();
		$diffPage = new ContentReviewDiffPage( $title );

		if ( $diffPage->shouldDisplayToolbar() ) {
			$diffPage->addToolbarToOutput( $output );
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
		global $wgCityId;

		$title = $rawAction->getTitle();
		$titleText = $title->getText();

		if ( $wgCityId == Helper::DEV_WIKI_ID && !$title->inNamespace( NS_MEDIAWIKI ) ) {
			$title = \Title::newFromText( $titleText, NS_MEDIAWIKI );

			// TODO: After scripts transition on dev wiki is done, remove this if statement (CE-3093)
			if ( !$title || !$title->exists() ) {
				return true;
			}

			$text = \Revision::newFromTitle( $title )->getRawText();
		}

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

		if ( !is_null( $title ) ) {
			if ( $title->isJsPage() ) {
				$this->purgeContentReviewData();

				if ( ( new Helper() )->userCanAutomaticallyApprove( $user ) ) {
					( new ContentReviewService() )
						->automaticallyApproveRevision( $user, $wgCityId, $title->getArticleID(), $revision->getId() );
				}
			}

			if ( ImportJS::isImportJSPage( $title ) ) {
				ImportJS::purgeImportScripts();
				\WikiPage::factory( $title )->doPurge();
			}
		}

		return true;
	}

	/**
	 * Purges JS pages data and removes data on a deleted page from the database
	 *
	 * @param \WikiPage $article
	 * @param \User $user
	 * @param $reason
	 * @param $id
	 * @return bool
	 */
	public function onArticleDeleteComplete( \WikiPage &$article, \User &$user, $reason, $id ) {
		global $wgCityId;

		$title = $article->getTitle();

		if ( !is_null( $title )	) {
			if ( $title->isJsPage() ) {
				$service = new ContentReviewService();
				$service->deletePageData( $wgCityId, $id );

				$this->purgeContentReviewData();
			}

			if ( ImportJS::isImportJSPage( $title ) ) {
				ImportJS::purgeImportScripts();
			}
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
		if ( !is_null( $title )	) {
			if ( $title->isJsPage() ) {
				$this->purgeContentReviewData();
			}

			if ( ImportJS::isImportJSPage( $title ) ) {
				ImportJS::purgeImportScripts();
			}
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

	private function prepareContent( \Title $title, $content, \Message $message, $parse = true ) {
		$isViewPage = empty( \RequestContext::getMain()->getRequest()->getVal( 'action' ) );

		if ( $isViewPage ) {
			$text = $parse ? $message->parse() : $message->escaped();
			$content = $text . '<pre>' . trim( strip_tags( $content ) ) . '</pre>';
		}

		return $content;
	}
}
