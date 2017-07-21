<?php

namespace SMW\Scribunto\Tests;

use SMW\Scribunto\ScribuntoLuaLibrary;

/**
 * Encapsulation of the Scribunto_LuaEngineTestBase class
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
abstract class ScribuntoLuaEngineTestBase extends \Scribunto_LuaEngineTestBase
{
	/**
	 * @var \SMW\Scribunto\ScribuntoLuaLibrary
	 */
	private $scribuntoLuaLibrary;

	protected function setUp() {
		parent::setUp();

		/** @noinspection PhpParamsInspection */
		$this->scribuntoLuaLibrary = new ScribuntoLuaLibrary(
			$this->getEngine()
		);
	}

	/**
	 * Accesses an instance of class {@see ScribuntoLuaLibrary}
	 *
	 * @return ScribuntoLuaLibrary ScribuntoLuaLibrary
	 */
	public function getScribuntoLuaLibrary() {
		return $this->scribuntoLuaLibrary;
	}
}