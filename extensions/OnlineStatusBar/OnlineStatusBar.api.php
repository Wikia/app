<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a part of mediawiki and can't be started separately";
	die();
}

/**
 * Hooks for OnlineStatusBar api's
 *
 * @group Extensions
 */

class ApiOnlineStatus extends ApiQueryBase {
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'onlinestatus' );
	}

	public function execute() {
		$params = $this->extractRequestParams();
		$result = OnlineStatusBar::getUserInfoFromString( $params['user'] );
		// if user is IP and we track them
		if ( User::isIP( $params['user'] ) && $result === false ) {
			$result = OnlineStatusBar::getAnonFromString( $params['user'] );
		}
		if ( $result === false ) {
			$ret = 'unknown';
		} else {
			$ret = $result[0];
		}

		$this->getResult()->addValue(
			null, $this->getModuleName(), array( 'result' => $ret ) );
	}

	public function getAllowedParams() {
	// params
		return array(
			'user' => array (
					ApiBase::PARAM_TYPE => 'string',
					ApiBase::PARAM_REQUIRED => true
				),
		);
	}

	public function getParamDescription() {
		return array(
			'user' => 'Username of user you want to get status for',
		);
	}

	public function getDescription() {
		return 'Returns online status of user.';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
		array( 'code' => 'unknown', 'info' => "User doesn't allow to display user status"),
		));
	}

	public function getExamples() {
		return array(
		'api.php?action=query&prop=onlinestatus&onlinestatususer=Petrb',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: OnlineStatusBar.api.php petrb $';
	}
}
