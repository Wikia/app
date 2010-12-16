<?php

class ApiCodeTestUpload extends ApiBase {

	public function execute() {
		global $wgUser;
		// Before doing anything at all, let's check permissions
		if( !$wgUser->isAllowed('codereview-use') ) {
			$this->dieUsage('You don\'t have permission to upload test results', 'permissiondenied');
		}
		$params = $this->extractRequestParams();
		
		$this->validateParams( $params );
		$this->validateHmac( $params );

		$repo = CodeRepository::newFromName( $params['repo'] );
		if( !$repo ) {
			$this->dieUsage( "Invalid repo ``{$params['repo']}''", 'invalidrepo' );
		}
		
		$suite = $repo->getTestSuite( $params['suite'] );
		if( !$suite ) {
			$this->dieUsage( "Invalid test suite ``{$params['suite']}''", 'invalidsuite' );
		}
		
		// Note that we might be testing a revision that hasn't gotten slurped in yet,
		// so we won't reject data for revisions we don't know about yet.
		$revId = intval( $params['rev'] );
		
		$status = $params['status'];
		if( $status == 'running' || $status == 'aborted' ) {
			// Set the 'tests running' flag so we can mark it...
			$suite->setStatus( $revId, $status );
		} elseif( $status == 'complete' ) {
			// Save data and mark running test as completed.
			$results = json_decode( $params['results'], true );
			if( !is_array( $results ) ) {
				$this->dieUsage( "Invalid test result data", 'invalidresults' );
			}
			$suite->saveResults( $revId, $results );
		}
	}
	
	protected function validateParams( $params ) {
		$required = array( 'repo', 'suite', 'rev', 'status', 'hmac' );
		if( isset( $params['status'] ) && $params['status'] == 'complete' ) {
			$required[] = 'results';
		}
		foreach( $required as $arg ) {
			if ( !isset( $params[$arg] ) ) {
				$this->dieUsageMsg( array( 'missingparam', $arg ) );
			}
		}
	}
	
	protected function validateHmac( $params ) {
		global $wgCodeReviewSharedSecret;
		
		// Generate a hash MAC to validate our credentials
		$message = array(
			$params['repo'],
			$params['suite'],
			$params['rev'],
			$params['status'],
		);
		if( $params['status'] == "complete" ) {
			$message[] = $params['results'];
		}
		$hmac = hash_hmac( "sha1", implode( "|", $message ), $wgCodeReviewSharedSecret );
		if( $hmac != $params['hmac'] ) {
			$this->dieUsageMsg( array( 'invalidhmac', $params['hmac'] ) );
		}
	}

	public function mustBePosted() {
		// Discourage casual browsing :)
		return true;
	}
	
	public function isWriteMode() {
		return true;
	}

	public function getAllowedParams() {
		return array(
			'repo' => null,
			'suite' => null,
			'rev' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_MIN => 1
			),
			'status' => array(
				ApiBase::PARAM_TYPE => array( 'running', 'complete', 'abort' ),
			),
			'hmac' => null,
			'results' => null,
		);
	}

	public function getParamDescription() {
		return array(
			'repo' => 'Name of repository to update',
			'suite' => 'Name of test suite to record run results for',
			'rev' => 'Revision ID tests were run against',
			'status' => 'Status of test run',
			'hmac' => 'HMAC validation',
			'results' => 'JSON-encoded map of test names to success results, for status "complete"',
		);
	}
	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'permissiondenied', 'info' => 'You don\'t have permission to upload test results' ),
			array( 'code' => 'invalidrepo', 'info' => "Invalid repo ``repo''" ),
			array( 'code' => 'invalidsuite', 'info' => "Invalid test suite ``suite''" ),
			array( 'code' => 'invalidresults', 'info' => 'Invalid test result data' ),
			array( 'invalidhmac', 'hmac' ),
			array( 'missingparam', 'repo' ),
			array( 'missingparam', 'suite' ),
			array( 'missingparam', 'rev' ),
			array( 'missingparam', 'status' ),
			array( 'missingparam', 'hmac' ),
			array( 'missingparam', 'results' ),
		) );
	}

	public function getDescription() {
		return array(
			'Upload CodeReview test run results from a test runner.' );
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiCodeUpdate.php 48928 2009-03-27 18:41:20Z catrope $';
	}
}
