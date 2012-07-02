<?php

class ViewQuizzes extends UnlistedSpecialPage {

	/**
	 * Construct the MediaWiki special page
	 */
	public function __construct() {
		parent::__construct( 'ViewQuizzes' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUploadPath, $wgScriptPath;

		// Add CSS & JS
		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$wgOut->addModules( 'ext.quizGame' );
		} else {
			$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/QuizGame/questiongame.css' );
			$wgOut->addScriptFile( $wgScriptPath . '/extensions/QuizGame/js/QuizGame.js' );
		}

		// Page either most or newest for everyone
		$type = $wgRequest->getVal( 'type' );
		if( !$type ) {
			$type = 'newest';
		}
		if( $type == 'newest' ) {
			$order = 'q_date';
		}
		if( $type == 'most' ) {
			$order = 'q_answer_count';
		}

		// Pagination
		$per_page = 20;
		$page = $wgRequest->getInt( 'page', 1 );

		$limit = $per_page;
		$limitvalue = 0; // OFFSET for SQL queries

		if ( $limit > 0 && $page ) {
			$limitvalue = $page * $limit - ( $limit );
		}

		$quizGameHome = SpecialPage::getTitleFor( 'QuizGameHome' );
		$output = '<div class="view-quizzes-top-links">
			<a href="' . $quizGameHome->escapeFullURL( 'questionGameAction=launchGame' ) .
				'">' . wfMsg( 'quiz-playneverending' ) . '</a> - 
			<a href="' . $quizGameHome->escapeFullURL( 'questionGameAction=createForm' ) .
				'">' . wfMsg( 'quiz-viewquizzes-create' ) . '</a>
			<br /><br />
		</div>

		<div class="view-quizzes-navigation">
			<h2>' . wfMsg( 'quiz-leaderboard-order-menu' ) . '</h2>';

		$dbr = wfGetDB( DB_MASTER );

		$where = array();
		$where[] = 'q_flag <> ' . QUIZGAME_FLAG_FLAGGED;

		// Display only a user's most or newest
		$user = $wgRequest->getVal( 'user' );
		$user_link = '';
		if ( $user ) {
			$where['q_user_name'] = $user;
			$user_link = '&user=' . urlencode( $user );
		}

		if( $type == 'newest' ) {
			$output .= '<p><b>' . wfMsg( 'quiz-newest' ) . '</b></p>
				<p><a href="' . $wgScriptPath . "/index.php?title=Special:ViewQuizzes&type=most{$user_link}\">" .
					wfMsg( 'quiz-popular' ) . '</a></p>';
		} else {
			$output .= '<p><a href="' . $wgScriptPath . "/index.php?title=Special:ViewQuizzes&type=newest{$user_link}\">" .
				wfMsg( 'quiz-newest' ) . '</a></p>
				<p><b>' . wfMsg( 'quiz-popular' ) . '</b></p>';
		}

		$output .= '</div>';

		if ( $user ) {
			$wgOut->setPageTitle( wfMsg( 'quiz-viewquizzes-title-by-user', $user ) );
		} else {
			$wgOut->setPageTitle( wfMsg( 'quiz-viewquizzes-title' ) );
		}

		$res = $dbr->select(
			'quizgame_questions',
			array(
				'q_id', 'q_user_id', 'q_user_name', 'q_text',
				'UNIX_TIMESTAMP(q_date) AS quiz_date', 'q_picture',
				'q_answer_count'
			),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => "$order DESC",
				'LIMIT' => $limit,
				'OFFSET' => $limitvalue
			)
		);

		$res_total = $dbr->select(
			'quizgame_questions',
			'COUNT(*) AS total_quizzes',
			$where,
			__METHOD__
		);
		$row_total = $dbr->fetchObject( $res_total );
		$total = $row_total->total_quizzes;

		$output .= '<div class="view-quizzes">';

		$x = ( ( $page - 1 ) * $per_page ) + 1; 

