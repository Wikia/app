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
		wfProfileIn( __METHOD__ );
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
		wfProfileOut( __METHOD__ );
	}

	protected function afterArticleInitialize($mode, $title, $article) {
		wfProfileIn( __METHOD__ );
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
		wfProfileOut( __METHOD__ );
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
		wfProfileIn( __METHOD__ );
		if( empty($this->mEditPage->summary )) {
			$this->mEditPage->summary = wfMessage( 'create-blog-updated' )->inContentLanguage()->text();
		}
		$this->mEditPage->recreate = true;
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Perform additional checks when saving an article
	 */
	protected function processSubmit() {
		wfProfileIn( __METHOD__ );
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
		wfProfileOut( __METHOD__ );
	}
	public function getPageTitle() {
		if( $this->mode == self::MODE_EDIT ) {
			return wfMessage( 'create-blog-post-title-edit' )->text();
		} else {
			return wfMessage( 'create-blog-post-title' )->text();
		}
	}

	public function renderHeader($par) {
		wfProfileIn( __METHOD__ );
		$this->forceUserToProvideTitle('create-blog-form-post-title');
		$this->addCustomCheckbox(self::FIELD_IS_COMMENTING_ENABLED, wfMessage( 'blog-comments-label')->text(), $this->mFormData['isCommentingEnabled']);
		wfProfileOut( __METHOD__ );
	}

	protected function afterSave( $status ) {
		wfProfileIn( __METHOD__ );
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
					$sMsg = wfMessage( 'create-blog-cant-edit' )->text();
				}
				else {
					$sMsg = wfMessage( 'create-blog-spam' )->text();
				}
				Wikia::log( __METHOD__, "save error", $sMsg, true );
				break;
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * purge cache for connected articles
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 *
	 */
	public function invalidateCacheConnected( BlogArticle $article ) {
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


	protected function setEditedTitle(Title $title) {
		wfProfileIn( __METHOD__ );
		$this->setEditedArticle(new BlogArticle($title));
		wfProfileOut( __METHOD__ );
	}
}
