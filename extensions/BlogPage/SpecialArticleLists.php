<?php
/**
 * A special page that displays the 25 most recent blog posts.
 *
 * @file
 * @ingroup Extensions
 */
class ArticleLists extends IncludableSpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'ArticleLists' );
	}

	/**
	 * Show the new special page
	 *
	 * @param $limit Integer: show this many entries (LIMIT for SQL)
	 */
	public function execute( $limit ) {
		global $wgMemc, $wgOut, $wgScriptPath;

		$wgOut->setPageTitle( wfMsg( 'ah-new-articles' ) );

		if ( empty( $limit ) ) {
			$limit = 25;
		} elseif ( !empty( $limit ) ) {
			$limit = intval( $limit );
		}

		// Add some CSS for ListPages
		// @todo FIXME: this should be loaded when including the special page,
		// too, but if ( $this->including() ) does nothing, prolly because of
		// the parser cache
		$wgOut->addModules( 'ext.blogPage.articlesHome' );

		$imgPath = $wgScriptPath . '/extensions/BlogPage/images/';

		$output = '<div class="left-articles">';
		if ( !$this->including() ) {
			$output .= '<h2>' . wfMsg( 'ah-new-articles' ) . '</h2>';
		}

		// Try cache first
		$key = wfMemcKey( 'blog', 'new', 'twentyfive' );
		$data = $wgMemc->get( $key );

		if( $data != '' ) {
			wfDebugLog( 'BlogPage', 'Got new articles in ArticleLists from cache' );
			$newBlogPosts = $data;
		} else {
			wfDebugLog( 'BlogPage', 'Got new articles in ArticleLists from DB' );
			$dbr = wfGetDB( DB_SLAVE );
			// Code sporked from Rob Church's NewestPages extension
			// You rock, dude!
			$res = $dbr->select(
				'page',
				array(
					'page_namespace', 'page_title', 'page_is_redirect',
					'page_id'
				),
				array( 'page_namespace' => NS_BLOG, 'page_is_redirect' => 0 ),
				__METHOD__,
				array( 'ORDER BY' => 'page_id DESC', 'LIMIT' => $limit )
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

		$output .= '<div class="listpages-container">' . "\n";
		if ( empty( $newBlogPosts ) ) {
			$output .= wfMsg( 'ah-no-results' );
		} else {
			foreach( $newBlogPosts as $newBlogPost ) {
				$titleObj = Title::makeTitle( NS_BLOG, $newBlogPost['title'] );
				$output .= "\t\t\t\t" . '<div class="listpages-item">';
				$pageImage = BlogPage::getPageImage( $newBlogPost['id'] );
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
						"</a>
						<div class=\"listpages-blurb\">\n" .
						BlogPage::getBlurb(
							$newBlogPost['title'],
							$newBlogPost['ns'],
							300
						) .
					'</div><!-- .listpages-blurb -->
				<div class="listpages-stats">' . "\n";
				$output .= "<img src=\"{$imgPath}voteIcon.gif\" alt=\"\" border=\"0\" /> " .
					wfMsgExt(
						'blog-author-votes',
						'parsemag',
						BlogPage::getVotesForPage( $newBlogPost['id'] )
					);
				$output .= " <img src=\"{$imgPath}comment.gif\" alt=\"\" border=\"0\" /> " .
					wfMsgExt(
						'blog-author-comments',
						'parsemag',
						BlogPage::getCommentsForPage( $newBlogPost['id'] )
					) . '</div><!-- . listpages-stats -->
				</div><!-- .listpages-item -->
				<div class="cleared"></div>' . "\n";
			}
		}
		$output .= '</div>' . "\n"; // .listpages-container
		$output .= '</div>' . "\n"; // .left-articles

		$wgOut->addHTML( $output );
	}

}