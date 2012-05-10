<?php

class SpecialUserInterview extends SpecialPage {

	function __construct() {
		parent::__construct('UserInterview', 'userinterview');
	}

	function execute() {
		wfProfileIn(__METHOD__);

		global $wgOut;
		$wgOut->setPageTitle('User Interview');
		
		SpecialUserInterview::userInterviewForm();
	}
	
	
	static function userInterviewForm() {
		global $wgOut, $wgTitle, $wgRequest, $wgExtensionsPath, $wgStylePath, $wgStyleVersion, $wgUser;
		
		$isAdmin = $wgUser->isAllowed('editinterface');
		
		if ($isAdmin) {
			$formURL = $wgTitle->getFullURL() .'?formaction=sent&action=purge';

			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/UserInterview/css/UserInterview.scss'));
			$wgOut->addScript("<script src=\"{$wgExtensionsPath}/wikia/UserInterview/js/UserInterview.js?{$wgStyleVersion}\"></script>\n");
			
			$template = new EasyTemplate(dirname(__FILE__).'/templates');
			$adminQuestions = SpecialUserInterview::getUserQuestions();

			if (count($adminQuestions) > 0) {
				$template->set_vars(array('adminQuestions' => $adminQuestions));
			}
			
			$template->set_vars(array(
						'formURL' => $formURL,
						'wgStylePath' => $wgStylePath
						));
			
			$wgOut->addHTML($template->render('SpecialUserInterview'));
		}
		else { // no admin
			$wgOut->addHTML('You have to be an admin of this wiki in order to create a user interview');
		}		
		
	}
	
	
	static function saveAdminQuestionsAjax() {
		global $wgRequest;
		
		parse_str($wgRequest->getVal('data'), $ajaxData);
		$questions = explode(',', $ajaxData['questions']);
		
		$data = array();
		foreach ($questions as $question) {
			if (isset( $ajaxData[$question] )) {
				$value = $ajaxData[$question];
				if ($value != '') {
					$data[$question] = $value;
				}
			}
		}
		
		SpecialUserInterview::saveAdminQuestion($data);
		NotificationsController::addConfirmation('Your user interview has been saved!');
	}
	
	
	static function getUserQuestionsHTML() {
		// user: get the questions
		global $wgUser, $wgTitle, $wgOut, $wgStylePath, $wgStyleVersion, $wgExtensionsPath;
		
		$wgOut->addScript("<script src=\"{$wgExtensionsPath}/wikia/UserInterview/js/UserInterviewAjax.js?{$wgStyleVersion}\"></script>\n");

		$avatarImg = strip_tags(SpecialUserInterview::getAvatarImg($wgUser->getId()), '<img>');
		$adminQuestion = SpecialUserInterview::getUserQuestions();
		$userAnswers = SpecialUserInterview::getUserAnswers();
		
		if ($adminQuestion) {
			foreach($adminQuestion as $question) {
				if (isset( $userAnswers[$question['id']]['answer'] )) {
					$answered = $userAnswers[$question['id']]['answer'];
					$adminQuestion[$question['id']]['answer'] = $answered;
				}
			}

			$questionIDs = array();
			foreach ($adminQuestion as $question) {
				array_push($questionIDs, $question['id']);	
			}	
			
			$userFormURL = $wgTitle->getFullURL() .'?userinterviewaction=sent&action=purge';
			
			$template = new EasyTemplate(dirname(__FILE__).'/templates');
			$template->set_vars(array(
						'userFormURL' => $userFormURL,
						'adminQuestion' => $adminQuestion,
						'avatarImg' => $avatarImg,
						'wgStylePath' => $wgStylePath,
						'questionIDs' => implode(',', $questionIDs)
						));
			
			$html = $template->render('SpecialUserInterviewUserQuestions');
			return $html;
		}
	}
	
	
	static function saveUserAnswersAJAX() {
		global $wgUser, $wgRequest;
		$adminQuestions = SpecialUserInterview::getUserQuestions();	
		
		parse_str($wgRequest->getVal('data'), $ajaxData);
		
		$answeredQuestions = array();
		$counter = 0;
		
		foreach ($adminQuestions as $adminQuestion) {
			if (isset( $ajaxData[$adminQuestion['id']] )) {
				$setQuestion = $ajaxData[$adminQuestion['id']];			
				if (isset($setQuestion) && $setQuestion != '') {
					$answeredQuestions[$counter] = array('question_id' => $adminQuestion['id'], 'question' => $adminQuestion['question'], 'answer' => $setQuestion);
					$counter ++;
				}
			}
		}
	
		SpecialUserInterview::saveUserAnswers($answeredQuestions); // save in dbase
		SpecialUserInterview::saveInUserProfile('<userinterview/>'); // ad into profile
	}
		
	
	static function getUserAnswersHTML() {
		global $wgOut, $wgUser;
		$userAnswers = SpecialUserInterview::getUserAnswers();
		
		$avatarImg = strip_tags(SpecialUserInterview::getAvatarImg($wgUser->getId()), '<img>');	
		$template = new EasyTemplate(dirname(__FILE__).'/templates');
			
		$template->set_vars(array(
					'userAnswers' => $userAnswers,
					'avatarImg' => $avatarImg
					));
		
		$userAnswersHTML = $template->render('SpecialUserInterviewAnswered');
	
		return $userAnswersHTML;
	}
	
	
	
