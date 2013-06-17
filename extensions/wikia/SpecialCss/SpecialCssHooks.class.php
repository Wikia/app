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
			$app->wg->Out->redirect( $model->getSpecialCssUrl() );
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @param $model SpecialCssModel
	 */
	private function shouldRedirect($app, $model, $articleId) {
		return $app->wg->EnableSpecialCssExt
			&& $model->isWikiaCssArticle( $articleId )
			&& $app->checkSkin( $model::$supportedSkins )
			&& $app->wg->User->isAllowed( 'specialcss' );
	}

	/**
	 * @desc Checks if CSS Update post was added, and purges cache with CSS Updates list
	 */
	public function onArticleSaveComplete($article) {
		$categories = $article->getTitle()->getParentCategories();
		if ( array_key_exists( "Category:" . SpecialCssModel::UPDATES_CATEGORY, $categories ) ) {
			WikiaDataAccess::cachePurge( wfSharedMemcKey(SpecialCssModel::MEMC_KEY) );
		}
		return true;
	}
}
