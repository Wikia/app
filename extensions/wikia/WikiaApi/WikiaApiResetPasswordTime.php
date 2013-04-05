<?php

/**
 * WikiaApiResetPasswordTime
 *
 * This API function allows to reset the time of last password recovery
 *
 * @author macbre
 */

class WikiaApiResetPasswordTime extends ApiBase {

	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action, '' /* prefix for parameters... so controller becomes $controller */ );
	}

	/**
	 * See functions below for expected URL params
	 */
	public function execute() {
		$app = F::app();
		wfProfileIn(__METHOD__);

		// validate token
		if ($this->getParameter('token') !== $app->wg->TheSchwartzSecretToken) {
			$this->dieUsage( 'Incorrect token provided', 'bad_token' );
			wfProfileOut(__METHOD__);
			return;
		}

		// validate the user
		$user = User::newFromName($this->getParameter('user'));

		if ( empty($user) || $user->getId() === 0 ) {
			$this->dieUsage( 'Invalid user provided', 'bad_user' );
			wfProfileOut(__METHOD__);
			return;
		}

		$user->mNewpassTime = null;
		$user->saveSettings();

		$this->getResult()->addValue('resetpasswordtime', 'success', true);

		wfProfileOut(__METHOD__);
	}

	public function mustBePosted() {
		return true;
	}

	public function getAllowedParams() {
		return array (
			'user' => array(
				ApiBase :: PARAM_TYPE => "string"
			),
			'token' => array(
				ApiBase :: PARAM_TYPE => "string"
			),
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiResetPasswordTime.php macbre';
	}

	public function getParamDescription() {
		return array(
			'user' => 'name of the user to reset the password time for',
			'token' => 'token to validate the request',
		);
	}

	public function getExamples() {
		return array (
			'api.php?action=resetpasswordtime&user=WikiaFooUser&token=xxx'
		);
	}

	public function getDescription() {
		return array(
			'This module is used to reset the time when password recovery email was sent'
		);
	}
}
