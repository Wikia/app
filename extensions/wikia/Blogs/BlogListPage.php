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

$wgHooks[ "ArticleFromTitle" ][] = "BlogListPage::ArticleFromTitle";

class BlogListPage extends Article {

	/**
	 * overwritten Article::view function
	 */
	public function view() {
		global $wgOut, $wgUser, $wgRequest, $wgTitle, $wgContLang;

		$feed = $wgRequest->getText( "feed", false );
		if( $feed && in_array( $feed, array( "rss", "atom" ) ) ) {
			$this->showFeed( $feed );
		}
		elseif ( $wgTitle->isSubpage() ) {
			/**
			 * blog article
			 */
			$oldPrefixedText = $this->mTitle->mPrefixedText;
			list( $author, $prefixedText )  = explode('/', $this->mTitle->mPrefixedText, 2);
			if( isset( $prefixedText ) && !empty( $prefixedText ) ) {
				$this->mTitle->mPrefixedText = $prefixedText;
			}
			Article::view();
			$this->mTitle->mPrefixedText = $oldPrefixedText;

			if( 1 ) {
				$pageid = $this->getLatest();
				$FauxRequest = new FauxRequest( array(
					"action" => "query",
					"list" => "wkvoteart",
					"wkpage" => $this->getLatest(),
					"wkuservote" => true
				));
				$oApi = new ApiMain( $FauxRequest );
				$oApi->execute();
				$aResult = $oApi->GetResultData();

				if( count($aResult['query']['wkvoteart']) > 0 ) {
					if(!empty($aResult['query']['wkvoteart'][ $pageid ]['uservote'])) {
						$voted = true;
					}
					else {
						$voted = false;
					}
					$rating = $aResult['query']['wkvoteart'][ $pageid ]['votesavg'];
				}
				else {
					$voted = false;
					$rating = 0;
				}

				$hidden_star = $voted ? ' style="display: none;"' : '';
				$rating = round($rating * 2)/2;
				$ratingPx = round($rating * 17);
			}
			$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
			$tmpl->set_vars( array(
				"voted" => $voted,
				"rating" => $rating,
				"hidden_star" => $hidden_star,
				"ratingPx" => $ratingPx,
				"edited" => $wgContLang->timeanddate( $this->getTimestamp() )
			) );
			$wgOut->addHTML( $tmpl->execute("footer") );
			$this->showBlogComments();
		}
		else {
			/**
			 * blog listing
			 */
			Article::view();
			$this->showBlogListing();
		}
	}

	/**
	 * display comments connected with article
	 *
	 * @access private
	 */
	private function showBlogComments() {
		global $wgOut;
		
		$page = BlogComments::newFromTitle( $this->mTitle );
	    $wgOut->addHTML( $page->render() );

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
		$user    = $this->mTitle->getDBkey();
		$listing = false;
		$purge   = $wgRequest->getVal( 'action' ) == 'purge';
		$offset  = 0;

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

		$user    = $this->mTitle->getDBkey();
		$listing = false;
		$purge   = $wgRequest->getVal( 'action' ) == 'purge';
		$offset  = 0;

		wfProfileIn( __METHOD__ );

		if( !$purge ) {
			$listing  = $wgMemc->get( wfMemcKey( "blog", "feed", $user, $offset ) );
		}

		if ( $listing ) {
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
			$wgMemc->set( wfMemcKey( "blog", "feed", $user, $offset ), $listing, 3600 );

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
	static public function ArticleFromTitle( &$Title, &$Article ) {
		global $wgRequest;

		if( $Title->getNamespace() !== NS_BLOG_ARTICLE ) {
			return true;
		}

		$Article = new BlogListPage( $Title );

		return true;
	}

	/**
	 * save article extra properties to page_props table
	 *
	 * @access public
	 * @param array $aPropsArray array of properties to save (prop name => prop value)
	 */
	public function saveProps(Array $aPropsArray) {
		$dbw = wfGetDB( DB_MASTER );
		foreach( $aPropsArray as $sPropName => $sPropValue) {
			$dbw->replace(
				"page_props",
				array(
					"pp_page",
					"pp_propname"
				),
				array(
					"pp_page" => $this->getID(),
					"pp_propname" => $sPropName,
					"pp_value" => $sPropValue
				),
				__METHOD__
			);
		}
	}
}
