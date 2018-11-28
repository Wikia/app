<?php

/**
 * Set of unit tests for SassUtilTest class
 *
 * @author macbre
 */
class SassUtilTest extends WikiaBaseTest {

	/**
	 * @group UsingDB
	 */
	function testSassUtil() {
		$sassParams = SassUtil::getSassParams();

		$this->assertInternalType( 'string', $sassParams );
		$this->assertRegExp( '/&color-page=%23[A-F0-9]{6}&/i', $sassParams );
	}

	/**
	 * @dataProvider isRTLProvider
	 */
	public function testIsRTL( $userRTL, $wikiRTL, $expected ) {
		$this->mockGlobalVariable( 'wgContLang', $this->getLanguageMock( $wikiRTL ) );
		$this->mockGlobalVariable( 'wgLang', $this->getLanguageMock( $userRTL ) );

		$this->assertEquals( $expected, SassUtil::isRTL() );
	}

	/**
	 * Returns Language object mock
	 *
	 * @param bool|null $isRTL
	 * @return Language|null|PHPUnit_Framework_MockObject_MockObject
	 */
	private function getLanguageMock( $isRTL ) {
		if ( is_bool( $isRTL ) ) {
			return $this->createConfiguredMock( Language::class, [
				'isRTL' => $isRTL
			] );
		}

		return null;
	}

	public function isRTLProvider() {
		return [
			[
				'userRTL' => null,
				'wikiRTL' => null,
				'expected' => false
			],
			[
				'userRTL' => false,
				'wikiRTL' => false,
				'expected' => false
			],
			[
				'userRTL' => true,
				'wikiRTL' => false,
				'expected' => true
			],
			[
				'userRTL' => false,
				'wikiRTL' => true,
				'expected' => false
			],
			[
				'userRTL' => true,
				'wikiRTL' => true,
				'expected' => true
			],
		];
	}

	/**
	 * @dataProvider isThemeDarkProvider
	 */
	public function testIsThemeDark( $color, $isDark ) {
		$settings = [
			'color-page' => $color
		];

		$this->assertEquals( $isDark, SassUtil::isThemeDark( $settings ) );
	}

	public function isThemeDarkProvider() {
		return [
			[
				'color' => '#000000',
				'isDark' => true
			],
			[
				'color' => '#000',
				'isDark' => true
			],
			[
				'color' => '#ffffff',
				'isDark' => false
			],
			[
				'color' => '#fff',
				'isDark' => false
			],
			[
				'color' => '#ffdddd',
				'isDark' => false
			],
			[
				'color' => '#fdd',
				'isDark' => false
			],
			[
				'color' => 'white',
				'isDark' => false
			],
			[
				'color' => 'black',
				'isDark' => true
			]
		];
	}

	/**
	 * @dataProvider hexToRgb
	 *
	 * @param $hex
	 * @param $rgb
	 */
	public function testHexToRgb( $hex, $rgb ) {
		$this->assertEquals( $rgb, SassUtil::hexToRgb( $hex ) );
	}

	public function hexToRgb() {
		return [
			[ '#ffffff', [ 'r' => 255, 'g' => 255, 'b' => 255 ] ],
			[ '#00ffff', [ 'r' => 0, 'g' => 255, 'b' => 255 ] ],
			[ '#ff00ff', [ 'r' => 255, 'g' => 0, 'b' => 255 ] ],
			[ '#ffff00', [ 'r' => 255, 'g' => 255, 'b' => 0 ] ],
			[ '#fff', [ 'r' => 255, 'g' => 255, 'b' => 255 ] ],
			[ '#0ff', [ 'r' => 0, 'g' => 255, 'b' => 255 ] ],
			[ '#f0f', [ 'r' => 255, 'g' => 0, 'b' => 255 ] ],
			[ '#ff0', [ 'r' => 255, 'g' => 255, 'b' => 0 ] ],
		];
	}
}
