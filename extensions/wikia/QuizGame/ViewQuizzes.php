<?php

$wgExtensionFunctions[] = 'wfSpecialViewQuizzes';

function wfSpecialViewQuizzes(){

	global $wgUser,$IP;
	
	class ViewQuizzes extends SpecialPage {
		
		/* Construct the MediaWiki special page */
		function ViewQuizzes(){
			UnlistedSpecialPage::UnlistedSpecialPage("ViewQuizzes");
		}
		
		// main execute function
		function execute(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgStyleVersion, $wgUploadPath;
			
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/QuizGame/questiongame.css?{$wgStyleVersion}\"/>\n");
			
			
			//page either most or newest for everyone
			$type = $wgRequest->getVal('type');
			if(!$type)$type="newest";
			if($type=="newest")$order="ORDER BY q_date";
			if($type=="most")$order="ORDER BY q_answer_count";
			
			//display only a user's most or newest
			$user = $wgRequest->getVal('user');
			if ($user) {
				$user_sql = "and q_user_name='{$user}'";
				$user_link = "&user=" . urlencode($user);
				$user_page_title = "{$user}'s";
			}
			
			//pagination
			$per_page = 20;
			$page = $wgRequest->getVal('page');
			if(!$page  || !is_numeric($page) )$page=1;
			
			$limit=$per_page;

			if ($limit > 0) {
					$limitvalue = 0;
					if($page)$limitvalue = $page * $limit - ($limit); 
					$limit_sql = " LIMIT {$limitvalue},{$limit} ";
			}
			
			$output .= "
			<div class=\"view-quizzes-top-links\">
				<a href=\"/index.php?title=Special:QuizGameHome&questionGameAction=launchGame\">Play the Never Ending Quiz</a> - 
				<a href=\"/index.php?title=Special:QuizGameHome&questionGameAction=createForm\">Create a Quiz Question</a>
				<br><br>
			</div>
			
			<div class=\"view-quizzes-navigation\">
				<h2>Order</h2>";
			
				if ($type=="newest") {
					$output .= "<p><b>Newest</b></p>
					<p><a href=\"/index.php?title=Special:ViewQuizzes&type=most{$user_link}\">Popular</a></p>";
				} else {
					$output .= "<p><a href=\"/index.php?title=Special:ViewQuizzes&type=newest{$user_link}\">Newest</a></p>
					<p><b>Popular</b></p>";
				}
			
			$output .= "</div>";
			
			$wgOut->setPageTitle("View {$user_page_title} Quiz Questions");
			
			$dbr =& wfGetDB( DB_MASTER );
			
			$sql = "SELECT q_id, q_user_id, q_user_name, q_text, UNIX_TIMESTAMP(q_date) as quiz_date, q_picture, q_answer_count FROM quizgame_questions WHERE q_flag <> 'FLAGGED' {$user_sql} {$order} DESC {$limit_sql}";
			$res = $dbr->query($sql);
			
			$sql_total = "SELECT COUNT(*) as total_quizzes FROM quizgame_questions WHERE q_flag <> 'FLAGGED' {$user_sql}";
			$res_total = $dbr->query($sql_total);
			$row_total = $dbr->fetchObject($res_total);
			$total = $row_total->total_quizzes;
			
			//javascript
			
			$output .= "<script type=\"text/javascript\" src=\"" . QuizGameHome::returnIncludePath() . "viewquizzes.js\"></script>";
			
			$output .= "<div class=\"view-quizzes\">";
			
				
				$x = (($page-1)*$per_page) + 1; 
				
				
				while ( $row = $dbr->fetchObject($res) ) {
					
					$user_create = $row->q_user_name;
					$user_id = $row->q_user_id;
					$avatar = new wAvatar($user_id,"m");
					$quiz_title = $row->q_text;
					$quiz_date = $row->quiz_date;
					$quiz_answers = $row->q_answer_count;
					$quiz_id = $row->q_id;
					$row_id = "quizz-row-{$x}";
					
					if (($x < $total) && ($x%$per_page != 0)) {
						$output .= "<div class=\"view-quizzes-row\" id=\"{$row_id}\" onmouseover=\"doHover('{$row_id}')\" onmouseout=\"endHover('{$row_id}')\" onclick=\"window.location='/index.php?title=Special:QuizGameHome&questionGameAction=renderPermalink&permalinkID={$quiz_id}'\">";
					} else {
						$output .= "<div class=\"view-quizzes-row-bottom\" id=\"{$row_id}\" onmouseover=\"doHover('{$row_id}')\" onmouseout=\"endHover('{$row_id}')\" onclick=\"window.location='/index.php?title=Special:QuizGameHome&questionGameAction=renderPermalink&permalinkID={$quiz_id}'\">";
					}
					
						$output .= "<div class=\"view-quizzes-number\">{$x}.</div>
						<div class=\"view-quizzes-user-image\"><img src=\"{$wgUploadPath}/avatars/{$avatar->getAvatarImage()}\" /></div>
						<div class=\"view-quizzes-user-name\">{$user_create}</div>
						<div class=\"view-quizzes-text\">
							<p><b><u>{$quiz_title}</u></b></p>
							<p class=\"view-quizzes-num-answers\">Answered {$quiz_answers} Times</p>
							<p class=\"view-quizzes-time\">(".get_time_ago($quiz_date)."ago)</p>
						</div>
						<div class=\"cleared\"></div>
					</div>";
					
					$x++;
				}
			
			$output .= "</div>
			<div class=\"cleared\"></div>";
			
			$numofpages = $total / $per_page; 
			
			if($numofpages>1){
				$output .= "<div class=\"view-quizzes-page-nav\">";
				if($page > 1){ 
					$output .= "<a href=\"index.php?title=Special:ViewQuizzes&type=most{$user_link}&page=" . ($page-1) . "\">prev</a> ";
				}
				
				
				if(($total % $per_page) != 0)$numofpages++;
				if($numofpages >=9 && $page < $total)$numofpages=9+$page;
				if($numofpages >= ($total / $per_page) )$numofpages = ($total / $per_page)+1;
				
				for($i = 1; $i <= $numofpages; $i++){
					if($i == $page){
					    $output .=($i." ");
					}else{
					    $output .="<a href=\"index.php?title=Special:ViewQuizzes&type=most{$user_link}&page=$i\">$i</a> ";
					}
				}
		
				if(($total - ($per_page * $page)) > 0){
					$output .=" <a href=\"index.php?title=Special:ViewQuizzes&type=most{$user_link}&page=" . ($page+1) . "\">next</a>"; 
				}
				$output .= "</div>";
			}
			
			$wgOut->addHTML($output);
		}
	}
	
	SpecialPage::addPage( new ViewQuizzes );
}

?>
