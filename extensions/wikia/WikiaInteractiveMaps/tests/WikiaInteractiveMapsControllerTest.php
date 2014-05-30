<?php
require_once( $IP . '/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMapsController.class.php' );
require_once( $IP . '/extensions/wikia/WikiaInteractiveMaps/models/WikiaMaps.class.php' );

class WikiaInteractiveMapsControllerTest extends WikiaBaseTest {

	/**
	 * @dataProvider haveNamesForAllPinTypesDataProvider
	 */
	public function testHaveNamesForAllPinTypes( $message, $input, $expected ) {
		$controller = new WikiaInteractiveMapsController();
		$controller->setCreationData( 'pinTypeNames', $input );

		$this->assertEquals( $expected, $controller->haveNamesForAllPinTypes(), $message );
	}

	public function haveNamesForAllPinTypesDataProvider() {
		return [
			[
				'Empty pin types data - valid',
				[],
				true
			],
			[
				'Correct pin types data - valid',
				[
					'Pin Type #1',
					'Pin Type #2',
					'Pin Type #3'
				],
				true
			],
			[
				'Empty pin name for first pin type - invalid',
				[
					'',
					'Pin Type #2',
					'Pin Type #3'
				],
				false
			],
			[
				'Empty pin name for second pin type - invalid',
				[
					'Pin Type #1',
					'',
					'Pin Type #3'
				],
				false
			],
			[
				'Empty pin name for last pin type - invalid',
				[
					'Pin Type #1',
					'Pin Type #2',
					''
				],
				false
			],
			[
				'Whitespace as a pin type name for one pin - invalid',
				[
					'                                  ',
					'Pin Type #2',
					'Pin Type #3'
				],
				false
			],
			[
				'Tabulation as a pin type name for one pin - invalid',
				[
					'		',
					'Pin Type #2',
					'Pin Type #3'
				],
				false
			],
		];
	}

}
