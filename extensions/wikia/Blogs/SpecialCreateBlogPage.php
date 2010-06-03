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
		// initialise messages
		wfLoadExtensionMessages( "Blogs" );
		parent::__construct( 'CreateBlogPage'  /*class*/, '' /*restriction*/, true);

		// force EditEnhancements initialisation if available
		if(function_exists('wfEditEnhancementsInit') && class_exists('EditEnhancements')) {
			wfEditEnhancementsInit(true);
		}
	}

	public function execute() {
		global $wgOut, $wgUser, $wgRequest, $wgTitle;

		if( !$wgUser->isLoggedIn() ) {
			$wgOut->showErrorPage( 'create-blog-no-login', 'create-blog-login-required', array(wfGetReturntoParam()));
			return;
		}

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'CreateBlogPage' );

		// force CategorySelect initialisation if available
		if(function_exists('CategorySelectInitializeHooks') && ($wgUser->getOption('disablecategoryselect', false) == false)) {
			$this->mCategorySelectEnabled = true;
			$wgRequest->setVal('action', 'edit');
			CategorySelectInit(true);
			CategorySelectInitializeHooks(null, null, $this->mTitle, null, null);
		}

		$wgOut->setPageTitle( wfMsg("create-blog-post-title") );

		if($wgRequest->wasPosted()) {
			$this->parseFormData();
			if(count($this->mFormErrors) > 0 || !empty($this->mPreviewTitle)) {
				$this->renderForm();
			}
			else {
				$this->save();
			}
		}
		else {
			if($wgRequest->getVal('article') != null) {
				$this->parseArticle(urldecode($wgRequest->getVal('article')));
			}
			else {
				$this->createEditPage('');
			}
			$this->renderForm();
		}
	}

	protected function save() {
		global $wgOut, $wgUser, $wgContLang, $wgRequest;

		// CategorySelect compatibility (add categories to article body)
		if($this->mCategorySelectEnabled) {
			CategorySelectImportFormData($this->mEditPage, $wgRequest);
		}

		$sPostBody = $this->mEditPage->textbox1;

		/**
		 * add category for blogs (if defined in message and not existed already)
		 * @author eloy
		 */
		$catName = wfMsgForContent("create-blog-post-category");
		if( $catName && $catName !== "-" && !$this->mPostArticle->exists()) {
			$sCategoryNSName = $wgContLang->getFormattedNsText( NS_CATEGORY );
			$sPostBody .= "\n[[" . $sCategoryNSName . ":" . $catName . "]]";
		}

		$aPageProps = array();
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
		$editPage->summary = isset($this->mFormData['postEditSummary']) ? $this->mFormData['postEditSummary'] : wfMsgForContent('create-blog-updated');

		$result = false;
		$bot = $wgUser->isAllowed('bot') && $wgRequest->getBool('bot',true);
		$status = $editPage->internalAttemptSave( $result, $bot );
		switch( $status ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
				if( count( $aPageProps ) ) {
					BlogArticle::setProps( $this->mPostArticle->getId(), $aPageProps );
				}
				self::invalidateCacheConnected( $this->mPostArticle );
				$this->createListingPage();
				$wgOut->redirect($this->mPostArticle->getTitle()->getFullUrl());
				break;

			default:
				Wikia::log( __METHOD__, "editpage", $status );
				if( $status == EditPage::AS_READ_ONLY_PAGE_LOGGED ) {
					$sMsg = wfMsg('create-blog-cant-edit');
				}
				else {
					$sMsg = wfMsg('create-blog-spam');
				}
				$this->mFormErrors[] = $sMsg . "($status)";
				$this->renderForm();
				break;
		}

	}

	protected function parseFormData() {
		global $wgUser, $wgRequest, $wgOut;

		wfRunHooks('BlogsAlternateEdit', array(false));

		$this->mFormData['postId'] = $wgRequest->getVal('blogPostId');
		$this->mFormData['postTitle'] = $wgRequest->getVal('blogPostTitle');
		$this->mFormData['postBody'] = $wgRequest->getVal('wpTextbox1');
		$this->mFormData['postEditSummary'] = $wgRequest->getVal('wpSummary');
		$this->mFormData['postCategories'] = $wgRequest->getVal('wpCategoryTextarea1');
		$this->mFormData['isVotingEnabled'] = $wgRequest->getCheck('blogPostIsVotingEnabled');
		$this->mFormData['isCommentingEnabled'] = $wgRequest->getCheck('blogPostIsCommentingEnabled');
		$this->mFormData['isExistingArticleEditAllowed'] = $wgRequest->getVal('articleEditAllowed');
		$this->mFormData['isWatched'] = $wgRequest->getCheck( 'wpWatchthis' );

		if(empty($this->mFormData['postId'])) {
			if(empty($this->mFormData['postTitle'])) {
				$this->mFormErrors[] = wfMsg('create-blog-empty-title-error');
			}
			else {
				$oPostTitle = Title::newFromText( $wgUser->getName() . '/' . $this->mFormData['postTitle'], NS_BLOG_ARTICLE);

				if(!($oPostTitle instanceof Title)) {
					$this->mFormErrors[] = wfMsg('create-blog-invalid-title-error');
				}
				else {
					$sFragment = $oPostTitle->getFragment();
					if ( strlen($sFragment) > 0 ) {
						$this->mFormErrors[] = wfMsg('create-blog-invalid-title-error');
					} else {
						$this->mPostArticle = new BlogArticle($oPostTitle, 0);
						if($this->mPostArticle->exists() && !$this->mFormData['isExistingArticleEditAllowed']) {
							$this->mFormErrors[] = wfMsg('create-blog-article-already-exists');
						}
					}
				}
			}
		}
		else { // we have an article id
			$isAllowed = $wgUser->isAllowed( "blog-articles-edit" );
			$oPostTitle = Title::newFromID($this->mFormData['postId']);
			$this->mPostArticle = new BlogArticle($oPostTitle, 0);
			if((strtolower($wgUser->getName()) != strtolower( BlogArticle::getOwner($oPostTitle))) && !$isAllowed) {
				$this->mFormErrors[] = wfMsg('create-blog-permission-denied');
			}
		}

		if(empty($this->mFormData['postBody'])) {
			$this->mFormErrors[] = wfMsg('create-blog-empty-post-error');
		}

		//create EditPage object
		$this->createEditPage( $this->mFormData['postBody'] );

		if(!count($this->mFormErrors) && $wgRequest->getVal('wpPreview')) {
			// preview mode
			$this->mEditPage->formtype = 'preview';
			$this->mPreviewTitle = Title::newFromText( $this->mFormData['postTitle'] );

			//simple hack to show correct title in preview mode
			global $wgCustomTitle;
			$wgCustomTitle = $this->mPreviewTitle;

			// CategorySelect compatibility (add categories to article body)
			if($this->mCategorySelectEnabled) {
				CategorySelectImportFormData( $this->mEditPage, $wgRequest );
			}
		}

	}

	protected function createEditPage($sPostBody) {
		$oArticle = new Article( Title::makeTitle( NS_BLOG_ARTICLE, 'New or Updated Blog Post' ) );
		$this->mEditPage = new EditPage($oArticle);
		$this->mEditPage->textbox1 = $sPostBody;

		// fix for RT #33844 - run hook fired by "classical" EditPage
		// Allow extensions to modify edit form
		global $wgEnableRTEExt, $wgRequest;
		if (!empty($wgEnableRTEExt)) {
			$wgRequest->setVal('wpTextbox1', $sPostBody); // RT #34055

			wfRunHooks('AlternateEdit', array(&$this->mEditPage));
			$this->mEditPage->textbox1 = $wgRequest->getVal('wpTextbox1');

			RTE::log(__METHOD__ . '::wikitext', $this->mEditPage->textbox1);
		}
	}

	protected function renderForm() {
		// CategorySelect compatibility (restore categories from article body)
		if($this->mCategorySelectEnabled) {
			CategorySelectReplaceContent( $this->mEditPage, $this->mEditPage->textbox1 );
		}

		$this->mEditPage->showEditForm( array($this, 'renderFormHeader') );
		return true;
	}

	/**
	 * EditPage::showEditForm callback - need to be public
	 */
	public function renderFormHeader($wgOut) {
		global $wgScriptPath;
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$oTmpl->set_vars( array(
			"formErrors" => $this->mFormErrors,
			"formData" => $this->mFormData,
			"preview" => $this->mPreviewTitle
		) );

		$wgOut->setPageTitle( wfMsg("create-blog-post-title") );
		$wgOut->addScript( '<script type="text/javascript" src="' . $wgScriptPath . '/skins/common/edit.js"><!-- edit js --></script>');
		$wgOut->addHTML( $oTmpl->render("createBlogFormHeader") );
	}

	private function parseArticle($sTitle) {
		global $wgParser, $wgContLang;

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
		if($this->mCategorySelectEnabled) {
			CategorySelectReplaceContent( $this->mEditPage, $this->mEditPage->textbox1 );
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
		$title = $article->getTitle();
		$title->invalidateCache();
		/**
		 * this should be subpage, invalidate page as well
		 */
		list( $page, $subpage ) = explode( "/", $title->getDBkey() );
		$title = Title::newFromDBkey( $page );
		$title->invalidateCache();
		$article->clearBlogListing();
	}

	/**
	 * createListingPage -- create listing article if not exists
	 *
	 * @access private
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 */
	private function createListingPage() {
		global $wgUser;

		$oTitle = Title::newFromText( $wgUser->getName(), NS_BLOG_ARTICLE );
		$oArticle = new Article( $oTitle, 0 );
		if( !$oArticle->exists( ) ) {
			/**
			 * add empty article for newlycreated blog
			 */
			$oArticle->doEdit(
				wfMsg("create-blog-empty-article"),     # body
				wfMsg("create-blog-empty-article-log"), # summary
				EDIT_NEW | EDIT_MINOR | EDIT_FORCE_BOT  # flags
			);
		}
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
