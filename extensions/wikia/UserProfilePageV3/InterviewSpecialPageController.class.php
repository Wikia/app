<?php

class InterviewSpecialPageController extends WikiaSpecialPageController {

	/**
	 * Interview object
	 * @var Interview
	 */
	private $interview = null;

	public function __construct() {
		// standard SpecialPage constructor call
		parent::__construct( 'Interview', '', false );
	}

	public function init() {
		$this->interview = F::build( 'Interview', array( 'wikiId' => $this->app->wg->CityId ) );
	}


	/**
	 * @brief rendering special page
	 *
	 * @responseParam WikiaResponse $questionList questionList method response
	 * @responseParam bool $isAddingAllowed allow more question flag
	 * @responseParam int $maxQuestionsNum questions limit
	 * @responseParam int $questionsNum numer of questions
	 */
	public function index() {
		$this->setHeaders();
		$this->wg->Out->addScriptFile( $this->wg->ExtensionsPath . '/wikia/UserProfilePageV3/js/InterviewSpecialPage.js' );

		$questionList = $this->sendSelfRequest( 'questionList' );

		$this->setVal( 'questionList', $questionList );
		$this->setVal( 'isAddingAllowed', $questionList->getVal( 'isAddingAllowed' ) );
		$this->setVal( 'questionsNum', $questionList->getVal( 'questionsNum' ) );
		$this->setVal( 'maxQuestionsNum', $questionList->getVal( 'maxQuestionsNum' ) );
	}


	/**
	 * @brief rendering list of questions
	 *
	 * @responseParam array $questions array of question objects
	 * @responseParam bool $isAddingAllowed allow more question flag
	 * @responseParam int $maxQuestionsNum questions limit
	 * @responseParam int $questionsNum numer of questions
	 */
	public function questionList() {
		//we'll implement interviews later
		//$this->setVal( 'questions', $this->interview->getQuestions() );
		$this->setVal( 'questions', array() );

		$this->setVal( 'isAddingAllowed', $this->interview->isAddingAllowed() );
		$this->setVal( 'maxQuestionsNum', Interview::MAX_QUESTIONS );
		
		//we'll implement interviews later
		//$this->setVal( 'questionsNum', $this->interview->getQuestionsNum() );
		$this->setVal( 'questionsNum', 0);
	}


	/**
	 * @brief add/modify question
	 *
	 * @requestParam int $questionId question id (empty for new)
	 * @requestParam string $questionBody question body
	 *
	 * @responseParam string $questionList rendered html of question list
	 * @responseParam bool $isAddingAllowed allow more question flag
	 * @responseParam string $noMoreQuestionMsg "userprofilepage-no-more-questions-allowed" message
	 */
	public function addOrModifyQuestion() {
		$questionId = $this->getVal( 'questionId' );
		$questionBody = $this->getVal( 'questionBody' );

		if( !empty( $questionBody ) ) {
			$question = $this->interview->addOrModifyQuestion( strip_tags( $questionBody ), $questionId );

			$this->populateQuestionListData();
		}
		else {
			throw new WikiaException( 'Question body is empty' );
		}
	}


	/**
	 * @brief remove question
	 *
	 * @requestParam int $questionId question id
	 */
	public function removeQuestion() {
		$questionId = $this->getVal( 'questionId' );
		if( !empty( $questionId ) ) {
			$this->interview->removeQuestion($questionId);

			$this->populateQuestionListData();
		}
		else {
			throw new WikiaException( 'Question ID is empty' );
		}
	}


	public function answersStats() {
		//we'll implement interviews later
		//$this->setVal( 'questions', $this->interview->getQuestions() );
		$this->setVal( 'questions', array() );
	}

	private function populateQuestionListData() {
			$questionList = $this->sendSelfRequest( 'questionList' );

			$this->setVal( 'questionList', $questionList->toString() );
			$this->setVal( 'isAddingAllowed', $questionList->getVal( 'isAddingAllowed' ) );
			$this->setVal( 'noMoreQuestionsAllowedMsg', $this->wf->msg( 'userprofilepage-no-more-questions-allowed') );
	}

	public function onGetRailModuleSpecialPageList( &$railModuleList ) {
		if( F::app()->wg->Title->isSpecial( 'Interview' ) ) {
			$railModuleList['1500'] = array( 'InterviewSpecialPage', 'answersStats', null );
		}

		return true;
	}
}