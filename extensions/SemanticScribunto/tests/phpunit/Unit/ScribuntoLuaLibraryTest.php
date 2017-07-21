<?php

namespace SMW\Scribunto\Tests;

/**
 * @covers \SMW\Scribunto\ScribuntoLuaLibrary
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author Tobias Oetterer
 */
class ScribuntoLuaLibraryTest extends ScribuntoLuaEngineTestBase {

	/**
	 * Lua test module
	 * @var string
	 */
	protected static $moduleName = self::class;

	/**
	 * ScribuntoLuaEngineTestBase::getTestModules
	 */
	public function getTestModules() {
		return parent::getTestModules() + [
			self::$moduleName => __DIR__ . '/' . 'mw.smw.tests.lua',
		];
	}


	public function testCanConstruct() {
		$this->assertInstanceOf(
			'\SMW\Scribunto\ScribuntoLuaLibrary',
			$this->getScribuntoLuaLibrary()
		);
	}

	/**
	 * Test, if all the necessary methods exists. Uses data provider {@see dataProviderFunctionTest}
	 * @dataProvider dataProviderFunctionTest
	 *
	 * @param string $method name of method to check
	 *
	 * @uses dataProviderFunctionTest
	 *
	 * @return void
	 */
	public function testMethodsExist( $method ) {
		$this->assertTrue(
			method_exists( $this->getScribuntoLuaLibrary(), $method ),
			'Class \SMW\Scribunto\ScribuntoLuaLibrary has method \'' . $method . '()\' missing!'
		);
	}


	/**
	 * Data provider for {@see testFunctions}
	 *
	 * @see testFunctions
	 *
	 * @return array
	 */
	public function dataProviderFunctionTest() {

		return [
			[ 'ask' ],
			[ 'getPropertyType' ],
			[ 'getQueryResult' ],
			[ 'info' ],
			[ 'set' ],
			[ 'subobject' ]
		];
	}

}