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

$wgHooks[ "ArticleFromTitle" ][] = "BlogArticle::ArticleFromTitle";
$wgHooks[ "CategoryViewer::getOtherSection" ][] = "BlogArticle::getOtherSection";
$wgHooks[ "CategoryViewer::addPage" ][] = "BlogArticle::addCategoryPage";
$wgHooks[ "SkinTemplateTabs" ][] = "BlogArticle::skinTemplateTabs";
$wgHooks[ "EditPage::showEditForm:checkboxes" ][] = "BlogArticle::editPageCheckboxes";
$wgHooks[ "LinksUpdate" ][] = "BlogArticle::linksUpdate";
$wgHooks[ "WikiFactoryChanged" ][] = "BlogArticle::WikiFactoryChanged";
$wgHooks[ "UnwatchArticleComplete" ][] = "BlogArticle::UnwatchBlogComments";
#---
$wgHooks[ "SpecialMovepageBeforeMove" ][] = "BlogArticle::checkBeforeMove";
$wgHooks[ "SpecialMovepageAfterMove" ][] = "BlogArticle::checkAfterMove";

class BlogArticle extends Article {

	public $mProps;

	/**
	 * how many entries on listing
	 */
	private $mCount = 5;

	/**
	 * setup -- called on initialization
	 *
	 * @access public
	 * @static
	 */
	public static function setup($title, $article) {
		// macbre: check namespace (RT #16832)
		if ( !in_array($title->getNamespace(), array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK, NS_BLOG_LISTING, NS_BLOG_LISTING_TALK)) ) {
			return true;
		}

