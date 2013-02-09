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
	 * The template used for article pages.
	 * Also used by EditPage for previewing edits.
	 */
	public function articlePage() {
		$this->wf->ProfileIn( __METHOD__ );

		// Template rendering cancelled by hook
		if ( !$this->wf->RunHooks( 'CategorySelectArticlePage' ) ) {
			$this->wf->ProfileOut( __METHOD__ );
			return false;
		}

		$categoryLinks = $this->wg->out->getCategoryLinks();
		$userCanEdit = $this->request->getVal( 'userCanEdit', CategorySelect::isEditable() );

		// Remove hidden categories if user has chosen not to see them.
		if ( !empty( $categoryLinks[ 'hidden' ] ) && !$this->wg->User->getBoolOption( 'showhiddencats' ) ) {
			unset( $categoryLinks[ 'hidden' ] );
		}

		// Make sure category types always show up in the same order (hidden last)
		krsort( $categoryLinks );

		// There are no categories present and user can't edit, skip rendering
		if ( !$userCanEdit && !count( $categoryLinks ) ) {
			$this->wf->ProfileOut( __METHOD__ );
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

		$this->response->setVal( 'categoryLinks', $categoryLinks );
		$this->response->setVal( 'categoriesLink', $categoriesLink );
		$this->response->setVal( 'userCanEdit', $userCanEdit );

		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * The template for a category in the category list.
	 */
	public function category() {
		$this->response->setVal( 'blankImageUrl', $this->wg->BlankImgUrl );
		$this->response->setVal( 'edit', $this->wf->Msg( 'categoryselect-category-edit' ) );
		$this->response->setVal( 'name', $this->request->getVal( 'name', '' ) );
		$this->response->setVal( 'remove', $this->wf->Msg( 'categoryselect-category-remove' ) );
		$this->response->setVal( 'type', $this->request->getVal( 'type', 'normal' ) );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * The template used for edit pages.
	 */
	public function editPage() {
		$data = CategorySelect::getExtractedCategoryData();

		$this->response->setVal( 'categories', $data[ 'categories' ] );

		$this->response->addAsset( 'categoryselect_edit_js' );
		$this->response->addAsset( 'extensions/wikia/CategorySelect/css/CategorySelect.edit.scss' );
	}

	/**
	 * The hidden form fields that store a JSON representation of the categories
	 * for an article.
	 */
	public function editPageMetadata() {
		$categories = '';
		$data = CategorySelect::getExtractedCategoryData();

		if ( !empty( $data[ 'categories' ] ) ) {
			$categories = htmlspecialchars( CategorySelect::changeFormat( $data[ 'categories' ], 'array', 'json' ) );
		}

		$this->response->setVal( 'categories', $categories );
	}

	/**
	 * Rerturns all of the categories for the given article.
	 */
	public function getArticleCategories() {
		$articleId = $this->request->getVal( 'articleId', 0 );
		$categories = array();

		$title = Title::newFromID( $articleId );

		if ( !empty( $title ) ) {
			$article = new Article( $title );
			$wikitext = $article->fetchContent();

			$data = CategorySelect::extractCategoriesFromWikitext( $wikitext, true );
			$categories = $data[ 'categories' ];
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
		$this->wf->ProfileIn( __METHOD__ );

		$articleId = $this->request->getVal( 'articleId', 0 );
		$categories = $this->request->getVal( 'categories', array() );

		$response = array();
		$title = Title::newFromID( $articleId );

		if ( $this->wf->ReadOnly() ) {
			$response[ 'error' ] = $this->wf->Message( 'categoryselect-error-db-locked' );

		} else if ( is_null( $title ) ) {
			$response[ 'error' ] = $this->wf->Message( 'categoryselect-error-article-doesnt-exist', $articleId );

		} else if ( !$title->userCan( 'edit' ) || $this->wg->User->isBlocked() ) {
			$response[ 'error' ] = $this->wf->Message( 'categoryselect-error-user-rights' );

		} else if ( !empty( $categories ) && is_array( $categories ) ) {
			Wikia::setVar( 'EditFromViewMode', 'CategorySelect' );

			$article = new Article( $title );
			$wikitext = $article->fetchContent();

			$data = CategorySelect::extractCategoriesFromWikitext( $wikitext, true );

			// Merge categories stored in the article with any that were passed in and remove duplicates.
			$categories = array_merge( $data[ 'categories' ], $categories );
			$categories = CategorySelect::getUniqueCategories( $categories );

			// Convert categories to wikitext and append them to the article's wikitext
			$wikitext = $data[ 'wikitext' ] . CategorySelect::changeFormat( $categories, 'array', 'wikitext' );

			$dbw = $this->wf->GetDB( DB_MASTER );
			$dbw->begin();

			$editPage = new EditPage( $article );
			$editPage->edittime = $article->getTimestamp();
			$editPage->recreate = true;
			$editPage->textbox1 = $wikitext;
			$editPage->summary = $this->wf->MsgForContent( 'categoryselect-edit-summary' );
			$editPage->watchthis = $editPage->mTitle->userIsWatching();

			$bot = $this->wg->User->isAllowed( 'bot' );
			$status = $editPage->internalAttemptSave( $result, $bot )->value;

			// Generate links for the new categories and add them to the response.
			$categoryLinks = array();
			foreach( $categories as $category ) {
				$title = Title::makeTitleSafe( NS_CATEGORY, $category[ 'name' ] );
				$text = $this->wg->ContLang->convertHtml( $title->getText() );

				// We need to pass these through Linker so CategoryBlueLinks can handle them (BugId:97334)
				$categoryLinks[] = Linker::link( $title, $text );
			}

			$response[ 'categories' ] = $categories;
			$response[ 'categoryLinks' ] = $categoryLinks;
			$response[ 'status' ] = $status;

			switch( $status ) {
				case EditPage::AS_SUCCESS_UPDATE:
				case EditPage::AS_SUCCESS_NEW_ARTICLE:
					$dbw->commit();
					$title->invalidateCache();
					Article::onArticleEdit( $title );
					break;

				case EditPage::AS_SPAM_ERROR:
					$dbw->rollback();
					$response[ 'error' ] = $this->wf->Message( 'spamprotectiontext' ) . '<p>( Case #8 )</p>';
					break;

				default:
					$dbw->rollback();
					$response[ 'error' ] = $this->wf->Message( 'categoryselect-edit-abort' );
			}
		}

		$this->response->setData( $response );

		$this->wf->ProfileOut( __METHOD__ );
	}
}