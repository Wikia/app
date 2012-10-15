<?php
class ApiQueryResearchToolsSurveys extends ApiQueryBase {

	/* Methods */

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'rt' );
	}

	public function execute() {
		$result = $this->getResult();
		$params = $this->extractRequestParams();

		$this->addTables( array( 'research_tools_surveys' ) );
		$this->addFields( array(
			'rts_id as id',
			'rts_title as title',
			'rts_description as description',
		) );
		if ( $params['survey'] ) {
			$this->addWhereFld( 'rts_id', $params['survey'] );
		} else {
			$this->addOption( 'OFFSET', $params['offset'] );
			$this->addOption( 'LIMIT', $params['limit'] );
		}

		$dbr = wfGetDb( DB_SLAVE );
		foreach ( $this->select( __METHOD__ ) as $surveyRow ) {
			$survey = (array)$surveyRow;
			$questionRows = $dbr->select(
				'research_tools_survey_questions',
				array(
					'rtsq_id as id',
					'rtsq_type as type',
					'rtsq_text as text',
					'rtsq_example as example',
					'rtsq_help as help'
				),
				array( 'rtsq_survey' => $params['survey'] ),
				__METHOD__
			);
			$survey['questions'] = array();
			foreach ( $questionRows as $row ) {
				$survey['questions'][] = $row;
			}
			$result->addValue( array( 'query', $this->getModuleName() ), null, $survey );
		}
	}

	public function getAllowedParams() {
		return array(
			'survey' => array(
				ApiBase::PARAM_REQUIRED => false,
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
			'survey' => 'Survey to get information for',
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
			'api.php?action=query&list=researchtools_surveys',
			'api.php?action=query&list=researchtools_surveys&rtsurvey=1',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryResearchToolsSurveys.php 81870 2011-02-10 02:42:02Z reedy $';
	}
}
