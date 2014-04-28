<?php


class WikiaAccessRulesTest extends WikiaBaseTest {

	const FOO_CONTROLLER = "FooController";
	const FOO_METHOD = "doFoo";
	const SOME_PERMISSION = "write";
	const SOME_DIFFERENT_PERMISSION = "write";

	public function  testReturnsRequiredPrivileges() {
		$rules = [
			[
				"class" => self::FOO_CONTROLLER,
				"method" => self::FOO_METHOD,
				"requiredPermissions" => [self::SOME_PERMISSION],
			],
		];
		$wikiaAccessRules = new WikiaAccessRules( $rules );

		$result = $wikiaAccessRules->getRequiredPermissionsFor(self::FOO_CONTROLLER, self::FOO_METHOD);

		$this->assertEquals([self::SOME_PERMISSION], $result);
	}

	public function  testNotMatchingRulesForDifferentClass() {
		$rules = [
			[
				"class" => "NotFooController",
				"method" => self::FOO_METHOD,
				"requiredPermissions" => [self::SOME_DIFFERENT_PERMISSION],
			],
			[
				"class" => self::FOO_CONTROLLER,
				"method" => self::FOO_METHOD,
				"requiredPermissions" => [self::SOME_PERMISSION],
			],
		];
		$wikiaAccessRules = new WikiaAccessRules( $rules );

		$result = $wikiaAccessRules->getRequiredPermissionsFor(self::FOO_CONTROLLER, self::FOO_METHOD);

		$this->assertEquals([self::SOME_PERMISSION], $result);
	}

	public function  testNotMatchingRulesForDifferentMethods() {
		$rules = [
			[
				"class" => self::FOO_CONTROLLER,
				"method" => "*",
				"requiredPermissions" => [self::SOME_DIFFERENT_PERMISSION],
			],
			[
				"class" => self::FOO_CONTROLLER,
				"method" => self::FOO_METHOD,
				"requiredPermissions" => [self::SOME_PERMISSION],
			],
		];
		$wikiaAccessRules = new WikiaAccessRules( $rules );

		$result = $wikiaAccessRules->getRequiredPermissionsFor(self::FOO_CONTROLLER, self::FOO_METHOD);

		$this->assertEquals([self::SOME_PERMISSION], $result);
	}

	public function  testMatchingClassWildcard() {
		$rules = [
			[
				"class" => "*",
				"method" => self::FOO_METHOD,
				"requiredPermissions" => [self::SOME_PERMISSION],
			],
		];
		$wikiaAccessRules = new WikiaAccessRules( $rules );

		$result = $wikiaAccessRules->getRequiredPermissionsFor(self::FOO_CONTROLLER, self::FOO_METHOD);

		$this->assertEquals([self::SOME_PERMISSION], $result);
	}

	public function  testMatchesMethodWildcard() {
		$rules = [
			[
				"class" => self::FOO_CONTROLLER,
				"method" => "*",
				"requiredPermissions" => [self::SOME_PERMISSION],
			],
		];
		$wikiaAccessRules = new WikiaAccessRules( $rules );

		$result = $wikiaAccessRules->getRequiredPermissionsFor(self::FOO_CONTROLLER, self::FOO_METHOD);

		$this->assertEquals([self::SOME_PERMISSION], $result);
	}

	public function  testCatchAll() {
		$rules = [
			[
				"class" => "*",
				"method" => "*",
				"requiredPermissions" => [self::SOME_PERMISSION],
			],
		];
		$wikiaAccessRules = new WikiaAccessRules( $rules );

		$result = $wikiaAccessRules->getRequiredPermissionsFor(self::FOO_CONTROLLER, self::FOO_METHOD);

		$this->assertEquals([self::SOME_PERMISSION], $result);
	}
}
