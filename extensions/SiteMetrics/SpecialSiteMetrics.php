<?php
/**
 * A special page for tracking usage of different kinds of social features.
 * @file
 * @ingroup Extensions
 */

class SiteMetrics extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'SiteMetrics', 'metricsview' );
	}

	function formatDate( $date ) {
		$date_array = explode( ' ', $date );

		$year = $date_array[0];
		$month = $date_array[1];

		$time = mktime( 0, 0, 0, $month, 1, '20' . $year );
		return date( 'm', $time ) . '/' . date( 'y', $time );
	}

	function formatDateDay( $date ) {
		$date_array = explode( ' ', $date );

		$year = $date_array[0];
		$month = $date_array[1];
		$day = $date_array[2];

		$time = mktime( 0, 0, 0, $month, $day, '20' . $year );
		return date( 'm', $time ) . '/' . date( 'd', $time ) . '/' . date( 'y', $time );
	}

	function displayChart( $stats ) {
		// reverse stats array so that chart outputs correctly
		$reversed_stats = array_reverse( $stats );

		// determine the maximum count
		$max = 0;
		for( $x = 0; $x <= count( $reversed_stats ) - 1; $x++ ) {
			if ( $reversed_stats[$x]['count'] > $max ) {
				$max = $reversed_stats[$x]['count'];
			}
		}

		// Write Google Charts API script to generate graph
		$output = "<script type=\"text/javascript\">

		var simpleEncoding = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		var maxValue = '{$max}';
		var valueArray = new Array(";

		$first_date = '';
		$last_date = '';
		for( $x = 0; $x <= count( $reversed_stats ) - 1; $x++ ) {
			// get first and last dates
			if ( $x == 0 ) {
				$first_date = $reversed_stats[$x]['date'];
			}
			if ( $x == count( $stats ) - 1 ) {
				$last_date = $reversed_stats[$x]['date'];
			}

			// make value array for Charts API
			$output .= $reversed_stats[$x]['count'];
			if ( $x != count( $stats ) - 1 ) {
				$output .= ',';
			}
		}

		$output .= ");

		function simpleEncode( valueArray, maxValue ) {
			var chartData = ['s:'];
			for ( var i = 0; i < valueArray.length; i++ ) {
				var currentValue = valueArray[i];
				if ( !isNaN( currentValue ) && currentValue >= 0 ) {
					chartData.push( simpleEncoding.charAt( Math.round( ( simpleEncoding.length - 1 ) * currentValue / maxValue ) ) );
				} else {
					chartData.push('_');
				}
			}
			return chartData.join('');
		}

		imgSrc = '<img src=\"http://chart.apis.google.com/chart?chs=400x200&amp;cht=lc&amp;chd='+simpleEncode(valueArray,maxValue)+'&amp;chco=ff0000&amp;chg=20,50,1,5&amp;chxt=x,y&amp;chxl=0:|{$first_date}|{$last_date}|1:||" . number_format( $max ) . "\"/>';

		document.write( imgSrc );

		</script>";

		return $output;
	}

	/**
	 * @param $title Mixed: title - what kind of stats are we viewing?
	 * @param $res Object: ResultWrapper object
	 * @param $type String: 'day' for daily stats, 'month' for monthly stats.
	 */
	function displayStats( $title, $res, $type ) {
		$dbr = wfGetDB( DB_SLAVE );

		// build stats array
		$stats = array();
		foreach ( $res as $row ) {
			if ( $type == 'month' ) {
				$stats[] = array(
					'date' => $this->formatDate( $row->the_date ),
					'count' => $row->the_count
				);
			} elseif ( $type == 'day' ) {
				$stats[] = array(
					'date' => $this->formatDateDay( $row->the_date ),
					'count' => $row->the_count
				);
			}
		}

		$output = '';
		$output .= "<h3>{$title}</h3>";

		$output .= $this->displayChart( $stats );

		$output .= '<table class="smt-table">
			<tr class="smt-header">
				<td>' . wfMsg( 'sitemetrics-date' ) . '</td>
				<td>' . wfMsg( 'sitemetrics-count' ) . '</td>
				<td>' . wfMsg( 'sitemetrics-difference' ) . '</td>
			</tr>';

		for ( $x = 0; $x <= count( $stats ) - 1; $x++ ) {
			$diff = '';
			if ( $x != count( $stats ) - 1 ) {
				$diff = $stats[$x]['count'] - $stats[$x + 1]['count'];
				if ( $diff > 0 ) {
					$diff = "+{$diff}";
				} else {
					$diff = "{$diff}";
				}
			}
			$output .= "<tr>
					<td>{$stats[$x]['date']}</td>
					<td>" . number_format( $stats[$x]['count'] ) . "</td>
					<td>{$diff}</td>
				</tr>";
		}

		$output .= '</table>';

		return $output;
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgScriptPath, $wgOut, $wgUser, $wgRegisterTrack;

		// Check the the user is allowed to access this page
		if ( !$wgUser->isAllowed( 'metricsview' ) ) {
			$this->displayRestrictionError();
			return;
		}

		// If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		$output = '';

		// Add CSS
		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$wgOut->addModuleStyles( 'ext.siteMetrics' );
		} else {
			$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/SiteMetrics/SiteMetrics.css' );
		}

		$statistic = $wgRequest->getVal( 'stat' );
		$pageTitle = ''; // page title, will be set later for each diff. query
		// This is required to make Special:SiteMetrics/param work...
		if( !isset( $statistic ) ) {
			if ( $par ) {
				$statistic = $par;
			} else {
				$statistic = 'Edits';
			}
		}
		// An odd fix to make links like [[Special:SiteMetrics/Wall Messages]]
		// work properly...
		$statistic = str_replace( array( '_', '%20' ), ' ', $statistic );

		$statLink = SpecialPage::getTitleFor( 'SiteMetrics' );

		$dbr = wfGetDB( DB_SLAVE );

		$output .= '<div class="sm-navigation">
				<h2>' . wfMsg( 'sitemetrics-content-header' ) . '</h2>
				<a href="' . $statLink->escapeFullURL( 'stat=Edits' ) . '">' . wfMsg( 'sitemetrics-edits' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=Main Namespace Edits' ) . '">' . wfMsg( 'sitemetrics-main-ns' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=New Main Namespace Articles' ) . '">' . wfMsg( 'sitemetrics-new-articles' ) . '</a>';
		// On March 26, 2010: these stats don't seem to be existing and
		// will only be confusing to end users, so I'm disabling them for now.
		//		<a href="' . $statLink->escapeFullURL( 'stat=Users Greater Than 5 Edits' ) . '">' . wfMsg( 'sitemetrics-greater-5-edits' ) . '</a>
		//		<a href="' . $statLink->escapeFullURL( 'stat=Users Greater Than 100 Edits' ) . '">' . wfMsg( 'sitemetrics-greater-100-edits' ) . '</a>
		$output .= '<a href="' . $statLink->escapeFullURL( 'stat=Anonymous Edits' ) . '">' . wfMsg( 'sitemetrics-anon-edits' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=Images' ) . '">' . wfMsg( 'sitemetrics-images' ) . '</a>';
		if ( class_exists( 'Video' ) ) {
			$output .= '<a href="' . $statLink->escapeFullURL( 'stat=Video' ) . '">' . wfMsg( 'sitemetrics-video' ) . '</a>';
		}

		$output .= '<h2>' . wfMsg( 'sitemetrics-user-social-header' ) . '</h2>
				<a href="' . $statLink->escapeFullURL( 'stat=New Users' ) . '">' . wfMsg( 'sitemetrics-new-users' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=Avatar Uploads' ) . '">' . wfMsg( 'sitemetrics-avatars' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=Profile Updates' ) . '">' . wfMsg( 'sitemetrics-profile-updates' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=User Page Edits' ) . '">' . wfMsg( 'sitemetrics-user-page-edits' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=Friendships' ) . '">' . wfMsg( 'sitemetrics-friendships' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=Foeships' ) . '">' . wfMsg( 'sitemetrics-foeships' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=Gifts' ) . '">' . wfMsg( 'sitemetrics-gifts' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=Wall Messages' ) . '">' . wfMsg( 'sitemetrics-wall-messages' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=User Talk Messages' ) . '">' . wfMsg( 'sitemetrics-talk-messages' ) . '</a>

				<h2>' . wfMsg( 'sitemetrics-point-stats-header' ) . '</h2>
				<a href="' . $statLink->escapeFullURL( 'stat=Awards' ) . '">' . wfMsg( 'sitemetrics-awards' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=Honorific Advancements' ) . '">' . wfMsg( 'sitemetrics-honorifics' ) . '</a>';

		// Only display links to casual game statistics if said extensions are
		// installed...
		if (
			class_exists( 'QuizGameHome' ) ||
			class_exists( 'Poll' ) ||
			class_exists( 'PictureGameHome' )
		)
		{
			$output .= '<h2>' . wfMsg( 'sitemetrics-casual-game-stats' ) . '</h2>';
			if ( class_exists( 'Poll' ) ) {
				$output .= '<a href="' . $statLink->escapeFullURL( 'stat=Polls Created' ) . '">' . wfMsg( 'sitemetrics-polls-created' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=Polls Taken' ) . '">' . wfMsg( 'sitemetrics-polls-taken' ) . '</a>';
			}
			if ( class_exists( 'PictureGameHome' ) ) {
				$output .= '<a href="' . $statLink->escapeFullURL( 'stat=Picture Games Created' ) . '">' . wfMsg( 'sitemetrics-picgames-created' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=Picture Games Taken' ) . '">' . wfMsg( 'sitemetrics-picgames-taken' ) . '</a>';
			}
			if ( class_exists( 'QuizGameHome' ) ) {
				$output .= '<a href="' . $statLink->escapeFullURL( 'stat=Quizzes Created' ) . '">' . wfMsg( 'sitemetrics-quizzes-created' ) . '</a>
				<a href="' . $statLink->escapeFullURL( 'stat=Quizzes Taken' ) . '">' . wfMsg( 'sitemetrics-quizzes-taken' ) . '</a>';
			}
		}

		// Show the "Blog and Voting Statistics" header only if at least some
		// of said features are enabled...
		if (
			class_exists( 'BlogPage' ) || $dbr->tableExists( 'Vote' ) ||
			$dbr->tableExists( 'Comments' ) || $dbr->tableExists( 'user_email_track' )
		)
		{
			$output .= '<h2>' . wfMsg( 'sitemetrics-blog-stats-header' ) . '</h2>';
		}
		if ( class_exists( 'BlogPage' ) ) {
			$output .= '<a href="' . $statLink->escapeFullURL( 'stat=New Blog Pages' ) . '">' . wfMsg( 'sitemetrics-new-blogs' ) . '</a>';
		}
		if ( $dbr->tableExists( 'Vote' ) ) {
			$output .= '<a href="' . $statLink->escapeFullURL( 'stat=Votes and Ratings' ) . '">' . wfMsg( 'sitemetrics-votes' ) . '</a>';
		}
		if ( $dbr->tableExists( 'Comments' ) ) {
			$output .= '<a href="' . $statLink->escapeFullURL( 'stat=Comments' ) . '">' . wfMsg( 'sitemetrics-comments' ) . '</a>';
		}
		if ( $dbr->tableExists( 'user_email_track' ) && class_exists( 'InviteEmail' ) ) {
			$output .= '<a href="' . $statLink->escapeFullURL( 'stat=Invitations to Read Blog Page' ) . '">' . wfMsg( 'sitemetrics-invites' ) . '</a>';
		}

		// Again, show the "Viral Statistics" header only if registration/email
		// tracking is enabled
		if (
			$dbr->tableExists( 'user_register_track' ) && $wgRegisterTrack ||
			$dbr->tableExists( 'user_email_track' )
		)
		{
			$output .= '<h2>' . wfMsg( 'sitemetrics-viral-stats' ) . '</h2>';
		}
		if ( $dbr->tableExists( 'user_email_track' ) ) {
			$output .= '<a href="' . $statLink->escapeFullURL( 'stat=Contact Invites' ) . '">' . wfMsg( 'sitemetrics-contact-imports' ) . '</a>';
		}
		// Only show the "User Recruits" link if
		// 1) the table user_register_track exists and
		// 2) registration tracking is enabled
		if ( $dbr->tableExists( 'user_register_track' ) && $wgRegisterTrack ) {
			$output .= '<a href="' . $statLink->escapeFullURL( 'stat=User Recruits' ) . '">' . wfMsg( 'sitemetrics-user-recruits' ) . '</a>';
		}
		$output .= '</div>
		<div class="sm-content">';

		if ( $statistic == 'Edits' ) {
			$pageTitle = wfMsg( 'sitemetrics-edits' );
			$sql = "SELECT COUNT(*) AS the_count,
				DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) AS the_date
				FROM {$dbr->tableName( 'revision' )} WHERE rev_user_text <> 'MLB Stats Bot'
				GROUP BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' )
				ORDER BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) DESC
				LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-total-edits-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'revision' )} WHERE rev_user_text <> 'MLB Stats Bot'
					GROUP BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' )
					ORDER BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-total-edits-day' ), $res, 'day' );
		} elseif ( $statistic == 'Main Namespace Edits' ) {
			$pageTitle = wfMsg( 'sitemetrics-main-ns' );
			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'revision' )}
					INNER JOIN {$dbr->tableName( 'page' )} ON rev_page=page_id WHERE page_namespace=0
					GROUP BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' )
					ORDER BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y  %m' )
					DESC LIMIT 0,12;";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-main-ns-edits-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'revision' )} INNER JOIN {$dbr->tableName( 'page' )} ON rev_page=page_id WHERE page_namespace=0
					GROUP BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' )
					ORDER BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y  %m %d' )
					DESC LIMIT 0,120;";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-main-ns-edits-day' ), $res, 'day' );
		} elseif ( $statistic == 'New Main Namespace Articles' ) {
			$pageTitle = wfMsg( 'sitemetrics-new-articles' );
			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1) , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'page' )}
					WHERE page_namespace=0
					GROUP BY DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m' )
					ORDER BY DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m' ) DESC
					LIMIT 0,12;";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-new-articles-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1) , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'page' )}
					WHERE page_namespace=0
					GROUP BY DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m %d' )
					ORDER BY DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m %d' ) DESC
					LIMIT 0,120;";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-new-articles-day' ), $res, 'day' );
		} elseif ( $statistic == 'Anonymous Edits' ) {
			$pageTitle = wfMsg( 'sitemetrics-anon-edits' );
			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'revision' )}
					WHERE rev_user = 0
					GROUP BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' )
					ORDER BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-anon-edits-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'revision' )}
					WHERE rev_user = 0
					GROUP BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' )
					ORDER BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-anon-edits-day' ), $res, 'day' );
		} elseif ( $statistic == 'Images' ) {
			$pageTitle = wfMsg( 'sitemetrics-images' );
			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m')  AS the_date
					FROM {$dbr->tableName( 'image' )}
					GROUP BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m')
					ORDER BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m') DESC
					LIMIT 0,12";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-images-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m %d')  AS the_date
					FROM {$dbr->tableName( 'image' )}
					GROUP BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m %d')
					ORDER BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(img_timestamp)), '%y %m %d') DESC
					LIMIT 0,120";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-images-day' ), $res, 'day' );
		} elseif ( $statistic == 'Video' ) {
			$pageTitle = wfMsg( 'sitemetrics-video' );
			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1) , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'page' )}
					WHERE page_namespace=400
					GROUP BY DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m' )
					ORDER BY DATE_FORMAT( (select FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m' ) DESC
					LIMIT 0,12";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-video-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1) , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'page' )}
					WHERE page_namespace=400
					GROUP BY DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m %d' )
					ORDER BY DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m %d' ) DESC
					LIMIT 0,120";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-video-day' ), $res, 'day' );
		} elseif ( $statistic == 'New Users' ) {
			$pageTitle = wfMsg( 'sitemetrics-new-users' );
			if ( $dbr->tableExists( 'user_register_track' ) && $wgRegisterTrack ) {
				$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `ur_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'user_register_track' )}
					GROUP BY DATE_FORMAT( `ur_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `ur_date` , '%y %m' ) DESC
					LIMIT 0,12";
				$res = $dbr->query( $sql, __METHOD__ );
				$output .= $this->displayStats( wfMsg( 'sitemetrics-new-users-month' ), $res, 'month' );

				$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `ur_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'user_register_track' )}
					GROUP BY DATE_FORMAT( `ur_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `ur_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
				$res = $dbr->query( $sql, __METHOD__ );
				$output .= $this->displayStats( wfMsg( 'sitemetrics-new-users-day' ), $res, 'day' );
			} else { // normal new user stats for this wiki from new user log
				$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d') AS the_date
					FROM {$dbr->tableName( 'logging' )}
					WHERE log_type='newusers'
					GROUP BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d')
					ORDER BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d') DESC
					LIMIT 0,12";
				$res = $dbr->query( $sql, __METHOD__ );
				$output .= $this->displayStats( wfMsg( 'sitemetrics-new-users-month' ), $res, 'month' );

				$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d') AS the_date
					FROM {$dbr->tableName( 'logging' )}
					WHERE log_type='newusers'
					GROUP BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d')
					ORDER BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d') DESC
					LIMIT 0,120";
				$res = $dbr->query( $sql, __METHOD__ );
				$output .= $this->displayStats( wfMsg( 'sitemetrics-new-users-day' ), $res, 'day' );
			}
		} elseif ( $statistic == 'Avatar Uploads' ) {
			$pageTitle = wfMsg( 'sitemetrics-avatars' );
			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m') AS the_date
					FROM {$dbr->tableName( 'logging' )}
					WHERE log_type='avatar'
					GROUP BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m')
					ORDER BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m') DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-avatars-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d') AS the_date
					FROM {$dbr->tableName( 'logging' )}
					WHERE log_type='avatar'
					GROUP BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d')
					ORDER BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d') DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-avatars-day' ), $res, 'day' );
		} elseif ( $statistic == 'Profile Updates' ) {
			$pageTitle = wfMsg( 'sitemetrics-profile-updates' );
			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m') AS the_date
					FROM {$dbr->tableName( 'logging' )}
					WHERE log_type='profile'
					GROUP BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m')
					ORDER BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m') DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-profile-updates-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d') AS the_date
					FROM {$dbr->tableName( 'logging' )}
					WHERE log_type='profile'
					GROUP BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d')
					ORDER BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(log_timestamp)), '%y %m %d') DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-profile-updates-day' ), $res, 'day' );
		} elseif ( $statistic == 'Friendships' ) {
			$pageTitle = wfMsg( 'sitemetrics-friendships' );
			$sql = "SELECT COUNT(*)/2 AS the_count, DATE_FORMAT( `r_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'user_relationship' )}
					WHERE r_type=1
					GROUP BY DATE_FORMAT( `r_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `r_date` , '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-friendships-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*)/2 AS the_count, DATE_FORMAT( `r_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'user_relationship' )}
					WHERE r_type=1
					GROUP BY DATE_FORMAT( `r_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `r_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-friendships-day' ), $res, 'day' );
		} elseif ( $statistic == 'Foeships' ) {
			$pageTitle = wfMsg( 'sitemetrics-foeships' );
			$sql = "SELECT COUNT(*)/2 AS the_count, DATE_FORMAT( `r_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'user_relationship' )}
					WHERE r_type=2
					GROUP BY DATE_FORMAT( `r_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `r_date` , '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-foeships-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*)/2 AS the_count, DATE_FORMAT( `r_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'user_relationship' )}
					WHERE r_type=2
					GROUP BY DATE_FORMAT( `r_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `r_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-foeships-day' ), $res, 'day' );
		} elseif ( $statistic == 'Gifts' ) {
			$pageTitle = wfMsg( 'sitemetrics-gifts' );
			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `ug_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'user_gift' )}
					GROUP BY DATE_FORMAT( `ug_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `ug_date` , '%y %m' ) DESC
					LIMIT 0,12";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-gifts-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `ug_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'user_gift' )}
					GROUP BY DATE_FORMAT( `ug_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `ug_date` , '%y %m %d' ) DESC
					LIMIT 0,120";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-gifts-day' ), $res, 'day' );
		} elseif ( $statistic == 'Wall Messages' ) {
			$pageTitle = wfMsg( 'sitemetrics-wall-messages' );
			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ub_date)), '%y %m') AS the_date
					FROM {$dbr->tableName( 'user_board' )}
					GROUP BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ub_date)), '%y %m')
					ORDER BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ub_date)), '%y %m') DESC
					LIMIT 0,12";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-wall-messages-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ub_date)), '%y %m %d') AS the_date
					FROM {$dbr->tableName( 'user_board' )}
					GROUP BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ub_date)), '%y %m %d')
					ORDER BY DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(ub_date)), '%y %m %d') DESC
					LIMIT 0,120";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-wall-messages-day' ), $res, 'day' );
		} elseif ( $statistic == 'User Page Edits' ) {
			$pageTitle = wfMsg( 'sitemetrics-user-page-edits' );
			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'revision' )}
					INNER JOIN {$dbr->tableName( 'page' )} ON rev_page=page_id
					WHERE page_namespace=2
					GROUP BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' )
					ORDER BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) DESC
					LIMIT 0,12;";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-user-page-edits-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'revision' )}
					INNER JOIN {$dbr->tableName( 'page' )} ON rev_page=page_id
					WHERE page_namespace=2
					GROUP BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' )
					ORDER BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y  %m %d' ) DESC
					LIMIT 0,120;";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-user-page-edits-day' ), $res, 'day' );
		} elseif ( $statistic == 'User Talk Messages' ) {
			$pageTitle = wfMsg( 'sitemetrics-talk-messages' );
			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'revision' )}
					INNER JOIN {$dbr->tableName( 'page' )} ON rev_page=page_id
					WHERE page_namespace=3
					GROUP BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' )
					ORDER BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m' ) DESC
					LIMIT 0,12;";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-talk-messages-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'revision' )}
					INNER JOIN {$dbr->tableName( 'page' )} ON rev_page=page_id
					WHERE page_namespace=3
					GROUP BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y %m %d' )
					ORDER BY DATE_FORMAT( FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp)), '%y  %m %d' ) DESC
					LIMIT 0,120;";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-talk-messages-day' ), $res, 'day' );
		} elseif ( $statistic == 'Polls Created' ) {
			$pageTitle = wfMsg( 'sitemetrics-polls-created' );
			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `poll_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'poll_question' )}
					GROUP BY DATE_FORMAT( `poll_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `poll_date` , '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-polls-created-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `poll_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'poll_question' )}
					GROUP BY DATE_FORMAT( `poll_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `poll_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-polls-created-day' ), $res, 'day' );
		} elseif ( $statistic == 'Polls Taken' ) {
			$pageTitle = wfMsg( 'sitemetrics-polls-taken' );
			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `pv_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'poll_user_vote' )}
					GROUP BY DATE_FORMAT( `pv_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `pv_date` , '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-polls-taken-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `pv_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'poll_user_vote' )}
					GROUP BY DATE_FORMAT( `pv_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `pv_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-polls-taken-day' ), $res, 'day' );
		} elseif ( $statistic == 'Picture Games Created' ) {
			$pageTitle = wfMsg( 'sitemetrics-picgames-created' );
			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `pg_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'picturegame_images' )}
					GROUP BY DATE_FORMAT( `pg_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `pg_date` , '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-picgames-created-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `pg_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'picturegame_images' )}
					GROUP BY DATE_FORMAT( `pg_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `pg_date` , '%y %m %d' ) DESC
					LIMIT 0,6";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-picgames-created-day' ), $res, 'day' );
		} elseif ( $statistic == 'Picture Games Taken' ) {
			$pageTitle = wfMsg( 'sitemetrics-picgames-taken' );
			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `vote_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'picturegame_votes' )}
					GROUP BY DATE_FORMAT( `vote_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `vote_date` , '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-picgames-taken-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `vote_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'picturegame_votes' )}
					GROUP BY DATE_FORMAT( `vote_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `vote_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-picgames-taken-day' ), $res, 'day' );
		} elseif ( $statistic == 'Quizzes Created' ) {
			$pageTitle = wfMsg( 'sitemetrics-quizzes-created' );
			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `q_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'quizgame_questions' )}
					GROUP BY DATE_FORMAT( `q_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `q_date` , '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-quizzes-created-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `q_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'quizgame_questions' )}
					GROUP BY DATE_FORMAT( `q_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `q_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-quizzes-created-day' ), $res, 'day' );
		} elseif ( $statistic == 'Quizzes Taken' ) {
			$pageTitle = wfMsg( 'sitemetrics-quizzes-taken' );
			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `a_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'quizgame_answers' )}
					GROUP BY DATE_FORMAT( `a_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `a_date` , '%y %m' ) DESC
					LIMIT 0,12";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-quizzes-taken-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `a_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'quizgame_answers' )}
					GROUP BY DATE_FORMAT( `a_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `a_date` , '%y %m %d' ) DESC
					LIMIT 0,120";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-quizzes-taken-day' ), $res, 'day' );
		} elseif ( $statistic == 'New Blog Pages' ) {
			$pageTitle = wfMsg( 'sitemetrics-new-blogs' );
			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1) , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'page' )}
					WHERE page_namespace=500
					GROUP BY DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM revision WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m' )
					ORDER BY DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM revision WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m' ) DESC
					LIMIT 0,12;";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-new-blogs-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1) , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'page' )}
					WHERE page_namespace=500
					GROUP BY DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m %d' )
					ORDER BY DATE_FORMAT( (SELECT FROM_UNIXTIME( UNIX_TIMESTAMP(rev_timestamp) ) FROM {$dbr->tableName( 'revision' )} WHERE rev_page=page_id ORDER BY rev_timestamp ASC LIMIT 1), '%y %m %d' ) DESC
					LIMIT 0,120;";

			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-new-blogs-day' ), $res, 'day' );
		} elseif ( $statistic == 'Votes and Ratings' ) {
			$pageTitle = wfMsg( 'sitemetrics-votes' );
			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `Vote_Date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'Vote' )}
					GROUP BY DATE_FORMAT( `Vote_Date` , '%y %m' )
					ORDER BY DATE_FORMAT( `Vote_Date` , '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-votes-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `Vote_Date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'Vote' )}
					GROUP BY DATE_FORMAT( `Vote_Date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `Vote_Date` , '%y %m %d' ) DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-votes-day' ), $res, 'day' );
		} elseif ( $statistic == 'Comments' ) {
			$pageTitle = wfMsg( 'sitemetrics-comments' );
			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `Comment_Date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'Comments' )}
					GROUP BY DATE_FORMAT( `Comment_Date` , '%y %m' )
					ORDER BY DATE_FORMAT( `Comment_Date` , '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-comments-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `Comment_Date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'Comments' )}
					GROUP BY DATE_FORMAT( `Comment_Date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `Comment_Date` , '%y %m %d' ) DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-comments-day' ), $res, 'day' );
		} elseif ( $statistic == 'Contact Invites' ) {
			$pageTitle = wfMsg( 'sitemetrics-contact-imports' );
			$sql = "SELECT SUM(ue_count) AS the_count, DATE_FORMAT( `ue_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'user_email_track' )}
					WHERE ue_type IN (1,2,3)
					GROUP BY DATE_FORMAT( `ue_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `ue_date` , '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-contact-invites-month' ), $res, 'month' );

			$sql = "SELECT SUM(ue_count) AS the_count, DATE_FORMAT( `ue_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'user_email_track' )}
					WHERE ue_type IN (1,2,3)
					GROUP BY DATE_FORMAT( `ue_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `ue_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-contact-invites-day' ), $res, 'day' );
		} elseif ( $statistic == 'Invitations to Read Blog Page' ) {
			$pageTitle = wfMsg( 'sitemetrics-invites' );
			$sql = "SELECT SUM(ue_count) AS the_count, DATE_FORMAT( `ue_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'user_email_track' )}
					WHERE ue_type IN (4)
					GROUP BY DATE_FORMAT( `ue_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `ue_date` , '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-invites-month' ), $res, 'month' );

			$sql = "SELECT SUM( ue_count ) AS the_count, DATE_FORMAT( `ue_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'user_email_track' )}
					WHERE ue_type IN (4)
					GROUP BY DATE_FORMAT( `ue_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `ue_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-invites-day' ), $res, 'day' );
		} elseif ( $statistic == 'User Recruits' ) {
			$pageTitle = wfMsg( 'sitemetrics-user-recruits' );
			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `ur_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'user_register_track' )}
					WHERE ur_user_id_referral <> 0
					GROUP BY DATE_FORMAT( `ur_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `ur_date` , '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-user-recruits-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count, DATE_FORMAT( `ur_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'user_register_track' )}
					WHERE ur_user_id_referral <> 0
					GROUP BY DATE_FORMAT( `ur_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `ur_date` , '%y %m %d' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-user-recruits-day' ), $res, 'day' );
		} elseif ( $statistic == 'Awards' ) {
			$pageTitle = wfMsg( 'sitemetrics-awards' );
			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( `sg_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'user_system_gift' )}
					GROUP BY DATE_FORMAT( `sg_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `sg_date` , '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-awards-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( `sg_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'user_system_gift' )}
					GROUP BY DATE_FORMAT( `sg_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `sg_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-awards-day' ), $res, 'day' );
		} elseif ( $statistic == 'Honorific Advancements' ) {
			$pageTitle = wfMsg( 'sitemetrics-honorifics' );
			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( `um_date` , '%y %m' ) AS the_date
					FROM {$dbr->tableName( 'user_system_messages' )}
					GROUP BY DATE_FORMAT( `um_date` , '%y %m' )
					ORDER BY DATE_FORMAT( `um_date` , '%y %m' ) DESC
					LIMIT 0,12";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-honorifics-month' ), $res, 'month' );

			$sql = "SELECT COUNT(*) AS the_count,
					DATE_FORMAT( `um_date` , '%y %m %d' ) AS the_date
					FROM {$dbr->tableName( 'user_system_messages' )}
					GROUP BY DATE_FORMAT( `um_date` , '%y %m %d' )
					ORDER BY DATE_FORMAT( `um_date` , '%y %m %d' ) DESC
					LIMIT 0,120";
			$res = $dbr->query( $sql, __METHOD__ );
			$output .= $this->displayStats( wfMsg( 'sitemetrics-honorifics-day' ), $res, 'day' );
		}

		$output .= '</div>';

		// Set page title here, we can't do it earlier
		$wgOut->setPageTitle( wfMsg( 'sitemetrics-title', $pageTitle ) );

		$wgOut->addHTML( $output );
	}

}