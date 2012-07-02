<?php
/**
 * Special:TopAwards -- a special page to show the awards with the most
 * recipients (I think)
 *
 * @file
 * @ingroup Extensions
 */

class TopAwards extends UnlistedSpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'TopAwards' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser, $wgSystemGiftsScripts, $wgUserStatsPointValues;

		// Variables
		$gift_name_check = '';
		$x = 0;
		$category_number = $wgRequest->getInt( 'category' );

		// System gift class array
		// The 'category_name' key is used to build the appropriate i18n
		// message keys later on in the code; 'category_id' corresponds to
		// system_gift.gift_category. Valid categories and their numbers are
		// the same that are shown on Special:SystemGiftManager, which are:
		// 1: edit, 2: vote, 3: comment, 4: comment_plus, 5: opinions_created,
		// 6: opinions_pub, 7: referral_complete, 8: friend, 9: foe,
		// 10: challenges_won, 11: gift_rec, 12: points_winner_weekly,
		// 13: points_winner_monthly, 14: quiz_points
		//
		// @todo I really think that this should be configurable, the way the
		// navigation bar (MediaWiki:Topfans-by-category) shown on
		// Special:TopUsers and related special pages is...this is ugly and
		// far from flexible, since the thresholds are all hard-coded in
		$categories = array(
			array(
				'category_name' => 'Edit',
				'category_threshold' => '500',
				'category_id' => 1
			),
			array(
				'category_name' => 'Friend',
				'category_threshold' => '25',
				'category_id' => 8
			)
		);

		// VoteStars is unique to the VoteNY extension, while there are a bunch
		// of other voting extensions where the main class is named "Vote"
		if ( class_exists( 'VoteStars' ) ) {
			$categories[] = array(
				'category_name' => 'Vote',
				'category_threshold' => '2000',
				'category_id' => 2
			);
		}

		// Show the "Comments" category only if the Comments extension is
		// installed
		if ( class_exists( 'Comment' ) ) {
			$categories[] = array(
				'category_name' => 'Comment',
				'category_threshold' => '1000',
				'category_id' => 3
			);
		}

		// Well, we could test for the existence of the extension which allows
		// for referring users to the wiki so that you get points for it, but
		// this seems like a better thing to check for.
		if ( $wgUserStatsPointValues['referral_complete'] > 0 ) {
			$categories[] = array(
				'category_name' => 'Recruit',
				'category_threshold' => '0',
				'category_id' => 7
			);
		}

		// Set title
		if ( !( $category_number ) || $category_number > 4 ) {
			$category_number = 0;
			$page_category = $categories[$category_number]['category_name'];
		} else {
			$page_category = $categories[$category_number]['category_name'];
		}

		// Database calls
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'user_system_gift', 'system_gift' ),
			array(
				'sg_user_name', 'sg_user_id', 'gift_category',
				'MAX(gift_threshold) AS top_gift'
			),
			array(
				"gift_category = {$categories[$category_number]['category_id']}",
				"gift_threshold > {$categories[$category_number]['category_threshold']}"
			),
			__METHOD__,
			array( 'GROUP BY' => 'sg_user_name', 'ORDER BY' => 'top_gift DESC' ),
			array( 'system_gift' => array( 'INNER JOIN', 'gift_id=sg_gift_id' ) )
		);

		// Page title
		// for grep: topawards-edit-title, topawards-vote-title,
		// topawards-comment-title, topawards-recruit-title,
		// topawards-friend-title
		$wgOut->setPageTitle(
			wfMsg( 'topawards-' . strtolower( $page_category ) . '-title' )
		);

		// Add CSS
		$wgOut->addExtensionStyle( $wgSystemGiftsScripts . '/SystemGift.css' );

		$output = '<div class="top-awards-navigation">
			<h1>' . wfMsg( 'topawards-award-categories' ) . '</h1>';

		$nav_x = 0;

		// Build the award categories menu on the right side of the page
		foreach ( $categories as $awardType ) {
			// for grep: topawards-edits, topawards-votes,
			// topawards-comments, topawards-recruits, topawards-friends
			$msg = wfMsg(
				'topawards-' .
				strtolower( $awardType['category_name'] ) . 's'
			);
			if ( $nav_x == $category_number ) {
				$output .= "<p><b>{$msg}</b></p>";
			} else {
				$output .= '<p><a href="' . $this->getTitle()->escapeFullURL(
					"category={$nav_x}" ) . "\">{$msg}</a></p>";
			}
			$nav_x++;
		}

		$output .= '</div>';
		$output .= '<div class="top-awards">';

		// Display a "no results" message if we got no results -- because it's
		// a lot nicer to display something rather than a half-empty page
		if ( $dbr->numRows( $res ) <= 0 ) {
			$output .= wfMsg( 'topawards-empty' );
		} else {
			foreach ( $res as $row ) {
				$user_name = $row->sg_user_name;
				$user_id = $row->sg_user_id;
				$avatar = new wAvatar( $user_id, 'm' );
				$top_gift = $row->top_gift;
				$lower = strtolower( $categories[$category_number]['category_name'] );
				// for grep: topawards-edit-milestone, topawards-vote-milestone,
				// topawards-comment-milestone, topawards-recruit-milestone,
				// topawards-friend-milestone
				$gift_name = wfMsgExt(
					'topawards-' . $lower . '-milestone',
					'parsemag',
					$top_gift
				);

				if ( $gift_name !== $gift_name_check ) {
					$x = 1;
					$output .= "<div class=\"top-award-title\">
					{$gift_name}
				</div>";
				} else {
					$x++;
				}

				$userLink = $wgUser->getSkin()->link(
					Title::makeTitle( NS_USER, $row->sg_user_name ),
					$user_name
				);
				$output .= "<div class=\"top-award\">
					<span class=\"top-award-number\">{$x}.</span>
					{$avatar->getAvatarURL()}
					{$userLink}
				</div>";

				$gift_name_check = $gift_name;
			}
		}

		$output .= '</div>
		<div class="cleared"></div>';

		$wgOut->addHTML( $output );
	}
}