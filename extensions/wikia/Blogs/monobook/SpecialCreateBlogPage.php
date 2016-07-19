<?php

/**
 * @addto SpecialPages
 *
 * @author Adrian Wieczorek
 */
class CreateBlogPage extends SpecialBlogPage {

	/** @var EditPage */
	private $mEditPage = null;
	private $mCategorySelectEnabled = false;
	private $mTitle;

	public function __construct() {
		parent::__construct( 'CreateBlogPage'  /*class*/, '' /*restriction*/, true );

		// force EditEnhancements initialisation if available
		if ( function_exists( 'wfEditEnhancementsInit' ) && !class_exists( 'EditEnhancements' ) ) {
			wfEditEnhancementsInit( true );
		}
	}

	public function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest;

		if ( !$wgUser->isLoggedIn() ) {
			$wgOut->showErrorPage(
				'create-blog-no-login',
				'create-blog-login-required',
				[ wfGetReturntoParam() ]
			);
			return;
		}

		if ( $wgUser->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->mBlock );
		}

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		// nAndy: bugId:9804
		$pageId = intval( $wgRequest->getVal( 'pageId' ) );
		$this->mTitle = ( $pageId > 0 ) ? Title::newFromId( $pageId ) : Title::makeTitle( NS_SPECIAL, 'CreateBlogPage' );

		// force CategorySelect initialisation if available
		if ( class_exists( 'CategorySelectHooksHelper' ) && ( $wgUser->getGlobalPreference( 'disablecategoryselect', false ) == false ) ) {
			$this->mCategorySelectEnabled = true;
			$wgRequest->setVal( 'action', 'edit' );
			CategorySelectHooksHelper::onMediaWikiPerformAction( null, null, $this->mTitle, null, null, null );
		}

		$wgOut->setPageTitle( wfMsg( "create-blog-post-title" ) );

		if ( $wgRequest->wasPosted() ) {
			// BugId:954 - check for "show changes"
			$isShowDiff = !is_null( $wgRequest->getVal( 'wpDiff' ) );

			$this->parseFormData();
			if ( count( $this->mFormErrors ) > 0 || !empty( $this->mPreviewTitle ) ) {
				$this->renderForm();
			} else if ( $isShowDiff ) {
				// watch out! there be dragons (temporary workaround)
				$this->mEditPage->diff = true;
				$this->mEditPage->edittime = null;
				$this->renderForm();
			} else {
				$this->save();
			}
		} else {
			if ( $wgRequest->getVal( 'article' ) != null ) {
				$this->parseArticle( urldecode( $wgRequest->getVal( 'article' ) ) );
			}
			else if ( $wgRequest->getText( 'preload' ) != null ) {
				// TOR: added preload functionality
				$preloadTitle = Title::newFromText( $wgRequest->getText( 'preload' ) );
				if ( !is_null( $preloadTitle ) ) {
					$preloadArticle = new Article( $preloadTitle );
					$text = $preloadArticle->getContent();
					$this->createEditPage( $text );
				}
			} else if ( $pageId > 0 ) {
				// nAndy: bugId:9804 Owen: bugId:11432
				$preloadTitle = Title::newFromId( $pageId );
				if ( !is_null( $preloadTitle ) ) {
					$this->parseArticle( $preloadTitle->getDBKey() );
				}
			} else {
				$this->createEditPage ( '' );
			}
			$this->renderForm();
		}
	}

	protected function save() {
		global $wgOut, $wgUser, $wgContLang, $wgRequest;

		// CategorySelect compatibility (add categories to article body)
		if ( $this->mCategorySelectEnabled ) {
			CategorySelectHooksHelper::onEditPageImportFormData( $this->mEditPage, $wgRequest );
		}

		$sPostBody = $this->mEditPage->textbox1;

		/**
		 * add category for blogs (if defined in message and not existed already)
		 * @author eloy
		 */
		$catName = wfMsgForContent( "create-blog-post-category" );
		if ( $catName && $catName !== "-" && !$this->mPostArticle->exists() ) {
			$sCategoryNSName = $wgContLang->getFormattedNsText( NS_CATEGORY );
			$sPostBody .= "\n[[" . $sCategoryNSName . ":" . $catName . "]]";
		}

		$aPageProps = array();

		$aPageProps['voting'] = 0;
		$aPageProps['commenting'] = 0;

		if ( !empty( $this->mFormData['isVotingEnabled'] ) ) {
			$aPageProps['voting'] = 1;
		}
		if ( !empty( $this->mFormData['isCommentingEnabled'] ) ) {
			$aPageProps['commenting'] = 1;
		}

		$editPage = new EditBlogPage( $this->mPostArticle );
		$editPage->initialiseForm();
		$editPage->textbox1 = $sPostBody;
		$editPage->watchthis = $this->mFormData['isWatched'];
		$editPage->summary = isset( $this->mFormData['postEditSummary'] ) ? $this->mFormData['postEditSummary'] : wfMsgForContent( 'create-blog-updated' );

		$result = false;
		$bot = $wgUser->isAllowed( 'bot' ) && $wgRequest->getBool( 'bot', true );
		$status = $editPage->internalAttemptSave( $result, $bot );

		switch( $status->value ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
				if ( count( $aPageProps ) ) {
					BlogArticle::setProps( $this->mPostArticle->getId(), $aPageProps );
				}
				self::invalidateCacheConnected( $this->mPostArticle );
				$this->createListingPage();
				$wgOut->redirect( $this->mPostArticle->getTitle()->getFullUrl() );
				break;

			// fix an issue with double edit page when captcha is triggered (BugId:6679)
			case EditPage::AS_HOOK_ERROR:
				Wikia::log( __METHOD__, 'editpage', 'hook prevented the save' );
				break;

			default:
				Wikia::log( __METHOD__, "editpage", $status->value );
				if ( $status->value == EditPage::AS_READ_ONLY_PAGE_LOGGED ) {
					$sMsg = wfMsg( 'create-blog-cant-edit' );
				}
				else {
					$sMsg = wfMsg( 'create-blog-spam' );
				}
				$this->mFormErrors[] = $sMsg . '(' . $status->value . ')';
				$this->renderForm();
				break;
		}
	}

	protected function parseFormData() {
		global $wgUser, $wgRequest;

		$token = $wgRequest->getVal( 'wpEditToken' );
		if ( !$wgUser->matchEditToken( $token ) ) {
			$this->mFormErrors[] = wfMessage( 'sessionfailure' )->escaped();
			return;
		}

		wfRunHooks( 'BlogsAlternateEdit', array( false ) );

		$this->mFormData['postId'] = $wgRequest->getVal( 'blogPostId' );
		$this->mFormData['postTitle'] = $wgRequest->getVal( 'blogPostTitle' );
		$this->mFormData['postBody'] = $wgRequest->getVal( 'wpTextbox1' );
		$this->mFormData['postEditSummary'] = $wgRequest->getVal( 'wpSummary' );
		$this->mFormData['postCategories'] = $wgRequest->getVal( 'wpCategoryTextarea1' );
		$this->mFormData['isVotingEnabled'] = $wgRequest->getCheck( 'blogPostIsVotingEnabled' );
		$this->mFormData['isCommentingEnabled'] = $wgRequest->getCheck( 'blogPostIsCommentingEnabled' );
		$this->mFormData['isExistingArticleEditAllowed'] = $wgRequest->getVal( 'articleEditAllowed' );
		$this->mFormData['isWatched'] = $wgRequest->getCheck( 'wpWatchthis' );

		if ( empty( $this->mFormData['postId'] ) ) {
			if ( empty( $this->mFormData['postTitle'] ) ) {
				$this->mFormErrors[] = wfMsg( 'create-blog-empty-title-error' );
			}
			else {
				$oPostTitle = Title::newFromText( $wgUser->getName() . '/' . $this->mFormData['postTitle'], NS_BLOG_ARTICLE );

				if ( !( $oPostTitle instanceof Title ) ) {
					$this->mFormErrors[] = wfMsg( 'create-blog-invalid-title-error' );
				}
				else {
					$sFragment = $oPostTitle->getFragment();
					if ( strlen( $sFragment ) > 0 ) {
						$this->mFormErrors[] = wfMsg( 'create-blog-invalid-title-error' );
					} else {
						$this->mPostArticle = new BlogArticle( $oPostTitle, 0 );
						if ( $this->mPostArticle->exists() && !$this->mFormData['isExistingArticleEditAllowed'] ) {
							$this->mFormErrors[] = wfMsg( 'create-blog-article-already-exists' );
						}
					}
				}
			}
		} else { // we have an article id
			$isAllowed = $wgUser->isAllowed( "blog-articles-edit" );
			$oPostTitle = Title::newFromID( $this->mFormData['postId'] );
			$this->mPostArticle = new BlogArticle( $oPostTitle, 0 );
			if ( ( strtolower( $wgUser->getName() ) != strtolower( BlogArticle::getOwner( $oPostTitle ) ) ) && !$isAllowed ) {
				$this->mFormErrors[] = wfMsg( 'create-blog-permission-denied' );
			}
		}

		if ( empty( $this->mFormData['postBody'] ) ) {
			$this->mFormErrors[] = wfMsg( 'create-blog-empty-post-error' );
		}

		// create EditPage object
		$this->createEditPage( $this->mFormData['postBody'] );

		// BugId:954 - show changes
		if ( !empty( $this->mPostArticle ) ) {
			$this->mEditPage->mArticle = $this->mPostArticle;
		}

		if ( !count( $this->mFormErrors ) && $wgRequest->getVal( 'wpPreview' ) ) {
			// preview mode
			$this->mEditPage->formtype = 'preview';
			$this->mPreviewTitle = Title::newFromText( $this->mFormData['postTitle'] );

			// simple hack to show correct title in preview mode
			global $wgCustomTitle;
			$wgCustomTitle = $this->mPreviewTitle;

			// CategorySelect compatibility (add categories to article body)
			if ( $this->mCategorySelectEnabled ) {
				CategorySelectHooksHelper::onEditPageImportFormData( $this->mEditPage, $wgRequest );
			}
		}
	}

	protected function createEditPage( $sPostBody ) {
		$oArticle = new Article( Title::makeTitle( NS_BLOG_ARTICLE, 'New or Updated Blog Post' ) );

		$this->mEditPage = new EditPage( $oArticle );
		$this->mEditPage->textbox1 = $sPostBody;

		// this applies user preferences, such as minor and watchlist
		// EditPage::getContent was called twice (causes BugId:4604)
		// beware: dirty copy&paste of the code (will be replaced by RTE reskin)
		global $wgUser;
		# Sort out the "watch" checkbox
		if ( $wgUser->getGlobalPreference( 'watchdefault' ) ) {
			# Watch all edits
			$this->mEditPage->watchthis = true;
		} elseif ( $wgUser->getGlobalPreference( 'watchcreations' ) && !$this->mEditPage->mTitle->exists() ) {
			# Watch creations
			$this->mEditPage->watchthis = true;
		} elseif ( $this->mEditPage->mTitle->userIsWatching() ) {
			# Already watched
			$this->mEditPage->watchthis = true;
		}
		if ( $wgUser->getGlobalPreference( 'minordefault' ) ) $this->mEditPage->minoredit = true;

		// fix for RT #33844 - run hook fired by "classical" EditPage
		// Allow extensions to modify edit form
		global $wgEnableRTEExt, $wgRequest;
		if ( !empty( $wgEnableRTEExt ) ) {
			$wgRequest->setVal( 'wpTextbox1', $sPostBody ); // RT #34055

			wfRunHooks( 'AlternateEdit', array( &$this->mEditPage ) );
			$this->mEditPage->textbox1 = $wgRequest->getVal( 'wpTextbox1' );

			RTE::log( __METHOD__ . '::wikitext', $this->mEditPage->textbox1 );
		}
	}

	protected function renderForm() {
		if ( $this->mEditPage instanceof EditPage )
			$this->mEditPage->showEditForm( array( $this, 'renderFormHeader' ) );
		return true;
	}

	/**
	 * EditPage::showEditForm callback - need to be public
	 *
	 * @param OutputPage $wgOut
	 */
	public function renderFormHeader( OutputPage $wgOut ) {
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$oTmpl->set_vars( array(
			"formErrors" => $this->mFormErrors,
			"formData" => $this->mFormData,
			"preview" => $this->mPreviewTitle
		) );

		$wgOut->setPageTitle( wfMsg( "create-blog-post-title" ) );
		$wgOut->addScriptFile( 'edit.js' );
		$wgOut->addHTML( $oTmpl->render( "createBlogFormHeader" ) );

		// BugId:954 - show changes
		if ( $this->mEditPage->diff ) {
			$this->mEditPage->mArticle->loadContent();
			$this->mEditPage->showDiff();
		}
	}

	private function parseArticle( $sTitle ) {
		global $wgContLang;

		$oTitle = Title::newFromText( $sTitle, NS_BLOG_ARTICLE );
		$oArticle = new Article( $oTitle, 0 );

		// macbre: RT #37120
		$sArticleBody = $oTitle->exists() ? $oArticle->getContent() : '';

		$aPageProps = BlogArticle::getProps( $oArticle->getId() );
		$aTitleParts = explode( '/', $oTitle->getText(), 2 );

		$this->mFormData['postId'] = $oArticle->getId();
		$this->mFormData['postTitle'] = $aTitleParts[1];
		$this->mFormData['postBody'] = trim( preg_replace( '/\[\[' . $wgContLang->getFormattedNsText( NS_CATEGORY ) . ':(.*)\]\]/siU', '', $sArticleBody ) );
		$this->mFormData['postBody'] = $sArticleBody;
		$this->mFormData['isVotingEnabled'] = isset( $aPageProps['voting'] ) ? $aPageProps['voting'] : 0;
		$this->mFormData['isCommentingEnabled'] = isset( $aPageProps['commenting'] ) ? $aPageProps['commenting'] : 0;
		$this->mFormData['isExistingArticleEditAllowed'] = 1;

		// create EditPage object
		$this->createEditPage( $this->mFormData['postBody'] );

		// CategorySelect compatibility (restore categories from article body)
		if ( $this->mCategorySelectEnabled ) {
			CategorySelectHooksHelper::onEditPageGetContentEnd( $this->mEditPage, $this->mEditPage->textbox1 );
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
	 * @param BlogArticle $article
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
		/** @var Article|WikiPage $oArticle */
		$oArticle = new Article( $oTitle, 0 );
		if ( !$oArticle->exists( ) ) {
			/**
			 * add empty article for newlycreated blog
			 */
			$oArticle->doEdit(
				wfMsg( "create-blog-empty-article" ),     # body
				wfMsg( "create-blog-empty-article-log" ), # summary
				EDIT_NEW | EDIT_MINOR | EDIT_FORCE_BOT  # flags
			);
		}
	}

	/**
	 * Add hidden field with blog page title when captcha is triggered (BugId:6679)
	 *
	 * Title provided by the user will be maintained when captcha is resolved and next POST request sent
	 *
	 * @param EditPage $editPage
	 * @param OutputPage $wgOut
	 *
	 * @return bool
	 */
	public static function onEditPageShowEditFormFields( &$editPage, OutputPage &$wgOut ) {
		global $wgRequest;
		$blogPostTitle = $wgRequest->getVal( 'blogPostTitle' );

		if ( !is_null( $blogPostTitle ) && $wgRequest->wasPosted() ) {
			$wgOut->addHTML( Html::hidden( 'blogPostTitle', $blogPostTitle ) );
		}

		return true;
	}
}

class EditBlogPage extends EditPage {
	# ---
	function __construct ( $article ) {
		parent::__construct( $article );
	}

	protected function wasDeletedSinceLastEdit() {
		# allow to recreate (always)
		return false;
	}
}
