<?php

/**
 * parser tag for Comments all comments for article
 */

global $wgAjaxExportList;
$wgAjaxExportList[] = "BlogComments::axPost";


# Define a setup function
$wgExtensionFunctions[] = 'efBlogCommentsTag_Setup';
# Add a hook to initialise the magic word
$wgHooks[ "LanguageGetMagic" ][] = 'efBlogCommentsTag_Magic';
$wgHooks[ "CategoryViewer::addPage" ][] = "BlogComments::addCategoryPage";
$wgHooks[ "CategoryViewer::getOtherSection" ][] = "BlogComments::getOtherSection";


function efBlogCommentsTag_Setup() {
	global $wgParser;
	# Set a function hook associating the "example" magic word with our function
	$wgParser->setFunctionHook( 'bloglistcomments', 'efBlogCommentsTag_Render' );
}

function efBlogCommentsTag_Magic( &$magicWords, $langCode ) {
	# Add the magic word
	# The first array element is case sensitive, in this case it is not case sensitive
	# All remaining elements are synonyms for our parser function
	$magicWords['bloglistcomments'] = array( 0, 'bloglistcomments' );
	# unless we return true, other parser functions extensions won't get loaded.
	return true;
}

function efBlogCommentsTag_Render( &$parser ) {
	global $wgTitle;

	/**
	 * for local usage/testing switch off caching
	 */
	$parser->disableCache();
	$args = array_shift( func_get_args() );

	$page = BlogComments::newFromTitle( $wgTitle );

    return $page->render();
}

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
			foreach( $pages as $page ) {
				/**
				 * page is Title object
				 */
				$revision = Revision::newFromTitle( $page );

				$comments[] = array(
					"comment" => $revision,
					"autor" => User::newFromId( $revision->getUser() ),
					"timestamp" => $wgContLang->timeanddate( $revision->getTimestamp() )
				);
			}
			$template->set_vars( array( "comments" => $comments, "input" => $input ) );
		}

		/**
		 * it's preparsed wikitext, we have to parse it to HTML
		 */
		$parser = new Parser();
		$text = $template->execute( "comment" );
		$options = new ParserOptions();
		$options->initialiseFromUser( $wgUser );

		return $parser->parse( $text, $wgTitle, $options )->getText();
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

	}

	/**
	 * doPost -- static hook/entry for normal request post
	 */
	static public function doPost( &$Request, &$User, &$Title ) {
		if( !$Request->getText( "wpBlogSubmit", false ) ) {
			return;
		}
//		print_pre( $Request );

		$text = $Request->getText("wpBlogComment", false);
		if( !$text || !strlen( $text ) ) {
			return;
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
		$article->doEdit( $text, "added new comment" );

		/**
		 * clear comments cache for this article
		 */
	}
}
