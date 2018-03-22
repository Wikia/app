<?php
use PHPUnit\Framework\TestCase;

class InfoboxParamsValidatorTest extends TestCase {
	/** @var \Wikia\PortableInfobox\Helpers\InfoboxParamsValidator $InfoboxParamsValidator */
	private $InfoboxParamsValidator;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../services/Helpers/InfoboxParamsValidator.php';

		$this->InfoboxParamsValidator = new \Wikia\PortableInfobox\Helpers\InfoboxParamsValidator();
	}

	/**
	 * @param array $params
	 * @dataProvider infoboxParamsFailValidationDataProvider
	 *
	 * @expectedException Wikia\PortableInfobox\Helpers\InvalidInfoboxParamsException
	 */
	public function testInfoboxParamsFailValidation( $params ) {
		$this->InfoboxParamsValidator->validateParams( $params );
	}

	/**
	 * @param array $params
	 * @dataProvider infoboxParamsPassValidationDataProvider
	 */
	public function testInfoboxParamsPassValidation( $params ) {
		$this->assertEquals( true, $this->InfoboxParamsValidator->validateParams( $params ) );
	}

	public function infoboxParamsFailValidationDataProvider() {
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

	public function infoboxParamsPassValidationDataProvider() {
		return [
			[
				'params' => [ ],
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
	 * @dataProvider passValidateColorValueDataProvider
	 */
	public function testPassValidateColorValue( $color ) {
		$this->assertTrue( $this->InfoboxParamsValidator->validateColorValue( $color ) );
	}

	public function passValidateColorValueDataProvider() {
		return [
			[ 'color' => '#aaa' ],
			[ 'color' => '#abc' ],
			[ 'color' => '#a12' ],
			[ 'color' => '#12f' ],
			[ 'color' => '#fff' ],
			[ 'color' => '#000' ],
			[ 'color' => '#999' ],
			[ 'color' => '#aaaaaa' ],
			[ 'color' => '#abcabc' ],
			[ 'color' => '#a12acd' ],
			[ 'color' => '#12f126' ],
			[ 'color' => '#adf129' ],
			[ 'color' => '#125fff' ],
			[ 'color' => '#ffffff' ],
			[ 'color' => '#000000' ],
			[ 'color' => '#999999' ],
		];
	}

	/**
	 * @param array $color
	 * @dataProvider failValidateColorValueDataProvider
	 */
	public function testFailValidateColorValue( $color ) {
		$this->assertFalse( $this->InfoboxParamsValidator->validateColorValue( $color ) );
	}

	public function failValidateColorValueDataProvider() {
		return [
			[ 'color' => '' ],
			[ 'color' => 'aaa' ],
			[ 'color' => 'abc' ],
			[ 'color' => 'a12' ],
			[ 'color' => '12f' ],
			[ 'color' => 'fff' ],
			[ 'color' => '000' ],
			[ 'color' => '999' ],
			[ 'color' => 'ggg' ],
			[ 'color' => 'asd' ],
			[ 'color' => '12g' ],
			[ 'color' => '1k2' ],
			[ 'color' => 'l34' ],
			[ 'color' => 'aaaa' ],
			[ 'color' => 'aaag' ],
			[ 'color' => '#ggg' ],
			[ 'color' => '#asd' ],
			[ 'color' => '#12g' ],
			[ 'color' => '#1k2' ],
			[ 'color' => '#l34' ],
			[ 'color' => '#aaaa' ],
			[ 'color' => '#aaag' ],
			[ 'color' => 'aaaaa' ],
			[ 'color' => 'aaaaaa' ],
			[ 'color' => 'abcabc' ],
			[ 'color' => 'a12acd' ],
			[ 'color' => '12f126' ],
			[ 'color' => 'adf129' ],
			[ 'color' => '125fff' ],
			[ 'color' => 'ffffff' ],
			[ 'color' => '000000' ],
			[ 'color' => '999999' ],
			[ 'color' => 'aaaaaaa' ],
			[ 'color' => '#aaaaaaa' ],
			[ 'color' => '#aaaaa' ],
		];
	}
}
