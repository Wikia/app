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

		if( static::shouldRedirect($app, $model, $editPage->getArticle()->getTitle()) ) {
			$oldid = $app->wg->Request->getIntOrNull( 'oldid' );
			$app->wg->Out->redirect( $model->getSpecialCssUrl( false, ( $oldid ) ? array( 'oldid' => $oldid ) : null ) );
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @param WikiaApp $app
	 * @param SpecialCssModel $model 
	 * @param integer $articleId
	 *
	 * @return boolean
	 */
	static private function shouldRedirect( $app, $model, $title ) {
		$result = false;
		// currently special:css cannot handle undo mode
		if ( $app->wg->Request->getInt( 'undo' ) > 0 || $app->wg->Request->getInt( 'undoafter' ) > 0 ) {
			return $result;
		}

		if( $app->wg->EnableSpecialCssExt ) {
			$specialCss = new SpecialCssController();

			/** @noinspection PhpUndefinedVariableInspection
			 * SpecialCssModel::$suppoertedSkins is defined -- lint has issues with it
			 */
			$result = $model->isWikiaCssTitle( $title )
				&& $app->checkSkin( $model::$supportedSkins )
				&& $specialCss->userCanExecute( $app->wg->User );
		}

		return $result;
	}

	/**
	 * @desc Checks if CSS Update post was added/changed and purges cache with CSS Updates list
	 *
	 * @param WikiPage $page
	 * @param Revision $revision
	 *
	 * @return boolean true because it's a hook
	 */
	static public function onArticleSaveComplete( $page, $user, $text, $summary, $minoredit, $watchthis, $sectionanchor, $flags, $revision, $status, $baseRevId ) {
		$app = F::app();
		
		if ( in_array( $app->wg->DBname, $app->wg->CssUpdatesLangMap ) ) {
			$title = $page->getTitle();
			$purged = static::purgeCacheDependingOnCats( $title, 'because a new post was added to the category' );
			
			// sometimes $revision parameter passed to this hook is null; it's because of master-slave lag
			$revision = is_null($revision) ? Revision::newFromTitle($title) : $revision;
			
			if( !$purged && self::prevRevisionHasCssUpdatesCat( $revision ) ) {
				wfDebugLog( __CLASS__, __METHOD__ . ' - purging "Wikia CSS Updates" cache because a post within the category was removed from the category' );
				WikiaDataAccess::cachePurge( wfSharedMemcKey( SpecialCssModel::MEMC_KEY, $app->wg->DBname ) );
			}
		}

		return true;
	}

	/**
	 * @desc Returns true if in given categories "CSS Updates" is present
	 *
	 * @param Array $categories
	 *
	 * @return boolean
	 */
	static private function hasCssUpdatesCat( $categories ) {
		return in_array( SpecialCssModel::UPDATES_CATEGORY, $categories );
	}

	static private function getCategoriesFromTitle( $title, $useMaster = false ) {
		/** @var $title Title */
		return ( $title instanceof Title ) ? self::removeNamespace( array_keys( $title->getParentCategories( $useMaster ) ) ) : [];
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
		$categoryNamespace = $app->wg->ContLang->getNsText( NS_CATEGORY );

		foreach ( $categories as $category ) {
			$results[] = str_replace( $categoryNamespace . ':', '', $category );
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
		return ( ( $prevRev = $rev->getPrevious( true ) ) instanceof Revision ) &&
			in_array( SpecialCssModel::UPDATES_CATEGORY, self::getCategoriesFromWikitext( $prevRev->getRawText() ) );
	}

	/**
	 * @desc Using CategoryHelper::extractCategoriesFromWikitext() retrieves categories' data array
	 * which then is being flatten to categories' names with replaces spacebar to _
	 *
	 * @param String $wikitext
	 *
	 * @see CategoryHelper::extractCategoriesFromWikitext
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
				$categories[] = str_replace( ' ', '_', $category['name'] );
			}
		}

		return $categories;
	}

	/**
	 * @desc Alias to CategoryHelper::extractCategoriesFromWikitext helpful for unit tests
	 *
	 * @param $wikitext
	 * @return Array
	 */
	static public function getCategoriesFromCategorySelect( $wikitext ) {
		return CategoryHelper::extractCategoriesFromWikitext( $wikitext, true );
	}

	/**
	 * @desc Purges cache once a post within category is requested for deletion
	 *
	 * @param WikiPage $page
	 * @param User $user
	 * @param String $reason
	 * @param $error
	 *
	 * @return boolean true because it's a hook
	 */
	static public function onArticleDelete( &$page, &$user, &$reason, &$error ) {
		$app = F::app();
		if ( in_array( $app->wg->DBname, $app->wg->CssUpdatesLangMap ) ) {
			$title = $page->getTitle();
			static::purgeCacheDependingOnCats( $title, 'because a post within the category was deleted' );
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
		$app = F::app();
		if ( in_array( $app->wg->DBname, $app->wg->CssUpdatesLangMap ) ) {
			static::purgeCacheDependingOnCats( $title, 'because a post from its category was restored' );
		}

		return true;
	}

	static private function purgeCacheDependingOnCats( $title, $reason = null ) {
		$app = F::app();
		$purged = false;
		
		wfDebugLog( __CLASS__, __METHOD__ . 'fetching categories from MASTER' );
		$categories = self::getCategoriesFromTitle( $title, true );

		if( self::hasCssUpdatesCat( $categories) ) {
			wfDebugLog( __CLASS__, __METHOD__ . $reason );
			WikiaDataAccess::cachePurge( wfSharedMemcKey( SpecialCssModel::MEMC_KEY, $app->wg->DBname ) );
			$purged = true;
		}

		return $purged;
	}
}
