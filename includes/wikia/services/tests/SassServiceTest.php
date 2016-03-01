<?php

use Wikia\Sass\Compiler\LibSassCompiler;

class SassServiceTest extends WikiaBaseTest {

	private static $sassVariables = [
		'color-body' => '#112233',
	];

	/**
	 * @see https://github.com/sensational/sassphp
	 */
	public function testSassPHPInstalled() {
		$this->assertTrue( extension_loaded( 'sass' ), 'sassphp PHP extension should be installed for faster SASS parsing' );
		$this->assertTrue( class_exists( 'Sass' ), 'Sass class is available' );
	}

	public function testCompileInlineCss() {
		$css = <<<CSS
@import "skins/shared/color";
header {
	div {
		color: \$color-body;
	}
}
CSS;
		$sass = SassService::newFromString( $css );
		$sass->setSassVariables( self::$sassVariables );

		$result = $sass->getCss( false ); # no cache

		$this->assertContains( 'header div {', $result, 'CSS selector is properly compiled' );
		$this->assertContains( 'color: #112233;', $result, 'Color variable is properly passed' );
	}

	public function testCompileSassFile() {
		$sass = SassService::newFromFile( __DIR__ . '/styles/style.scss' );
		$sass->setSassVariables( self::$sassVariables );

		$result = $sass->getCss( false ); # no cache

		$this->assertContains( '@import url(/skins/wikia/shared.css);', $result, 'CSS @import statements are kept' );
		$this->assertContains( 'font-size: 13px;', $result, '@bodytext mixin is expanded' );
		$this->assertContains( 'color: #112233;', $result, 'Color variable is properly passed' );
	}

	/**
	 * @dataProvider encodeSassMapDataProvider
	 */
	public function testEncodeSassMap( Array $map, $expected ) {
		$this->assertEquals( $expected, LibSassCompiler::encodeSassMap( $map ) );
	}

	public function encodeSassMapDataProvider() {
		return [
			[
				[],
				'()'
			],
			[
				['a' => 2],
				'("a": 2)'
			],
			[
				['a' => ''],
				'("a": "")'
			],
			[
				['a' => 'foo'],
				'("a": foo)'
			],
			[
				['a' => 1, 'b' => 2],
				'("a": 1, "b": 2)'
			],
		];
	}

	/**
	 * @dataProvider quoteIfNeededDataProvider
	 * @param string $item
	 * @param string $key
	 * @param string $itemExpected
	 */
	public function testQuoteIfNeeded( $item, $key, $itemExpected ) {
		$compiler = new LibSassCompiler( [] );
		$this->assertEquals( $itemExpected, $compiler->quoteIfNeeded( $item, $key ) );
	}

	public function quoteIfNeededDataProvider() {
		return [
			[
				'#FFF', 'color', '#FFF'
			], [
				'123', 'width', 123
			], [
				'foo', 'border', '\'foo\''
			], [
				'double"quote', 'position', '\'double"quote\''
			], [
				'single\'quote', 'transform', '\'single\\\'quote\''
			]
		];
	}
}
