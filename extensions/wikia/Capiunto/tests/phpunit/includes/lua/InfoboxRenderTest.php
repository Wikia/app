<?php

namespace Capiunto\Test;
use Scribunto_LuaEngineTestBase;

/**
 * Tests for mw.capiunto.Infobox._render
 *
 * @license GNU GPL v2+
 *
 * @author Marius Hoch < hoo@online.de >
 */

class InfoboxRenderModuleTest extends Scribunto_LuaEngineTestBase {
	protected static $moduleName = 'InfoboxRenderModuleTests';

	function getTestModules() {
		return parent::getTestModules() + array(
			'InfoboxRenderModuleTests' => __DIR__ . '/InfoboxRenderTests.lua',
		);
	}
}
