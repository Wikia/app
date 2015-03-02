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

class BlogArticle extends Article {

	public $mProps;

	/**
	 * how many entries on listing
	 */
	private $mCount = 5;

	/**
	 * setup function called on initialization
	 * Create a Category:BlogListingPage so that we can purge by category when new blogs are posted
	 * moved other setup code to ::ArticleFromTitle instead of hooking that twice [owen]
	 *
	 * @access public
	 * @static
	 */
	public static function createCategory() {
		// make sure page "Category:BlogListingTag" exists
		$title = Title::newFromText( 'Category:BlogListingPage' );
		global $wgUser;
		if ( !$title->exists() && $wgUser->isAllowed( 'edit' ) ) {
			$article = new Article( $title );
			$article->doEdit(
				"__HIDDENCAT__", $title, EDIT_NEW | EDIT_FORCE_BOT | EDIT_SUPPRESS_RC
			);
		}
	}

	/**
	 * overwritten Article::view function
	 */
	public function view() {
		global $wgOut, $wgRequest, $wgTitle;

		$feed = $wgRequest->getText( "feed", false );
		if( $feed && in_array( $feed, array( "rss", "atom" ) ) ) {
			$this->showFeed( $feed );
		}
		elseif ( $wgTitle->isSubpage() ) {
			/**
			 * blog article, show if exists
			 */
			$oldPrefixedText = $this->mTitle->mPrefixedText;
			list( $author, $prefixedText )  = explode('/', $this->mTitle->getPrefixedText(), 2);
			if( isset( $prefixedText ) && !empty( $prefixedText ) ) {
				$this->mTitle->mPrefixedText = $prefixedText;
			}
			$this->mTitle->mPrefixedText = $oldPrefixedText;
			$this->mProps = self::getProps( $this->mTitle->getArticleID() );
			Article::view();
		}
		else {
			/**
			 * blog listing
			 */
			$wgOut->setHTMLTitle( $wgOut->getWikiaPageTitle( $this->mTitle->getPrefixedText() ) );
			$this->showBlogListing();
		}
	}

	/**
	 * take data from blog tag extension and display it
	 *
	 * @access private
	 */
	private function showBlogListing() {
		global $wgOut, $wgRequest, $wgMemc, $wgParser;

		/**
		 * use cache or skip cache when action=purge
		 */
		$user    = $this->mTitle->getBaseText();
		$userMem = $this->mTitle->getPrefixedDBkey();
		$listing = false;
		$purge   = $wgRequest->getVal( "action" ) == 'purge';
		$page    = $wgRequest->getVal( "page", 0 );
		$offset  = $page * $this->mCount;
		$blogPostCount = null;

		$wgOut->setSyndicated( true );

		if( !$purge ) {
			$cachedValueKey  = $this->blogListingMemcacheKey( $userMem, $page );
			$cachedValue = $wgMemc->get( $cachedValueKey );

			if ( $cachedValue && isset( $cachedValue['listing'] ) ) {
				$listing = $cachedValue['listing'];
				if ( isset($cachedValue['blogPostCount']) ) {
					$blogPostCount = $cachedValue['blogPostCount'];
				}
			}
		}

		if( !$listing ) {
			$text = "
				<bloglist
					count=$this->mCount
					summary=true
					summarylength=750
					type=plain
					title=Blogs
					offset=$offset>
					<author>$user</author>
				</bloglist>";
			$parserOutput = $wgParser->parse($text, $this->mTitle,  new ParserOptions());
			$listing = $parserOutput->getText();
			$blogPostCount = $parserOutput->getProperty("blogPostCount");
			$wgMemc->set( $this->blogListingMemcacheKey( $userMem, $page ), [ 'listing'=> $listing, 'blogPostCount' => $blogPostCount ], 3600 );
		}
		if ( isset($blogPostCount) && $blogPostCount == 0 ) {
			// bugid: PLA-844
			$wgOut->setRobotPolicy( "noindex,nofollow" );
		}
		$wgOut->addHTML( $listing );
	}


	/**
	 * clear data from memcache and purge any pages in Category:BlogListingPage
	 *
	 * @access public
	 */
	public function clearBlogListing() {
		global $wgRequest, $wgMemc, $wgLang;

		// Clear Oasis rail module
		$mcKey = wfMemcKey( "OasisPopularBlogPosts", $wgLang->getCode() );
		$wgMemc->delete($mcKey);

		$user = $this->mTitle->getPrefixedDBkey();
		foreach( range(0, 5) as $page ) {
			$wgMemc->delete($this->blogListingMemcacheKey($user, $page));
		}
		$this->doPurge();

		$title = Title::newFromText( 'Category:BlogListingPage' );
		$title->touchLinks();

	}

