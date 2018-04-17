<?php

namespace Wikia\ContentReview;

class ImportJSHooks {

	public static function register() {
		$hooks = new self();
		\Hooks::register( 'ArticleSaveComplete', [ $hooks, 'onArticleSaveComplete' ] );
		\Hooks::register( 'ArticleDeleteComplete', [ $hooks, 'onArticleDeleteComplete' ] );
		\Hooks::register( 'ArticleUndelete', [ $hooks, 'onArticleUndelete' ] );
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

	/**
	 * Add script to load safe imports
	 *
	 * @param \Skin $skin
	 * @param String $bottomScripts
	 * @return bool
	 * @throws \MWException
	 */
	public function onSkinAfterBottomScripts( $skin, &$bottomScripts ) {
		if ( $skin->getRequest()->getBool( 'usesitejs', true ) !== false && $skin->getOutput()->isUserJsAllowed() ) {
			$bottomScripts .= ( new ImportJS() )->getImportScripts();
		}

		return true;
	}

	/**
	 * This method hooks into the Publish process of an article and purges the cached timestamp
	 * of the latest revision made to JS pages.
	 *
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
	 */
	public function onArticleSaveComplete( \WikiPage $article, \User $user, $text, $summary,
			$minoredit, $watchthis, $sectionanchor, $flags, $revision, &$status, $baseRevId
	): bool {
		/**
		 * If no new revision has been created we can quit early.
		 */
		if ( $revision === null ) {
			return true;
		}

		$title = $article->getTitle();

		if ( !is_null( $title ) ) {
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
	public function onArticleDeleteComplete( \WikiPage $article, \User $user, $reason, $id ): bool {
		$title = $article->getTitle();

		if ( !is_null( $title )	) {
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
			if ( ImportJS::isImportJSPage( $title ) ) {
				ImportJS::purgeImportScripts();
			}
		}

		return true;
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
