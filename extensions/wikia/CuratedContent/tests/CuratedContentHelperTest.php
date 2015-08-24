<?php
require_once( $IP . '/extensions/wikia/CuratedContent/CuratedContentHelper.class.php' );

class CuratedContentHelperTest extends WikiaBaseTest {
	/**
	 * @param array $data
	 * @param array $resultExpected
	 *
	 * @dataProvider testRemoveEmptySectionsDataProvider
	 */
	public function testRemoveEmptySections( $data, $resultExpected ) {
		$this->assertEquals( $resultExpected, ( new CuratedContentHelper )->removeEmptySections( $data ) );
	}

	public function testRemoveEmptySectionsDataProvider() {
		return [
			[
				[ ],
				[ ]
			],
			[
				[ null, null, null ],
				[ ],
			],
			[
				[ null, [ ], null ],
				[ [ ] ],
			],
		];
	}

	/**
	 * @param array $section
	 * @param array $resultExpected
	 *
	 * @dataProvider testProcessLogicForSectionDataProvider
	 */
	public function testProcessLogicForSection( $section, $resultExpected ) {
		$this->getMock( 'CuratedContentHelper', [ 'processCrop', 'fillItemInfo' ] );

		$this->assertEquals( $resultExpected, ( new CuratedContentHelper )->processLogicForSection( $section ) );
	}

	public function testProcessLogicForSectionDataProvider() {
		return [
			// bad data - empty items
			[
				[ 'items' => [ ] ],
				null,
			],
			// good data, non-empty items
			[
				[ 'items' => [ [ ], [ ], [ ] ] ],
				[ 'items' => [ [ ], [ ], [ ] ], 'image_id' => 0 ],
			],
		];
	}

	public function testFindImageIdAndUrlWhenImageAndArticleEmpty() {
		$this->getStaticMethodMock( 'CuratedContentHelper', 'findFirstImageTitleFromArticle' )
			->expects( $this->any() )
			->method( 'findFirstImageTitleFromArticle' )
			->will( $this->returnValue( null ) );

		$this->assertEquals( CuratedContentHelper::findImageIdAndUrl(0, 0), [ 0, null] );
	}

	public function testFindImageIdAndUrlWhenArticleExists() {
		$articleId = 26;
		$expectedImageId = 13;
		$expectedImageUrl = 'foo';

		$titleMock = $this->getMockBuilder( 'Title' )
			->setMethods( [ 'getArticleID', 'exists' ] )
			->getMock();

		$titleMock->expects( $this->any() )
			->method( 'getArticleID' )
			->willReturn( $expectedImageId );

		$titleMock->expects( $this->any() )
			->method( 'exists' )
			->willReturn( true );

		$this->getStaticMethodMock( 'CuratedContentHelper', 'findFirstImageTitleFromArticle' )
			->expects( $this->any() )
			->method( 'findFirstImageTitleFromArticle' )
			->will( $this->returnValue( $titleMock ) );

		$this->getStaticMethodMock( 'CuratedContentHelper', 'getUrlFromImageTitle' )
			->expects( $this->any() )
			->method( 'getUrlFromImageTitle' )
			->will( $this->returnValue( $expectedImageUrl ) );

		$this->assertEquals( CuratedContentHelper::findImageIdAndUrl(0, $articleId), [ $expectedImageId, $expectedImageUrl ] );
	}

	public function testFindImageIdAndUrlWhenImageIdNotEmptyAndArticleIdNotEmpty() {
		$imageId = 13;
		$articleId = 26;
		$expectedImageId = 13;
		$expectedImageUrl = 'foo';

		$this->getStaticMethodMock( 'CuratedContentHelper', 'getImageUrl' )
			->expects( $this->any() )
			->method( 'getImageUrl' )
			->will( $this->returnValue( $expectedImageUrl ) );

		$this->assertEquals( CuratedContentHelper::findImageIdAndUrl($imageId, $articleId), [ $expectedImageId, $expectedImageUrl ] );
	}

	public function testFindImageIdAndUrlWhenImageIdNotEmptyAndArticleIdIsEmpty() {
		$imageId = 13;
		$expectedImageId = 13;
		$expectedImageUrl = 'foo';

		$this->getStaticMethodMock( 'CuratedContentHelper', 'getImageUrl' )
			->expects( $this->any() )
			->method( 'getImageUrl' )
			->will( $this->returnValue( $expectedImageUrl ) );

		$this->assertEquals( CuratedContentHelper::findImageIdAndUrl($imageId), [ $expectedImageId, $expectedImageUrl ] );
	}
}
