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
	 * @bool Language|null
	 */
	private function getLanguageMock( $isRTL ) {
		if ( is_bool( $isRTL ) ) {
			return $this->mockClassWithMethods( 'Language', ['isRTL' => $isRTL] );
		}
		else {
			return null;
		}
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
}
