<?php

class ApiEmailCapture extends ApiBase {
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, '' );
	}

	public function execute() {
		$params = $this->extractRequestParams();

		// Validation
		if ( !User::isValidEmailAddr( $params['email'] ) ) {
			$this->dieUsage( 'The email address does not appear to be valid', 'invalidemail' );
		}

		// Verification code
		$code = md5( 'EmailCapture' . time() . $params['email'] . $params['info'] );

		// Insert
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			'email_capture',
			array(
				'ec_email' => $params['email'],
				'ec_info' => isset( $params['info'] ) ? $params['info'] : null,
				'ec_code' => $code,
			),
			__METHOD__,
			 array( 'IGNORE' )
		);

		if ( $dbw->affectedRows() ) {
			// Send auto-response
			global $wgEmailCaptureSendAutoResponse, $wgEmailCaptureAutoResponse;
			$title = SpecialPage::getTitleFor( 'EmailCapture' );
			$link = $title->getCanonicalURL();
			$fullLink = $title->getCanonicalURL( array( 'verify' => $code ) );
			if ( $wgEmailCaptureSendAutoResponse ) {
				UserMailer::send(
					new MailAddress( $params['email'] ),
					new MailAddress(
						$wgEmailCaptureAutoResponse['from'],
						$wgEmailCaptureAutoResponse['from-name']
					),
					wfMsg( $wgEmailCaptureAutoResponse['subject-msg'] ),
					wfMsg( $wgEmailCaptureAutoResponse['body-msg'], $fullLink, $link, $code ),
					$wgEmailCaptureAutoResponse['reply-to'],
					$wgEmailCaptureAutoResponse['content-type']
				);
			}
			$r = array( 'result' => 'Success' );
		} else {
			$r = array( 'result' => 'Failure', 'message' => 'Duplicate email address' );
		}
		$this->getResult()->addValue( null, $this->getModuleName(), $r );
	}

	public function getAllowedParams() {
		return array(
			'email' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => 'string',
			),
			'info' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
		);
	}

	public function getParamDescription() {
		return array(
			'email' => 'Email address to capture',
			'info' => 'Extra information to log, usually JSON encoded structured information',
		);
	}

	public function getDescription() {
		return array(
			'Capture email addresses'
		);
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array(
				'code' => 'invalidemail',
				'info' => 'The email address does not appear to be valid'
			),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=emailcapture'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiEmailCapture.php 95659 2011-08-29 12:33:53Z catrope $';
	}
}
