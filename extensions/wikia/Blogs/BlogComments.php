<?php

/**
 * parser tag for Comments all comments for article
 */

global $wgAjaxExportList;
$wgAjaxExportList[] = "BlogComments::axPost";

class BlogComments {

	private $mText;
	private $mComments = false;

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

		/**
		 * get talk page for this article
		 */
		$comments = new BlogComments();
		$comments->setText( $blogPage->getDBkey() );
		return $comments;
	}

	public function setText( $text ) {
		$this->mText = $text;
	}

	/**
	 * showInput -- show textarea for adding comments
	 *
	 * @param string $position -- top or bottom
	 *
	 * @access public
	 */
	public function showInput( $position ) {
		global $wgUser;

		wfProfileIn( __METHOD__ );

		$Avatar = BlogAvatar::newFromUser( $wgUser );
//		print_pre( $Avatar );
		$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$tmpl->set_vars(
			array( "position" => $position, "author" => $wgUser, "avatar" => $Avatar )
		);

		wfProfileOut( __METHOD__ );

		return  $tmpl->execute("comment-post");
	}

	/**
	 * getCommentPages -- take pages connected to comments list
	 */
	private function getCommentPages() {

		if( is_array( $this->mComments ) ) {
			return $this->mComments;
		}
		wfProfileIn( __METHOD__ );
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
			array( "ORDER BY" => "page_touched" )
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
		 * $pages is array of comment titles
		 */
		$pages = $this->getCommentPages();

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );

		if( ! count( $pages ) ) {
			/**
			 * no comments at all
			 */
			$template->set_vars( array( "comments" => false, "input" => $input ) );
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
				$sig      = Xml::element( 'a', array ( "href" => $author->getUserPage()->getFullUrl() ), $author->getName() );

				$comments[] = array(
					"sig"       => $sig,
					"text"      => $text,
					"title"     => $page,
					"author"    => $author,
					"avatar"    => BlogAvatar::newFromUser( $author )->getImageTag( 50, 50 ),
					"timestamp" => $wgContLang->timeanddate( $revision->getTimestamp() )
				);
			}
			$template->set_vars( array( "comments" => $comments, "input" => $input, "list" => true ) );
		}

		$text = $template->execute( "comment" );

		return $text;
	}

	/**
	 * static methods used in Hooks
	 */

	static public function getOtherSection( &$catView, &$output ) {
		if( !isset( $catView->blogs ) ) {
			return true;
		}
		$ti = htmlspecialchars( $catView->title->getText() );
		$r = '';
		$cat = $catView->getCat();

		$dbcnt = $cat->getPageCount() - $cat->getSubcatCount() - $cat->getFileCount();
		$rescnt = count( $catView->blogs );
		#	$countmsg = $catView->getCountMessage( $rescnt, $dbcnt, 'article' );

		if( $rescnt > 0 ) {
			$r = "<div id=\"mw-pages\">\n";
			$r .= '<h2>' . wfMsg( "blog-header", $ti ) . "</h2>\n";
			#	$r .= $countmsg;
			$r .= $catView->formatList( $catView->blogs, $catView->blogs_start_char );
			$r .= "\n</div>";
		}
		$output = $r;

		return true;
	}

	/**
	 * Hook
	 */
	static public function addCategoryPage( &$catView, &$title, &$row ) {
		global $wgContLang;

		if( $row->page_namespace == NS_BLOG_ARTICLE ) {
			/**
			 * initialize CategoryView->blogs array
			 */
			if( !isset( $catView->blogs ) ) {
				$catView->blogs = array();
			}

			/**
			 * initialize CategoryView->blogs_start_char array
			 */
			if( !isset( $catView->blogs_start_char ) ) {
				$catView->blogs_start_char = array();
			}

			$catView->blogs[] = $row->page_is_redirect
				? '<span class="redirect-in-category">' . $catView->getSkin()->makeKnownLinkObj( $title ) . '</span>'
				: $catView->getSkin()->makeSizeLinkObj( $row->page_len, $title );

			list( $namespace, $title ) = explode( ":", $row->cl_sortkey, 2 );
			$catView->blogs_start_char[] = $wgContLang->convert( $wgContLang->firstChar( $title ) );

			/**
			 * when we return false it won't be displayed as normal category but
			 * in "other" categories
			 */
			return false;
		}
		return true;
	}

	/**
	 * axPost -- static hook/entry for ajax request post
	 */
	static public function axPost() {
		global $wgRequest, $wgUser, $wgTitle;
		$article = self::doPost( $wgRequest, $wgUser, $wgTitle );
		if( !$article ) {
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

		$text = $parser->parse( $article->getContent(), $wgTitle, $options )->getText();
		// we probably should return whole rendered html

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
		if( !$Request->getText( "wpBlogSubmit", false ) ) {
			return;
		}

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
		return $article;
	}
}
