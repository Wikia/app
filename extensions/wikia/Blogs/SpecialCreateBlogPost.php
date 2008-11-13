<?php

class CreateBlogPost extends SpecialPage {

	private $mFormData;
	private $mFormErrors = array();
	private $mPostTitle = null;

	public function __construct() {
		global $wgExtensionMessagesFiles;

		// initialise messages
		$wgExtensionMessagesFiles['CreateBlogPost'] = dirname(__FILE__) . '/Blogs.i18n.php';
		wfLoadExtensionMessages('CreateBlogPost');

		parent::__construct( 'CreateBlogPost'  /*class*/, 'createblogpost' /*restriction*/, true);
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

			$this->mTitle = Title::makeTitle( NS_SPECIAL, 'CreateBlogPost' );

			$wgOut->setPageTitle( wfMsg("create-blog-post-title") );

			if($wgRequest->wasPosted()) {
				$this->parseFormData();
				if(count($this->mFormErrors) > 0) {
					$this->renderForm();
				}
				else {
					$this->savePost();
				}
			}
			else {
				$this->renderForm();
			}
		}

		private function savePost() {
			global $wgOut, $wgUser;

			$oArticle = new Article($this->mPostTitle, 0);
			$oArticle->doEdit($this->mFormData['postBody'], "Blog post created." );

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"title" => $this->mPostTitle)
			);

			$wgOut->addHTML( $oTmpl->execute("createPostConfirm") );
			return true;
		}

		private function parseFormData() {
			global $wgUser, $wgRequest;

			$this->mFormData['postTitle'] = $wgRequest->getVal('blogPostTitle');
			$this->mFormData['postBody'] = $wgRequest->getVal('wpTextbox1');
			$this->mFormData['isVotingEnabled'] = $wgRequest->getCheck('blogPostIsVotingEnabled');
			$this->mFormData['isCommentingEnabled'] = $wgRequest->getCheck('blogPostIsCommentingEnabled');

			$this->mPostTitle = Title::newFromText( $wgUser->getName() . '/' . $this->mFormData['postTitle'], NS_BLOG_ARTICLE);

			if(empty($this->mFormData['postTitle'])) {
				$this->mFormErrors[] = wfMsg('create-blog-empty-title-error');
			}
			else if(!($this->mPostTitle instanceof Title)) {
				$this->mFormErrors[] = wfMsg('create-blog-invalid-title-error');
			}

			if(empty($this->mFormData['postBody'])) {
				$this->mFormErrors[] = wfMsg('create-blog-empty-post-error');
			}
		}

		private function renderForm() {
			global $wgOut, $wgScriptPath;

			$wgOut->addScript( '<script type="text/javascript" src="' . $wgScriptPath . '/skins/common/edit.js"><!-- edit js --></script>');

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

			$oTmpl->set_vars( array(
				'num' => 0,
				'cloud' => new TagCloud(),
				'cols' => 10,
				'text_category' => '' ,
				'array_category' => array () )
			);

			$sCategoryCloud = $oTmpl->execute("createPostCategoryCloud");

			$oTmpl->set_vars( array(
				"title" => $this->mTitle,
				"formErrors" => $this->mFormErrors,
				"formData" => $this->mFormData,
				"categoryCloud" => $sCategoryCloud )
			);

			$wgOut->addHTML( $oTmpl->execute("createPostForm") );


			return;
		}

}

