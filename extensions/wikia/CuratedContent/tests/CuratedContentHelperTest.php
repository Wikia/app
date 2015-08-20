<?php
require_once( $IP . '/extensions/wikia/CuratedContent/CuratedContentHelper.class.php' );

class CuratedContentHelperTest extends WikiaBaseTest {

	/**
	 * @param array $resultExpected
	 * @param array $data
	 *
	 * @dataProvider testProcessSectionsDataProvider
	 */
	public function testProcessSections( $resultExpected, $data ) {
		$this->getMock( 'CuratedContentHelper', [ 'processCrop', 'fillItemInfo' ] );

		$this->assertEquals( $resultExpected, ( new CuratedContentHelper )->processSections( $data ) );
	}

	public function testProcessSectionsDataProvider() {
		return [
			[
				[ ],
				[ ]
			],
			[
				[ ],
				[ null, null, null ]
			],
			[
				[ ],
				[ [ ], [ ], [ ] ]
			],
			[
				[ ],
				[ ['items' => [ ] ] ]
			],
			[
				[ ['items' => [ [ ], [ ], [ ] ], 'image_id' => 0]],
				[ ['items' => [ [ ], [ ], [ ] ] ] ]
			],
			[
				[ ['items' => [ [ ], [ ], [ ] ], 'image_id' => 0], ['items' => [ [ ], [ ], [ ] ], 'image_id' => 0]],
				[ ['items' => [ [ ], [ ], [ ] ] ], ['items' => [ [ ], [ ], [ ] ] ] ]
			],
		];
	}
}
