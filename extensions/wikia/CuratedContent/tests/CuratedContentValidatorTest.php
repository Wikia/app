<?php
require_once( $IP . '/extensions/wikia/CuratedContent/CuratedContentValidator.class.php' );

class CuratedContentValidatorTest extends WikiaBaseTest {

	/**
	 * @param array $item
	 * @param array $expectedResult
	 * @dataProvider validateFeaturedItemDataProvider
	 */
	public function testValidateFeaturedItem( $item, $expectedResult ) {
		$validator = new CuratedContentValidator();
		$result = $validator->validateFeaturedItem( $item );
		$this->assertEquals( $result, $expectedResult );
	}

	public function validateFeaturedItemDataProvider() {
		return [
			[
				['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category'],
				[]
			], [
				['article_id' => null, 'image_id' => 9, 'label' => 'foo', 'type' => 'file'],
				[CuratedContentValidator::ERR_ARTICLE_NOT_FOUND],
			], [
				['article_id' => null, 'image_id' => 9, 'label' => 'foo', 'type' => 'category'],
				[],
			], [
				['article_id' => 9, 'image_id' => 0, 'label' => 'foo', 'type' => 'category'],
				[CuratedContentValidator::ERR_IMAGE_MISSING],
			], [
				['article_id' => 9, 'image_id' => 9, 'label' => '', 'type' => 'category'],
				[CuratedContentValidator::ERR_EMPTY_LABEL],
			], [
				[
					'article_id' => 9,
					'image_id' => 9,
					'label' => 'thisisfartoolonglabelthisisfartoolonglabelthisisfartoolonglabelthisisfartoolonglabel',
					'type' => 'category'
				],
				[CuratedContentValidator::ERR_TOO_LONG_LABEL],
			], [
				['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'video', 'video_info' => [
						'provider' => 'notSupported'
					]
				],
				[CuratedContentValidator::ERR_VIDEO_NOT_SUPPORTED],
			], [
				['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'video'],
				[CuratedContentValidator::ERR_VIDEO_WITHOUT_INFO],
			], [
				['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'video', 'video_info' => [
						'provider' => 'youtube'
					]
				],
				[],
			], [
				['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'video', 'video_info' => [
						'provider' => 'ooyalaFoo'
					]
				],
				[],
			], [
				['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => ''],
				[CuratedContentValidator::ERR_NOT_SUPPORTED_TYPE],
			], [
				['article_id' => null, 'image_id' => null, 'label' => '', 'type' => ''],
				[
					CuratedContentValidator::ERR_IMAGE_MISSING,
					CuratedContentValidator::ERR_ARTICLE_NOT_FOUND,
					CuratedContentValidator::ERR_EMPTY_LABEL,
					CuratedContentValidator::ERR_NOT_SUPPORTED_TYPE,
				],
			],
		];
	}

	/**
	 * @param array $item
	 * @param array $expectedResult
	 * @dataProvider validateSectionItemDataProvider
	 */
	public function testValidateSectionItem( $item, $expectedResult ) {
		$validator = new CuratedContentValidator();
		$result = $validator->validateSectionItem( $item );
		$this->assertEquals( $result, $expectedResult );
	}

	public function validateSectionItemDataProvider() {
		return [
			[
				['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category'],
				[]
			], [
				['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'file'],
				[CuratedContentValidator::ERR_NO_CATEGORY_IN_TAG],
			], [
				['article_id' => null, 'image_id' => 9, 'label' => 'foo', 'type' => 'category'],
				[],
			], [
				['article_id' => 9, 'image_id' => 0, 'label' => 'foo', 'type' => 'category'],
				[CuratedContentValidator::ERR_IMAGE_MISSING],
			], [
				['article_id' => 9, 'image_id' => 9, 'label' => '', 'type' => 'category'],
				[CuratedContentValidator::ERR_EMPTY_LABEL],
			], [
				[
					'article_id' => 9,
					'image_id' => 9,
					'label' => 'thisisfartoolonglabelthisisfartoolonglabelthisisfartoolonglabelthisisfartoolonglabel',
					'type' => 'category'
				],
				[CuratedContentValidator::ERR_TOO_LONG_LABEL],
			], [
				['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'video', 'video_info' => [
					'provider' => 'youtube'
				]
				],
				[CuratedContentValidator::ERR_NO_CATEGORY_IN_TAG],
			], [
				['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => ''],
				[CuratedContentValidator::ERR_NOT_SUPPORTED_TYPE],
			], [
				['article_id' => null, 'image_id' => null, 'label' => '', 'type' => ''],
				[
					CuratedContentValidator::ERR_IMAGE_MISSING,
					CuratedContentValidator::ERR_EMPTY_LABEL,
					CuratedContentValidator::ERR_NOT_SUPPORTED_TYPE,
					CuratedContentValidator::ERR_ARTICLE_NOT_FOUND,
				],
			],
		];
	}

	/**
	 * @param array $section
	 * @param array $expectedResult
	 * @dataProvider validateSectionDataProvider
	 */
	public function testValidateSection( $section, $expectedResult ) {
		$validator = new CuratedContentValidator();
		$result = $validator->validateSection( $section );
		$this->assertEquals( $result, $expectedResult );
	}

	public function validateSectionDataProvider() {
		return [
			[
				['image_id' => 9, 'title' => 'foo'],
				[],
			], [
				['image_id' => 0, 'title' => 'foo'],
				[CuratedContentValidator::ERR_IMAGE_MISSING],
			], [
				['image_id' => 9, 'label' => 'foo'],
				[CuratedContentValidator::ERR_EMPTY_LABEL],
			], [
				['image_id' => 9, 'title' => ''],
				[CuratedContentValidator::ERR_EMPTY_LABEL],
			], [
				[
					'image_id' => 9,
					'title' => 'thisisfartoolonglabelthisisfartoolonglabelthisisfartoolonglabelthisisfartoolonglabel',
				],
				[CuratedContentValidator::ERR_TOO_LONG_LABEL],
			], [
				['image_id' => null, 'title' => ''],
				[
					CuratedContentValidator::ERR_EMPTY_LABEL,
					CuratedContentValidator::ERR_IMAGE_MISSING,
				],
			],
		];
	}

	/**
	 * @param array $section
	 * @param array $expectedResult
	 * @dataProvider validateSectionWithItemsDataProvider
	 */
	public function testValidateSectionWithItems( $section, $expectedResult ) {
		$validator = new CuratedContentValidator();
		$result = $validator->validateSectionWithItems( $section );
		$this->assertEquals( $result, $expectedResult );
	}

	public function validateSectionWithItemsDataProvider() {
		return [
			[
				['image_id' => 9, 'title' => 'foo', 'items' => [
					['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category'],
					['article_id' => 9, 'image_id' => 9, 'label' => 'bar', 'type' => 'category'],
				]],
				[],
			], [
				['image_id' => 9, 'title' => 'foo'],
				[CuratedContentValidator::ERR_ITEMS_MISSING],
			], [
				['image_id' => 9, 'title' => 'foo', 'items' => []],
				[CuratedContentValidator::ERR_ITEMS_MISSING],
			], [
				['image_id' => 0, 'title' => '', 'items' => []],
				[CuratedContentValidator::ERR_ITEMS_MISSING, CuratedContentValidator::ERR_OTHER_ERROR],
			], [
				['image_id' => 9, 'title' => 'foo', 'items' => [
					['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category'],
					['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category'],
				]],
				[],
			], [
				['image_id' => 9, 'title' => 'foo', 'items' => [
					['article_id' => 9, 'image_id' => 0, 'label' => 'foo', 'type' => 'category'],
				]],
				[CuratedContentValidator::ERR_OTHER_ERROR],
			],
		];
	}

	/**
	 * @param array $data
	 * @param array $expectedResult
	 * @dataProvider validateDataDataProvider
	 */
	public function testValidateData( $data, $expectedResult ) {
		$validator = new CuratedContentValidator();
		$result = $validator->validateData( $data );
		$this->assertEquals( $result, $expectedResult );
	}

	public function validateDataDataProvider() {
		return [
			[
				[],
				[]
			], [
				[['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'featured' => true, 'title' => 'foo', 'image_id' => 0]],
				[]
			], [
				[['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => '', 'image_id' => 0]],
				[]
			], [
				[['items' => [], 'featured' => true, 'title' => 'foo', 'image_id' => 0]],
				[CuratedContentValidator::ERR_OTHER_ERROR]
			], [
				[['featured' => true, 'title' => 'foo', 'image_id' => 0]],
				[CuratedContentValidator::ERR_OTHER_ERROR]
			], [
				[['items' => [], 'title' => '', 'image_id' => 0]],
				[CuratedContentValidator::ERR_OTHER_ERROR]
			], [
				[['title' => '', 'image_id' => 0]],
				[CuratedContentValidator::ERR_OTHER_ERROR]
			], [
				[['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'video']], 'featured' => true, 'title' => 'foo', 'image_id' => 0]],
				[CuratedContentValidator::ERR_OTHER_ERROR]
			], [
				[['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'video']], 'title' => '', 'image_id' => 0]],
				[CuratedContentValidator::ERR_OTHER_ERROR]
			], [
				[['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => 'foo', 'image_id' => 9]],
				[]
			], [
				[['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'notSupported']], 'title' => 'foo', 'image_id' => 0]],
				[CuratedContentValidator::ERR_OTHER_ERROR]
			], [
				[
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => 'foo', 'image_id' => 9],
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => 'bar', 'image_id' => 9]
				],
				[]
			], [
				[
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => 'foo', 'image_id' => 9],
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => 'foo', 'image_id' => 9]
				],
				[CuratedContentValidator::ERR_DUPLICATED_LABEL]
			], [
				[
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => '', 'image_id' => 9],
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => '', 'image_id' => 9]
				],
				[CuratedContentValidator::ERR_DUPLICATED_LABEL]
			], [
				[
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'featured' => true, 'title' => 'foo', 'image_id' => 0],
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => 'section', 'image_id' => 9],
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => '', 'image_id' => 0]
				],
				[]
			], [
				[
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'featured' => true, 'title' => 'foo', 'image_id' => 0],
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category'], ['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => 'section', 'image_id' => 9],
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => '', 'image_id' => 0]
				],
				[]
			], [
				[
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'featured' => true, 'title' => 'foo', 'image_id' => 0],
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category'], ['article_id' => 9, 'image_id' => 9, 'label' => 'bar', 'type' => 'category']], 'title' => 'section', 'image_id' => 9],
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => '', 'image_id' => 0]
				],
				[]
			], [
				[
					// Section with title 0 is incorrect -> image_id can't be 0
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => 0, 'image_id' => 0],
					['items' => [['article_id' => 9, 'image_id' => 9, 'label' => 'foo', 'type' => 'category']], 'title' => '', 'image_id' => 0]
				],
				[CuratedContentValidator::ERR_OTHER_ERROR]
			],
		];
	}

	/**
	 * @param array $labelsList
	 * @param boolean $expectedResult
	 * @dataProvider areLabelsUniqueDataProvider
	 */
	public function testAreLabelsUnique( $labelsList, $expectedResult ) {
		$validator = new CuratedContentValidator();
		$result = $validator->areLabelsUnique( $labelsList );
		$this->assertSame( $result, $expectedResult );
	}

	public function areLabelsUniqueDataProvider() {
		return [
			[
				['foo', 'bar', 0, false, ''],
				true
			],
			[
				['foo', 'foo'],
				false
			], [
				['', ''],
				false
			]
		];
	}

	/**
	 * @param array $items
	 * @param boolean $expectedResult
	 * @dataProvider areItemsCorrectDataProvider
	 */
	public function testAreItemsCorrect( $items, $expectedResult ) {
		$validator = new CuratedContentValidator();
		$result = $validator->areItemsCorrect( $items );
		$this->assertSame( $result, $expectedResult );
	}

	public function areItemsCorrectDataProvider() {
		return [
			[
				['foo', 'bar', 0, false, ''],
				true
			],
			[
				[],
				false
			], [
				'',
				false
			], [
				null,
				false
			]
		];
	}
}
