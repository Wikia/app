<?php

/**
 * API module to add surveys.
 *
 * @since 0.1
 *
 * @file ApiAddSurvey.php
 * @ingroup Survey
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiAddSurvey extends ApiBase {
	
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}
	
	public function execute() {
		global $wgUser;
		
		if ( !$wgUser->isAllowed( 'surveyadmin' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}
		
		$params = $this->extractRequestParams();
		
		foreach ( $params['questions'] as &$question ) {
			$question = SurveyQuestion::newFromUrlData( $question );
		}
		
		try {
			$survey = new Survey( Survey::getValidFields( $params ) );
			$success = $survey->writeToDB();
		}
		catch ( DBQueryError $ex ) {
			if ( $ex->errno == 1062 ) {
				$this->dieUsage( wfMsgExt( 'survey-err-duplicate-name', 'parsemag', $params['name'] ), 'duplicate-survey-name' );
			} else {
				throw $ex;
			}
		}
		
		$this->getResult()->addValue(
			null,
			'success',
			$success
		);
		
		$this->getResult()->addValue(
			'survey',
			'id',
			$survey->getId()
		);
		
		$this->getResult()->addValue(
			'survey',
			'name',
			$survey->getField( 'name' )
		);
	}
	
	public function needsToken() {
		return true;
	}
	
	public function getTokenSalt() {
		return 'addsurvey';
	}
	
	public function mustBePosted() {
		return true;
	}

	public function getAllowedParams() {
		$params = array(
			'questions' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_DFLT => '',
			),
			'token' => null,
		);
		
		return array_merge( Survey::getAPIParams(), $params );
	}
	
	public function getParamDescription() {
		return array(
			'name' => 'The name of the survey',
			'enabled' => 'Enable the survey or not',
			'questions' => 'The questions that make up the survey',
			'token' => 'Edit token. You can get one of these through prop=info.',
		);
	}
	
	public function getDescription() {
		return array(
			'API module for adding surveys.'
		);
	}
	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'name' ),
			array( 'missingparam', 'enabled' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=addsurvey&name=My awesome survey&enabled=1&questions=',
		);
	}	
	
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiAddSurvey.php 96766 2011-09-11 01:17:47Z jeroendedauw $';
	}	
	
}
