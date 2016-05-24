<?php

/**
 * @group TitleBatch
 */
class TitleBatchTest extends WikiaBaseTest {

	// This test cover constructor, getArticlesIds and check exact behaviour of getWikiaProperties
	public function testGetWikiaPropertiesShouldOnlyReturnPropertiesForTitlesThatContains() {

		$expectedProperty = 17;
		$expectedId1 = 1;
		$expectedId2 = 124;
		$expectedId3 = 1243;

		$expectedPropValue1 = 'a';
		$expectedPropValue2 = 'b';
		$expectedPropValue3 = null;

		$expectedIds = [ $expectedId1, $expectedId2, $expectedId3 ];

		$titles = [ ];
		foreach ( $expectedIds as $titleId ) {
			$titles[] = $this->getTestTitle( $titleId );
		}

		$mockDb = $this->getMockBuilder( '\DatabaseMysqli' )
			->disableOriginalConstructor()
			->setMethods( [ 'select' ] )
			->getMock();

		$fields = [ 'p' => 'page', 'pp' => 'page_wikia_props' ];
		$table = [ 'p.page_id, pp.propname, pp.props' ];
		$cond = [ 'p.page_id = pp.page_id',
			'pp.propname' => $expectedProperty,
			'p.page_id' => $expectedIds ];

		$result = [
			(object)[ 'page_id' => $expectedId1, 'propname' => $expectedProperty, 'props' => serialize( $expectedPropValue1 ) ],
			(object)[ 'page_id' => $expectedId2, 'propname' => $expectedProperty, 'props' => serialize( $expectedPropValue2 ) ],
		];

		$mockDb->expects( $this->once() )
			->method( 'select' )
			->with( $fields, $table, $cond, 'TitleBatch::getWikiaProperties' )
			->will( $this->returnValue( $result ) );

		$this->mockGlobalFunction( 'wfGetDB', $mockDb );

		var_dump('mocked wfGetDB', wfGetDB( DB_SLAVE ), 'mocked DB', $mockDb );

		$titleBatch = new TitleBatch( $titles );
		$props = $titleBatch->getWikiaProperties( $expectedProperty );

		$this->assertEquals( $expectedPropValue1, $props[ $expectedId1 ] );
		$this->assertEquals( $expectedPropValue2, $props[ $expectedId2 ] );
		$this->assertEquals( $expectedPropValue3, $props[ $expectedId3 ] );
	}


	/**
	 * @param $titleId
	 * @return Title
	 */
	private function getTestTitle( $titleId ) {
		$title = $this->getMock( 'Title', [ 'getArticleID' ] );
		$title->expects( $this->any() )
			->method( 'getArticleID' )
			->willReturn( $titleId );
		return $title;
	}

}
