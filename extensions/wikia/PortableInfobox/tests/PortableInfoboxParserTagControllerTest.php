<?php

class PortableInfoboxParserTagControllerTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	public function testEmptyInfobox() {
		$text = '';
		$controller = new PortableInfoboxParserTagController();

		$parser = new Parser();
		$options = new ParserOptions();
		$title = Title::newFromText( 'Test' );
		$parser->Options( $options );
		$parser->startExternalParse( $title, $options, 'text', true );
		$frame = $parser->getPreprocessor()->newFrame();
		$marker = $controller->renderInfobox( $text, [ ], $parser, $frame )[ 0 ];
		$output = $controller->replaceMarkers( $marker );

		$this->assertEquals( $output, '' );
	}
}
