<?php

/**
 * @addto SpecialPages
 *
 * @author Adrian Wieczorek
 */
class CreateBlogPage extends SpecialBlogPage {

	public function __construct() {
		// initialise messages
		wfLoadExtensionMessages( "Blogs" );
		parent::__construct( 'CreateBlogPage'  /*class*/, '' /*restriction*/, true);
	}

	public function execute() {
		global $wgOut, $wgUser, $wgRequest;

		if( !$wgUser->isLoggedIn() ) {
			$wgOut->showErrorPage( 'create-blog-no-login', 'create-blog-login-required');
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

		$wgOut->setPageTitle( wfMsg("create-blog-post-title") );

		if($wgRequest->wasPosted()) {
			$this->parseFormData();
			if(count($this->mFormErrors) > 0 || !empty($this->mRenderedPreview)) {
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
			$this->renderForm();
		}
	}

	protected function save() {
		global $wgOut, $wgUser, $wgContLang;

		$sPostBody = $this->mFormData['postBody'];

		if(!empty($this->mFormData['postCategories'])) {
			// add categories
			$aCategories = preg_split ("/\|/", $this->mFormData['postCategories'], -1);
			$sPostBody .= $this->getCategoriesAsText($aCategories);
		}

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
		$editPage->summary  = wfMsg('create-blog-updated');
		$status = $editPage->internalAttemptSave( $result );
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
				$sMsg = wfMsg('create-blog-spam');
				$this->mFormErrors[] = $sMsg . "($status)";
				$this->renderForm();
				break;
		}

	}

	protected function parseFormData() {
		global $wgUser, $wgRequest, $wgOut;

		$this->mFormData['postId'] = $wgRequest->getVal('blogPostId');
		$this->mFormData['postTitle'] = $wgRequest->getVal('blogPostTitle');
		$this->mFormData['postBody'] = $wgRequest->getVal('wpTextbox1');
		$this->mFormData['postCategories'] = $wgRequest->getVal('wpCategoryTextarea1');
		$this->mFormData['isVotingEnabled'] = $wgRequest->getCheck('blogPostIsVotingEnabled');
		$this->mFormData['isCommentingEnabled'] = $wgRequest->getCheck('blogPostIsCommentingEnabled');
		$this->mFormData['isExistingArticleEditAllowed'] = $wgRequest->getVal('articleEditAllowed');

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
			$isSysop = ( in_array('sysop', $wgUser->getGroups()) || in_array('staff', $wgUser->getGroups() ) );
			$oPostTitle = Title::newFromID($this->mFormData['postId']);
			$this->mPostArticle = new BlogArticle($oPostTitle, 0);
			if((strtolower($wgUser->getName()) != strtolower( BlogArticle::getOwner($oPostTitle))) && !$isSysop) {
				$this->mFormErrors[] = wfMsg('create-blog-permission-denied');
			}
		}

		if(empty($this->mFormData['postBody'])) {
			$this->mFormErrors[] = wfMsg('create-blog-empty-post-error');
		}

		if(!count($this->mFormErrors) && $wgRequest->getVal('wpPreview')) {
			$oParser = new Parser();
			$this->mRenderedPreview = $oParser->parse( $this->mFormData['postBody'], Title::newFromText($this->mFormData['postTitle']), $wgOut->parserOptions() );
		}
	}

	protected function renderForm() {
		global $wgOut, $wgScriptPath;

		$wgOut->addScript( '<script type="text/javascript" src="' . $wgScriptPath . '/skins/common/edit.js"><!-- edit js --></script>');
		$wgOut->addScript( '<script type="text/javascript" src="' . $wgScriptPath . '/extensions/wikia/Blogs/js/categoryCloud.js"><!-- categoryCloud js --></script>');

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$oTmpl->set_vars( array(
			'categoryCloudTitle' => wfMsg('create-blog-categories-title'),
			'cloud' => new TagCloud(),
			'cols' => 10,
			'cloudNo' => 1,
			'textCategories' => ( isset($this->mFormData['postCategories']) ? $this->mFormData['postCategories'] : "" ) )
		);

		$sCategoryCloud = $oTmpl->execute("createPostCategoryCloud");

		$oTmpl->set_vars( array(
			"title" => $this->mTitle,
			"formErrors" => $this->mFormErrors,
			"formData" => $this->mFormData,
			"preview" => $this->mRenderedPreview,
			"categoryCloud" => $sCategoryCloud )
		);

		$wgOut->addHTML( $oTmpl->execute("createBlogForm") );


		return;
	}

	private function parseArticle($sTitle) {
		global $wgParser, $wgContLang;

		$oTitle = Title::newFromText($sTitle, NS_BLOG_ARTICLE);
		$oArticle = new Article($oTitle, 0);
		$sArticleBody = $oArticle->getContent();
		$aPageProps = BlogArticle::getProps($oArticle->getId());
		$aTitleParts = explode('/', $oTitle->getText(), 2);

		$this->mFormData['postId'] = $oArticle->getId();
		$this->mFormData['postTitle'] = $aTitleParts[1];
		$this->mFormData['postBody'] = trim(preg_replace('/\[\[' . $wgContLang->getFormattedNsText( NS_CATEGORY ) . ':(.*)\]\]/siU', '', $sArticleBody));
		$this->mFormData['postCategories'] = implode('|', $this->getCategoriesFromArticleContent($sArticleBody));
		$this->mFormData['isVotingEnabled'] = isset($aPageProps['voting']) ? $aPageProps['voting'] : 0;
		$this->mFormData['isCommentingEnabled'] = isset($aPageProps['commenting']) ? $aPageProps['commenting'] : 0;
		$this->mFormData['isExistingArticleEditAllowed'] = 1;

	}

	private function getCategoriesFromArticleContent($sArticleContent) {
		global $wgContLang;

		$aMatches = null;
		preg_match_all('/\[\[' . $wgContLang->getFormattedNsText( NS_CATEGORY ) . ':(.*)\]\]/siU', $sArticleContent, $aMatches);

		return ( is_array($aMatches) ? $aMatches[1] : array() );
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
