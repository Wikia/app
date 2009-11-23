<?php

/**
 * @author Krzysztof Krzyżaniak <eloy@wikia.inc>
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 *
 * @name ArticleComment -- single comment
 * @name ArticleCommentList -- listing
 *
 */

//TODO:
//* change $this->getTitle()->getNamespace() to some private variable
//* change Namespace::getTalk($this->getTitle()->getNamespace()) to some private variable

define( "BLOGCOMMENTORDERCOOKIE_NAME", "blogcommentorder" );
define( "BLOGCOMMENTORDERCOOKIE_EXPIRE", 60 * 60 * 24 * 365 );
define('ARTICLECOMMENT_PREFIX', '@comment-');

$wgExtensionMessagesFiles['ArticleComments'] = dirname(__FILE__) . '/ArticleComments.i18n.php';

global $wgAjaxExportList;
$wgAjaxExportList[] = "ArticleComment::axPost";
$wgAjaxExportList[] = "ArticleComment::axEdit";
$wgAjaxExportList[] = "ArticleComment::axSave";

$wgHooks[ "ArticleDeleteComplete" ][] = "ArticleCommentList::articleDeleteComplete";
$wgHooks[ "ArticleRevisionUndeleted" ][] = "ArticleCommentList::undeleteComments";
$wgHooks[ "UndeleteComplete" ][] = "ArticleCommentList::undeleteComplete";
$wgHooks[ "RecentChange_save" ][] = "ArticleComment::watchlistNotify";
# recentchanges
$wgHooks[ "ChangesListMakeSecureName" ][] = "ArticleCommentList::makeChangesListKey";
$wgHooks[ "ChangesListHeaderBlockGroup" ][] = "ArticleCommentList::setHeaderBlockGroup";
# special::watchlist
$wgHooks[ "SpecialWatchlistQuery" ][] = "ArticleComment::WatchlistQuery";
$wgHooks[ "ComposeCommonSubjectMail" ][] = "ArticleComment::ComposeCommonMail";
$wgHooks[ "ComposeCommonBodyMail" ][] = "ArticleComment::ComposeCommonMail";
# test
$wgHooks['SkinAfterContent'][] = 'ArticleCommentEnable';

