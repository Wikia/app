<?php

$wgAvailableRights[] = 'quizadmin';
$wgGroupPermissions['staff']['quizadmin'] = true;
$wgGroupPermissions['sysop']['quizadmin'] = true;

$wgQuizLogs = true;
//custom content actions for quiz game
function wfAddQuizContentActions( $skin, $content_actions ){
	global $wgUser, $wgRequest, $wgQuizID, $wgTitle;
	
	
	//Add Edit Page to Content Actions
	if( $wgQuizID > 0  && $wgRequest->getVal( 'questionGameAction' ) != "createForm" && $wgUser->isAllowed( 'quizadmin' ) ){
		$quiz = Title::makeTitle( NS_SPECIAL, "QuizGameHome");
		$content_actions["edit"] = array(
			'class' => ($wgRequest->getVal("questionGameAction") == 'editItem') ? 'selected' : false,
			'text' => wfMsg('edit'),
			'href' => $quiz->getFullURL("questionGameAction=editItem&quizGameId=".$wgQuizID), // @bug 2457, 2510
		);
	}
	
	//if editing, make special page go back to quiz question
	if( $wgRequest->getVal( 'questionGameAction' ) == "editItem" ){
		global $wgQuizID;
		$quiz = Title::makeTitle( NS_SPECIAL, "QuizGameHome");
		$content_actions[$wgTitle->getNamespaceKey()] = array(
			'class' => 'selected',
			'text' => wfMsg('nstab-special'),
			'href' => $quiz->getFullURL("questionGameAction=renderPermalink&permalinkID=" . $wgQuizID), 
		);
	}
	return true;
}

$wgNewuserlogMessages = array();

$wgNewuserlogMessages['en'] = array(
	'quizquestionslogpage'           => 'Quiz Question creation log',
	'quizquestionslogpagetext'       => 'This is a log of quiz question creations',
	'quizquestionslogentry'          => '', # For compatibility, don't translate this
	'quizquestionslog-create-entry'  => 'New quiz question',
 
	'quizquestionslog-create-text'   => "[[$1|quiz question]]", # Don't translate this
);


	
$wgExtensionFunctions[] = 'wfSpecialQuizGameHome';
$wgExtensionFunctions[] = 'wfQuizGameReadLang';

