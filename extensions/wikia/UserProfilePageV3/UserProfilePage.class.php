<?php

class UserProfilePage {

	const INTERVIEW_PAGE_TITLE = 'Interview';

	/**
	 * @var WikiaApp
	 */
	private $app = null;
	/**
	 * user object
	 * @var User
	 */
	private $user = null;

	public function __construct( User $user, WikiaApp $app = null ) {
		if( is_null( $app ) ) {
			$app = F::app();
		}
		$this->app = $app;
		$this->user = $user;
	}

	/**
	 * get interview questions and answers when possible
	 * @param int $wikiId wiki id
	 * @param bool $answeredOnly get only answered questions
	 * @param bool $asArray return array of arrays instead of objects
	 */
	public function getInterviewQuestions( $wikiId, $answeredOnly = false, $asArray = false ) {
		$interview = new Interview( $wikiId );

		$questions = array();
		$answers = $this->parseInterviewAnswers();

		$index = 0;
		$interviewQuestions = $interview->getQuestions();
		$questionsNum = count( $interviewQuestions );

		foreach( $interviewQuestions as $question ) {
			$index++;
			$question->setCaption( wfMsg( 'userprofilepage-question-caption', $index, $questionsNum ) );
			if( isset( $answers[ $question->getId() ] ) ) {
				$question->setAnswerBody( $answers[ $question->getId() ] );
			}
			if( $answeredOnly && $question->hasAnswer() ) {
				$questions[] = $asArray ? $question->toArray() : $question;
			}
			else if( !$answeredOnly ) {
				$questions[] = $asArray ? $question->toArray() : $question;
			}
		}
		return $questions;
	}

	/**
	 * store user interview answers on User:Name/Interview subpagepage as XML
	 * @param int $wikiId
	 * @param array $answers
	 * @return bool true if success
	 */
	public function saveInterviewAnswers( $wikiId, Array $answers ) {
		$currentAnswers = $this->parseInterviewAnswers();
		$incrCounters = array();
		$decrCounters = array();

		$answersXML = '';
		foreach( $answers as $answer ) {
			if( isset( $currentAnswers[ $answer->id ] ) ) {
				if( empty( $answer->answerBody ) ) {
					$decrCounters[] = $answer->id;
				}
			}
			else {
				if( !empty( $answer->answerBody ) ) {
					$incrCounters[] = $answer->id;
				}
			}
			$answersXML .= "<interviewAnswer><questionId>{$answer->id}</questionId><body>{$answer->answerBody}</body></interviewAnswer>\n";
		}
		$articleContent =  "<userInterview>{$answersXML}</userInterview>";

		$interviewArticle = $this->getInterviewArticle();

		if( $interviewArticle->exists() ) {
			$editMode = EDIT_UPDATE;
			$summaryMsg = 'userprofilepage-interview-edit-update-summary';
		}
		else {
			$editMode = EDIT_NEW;
			$summaryMsg = 'userprofilepage-interview-edit-new-summary';
		}

		$status = $interviewArticle->doEdit( $articleContent , wfMsgForContent( $summaryMsg ), $editMode );

		if( $status->isOK() ) {
			// purge userpage content
			$this->invalidateCache();

			// update counters
			foreach($incrCounters as $questionId) {
				$question = new InterviewQuestion( $questionId );
				$question->incrAnswersCount();
			}

			foreach($decrCounters as $questionId) {
				$question = new InterviewQuestion( $questionId );
				$question->decrAnswersCount();
			}

			return true;
		}
		else {
			return false;
		}
	}

	protected function parseInterviewAnswers() {
		$interviewArticle = $this->getInterviewArticle();

		$answers = array();

		if( $interviewArticle->exists() ) {
			$dom = new DOMDocument;
			$dom->loadXML( $interviewArticle->getContent() );

			$answerNodes = $dom->getElementsByTagName( 'interviewAnswer' );
			foreach( $answerNodes as $answerNode ) {
				$questionId = $answerNode->getElementsByTagName( 'questionId' )->item(0)->nodeValue;
				$answerBody = $answerNode->getElementsByTagName( 'body' )->item(0)->nodeValue;
				if( !empty( $questionId ) && !empty( $answerBody ) ) {
					$answers[ $questionId ] = $answerBody;
				}
			}
		}

		return $answers;
	}

	protected function getInterviewArticle() {
		$title = Title::makeTitle( NS_USER, $this->user->getName() . '/' . self::INTERVIEW_PAGE_TITLE );
		return new Article( $title );
	}

	protected function invalidateCache() {
		$title = $this->user->getUserPage();
		$title->invalidateCache();
		$title->purgeSquid();

		$article = new Article( $title );
		$article->doPurge();
	}

}