		foreach ( $res as $row ) {
			$user_create = $row->q_user_name;
			$user_id = $row->q_user_id;
			$avatar = new wAvatar( $user_id, 'm' );
			$quiz_title = $row->q_text;
			$quiz_date = $row->quiz_date;
			$quiz_answers = $row->q_answer_count;
			$quiz_id = $row->q_id;
			$row_id = "quizz-row-{$x}";

			$url = $quizGameHome->escapeFullURL( array(
				'questionGameAction' => 'renderPermalink',
				'permalinkID' => $quiz_id
			) );
			$startHover = "QuizGame.doHover('{$row_id}')";
			$endHover = "QuizGame.endHover('{$row_id}')";
			if ( ( $x < $total ) && ( $x % $per_page != 0 ) ) {
				$output .= "<div class=\"view-quizzes-row\" id=\"{$row_id}\" onmouseover=\"{$startHover}\" onmouseout=\"{$endHover}\" onclick=\"window.location='" . $url . '\'">';
			} else {
				$output .= "<div class=\"view-quizzes-row-bottom\" id=\"{$row_id}\" onmouseover=\"{$startHover}\" onmouseout=\"{$endHover}\" onclick=\"window.location='" . $url . '\'">';
			}

			$output .= "<div class=\"view-quizzes-number\">{$x}.</div>
				<div class=\"view-quizzes-user-image\"><img src=\"{$wgUploadPath}/avatars/{$avatar->getAvatarImage()}\" alt=\"\" /></div>
				<div class=\"view-quizzes-user-name\">{$user_create}</div>
				<div class=\"view-quizzes-text\">
					<p><b><u>{$quiz_title}</u></b></p>
					<p class=\"view-quizzes-num-answers\">" .
						wfMsgExt( 'quiz-answered', 'parsemag', $quiz_answers ) . '</p>
					<p class="view-quizzes-time">(' .
						wfMsg( 'quiz-ago', self::getTimeAgo( $quiz_date ) ) .
					')</p>
				</div>
				<div class="cleared"></div>
			</div>';

			$x++;
		}

		$output .= '</div>
		<div class="cleared"></div>';

		$numofpages = $total / $per_page;

		if( $numofpages > 1 ) {
			$output .= '<div class="view-quizzes-page-nav">';
			if( $page > 1 ) {
				$output .= '<a href="' . $wgScriptPath . "/index.php?title=Special:ViewQuizzes&type=most{$user_link}&page=" . ( $page - 1 ) . '">' .
					wfMsg( 'quiz-prev' ) . '</a> ';
			}

			if( ( $total % $per_page ) != 0 ) {
				$numofpages++;
			}
			if( $numofpages >= 9 && $page < $total ) {
				$numofpages = 9 + $page;
			}
			if( $numofpages >= ( $total / $per_page ) ) {
				$numofpages = ( $total / $per_page ) + 1;
			}

			for( $i = 1; $i <= $numofpages; $i++ ) {
				if( $i == $page ) {
					$output .= ( $i . ' ' );
				} else {
					$output .= '<a href="' . $wgScriptPath . "/index.php?title=Special:ViewQuizzes&type=most{$user_link}&page=$i\">$i</a> ";
				}
			}

			if( ( $total - ( $per_page * $page ) ) > 0 ) {
				$output .= ' <a href="' . $wgScriptPath . "/index.php?title=Special:ViewQuizzes&type=most{$user_link}&page=" . ( $page + 1 ) . '">' .
					wfMsg( 'quiz-nav-next' ) . '</a>';
			}
			$output .= '</div>';
		}

		$wgOut->addHTML( $output );
	}

	/**
	 * The following three functions are borrowed
	 * from includes/wikia/GlobalFunctionsNY.php
	 */
	static function dateDiff( $date1, $date2 ) {
		$dtDiff = $date1 - $date2;

		$totalDays = intval( $dtDiff / ( 24 * 60 * 60 ) );
		$totalSecs = $dtDiff - ( $totalDays * 24 * 60 * 60 );
		$dif['w'] = intval( $totalDays / 7 );
		$dif['d'] = $totalDays;
		$dif['h'] = $h = intval( $totalSecs / ( 60 * 60 ) );
		$dif['m'] = $m = intval( ( $totalSecs - ( $h * 60 * 60 ) ) / 60 );
		$dif['s'] = $totalSecs - ( $h * 60 * 60 ) - ( $m * 60 );

		return $dif;
	}

	static function getTimeOffset( $time, $timeabrv, $timename ) {
		$timeStr = '';
		if( $time[$timeabrv] > 0 ) {
			$timeStr = wfMsgExt( "quiz-time-{$timename}", 'parsemag', $time[$timeabrv] );
		}
		if( $timeStr ) {
			$timeStr .= ' ';
		}
		return $timeStr;
	}

	static function getTimeAgo( $time ) {
		$timeArray = self::dateDiff( time(), $time );
		$timeStr = '';
		$timeStrD = self::getTimeOffset( $timeArray, 'd', 'days' );
		$timeStrH = self::getTimeOffset( $timeArray, 'h', 'hours' );
		$timeStrM = self::getTimeOffset( $timeArray, 'm', 'minutes' );
		$timeStrS = self::getTimeOffset( $timeArray, 's', 'seconds' );
		$timeStr = $timeStrD;
		if( $timeStr < 2 ) {
			$timeStr .= $timeStrH;
			$timeStr .= $timeStrM;
			if( !$timeStr ) {
				$timeStr .= $timeStrS;
			}
		}
		if( !$timeStr ) {
			$timeStr = wfMsgExt( 'quiz-time-seconds', 'parsemag', 1 );
		}
		return $timeStr;
	}

}