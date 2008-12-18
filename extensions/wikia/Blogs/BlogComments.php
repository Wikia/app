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
		$mRevision,
		$mUser,	 ### comment creator
		$mOwner; ### owner of blog

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
		if( $this->mTitle ) {
			$this->mRevision = Revision::newFromTitle( $this->mTitle );
			if( $this->mRevision ) {
				$this->mUser = User::newFromId( $this->mRevision->getUser() );
			}
			$this->getProps();
			/**
			 * set blog owner
			 */
			$owner = BlogListPage::getOwner( $this->mTitle );
			$this->mOwner = User::newFromName( $owner );
		}
	}

	/**
	 * getTitle -- getter/accessor
	 *
	 */
	public function getTitle() {
		return $this->mTitle;
	}

	/**
	 * isDeleted -- checks (of course) is deleted
	 *
	 * @access public
	 */
	public function isDeleted() {
		$this->load();
		if( $this->mRevision ) {
			$deleted = $this->mRevision->isDeleted( Revision::DELETED_TEXT );
		}
		else {
			$deleted = true;
		}

		return $deleted;
	}

	/**
	 * render -- generate HTML for displaying comment
	 *
	 * @return String -- generated HTML text
	 */
	public function render() {
		global $wgContLang, $wgUser, $wgCityId, $wgDevelEnvironment;

		wfProfileIn( __METHOD__ );

		$text = false;
		if( !$this->isDeleted() ) {
			$canDelete = $wgUser->isAllowed( "delete" );

			$Parser  = new Parser( );
			$Options = new ParserOptions( );
			$Options->initialiseFromUser( $this->mUser );

			/**
			 * if $props are not cache we read them from database
			 */
			$this->getProps();

			$text     = $Parser->parse( $this->mRevision->getText(), $this->mTitle, $Options )->getText();
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
				"timestamp" => $wgContLang->timeanddate( $this->mRevision->getTimestamp() )
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
			BlogListPage::saveProps( $this->mTitle->getArticleID(), $props );
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
			$this->mProps = BlogListPage::getProps( $this->mTitle->getArticleID() );
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
		$isSysop  = ( in_array('sysop', $wgUser->getGroups()) || in_array('staff', $wgUser->getGroups() ) );

		return $devel && ($isAuthor || $isOwner || $isSysop );
	}

	/**
	 * toggle -- toggle hidden/show flag
	 *
	 * @access public
	 *
	 * @return Boolean -- new status
	 */
	public function toggle() {
		global $wgUser;

		wfProfileIn( __METHOD__ );

		$this->load();

		if( $this->canToggle() ) {
			if( isset( $this->mProps["hiddencomm"] ) ) {
				$this->mProps["hiddencomm"] = empty( $this->mProps["hiddencomm"] ) ? 1 : 0;
			}
			else {
				$this->mProps["hiddencomm"] = 1;
			}
			BlogListPage::saveProps( $this->mTitle->getArticleID(), $this->mProps );
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

		$article = self::doPost( $wgRequest, $wgUser, $Title );
		if( !$article ) {
			Wikia::log( __METHOD__, "error", "No article created" );
			return Wikia::json_encode(
				array( "msg" => wfMsg("blog-comment-error"), "error" => 1 )
			);
		}

		$comment = BlogComment::newFromArticle( $article );
		$text = $comment->render();

		return Wikia::json_encode(
			array(
				"msg" => wfMsg("blog-comment-error"),
				"error" => 0,
				"text" => $text,
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
		$commentTitleText = sprintf( "%s/%s-%s", $Title->getText(), $User->getName(), wfTimestampNow() );
		$commentTitle = Title::newFromText( $commentTitleText, NS_BLOG_ARTICLE_TALK );

		/**
		 * add article
		 */
		$article = new Article( $commentTitle, 0 );
		$article->doEdit( $text, "New comment in blog" );

		/**
		 * clear comments cache for this article
		 */
		$update = SquidUpdate::newSimplePurge( $Title );
		$update->doUpdate();

		$key = $Title->getBaseText();
		$wgMemc->delete( wfMemcKey( "blog", "listing", $key, 0 ) );
		$wgMemc->delete( wfMemcKey( "blog", "comm", $Title->getArticleID() ) );

		wfProfileOut( __METHOD__ );

		return $article;
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
