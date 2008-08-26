<?php

$wgAjaxExportList [] = 'wfQuestionGameAdmin';
function wfQuestionGameAdmin($action,$key,$id,$comment=""){
	global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP;
	
	if($key != md5( "SALT" . $id ) ){
		$output = "You need a valid key to do that.";
		return $output;
	}
	
	$dbr =& wfGetDB( DB_MASTER );
	
	switch($action){
	case "unprotectItem":
		$sql = "UPDATE quizgame_questions SET q_flag=\"NONE\" WHERE q_id={$id};";
		$output = "The question has been un-protected.";
		break;
	case "protectItem":
		$sql = "UPDATE quizgame_questions SET q_flag=\"PROTECT\" WHERE q_id={$id};";
		$output = "The question has been protected.";
		break;
	case "unflagItem":
		//Fix Stats of those who answered the flagged question
		/*
		$sql = "UPDATE user_stats set stats_quiz_questions_answered=stats_quiz_questions_answered+1
		WHERE stats_user_id in (select a_user_id from quizgame_answers where a_q_id = {$id} )";
		$res = $dbr->query($sql);
		
		//Fix Stats of those who answered the flagged question correctly
		$sql = "UPDATE user_stats set stats_quiz_questions_correct=stats_quiz_questions_correct+1
		WHERE stats_user_id in (select a_user_id from quizgame_answers inner join quizgame_choice on a_choice_id=choice_id where a_q_id = {$id} and choice_is_correct=1 )";
		$res = $dbr->query($sql);
		
		//Update everyone's percentage who answered that question
		$sql = "UPDATE user_stats set stats_quiz_questions_correct_percent=stats_quiz_questions_correct /stats_quiz_questions_answered
		WHERE stats_user_id in (select a_user_id from quizgame_answers where a_q_id = {$id} )";
		$res = $dbr->query($sql);
		*/
		
		$sql = "UPDATE quizgame_questions SET q_flag=\"NONE\", q_comment='' WHERE q_id={$id};";
		$output = "The question has been re-instated.";
		break;
	case "flagItem":
		/*
		//Fix Stats of those who answered the flagged question
		$sql = "UPDATE user_stats set stats_quiz_questions_answered=stats_quiz_questions_answered-1
		WHERE stats_user_id in (select a_user_id from quizgame_answers where a_q_id = {$id} )";
		$res = $dbr->query($sql);
		
		//Fix Stats of those who answered the flagged question correctly
		$sql = "UPDATE user_stats set stats_quiz_questions_correct=stats_quiz_questions_correct-1
		WHERE stats_user_id in (select a_user_id from quizgame_answers inner join quizgame_choice on a_choice_id=choice_id where a_q_id = {$id} and choice_is_correct=1 )";
		$res = $dbr->query($sql);
		
		//Update everyone's percentage who answered that question
		$sql = "UPDATE user_stats set stats_quiz_questions_correct_percent=stats_quiz_questions_correct /stats_quiz_questions_answered
		WHERE stats_user_id in (select a_user_id from quizgame_answers where a_q_id = {$id} )";
		$res = $dbr->query($sql);
		*/
		
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( 'quizgame_questions',
			array( "q_flag"=>"FLAGGED", "q_comment" => $comment ),
			array( 'q_id' => $id  ),
			__METHOD__ );
		$dbw->commit();
		
		$sql = "UPDATE quizgame_questions SET q_flag=\"FLAGGED\" WHERE q_id={$id};";
		$sql="";
		$output = "The question has been flagged.";
		break;
		case "unprotectItem":
		$sql = "UPDATE quizgame_questions SET q_flag=\"NONE\" WHERE q_id={$id};";
		$output = "The question has been un-protected.";
		break;
	case "deleteItem":
		
		global $wgMemc;
		
		$where["a_q_id"] = $id;
		$res = $dbr->select( '`quizgame_answers` LEFT JOIN `quizgame_choice` on choice_id=a_choice_id', 
				array('a_user_id', 'a_points', 'choice_is_correct'),
			$where, __METHOD__, 
			""
		);
		
		while ($row = $dbr->fetchObject( $res ) ) {
			
			if( $row->choice_is_correct == 1 ){
				$percentage = "stats_quiz_questions_correct_percent= ( stats_quiz_questions_correct - 1)/(stats_quiz_questions_answered-1)";
			}else{
				$percentage = "stats_quiz_questions_correct_percent= ( stats_quiz_questions_correct )/(stats_quiz_questions_answered-1)";
			}
 
			//update everyone who answered this question
			$dbr->update( '`user_stats`',
				array( /* SET */
				$percentage,
				'stats_quiz_questions_answered=stats_quiz_questions_answered-1',
				), array( /* WHERE */
				'stats_user_id' => $row->a_user_id
				), ""
			);
			
			//update everyone who answered this question correct
			if( $row->choice_is_correct == 1 ){
				$dbr->update( '`user_stats`',
					array( /* SET */
					'stats_quiz_questions_correct=stats_quiz_questions_correct-1',
					'stats_quiz_points=stats_quiz_points-' . $row->a_points
					), array( /* WHERE */
					'stats_user_id' => $row->a_user_id
					), ""
				);
			}
	
			
			$key = wfMemcKey( 'user', 'stats', $row->a_user_id );
			$wgMemc->delete( $key );
		}
		
		$sql = "DELETE FROM quizgame_answers WHERE a_q_id={$id};";
		$res = $dbr->query($sql);
		$dbr->commit();
		
		$sql = "DELETE FROM quizgame_choice WHERE choice_q_id={$id};";
		$res = $dbr->query($sql);
		$dbr->commit();
		
		$sql = "DELETE FROM quizgame_questions WHERE q_id={$id};";
		$output = "Delete Succesfull!";
		break;
	default:
		$output = "Invalid AJAX option.";
		$sql = "";
		break;
	}
	//"
	if($sql){
		$res = $dbr->query($sql);
		$dbr->commit();
	}
	return $output;
}

