<?php
/**
 * Vote class - class for handling vote-related functions (counting
 * the average score of a given page, inserting/updating/removing a vote etc.)
 *
 * @file
 * @ingroup Extensions
 */
class Vote {
	var $PageID = 0;
	var $Userid = 0;
	var $Username = null;

	/**
	 * Constructor
	 *
	 * @param $pageID Integer: article ID number
	 */
	public function __construct( $pageID ) {
		global $wgUser;

		$this->PageID = $pageID;
		$this->Username = $wgUser->getName();
		$this->Userid = $wgUser->getID();
	}

	/**
	 * Counts all votes, fetching the data from memcached if available
	 * or from the database if memcached isn't available
	 *
	 * @return Integer: amount of votes
	 */
	function count() {
		global $wgMemc;

		$key = wfMemcKey( 'vote', 'count', $this->PageID );
		$data = $wgMemc->get( $key );

		// Try cache
		if( $data ) {
			wfDebug( "Loading vote count for page {$this->PageID} from cache\n" );
			$vote_count = $data;
		} else {
			$dbr = wfGetDB( DB_SLAVE );
			$vote_count = 0;
			$res = $dbr->select(
				'Vote',
				'COUNT(*) AS VoteCount',
				array( 'vote_page_id' => $this->PageID ),
				__METHOD__
			);
			$row = $dbr->fetchObject( $res );
			if( $row ) {
				$vote_count = $row->VoteCount;
			}
			$wgMemc->set( $key, $vote_count );
		}

		return $vote_count;
	}

	/**
	 * Gets the average score of all votes
	 * @return Integer: formatted average number of votes (something like 3.50)
	 */
	function getAverageVote() {
		global $wgMemc;
		$key = wfMemcKey( 'vote', 'avg', $this->PageID );
		$data = $wgMemc->get( $key );

		$voteAvg = 0;
		if( $data ) {
			wfDebug( "Loading vote avg for page {$this->PageID} from cache\n" );
			$voteAvg = $data;
		} else {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				'Vote',
				'AVG(vote_value) AS VoteAvg',
				array( 'vote_page_id' => $this->PageID ),
				__METHOD__
			);
			$row = $dbr->fetchObject( $res );
			if( $row ) {
				$voteAvg = $row->VoteAvg;
			}
			$wgMemc->set( $key, $voteAvg );
		}

		return number_format( $voteAvg, 2 );
	}

	/**
	 * Clear caches - memcached, parser cache and Squid cache
	 */
	function clearCache() {
		global $wgUser, $wgMemc;

		// Kill internal cache
		$wgMemc->delete( wfMemcKey( 'vote', 'count', $this->PageID ) );
		$wgMemc->delete( wfMemcKey( 'vote', 'avg', $this->PageID ) );

		// Purge squid
		$pageTitle = Title::newFromID( $this->PageID );
		if( is_object( $pageTitle ) ) {
			$pageTitle->invalidateCache();
			$pageTitle->purgeSquid();

			// Kill parser cache
			$article = new Article( $pageTitle, /* oldid */0 );
			$parserCache = ParserCache::singleton();
			$parserKey = $parserCache->getKey( $article, $wgUser );
			$wgMemc->delete( $parserKey );
		}
	}

	/**
	 * Delete the user's vote from the database, purges normal caches and
	 * updates SocialProfile's statistics, if SocialProfile is active.
	 */
	function delete() {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete(
			'Vote',
			array(
				'vote_page_id' => $this->PageID,
				'username' => $this->Username
			),
			__METHOD__
		);
		$dbw->commit();

		$this->clearCache();

		// Update social statistics if SocialProfile extension is enabled
		if( class_exists( 'UserStatsTrack' ) ) {
			$stats = new UserStatsTrack( $this->Userid, $this->Username );
			$stats->decStatField( 'vote' );
		}
	}

	/**
	 * Inserts a new vote into the Vote database table
	 * @param $voteValue
	 */
	function insert( $voteValue ) {
		$dbw = wfGetDB( DB_MASTER );
		wfSuppressWarnings(); // E_STRICT whining
		$voteDate = date( 'Y-m-d H:i:s' );
		wfRestoreWarnings();
		if( $this->UserAlreadyVoted() == false ) {
			$dbw->insert(
				'Vote',
				array(
					'username' => $this->Username,
					'vote_user_id' => $this->Userid,
					'vote_page_id' => $this->PageID,
					'vote_value' => $voteValue,
					'vote_date' => $voteDate,
					'vote_ip' => wfGetIP()
				),
				__METHOD__
			);
			$dbw->commit();

			$this->clearCache();

			// Update social statistics if SocialProfile extension is enabled
			if( class_exists( 'UserStatsTrack' ) ) {
				$stats = new UserStatsTrack( $this->Userid, $this->Username );
				$stats->incStatField( 'vote' );
			}
		}
	}

	/**
	 * Checks if a user has already voted
	 *
	 * @return Boolean|Integer: false if s/he hasn't, otherwise returns the
	 *                          value of 'vote_value' column from Vote DB table
	 */
	function UserAlreadyVoted() {
		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow(
			'Vote',
			array( 'vote_value' ),
			array(
				'vote_page_id' => $this->PageID,
				'username' => $this->Username
			),
			__METHOD__
		);
		if( $s === false ) {
			return false;
		} else {
			return $s->vote_value;
		}
	}

	/**
	 * Displays the green voting box
	 * @return Mixed: HTML output
	 */
	function display() {
		global $wgUser;

		$voted = $this->UserAlreadyVoted();

		$make_vote_box_clickable = '';
		if( $voted == false ) {
			$make_vote_box_clickable = ' vote-clickable';
		}

		$output = "<div class=\"vote-box{$make_vote_box_clickable}\" id=\"votebox\">";
	 	$output .= '<span id="PollVotes" class="vote-number">' . $this->count() . '</span>';
		$output .= '</div>';
		$output .= '<div id="Answer" class="vote-action">';

		if ( !$wgUser->isAllowed( 'vote' ) ) {
			// @todo FIXME: this is horrible. If we don't have enough
			// permissions to vote, we should tell the end-user /that/,
			// not require them to log in!
			$login = SpecialPage::getTitleFor( 'Userlogin' );
			$output .= '<a class="votebutton" href="' .
				$login->escapeFullURL() . '" rel="nofollow">' .
				wfMsg( 'vote-link' ) . '</a>';
		} else {
			if( !wfReadOnly() ) {
				if( $voted == false ) {
					$output .= '<a href="javascript:void(0);" class="vote-vote-link">' .
						wfMsg( 'vote-link' ) . '</a>';
				} else {
					$output .= '<a href="javascript:void(0);" class="vote-unvote-link">' .
						wfMsg( 'vote-unvote-link' ) . '</a>';
				}
			}
		}
		$output .= '</div>';

		return $output;
	}
}

