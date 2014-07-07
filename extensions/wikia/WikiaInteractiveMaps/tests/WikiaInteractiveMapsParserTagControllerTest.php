<?php
require_once( $IP . '/extensions/wikia/WikiaInteractiveMaps/controllers/WikiaInteractiveMapsParserTagController.class.php' );

class WikiaInteractiveMapsParserTagControllerTest extends WikiaBaseTest {

	/**
	 * @dataProvider validateParseTagParamsDataProvider
	 */
	public function testValidateParseTagParams( $message, $params, $expected ) {
		$errorMessage = '';
		$parserTagController = new WikiaInteractiveMapsParserTagController();
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
				'Valid width parameter',
				[ 'id' => 1, 'zoom' => 100 ],
				true
			],
			[
				'Valid width parameter',
				[ 'id' => 1, 'zoom' => '100' ],
				true
			],
			[
				'Invalid width parameter',
				[ 'id' => 1, 'width' => 0 ],
				false
			],
			[
				'Invalid width parameter',
				[ 'id' => 1, 'width' => '100px' ],
				false
			],
			[
				'Invalid width parameter',
				[ 'id' => 1, 'width' => '-200' ],
				false
			],
			[
				'Invalid width parameter',
				[ 'id' => 1, 'width' => 'abc' ],
				false
			],
			[
				'Invalid first parameter but valid second one',
				[ 'id' => 'abc', 'width' => '100' ],
				false
			],
		];
	}

}
