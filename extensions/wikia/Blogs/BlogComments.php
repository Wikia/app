<?php

/**
 * parser tag for Comments all comments for article
 */

global $wgAjaxExportList;
$wgAjaxExportList[] = "BlogComments::axPost";
$wgAjaxExportList[] = "BlogComments::axHide";

class BlogComments {

	private $mTitle;
	private $mText;
	private $mOwner;
	private $mComments = false;
	private $mProps = false;
	private $mOrder = false;

	static public function newFromTitle( Title $title ) {
		$comments = new BlogComments();
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

		$comments = new BlogComments();
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

		/**
		 * action "purge" beats cache
		 */
		if( $action != "purge" ) {
			/**
			 * maybe already loaded
			 */
			if( is_array( $this->mComments ) ) {
				/**
				 * sort properly result
				 */
				wfProfileOut( __METHOD__ );
				return $this->sort();
			}

			$this->mComments = $wgMemc->get( wfMemcKey( "blog", "comm", $this->getTitle()->getArticleId() ) );
			if( is_array( $this->mComments ) ) {
				wfProfileOut( __METHOD__ );
				return $this->sort();
			}
		}

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
			$pages[ $row->page_id ] = Title::newFromId( $row->page_id );
		}

		$dbr->freeResult( $res );

		$this->mComments = $pages;
		$wgMemc->set( wfMemcKey( "blog", "comm", $this->getTitle()->getArticleId() ), $pages, 3600 );

		wfProfileOut( __METHOD__ );

		return $this->mComments;
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
	 * @param Boolean $input -- show/hide input for adding comments default false
	 *
	 * @return String HTML text with rendered comments section
	 */
	public function render( $input = false ) {
		global $wgContLang, $wgUser, $wgTitle;

		/**
		 * $pages is array of comment titles
		 */
		$owner     = $this->mTitle->getBaseText();
		$pages     = $this->getCommentPages();
		$avatar    = BlogAvatar::newFromUser( $wgUser );
		$isSysop   = ( in_array('sysop', $wgUser->getGroups()) || in_array('staff', $wgUser->getGroups() ) );
		$isOwner   = ( $owner == $wgUser->getName() );
		$canEdit   = $wgUser->isAllowed( "edit" );
		$canDelete = $wgUser->isAllowed( "delete" );

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );

		if( ! count( $pages ) ) {
			/**
			 * no comments at all
			 */
			$template->set_vars( array(
				"input"     => $input,
				"props"     => $this->mProps,
				"avatar"    => $avatar,
				"title"     => $wgTitle,
				"isSysop"   => $isSysop,
				"isOwner"   => $isOwner,
				"canEdit"   => $canEdit,
				"comments"  => false,
				"canDelete" => $canDelete,
			));
		}
		else {
			$parser = new Parser();
			$options = new ParserOptions();
			$options->initialiseFromUser( $wgUser );

			foreach( $pages as $page ) {
				/**
				 * page is Title object
				 */
				$revision = Revision::newFromTitle( $page );
				/**
				 * it's preparsed wikitext, we have to parse it to HTML
				 */
				$text     = $parser->parse( $revision->getText(), $page, $options )->getText();
				$author   = User::newFromId( $revision->getUser() );
				$sig      = ( $author->isAnon() )
					? wfMsg("blog-comments-anonymous")
					: Xml::element( 'a', array ( "href" => $author->getUserPage()->getFullUrl() ), $author->getName() );

				$anchor   = explode( "/", $page->getDBkey(), 3 );

				$comments[ $revision->getTimestamp() ] = array(
					"sig"       => $sig,
					"text"      => $text,
					"title"     => $page,
					"author"    => $author,
					"anchor"    => $anchor,
					"avatar"    => BlogAvatar::newFromUser( $author )->getLinkTag( 50, 50 ),
					"timestamp" => $wgContLang->timeanddate( $revision->getTimestamp() )
				);
			}

			$template->set_vars( array(
				"order"     => $this->mOrder,
				"input"     => $input,
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
		}

		$text = $template->execute( "comment" );

		return $text;
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
		global $wgRequest, $wgUser, $wgTitle, $wgContLang;
		$article = self::doPost( $wgRequest, $wgUser, $wgTitle );
		if( !$article ) {
			Wikia::log( __METHOD__, "error", "No article created" );
			return Wikia::json_encode(
				array( "msg" => wfMsg("blog-comment-error"), "error" => 1 )
			);
		}

		/**
		 * parse text from returned article
		 */
		$parser  = new Parser();
		$options = new ParserOptions();
		$options->initialiseFromUser( $wgUser );

		$text     = $parser->parse( $article->getContent(), $wgTitle, $options )->getText();
		$anchor   = explode( "/", $article->getTitle()->getDBkey(), 3 );
		$sig      = ( $wgUser->isAnon() )
			? wfMsg("blog-comments-anonymous")
			: Xml::element( 'a', array ( "href" => $wgUser->getUserPage()->getFullUrl() ), $wgUser->getName() );

		$comments = array(
				"sig"       => $sig,
				"text"      => $text,
				"title"     => $article->getTitle(),
				"author"    => $article->getUser(),
				"anchor"    => $anchor,
				"avatar"    => BlogAvatar::newFromUser( $wgUser )->getLinkTag( 50, 50 ),
				"timestamp" => $wgContLang->timeanddate( $article->getTimestamp() )
		);

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$template->set_vars( array( "single" => true, "comment" => $comments ));
		$text = $template->execute( "comment" );

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
		$updateTitle = Title::newFromText( $Title->getText(), NS_BLOG_ARTICLE );
		$update = SquidUpdate::newSimplePurge( $updateTitle );
		$update->doUpdate();

		$key = $Title->getBaseText();
		$wgMemc->delete( wfMemcKey( "blog", "listing", $key, 0 ) );
		$wgMemc->delete( wfMemcKey( "blog", "comm", $updateTitle->getArticleID() ) );

		wfProfileOut( __METHOD__ );

		return $article;
	}

	/**
	 * axPost -- static hook/entry for ajax request post
	 *
	 * @static
	 * @access public
	 *
	 * @return String -- json-ized array
	 */
	static public function axHide() {
		global $wgRequest, $wgUser, $wgTitle;

		$commentId = $wgRequest->getVal( "id", false );
		$props = BlogListPage::getProps( $commentId );
		if( isset( $props["hiddencomm"] ) ) {
			$hiddencomm = empty( $props["hiddencomm"] ) ? 1 : 0;
		}
		else {
			$hiddencomm = 1;
		}
		return Wikia::json_encode(
			array( "id" => $commentId )
		);
	}
}
