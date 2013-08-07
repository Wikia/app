<?php
class ArticleCommentInit {
	const ERROR_READONLY = 1;
	const ERROR_USER_CANNOT_EDIT = 2;

	public static $enable = null;
	public static $commentByAnonMsg = null;

	static public function ArticleCommentCheck( $title=null ) {
		global $wgRequest, $wgUser;
		wfProfileIn( __METHOD__ );

		if( $title === null ) {
			global $wgTitle;
			$title = $wgTitle;
		}

		if (is_null(self::$enable) && !empty($title)) {
			self::$enable = self::ArticleCommentCheckTitle($title);

			if (self::$enable && !is_null($wgRequest->getVal('diff'))) {
				self::$enable = false;
			}

			$action = $wgRequest->getVal('action', 'view');
			if (self::$enable && $action == 'purge' && $wgUser->isAnon() && !$wgRequest->wasPosted()) {
				self::$enable = false;
			}

			if (self::$enable && $action != 'view' && $action != 'purge') {
				self::$enable = false;
			}

			if (self::$enable && !wfRunHooks('ArticleCommentCheck', array($title))) {
				self::$enable = false;
			}
		}
		wfProfileOut( __METHOD__ );
		return self::$enable;
	}

	/**
	 * Check whether comments should be enabled for given title
	 */
	static public function ArticleCommentCheckTitle($title) {
		wfProfileIn(__METHOD__);

		//enable comments only on content namespaces (use $wgArticleCommentsNamespaces if defined)
		if ( !self::ArticleCommentCheckNamespace($title) ) {
			wfProfileOut(__METHOD__);
			return false;
		}

		//non-existing articles
		if ( !$title->exists() ) {
			wfProfileOut(__METHOD__);
			return false;
		}

		//disable on main page (RT#33703)
		if ( Title::newMainPage()->getText() == $title->getText() ) {
			wfProfileOut(__METHOD__);
			return false;
		}

		//disable on pages that cant be read (RT#49525)
		if ( !$title->userCan('read') ) {
			wfProfileOut(__METHOD__);
			return false;
		}

		//blog listing? (eg: User:Name instead of User:Name/Blog_name) - do not show comments
		if ( ArticleComment::isBlog() && strpos( $title->getText(), '/' ) === false ) {
			wfProfileOut(__METHOD__);
			return false;
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Check whether comments should be enabled for namespace of given title
	 */
	static public function ArticleCommentCheckNamespace($title) {
		global $wgContentNamespaces, $wgArticleCommentsNamespaces;
		wfProfileIn(__METHOD__);

		//enable comments only on content namespaces (use $wgArticleCommentsNamespaces if defined)

		$enable = (
				$title instanceof Title &&
				in_array(
						$title->getNamespace(),
						empty( $wgArticleCommentsNamespaces ) ? $wgContentNamespaces : $wgArticleCommentsNamespaces
				)
		);

		wfProfileOut(__METHOD__);
		return $enable;
	}

	//hook used only in Monaco - we want to put comment box in slightly different position, just between article area and the footer
	static public function ArticleCommentEnableMonaco(&$this, &$tpl, &$custom_article_footer) {
		//don't touch $custom_article_footer! we don't want to replace the footer - we just want to echo something just before it
		if (self::ArticleCommentCheck()) {
			global $wgTitle;

			$page = ArticleCommentList::newFromTitle($wgTitle);
			echo $page->render();
		}
		return true;
	}

	static public function ArticleCommentEnable(&$data) {
		global $wgTitle;

		$skin = RequestContext::getMain()->getSkin();

		//use this hook only for skins other than Monaco
		//update: it's actually only MonoBook since Oasis and WikiaMobile use their own
		//logic and the other mobile skins do not show comments-related stuff
		if ( $skin instanceof SkinMonoBook ) {
			wfProfileIn( __METHOD__ );

			if (self::ArticleCommentCheck()) {

				$page = ArticleCommentList::newFromTitle($wgTitle);
				$data = $page->render();
			}

			wfProfileOut( __METHOD__ );
		}

		return true;
	}

	/**
	 * @static
	 * @param OutputPage $out
	 * @param Skin $sk
	 * @return bool
	 */
	static public function ArticleCommentAddJS( &$out, &$sk ){
		global $wgExtensionsPath;
		wfProfileIn( __METHOD__ );

		if ( self::ArticleCommentCheck() ) {
			//FB#21244 this should run only for MonoBook, Oasis and WikiaMobile have their own SASS-based styling
			if ( $sk instanceof SkinMonoBook ) {
				$out->addExtensionStyle("$wgExtensionsPath/wikia/ArticleComments/css/ArticleComments.css");
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	//TODO: not used in oasis - remove
	static public function ArticleCommentHideTab($skin, &$content_actions) {
		global $wgArticleCommentsHideDiscussionTab;
		wfProfileIn( __METHOD__ );

		if (!empty($wgArticleCommentsHideDiscussionTab) && self::ArticleCommentCheck()) {
			unset($content_actions['talk']);
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Hook
	 *
	 * @param Parser $parser -- instance of Parser class
	 * @param Skin $sk -- instance of Skin class
	 * @param string $toc -- HTML for TOC
	 * @param array $sublevelCount -- last used numbers for each indentation
	 *
	 * @static
	 * @access public
	 * @todo TODO: not working - check
	 *
	 * @return Bool true -- because it's a hook
	 */
	static function InjectTOCitem($parser, &$toc, &$sublevelCount) {
		if ( self::ArticleCommentCheck() && !( F::app()->checkSkin( 'wikiamobile' ) ) ) {
			$tocnumber = ++$sublevelCount[1];

			$toc .= Linker::tocLine('WikiaArticleComments', wfMsg( 'article-comments-toc-item' ), $tocnumber, 1);
		}
		return true;
	}

	/**
	 * Hook handler
	 *
	 * @param Title $title
	 * @param User $fakeUser
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static function ArticleCommentNotifyUser($title, &$fakeUser) {
		if ($title->getNamespace() == NS_USER_TALK && ArticleComment::isTitleComment($title)) {
			$parts = ArticleComment::explode($title->getText());
			if ($parts['title'] != '') {
				$newUser = User::newFromName($parts['title']);
				if ($newUser instanceof User) {
					$fakeUser = $newUser;
				}
			}
		}
		return true;
	}

	/**
	 * Hook handler
	 *
	 * @static
	 * @param Title $title
	 * @param User $user
	 * @param $action
	 * @param $result
	 * @return bool
	 */
	public static function userCan( $title, $user, $action, &$result ) {
		$namespace = $title->getNamespace();

		// we only care if this is a talk namespace
		if ( MWNamespace::getSubject( $namespace ) == $namespace ) {
			return true;
		}

		//for blog comments BlogLockdown is checking rights
		if ( ArticleComment::isBlog() ) {
			return true;
		}

		$parts = ArticleComment::explode($title->getText());
		//not article comment
		if (count($parts['partsStripped']) == 0) {
			return true;
		}

		$firstRev = $title->getFirstRevision();
		if ($firstRev && $user->getName() == $firstRev->getUserText()) {
			return true;
		}

		// Facebook connection needed
		if ( self::isFbConnectionNeeded() ){
			return false;
		}

		switch ($action) {
			case 'move':
			case 'move-target':
				return $user->isAllowed( 'commentmove' );
				break;
			case 'edit':
				return $user->isAllowed( 'commentedit' );
				break;
			case 'delete':
				return $user->isAllowed( 'commentdelete' );
				break;
		}
		return true;
	}

	/**
	 * isFbConnectionNeeded -- checkes is everything OK with Facebook connection
	 *
	 * @access public
	 * @author Jakub
	 *
	 * @return boolean
	 */
	static public function isFbConnectionNeeded() {
		global $wgRequireFBConnectionToComment, $wgEnableFacebookConnectExt, $wgUser;

		if ( !empty ( $wgRequireFBConnectionToComment ) &&
				!empty ( $wgEnableFacebookConnectExt ) ) {
			$fb = new FBConnectAPI();
			$tmpArrFaceBookId = FBConnectDB::getFacebookIDs($wgUser);
			$isFBConnectionProblem = (
					( $fb->user() == 0 ) ||					// fb id or 0 if none is found.
					!isset( $tmpArrFaceBookId[0] ) ||
					( (int)$fb->user() != (int)$tmpArrFaceBookId[0] )	// current fb id different from fb id of currenty logged user.
			);
			return $isFBConnectionProblem;
		} else {
			return false;
		}
	}

	/**
	 * HAWelcome
	 *
	 * @param Title $title
	 * @param User $fakeUser
	 *
	 * @access public
	 * @author Jakub
	 *
	 * @return boolean
	 */
	static public function HAWelcomeGetPrefixText( &$prefixedText, $title ) {

		if ( ArticleComment::isTitleComment( $title ) ){
			$title = $title->getSubjectPage();
			$prefixedText = $title->getPrefixedText();

			$aPrefix = explode( ARTICLECOMMENT_PREFIX, $prefixedText );
			if ( count( $aPrefix ) > 0 ){
				$prefixedText = substr_replace( $aPrefix[0] ,"" ,-1 );
			}
		}
		return true;
	}

	/**
	 * Checks if a user can comment, producing an error code and a related message
	 *
	 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
	 *
	 * @param array $info [Optional] If passed this will be filled in with an error code and related message in case of negative result
	 * @param Title $title [Optional] Title to use to create login counter redirect
	 * @param User $user [Optional] The user to check, if not passed it will use the global user
	 *
	 * @return bool
	 */
	static public function userCanComment( Array &$info = array(), Title $title = null, User $user = null ) {
		$ret = true;

		if ( !( $user instanceof User ) ) {
			global $wgUser;
			$user = $wgUser;
		}

		if (wfReadOnly()) {
			$info['error'] = self::ERROR_READONLY;
			$info['msg'] = wfMsg('readonlytext');
			$ret = false;
		} elseif ( !$user->isAllowed( 'edit' ) ) {
			$info['error'] = self::ERROR_USER_CANNOT_EDIT;
			$info['msg'] = wfMsg( 'article-comments-login', SpecialPage::getTitleFor( 'UserLogin' )->getLocalUrl( ( $title instanceof Title ) ? 'returnto=' . $title->getPrefixedUrl() : null ) );
			$ret = false;
		}

		return $ret;
	}

	//when comments are enabled on the current namespace make the WikiaMobile skin enriched assets
	//while keeping the response size (assets minification) and the number of external requests low (aggregation)
	static public function onWikiaMobileAssetsPackages( Array &$jsStaticPackages, Array &$jsExtensionPackages, Array &$scssPackages ){
		if ( self::ArticleCommentCheck() ) {
			$jsExtensionPackages[] = 'articlecomments_init_js_wikiamobile';
		}

		return true;
	}

	/**
	 * formats links in the "File usage" section of file pages
	 * @author Jakub Olek
	 */
	public static function onFilePageImageUsageSingleLink( &$link, &$element ) {
		$app = F::app();
		$ns = $element->page_namespace;

		$title = Title::newFromText( $element->page_title, $ns );

		if ( empty( $title ) ) {
			// sanity check
			return true;
		}

		// format links to comment pages
		if ( $ns == NS_TALK && ArticleComment::isTitleComment( $title ) ) {
			$parentTitle = reset( explode( '/', $element->page_title) ); // getBaseText returns me parent comment for subcomment

			$link = wfMsgExt(
				'article-comments-file-page',
				array ('parsemag'),
				$title->getLocalURL(),
				self::getUserNameFromRevision($title),
				Title::newFromText( $parentTitle )->getLocalURL(),
				$parentTitle
			);

		// format links to blog posts
		} else if ( defined('NS_BLOG_ARTICLE_TALK') && $ns == NS_BLOG_ARTICLE_TALK ) {
			$baseText = $title->getBaseText();
			$titleNames = explode( '/', $baseText );
			$userBlog = Title::newFromText( $titleNames[0], NS_BLOG_ARTICLE );

			$link = wfMsgExt(
				'article-blog-comments-file-page',
				array ('parsemag'),
				$title->getLocalURL(),
				self::getUserNameFromRevision($title),
				Title::newFromText( $baseText, NS_BLOG_ARTICLE )->getLocalURL(),
				$titleNames[1],
				$userBlog->getLocalURL(),
				$userBlog->getBaseText()
			);
		}

		return true;
	}

	public static function getUserNameFromRevision(Title $title) {
		$rev = Revision::newFromId( $title->getLatestRevID() );
		
		if ( !empty( $rev ) ) {
			$user = User::newFromId( $rev->getUser() );

			if ( !empty( $user ) ) {
				$userName = $user->getName();
			} else {
				$userName = self::getCommentByAnonMsg();
			}
		}
		
		return $userName;
	}
	
	public static function getCommentByAnonMsg() {
		if( is_null(self::$commentByAnonMsg) ) {
			self::$commentByAnonMsg = wfMessage( 'article-comments-anonymous' )->text();
		}
		
		return self::$commentByAnonMsg;
	}
}
