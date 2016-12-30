<?php

class PortableInfoboxParserTagControllerTest extends WikiaBaseTest {

	/** @var Parser */
	protected $parser;

	/** @var PortableInfoboxParserTagController */
	protected $controller;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
		$this->parser = $this->setUpParser();
		$this->controller = new PortableInfoboxParserTagController();
	}

	protected function tearDown() {
		// we use libxml only for tests here
		libxml_clear_errors();
		parent::tearDown();
	}

	protected function setUpParser() {
		$parser = new Parser();
		$options = new ParserOptions();
		$title = Title::newFromText( 'Test' );
		$parser->Options( $options );
		$parser->startExternalParse( $title, $options, 'text', true );

		return $parser;
	}

	/**
	 * @param $html
	 * @return string
	 */
	private function normalizeHTML( $html ) {
		$DOM = new DOMDocument( '1.0' );
		$DOM->formatOutput = true;
		$DOM->preserveWhiteSpace = false;
		$DOM->loadXML( $html );

		return $DOM->saveXML();
	}

	protected function checkClassName( $output, $class ) {
		$xpath = $this->getXPath( $output );

		return $xpath->query( '//aside[contains(@class, \'' . $class . '\')]' )->length > 0 ? true : false;
	}

	protected function getXPath( $output ) {
		$result = new DOMDocument();
		$result->loadHTML( $output );

		return new DOMXPath( $result );
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
			PortableInfoboxParserTagController::INFOBOX_THEME_PREFIX . $defaultTheme
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
			PortableInfoboxParserTagController::INFOBOX_THEME_PREFIX . $themeName
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
			PortableInfoboxParserTagController::INFOBOX_THEME_PREFIX . $defaultTheme
		) );
	}

	public function testNoThemeInfobox() {
		$text = '<data><default>test</default></data>';

		$marker = $this->controller->renderInfobox( $text, [ ], $this->parser,
			$this->parser->getPreprocessor()->newFrame() )[ 0 ];
		$output = $this->controller->replaceMarkers( $marker );

		$this->assertTrue( $this->checkClassName(
			$output,
			PortableInfoboxParserTagController::INFOBOX_THEME_PREFIX . PortableInfoboxParserTagController::DEFAULT_THEME_NAME
		) );
	}

	public function testWhiteSpacedThemeInfobox() {
		$text = '<data><default>test</default></data>';
		$defaultTheme = 'test test';
		$expectedName = 'test-test';

		$marker = $this->controller->renderInfobox( $text, [ 'theme' => $defaultTheme ], $this->parser,
			$this->parser->getPreprocessor()->newFrame() )[ 0 ];
		$output = $this->controller->replaceMarkers( $marker );

		$this->assertTrue( $this->checkClassName(
			$output,
			PortableInfoboxParserTagController::INFOBOX_THEME_PREFIX . $expectedName
		) );
	}

	public function testMultiWhiteSpacedThemeInfobox() {
		$text = '<data><default>test</default></data>';
		$defaultTheme = "test    test\n test\ttest";
		$expectedName = 'test-test-test-test';

		$marker = $this->controller->renderInfobox( $text, [ 'theme' => $defaultTheme ], $this->parser,
			$this->parser->getPreprocessor()->newFrame() )[ 0 ];
		$output = $this->controller->replaceMarkers( $marker );

		$this->assertTrue( $this->checkClassName(
			$output,
			PortableInfoboxParserTagController::INFOBOX_THEME_PREFIX . $expectedName
		) );
	}

	/**
	 * @dataProvider testGetLayoutDataProvider
	 */
	public function testGetLayout( $layout, $expectedOutput, $text, $message ) {
		$marker = $this->controller->renderInfobox( $text, $layout, $this->parser,
			$this->parser->getPreprocessor()->newFrame() )[ 0 ];
		$output = $this->controller->replaceMarkers( $marker );

		$this->assertTrue( $this->checkClassName(
			$output,
			$expectedOutput,
			$message
		) );
	}

	public function testGetLayoutDataProvider() {
		return [
			[
				'layout' => [ 'layout' => 'stacked' ],
				'expectedOutput' => 'pi-layout-stacked',
				'text' => '<data><default>test</default></data>',
				'message' => 'set stacked layout'
			],
			[
				'layout' => [ 'layout' => 'looool' ],
				'expectedOutput' => 'pi-layout-default',
				'text' => '<data><default>test</default></data>',
				'message' => 'invalid layout name'
			],
			[
				'layout' => [ 'layout' => '' ],
				'expectedOutput' => 'pi-layout-default',
				'text' => '<data><default>test</default></data>',
				'message' => 'layout is empty string'
			],
			[
				'layout' => [ 'layout' => 5 ],
				'expectedOutput' => 'pi-layout-default',
				'text' => '<data><default>test</default></data>',
				'message' => 'layout is an integer'
			],
			[
				'layout' => [ 'layout' => [ ] ],
				'expectedOutput' => 'pi-layout-default',
				'text' => '<data><default>test</default></data>',
				'message' => 'layout an empty table'
			],
			[
				'layout' => [ ],
				'expectedOutput' => 'pi-layout-default',
				'text' => '<data><default>test</default></data>',
				'message' => 'layout is not set'
			]
		];
	}

	/**
	 * @dataProvider testGetColorDataProvider
	 */
	public function testGetColor( $params, $expectedOutput, $text, $templateInvocation, $message ) {
		$marker = $this->controller->renderInfobox( $text, $params, $this->parser,
			$this->parser->getPreprocessor()->newCustomFrame( $templateInvocation ) )[ 0 ];
		$output = $this->controller->replaceMarkers( $marker );

		$this->assertEquals($this->normalizeHTML($expectedOutput), $this->normalizeHTML($output), $message);
	}

	public function testGetColorDataProvider() {
		return [
			[
				'params' => [ 'accent-color-default' => '#fff' ],
				'expectedOutput' => '<aside class="portable-infobox pi-background pi-theme-wikia pi-layout-default">
										<h2 class="pi-item pi-item-spacing pi-title" style="background-color:#fff;">test</h2>
									</aside>',
				'text' => '<title><default>test</default></title>',
				'templateInvocation' => [],
				'message' => 'accent-color-default set'
			],
			[
				'params' => [ 'accent-color-source' => 'color-source' ],
				'expectedOutput' => '<aside class="portable-infobox pi-background pi-theme-wikia pi-layout-default">
										<h2 class="pi-item pi-item-spacing pi-title" style="background-color:#000;">test</h2>
									</aside>',
				'text' => '<title><default>test</default></title>',
				'templateInvocation' => [
					'color-source' => '#000'
				],
				'message' => 'accent-color-source set'
			],
			[
				'params' => [
					'accent-color-default' => '#fff' ,
					'accent-color-source' => 'color-source'
				],
				'expectedOutput' => '<aside class="portable-infobox pi-background pi-theme-wikia pi-layout-default">
										<h2 class="pi-item pi-item-spacing pi-title" style="background-color:#000;">test</h2>
									</aside>',
				'text' => '<title><default>test</default></title>',
				'templateInvocation' => [
					'color-source' => '#000'
				],
				'message' => 'accent-color-default and accent-color-source set'
			],
			[
				'params' => [ 'accent-color-text-default' => '#fff' ],
				'expectedOutput' => '<aside class="portable-infobox pi-background pi-theme-wikia pi-layout-default">
										<h2 class="pi-item pi-item-spacing pi-title" style="color:#fff;">test</h2>
									</aside>',
				'text' => '<title><default>test</default></title>',
				'templateInvocation' => [],
				'message' => 'accent-color-text-default set'
			],
			[
				'params' => [
					'accent-color-text-default' => '#fff' ,
					'accent-color-text-source' => 'color-source'
				],
				'expectedOutput' => '<aside class="portable-infobox pi-background pi-theme-wikia pi-layout-default">
										<h2 class="pi-item pi-item-spacing pi-title" style="color:#000;">test</h2>
									</aside>',
				'text' => '<title><default>test</default></title>',
				'templateInvocation' => [
					'color-source' => '#000'
				],
				'message' => 'accent-color-text-source set'
			],
			[
				'params' => [
					'accent-color-text-default' => '#fff' ,
					'accent-color-text-source' => 'color-source'
				],
				'expectedOutput' => '<aside class="portable-infobox pi-background pi-theme-wikia pi-layout-default">
										<h2 class="pi-item pi-item-spacing pi-title" style="color:#000;">test</h2>
									</aside>',
				'text' => '<title><default>test</default></title>',
				'templateInvocation' => [
					'color-source' => '#000'
				],
				'message' => 'accent-color-text-default and accent-color-text-source set'
			],
			[
				'params' => [
					'accent-color-text-default' => '#fff' ,
					'accent-color-text-source' => 'color-source',
					'accent-color-default' => '#fff' ,
					'accent-color-source' => 'color-source2'
				],
				'expectedOutput' => '<aside class="portable-infobox pi-background pi-theme-wikia pi-layout-default">
										<h2 class="pi-item pi-item-spacing pi-title" style="background-color:#001;color:#000;">test</h2>
									</aside>',
				'text' => '<title><default>test</default></title>',
				'templateInvocation' => [
					'color-source' => '#000',
					'color-source2' => '#001'
				],
				'message' => 'accent-color-text-default and accent-color-text-source, accent-color-default, accent-color-source set'
			],
			[
				'params' => [
					'accent-color-text-default' => 'fff' ,
					'accent-color-text-source' => 'color-source',
					'accent-color-default' => 'fff' ,
					'accent-color-source' => 'color-source2'
				],
				'expectedOutput' => '<aside class="portable-infobox pi-background pi-theme-wikia pi-layout-default">
										<h2 class="pi-item pi-item-spacing pi-title" style="background-color:#001;color:#000;">test</h2>
									</aside>',
				'text' => '<title><default>test</default></title>',
				'templateInvocation' => [
					'color-source' => '000',
					'color-source2' => '001'
				],
				'message' => 'colors without #'
			],
		];
	}

	/**
	 * @dataProvider paramsDataProvider
	 */
	public function testParamsParsing( $expected, $params ) {
		$text = '<data source="0"><label>0</label></data>
    <data source="1"><label>1</label></data>
    <data source="2"><label>2</label></data>
    <data source="3"><label>3</label></data>';

		$marker = $this->controller->renderInfobox( $text, [ ], $this->parser,
			$this->parser->getPreprocessor()->newCustomFrame( $params ) )[ 0 ];
		$output = $this->controller->replaceMarkers( $marker );

		$result = [ ];
		$xpath = $this->getXPath( $output );
		// get all data nodes from parsed infobox
		$dataNodes = $xpath->query( '//aside/div[contains(@class,\'pi-data\')]' );
		for ( $i = 0; $i < $dataNodes->length; $i++ ) {
			// get map of label => value from parsed data node
			$result[ $xpath->query( 'h3[contains(@class, \'pi-data-label\')]', $dataNodes->item( $i ) )
				->item( 0 )->nodeValue ] =
				$xpath->query( 'div[contains(@class, \'pi-data-value\')]', $dataNodes->item( $i ) )
					->item( 0 )->nodeValue;
		}

		$this->assertEquals( $expected, $result );
	}

	public function paramsDataProvider() {
		return [
			[ [ 0 => 'zero', 1 => 'one', 2 => 'two' ], [ 'zero', 'one', 'two' ] ],
			[ [ 1 => 'three', 2 => 'four', 3 => 'five' ],
			  // this is actual mw way of handling params provided as "1=one|2=two|three|four|five"
			  [ '1' => 'one', '2' => 'two', 1 => 'three', 2 => 'four', 3 => 'five' ] ],
			[ [ 1 => 'one', 2 => 'two', 3 => 'three' ], [ '1' => 'one', '2' => 'two', '3' => 'three' ] ],
			[ [ 0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three' ],
			  [ '-1' => 'minus one', '0' => 'zero', '1' => 'one', '2' => 'two', '3' => 'three' ] ],
			[ [ 0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three' ],
			  [ 'abc' => 'minus one', '0' => 'zero', '1' => 'one', '2' => 'two', '3' => 'three' ] ],
		];
	}

	/**
	 * @dataProvider moveFirstMarkerToTopDataProvider
	 */
	public function testMoveFirstMarkerToTop( $markers, $text, $expected ) {
		$this->controller->markers = $markers;
		$this->controller->moveFirstMarkerToTop( $text );
		$this->assertEquals( $expected, $text );
	}

	public function moveFirstMarkerToTopDataProvider() {
		return [
			[
				'markers' => [
					'infobox-1' => '1',
					'infobox-2' => '2',
				],
				'text' => 'infobox-1 some text infobox-2',
				'expected' => 'infobox-1 some text infobox-2',
				'message' => 'first infobox already at the top'
			],
			[
				'markers' => [
					'infobox-1' => '1',
					'infobox-2' => '2',
				],
				'text' => 'some text infobox-1 infobox-2',
				'expected' => 'infobox-1 some text infobox-2',
				'message' => 'first infobox below text'
			],
			[
				'markers' => [
					'infobox-1' => '1'
				],
				'text' => 'nospaceinfobox-1',
				'expected' => 'infobox-1 nospace',
				'message' => 'no space between input elements'
			],
			[
				'markers' => [
					'infobox-1' => '1',
					'infobox-2' => '2',
				],
				'text' => 'some text
						   some more
						   infobox-1
						   more text
						   infobox-2
						   and some more',
				'expected' => 'infobox-1 some text
						   some more
						   more text
						   infobox-2
						   and some more',
				'message' => 'multiple lines'
			],
		];
	}
}
