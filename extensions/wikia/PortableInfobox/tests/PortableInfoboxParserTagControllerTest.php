<?php
use PHPUnit\Framework\TestCase;

class PortableInfoboxParserTagControllerTest extends TestCase {

	/** @var Parser */
	protected $parser;

	/** @var PortableInfoboxParserTagController */
	protected $controller;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../controllers/PortableInfoboxParserTagController.class.php';

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

	protected function containsClassName( $output, $class ) {
		$xpath = $this->getXPath( $output );

		return $xpath->query( '//aside[contains(@class, \'' . $class . '\')]' )->length > 0;
	}

	protected function getXPath( $output ) {
		$result = new DOMDocument();

		// Surpress `Warning: DOMDocument::loadHTML(): Tag aside invalid in Entity`
		// http://stackoverflow.com/questions/9149180/domdocumentloadhtml-error
		$setting = libxml_use_internal_errors( true );
		$result->loadHTML( $output );
		libxml_use_internal_errors( $setting );

		return new DOMXPath( $result );
	}

	public function testEmptyInfobox() {
		$text = '';

		$marker = $this->controller->renderInfobox( $text, [ ], $this->parser,
			$this->parser->getPreprocessor()->newFrame() )[0];
		$output = $this->controller->replaceMarkers( $marker );

		$this->assertEquals( $output, '', 'Should be empty' );
	}

	/**
	 * @dataProvider themeNamesProvider
	 */
	public function testThemes( $staticTheme, $variableTheme, $classes, $message ) {
		$text = '<data><default>test</default></data>';

		$marker = $this->controller->renderInfobox( $text,
			[ 'theme' => $staticTheme, 'theme-source' => 'testVar' ],
			$this->parser,
			$this->parser->getPreprocessor()->newCustomFrame( [ 'testVar' => $variableTheme ] ) )[0];
		$output = $this->controller->replaceMarkers( $marker );

		$this->assertTrue( array_reduce( $classes, function ( $result, $class ) use ( $output ) {
			return $result && $this->containsClassName( $output, $class );
		}, true ), $message );
	}

	public function themeNamesProvider() {
		return [
			// static theme, variable name, variable theme, [ classes ], message
			[ ' ', '', [
				PortableInfoboxParserTagController::INFOBOX_THEME_PREFIX . PortableInfoboxParserTagController::DEFAULT_THEME_NAME
			], "Should use default when theme names are invalid" ],
			[ 'test', null, [ PortableInfoboxParserTagController::INFOBOX_THEME_PREFIX . 'test' ],
				"Should contain static theme" ],
			[ null, 'variable', [
				PortableInfoboxParserTagController::INFOBOX_THEME_PREFIX . 'variable'
			], "Should contain theme from params" ],
			[ 'default', 'variable', [
				PortableInfoboxParserTagController::INFOBOX_THEME_PREFIX . 'default',
				PortableInfoboxParserTagController::INFOBOX_THEME_PREFIX . 'variable'
			], "Should contain static and param themes" ],
			[ null, null, [
				PortableInfoboxParserTagController::INFOBOX_THEME_PREFIX . PortableInfoboxParserTagController::DEFAULT_THEME_NAME
			], "Should contain default theme" ],
			[ ' test test', null, [ PortableInfoboxParserTagController::INFOBOX_THEME_PREFIX . 'test-test' ],
				"Should sanitize infobox theme name" ],
			[ "test    test\n test\ttest", null, [
				PortableInfoboxParserTagController::INFOBOX_THEME_PREFIX . 'test-test-test-test'
			], "Should sanitize multiline infobox theme name" ]
		];
	}

	/**
	 * @dataProvider getLayoutDataProvider
	 */
	public function testGetLayout( $layout, $expectedOutput, $text, $message ) {
		$marker = $this->controller->renderInfobox( $text, $layout, $this->parser,
			$this->parser->getPreprocessor()->newFrame() )[0];
		$output = $this->controller->replaceMarkers( $marker );

		$this->assertTrue( $this->containsClassName(
			$output,
			$expectedOutput
		), $message );
	}

	public function getLayoutDataProvider() {
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
	 * @dataProvider getColorDataProvider
	 */
	public function testGetColor( $params, $expectedOutput, $text, $templateInvocation, $message ) {
		$marker = $this->controller->renderInfobox( $text, $params, $this->parser,
			$this->parser->getPreprocessor()->newCustomFrame( $templateInvocation ) )[ 0 ];
		$output = $this->controller->replaceMarkers( $marker );

		$this->assertEquals($this->normalizeHTML($expectedOutput), $this->normalizeHTML($output), $message);
	}

	public function getColorDataProvider() {
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
			$this->parser->getPreprocessor()->newCustomFrame( $params ) )[0];
		$output = $this->controller->replaceMarkers( $marker );

		$result = [ ];
		$xpath = $this->getXPath( $output );
		// get all data nodes from parsed infobox
		$dataNodes = $xpath->query( '//aside/div[contains(@class,\'pi-data\')]' );
		for ( $i = 0; $i < $dataNodes->length; $i++ ) {
			// get map of label => value from parsed data node
			$result[$xpath->query( 'h3[contains(@class, \'pi-data-label\')]', $dataNodes->item( $i ) )
				->item( 0 )->nodeValue] =
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
