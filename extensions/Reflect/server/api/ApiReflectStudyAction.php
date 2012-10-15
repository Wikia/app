<?php

/**
* Implements the API for a research study investigating the affordances
* of Reflect and LQT. Users are asked to fill out short surveys about 
* something that they just did (like why they just added a summary point). 
* These survey results are then posted to here. 
* 
* However, the survey responses cannot be added to the local wikimedia 
* installation's database. This is because of American Universities' 
* Institutional Review Board for approving research involving human 
* subjects (http://en.wikipedia.org/wiki/Institutional_review_board). 
* We need to store the results of the surveys on a university
* server dissasociated from personally identifying information (i.e. username). 
* 
* Therefore, ApiReflectStudyAction handles posts but then creates an XML-RPC
* connection to a remote server, where the survey response and a hash of the
* user name are stored. 
* 
*/		

// dependency on http://pear.php.net/package/XML_RPC2/
require_once 'XML/RPC2/Client.php';

class ApiReflectStudyAction extends ApiBase {

	public function execute() {
		$params = $this->extractRequestParams();

		if ( empty( $params['reflectstudyaction'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'action' ) );
		}

		$allowedAllActions = array();
		$action = $params['reflectstudyaction'];

		// Find the appropriate module
		$actions = $this->getActions();

		$method = $actions[$action];

		call_user_func_array( array( $this, $method ), array( $params ) );
	}

	/**
	* Fetches the surveys that the current user has already filled out. 
	* Only the bullet_ids of the completed surveys are returned from the
	* remote server. 
	* 
 	* The params listed below are the items posted in $params.
	* @param $bullets List of bullet_ids for which the user MAY already have been surveyed
	* 
	* @return Returns the response from the remote host. 
	*/			
	public function actionGetSurveyBullets( $params ) {
		global $wgUser;
		$user = $wgUser->getName();
		$user = md5( $user );

		global $wgReflectStudyRPCHost, $wgReflectStudyDomain;

		$rpcConn = XML_RPC2_Client::create( $wgReflectStudyRPCHost, 
				array( 'backend' => 'php' ) );
		try {
			$resp = $rpcConn->get_survey_responses( $wgReflectStudyDomain, 
					$params['bullets'], $user );
		} catch ( XML_RPC2_FaultException $e ) {
			 // The XMLRPC server returns a XMLRPC error
			 die( 'Exception #' . $e->getFaultCode() . ' : ' . $e->getFaultString() );
		} catch ( Exception $e ) {
			 // Other errors (HTTP or networking problems...)
			 die( 'Exception : ' . $e->getMessage() );
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $resp );
	}
	
	/**
	* Posts a survey response to the remote server. But first 
	* checks to make sure the current user is authorized to 
	* post the survey. 
	* 
 	* The params listed below are the items posted in $params.
	* @param $comment_id
	* @param $bullet_id 
	* @param $bullet_rev
	* @param $survey_id An identifier for the survey being responded to
	* @param $response_id The answer to the response
	* @param $text Free form survey response (if relevant)
	* 
	* @return Returns the response from the remote host. 
	*/		
	public function actionPostSurveyBullets( $params ) {
		$dbr = wfGetDB( DB_SLAVE );

		global $wgUser;
		$user = $wgUser->getName();

		$bulletID = $params['bullet_id'];
		$commentID = $params['comment_id'];
		$bulletRev = $params['bullet_rev'];
		$surveyID = $params['survey_id'];
		$responseID = $params['response_id'];
		$text = $params['text'];

		$comment = $dbr->selectRow(
				$table = 'thread',
				$vars = array( 'thread_author_name as user' ),
				$conds = 'thread_id = ' . $commentID );

		$bullet = $dbr->selectRow(
						 $table = 'reflect_bullet_revision',
						 $vars = array( 'bl_user as user' ),
						 $conds = 'bl_rev_id = ' . $bulletRev );

		// only commenters can answer survey 2
		// only bullet writers can answer survey 1
		if ( ( $surveyID == "2" && $user != $comment->user ) 
				|| ( $surveyID == "1" && $user != $bullet->user ) ) 
		{
			$resp = array( 'invalid post' ); // TODO: use dieUsageMsg instead
		} else {
			global $wgReflectStudyRPCHost, $wgReflectStudyDomain;

			// store hash of username on remote study server for anonymity
			$user = md5( $user );

			$rpcConn = XML_RPC2_Client::create( $wgReflectStudyRPCHost, 
					array( 'backend' => 'php' ) );
			try {
				if ( !$text ) $text = '';
				$resp = $rpcConn->post_survey_response( $wgReflectStudyDomain,
						$commentID, $bulletID, $bulletRev,
						$responseID, $surveyID, $user, $text );
			} catch ( XML_RPC2_FaultException $e ) {
				 // The XMLRPC server returns a XMLRPC error
				 die( 'Exception #' . $e->getFaultCode() . ' : ' . $e->getFaultString() );
			} catch ( Exception $e ) {
				 // Other errors (HTTP or networking problems...)
				 die( 'Exception : ' . $e->getMessage() );
			}
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $resp );
	}

	/****** ApiBase methods ********/
	
	public function getDescription() {
		return 'Enables in-situ surveys for study Reflect activities in Liquid-Threaded discussions.';
	}

	public function getActions() {
		return array(
			'post_survey_bullets' => 'actionPostSurveyBullets',
			'get_survey_responses' => 'actionGetSurveyBullets',
		);
	}

	public function getParamDescription() {
		return array(
			'reflectstudyaction' => 'The action to take',
			'token' => 'An edit token (from ?action=query&prop=info&intoken=edit)',
			'comment_id' => 'The id of the thread',
			'bullet_id' => 'The id of the bullet the survey is asking about',
			'bullet_rev' => 'The revid of the bullet the survey is asking about',
			'response_id' => 'An answer to a survey question',
			'survey_id' => 'An identifier for the specific survey being administered',
			'text' => 'Optional text field for open ended survey questions',
			'bullets' => 'list of bullets for survey to get'
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'action' ),
		) );
	}

	public function getExamples() {
		return array();
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function getAllowedParams() {
		return array(
			'reflectstudyaction' => array(
				ApiBase::PARAM_TYPE => array_keys( $this->getActions() ),
			),
			'token' => null,
			'comment_id' => null,
			'bullet_id' => null,
			'bullet_rev' => null,
			'response_id' => null,
			'survey_id' => null,
			'text' => null,
			'bullets' => null,
		);
	}

	public function mustBePosted() {
		return false;
	}

	public function isWriteMode() {
		return true;
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiReflectStudyAction.php 83769 2011-03-12 18:05:13Z reedy $';
	}
}
