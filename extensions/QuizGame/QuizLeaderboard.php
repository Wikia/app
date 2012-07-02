<?php

class QuizLeaderboard extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'QuizLeaderboard' );
	}

	/**
	 * Show the special page
	 *
	 * @param $input Mixed: parameter passed to the page or null
	 */
	public function execute( $input ) {
		global $wgOut, $wgUser, $wgScriptPath;

		if( !$input ) {
			$input = 'points';
		}

		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/QuizGame/questiongame.css' );

		$whereConds = array();

		switch( $input ) {
			case 'correct':
				$wgOut->setPageTitle( wfMsg( 'quiz-leaderboard-most-correct' ) );
				$field = 'stats_quiz_questions_correct';
				break;
			case 'percentage':
				$wgOut->setPageTitle( wfMsg( 'quiz-leaderboard-highest-percent' ) );
				$field = 'stats_quiz_questions_correct_percent';
				$whereConds[] = 'stats_quiz_questions_answered >= 50';
				break;
			case 'points':
				$wgOut->setPageTitle( wfMsg( 'quiz-leaderboard-most-points' ) );
				$field = 'stats_quiz_points';
				break;
		}

		$dbr = wfGetDB( DB_MASTER );
		$whereConds[] = 'stats_user_id <> 0';
		$res = $dbr->select(
			'user_stats',
			array(
				'stats_user_id', 'stats_user_name', 'stats_quiz_points',
				'stats_quiz_questions_correct',
				'stats_quiz_questions_correct_percent'
			),
			$whereConds,
			__METHOD__,
			array( 'ORDER BY' => "{$field} DESC", 'LIMIT' => 50, 'OFFSET' => 0 )
		);

		$quizgame_title = SpecialPage::getTitleFor( 'QuizGameHome' );

		$output = '<div class="quiz-leaderboard-nav">';

		if( $wgUser->isLoggedIn() ) {
			$stats = new UserStats( $wgUser->getID(), $wgUser->getName() );
			$stats_data = $stats->getUserStats();

			// Get users rank
			$quiz_rank = 0;
			$s = $dbr->selectRow(
				'user_stats',
				array( 'COUNT(*) AS count' ),
				array( 'stats_quiz_points >' . str_replace( ',', '', $stats_data['quiz_points'] ) ),
				__METHOD__
			);
			if ( $s !== false ) {
				$quiz_rank = $s->count + 1;
			}
			$avatar = new wAvatar( $wgUser->getID(), 'm' );

			$output .= "<div class=\"user-rank-lb\">
				<h2>{$avatar->getAvatarURL()} " . wfMsg( 'quiz-leaderboard-scoretitle' ) . '</h2>

					<p><b>' . wfMsg( 'quiz-leaderboard-quizpoints' ) . "</b></p>
					<p class=\"user-rank-points\">{$stats_data['quiz_points']}</p>
					<div class=\"cleared\"></div>

					<p><b>" . wfMsg( 'quiz-leaderboard-correct' ) . "</b></p>
					<p>{$stats_data['quiz_correct']}</p>
					<div class=\"cleared\"></div>

					<p><b>" . wfMsg( 'quiz-leaderboard-answered' ) . "</b></p>
					<p>{$stats_data['quiz_answered']}</p>
					<div class=\"cleared\"></div>

					<p><b>" . wfMsg( 'quiz-leaderboard-pctcorrect' ) . "</b></p>
					<p>{$stats_data['quiz_correct_percent']}%</p>
					<div class=\"cleared\"></div>

					<p><b>" . wfMsg( 'quiz-leaderboard-rank' ) . "</b></p>
					<p>{$quiz_rank}</p>
					<div class=\"cleared\"></div>

				</div>";
		}

		// Build nav
		$menu = array(
			wfMsg( 'quiz-leaderboard-menu-points' ) => 'points',
			wfMsg( 'quiz-leaderboard-menu-correct' ) => 'correct',
			wfMsg( 'quiz-leaderboard-menu-pct' ) => 'percentage'
		);

		$output .= '<h1>' . wfMsg( 'quiz-leaderboard-order-menu' ) . '</h1>';

		foreach( $menu as $title => $qs ) {
			if ( $input != $qs ) {
				$output .= "<p><a href=\"{$this->getTitle()->getFullURL()}/{$qs}\">{$title}</a><p>";
			} else {
				$output .= "<p><b>{$title}</b></p>";
			}
		}

		$output .= '</div>';

		$output .= '<div class="quiz-leaderboard-top-links">
			<a href="' . $quizgame_title->getFullURL( 'questionGameAction=launchGame' ) . '">'
				. wfMsg( 'quiz-admin-back' ) .
			'</a>
		</div>';

		$x = 1;
		$output .= '<div class="top-users">';

		foreach ( $res as $row ) {
		    $user_name = $row->stats_user_name;
		    $user_title = Title::makeTitle( NS_USER, $row->stats_user_name );
		    $avatar = new wAvatar( $row->stats_user_id, 'm' );
			if ( $user_name == substr( $user_name, 0, 18 ) ) {
				$user_name_short = $user_name;
			} else {
				$user_name_short = substr( $user_name, 0, 18 ) . wfMsg( 'ellipsis' );
			}

		    $output .= "<div class=\"top-fan-row\">
		 		   <span class=\"top-fan-num\">{$x}.</span>
				   <span class=\"top-fan\">{$avatar->getAvatarURL()}
				   <a href='" . $user_title->getFullURL() . "'>" . $user_name_short . '</a>
				</span>';

			switch( $input ) {
				case 'correct':
					$stat = number_format( $row->$field ) . ' ' . wfMsg( 'quiz-leaderboard-desc-correct' );
					break;
				case 'percentage':
					$stat = number_format( $row->$field * 100, 2 ) . wfMsg( 'quiz-leaderboard-desc-pct' );
					break;
				case 'points':
					$stat = number_format( $row->$field ) . ' ' . wfMsg( 'quiz-leaderboard-desc-points' );
					break;
			}

			$output .= "<span class=\"top-fan-points\"><b>{$stat}</b></span>";
		    $output .= '<div class="cleared"></div>';
		    $output .= '</div>';
		    $x++;
		}
		$output .= '</div><div class="cleared"></div>';

		$wgOut->addHTML( $output );

	}
}