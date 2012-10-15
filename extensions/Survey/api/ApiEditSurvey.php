<?php

/**
 * API module to edit surveys.
 *
 * @since 0.1
 *
 * @file ApiEditSurvey.php
 * @ingroup Survey
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiEditSurvey extends ApiBase {
	
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
		
		$survey = new Survey( Survey::getValidFields( $params, $params['id'] ) );
		
		$this->getResult()->addValue(
			null,
			'success',
			$survey->writeToDB()
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
		return 'editsurvey';
	}
	
	public function mustBePosted() {
		return true;
	}

	public function getAllowedParams() {
		$params = array(
			'id' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true,
			),
			'questions' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_REQUIRED => true,
			),
			'token' => null,
		);
		
		return array_merge( Survey::getAPIParams(), $params );
	}
	
	public function getParamDescription() {
		return array(
			'id' => 'The ID of the survey to modify',
			'name' => 'The name of the survey',
			'enabled' => 'Enable the survey or not',
			'questions' => 'The questions that make up the survey',
			'token' => 'Edit token. You can get one of these through prop=info.',
		);
	}
	
	public function getDescription() {
		return array(
			'API module for editing a survey.'
		);
	}
	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'id' ),
			array( 'missingparam', 'name' ),
			array( 'missingparam', 'enabled' ),
			array( 'missingparam', 'questions' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=editsurvey&',
		);
	}	
	
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiEditSurvey.php 96766 2011-09-11 01:17:47Z jeroendedauw $';
	}		
	
}
