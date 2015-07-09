<?php

class MercuryApiTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/MercuryApi/MercuryApi.setup.php";
		parent::setUp();
	}

	/**
	 * @dataProvider getCuratedContentSectionsDataProvider
	 */
	public function testGetCuratedContentSections( $expected, $data ) {
		$mercuryApi = new MercuryApi();
		$this->assertEquals( $expected, $mercuryApi->getCuratedContentSections( $data ) );
	}

	public function getCuratedContentSectionsDataProvider() {
		return [
			[
				'$expected' => [ ],
				'$data' => [ ]
			],
			[
				'$expected' => [
					[
						'title' => 'Curated Content Section',
						'image_id' => 1024,
						'image_url' => 'image_url_0',
						'type' => 'section',
					],
					[
						'title' => 'Another Curated Content Section',
						'image_id' => 2048,
						'image_url' => 'image_url_2',
						'type' => 'section',
					],
				],
				'$data' => [
					'sections' => [
						[
							'title' => 'Curated Content Section',
							'image_id' => 1024,
							'image_url' => 'image_url_0',
						],
						[
							'title' => 'Another Curated Content Section',
							'image_id' => 2048,
							'image_url' => 'image_url_2',
						],
					],
					'items' => [
						[
							'title' => 'Category:Category_name_0',
							'label' => 'Category Name Zero',
							'image_id' => 4096,
							'article_id' => 0,
							'type' => 'category',
							'image_url' => 'image_url_3',
						],
						[
							'title' => 'Category:Category_name_1',
							'label' => 'Category Name One',
							'image_id' => 8192,
							'article_id' => 512,
							'type' => 'category',
							'image_url' => 'image_url_4',
						],
					],
					'featured' => [
						[
							'title' => 'Article_title',
							'label' => 'Article label',
							'image_id' => 256,
							'article_id' => 128,
							'type' => 'article',
							'image_url' => 'image_url_5',
						],
						[
							'title' => 'User_blog:Warkot/Such_Post',
							'label' => 'Awesome blog post',
							'image_id' => 64,
							'article_id' => 32,
							'type' => 'blog',
							'image_url' => 'image_url_6',
						],
					],
				]
			],
			[
				'$expected' => [ ],
				'$data' => [
					'items' => [
						[
							'title' => 'Category:Category_name_2',
							'label' => 'Category Name Two',
							'image_id' => 4096,
							'article_id' => 0,
							'type' => 'category',
							'image_url' => 'image_url_6',
						],
					],
				]
			]
		];
	}
}
