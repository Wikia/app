<?php
require_once( $IP . '/extensions/wikia/CuratedContent/CuratedContentValidator.class.php' );

class CuratedContentValidatorTest extends WikiaBaseTest {

	/**
	 * @param array $data
	 * @param array $errorsExpected
	 *
	 * @dataProvider testValidationDataProvider
	 */
	public function testValidation( $errorsExpected, $data, $brokenValidationMessage ) {
		$this->assertEquals( $errorsExpected, ( new CuratedContentValidator )->validateData( $data ), $brokenValidationMessage );
	}

	public function testValidationDataProvider() {
		return [
			[
				// Featured all is ok
				[
				],
				[
					[
						'title' => 'Featured Content',
						'image_id' => 0,
						'featured' => true,
						'items' => [
							[
								'title' => 'Featured Title 01',
								'label' => 'Featured Label 01',
								'image_id' => '1',
								'article_id' => '1',
								'type' => 'file',
							],
							[
								'title' => 'Featured Title 02',
								'label' => 'Featured Label 02',
								'image_id' => '2',
								'article_id' => '2',
								'type' => 'blog',
							],
							[
								'title' => 'Featured Title 03',
								'label' => 'Featured Label 03',
								'image_id' => '3',
								'type' => 'category',
							],
							[
								'title' => 'Featured Title 04',
								'label' => 'Featured Label 04',
								'image_id' => '4',
								'article_id' => '4',
								'type' => 'video',
								'video_info' => [
									'provider' => 'youtube',
								],
							],
						],
					],
				],
				'All should be ok',
			],
			[
				// Featured - tooLongLabel
				[
					[
						'title' => 'Featured Title Long',
						'reason' => 'tooLongLabel',
					],
				],
				[
					[
						'title' => 'Featured Content',
						'image_id' => 0,
						'featured' => true,
						'items' => [
							[
								'title' => 'Featured Title Long',
								'label' => 'FEATURED LABEL THAT IS TOO LONG - FEATURED LABEL THAT IS TOO LONG - FEATURED LABEL THAT IS TOO LONG',
								'image_id' => '1',
								'article_id' => '1',
								'type' => 'blog',
							],
						],
					],
				],
				'tooLongLabel',
			],
			[
				// Featured - emptyLabel
				[
					[
						'title' => 'Featured Title For Empty Label',
						'reason' => 'emptyLabel',
					],
				],
				[
					[
						'title' => 'Featured Content',
						'image_id' => 0,
						'featured' => true,
						'items' => [
							[
								'title' => 'Featured Title For Empty Label',
								'label' => '',
								'image_id' => '1',
								'article_id' => '1',
								'type' => 'category',
							],
						],
					],
				],
				'emptyLabel',
			],
			[
				// Featured - imageMissing
				[
					[
						'title' => 'Featured Title Without Image',
						'reason' => 'imageMissing',
					],
				],
				[
					[
						'title' => 'Featured Content',
						'image_id' => 0,
						'featured' => true,
						'items' => [
							[
								'title' => 'Featured Title Without Image',
								'label' => 'Featured Label Without Image',
								'image_id' => '0',
								'article_id' => '1',
								'type' => 'file',
							],
						],
					],
				],
				'imageMissing',
			],
			[
				// Featured - notSupportedType
				[
					[
						'title' => 'Featured Title Not Supported',
						'reason' => 'notSupportedType',
					],
				],
				[
					[
						'title' => 'Featured Content',
						'image_id' => 0,
						'featured' => true,
						'items' => [
							[
								'title' => 'Featured Title Not Supported',
								'label' => 'Featured Label Not Supported',
								'image_id' => '1',
								'article_id' => '1',
								'type' => null,
							],
						],
					],
				],
				'notSupportedType',
			],
			[
				// Featured - videoNotHaveInfo
				[
					[
						'title' => 'Featured Title Video Without Info',
						'reason' => 'videoNotHaveInfo',
					],
				],
				[
					[
						'title' => 'Featured Content',
						'image_id' => 0,
						'featured' => true,
						'items' => [
							[
								'title' => 'Featured Title Video Without Info',
								'label' => 'Featured Label Video Without Info',
								'image_id' => '1',
								'article_id' => '1',
								'type' => 'video',
							],
						],
					],
				],
				'videoNotHaveInfo',
			],
			[
				// Featured - videoNotSupportProvider
				[
					[
						'title' => 'Featured Title Video Not Supported Provider',
						'reason' => 'videoNotSupportProvider',
					],
				],
				[
					[
						'title' => 'Featured Content',
						'image_id' => 0,
						'featured' => true,
						'items' => [
							[
								'title' => 'Featured Title Video Not Supported Provider',
								'label' => 'Featured Label Video Not Supported Provider',
								'image_id' => '1',
								'article_id' => '1',
								'type' => 'video',
								'video_info' => [
									'provider' => 'Not supported provider',
								]
							],
						],
					],
				],
				'videoNotSupportProvider',
			],
			[
				// Featured - articleNotFound
				[
					[
						'title' => 'Featured Title Without Article',
						'reason' => 'articleNotFound',
					],
				],
				[
					[
						'title' => 'Featured Content',
						'image_id' => 0,
						'featured' => true,
						'items' => [
							[
								'title' => 'Featured Title Without Article',
								'label' => 'Featured Label Without Article',
								'image_id' => '1',
								'article_id' => '0',
								'type' => 'article',
							],
						],
					],
				],
				'articleNotFound',
			],
			[
				// Normal sections all is ok
				[
					// empty errors array
				],
				[
					[
						'title' => 'Another Featured Section Without Items',
						'image_id' => '0',
						'featured' => 'true',
						'items' => [
						],
					],
					[
						'title' => 'Section 01',
						'image_id' => '1',
						'items' => [
							[
								'title' => 'Section 01 Title 01',
								'label' => 'Section 01 Label 01',
								'image_id' => '1',
								'type' => 'category',
							],
						],
					],
					[
						'title' => 'Section 02',
						'image_id' => '1',
						'items' => [
							[
								'title' => 'Section 02 Title 01',
								'label' => 'Section 02 Label 01',
								'image_id' => '1',
								'type' => 'category',
							],
							[
								'title' => 'Section 02 Title 02',
								'label' => 'Section 02 Label 02',
								'image_id' => '2',
								'type' => 'category',
							],
						],
					],
					[
						// optional section
						'title' => '',
						'image_id' => '0',
						'items' => [
							[
								'title' => 'Section Optional Title 01',
								'label' => 'Section Optional Label 01',
								'image_id' => '1',
								'type' => 'category',
							],
							[
								'title' => 'Section Optional Title 02',
								'label' => 'Section Optional Label 02',
								'image_id' => '2',
								'type' => 'category',
							],
							[
								'title' => 'Featured Title 03',
								'label' => 'Featured Label 03',
								'image_id' => '3',
								'type' => 'category',
							],
						],
					],
				],
				'All should be ok',
			],
			[
				// Normal sections  - tooLongLabel
				[
					[
						'title' => 'TOO LONG LABEL - TOO LONG LABEL - TOO LONG LABEL - TOO LONG LABEL - TOO LONG LABEL - TOO LONG LABEL',
						'reason' => 'tooLongLabel',
					],
				],
				[
					[
						'title' => 'TOO LONG LABEL - TOO LONG LABEL - TOO LONG LABEL - TOO LONG LABEL - TOO LONG LABEL - TOO LONG LABEL',
						'image_id' => '1',
						'items' => [
							[
								'title' => 'Section 01 Title 01',
								'label' => 'Section 01 Label 01',
								'image_id' => '1',
								'type' => 'category',
							],
						],
					],
				],
				'tooLongLabel',
			],
			[
				// Normal sections  - duplicatedLabel (1)
				[
					[
						'title' => 'Section Duplicated Title',
						'reason' => 'duplicatedLabel',
					],
				],
				[
					[
						'title' => 'Section Duplicated Title',
						'image_id' => '1',
						'items' => [
							[
								'title' => 'Section 01 Title 01',
								'label' => 'Section 01 Label 01',
								'image_id' => '1',
								'type' => 'category',
							],
						],
					],
					[
						'title' => 'Section Duplicated Title',
						'image_id' => '1',
						'items' => [
							[
								'title' => 'Section 02 Title 01',
								'label' => 'Section 02 Label 01',
								'image_id' => '1',
								'type' => 'category',
							],
						],
					],
				],
				'duplicatedLabel',
			],
			[
				// Normal sections  - duplicatedLabel (2)
				[
					[
						'title' => '',
						'reason' => 'duplicatedLabel',
					],
				],
				[
					[
						'title' => '',
						'image_id' => '1',
						'items' => [
							[
								'title' => 'Section 01 Title 01',
								'label' => 'Section 01 Label 01',
								'image_id' => '1',
								'type' => 'category',
							],
						],
					],
					[
						'title' => '',
						'image_id' => '1',
						'items' => [
							[
								'title' => 'Section 02 Title 01',
								'label' => 'Section 02 Label 01',
								'image_id' => '1',
								'type' => 'category',
							],
						],
					],
				],
				'duplicatedLabel',
			],
			[
				// Normal sections  - imageMissing
				[
					[
						'title' => 'Section Without Image',
						'reason' => 'imageMissing',
					],
				],
				[
					[
						'title' => 'Featured Section Without Image',
						'image_id' => '0',
						'featured' => 'true',
						'items' => [
							[
								'title' => 'Featured Section Title 01',
								'label' => 'Featured Section Label 01',
								'image_id' => '1',
								'type' => 'category',
							],
						],
					],
					[
						'title' => 'Section Without Image',
						'image_id' => '0',
						'items' => [
							[
								'title' => 'Section 01 Title 01',
								'label' => 'Section 01 Label 01',
								'image_id' => '1',
								'type' => 'category',
							],
						],
					],
					[
						// optional section without image
						'title' => '',
						'image_id' => '0',
						'items' => [
							[
								'title' => 'Optional Section Title 01',
								'label' => 'Optional Section Label 01',
								'image_id' => '1',
								'type' => 'category',
							],
						],
					],
				],
				'imageMissing',
			],
			[
				// Normal sections  - itemsMissing
				[
					[
						'title' => 'Section Without Items',
						'reason' => 'itemsMissing',
					],
				],
				[
					[
						'title' => 'Featured Section Without Items',
						'image_id' => '0',
						'featured' => 'true',
					],
					[
						'title' => 'Section Without Items',
						'image_id' => '1',
					],
					[
						// optional section without Items
						'title' => '',
						'image_id' => '0',
					],
				],
				'itemsMissing',
			],
			[
				// Normal sections  - noCategoryInTag
				[
					[
						'title' => 'Section With No Category Title 01',
						'reason' => 'noCategoryInTag',
					],
				],
				[
					[
						'title' => 'Featured Section With No Category',
						'image_id' => '0',
						'featured' => 'true',
						'items' => [
							[
								'title' => 'Featured Section Title 01',
								'label' => 'Featured Section Label 01',
								'image_id' => '1',
								'article_id' => '1',
								'type' => 'file',
							],
						],
					],
					[
						'title' => 'Section With No Category',
						'image_id' => '1',
						'items' => [
							[
								'title' => 'Section With No Category Title 01',
								'label' => 'Section With No Category Label 01',
								'image_id' => '1',
								'article_id' => '1',
								'type' => 'file',
							],
						],
					],
				],
				'noCategoryInTag',
			],
		];
	}
}
