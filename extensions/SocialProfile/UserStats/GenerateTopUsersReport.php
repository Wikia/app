<?php
/**
 * A special page to generate the report of the users who earned the most
 * points during the past week or month. This is the only way to update the
 * points_winner_weekly and points_winner_monthly columns in the user_stats
 * table.
 *
 * This special page also creates a weekly report in the project namespace.
 * The name of that page is controlled by two system messages,
 * MediaWiki:User-stats-report-weekly-page-title and
 * MediaWiki:User-stats-report-monthly-page-title (depending on the type of the
 * report).
 *
 * @file
 * @ingroup Extensions
 */
class GenerateTopUsersReport extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'GenerateTopUsersReport', 'generatetopusersreport' );
	}

	/**
	 * Show the special page
	 *
	 * @param $period String: either weekly or monthly
	 */
	public function execute( $period ) {
		global $wgUser, $wgOut, $wgRequest, $wgContLang, $wgScriptPath;
		global $wgUserStatsPointValues;

		// Blocked through Special:Block? Tough luck.
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage( false );
			return false;
		}

		// Is the database locked or not?
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return false;
		}

		// Check for the correct permission
		if( !$wgUser->isAllowed( 'generatetopusersreport' ) ) {
			$wgOut->permissionRequired( 'generatetopusersreport' );
			return false;
		}

		// Set the page title, robot policy, etc.
		$this->setHeaders();

		$period = $wgRequest->getVal( 'period', $period );

		// If we don't have a period, default to weekly or else we'll be
		// hitting a database error because when constructing table names
		// later on in the code, we assume that $period is set to something
		if ( !$period ) {
			$period = 'weekly';
		}

		// Make sure that we are actually going to give out some extra points
		// for weekly and/or monthly wins, depending on which report we're
		// generating here. If not, there's no point in continuing.
		if ( empty( $wgUserStatsPointValues["points_winner_{$period}"] ) ) {
			$wgOut->addHTML( wfMsg( 'user-stats-report-error-variable-not-set', $period ) );
			return;
		}

		// There used to be a lot of inline CSS here in the original version.
		// I removed that, because most of it is already in TopList.css, inline
		// CSS (and JS, for that matter) is evil, there were only 5 CSS
		// declarations that weren't in TopList.css and it was making the
		// display look worse, not better.

		// Add CSS
		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/SocialProfile/UserStats/TopList.css' );

		// Used as the LIMIT for SQL queries; basically, show this many users
		// in the generated reports.
		$user_count = $wgRequest->getInt( 'user_count', 10 );

		if( $period == 'weekly' ) {
			$period_title = $wgContLang->date( wfTimestamp( TS_MW, strtotime( '-1 week' ) ) ) .
				'-' . $wgContLang->date( wfTimestampNow() );
		} elseif ( $period == 'monthly' ) {
			$date = getdate(); // It's a PHP core function
			$period_title = $wgContLang->getMonthName( $date['mon'] ) .
				' ' . $date['year'];
		}

		$dbw = wfGetDB( DB_MASTER );
		// Query the appropriate points table
		$res = $dbw->select(
			"user_points_{$period}",
			array( 'up_user_id', 'up_user_name', 'up_points' ),
			array(),
			__METHOD__,
			array( 'ORDER BY' => 'up_points DESC', 'LIMIT' => $user_count )
		);

		$last_rank = 0;
		$last_total = 0;
		$x = 1;

		$users = array();

		// Initial run is a special case
		if ( $dbw->numRows( $res ) <= 0 ) {
			// For the initial run, everybody's a winner!
			// Yes, I know that this isn't ideal and I'm sorry about that.
			// The original code just wouldn't work if the first query
			// (the $res above) returned nothing so I had to work around that
			// limitation.
			$res = $dbw->select(
				'user_stats',
				array( 'stats_user_id', 'stats_user_name', 'stats_total_points' ),
				array(),
				__METHOD__,
				array(
					'ORDER BY' => 'stats_total_points DESC',
					'LIMIT' => $user_count
				)
			);

			$out = '<div class="top-users">';

			foreach( $res as $row ) {
				if( $row->stats_total_points == $last_total ) {
					$rank = $last_rank;
				} else {
					$rank = $x;
				}
				$last_rank = $x;
				$last_total = $row->stats_total_points;
				$x++;
				$users[] = array(
					'user_id' => $row->stats_user_id,
					'user_name' => $row->stats_user_name,
					'points' => $row->stats_total_points,
					'rank' => $rank
				);
			}
		} else {
			$out = '<div class="top-users">';

			foreach( $res as $row ) {
				if( $row->up_points == $last_total ) {
					$rank = $last_rank;
				} else {
					$rank = $x;
				}
				$last_rank = $x;
				$last_total = $row->up_points;
				$x++;
				$users[] = array(
					'user_id' => $row->up_user_id,
					'user_name' => $row->up_user_name,
					'points' => $row->up_points,
					'rank' => $rank
				);
			}
		}

		$winner_count = 0;
		$winners = '';

		if ( !empty( $users ) ) {
			$localizedUserNS = $wgContLang->getNsText( NS_USER );
			foreach ( $users as $user ) {
				if ( $user['rank'] == 1 ) {
					// Mark the user ranked #1 as the "winner" for the given
					// period
					$stats = new UserStatsTrack( $user['user_id'], $user['user_name'] );
					$stats->incStatField( "points_winner_{$period}" );
					if( $winners ) {
						$winners .= ', ';
					}
					$winners .= "[[{$localizedUserNS}:{$user['user_name']}|{$user['user_name']}]]";
					$winner_count++;
				}
			}
		}

		// Start building the content of the report page
		$pageContent = "__NOTOC__\n";

		// For grep: user-stats-weekly-winners, user-stats-monthly-winners
		$pageContent .= '==' . wfMsgExt(
			"user-stats-{$period}-winners",
			array( 'parsemag', 'content' ),
			$winner_count
		) . "==\n\n";

		// For grep: user-stats-weekly-win-congratulations, user-stats-monthly-win-congratulations
		$pageContent .= wfMsgExt(
			"user-stats-{$period}-win-congratulations",
			array( 'parsemag', 'content' ),
			$winner_count,
			$wgContLang->formatNum( $wgUserStatsPointValues["points_winner_{$period}"] )
		) . "\n\n";
		$pageContent .= "=={$winners}==\n\n<br />\n";

		$pageContent .= '==' . wfMsgForContent( 'user-stats-full-top', $wgContLang->formatNum( $user_count ) ) . "==\n\n";

		foreach( $users as $user ) {
			$userTitle = Title::makeTitle( NS_USER, $user['user_name'] );
			$pageContent .= wfMsgExt(
				'user-stats-report-row',
				array( 'content', 'parsemag' ),
				$wgContLang->formatNum( $user['rank'] ),
				$user['user_name'],
				$wgContLang->formatNum( $user['points'] )
			) . "\n\n";

			$out .= "<div class=\"top-fan-row\">
			<span class=\"top-fan-num\">{$user['rank']}</span><span class=\"top-fan\"> <a href='" .
				$userTitle->getFullURL() . "' >" . $user['user_name'] . "</a>
			</span>";

			$out .= '<span class="top-fan-points">' . wfMsgExt(
				'user-stats-report-points',
				array( 'content', 'parsemag' ),
				$wgContLang->formatNum( $user['points'] )
			) . '</span>
		</div>';
		}

		// Make the edit as MediaWiki default
		$oldUser = $wgUser;
		$wgUser = User::newFromName( 'MediaWiki default' );
		$wgUser->addGroup( 'bot' );

		// Add a note to the page that it was automatically generated
		$pageContent .= "\n\n''" . wfMsgForContent( 'user-stats-report-generation-note' ) . "''\n\n";

		// Create the Title object that represents the report page
		// For grep: user-stats-report-weekly-page-title, user-stats-report-monthly-page-title
		$title = Title::makeTitleSafe(
			NS_PROJECT,
			wfMsgForContent( "user-stats-report-{$period}-page-title", $period_title )
		);

		$article = new Article( $title );
		// If the article doesn't exist, create it!
		// @todo Would there be any point in updating a pre-existing article?
		// I think not, but...
		if( !$article->exists() ) {
			// For grep: user-stats-report-weekly-edit-summary, user-stats-report-monthly-edit-summary
			$article->doEdit(
				$pageContent,
				wfMsgForContent( "user-stats-report-{$period}-edit-summary" )
			);
			$date = date( 'Y-m-d H:i:s' );
			// Archive points from the weekly/monthly table into the archive
			// table
			$dbw->insertSelect(
				'user_points_archive',
				"user_points_{$period}",
				array(
					'up_user_name' => 'up_user_name',
					'up_user_id' => 'up_user_id',
					'up_points' => 'up_points',
					'up_period' => ( ( $period == 'weekly' ) ? 1 : 2 ),
					'up_date' => $dbw->addQuotes( $date )
				),
				'*',
				__METHOD__
			);

			// Clear the current point table to make way for the next period
			$res = $dbw->delete( "user_points_{$period}", '*', __METHOD__ );
		}

		// Switch the user back
		$wgUser = $oldUser;

		$out .= '</div>'; // .top-users
		$wgOut->addHTML( $out );
	}
}
