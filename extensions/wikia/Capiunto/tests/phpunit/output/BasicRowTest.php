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

class RowInfobox extends \Scribunto_LuaEngineTestBase {
	public function provideLuaData() {
		// We need to override this to prevent the parent from doing things we don't want/need
		return array();
	}

	public function testOutput() {
		$engine = $this->getEngine();
		$frame = $engine->getParser()->getPreprocessor()->newFrame();

		$title = Title::makeTitle( NS_MODULE, 'RowInfobox' );
		$this->extraModules[ $title->getPrefixedDBkey() ] = file_get_contents( __DIR__ . '/BasicRowTest.lua' );

		$module = $engine->fetchModuleFromParser( $title );

		$box = $module->invoke( 'run', $frame->newChild() );

		$this->assertValidHtmlSnippet( $box );

		$matcher = array(
			'tag' => 'table',
			'attributes' => array( 'class' => 'mw-capiunto-infobox' ),
			'descendant' => array( 'tag' => 'caption' )
		);

		$this->assertTag(
			$matcher,
			$box,
			"Basic row infobox integration test didn't create expected html"
		);

		$this->assertTrue(
			strpos( $box, "<td>\nThis+should+get+processed</td>" ) !== false,
			'Arguments should be preprocessed'
		);
	}
}
