<?php

class ApiAccessService {

	const ENV_DEVELOPMENT = 1;
	const ENV_SANDBOX = 2;
	const WIKIA_CORPORATE = 32;
	const WIKIA_NON_CORPORATE = 64;
	const URL_TEST = 128;
	const ALWAYS_HIDDEN = 256;

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
				if ( isset( $actions[ $action ] ) ) {
					return $actions[ $action ];
				} else if ( isset ( $actions[ '*' ] ) ) {
					return $actions[ '*' ];
				} 
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
		if ( ($access & self::WIKIA_NON_CORPORATE) && $this->isCorporateWiki() ) {
			return false;
		}
		if ( ($access & self::WIKIA_CORPORATE) && !($this->isCorporateWiki()) ) {
			return false;
		}
		$isTest = $this->isTestLocation();
		//if access needs TEST in url, and it's using standard url deny access
		if ( ($access & self::URL_TEST) && !$isTest ) {
			return false;
		}
		$access = $access & ~(self::URL_TEST | self::WIKIA_CORPORATE | self::WIKIA_NON_CORPORATE );
		//no access restriction found
		if ( !$access ) {
			return true;
		}
		$prodVal = $this->getEnvValue();
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
	protected function isCorporateWiki() {
		global $wgEnableWikiaHomePageExt;
		return !empty($wgEnableWikiaHomePageExt);
	}
	
}
