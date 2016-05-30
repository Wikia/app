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
				[ 'map-id' => 1 ],
				true
			],
			[
				'Invalid map id parameter (id instead of map-id)',
				[ 'id' => 1 ],
				false
			],
			[
				'No map id parameter provided',
				[],
				false
			],
			[
				'Valid latitude parameter',
				[ 'map-id' => 1, 'lat' => 50.123 ],
				true
			],
			[
				'Valid latitude parameter',
				[ 'map-id' => 1, 'lat' => "50.123" ],
				true
			],
			[
				'Valid latitude parameter',
				[ 'map-id' => 1, 'lat' => "-12.345" ],
				true
			],
			[
				'Valid latitude parameter',
				[ 'map-id' => 1, 'lat' => 0x32 ],
				true
			],
			[
				'Invalid latitude parameter',
				[ 'map-id' => 1, 'lat' => '0x32' ],
				version_compare(PHP_VERSION, '7.0.0.', '>=') ? false : true # PHP7 does not cast strings to numbers
			],
			[
				'Invalid latitude parameter',
				[ 'map-id' => 1, 'lat' => 'abc' ],
				false
			],
			[
				'Valid zoom parameter',
				[ 'map-id' => 1, 'zoom' => 0 ],
				true
			],
			[
				'Valid zoom parameter',
				[ 'map-id' => 1, 'zoom' => '0' ],
				true
			],
			[
				'Invalid zoom parameter',
				[ 'map-id' => 1, 'zoom' => 'abc' ],
				false
			],
			[
				'Invalid zoom parameter',
				[ 'map-id' => 1, 'zoom' => -1 ],
				false
			],
			[
				'Invalid zoom parameter',
				[ 'map-id' => 1, 'zoom' => '-2' ],
				false
			],
			[
				'Invalid first parameter but valid second one',
				[ 'map-id' => 'abc', 'lat' => '100' ],
				false
			],
			[
				'No required parameter (map-id) but valid second one',
				[ 'lat' => '100' ],
				false
			],
		];
	}

	/**
	 * @dataProvider sanitizeParserTagArgumentsDataProvider
	 */
	public function testSanitizeParserTagArguments( $message, $tagArgs, $expected ) {
		$parserTagController = new WikiaMapsParserTagController();
		$this->assertEquals(
			$expected,
			$parserTagController->sanitizeParserTagArguments( $tagArgs ),
			$message
		);
	}

	public function sanitizeParserTagArgumentsDataProvider() {
		return [
			[
				'Invalid tag attribute get mapped to an empty array',
				[ 'id' => 1 ],
				[],
			],
			[
				'Valid map-id tag attribute gets mapped to an id',
				[ 'map-id' => 1 ],
				[ 'id' => 1 ],
			],
		];
	}

}
