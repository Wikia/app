<?php

namespace Capiunto\Test;
use Title;

/**
 * A basic Infobox output test
 *
 * @license GNU GPL v2+
 *
 * @author Marius Hoch < hoo@online.de >
 */

class BasicInfobox extends \Scribunto_LuaEngineTestBase {
	public function provideLuaData() {
		// We need to override this to prevent the parent from doing things we don't want/need
		return array();
	}

	public function testOutput() {
		$engine = $this->getEngine();
		$frame = $engine->getParser()->getPreprocessor()->newFrame();

		$title = Title::makeTitle( NS_MODULE, 'BasicTest' );
		$this->extraModules[ $title->getPrefixedDBkey() ] = file_get_contents( __DIR__ . '/BasicTest.lua' );

		$module = $engine->fetchModuleFromParser( $title );

		$box = $module->invoke( 'run', $frame->newChild() );

		$this->assertValidHtmlSnippet( $box );

		$matcher = array(
			'tag' => 'table',
			'attributes' => array( 'class' => 'mw-capiunto-infobox' ),
			'descendant' => array( 'tag' => 'th' )
		);

		$this->assertTag(
			$matcher,
			$box,
			"Basic infobox integration test didn't create expected html"
		);

	}
}