function ArticleCommentEnable(&$data) {
	global $wgOut, $wgTitle, $wgStyleVersion, $wgExtensionsPath, $wgJsMimeType;
	wfProfileIn( __METHOD__ );

	wfLoadExtensionMessages('ArticleComments');
	$page = ArticleCommentList::newFromTitle( $wgTitle );
	$data = $page->render( true );
	$data .= "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/ArticleComments/js/ArticleComments.js?{$wgStyleVersion}\" ></script>\n";

	wfProfileOut( __METHOD__ );
	return true;
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
		$mUser;	         ### comment creator


	public function __construct( $Title ) {
		/**
		 * initialization
		 */
		$this->mTitle = $Title;
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
					Wikia::log( __METHOD__, "ne", "{$this->mLastRevId} ne {$this->mFirstRevId}" );
				}
				else {
					$this->mFirstRevision = Revision::newFromId( $this->mFirstRevId );
					$this->mLastRevision = $this->mFirstRevision;
					$this->mLastRevId = $this->mFirstRevId;
					Wikia::log( __METHOD__, "ne", "getting {$this->mFirstRevId} as lastRev" );
				}
			}
			else {
				Wikia::log( __METHOD__, "eq" );
				if( $this->mFirstRevId ) {
					$this->mFirstRevision = Revision::newFromId( $this->mFirstRevId );
					$this->mLastRevision = $this->mFirstRevision;
					Wikia::log( __METHOD__, "eq", "{$this->mLastRevId} eq {$this->mFirstRevId}" );
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
				"revision",
				"min(rev_id)",
				array( "rev_page" => $this->mTitle->getArticleID() ),
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
		global $wgContLang, $wgUser, $wgParser;
		global $wgOut;

		wfProfileIn( __METHOD__ );

		$text = false;
		if( $this->load() ) {
			$canDelete = $wgUser->isAllowed( "delete" );

			$text     = $wgOut->parse( $this->mLastRevision->getText() );
			$anchor   = self::explode( $this->mTitle->getDBkey() );
			$sig      = ( $this->mUser->isAnon() )
				? Xml::span( wfMsg("blog-comments-anonymous"), false, array( "title" => $this->mFirstRevision->getUserText() ) )
				: Xml::element( 'a', array ( "href" => $this->mUser->getUserPage()->getFullUrl() ), $this->mUser->getName() );

			$comments = array(
				"sig"       => $sig,
				"text"      => $text,
				"title"     => $this->mTitle,
				"author"    => $this->mUser,
				"anchor"    => $anchor,
				"avatar"    => Masthead::newFromUser( $this->mUser )->display( 50, 50 ),
				"timestamp" => $wgContLang->timeanddate( $this->mFirstRevision->getTimestamp() )
			);

			$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
			$template->set_vars(
				array (
					"comment" 	=> $comments,
					"canDelete" => $canDelete,
					"canEdit"	=> $this->canEdit(),
					"sk"		=> $wgUser->getSkin(),
					"showHistory" => 1
				)
			);
			$text = $template->render( "comment" );
		}

		wfProfileOut( __METHOD__ );

		return $text;
	}

	/**
	 * get Title object of blog page
	 *
	 * @access private
	 */
	public function getBlogTitle() {
		if ( !isset($this->mTitle) ) {
			return null;
		}

		$Title = null;
		list ( $user, $comment ) = self::explode($this->mTitle->getDBkey());
		if ( !empty($user) ) {
			$blogTitle = $user;
			$Title = Title::makeTitle($this->getTitle()->getNamespace(), $blogTitle);
		}
		return $Title;
	}

	public function explode($title) {
		$oTitle = Title::newFromText($title);
		if ( !is_null($oTitle) ) {
			$title = $oTitle->getPrefixedDBkey();
		}
		$elements = explode( "/", $title );
		$res = array( '', '', '' );
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
			$canEdit   = $wgUser->isAllowed( "edit" );

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
		global $wgUser, $wgMemc, $wgTitle;
		wfProfileIn( __METHOD__ );

		$text = "";
		$this->load();
		if ( $this->canEdit() ) {
			$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
			$template->set_vars(
				array(
					"comment" 		=> $this->mLastRevision->getText(),
					"isReadOnly" 	=> wfReadOnly(),
					"canEdit"		=> $this->canEdit(),
					"title"     	=> $this->mTitle,
				)
			);
			$text = $template->execute( "comment-edit" );
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

			$text = $Request->getText("wpArticleComment", false);
			$commentId = $Request->getText("id", false);
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
			Wikia::log( __METHOD__, "editpage", "Returned value {$retval}" );

			/**
			 * clear comments cache for this article
			 */
			$Title->invalidateCache();
			$Title->purgeSquid();

			$key = $Title->getPrefixedDBkey();
			$wgMemc->delete( wfMemcKey( "blog", "listing", $key, 0 ) );
			$wgMemc->delete( wfMemcKey( "blog", "comm", $Title->getArticleID() ) );

			$res = array( $retval, $article );

			/**
			 * update cache from master
			 */
//TODO: check this
//			$clist = ArticleCommentList::newFromTitle( $Title );
//			$clist->getCommentPages( true );

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

		$articleId = $wgRequest->getVal( "article", false );
		$commentId = $wgRequest->getVal( "id", false );

		$Title = Title::newFromID( $articleId );
		if( ! $Title ) {
			Wikia::log( __METHOD__, "error", "Cannot create title" );
			return Wikia::json_encode( array( "error" => 1 ) );
		}

		$res = array();
		$Comment = ArticleComment::newFromId( $commentId );
		if( $Comment ) {
			$response = $Comment->doSaveComment( $wgRequest, $wgUser, $Title );
		}
		else {
			return Wikia::json_encode( array( "error" => 1 ) );
		}

		if ( $response !== false ) {
			$status = $response[0]; $article = $response[1];
			$res = self::doAfterPost($status, $article, $commentId);
		}

		return Wikia::json_encode( $res );
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

		$commentId = $wgRequest->getVal( "id", false );
		$articleId = $wgRequest->getVal( "article", false );
		$error     = 0;

		/**
		 * check owner of blog
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
			$text = "";
			$status = false;
		}

		return Wikia::json_encode(
			array(
				"id"	=> $commentId,
				"error"	=> $error,
				"show"	=> $status,
				"text"	=> $text
			)
		);
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
		global $wgRequest, $wgUser, $wgDevelEnvironment, $wgDBname;

		$articleId = $wgRequest->getVal( "article", false );

		$Title = Title::newFromID( $articleId );
		if( ! $Title ) {
			Wikia::log( __METHOD__, "error", "Cannot create title" );
			return Wikia::json_encode( array( "error" => 1 ) );
		}

		$response = self::doPost( $wgRequest, $wgUser, $Title );
		$res = array();
		if ( $response !== false ) {
			$status = $response[0]; $article = $response[1];
			$res = self::doAfterPost($status, $article);
		}

		return Wikia::json_encode( $res );
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

		$text = $Request->getText("wpArticleComment", false);
		if( !$text || !strlen( $text ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		/**
		 * title for comment is combination of article title and some "random"
		 * data
		 */
		$commentTitle = Title::newFromText(
			sprintf( "%s/%s%s-%s", $Title->getText(), ARTICLECOMMENT_PREFIX, $User->getName(), wfTimestampNow() ),
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
		Wikia::log( __METHOD__, "editpage", "Returned value {$retval}" );

		/**
		 * clear comments cache for this article
		 */
		$Title->invalidateCache();
		$Title->purgeSquid();

		$key = $Title->getPrefixedDBkey();
		$wgMemc->delete( wfMemcKey( "blog", "listing", $key, 0 ) );

//TODO: check this
//		$clist = ArticleCommentList::newFromTitle( $Title );
//		$clist->getCommentPages( true );

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
					$ok = self::addBlogPageToWatchlist($comment, $commentId) ;
				}
				$message = false;
				break;
			default:
				$wgDevelEnvironment = true;
				$userId = $wgUser->getId();
				Wikia::log( __METHOD__, "error", "No article created. Status: {$status}; DB: {$wgDBname}; User: {$userId}" );
				$text  = false;
				$error = true;
				$message = wfMsg("blog-comment-error");
				$wgDevelEnvironment = false;
		}

		$res = array(
			"msg"    	=> $message,
			"error"  	=> $error,
			"text"   	=> $text,
			"status" 	=> $status,
			"commentId" => $commentId,
			"id"		=> $id
		);

		return $res;
	}

	static public function addBlogPageToWatchlist($Comment, $commentId) {
		global $wgUser, $wgEnableBlogWatchlist, $wgTitle;
		//TODO: check proper usage of wgTitle

		$watchthis = false;
		if ( empty($wgEnableBlogWatchlist) ) {
			return $watchthis;
		}

		if ( !$wgUser->isAnon() ) {
			if ( $wgUser->getOption( 'watchdefault' ) ) {
				$watchthis = true;
			} elseif ( $wgUser->getOption( 'watchcreations' ) && empty($commentId) /* new comment */ ) {
				$watchthis = true;
			}
		}

		$oBlogPage = $Comment->getBlogTitle();
		if ( !is_null($oBlogPage) ) {
			$dbw = wfGetDB(DB_MASTER);
			$dbw->begin();
			if ( !$Comment->mTitle->userIsWatching() ) {
				# comment
				$dbw->insert( 'watchlist',
					array(
					'wl_user' => $wgUser->getId(),
					'wl_namespace' => Namespace::getTalk($wgTitle->getNamespace()),
					'wl_title' => $Comment->mTitle->getDBkey(),
					'wl_notificationtimestamp' => wfTimestampNow()
					), __METHOD__, 'IGNORE'
				);
			}

			if ( !$oBlogPage->userIsWatching() ) {
				# and blog page
				$dbw->insert( 'watchlist',
					array(
					'wl_user' => $wgUser->getId(),
					'wl_namespace' => $wgTitle->getNamespace(),
					'wl_title' => $oBlogPage->getDBkey(),
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
	 * @return true -- because it's hook
	 */
	static public function watchlistNotify ( RecentChange &$oRC ) {
		global $wgEnableBlogWatchlist, $wgTitle;
		wfProfileIn( __METHOD__ );

		if ( !empty($wgEnableBlogWatchlist) && ( $oRC instanceof RecentChange ) ) {
			$namespace = $oRC->getAttribute('rc_namespace');
			$blog_id = $oRC->getAttribute('rc_cur_id');
			//TODO: is this usage of wgTitle is proper?
			if ( ( $namespace == Namespace::getTalk($wgTitle->getNamespace()) ) && !empty( $blog_id ) ) {
				$Comment = ArticleComment::newFromId( $blog_id );
				if ( !is_null($Comment) ) {
					$oBlogPage = $Comment->getBlogTitle();
					#---
					$mAttribs = $oRC->mAttribs;
					#---
					$mAttribs['rc_title'] = $oBlogPage->getText();
					$mAttribs['rc_namespace'] = $oBlogPage->getNamespace();
					$mAttribs['rc_log_action'] = 'blogs_comment';
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
	 * @param RecentChange $oRC -- instance of RecentChange class
	 *
	 * @static
	 * @access public
	 *
	 * @return true -- because it's hook
	 */
	static public function WatchlistQuery ( &$conds,&$tables,&$join_conds,&$fields ) {
		global $wgEnableBlogWatchlist;
		wfProfileIn( __METHOD__ );

		if ( !empty($wgEnableBlogWatchlist) ) {
			$new_fields = array(
				'rc_id',
				'rc_timestamp',
				'rc_cur_time',
				'rc_user',
				'rc_user_text',
				'if(rc_namespace='.Namespace::getTalk($this->getTitle()->getNamespace()).', SUBSTRING_INDEX(rc_title, \'/\', 2), rc_title) as rc_title',
				'if(rc_namespace='.Namespace::getTalk($this->getTitle()->getNamespace()).', '.$this->getTitle()->getNamespace().', rc_namespace) as rc_namespace',
				'rc_comment',
				'rc_minor',
				'rc_bot',
				'rc_new',
				'rc_cur_id',
				'rc_this_oldid',
				'rc_last_oldid',
				'rc_type',
				'rc_moved_to_ns',
				'rc_moved_to_title',
				'rc_patrolled',
				'rc_ip',
				'rc_old_len',
				'rc_new_len',
				'rc_deleted',
				'rc_logid',
				'rc_log_type',
				'rc_log_action',
				'rc_params'
			);

			if ( !empty($fields) ) {
				foreach ( $fields as $id => $field ) {
					if ( strpos($field, 'recentchanges') === false ) {
						$new_fields[] = $field;
					}
				}
				$fields = $new_fields;
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
	 * @return true -- because it's hook
	 */
	static public function ComposeCommonMail( $Title, &$keys, &$message, $editor ) {
		global $wgEnotifUseRealName;

		$name = $wgEnotifUseRealName ? $editor->getRealName() : $editor->getName();

		if ( $Title->getNamespace() == $this->getTitle()->getNamespace() ) {
			if ( !is_array($keys) ) {
				$keys = array();
			}
			if( $editor->isIP( $name ) ) {
				$utext = trim(wfMsgForContent('enotif_anon_editor', ""));
				$message = str_replace('$PAGEEDITOR', $utext, $message);
				$keys['$PAGEEDITOR'] = $utext;
			}

			$keys['$DBPAGETITLE'] = $Title->getText();
			$keys['$CHANGEDORCREATED'] = wfMsgForContent( 'blog-added' );
			list ( $keys['$AUTHOR'], $keys['$BLOGTITLE'] ) = explode( "/", $keys['$DBPAGETITLE'], 2 );
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

	static public function newFromTitle( Title $title ) {
		$comments = new ArticleCommentList();
		$comments->setTitle( $title );
		$comments->setText( $title->getDBkey( ) );
		return $comments;
	}

	static public function newFromText( $text ) {
		$blogPage = Title::newFromText( $text, $this->getTitle()->getNamespace() );
		if( ! $blogPage ) {
			/**
			 * doesn't exist, lame
			 */
			return false;
		}

		$comments = new ArticleCommentList();
		$comments->setText( $blogPage->getDBkey() );
		$comments->setTitle( $blogPage );
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
	 * sort -- sort array according to mOrder variable
	 *
	 * @return Array --sorted array
	 */
	private function sort() {
		Wikia::log( __METHOD__, "order", $this->mOrder );
		if( $this->mOrder == "desc" ) {
			krsort( $this->mComments, SORT_NUMERIC );
		}
		else {
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
	public function getCommentPages( $master = true ) {
		global $wgRequest, $wgMemc;

		wfProfileIn( __METHOD__ );

		$order  = $wgRequest->getText( "order",  false );
		$action = $wgRequest->getText( "action", false );

		$this->handleBlogCommentOrderCookie( $order ); // it's &$order...
		$this->mOrder = ( $order == "desc" ) ? "desc" : "asc";

		/**
		 * skip cache if purging or using master connection
		 */
		if( $action != "purge" && ! $master ) {
			$this->mComments = $wgMemc->get( wfMemcKey( "blog", "comm", $this->getTitle()->getArticleId() ) );
		}

		if( ! is_array( $this->mComments ) ) {
			/**
			 * cache it! but with what key?
			 */
			$pages = array();

			$dbr = ( $master ) ? wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( "page" ),
				array( "page_id" ),
				array(
					"page_namespace" => Namespace::getTalk($this->getTitle()->getNamespace()),
					"page_title LIKE '" . $dbr->escapeLike( $this->mText ) . "/" . ARTICLECOMMENT_PREFIX . "%'"
				),
				__METHOD__,
				array( "ORDER BY" => "page_id {$this->mOrder}" )
			);
			while( $row = $dbr->fetchObject( $res ) ) {
				$pages[ $row->page_id ] = ArticleComment::newFromId( $row->page_id );
			}
			$dbr->freeResult( $res );
			$this->mComments = $pages;
			$wgMemc->set( wfMemcKey( "blog", "comm", $this->getTitle()->getArticleId() ), $this->mComments, 3600 );
		}

		wfProfileOut( __METHOD__ );
		return $this->sort();
	}

	/**
	 * handleBlogCommentOrderCookie -- save in cookie blog comment order from url & get it next time
	 *
	 * @param string $order -- asc/desc or false if not set via url
	 *
	 * @see RT#19080
	 */
	private function handleBlogCommentOrderCookie(&$order) {
		global $wgCookiePrefix;
		$cookie = !empty($_COOKIE[$wgCookiePrefix . BLOGCOMMENTORDERCOOKIE_NAME]) ? $_COOKIE[$wgCookiePrefix . BLOGCOMMENTORDERCOOKIE_NAME] : false;

		if (empty($cookie)) {
			if (empty($order)) {
				// nothing to do, 100% default
			} else {
				// save order in cookie
				WebResponse::setcookie(BLOGCOMMENTORDERCOOKIE_NAME, $order, time() + BLOGCOMMENTORDERCOOKIE_EXPIRE);
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
					WebResponse::setcookie(BLOGCOMMENTORDERCOOKIE_NAME, $order, time() + BLOGCOMMENTORDERCOOKIE_EXPIRE);
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
				array( "archive" ),
				array( "ar_page_id", "ar_title" ),
				array(
					"ar_namespace" => Namespace::getTalk($this->getTitle()->getNamespace()),
					"ar_title LIKE '" . $dbr->escapeLike( $oTitle->getDBkey( ) ) . "/%'"
				),
				__METHOD__,
				array( "ORDER BY" => "ar_page_id" )
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
		global $wgUser, $wgTitle, $wgRequest;
		global $wgOut;

		if ($wgRequest->wasPosted()) {
			// for non-JS version !!!
			$sComment = $wgRequest->getVal( "wpArticleComment", false );
			$iArticleId = $wgRequest->getVal( "wpArticleId", false );
			$sSubmit = $wgRequest->getVal( "wpBlogSubmit", false );
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
		$avatar    = Masthead::newFromUser( $wgUser );
		$isSysop   = ( in_array('sysop', $wgUser->getGroups()) || in_array('staff', $wgUser->getGroups() ) );
		$canEdit   = $wgUser->isAllowed( "edit" );
		$isBlocked = $wgUser->isBlocked();

		$comments  = $this->getCommentPages();
		$canDelete = $wgUser->isAllowed( "delete" );
		$isReadOnly = wfReadOnly();

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );

		$template->set_vars( array(
			"order"     => $this->mOrder,
			"title"     => $wgTitle,
			"avatar"    => $avatar,
			"wgUser"    => $wgUser,
			"isSysop"   => $isSysop,
			"canEdit"   => $canEdit,
			"isBlocked" => $isBlocked,
			"reason"	=> $isBlocked ? $this->blockedPage() : "",
			"output"	=> $wgOut,
			"comments"  => $comments,
			"canDelete" => $canDelete,
			"isReadOnly" => $isReadOnly,
		) );

		$text = $template->execute( "comment-list" );

		return $text;
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

		return wfMsgExt( $msg, array("parse"), $blockerLink, $reason, $ip, $blockerName, $blockid, $blockExpiry, $intended, $blockTimestamp );
	}

	/**
	 * remove lising from cache and mark title for squid as invalid
	 */
	public function purge() {
		global $wgMemc;

		$wgMemc->delete( wfMemcKey( "blog", "comm", $this->mTitle->getArticleID() ) );

		$this->mTitle->invalidateCache();
		$this->mTitle->purgeSquid();
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
	 * @return true -- because it's hook
	 */
	static public function articleDeleteComplete( &$Article, &$User, $reason, $id ) {
		wfProfileIn( __METHOD__ );

		if ( $this->getTitle()->getNamespace() == $Article->getTitle()->getNamespace() ) {
			$listing = ArticleCommentList::newFromTitle( $Article->getTitle() );

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
	 * @return true -- because it's hook
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
						$ok = $archive->undelete( "", wfMsg("blogs-undeleted-comment", $new_page_id) );

						if ( !is_array($ok) ) {
							Wikia::log( __METHOD__, "error", "cannot restore comment {$page_value['title']} (id: {$page_id})" );
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
			if ( in_array($oTitle->getNamespace(), array($this->getTitle()->getNamespace(), Namespace::getTalk($this->getTitle()->getNamespace()))) ) {
				$pageId = $oTitle->getArticleId();
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
	 * @return true -- because it's hook
	 */
	static public function makeChangesListKey( &$oChangeList, &$currentName, &$oRCCacheEntry ) {
		global $wgUser, $wgEnabledGroupedBlogComments;
		wfProfileIn( __METHOD__ );

		if ( empty($wgEnabledGroupedBlogComments) ) {
			return true;
		}

		$oTitle = $oRCCacheEntry->getTitle();
		$namespace = $oTitle->getNamespace();

		if ( !is_null($oTitle) && in_array( $namespace, array ( Namespace::getTalk($this->getTitle()->getNamespace()) ) ) ) {
			$user = $page_title = $comment = "";
			$newTitle = null;
			list( $user, $page_title, $comment ) = ArticleComment::explode( $oTitle->getDBkey() );

			if ( !empty($user) && (!empty($page_title)) ) {
				$currentName = "Comments";
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
	 * @return true -- because it's hook
	 */
	static public function setHeaderBlockGroup(&$oChangeList, &$header, Array /*of oRCCacheEntry*/ &$oRCCacheEntryArray) {
		global $wgLang, $wgContLang, $wgEnabledGroupedBlogComments;

		if ( empty($wgEnabledGroupedBlogComments) ) {
			return true;
		}

		$oRCCacheEntry = null;
		if ( !empty($oRCCacheEntryArray) ) {
			$oRCCacheEntry = $oRCCacheEntryArray[0];
		}

		if ( !is_null($oRCCacheEntry) ) {
			$oTitle = $oRCCacheEntry->getTitle();
			$namespace = $oTitle->getNamespace();

			if ( !is_null($oTitle) && in_array( $namespace, array ( Namespace::getTalk($this->getTitle()->getNamespace()) ) ) ) {
				list( $user, $page_title, $comment ) = ArticleComment::explode( $oTitle->getDBkey() );

				if ( !empty($user) && (!empty($page_title)) ) {
					$cnt = count($oRCCacheEntryArray);

					$userlinks = array();
					foreach ( $oRCCacheEntryArray as $id => $oRCCacheEntry ) {
			 			# make proper text
			 			if ( !isset($oRCCacheEntry->mOtherFlags) ) {
			 				$oRCCacheEntry->mOtherFlags = array();
						}
			 			$oRCCacheEntry->mOtherFlags[] = $oRCCacheEntry->timestamp;
			 			$oRCCacheEntry->ownTitle = $oRCCacheEntry->getTitle()->getText();

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

					$cntChanges = wfMsgExt( 'nchanges', array( 'parsemag', 'escape' ), $wgLang->formatNum( $cnt ) );
					$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
					$template->set_vars(
						array (
							"hdrtitle" 		=> wfMsg('blog-rc-comments'),
							"inx"			=> $oChangeList->rcCacheIndex,
							"cntChanges"	=> $cntChanges,
							"users"			=> $users,
						)
					);
					$header = $template->execute( "rcheaderblock" );
				}
			}

		}

		return true;
	}

}
