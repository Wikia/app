<?php

class CreateBlogPage extends SpecialCustomEditPage {

	const FIELD_IS_COMMENTING_ENABLED = 'wpIsCommentingEnabled';
	const STATUS_BLOG_PERMISSION_DENIED = -101;
	protected $mFormData = array();
	protected $titleNS = NS_BLOG_ARTICLE;

	public function __construct() {
		//TODO create some abstract metod to force user to get CreateBlogPage
		parent::__construct('CreateBlogPage');
	}

	protected function initializeEditPage() {
		$editPage = parent::initializeEditPage();
		$editPage->isCreateBlogPage = true;
		return $editPage;
	}


	public function execute($par) {
		if( !$this->user->isLoggedIn() ) {
			$this->out->showErrorPage( 'create-blog-no-login', 'create-blog-login-required', array(wfGetReturntoParam()));
			return;
		}

		if( $this->user->isBlocked() ) {
			throw new UserBlockedError( $this->user->mBlock );
		}

		if( wfReadOnly() ) {
			$this->out->readOnlyPage();
			return;
		}

		parent::execute($par);
		
		/* bugId::34933 Actions::getActionName() assumes every Special page is a view.  Forcing a wgAction override for this page */
		RequestContext::getMain()->getOutput()->addJsConfigVars('wgAction', 'edit');
	}

	protected function afterArticleInitialize($mode, $title, $article) {
		wfRunHooks('BlogArticleInitialized', array($this, $mode));

		if( $mode == self::MODE_EDIT ) {
			$aPageProps = BlogArticle::getProps($article->getId());
			$this->mFormData['isCommentingEnabled'] = empty($aPageProps['commenting']) ? 0 :$aPageProps['commenting'];

			$isAllowed = $this->user->isAllowed( "blog-articles-edit" );
			if((strtolower($this->user->getName()) != strtolower( BlogArticle::getOwner($title))) && !$isAllowed) {
				$this->titleStatus = self::STATUS_BLOG_PERMISSION_DENIED;
				$this->addEditNotice(  wfMsg('create-blog-permission-denied') );
			}
		} else {
			$this->mFormData['isCommentingEnabled'] = true;
		}
	}

	/**
	 * Return wikitext for generating preview / diff / to be saved
	 */
	public function getWikitextFromRequest() {
		$wikitext = parent::getWikitextFromRequest();

		if( $this->mode == self::MODE_NEW ) {
			$catName = wfMsgForContent("create-blog-post-category");
			$sCategoryNSName = $this->contLang->getFormattedNsText( NS_CATEGORY );
			$wikitext .= "\n[[" . $sCategoryNSName . ":" . $catName . "]]";
		}

		return $wikitext;
	}


	protected function getTitlePrefix() {
		return $this->user->getName() . '/';
	}

	/**
	 * add some default values
	 */
	public function beforeSave() {
		if( empty($this->mEditPage->summary )) {
			$this->mEditPage->summary = wfMsgForContent('create-blog-updated');
		}
		$this->mEditPage->recreate = true;
	}

	/**
	 * Perform additional checks when saving an article
	 */
	protected function processSubmit() {
		//used to set some default values */

		if ($this->mode != self::MODE_NEW_SETUP) {
			if ($this->contentStatus == EditPage::AS_BLANK_ARTICLE) {
				$this->addEditNotice(wfMsg('plb-create-empty-body-error'));
			}

			switch ($this->titleStatus) {
				case self::STATUS_EMPTY:
					$this->addEditNotice(wfMsg( 'create-blog-empty-title-error' ));
					break;
				case self::STATUS_INVALID:
					$this->addEditNotice( wfMsg('create-blog-invalid-title-error') );
					break;
				case self::STATUS_ALREADY_EXISTS:
					$this->addEditNotice(wfMsg( 'create-blog-article-already-exists' ));
					break;
			}
		}
	}
	public function getPageTitle() {
		if( $this->mode == self::MODE_EDIT ) {
			return wfMsg( 'create-blog-post-title-edit' );
		} else {
			return wfMsg( 'create-blog-post-title' );
		}
	}

	public function renderHeader($par) {
		$this->forceUserToProvideTitle('create-blog-form-post-title');
		$this->addCustomCheckbox(self::FIELD_IS_COMMENTING_ENABLED, wfMsg('blog-comments-label'), $this->mFormData['isCommentingEnabled']);
	}

	protected function afterSave( $status ) {
		switch( $status->value ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:

				$article = $this->getEditedArticle();
				$articleId = $article->getID();

				$aPageProps = array();
				$aPageProps['commenting'] = 0;
				if( $this->getField(self::FIELD_IS_COMMENTING_ENABLED) != "" ) {
					$aPageProps['commenting'] = 1;
				}

				if( count( $aPageProps ) ) {
					BlogArticle::setProps( $articleId, $aPageProps );
				}

				$this->invalidateCacheConnected( $article );
				$this->createListingPage();

				// BugID:25123 purge the main blog listing pages cache
				global $wgMemc;
				$user = $article->getTitle()->getBaseText();
				$ns = $article->getTitle()->getNSText();
				foreach( range(0, 5) as $page ) {
					$wgMemc->delete( wfMemcKey( 'blog', 'listing', $ns, $user, $page ) );
				}

				$this->out->redirect($article->getTitle()->getFullUrl());
				break;

			default:
				Wikia::log( __METHOD__, "editpage", $status->value );
				if( $status->value == EditPage::AS_READ_ONLY_PAGE_LOGGED ) {
					$sMsg = wfMsg('create-blog-cant-edit');
				}
				else {
					$sMsg = wfMsg('create-blog-spam');
				}
				Wikia::log( __METHOD__, "save error", $sMsg, true );
				break;
		}
	}

	/**
	 * purge cache for connected articles
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 *
	 */
	public function invalidateCacheConnected( BlogArticle $article ) {
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


	protected function setEditedTitle(Title $title) {
		$this->setEditedArticle(new BlogArticle($title));
	}
}
