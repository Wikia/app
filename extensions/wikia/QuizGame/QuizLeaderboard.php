<?php

$wgExtensionFunctions[] = 'wfSpecialQuizLeaderboard';
$wgExtensionFunctions[] = 'wfQuizGameReadLang';


function wfSpecialQuizLeaderboard(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class QuizLeaderboard extends SpecialPage {

	
	function QuizLeaderboard(){
		UnlistedSpecialPage::UnlistedSpecialPage("QuizLeaderboard");
	}
	
	function execute($input){
		global $wgRequest, $IP, $wgOut, $wgUser;
		
		if(!$input)$input="points";
		
		
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/QuizGame/questiongame.css?{$wgStyleVersion}\"/>\n");
		
		switch($input){
			
			case "correct":
				$wgOut->setPagetitle( wfMsgForContent( 'quiz_leaderboard_most_correct' ) );
				$field = "stats_quiz_questions_correct";
				break;
			case "percentage":
				$wgOut->setPagetitle( wfMsgForContent( 'quiz_leaderboard_highest_percent' ) );
				$field = "stats_quiz_questions_correct_percent";
				$min = " and stats_quiz_questions_answered >= 50 ";
				break;
			case "points":
				$wgOut->setPagetitle( wfMsgForContent( 'quiz_leaderboard_most_points' ) );
				$field = "stats_quiz_points";
				break;
				
		}
	
		
		
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT stats_user_id,stats_user_name, stats_quiz_points, stats_quiz_questions_correct, stats_quiz_questions_correct_percent from user_stats where stats_user_id <> 0 {$min} ORDER BY {$field} DESC LIMIT 0,50";
		$res = $dbr->query($sql);

		$output .= "";

		
		$leaderboard_title = Title::makeTitle( NS_SPECIAL  , "QuizLeaderboard"  );
		$quizgame_title = Title::makeTitle( NS_SPECIAL  , "QuizGameHome"  );
		
		$output .= "<div class=\"quiz-leaderboard-nav\">";
		
		if($wgUser->isLoggedIn()){
			$stats = new UserStats($wgUser->getID(), $wgUser->getName());
			$stats_data = $stats->getUserStats();
			
			//get users rank
			$quiz_rank = 0;
			$s = $dbr->selectRow( '`user_stats`', array( 'count(*) as count' ), array("stats_quiz_points>" . str_replace(",","",$stats_data["quiz_points"] )), $fname );
			if ( $s !== false ) {
				$quiz_rank = $s->count+1;
			}	
			$avatar = new wAvatar($wgUser->getID(),"m");
			
			$output .= "<div class=\"user-rank-lb\">
				<h2>{$avatar->getAvatarURL()} " . wfMsgForContent( 'quiz_leaderboard_scoretitle' ) . "</h2>
					
					<p><b>" . wfMsgForContent( 'quiz_leaderboard_quizpoints' ) . "</b></p>
					<p class=\"user-rank-points\">{$stats_data["quiz_points"]}</p>
					<div class=\"cleared\"></div>
					
					<p><b>" . wfMsgForContent( 'quiz_leaderboard_correct' ) . "</b></p>
					<p>{$stats_data["quiz_correct"]}</p>
					<div class=\"cleared\"></div>
					
					<p><b>" . wfMsgForContent( 'quiz_leaderboard_answered' ) . "</b></p>
					<p>{$stats_data["quiz_answered"]}</p>
					<div class=\"cleared\"></div>
					
					<p><b>" . wfMsgForContent( 'quiz_leaderboard_pctcorrect' ) . "</b></p>
					<p>{$stats_data["quiz_correct_percent"]}%</p>
					<div class=\"cleared\"></div>
					
					<p><b>" . wfMsgForContent( 'quiz_leaderboard_rank' ) . "</b></p>
					<p>{$quiz_rank}</p>
					<div class=\"cleared\"></div>
					
				</div>";
		}
		
		//Build Nav
		$menu = array(
			wfMsgForContent( 'quiz_leaderboard_menu_points' ) => "points",
			wfMsgForContent( 'quiz_leaderboard_menu_correct' ) => "correct",
			wfMsgForContent( 'quiz_leaderboard_menu_pct' ) => "percentage"
			);
		
		$output .= "<h1>" . wfMsgForContent( 'quiz_leaderboard_order_menu' ) . "</h1>";
		
		foreach($menu as $title=>$qs){
			if ($input!=$qs){
				$output.= "<p><a href=\"{$leaderboard_title->getFullURL()}/{$qs}\">{$title}</a><p>";
			} else {
				$output .= "<p><b>{$title}</b></p>";
			}
		}
		
		$output .= "</div>";
		
		$output .= "<div class=\"quiz-leaderboard-top-links\">
			<a href=\"" .$quizgame_title->getFullURL('questionGameAction=launchGame') . "\">" . wfMsgForContent( 'quiz_admin_back' ) . "</a>
		</div>";
		
		$x = 1;
		$output .= "<div class=\"top-users\">";
		
		while ($row = $dbr->fetchObject( $res ) ) {
		    $user_name = $row->stats_user_name;
		    $user_title = Title::makeTitle( NS_USER  , $row->stats_user_name  );
		    $avatar = new wAvatar($row->stats_user_id,"m");
			$user_name_short = ($user_name == substr($user_name, 0, 18) ) ?
								 $user_name : ( substr($user_name, 0, 18) . "...");
			
		    $output .= "<div class=\"top-fan-row\">
		 		   <span class=\"top-fan-num\">{$x}.</span><span class=\"top-fan\">{$avatar->getAvatarURL()} <a href='" . $user_title->getFullURL() . "' >" . $user_name_short . "</a>
				</span>";
				
			switch($input){
				
				case "correct":
					$stat = number_format($row->$field) . " " . wfMsgForContent( 'quiz_leaderboard_desc_correct' ) . "";
					break;
				case "percentage":
					$stat = number_format($row->$field * 100 ,2) . wfMsgForContent( 'quiz_leaderboard_desc_pct' );
					break;
				case "points":
					$stat = number_format($row->$field) . " " . wfMsgForContent( 'quiz_leaderboard_desc_points' ) . "";
					break;
					
			}
			$output .=  "<span class=\"top-fan-points\"><b>{$stat}</b></span>";
		    $output .= "<div class=\"cleared\"></div>";
		    $output .= "</div>";
		    $x++;
		}
		$output .= "</div><div class=\"cleared\"></div>";
	
		$wgOut->addHTML($output);
	
	}
  
}

SpecialPage::addPage( new QuizLeaderboard );

}

?>