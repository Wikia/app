<?php
/**
 * AJAX functions used by QuizGame extension.
 */

$wgAjaxExportList[] = 'wfQuestionGameAdmin';
/**
 * Main admin panel entry point.
 *
 * @param $action String: what to do + the word "Item", i.e. deleteItem
 * @param $key String: MD5 hash of the word 'SALT' and the quiz ID number
 * @param $id Integer: quiz ID number
 * @param $comment String: reason for flagging (used only in flagItem)
 * @return String: message indicating what was done
 */
function wfQuestionGameAdmin( $action, $key, $id, $comment = '' ) {
	global $wgUser, $wgQuizLogs;

	// Check that the key is correct to make sure that no-one's trying any
	// funny business
	// We cannot check for !$wgUser->isAllowed( 'quizadmin' ) since this
	// function also handles flagging...all the other actions are admin-only,
	// though
	if( $key != md5( 'SALT' . $id ) ) {
		$output = wfMsg( 'quiz-ajax-invalid-key' );
		return $output;
	}

	$dbw = wfGetDB( DB_MASTER );

	switch( $action ) {
	case 'unprotectItem':
		$dbw->update(
			'quizgame_questions',
			array( 'q_flag' => QUIZGAME_FLAG_NONE ),
			array( 'q_id' => intval( $id ) ),
			__METHOD__
		);
		$dbw->commit();
		$output = wfMsg( 'quiz-ajax-unprotected' );
		// Add a log entry if quiz logging is enabled
		if( $wgQuizLogs ) {
			$message = wfMsgForContent(
				'quiz-questions-log-unprotect-text',
				"Special:QuizGameHome/{$id}",
				$id
			);
			$log = new LogPage( 'quiz' );
			$log->addEntry( 'unprotect', $wgUser->getUserPage(), $message );
		}
		break;
	case 'protectItem':
		$dbw->update(
			'quizgame_questions',
			array( 'q_flag' => QUIZGAME_FLAG_PROTECT ),
			array( 'q_id' => intval( $id ) ),
			__METHOD__
		);
		$dbw->commit();
		$output = wfMsg( 'quiz-ajax-protected' );
		// Add a log entry if quiz logging is enabled
		if( $wgQuizLogs ) {
			$message = wfMsgForContent(
				'quiz-questions-log-protect-text',
				"Special:QuizGameHome/{$id}",
				$id
			);
			$log = new LogPage( 'quiz' );
			$log->addEntry( 'protect', $wgUser->getUserPage(), $message );
		}
		break;
	case 'unflagItem':
		// Fix Stats of those who answered the flagged question
		/*
		$sql = "UPDATE user_stats SET stats_quiz_questions_answered=stats_quiz_questions_answered+1
		WHERE stats_user_id IN (SELECT a_user_id FROM quizgame_answers WHERE a_q_id = {$id})";
		$res = $dbr->query( $sql, __METHOD__ );

		// Fix Stats of those who answered the flagged question correctly
		$sql = "UPDATE user_stats SET stats_quiz_questions_correct=stats_quiz_questions_correct+1
		WHERE stats_user_id IN (SELECT a_user_id FROM quizgame_answers INNER JOIN quizgame_choice ON a_choice_id=choice_id WHERE a_q_id = {$id} AND choice_is_correct=1 )";
		$res = $dbr->query( $sql, __METHOD__ );

		// Update everyone's percentage who answered that question
		$sql = "UPDATE user_stats SET stats_quiz_questions_correct_percent=stats_quiz_questions_correct /stats_quiz_questions_answered
		WHERE stats_user_id IN (SELECT a_user_id FROM quizgame_answers WHERE a_q_id = {$id} )";
		$res = $dbr->query( $sql, __METHOD__ );
		*/

		$dbw->update(
			'quizgame_questions',
			array( 'q_flag' => QUIZGAME_FLAG_NONE, 'q_comment' => '' ),
			array( 'q_id' => intval( $id ) ),
			__METHOD__
		);
		#$sql = "UPDATE quizgame_questions SET q_flag=\"NONE\", q_comment='' WHERE q_id={$id};";
		#$dbw->query( $sql, __METHOD__ );
		$dbw->commit();
		$output = wfMsg( 'quiz-ajax-unflagged' );
		// Add a log entry if quiz logging is enabled
		if( $wgQuizLogs ) {
			$message = wfMsgForContent(
				'quiz-questions-log-unflag-text',
				"Special:QuizGameHome/{$id}",
				$id
			);
			$log = new LogPage( 'quiz' );
			$log->addEntry( 'unflag', $wgUser->getUserPage(), $message );
		}
		break;
	case 'flagItem':
		/*
		// Fix Stats of those who answered the flagged question
		$sql = "UPDATE user_stats SET stats_quiz_questions_answered=stats_quiz_questions_answered-1
		WHERE stats_user_id IN (SELECT a_user_id FROM quizgame_answers WHERE a_q_id = {$id} )";
		$res = $dbr->query( $sql, __METHOD__ );

		// Fix Stats of those who answered the flagged question correctly
		$sql = "UPDATE user_stats SET stats_quiz_questions_correct=stats_quiz_questions_correct-1
		WHERE stats_user_id IN (SELECT a_user_id FROM quizgame_answers INNER JOIN quizgame_choice ON a_choice_id=choice_id WHERE a_q_id = {$id} AND choice_is_correct=1 )";
		$res = $dbr->query( $sql, __METHOD__ );

		// Update everyone's percentage who answered that question
		$sql = "UPDATE user_stats SET stats_quiz_questions_correct_percent=stats_quiz_questions_correct /stats_quiz_questions_answered
		WHERE stats_user_id IN (SELECT a_user_id FROM quizgame_answers WHERE a_q_id = {$id} )";
		$res = $dbr->query( $sql, __METHOD__ );
		*/

		$dbw->update(
			'quizgame_questions',
			array( 'q_flag' => QUIZGAME_FLAG_FLAGGED, 'q_comment' => $comment ),
			array( 'q_id' => intval( $id ) ),
			__METHOD__
		);

		$dbw->update(
			'quizgame_questions',
			array( 'q_flag' => QUIZGAME_FLAG_FLAGGED ),
			array( 'q_id' => intval( $id ) ),
			__METHOD__
		);
		$dbw->commit();
		$output = wfMsg( 'quiz-ajax-flagged' );
		// Add a log entry if quiz logging is enabled
		if( $wgQuizLogs ) {
			$message = wfMsgForContent(
				'quiz-questions-log-flag-text',
				"Special:QuizGameHome/{$id}",
				$id,
				$comment
			);
			$log = new LogPage( 'quiz' );
			$log->addEntry( 'flag', $wgUser->getUserPage(), $message );
		}
		break;
	case 'deleteItem':
		$res = $dbw->select(
			array( 'quizgame_answers', 'quizgame_choice' ),
			array( 'a_user_id', 'a_points', 'choice_is_correct' ),
			array( 'a_q_id' => intval( $id ) ),
			__METHOD__,
			'',
			array( 'quizgame_choice' => array( 'LEFT JOIN', 'choice_id = a_choice_id' ) )
		);

		foreach ( $res as $row ) {
			if( $row->choice_is_correct == 1 ) {
				$percentage = 'stats_quiz_questions_correct_percent = ( stats_quiz_questions_correct - 1)/(stats_quiz_questions_answered-1)';
			} else {
				$percentage = 'stats_quiz_questions_correct_percent = ( stats_quiz_questions_correct )/(stats_quiz_questions_answered-1)';
			}

			// Update everyone who answered this question
			$dbw->update(
				'user_stats',
				/* SET */array(
					$percentage,
					'stats_quiz_questions_answered=stats_quiz_questions_answered-1',
				),
				/* WHERE */array(
					'stats_user_id' => $row->a_user_id
				),
				__METHOD__
			);

			// Update everyone who answered this question correct
			if( $row->choice_is_correct == 1 ) {
				$dbw->update(
					'user_stats',
					/* SET */array(
						'stats_quiz_questions_correct=stats_quiz_questions_correct-1',
						'stats_quiz_points=stats_quiz_points-' . $row->a_points
					),
					/* WHERE */array(
						'stats_user_id' => $row->a_user_id
					),
					__METHOD__
				);
			}

			global $wgMemc;
			$key = wfMemcKey( 'user', 'stats', $row->a_user_id );
			$wgMemc->delete( $key );
		}

		$dbw->delete(
			'quizgame_answers',
			array( 'a_q_id' => intval( $id ) ),
			__METHOD__
		);
		$dbw->commit();

		$dbw->delete(
			'quizgame_choice',
			array( 'choice_q_id' => intval( $id ) ),
			__METHOD__
		);
		$dbw->commit();

		$dbw->delete(
			'quizgame_questions',
			array( 'q_id' => intval( $id ) ),
			__METHOD__
		);
		$dbw->commit();
		$output = wfMsg( 'quiz-ajax-deleted' );
		// Add a log entry if quiz logging is enabled
		if( $wgQuizLogs ) {
			$message = wfMsgForContent(
				'quiz-questions-log-delete-text',
				"Special:QuizGameHome/{$id}",
				$id
			);
			$log = new LogPage( 'quiz' );
			$log->addEntry( 'delete', $wgUser->getUserPage(), $message );
		}
		break;
	default:
		$output = wfMsg( 'quiz-ajax-invalid-option' );
		break;
	}

	return $output;
}

