<?php

/**
 * API module that records problems with Congress
 */
class ApiCongressLookup extends ApiBase {
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {

		$params = $this->extractRequestParams();

		$dbw = wfGetDb( DB_MASTER );

		$dbw->insert(
			'cl_errors',
			array(
				'cle_zip' => $params['zip'],
				'cc_comment' => $params['comment']
			),
			__METHOD__,
			array()
		);

		$this->getResult()->addValue( null, $this->getModuleName(), 'OK' );
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getAllowedParams() {
		return array(
			'zip' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true
			),
			'comment' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'token' => null,
		);
	}

	public function getParamDescription() {
		return array(
			'zip' => 'the zipcode with a problem',
			'comment' => 'whatever the user has to say about that problem',
		);
	}

	public function getDescription() {
		return 'Record errors regarding congressional representative lookups';
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: $';
	}

	private function checkPermission( $user ) {
		if ( $user->isBlocked( false ) ) {
			$this->dieUsageMsg( array( 'blockedtext' ) );
		}
	}
}
