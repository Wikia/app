<?php

/**
 * @addto SpecialPages
 *
 * @author Adrian Wieczorek
 */
class CreateBlogPage extends SpecialBlogPage {

	private $mEditPage = null;
	private $mCategorySelectEnabled = false;

	public function __construct() {
		parent::__construct( 'CreateBlogPage'  /*class*/, '' /*restriction*/, true);

		// force EditEnhancements initialisation if available
		if(function_exists('wfEditEnhancementsInit') && !class_exists('EditEnhancements')) {
			wfEditEnhancementsInit(true);
		}
	}

	public function execute() {
		wfProfileIn( __METHOD__ );
		$output = $this->getOutput();
		$user = $this->getUser();
		$request = $this->getRequest();

		if( !$user->isLoggedIn() ) {
			$output->showErrorPage( 'create-blog-no-login', 'create-blog-login-required', array(wfGetReturntoParam()));
			return;
		}

		if( $user->isBlocked() ) {
			throw new UserBlockedError( $user()->mBlock );
		}

		if( wfReadOnly() ) {
			$output->readOnlyPage();
			return;
		}

		//nAndy: bugId:9804
		$pageId = intval( $request->getVal( 'pageId' ) );
		$this->mTitle = ($pageId > 0) ? Title::newFromId($pageId) : Title::makeTitle( NS_SPECIAL, 'CreateBlogPage' );

		// force CategorySelect initialisation if available
		if (class_exists('CategorySelectHooksHelper') && ( $user->getOption('disablecategoryselect', false ) == false)) {
			$this->mCategorySelectEnabled = true;
			$request->setVal( 'action', 'edit' );
			CategorySelectHooksHelper::onMediaWikiPerformAction(null, null, $this->mTitle, null, null, null);
		}

		$output->setPageTitle( wfMessage( "create-blog-post-title" )->text() );

		if( $request->wasPosted() ) {
			// BugId:954 - check for "show changes"
			$isShowDiff = !is_null( $request->getVal( 'wpDiff' ) );

			$this->parseFormData();
			if(count($this->mFormErrors) > 0 || !empty($this->mPreviewTitle)) {
				$this->renderForm();
			} elseif ( $isShowDiff ) {
				// watch out! there be dragons (temporary workaround)
				$this->mEditPage->diff = true;
				$this->mEditPage->edittime = null;
				$this->renderForm();
			} else {
				$this->save();
			}
		}
		else {
			if( $request->getVal( 'article' ) != null ) {
				$this->parseArticle( urldecode( $request->getVal( 'article' ) ) );
			}
			elseif ( $request->getText( 'preload' ) != null ) {
				// TOR: added preload functionality
				$preloadTitle = Title::newFromText( $request->getText( 'preload' ) );
				if ( !is_null( $preloadTitle ) ) {
					$preloadArticle = new Article( $preloadTitle );
					$text = $preloadArticle->getContent();
					$this->createEditPage( $text );
				}
			}
			else if ($pageId > 0) {
				//nAndy: bugId:9804 Owen: bugId:11432
				$preloadTitle = Title::newFromId($pageId);
				if ( !is_null( $preloadTitle ) ) {
					$this->parseArticle($preloadTitle->getDBKey());
				}
			} else {
				$this->createEditPage ('');
			}
			$this->renderForm();
		}
		wfProfileOut( __METHOD__ );
	}

