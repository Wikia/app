<?php
class SpecialCssHooks {
	/**
	 * @desc Redirects to Special:CSS if this is a try of edition of Wikia.css
	 * 
	 * @param EditPage $editPage
	 * @return bool
	 */
	public function onAlternateEdit( EditPage $editPage ) {
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
	 * @param $app
	 * @param $model SpecialCssModel
	 * @param integer $articleId
	 * 
	 * @return boolean
	 */
	private function shouldRedirect( $app, $model, $articleId ) {
		return $app->wg->EnableSpecialCssExt
			&& $model->isWikiaCssArticle( $articleId )
			&& $app->checkSkin( $model::$supportedSkins )
			&& $app->wg->User->isAllowed( 'specialcss' );
	}
	
	/**
	 * @desc Checks if CSS Update post was added/changed and purges cache with CSS Updates list
	 * 
	 * @param Article $article
	 * @param Revision $revision
	 * 
	 * @return true because it's a hook
	 */
	public function onArticleSaveComplete( $article, $user, $text, $summary, $minoredit, $watchthis, $sectionanchor, $flags, $revision, $status, $baseRevId ) {
		$title = $article->getTitle();
		$categories = ( $title instanceof Title ) ? $this->removeNamespace( array_keys( $title->getParentCategories() ) ) : [];
		
		if( in_array( SpecialCssModel::UPDATES_CATEGORY, $categories ) ) {
			// purging "Wikia CSS Updates" cache because a new post was added to the category
			WikiaDataAccess::cachePurge( wfSharedMemcKey( SpecialCssModel::MEMC_KEY ) );
		} else if( $this->prevRevisionHasCssUpdatesCat($revision) ) {
			// purging "Wikia CSS Updates" cache because a post within the category was removed from the category
			WikiaDataAccess::cachePurge( wfSharedMemcKey( SpecialCssModel::MEMC_KEY ) );
		}
		
		return true;
	}

	/**
	 * @desc Removes category namespace name in content language i.e. 'Category:Abc' will result with 'Abc'
	 * 
	 * @param Array $categories an array of categories with the namespace i.e. ['Category:Abc', 'Category:Def', 'Category:Ghi'] or ['Kategoria:Abc', 'Kategoria:Def', 'Kategoria:Ghi']
	 * 
	 * @return array
	 */
	private function removeNamespace( $categories ) {
		$app = F::app();
		$results = [];
		$categoryNamespace = $app->wg->ContLang->getNsText(NS_CATEGORY);
		
		foreach( $categories as $category ) {
			$results[] = str_replace($categoryNamespace . ':', '', $category);
		}
		
		return $results;
	}

	/**
	 * @desc Retrives categories list from previous revision's text and if there is "CSS Updates" category returns true 
	 * 
	 * @param Revision $rev
	 * 
	 * @return bool
	 */
	private function prevRevisionHasCssUpdatesCat( Revision $rev ) {
		return ( ( $prevRev = $rev->getPrevious() ) instanceof Revision ) &&
			in_array( SpecialCssModel::UPDATES_CATEGORY, $this->getCategoriesFromWikitext( $prevRev->getRawText() ) );
	}

	/**
	 * @desc Using CategorySelect::extractCategoriesFromWikitext() retrives categories' data array which then is being flattern to categories' names with replaces spacebar to _
	 * 
	 * @param String $wikitext
	 * 
	 * @see CategorySelect::extractCategoriesFromWikitext
	 * 
	 * @return array
	 */
	private function getCategoriesFromWikitext( $wikitext ) {
		$app = F::app();
		$categories = [];
		
		if( !empty( $app->wg->EnableCategorySelectExt ) && 
			( $results = CategorySelect::extractCategoriesFromWikitext( $wikitext, true ) ) && 
			!empty( $results['categories'] ) 
		) {
			foreach( $results['categories'] as $category ) {
				$categories[] = str_replace(' ', '_', $category['name']);
			}
		}
		
		return $categories;
	}
}
