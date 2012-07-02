<?php

/**
 * Simple Survey object class.
 * 
 * @since 0.1
 * 
 * @file Survey.class.php
 * @ingroup Survey
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class Survey extends SurveyDBClass {
	
	public static $USER_ALL = 0;
	public static $USER_LOGGEDIN = 1;
	public static $USER_CONFIRMED = 2;
	public static $USER_EDITOR = 3;
	public static $USER_ANON = 4;
	
	/**
	 * @see SurveyDBClass::getDBTable()
	 */
	public static function getDBTable() {
		return 'surveys';
	}
	
	/**
	 * Returns an array with the fields and their types this object contains.
	 * This corresponds directly to the fields in the database, without prefix.
	 * 
	 * @since 0.1
	 * 
	 * @return array
	 */
	protected static function getFieldTypes() {
		return array(
			'id' => 'id',
			'name' => 'str',
			'title' => 'str',
			'enabled' => 'bool',
			'header' => 'str',
			'footer' => 'str',
			'thanks' => 'str',
			'user_type' => 'int',
			'namespaces' => 'array',
			'ratio' => 'int',
			'expiry' => 'int',
			'min_pages' => 'int'
		);
	}
	
	/**
	 * Returns a list of default field values.
	 * field name => field value
	 * 
	 * @since 0.1
	 * 
	 * @return array
	 */
	public static function getDefaults() {
		return array(
			'name' => '',
			'title' => '',
			'enabled' => SurveySettings::get( 'defaultEnabled' ) ? '1' : '0',
			'header' => 'Thank you for taking this short survey. Please fill out the following questions:',
			'footer' => '',
			'thanks' => 'Thank you for your responses.',
			'user_type' => SurveySettings::get( 'defaultUserType' ),
			'namespaces' => SurveySettings::get( 'defaultNamespaces' ),
			'ratio' => SurveySettings::get( 'defaultRatio' ),
			'expiry' => SurveySettings::get( 'defaultExpiry' ),
			'min_pages' => SurveySettings::get( 'defaultMinPages' ),
		);
	}
	
	/**
	 * Gets the db field prefix. 
	 * 
	 * @since 0.1
	 * 
	 * @return string
	 */
	protected static function getFieldPrefix() {
		return 'survey_';
	}
	
	/**
	 * Returns the Survey with specified name, or false if there is no such survey.
	 * 
	 * @since 0.1
	 * 
	 * @param string $surveyName
	 * @param array|null $fields
	 * @param boolean $loadQuestions
	 * 
	 * @return Survey or false
	 */
	public static function newFromName( $surveyName, $fields = null, $loadQuestions = true ) {
		return self::newFromDB( array( 'name' => $surveyName ), $fields, $loadQuestions );
	}
	
	/**
	 * Returns the Survey with specified ID, or false if there is no such survey.
	 * 
	 * @since 0.1
	 * 
	 * @param integer surveyId
	 * @param array|null $fields
	 * @param boolean $loadQuestions
	 * 
	 * @return Survey or false
	 */
	public static function newFromId( $surveyId, $fields = null, $loadQuestions = true ) {
		return self::newFromDB( array( 'id' => $surveyId ), $fields, $loadQuestions );
	}
	
	/**
	 * Returns a new instance of Survey build from a database result
	 * obtained by doing a select with the porvided conditions on the surveys table.
	 * If no survey matches the conditions, false will be returned.
	 * 
	 * @since 0.1
	 * 
	 * @param array $conditions
	 * @param array|null $fields
	 * @param boolean $loadQuestions
	 * 
	 * @return Survey or false
	 */
	public static function newFromDB( array $conditions, $fields = null, $loadQuestions = true ) {
		$survey = self::selectRow( $fields, $conditions );
		
		if ( $survey !== false && $loadQuestions ) {
			$survey->loadQuestionsFromDB();
		}
		
		return $survey;
	}
	
	/**
	 * The questions that go with this survey.
	 * 
	 * @since 0.1
	 * @var array of SurveyQuestion
	 */
	protected $questions;
	
	/**
	 * Constructor.
	 * 
	 * @since 0.1
	 * 
	 * @param array|null $fields
	 * @param boolean $loadDefaults
	 * @param array $questions
	 */
	public function __construct( $fields, $loadDefaults = false, array $questions = array() ) {
		parent::__construct( $fields, $loadDefaults );
		$this->setQuestions( $questions );
	}
	
	/**
	 * Load the surveys questions from the database.
	 * 
	 * @since 0.1
	 */
	public function loadQuestionsFromDB() {
		$this->questions = SurveyQuestion::getQuestionsForSurvey( $this->getId() );
	}
	
	/**
	 * Writes the surveyand it's questions to the database, either updating it
	 * when it already exists, or inserting it when it doesn't.
	 * 
	 * @since 0.1
	 * 
	 * @return boolean Success indicator
	 */
	public function writeToDB() {
		$success = parent::writeToDB();
		
		if ( $success ) {
			$success = $this->writeQuestionsToDB();
		}
		
		return $success;
	}
	
	/**
	 * Writes the surveys questions to the database.
	 * 
	 * @since 0.1
	 * 
	 * @return boolean Success indicator
	 */
	public function writeQuestionsToDB() {
		$success = true;
		
		$dbw = wfGetDB( DB_MASTER );
		
		$dbw->begin();

		SurveyQuestion::update(
			array( 'removed' => 1 ),
			array( 'survey_id' => $this->getId() )
		);
		
		foreach ( $this->questions as /* SurveyQuestion */ $question ) {
			$question->setField( 'survey_id', $this->getId() );
			$success = $question->writeToDB() && $success;
		}
		
		$dbw->commit();
		
		return $success;
	}
	
	/**
	 * Returns the surveys questions.
	 * 
	 * @since 0.1
	 * 
	 * @return array of SurveyQuestion
	 */
	public function getQuestions() {
		return $this->questions;
	}
	
	/**
	 * Sets the surveys questions.
	 * 
	 * @since 0.1
	 * 
	 * @param array $questions list of SurveyQuestion
	 */
	public function setQuestions( array /* of SurveyQuestion */ $questions ) {
		$this->questions = $questions;
	}
	
	/**
	 * Serializes the survey to an associative array which
	 * can then easily be converted into JSON or similar.
	 * 
	 * @since 0.1
	 * 
	 * @param null|array $fields
	 * 
	 * @return array
	 */
	public function toArray( $fields = null ) {
		$data = parent::toArray( $fields );
		
		$data['questions'] = array();
		
		foreach ( $this->questions as /* SurveyQuestion */ $question ) {
			$data['questions'][] = $question->toArray();
		}
		
		return $data;
	}
	
	/**
	 * Removes the object from the database.
	 * 
	 * @since 0.1
	 * 
	 * @return boolean Success indicator
	 */
	public function removeFromDB() {
		$dbr= wfgetDB( DB_SLAVE );
		
		$submissionsForSurvey = $dbr->select(
			'survey_submissions',
			array( 'submission_id' ),
			array( 'submission_survey_id' => $this->getId() )
		);
		
		$dbw = wfGetDB( DB_MASTER );
		
		$dbw->begin();
		
		$sucecss = parent::removeFromDB();
		
		$sucecss = $dbw->delete(
			'survey_questions',
			array( 'question_survey_id' => $this->getId() )
		) && $sucecss;
		
		$sucecss = $dbw->delete(
			'survey_submissions',
			array( 'submission_survey_id' => $this->getId() )
		) && $sucecss;
		
		foreach ( $submissionsForSurvey as $nr => $submission ) {
			$sucecss = $dbw->delete(
				'survey_answers',
				array( 'answer_submission_id' => $submission->id )
			) && $sucecss;
			
			if ( $nr % 500 == 0 ) {
				$dbw->commit();
				$dbw->begin();
			}
		}
		
		$dbw->commit();
		
		return $sucecss;
	}
	
	/**
	 * Returns the survey user types the provided user has.
	 * 
	 * @since 0.1
	 * 
	 * @param User $user
	 * 
	 * @return array of Survey::$USER_
	 */
	public static function getTypesForUser( User $user ) {
		$userTypes = array( Survey::$USER_ALL );
		
		$userTypes[] = $user->isLoggedIn() ? Survey::$USER_LOGGEDIN : Survey::$USER_ANON;
		
		if ( $user->isEmailConfirmed() ) {
			$userTypes[] = Survey::$USER_CONFIRMED;
		}
		
		if ( $user->getEditCount() > 0 ) {
			$userTypes[] = Survey::$USER_EDITOR;
		}
		
		return $userTypes;
	}
	
}