	/**
	 * @param $user - user dbkKey
	 * @param $page - page no
	 * @return String - memcache key
	 */
	private function blogListingMemcacheKey($user, $page) {
		return wfMemcKey("blog", "listing", "v2", $user, $page);
	}

	/**
	 * generate xml feed from returned data
	 */
	private function showFeed( $format ) {
		global $wgOut, $wgRequest, $wgParser, $wgMemc, $wgFeedClasses, $wgTitle;
		global $wgSitename;

		$user    = $this->mTitle->getBaseText();
		$userMemc = $this->mTitle->getPrefixedDBkey();
		$listing = false;
		$purge   = $wgRequest->getVal( 'action' ) == 'purge';
		$offset  = 0;

		wfProfileIn( __METHOD__ );

		if( !$purge ) {
			$listing  = $wgMemc->get( wfMemcKey( "blog", "feed", $userMemc, $offset ) );
		}

		if ( !$listing ) {
			$params = array(
				"count"  => 50,
				"summary" => true,
				"summarylength" => 750,
				"type" => "array",
				"title" => "Blogs",
				"offset" => $offset
			);

			$listing = BlogTemplateClass::parseTag( "<author>$user</author>", $params, $wgParser );
			$wgMemc->set( wfMemcKey( "blog", "feed", $userMemc, $offset ), $listing, 3600 );
		}

		$feed = new $wgFeedClasses[ $format ]( wfMsg("blog-userblog", $user), wfMsg("blog-fromsitename", $wgSitename), $wgTitle->getFullUrl() );

		$feed->outHeader();
		if( is_array( $listing ) ) {
			foreach( $listing as $item ) {
				$title = Title::newFromText( $item["title"], NS_BLOG_ARTICLE );
				$item = new FeedItem(
					$title->getSubpageText(),
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
		return Xml::element( 'link', array(
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
		global $wgOut;
		// macbre: check namespace (RT #16832)
		if ( !in_array($Title->getNamespace(), array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK, NS_BLOG_LISTING, NS_BLOG_LISTING_TALK)) ) {
			return true;
		}

		if( $Title->getNamespace() == NS_BLOG_ARTICLE ) {
			$Article = new BlogArticle( $Title );
		}

		return true;
	}


	/**
	 * return list of props
	 *
	 * @access public
	 * @static
	 *
	 */

	static public function getPropsList() {
		$replace = array('voting' => WPP_BLOGS_VOTING, 'commenting' => WPP_BLOGS_COMMENTING );
		return $replace;
	}

	/**
	 * save article extra properties to page_props table
	 *
	 * @access public
	 * @static
	 *
	 * @param array $props array of properties to save (prop name => prop value)
	 */
	static public function setProps( $page_id, Array $props ) {
		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_MASTER );

		$replace = self::getPropsList();
		foreach( $props as $sPropName => $sPropValue) {
			wfSetWikiaPageProp($replace[$sPropName], $page_id, $sPropValue );
		}

		$dbw->commit(); #--- for ajax
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
		$types = self::getPropsList();
		foreach( $types as $key => $value ) {
			$return[$key] =  (int) wfGetWikiaPageProp( $value, $page_id );
		}

		wfProfileOut( __METHOD__ );
		wfDebug( __METHOD__ . ": getting props for $page_id\n" );

		return $return;
	}

	/**
	 * static methods used in Hooks
	 */
	static public function getOtherSection( &$catView, &$output ) {
		global $wgContLang;
		wfProfileIn(__METHOD__);

		/* @var $catView CategoryViewer */
		if( !isset( $catView->blogs ) ) {
			wfProfileOut(__METHOD__);
			return true;
		}
		$ti = htmlspecialchars( $catView->title->getText() );
		$r = '';
		$cat = $catView->getCat();

		$dbcnt = self::blogsInCategory($cat);
		$rescnt = count( $catView->blogs );
		$countmsg = self::getCountMessage( $catView, $rescnt, $dbcnt, 'article' );

		if( $rescnt > 0 ) {
			$r = "<div id=\"mw-pages\">\n";
			$r .= '<h2>' . wfMsg( "blog-header", $ti ) . "</h2>\n";
			$r .= $countmsg;
			$r .= $catView->getSectionPagingLinksExt( 'page' );
			$r .= $catView->formatList( array_values($catView->blogs), $catView->blogs_start_char );
			$r .= $catView->getSectionPagingLinksExt( 'page' );
			$r .= "\n</div>";
		}
		$output = $r;

		wfProfileOut(__METHOD__);
		return true;
	}

	static public function blogsInCategory ( $cat ) {
		global $wgMemc;
		$titleText = $cat->getTitle()->getDBkey();
		$memKey = self::getCountKey( $titleText );

		$count = $wgMemc->get( $memKey );

		if (empty($count)) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array('page', 'categorylinks'),
				'count(*) as count',
				array(
					'page_id = cl_from',
					'page_namespace' => array(NS_BLOG_ARTICLE, NS_BLOG_LISTING),
					'cl_to' => $titleText,
				),
				__METHOD__
			);

			$count = 0;
			if ( $res->numRows() > 0 ) {
				while ( $row = $res->fetchObject() ) {
					$count = $row->count;
				}
				$dbr->freeResult( $res );
			}

			$wgMemc->set($memKey, $count);
		}

		return $count;
	}

	/**
	 * Hook - AfterCategoriesUpdate
	 */
	static public function clearCountCache ($categoryInserts, $categoryDeletes, $title) {
		global $wgMemc;

		// Clear the count cache for inserts
		foreach ($categoryInserts as $catName => $prefix) {
			$memKey = self::getCountKey( $catName );
			$wgMemc->delete($memKey);
		}

		// Clear the count cache for deletes
		foreach ($categoryDeletes as $catName => $prefix) {
			$memKey = self::getCountKey( $catName );
			$wgMemc->delete($memKey);
		}

		return true;
	}

	static public function getCountKey ($catName) {
		return wfMemcKey( 'blog', 'category', 'count', $catName );
	}

	/*
	 * static method to get number of pages in category
	 */
	static public function getCountMessage( &$catView, $rescnt, $dbcnt, $type ) {
		global $wgLang;
		# See CategoryPage->getCountMessage() function
		$totalrescnt = count( $catView->blogs ) + count( $catView->children ) + ($catView->showGallery ? $catView->gallery->count() : 0);
		if ($dbcnt == $rescnt || (($totalrescnt == $catView->limit || $catView->from || $catView->until) && $dbcnt > $rescnt)) {
			# Case 1: seems sane.
			$totalcnt = $dbcnt;
		} elseif ( $totalrescnt < $catView->limit && !$catView->from && !$catView->until ) {
			# Case 2: not sane, but salvageable.
			$totalcnt = $rescnt;
		} else {
			# Case 3: hopeless.  Don't give a total count at all.
			return wfMsgExt("blog-subheader", 'parse', $wgLang->formatNum( $rescnt ) );
		}
		return wfMsgExt( "blog-subheader-all", 'parse', $wgLang->formatNum( $rescnt ), $wgLang->formatNum( $totalcnt ) );
	}

	/**
	 * Hook
	 * @param CategoryViewer
	 */
	static public function addCategoryPage( &$catView, &$title, &$row, $sortkey ) {
		global $wgContLang;

		if( in_array( $row->page_namespace, array( NS_BLOG_ARTICLE, NS_BLOG_LISTING ) ) ) {
			/**
			 * initialize CategoryView->blogs array
			 */
			if( !isset( $catView->blogs ) ) {
				$catView->blogs = array();
			}

			if ( F::app()->checkSkin( 'wikiamobile' ) ) {
				$catView->blogs[] = [
					'name' => $title->getText(),
					'url' => $title->getLocalUrl(),
				];

				return false;
			}

			/**
			 * initialize CategoryView->blogs_start_char array
			 */
			if( !isset( $catView->blogs_start_char ) ) {
				$catView->blogs_start_char = array();
			}

			// remove user blog:foo from displayed titles (requested by Angie)
			// "User blog:Homersimpson89/Best Simpsons episode..." -> "Best Simpsons episode..."
			$text = $title->getSubpageText();
			$userName = $title->getBaseText();
			$link = $catView->getSkin()->link($title, $userName." - ".$text);

			$catView->blogs[] = $row->page_is_redirect
				? '<span class="redirect-in-category">' . $link . '</span>'
				: $link;

			// The blog entries should be sorted on the category page
			// just like other pages
			$catView->blogs_start_char[] = $catView->collation->getFirstLetter( $sortkey );

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
		global $wgEnableSemanticMediaWikiExt, $wgEnableBlogCommentEdit;

		if( ! in_array( $wgTitle->getNamespace(), array( NS_BLOG_ARTICLE, NS_BLOG_LISTING, NS_BLOG_ARTICLE_TALK ) ) ) {
			return true;
		}

		if ( ( $wgTitle->getNamespace() == NS_BLOG_ARTICLE_TALK ) && ( empty($wgEnableBlogCommentEdit) ) ) {
			return true;
		}

		$row = array();
		switch( $wgTitle->getNamespace()  ) {
			case NS_BLOG_ARTICLE:
				if ( !$wgTitle->isSubpage() ) {
					$allowedTabs = array();
					$tabs = array();
					break;
				}
			case NS_BLOG_LISTING:
				if (empty($wgEnableSemanticMediaWikiExt)) {
					$row["listing-refresh-tab"] = array(
						"class" => "",
						"text" => wfMsg("blog-refresh-label"),
						"icon" => "refresh",
						"href" => $wgTitle->getLocalUrl( "action=purge" )
					);
					$tabs += $row;
				}
				break;
			case NS_BLOG_ARTICLE_TALK: {
				$allowedTabs = array('viewsource', 'edit', 'delete', 'history');
				foreach ( $tabs as $key => $tab ) {
					if ( !in_array($key, $allowedTabs) ) {
						unset($tabs[$key]);
					}
				}
				break;
			}
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
			$output["voting"] = Xml::checkLabel(
				wfMsg("blog-voting-label"),
				"wpVoting",
				"wpVoting",
				isset( $props["voting"] ) && $props[ "voting" ] == 1
			);
			$output["commenting"] = Xml::checkLabel(
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

		$namespace = $LinksUpdate->mTitle->getNamespace();
		if( !in_array( $namespace, array( NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK ) ) ) {
			return true;
		}

		wfProfileIn( __METHOD__ );
		global $wgRequest;

		/**
		 * restore/change properties for blog article
		 */
		$pageId = $LinksUpdate->mTitle->getArticleId();
		$keep   = array();

		if( $wgRequest->wasPosted() ) {
			$keep[ "voting" ]     = $wgRequest->getVal( "wpVoting", 0 );
			$keep[ "commenting" ] = $wgRequest->getVal( "wpCommenting", 0 );
		}
		else {
			/**
			 * read current values from database
			 */
			$props = self::getProps( $pageId );
			switch( $namespace ) {
				case NS_BLOG_ARTICLE:
					$keep[ "voting" ]     = isset( $props["voting"] ) ? $props["voting"] : 0;
					$keep[ "commenting" ] = isset( $props["commenting"] ) ? $props["commenting"] : 0;
					break;

				case NS_BLOG_ARTICLE_TALK:
					$keep[ "hiddencomm" ] = isset( $props["hiddencomm"] ) ? $props["hiddencomm"] : 0;
					break;
			}
		}

		if( $pageId ) {
			$LinksUpdate->mProperties += $keep;
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * guess Owner of blog from title
	 *
	 * @static
	 * @access public
	 *
	 * @return String -- guessed name
	 */
	static public function getOwner( $title ) {
		wfProfileIn( __METHOD__ );
		if( $title instanceof Title ) {
			$title = $title->getBaseText();
		}
		if( strpos( $title, "/" ) !== false ) {
			list( $title, $rest) = explode( "/", $title, 2 );
		}
		wfProfileOut( __METHOD__ );

		return $title;
	}

	/**
	 * guess Owner of blog from title and return Title instead of string
	 *
	 * @static
	 * @access public
	 *
	 * @return String -- guessed name
	 */
	static public function getOwnerTitle( $title ) {
		wfProfileIn( __METHOD__ );

		$owner = false;

		if( $title instanceof Title ) {
			$text = $title->getBaseText();
		}
		if( strpos( $text, "/" ) !== false ) {
			list( $owner, $rest) = explode( "/", $text, 2 );
		}
		wfProfileOut( __METHOD__ );

		return ( $owner ) ? Title::newFromText( $owner, NS_BLOG_ARTICLE ) : false;
	}


	/**
	 * wfMaintenance -- wiki factory maintenance
	 *
	 * @static
	 */
	static public function wfMaintenance() {

		$results = [];

		// VOLDEV-96: Do not credit edits to localhost
		$wikiaUser = User::newFromName( 'Wikia' );

		/**
		 * create Blog:Recent posts page if not exists
		 */
		$recentPosts = wfMessage( 'create-blog-post-recent-listing' )->text();
		if ( $recentPosts ) {
			$recentPostsKey = "Creating {$recentPosts}";
			$oTitle = Title::newFromText( $recentPosts,  NS_BLOG_LISTING );
			if ( $oTitle ) {
				$page = new WikiPage( $oTitle );
				if ( !$page->exists( ) ) {
					$page->doEdit(
						'<bloglist summary="true" count=50><title>'
						. wfMessage( 'create-blog-post-recent-listing-title ')->text()
						.'</title><type>plain</type><order>date</order></bloglist>',
						wfMessage( 'create-blog-post-recent-listing-log' )->text(),
						EDIT_NEW | EDIT_MINOR | EDIT_FORCE_BOT,  # flags
						false,
						$wikiaUser
					);
					$results[$recentPostsKey] = 'done';
				}
				else {
					$results[$recentPostsKey] = 'already exists';
				}
			}
		}

		/**
		 * create Category:Blog page if not exists
		 */
		$catName = wfMessage( 'create-blog-post-category' )->text();
		if ( $catName && $catName !== "-" ) {
			$catNameKey = "Creating {$catName}";
			$oTitle = Title::newFromText( $catName, NS_CATEGORY );
			if ( $oTitle ) {
				$page = new WikiPage( $oTitle );
				if ( !$page->exists( ) ) {
					$page->doEdit(
						wfMessage( 'create-blog-post-category-body' )->text(),
						wfMessage( 'create-blog-post-category-log' )->text(),
						EDIT_NEW | EDIT_MINOR | EDIT_FORCE_BOT,  # flags
						false,
						$wikiaUser
					);
					$results[$catNameKey] = 'done';
				}
				else {
					$results[$catNameKey] = 'already exists';
				}
			}
		}

		return $results;
	}

	/**
	 * auto-unwatch all comments if blog post was unwatched
	 *
	 * @access public
	 * @static
	 */
	static public function UnwatchBlogComments($oUser, $oArticle) {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		/* @var $oUser User */
		if ( !$oUser instanceof User ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		/* @var $oArticle WikiPage */
		if ( !$oArticle instanceof Article ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		/* @var $oTitle Title */
		$oTitle = $oArticle->getTitle();
		if ( !$oTitle instanceof Title ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$list = array();
		$dbr = wfGetDB( DB_SLAVE );
		$like = $dbr->buildLike( sprintf( "%s/", $oTitle->getDBkey() ), $dbr->anyString() );
		$res = $dbr->select(
			'watchlist',
			'*',
			array(
				'wl_user' => $oUser->getId(),
				'wl_namespace' => NS_BLOG_ARTICLE_TALK,
				"wl_title $like",
			),
			__METHOD__
		);
		if( $res->numRows() > 0 ) {
			while( $row = $res->fetchObject() ) {
				$oCommentTitle = Title::makeTitleSafe( $row->wl_namespace, $row->wl_title );
				if ( $oCommentTitle instanceof Title )
					$list[] = $oCommentTitle;
			}
			$dbr->freeResult( $res );
		}

		if ( !empty($list) ) {
			foreach ( $list as $oCommentTitle ) {
				$oWItem = WatchedItem::fromUserTitle( $oUser, $oCommentTitle );
				$oWItem->removeWatch();
			}
			$oUser->invalidateCache();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/* hook used to redirect to custom edit page */

	public static function alternateEditHook(EditPage $oEditPage) {
		global $wgOut, $wgRequest;
		$oTitle = $oEditPage->mTitle;
		if($oTitle->getNamespace() == NS_BLOG_LISTING) {
			$oSpecialPageTitle = Title::newFromText('CreateBlogListingPage', NS_SPECIAL);
			$wgOut->redirect($oSpecialPageTitle->getFullUrl("article=" . urlencode($oTitle->getText())));
		}
		if($oTitle->getNamespace() == NS_BLOG_ARTICLE && $oTitle->isSubpage() && empty($oEditPage->isCreateBlogPage) ) {
			$oSpecialPageTitle = Title::newFromText('CreateBlogPage', NS_SPECIAL);
			if ($wgRequest->getVal('oldid')) {
				$url = $oSpecialPageTitle->getFullUrl("pageId=" . $oTitle->getArticleId() . "&oldid=" . $wgRequest->getVal('oldid'));
			}
			else if ($wgRequest->getVal('undoafter') && $wgRequest->getVal('undo')) {
				$url = $oSpecialPageTitle->getFullUrl("pageId=" . $oTitle->getArticleId() . "&undoafter=" . $wgRequest->getVal('undoafter') . "&undo=" . $wgRequest->getVal('undo'));
			}
			else {
				$url = $oSpecialPageTitle->getFullUrl("pageId=" . $oTitle->getArticleId() );
			}
			$wgOut->redirect($url);

		}
		return true;
	}
}
