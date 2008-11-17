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
		global $wgOut, $wgRequest;
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

		$feed = $wgRequest->getText( "feed" );
		if( isset( $feed ) ) {
			/**
			 * return feed for blog
			 */
		}
		else {
			/**
			 * return article for blog
			 */
			$Article = new BlogListPage( $Title );
		}
		return true;
	}

}
