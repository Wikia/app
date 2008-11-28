<?php

/**
 * @addto SpecialPages
 *
 * @author Adrian Wieczorek
 */
class CreateBlogPage extends SpecialBlogPage {

	public function __construct() {
		global $wgExtensionMessagesFiles;

		// initialise messages
		$wgExtensionMessagesFiles['CreateBlogPage'] = dirname(__FILE__) . '/Blogs.i18n.php';
		wfLoadExtensionMessages('CreateBlogPage');

		parent::__construct( 'CreateBlogPage'  /*class*/, 'createblogpage' /*restriction*/, true);
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
			$this->renderForm();
		}
	}

	protected function save() {
		global $wgOut, $wgUser;

		$sPostBody = $this->mFormData['postBody'];

		if(!empty($this->mFormData['postCategories'])) {
			// add categories
			$aCategories = preg_split ("/\|/", $this->mFormData['postCategories'], -1);
			$sPostBody .= $this->getCategoriesAsText($aCategories);
		}

		$aPageProps = array();
		if(!empty($this->mFormData['isVotingEnabled'])) {
			$aPageProps['voting'] = 1;
		}
		if(!empty($this->mFormData['isCommentingEnabled'])) {
			$aPageProps['commenting'] = 1;
		}

		$this->mPostArticle->doEdit($sPostBody, "Blog post created." );
		if(count($aPageProps)) {
			// save extra properties
			$this->mPostArticle->saveProps($aPageProps);
		}

		$this->createListingPage();

		self::invalidateCacheConnected( $this->mPostArticle );

		$wgOut->redirect($this->mPostArticle->getTitle()->getFullUrl());
	}

	protected function parseFormData() {
		global $wgUser, $wgRequest, $wgOut;

		$this->mFormData['postTitle'] = $wgRequest->getVal('blogPostTitle');
		$this->mFormData['postBody'] = $wgRequest->getVal('wpTextbox1');
		$this->mFormData['postCategories'] = $wgRequest->getVal('wpCategoryTextarea1');
		$this->mFormData['isVotingEnabled'] = $wgRequest->getCheck('blogPostIsVotingEnabled');
		$this->mFormData['isCommentingEnabled'] = $wgRequest->getCheck('blogPostIsCommentingEnabled');

		$oPostTitle = Title::newFromText( $wgUser->getName() . '/' . $this->mFormData['postTitle'], NS_BLOG_ARTICLE);
		$this->mPostArticle = new BlogListPage($oPostTitle, 0);

		if(empty($this->mFormData['postTitle'])) {
			$this->mFormErrors[] = wfMsg('create-blog-empty-title-error');
		}
		else if(!($oPostTitle instanceof Title)) {
			$this->mFormErrors[] = wfMsg('create-blog-invalid-title-error');
		}
		else if($this->mPostArticle->exists()) {
			$this->mFormErrors[] = wfMsg('create-blog-article-already-exists');
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
		$wgOut->addHTML( '<link rel="stylesheet" type="text/css" href="' . $wgScriptPath . '/extensions/wikia/Blogs/css/BlogCreateForm.css" />' );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$oTmpl->set_vars( array(
			'categoryCloudTitle' => wfMsg('create-blog-categories-title'),
			'cloud' => new TagCloud(),
			'cols' => 10,
			'cloudNo' => 1,
			'textCategories' => $this->mFormData['postCategories'] )
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

	/**
	 * purge cache for connected articles
	 *
	 * @static
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 *
	 */
	static public function invalidateCacheConnected( BlogListPage $article ) {
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
	 * create listing article
	 *
	 * @access private
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 */
	private function createListingPage() {
		global $wgUser;

		/**
		 * it should be done only once
		 */
		$listing = Title::newFromText( $wgUser->getName(), NS_BLOG_ARTICLE );
		$article = new Article( $listing, 0 );
		// $oArticle->doEdit($sPostBody, "Blog listing created." );
	}
}
