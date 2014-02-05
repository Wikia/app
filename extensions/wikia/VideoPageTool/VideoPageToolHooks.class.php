<?php

class VideoPageToolHooks {

	/**
	 * @param Title $title
	 * @param Article $article
	 * @return boolean
	 */
	public static function onArticleFromTitle( &$title, &$article ) {
		wfProfileIn(__METHOD__);
		$app = F::app();

		if ( $title->isMainPage() && $app->checkSkin( 'oasis' ) ) {
			$app->wg->SuppressPageHeader = true;
			$app->wg->SuppressWikiHeader = true;
			$app->wg->SuppressRail = true;
			$app->wg->SuppressFooter = true;
			if ( !$app->wg->request->wasPosted() ) {
				// don't change article object while saving data
				$article = new VideoHomePageArticle( $title );
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Hook: Clear cache (videos by category) when the category page is purged
	 * @param WikiPage $page
	 * @return true
	 */
	public static function onArticlePurge( WikiPage &$page ) {
		wfProfileIn( __METHOD__ );

		$title = $page->getTitle();
		if ( $title->getNamespace() == NS_CATEGORY ) {
			$helper = new VideoPageToolHelper();
			$helper->invalidateCacheVideosByCategory( $title->getDBkey() );
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * Hook: Clear cache (videos by category) when adding new category on file page
	 * @param Title $title
	 * @param array $categories
	 * @return true
	 */
	public static function onCategorySelectSave( $title, $categories ) {
		if ( $title instanceof Title && is_array( $categories ) && $title->getNamespace() == NS_FILE ) {
			$helper = new VideoPageToolHelper();
			foreach ( $categories as $category ) {
				if ( !empty( $category['namespace'] ) && $category['namespace'] == F::app()->wg->ContLang->getFormattedNsText( NS_CATEGORY ) ) {
					$categoryTitle = Title::newFromText( $category['name'], NS_CATEGORY );
					if ( !empty( $categoryTitle ) ) {
						$helper->invalidateCacheVideosByCategory( $categoryTitle->getDBkey() );
					}
				}
			}
		}

		return true;
	}

	/**
	 * Hook: Clear cache (videos by category) when video ingestion is completed
	 * @param Title $title
	 * @param array $categories
	 * @return true
	 */
	public static function onVideoIngestionComplete( $title, $categories ) {
		if ( $title instanceof Title && is_array( $categories ) ) {
			$helper = new VideoPageToolHelper();
			foreach ( $categories as $category ) {
				$categoryTitle = Title::newFromText( $category, NS_CATEGORY );
				if ( !empty( $categoryTitle ) ) {
					$helper->invalidateCacheVideosByCategory( $categoryTitle->getDBkey() );
				}
			}
		}

		return true;
	}

	/**
	 * Hook: Clear cache (videos by category) when video is deleted. We don't need
	 * any of the parameters OnFileDeleteComplete passes in by default, instead we
	 * find the latest program, and clear the cache for the category names defined
	 * in the category assets for that program.
	 * @return true
	 */
	public static function onFileDeleteComplete( &$file, $oldimage, $article, $user, $reason ) {
		$controller = new VideoHomePageController();
		$program = $controller->getProgram();
		$assets = $program->getAssetsBySection( VideoHomePageController::MODULE_CATEGORY );
		$helper = new VideoPageToolHelper();
		foreach ( $assets as $asset ) {
			$title = Title::newFromText( $asset->getCategoryName(), NS_CATEGORY );
			$helper->invalidateCacheVideosByCategory( $title->getDBkey() );
		}

		return true;
	}

}