	protected function save() {
		wfProfileIn( __METHOD__ );
		global $wgContLang;

		// CategorySelect compatibility (add categories to article body)
		if($this->mCategorySelectEnabled) {
			CategorySelectHooksHelper::onEditPageImportFormData($this->mEditPage, $wgRequest);
		}

		$sPostBody = $this->mEditPage->textbox1;

		/**
		 * add category for blogs (if defined in message and not existed already)
		 * @author eloy
		 */
		$catName = wfMessage( "create-blog-post-category" )->inContentLanguage()->text();
		if( $catName && $catName !== "-" && !$this->mPostArticle->exists()) {
			$sCategoryNSName = $wgContLang->getFormattedNsText( NS_CATEGORY );
			$sPostBody .= "\n[[" . $sCategoryNSName . ":" . $catName . "]]";
		}

		$aPageProps = array();

		$aPageProps['voting'] = 0;
		$aPageProps['commenting'] = 0;

		if(!empty($this->mFormData['isVotingEnabled'])) {
			$aPageProps['voting'] = 1;
		}
		if(!empty($this->mFormData['isCommentingEnabled'])) {
			$aPageProps['commenting'] = 1;
		}

		$editPage = new EditBlogPage( $this->mPostArticle );
		$editPage->initialiseForm();
		$editPage->textbox1 = $sPostBody;
		$editPage->watchthis = $this->mFormData['isWatched'];
		$editPage->summary = isset($this->mFormData['postEditSummary']) ? $this->mFormData['postEditSummary'] : wfMessage( 'create-blog-updated' )->inContentLanguage()->text();

		$result = false;
		$bot = $this->getUser()->isAllowed( 'bot' ) && $this->getRequest()->getBool( 'bot', true );
		$status = $editPage->internalAttemptSave( $result, $bot );

		switch( $status->value ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
				if( count( $aPageProps ) ) {
					BlogArticle::setProps( $this->mPostArticle->getId(), $aPageProps );
				}
				self::invalidateCacheConnected( $this->mPostArticle );
				$this->createListingPage();
				$this->getOutput()->redirect( $this->mPostArticle->getTitle()->getFullUrl() );
				break;

			// fix an issue with double edit page when captcha is triggered (BugId:6679)
			case EditPage::AS_HOOK_ERROR:
				Wikia::log( __METHOD__, 'editpage', 'hook prevented the save' );
				break;

			default:
				Wikia::log( __METHOD__, "editpage", $status->value );
				if( $status->value == EditPage::AS_READ_ONLY_PAGE_LOGGED ) {
					$sMsg = wfMessage( 'create-blog-cant-edit' )->text();
				}
				else {
					$sMsg = wfMessage( 'create-blog-spam' )->text()
				}
				$this->mFormErrors[] = $sMsg . '(' . $status->value . ')';
				$this->renderForm();
				break;
		}
		wfProfileOut( __METHOD__ );
	}

	protected function parseFormData() {
		wfProfileIn( __METHOD__ );
		$request = $this->getRequest();
		$user = $this->getUser();

		wfRunHooks('BlogsAlternateEdit', array(false));

		$this->mFormData['postId'] = $request->getVal( 'blogPostId' );
		$this->mFormData['postTitle'] = $request->getVal( 'blogPostTitle' );
		$this->mFormData['postBody'] = $request->getVal( 'wpTextbox1' );
		$this->mFormData['postEditSummary'] = $request->getVal( 'wpSummary' );
		$this->mFormData['postCategories'] = $request->getVal( 'wpCategoryTextarea1' );
		$this->mFormData['isVotingEnabled'] = $request->getCheck( 'blogPostIsVotingEnabled' );
		$this->mFormData['isCommentingEnabled'] = $request->getCheck( 'blogPostIsCommentingEnabled' );
		$this->mFormData['isExistingArticleEditAllowed'] = $request->getVal( 'articleEditAllowed' );
		$this->mFormData['isWatched'] = $request->getCheck( 'wpWatchthis' );

		if(empty($this->mFormData['postId'])) {
			if(empty($this->mFormData['postTitle'])) {
				$this->mFormErrors[] = wfMessage( 'create-blog-empty-title-error' )->text();
			}
			else {
				$oPostTitle = Title::newFromText( $user->getName() . '/' . $this->mFormData['postTitle'], NS_BLOG_ARTICLE);

				if(!($oPostTitle instanceof Title)) {
					$this->mFormErrors[] = wfMessage( 'create-blog-invalid-title-error' )->text();
				} else {
					$sFragment = $oPostTitle->getFragment();
					if ( strlen($sFragment) > 0 ) {
						$this->mFormErrors[] = wfMessage( 'create-blog-invalid-title-error' )->text();
					} else {
						$this->mPostArticle = new BlogArticle($oPostTitle, 0);
						if($this->mPostArticle->exists() && !$this->mFormData['isExistingArticleEditAllowed']) {
							$this->mFormErrors[] = wfMessage( 'create-blog-article-already-exists' )->text();
						}
					}
				}
			}
		} else { // we have an article id
			$isAllowed = $user->isAllowed( "blog-articles-edit" );
			$oPostTitle = Title::newFromID($this->mFormData['postId']);
			$this->mPostArticle = new BlogArticle($oPostTitle, 0);
			if((strtolower( $user->getName() ) != strtolower( BlogArticle::getOwner($oPostTitle))) && !$isAllowed) {
				$this->mFormErrors[] = wfMessage( 'create-blog-permission-denied' )->text();
			}
		}

		if(empty($this->mFormData['postBody'])) {
			$this->mFormErrors[] = wfMessage( 'create-blog-empty-post-error' )->text();
		}

		//create EditPage object
		$this->createEditPage( $this->mFormData['postBody'] );

		// BugId:954 - show changes
		if (!empty($this->mPostArticle)) {
			$this->mEditPage->mArticle = $this->mPostArticle;
		}

		if( !count( $this->mFormErrors ) && $request->getVal( 'wpPreview' ) ) {
			// preview mode
			$this->mEditPage->formtype = 'preview';
			$this->mPreviewTitle = Title::newFromText( $this->mFormData['postTitle'] );

			//simple hack to show correct title in preview mode
			global $wgCustomTitle;
			$wgCustomTitle = $this->mPreviewTitle;

			// CategorySelect compatibility (add categories to article body)
			if($this->mCategorySelectEnabled) {
				CategorySelectHooksHelper::onEditPageImportFormData($this->mEditPage, $request);
			}
		}
		wfProfileOut( __METHOD__ );
	}

