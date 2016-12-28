<?php

class InfoboxParamsValidatorTest extends WikiaBaseTest {
	private $InfoboxParamsValidator;
	private $invalidParamsExpectionName =
		'Wikia\PortableInfobox\Helpers\InvalidInfoboxParamsException';
	private $invalidColorValueExceptionName = 'Wikia\PortableInfobox\Helpers\InvalidColorValueException';

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();

		$this->InfoboxParamsValidator = new \Wikia\PortableInfobox\Helpers\InfoboxParamsValidator();
	}

	/**
	 * @param array $params
	 * @dataProvider testInfoboxParamsFailValidationDataProvider
	 */
	public function testInfoboxParamsFailValidation ( $params ) {
		$this->setExpectedException( $this->invalidParamsExpectionName );
		$this->InfoboxParamsValidator->validateParams( $params );
	}

	/**
	 * @param array $params
	 * @dataProvider testInfoboxParamsPassValidationDataProvider
	 */
	public function testInfoboxParamsPassValidation ( $params ) {
		$this->assertEquals( true, $this->InfoboxParamsValidator->validateParams( $params ) );
	}

	public function testInfoboxParamsFailValidationDataProvider() {
		return [
			[
				'params' => [
					'theme' => 'test',
					'abc' => 'def',
					'layout' => 'myLayout'
				]
			],
			[
				'params' => [
					'abc' => 'def',
				]
			],
		];
	}

	public function testInfoboxParamsPassValidationDataProvider() {
		return [
			[
				'params' => [],
			],
			[
				'params' => [
					'theme' => 'test',
					'theme-source' => 'loremIpsum',
					'layout' => 'myLayout'
				]
			],
			[
				'params' => [
					'theme' => 'test',
				]
			]
		];
	}

	/**
	 * @param $color
	 * @dataProvider testPassValidateColorValueDataProvider
	 */
	public function testPassValidateColorValue( $color ) {
		$this->assertTrue( $this->InfoboxParamsValidator->validateColorValue( $color ) );
	}

	public function testPassValidateColorValueDataProvider() {
		return [
			['color' => 'aaa'],
			['color' => 'abc'],
			['color' => 'a12'],
			['color' => '12f'],
			['color' => 'fff'],
			['color' => '000'],
			['color' => '999'],
			['color' => '#aaa'],
			['color' => '#abc'],
			['color' => '#a12'],
			['color' => '#12f'],
			['color' => '#fff'],
			['color' => '#000'],
			['color' => '#999'],
			['color' => 'aaaaaa'],
			['color' => 'abcabc'],
			['color' => 'a12acd'],
			['color' => '12f126'],
			['color' => 'adf129'],
			['color' => '125fff'],
			['color' => 'ffffff'],
			['color' => '000000'],
			['color' => '999999'],
			['color' => '#aaaaaa'],
			['color' => '#abcabc'],
			['color' => '#a12acd'],
			['color' => '#12f126'],
			['color' => '#adf129'],
			['color' => '#125fff'],
			['color' => '#ffffff'],
			['color' => '#000000'],
			['color' => '#999999'],
		];
	}

	/**
	 * @param array $color
	 * @dataProvider testFailValidateColorValueDataProvider
	 */
	public function testFailValidateColorValue( $color ) {
		$this->setExpectedException( $this->invalidColorValueExceptionName );
		$this->InfoboxParamsValidator->validateColorValue( $color );
	}

	public function testFailValidateColorValueDataProvider() {
		return [
			['color' => ''],
			['color' => 'ggg'],
			['color' => 'asd'],
			['color' => '12g'],
			['color' => '1k2'],
			['color' => 'l34'],
			['color' => 'aaaa'],
			['color' => 'aaag'],
			['color' => '#ggg'],
			['color' => '#asd'],
			['color' => '#12g'],
			['color' => '#1k2'],
			['color' => '#l34'],
			['color' => '#aaaa'],
			['color' => '#aaag'],
			['color' => 'aaaaa'],
			['color' => 'aaaaaaa'],
			['color' => '#aaaaaaa'],
			['color' => '#aaaaa'],
		];
	}
}
