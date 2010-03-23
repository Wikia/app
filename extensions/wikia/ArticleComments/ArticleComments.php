<?php

/**
 * @author Krzysztof Krzyżaniak <eloy@wikia.inc>
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 *
 * @name ArticleComment -- single comment
 * @name ArticleCommentList -- listing
 *
 */

define('ARTICLECOMMENTORDERCOOKIE_NAME', 'articlecommentorder');
define('ARTICLECOMMENTORDERCOOKIE_EXPIRE', 60 * 60 * 24 * 365);
define('ARTICLECOMMENT_PREFIX', '@comment-');

$wgExtensionMessagesFiles['ArticleComments'] = dirname(__FILE__) . '/ArticleComments.i18n.php';

global $wgAjaxExportList;
$wgAjaxExportList[] = 'ArticleComment::axPost';
$wgAjaxExportList[] = 'ArticleComment::axEdit';
$wgAjaxExportList[] = 'ArticleComment::axSave';
$wgAjaxExportList[] = 'ArticleCommentList::axGetComments';

$wgHooks['ArticleDeleteComplete'][] = 'ArticleCommentList::articleDeleteComplete';
$wgHooks['ArticleRevisionUndeleted'][] = 'ArticleCommentList::undeleteComments';
$wgHooks['RecentChange_save'][] = 'ArticleComment::watchlistNotify';
# recentchanges
$wgHooks['ChangesListMakeSecureName'][] = 'ArticleCommentList::makeChangesListKey';
$wgHooks['ChangesListHeaderBlockGroup'][] = 'ArticleCommentList::setHeaderBlockGroup';
$wgHooks['ChangesListInsertArticleLink'][] = 'ArticleCommentList::ChangesListInsertArticleLink';
# special::watchlist
$wgHooks['ComposeCommonSubjectMail'][] = 'ArticleComment::ComposeCommonMail';
$wgHooks['ComposeCommonBodyMail'][] = 'ArticleComment::ComposeCommonMail';
# ActivityFeed
$wgHooks['MyHome:BeforeStoreInRC'][] = 'ArticleCommentList::BeforeStoreInRC';
# TOC
$wgHooks['Parser::InjectTOCitem'][] = 'ArticleCommentInit::InjectTOCitem';
# omit captcha
$wgHooks['ConfirmEdit::onConfirmEdit'][] = 'ArticleCommentList::onConfirmEdit';
# redirect
$wgHooks['ArticleFromTitle'][] = 'ArticleCommentList::ArticleFromTitle';
# init
$wgHooks['SkinAfterContent'][] = 'ArticleCommentInit::ArticleCommentEnable';
$wgHooks['CustomArticleFooter'][] = 'ArticleCommentInit::ArticleCommentEnableMonaco';
$wgHooks['BeforePageDisplay'][] = 'ArticleCommentInit::ArticleCommentAddJS';
$wgHooks['SkinTemplateTabs'][] = 'ArticleCommentInit::ArticleCommentHideTab';

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

			if ( $wgEnableBlogArticles && in_array($wgTitle->getNamespace(), array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK)) ) {
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
		if(get_class($wgUser->getSkin()) == 'SkinMonaco' || get_class($wgUser->getSkin()) == 'SkinAnswers') {
			return true;
		}
		wfProfileIn( __METHOD__ );

		if (self::ArticleCommentCheck()) {
			wfLoadExtensionMessages('ArticleComments');
			$page = ArticleCommentList::newFromTitle( $wgTitle );
			$data = $page->render();
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function ArticleCommentAddJS(&$out, &$sk) {
		global $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion;
		wfProfileIn( __METHOD__ );

		if (self::ArticleCommentCheck()) {
			$out->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/ArticleComments/js/ArticleComments.js?{$wgStyleVersion}\" ></script>\n");
			$out->addExtensionStyle("$wgExtensionsPath/wikia/ArticleComments/css/ArticleComments.css?$wgStyleVersion");
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function ArticleCommentHideTab(&$skin, &$content_actions) {
		wfProfileIn( __METHOD__ );

		if (self::ArticleCommentCheck()) {
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
}

/**
 * ArticleComment is article, this class is used for manipulation on it
 */
class ArticleComment {

	public
		$mTitle,
		$mLastRevId,
		$mFirstRevId,
		$mLastRevision,  ### for displaying text
		$mFirstRevision, ### for author & time
		$mUser,	         ### comment creator
		$mNamespace,
		$mNamespaceTalk;


	public function __construct( $Title ) {
		/**
		 * initialization
		 */
		$this->mTitle = $Title;
		$this->mNamespace = $Title->getNamespace();
		$this->mNamespaceTalk = Namespace::getTalk($this->mNamespace);
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
	static public function newFromTitle( Title $Title ) {
		return new ArticleComment( $Title );
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
	static public function newFromArticle( Article $Article ) {
		$Title = $Article->getTitle();

		$Comment = new ArticleComment( $Title );
		return $Comment;
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
		$Title = Title::newFromID( $id );
		if( ! $Title ) {
			/**
			 * maybe from Master?
			 */
			$Title = Title::newFromID( $id, GAID_FOR_UPDATE );

			if( ! $Title ) {
				return false;
			}
		}
		return new ArticleComment( $Title );
	}


	/**
	 * load -- set variables, load data from database
	 *
	 * @access private
	 */
	private function load() {
		wfProfileIn( __METHOD__ );

		$result = true;

		if( $this->mTitle ) {
			/**
			 * if we lucky we got only one revision, we check slave first
			 * then if no answer we check master
			 */
			$this->mFirstRevId = $this->getFirstRevID(DB_SLAVE);
			if( !$this->mFirstRevId ) {
				 $this->mFirstRevId = $this->getFirstRevID( DB_MASTER );
			}
			if( !$this->mLastRevId ) {
				$this->mLastRevId = $this->mTitle->getLatestRevID();
			}
			/**
			 * still not defined?
			 */
			if( !$this->mLastRevId ) {
				$this->mLastRevId = $this->mTitle->getLatestRevID( GAID_FOR_UPDATE );
			}
			if( $this->mLastRevId != $this->mFirstRevId ) {
				if( $this->mLastRevId && $this->mFirstRevId ) {
					$this->mLastRevision = Revision::newFromTitle( $this->mTitle );
					$this->mFirstRevision = Revision::newFromId( $this->mFirstRevId );
					Wikia::log( __METHOD__, 'ne', "{$this->mLastRevId} ne {$this->mFirstRevId}" );
				}
				else {
					$this->mFirstRevision = Revision::newFromId( $this->mFirstRevId );
					$this->mLastRevision = $this->mFirstRevision;
					$this->mLastRevId = $this->mFirstRevId;
					Wikia::log( __METHOD__, 'ne', "getting {$this->mFirstRevId} as lastRev" );
				}
			}
			else {
				Wikia::log( __METHOD__, 'eq' );
				if( $this->mFirstRevId ) {
					$this->mFirstRevision = Revision::newFromId( $this->mFirstRevId );
					$this->mLastRevision = $this->mFirstRevision;
					Wikia::log( __METHOD__, 'eq', "{$this->mLastRevId} eq {$this->mFirstRevId}" );
				}
				else {
					$result = false;
				}
			}

			if( $this->mFirstRevision ) {
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
	 * @param Integer $flags a bit field; may be GAID_FOR_UPDATE to select for update
	 *
	 * @return Integer
	 */
	private function getFirstRevID( $db_conn ) {
		wfProfileIn( __METHOD__ );

		$id = false;

		if( $this->mTitle ) {
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
	 * fetch --
	 *
	 * @access public
	 */
	public function fetch() {
		$this->load();
	}

	/**
	 * render -- generate HTML for displaying comment
	 *
	 * @return String -- generated HTML text
	 */
	public function render() {
		global $wgLang, $wgContLang, $wgUser, $wgParser;
		global $wgOut;

		wfProfileIn( __METHOD__ );

		$text = false;
		if( $this->load() ) {
			$canDelete = $wgUser->isAllowed( 'delete' );

			$text     = $wgOut->parse( $this->mLastRevision->getText() );
			$anchor   = self::explode( $this->mTitle->getDBkey() );
			$sig      = ( $this->mUser->isAnon() )
				? Xml::span( wfMsg('article-comments-anonymous'), false, array( 'title' => $this->mFirstRevision->getUserText() ) )
				: Xml::element( 'a', array ( 'href' => $this->mUser->getUserPage()->getFullUrl() ), $this->mUser->getName() );

			$comments = array(
				'sig'       => $sig,
				'text'      => $text,
				'title'     => $this->mTitle,
				'author'    => $this->mUser,
				'anchor'    => $anchor,
				'avatar'    => $this->getAvatarImg($this->mUser),
				'timestamp' => $wgLang->timeanddate( $this->mFirstRevision->getTimestamp() )
			);

			$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
			$template->set_vars(
				array (
					'comment' 	=> $comments,
					'canDelete' => $canDelete,
					'canEdit'	=> $this->canEdit(),
					'sk'		=> $wgUser->getSkin(),
					'showHistory' => 1
				)
			);
			$text = $template->render( 'comment' );
		}

		wfProfileOut( __METHOD__ );

		return $text;
	}

	function getAvatarImg($user){
		if (class_exists('Masthead')){
			return Masthead::newFromUser( $user )->display( 50, 50 );
		} else {
			// Answers
			$avatar = new wAvatar($user->getId(), "ml");
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

		$Title = null;
		list ( $user, $comment ) = self::explode($this->mTitle->getDBkey());
		if ( !empty($user) ) {
			$articleTitle = $user;
			$Title = Title::makeTitle($this->mNamespace, $articleTitle);
		}
		return $Title;
	}

	public function explode($title) {
		$oTitle = Title::newFromText($title);
		if ( !is_null($oTitle) ) {
			$title = $oTitle->getPrefixedDBkey();
		}
		$elements = explode( '/', $title );
		$res = array( '', '' );
		if ( !empty($elements) && is_array($elements) ) {
			reset($elements);
			$user = $elements[key($elements)];
			$comment = end($elements);
			$res = array ($user, $comment);
		}
		return $res;
	}

	/**
	 * check if current user can edit comment
	 *
	 * @access private
	 */
	public function canEdit() {
		global $wgUser;

		$res = false;
		if ( $this->mUser ) {
			$isAuthor = ($this->mUser->getId() == $wgUser->getId()) && (!$wgUser->isAnon());
			$canEdit = $wgUser->isAllowed( 'edit' ) && $this->mTitle->userCanEdit();

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
		global $wgUser, $wgTitle;
		wfProfileIn( __METHOD__ );

		$text = '';
		$this->load();
		if ( $this->canEdit() ) {
			$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
			$template->set_vars(
				array(
					'comment' 		=> $this->mLastRevision->getText(),
					'isReadOnly' 	=> wfReadOnly(),
					'canEdit'		=> $this->canEdit(),
					'title'     	=> $this->mTitle,
				)
			);
			wfLoadExtensionMessages('ArticleComments');
			$text = $template->execute( 'comment-edit' );
		}

		wfProfileOut( __METHOD__ );

		return $text;
	}

	/**
	 * editPage -- show edit form
	 *
	 * @access public
	 *
	 * @return String
	 */
	public function doSaveComment( $Request, $User, $Title ) {
		global $wgMemc, $wgTitle;
		wfProfileIn( __METHOD__ );

		$res = array();
		$this->load();
		if ( $this->canEdit() ) {

			if ( wfReadOnly() ) {
				wfProfileOut( __METHOD__ );
				return false;
			}

			$text = $Request->getText('wpArticleComment', false);
			$commentId = $Request->getText('id', false);
			if( !$text || !strlen( $text ) ) {
				wfProfileOut( __METHOD__ );
				return false;
			}

			if( !$commentId ) {
				wfProfileOut( __METHOD__ );
				return false;
			}

			$commentTitle = ( $this->mTitle ) ? $this->mTitle : Title::newFromId($commentId);

			/**
			 * because we save different tile via Ajax request
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
			$Title->invalidateCache();
			$Title->purgeSquid();

			$key = $Title->getPrefixedDBkey();
			$wgMemc->delete( wfMemcKey( 'articlecomment', 'listing', $key, 0 ) );
			$wgMemc->delete( wfMemcKey( 'articlecomment', 'comm', $Title->getArticleID() ) );

			$res = array( $retval, $article );
		} else {
			$res = false;
		}

		wfProfileOut( __METHOD__ );

		return $res;
	}

	/**
	 * axSave -- static hook/entry for ajax request save comment
	 *
	 * @static
	 * @access public
	 *
	 * @return String -- json-ized array
	 */
	static public function axSave() {
		global $wgRequest, $wgUser, $wgDevelEnvironment, $wgDBname;

		$articleId = $wgRequest->getVal( 'article', false );
		$commentId = $wgRequest->getVal( 'id', false );

		$Title = Title::newFromID( $articleId );
		if( ! $Title ) {
			return Wikia::json_encode( array( 'error' => 1 ) );
		}

		$res = array();
		$Comment = ArticleComment::newFromId( $commentId );
		if( $Comment ) {
			$response = $Comment->doSaveComment( $wgRequest, $wgUser, $Title );
		} else {
			return Wikia::json_encode( array( 'error' => 1 ) );
		}

		if ( $response !== false ) {
			$status = $response[0]; $article = $response[1];
			wfLoadExtensionMessages('ArticleComments');
			$res = self::doAfterPost($status, $article, $commentId);
		} else {
			return Wikia::json_encode( array( 'error' => 1 ) );
		}

		$json = Wikia::json_encode($res);
		$response = new AjaxResponse($json);
		$response->setContentType('application/json; charset=utf-8');
		return $response;
	}

	/**
	 * axEdit -- static hook/entry for ajax request post -- edit comment
	 *
	 * @static
	 * @access public
	 *
	 * @return String -- html -> textarea
	 */
	static public function axEdit() {
		global $wgRequest, $wgUser, $wgTitle;

		$commentId = $wgRequest->getVal( 'id', false );
		$articleId = $wgRequest->getVal( 'article', false );
		$error     = 0;

		/**
		 * check owner of article
		 */
		$Title = Title::newFromID( $articleId );
		if( ! $Title ) {
			$error = 1;
		}

		/**
		 * edit comment
		 */
		$Comment = ArticleComment::newFromId( $commentId );
		if( $Comment ) {
			$status  = true;
			$text    = $Comment->editPage();
		}
		else {
			$text = '';
			$status = false;
		}

		$json = Wikia::json_encode(
			array(
				'id'	=> $commentId,
				'error'	=> $error,
				'show'	=> $status,
				'text'	=> $text
			)
		);
		$response = new AjaxResponse($json);
		$response->setContentType('application/json; charset=utf-8');
		return $response;
	}

	/**
	 * axPost -- static hook/entry for ajax request post
	 *
	 * @static
	 * @access public
	 *
	 * @return String -- json-ized array`
	 */
	static public function axPost() {
		global $wgRequest, $wgUser, $wgDevelEnvironment, $wgDBname, $wgArticleCommentsMaxPerPage;

		$articleId = $wgRequest->getVal( 'article', false );

		$Title = Title::newFromID( $articleId );
		if( ! $Title ) {
			return Wikia::json_encode( array( 'error' => 1 ) );
		}

		$response = self::doPost( $wgRequest, $wgUser, $Title );
		$res = array();
		if ( $response !== false ) {
			$status = $response[0]; $article = $response[1];
			$res = self::doAfterPost($status, $article);

			$listing = ArticleCommentList::newFromTitle($Title);
			$comments = $listing->getCommentPages(true, false);
			$countComments = count($comments);
			$countPages = ceil($countComments / $wgArticleCommentsMaxPerPage);
			$page = $listing->getOrder() == 'desc' ? 0 : $countPages-1;
			$comments = array_slice($comments, $page * $wgArticleCommentsMaxPerPage, $wgArticleCommentsMaxPerPage, true);
			$comments = ArticleCommentList::formatList($comments);
			$pagination = ArticleCommentList::doPagination($countComments, count($comments), $page,$Title);

			$res = array('text' => $comments, 'pagination' => $pagination);
		}

		$json = Wikia::json_encode($res);
		$response = new AjaxResponse($json);
		$response->setContentType('application/json; charset=utf-8');
		return $response;
	}

	/**
	 * doPost -- static hook/entry for normal request post
	 *
	 * @static
	 * @access public
	 *
	 * @param WebRequest $Request -- instance of WebRequest
	 * @param User       $User    -- instance of User
	 * @param Title      $Title   -- instance of Title
	 *
	 * @return Article -- newly created article
	 */
	static public function doPost( &$Request, &$User, &$Title ) {

		global $wgMemc, $wgTitle;
		wfProfileIn( __METHOD__ );

		$text = $Request->getText('wpArticleComment', false);
		if( !$text || !strlen( $text ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		/**
		 * title for comment is combination of article title and some 'random'
		 * data
		 */
		$commentTitle = Title::newFromText(
			sprintf( '%s/%s%s-%s', $Title->getText(), ARTICLECOMMENT_PREFIX, $User->getName(), wfTimestampNow() ),
			Namespace::getTalk($Title->getNamespace()) );
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
		$Title->invalidateCache();
		$Title->purgeSquid();

		$key = $Title->getPrefixedDBkey();
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
				$text = $comment->render();
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

	static public function addArticlePageToWatchlist($Comment, $commentId) {
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

		$oArticlePage = $Comment->getArticleTitle();
		if ( !is_null($oArticlePage) ) {
			$dbw = wfGetDB(DB_MASTER);
			$dbw->begin();
			if ( !$Comment->mTitle->userIsWatching() ) {
				# comment
				$dbw->insert( 'watchlist',
					array(
					'wl_user' => $wgUser->getId(),
					'wl_namespace' => Namespace::getTalk($comment->mTitle->getNamespace()),
					'wl_title' => $Comment->mTitle->getDBkey(),
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

			if (Namespace::isTalk($namespace) &&
				strpos(end(explode('/', $title)), ARTICLECOMMENT_PREFIX) === 0 &&
				!empty($article_id)) {

				$Comment = ArticleComment::newFromId( $article_id );
				if ( !is_null($Comment) ) {
					$oArticlePage = $Comment->getArticleTitle();
					#---
					$mAttribs = $oRC->mAttribs;
					#---
					$mAttribs['rc_title'] = $oArticlePage->getDBkey();
					$mAttribs['rc_namespace'] = Namespace::getSubject($oArticlePage->getNamespace());
					$mAttribs['rc_log_action'] = 'article_comment';
					#---
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
	 * @param Title $Title -- instance of EmailNotification class
	 * @param Array $keys -- array of all special variables like $PAGETITLE etc
	 * @param String $message (subject or body)
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static public function ComposeCommonMail( $Title, &$keys, &$message, $editor ) {
		global $wgEnotifUseRealName;

		if (Namespace::isTalk($Title->getNamespace()) && strpos(end(explode('/', $Title->getText())), ARTICLECOMMENT_PREFIX) === 0) {
			if ( !is_array($keys) ) {
				$keys = array();
			}

			$name = $wgEnotifUseRealName ? $editor->getRealName() : $editor->getName();
			if( $editor->isIP( $name ) ) {
				$utext = trim(wfMsgForContent('enotif_anon_editor', ""));
				$message = str_replace('$PAGEEDITOR', $utext, $message);
				$keys['$PAGEEDITOR'] = $utext;
			}
		}
		return true;
	}
}

/**
 * ArticleComment is listing, basicly it's array of comments
 */
class ArticleCommentList {

	private $mTitle;
	private $mText;
	private $mComments = false;
	private $mOrder = false;
	private $mCountAll;

	static public function newFromTitle( Title $title ) {
		$comments = new ArticleCommentList();
		$comments->setTitle( $title );
		$comments->setText( $title->getDBkey( ) );
		return $comments;
	}

	static public function newFromText( $text ) {
		$articlePage = Title::newFromText( $text, $this->getTitle()->getNamespace() );
		if( ! $articlePage ) {
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
	 * getOrder -- standard accessor/getter
	 */
	public function getOrder() {
		return $this->mOrder;
	}

	/**
	 * sort -- sort array according to mOrder variable
	 *
	 * @return Array --sorted array
	 */
	private function sort() {
		if ( $this->mOrder == 'desc' ) {
			krsort( $this->mComments, SORT_NUMERIC );
		} else {
			ksort( $this->mComments, SORT_NUMERIC );
		}
		return $this->mComments;
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
	public function getCommentPages( $master = true, $page = 0 ) {
		global $wgRequest, $wgMemc, $wgArticleCommentsMaxPerPage;

		wfProfileIn( __METHOD__ );

		$order  = $wgRequest->getText( 'order',  false );
		$action = $wgRequest->getText( 'action', false );

		$this->handleArticleCommentOrderCookie( $order ); // it's &$order...
		$this->mOrder = $order == 'desc' ? 'desc' : 'asc';

		/**
		 * skip cache if purging or using master connection
		 */
		if( $action != 'purge' && ! $master ) {
			$this->mComments = $wgMemc->get( wfMemcKey( 'articlecomment', 'comm', $this->getTitle()->getArticleId() ) );
		}

		if( ! is_array( $this->mComments ) ) {
			/**
			 * cache it! but with what key?
			 */
			$pages = array();

			$dbr = ( $master ) ? wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'page' ),
				array( 'page_id' ),
				array(
					'page_namespace' => Namespace::getTalk($this->getTitle()->getNamespace()),
					"page_title LIKE '" . $dbr->escapeLike( $this->mText ) . "/" . ARTICLECOMMENT_PREFIX . "%'"
				),
				__METHOD__,
				array( 'ORDER BY' => "page_id {$this->mOrder}" )
			);
			while( $row = $dbr->fetchObject( $res ) ) {
				$pages[ $row->page_id ] = ArticleComment::newFromId( $row->page_id );
			}
			$dbr->freeResult( $res );
			$this->mComments = $pages;
			$wgMemc->set( wfMemcKey( 'articlecomment', 'comm', $this->getTitle()->getArticleId() ), $this->mComments, 3600 );
		}

		$this->mComments = $this->sort();

		//pagination
		$this->mCountAll = count($this->mComments);
		if ($page !== false) {
			$this->mComments = array_slice($this->mComments, $page * $wgArticleCommentsMaxPerPage, $wgArticleCommentsMaxPerPage, true);
		}

		wfProfileOut( __METHOD__ );
		return $this->mComments;
	}

	/**
	 * handleArticleCommentOrderCookie -- save in cookie article comment order from url & get it next time
	 *
	 * @param string $order -- asc/desc or false if not set via url
	 *
	 * @see RT#19080
	 */
	private function handleArticleCommentOrderCookie(&$order) {
		global $wgCookiePrefix;
		$cookie = !empty($_COOKIE[$wgCookiePrefix . ARTICLECOMMENTORDERCOOKIE_NAME]) ? $_COOKIE[$wgCookiePrefix . ARTICLECOMMENTORDERCOOKIE_NAME] : false;

		if (empty($cookie)) {
			if (empty($order)) {
				// nothing to do, 100% default
			} else {
				// save order in cookie
				WebResponse::setcookie(ARTICLECOMMENTORDERCOOKIE_NAME, $order, time() + ARTICLECOMMENTORDERCOOKIE_EXPIRE);
			}
		} else {
			if (empty($order)) {
				// set order to cookie value
				$order = $cookie;
			} else {
				// both set, another round of arbitrage
				if ($order == $cookie) {
					// nothing to do, both are in sync
				} else {
					// save order in cookie
					WebResponse::setcookie(ARTICLECOMMENTORDERCOOKIE_NAME, $order, time() + ARTICLECOMMENTORDERCOOKIE_EXPIRE);
				}
			}
		}
	}

	/**
	 * getCommentPages -- take pages connected to comments list
	 */
	private function getRemovedCommentPages( $oTitle ) {
		wfProfileIn( __METHOD__ );

		$pages = array();

		if ($oTitle instanceof Title) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'archive' ),
				array( 'ar_page_id', 'ar_title' ),
				array(
					'ar_namespace' => Namespace::getTalk($this->getTitle()->getNamespace()),
					"ar_title LIKE '" . $dbr->escapeLike( $oTitle->getDBkey( ) ) . "/%'"
				),
				__METHOD__,
				array( 'ORDER BY' => 'ar_page_id' )
			);
			while( $row = $dbr->fetchObject( $res ) ) {
				$pages[ $row->ar_page_id ] = array(
					'title' => $row->ar_title,
					'nspace' => Namespace::getTalk($this->getTitle()->getNamespace())
				);
			}
			$dbr->freeResult( $res );
		}

		wfProfileOut( __METHOD__ );
		return $pages;
	}

	/**
	 * count -- just return number of comments
	 *
	 * @return integer
	 */
	public function count() {
		$comments = $this->getCommentPages();
		if( is_array( $comments ) ) {
			return count( $comments );
		}

		return 0;
	}

	/**
	 * render -- return HTML code for displaying comments
	 *
	 * @access public
	 *
	 * @return String HTML text with rendered comments section
	 */
	public function render() {
		global $wgUser, $wgTitle, $wgRequest, $wgOut, $wgArticleCommentsMaxPerPage;

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

		//get first or last page to show newest comments in default view
		$comments = $this->getCommentPages(true, false);
		$countComments = count($comments);
		$countPages = ceil($countComments / $wgArticleCommentsMaxPerPage);
		$page = $this->getOrder() == 'desc' ? 0 : $countPages-1;
		
		$pageRequest = (int) $wgRequest->getVal( 'page', 0 );
		if ( ( $pageRequest <= $countPages ) && ($pageRequest > 0) ) {
			$page = $pageRequest - 1;
		}

		$comments = array_slice($comments, $page * $wgArticleCommentsMaxPerPage, $wgArticleCommentsMaxPerPage, true);
		$pagination = self::doPagination($countComments, count($comments), $page);

		$canDelete = $wgUser->isAllowed( 'delete' );
		$isReadOnly = wfReadOnly();

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );

		$template->set_vars( array(
			'order'     => $this->mOrder,
			'title'     => $wgTitle,
			'avatar'    => $avatar,
			'wgUser'    => $wgUser,
			'isSysop'   => $isSysop,
			'canEdit'   => $canEdit,
			'isBlocked' => $isBlocked,
			'reason'	=> $isBlocked ? $this->blockedPage() : '',
			'output'	=> $wgOut,
			'comments'  => $comments,
			'canDelete' => $canDelete,
			'isReadOnly' => $isReadOnly,
			'pagination' => $pagination,
			'countComments' => $countComments
		) );

		$text = $template->execute( 'comment-list' );

		return $text;
	}

	/**
	 * doPagination -- return HTML code for pagination
	 *
	 * @access public
	 *
	 * @return String HTML text
	 */
	static function doPagination($countAll, $countComments, $activePage = 0,$title = null) {
		global $wgArticleCommentsMaxPerPage,$wgTitle,$wgRequest;
		$pagination = '';
		
		if ( $title == null ){
			$title = $wgTitle;
		}
		
		if ($countAll > $countComments) {
			$numberOfPages = ceil($countAll / $wgArticleCommentsMaxPerPage);
			$pagination .= '<a href="' . $title->getLinkUrl("page=". (max($activePage, 1)) ) . '#article-comment-header" id="article-comments-pagination-link-prev" class="article-comments-pagination-link dark_text_1" page="' . (max($activePage - 1, 0)) . '">&laquo;</a>';
			for ($i = 0; $i < $numberOfPages; $i++) {
				$pagination .= '<a href="' . $title->getFullUrl("page=".($i+1)) . '#article-comment-header" id="article-comments-pagination-link-' . $i . '" class="article-comments-pagination-link dark_text_1' . ($i == $activePage ? ' article-comments-pagination-link-active' : '') . '" page="' . $i . '">' . ($i+1) . '</a>';
			}
			$pagination .= '<a href="' . $title->getFullUrl("page=" . (min($activePage + 2, $numberOfPages )) ) . '#article-comment-header" id="article-comments-pagination-link-next" class="article-comments-pagination-link dark_text_1" page="' . (min($activePage + 1, $numberOfPages - 1)) . '">&raquo;</a>';
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
		$title = Title::newFromText(reset(explode('/', $this->mText)), Namespace::getSubject($this->mTitle->getNamespace()));
		$title->invalidateCache();
		$titleURL = $title->getFullUrl();
		$urls = array("$titleURL?order=asc", "$titleURL?order=desc");
		SquidUpdate::purge($urls);
	}

	/**
	 * Hook
	 *
	 * @param Article $Article -- instance of Article class
	 * @param User    $User    -- current user
	 * @param string  $reason  -- deleting reason
	 * @param integer $id      -- article id
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's a hook
	 */
	static public function articleDeleteComplete( &$Article, &$User, $reason, $id ) {
		wfProfileIn( __METHOD__ );

		$title = $Article->getTitle();
		if (Namespace::isTalk($title->getNamespace()) && strpos(end(explode('/', $title->getText())), ARTICLECOMMENT_PREFIX) === 0) {
			$listing = ArticleCommentList::newFromTitle($title);

			$aComments = $listing->getCommentPages();
			if ( !empty($aComments) ) {
				foreach ($aComments as $page_id => $oComment) {
					$oCommentTitle = $oComment->getTitle();
					if ( $oCommentTitle instanceof Title ) {
						$oArticle = new Article($oCommentTitle);
						$oArticle->doDeleteArticle($reason);
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
		// to do
		wfProfileIn( __METHOD__ );

		if ( $oTitle instanceof Title ) {
			#---
			$new_page_id = $oTitle->getArticleId();
			#---
			$listing = ArticleCommentList::newFromTitle( $oTitle );
			#---
			$pagesToRecover = $listing->getRemovedCommentPages($oTitle);
			#---
			if ( !empty($pagesToRecover) && is_array($pagesToRecover) ) {
				#---
				foreach ($pagesToRecover as $page_id => $page_value) {
					#---
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
	static public function makeChangesListKey( &$oChangeList, &$currentName, &$oRCCacheEntry ) {
		global $wgUser, $wgEnableGroupedArticleCommentsRC, $wgTitle, $wgEnableBlogArticles;
		wfProfileIn( __METHOD__ );

		if ( empty($wgEnableGroupedArticleCommentsRC) ) {
			return true;
		}

		$oTitle = $oRCCacheEntry->getTitle();
		$namespace = $oTitle->getNamespace();

		$allowed = !( $wgEnableBlogArticles && in_array($oTitle->getNamespace(), array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK)) );
		if (!is_null($oTitle) && Namespace::isTalk($oTitle->getNamespace()) && strpos(end(explode('/', $oTitle->getText())), ARTICLECOMMENT_PREFIX) === 0 && $allowed) {
			$user = $comment = '';
			$newTitle = null;
			list( $user, $comment ) = ArticleComment::explode( $oTitle->getDBkey() );

			if ( !empty($user) ) {
				$currentName = 'ArticleComments' . reset(explode('/', $oTitle->getText()));
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
			if ( !is_null($oTitle) && Namespace::isTalk($oTitle->getNamespace()) && strpos(end(explode('/', $oTitle->getText())), ARTICLECOMMENT_PREFIX) === 0 && $allowed ) {
				list( $user, $comment ) = ArticleComment::explode( $oTitle->getDBkey() );

				if ( !empty($user) ) {
					$cnt = count($oRCCacheEntryArray);

					$userlinks = array();
					foreach ( $oRCCacheEntryArray as $id => $oRCCacheEntry ) {
			 			$u = $oRCCacheEntry->userlink;
						if( !isset( $userlinks[$u] ) ) {
							$userlinks[$u] = 0;
						}
						$userlinks[$u]++;
					}

					$users = array();
					foreach( $userlinks as $userlink => $count) {
						$text = $userlink;
						$text .= $wgContLang->getDirMark();
						if( $count > 1 ) {
							$text .= ' (' . $wgLang->formatNum( $count ) . '×)';
						}
						array_push( $users, $text );
					}

					wfLoadExtensionMessages('ArticleComments');
					$cntChanges = wfMsgExt( 'nchanges', array( 'parsemag', 'escape' ), $wgLang->formatNum( $cnt ) );
					$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
					$template->set_vars(
						array (
							'hdrtitle' 		=> wfMsgExt('article-comments-rc-comments', array('parseinline'), reset(explode('/', $oTitle->getText()))),
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
	 * axGetComments -- static hook/entry for ajax request for pagination
	 *
	 * @static
	 * @access public
	 *
	 * @return String - HTML
	 */
	static function axGetComments() {
		global $wgRequest, $wgTitle;

		$page = $wgRequest->getVal('page', false);
		$articleId = $wgRequest->getVal('article', false);
		$order  = $wgRequest->getText('order',  false);
		$error = 0;
		$text = '';

		$title = Title::newFromID($articleId);
		if( !$title ) {
			$error = 1;
		} else {
			wfLoadExtensionMessages('ArticleComments');
			$listing = ArticleCommentList::newFromTitle($title);
			$listing->handleArticleCommentOrderCookie($order);
			$listing->mOrder = $order == 'desc' ? 'desc' : 'asc';
			$comments = $listing->getCommentPages(true, $page);
			$text = self::formatList($comments);
		}

		$result = Wikia::json_encode(array('error' => $error, 'text' => $text));
		$ar = new AjaxResponse($result);

		return $ar;
	}

	/**
	 * formatList -- TODO: move it to template?
	 *
	 * @static
	 * @access public
	 *
	 * @return String - HTML
	 */
	static function formatList($comments) {
		$text = '<ul id="article-comments-ul">';
		$odd = true;
		foreach( $comments as $articleID => $comment ) {
			$class = $odd ? 'odd' : 'even'; $odd = !$odd;
			$text .= "<li id=\"comm-{$articleID}\" class=\"article-comments-li article-comment-row-{$class}\">\n";
			$text .= $comment->render();
			$text .= "\n</li>\n";
		}
		$text .= '</ul>';
		return $text;
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
		if (strpos($rcTitle, '/') !== false && strpos(end(explode('/', $rcTitle)), ARTICLECOMMENT_PREFIX) === 0) {
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
	static public function ArticleFromTitle( &$Title, &$Article ) {
		if (Namespace::isTalk($Title->getNamespace()) && strpos(end(explode('/', $Title->getText())), ARTICLECOMMENT_PREFIX) === 0) {
			global $wgRequest, $wgTitle, $wgOut;
			$redirect = $wgRequest->getText('redirect', false);
			$diff = $wgRequest->getText('diff', '');
			$oldid = $wgRequest->getText('oldid', '');
			$action = $wgRequest->getText('action', '');
			if (($redirect != 'no') && empty($diff) && empty($oldid) && ($action != 'history')) {
				$redirect = Title::newFromText(reset(explode('/', $Title->getText())), Namespace::getSubject($Title->getNamespace()));
				$wgOut->redirect($redirect->getFullUrl());
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
		if (Namespace::isTalk($title->getNamespace()) && strpos(end(explode('/', $title->getText())), ARTICLECOMMENT_PREFIX) === 0) {
			$result = true;	//omit captcha
			return false;
		}
		return true;
	}

	static function ChangesListInsertArticleLink($changeList, &$articlelink, &$s, &$rc, $unpatrolled, $watched) {
		$title = $rc->getAttribute('rc_title');
		$namespace = $rc->getAttribute('rc_namespace');

		if (Namespace::isTalk($namespace) &&
			strpos(end(explode('/', $title)), ARTICLECOMMENT_PREFIX) === 0) {

			wfLoadExtensionMessages('ArticleComments');
			$articlelink = wfMsgExt('article-comments-rc-comment', array('parseinline'), str_replace('_', ' ', reset(explode('/', $title))));
		}
		return true;
	}
}
