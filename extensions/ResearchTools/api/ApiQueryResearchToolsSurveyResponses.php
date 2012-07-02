<?php
class ApiQueryResearchToolsSurveyResponses extends ApiQueryBase {

	/* Methods */

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'rt' );
	}

	public function execute() {
		$result = $this->getResult();
		$params = $this->extractRequestParams();

		$this->addTables( array(
			'research_tools_survey_answers',
			'research_tools_survey_responses',
		) );
		$this->addFields( array(
			'rtsr_id id',
			'rtsr_time time',
			'rtsr_user_text as user',
			'rtsr_user_anon_token anontoken',
			'rtsa_question as question',
			'rtsa_value_integer as value_integer',
			'rtsa_value_text as value_text',
		) );
		$this->addJoinConds( array(
			'research_tools_survey_responses' => array(
				'LEFT JOIN', array( 'rtsa_response=rtsr_id' )
			),
		) );
		$this->addWhereFld( 'rtsr_survey', $params['survey'] );
		$this->addOption( 'OFFSET', $params['offset'] );
		$this->addOption( 'LIMIT', $params['limit'] );
		$this->addOption( 'ORDER BY', 'id,question' );

		$responses = array();
		$responder = null;
		foreach ( $this->select( __METHOD__ ) as $row ) {
			if ( $responder !== $row->user . $row->anontoken ) {
				$responder = $row->user . $row->anontoken;
				$responses[$responder] = array(
					'id' => $row->id,
					'time' => $row->time,
					'user' => $row->user,
					'anontoken' => $row->anontoken,
					'answers' => array(),
				);
			}
			$responses[$responder]['answers'][$row->question] = is_null( $row->value_integer )
				? $row->value_text : intval( $row->value_integer );
		}
		foreach ( $responses as $response ) {
			$result->addValue( array( 'query', $this->getModuleName() ), null, $response );
		}
	}

	public function getAllowedParams() {
		return array(
			'survey' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI => false,
				ApiBase::PARAM_TYPE => 'integer',
			),
			'offset' => 0,
			'limit' => array(
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
		);
	}

	public function getParamDescription() {
		return array(
			'survey' => 'Survey to get feedbacks for',
			'offset' => 'When more results are available, use this to continue',
			'limit' => 'Number of results to return',
		);
	}

	public function getDescription() {
		return array(
			'List all responses to a survey'
		);
	}

	public function getExamples() {
		return array(
			'api.php?action=query&list=researchtools_surveyresponses&rtsurvey=1',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryResearchToolsSurveyResponses.php 81869 2011-02-10 02:39:42Z reedy $';
	}
}