	static function getAvatarImg($user){
		if (class_exists('Masthead')) {
			global $wgUser, $wgTitle;
			
			$userName = UserPagesHeaderController::getUserName($wgTitle, BodyController::getUserPagesNamespaces());
			$userId = (User::isIP($userName)) ? 0 : User::newFromName($userName)->getID();

			$user = User::newFromId($userId);
			return Masthead::newFromUser( $user )->display( 50, 50 );
		}
		else {
			// Answers
			return AvatarService::getAvatarUrl($user->getName(), 50);
		}
	}
	
	
	static private function saveAdminQuestion($data) {
		global $wgCityId, $wgExternalSharedDB;
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		
		$answered_questions = SpecialUserInterview::getUserQuestions();

		$addedKeys = array();
		foreach (array_keys($data) as $single) {
			
			if (isset($answered_questions)) {
				if (array_key_exists($single, $answered_questions)) { // CHANGE TO $answered_questions
					$value = $data[$single];
					$sql = "UPDATE user_interview_questions SET question = '$value', wiki_id = $wgCityId WHERE id = $single;";
					$dbw->query($sql);
				}
				else {
					$question = $data[$single];
					$sql = "INSERT INTO user_interview_questions (wiki_id, question) VALUES ($wgCityId, '$question');";	
					$dbw->query($sql);
				}
			}
			else { // complete empty form
				$question = $data[$single];
				$sql = "INSERT INTO user_interview_questions (wiki_id, question) VALUES ($wgCityId, '$question');";	
				$dbw->query($sql);
			}
			array_push($addedKeys,$single);
			
		}
		
		$oldKeys = array();
		if (isset($answered_questions)) {
			foreach ($answered_questions as $question) {
				array_push($oldKeys, $question['id']);
			}
		}
		
		
		$deleteQuestions = array_diff($oldKeys, $addedKeys);
		if ($deleteQuestions) {
			foreach ($deleteQuestions as $deleteQuestion) {
				$sql = "DELETE FROM user_interview_questions WHERE id = $deleteQuestion;";
				$dbw->query($sql);
			}
		}
	}
	
	
	static function getUserQuestions() {
		global $wgCityId, $wgExternalSharedDB;
		
		$dbw = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$sql = "SELECT * FROM user_interview_questions WHERE wiki_id = {$wgCityId} ORDER BY id DESC;";
		$res = $dbw->query($sql);
		$data = array();
		
		$count = 0;
		while ($row = $dbw->fetchObject($res)) {
			$count ++;
			$data[$row->id] = array('id' => $row->id, 'question' => $row->question);
		}

		$dbw->freeResult($res);
		if (!empty($data)) {
			return $data;		
		}
	}
	
	
	static private function saveUserAnswers($data) {
		global $wgUser, $wgCityId;
		$userId = $wgUser->getId();
		
		if ($userId != 0) {
			
			global $wgExternalSharedDB;
			$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
			
			$query = "DELETE FROM user_interview_answers WHERE user_id = '{$userId}' AND wiki_id = {$wgCityId};";
			$dbw->query($query);
			
			foreach ($data as $insertRow) {
				$query = sprintf("INSERT INTO user_interview_answers (wiki_id, question_id, user_id, question, answer) VALUES(%s, %s, %s, '%s', '%s');",
				$wgCityId, $insertRow['question_id'], $userId, $insertRow['question'], $insertRow['answer'] );
				$dbw->query($query);
			}
			$dbw->commit();
		}		
	}
	
	
	static  private function getUserAnswers() {
		global $wgUser, $wgTitle, $wgCityId;
		
		$userName = UserPagesHeaderController::getUserName($wgTitle, BodyController::getUserPagesNamespaces());
		$userId = (User::isIP($userName)) ? 0 : User::newFromName($userName)->getID();
		
		if ($userId != 0) {
			
			global $wgExternalSharedDB;
			$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
			
			$query = "SELECT * FROM user_interview_answers WHERE user_id = {$userId} AND wiki_id = {$wgCityId};";
			
			$res = $dbw->query($query);
			$data = array();
			
			$count = 0;
			while ($row = $dbw->fetchObject($res)) {
				$count ++;
				$data[$row->question_id] = array('id' => $row->question_id, 'question' => $row->question, 'answer' => $row->answer);
			}
			
			$dbw->freeResult($res);
			if (!empty($data)) {
				return $data;		
			}
		}
	}
	
	
	static private function saveInUserProfile($html) {
		if ($html) {
			global $wgOut, $wgTitle, $wgUser;
			
			$userID = $wgUser->getID();
			$userURL  = User::newFromId($userID)->getUserPage()->getLocalURL();
			$userURL = str_replace('/wiki/', '', $userURL);
			$articleTitle = Title::newFromText($userURL);
			$wgArticle = new Article($articleTitle);
			$userProfileContent = $wgArticle->getContent(); // reading content
						
			// remove already existing interview tag
			$interviewTag = "<userinterview />\n";
						
			$regex = '#<userinterview />#i';
			$userProfileContent = preg_replace($regex, '', $userProfileContent);
			
			$newUserProfileContent = $interviewTag .$userProfileContent;
			
			// save updated profile
			$summary = "answered a user interview";
			
			$status = $wgArticle->doEdit($newUserProfileContent, $summary, 
					( 0 ) |
					( 0 ) | 
					( 0 ) |
					( 0 )
					 );
					
		}
	}
}
