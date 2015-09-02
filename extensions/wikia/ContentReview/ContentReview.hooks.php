<?php

namespace Wikia\ContentReview;

use Wikia\ContentReview\Models\CurrentRevisionModel;

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

			$railModuleList[1403] = [ 'ContentReviewModule', 'Render', [
				'pageStatus' => $pageStatus,
				'latestRevisionId' => $wgTitle->getLatestRevID(),
			] ];
		}

		return true;
	}

	public static function onMakeGlobalVariablesScript( &$vars ) {
		$helper = new Helper();

		$vars['contentReviewExtEnabled'] = true;
		$vars['contentReviewTestModeEnabled'] = $helper->isContentReviewTestModeEnabled();
		$vars['contentReviewScriptsHash'] = $helper->getSiteJsScriptsHash();

		return true;

	}

	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$helper = new Helper();

		if ( $helper->isContentReviewTestModeEnabled() || self::userCanEditJsPage() ) {
			\Wikia::addAssetsToOutput( 'content_review_test_mode_js' );
			\JSMessages::enqueuePackage( 'ContentReviewTestMode', \JSMessages::EXTERNAL );
		}

		return true;
	}

	public static function onArticleContentOnDiff( $diffEngine, \OutputPage $output ) {
		$helper = new Helper();

		if ( $helper->shouldDisplayReviewerToolbar() ) {
			\Wikia::addAssetsToOutput( 'content_review_diff_page_js' );
			\Wikia::addAssetsToOutput( 'content_review_diff_page_scss' );
			\JSMessages::enqueuePackage( 'ContentReviewDiffPage', \JSMessages::EXTERNAL );

			$output->prependHTML( $helper->getToolbarTemplate() );
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
			$helper = new Helper();

			if ( $latestReviewedRev['revision_id'] != $latestRevId
				&& !$helper->isContentReviewTestModeEnabled()
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

	public static function onResourceLoaderModifyMaxAge( \ResourceLoader $rl, \ResourceLoaderContext $context, $mtime, &$maxage, &$smaxage ) {
		if ( ( new Helper() )->isContentReviewTestModeEnabled() ) {
			foreach ( $context->getModules() as $moduleName ) {
				$module = $rl->getModule( $moduleName );
				if ( $module instanceof \ResourceLoaderSiteModule && $context->getOnly() == 'scripts' ) {
					$maxage = 0;
					$smaxage = 0;
				} elseif ( $module instanceof \ResourceLoaderCustomWikiModule ) {
					foreach ( $module->getPages( $context ) as $pageName => $page ) {
						if ( $page['type'] == 'script' ) {
							$title = \Title::newFromText( $pageName );
							if ( $title->inNamespace( NS_MEDIAWIKI ) ) {
								$maxage = 0;
								$smaxage = 0;
							}
						}
					}
				}
			}
		}

		return true;
	}

	private static function userCanEditJsPage() {
		global $wgTitle, $wgUser;

		return $wgTitle->inNamespace( NS_MEDIAWIKI ) && $wgTitle->isJsPage() && $wgTitle->userCan( 'edit', $wgUser );
	}
}
