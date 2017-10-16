<?php


class WikiaAccessRules {
	const REQUIRED_PERMISSIONS_FIELD_NAME = 'requiredPermissions';
	const CLASS_FIELD_NAME = "class";
	const METHOD_FIELD_NAME = "method";

	/**
	 * @var array
	 */
	private $rules;

	public static function instance() {
		global $wgNirvanaAccessRules;

		return new WikiaAccessRules( $wgNirvanaAccessRules );
	}

	/**
	 * @param $rules
	 * @see WikiaAccessRules::instance() - factory method
	 * @see $wgNirvanaAccessRules
	 */
	function __construct( $rules ) {
		$this->rules = $rules;
	}

	/**
	 * @param $controller - Controller class name
	 * @param $method - Method name
	 * @return string[]
	 */
	public function getRequiredPermissionsFor( $controller, $method ) {
		$rule = $this->getMatchingRule( $controller, $method );
		return $rule[ self::REQUIRED_PERMISSIONS_FIELD_NAME ];
	}

	private function  getMatchingRule( $controller, $method ) {
		foreach ( $this->rules as $rule ) {
			if ( $this->matchesControllerName($rule, $controller) && $this->matchesMethodName($rule, $method) ) {
				return $rule;
			}
		}
		return null;
	}

	/**
	 * @param $rule
	 * @param $controller
	 * @return bool
	 */
	private function matchesControllerName($rule, $controller) {
		if ( $rule[self::CLASS_FIELD_NAME] === '*' ) {
			return true;
		}
		return $rule[self::CLASS_FIELD_NAME] === $controller;
	}

	/**
	 * @param $rule
	 * @param $method
	 * @return bool
	 */
	private function matchesMethodName($rule, $method) {
		if ( $rule[self::METHOD_FIELD_NAME] === "*" ) {
			return true;
		}
		return $rule[self::METHOD_FIELD_NAME] === $method;
	}
} 
