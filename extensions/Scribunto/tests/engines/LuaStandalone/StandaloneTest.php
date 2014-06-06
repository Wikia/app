<?php

class Scribunto_LuaStandaloneTests extends Scribunto_LuaEngineTestBase {
	protected static $moduleName = 'StandaloneTests';

	public static function suite( $className ) {
		return self::makeSuite( $className, 'LuaStandalone' );
	}

	public function setUp() {
		parent::setUp();

		$interpreter = $this->getEngine()->getInterpreter();
		$func = $interpreter->wrapPhpFunction( function ( $v ) {
			return array( preg_replace( '/\s+/', ' ', trim( var_export( $v, 1 ) ) ) );
		} );
		$interpreter->callFunction(
			$interpreter->loadString( 'mw.var_export = ...', 'fortest' ), $func
		);
	}

	function getTestModules() {
		return parent::getTestModules() + array(
			'StandaloneTests' => __DIR__ . '/StandaloneTests.lua',
		);
	}
}
