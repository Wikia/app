<?php

class ApiAccessService {

	const URL_TEST = 128;
	const ENV_DEVELOPMENT = 1;
	const ENV_SANDBOX = 2;

	/**
	 * @var WikiaRequest
	 */
	protected $request;

	/**
	 * APIs and endpoints that are not public
	 * @var array
	 */
	protected $envValues = [
		'development' => self::ENV_DEVELOPMENT,
		'sandbox' => self::ENV_SANDBOX
	];

	public function __construct( WikiaRequest $request ) {
		$this->request = $request;
	}

	protected function getApiAccess($controller, $action ) {
		global $wgApiAccess;
		if ( is_array( $wgApiAccess ) && isset( $wgApiAccess[ $controller ] ) ) {
			$actions = $wgApiAccess[ $controller ];
			if ( is_array( $actions ) ) {
				return isset( $actions[ $action ] ) ? $actions[ $action ] : 0;
			} else {
				return $actions;
			}
		}
		return 0;
	}

	/**
	 * Checks $wgApiEnvironment and returns value from $envValues
	 * @return int
	 */
	protected function getEnvValue() {
		global $wgApiEnvironment;
		$val = 0;
		$name = isset( $wgApiEnvironment ) ? $wgApiEnvironment : "";
		if ( isset( $this->envValues[ $name ] ) ) {
			$val = $this->envValues[ $name ];
		}
		return $val;
	}

	/**
	 * Test if you can use (or display in doc) specified controller and action.
	 *
	 * @param $controller string
	 * @param $action string
	 * @return bool result
	 */
	public function canUse( $controller, $action ) {
		$access = $this->getApiAccess($controller, $action );
		$isTest = $this->isTestLocation();
		$prodVal = $this->getEnvValue();
		//no access restriction found
		if ( !$access ) {
			return true;
		}
		//if access needs TEST in url, and we are not on test
		if ( $access & self::URL_TEST ) {
			if ( !$isTest ) {
				return false;
			} elseif ( $access === self::URL_TEST ) {
				return true;
			}
		}
		return (bool)( $access & $prodVal );
	}

	/**
	 * Same as ApiAccessService::canUse but if you cannot use controller/action
	 * this will throw NotFoundApiException exception
	 *
	 * @param $controller string
	 * @param $action string
	 * @throws NotFoundApiException
	 */
	public function checkUse( $controller, $action ) {
		if ( !$this->canUse( $controller, $action ) ) {
			throw new NotFoundApiException();
		}
	}

	protected function isTestLocation() {
		static $result = null;
		if ( $result === null ) {
			$result = ( stripos( $this->request->getScriptUrl(), '/api/test' ) !== false );
		}

		return $result;
	}
}