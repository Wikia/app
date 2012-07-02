<?php

/**
 * API module to get a list of survey answers.
 *
 * @since 0.1
 *
 * @file ApiQuerySurveyAnswers.php
 * @ingroup Surveys
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiQuerySurveyAnswers extends ApiQueryBase {
	
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action, 'qa' );
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
			$params['props'] = array_merge( $params['props'], SurveyAnswer::getFieldNames() );
		}
		
		$params = array_filter( $params, function( $param ) { return !is_null( $param ); } );
		
		$answers = SurveyAnswer::select(
			$params['props'],
			SurveyAnswer::getValidFields( $params ),
			array(
				'LIMIT' => $params['limit'] + 1,
				'ORDER BY' => SurveyAnswer::getPrefixedField( 'id' ) . ' ASC'
			)
		);
		
		$serializedAnswers = array();
		$count = 0;
		
		foreach ( $answers as $answer ) {
			if ( ++$count > $params['limit'] ) {
				// We've reached the one extra which shows that
				// there are additional pages to be had. Stop here...
				$this->setContinueEnumParameter( 'continue', $answer->getId() );
				break;
			}
			
			$serializedAnswers[] = $answer->toArray();
		}

		$this->getResult()->setIndexedTagName( $serializedAnswers, 'answer' );
		
		$this->getResult()->addValue(
			null,
			'answers',
			$serializedAnswers
		);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getAllowedParams()
	 */
	public function getAllowedParams() {
		$params = array (
			'props' => array(
				ApiBase::PARAM_TYPE => array_merge( SurveyAnswer::getFieldNames(), array( '*' ) ),
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
		
		return array_merge( SurveyAnswer::getAPIParams( false ), $params );
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
		
		return array_merge( SurveyAnswer::getFieldDescriptions(), $descs );
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getDescription()
	 */
	public function getDescription() {
		return 'API module for obatining survey answers';
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
			'api.php?action=query&list=surveyanswers&qaid=42',
			'api.php?action=query&list=surveyanswers&qaid=42&qaprops=text|submission_id',
			'api.php?action=query&list=surveyanswers&qaquestion_id=9001&qaprops=text',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQuerySurveyAnswers.php 101805 2011-11-03 13:57:49Z jeroendedauw $';
	}
	
}
