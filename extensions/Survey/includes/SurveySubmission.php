<?php

/**
 * Simple survey submission object class.
 * 
 * @since 0.1
 * 
 * @file SurveySubmission.php
 * @ingroup Survey
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SurveySubmission extends SurveyDBClass {
	
	/**
	 * @see SurveyDBClass::getDBTable()
	 */
	public static function getDBTable() {
		return 'survey_submissions';
	}
	
	/**
	 * Gets the db field prefix. 
	 * 
	 * @since 0.1
	 * 
	 * @return string
	 */
	protected static function getFieldPrefix() {
		return 'submission_';
	}
	
	/**
	 * Returns an array with the fields and their types this object contains.
	 * This corresponds directly to the fields in the database, without prefix.
	 * 
	 * survey_id:
	 * The ID of the survey this submission is for.
	 * 
	 * page_id:
	 * The ID of the page this submission was made on.
	 * 
	 * user_name:
	 * The name of the user that made the submission (username or ip).
	 * 
	 * time:
	 * Timestamp idnicating when the submission was made.
	 * 
	 * @since 0.1
	 * 
	 * @return array
	 */
	protected static function getFieldTypes() {
		return array(
			'id' => 'id',
			'survey_id' => 'id',
			'page_id' => 'id',
			'user_name' => 'str',
			'time' => 'str',
		);
	}
	
	/**
	 * List of answers.
	 * 
	 * @since 0.1
	 * @var array of SurveyAnswer
	 */
	protected $answers;
	
	
	public function addAnswer( SurveyAnswer $answer ) {
		$this->answers[] = $answer;
	}
	
	public function setAnswers( array $answers ) {
		$this->answers = $answers;
	}
	
	public function getAnswers() {
		return $this->answers;
	}
	
	/**
	 * Writes the answer to the database, either updating it
	 * when it already exists, or inserting it when it doesn't.
	 * 
	 * @since 0.1
	 * 
	 * @return boolean Success indicator
	 */
	public function writeToDB() {
		$success = parent::writeToDB();
		
		if ( $success ) {
			$this->writeAnswersToDB();
		}
		
		return $success;
	}
	
	public function writeAnswersToDB() {
		foreach ( $this->answers as /* SurveyAnswer */ $answer ) {
			$answer->setField( 'submission_id', $this->getId() );
			$answer->writeToDB();
		}
	}
	
}
