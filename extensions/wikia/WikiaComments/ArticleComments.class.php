<?php

/**
 * ArticleComments
 *
 * A ArticleComments extension for MediaWiki
 * Adding comment functionality on article pages
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia.inc>
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-07-14
 * @copyright Copyright (C) 2010 Krzysztof Krzyżaniak, Wikia Inc.
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/ArticleComments/ArticleComments_setup.php");
 */

class ArticleCommentInit {
	private static $enable = null;

	static private function ArticleCommentCheck() {
		global $wgOut, $wgTitle, $wgUser, $wgRequest, $wgContentNamespaces, $wgArticleCommentsNamespaces, $wgEnableBlogArticles;
		wfProfileIn( __METHOD__ );

		if (is_null(self::$enable)) {
			self::$enable = true;
			//enable comments only on content namespaces (use $wgArticleCommentsNamespaces if defined)
			if (!in_array($wgTitle->getNamespace(), empty($wgArticleCommentsNamespaces) ? $wgContentNamespaces : $wgArticleCommentsNamespaces)) {
				self::$enable = false;
			}

			//non-existing articles
			if (!$wgTitle->exists()) {
				self::$enable = false;
			}

			$action = $wgRequest->getVal('action', 'view');
			if ($action == 'purge' && $wgUser->isAnon() && !$wgRequest->wasPosted()) {
				self::$enable = false;
			}
			if ($action != 'view' && $action != 'purge') {
				self::$enable = false;
			}

			//disable on main page (RT#33703)
			if (Title::newMainPage()->getText() == $wgTitle->getText()) {
				self::$enable = false;
			}

			//disable on redirect pages (RT#44315)
			if ($wgTitle->isRedirect()) {
				self::$enable = false;
			}

			//disable on pages that cant be read (RT#49525)
			if (!$wgTitle->userCan('read')) {
				self::$enable = false;
			}

			//commenting disabled? do not load extension
			if (class_exists('BlogArticle') && $wgTitle->getNamespace() == NS_BLOG_ARTICLE) {
				$props = BlogArticle::getProps($wgTitle->getArticleID());
				if (isset($props['commenting']) && !$props['commenting']) {
					self::$enable = false;
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return self::$enable;
	}

	//hook used only in Monaco - we want to put comment box in slightly different position, just between article area and the footer
	static public function ArticleCommentEnableMonaco(&$this, &$tpl, &$custom_article_footer) {
		//don't touch $custom_article_footer! we don't want to replace the footer - we just want to echo something just before it
		if (self::ArticleCommentCheck()) {
			global $wgTitle;
			wfLoadExtensionMessages('ArticleComments');
			$page = ArticleCommentList::newFromTitle($wgTitle);
			echo $page->render();
		}
		return true;
	}

	static public function ArticleCommentEnable(&$data) {
		global $wgTitle, $wgUser;

		//use this hook only for skins other than Monaco
		if (get_class($wgUser->getSkin()) == 'SkinMonaco' || get_class($wgUser->getSkin()) == 'SkinAnswers') {
			return true;
		}
		wfProfileIn( __METHOD__ );

		if (self::ArticleCommentCheck()) {
			wfLoadExtensionMessages('ArticleComments');
			$page = ArticleCommentList::newFromTitle($wgTitle);
			$data = $page->render();
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function ArticleCommentAddJS(&$out, &$sk) {
		global $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion, $wgEnableWikiaCommentsExt;
		wfProfileIn( __METHOD__ );

		if (self::ArticleCommentCheck()) {
			//TODO: temporary change: 2 different paths
			$folder = empty($wgEnableWikiaCommentsExt) ? 'ArticleComments' : 'WikiaComments';
			$out->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/$folder/js/ArticleComments.js?{$wgStyleVersion}\" ></script>\n");
			$out->addExtensionStyle("$wgExtensionsPath/wikia/$folder/css/ArticleComments.css?$wgStyleVersion");
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function ArticleCommentHideTab(&$skin, &$content_actions) {
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
	 * @param Parser $rc -- instance of Parser class
	 * @param Skin $sk -- instance of Skin class
	 * @param string $toc -- HTML for TOC
	 * @param array $sublevelCount -- last used numbers for each indentation
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static function InjectTOCitem($parser, $sk, &$toc, &$sublevelCount) {
		if (self::ArticleCommentCheck()) {
			wfLoadExtensionMessages('ArticleComments');
			$tocnumber = ++$sublevelCount[1];
			$toc .= $sk->tocLine('article-comment-header', wfMsg('article-comments-toc-item'), $tocnumber, 1);
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
	 */
	public static function userCan( $title, $user, $action, &$result ) {
		$namespace = $title->getNamespace();

		//for blog comments BlogLockdown is checking rights
		if ((defined('NS_BLOG_ARTICLE') && $namespace == NS_BLOG_ARTICLE) ||
			defined('NS_BLOG_ARTICLE_TALK') && $namespace == NS_BLOG_ARTICLE_TALK ) {
			return true;
		}

		$parts = ArticleComment::explode($title->getText());
		//not article comment
		if (count($parts['partsStripped']) == 0) {
			return true;
		}

		switch ($action) {
			case 'move':
			case 'move-target':
			case 'edit':
			case 'delete':
				//allow action if user is the author of 1st revision (sysop could edit an inappropriate comment)
				$firstRev = $title->getFirstRevision();
				if ($firstRev && $user->getName() == $firstRev->getUserText()) {
					return true;
				}

				//TODO: create new permission and remove checking groups below
				$groups = $user->getGroups();
				if (in_array('staff', $groups) || in_array('sysop', $groups)) {
					return true;
				}

				//fallback - not author nor sysop
				return false;
		}
		return true;
	}
}

/**
 * ArticleComment is article, this class is used for manipulation on it
 */
class ArticleComment {

	public
		$mProps,	//blogs only
		$mTitle,
		$mLastRevId,
		$mFirstRevId,
		$mLastRevision,  ### for displaying text
		$mFirstRevision, ### for author & time
		$mUser,	         ### comment creator
		$mNamespace,
		$mNamespaceTalk;


	public function __construct( $title ) {
		$this->mTitle = $title;
		$this->mNamespace = $title->getNamespace();
		$this->mNamespaceTalk = MWNamespace::getTalk($this->mNamespace);
		$this->mProps = false;
	}

	/**
	 * newFromTitle -- static constructor
	 *
	 * @static
	 * @access public
	 *
	 * @param Title $title -- Title object connected to comment
	 *
	 * @return ArticleComment object
	 */
	static public function newFromTitle( Title $title ) {
		return new ArticleComment( $title );
	}

	/**
	 * newFromTitle -- static constructor
	 *
	 * @static
	 * @access public
	 *
	 * @param Title $title -- Title object connected to comment
	 *
	 * @return ArticleComment object
	 */
	static public function newFromArticle( Article $article ) {
		$title = $article->getTitle();

		$comment = new ArticleComment( $title );
		return $comment;
	}

	/**
	 * newFromId -- static constructor
	 *
	 * @static
	 * @access public
	 *
	 * @param Integer $id -- identifier from page_id
	 *
	 * @return ArticleComment object
	 */
	static public function newFromId( $id ) {
		$title = Title::newFromID( $id );
		if ( ! $title ) {
			/**
			 * maybe from Master?
			 */
			$title = Title::newFromID( $id, GAID_FOR_UPDATE );

			if ( ! $title ) {
				return false;
			}
		}
		return new ArticleComment( $title );
	}


	/**
	 * load -- set variables, load data from database
	 */
	public function load($master = false) {
		wfProfileIn( __METHOD__ );

		$result = true;

		if ( $this->mTitle ) {
			/**
			 * if we lucky we got only one revision, we check slave first
			 * then if no answer we check master
			 */
			$this->mFirstRevId = $this->getFirstRevID( $master ? DB_MASTER : DB_SLAVE );
			if ( !$this->mFirstRevId && !$master ) {
				 $this->mFirstRevId = $this->getFirstRevID( DB_MASTER );
			}
			if ( !$this->mLastRevId ) {
				$this->mLastRevId = $this->mTitle->getLatestRevID();
			}
			/**
			 * still not defined?
			 */
			if ( !$this->mLastRevId ) {
				$this->mLastRevId = $this->mTitle->getLatestRevID( GAID_FOR_UPDATE );
			}
			if ( $this->mLastRevId != $this->mFirstRevId ) {
				if ( $this->mLastRevId && $this->mFirstRevId ) {
					$this->mLastRevision = Revision::newFromTitle( $this->mTitle );
					$this->mFirstRevision = Revision::newFromId( $this->mFirstRevId );
				}
				else {
					$this->mFirstRevision = Revision::newFromId( $this->mFirstRevId );
					$this->mLastRevision = $this->mFirstRevision;
					$this->mLastRevId = $this->mFirstRevId;
				}
			}
			else {
				if ( $this->mFirstRevId ) {
					$this->mFirstRevision = Revision::newFromId( $this->mFirstRevId );
					$this->mLastRevision = $this->mFirstRevision;
				}
				else {
					$result = false;
				}
			}

			if ( $this->mFirstRevision ) {
				$this->mUser = User::newFromId( $this->mFirstRevision->getUser() );
			}
			else {
				$result = false;
			}
		}
		else {
			$result = false;
		}
		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * getFirstRevID -- What is id for first revision
	 * @see Title::getLatestRevID
	 *
	 * @return Integer
	 */
	private function getFirstRevID( $db_conn ) {
		wfProfileIn( __METHOD__ );

		$id = false;

		if ( $this->mTitle ) {
			$db = wfGetDB($db_conn);
			$id = $db->selectField(
				'revision',
				'min(rev_id)',
				array( 'rev_page' => $this->mTitle->getArticleID() ),
				__METHOD__
			);
		}

		wfProfileOut( __METHOD__ );

		return $id;
	}
	/**
	 * getTitle -- getter/accessor
	 *
	 */
	public function getTitle() {
		return $this->mTitle;
	}

	/**
	 * render -- generate HTML for displaying comment
	 *
	 * @return String -- generated HTML text
	 */
	public function render($master = false) {
		global $wgLang, $wgContLang, $wgUser, $wgParser, $wgOut, $wgBlankImgUrl;

		wfProfileIn( __METHOD__ );

		$text = false;
		if ( $this->load($master) ) {
			$canDelete = $wgUser->isAllowed( 'delete' );

			$text = $wgOut->parse( $this->mLastRevision->getText() );
			$sig = ( $this->mUser->isAnon() )
				? Xml::span( wfMsg('article-comments-anonymous'), false, array( 'title' => $this->mFirstRevision->getUserText() ) )
				: Xml::element( 'a', array ( 'href' => $this->mUser->getUserPage()->getFullUrl() ), $this->mUser->getName() );
			$articleId = $this->mTitle->getArticleId();

			$parts = self::explode($this->getTitle());

			$buttons = array();
			$replyButton = '';
			if ( count($parts['partsStripped']) == 1 ) {
				$replyButton = '<a href="#" class="article-comm-reply wikia-button secondary">' . wfMsg('article-comments-reply') . '</a>';
			}

			if ( $canDelete ) {
				$img = '<img class="delete sprite" alt="" src="'. $wgBlankImgUrl .'" width="16" height="16" />';
				$buttons[] = $img . '<a href="' . $this->mTitle->getLocalUrl('redirect=no&action=delete') . '" class="article-comm-delete">' . wfMsg('article-comments-delete') . '</a>';
			}

			//due to slave lag canEdit() can return false negative - we are hiding it by CSS and force showing by JS
			if ( $wgUser->isLoggedIn() ) {
				$display = $this->canEdit() ? '' : ' style="display:none"';
				$img = '<img class="edit sprite" alt="" src="' . $wgBlankImgUrl . '" width="16" height="16" />';
				$buttons[] = "<span class='edit-link'$display>" . $img . '<a href="#comment' . $articleId . '" class="article-comm-edit" id="comment' . $articleId . '">' . wfMsg('article-comments-edit') . '</a></span>';
			}

			if ( !$this->mTitle->isNewPage(GAID_FOR_UPDATE) ) {
				$img = '<img class="history sprite" alt="" src="'. $wgBlankImgUrl .'" width="16" height="16" />';
				$buttons[] = $img . $wgUser->getSkin()->makeKnownLinkObj( $this->mTitle, wfMsgHtml('article-comments-history'), 'action=history', '', '', 'class="article-comm-history"' );
			}

			$comment = array(
				'articleId' => $articleId,
				'sig' => $sig,
				'text' => $text,
				'title' => $this->mTitle,
				'author' => $this->mUser,
				'avatar' => $this->getAvatarImg($this->mUser),
				'timestamp' => wfTimeFormatAgo($this->mFirstRevision->getTimestamp()),
				'buttons' => $buttons,
				'replyButton' => $replyButton
			);

			$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
			$template->set_vars(
				array (
					'comment' => $comment
				)
			);
			$text = $template->render( 'comment' );
		}

		wfProfileOut( __METHOD__ );

		return $text;
	}

	function getAvatarImg($user){
		if (class_exists('Masthead')) {
			return Masthead::newFromUser( $user )->display( 50, 50 );
		} else {
			// Answers
			$avatar = new wAvatar($user->getId(), 'ml');
			return $avatar->getAvatarURL();
		}
	}

	/**
	 * get Title object of article page
	 *
	 * @access private
	 */
	public function getArticleTitle() {
		if ( !isset($this->mTitle) ) {
			return null;
		}

		$title = null;
		$parts = self::explode($this->mTitle->getDBkey());
		if ($parts['title'] != '') {
			$title = Title::makeTitle($this->mNamespace, $parts['title']);
		}
		return $title;
	}

	public function isTitleComment($title) {
		if (!($title instanceof Title)) {
			return false;
		}

		if (defined('NS_BLOG_ARTICLE') && $title->getNamespace() == NS_BLOG_ARTICLE) {
			return true;
		} else {
			return strpos(end(explode('/', $title->getText())), ARTICLECOMMENT_PREFIX) === 0;
		}
	}

	public static function explode($titleText) {
		$count = 0;
		$titleTextStripped = str_replace(ARTICLECOMMENT_PREFIX, '', $titleText, $count);
		$partsOriginal = explode('/', $titleText);
		$partsStripped = explode('/', $titleTextStripped);

		//count != 0 for article and == 0 for blog
		if ($count) {
			$title = implode('/', array_splice($partsOriginal, 0, -$count));
			array_splice($partsStripped, 0, -$count);
		} else {
			$title = implode('/', array_splice($partsOriginal, 0, 2));
			array_splice($partsStripped, 0, 2);
		}

		$result = array(
			'blog' => $count == 0,
			'title' => $title,
			'partsOriginal' => $partsOriginal,
			'partsStripped' => $partsStripped
		);
		return $result;
	}

	/**
	 * check if current user can edit comment
	 */
	public function canEdit() {
		global $wgUser;

		$res = false;
		if ( $this->mUser ) {
			$isAuthor = ($this->mUser->getId() == $wgUser->getId()) && (!$wgUser->isAnon());
			$canEdit =
				//prevent infinite loop for blogs - userCan hooked up in BlogLockdown
				defined('NS_BLOG_ARTICLE_TALK') && $this->mTitle->getNamespace() == NS_BLOG_ARTICLE_TALK ||
				$this->mTitle->userCanEdit();

			//TODO: create new permission and remove checking groups below
			$groups = $wgUser->getGroups();
			$isAdmin = in_array( 'staff', $groups ) || in_array( 'sysop', $groups );

			$res = ( $isAuthor || $isAdmin ) && $canEdit;
		}

		return $res;
	}

	/**
	 * editPage -- show edit form
	 *
	 * @access public
	 *
	 * @return String
	 */
	public function editPage() {
		global $wgUser, $wgTitle, $wgStylePath;
		wfProfileIn( __METHOD__ );

		$text = '';
		$this->load(true);
		if ( $this->canEdit() ) {
			$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
			$template->set_vars(
				array(
					'comment' => $this->mLastRevision->getText(),
					'isReadOnly' => wfReadOnly(),
					'canEdit' => $this->canEdit(),
					'title' => $this->mTitle,
					'stylePath' => $wgStylePath
				)
			);
			wfLoadExtensionMessages('ArticleComments');
			$text = $template->execute( 'comment-edit' );
		}

		wfProfileOut( __METHOD__ );

		return $text;
	}

	/**
	 * doSaveComment -- save comment
	 *
	 * @access public
	 *
	 * @return String
	 */
	public function doSaveComment( $request, $user, $title ) {
		global $wgMemc, $wgTitle;
		wfProfileIn( __METHOD__ );

		$res = array();
		$this->load(true);
		if ( $this->canEdit() ) {

			if ( wfReadOnly() ) {
				wfProfileOut( __METHOD__ );
				return false;
			}

			$text = $request->getText('wpArticleComment', false);
			$commentId = $request->getText('id', false);
			if ( !$text || !strlen( $text ) ) {
				wfProfileOut( __METHOD__ );
				return false;
			}

			if ( !$commentId ) {
				wfProfileOut( __METHOD__ );
				return false;
			}

			$commentTitle = $this->mTitle ? $this->mTitle : Title::newFromId($commentId);

			/**
			 * because we save different title via Ajax request
			 */
			$wgTitle = $commentTitle;

			/**
			 * add article using EditPage class (for hooks)
			 */
			$result   = null;
			$article  = new Article( $commentTitle, intval($this->mLastRevId) );
			$editPage = new EditPage( $article );
			$editPage->edittime = $article->getTimestamp();
			$editPage->textbox1 = $text;
			$retval = $editPage->internalAttemptSave( $result );

			/**
			 * clear comments cache for this article
			 */
			$title->invalidateCache();
			$title->purgeSquid();

			$key = $title->getPrefixedDBkey();
			$wgMemc->delete( wfMemcKey( 'articlecomment', 'listing', $key, 0 ) );
			$wgMemc->delete( wfMemcKey( 'articlecomment', 'comm', $title->getArticleID() ) );

			$res = array( $retval, $article );
		} else {
			$res = false;
		}

		wfProfileOut( __METHOD__ );

		return $res;
	}

	/**
	 * doPost -- static hook/entry for normal request post
	 *
	 * @static
	 * @access public
	 *
	 * @param WebRequest $request -- instance of WebRequest
	 * @param User       $user    -- instance of User
	 * @param Title      $title   -- instance of Title
	 *
	 * @return Article -- newly created article
	 */
	static public function doPost( &$request, &$user, &$title, $parentId = false ) {
		global $wgMemc, $wgTitle;
		wfProfileIn( __METHOD__ );

		$text = $request->getText('wpArticleComment', false);

		if ( !$text || !strlen( $text ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		/**
		 * title for comment is combination of article title and some 'random' data
		 */
		if ($parentId == false) {
			//1st level comment
			if (defined('NS_BLOG_ARTICLE') && $title->getNamespace() == NS_BLOG_ARTICLE) {
				//blogs
				$commentTitle = sprintf('%s/%s-%s', $title->getText(), $user->getName(), wfTimestampNow());
			} else {
				//article
				$commentTitle = sprintf('%s/%s%s-%s', $title->getText(), ARTICLECOMMENT_PREFIX, $user->getName(), wfTimestampNow());
			}
		} else {
			$parentArticle = Article::newFromID($parentId);
			$parentTitle = $parentArticle->getTitle();
			//nested comment
			if (defined('NS_BLOG_ARTICLE') && $title->getNamespace() == NS_BLOG_ARTICLE) {
				//blogs
				$commentTitle = sprintf('%s/%s-%s', $parentTitle->getText(), $user->getName(), wfTimestampNow());
			} else {
				//article
				$commentTitle = sprintf('%s/%s%s-%s', $parentTitle->getText(), ARTICLECOMMENT_PREFIX, $user->getName(), wfTimestampNow());
			}
		}

		$commentTitle = Title::newFromText($commentTitle, MWNamespace::getTalk($title->getNamespace()));
		/**
		 * because we save different tile via Ajax request
		 */
		$wgTitle = $commentTitle;

		/**
		 * add article using EditPage class (for hooks)
		 */
		$result   = null;
		$article  = new Article( $commentTitle, 0 );
		$editPage = new EditPage( $article );
		$editPage->edittime = $article->getTimestamp();
		$editPage->textbox1 = $text;
		$retval = $editPage->internalAttemptSave( $result );

		/**
		 * clear comments cache for this article
		 */
		$title->invalidateCache();
		$title->purgeSquid();

		$key = $title->getPrefixedDBkey();
		$wgMemc->delete( wfMemcKey( 'articlecomment', 'listing', $key, 0 ) );

		wfProfileOut( __METHOD__ );

		return array( $retval, $article );
	}

	static public function doAfterPost($status, $article, $commentId = 0) {
		global $wgUser, $wgDBname;
		global $wgDevelEnvironment;

		$error = false; $id = 0;
		switch( $status ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
				$comment = ArticleComment::newFromArticle( $article );
				$text = $comment->render(true);
				if ( !is_null($comment->mTitle) ) {
					$id = $comment->mTitle->getArticleID();
				}
				if ( empty( $commentId ) && !empty($comment->mTitle) ) {
					$ok = self::addArticlePageToWatchlist($comment, $commentId) ;
				}
				$message = false;
				$listing = ArticleCommentList::newFromTitle($comment->mTitle);
				$listing->purge();
				wfGetDB(DB_MASTER)->commit();
				break;
			default:
				//TODO: review - why using wgDevelEnvironment?
				$wgDevelEnvironment = true;
				$userId = $wgUser->getId();
				Wikia::log( __METHOD__, 'error', "No article created. Status: {$status}; DB: {$wgDBname}; User: {$userId}" );
				$text  = false;
				$error = true;
				$message = wfMsg('article-comments-error');
				$wgDevelEnvironment = false; // TODO: FIXME: is this right or do we want to set this to the original value?
		}

		$res = array(
			'msg'    	=> $message,
			'error'  	=> $error,
			'text'   	=> $text,
			'status' 	=> $status,
			'commentId' => $commentId,
			'id'		=> $id
		);

		return $res;
	}

	static public function addArticlePageToWatchlist($comment, $commentId) {
		global $wgUser, $wgEnableArticleWatchlist;

		$watchthis = false;
		if ( empty($wgEnableArticleWatchlist) ) {
			return $watchthis;
		}

		if ( !$wgUser->isAnon() ) {
			if ( $wgUser->getOption( 'watchdefault' ) ) {
				$watchthis = true;
			} elseif ( $wgUser->getOption( 'watchcreations' ) && empty($commentId) /* new comment */ ) {
				$watchthis = true;
			}
		}

		$oArticlePage = $comment->getArticleTitle();
		if ( !is_null($oArticlePage) ) {
			$dbw = wfGetDB(DB_MASTER);
			$dbw->begin();
			if ( !$comment->mTitle->userIsWatching() ) {
				# comment
				$dbw->insert( 'watchlist',
					array(
					'wl_user' => $wgUser->getId(),
					'wl_namespace' => MWNamespace::getTalk($comment->mTitle->getNamespace()),
					'wl_title' => $comment->mTitle->getDBkey(),
					'wl_notificationtimestamp' => wfTimestampNow()
					), __METHOD__, 'IGNORE'
				);
			}

			if ( !$oArticlePage->userIsWatching() ) {
				# and article page
				$dbw->insert( 'watchlist',
					array(
					'wl_user' => $wgUser->getId(),
					'wl_namespace' => $comment->mTitle->getNamespace(),
					'wl_title' => $oArticlePage->getDBkey(),
					'wl_notificationtimestamp' => NULL
					), __METHOD__, 'IGNORE' );
			}
			$dbw->commit();
		}

		return $watchthis;
	}

	/**
	 * Hook
	 *
	 * @param RecentChange $oRC -- instance of RecentChange class
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static public function watchlistNotify(RecentChange &$oRC) {
		global $wgEnableGroupedArticleCommentsRC;
		wfProfileIn( __METHOD__ );

		if ( !empty($wgEnableGroupedArticleCommentsRC) && ( $oRC instanceof RecentChange ) ) {
			$title = $oRC->getAttribute('rc_title');
			$namespace = $oRC->getAttribute('rc_namespace');
			$article_id = $oRC->getAttribute('rc_cur_id');
			$title = Title::newFromText($title, $namespace);

			//TODO: review
			if (MWNamespace::isTalk($namespace) &&
				ArticleComment::isTitleComment($title) &&
				!empty($article_id)) {

				$comment = ArticleComment::newFromId( $article_id );
				if ( !is_null($comment) ) {
					$oArticlePage = $comment->getArticleTitle();
					$mAttribs = $oRC->mAttribs;
					$mAttribs['rc_title'] = $oArticlePage->getDBkey();
					$mAttribs['rc_namespace'] = MWNamespace::getSubject($oArticlePage->getNamespace());
					$mAttribs['rc_log_action'] = 'article_comment';
					$oRC->setAttribs($mAttribs);
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Hook
	 *
	 * @param Title $title -- instance of EmailNotification class
	 * @param Array $keys -- array of all special variables like $PAGETITLE etc
	 * @param String $message (subject or body)
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static public function ComposeCommonMail( $title, &$keys, &$message, $editor ) {
		global $wgEnotifUseRealName;

		if (MWNamespace::isTalk($title->getNamespace()) && ArticleComment::isTitleComment($title)) {
			if ( !is_array($keys) ) {
				$keys = array();
			}

			$name = $wgEnotifUseRealName ? $editor->getRealName() : $editor->getName();
			if ( $editor->isIP( $name ) ) {
				$utext = trim(wfMsgForContent('enotif_anon_editor', ''));
				$message = str_replace('$PAGEEDITOR', $utext, $message);
				$keys['$PAGEEDITOR'] = $utext;
			}
		}
		return true;
	}


	/**
	 * hook
	 *
	 * @access public
	 * @static
	 */
	static public function moveComments( /*MovePageForm*/ &$form , /*Title*/ &$oOldTitle , /*Title*/ &$oNewTitle ) {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		$commentList = ArticleCommentList::newFromTitle( $oOldTitle );
		$comments = $commentList->getCommentPages(true, false);
		if (count($comments)) {
			foreach ($comments as $aCommentArr) {
				$oCommentTitle = $aCommentArr['level1']->getTitle();
				$parts = self::explode($oCommentTitle->getDBkey());
				$commentTitleText = implode('/', $parts['partsOriginal']);

				$newCommentTitle = Title::newFromText(
					sprintf( '%s/%s', $oNewTitle->getText(), $commentTitleText ),
					MWNamespace::getTalk($oNewTitle->getNamespace()) );

				$error = $oCommentTitle->moveTo( $newCommentTitle, false, $form->reason, false );
				if ( $error !== true ) {
					Wikia::log( __METHOD__, 'movepage',
						'cannot move blog comments: old comment: ' . $oCommentTitle->getPrefixedText() . ', ' .
						'new comment: ' . $newCommentTitle->getPrefixedText() . ', error: ' . @implode(', ', $error)
					);
				}

				if (isset($aCommentArr['level2'])) {
					foreach ($aCommentArr['level2'] as $oComment) {
						$oCommentTitle = $oComment->getTitle();
						$parts = self::explode($oCommentTitle->getDBkey());
						$commentTitleText = implode('/', $parts['partsOriginal']);

						$newCommentTitle = Title::newFromText(
							sprintf( '%s/%s', $oNewTitle->getText(), $commentTitleText ),
							MWNamespace::getTalk($oNewTitle->getNamespace()) );

						$error = $oCommentTitle->moveTo( $newCommentTitle, false, $form->reason, false );
						if ( $error !== true ) {
							Wikia::log( __METHOD__, 'movepage',
								'cannot move blog comments: old comment: ' . $oCommentTitle->getPrefixedText() . ', ' .
								'new comment: ' . $newCommentTitle->getPrefixedText() . ', error: ' . @implode(', ', $error)
							);
						}
					}
				}
			}
		} else {
			Wikia::log( __METHOD__, 'movepage', 'cannot move article comments, because no comments: ' . $oOldTitle->getPrefixedText());
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	//Blogs only functions
	/**
	 * setProps -- change props for comment article
	 *
	 */
	public function setProps( $props, $update = false ) {
		wfProfileIn( __METHOD__ );

		if ( $update && class_exists('BlogArticle') ) {
			BlogArticle::setProps( $this->mTitle->getArticleID(), $props );
		}
		$this->mProps = $props;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * getProps -- get props for comment article
	 *
	 */
	public function getProps() {
		if ( (!$this->mProps || !is_array( $this->mProps )) && class_exists('BlogArticle') ) {
			$this->mProps = BlogArticle::getProps( $this->mTitle->getArticleID() );
		}
		return $this->mProps;
	}
}

/**
 * ArticleComment is listing, basicly it's array of comments
 */
class ArticleCommentList {

	private $mTitle;
	private $mText;
	private $mComments = false;
	private $mCommentsAll = false;
	private $mCountAll = false;
	private $mCountAllNested = false;
	private static $mArticlesToDelete;

	static public function newFromTitle( Title $title ) {
		$comments = new ArticleCommentList();
		$comments->setTitle( $title );
		$comments->setText( $title->getDBkey( ) );
		return $comments;
	}

	static public function newFromText( $text, $namespace ) {
		$articlePage = Title::newFromText( $text, $namespace );
		if ( ! $articlePage ) {
			/**
			 * doesn't exist, lame
			 */
			return false;
		}

		$comments = new ArticleCommentList();
		$comments->setText( $articlePage->getDBkey() );
		$comments->setTitle( $articlePage );
		return $comments;
	}

	public function setText( $text ) {
		$this->mText = $text;
	}

	/**
	 * setTitle -- standard accessor/setter
	 */
	public function setTitle( Title $title ) {
		$this->mTitle = $title;
	}

	/**
	 * getTitle -- standard accessor/getter
	 */
	public function getTitle( ) {
		return $this->mTitle;
	}

	/**
	 * getCountAll -- count 1st level comments
	 */
	public function getCountAll() {
		if ($this->mCountAll === false) {
			$this->getCommentPages(false, false);
		}
		return $this->mCountAll;
	}

	/**
	 * getCountAllNested -- count all comments - including nested
	 */
	public function getCountAllNested() {
		if ($this->mCountAllNested === false) {
			$this->getCommentPages(false, false);
			$this->mCountAllNested = 0;
			foreach ($this->mCommentsAll as $comment) {
				$this->mCountAllNested++;
				if (isset($comment['level2'])) {
					$this->mCountAllNested += count($comment['level2']);
				}
			}
		}
		return $this->mCountAllNested;
	}

	/**
	 * getCommentPages -- take pages connected to comments list
	 *
	 * @access public
	 *
	 * @param string $master use master connection, skip cache
	 *
	 * @return array
	 */
	public function getCommentPages( $master = true, $page = 1 ) {
		global $wgRequest, $wgMemc, $wgArticleCommentsMaxPerPage;

		wfProfileIn( __METHOD__ );

		$showall = $wgRequest->getText( 'showall', false );
		$action = $wgRequest->getText( 'action', false );

		/**
		 * skip cache if purging or using master connection
		 */
		if ( $action != 'purge' && !$master ) {
			$this->mCommentsAll = $wgMemc->get( wfMemcKey( 'articlecomment', 'comm', $this->getTitle()->getArticleId() ) );
		}

		if ( !is_array( $this->mCommentsAll ) ) {
			$pages = array();

			$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE );

			if (defined('NS_BLOG_ARTICLE') && $this->getTitle()->getNamespace() == NS_BLOG_ARTICLE) {
				//comments for blog
				$res = $dbr->select(
					array( 'page' ),
					array( 'page_id', 'page_title' ),
					array(
						'page_namespace' => NS_BLOG_ARTICLE_TALK,
						"page_title LIKE '" . $dbr->escapeLike( $this->mText ) . "/%'"
					),
					__METHOD__,
					array( 'ORDER BY' => "page_id ASC" )
				);
			} else {
				//comments for article
				$res = $dbr->select(
					array( 'page' ),
					array( 'page_id', 'page_title' ),
					array(
						'page_namespace' => MWNamespace::getTalk($this->getTitle()->getNamespace()),
						"page_title LIKE '" . $dbr->escapeLike( $this->mText ) . "/" . ARTICLECOMMENT_PREFIX . "%'"
					),
					__METHOD__,
					array( 'ORDER BY' => 'page_id ASC' )
				);
			}

			$helperArray = array();
			while ( $row = $dbr->fetchObject( $res ) ) {
				$parts = ArticleComment::explode($row->page_title);

				if (count($parts['partsStripped']) == 2) {
					//if helperArray is empty for this key that means that someone created the "fake" nested comment by editing regular MW page - shouldn't happen at all
					if (isset($helperArray[$parts['partsStripped'][0]])) {
						$pages[$helperArray[$parts['partsStripped'][0]]]['level2'][$row->page_id] = ArticleComment::newFromId( $row->page_id );
					}
				} else {
					$helperArray[$parts['partsStripped'][0]] = $row->page_id;
					$pages[$row->page_id]['level1'] = ArticleComment::newFromId( $row->page_id );
				}
			}

			$dbr->freeResult( $res );
			$this->mCommentsAll = $pages;
			$wgMemc->set( wfMemcKey( 'articlecomment', 'comm', $this->getTitle()->getArticleId() ), $this->mCommentsAll, 3600 );
		}

		$this->mCountAll = count($this->mCommentsAll);
		//1st level descending, 2nd level ascending
		krsort($this->mCommentsAll, SORT_NUMERIC);
		//pagination
		if ($page !== false && $showall != 1) {
			$this->mComments = array_slice($this->mCommentsAll, ($page - 1) * $wgArticleCommentsMaxPerPage, $wgArticleCommentsMaxPerPage, true);
		} else {
			$this->mComments = $this->mCommentsAll;
		}

		wfProfileOut( __METHOD__ );
		return $this->mComments;
	}

	//TODO: review
	private function getRemovedCommentPages( $oTitle ) {
		wfProfileIn( __METHOD__ );

		$pages = array();

		if ($oTitle instanceof Title) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'archive' ),
				array( 'ar_page_id', 'ar_title' ),
				array(
					'ar_namespace' => MWNamespace::getTalk($this->getTitle()->getNamespace()),
					"ar_title LIKE '" . $dbr->escapeLike($oTitle->getDBkey()) . "/" . ARTICLECOMMENT_PREFIX . "%'"
				),
				__METHOD__,
				array( 'ORDER BY' => 'ar_page_id ASC' )
			);
			while ( $row = $dbr->fetchObject( $res ) ) {
				$pages[ $row->ar_page_id ] = array(
					'title' => $row->ar_title,
					'nspace' => MWNamespace::getTalk($this->getTitle()->getNamespace())
				);
			}
			$dbr->freeResult( $res );
		}

		wfProfileOut( __METHOD__ );
		return $pages;
	}

	/**
	 * render -- return HTML code for displaying comments
	 *
	 * @access public
	 *
	 * @return String HTML text with rendered comments section
	 */
	public function render() {
		global $wgUser, $wgTitle, $wgRequest, $wgOut, $wgArticleCommentsMaxPerPage, $wgStylePath;

		if ($wgRequest->wasPosted()) {
			// for non-JS version !!!
			$sComment = $wgRequest->getVal( 'wpArticleComment', false );
			$iArticleId = $wgRequest->getVal( 'wpArticleId', false );
			$sSubmit = $wgRequest->getVal( 'wpArticleSubmit', false );
			if ( $sSubmit && $sComment && $iArticleId ) {
				$oTitle = Title::newFromID( $iArticleId );
				if ( $oTitle instanceof Title ) {
					$response = ArticleComment::doPost( $wgRequest, $wgUser, $oTitle );
					$res = array();
					if ( $response !== false ) {
						$status = $response[0]; $article = $response[1];
						$res = ArticleComment::doAfterPost($status, $article);
					}
					$wgOut->redirect( $oTitle->getLocalURL() );
				}
			}
		}

		$hiddenComments = isset($this->mProps['hiddencomm']) ? (bool)$this->mProps['hiddencomm'] : false;
		if ($hiddenComments) {
			return '';
		}

		wfLoadExtensionMessages('ArticleComments');
		/**
		 * $pages is array of comment articles
		 */
		if (class_exists('Masthead')){
			$avatar = Masthead::newFromUser( $wgUser );
		} else {
			// Answers
			$avatar = new wAvatar($wgUser->getId(), "ml");
		}

		$isSysop   = ( in_array('sysop', $wgUser->getGroups()) || in_array('staff', $wgUser->getGroups() ) );
		$canEdit   = $wgUser->isAllowed( 'edit' );
		$isBlocked = $wgUser->isBlocked();
		$isReadOnly = wfReadOnly();
		$showall = $wgRequest->getText( 'showall', false );

		//get first or last page to show newest comments in default view
		//TODO: always master? use master only when new comment added
		$comments = $this->getCommentPages(true, false);
		$countComments = $this->getCountAll();
		$countCommentsNested = $this->getCountAllNested();
		$countPages = ceil($countComments / $wgArticleCommentsMaxPerPage);

		$pageRequest = (int)$wgRequest->getVal( 'page', 1 );
		$page = 1;
		if ($pageRequest <= $countPages && $pageRequest > 0) {
			$page = $pageRequest;
		}

		if ($showall != 1) {
			$comments = array_slice($comments, ($page - 1) * $wgArticleCommentsMaxPerPage, $wgArticleCommentsMaxPerPage, true);
		}
		$pagination = self::doPagination($countComments, count($comments), $page);

		$commentListText = $this->formatList($comments);

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$template->set_vars( array(
			'title'     => $wgTitle,
			'avatar'    => $avatar,
			'canEdit'   => $canEdit,
			'isBlocked' => $isBlocked,
			'reason'	=> $isBlocked ? $this->blockedPage() : '',
			'commentListText' => $commentListText,
			'isReadOnly' => $isReadOnly,
			'pagination' => $pagination,
			'countComments' => $countComments,
			'countCommentsNested' => $countCommentsNested,
			'stylePath' => $wgStylePath
		) );

		$text = $template->execute( 'comment-main' );

		return $text;
	}

	/**
	 * doPagination -- return HTML code for pagination
	 *
	 * @access public
	 *
	 * @return String HTML text
	 */
	static function doPagination($countAll, $countComments, $activePage = 1, $title = null) {
		global $wgArticleCommentsMaxPerPage, $wgTitle;

		$maxDisplayedPages = 6;
		$pagination = '';

		if ( $title == null ){
			$title = $wgTitle;
		}

		if ($countAll > $countComments) {
			$numberOfPages = ceil($countAll / $wgArticleCommentsMaxPerPage);

			//previous
			if ($activePage > 1) {
				$pagination .= '<a href="' . $title->getLinkUrl('page='. (max($activePage - 1, 1)) ) . '#article-comment-header" id="article-comments-pagination-link-prev" class="article-comments-pagination-link dark_text_1" page="' . (max($activePage - 1, 1)) . '">' . wfMsg('article-comments-prev-page') . '</a>';
			}

			//first page - always visible
			$pagination .= '<a href="' . $title->getFullUrl('page=1') . '#article-comment-header" id="article-comments-pagination-link-1" class="article-comments-pagination-link dark_text_1' . ($activePage == 1 ? ' article-comments-pagination-link-active accent' : '') . '" page="1">1</a>';

			//calculate the 2nd and the last but one pages to display
			$firstVisiblePage = max(2, min($numberOfPages - $maxDisplayedPages + 1, $activePage - $maxDisplayedPages + 4));
			$lastVisiblePage = min($numberOfPages - 1, $maxDisplayedPages + $firstVisiblePage - 2);

			//add spacer when there is a gap between 1st and 2nd visible page
			if ($firstVisiblePage > 2) {
				$pagination .= wfMsg('article-comments-page-spacer');
			}

			//generate links
			for ($i = $firstVisiblePage; $i <= $lastVisiblePage; $i++) {
				$pagination .= '<a href="' . $title->getFullUrl('page=' . $i) . '#article-comment-header" id="article-comments-pagination-link-' . $i . '" class="article-comments-pagination-link dark_text_1' . ($i == $activePage ? ' article-comments-pagination-link-active accent' : '') . '" page="' . $i . '">' . $i . '</a>';
			}

			//add spacer when there is a gap between 2 last links
			if ($numberOfPages - $lastVisiblePage > 1) {
				$pagination .= wfMsg('article-comments-page-spacer');
			}

			//add last page - always visible
			$pagination .= '<a href="' . $title->getFullUrl('page=' . $numberOfPages) . '#article-comment-header" id="article-comments-pagination-link-' . $numberOfPages . '" class="article-comments-pagination-link dark_text_1' . ($numberOfPages == $activePage ? ' article-comments-pagination-link-active accent' : '') . '" page="' . $numberOfPages . '">' . $numberOfPages . '</a>';

			//next
			if ($activePage < $numberOfPages) {
				$pagination .= '<a href="' . $title->getFullUrl('page=' . (min($activePage + 1, $numberOfPages)) ) . '#article-comment-header" id="article-comments-pagination-link-next" class="article-comments-pagination-link dark_text_1" page="' . (min($activePage + 1, $numberOfPages)) . '">' . wfMsg('article-comments-next-page') . '</a>';
			}
		}
		return $pagination;
	}

	/**
	 * blockedPage -- return HTML code for displaying reason of user block
	 *
	 * @access public
	 *
	 * @return String HTML text
	 */
	public function blockedPage() {
		global $wgUser, $wgLang, $wgContLang;

		list ($blockerName, $reason, $ip, $blockid, $blockTimestamp, $blockExpiry, $intended) = array(
			User::whoIs( $wgUser->blockedBy() ),
			$wgUser->blockedFor() ? $wgUser->blockedFor() : wfMsg( 'blockednoreason' ),
			wfGetIP(),
			$wgUser->mBlock->mId,
			$wgLang->timeanddate( wfTimestamp( TS_MW, $wgUser->mBlock->mTimestamp ), true ),
			$wgUser->mBlock->mExpiry,
			$wgUser->mBlock->mAddress
		);

		$blockerLink = '[[' . $wgContLang->getNsText( NS_USER ) . ":{$blockerName}|{$blockerName}]]";

		if ( $blockExpiry == 'infinity' ) {
			$scBlockExpiryOptions = wfMsg( 'ipboptions' );
			foreach ( explode( ',', $scBlockExpiryOptions ) as $option ) {
				if ( strpos( $option, ":" ) === false ) continue;
				list( $show, $value ) = explode( ":", $option );
				if ( $value == 'infinite' || $value == 'indefinite' ) {
					$blockExpiry = $show;
					break;
				}
			}
		} else {
			$blockExpiry = $wgLang->timeanddate( wfTimestamp( TS_MW, $blockExpiry ), true );
		}

		if ( $wgUser->mBlock->mAuto ) {
			$msg = 'autoblockedtext';
		} else {
			$msg = 'blockedtext';
		}

		return wfMsgExt( $msg, array('parse'), $blockerLink, $reason, $ip, $blockerName, $blockid, $blockExpiry, $intended, $blockTimestamp );
	}

	/**
	 * remove lising from cache and mark title for squid as invalid
	 */
	public function purge() {
		global $wgMemc;

		$wgMemc->delete( wfMemcKey( 'articlecomment', 'comm', $this->mTitle->getArticleID() ) );

		$this->mTitle->invalidateCache();
		$this->mTitle->purgeSquid();

		//purge varnish
		$parts = ArticleComment::explode($this->mText);
		$title = Title::newFromText($parts['title'], MWNamespace::getSubject($this->mTitle->getNamespace()));
		if ($title) {
			$title->invalidateCache();
			$titleURL = $title->getFullUrl();
			$urls = array("$titleURL?shawall=1");
			SquidUpdate::purge($urls);
		} else {
			Wikia::log(__METHOD__, 'error', "bad URL for comment, whole title: {$this->mText}");
		}
	}

	/**
	 * Hook
	 *
	 * @param Article $article -- instance of Article class
	 * @param User    $user    -- current user
	 * @param string  $reason  -- deleting reason
	 * @param integer $error   -- error msg
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static public function articleDelete( &$article, &$user, &$reason, &$error ) {
		wfProfileIn( __METHOD__ );

		$title = $article->getTitle();
		if (MWNamespace::isTalk($title->getNamespace()) && ArticleComment::isTitleComment($title)) {
			$parts = ArticleComment::explode($title->getText());

			//deleting comment - check if 1st level and delete connected 2nd level
			if (count($parts['partsOriginal']) == 1) {
				$oTitle = Title::newFromText($parts['title'], $title->getNamespace());
				$listing = ArticleCommentList::newFromTitle($oTitle);
				$aComments = $listing->getCommentPages(true, false);

				if ($listing->getCountAll() && isset($aComments[$article->getID()]['level2'])) {
					self::$mArticlesToDelete = $aComments[$article->getID()]['level2'];
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Hook
	 *
	 * @param Article $article -- instance of Article class
	 * @param User    $user    -- current user
	 * @param string  $reason  -- deleting reason
	 * @param integer $id      -- article id
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static public function articleDeleteComplete( &$article, &$user, $reason, $id ) {
		wfProfileIn( __METHOD__ );

		$title = $article->getTitle();

		//we have comment 1st level - checked in articleDelete()
		if (is_array(self::$mArticlesToDelete)) {
			foreach (self::$mArticlesToDelete as $page_id => $oComment) {
				$oCommentTitle = $oComment->getTitle();
				if ( $oCommentTitle instanceof Title ) {
					$oArticle = new Article($oCommentTitle);
					$oArticle->doDeleteArticle($reason);
				}
			}
		//regular article - delete connected comments
		} else {
			$listing = ArticleCommentList::newFromTitle($title);

			$aComments = $listing->getCommentPages(true, false);
			if ($listing->getCountAll()) {
				foreach ($aComments as $page_id => $aCommentArr) {
					$oCommentTitle = $aCommentArr['level1']->getTitle();
					if ( $oCommentTitle instanceof Title ) {
						$oArticle = new Article($oCommentTitle);
						$oArticle->doDeleteArticle($reason);
					}
					if (isset($aCommentArr['level2'])) {
						foreach ($aCommentArr['level2'] as $page_id => $oComment) {
							$oCommentTitle = $oComment->getTitle();
							if ( $oCommentTitle instanceof Title ) {
								$oArticle = new Article($oCommentTitle);
								$oArticle->doDeleteArticle($reason);
							}
						}
					}
				}
			}
			$listing->purge();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Hook
	 *
	 * @param Title $oTitle -- instance of Title class
	 * @param Revision $revision    -- new revision
	 * @param Integer  $old_page_id  -- old page ID
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static public function undeleteComments( &$oTitle, $revision, $old_page_id ) {
		wfProfileIn( __METHOD__ );

		if ( $oTitle instanceof Title ) {
			$new_page_id = $oTitle->getArticleId();
			$listing = ArticleCommentList::newFromTitle($oTitle);
			$pagesToRecover = $listing->getRemovedCommentPages($oTitle);
			if ( !empty($pagesToRecover) && is_array($pagesToRecover) ) {
				wfLoadExtensionMessages('ArticleComments');
				foreach ($pagesToRecover as $page_id => $page_value) {
					$oCommentTitle = Title::makeTitleSafe( $page_value['nspace'], $page_value['title'] );
					if ($oCommentTitle instanceof Title) {
						$archive = new PageArchive( $oCommentTitle );
						$ok = $archive->undelete( '', wfMsg('article-comments-undeleted-comment', $new_page_id) );

						if ( !is_array($ok) ) {
							Wikia::log( __METHOD__, 'error', "cannot restore comment {$page_value['title']} (id: {$page_id})" );
						}
					}
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Hook
	 *
	 * @param ChangeList $oChangeList -- instance of ChangeList class
	 * @param String $currentName    -- current value of RC key
	 * @param RCCacheEntry $oRCCacheEntry  -- instance of RCCacheEntry class
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	//TODO: review - blogs only?
	static public function makeChangesListKey( &$oChangeList, &$currentName, &$oRCCacheEntry ) {
		global $wgUser, $wgEnableGroupedArticleCommentsRC, $wgTitle, $wgEnableBlogArticles;
		wfProfileIn( __METHOD__ );

		if ( empty($wgEnableGroupedArticleCommentsRC) ) {
			return true;
		}

		$oTitle = $oRCCacheEntry->getTitle();
		$namespace = $oTitle->getNamespace();

		$allowed = !( $wgEnableBlogArticles && in_array($oTitle->getNamespace(), array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK)) );
		if (!is_null($oTitle) && MWNamespace::isTalk($oTitle->getNamespace()) && ArticleComment::isTitleComment($oTitle) && $allowed) {
			$parts = ArticleComment::explode($oTitle->getText());
			if ($parts['title'] != '') {
				$currentName = 'ArticleComments' . $parts['title'];
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Hook
	 *
	 * @param ChangeList $oChangeList -- instance of ChangeList class
	 * @param String $header    -- current value of RC key
	 * @param Array of RCCacheEntry $oRCCacheEntryArray  -- array of instance of RCCacheEntry classes
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static public function setHeaderBlockGroup(&$oChangeList, &$header, Array /*of oRCCacheEntry*/ &$oRCCacheEntryArray) {
		global $wgLang, $wgContLang, $wgEnableGroupedArticleCommentsRC, $wgTitle, $wgEnableBlogArticles;

		if ( empty($wgEnableGroupedArticleCommentsRC) ) {
			return true;
		}

		$oRCCacheEntry = null;
		if ( !empty($oRCCacheEntryArray) ) {
			$oRCCacheEntry = $oRCCacheEntryArray[0];
		}

		if ( !is_null($oRCCacheEntry) ) {
			$oTitle = $oRCCacheEntry->getTitle();
			$namespace = $oTitle->getNamespace();

			$allowed = !( $wgEnableBlogArticles && in_array($oTitle->getNamespace(), array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK)) );
			if ( !is_null($oTitle) && MWNamespace::isTalk($oTitle->getNamespace()) && ArticleComment::isTitleComment($oTitle) && $allowed ) {
				$parts = ArticleComment::explode($oTitle->getFullText());

				if ($parts['title'] != '') {
					$cnt = count($oRCCacheEntryArray);

					$userlinks = array();
					foreach ( $oRCCacheEntryArray as $id => $oRCCacheEntry ) {
			 			$u = $oRCCacheEntry->userlink;
						if ( !isset( $userlinks[$u] ) ) {
							$userlinks[$u] = 0;
						}
						$userlinks[$u]++;
					}

					$users = array();
					foreach( $userlinks as $userlink => $count) {
						$text = $userlink;
						$text .= $wgContLang->getDirMark();
						if ( $count > 1 ) {
							$text .= ' (' . $wgLang->formatNum( $count ) . '×)';
						}
						array_push( $users, $text );
					}

					wfLoadExtensionMessages('ArticleComments');
					$cntChanges = wfMsgExt( 'nchanges', array( 'parsemag', 'escape' ), $wgLang->formatNum( $cnt ) );
					$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
					$template->set_vars(
						array (
							'hdrtitle' 		=> wfMsgExt('article-comments-rc-comments', array('parseinline'), $parts['title']),
							'inx'			=> $oChangeList->rcCacheIndex,
							'cntChanges'	=> $cntChanges,
							'users'			=> $users,
						)
					);
					$header = $template->execute( 'rcheaderblock' );
				}
			}
		}
		return true;
	}

	/**
	 * formatList
	 *
	 * @static
	 * @access public
	 *
	 * @return String - HTML
	 */
	static function formatList($comments) {
		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$template->set_vars( array(
			'comments'  => $comments
		) );
		return $template->execute( 'comment-list' );
	}

	/**
	 * Hook
	 *
	 * @param RecentChange $rc -- instance of RecentChange class
	 * @param array $data -- data used by ActivityFeed
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static function BeforeStoreInRC(&$rc, &$data) {
		$rcTitle = $rc->getAttribute('rc_title');
		$rcNamespace = $rc->getAttribute('rc_namespace');
		$title = Title::newFromText($rcTitle, $rcNamespace);
		if (ArticleComment::isTitleComment($title)) {
			$data['articleComment'] = true;
		}
		return true;
	}

	/**
	 * static entry point for hook
	 *
	 * @static
	 * @access public
	 */
	static public function ArticleFromTitle( &$title, &$article ) {
		if (MWNamespace::isTalk($title->getNamespace()) && ArticleComment::isTitleComment($title)) {
			global $wgRequest, $wgTitle, $wgOut;
			$redirect = $wgRequest->getText('redirect', false);
			$diff = $wgRequest->getText('diff', '');
			$oldid = $wgRequest->getText('oldid', '');
			$action = $wgRequest->getText('action', '');
			if (($redirect != 'no') && empty($diff) && empty($oldid) && ($action != 'history')) {
				$parts = ArticleComment::explode($title->getText());
				$redirect = Title::newFromText($parts['title'], MWNamespace::getSubject($title->getNamespace()));
				if ($redirect) {
					$wgOut->redirect($redirect->getFullUrl());
				}
			}
		}
		return true;
	}

	/**
	 * static entry point for hook
	 *
	 * @static
	 * @access public
	 */
	static public function onConfirmEdit(&$SimpleCaptcha, &$editPage, $newtext, $section, $merged, &$result) {
		$title = $editPage->getArticle()->getTitle();
		if (MWNamespace::isTalk($title->getNamespace()) && ArticleComment::isTitleComment($title)) {
			$result = true;	//omit captcha
			return false;
		}
		return true;
	}

	static function ChangesListInsertArticleLink($changeList, &$articlelink, &$s, &$rc, $unpatrolled, $watched) {
		$rcTitle = $rc->getAttribute('rc_title');
		$rcNamespace = $rc->getAttribute('rc_namespace');
		$title = Title::newFromText($rcTitle, $rcNamespace);

		if (MWNamespace::isTalk($rcNamespace) && ArticleComment::isTitleComment($title)) {
			wfLoadExtensionMessages('ArticleComments');
			$parts = ArticleComment::explode($rcTitle);
			$articlelink = wfMsgExt('article-comments-rc-comment', array('parseinline'), str_replace('_', ' ', $parts['title']));
		}
		return true;
	}

	/**
	 * Hook
	 *
	 * @param Title $oTitle -- instance of Title class
	 * @param User    $User    -- current user
	 * @param string  $reason  -- undeleting reason
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's hook
	 */
	static public function undeleteComplete($oTitle, $oUser, $reason) {
		wfProfileIn( __METHOD__ );
		if ($oTitle instanceof Title) {
			if ( in_array($oTitle->getNamespace(), array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK)) ) {
				$aProps = $oTitle->aProps;
				$pageId = $oTitle->getArticleId();
				if (!empty($aProps)) {
					BlogArticle::setProps($pageId, $aProps);
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}