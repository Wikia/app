<?php

/**
 * parser tag for Comments all comments for article
 */

# Define a setup function
$wgExtensionFunctions[] = 'efBlogCommentsTag_Setup';
# Add a hook to initialise the magic word
$wgHooks[ "LanguageGetMagic" ][] = 'efBlogCommentsTag_Magic';
$wgHooks[ "ArticleFromTitle" ][] = "efBlogCommentsArticleFromTitle";

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

function efBlogCommentsArticleFromTitle( &$title, &$article ) {

	/**
	 * check if namespaces we care
	 */
	if( ! in_array( $title->getNamespace(), array( NS_BLOG_ARTICLE_TALK )  ) ){
		return true;
	}

	/**
	 * check if title is subpage, if it is subpage do nothing so far
	 */
	if( !$title->isSubpage() ) {
		return true;
	}

	/**
	 * check if article exists
	 */


	/**
	 * ... and eventually
	 */
	return true;
}


class BlogComments {

	private $mText;

	static public function newFromTitle( Title $title ) {
		$comments = new BlogComments();
		$comments->setText( $title->getDBkey( ) );
		return $comments;
	}

	static public function newFromBlogPage( $text ) {
		$blogPage = Title::newFromText( $text, NS_BLOG_ARTICLE );
		if( ! $blogPage ) {
			/**
			 * doesn't exist, lame
			 */
		}

		/**
		 * get talk page for this article
		 */
		$talkPage = $blogPage->getTalkPage();
	}

	public function setText( $text ) {
		$this->mText = $text;
	}

	private function getCommentPages() {
		/**
		 * from Title::hasSubpages
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
			array( "ORDER BY" => "page_touched" )
		);
		while( $row = $dbr->fetchObject( $res ) ) {
			$pages[] = Title::newFromId( $row->page_id );
		}

		$dbr->freeResult( $res );

		return $pages;
	}

	public function render() {

		$pages = $this->getCommentPages();
		/**
		 * $pages is array of comment titles
		 */
		if( ! count( $pages ) ) {
			/**
			 * no comments at all
			 */
			return wfMsg( "blog-zero-comments" );
		}
		else {
			$output = "";
			$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
			foreach( $pages as $page ) {
				/**
				 * page is Title object
				 */
				$comment = new Article( $page, 0 );
				$template->set_vars(
					array(
						"article" => $comment
					),
					true /** refresh **/
				);
				$output = $template->execute( "comment" );
			}
		}
	}
}
