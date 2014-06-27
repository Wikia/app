<?php

namespace Capiunto\Test;
use Scribunto_LuaEngineTestBase;

/**
 * Tests for mw.capiunto.Infobox
 *
 * @license GNU GPL v2+
 *
 * @author Marius Hoch < hoo@online.de >
 */

class InfoboxModuleTest extends Scribunto_LuaEngineTestBase {
	protected static $moduleName = 'InfoboxModuleTests';

	function getTestModules() {
		return parent::getTestModules() + array(
			'InfoboxModuleTests' => __DIR__ . '/InfoboxTests.lua',
		);
	}

}