	protected function createEditPage($sPostBody) {
		wfProfileIn( __METHOD__ );
		$oArticle = new Article( Title::makeTitle( NS_BLOG_ARTICLE, 'New or Updated Blog Post' ) );

		$this->mEditPage = new EditPage($oArticle);
		$this->mEditPage->textbox1 = $sPostBody;

		// this applies user preferences, such as minor and watchlist
		// EditPage::getContent was called twice (causes BugId:4604)
		// beware: dirty copy&paste of the code (will be replaced by RTE reskin)
		$user = $this->getUser();
		# Sort out the "watch" checkbox
		if ( $user->getOption( 'watchdefault' ) ) {
			# Watch all edits
			$this->mEditPage->watchthis = true;
		} elseif ( $user->getOption( 'watchcreations' ) && !$this->mEditPage->mTitle->exists() ) {
			# Watch creations
			$this->mEditPage->watchthis = true;
		} elseif ( $this->mEditPage->mTitle->userIsWatching() ) {
			# Already watched
			$this->mEditPage->watchthis = true;
		}
		if ( $user->getOption( 'minordefault' ) ) $this->mEditPage->minoredit = true;

		// fix for RT #33844 - run hook fired by "classical" EditPage
		// Allow extensions to modify edit form
		global $wgEnableRTEExt;
		$request = $this->getRequest();

		if (!empty($wgEnableRTEExt)) {
			$request->setVal( 'wpTextbox1', $sPostBody ); // RT #34055

			wfRunHooks('AlternateEdit', array(&$this->mEditPage));
			$this->mEditPage->textbox1 = $request->getVal( 'wpTextbox1' );

			RTE::log(__METHOD__ . '::wikitext', $this->mEditPage->textbox1);
		}
		wfProfileOut( __METHOD__ );
	}

	protected function renderForm() {
		if ($this->mEditPage instanceof EditPage)
			$this->mEditPage->showEditForm( array($this, 'renderFormHeader') );
		return true;
	}

