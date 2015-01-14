<?php

class Scribunto_LuaUriLibraryTests extends Scribunto_LuaEngineTestBase {
	protected static $moduleName = 'UriLibraryTests';

	function setUp() {
		parent::setUp();

		$this->setMwGlobals( array(
			'wgServer' => '//wiki.local',
			'wgCanonicalServer' => 'http://wiki.local',
			'wgUsePathInfo' => true,
			'wgActionPaths' => array(),
			'wgScript' => '/w/index.php',
			'wgScriptPath' => '/w',
			'wgArticlePath' => '/wiki/$1',
		) );
	}

	function getTestModules() {
		return parent::getTestModules() + array(
			'UriLibraryTests' => __DIR__ . '/UriLibraryTests.lua',
		);
	}
}
