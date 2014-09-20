<?php

class Scribunto_LuaSandboxTests extends Scribunto_LuaEngineTestBase {
	protected static $moduleName = 'SandboxTests';

	public static function suite( $className ) {
		return self::makeSuite( $className, 'LuaSandbox' );
	}

	function getTestModules() {
		return parent::getTestModules() + array(
			'SandboxTests' => __DIR__ . '/SandboxTests.lua',
		);
	}
}
