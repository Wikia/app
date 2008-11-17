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
		global $wgOut, $wgUser, $wgRequest;

		$feed = $wgRequest->getText( "feed", false );
		if( $feed && in_array( $feed, array( "rss", "atom" ) ) ) {
			$this->showFeed( $feed );
		}
		else {
			Article::view();
			$this->showBlogListing();
		}
	}

	/**
	 * take data from blog tag extension and display it
	 *
	 * @access private
	 */
	private function showBlogListing() {
		global $wgOut, $wgRequest, $wgParser, $wgMemc;

		/**
		 * use cache or skip cache when action=purge
		 */
		$user = $this->mTitle->getDBkey();
		$listing = false;
		$purge = $wgRequest->getVal( 'action' ) == 'purge';
		$offset = 0;

		if( !$purge ) {
			$listing  = $wgMemc->get( wfMemcKey( "blog", "listing", $user, $offset ) );
		}

		if( !$listing ) {
			$params = array(
				"author" => $user,
				"count"  => 50,
				"summary" => true,
				"summarylength" => 750,
				"style" => "plain",
				"title" => "Blogs",
				"timestamp" => true,
				"offset" => $offset
			);
			$listing = BlogTemplateClass::parseTag( "<author>$user</author>", $params, $wgParser );
			$wgMemc->set( wfMemcKey( "blog", "listing", $user, $offset ), $listing, 3600 );
		}
		$wgOut->addHTML( $listing );
	}

	/**
	 * generate xml feed from returned data
	 */
	private function showFeed( $format ) {
		global $wgOut, $wgRequest, $wgParser, $wgMemc, $wgFeedClasses, $wgTitle;

		$offset = 0;
		$user = $this->mTitle->getDBkey();

		wfProfileIn( __METHOD__ );
		if (1) {
			$params = array(
				"count"  => 50,
				"summary" => true,
				"summarylength" => 750,
				"style" => "array",
				"title" => "Blogs",
				"timestamp" => true,
				"offset" => $offset
			);
			$listing = BlogTemplateClass::parseTag( "<author>$user</author>", $params, $wgParser );

			$feed = new $wgFeedClasses[ $format ](
				"Test title", "Test description", $wgTitle->getFullUrl() );

			$feed->outHeader();
			if( is_array( $listing ) ) {
				foreach( $listing as $item ) {
					$title = Title::newFromText( $item["title"], NS_BLOG_ARTICLE );
					$item = new FeedItem(
						$title->getPrefixedText(),
						$item["description"],
						$item["url"],
						$item["timestamp"],
						$item["author"]
					);
					$feed->outItem( $item );
				}
			}
			$feed->outFooter();
		}
		wfProfileOut( __METHOD__ );
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

		Wikia::log( __METHOD__, "article" );
		$Article = new BlogListPage( $Title );

		return true;
	}

}
