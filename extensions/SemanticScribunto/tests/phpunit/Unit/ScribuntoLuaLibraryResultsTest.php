<?php

namespace SMW\Scribunto\Tests;

/**
 * @covers \SMW\Scribunto\ScribuntoLuaLibrary
 * @group semantic-scribunto
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class ScribuntoLuaLibraryResultsTest extends ScribuntoLuaEngineTestBase {

	/**
	 * Lua test module
	 * @var string
	 */
	protected static $moduleName = 'SMW\Scribunto\Tests\ScribuntoLuaLibraryResultsTest';

	/**
	 * ScribuntoLuaEngineTestBase::getTestModules
	 */
	public function getTestModules() {
		return parent::getTestModules() + [
			'SMW\Scribunto\Tests\ScribuntoLuaLibraryResultsTest' => __DIR__ . '/' . 'mw.smw.results.tests.lua',
		];
	}

	/**
	 * Tests method getQueryResult
	 *
	 * @return void
	 */
	public function testGetQueryResult() {
		$this->assertArrayHasKey(
			'meta',
			$this->getScribuntoLuaLibrary()->getQueryResult()[0]
		);
		$this->assertArrayHasKey(
			'count',
			$this->getScribuntoLuaLibrary()->getQueryResult()[0]['meta']
		);
		$this->assertEquals(
			0,
			$this->getScribuntoLuaLibrary()->getQueryResult()[0]['meta']['count']
		);
		$this->assertArrayHasKey(
			'printrequests',
			$this->getScribuntoLuaLibrary()->getQueryResult( '[[Modification date::+]]|?Modification date|limit=0|mainlabel=-' )[0]
		);
		$this->assertArrayHasKey(
			1,
			$this->getScribuntoLuaLibrary()->getQueryResult( '[[Modification date::+]]|?Modification date|limit=0|mainlabel=-' )[0]['printrequests']
		);
		$this->assertArrayHasKey(
			'label',
			$this->getScribuntoLuaLibrary()->getQueryResult( '[[Modification date::+]]|?Modification date|limit=0|mainlabel=-' )[0]['printrequests'][1]
		);
		$this->assertEquals(
			'Modification date',
			$this->getScribuntoLuaLibrary()->getQueryResult( '[[Modification date::+]]|?Modification date|limit=0|mainlabel=-' )[0]['printrequests'][1]['label']
		);
		$this->assertEquals(
			'Modification date',
			$this->getScribuntoLuaLibrary()->getQueryResult( [ '[[Modification date::+]]', '?Modification date', 'limit' => 0, 'mainlabel=-' ] )[0]['printrequests'][1]['label']
		);
	}
}