		global $wgOut, $wgStyleVersion, $wgExtensionsPath, $wgJsMimeType;
		// hack - addScript should be changed to addStyle (but not OutputPage::addStyle which is more like addStyleFile) but it wont work outside wgStylePath
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/Blogs/js/Blogs.js?{$wgStyleVersion}\" ></script>\n");
		wfLoadExtensionMessages( "Blogs" );

		return true;
	}

	/**
	 * overwritten Article::view function
	 */
	public function view() {
		global $wgOut, $wgUser, $wgRequest, $wgTitle, $wgContLang;
		global $wgStylePath, $wgLang;
		global $wgProblemReportsEnable, $wgNotificationEnableSend;

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

			if( $this->exists() ) {
				/**
				 * check if something was posted, maybe comment with ajax switched
				 * off so it wend to $wgRequest
				 */
				if( $wgRequest->wasPosted() ) {
					BlogComment::doPost( $wgRequest, $wgUser, $wgTitle );
				}
				$this->showBlogComments();
			}
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
	 * display comments connected with article
	 *
	 * @access private
	 */
	private function showBlogComments() {
		global $wgOut;

		wfProfileIn( __METHOD__ );

		$page = BlogCommentList::newFromTitle( $this->mTitle );
		$page->setProps( $this->mProps );
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
		$userMem = $this->mTitle->getPrefixedDBkey();
		$listing = false;
		$purge   = $wgRequest->getVal( "action" ) == 'purge';
		$page    = $wgRequest->getVal( "page", 0 );
		$offset  = $page * $this->mCount;

		$wgOut->setSyndicated( true );

		if( !$purge ) {
			$listing  = $wgMemc->get( wfMemcKey( "blog", "listing", $userMem, $page ) );
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
			$wgMemc->set( wfMemcKey( "blog", "listing", $userMem, $page ), $page, 3600 );
		}

		$wgOut->addHTML( $listing );
	}


	/**
	 * clear data from memcache
	 *
	 * @access public
	 */
	public function clearBlogListing() {
		global $wgRequest, $wgMemc;

		$user = $this->mTitle->getPrefixedDBkey();
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
				"timestamp" => true,
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
			$diff = $wgRequest->getText( "diff", '' );
			$action = $wgRequest->getText( "action", '' );
			if ( ($redirect != 'no' ) && empty($diff) && ($action != 'history') ) {
				$text = $wgTitle->getText();
				list( $user, $title, $anchor ) = BlogComment::explode( $text );
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

		$Article = new BlogArticle( $Title );

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
	static public function setProps( $page_id, Array $props ) {

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
			Wikia::log( __METHOD__, "save", "id: {$page_id}, key: {$sPropName}, value: {$sPropValue}" );
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
		$countmsg = self::getCountMessage( $catView, $rescnt, $dbcnt, 'article' );

		if( $rescnt > 0 ) {
			$r = "<div id=\"mw-pages\">\n";
			$r .= '<h2>' . wfMsg( "blog-header", $ti ) . "</h2>\n";
			$r .= $countmsg;
			$r .= $catView->formatList( $catView->blogs, $catView->blogs_start_char );
			$r .= "\n</div>";
		}
		$output = $r;

		return true;
	}

	/*
	 * static method to get number of pages in caetgory
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
			return wfMsgExt("blog-subheader-all", 'parse', $wgLang->formatNum( $rescnt ) );
		}
		return wfMsgExt( "blog-subheader-all", 'parse', $wgLang->formatNum( $rescnt ), $wgLang->formatNum( $totalcnt ) );
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
		global $wgTitle;
		echo "Blog Article maintenance.\n";
		/**
		 * create Blog:Recent posts page if not exists
		 */
		$recentPosts = wfMsg("create-blog-post-recent-listing");
		if( $recentPosts ) {
			echo "Creating {$recentPosts}";
			$oTitle = Title::newFromText( $recentPosts,  NS_BLOG_LISTING );
			if( $oTitle ) {
				$wgTitle = $oTitle;
				$oArticle = new Article( $oTitle, 0 );
				if( !$oArticle->exists( ) ) {
					$oArticle->doEdit(
						'<bloglist summary="true" timestamp="true" count=50><title>'
						. wfMsg("create-blog-post-recent-listing-title")
						.'</title><type>plain</type><order>date</order></bloglist>',
						wfMsg("create-blog-post-recent-listing-log"),
						EDIT_NEW | EDIT_MINOR | EDIT_FORCE_BOT  # flags
					);
					echo "... done.\n";
				}
				else {
					echo "... already exists.\n";
				}
				/**
				 * Edit sidebar, add link to recent blog posts
				 */
				echo "Updating Monaco-sidebar";
				$sidebar = wfMsg('Monaco-sidebar');
				$newline = sprintf("\n* %s|%s", $oTitle->getPrefixedText(), wfMsg("create-blog-post-recent-listing-title") );
				if( strpos( $sidebar, $newline ) !== false ) {
					$sidebar .= $newline;
					$msgTitle = Title::newFromText( 'Monaco-sidebar', NS_MEDIAWIKI );
					if( $msgTitle ) {
						$oArticle = new Article( $msgTitle, 0 );
						$oArticle->doEdit(
							$sidebar,
							wfMsg("create-blog-post-recent-listing-log"),
							EDIT_MINOR | EDIT_FORCE_BOT  # flags
						);
					}
					echo "... done.\n";
				}
				else {
					echo "... already added.\n";
				}

			}
		}

		/**
		 * create Category:Blog page if not exists
		 */
		$catName = wfMsg("create-blog-post-category");
		if( $catName && $catName !== "-" ) {
			echo "Creating {$catName}";
			$oTitle = Title::newFromText( $catName, NS_CATEGORY );
			if( $oTitle ) {
				$oArticle = new Article( $oTitle, 0 );
				if( !$oArticle->exists( ) ) {
					$oArticle->doEdit(
						wfMsg( "create-blog-post-category-body" ),
						wfMsg( "create-blog-post-category-log" ),
						EDIT_NEW | EDIT_MINOR | EDIT_FORCE_BOT  # flags
					);
					echo "... done.\n";
				}
				else {
					echo "... already exists.\n";
				}
			}
		}
	}

	/**
	 * Hook handler
	 *
	 * @access public
	 * @static
	 */
	static public function wikiFactoryChanged( $cv_name, $city_id, $value ) {
		Wikia::log( __METHOD__, $city_id, "{$cv_name} = {$value}" );
		if( $cv_name == "wgEnableBlogArticles" && $value == true ) {
			/**
			 * add task to TaskManager
			 */
			$Task = new BlogTask();
			$Task->createTask( array( "city_id" => $city_id ), TASK_QUEUED );
		}
		return true;
	}

	/**
	 * Get User_blog article from USer_blog_comment
	 *
	 * @access public
	 * @static
	 */
	static public function commentToUserBlog( $oTitle ) {
		$oUBlogTitle = null;
		if ($oTitle instanceof Title) {
			list( $author, $title, $comment_title )  = BlogComment::explode( $oTitle->getPrefixedText() );
			if ( !empty($author) ) {
				list ( $ns, $user ) = explode ( ':', $author );
				$oUBlogTitle = Title::newFromText( "{$user}/{$title}#{$comment_title}", NS_BLOG_ARTICLE);
			}
		}
		return $oUBlogTitle;
	}
	
	/**
	 * auto-unwatch all comments if blog post was unwatched
	 *
	 * @access public
	 * @static
	 */
	static public function UnwatchBlogComments(&$oUser, &$oArticle) {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( !$oUser instanceof User ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( !$oArticle instanceof Article ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oTitle = $oArticle->getTitle();
		if ( !$oTitle instanceof Title ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		
		$list = array();
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'watchlist',
			'*',
			array(
				'wl_user' => $oUser->getId(),
				'wl_namespace' => NS_BLOG_ARTICLE_TALK,
				"wl_title LIKE '" . $dbr->escapeLike( $oTitle->getDBkey() ) . "/%'",
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

	/**
	 * hook
	 *
	 * @access public
	 * @static
	 */
	static public function checkBeforeMove( /*MovePageForm*/ &$form ) {
		global $wgUser;
		wfProfileIn( __METHOD__ );
		$return = true;
		
		$oOldTitle = $form->oldTitle;
		$oNewTitle = $form->newTitle;

		if ( ( $oOldTitle instanceof Title ) && ( NS_BLOG_ARTICLE == $oOldTitle->getNamespace() ) ) {
			if ( ( $oNewTitle instanceof Title ) && ( NS_BLOG_ARTICLE == $oNewTitle->getNamespace() ) ) {
				$oldTitleOwner = self::getOwner($oOldTitle);
				$newTitleOwner = self::getOwner($oNewTitle);

				$groups = $wgUser->getGroups();
				$isAllowed = $wgUser->isAllowed( "blog-articles-move" ) || $oldTitleOwner == $wgUser->getName();
				
				if ( !$isAllowed ) {
					Wikia::log( __METHOD__, "movepage", 
						"invalid permissions: oldpage: ".$oOldTitle->getPrefixedText().", newPage: ".$oNewTitle->getPrefixedText()
					);
					$return = false;
				}
			} else {
				Wikia::log( __METHOD__, "movepage", 
					"cannot move blog: oldpage: ".$oOldTitle->getPrefixedText().", newPage: ".$oNewTitle->getPrefixedText() 
				);
				$return = false;
			}
			
			if ( $return == false ) {
				$form->showForm( 'blog-movepage-badtitle' );
			}
		}

		wfProfileOut( __METHOD__ );
		return $return;
	}
	
	/**
	 * hook
	 *
	 * @access public
	 * @static
	 */
	static public function checkAfterMove ( /*MovePageForm*/ &$form , /*Title*/&$oOldTitle , /*Title*/ &$oNewTitle ) {
		global $wgUser;
		wfProfileIn( __METHOD__ );
		
		if ( ( $oOldTitle instanceof Title ) && ( NS_BLOG_ARTICLE == $oOldTitle->getNamespace() ) ) {
			if ( ( $oNewTitle instanceof Title ) && ( NS_BLOG_ARTICLE == $oNewTitle->getNamespace() ) ) {
				$oldTitleOwner = self::getOwner($oOldTitle);
				$newTitleOwner = self::getOwner($oNewTitle);

				$groups = $wgUser->getGroups();
				$isAllowed = $wgUser->isAllowed( "blog-articles-move" ) || $oldTitleOwner == $wgUser->getName();
				
				if ( ( $isAllowed ) ) {
					$clist = BlogCommentList::newFromTitle( $oOldTitle );
					$comments = $clist->getCommentPages();
					if ( count($comments) > 0 ) {
						# maybe check number of comments?
						list( $author, $newTitleText )  = explode('/', $oNewTitle->getPrefixedText(), 2);
						foreach ($comments as $oComment) {
							#---
							if ( !$oComment->mTitle instanceof Title ) continue;
							#---
							list ( $user, $page_title, $comment ) = BlogComment::explode($oComment->mTitle->getDBkey());
							
							$newCommentTitle = Title::newFromText(
								sprintf( "%s/%s/%s", $newTitleOwner, $newTitleText, $comment ),
								NS_BLOG_ARTICLE_TALK );
							
							$error = $oComment->mTitle->moveTo( $newCommentTitle, false, $form->reason, false );
							if ( $error !== true ) {
								Wikia::log( __METHOD__, "movepage", 
									"cannot move blog comments: old comment: ".$oComment->mTitle->getPrefixedText().", ".
									"new comment: ".$newCommentTitle->getPrefixedText().", error: " . @implode(", ", $error )
								);
							}
						}
					} else {
						Wikia::log( __METHOD__, "movepage", "cannot move blog comments, because no comments: ". $oOldTitle->getPrefixedText() );
					} 
				}
			}
		}
		
		wfProfileOut( __METHOD__ );
		return true;
	}
}

