<?php

class Scribunto_LuaStandaloneTests extends Scribunto_LuaEngineTestBase {
	protected static $moduleName = 'StandaloneTests';

	public static function suite( $className ) {
		return self::makeSuite( $className, 'LuaStandalone' );
	}

	function getTestModules() {
		return parent::getTestModules() + array(
			'StandaloneTests' => __DIR__ . '/StandaloneTests.lua',
		);
	}
}
