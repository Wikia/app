<?php
class ApiResearchToolsSurveyResponse extends ApiBase {

	/* Methods */

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName );
	}

	public function execute() {
		global $wgUser;

		$result = $this->getResult();
		$params = $this->extractRequestParams();

		$token = array();
		if ( $wgUser->isAnon() ) {
			if ( !isset( $params['anontoken'] ) ) {
				$this->dieUsageMsg( array( 'missingparam', 'anontoken' ) );
			} elseif ( strlen( $params['anontoken'] ) != 32 ) {
				$this->dieUsage( 'The anontoken is not 32 characters', 'invalidtoken' );
			}
			$token = $params['anontoken'];
		} else {
			$token = '';
		}

		$dbr = wfGetDB( DB_SLAVE );
		$dbw = wfGetDB( DB_MASTER );

		// Check if the incoming survey is valid
		$surveyCount = $dbr->selectRow(
			'research_tools_surveys',
			'rts_id',
			array( 'rts_id' => $params['survey'] ),
			__METHOD__
		);
		if ( $surveyCount === false ) {
			$this->dieUsage( 'The survey is unknown', 'invalidsurvey' );
		}

		// Find an existing response from this user for this survey
		$response = $dbr->selectRow(
			'research_tools_survey_responses',
			'rtsr_id',
			array(
				'rtsr_user_text' => $wgUser->getName(),
				'rtsr_user_anon_token' => $token,
				'rtsr_survey' => $params['survey'],
			),
			__METHOD__
		);
		if ( $response !== false ) {
			// Delete any of the previous answers (they questions may have changed)
			$dbw->delete(
				'research_tools_survey_answers',
				array( 'rtsa_response' => $response->rtsr_id ),
				__METHOD__
			);
		}

		// Decode JSON answer data
		$answers = FormatJson::decode( $params['answers'], true );
		if ( !is_array( $answers ) ) {
			$this->dieUsage( 'Invalid answer data', 'invalidanswers' );
		}

		// Verify questions exist
		foreach ( $answers as $question => $answer ) {
			$question = $dbr->selectRow(
				'research_tools_survey_questions',
				'rtsq_id',
				array( 'rtsq_survey' => $params['survey'], 'rtsq_id' => $question ),
				__METHOD__
			);
			if ( $question === false ) {
				$this->dieUsage( 'A question is unknown', 'invalidquestion' );
			}
		}

		if ( $response === false ) {
			// Insert a new response row
			$dbw->insert(
				'research_tools_survey_responses', 
				array(
					'rtsr_time' => wfTimestamp( TS_MW ),
					'rtsr_user_text' => $wgUser->getName(),
					'rtsr_user_anon_token' => $token,
					'rtsr_survey' => $params['survey'],
				),
				__METHOD__
			);
			$response = $dbw->insertId();
		} else {
			$response = $response->rtsr_id;
			// Update the timestamp of the existing response row
			$dbw->update(
				'research_tools_survey_responses', 
				array( 'rtsr_time' => wfTimestamp( TS_MW ) ),
				array( 'rtsr_id' => $response ),
				__METHOD__
			);
		}

		// Insert answers for the response
		$answerRows = array();
		foreach ( $answers as $question => $answer ) {
			// Build row data
			$answerRows[] = array(
				'rtsa_response' => $response,
				'rtsa_question' => $question,
				'rtsa_value_integer' => is_numeric( $answer ) ? intval( $answer ) : null,
				'rtsa_value_text' => is_numeric( $answer ) ? '' : $answer,
			);
		}
		$dbw->insert( 'research_tools_survey_answers', $answerRows, __METHOD__ );

		// Add success to result
		$result->addValue( null, $this->getModuleName(), array( 'result' => 'Success' ) );
	}

	public function getAllowedParams() {
		return array(
			'anontoken' => null,
			'survey' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI => false,
				ApiBase::PARAM_TYPE => 'integer',
			),
			'answers' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI => false,
				ApiBase::PARAM_TYPE => 'string',
			),
		);
	}

	public function getParamDescription() {
		return array(
			'anontoken' => 'Token for anonymous users',
			'survey' => 'Survey ID to submit response for',
			'answers' => 'Answer data in question ID/answer value pairs encoded as JSON',
		);
	}

	public function getDescription() {
		return array(
			'Submit ResearchTools survey response'
		);
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'anontoken' ),
			array( 'code' => 'invalidtoken', 'info' => 'The anontoken is not 32 characters' ),
			array( 'code' => 'invalidsurvey', 'info' => 'The survey is unknown' ),
			array( 'code' => 'invalidquestion', 'info' => 'A question is unknown' ),
			array( 'code' => 'invalidanswers', 'info' => 'Invalid answer data' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=researchtools_surveyrespose'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiResearchToolsSurveyResponse.php 81869 2011-02-10 02:39:42Z reedy $';
	}
}