<?php

class PortableInfoboxParserTagControllerTest extends WikiaBaseTest {

	protected function setUp() {
		parent::setUp();
		require_once( dirname( __FILE__ ) . '/../PortableInfobox.setup.php' );
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
		$output = trim( $controller->renderInfobox( $text, [ ], $parser, $frame )[0] );

		$this->assertEquals( $output, '' );
	}

	public function testNoWrappingParagraphs() {
		$this->markTestSkipped( 'DAT-2738 - awaiting decision whether this is a behavior to be fixed' );
		$text = PHP_EOL . '<infobox><pair><default>Val</default></pair></infobox>' . PHP_EOL;

		$parser = new Parser();
		$options = new ParserOptions();
		$title = Title::newFromText( 'Test' );
		$parser->Options( $options );
		$parser->startExternalParse( $title, $options, 'text', true );
		$output = $parser->parse( $text, $title, $options )->getText();

		$this->assertFalse( startsWith( trim( $output ), '<p>' ) );
		$this->assertFalse( endsWith( trim( $output ), '<p>' ) );
	}

	public function testNoPreTag() {
		$this->markTestSkipped( 'DAT-2736 - awaiting decision whether this is a behavior to be fixed' );
		$text = '<infobox><pair><default>Val</default></pair></infobox>' . PHP_EOL . ' Test';

		$parser = new Parser();
		$options = new ParserOptions();
		$title = Title::newFromText( 'Test' );
		$parser->Options( $options );
		$parser->startExternalParse( $title, $options, 'text', true );
		$output = trim( $parser->parse( $text, $title, $options, false )->getText() );

		$this->assertFalse( strpos( $output, '<pre>Test' . PHP_EOL . '</pre>' ) );
	}
}
