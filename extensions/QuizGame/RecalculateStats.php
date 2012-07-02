<?php

class QuizRecalcStats extends UnlistedSpecialPage {

	/**
	 * Construct the MediaWiki special page
	 */
	public function __construct() {
		parent::__construct( 'QuizRecalcStats' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser;

		// Only Quiz Administrators should be allowed to access this page
		if( !$wgUser->isAllowed( 'quizadmin' ) ) {
			throw new ErrorPageError( 'error', 'noaccess' );
			return '';
		}

		// Show a message if the database is in read-only mode
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		// If user is blocked, s/he doesn't need to access this page
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select(
			'user_stats',
			array( 'stats_user_name', 'stats_user_id' ),
			array( 'stats_quiz_questions_correct >= stats_quiz_questions_answered' ),
			__METHOD__
		);
		$count = 0;
		foreach ( $res as $row ) {
			$sql = "UPDATE {$dbw->tableName( 'user_stats' )} SET stats_quiz_points = (
				SELECT SUM(a_points) FROM {$dbw->tableName( 'quizgame_answers' )}
				INNER JOIN {$dbw->tableName( 'quizgame_choice' )} ON a_choice_id=choice_id
				WHERE a_user_id = {$row->stats_user_id} AND choice_is_correct=1),
				stats_quiz_questions_correct = (
				SELECT COUNT(*) FROM {$dbw->tableName( 'quizgame_answers' )}
				INNER JOIN {$dbw->tableName( 'quizgame_choice' )} ON a_choice_id=choice_id
				WHERE a_user_id = {$row->stats_user_id} AND choice_is_correct=1),

				stats_quiz_questions_answered = (
				SELECT COUNT(*) FROM {$dbw->tableName( 'quizgame_answers' )}
				WHERE a_user_id = {$row->stats_user_id} )

				WHERE stats_user_id = '{$row->stats_user_id}'";

			$res2 = $dbw->query( $sql, __METHOD__ );
			/*
			// Database::selectField() does not take the last (join conds) arg
			// How typical...
			$quizPoints = $dbw->select(
				array( 'quizgame_answers', 'quizgame_choice' ),
				'SUM(a_points) AS sum',
				array(
					'a_user_id' => $row->stats_user_id,
					'choice_is_correct' => 1
				),
				__METHOD__,
				array( 'LIMIT' => 1 ),
				array(
					'quizgame_choice' =>
						array( 'INNER JOIN', 'a_choice_id = choice_id' )
				)
			);

			$correct = $dbw->select(
				array( 'quizgame_answers', 'quizgame_choice' ),
				array( 'COUNT(*) AS count' ),
				array(
					'a_user_id' => $row->stats_user_id,
					'choice_is_correct' => 1
				),
				__METHOD__,
				array(),
				array(
					'quizgame_choice' =>
						array( 'INNER JOIN', 'a_choice_id = choice_id' )
				)
			);

			$answered = $dbw->selectField(
				'quizgame_answers',
				'COUNT(*)',
				array( 'a_user_id' => $row->stats_user_id ),
				__METHOD__
			);

			$final = $dbw->update(
				'user_stats',
				array(
					'stats_quiz_points' => intval( $quizPoints->sum ),
					'stats_quiz_questions_correct' => intval( $correct->count ),
					'stats_quiz_questions_answered' => intval( $answered )
				),
				array( 'stats_user_id' => $row->stats_user_id ),
				__METHOD__
			);
			*/
			// Update the users % correct
			$dbw->update(
				'user_stats',
				array( 'stats_quiz_questions_correct_percent=stats_quiz_questions_correct/stats_quiz_questions_answered' ),
				array( 'stats_user_id' => $row->stats_user_id ),
				__METHOD__
			);
			$count++;
		}
		$wgOut->addHTML( "Updated {$count} users" );
	}
}