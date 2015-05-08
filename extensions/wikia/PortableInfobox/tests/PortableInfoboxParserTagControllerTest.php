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

	public function testNoPreTag() {
		$this->markTestSkipped( 'DAT-2736 - awaiting decision whether this is a behavior to be fixed' );
		$text = '<infobox><data><default>Val</default></data></infobox>' . PHP_EOL . ' Test';

		$parser = new Parser();
		$options = new ParserOptions();
		$title = Title::newFromText( 'Test' );
		$parser->Options( $options );
		$parser->startExternalParse( $title, $options, 'text', true );
		$marker = $parser->parse( $text, $title, $options, false )->getText();
		$output = $controller->replaceMarkers( $marker );

		$this->assertFalse( strpos( $output, '<pre>Test' . PHP_EOL . '</pre>' ) );
	}
}