/**
 * Class for generating star rating stars.
 */
class VoteStars extends Vote {

	var $maxRating = 5;

	/**
	 * Displays voting stars
	 *
	 * @param $voted Boolean: has the user already voted? False by default
	 * @return Mixed: HTML output
	 */
	function display( $voted = false ) {
		global $wgUser;

		$overall_rating = $this->getAverageVote();

		if( $voted ) {
			$display_stars_rating = $voted;
		} else {
			$display_stars_rating = $this->getAverageVote();
		}

	 	$id = '';

		// Should probably be $this->PageID or something?
		// 'cause we define $id just above as an empty string...duh
		$output = '<div id="rating_' . $id . '">';
		$output .= '<div class="rating-score">';
		$output .= '<div class="voteboxrate">' . $overall_rating . '</div>';
		$output .= '</div>';
		$output .= '<div class="rating-section">';
		$output .= $this->displayStars( $id, $display_stars_rating, $voted );
		$count = $this->count();
		if( $count ) {
			$output .= ' <span class="rating-total">(' .
				wfMsgExt( 'vote-votes', 'parsemag', $count ) . ')</span>';
		}
		$already_voted = $this->UserAlreadyVoted();
		if( $already_voted && $wgUser->isLoggedIn() ) {
			$output .= '<div class="rating-voted">' .
				wfMsgExt( 'vote-gave-this', 'parsemag', $already_voted ) .
			" </div>
			<a href=\"javascript:void(0);\" class=\"vote-remove-stars-link\" data-vote-id=\"{$id}\">("
				. wfMsg( 'vote-remove' ) .
			')</a>';
		}
		$output .= '</div>
				<div class="rating-clear">
			</div>';

		$output .= '</div>';
		return $output;
	}

	/**
	 * Displays the actual star images, depending on the state of the user's mouse
	 * @param $id Integer: ID of the rating (div) element
	 * @param $rating Integer: average rating
	 * @param $voted Integer
	 * @return Mixed: generated <img> tag
	 */
	function displayStars( $id, $rating, $voted ) {
		global $wgScriptPath;

		if( !$rating ) {
			$rating = 0;
		}
		if( !$voted ) {
			$voted = 0;
		}
		$output = '';

		for( $x = 1; $x <= $this->maxRating; $x++ ) {
			if( !$id ) {
				$action = 3;
			} else {
				$action = 5;
			}
			$output .= "<img class=\"vote-rating-star\" data-vote-the-vote=\"{$x}\"" .
				" data-vote-id=\"{$id}\" data-vote-action=\"{$action}\" data-vote-rating=\"{$rating}\"" .
				" data-vote-voted=\"{$voted}\" id=\"rating_{$id}_{$x}\"" .
				" src=\"{$wgScriptPath}/extensions/VoteNY/images/star_";
			switch( true ) {
				case $rating >= $x:
					if( $voted ) {
						$output .= 'voted';
					} else {
						$output .= 'on';
					}
					break;
				case( $rating > 0 && $rating < $x && $rating > ( $x - 1 ) ):
					$output .= 'half';
					break;
				case( $rating < $x ):
					$output .= 'off';
					break;
			}

			$output .= '.gif" alt="" />';
		}

		return $output;
	}

	/**
	 * Displays the average score for the current page
	 * and the total amount of votes.
	 */
	function displayScore() {
		$count = $this->count();
		return wfMsg( 'vote-community-score', '<b>' . $this->getAverageVote() . '</b>' ) .
				' (' . wfMsgExt( 'vote-ratings', 'parsemag', $count ) . ')';
	}

}
