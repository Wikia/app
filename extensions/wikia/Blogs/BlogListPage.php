<?php
/**
 * blog listing for user, something similar to CategoryPage
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension.\n";
    exit( 1 ) ;
}

$wgHooks[ "ArticleFromTitle" ][] = "BlogListPage::hook";

class BlogListPage extends Article {

	/**
	 * overwritten Article::view function
	 */
	public function view() {
		global $wgOut, $wgUser;
		Article::view();
		$this->showBlogListing();
	}

	/**
	 * take data from blog tag extension and display it
	 *
	 * @access private
	 */
	private function showBlogListing() {
		global $wgOut, $wgRequest, $wgParser;

		$params = array(
			"author" => $this->mTitle->getDBkey(),
			"count"  => 50,
			"summary" => true,
			"summarylength" => 750,
			"style" => "plain",
			"title" => "Blogs",
			"timestamp" => true,
			"offset" => 0
		);
		error_log( print_r( $params ) );
		$wgOut->addHTML( BlogTemplateClass::parseTag( "", $params, $wgParser ) );
	}

	/**
	 * static entry point for hook
	 *
	 * @static
	 * @access public
	 */
	static public function hook( &$Title, &$Article ) {
		global $wgRequest;

		/**
		 * we are only interested in User_blog:Username pages
		 */
		if( $Title->getNamespace() !== NS_BLOG_ARTICLE || $Title->isSubpage() ) {
			return true;
		}

		$feed = $wgRequest->getText( "feed", false );
		if( $feed ) {
			/**
			 * return feed for blog
			 */
			error_log( __METHOD__. "-feed" );
		}
		else {
			/**
			 * return article for blog
			 */
			error_log( __METHOD__. "-article" );
			$Article = new BlogListPage( $Title );
		}
		return true;
	}

}