/**
 * Casts a vote by inserting some SQL.
 *
 * @param $answer Integer: numeric answer ID
 * @param $key String: MD5 hash of the word 'SALT' and the quiz ID number
 * @param $id Integer: quiz ID number
 * @param $points
 * @return String: the next question as well as stats about previous question
 *                 in JSON
 */
$wgAjaxExportList[] = 'wfQuestionGameVote';
function wfQuestionGameVote( $answer, $key, $id, $points ) {
	global $wgUser;

	if( $key != md5( 'SALT' . $id ) ) {
		$err = '
		{
			"status": "500",
			"error": "Key is invalid!"
		}';

		return $err;
	}

	if( !is_numeric( $answer ) ) {
		$err = '
		{
			"status": "500",
			"error": "Answer choice is not numeric."
		}';

		return $err;
	}

	$dbw = wfGetDB( DB_MASTER );

	// Check if they already answered
	$s = $dbw->selectRow(
		'quizgame_answers',
		array( 'a_choice_id' ),
		array( 'a_q_id' => intval( $id ), 'a_user_name' => $wgUser->getName() ),
		__METHOD__
	);
	if ( $s !== false ) {
		$err = '
		{
			"status": "500",
			"error": "You already answered this question."
		}';
		return $err;
	}

	// Add answer by user
	$dbw->insert(
		'quizgame_answers',
		array(
			'a_q_id' => intval( $id ),
			'a_user_id' => $wgUser->getID(),
			'a_user_name' => $wgUser->getName(),
			'a_choice_id' => $answer,
			'a_points' => $points,
			'a_date' => date( 'Y-m-d H:i:s' )
		),
		__METHOD__
	);

	// If the question is being skipped, stop here
	if( $answer == -1 ) {
		return 'ok';
	}

	// Clear out anti-cheating table
	$dbw->delete(
		'quizgame_user_view',
		array( 'uv_user_id' => $wgUser->getID(), 'uv_q_id' => intval( $id ) ),
		__METHOD__
	);
	$dbw->commit();

	// Update answer picked
	$dbw->update(
		'quizgame_choice',
		array( 'choice_answer_count = choice_answer_count+1' ),
		array( 'choice_id' => $answer ),
		__METHOD__
	);

	// Update question answered
	$dbw->update(
		'quizgame_questions',
		array( 'q_answer_count = q_answer_count+1' ),
		array( 'q_id' => intval( $id ) ),
		__METHOD__
	);

	// Add to stats how many quizzes the user has answered
	$stats = new UserStatsTrack( $wgUser->getID(), $wgUser->getName() );
	$stats->incStatField( 'quiz_answered' );

	// Check if the answer was right
	$s = $dbw->selectRow(
		'quizgame_questions',
		array( 'q_answer_count' ),
		array( 'q_id' => intval( $id ) ),
		__METHOD__
	);
	if ( $s !== false ) {
		$answer_count = $s->q_answer_count;
	}

	// Check if the answer was right
	$s = $dbw->selectRow(
		'quizgame_choice',
		array( 'choice_id', 'choice_text', 'choice_answer_count' ),
		array( 'choice_q_id' => intval( $id ), 'choice_is_correct' => 1 ),
		__METHOD__
	);

	if ( $s !== false ) {
		if( $answer_count ) {
			$formattedNumber = number_format( $s->choice_answer_count / $answer_count * 100, 1 );
			$percent = str_replace( '.0', '', $formattedNumber );
		} else {
			$percent = 0;
		}

		$isRight = ( ( $s->choice_id == $answer ) ? 'true' : 'false' );
		$output = "{'isRight': '{$isRight}', 'rightAnswer':'" .
			addslashes( $s->choice_text ) . "', 'percentRight':'{$percent}'}";

		if( $s->choice_id == $answer ) {
			// Update question answered correctly for entire question
			$dbw->update(
				'quizgame_questions',
				array( 'q_answer_correct_count = q_answer_correct_count+1' ),
				array( 'q_id' => $id ),
				__METHOD__
			);

			// Add to stats how many quizzes the user has answered correctly
			$stats->incStatField( 'quiz_correct' );

			// Add to point total
			if( !$wgUser->isBlocked() && is_numeric( $points ) ) {
				$stats->incStatField( 'quiz_points', $points );
			}
		}

		// Update the users % correct
		$dbw->update(
			'user_stats',
			array( 'stats_quiz_questions_correct_percent = stats_quiz_questions_correct/stats_quiz_questions_answered' ),
			array( 'stats_user_id' => $wgUser->getID() ),
			__METHOD__
		);

		return $output;
	} else {
		$err = '
		{
			"status": "500",
			"error": "There is no question by that ID."
		}';
		return $err;
	}

}