<?php

use PHPUnit\Framework\Constraint\ArraySubset;
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

	public function testGetCityId() {
		$this->assertEquals( static::TEST_CITY_ID, $this->themeSettings->getCityId() );
	}

	public function testNotValidSettingKeysAreNotSet() {
		$settings = [
			'foo' => 'bar',
			'baz',
			'karamba' => 5
		];

		$constraint = $this->logicalNot( new ArraySubset( $settings ) );

		$this->themeSettingsPersistence->expects( $this->once() )
			->method( 'saveSettings' )
			->with( $constraint );

		$this->themeSettings->saveSettings( $settings );
	}

	/**
	 * Regression test for SUS-3104
	 * All valid default setting keys must be settable even if their default value is falsy
	 */
	public function testValidSettingKeysAreSet() {
		$settings = [
			'background-image-height' => 1000,
			'background-image-width' => 1000,
			'wordmark-text' => 'foo'
		];

		$this->themeSettingsPersistence->expects( $this->once() )
			->method( 'saveSettings' )
			->with( new ArraySubset( $settings ) );

		$this->themeSettings->saveSettings( $settings );
	}

	/**
	 * @dataProvider provideOpacityValues
	 *
	 * @param mixed $userProvidedValue
	 * @param int $expectedValue
	 */
	public function testOpacityValidation( $userProvidedValue, int $expectedValue ) {
		$settings = [
			'page-opacity' => $userProvidedValue
		];

		$this->themeSettingsPersistence->expects( $this->once() )
			->method( 'saveSettings' )
			->with( new ArraySubset( [ 'page-opacity' => $expectedValue ] ) );

		$this->themeSettings->saveSettings( $settings );
	}

	public function provideOpacityValues(): array {
		return [
			'valid opacity' => [ 75, 75 ],
			'opacity below 50' => [ 25, 50 ],
			'non-numeric opacity' => [ 'alamakota', 50 ]
		];
	}

	/**
	 * @dataProvider provideEmptyWordmarkText
	 * @param $userProvidedWordMarkValue
	 */
	public function testEmptyWordmarkTextIsNotValid( $userProvidedWordMarkValue ) {
		$settings = [ 'wordmark-text' => $userProvidedWordMarkValue ];

		$constraint = $this->logicalNot( $this->arrayHasKey( 'wordmark-text' ) );

		$this->themeSettingsPersistence->expects( $this->once() )
			->method( 'saveSettings' )
			->with( $constraint );

		$this->themeSettings->saveSettings( $settings );
	}

	public function provideEmptyWordmarkText(): Generator {
		yield [ '' ];
		yield [ [] ];
	}

	/**
	 * @dataProvider  provideValidColorVars
	 *
	 * @param $varName
	 * @param $colorValue
	 */
	public function testValidColorsAreAcceptedForColorVars( $varName, $colorValue ) {
		$settings = [ $varName => $colorValue ];

		$this->themeSettingsPersistence->expects( $this->once() )
			->method( 'saveSettings' )
			->with( new ArraySubset( $settings ) );

		$this->themeSettings->saveSettings( $settings );
	}

	public function provideValidColorVars(): Generator {
		$validColors = ThemeDesignerHelper::COLORS + [ '#000', '#CCCCCC' ];
		$colorVars = array_slice( ThemeDesignerHelper::getColorVars(), 0, 5 );

		foreach ( $colorVars as $varName => $defaultValue ) {
			foreach ( $validColors as $colorValue ) {
				yield [ $varName, $colorValue ];
			}
		}
	}

	/**
	 * @dataProvider provideNotValidColorVars
	 *
	 * @param $varName
	 * @param $defaultValue
	 * @param $colorValue
	 */
	public function testNotValidColorsAreRejectedForColorVars( $varName, $defaultValue, $colorValue ) {
		$settings = [ $varName => $colorValue ];

		$this->themeSettingsPersistence->expects( $this->once() )
			->method( 'saveSettings' )
			->with( new ArraySubset( [ $varName => $defaultValue ] ) );

		$this->themeSettings->saveSettings( $settings );
	}

	public function provideNotValidColorVars(): Generator {
		$notValidColors = [ 'foo', 'bar', 'baz', 0, [] ];
		$colorVars = array_slice( ThemeDesignerHelper::getColorVars(), 0, 5 );

		foreach ( $colorVars as $varName => $defaultValue ) {
			foreach ( $notValidColors as $colorValue ) {
				yield [ $varName, $defaultValue, $colorValue ];
			}
		}
	}

	public function testGetSettingsSetsSaneDefaultForVars() {
		$settings = [
			'color-body' => 'aliceblue',
			'color-buttons' => 'ghostwhite',
		];

		$this->themeSettingsPersistence->expects( $this->any() )
			->method( 'getSettings' )
			->willReturn( $settings );

		$themeSettings = $this->themeSettings->getSettings();

		$this->assertArrayHasKey( 'background-fixed', $themeSettings );
		$this->assertFalse( $themeSettings['background-fixed'] );

		$this->assertEquals( 'ghostwhite', $themeSettings['color-community-header'] );
	}

	public function testSettingsAreEscaped() {
		$settings = [
			'wordmark-text' => '<div>test</div>',
		];

		$this->themeSettingsPersistence->expects( $this->once() )
			->method( 'saveSettings' )
			->with( new ArraySubset( [ 'wordmark-text' => '&lt;div&gt;test&lt;/div&gt;'] ) );

		$this->themeSettings->saveSettings( $settings );
	}

	public function testSettingsAreNotEscapedTwice() {
		$settings = [
			'wordmark-text' => '&lt;div&gt;test&lt;/div&gt;',
		];

		$this->themeSettingsPersistence->expects( $this->once() )
			->method( 'saveSettings' )
			->with( new ArraySubset( [ 'wordmark-text' => '&lt;div&gt;test&lt;/div&gt;'] ) );

		$this->themeSettings->saveSettings( $settings );
	}
}
