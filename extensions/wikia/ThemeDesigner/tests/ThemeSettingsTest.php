<?php

use PHPUnit\Framework\TestCase;

class ThemeSettingsTest extends TestCase {
	const TEST_CITY_ID = 177;

	/** @var ThemeSettingsPersistence|PHPUnit_Framework_MockObject_MockObject $themeSettingsPersistence */
	private $themeSettingsPersistence;

	/** @var ThemeSettings $themeSettings */
	private $themeSettings;

	protected function setUp() {
		parent::setUp();
		$this->themeSettingsPersistence = $this->createMock( ThemeSettingsPersistence::class );

		$this->themeSettings = new ThemeSettings( static::TEST_CITY_ID );

		// inject mock
		$reflThemeSettingsPersistence = new ReflectionProperty( ThemeSettings::class, 'themeSettingsPersistence' );
		$reflThemeSettingsPersistence->setAccessible( true );
		$reflThemeSettingsPersistence->setValue( $this->themeSettings, $this->themeSettingsPersistence );
	}

	/**
	 * Regression test for SUS-3104
	 * All valid default setting keys must be settable even if their default value is falsy
	 */
	public function testNotValidSettingKeysAreNotSet() {
		$settings = [
			'foo' => 'bar',
			'baz',
			'karamba' => 5
		];

		$constraint = $this->logicalAnd(
			$this->logicalNot( $this->arrayHasKey( 'foo' ) ),
			$this->logicalNot( $this->arrayHasKey( 'baz' ) ),
			$this->logicalNot( $this->arrayHasKey( 'karamba' ) )
		);

		$this->themeSettingsPersistence->expects( $this->once() )
			->method( 'saveSettings' )
			->with( $constraint );

		$this->themeSettings->saveSettings( $settings );
	}

	public function testValidSettingKeysAreSet() {
		$settings = [
			'background-image-height' => 1000,
			'background-image-width' => 1000,
			'wordmark-text' => 'foo'
		];

		$this->themeSettingsPersistence->expects( $this->once() )
			->method( 'saveSettings' )
			->with( $settings );

		$this->themeSettings->saveSettings( $settings );
	}

	/**
	 * @dataProvider provideOpacityValues
	 *
	 * @param int $userProvidedValue
	 * @param int $expectedValue
	 */
	public function testOpacityValidation( int $userProvidedValue, int $expectedValue ) {
		$settings = [
			'page-opacity' => $userProvidedValue
		];

		$this->themeSettingsPersistence->expects( $this->once() )
			->method( 'saveSettings' )
			->with( [ 'page-opacity' => $expectedValue ] );

		$this->themeSettings->saveSettings( $settings );
	}

	public function provideOpacityValues() {
		return [
			'valid opacity' => [ 75, 75 ],
			'opacity below 50' => [ 25, 50 ],
			'non-numeric opacity' => [ 'alamakota', 50 ]
		];
	}


}
