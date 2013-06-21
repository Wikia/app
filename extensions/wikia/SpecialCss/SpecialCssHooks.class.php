<?php
class SpecialCssHooks {
	/**
	 * @desc Redirects to Special:CSS if this is a try of edition of Wikia.css
	 * 
	 * @param EditPage $editPage
	 * @return bool
	 */
	public function onAlternateEdit(EditPage $editPage) {
		wfProfileIn(__METHOD__);
		$app = F::app();
		$model = new SpecialCssModel();

		if( $this->shouldRedirect($app, $model, $editPage->getArticle()->getTitle()->getArticleId()) ) {
			$oldid = $app->wg->Request->getIntOrNull( 'oldid' );
			$app->wg->Out->redirect( $model->getSpecialCssUrl( false, ( $oldid ) ? array( 'oldid' => $oldid ) : null ) );
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @param $app
	 * @param $model SpecialCssModel
	 * @param integer $articleId
	 * 
	 * @return boolean
	 */
	private function shouldRedirect($app, $model, $articleId) {
		// currently special::css cannot handle undo mode
		if ( $app->wg->Request->getInt( 'undo' ) > 0 && $app->wg->Request->getInt( 'undoafter' ) > 0 ) {
			return false;
		}

		return $app->wg->EnableSpecialCssExt
			&& $model->isWikiaCssArticle( $articleId )
			&& $app->checkSkin( $model::$supportedSkins )
			&& $app->wg->User->isAllowed( 'specialcss' );
	}

	/**
	 * @desc Checks if CSS Update post was added/changed and purges cache with CSS Updates list
	 * 
	 * @param Article $article
	 * 
	 * @return true because it's a hook
	 */
	public function onArticleSaveComplete($article, $user, $text, $summary, $minoredit, $watchthis, $sectionanchor, $flags, $revision, $status, $baseRevId) {
		$app = F::app();
		
		$title = $article->getTitle();
		$categories = ( $title instanceof Title ) ? $title->getParentCategories() : [];
		$categoryNamespace = $app->wg->ContLang->getNsText(NS_CATEGORY);
		$cssUpdatesCagtegory = $categoryNamespace . ':' . SpecialCssModel::UPDATES_CATEGORY;
		
		if( array_key_exists( $cssUpdatesCagtegory, $categories ) ) {
			WikiaDataAccess::cachePurge( wfSharedMemcKey( SpecialCssModel::MEMC_KEY ) );
		}
		
		return true;
	}
}
