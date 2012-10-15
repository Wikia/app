<?php

class ApiFeedbackDashboard extends ApiBase {
	public function execute() {
		global $wgUser;
		if ( ! $wgUser->isAllowed('moodbar-admin') ) {
			$this->dieUsage( "You don't have permission to do that", 'permission-denied' );
		}
	
		$params = $this->extractRequestParams();
		$form = null;

		if ( $params['mbaction'] == 'hide' ) {
			$form = new MBHideForm( $params['item'] );
		} elseif ( $params['mbaction'] == 'restore' ) {
			$form = new MBRestoreForm( $params['item'] );
		} else {
			throw new MWException( "Action {$params['action']} not implemented" );
		}
		
		$data = array(
			'reason' => $params['reason'],
			'item' => $params['item'],
		);
		
		$result = null;
		$output = $form->submit( $data );
		if ( $output === true ) {
			$result = array( 'result' => 'success' );
		} else {
			$result = array( 'result' => 'error', 'error' => $output );
		}
		
		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function getAllowedParams() {
		return array(
			'mbaction' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => array(
					'hide',
					'restore',
				),
			),
			
			'item' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => 'integer',
			),
			
			'reason' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => 'string'
			),
			'token' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
		);
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiFeedbackDashboard.php 103224 2011-11-15 21:24:44Z bsitu $';
	}

	public function getParamDescription() {
		return array(
			'mbaction' => 'The action to take',
			'item' => 'The feedback item to apply it to',
			'reason' => 'The reason to specify in the log',
		);
	}

	public function getDescription() {
		return 'Allows administrators to manage submissions to the feedback dashboard';
	}
}
