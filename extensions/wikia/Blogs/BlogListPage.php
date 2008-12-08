<?php
/**
 * blog listing for user, something similar to CategoryPage
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 * @author Adrtian Wieczorek <adi@wkia-inc.com>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension.\n";
	exit( 1 ) ;
}

$wgHooks[ "ArticleFromTitle" ][] = "BlogListPage::ArticleFromTitle";
$wgHooks[ "CategoryViewer::getOtherSection" ][] = "BlogListPage::getOtherSection";
$wgHooks[ "CategoryViewer::addPage" ][] = "BlogListPage::addCategoryPage";
$wgHooks[ "SkinTemplateTabs" ][] = "BlogListPage::skinTemplateTabs";
$wgHooks[ "EditPage::showEditForm:checkboxes" ][] = "BlogListPage::editPageCheckboxes";
$wgHooks[ "LinksUpdate" ][] = "BlogListPage::linksUpdate";

class BlogListPage extends Article {

	public $mProps;

	/**
	 * how many entries on listing
	 */
	private $mCount = 5;

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

			$this->mProps = self::getProps( $this->mTitle->getArticleID() );
			$templateParams = array();

			if( isset( $this->mProps[ "voting" ] ) && $this->mProps[ "voting" ] == 1 ) {
				$pageid = $this->mTitle->getArticleID();
				$FauxRequest = new FauxRequest( array(
					"action" => "query",
					"list" => "wkvoteart",
					"wkpage" => $pageid,
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
				$templateParams = $templateParams + array(
					"voted"          => $voted,
					"rating"         => $rating,
					"ratingPx"       => $ratingPx,
					"hidden_star"    => $hidden_star,
					"voting_enabled" => true,
				);
			}
			else {
				$templateParams[ "voting_enabled" ] = false;
			}
			$templateParams[ "edited" ] = $wgContLang->timeanddate( $this->getTimestamp() );

			$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
			$tmpl->set_vars( $templateParams );
			$wgOut->addHTML( $tmpl->execute( "footer" ) );

			/**
			 * check if something was posted, maybe comment with ajax switched
			 * off so it wend to $wgRequest
			 */
			if( $wgRequest->wasPosted() ) {
				BlogComments::doPost( $wgRequest, $wgUser, $wgTitle );
			}

			/**
			 * show comments for this article (if exists) or info otherwise
			 */
			if( $this->exists() ) {
				$this->showBlogComments();
			}
		}
		else {
			/**
			 * blog listing
			 */
			if( $this->exists() ) {
				Article::view();
			}
			else {
				$wgOut->setArticleFlag( true );
				$wgOut->setPageTitle( $this->mTitle->getPrefixedText() );
				$wgOut->addHTML( wfMsg("blog-listing-zero-other") );
			}
			$this->showBlogListing();
		}
	}

	/**
	 * display comments connected with article
	 *
	 * @access private
	 */
	private function showBlogComments() {
		global $wgOut, $wgJsMimeType, $wgExtensionsPath, $wgMergeStyleVersionJS;

		wfProfileIn( __METHOD__ );

		$rand = $wgMergeStyleVersionJS;
		$page = BlogComments::newFromTitle( $this->mTitle );
		$page->setProps( $this->mProps );

		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/Blogs/js/Blogs.js?{$rand}\" ></script>" );
	    $wgOut->addHTML( $page->render( true ) );

		wfProfileOut( __METHOD__ );
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
		$user    = $this->mTitle->getBaseText();
		$listing = false;
		$purge   = $wgRequest->getVal( "action" ) == 'purge';
		$page    = $wgRequest->getVal( "page", 0 );
		$offset  = $page * 5;

		$wgOut->setSyndicated( true );

		if( !$purge ) {
			$listing  = $wgMemc->get( wfMemcKey( "blog", "listing", $user, $page ) );
		}

		if( !$listing ) {
			$params = array(
				"author" => $user,
				"count"  => $this->mCount,
				"summary" => true,
				"summarylength" => 750,
				"type" => "plain",
				"title" => "Blogs",
				"timestamp" => true,
				"offset" => $offset
			);
			$listing = BlogTemplateClass::parseTag( "<author>$user</author>", $params, $wgParser );
			$wgMemc->set( wfMemcKey( "blog", "listing", $user, $offset ), $page, 3600 );
		}

		$wgOut->addScript (
			$this->__makefeedLink( 'rss', 'application/rss+xml' ) .
			$this->__makefeedLink( 'atom', 'application/atom+xml' )
		);

		$wgOut->addHTML( $listing );
	}


	/**
	 * clear data from memcache
	 *
	 * @access public
	 */
	public function clearBlogListing() {
		global $wgRequest, $wgMemc;

		$user = $this->mTitle->getBaseText();
		foreach( range(0, 5) as $page ) {
			$wgMemc->delete( wfMemcKey( "blog", "listing", $user, $page ) );
		}
		$this->doPurge();
	}

	/**
	 * generate xml feed from returned data
	 */
	private function showFeed( $format ) {
		global $wgOut, $wgRequest, $wgParser, $wgMemc, $wgFeedClasses, $wgTitle;

		$user    = $this->mTitle->getBaseText();
		$listing = false;
		$purge   = $wgRequest->getVal( 'action' ) == 'purge';
		$offset  = 0;

		wfProfileIn( __METHOD__ );

		if( !$purge ) {
			$listing  = $wgMemc->get( wfMemcKey( "blog", "feed", $user, $offset ) );
		}

		if ( !$listing ) {
			$params = array(
				"count"  => 50,
				"summary" => true,
				"summarylength" => 750,
				"type" => "array",
				"title" => "Blogs",
				"timestamp" => true,
				"offset" => $offset
			);

			$listing = BlogTemplateClass::parseTag( "<author>$user</author>", $params, $wgParser );
			$wgMemc->set( wfMemcKey( "blog", "feed", $user, $offset ), $listing, 3600 );
		}

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

		wfProfileOut( __METHOD__ );
	}

	/**
	 * private function
	 *
	 * @access private
	 */
	private function __makefeedLink( $type, $mime ) {
		return wfElement( 'link', array(
			'rel' => 'alternate',
			'type' => $mime,
			'href' => $this->mTitle->getLocalUrl( "feed={$type}" ) )
		);
	}

	/**
	 * static entry point for hook
	 *
	 * @static
	 * @access public
	 */
	static public function ArticleFromTitle( &$Title, &$Article ) {
		global $wgRequest;

		if( $Title->getNamespace() === NS_BLOG_ARTICLE_TALK ) {
			/**
			 * redirect to proper comment in NS_BLOG_ARTICLE namespace
			 */
			global $wgRequest, $wgTitle, $wgOut;
			$redirect = $wgRequest->getText( "redirect", false );
			if( $redirect != "no" ) {
				$text = $wgTitle->getText();
				list( $user, $title, $anchor ) = explode( "/", $text, 3 );
				$redirect = Title::newFromText( "{$user}/{$title}", NS_BLOG_ARTICLE );
				if( $title ) {
					$url = $redirect->getFullUrl();
					$wgOut->redirect( "{$url}#{$anchor}" );
				}
			}
			return true;
		}

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
	 * @static
	 *
	 * @param array $props array of properties to save (prop name => prop value)
	 */
	static public function saveProps( $page_id, Array $props ) {

		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_MASTER );
		foreach( $props as $sPropName => $sPropValue) {
			$dbw->replace(
				"page_props",
				array(
					"pp_page",
					"pp_propname"
				),
				array(
					"pp_page" => $page_id,
					"pp_propname" => $sPropName,
					"pp_value" => $sPropValue
				),
				__METHOD__
			);
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * get properties for page, maybe it should be cached?
	 *
	 * @access public
	 * @static
	 *
	 * @return Array
	 */
	static public function getProps( $page_id ) {

		wfProfileIn( __METHOD__ );
		$return = array();

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( "page_props" ),
			array( "*" ),
			array( "pp_page" => $page_id ),
			__METHOD__
		);
		while( $row = $dbr->fetchObject( $res ) ) {
			$return[ $row->pp_propname ] = $row->pp_value;
		}
		$dbr->freeResult( $res );
		wfProfileOut( __METHOD__ );

		Wikia::log( __METHOD__, "props", $page_id );

		return $return;
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

		if( in_array( $row->page_namespace, array( NS_BLOG_ARTICLE, NS_BLOG_LISTING ) ) ) {
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
	 * hook, add link to toolbar
	 */
	static public function skinTemplateTabs( $skin, &$tabs ) {
		global $wgTitle, $wgUser;

		if( ! in_array( $wgTitle->getNamespace(), array( NS_BLOG_ARTICLE, NS_BLOG_LISTING ) ) ) {
			return true;
		}

		if( ! $wgUser->isLoggedIn() ) {
			return true;
		}

		$row = array();
		switch( $wgTitle->getNamespace()  ) {
			case NS_BLOG_ARTICLE:
				$row["blog-create-tab"] = array(
					"class" => "",
					"text" => wfMsg("blog-create-label"),
					"href" => Title::newFromText("CreateBlogPage", NS_SPECIAL)->getLocalUrl()
				);
				$tabs = $row + $tabs;
				break;
			case NS_BLOG_LISTING:
				$row["listing-create-tab"] = array(
					"class" => "",
					"text" => wfMsg("blog-create-listing-label"),
					"href" => Title::newFromText( "CreateBlogListingPage", NS_SPECIAL)->getLocalUrl()
				);
				$tabs = $row + $tabs;
				$row["listing-refresh-tab"] = array(
					"class" => "",
					"text" => wfMsg("blog-refresh-label"),
					"href" => $wgTitle->getLocalUrl( "action=purge" )
				);
				$tabs += $row;
				break;
		}


		return true;
	}

	/**
	 * write additinonal checkboxes on editpage
	 */
	static public function editPageCheckboxes( &$EditPage, &$checkboxes ) {

		global $wgOut;

		if( $EditPage->mTitle->getNamespace() != NS_BLOG_ARTICLE ) {
			return true;
		}
		wfProfileIn( __METHOD__ );
		Wikia::log( __METHOD__ );

		$output = array();
		if( $EditPage->mTitle->mArticleID ) {
			$props = self::getProps( $EditPage->mTitle->mArticleID );
			$output["voting"] = wfCheckLabel(
				wfMsg("blog-voting-label"),
				"wpVoting",
				"wpVoting",
				isset( $props["voting"] ) && $props[ "voting" ] == 1
			);
			$output["commenting"] = wfCheckLabel(
				wfMsg("blog-comments-label"),
				"wpCommenting",
				"wpCommenting",
				isset( $props["commenting"] ) && $props[ "commenting"] == 1
			);
		}
		$checkboxes += $output;
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * store properties for updated article
	 */
	static public function linksUpdate( &$LinksUpdate ) {
		Wikia::log( __METHOD__, "entry" );

		if( $LinksUpdate->mTitle->getNamespace() != NS_BLOG_ARTICLE ) {
			return true;
		}

		wfProfileIn( __METHOD__ );
		global $wgRequest;

		/**
		 * restore/change properties for blog article
		 */
		$voting = $wgRequest->getVal( "wpVoting", 0 );
		$commenting = $wgRequest->getVal( "wpCommenting", 0 );
		$id = $LinksUpdate->mTitle->getArticleId();

		Wikia::log( __METHOD__, "save", "voting: {$voting}, commenting: {$commenting}, id: {$id}" );
		if( $id ) {
			$LinksUpdate->mProperties = array( "voting" => $voting, "commenting" => $commenting );
			// self::saveProps( $id, array( "voting" => $voting, "commenting" => $commenting ) );
		}
		wfProfileOut( __METHOD__ );

		return true;
	}
}
