<?php

class ApiAbuseFilterUnblockAutopromote extends ApiBase {
	public function execute() {
		if ( !$this->getUser()->isAllowed( 'abusefilter-modify' ) ) {
			$this->dieUsage( 'You do not have permissions to unblock autopromotion', 'permissiondenied' );
		}

		$params = $this->extractRequestParams();
		$user = User::newFromName( $params['user'] );

		if ( $user === false ) {
			// Oh god this is so bad but this message uses GENDER
			$msg = wfMsgExt( 'abusefilter-reautoconfirm-none', array( 'parsemag' ), $params['user'] );
			$this->dieUsage( $msg, 'notsuspended' );
		}

		global $wgMemc;
		$key = AbuseFilter::autoPromoteBlockKey( $user );

		if ( !$wgMemc->get( $key ) ) {
			// Same as above :(
			$msg = wfMsgExt( 'abusefilter-reautoconfirm-none', array( 'parsemag' ), $params['user'] );
			$this->dieUsage( $msg, 'notsuspended' );
		}

		$wgMemc->delete( $key );

		$res = array( 'user' => $params['user'] );
		$this->getResult()->addValue( null, $this->getModuleName(), $res );
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getAllowedParams() {
		return array(
			'user' => array(
				ApiBase::PARAM_REQUIRED => true
			),
			'token' => null,
		);
	}

	public function getParamDescription() {
		return array(
			'user' => 'Username of the user you want to unblock',
			'token' => 'An edit token',
		);
	}

	public function getDescription() {
		return 'Unblocks a user from receiving autopromotions due to an abusefilter consequence';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'notsuspended', 'info' => 'That user has not had their autoconfirmed status suspended'),
			array( 'code' => 'permissiondenied', 'info' => 'You do not have permissions to unblock autopromotion' ),
		) );
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function getExamples() {
		return array(
			'api.php?action=abusefilterunblockautopromote&user=Bob'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiAbuseFilterUnblockAutopromote.php 108852 2012-01-13 21:36:51Z reedy $';
	}
}
