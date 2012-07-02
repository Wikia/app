<?php

/**
 * API module to get a list of survey submissions.
 *
 * @since 0.1
 *
 * @file ApiQuerySurveySubmissions.php
 * @ingroup Surveys
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiQuerySurveySubmissions extends ApiQueryBase {
	
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action, 'qs' );
	}

	/**
	 * Retrieve the special words from the database.
	 */
	public function execute() {
		global $wgUser;
		
		if ( !$wgUser->isAllowed( 'surveyadmin' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}
		
		// Get the requests parameters.
		$params = $this->extractRequestParams();
		
		$starPropPosition = array_search( '*', $params['props'] );
		
		if ( $starPropPosition !== false ) {
			unset( $params['props'][$starPropPosition] );
			$params['props'] = array_merge( $params['props'], SurveySubmission::getFieldNames() );
		}
		
		$params = array_filter( $params, function( $param ) { return !is_null( $param ); } );
		
		$results = SurveySubmission::select(
			$params['props'],
			SurveySubmission::getValidFields( $params ),
			array(
				'LIMIT' => $params['limit'] + 1,
				'ORDER BY' => SurveySubmission::getPrefixedField( 'id' ) . ' ASC'
			)
		);
		
		$serializedResults = array();
		$count = 0;
		
		foreach ( $results as $result ) {
			if ( ++$count > $params['limit'] ) {
				// We've reached the one extra which shows that
				// there are additional pages to be had. Stop here...
				$this->setContinueEnumParameter( 'continue', $result->getId() );
				break;
			}
			
			$serializedResults[] = $result->toArray();
		}

		$this->getResult()->setIndexedTagName( $serializedResults, 'submission' );
		
		$this->getResult()->addValue(
			null,
			'submissions',
			$serializedResults
		);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getAllowedParams()
	 */
	public function getAllowedParams() {
		$params = array (
			'props' => array(
				ApiBase::PARAM_TYPE => array_merge( SurveySubmission::getFieldNames(), array( '*' ) ),
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_DFLT => '*'
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
		
		return array_merge( SurveySubmission::getAPIParams( false ), $params );
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getParamDescription()
	 */
	public function getParamDescription() {
		$descs = array (
			'props' => 'Survey data to query',
			'continue' => 'Offset number from where to continue the query',
			'limit' => 'Max amount of words to return',
		);
		
		return array_merge( SurveySubmission::getFieldDescriptions(), $descs );
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getDescription()
	 */
	public function getDescription() {
		return 'API module for obatining survey submissions';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getPossibleErrors()
	 */
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
		) );
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getExamples()
	 */
	public function getExamples() {
		return array (
			'api.php?action=query&list=surveysubmissions&qsid=42',
			'api.php?action=query&list=surveysubmissions&qssurvey_id=9001',
			'api.php?action=query&list=surveysubmissions&qsuser_name=Jeroen%20De%20Dauw&qsprops=survey_id|page_id|time',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQuerySurveySubmissions.php 101805 2011-11-03 13:57:49Z jeroendedauw $';
	}
	
}