	/**
	 * EditPage::showEditForm callback - need to be public
	 */
	public function renderFormHeader($wgOut) {
		wfProfileIn( __METHOD__ );
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$oTmpl->set_vars( array(
			"formErrors" => $this->mFormErrors,
			"formData" => $this->mFormData,
			"preview" => $this->mPreviewTitle
		) );

		$wgOut->setPageTitle( wfMessage( "create-blog-post-title" )->text() );
		$wgOut->addScriptFile('edit.js');
		$wgOut->addHTML( $oTmpl->render("createBlogFormHeader") );

		// BugId:954 - show changes
		if ($this->mEditPage->diff) {
			$this->mEditPage->mArticle->loadContent();
			$this->mEditPage->showDiff();
		}
		wfProfileOut( __METHOD__ );
	}

	private function parseArticle($sTitle) {
		global $wgContLang;

		$oTitle = Title::newFromText($sTitle, NS_BLOG_ARTICLE);
		$oArticle = new Article($oTitle, 0);

		// macbre: RT #37120
		$sArticleBody = $oTitle->exists() ? $oArticle->getContent() : '';

		$aPageProps = BlogArticle::getProps($oArticle->getId());
		$aTitleParts = explode('/', $oTitle->getText(), 2);

		$this->mFormData['postId'] = $oArticle->getId();
		$this->mFormData['postTitle'] = $aTitleParts[1];
		$this->mFormData['postBody'] = trim(preg_replace('/\[\[' . $wgContLang->getFormattedNsText( NS_CATEGORY ) . ':(.*)\]\]/siU', '', $sArticleBody));
		$this->mFormData['postBody'] = $sArticleBody;
		$this->mFormData['isVotingEnabled'] = isset($aPageProps['voting']) ? $aPageProps['voting'] : 0;
		$this->mFormData['isCommentingEnabled'] = isset($aPageProps['commenting']) ? $aPageProps['commenting'] : 0;
		$this->mFormData['isExistingArticleEditAllowed'] = 1;

		//create EditPage object
		$this->createEditPage( $this->mFormData['postBody'] );

		// CategorySelect compatibility (restore categories from article body)
		if ($this->mCategorySelectEnabled) {
			CategorySelectHooksHelper::onEditPageGetContentEnd($this->mEditPage, $this->mEditPage->textbox1);
		}

		return $oArticle;
	}

	/**
	 * purge cache for connected articles
	 *
	 * @static
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 *
	 */
	static public function invalidateCacheConnected( BlogArticle $article ) {
		wfProfileIn( __METHOD__ );
		$title = $article->getTitle();
		$title->invalidateCache();
		/**
		 * this should be subpage, invalidate page as well
		 */
		list( $page, $subpage ) = explode( "/", $title->getDBkey() );
		$title = Title::newFromDBkey( $page );
		$title->invalidateCache();
		$article->clearBlogListing();
		wfProfileOut( __METHOD__ );
	}

	/**
	 * createListingPage -- create listing article if not exists
	 *
	 * @access private
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 */
	private function createListingPage() {
		wfProfileIn( __METHOD__ );
		$oTitle = Title::newFromText( $this->getUser()->getName(), NS_BLOG_ARTICLE );
		$oArticle = new Article( $oTitle, 0 );
		if( !$oArticle->exists( ) ) {
			/**
			 * add empty article for newlycreated blog
			 */
			$oArticle->doEdit(
				wfMessage( "create-blog-empty-article" )->text(),     # body
				wfMessage( "create-blog-empty-article-log" )->text(), # summary
				EDIT_NEW | EDIT_MINOR | EDIT_FORCE_BOT  # flags
			);
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Add hidden field with blog page title when captcha is triggered (BugId:6679)
	 *
	 * Title provided by the user will be maintained when captcha is resolved and next POST request sent
	 */
	public static function onEditPageShowEditFormFields(&$editPage, &$wgOut) {
		$request = $this->getRequest();
		$blogPostTitle = $request->getVal('blogPostTitle');

		if ( !is_null( $blogPostTitle ) && $request->wasPosted() ) {
			$wgOut->addHTML(Html::hidden('blogPostTitle', $blogPostTitle));
		}

		return true;
	}
}

class EditBlogPage extends EditPage {
	#---
	function __construct ($article) {
		parent::__construct($article);
	}

	protected function wasDeletedSinceLastEdit() {
		# allow to recreate (always)
		return false;
	}
}
