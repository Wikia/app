<?php
/**
 * @group UsingDB
 */
class WikiaMapsParserTagControllerTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaMaps/WikiaMaps.setup.php";
		parent::setUp();
	}

	/**
	 * @dataProvider validateParseTagParamsDataProvider
	 * @group WikiaParserTagController
	 */
	public function testValidateParseTagParams( $message, $params, $expected ) {
		$errorMessage = '';
		$parserTagController = new WikiaMapsParserTagController();
		$this->assertEquals(
			$expected,
			$parserTagController->validateParseTagParams( $params, $errorMessage ),
			$message
		);
	}

	public function validateParseTagParamsDataProvider() {
		return [
			[
				'Valid map id parameter',
				[ 'id' => 1 ],
				true
			],
			[
				'Invalid map id parameter (map-id instead of id)',
				[ 'map-id' => 1 ],
				false
			],
			[
				'No map id parameter provided',
				[],
				false
			],
			[
				'Valid latitude parameter',
				[ 'id' => 1, 'lat' => 50.123 ],
				true
			],
			[
				'Valid latitude parameter',
				[ 'id' => 1, 'lat' => "50.123" ],
				true
			],
			[
				'Valid latitude parameter',
				[ 'id' => 1, 'lat' => "-12.345" ],
				true
			],
			[
				'Valid latitude parameter',
				[ 'id' => 1, 'lat' => 0x32 ],
				true
			],
			[
				'Invalid latitude parameter',
				[ 'id' => 1, 'lat' => '0x32' ],
				true
			],
			[
				'Invalid latitude parameter',
				[ 'id' => 1, 'lat' => 'abc' ],
				false
			],
			[
				'Valid zoom parameter',
				[ 'id' => 1, 'zoom' => 0 ],
				true
			],
			[
				'Valid zoom parameter',
				[ 'id' => 1, 'zoom' => '0' ],
				true
			],
			[
				'Invalid zoom parameter',
				[ 'id' => 1, 'zoom' => 'abc' ],
				false
			],
			[
				'Invalid zoom parameter',
				[ 'id' => 1, 'zoom' => -1 ],
				false
			],
			[
				'Invalid zoom parameter',
				[ 'id' => 1, 'zoom' => '-2' ],
				false
			],
			[
				'Invalid first parameter but valid second one',
				[ 'id' => 'abc', 'lat' => '100' ],
				false
			],
		];
	}

}
