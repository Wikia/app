<?php
/**
 * Blogs homepage - blog articles will make it to this page when they receive a
 * certain number of votes and/or unique commentors commenting.
 *
 * In addition to the most popular blog posts, this page will display the
 * newest blog posts, the most commented and most voted blog posts within the
 * past 72 hours.
 *
 * @file
 * @ingroup Extensions
 */
class ArticlesHome extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'ArticlesHome' );
	}

	/**
	 * Show the new special page
	 *
	 * @param $type String: what kind of articles to show? Default is 'popular'
	 */
	public function execute( $type ) {
		global $wgContLang, $wgOut, $wgScriptPath, $wgSupressPageTitle;

		$wgSupressPageTitle = true;

		// Add CSS
		$wgOut->addModules( 'ext.blogPage.articlesHome' );

		if( !$type ) {
			$type = 'popular';
		}

		// Get the category names for today and the past two days
		$dates_array = $this->getDatesFromElapsedDays( 2 );
		$date_categories = '';
		foreach ( $dates_array as $key => $value ) {
			if( $date_categories ) {
				$date_categories .= ',';
			}
			$date_categories .= $key;
		}

		// Determine the page title and set it
		if ( $type == 'popular' ) {
			$name = wfMsg( 'ah-popular-articles' );
			$name_right = wfMsg( 'ah-new-articles' );
		} else {
			$name = wfMsg( 'ah-new-articles' );
			$name_right = wfMsg( 'ah-popular-articles' );
		}

		$wgOut->setPageTitle( $name );

		$today = $wgContLang->date( wfTimestampNow() );

		// Start building the HTML output
		$output = '<div class="main-page-left">';
		$output .= '<div class="logged-in-articles">';
		$output .= '<h2>' . $name . '</h2>';
		//$output .= '<h2>' . $name . ' <span class="rss-feed"><a href="http://feeds.feedburner.com/Armchairgm"><img src="http://www.armchairgm.com/images/a/a7/Rss-icon.gif" border="0" alt="RSS" /></a> ' . wfMsg( 'ah-feed-rss' ) . '</span></h2>';
		$output .= '<p class="main-page-sub-links"><a href="' .
			SpecialPage::getTitleFor( 'CreateBlogPost' )->escapeFullURL() . '">' .
			wfMsg( 'ah-write-article' ) . '</a> - <a href="' .
				// original used date( 'F j, Y' ) which returned something like
				// December 5, 2008
				Title::makeTitle( NS_CATEGORY, $today )->escapeFullURL() . '">' .
				wfMsg( 'ah-todays-articles' ) . '</a> - <a href="' .
				Title::newMainPage()->escapeFullURL() . '">' .
					wfMsg( 'mainpage' ) . '</a></p>' . "\n\n";

		if ( $type == 'popular' ) {
			$output .= $this->getPopularPosts();
		} else {
			$output .= $this->getNewestPosts();
		}

		$output .= '</div>';
		$output .= '</div>';
		$output .= '<div class="main-page-right">';

		// Side Articles
		$output .= '<div class="side-articles">';
		$output .= '<h2>' . $name_right . '</h2>';

		if ( $type == 'popular' ) {
			$output .= $this->displayNewestPages();
		} else {
			$output .= $this->getPopularPostsForRightSide();
		}

		$output .= '</div>';

		wfDebugLog( 'BlogPage', 'ArticlesHome: date_categories=' . $date_categories );

		// Most Votes
		$output .= '<div class="side-articles">';
		$output .= '<h2>' . wfMsg( 'ah-most-votes' ) . '</h2>';
		$output .= $this->displayMostVotedPages( $date_categories );
		$output .= '</div>';

		// Most Comments
		$output .= '<div class="side-articles">';
		$output .= '<h2>' . wfMsg( 'ah-what-talking-about' ) . '</h2>';
		$output .= $this->displayMostCommentedPages( $date_categories );
		$output .= '</div>';

		$output .= '</div>';
		$output .= '<div class="cleared"></div>';

		$wgOut->addHTML( $output );
	}

	/**
	 * @param $numberOfDays Integer: get this many days in addition to today
	 * @return Array: array containing today and the past $numberOfDays days in
	 *                the wiki's content language
	 */
	function getDatesFromElapsedDays( $numberOfDays ) {
		global $wgContLang;
		$today = $wgContLang->date( wfTimestampNow() ); // originally date( 'F j, Y', time() )
		$dates[$today] = 1; // Gets today's date string
		for( $x = 1; $x <= $numberOfDays; $x++ ) {
			$timeAgo = time() - ( 60 * 60 * 24 * $x );
			// originally date( 'F j, Y', $timeAgo );
			$dateString = $wgContLang->date( wfTimestamp( TS_MW, $timeAgo ) );
			$dates[$dateString] = 1;
		}
		return $dates;
	}

	/**
	 * Get the 25 most popular blog posts from the database and then cache them
	 * in memcached for 15 minutes.
	 * The definition of 'popular' is very arbitrary at the moment.
	 *
	 * @return String: HTML
	 */
	public function getPopularPosts() {
		global $wgMemc, $wgScriptPath;

		// Try cache first
		$key = wfMemcKey( 'blog', 'popular', 'twentyfive' );
		$data = $wgMemc->get( $key );

		if( $data != '' ) {
			wfDebugLog( 'BlogPage', 'Got popular posts in ArticlesHome from cache' );
			$popularBlogPosts = $data;
		} else {
			wfDebugLog( 'BlogPage', 'Got popular posts in ArticlesHome from DB' );
			$dbr = wfGetDB( DB_SLAVE );
			// Code sporked from Rob Church's NewestPages extension
			$commentsTable = $dbr->tableName( 'Comments' );
			$voteTable = $dbr->tableName( 'Vote' );
			$res = $dbr->select(
				array( 'page', 'Comments', 'Vote' ),
				array(
					'DISTINCT page_id', 'page_namespace', 'page_title',
					'page_is_redirect',
				),
				array(
					'page_namespace' => NS_BLOG,
					'page_is_redirect' => 0,
					// If you can figure out how to do this without a subquery,
					// please let me know. Until that...
					"((SELECT COUNT(*) FROM $voteTable WHERE vote_page_id = page_id) >= 5 OR
					(SELECT COUNT(*) FROM $commentsTable WHERE Comment_Page_ID = page_id) >= 5)",
				),
				__METHOD__,
				array(
					'ORDER BY' => 'page_id DESC',
					'LIMIT' => 25
				),
				array(
					'Comments' => array( 'INNER JOIN', 'page_id = Comment_Page_ID' ),
					'Vote' => array( 'INNER JOIN', 'page_id = vote_page_id' )
				)
			);

			$popularBlogPosts = array();
			foreach ( $res as $row ) {
				$popularBlogPosts[] = array(
					'title' => $row->page_title,
					'ns' => $row->page_namespace,
					'id' => $row->page_id
				);
			}

			// Cache in memcached for 15 minutes
			$wgMemc->set( $key, $popularBlogPosts, 60 * 15 );
		}

		$imgPath = $wgScriptPath . '/extensions/BlogPage/images/';

		$output = '<div class="listpages-container">';
		if ( empty( $popularBlogPosts ) ) {
			$output .= wfMsg( 'ah-no-results' );
		} else {
			foreach( $popularBlogPosts as $popularBlogPost ) {
				$titleObj = Title::makeTitle( NS_BLOG, $popularBlogPost['title'] );
				$output .= '<div class="listpages-item">';
				$pageImage = BlogPage::getPageImage( $popularBlogPost['id'] );
				if( $pageImage ) {
					// Load MediaWiki image object to get thumbnail tag
					$img = wfFindFile( $pageImage );
					$imgTag = '';
					if ( is_object( $img ) ) {
						$thumb = $img->transform( array( 'width' => 65, 'height' => 0 ) );
						$imgTag = $thumb->toHtml();
					}

					$output .= "<div class=\"listpages-image\">{$imgTag}</div>\n";
				}
				$output .= '<a href="' . $titleObj->escapeFullURL() . '">' .
						$titleObj->getText() .
						'</a>
						<div class="listpages-date">';
				$output .= '(' . wfMsg( 'blog-created-ago',
					BlogPage::getTimeAgo(
						// need to strtotime() it because getCreateDate() now
						// returns the raw timestamp from the database; in the past
						// it converted it to UNIX timestamp via the SQL function
						// UNIX_TIMESTAMP but that was no good for our purposes
						strtotime( BlogPage::getCreateDate( $popularBlogPost['id'] ) )
					) ) . ')';
				$output .= "</div>
				<div class=\"listpages-blurb\">\n" .
						BlogPage::getBlurb(
							$popularBlogPost['title'],
							$popularBlogPost['ns'],
							300
						) .
					'</div><!-- .listpages-blurb -->
				<div class="listpages-stats">' . "\n";
				$output .= "<img src=\"{$imgPath}voteIcon.gif\" alt=\"\" border=\"0\" /> " .
					wfMsgExt(
						'blog-author-votes',
						'parsemag',
						BlogPage::getVotesForPage( $popularBlogPost['id'] )
					);
				$output .= " <img src=\"{$imgPath}comment.gif\" alt=\"\" border=\"0\" /> " .
					wfMsgExt(
						'blog-author-comments',
						'parsemag',
						BlogPage::getCommentsForPage( $popularBlogPost['id'] )
					) . '</div><!-- . listpages-stats -->
				</div><!-- .listpages-item -->
				<div class="cleared"></div>' . "\n";
			}
		}

		$output .= '</div>' . "\n"; // .listpages-container

		return $output;
	}

	/**
	 * Get the list of the most voted pages within the last 72 hours.
	 *
	 * @param $dateCategories String: last three days (localized), separated
	 *                                by commas
	 * @return String: HTML
	 */
	function displayMostVotedPages( $dateCategories ) {
		global $wgMemc;

		// Try cache first
		$key = wfMemcKey( 'blog', 'mostvoted', 'ten' );
		$data = $wgMemc->get( $key );

		if( $data != '' ) {
			wfDebugLog( 'BlogPage', 'Got most voted posts in ArticlesHome from cache' );
			$votedBlogPosts = $data;
		} else {
			wfDebugLog( 'BlogPage', 'Got most voted posts in ArticlesHome from DB' );
			$dbr = wfGetDB( DB_SLAVE );
			$kaboom = explode( ',', $dateCategories );
			// Without constructing Titles for all the categories, they won't
			// have the underscores and thus the query will never match
			// anything...thankfully getDBkey returns the title with the
			// underscores
			$titleOne = Title::makeTitle( NS_CATEGORY, $kaboom[0] );
			$titleTwo = Title::makeTitle( NS_CATEGORY, $kaboom[1] );
			$titleThree = Title::makeTitle( NS_CATEGORY, $kaboom[2] );
			$res = $dbr->select(
				array( 'page', 'categorylinks', 'Vote' ),
				array( 'DISTINCT page_id', 'page_title', 'page_namespace' ),
				array(
					'cl_to' => array(
						$titleOne->getDBkey(), $titleTwo->getDBkey(),
						$titleThree->getDBkey()
					),
					'page_namespace' => NS_BLOG,
					'page_id = vote_page_id',
					'vote_date < "' . date( 'Y-m-d H:i:s' ) . '"'
				),
				__METHOD__,
				array( 'LIMIT' => 10 ),
				array(
					'categorylinks' => array( 'INNER JOIN', 'cl_from = page_id' ),
					'Vote' => array( 'LEFT JOIN', 'vote_page_id = page_id' ),
				)
			);

			$votedBlogPosts = array();
			foreach ( $res as $row ) {
				$votedBlogPosts[] = array(
					'title' => $row->page_title,
					'ns' => $row->page_namespace,
					'id' => $row->page_id
				);
			}

			// Cache in memcached for 15 minutes
			$wgMemc->set( $key, $votedBlogPosts, 60 * 15 );
		}

		// Here we output HTML
		$output = '<div class="listpages-container">' . "\n";

		if ( empty( $votedBlogPosts ) ) {
			$output .= wfMsg( 'ah-no-results' );
		} else {
			foreach ( $votedBlogPosts as $votedBlogPost ) {
				$titleObj = Title::makeTitle( NS_BLOG, $votedBlogPost['title'] );
				$votes = BlogPage::getVotesForPage( $votedBlogPost['id'] );
				$output .= '<div class="listpages-item">' . "\n";
				$output .= '<div class="listpages-votebox">' . "\n";
				$output .= '<div class="listpages-votebox-number">' .
					$votes . "</div>\n";
				$output .= '<div class="listpages-votebox-text">' .
					wfMsgExt(
						'blog-author-votes',
						'parsemag',
						$votes
					) . "</div>\n"; // .listpages-votebox-text
				$output .= '</div>' . "\n"; // .listpages-votebox
				$output .= '</div>' . "\n"; // .listpages-item
				$output .= '<a href="' . $titleObj->escapeFullURL() . '">' .
					$titleObj->getText() . '</a>';
				$output .= '<div class="cleared"></div>';
			}
		}

		$output .= "</div>\n"; // .listpages-container

		return $output;
	}

	/**
	 * Get the list of the most commented pages within the last 72 hours.
	 *
	 * @param $dateCategories String: last three days (localized), separated
	 *                                by commas
	 * @return String: HTML
	 */
	function displayMostCommentedPages( $dateCategories ) {
		global $wgMemc;

		// Try cache first
		$key = wfMemcKey( 'blog', 'mostcommented', 'ten' );
		$data = $wgMemc->get( $key );

		if( $data != '' ) {
			wfDebugLog( 'BlogPage', 'Got most commented posts in ArticlesHome from cache' );
			$commentedBlogPosts = $data;
		} else {
			wfDebugLog( 'BlogPage', 'Got most commented posts in ArticlesHome from DB' );
			$dbr = wfGetDB( DB_SLAVE );
			$kaboom = explode( ',', $dateCategories );
			// Without constructing Titles for all the categories, they won't
			// have the underscores and thus the query will never match
			// anything...thankfully getDBkey returns the title with the
			// underscores
			$titleOne = Title::makeTitle( NS_CATEGORY, $kaboom[0] );
			$titleTwo = Title::makeTitle( NS_CATEGORY, $kaboom[1] );
			$titleThree = Title::makeTitle( NS_CATEGORY, $kaboom[2] );
			$res = $dbr->select(
				array( 'page', 'categorylinks', 'Comments' ),
				array( 'DISTINCT page_id', 'page_title', 'page_namespace' ),
				array(
					'cl_to' => array(
						$titleOne->getDBkey(), $titleTwo->getDBkey(),
						$titleThree->getDBkey()
					),
					'page_namespace' => NS_BLOG,
					'page_id = Comment_Page_ID',
					'Comment_Date < "' . date( 'Y-m-d H:i:s' ) . '"'
				),
				__METHOD__,
				array( 'LIMIT' => 10 ),
				array(
					'categorylinks' => array( 'INNER JOIN', 'cl_from = page_id' ),
					'Comments' => array( 'LEFT JOIN', 'Comment_Page_ID = page_id' ),
				)
			);

			$commentedBlogPosts = array();
			foreach ( $res as $row ) {
				$commentedBlogPosts[] = array(
					'title' => $row->page_title,
					'ns' => $row->page_namespace,
					'id' => $row->page_id
				);
			}

			// Cache in memcached for 15 minutes
			$wgMemc->set( $key, $commentedBlogPosts, 60 * 15 );
		}

		$output = '<div class="listpages-container">';

		if ( empty( $commentedBlogPosts ) ) {
			$output .= wfMsg( 'ah-no-results' );
		} else {
			foreach( $commentedBlogPosts as $commentedBlogPost ) {
				$titleObj = Title::makeTitle( NS_BLOG, $commentedBlogPost['title'] );
				$output .= '<div class="listpages-item">
					<div class="listpages-votebox">
						<div class="listpages-commentbox-number">' .
						BlogPage::getCommentsForPage( $commentedBlogPost['id'] ) .
					'</div>
				</div>
				<a href="' . $titleObj->escapeFullURL() . '">' .
					$titleObj->getText() .
					'</a>
			</div><!-- .listpages-item -->
			<div class="cleared"></div>' . "\n";
			}
		}

		$output .= '</div>' . "\n"; // .listpages-container

		return $output;
	}

	/**
	 * Get the list of the ten newest pages in the NS_BLOG namespace.
	 * This is used in the right side of the special page.
	 *
	 * @return String: HTML
	 */
	function displayNewestPages() {
		global $wgMemc;

		// Try cache first
		$key = wfMemcKey( 'blog', 'newest', 'ten' );
		$data = $wgMemc->get( $key );

		if( $data != '' ) {
			wfDebugLog( 'BlogPage', 'Got new articles in ArticlesHome from cache' );
			$newBlogPosts = $data;
		} else {
			wfDebugLog( 'BlogPage', 'Got new articles in ArticlesHome from DB' );
			$dbr = wfGetDB( DB_SLAVE );
			// Code sporked from Rob Church's NewestPages extension
			$res = $dbr->select(
				'page',
				array(
					'page_namespace', 'page_title', 'page_is_redirect',
					'page_id'
				),
				array( 'page_namespace' => NS_BLOG, 'page_is_redirect' => 0 ),
				__METHOD__,
				array( 'ORDER BY' => 'page_id DESC', 'LIMIT' => 10 )
			);

			$newBlogPosts = array();
			foreach ( $res as $row ) {
				$newBlogPosts[] = array(
					'title' => $row->page_title,
					'ns' => $row->page_namespace,
					'id' => $row->page_id
				);
			}

			// Cache in memcached for 15 minutes
			$wgMemc->set( $key, $newBlogPosts, 60 * 15 );
		}

		$output = '<div class="listpages-container">' . "\n";
		if ( empty( $newBlogPosts ) ) {
			$output .= wfMsg( 'ah-no-results' );
		} else {
			foreach( $newBlogPosts as $newBlogPost ) {
				$titleObj = Title::makeTitle( NS_BLOG, $newBlogPost['title'] );
				$votes = BlogPage::getVotesForPage( $newBlogPost['id'] );
				$output .= "\t\t\t\t" . '<div class="listpages-item">';
				$output .= '<div class="listpages-votebox">' . "\n";
				$output .= '<div class="listpages-votebox-number">' .
					$votes .
					"</div>\n"; // .listpages-votebox-number
				$output .= '<div class="listpages-votebox-text">' .
					wfMsgExt(
						'blog-author-votes',
						'parsemag',
						$votes
					) . "</div>\n"; // .listpages-votebox-text
				$output .= "</div>\n"; // .listpages-votebox
				$output .= '<a href="' . $titleObj->escapeFullURL() . '">' .
						$titleObj->getText() .
					'</a>
				</div><!-- .listpages-item -->
				<div class="cleared"></div>' . "\n";
			}
		}
		$output .= '</div>' . "\n"; // .listpages-container
		return $output;
	}

	/**
	 * Get the 25 newest blog posts from the database and then cache them in
	 * memcached for 15 minutes.
	 *
	 * @return String: HTML
	 */
	public function getNewestPosts() {
		global $wgMemc, $wgScriptPath;

		// Try cache first
		$key = wfMemcKey( 'blog', 'newest', 'twentyfive' );
		$data = $wgMemc->get( $key );

		if( $data != '' ) {
			wfDebugLog( 'BlogPage', 'Got newest posts in ArticlesHome from cache' );
			$newestBlogPosts = $data;
		} else {
			wfDebugLog( 'BlogPage', 'Got newest posts in ArticlesHome from DB' );
			$dbr = wfGetDB( DB_SLAVE );
			// Code sporked from Rob Church's NewestPages extension
			$res = $dbr->select(
				array( 'page' ),
				array(
					'page_namespace', 'page_title', 'page_is_redirect',
					'page_id',
				),
				array(
					'page_namespace' => NS_BLOG,
					'page_is_redirect' => 0,
				),
				__METHOD__,
				array(
					'ORDER BY' => 'page_id DESC',
					'LIMIT' => 25
				)
			);

			$newestBlogPosts = array();
			foreach ( $res as $row ) {
				$newestBlogPosts[] = array(
					'title' => $row->page_title,
					'ns' => $row->page_namespace,
					'id' => $row->page_id
				);
			}

			// Cache in memcached for 15 minutes
			$wgMemc->set( $key, $newestBlogPosts, 60 * 15 );
		}

		$imgPath = $wgScriptPath . '/extensions/BlogPage/images/';

		$output = '<div class="listpages-container">';
		if ( empty( $newestBlogPosts ) ) {
			$output .= wfMsg( 'ah-no-results' );
		} else {
			foreach( $newestBlogPosts as $newestBlogPost ) {
				$titleObj = Title::makeTitle( NS_BLOG, $newestBlogPost['title'] );
				$output .= '<div class="listpages-item">';
				$pageImage = BlogPage::getPageImage( $newestBlogPost['id'] );
				if( $pageImage ) {
					// Load MediaWiki image object to get thumbnail tag
					$img = wfFindFile( $pageImage );
					$imgTag = '';
					if ( is_object( $img ) ) {
						$thumb = $img->transform( array( 'width' => 65, 'height' => 0 ) );
						$imgTag = $thumb->toHtml();
					}

					$output .= "<div class=\"listpages-image\">{$imgTag}</div>\n";
				}
				$output .= '<a href="' . $titleObj->escapeFullURL() . '">' .
						$titleObj->getText() .
						'</a>
						<div class="listpages-date">';
				$output .= '(' . wfMsg( 'blog-created-ago',
					BlogPage::getTimeAgo(
						// need to strtotime() it because getCreateDate() now
						// returns the raw timestamp from the database; in the past
						// it converted it to UNIX timestamp via the SQL function
						// UNIX_TIMESTAMP but that was no good for our purposes
						strtotime( BlogPage::getCreateDate( $newestBlogPost['id'] ) )
					) ) . ')';
				$output .= "</div>
				<div class=\"listpages-blurb\">\n" .
						BlogPage::getBlurb(
							$newestBlogPost['title'],
							$newestBlogPost['ns'],
							300
						) .
					'</div><!-- .listpages-blurb -->
				<div class="listpages-stats">' . "\n";
				$output .= "<img src=\"{$imgPath}voteIcon.gif\" alt=\"\" border=\"0\" /> " .
					wfMsgExt(
						'blog-author-votes',
						'parsemag',
						BlogPage::getVotesForPage( $newestBlogPost['id'] )
					);
				$output .= " <img src=\"{$imgPath}comment.gif\" alt=\"\" border=\"0\" /> " .
					wfMsgExt(
						'blog-author-comments',
						'parsemag',
						BlogPage::getCommentsForPage( $newestBlogPost['id'] )
					) . '</div><!-- . listpages-stats -->
				</div><!-- .listpages-item -->
				<div class="cleared"></div>' . "\n";
			}
		}

		$output .= '</div>' . "\n"; // .listpages-container

		return $output;
	}

	/**
	 * Get the 25 most popular blog posts from the database and then cache them
	 * in memcached for 15 minutes.
	 * The definition of 'popular' is very arbitrary at the moment.
	 *
	 * Fork of the original getPopularPosts() method, the only thing changed
	 * here is the HTML output which was toned down and count changed from 25
	 * to 10.
	 *
	 * @return String: HTML
	 */
	public function getPopularPostsForRightSide() {
		global $wgMemc;

		// Try cache first
		$key = wfMemcKey( 'blog', 'popular', 'ten' );
		$data = $wgMemc->get( $key );

		if( $data != '' ) {
			wfDebugLog( 'BlogPage', 'Got popular posts in ArticlesHome from cache' );
			$popularBlogPosts = $data;
		} else {
			wfDebugLog( 'BlogPage', 'Got popular posts in ArticlesHome from DB' );
			$dbr = wfGetDB( DB_SLAVE );
			$commentsTable = $dbr->tableName( 'Comments' );
			$voteTable = $dbr->tableName( 'Vote' );
			// Code sporked from Rob Church's NewestPages extension
			$res = $dbr->select(
				array( 'page', 'Comments', 'Vote' ),
				array(
					'DISTINCT page_id', 'page_namespace', 'page_title',
					'page_is_redirect',
				),
				array(
					'page_namespace' => NS_BLOG,
					'page_is_redirect' => 0,
					'page_id = Comment_Page_ID',
					'page_id = vote_page_id',
					// If you can figure out how to do this without a subquery,
					// please let me know. Until that...
					"((SELECT COUNT(*) FROM $voteTable WHERE vote_page_id = page_id) >= 5 OR
					(SELECT COUNT(*) FROM $commentsTable WHERE Comment_Page_ID = page_id) >= 5)",
				),
				__METHOD__,
				array(
					'ORDER BY' => 'page_id DESC',
					'LIMIT' => 10
				),
				array(
					'Comments' => array( 'INNER JOIN', 'page_id = Comment_Page_ID' ),
					'Vote' => array( 'INNER JOIN', 'page_id = vote_page_id' )
				)
			);

			$popularBlogPosts = array();
			foreach ( $res as $row ) {
				$popularBlogPosts[] = array(
					'title' => $row->page_title,
					'ns' => $row->page_namespace,
					'id' => $row->page_id
				);
			}

			// Cache in memcached for 15 minutes
			$wgMemc->set( $key, $popularBlogPosts, 60 * 15 );
		}

		$output = '<div class="listpages-container">';
		if ( empty( $popularBlogPosts ) ) {
			$output .= wfMsg( 'ah-no-results' );
		} else {
			foreach( $popularBlogPosts as $popularBlogPost ) {
				$titleObj = Title::makeTitle( NS_BLOG, $popularBlogPost['title'] );
				$votes = BlogPage::getVotesForPage( $popularBlogPost['id'] );
				$output .= '<div class="listpages-item">';
				$output .= '<div class="listpages-votebox">' . "\n";
				$output .= '<div class="listpages-votebox-number">' .
					$votes . "</div>\n";
				$output .= '<div class="listpages-votebox-text">' .
					wfMsgExt(
						'blog-author-votes',
						'parsemag',
						$votes
					) . "</div>\n"; // .listpages-votebox-text
				$output .= '</div>' . "\n"; // .listpages-votebox
				$output .= '<a href="' . $titleObj->escapeFullURL() . '">' .
							$titleObj->getText() .
						'</a>
					</div><!-- .listpages-item -->
				<div class="cleared"></div>' . "\n";
			}
		}

		$output .= '</div>' . "\n"; // .listpages-container

		return $output;
	}
}