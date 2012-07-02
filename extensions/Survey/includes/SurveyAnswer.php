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
class SurveyAnswer extends SurveyDBClass {
	
	/**
	 * @see SurveyDBClass::getDBTable()
	 */
	public static function getDBTable() {
		return 'survey_answers';
	}
	
	/**
	 * Gets the db field prefix. 
	 * 
	 * @since 0.1
	 * 
	 * @return string
	 */
	protected static function getFieldPrefix() {
		return 'answer_';
	}
	
	/**
	 * Returns an array with the fields and their types this object contains.
	 * This corresponds directly to the fields in the database, without prefix.
	 * 
	 * text:
	 * The answer text.
	 * 
	 * submission_id:
	 * The ID of the submission this answer is part of.
	 * 
	 * question_id:
	 * The ID of the question this answer corresponds to.
	 * 
	 * @since 0.1
	 * 
	 * @return array
	 */
	protected static function getFieldTypes() {
		return array(
			'id' => 'id',
			'text' => 'str',
			'submission_id' => 'id',
			'question_id' => 'id',
		);
	}
	
}
