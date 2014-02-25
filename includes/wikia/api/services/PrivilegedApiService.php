<?php

class PrivilegedApiService {
	/**
	 * @var WikiaRequest
	 */
	protected $request;

	/**
	 * APIs and endpoints that are not public
	 * @var array
	 */
	protected $privileged = [
		'TvApiController' => true,
		'SearchApiController' => [
			'getCombined' => true
		]
	];

	/**
	 * APIs and endpoints to be only in test
	 * @var array
	 */
	protected $testOnly = [
		'TvApiController' => true,
		'SearchApiController' => [
			'getCombined' => true
		]
	];


	public function __construct( WikiaRequest $request ) {
		$this->request = $request;
	}

	protected function lookInArray( $array, $controller, $action ) {
		if ( isset( $array[ $controller ] ) ) {
			$actions = $array[ $controller ];
			if ( is_array( $actions ) ) {
				return isset( $actions[ $action ] ) && $actions[ $action ] === true;
			} else {
				return $actions === true;
			}
		}
		return false;
	}

	protected function isPrivileged( $controller, $action ) {
		return $this->lookInArray( $this->privileged, $controller, $action );
	}

	protected function isTestOnly( $controller, $action ) {
		return $this->lookInArray( $this->testOnly, $controller, $action );
	}

	/**
	 * Test if you can use (or display in doc) specified controller and action. Depending on
	 * $wgPrivilegedEnvironment and "api/test" in url
	 *
	 * @param $controller string
	 * @param $action string
	 * @return bool result
	 */
	public function canUse( $controller, $action ) {
		global $wgPrivilegedEnvironment;
		if ( !$this->isTestLocation() && $this->isTestOnly( $controller, $action ) ) {
			return false;
		}
		if ( isset( $wgPrivilegedEnvironment ) && $wgPrivilegedEnvironment === true ) {
			return true;
		}

		return !$this->isPrivileged( $controller, $action );
	}

	/**
	 * Same as PrivilegedApiService::canUse but if you cannot use controller/action
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