// casts a vote by inserting some SQL
// returns the next question as well as stats about previous question in JSON
$wgAjaxExportList [] = 'wfQuestionGameVote';
function wfQuestionGameVote($answer,$key,$id, $points){
	global $wgRequest, $wgUser, $wgOut, $wgRequest, $IP;
	
	if($key != md5( "SALT" . $id ) ){
		$err = '
		{
			"status": "500",
			"error": "Key is invalid!"
		}';
		
		return $err;
	}
 
	
	if( !is_numeric($answer) ){
		$err = '
		{
			"status": "500",
			"error": "Answer choice is not numeric."
		}';
		
		return $err;
	}
	
	
	
	$dbr =& wfGetDB( DB_MASTER );
	
	//check if they already answered
	$s = $dbr->selectRow( '`quizgame_answers`', array( 'a_choice_id' ), array('a_q_id'=>$id, 'a_user_name' => $wgUser->getName() ), $fname );
	if ( $s !== false ) {
		$err = '
		{
			"status": "500",
			"error": "You already answered this question."
		}';
		return $err;
	}
			
	//add answer by user
	$dbr->insert( '`quizgame_answers`',
	array(
		'a_q_id' => $id,
		'a_user_id' => $wgUser->getID(),
		'a_user_name' => $wgUser->getName(),
		'a_choice_id' => $answer,
		'a_points' => $points,
		'a_date' => date("Y-m-d H:i:s")
		), __METHOD__
	);

	//if The question is being skipped, stop here
	if($answer==-1){
		return "ok";
	}
	
	//clear out anti-cheating table
	$sql = "DELETE FROM quizgame_user_view WHERE uv_user_id = {$wgUser->getID()} AND uv_q_id={$id}";
	$res = $dbr->query($sql);
	
	//update answer picked
	$dbr->update( 'quizgame_choice',
	array( 'choice_answer_count=choice_answer_count+1'),
	array( 'choice_id' => $answer ),
	__METHOD__ );

	//update question answered
	$dbr->update( 'quizgame_questions',
	array( 'q_answer_count=q_answer_count+1'),
	array( 'q_id' => $id ),
	__METHOD__ );
	

	

		
	//add to stats how many quizzes the user has answered
	$stats = new UserStatsTrack($wgUser->getID(), $wgUser->getName());
	$stats->incStatField("quiz_answered");
	
	//check if the answer was right
	$s = $dbr->selectRow( 'quizgame_questions', array( 'q_answer_count' ), array( 'q_id' => $id )   );
	if ( $s !== false ) {
		$answer_count = $s->q_answer_count;
	}
	
	//check if the answer was right
	$s = $dbr->selectRow( 'quizgame_choice', array( 'choice_id','choice_text','choice_answer_count' ), array( 'choice_q_id' => $id, 'choice_is_correct' => 1)   );
	if ( $s !== false ) {
		
		if($answer_count){
			$percent =  str_replace(".0","",number_format( $s->choice_answer_count / $answer_count * 100 , 1) ) ;
		}else{
			$percent = 0;
		}
		
		$isRight = (($s->choice_id == $answer) ? "true" : "false");
		$output = "{'isRight': '{$isRight}', 'rightAnswer':'" . addslashes($s->choice_text) . "', 'percentRight':'{$percent}'}";
		

				
		if($s->choice_id == $answer){
			
			//update question answered correctly for entire question
			$dbr->update( 'quizgame_questions',
			array( 'q_answer_correct_count=q_answer_correct_count+1'),
			array( 'q_id' => $id ),
			__METHOD__ );
			
			//add to stats how many quizzes the user has answered correctly
			$stats->incStatField("quiz_correct");
			
			//add to point total
			if( ! $wgUser->isBlocked() && is_numeric( $points ) ){
				$stats->incStatField("quiz_points",$points);
			}
			
	
		}
		//update the users % correct
		$dbr->update( 'user_stats',
		array( 'stats_quiz_questions_correct_percent=stats_quiz_questions_correct/stats_quiz_questions_answered '),
		array( 'stats_user_id' => $wgUser->getID() ),
		__METHOD__ );
		
		return $output;
	} else {
		$err = '
		{
			"status": "500",
			"error": "There is no question by that id."
		}';
		return $err;
	}
	
	

	
}


?>