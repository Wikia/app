<?php

$wgExtensionFunctions[] = 'wfSpecialQuizRecalcStats';

function wfSpecialQuizRecalcStats(){

	
	class QuizRecalcStats extends SpecialPage {
		
 
		/* Construct the MediaWiki special page */
		function QuizRecalcStats(){
			UnlistedSpecialPage::UnlistedSpecialPage("QuizRecalcStats");
		}
		
		function execute(){
			global $wgOut, $wgUser;
			
			if( !in_array('staff', $wgUser->getGroups() ) ){
				$wgOut->errorpage('error', 'noaccess');
				return "";
			}
		
			$dbr =& wfGetDB( DB_MASTER );
			$sql = "SELECT stats_user_name, stats_user_id from user_stats where stats_quiz_questions_correct >= stats_quiz_questions_answered  ";
			$res = $dbr->query($sql);
			while ($row = $dbr->fetchObject( $res ) ) {

				$sql = "update user_stats set stats_quiz_points = (
					select sum(a_points) from quizgame_answers inner join quizgame_choice on a_choice_id=choice_id
					where  a_user_id = {$row->stats_user_id} and choice_is_correct=1),
					stats_quiz_questions_correct = (
					select count(*) from quizgame_answers inner join quizgame_choice on a_choice_id=choice_id
					 where a_user_id = {$row->stats_user_id} and choice_is_correct=1),

					stats_quiz_questions_answered = (
					select count(*) from quizgame_answers  
					where  a_user_id = {$row->stats_user_id}  )


					where stats_user_id = '{$row->stats_user_id}'
				";
						
				$res2 = $dbr->query($sql);
					//update the users % correct
				$dbr->update( 'user_stats',
				array( 'stats_quiz_questions_correct_percent=stats_quiz_questions_correct/stats_quiz_questions_answered'),
				array(  'stats_user_id' => $row->stats_user_id ),
				__METHOD__ );
				$count++;
			}
			$wgOut->addHTML("Updated {$count} users");
		}			
	}

	SpecialPage::addPage( new QuizRecalcStats );
}

?>