<?php
/**
 * Links' homepage -- a listing of user-submitted links.
 *
 * @file
 * @ingroup Extensions
 */
class LinksHome extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'LinksHome' );
	}

	/**
	 * Displays news items from MediaWiki:Inthenews
	 * @return HTML
	 */
	function getInTheNews() {
		global $wgLinkPageDisplay, $wgOut;

		if( !$wgLinkPageDisplay['in_the_news'] ) {
			return '';
		}

		$newsArray = explode( "\n\n", wfMsgForContent( 'inthenews' ) );
		$newsItem = $newsArray[array_rand( $newsArray )];
		$output = '<div class="link-container border-fix">
			<h2>' . wfMsg( 'linkfilter-in-the-news' ) . '</h2>
			<div>' . $wgOut->parse( $newsItem, false ) . '</div>
		</div>';

		return $output;
	}

	function getPopularArticles() {
		global $wgLinkPageDisplay;

		if( !$wgLinkPageDisplay['popular_articles'] ) {
			return '';
		}

		$dbr = wfGetDB( DB_SLAVE );

		// This query is a lot simpler than the ugly one used by BlogPage et
		// al. which uses three tables and has that nasty subquery
		$res = $dbr->select(
			array( 'link', 'page' ),
			array(
				'DISTINCT link_page_id', 'page_id', 'page_title',
				'page_is_redirect'
			),
			array(
				'link_comment_count >= 5',
				'link_page_id = page_id',
				'page_is_redirect' => 0
			),
			__METHOD__,
			array(
				'ORDER BY' => 'page_id DESC',
				'LIMIT' => 7
			)
		);

		$popularLinks = array();
		foreach ( $res as $row ) {
			$popularLinks[] = array(
				'title' => $row->page_title,
				'id' => $row->page_id
			);
		}

		$html = '<div class="listpages-container">';
		if ( empty( $popularLinks ) ) {
			$html .= wfMsg( 'linkfilter-no-results' );
		} else {
			foreach( $popularLinks as $popularLink ) {
				$titleObj = Title::makeTitle( NS_LINK, $popularLink['title'] );
				$html .= '<div class="listpages-item">';
				$html .= '<a href="' . $titleObj->escapeFullURL() . '">' .
						$titleObj->getText() .
					'</a>
				</div><!-- .listpages-item -->
				<div class="cleared"></div>' . "\n";
			}
		}

		$html .= '</div>' . "\n"; // .listpages-container

		$output = '<div class="link-container">
			<h2>' . wfMsg( 'linkfilter-popular-articles' ) . '</h2>
			<div>' . $html . '</div>
		</div>';

		return $output;
	}

	/**
	 * Gets a random casual game if RandomGameUnit extension is installed.
	 * @return HTML or nothing
	 */
	function getRandomCasualGame() {
		if( function_exists( 'wfGetRandomGameUnit' ) ) {
			return wfGetRandomGameUnit();
		} else {
			return '';
		}
	}

	/**
	 * Gets a wide skyscraper ad unit
	 * @return HTML
	 */
	function getAdUnit() {
		global $wgLinkPageDisplay, $wgAdConfig;

		if( !$wgLinkPageDisplay['left_ad'] ) {
			return '';
		}

		$output = '<div class="article-ad">
			<script type="text/javascript"><!--
			google_ad_client = "pub-' . $wgAdConfig['adsense-client'] . '";
			google_ad_slot = "' . $wgAdConfig['ad-slot'] . '";
			google_ad_width = 160;
			google_ad_height = 600;
			google_ad_format = "160x600_as";
			google_ad_type = "text";
			google_ad_channel = "";
			google_color_border = "F6F4C4";
			google_color_bg = "FFFFE0";
			google_color_link = "000000";
			google_color_text = "000000";
			google_color_url = "002BB8";
			//--></script>
			<script type="text/javascript"
			  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>';
		return $output;
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgRequest, $wgSupressPageTitle;

		$wgSupressPageTitle = true;

		// Add CSS & JS
		$wgOut->addModules( 'ext.linkFilter' );

		$per_page = 20;
		$page = $wgRequest->getInt( 'page', 1 );
		$link_type = $wgRequest->getInt( 'link_type' );

		if( $link_type ) {
			$type_name = Link::$link_types[$link_type];
			$pageTitle = wfMsg( 'linkfilter-home-title', $type_name );
		} else {
			$type_name = 'All';
			$pageTitle = wfMsg( 'linkfilter-home-title-all' );
		}

		$wgOut->setPageTitle( $pageTitle );

		$output = '<div class="links-home-left">' . "\n\t";
		$output .= '<h1 class="page-title">' . $pageTitle . '</h1>' . "\n\t";
		$output .= '<div class="link-home-navigation">
		<a href="' . Link::getSubmitLinkURL() . '">' .
			wfMsg( 'linkfilter-submit-title' ) . '</a>' . "\n";

		if( Link::canAdmin() ) {
			$output .= "\t\t" . '<a href="' . Link::getLinkAdminURL() . '">' .
				wfMsg( 'linkfilter-approve-links' ) . '</a>' . "\n";
		}

		$output .= "\t\t" . '<div class="cleared"></div>
		</div>' . "\n";
		$l = new LinkList();

		$type = 0; // FIXME lazy hack --Jack on July 2, 2009
		$total = $l->getLinkListCount( LINK_APPROVED_STATUS, $type );
		$links = $l->getLinkList( LINK_APPROVED_STATUS, $type, $per_page, $page, 'link_approved_date' );
		$linkRedirect = SpecialPage::getTitleFor( 'LinkRedirect' );
		$output .= '<div class="links-home-container">';
		$link_count = count( $links );
		$x = 1;

		// No links at all? Oh dear...show a message to the user about that!
		if ( $link_count <= 0 ) {
			$wgOut->addWikiMsg( 'linkfilter-no-links-at-all' );
		}

		// Create RSS feed icon for special page
		$wgOut->setSyndicated( true );

		// Make feed (RSS/Atom) if requested
		$feedType = $wgRequest->getVal( 'feed' );
		if ( $feedType != '' ) {
			return $this->makeFeed( $feedType, $links );
		}

		foreach( $links as $link ) {
			$border_fix = '';
			if( $link_count == $x ) {
				$border_fix = 'border-fix';
			}

			$border_fix2 = '';
			wfSuppressWarnings();
			$date = date( 'l, F j, Y', $link['approved_timestamp'] );
			if( $date != $last_date ) {
				$border_fix2 = ' border-top-fix';
				$output .= "<div class=\"links-home-date\">{$date}</div>";
				#global $wgLang;
				#$unix = wfTimestamp( TS_MW, $link['approved_timestamp'] );
				#$weekday = $wgLang->getWeekdayName( gmdate( 'w', $unix ) + 1 );
				#$output .= '<div class="links-home-date">' . $weekday .
				#	wfMsg( 'word-separator' ) . $wgLang->date( $unix, true ) .
				#	'</div>';
			}
			wfRestoreWarnings(); // okay, so suppressing E_NOTICEs is kinda bad practise, but... -Jack, January 21, 2010
			$last_date = $date;

			$output .= "<div class=\"link-item-container{$border_fix2}\">
					<div class=\"link-item-type\">
						{$link['type_name']}
					</div>
					<div class=\"link-item\">
						<div class=\"link-item-url\">
							<a href=\"" . $linkRedirect->escapeFullURL( array(
								'link' => 'true', 'url' => $link['url'] ) ) .
								'" target="new">' . $link['title'] .
							'</a>
						</div>
						<div class="link-item-desc">' . $link['description'] .
						'</div>
					</div>
					<div class="link-item-page">
						<a href="' . $link['wiki_page'] . '">(' .
							wfMsgExt( 'linkfilter-comments', 'parsemag', $link['comments'] ) .
						')</a>
					</div>
					<div class="cleared"></div>';
			$output .= '</div>';

			$x++;
		}

		$output .= '</div>';

		/**
		 * Build next/prev nav
		 */
		$numofpages = $total / $per_page; 

		$pageLink = $this->getTitle();

		if( $numofpages > 1 ) {
			$output .= '<div class="page-nav">';
			if( $page > 1 ) { 
				$output .= '<a href="' . $pageLink->escapeFullURL( 'page=' . ( $page - 1 ) ) . '">' .
					wfMsg( 'linkfilter-previous' ) . '</a> ';
			}

			if( ( $total % $per_page ) != 0 ) {
				$numofpages++;
			}
			if( $numofpages >= 9 && $page < $total ) {
				$numofpages = 9 + $page;
			}
			if( $numofpages > ( $total / $per_page ) ) {
				$numofpages = ( $total / $per_page ) + 1;
			}

			for( $i = 1; $i <= $numofpages; $i++ ) {
				if( $i == $page ) {
					$output .= ( $i . ' ' );
				} else {
					$output .= '<a href="' . $pageLink->escapeFullURL( 'page=' . $i ) . "\">$i</a> ";
				}
			}

			if( ( $total - ( $per_page * $page ) ) > 0 ) {
				$output .= ' <a href="' . $pageLink->escapeFullURL( 'page=' . ( $page + 1 ) ) . '">' .
					wfMsg( 'linkfilter-next' ) . '</a>';
			}
			$output .= '</div>';
		}

		$output .= '</div>' . "\n"; // .links-home-left

		global $wgLinkPageDisplay;
		if( $wgLinkPageDisplay['rightcolumn'] ) {
			$output .= '<div class="links-home-right">';
			$output .= '<div class="links-home-unit-container">';
			$output .= $this->getPopularArticles();
			$output .= $this->getInTheNews();
			$output .= '</div>';
			$output .= $this->getAdUnit();
			$output .= '</div>';
		}
		$output .= '<div class="cleared"></div>' . "\n";
		$wgOut->addHTML( $output );
	}

	/**
	 * Create feed (RSS/Atom) from given links array
	 * Based on ProblemReports' makeFeed() function by Maciej Brencz
	 *
	 * @param $type String: feed type, RSS or Atom
	 * @param $links Array:
	 */
	function makeFeed( $type, &$links ) {
		wfProfileIn( __METHOD__ );

		$feed = new LinkFeed(
			wfMsgExt( 'linkfilter-feed-title', 'parsemag' ),
			'',
			$this->getTitle()->escapeFullURL()
		);

		$feed->outHeader();

		foreach ( $links as $link ) {
			$item = new FeedItem(
				'[' . $link['type_name'] . '] ' . $link['title'],
				str_replace( 'http://', '', $link['url'] ),
				Title::newFromId( $link['page_id'] )->escapeFullURL()
			);
			$feed->outItem( $item );
		}

		$feed->outFooter();

		wfProfileOut( __METHOD__ );

		return true;
	}
}