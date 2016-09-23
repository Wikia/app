<?php

/**
 * CategorySelect controller.
 *
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia-inc.com>
 * @author Inez Korczyński
 * @author Kyle Florence <kflorence@wikia-inc.com>
 */

class CategorySelectController extends WikiaController {
	const CACHE_TTL_AJAX = 360; // 1 hour
	const CACHE_TTL_MEMCACHE = 86400; // 1 day
	const VERSION = 1;

	/**
	 * The template used for article pages and edit previews.
	 */
	public function articlePage() {
		wfProfileIn( __METHOD__ );

		// Template rendering cancelled by hook
		if ( !wfRunHooks( 'CategorySelectArticlePage' ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$categories = $this->wg->out->getCategories();
		$showHidden = (bool)$this->wg->User->getGlobalPreference( 'showhiddencats' );
		$userCanEdit = $this->request->getVal( 'userCanEdit', CategorySelectHelper::isEditable() );

		// There are no categories present and user can't edit, skip rendering
		if ( !$userCanEdit && !count( $categories ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		// Categories link
		$categoriesLinkAttributes = array( 'class' => 'categoriesLink' );
		$categoriesLinkPage = wfMessage( 'pagecategorieslink' )->inContentLanguage()->text();
		$categoriesLinkText = wfMessage( 'pagecategories' )->escaped();

		if ( !empty( $this->wg->WikiaUseNoFollow ) ) {
			$categoriesLinkAttributes[ 'rel' ] = 'nofollow';
		}

		$categoriesLink = Linker::link( Title::newFromText( $categoriesLinkPage ), $categoriesLinkText, $categoriesLinkAttributes );

		Wikia::addAssetsToOutput( 'category_select_css' );
		Wikia::addAssetsToOutput( 'category_select_js' );

		$this->response->setVal( 'categories', $categories );
		$this->response->setVal( 'categoriesLink', $categoriesLink );
		$this->response->setVal( 'showHidden', $showHidden );
		$this->response->setVal( 'userCanEdit', $userCanEdit );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * The category list template. Used by article pages on view and edit save.
	 */
	public function categories() {
		wfProfileIn( __METHOD__ );

		$categories = $this->request->getVal( 'categories', array() );
		$data = array();

		// Because $out->getCategoryLinks doesn't maintain the order of the stored category data,
		// we have to build this information ourselves manually. This is essentially the same
		// code from $out->addCategoryLinks() but it results in a different data format.
		foreach( $categories as $category ) {
			// Support category name or category data object
			$name = is_array( $category ) ? $category[ 'name' ] : $category;
			$originalName = $name;
			$title = Title::makeTitleSafe( NS_CATEGORY, $name );
			if ( $title != null ) {
				$this->wg->ContLang->findVariantLink( $name, $title, true );
				if ( $name != $originalName && array_key_exists( $name, $data ) ) {
					continue;
				}
				$text = $this->wg->ContLang->convertHtml( $title->getText() );
				$data[ $name ] = array(
					'link' => Linker::link( $title, $text ),
					'name' => $text,
					'type' => CategoryHelper::getCategoryType( $originalName ),
				);
			} else {
				\Wikia\Logger\WikiaLogger::instance()->warning( "Unsafe category provided", [ 'name' => $name ] );
			}
		}

		$this->response->setVal( 'categories', $data );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * The template for a category in the category list.
	 */
	public function category() {
		$this->response->setVal( 'blankImageUrl', $this->wg->BlankImgUrl );
		$this->response->setVal( 'edit', wfMessage( 'categoryselect-category-edit' )->text() );
		$this->response->setVal( 'link', $this->request->getVal( 'link', '' ) );
		$this->response->setVal( 'name', $this->request->getVal( 'name', '' ) );
		$this->response->setVal( 'namespace', $this->request->getVal( 'namespace', '' ) );
		$this->response->setVal( 'outertag', $this->request->getVal( 'outertag', '' ) );
		$this->response->setVal( 'remove', wfMessage( 'categoryselect-category-remove' )->text() );
		$this->response->setVal( 'sortkey', $this->request->getVal( 'sortkey', '' ) );
		$this->response->setVal( 'type', $this->request->getVal( 'type', 'normal' ) );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * The template used for edit pages.
	 */
	public function editPage() {
		$this->response->addAsset( 'categoryselect_edit_js' );
		$this->response->addAsset( 'extensions/wikia/CategorySelect/css/CategorySelect.edit.scss' );

		$categories = array();
		$data = CategoryHelper::getExtractedCategoryData();

		if ( isset( $data ) && !empty( $data[ 'categories' ] ) ) {
			$categories = $data[ 'categories' ];
		}

		$this->response->setVal( 'categories', $categories );
	}

	/**
	 * The hidden form fields that store a JSON representation of the categories
	 * for an article.
	 */
	public function editPageMetadata() {
		$categories = '';
		$data = $this->getVal('categories', CategoryHelper::getExtractedCategoryData());

		if ( isset( $data ) && !empty( $data[ 'categories' ] ) ) {
			$categories = htmlspecialchars( CategoryHelper::changeFormat( $data[ 'categories' ], 'array', 'json' ) );
		}

		$this->response->setVal( 'categories', $categories );
	}

	/**
	 * Returns all of the categories on the current wiki.
	 */
	public function getWikiCategories() {
		wfProfileIn( __METHOD__ );

		$key = wfMemcKey( 'CategorySelectGetWikiCategories', self::VERSION );
		$data = $this->wg->Memc->get( $key );

		if ( empty( $data ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				'category',
				'cat_title',
				array( 'cat_pages > 0' ),
				__METHOD__,
				array(
					'ORDER BY' => 'cat_pages DESC',
					'LIMIT' => '10000'
				)
			);

			$data = array();
			while( $row = $dbr->fetchObject( $res ) ) {
				$data[] = str_replace( '_', ' ', $row->cat_title );
			}

			// TODO: clear the cache when new category is added
			$this->wg->Memc->set( $key, $data, self::CACHE_TTL_MEMCACHE );
		}

		$this->response->setData( $data );
		$this->response->setFormat( 'json' );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Save categories sent via AJAX into article
	 */
	public function save() {
		wfProfileIn( __METHOD__ );

		$this->checkWriteRequest();

		$articleId = $this->request->getVal( 'articleId', 0 );
		$categories = $this->request->getVal( 'categories', array() );

		$response = array();
		$title = Title::newFromID( $articleId );

		if ( wfReadOnly() ) {
			$response[ 'error' ] = wfMessage( 'categoryselect-error-db-locked' )->text();

		} else if ( is_null( $title ) ) {
			$response[ 'error' ] = wfMessage( 'categoryselect-error-article-doesnt-exist', $articleId )->text();

		} else if ( !$title->userCan( 'edit' ) || $this->wg->User->isBlocked() ) {
			$response[ 'error' ] = wfMessage( 'categoryselect-error-user-rights' )->text();

		} else if ( !empty( $categories ) && is_array( $categories ) ) {
			Wikia::setVar( 'EditFromViewMode', 'CategorySelect' );

			$article = new Article( $title );
			$wikitext = $article->fetchContent();

			// Pull in categories from templates inside of the article (BugId:100980)
			$options = new ParserOptions();
			$preprocessedWikitext = ParserPool::preprocess( $wikitext, $title, $options );
			$preprocessedData = CategoryHelper::extractCategoriesFromWikitext( $preprocessedWikitext, true );

			// Compare the new categories with those already in the article to weed out duplicates
			$newCategories = CategoryHelper::getDiffCategories( $preprocessedData[ 'categories' ], $categories );

			// Append the new categories to the end of the article wikitext
			$wikitext .= CategoryHelper::changeFormat( $newCategories, 'array', 'wikitext' );

			// Update the array of categories for the front-end
			$categories = array_merge( $preprocessedData[ 'categories' ], $newCategories );

			$dbw = wfGetDB( DB_MASTER );
			$dbw->begin();

			$editPage = new EditPage( $article );
			$editPage->edittime = $article->getTimestamp();
			$editPage->recreate = true;
			$editPage->textbox1 = $wikitext;
			$editPage->summary = wfMessage( 'categoryselect-edit-summary' )->inContentLanguage()->text();
			$editPage->watchthis = $editPage->mTitle->userIsWatching();

			$bot = $this->wg->User->isAllowed( 'bot' );
			$status = $editPage->internalAttemptSave( $result, $bot )->value;

			$response[ 'status' ] = $status;

			switch( $status ) {
				case EditPage::AS_SUCCESS_UPDATE:
				case EditPage::AS_SUCCESS_NEW_ARTICLE:
					$dbw->commit();
					$title->invalidateCache();
					Article::onArticleEdit( $title );
					$response[ 'html' ] = $this->app->renderView( 'CategorySelectController', 'categories', array(
						'categories' => $categories
					));
					wfRunHooks( 'CategorySelectSave', array( $title, $newCategories ) );
					break;

				case EditPage::AS_SPAM_ERROR:
					$dbw->rollback();
					$response[ 'error' ] = wfMessage( 'spamprotectiontext' )->text() . '<p>( Case #8 )</p>';
					break;

				default:
					$dbw->rollback();
					$response[ 'error' ] = wfMessage( 'categoryselect-error-edit-abort' )->text();
			}
		}

		$this->response->setData( $response );

		wfProfileOut( __METHOD__ );
	}
}
