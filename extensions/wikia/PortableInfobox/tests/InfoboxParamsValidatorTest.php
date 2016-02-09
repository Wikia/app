<?php

class InfoboxParamsValidatorTest extends WikiaBaseTest {
	private $InfoboxParamsValidator;
	private $invalidParamsExpectionName =
		'Wikia\PortableInfobox\Helpers\InvalidInfoboxParamsException';

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
}