//read in localisation messages
function wfQuizGameReadLang(){
	global $wgMessageCache, $IP;
	require_once ( "QuestionGame.i18n.php" );
	foreach( efWikiaQuizGame() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
}

function wfSpecialQuizGameHome(){

	global $wgUser,$IP, $wgQuizLogs;
	
	# Add messages
	global $wgMessageCache, $wgNewuserlogMessages;
	foreach( $wgNewuserlogMessages as $key => $value ) {
		$wgMessageCache->addMessages( $wgNewuserlogMessages[$key], $key );
	}
		
	if( $wgQuizLogs ){
		# Add a new log type	 
		global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
		$wgLogTypes[]                      = 'quiz';
		$wgLogNames['quiz']            = 'quizquestionslogpage';
		$wgLogHeaders['quiz']          = 'quizquestionslogpagetext';
		$wgLogActions['quiz/quiz'] = 'quizquestionslogentry';
	}	
	class QuizGameHome extends UnlistedSpecialPage {
	
		private $SALT;
		private $INCLUDEPATH;
		
		/* Construct the MediaWiki special page */
		function QuizGameHome() {
			global $wgExtensionsPath;
			parent::__construct("QuizGameHome");
			$this->INCLUDEPATH = "{$wgExtensionsPath}/wikia/QuizGame/";
		}
		
		public function returnIncludePath() {
			return $this->INCLUDEPATH;
		}
		
		// main execute function
		function execute( $permalink ){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgExtensionsPath, $wgStyleVersion, $wgSupressPageTitle;
			
			if( $permalink ){
				$wgOut->redirect( Title::makeTitle( NS_SPECIAL, "QuizGameHome" )->getFullURL("questionGameAction=renderPermalink&permalinkID={$permalink}") );
			}
			
			global $wgHooks;
			$wgHooks["SkinTemplateBuildContentActionUrlsAfterSpecialPage"][] = "wfAddQuizContentActions";
			
			$wgSupressPageTitle=true;

			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgExtensionsPath}/wikia/QuizGame/questiongame.css?{$wgStyleVersion}\"/>\n");
			
			// salt at will
			$this->SALT = "SALT";
			
			$action = $wgRequest->getVal("questionGameAction");
			
	
			switch($action){
			case "createGame":
				$this->createQuizGame();
				break;
			case "launchGame":
				$this->launchGame();
				break;
			case "renderPermalink":
				$this->launchGame();
				break;
			case "castVote":
				$this->castVote();
				break;
			case "flagItem":
				$this->adminAjaxFunctions("FLAG");
				break;
			case "editItem":
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed("quizadmin") ) {
					$this->editItem();
				}else{
					$this->renderWelcomePage();
				}
				break;
			case "completeEdit":
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed("quizadmin") ) {
					$this->completeEdit();
				}else{
					$this->renderWelcomePage();
				}
				break;
			case "deleteItem":
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed("quizadmin") ) {
					$this->adminAjaxFunctions("DELETE");
				}else{
					$this->renderWelcomePage();
				}
				break;
			case "adminPanel":
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed("quizadmin") ) {
					$this->adminPanel();
				}else{
					$this->renderWelcomePage();
				}
				break;				
			case "protectItem":
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed("quizadmin") ) {
					$this->adminAjaxFunctions("PROTECT");
				}else{
					$this->renderWelcomePage();
				}
				break;
			case "unprotectItem":
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed("quizadmin") ) {
					$this->adminAjaxFunctions("UNPROTECT");
				}else{
					$this->renderWelcomePage();
				}
				break;
			case "createForm":
				if( !$wgUser->isLoggedIn() ){
					$this->renderLoginPage();
					return;
				}
				$this->renderWelcomePage();
				break;
			default:
				$this->launchGame();
				break;	 
			
			}
		}
		
		public function user_answered($user_name,$q_id){
			$dbr =& wfGetDB( DB_SLAVE );
			$s = $dbr->selectRow( '`quizgame_answers`', array( 'a_choice_id' ), array('a_q_id'=>$q_id, 'a_user_name' => $user_name ), $fname );
			if ( $s !== false ) {
				if($s->a_choice_id == 0){
					return -1;
				}else{
					return $s->a_choice_id;
				}
			}
			return false;
		}

		public function get_answer_points($user_name,$q_id){
		
			$dbr =& wfGetDB( DB_SLAVE );
			$s = $dbr->selectRow( '`quizgame_answers`', array( 'a_points' ), array('a_q_id'=>$q_id, 'a_user_name' => $user_name ), $fname );
			if ( $s !== false ) {
	
				return $s->a_points;
			}
			return false;
		}
		
		public function get_next_question(){
			global $wgUser;
			$dbr =& wfGetDB( DB_SLAVE );
			$use_index = $dbr->useIndexClause( 'q_random' );
			$randstr = wfRandom();
			
			$q_id = 0;
			$sql = "SELECT q_id FROM quizgame_questions {$use_index} WHERE q_id NOT IN (select a_q_id from quizgame_answers where a_user_name = '" . addslashes($wgUser->getName() ) . "') and q_flag != 'FLAGGED' and q_user_id <> " . $wgUser->getID() . " and q_random>$randstr ORDER by q_random LIMIT 1";
			$res = $dbr->query($sql);
			$row = $dbr->fetchObject( $res );
			if($row){
				$q_id = $row->q_id;
			}
			if($q_id == 0){
				$sql = "SELECT q_id FROM quizgame_questions {$use_index} WHERE q_id NOT IN (select a_q_id from quizgame_answers where a_user_name = '" . addslashes($wgUser->getName() ) . "') and q_flag != 'FLAGGED' and q_user_id <> " . $wgUser->getID() . " and q_random<$randstr ORDER by q_random LIMIT 1";
				$res = $dbr->query($sql);
				$row = $dbr->fetchObject( $res );
				if($row){
					$q_id = $row->q_id;
				}
			}
			return $q_id;
		}
		
		public function get_question($question_id, $skip_id = 0){
			global $wgUser;
			
			$dbr =& wfGetDB( DB_SLAVE );
			if($skip_id > 0)$skip_sql = " and q_id <> {$skip_id}";
			$sql = "SELECT q_id,q_user_id, q_user_name, q_text, q_flag, q_answer_count, q_answer_correct_count, q_picture, q_date
			FROM quizgame_questions WHERE q_id = {$question_id} {$skip_sql} LIMIT 0,1";
			$res = $dbr->query($sql);
			$row = $dbr->fetchObject( $res );
			if($row){
				$quiz["text"]= $row->q_text;
				$quiz["image"]= $row->q_picture;
				$quiz["user_name"]= $row->q_user_name;
				$quiz["user_id"]= $row->q_user_id;
				$quiz["answer_count"]= $row->q_answer_count;	
				$quiz["id"]= $row->q_id;
				$quiz["status"]= $row->q_flag;
				
				if($row->q_answer_count>0){
					$correct_percent =  str_replace(".0","",number_format( $row->q_answer_correct_count / $row->q_answer_count  * 100 , 1) ) ;
				}else{
					$correct_percent = 0;
				}
				$quiz["correct_percent"]= $correct_percent;
				$quiz["user_answer"] = $this->user_answered($wgUser->getName(),$row->q_id);
			
				if($quiz["user_answer"]){
					$quiz["points"] = $this->get_answer_points($wgUser->getName(),$question_id);
	
				}
				$choices = $this->get_question_choices( $question_id, $row->q_answer_count );
				foreach($choices as $choice)if($choice["is_correct"])$quiz["correct_answer"]= $choice["id"];
				$quiz["choices"] = $choices;
			}
			return $quiz;
		}
		
		public function get_question_choices($question_id, $question_answer_count = 0){
			$dbr =& wfGetDB( DB_SLAVE );
			
			$sql = "SELECT choice_id, choice_text, choice_order, choice_answer_count, choice_is_correct
				FROM quizgame_choice 
				WHERE choice_q_id = {$question_id}
				ORDER BY choice_order
				";
			
			$choices = array();
			$res = $dbr->query($sql);
			while ($row = $dbr->fetchObject( $res ) ) {
				if($question_answer_count){
					$percent =  str_replace(".0","",number_format( $row->choice_answer_count / $question_answer_count  * 100 , 1) ) ;
				}else{
					$percent = 0;
				}
		
				 $choices[] = array(
					 "id"=>$row->choice_id,"text"=>$row->choice_text,"is_correct" => $row->choice_is_correct,
					 "answers"=>$row->choice_answer_count ,"percent"=>$percent
					 );
			}
		
			return $choices;
		}

		
		function adminPanel(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP;
			
			$dbr =& wfGetDB( DB_SLAVE );
			
			$sql = "SELECT q_id, q_text, q_flag, q_picture, q_comment FROM quizgame_questions WHERE q_flag=\"FLAGGED\" OR q_flag=\"PROTECT\";";
			$res = $dbr->query($sql);
			//"
			$flaggedQuestions = "";
			$protectedQuestions = "";
			while ( $row = $dbr->fetchObject( $res ) ) {
				
				$options = "<ul>";
				$choices = $this->get_question_choices($row->q_id);
				foreach($choices as $choice){
					$options .= "<li>{$choice["text"]} " . (($choice["is_correct"]==1)?"-correct answer":"") . "</li>";
				}
				$options .= "</ul>";
				
				if (strlen($row->q_picture) > 0) {
					$image = Image::newFromName( $row->q_picture );
					$thumb = $image->getThumbnail( 80, 0, true );
					$thumbnail = $thumb->toHtml();
				} else {
					$thumbnail = "";	
				}
				
				$key = md5( $this->SALT . $row->q_id ); 
				$buttons = "<a href=\"" . Title::makeTitle(NS_SPECIAL, "QuizGameHome")->escapeFullURL("questionGameAction=editItem&quizGameId={$row->q_id }&quizGameKey={$key}") . "\">" . wfMsgForContent( 'quiz_edit' ) . "</a> -
						<a href=\"javascript:deleteById('{$row->q_id }', '{$key}')\">" . wfMsgForContent( 'quiz_delete' ) . "</a> - ";
				
				if ($row->q_flag == "FLAGGED") {
					$buttons .= "<a href=\"javascript:protectById('{$row->q_id }', '{$key}')\">" . wfMsgForContent( 'quiz_protect' ) . "</a> 
						     - <a href=\"javascript:unflagById('{$row->q_id }', '{$key}')\">" . wfMsgForContent( 'quiz_reinstate' ) . "</a>";
				} else {
					$buttons .= "<a href=\"javascript:unprotectById({$row->q_id }, '{$key}')\">" . wfMsgForContent( 'quiz_unprotect' ) . "</a>";
				}
				
				if($row->q_flag == "FLAGGED"){
				
				$reason = "";
				if( $row->q_comment != ""){
					$reason = "<div class=\"quizgame-flagged-answers\" id=\"quizgame-flagged-reason-{$row->q_id}\">
						<b>Reason</b>: {$row->q_comment}
					</div><p>";
				}
				
				$flaggedQuestions .= "<div class=\"quizgame-flagged-item\" id=\"items[{$row->q_id}]\">
					   	
					<h3>{$row->q_text}</h3>
					
					<div class=\"quizgame-flagged-picture\" id=\"quizgame-flagged-picture-{$row->q_id}\">
						{$thumbnail}
					</div>
					
					<div class=\"quizgame-flagged-answers\" id=\"quizgame-flagged-answers-{$row->q_id}\">
						{$options}
					</div>
					{$reason}
					<div class=\"quizgame-flagged-buttons\" id=\"quizgame-flagged-buttons\">
						{$buttons}
					</div>
					
				</div>";
				   
				
				} else {
					
					$protectedQuestions .= "<div class=\"quizgame-protected-item\" id=\"items[{$row->q_id}]\">
				
				   	<h3>{$row->q_text}</h3>

					<div class=\"quizgame-flagged-picture\" id=\"quizgame-flagged-picture-{$row->q_id}\">
						{$thumbnail}
					</div>
					
					<div class=\"quizgame-flagged-answers\" id=\"quizgame-flagged-answers-{$row->q_id}\">
						{$options}
					</div>
					
					<div class=\"quizgame-flagged-buttons\" id=\"quizgame-flagged-buttons\">
						{$buttons}
					</div>
					
				</div>";

				}
			}

			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$this->INCLUDEPATH}adminpanel.js?{$wgStyleVersion}\"></script>\n");
			

			$wgOut->setPagetitle( wfMsgForContent( 'quiz_admin_panel_title' ) );
			
			$output .= "<div class=\"quizgame-admin\" id=\"quizgame-admin\">
					
					<div class=\"ajax-messages\" id=\"ajax-messages\" style=\"color:red; font-size:16px; font-weight:bold;margin:0px 0px 15px 0px;\"></div>
					
					<div class=\"quizgame-admin-top-links\"> 
						<a href=\"" . Title::makeTitle(NS_SPECIAL, "QuizGameHome")->escapeFullURL("questionGameAction=launchGame") . "\">" . wfMsgForContent( 'quiz_admin_back' ) . "</a>
					</div>
					
					<h1>" . wfMsgForContent( 'quiz_admin_flagged' ) . "</h1>
					{$flaggedQuestions}
					
					<h1>" . wfMsgForContent( 'quiz_admin_protected' ) . "</h1>
					{$protectedQuestions}
					
				  </div>";
			
			$wgOut->addHTML( $output );
		}
		
		// Completes an edit of a question"
		// updates the SQL and then forwards to the permalink
		function completeEdit(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP;
			
			$key = $wgRequest->getVal("quizGameKey");
			$id =  $wgRequest->getVal("quizGameId");
			
			if( !$wgUser->isAllowed("quizadmin") ){
				$output = wfMsgForContent( 'quiz_admin_permission' ); //"You dont have permission to edit";
				$wgOut->addHTML($output);
				return;
			}
			
			$question =   $wgRequest->getVal("quizgame-question");
			$choices_count =   $wgRequest->getVal("choices_count");
			$old_correct_id =   $wgRequest->getVal("old_correct");
			
			$picture = $wgRequest->getVal("quizGamePicture");
			
			//Updated Quiz Choices
			$dbr =& wfGetDB( DB_MASTER );
			for($x=1;$x<=$choices_count;$x++){
				if( $wgRequest->getVal("quizgame-answer-{$x}") ){
					 
					if( $wgRequest->getVal("quizgame-isright-{$x}") == "on" ) {
						$is_correct = 1;
					}else{
						$is_correct = 0;
					}
					
					$dbr->update( 'quizgame_choice',
					array( 'choice_text'=>$wgRequest->getVal("quizgame-answer-{$x}"), 'choice_is_correct'=>$is_correct),
					array( 'choice_q_id' => $id, 'choice_order' => $x ),
					__METHOD__ );
				}
			}
			
			$dbr->update( 'quizgame_questions',
			array( 'q_text'=>$question, 'q_picture'=>$picture),
			array( 'q_id' => $id ),
			__METHOD__ );
			
			//get new correct answer to see if its different, and if we have to update any user stats
			$s = $dbr->selectRow( 'quizgame_choice', array( 'choice_id' ), array( 'choice_q_id' => $id, 'choice_is_correct' => 1)   );
			if ( $s !== false ) {
				$new_correct_id = $s->choice_id;
			}

			//ruh roh rorge..we have to fix stats
			if( $new_correct_id != $old_correct_id){
				
				//those who had the old answer id correct need their total to be decremented
				$sql = "UPDATE user_stats set stats_quiz_questions_correct=stats_quiz_questions_correct-1
				WHERE stats_user_id in (select a_user_id from quizgame_answers where a_choice_id = {$old_correct_id} )";
				$res = $dbr->query($sql);
		 
				//those who had the new answer id correct need their total to be increased
				$sql = "UPDATE user_stats set stats_quiz_questions_correct=stats_quiz_questions_correct+1
				WHERE stats_user_id in (select a_user_id from quizgame_answers where a_choice_id = {$new_correct_id} )";
				$res = $dbr->query($sql);
				 
				//finally, we need to adjust everyone's %'s who have been affected by this switch
				$sql = "UPDATE user_stats set stats_quiz_questions_correct_percent=stats_quiz_questions_correct /stats_quiz_questions_answered
				WHERE stats_user_id in (select a_user_id from quizgame_answers where a_choice_id = {$new_correct_id} or a_choice_id = {$old_correct_id} )";
				$res = $dbr->query($sql);
				
				//also, we need to adjust the question table and fix how many answered it correctly
				$sql = "UPDATE quizgame_questions set q_answer_correct_count=(select count(*) from quizgame_answers where a_choice_id = {$new_correct_id}) where q_id={$id} ";
				$res = $dbr->query($sql);
			}
			
			header("Location: " . Title::makeTitle(NS_SPECIAL, "QuizGameHome")->getFullURL("renderPermalink&permalinkID={$id}") );
			
		}
		
		// shows the edit panel for a single question
		function editItem(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgUploadPath;
			
			$key = $wgRequest->getVal("quizGameKey");
			$id =  $wgRequest->getVal("quizGameId");
			
			global $wgQuizID;
			$wgQuizID = $id;
			
			if($key != md5( $this->SALT . $id ) ){
				//$output = wfMsgForContent( 'quiz_admin_permission' ); //"You dont have permission to edit";
				//$wgOut->addHTML($output);
				//return;
			}
			
			$question = $this->get_question($id);
			
			$wgOut->setPageTitle( wfMsgForContent( 'quiz_edit_title' ) . " - " . $question["text"] );
			
			$user_name = $question["user_name"];
			$user_id = $question["user_id"];
			$user_title = Title::makeTitle( NS_USER  , $question["user_name"]  );
			$avatar = new wAvatar($user_id,"l");
			$avatarID = $avatar->getAvatarImage();
			$stats = new UserStats($user_id, $user_name);
			$stats_data = $stats->getUserStats();
			
			if(strlen( $question["image"] ) > 0){
				$image = Image::newFromName( $question["image"] );
				$thumb = $image->getThumbnail( 80 );
				$thumbtag = $thumb->toHtml();
				
				$pictag =  "<div id=\"quizgame-picture\" class=\"quizgame-picture\">" . $thumbtag . "</div>
					    <p id=\"quizgame-editpicture-link\"><a href=\"javascript:showUpload()\">" . wfMsgForContent( 'quiz_edit_picture_link' ) . "</a></p>
					    <div id=\"quizgame-upload\" class=\"quizgame-upload\" style=\"display:none\"> 
					  	<iframe id=\"imageUpload-frame\" class=\"imageUpload-frame\" width=\"420\" scrolling=\"no\" frameborder=\"0\" src=\"/index.php?title=Special:QuestionGameUpload&wpThumbWidth=80&wpCategory=Quizgames&wpOverwriteFile=true&wpDestFile={$question["image"]}\">
						</iframe>
					    </div>";
				
			} else {
				$pictag =  "<div id=\"quizgame-picture\" class=\"quizgame-picture\"></div>
					    <div id=\"quizgame-editpicture-link\"></div>
					
					   	<div id=\"quizgame-upload\" class=\"quizgame-upload\"> 
								<iframe id=\"imageUpload-frame\" class=\"imageUpload-frame\" width=\"420\" scrolling=\"no\" frameborder=\"0\" src=\"/index.php?title=Special:QuestionGameUpload&wpThumbWidth=80&wpCategory=Quizgames\">
								</iframe>
					    </div>
						
						</div>";
			}
			$x = 1;
			$choices_count = count($question["choices"]);
			$quizOptions = "";
			foreach($question["choices"] as $choice){
				if($choice["is_correct"])$old_correct = $choice["id"];
						$quizOptions .= "<div id=\"quizgame-answer-container-{$x}\" class=\"quizgame-answer\" >
								<span class=\"quizgame-answer-number\">{$x}.</span>
								<input name=\"quizgame-answer-{$x}\" id=\"quizgame-answer-{$x}\" type=\"text\" value=\"" . htmlspecialchars($choice["text"], ENT_QUOTES) . "\" size=\"32\"   />
								<input type=\"checkbox\" onclick=\"javascript:toggleCheck(this)\" id=\"quizgame-isright-{$x}\" " . (($choice["is_correct"])?"checked":"") . " name=\"quizgame-isright-{$x}\">
								</div>";
						
						$x++;
					}
					
			 
			
			$output = "<div class=\"quizgame-edit-container\" id=\"quizgame-edit-container\">
				
					<script type=\"text/javascript\">
					var __choices_count__ = {$choices_count};
					</script>";
					
					$wgOut->addScript("<script type=\"text/javascript\" src=\"{$this->INCLUDEPATH}edititem.js?{$wgStyleVersion}\"></script>\n");

			$output .= "
				
					<div class=\"quizgame-edit-question\" id=\"quizgame-edit-question\">
						<form name=\"quizGameEditForm\" id=\"quizGameEditForm\" method=\"post\" action=\"/index.php?title=Special:QuizGameHome&questionGameAction=completeEdit\">
							
							<div class=\"credit-box\" id=\"creditBox\">
								<h1>" . wfMsgForContent( 'quiz_submitted_by' ) . "</h1>

								<div id=\"submitted-by-image\" class=\"submitted-by-image\">
								<a href=\"{$user_title->getFullURL()}\">
									<img src=\"{$wgUploadPath}/avatars/{$avatarID}\" style=\"border:1px solid #d7dee8; width:50px; height:50px;\"/></a>
								</div>

								<div id=\"submitted-by-user\" class=\"submitted-by-user\">
									<div id=\"submitted-by-uEffectser-text\"><a href=\"{$user_title->getFullURL()}\">{$user_name}</a></div>							
									<ul>
										<li id=\"userstats-votes\">
											<img src=\"{$wgUploadPath}/common/voteIcon.gif\" border=\"0\"> {$stats_data["votes"]}
										</li>
										<li id=\"userstats-edits\">
											<img src=\"{$wgUploadPath}/common/pencilIcon.gif\" border=\"0\"> {$stats_data["edits"]}
										</li>
										<li id=\"userstats-comments\">
											<img src=\"{$wgUploadPath}/common/commentsIcon.gif\" border=\"0\"> {$stats_data["comments"]}
										</li>
									</ul>
								</div>
								<div class=\"cleared\"></div>
							</div>
							
							<div class=\"ajax-messages\" id=\"ajax-messages\" style=\"color:red; font-size:16px; font-weight:bold;margin:20px 0px 15px 0px;\"></div>
							
							<h1>" . wfMsgForContent( 'quiz_question' ) . "</h1>
							<input name=\"quizgame-question\" id=\"quizgame-question\" type=\"text\" value=\"" . htmlspecialchars($question["text"], ENT_QUOTES)  . "\" size=\"64\" />
							<h1>" . wfMsgForContent( 'quiz_answers' ) . "</h1>
							<div style=\"margin:10px 0px;\">" . wfMsgForContent( 'quiz_correct_answer_checked' ) . "</div>
							{$quizOptions}
							<h1>" . wfMsgForContent( 'quiz_picture' ) . "</h1>
							<div class=\"quizgame-edit-picture\" id=\"quizgame-edit-picture\">
								{$pictag}
							</div>
							
							<input id=\"quizGamePicture\" name=\"quizGamePicture\" type=\"hidden\" value=\"{$question["image"]}\" />

							<input id=\"quizGameId\" name=\"quizGameId\" type=\"hidden\" value=\"{$question["id"]}\" />
							<input id=\"quizGameKey\" name=\"quizGameKey\" type=\"hidden\" value=\"{$key}\" />
							<input name=\"choices_count\" type=\"hidden\" value=\"{$choices_count}\" /> 
							<input name=\"old_correct\" type=\"hidden\" value=\"{$old_correct}\" />
						</form>
					</div>
					
					<div class=\"quizgame-copyright-warning\">".wfMsgExt("copyrightwarning","parse")."</div>
					
					<div class=\"quizgame-edit-buttons\" id=\"quizgame-edit-buttons\">
						<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'quiz_save_page_button' ) . "\" onclick=\"javascript:document.quizGameEditForm.submit()\"/>
						<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'quiz_cancel_button' ) . "\" onclick=\"javascript:document.location='/index.php?title=Special:QuizGameHome&questionGameAction=launchGame'\"/>
					</div>
				</div>
				";
			
			$wgOut->addHTML($output);
		}
		//" present some log in message
		function renderLoginPage(){
			global $wgOut;
			
			$wgOut->setPageTitle(wfMsgForContent( 'quiz_login_title' ));
			
			$output = wfMsgForContent( 'quiz_login_text' ) . "<p>";
			$output .= "<div>
				<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'quiz_main_page_button' ) . "\" onclick=\"window.location='" . Title::newMainPage()->escapeFullURL() . "'\"/> 
				<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'quiz_login_button' ) . "\" onclick=\"window.location='" . Title::makeTitle(NS_SPECIAL, "Userlogin")->escapeFullURL() . "'\"/>
			</div>";
			$wgOut->addHTML($output);
		}
		
		//" present some log in message
		function renderQuizOver(){
			global $wgOut, $wgSupressPageTitle;
			$wgSupressPageTitle = false;
			
			$wgOut->setPageTitle(wfMsgForContent( 'quiz_nomore_questions' ));
			
			$output = wfMsgExt( 'quiz_ohnoes', "parse" );
			$output .= "<div>
			<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'quiz_create_button' ) . "\" onclick=\"window.location='/index.php?title=Special:QuizGameHome&questionGameAction=createForm'\"/> 
				
			</div>";
			$wgOut->addHTML($output);
			return '';
		}
		
		function renderPermalinkError(){
			global $wgOut, $wgSupressPageTitle;
			$wgSupressPageTitle = false;
			
			$output = wfMsg( 'quiz_unavailable' , Title::makeTitle(NS_SPECIAL, "QuizGameHome")->escapeFullURL() );
			$wgOut->setPageTitle( wfMsg('quiz_title') );
			$wgOut->addHTML($output);	
		}
		
		function renderStart(){
			global $wgOut;
			$wgOut->setPageTitle(wfMsgForContent( 'quiz_title' ));
			$output = wfMsgForContent( 'quiz_intro' ) . "  <a href=\"" . Title::makeTitle(NS_SPECIAL, "QuizGameHome")->escapeFullURL("questionGameAction=launchGame") . "\">" . wfMsgForContent( 'quiz_introlink' ) . "</a>";
			$wgOut->addHTML($output);	
		}
		
		
		// main function to render a game
		// also handles rendering a permalink
		function launchGame(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgUploadPath, $wgSiteName, $wgStyleVersion;
			
			$on_load = "show_answers();";
			
			
			// controls the maximum length of the previous game bar graphs"
			$dbr =& wfGetDB( DB_MASTER );
			
			$permalinkID = addslashes ( $wgRequest->getVal("permalinkID") );
			
			$lastid = addslashes ( $wgRequest->getVal("lastid") );
			$skipid = addslashes ( $wgRequest->getVal("skipid") );
			
			$isPermalink = is_numeric($permalinkID);
			$isFixedlink = false;
			$permalinkOptions = -1;
			$backButton = "";
			$editMenu = "";
			$editLinks = "";
			
			//logged in user's stats
			$stats = new UserStats($wgUser->getID(), $wgUser->getName() );
			$current_user_stats = $stats->getUserStats();
			if( ! $current_user_stats["quiz_points"] ) $current_user_stats["quiz_points"] = 0;
			
			//get users rank
			$quiz_rank = 0;
			$s = $dbr->selectRow( '`user_stats`', array( 'count(*) as count' ), array("stats_quiz_points> " . str_replace(",","",$current_user_stats["quiz_points"])  ), $fname );
			if ( $s !== false ) {
				$quiz_rank = $s->count+1;
			}	
			
			// this is assuming that lastid and permalinkid 
			// are mutually exclusive
			
			if( $isPermalink ){
				$question = $this->get_question($permalinkID);
				if(!$question){
					$this->renderPermalinkError();
					return "";
				}
			}else{
				$question = $this->get_question( $this->get_next_question(), $skipid );
				if(!$question){
					$this->renderQuizOver();
					return "";
				}
			}
			global $wgQuizID;
			$wgQuizID = $question["id"];
			
			$timestamped_viewed = 0;
			if($wgUser->getName() != $question["user_name"]){
				//check to see if the user already had viewed this question
				global $wgMemc;
				$key = wfMemcKey( 'quizgame_user_view', $wgUser->getID(), $question["id"] );
				$data = $wgMemc->get( $key );
				if( $data > 0 ){
					$timestamped_viewed = $data;
				}else{
					//mark that they viewed for first time
					$wgMemc->set( $key, time() );	
				}
				$on_load .= "count_down({$timestamped_viewed});";
			}
			
			if ( is_numeric($lastid) ){
				$prev_question = $this->get_question( $lastid  );
			}
			
			$wgOut->addScript("<script type=\"text/javascript\">YAHOO.util.Event.on(window, 'load', function () {" . $on_load . "});</script>");
			
			$gameid = $question["id"];
			$wgOut->setHTMLTitle( wfMsg( 'pagetitle', $question["text"] ) );
			$wgOut->setPageTitle( wfMsg( 'pagetitle', $question["text"] ) );
			if(strlen($question["image"]) > 0){
				$image = Image::newFromName( $question["image"] );
				$imageThumb = $image->createThumb(160);
				$imageThumb .= "?" . time();
				$imageTag = "
				<div id=\"quizgame-picture\" class=\"quizgame-picture\">
					<img src='" . $imageThumb . "' width='" . 
						($image->getWidth() >= 160 ? 160 : $image->getWidth() ) . "'></div>";
			}else{
				$imageTag = "";
			}
		
			$key = md5( $this->SALT . $gameid );
			
			$user_name = $question["user_name"];
			$user_title = Title::makeTitle(NS_USER,$user_name);
			$id = $question["user_id"];
			$avatar = new wAvatar($id,"l");
			$avatarID = $avatar->getAvatarImage();
			$stats = new UserStats($id, $user_name);
			$stats_data = $stats->getUserStats();
			
			$user_answer = $this->user_answered($wgUser->getName(), $gameid);
			
			global $wgUseEditButtonFloat, $wgUploadPath;
			if (($wgUser->getID() == $question["user_id"] || ($user_answer && $wgUser->isLoggedIn() && $wgUser->isAllowed("quizadmin")) || in_array('staff',($wgUser->getGroups()))) && ($wgUseEditButtonFloat == true)) {
				$editMenu = "
					<div class=\"edit-menu-quiz-game\">
						<div class=\"edit-button-quiz-game\">
						<img src=\"{$wgUploadPath}/common/editIcon.gif\"/>
						<a href=\"javascript:showEditMenu()\">" . wfMsgForContent( 'quiz_edit' ) . "</a>
					</div></div>";
				
				$editLinks = "
				    <a href=\"" . Title::makeTitle( NS_SPECIAL  , "QuizGameHome"  )->escapeFullURL("questionGameAction=adminPanel") . "\">" . wfMsgForContent( 'quiz_admin_panel_title' ) . "</a> -
					<a href=\"javascript:protectImage()\">" . wfMsgForContent( 'quiz_protect' ) . "</a> -
					<a href=\"javascript:deleteQuestion()\">" . wfMsgForContent( 'quiz_delete' ) . "</a> -";
			}
			
			$leaderboard_title = Title::makeTitle( NS_SPECIAL  , "QuizLeaderboard"  );
			
			if($wgUser->isLoggedIn()){
				$stats_box = "<div class=\"user-rank\">
						<h2>" . wfMsgForContent( 'quiz_leaderboard_scoretitle' ) . "</h2>
						
						<p><b>" . wfMsgForContent( 'quiz_leaderboard_quizpoints' ) . "</b></p>
						<p class=\"user-rank-points\">{$current_user_stats["quiz_points"]}</p>
						<div class=\"cleared\"></div>
						
						<p><b>" . wfMsgForContent( 'quiz_leaderboard_correct' ) . "</b></p>
						<p>{$current_user_stats["quiz_correct"]}</p>
						<div class=\"cleared\"></div>
						
						<p><b>" . wfMsgForContent( 'quiz_leaderboard_answered' ) . "</b></p>
						<p>{$current_user_stats["quiz_answered"]}</p>
						<div class=\"cleared\"></div>
						
						<p><b>" . wfMsgForContent( 'quiz_leaderboard_pctcorrect' ) . "</b></p>
						<p>{$current_user_stats["quiz_correct_percent"]}%</p>
						<div class=\"cleared\"></div>
						
						<p><b>" . wfMsgForContent( 'quiz_leaderboard_rank' ) . "</b></p>
						<p>{$quiz_rank} <span class=\"user-rank-link\">
							<a href=\"{$leaderboard_title->getFullURL()}\">(" . wfMsgForContent( 'quiz_leaderboard_link' ) . ")</a>
						</span></p>
						<div class=\"cleared\"></div>
						
					</div>";
			}else{
				$stats_box = "<div class=\"user-rank\"><h2>" . wfMsgForContent( 'quiz_leaderboard_scoretitle' ) . "</h2><a href=\"" . Title::makeTitle(NS_SPECIAL, "Userlogin")->escapeFullURL() . "\">" . wfMsgForContent( 'quiz_login' ) . "</a> " . wfMsgForContent( 'quiz_or' ) . " <a href=\"" . Title::makeTitle(NS_SPECIAL, "UserRegister")->escapeFullURL() . "\">" . wfMsgForContent( 'quiz_create_account' ) . "</a> " . wfMsgForContent( 'quiz_leaderboard_climb' ) . "</div>";
			}
			
			
			
			if($user_answer){
				
				$answers .= "<div class=\"answer-percent-correct\">{$question["correct_percent"]}" . wfMsgForContent( 'quiz_pct_answered_correct' ) . "</div>";
				if($user_answer == $question["correct_answer"]){
					$answers .= "<div class=\"answer-message-correct\">" . wfMsgForContent( 'quiz_answered_correctly' ) . "</div>";
				}else{
					if($user_answer == -1){
						$answers .= "<div class=\"answer-message-incorrect\">" . wfMsgForContent( 'quiz_skipped' ) . "</div>";
					}else{
						$answers .= "<div class=\"answer-message-incorrect\">" . wfMsgForContent( 'quiz_answered_incorrectly' ) . "</div>";
					}
				}
			}
			
			//User hasn't answered yet, so display the quiz options with the ability to play the question
			if( !$user_answer && $wgUser->getName() != $question["user_name"] ){
				$answers .= "<ul>";
				$x = 1;
				foreach($question["choices"] as $choice){
					$answers .= "<li id=\"{$x}\"><a href=\"javascript:vote({$choice["id"]});\">{$choice["text"]}</a></li>";
					$x++;
				}
				$answers .= "</ul>";
			}else{
			//User has answered, so display the right answer, and how many people picked what
				$x = 1;
				foreach($question["choices"] as $choice){
					$bar_width = floor( 220 * ( $choice["percent"] / 100 )) ;
					$answers .= "<div id=\"{$x}\" class=\"answer-choice\">{$choice["text"]}" . (( $user_answer == $choice["id"] && $question["correct_answer"] != $choice["id"])?"- <span class=\"answer-message-incorrect\">" . wfMsgForContent( 'quiz_your_answer' ) . "</span>":"") . (($question["correct_answer"] == $choice["id"])?"- <span class=\"answer-message-correct\">" . wfMsgForContent( 'quiz_correct_answer' ) . "</span>":"") . "</div>";
					$answers .= "<div id=\"one-answer-bar\" style=\"margin-bottom:10px;\" class=\"answer-".($choice["is_correct"] == 1 ? "green" : "red")."\">
												<img border=\"0\" style=\"width:{$bar_width}px; height: 9px;\" id=\"one-answer-width\" src=\"{$wgUploadPath}/common/vote-bar-" . ($choice["is_correct"] == 1 ? "green" : "red") . ".gif\"/> 
												<span class=\"answer-percent\">{$choice["percent"]}%</span>
											</div>";
					$x++;
				}
			}
		
			
			
			
			$output = "
			<script type=\"text/javascript\" src=\"{$this->INCLUDEPATH}lightbox_light.js?" . $wgStyleVersion . "\"></script>
			
			<script type=\"text/javascript\">
				var __quiz_js_reloading__ = \"" . wfMsgForContent( 'quiz_js_reloading' ) . "\";
				var __quiz_js_errorwas__ = \"" . wfMsgForContent( 'quiz_js_errorwas' ) . "\";
				var __quiz_js_timesup__ = \"" . wfMsgForContent( 'quiz_js_timesup' ) . "\";
				var __quiz_js_points__ = \"" . wfMsgForContent( 'quiz_js_points' ) . "\";
				var __quiz_pause_continue__ = \"" . wfMsgForContent( 'quiz_pause_continue' ) . "\";				
				var __quiz_pause_view_leaderboard__ = \"" . wfMsgForContent( 'quiz_pause_view_leaderboard' ) . "\";
				var __quiz_pause_create_question__ = \"" . wfMsgForContent( 'quiz_pause_create_question' ) . "\";
				var __quiz_main_page_button__ = \"" . wfMsgForContent( 'quiz_main_page_button' ) . "\";
				var __quiz_js_loading__ = \"" . wfMsgForContent( 'quiz_js_loading' ) . "\";
				var __quiz_lightbox_pause_quiz__ = \"" . wfMsgForContent( 'quiz_lightbox_pause_quiz' ) . "\";			
				var __quiz_lightbox_breakdown__ = \"" . wfMsgForContent( 'quiz_lightbox_breakdown' ) . "\";
				var __quiz_lightbox_breakdown_percent__ = \"" . wfMsgForContent( 'quiz_lightbox_breakdown_percent' ) . "\";
				var __quiz_lightbox_correct__ = \"" . wfMsgForContent( 'quiz_lightbox_correct' ) . "\";
				var __quiz_lightbox_incorrect__ = \"" . wfMsgForContent( 'quiz_lightbox_incorrect' ) . "\";
				var __quiz_lightbox_correct_points__ = \"" . wfMsgForContent( 'quiz_lightbox_correct_points' ) . "\";
				var __quiz_lightbox_incorrect_correct__ = \"" . wfMsgForContent( 'quiz_lightbox_incorrect_correct' ) . "\";
				var __quiz_time__ = \"" . time() . "\";
				
			
			</script>

			<script type=\"text/javascript\" src=\"{$this->INCLUDEPATH}launchgame.js?{$wgStyleVersion}\"></script>

			
			<div id=\"quizgame-container\" class=\"quizgame-container\">
				{$editMenu}
			";
			
					$output .= "<div class=\"quizgame-left\">
					<div id=\"quizgame-title\" class=\"quizgame-title\">
								{$question["text"]}
					</div>";
					
					if( !$user_answer && $wgUser->getName() != $question["user_name"] ){
							$output .= "<div class=\"time-box\">
							<div class=\"quiz-countdown\">
								<span id=\"time-countdown\">-</span> " . wfMsgForContent( 'quiz_js_seconds' ) . "
							</div>
								
							<div class=\"quiz-points\" id=\"quiz-points\">
								30 pts
							</div>
							<div class=\"quiz-notime\" id=\"quiz-notime\"></div>
							</div>";
						}
						
					
						
						$output .= "<div class=\"ajax-messages\" id=\"ajax-messages\"></div>";
						
						$output .="
						
						{$imageTag}
						
						<div id=\"loading-answers\" >" . wfMsgForContent( 'quiz_js_loading' ) . "</div>
						<div id=\"quizgame-answers\" style=\"display:none;\" class=\"quizgame-answers\">
							{$answers}
						</div>
						
						<form name=\"quizGameForm\" id=\"quizGameForm\">
							<input id=\"quizGameId\" name=\"quizGameId\" type=\"hidden\" value=\"{$gameid}\" />
							<input id=\"quizGameKey\" name=\"quizGameKey\" type=\"hidden\" value=\"{$key}\" />
						</form>
					
						<div class=\"navigation-buttons\">
							{$backButton}";
							
						if(!$user_answer && $wgUser->getName() != $question["user_name"] ){
							$output .=  "<a href=\"javascript:void(0);\" onclick=\"javascript:skip_question();\">" . wfMsgForContent( 'quiz_skip' ) . "</a>";
						}else{
							$output .=  "<a href=\"" . Title::makeTitle(NS_SPECIAL, "QuizGameHome")->escapeFullURL("questionGameAction=launchGame") . "\">" . wfMsgForContent( 'quiz_next' ) . "</a>";
						}
						$output .= "</div>";
						
							if($prev_question["id"] && $prev_question["user_answer"]) {
								
								$output .= "<div id=\"answer-stats\" class=\"answer-stats\" style=\"display:block\">
				
								<div class=\"last-game\">
							
								<div class=\"last-question-heading\">
									" . wfMsgForContent( 'quiz_last_question' ) . " - <a href=\"" . Title::makeTitle(NS_SPECIAL, "QuizGameHome")->escapeFullURL("questionGameAction=renderPermalink&permalinkID={$prev_question["id"]}") . "\">{$prev_question["text"]}</a>
									<div class=\"last-question-count\">" . wfMsgForContent( 'quiz_times_answered', $prev_question["answer_count"] ) ."</div>
								</div>";
								 
								if($prev_question["id"] && $prev_question["user_answer"]){
							
							//Get the choice text of what the user picked (and show how many points they got)
							foreach($prev_question["choices"] as $choice){
								if($choice["id"] == $prev_question["user_answer"]){
									$your_answer = $choice["text"];
									if($choice["is_correct"] == 1){
										$your_answer_status = "<div class=\"answer-status-correct\">
											" . wfMsgForContent( 'quiz_chose_correct', $prev_question["points"] ) ."
										</div>";
									}else{
										$your_answer_status = "<div class=\"answer-status-incorrect\">
											" . wfMsgForContent( 'quiz_chose_incorrect' ) . "
										</div>";
									}
								}
							}
						}
						
								$output .= "<div class=\"user-answer-status\">
									{$your_answer_status}
								</div>";
						
								foreach($prev_question["choices"] as $choice){
									$bar_width = floor( 460 * ( $choice["percent"] / 100 )) ;
									$output .= "<div class=\"answer-bar\" id=\"answer-bar-one\" style=\"display:block\">
											<div id=\"one-answer\" class=\"small-answer-".($choice["is_correct"] == 1 ? "correct" : "incorrect")."\">{$choice["text"]}</div>
									<span id=\"one-answer-bar\" class=\"answer-".($choice["is_correct"] == 1 ? "green" : "red")."\">
									<img border=\"0\" style=\"width:{$bar_width}px; height: 11px;\" id=\"one-answer-width\" src=\"{$wgUploadPath}/common/vote-bar-" . ($choice["is_correct"] == 1 ? "green" : "red") . ".gif\"/> 
									<span id=\"one-answer-percent\" class=\"answer-percent\">{$choice["percent"]}%</span>
									</span>
								</div>";	
								}
									
									
									
								$output .= "</div>
								</div>";
							}
							
					
					$output .= "</div>
					
					<div class=\"quizgame-right\">
					
						<div class=\"create-link\"><img border=\"0\" src=\"{$wgUploadPath}/common/addIcon.gif\"/> <a href=\"" . Title::makeTitle(NS_SPECIAL, "QuizGameHome")->escapeFullURL("questionGameAction=createForm") . "\">" . wfMsgForContent( 'quiz_create_title' ) . "</a></div>
						<div class=\"credit-box\" id=\"creditBox\">
							<h1>" . wfMsgForContent( 'quiz_submitted_by' ) . "</h1>
							
							<div id=\"submitted-by-image\" class=\"submitted-by-image\">
							<a href=\"{$user_title->getFullURL()}\">
							<img src=\"{$wgUploadPath}/avatars/{$avatarID}\" style=\"border:1px solid #d7dee8; width:50px; height:50px;\"/></a>
							</div>
						
							<div id=\"submitted-by-user\" class=\"submitted-by-user\">
								<div id=\"submitted-by-user-text\"><a href=\"" . Title::makeTitle(NS_USER, $user_name)->escapeFullURL() . "\">{$user_name}</a></div>							
								<ul>
									<li id=\"userstats-votes\">
										<img src=\"{$wgUploadPath}/common/voteIcon.gif\" border=\"0\"> {$stats_data["votes"]}
									</li>
									<li id=\"userstats-edits\">
										<img src=\"{$wgUploadPath}/common/pencilIcon.gif\" border=\"0\"> {$stats_data["edits"]}
									</li>
									<li id=\"userstats-comments\">
										<img src=\"{$wgUploadPath}/common/commentsIcon.gif\" border=\"0\"> {$stats_data["comments"]}
									</li>
								</ul>
								</div>
								<div class=\"cleared\"></div>
								{$stats_box}
							</div>
							<div class=\"bottom-links\" id=\"utility-buttons\">
								<a href=\"javascript:flagQuestion()\">" . wfMsgForContent( 'quiz_flag' ) . "</a> - ";
								
								$admin_panel_link = Title::makeTitle(NS_SPECIAL,"QuizGameHome");
						
								if ($wgUser->isAllowed("quizadmin")) {
									
									$output .= "<a href=\"".$admin_panel_link->escapeFullURL("questionGameAction=adminPanel")."\">"
										.wfMsgForContent('quiz_admin_panel_title').
									"</a> -
									<a href=\"javascript:protectImage()\">" . wfMsgForContent( 'quiz_protect' ) . "</a> -
									<a href=\"javascript:deleteQuestion()\">" . wfMsgForContent( 'quiz_delete' ) . "</a> - ";
									
								}
								
								//{$editLinks}
								$output .= "<a href=\"javascript:document.location='" . Title::makeTitle(NS_SPECIAL, "QuizGameHome")->escapeFullURL("questionGameAction=renderPermalink") . "&permalinkID=' + \$G( 'quizGameId' ).value\">" . wfMsgForContent( 'quiz_permalink' ) . "</a>
								
								<div id=\"flag-comment\" style=\"display:none;margin-top:5px;\">Reason: <input type=\"text\" size=\"20\" id=\"flag-reason\"> <input type=\"button\" onclick=\"doflagQuestion()\" value=\"Submit\"></div>
							</div>
					</div>
				</div>
				
				<div class=\"cleared\"/>
				<div class=\"hiddendiv\" style=\"display:none\">
					<img src=\"{$this->INCLUDEPATH}overlay.png\">
				</div>
			</div>";
			
			$wgOut->addHTML($output);
		}
		
		//" function that inserts questions into the database
		function createQuizGame(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP;
			
			$key = $wgRequest->getText("key");
			$chain = $wgRequest->getText("chain");
			
			$max_answers = 8;
			
			if($key != md5( $this->SALT . $chain ) ){
				header( 'Location: ' . Title::makeTitle(NS_SPECIAL,"QuizGameHome")->getFullURL() ) ;
				return;
			}
			
			$question = $wgRequest->getText("quizgame-question") ;
			$imageName =  $wgRequest->getText("quizGamePictureName");

			//Add Quiz Question
			$dbr =& wfGetDB( DB_MASTER );
			$dbr->insert( '`quizgame_questions`',
			array(
				'q_user_id' => $wgUser->getID(),
				'q_user_name' => $wgUser->getName(),
				'q_text' => strip_tags($question), //make sure no inserts malicious code
				'q_picture' => $imageName,
				'q_date' => date("Y-m-d H:i:s"),
				'q_random' => wfRandom()
				), __METHOD__
			);	
			$question_id =  $dbr->insertId();

			//Add Quiz Choices
			$dbr =& wfGetDB( DB_MASTER );
			for($x=1;$x<=$max_answers;$x++){
				if( $wgRequest->getVal("quizgame-answer-{$x}") ){
					 
					if( $wgRequest->getVal("quizgame-isright-{$x}") == "on" ) {
						$is_correct = 1;
					}else{
						$is_correct = 0;
					}
					$dbr->insert( '`quizgame_choice`',
					array(
						'choice_q_id' => $question_id,
						'choice_text' => strip_tags( $wgRequest->getVal("quizgame-answer-{$x}")), //make sure no inserts malicious code
						'choice_order' => $x,
						'choice_is_correct' => $is_correct
						), __METHOD__
					);
				}
			}
			$stats = new UserStatsTrack($wgUser->getID(), $wgUser->getName());
			$stats->incStatField("quiz_created");
			
			$message = wfMsgForContent( 'quizquestionslog-create-text',
			"Special:QuizGameHome/{$question_id}" );
			
			global $wgQuizLogs;
			if( $wgQuizLogs ){
				$log = new LogPage( 'quiz' );
				$log->addEntry( "create", $wgUser->getUserPage(), $message );
			}
			global $wgMemc;
			$key = wfMemcKey( 'user', 'profile', 'quiz' , $wgUser->getID());
			$wgMemc->delete( $key );
			
			header( 'Location: ' . Title::makeTitle(NS_SPECIAL,"QuizGameHome")->getFullURL("questionGameAction=renderPermalink&permalinkID={$question_id}") );
			 
		}
		
		function renderWelcomePage(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgStyleVersion;
	
			if( $wgUser->isBlocked() ){
				$wgOut->blockedPage( false );
				return false;
			}
			
			/*/
			/*Create Quiz Thresholds based on User Stats
			/*/
			global $wgCreateQuizThresholds;
			if( is_array( $wgCreateQuizThresholds ) && count( $wgCreateQuizThresholds ) > 0 ){
				
				$can_create = true;
				
				$stats = new UserStats( $wgUser->getID(), $wgUser->getName() );
				$stats_data = $stats->getUserStats();
				
				$threshold_reason = "";
				foreach( $wgCreateQuizThresholds as $field => $threshold ){
					if ( $stats_data[ $field ] < $threshold ){
						$can_create = false;
						$threshold_reason .= (($threshold_reason)?", ":"") . "$threshold $field";
					}
				}
					
				if( $can_create == false ){
					global $wgSupressPageTitle;
					$wgSupressPageTitle = false;
					$wgOut->setPageTitle( wfMsg('quiz_create_threshold_title') );
					$wgOut->addHTML( wfMsg("quiz_create_threshold_reason", $threshold_reason) );
					return "";
				}
			}
			
			$chain = time();
			$key = md5( $this->SALT . $chain );
			$max_answers = 8;

			
			$output .= "
			<script type=\"text/javascript\" language=\"javascript\">
			
			var __quiz_max_answers__ = {$max_answers};
			var __quiz_create_error_numanswers__ = \"" . wfMsgForContent( 'quiz_create_error_numanswers' ) . "\";
			var __quiz_create_error_noquestion__ = \"" . wfMsgForContent( 'quiz_create_error_noquestion' ) . "\";
			var __quiz_create_error_numcorrect__ = \"" . wfMsgForContent( 'quiz_create_error_numcorrect' ) . "\";
			
			</script>
			
			<script type=\"text/javascript\" src=\"{$this->INCLUDEPATH}renderwelcomepage.js?{$wgStyleVersion}\"></script>";
			
			$wgOut->setHTMLTitle( wfMsg( 'pagetitle', wfMsgForContent( 'quiz_create_title' ) ) );
			$wgOut->setPageTitle( wfMsg( 'pagetitle', wfMsgForContent( 'quiz_create_title' ) ) );
			$output .= "<div id=\"quiz-container\" class=\"quiz-container\">
				
				<div class=\"create-message\">
					<h1>" . wfMsgForContent( 'quiz_create_title' ) . "</h1>
					<p>" . wfMsgExt( 'quiz_create_message', "parse" ) . "</p>
					<p><input class=\"site-button\" type=\"button\" onclick=\"document.location='" . Title::makeTitle(NS_SPECIAL, "QuizGameHome")->escapeFullURL("questionGameAction=launchGame") . "'\" value=\"" . wfMsgForContent( 'quiz_play_quiz' ) . "\"/></p>
				</div>
				
				<div class=\"quizgame-create-form\" id=\"quizgame-create-form\">		
					<form id=\"quizGameCreate\" name=\"quizGameCreate\" method=\"post\" action=\"" . Title::makeTitle(NS_SPECIAL, "QuizGameHome")->escapeFullURL("questionGameAction=createGame") . "\">
					<div id=\"quiz-game-errors\" style=\"color:red\"></div>
					
					<h1>" . wfMsgForContent( 'quiz_create_write_question' ) . "</h1> 
					<input name=\"quizgame-question\" id=\"quizgame-question\" type=\"text\" value=\"\" size=\"64\" />
					<h1 class=\"write-answer\">" . wfMsgForContent( 'quiz_create_write_answers' ) . "</h1>
					<span style=\"margin-top:10px;\">" . wfMsgForContent( 'quiz_create_check_correct' ) . "</span>";
					
					for($x=1;$x<=$max_answers;$x++){
						$output .= "<div id=\"quizgame-answer-container-{$x}\" class=\"quizgame-answer\" " . (($x>2)?"style=\"display:none;\"":"") . ">
								<span class=\"quizgame-answer-number\">{$x}.</span>
								<input name=\"quizgame-answer-{$x}\" id=\"quizgame-answer-{$x}\" type=\"text\" value=\"\" size=\"32\" onKeyUp=\"update_answer_boxes();\" />
								<input type=\"checkbox\" onclick=\"javascript:toggleCheck(this)\" id=\"quizgame-isright-{$x}\" name=\"quizgame-isright-{$x}\">
								</div>";
						
						
					}
	
					
					
					$output .= "<input id=\"quizGamePictureName\" name=\"quizGamePictureName\" type=\"hidden\" value=\"\" />
					<input id=\"key\" name=\"key\" type=\"hidden\" value=\"{$key}\" />
					<input id=\"chain\" name=\"chain\" type=\"hidden\" value=\"{$chain}\" />
					
				</form>
				
				<h1 style=\"margin-top:20px\">" . wfMsgForContent( 'quiz_create_add_picture' ) . "</h1>
				<div id=\"quizgame-picture-upload\" style=\"display:block;\">
					
					<div id=\"real-form\" style=\"display:block;height:70px;\">
						<iframe id=\"imageUpload-frame\" class=\"imageUpload-frame\" width=\"420\" 
							scrolling=\"no\" border=\"0\" frameborder=\"0\" src=\"" . Title::makeTitle(NS_SPECIAL,"QuestionGameUpload")->escapeFullURL("wpThumbWidth=75&wpCategory=Quizgames") . "\">
						</iframe>
					</div>
				</div>
				<div id=\"quizgame-picture-preview\" class=\"quizgame-picture-preview\"></div>
				<p id=\"quizgame-picture-reupload\" style=\"display:none\"><a href=\"javascript:showAttachPicture()\">" . wfMsgForContent( 'quiz_create_edit_picture' ) . "</a></p>
				</div>
				
					<div id=\"startButton\" class=\"startButton\" sstyle=\"display:none\">
						<input type=\"button\" class=\"site-button\" onclick=\"startGame()\" value=\"" . wfMsgForContent( 'quiz_create_play' ) . "\"/>
					</div>
				  
				</div>";
			
			$wgOut->addHTML($output);
		}
	}
	
	SpecialPage::addPage( new QuizGameHome );
}

$wgHooks['UserRename::Local'][] = "QuizGameUserRenameLocal";

function QuizGameUserRenameLocal( $dbw, $uid, $oldusername, $newusername, $process, $cityId, &$tasks ) {
	$tasks[] = array(
		'table' => 'quizgame_questions',
		'userid_column' => 'q_user_id',
		'username_column' => 'q_user_name',
	);
	$tasks[] = array(
		'table' => 'quizgame_answers',
		'userid_column' => 'a_user_id',
		'username_column' => 'a_user_name',
	);
	return true;
}

?>
