<?php
/**
 * A special page to display the highest rated pages on the wiki.
 *
 * This special page supports filtering by category and namespace, so
 * {{Special:TopRatings/Adventure Games/0/10}} will show 10 ratings where the
 * pages are in the "Adventure Games" category and the pages are in the main
 * (0) namespace.
 *
 * @file
 * @ingroup Extensions
 * @date 11 December 2011
 * @license To the extent that it is possible, this code is in the public domain
 */
class SpecialTopRatings extends IncludableSpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'TopRatings' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the special page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgScriptPath;

		// Set the page title, robot policies, etc.
		$this->setHeaders();

		$categoryName = $namespace = '';

		// Parse the parameters passed to the special page
		// Make sure that the limit parameter passed to the special page is
		// an integer and that it's less than 100 (performance!)
		if ( isset( $par ) && is_numeric( $par ) && $par < 100 ) {
			$limit = intval( $par );
		} elseif ( isset( $par ) && !is_numeric( $par ) ) {
			// $par is a string...assume that we can explode() it
			$exploded = explode( '/', $par );
			$categoryName = $exploded[0];
			$namespace = ( isset( $exploded[1] ) ? intval( $exploded[1] ) : $namespace );
			$limit = ( isset( $exploded[2] ) ? intval( $exploded[2] ) : 50 );
		} else {
			$limit = 50;
		}

		// Add JS (and CSS) -- needed so that users can vote on this page and
		// so that their browsers' consoles won't be filled with JS errors ;-)
		$wgOut->addModules( 'ext.voteNY' );

		$ratings = array();
		$output = '';

		$dbr = wfGetDB( DB_SLAVE );
		$tables = $where = $joinConds = array();
		$whatToSelect = array( 'DISTINCT vote_page_id' );

		// By default we have no category and no namespace
		$tables = array( 'Vote' );
		$where = array( 'vote_page_id <> 0' );

		// isset(), because 0 is a totally valid NS
		if ( !empty( $categoryName ) && isset( $namespace ) ) {
			$tables = array( 'Vote', 'page', 'categorylinks' );
			$where = array(
				'vote_page_id <> 0',
				'cl_to' => str_replace( ' ', '_', $categoryName ),
				'page_namespace' => $namespace
			);
			$joinConds = array(
				'categorylinks' => array( 'INNER JOIN', 'cl_from = page_id' ),
				'page' => array( 'INNER JOIN', 'page_id = vote_page_id' )
			);
		}

		// Perform the SQL query with the given conditions; the basic idea is
		// that we get $limit (however, 100 or less) unique page IDs from the
		// Vote table. If a category and a namespace have been given, we also
		// do an INNER JOIN with page and categorylinks table to get the
		// correct data.
		$res = $dbr->select(
			$tables,
			$whatToSelect,
			$where,
			__METHOD__,
			array( 'LIMIT' => intval( $limit ) ),
			$joinConds
		);

		foreach ( $res as $row ) {
			// Add the results to the $ratings array and get the amount of
			// votes the given page ID has
			// For example: $ratings[1] = 11 = page with the page ID 1 has 11
			// votes
			$ratings[$row->vote_page_id] = (int)$dbr->selectField(
				'Vote',
				'SUM(vote_value)',
				array( 'vote_page_id' => $row->vote_page_id ),
				__METHOD__
			);
		}

		// If we have some ratings, start building HTML output
		if ( !empty( $ratings ) ) {
			/* XXX dirrrrrrty hack! because when we include this page, the JS
			is not included, but we want things to work still */
			if ( $this->including() ) {
				$output .= '<script type="text/javascript" src="' .
					$wgScriptPath . '/extensions/VoteNY/Vote.js"></script>';
			}

			// yes, array_keys() is needed
			foreach ( array_keys( $ratings ) as $discardThis => $pageId ) {
				$titleObj = Title::newFromId( $pageId );
				if ( !( $titleObj instanceof Title ) ) {
					continue;
				}

				$vote = new VoteStars( $pageId );
				$output .= '<div class="user-list-rating">' .
					Linker::link(
						$titleObj,
						$titleObj->getPrefixedText() // prefixed, so that the namespace shows!
					) . wfMsg( 'word-separator' ) . // i18n overkill? ya betcha...
					wfMsg( 'parentheses', $ratings[$pageId] ) .
				'</div>';

				$id = mt_rand(); // AFAIK these IDs are and originally were totally random...
				$output .= "<div id=\"rating_stars_{$id}\">" .
					$vote->displayStars(
						$id,
						self::getAverageRatingForPage( $pageId ),
						false
					) . '</div>';
				$output .= "<div id=\"rating_{$id}\" class=\"rating-total\">" .
					$vote->displayScore() .
				'</div>';
			}
		} else {
			// Nothing? Well, display an informative error message rather than
			// a blank page or somesuch.
			$output .= wfMsg( 'topratings-no-pages' );
		}

		// Output everything!
		$wgOut->addHTML( $output );
	}

	/**
	 * Static version of Vote::getAverageVote().
	 *
	 * @param $pageId Integer: ID of the page for which we want to get the avg.
	 *                         rating
	 * @return Integer: average vote for the given page (ID)
	 */
	public static function getAverageRatingForPage( $pageId ) {
		global $wgMemc;

		$key = wfMemcKey( 'vote', 'avg', $pageId );
		$data = $wgMemc->get( $key );
		$voteAvg = 0;

		if( $data ) {
			wfDebug( "Loading vote avg for page {$pageId} from cache (TopRatings)\n" );
			$voteAvg = $data;
		} else {
			$dbr = wfGetDB( DB_SLAVE );
			$voteAvg = (int)$dbr->selectField(
				'Vote',
				'AVG(vote_value) AS VoteAvg',
				array( 'vote_page_id' => $pageId ),
				__METHOD__
			);
			$wgMemc->set( $key, $voteAvg );
		}

		return $voteAvg;
	}
}