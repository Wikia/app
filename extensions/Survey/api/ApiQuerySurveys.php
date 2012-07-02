<?php

/**
 * API module to get a list of surveys.
 *
 * @since 0.1
 *
 * @file ApiQuerySurveys.php
 * @ingroup Surveys
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiQuerySurveys extends ApiQueryBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action, 'su' );
	}

	/**
	 * Retrieve the special words from the database.
	 */
	public function execute() {
		global $wgUser;

		if ( !$wgUser->isAllowed( 'surveysubmit' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}

		// Get the requests parameters.
		$params = $this->extractRequestParams();

		if ( !( ( isset( $params['ids'] ) && count( $params['ids'] ) > 0 )
			 XOR ( isset( $params['names'] ) && count( $params['names'] ) > 0 )
			 ) ) {
			$this->dieUsage( wfMsg( 'survey-err-ids-xor-names' ), 'ids-xor-names' );
		}

		$this->addTables( 'surveys' );

		$starPropPosition = array_search( '*', $params['props'] );

		if ( $starPropPosition !== false ) {
			unset( $params['props'][$starPropPosition] );
			$params['props'] = array_merge( $params['props'], Survey::getFieldNames() );
		}

		$fields = array_merge( array( 'id' ), $params['props'] );

		$this->addFields( Survey::getPrefixedFields( $fields ) );

		if ( isset( $params['ids'] ) ) {
			$this->addWhere( array( 'survey_id' => $params['ids'] ) );
		} else {
			$this->addWhere( array( 'survey_name' => $params['names'] ) );
		}

		if ( !$GLOBALS['wgUser']->isAllowed( 'surveyadmin' ) ) {
			$this->addWhere( array( 'survey_enabled' => 1 ) );
		}
		elseif ( isset( $params['enabled'] ) ) {
			$this->addWhere( array( 'survey_enabled' => $params['enabled'] ) );
		}

		if ( isset( $params['continue'] ) ) {
			$this->addWhere( 'survey_id >= ' . wfGetDB( DB_SLAVE )->addQuotes( $params['continue'] ) );
		}

		$this->addOption( 'LIMIT', $params['limit'] + 1 );
		$this->addOption( 'ORDER BY', 'survey_id ASC' );

		$surveys = $this->select( __METHOD__ );
		$count = 0;
		$resultSurveys = array();

		foreach ( $surveys as $survey ) {
			if ( ++$count > $params['limit'] ) {
				// We've reached the one extra which shows that
				// there are additional pages to be had. Stop here...
				$this->setContinueEnumParameter( 'continue', $survey->survey_id );
				break;
			}

			$surveyObject = Survey::newFromDBResult( $survey );

			if ( $params['incquestions'] ) {
				$surveyObject->loadQuestionsFromDB();
			}

			$resultSurveys[] = $this->getSurveyData( $surveyObject->toArray( $fields ) );
		}

		$this->getResult()->setIndexedTagName( $resultSurveys, 'survey' );

		$this->getResult()->addValue(
			null,
			'surveys',
			$resultSurveys
		);
	}

	/**
	 *
	 *
	 * @since 0.1
	 *
	 * @param array $survey
	 *
	 * @return $survey
	 */
	protected function getSurveyData( array $survey ) {
		foreach ( $survey['questions'] as $nr => $question ) {
			$this->getResult()->setIndexedTagName( $survey['questions'][$nr], 'answer' );
		}

		$this->getResult()->setIndexedTagName( $survey['questions'], 'question' );

		return $survey;
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getAllowedParams()
	 */
	public function getAllowedParams() {
		return array (
			'ids' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_ISMULTI => true,
			),
			'names' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
			),
			'props' => array(
				ApiBase::PARAM_TYPE => array_merge( Survey::getFieldNames(), array( '*' ) ),
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_DFLT => 'id|name|enabled'
			),
			'incquestions' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_DFLT => '0',
			),
			'enabled' => array(
				ApiBase::PARAM_TYPE => 'integer',
			),
			'limit' => array(
				ApiBase::PARAM_DFLT => 20,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
			'continue' => null,
		);

	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getParamDescription()
	 */
	public function getParamDescription() {
		return array (
			'ids' => 'The IDs of the surveys to return',
			'names' => 'The names of the surveys to return',
			'incquestions' => 'Include the questions of the surveys or not',
			'enabled' => 'Enabled state to filter on',
			'props' => 'Survey data to query',
			'continue' => 'Offset number from where to continue the query',
			'limit' => 'Max amount of words to return',
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getDescription()
	 */
	public function getDescription() {
		return 'API module for obatining surveys and optionaly their questions';
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getPossibleErrors()
	 */
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'surveyids', 'name' ),
		) );
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getExamples()
	 */
	public function getExamples() {
		return array (
			'api.php?action=query&list=surveys&suids=4|2',
			'api.php?action=query&list=surveys&suenabled=1&suprops=id|name',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQuerySurveys.php 104210 2011-11-25 00:20:54Z reedy $';
	}

}
