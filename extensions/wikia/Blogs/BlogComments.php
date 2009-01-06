<?php

/**
 * @author Krzysztof Krzyżaniak <eloy@wikia.inc>
 *
 * @name BlogComment -- single comment
 * @name BlogCommentList -- listing
 *
 */

global $wgAjaxExportList;
$wgAjaxExportList[] = "BlogComment::axPost";
$wgAjaxExportList[] = "BlogComment::axToggle";


/**
 * BlogComment is article, this class is used for manipulation on it
 */
class BlogComment {

	public
		$mProps,
		$mTitle,
		$mLastRevId,
		$mFirstRevId,
		$mLastRevision,  ### for displaying text
		$mFirstRevision, ### for author & time
		$mUser,	         ### comment creator
		$mOwner;         ### owner of blog

	public function __construct( $Title ) {
		/**
		 * initialization
		 */
		$this->mTitle = $Title;
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
	 * @return BlogComment object
	 */
	static public function newFromTitle( Title $Title ) {
		return new BlogComment( $Title );
	}

	/**
	 * newFromTitle -- static constructor
	 *
	 * @static
	 * @access public
	 *
	 * @param Title $title -- Title object connected to comment
	 *
	 * @return BlogComment object
	 */
	static public function newFromArticle( Article $Article ) {
		$Title = $Article->getTitle();

		$Comment = new BlogComment( $Title );
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
	 * @return BlogComment object
	 */
	static public function newFromId( $id ) {
		$Title = Title::newFromID( $id );
		if( ! $Title ) {
			return false;
		}
		return new BlogComment( $Title );
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
			$firstRev = $this->getFirstRevID();
			if( !$this->mFirstRevId ) {
				 $this->mFirstRevId = $this->getFirstRevID( GAID_FOR_UPDATE );
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
					$this->mLastRevision = Revision::newFromId( $this->mLastRevId );
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
				$this->getProps();
				$owner = BlogArticle::getOwner( $this->mTitle );
				$this->mOwner = User::newFromName( $owner );
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
	private function getFirstRevID( $flags = 0 ) {
		wfProfileIn( __METHOD__ );

		$id = false;

		if( $this->mTitle ) {
			$db = ($flags & GAID_FOR_UPDATE) ? wfGetDB(DB_MASTER) : wfGetDB(DB_SLAVE);
			$id = $db->selectField(
				"revision",
				"min(rev_id)",
				array( "rev_page" => $this->mTitle->getArticleID( $flags ) ),
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
	public function render() {
		global $wgContLang, $wgUser, $wgParser;
		global $wgOut;

		wfProfileIn( __METHOD__ );

		$text = false;
		if( $this->load() ) {
			$canDelete = $wgUser->isAllowed( "delete" );
/*	to remove?
  			if ( !$wgParser ) {
				$Parser = new Parser();
				error_log ("parser => new Parser \n", 3, "/tmp/moli.log");
				$clear = true;
			}
			else {
				$Parser = $wgParser;
				$clear = false;
				error_log ("parser => wgParser \n", 3, "/tmp/moli.log");
				if ( $wgUser->isAnon() ) {
					$clear = true;
				}
			}
			
			$Options = new ParserOptions( );
			$Options->initialiseFromUser( $wgUser );
*/
			
			/**
			 * if $props are not cache we read them from database
			 */
			$this->getProps();

			$text = $wgOut->parse( $this->mLastRevision->getText() );
/* to remove? 
			$text     = $Parser->parse( $this->mLastRevision->getText(), $this->mTitle, $Options, true, $clear )->getText(); 
*/
			$anchor   = explode( "/", $this->mTitle->getDBkey(), 3 );
			$sig      = ( $this->mUser->isAnon() )
				? wfMsg("blog-comments-anonymous")
				: Xml::element( 'a', array ( "href" => $this->mUser->getUserPage()->getFullUrl() ), $this->mUser->getName() );

			$hidden   = isset( $this->mProps[ "hiddencomm" ] )
				? (bool )$this->mProps[ "hiddencomm" ]
				: false;

			$comments = array(
				"sig"       => $sig,
				"text"      => $text,
				"title"     => $this->mTitle,
				"author"    => $this->mUser,
				"anchor"    => $anchor,
				"avatar"    => BlogAvatar::newFromUser( $this->mUser )->getLinkTag( 50, 50 ),
				"hidden"	=> $hidden,
				"timestamp" => $wgContLang->timeanddate( $this->mFirstRevision->getTimestamp() )
			);

			$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
			$template->set_vars(
				array(
					"comment" => $comments,
					"canToggle" => $this->canToggle(),
					"canDelete" => $canDelete,
				)
			);
			$text = $template->execute( "comment" );
		}

		wfProfileOut( __METHOD__ );

		return $text;
	}

	/**
	 * setProps -- change props for comment article
	 *
	 */
	public function setProps( $props, $update = false ) {
		wfProfileIn( __METHOD__ );

		if( $update ) {
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
		if( ! $this->mProps || ! is_array( $this->mProps ) ) {
			$this->mProps = BlogArticle::getProps( $this->mTitle->getArticleID() );
		}
		return $this->mProps;
	}

	/**
	 * check if current user can toggle show/hide comment
	 *
	 * @access private
	 */
	private function canToggle() {
		global $wgUser, $wgCityId, $wgDevelEnvironment;

		$devel    = $wgCityId == 4832 || $wgDevelEnvironment;
		$isAuthor = $this->mUser->getId() == $wgUser->getId() && ! $wgUser->isAnon();
		$isOwner  = $this->mOwner->getId() == $wgUser->getId();
		$isSysop  = $wgUser->isAllowed( "blog-comments-toggle" );

		return $devel && ( $isOwner || $isSysop );
	}

	/**
	 * toggle -- toggle hidden/show flag
	 *
	 * @access public
	 *
	 * @return Boolean -- new status
	 */
	public function toggle() {
		global $wgUser, $wgMemc;

		wfProfileIn( __METHOD__ );

		$this->load();

		if( $this->canToggle() ) {
			if( isset( $this->mProps["hiddencomm"] ) ) {
				$this->mProps["hiddencomm"] = empty( $this->mProps["hiddencomm"] ) ? 1 : 0;
			}
			else {
				$this->mProps["hiddencomm"] = 1;
			}
			BlogArticle::setProps( $this->mTitle->getArticleID(), $this->mProps );
			$wgMemc->delete( wfMemcKey( "blog", "comm", $this->mTitle->getArticleID() ) );
		}
		wfProfileOut( __METHOD__ );

		return (bool )$this->mProps["hiddencomm"];
	}

	/**
	 * axToggle -- static hook/entry for ajax request post -- toggle visbility
	 * of comment
	 *
	 * @static
	 * @access public
	 *
	 * @return String -- json-ized array
	 */
	static public function axToggle() {
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
		 * toggle
		 */
		$Comment = BlogComment::newFromId( $commentId );
		$status  = $Comment->toggle();
		$text    = $Comment->render();

		/**
		 * clear article/listing cache for this article
		 */
		$Title->invalidateCache();
		$update = SquidUpdate::newSimplePurge( $Title );
		$update->doUpdate();

		return Wikia::json_encode(
			array(
				"id"     => $commentId,
				"error"  => $error,
				"hidden" => $status,
				"text"	 => $text
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
		global $wgRequest, $wgUser;

		$articleId = $wgRequest->getVal( "article", false );

		$Title = Title::newFromID( $articleId );
		if( ! $Title ) {
			Wikia::log( __METHOD__, "error", "Cannot create title" );
			return Wikia::json_encode( array( "error" => 1 ) );
		}

		list( $status, $article ) = self::doPost( $wgRequest, $wgUser, $Title );
		$error  = false;

		switch( $status ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
				$comment = BlogComment::newFromArticle( $article );
				$text = $comment->render();
				$message = false;
				Wikia::log( __METHOD__, "render", $text );
				break;
			default:
				Wikia::log( __METHOD__, "error", "No article created" );
				$text  = false;
				$error = true;
				$message = wfMsg("blog-comment-error");
		}

		return Wikia::json_encode(
			array(
				"msg" => $message,
				"error" => $error,
				"text"  => $text,
			)
		);
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

		global $wgMemc;

		$text = $Request->getText("wpBlogComment", false);
		if( !$text || !strlen( $text ) ) {
			return false;
		}
		wfProfileIn( __METHOD__ );

		/**
		 * title for comment is combination of article title and some "random"
		 * data
		 */
		$commentTitle = Title::newFromText(
			sprintf( "%s/%s-%s", $Title->getText(), $User->getName(), wfTimestampNow() ),
			NS_BLOG_ARTICLE_TALK );

		/**
		 * add article using EditPage class (for hooks)
		 */
		$result   = null;
		$article  = new Article( $commentTitle, 0 );
		$editPage = new EditPage( $article );
		$editPage->textbox1 = $text;
		$editpage->summary  = wfMsg('blog-comments-new');
		$retval = $editPage->internalAttemptSave( $result );
		Wikia::log( __METHOD__, "editpage", "Returned value {$retval}" );

		// $article->doEdit( $text, wfMsg('blog-comments-new') );

		/**
		 * clear comments cache for this article
		 */
		$update = SquidUpdate::newSimplePurge( $Title );
		$update->doUpdate();

		$key = $Title->getBaseText();
		$wgMemc->delete( wfMemcKey( "blog", "listing", $key, 0 ) );
		$wgMemc->delete( wfMemcKey( "blog", "comm", $Title->getArticleID() ) );

		wfProfileOut( __METHOD__ );

		return array( $retval, $article );
	}
}

/**
 * BlogComment is listing, basicly it's array of comments
 */
class BlogCommentList {

	private $mTitle;
	private $mText;
	private $mOwner;
	private $mComments = false;
	private $mProps = false;
	private $mOrder = false;

	static public function newFromTitle( Title $title ) {
		$comments = new BlogCommentList();
		$comments->setTitle( $title );
		$comments->setText( $title->getDBkey( ) );
		return $comments;
	}

	static public function newFromText( $text ) {
		$blogPage = Title::newFromText( $text, NS_BLOG_ARTICLE );
		if( ! $blogPage ) {
			/**
			 * doesn't exist, lame
			 */
			return false;
		}

		$comments = new BlogCommentList();
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
	 * setProps -- set value of page_props for that page, there we store
	 * flags for articles like 'show/hide comments' and 'show/hide voting
	 *
	 * @access public
	 *
	 * @param Array $props - values from page_props table
	 */
	public function setProps( $props ) {
		if( is_array( $props ) ) {
			$this->mProps = $props;
		}
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
	 */
	private function getCommentPages() {
		global $wgRequest, $wgMemc;

		wfProfileIn( __METHOD__ );

		$order  = $wgRequest->getText("order", false );
		$action = $wgRequest->getText( "action", false );

		$this->mOrder = ( $order == "desc" ) ? "desc" : "asc";
		if( $action != "purge" ) {
			$this->mComments = $wgMemc->get( wfMemcKey( "blog", "comm", $this->getTitle()->getArticleId() ) );
		}

		if( ! is_array( $this->mComments ) ) {
			/**
			 * cache it! but with what key?
			 */
			$pages = array();

			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( "page" ),
				array( "page_id" ),
				array(
					"page_namespace" => NS_BLOG_ARTICLE_TALK,
					"page_title LIKE '" . $dbr->escapeLike( $this->mText ) . "/%'"
				),
				__METHOD__,
				array( "ORDER BY" => "page_id {$this->mOrder}" )
			);
			while( $row = $dbr->fetchObject( $res ) ) {
				$pages[ $row->page_id ] = BlogComment::newFromId( $row->page_id );
			}
			$dbr->freeResult( $res );
			$this->mComments = $pages;
			$wgMemc->set( wfMemcKey( "blog", "comm", $this->getTitle()->getArticleId() ), $this->mComments, 3600 );
		}

		wfProfileOut( __METHOD__ );
		return $this->sort();
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

		/**
		 * $pages is array of comment articles
		 */
		$owner     = $this->mTitle->getBaseText();
		$avatar    = BlogAvatar::newFromUser( $wgUser );
		$isSysop   = ( in_array('sysop', $wgUser->getGroups()) || in_array('staff', $wgUser->getGroups() ) );
		$isOwner   = ( $owner == $wgUser->getName() );
		$canEdit   = $wgUser->isAllowed( "edit" );
		$comments  = $this->getCommentPages();
		$canDelete = $wgUser->isAllowed( "delete" );

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );

		$template->set_vars( array(
			"order"     => $this->mOrder,
			"title"     => $wgTitle,
			"props"     => $this->mProps,
			"avatar"    => $avatar,
			"wgUser"    => $wgUser,
			"isSysop"   => $isSysop,
			"isOwner"   => $isOwner,
			"canEdit"   => $canEdit,
			"comments"  => $comments,
			"canDelete" => $canDelete,
		) );

		$text = $template->execute( "comment-list" );

		return $text;
	}
}
