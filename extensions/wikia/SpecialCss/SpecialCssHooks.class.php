<?php
class SpecialCssHooks {
	/**
	 * @desc Redirects to Special:CSS if this is a try of edition of Wikia.css
	 * 
	 * @param EditPage $editPage
	 * @return bool
	 */
	static public function onAlternateEdit( EditPage $editPage ) {
		wfProfileIn(__METHOD__);
		$app = F::app();
		$model = new SpecialCssModel();

		if( static::shouldRedirect($app, $model, $editPage->getArticle()->getTitle()->getArticleId()) ) {
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
	static private function shouldRedirect( $app, $model, $articleId ) {
		// currently special::css cannot handle undo mode
		if ( $app->wg->Request->getInt( 'undo' ) > 0 || $app->wg->Request->getInt( 'undoafter' ) > 0 ) {
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
	 * @param Article $page
	 * @param Revision $revision
	 * 
	 * @return true because it's a hook
	 */
	static public function onArticleSaveComplete( $page, $user, $text, $summary, $minoredit, $watchthis, $sectionanchor, $flags, $revision, $status, $baseRevId ) {
		$title = $page->getTitle();
		$categories = ( $title instanceof Title ) ? self::removeNamespace( array_keys( $title->getParentCategories() ) ) : [];
		
		if( self::hasCssUpdatesCat( $categories ) ) {
			wfDebugLog( __CLASS__, __METHOD__ .' - purging "Wikia CSS Updates" cache because a new post was added to the category' );
			WikiaDataAccess::cachePurge( wfSharedMemcKey( SpecialCssModel::MEMC_KEY ) );
		} else if( self::prevRevisionHasCssUpdatesCat( $revision ) ) {
			wfDebugLog( __CLASS__, __METHOD__ . ' - purging "Wikia CSS Updates" cache because a post within the category was removed from the category' );
			WikiaDataAccess::cachePurge( wfSharedMemcKey( SpecialCssModel::MEMC_KEY ) );
		}
		
		if( empty( $categories ) ) {
			$categories = ( $title instanceof Title ) ? self::removeNamespace( array_keys( $title->getParentCategories( true ) ) ) : [];

			wfDebugLog( __CLASS__, __METHOD__ . ' - empty categories' );
			
			if( self::hasCssUpdatesCat( $categories) ) {
				wfDebugLog( __CLASS__, __METHOD__ . ' - purging "Wikia CSS Updates" cache because a new post within the category was created' );
				WikiaDataAccess::cachePurge( wfSharedMemcKey( SpecialCssModel::MEMC_KEY ) );
			}
		}
		
		return true;
	}

	/**
	 * @desc Returns true if given title has "CSS Updates" category
	 * 
	 * @param $title
	 * 
	 * @return boolean
	 */
	static private function hasCssUpdatesCat( $categories ) {
		return in_array( SpecialCssModel::UPDATES_CATEGORY, $categories );
	}

	/**
	 * @desc Removes category namespace name in content language i.e. 'Category:Abc' will result with 'Abc'
	 * 
	 * @param Array $categories an array of categories with the namespace i.e. ['Category:Abc', 'Category:Def', 'Category:Ghi'] or ['Kategoria:Abc', 'Kategoria:Def', 'Kategoria:Ghi']
	 * 
	 * @return array
	 */
	static private function removeNamespace( $categories ) {
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
	static private function prevRevisionHasCssUpdatesCat( Revision $rev ) {
		return ( ( $prevRev = $rev->getPrevious() ) instanceof Revision ) &&
			in_array( SpecialCssModel::UPDATES_CATEGORY, self::getCategoriesFromWikitext( $prevRev->getRawText() ) );
	}

	/**
	 * @desc Using CategorySelect::extractCategoriesFromWikitext() retrives categories' data array 
	 * which then is being flattern to categories' names with replaces spacebar to _
	 * 
	 * @param String $wikitext
	 * 
	 * @see CategorySelect::extractCategoriesFromWikitext
	 * 
	 * @return array
	 */
	static public function getCategoriesFromWikitext( $wikitext ) {
		$app = F::app();
		$categories = [];
		
		if( !empty( $app->wg->EnableCategorySelectExt ) && 
			( $results = static::getCategoriesFromCategorySelect( $wikitext ) ) && 
			!empty( $results['categories'] ) 
		) {
			foreach( $results['categories'] as $category ) {
				$categories[] = str_replace(' ', '_', $category['name']);
			}
		}
		
		return $categories;
	}

	/**
	 * @desc Alias to CategorySelect::extractCategoriesFromWikitext helpful for unit tests
	 * 
	 * @param $wikitext
	 * @return Array
	 */
	static public function getCategoriesFromCategorySelect( $wikitext ) {
		return CategorySelect::extractCategoriesFromWikitext( $wikitext, true );
	}

	/**
	 * @desc Purges cache once a post within category is requested for deletion
	 * 
	 * @param Article $article
	 * @param User $user
	 * @param String $reason
	 * @param $error
	 * 
	 * @return true because it's a hook
	 */
	static public function onArticleDelete( &$article, &$user, &$reason, &$error ) {
		$title = $article->getTitle();
		$categories = ( $title instanceof Title ) ? self::removeNamespace( array_keys( $title->getParentCategories() ) ) : [];
		
		if( self::hasCssUpdatesCat( $categories ) ) {
			wfDebugLog( __CLASS__, __METHOD__ . ' - purging "Wikia CSS Updates" cache because a post within the category was deleted' );
			WikiaDataAccess::cachePurge( wfSharedMemcKey( SpecialCssModel::MEMC_KEY ) );
		}
		
		return true;
	}

	/**
	 * @desc Purges cache once a post within category is restored
	 * 
	 * @param Title $title
	 * @param $created
	 * @param String $comment
	 * 
	 * @return bool
	 */
	static public function onArticleUndelete( $title, $created, $comment ) {
		$categories = ( $title instanceof Title ) ? self::removeNamespace( array_keys( $title->getParentCategories() ) ) : [];
		
		if( self::hasCssUpdatesCat( $categories ) ) {
			wfDebugLog( __CLASS__, __METHOD__ . ' - purging "Wikia CSS Updates" cache because a post from its category was restored' );
			WikiaDataAccess::cachePurge( wfSharedMemcKey( SpecialCssModel::MEMC_KEY ) );
		}
		
		return true;
	}
}
