<?php

class Scribunto_LuaTextLibraryTests extends Scribunto_LuaEngineTestBase {
	protected static $moduleName = 'TextLibraryTests';

	function setUp() {
		parent::setUp();

		// For unstrip test
		$parser = $this->getEngine()->getParser();
		$markers = array(
			'nowiki' => $parser->uniqPrefix() . '-test-nowiki-' . Parser::MARKER_SUFFIX,
			'general' => $parser->uniqPrefix() . '-test-general-' . Parser::MARKER_SUFFIX,
		);
		$parser->mStripState->addNoWiki( $markers['nowiki'], 'NoWiki' );
		$parser->mStripState->addGeneral( $markers['general'], 'General' );
		$interpreter = $this->getEngine()->getInterpreter();
		$interpreter->callFunction(
			$interpreter->loadString( 'mw.text.stripTest = ...', 'fortest' ),
			$markers
		);
	}


	function getTestModules() {
		return parent::getTestModules() + array(
			'TextLibraryTests' => __DIR__ . '/TextLibraryTests.lua',
		);
	}
}
