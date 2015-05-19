<?php

class PortableInfoboxParserTagControllerTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
		$this->parser = $this->setUpParser();
		$this->controller = new PortableInfoboxParserTagController();
	}

	protected function setUpParser() {
		$parser = new Parser();
		$options = new ParserOptions();
		$title = Title::newFromText( 'Test' );
		$parser->Options( $options );
		$parser->startExternalParse( $title, $options, 'text', true );
		return $parser;
	}

	protected function checkClassName( $output, $class ) {
		$result = new DOMDocument();
		$result->loadHTML( $output );
		$xpath = new DOMXPath( $result );
		return $xpath->query( '//aside[contains(@class, \'' . $class . '\')]' )->length > 0 ? true : false;
	}

	public function testEmptyInfobox() {
		$text = '';

		$marker = $this->controller->renderInfobox( $text, [ ], $this->parser,
			$this->parser->getPreprocessor()->newFrame() )[ 0 ];
		$output = $this->controller->replaceMarkers( $marker );

		$this->assertEquals( $output, '' );
	}

	public function testThemedInfobox() {
		$text = '<data><default>test</default></data>';
		$defaultTheme = 'test';

		$marker = $this->controller->renderInfobox( $text, [ 'theme' => $defaultTheme ], $this->parser,
			$this->parser->getPreprocessor()->newFrame() )[ 0 ];
		$output = $this->controller->replaceMarkers( $marker );

		$this->assertTrue( $this->checkClassName(
			$output,
			$defaultTheme . PortableInfoboxParserTagController::INFOBOX_THEME_SUFFIX
		) );
	}

	public function testSourceThemedInfobox() {
		$text = '<data><default>test</default></data>';
		$themeVariableName = 'variableName';
		$themeName = 'variable';

		$marker = $this->controller->renderInfobox( $text, [ 'theme-source' => $themeVariableName ], $this->parser,
			$this->parser->getPreprocessor()->newCustomFrame( [ $themeVariableName => $themeName ] ) )[ 0 ];
		$output = $this->controller->replaceMarkers( $marker );

		$this->assertTrue( $this->checkClassName(
			$output,
			$themeName . PortableInfoboxParserTagController::INFOBOX_THEME_SUFFIX
		) );
	}

	public function testEmptySourceDefaultThemedInfobox() {
		$text = '<data><default>test</default></data>';
		$themeVariableName = 'variableName';
		$themeName = 'variable';
		$defaultTheme = 'default';

		$marker = $this->controller->renderInfobox( $text,
			[ 'theme' => $defaultTheme, 'theme-source' => $themeVariableName ],
			$this->parser,
			$this->parser->getPreprocessor()->newFrame() )[ 0 ];
		$output = $this->controller->replaceMarkers( $marker );

		$this->assertTrue( $this->checkClassName(
			$output,
			$defaultTheme . PortableInfoboxParserTagController::INFOBOX_THEME_SUFFIX
		) );
	}

	public function testNoThemeInfobox() {
		$text = '<data><default>test</default></data>';

		$marker = $this->controller->renderInfobox( $text, [ ], $this->parser,
			$this->parser->getPreprocessor()->newFrame() )[ 0 ];
		$output = $this->controller->replaceMarkers( $marker );

		$this->assertTrue( $this->checkClassName(
			$output,
			PortableInfoboxParserTagController::DEFAULT_THEME_NAME . PortableInfoboxParserTagController::INFOBOX_THEME_SUFFIX
		) );
	}
}
