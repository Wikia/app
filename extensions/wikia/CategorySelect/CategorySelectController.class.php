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
		if ( !$this->wf->RunHooks( 'CategorySelectArticlePage' ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$categories = $this->wg->out->getCategories();
		$showHidden = $this->wg->User->getBoolOption( 'showhiddencats' );
		$userCanEdit = $this->request->getVal( 'userCanEdit', CategorySelect::isEditable() );

		// There are no categories present and user can't edit, skip rendering
		if ( !$userCanEdit && !count( $categories ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		// Categories link
		$categoriesLinkAttributes = array( 'class' => 'categoriesLink' );
		$categoriesLinkPage = $this->wf->Message( 'pagecategorieslink' )->inContentLanguage()->text();
		$categoriesLinkText = $this->wf->Message( 'pagecategories' )->escaped();

		if ( !empty( $this->wg->WikiaUseNoFollow ) ) {
			$categoriesLinkAttributes[ 'rel' ] = 'nofollow';
		}

		$categoriesLink = Linker::link( Title::newFromText( $categoriesLinkPage ), $categoriesLinkText, $categoriesLinkAttributes );

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
			$this->wg->ContLang->findVariantLink( $name, $title, true );
			if ( $name != $originalName && array_key_exists( $name, $data ) ) {
				continue;
			}
			$text = $this->wg->ContLang->convertHtml( $title->getText() );
			$data[ $name ] = array(
				'link' => Linker::link( $title, $text ),
				'name' => $text,
				'type' => CategorySelect::getCategoryType( $originalName ),
			);
		}

		$this->response->setVal( 'categories', $data );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * The template for a category in the category list.
	 */
	public function category() {
		$this->response->setVal( 'blankImageUrl', $this->wg->BlankImgUrl );
		$this->response->setVal( 'edit', $this->wf->Message( 'categoryselect-category-edit' )->text() );
		$this->response->setVal( 'link', $this->request->getVal( 'link', '' ) );
		$this->response->setVal( 'name', $this->request->getVal( 'name', '' ) );
		$this->response->setVal( 'namespace', $this->request->getVal( 'namespace', '' ) );
		$this->response->setVal( 'outertag', $this->request->getVal( 'outertag', '' ) );
		$this->response->setVal( 'remove', $this->wf->Message( 'categoryselect-category-remove' )->text() );
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
		$data = CategorySelect::getExtractedCategoryData();

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
		$data = CategorySelect::getExtractedCategoryData();

		if ( isset( $data ) && !empty( $data[ 'categories' ] ) ) {
			$categories = htmlspecialchars( CategorySelect::changeFormat( $data[ 'categories' ], 'array', 'json' ) );
		}

		$this->response->setVal( 'categories', $categories );
	}

	/**
	 * Returns all of the categories on the current wiki.
	 */
	public function getWikiCategories() {
		wfProfileIn( __METHOD__ );

		$key = $this->wf->MemcKey( 'CategorySelectGetWikiCategories', self::VERSION );
		$data = $this->wg->Memc->get( $key );

		if ( empty( $data ) ) {
			$dbr = $this->wf->GetDB( DB_SLAVE );
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

		$articleId = $this->request->getVal( 'articleId', 0 );
		$categories = $this->request->getVal( 'categories', array() );

		$response = array();
		$title = Title::newFromID( $articleId );

		if ( $this->wf->ReadOnly() ) {
			$response[ 'error' ] = $this->wf->Message( 'categoryselect-error-db-locked' )->text();

		} else if ( is_null( $title ) ) {
			$response[ 'error' ] = $this->wf->Message( 'categoryselect-error-article-doesnt-exist', $articleId )->text();

		} else if ( !$title->userCan( 'edit' ) || $this->wg->User->isBlocked() ) {
			$response[ 'error' ] = $this->wf->Message( 'categoryselect-error-user-rights' )->text();

		} else if ( !empty( $categories ) && is_array( $categories ) ) {
			Wikia::setVar( 'EditFromViewMode', 'CategorySelect' );

			$article = new Article( $title );
			$wikitext = $article->fetchContent();

			$articleData = CategorySelect::extractCategoriesFromWikitext( $wikitext, true );

			// Pull in categories from templates inside of the article (BugId:100980)
			$options = new ParserOptions();
			$preprocessedWikitext = ParserPool::preprocess( $articleData[ 'wikitext' ], $title, $options );
			$preprocessedData = CategorySelect::extractCategoriesFromWikitext( $preprocessedWikitext, true );

			// Merge together the categories extracted from the article, templates and the category module
			$categories = CategorySelect::getUniqueCategories(
					$articleData[ 'categories' ], $preprocessedData[ 'categories' ], $categories );

			// Append the categories to the end of the article
			$wikitext = $articleData[ 'wikitext' ] . CategorySelect::changeFormat( $categories, 'array', 'wikitext' );

			$dbw = $this->wf->GetDB( DB_MASTER );
			$dbw->begin();

			$editPage = new EditPage( $article );
			$editPage->edittime = $article->getTimestamp();
			$editPage->recreate = true;
			$editPage->textbox1 = $wikitext;
			$editPage->summary = $this->wf->Message( 'categoryselect-edit-summary' )->inContentLanguage()->text();
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
					break;

				case EditPage::AS_SPAM_ERROR:
					$dbw->rollback();
					$response[ 'error' ] = $this->wf->Message( 'spamprotectiontext' )->text() . '<p>( Case #8 )</p>';
					break;

				default:
					$dbw->rollback();
					$response[ 'error' ] = $this->wf->Message( 'categoryselect-error-edit-abort' )->text();
			}
		}

		$this->response->setData( $response );

		wfProfileOut( __METHOD__ );
	}
}