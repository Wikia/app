<?php

/**
 * parser tag for Comments all comments for article
 */

global $wgAjaxExportList;
$wgAjaxExportList[] = "BlogComments::axPost";

class BlogComments {

	private $mText;
	private $mOwner;
	private $mComments = false;
	private $mProps = false;
	private $mOrder = false;

	static public function newFromTitle( Title $title ) {
		$comments = new BlogComments();
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
		return $comments;
	}

	public function setText( $text ) {
		$this->mText = $text;
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
	 * getCommentPages -- take pages connected to comments list
	 */
	private function getCommentPages() {
		global $wgRequest;

		$order = $wgRequest->getText("order", false );
		$this->mOrder = ( $order == "desc" ) ? "desc" : "asc";

		if( is_array( $this->mComments ) ) {
			return $this->mComments;
		}
		wfProfileIn( __METHOD__ );

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
			array( "ORDER BY" => "page_touched {$this->mOrder}" )
		);
		while( $row = $dbr->fetchObject( $res ) ) {
			$pages[] = Title::newFromId( $row->page_id );
		}

		$dbr->freeResult( $res );
		$this->mComments = $pages;

		wfProfileOut( __METHOD__ );

		return $this->mComments;
	}

	/**
	 * count -- just return number of comments
	 *
	 * @return integer
	 */
	public function count() {
		$this->getCommentPages();
		if( is_array( $this->mComments ) ) {
			return count( $this->mComments );
		}

		return 0;
	}

	/**
	 * render - return HTML code for displaying comments
	 *
	 * @param Boolean $input -- show/hide input for adding comments default false
	 *
	 */
	public function render( $input = false ) {
		global $wgContLang, $wgUser, $wgTitle;

		/**
		 * get properties for page (ie. we show input comments)
		 */

		/**
		 * $pages is array of comment titles
		 */
		$pages = $this->getCommentPages();
		$avatar = BlogAvatar::newFromUser( $wgUser );

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );

		if( ! count( $pages ) ) {
			/**
			 * no comments at all
			 */
			$template->set_vars( array(
				"comments" => false,
				"input" => $input,
				"props" => $this->mProps,
				"avatar" => $avatar,
				"title"   => $wgTitle
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
				"order"    => $this->mOrder,
				"input"    => $input,
				"title"    => $wgTitle,
				"props"    => $this->mProps,
				"avatar"   => $avatar,
				"wgUser"   => $wgUser,
				"comments" => $comments,
			) );
		}

		$text = $template->execute( "comment" );

		return $text;
	}


	/**
	 * axPost -- static hook/entry for ajax request post
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
		$parser = new Parser();
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
	 */
	static public function doPost( &$Request, &$User, &$Title ) {

		global $wgMemc;

		$text = $Request->getText("wpBlogComment", false);
		if( !$text || !strlen( $text ) ) {
			return false;
		}

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
		$updateTitle = Title::newFromText( $commentTitleText, NS_BLOG_ARTICLE );
		$update = SquidUpdate::newSimplePurge( $updateTitle );
		$update->doUpdate();

		$key = $Title->getBaseText();
		$wgMemc->delete( wfMemcKey( "blog", "listing", $key, 0 ) );
		return $article;
	}
}
