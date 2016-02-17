<?php

class CuratedContentHooksTest extends WikiaBaseTest {

	/**
	 * @dataProvider urlsDataProvider
	 */
	public function testUrlsToPurgeCreation( $curated, $expected ) {
		$result = CuratedContentHooks::createCuratedContentUrlsPurgeList( $curated );
		$this->assertEquals( $expected, $result );
	}

	public function urlsDataProvider() {
		return [
			[
				[ ],
				[
					'http://localhost/wikia.php?controller=CuratedContent&method=getList',
					'http://localhost/wikia.php?controller=CuratedContent&method=getData'
				]
			],
			[
				[
					[
						'label' => 'Mobs',
						'image_id' => 58472,
						'items' => [
							[
								'title' => 'Category:Mobs',
								'label' => 'Mobs',
								'image_id' => 5218,
								'type' => 'category',
								'article_id' => 5218,
							],
						],
					],
					[
						'label' => 'Gameplay',
						'image_id' => 2418,
						'items' => [
							[
								'title' => 'Category:Gameplay',
								'label' => 'Gameplay',
								'image_id' => 5944,
								'type' => 'category',
								'article_id' => 5944,
							],
						],
					]
				],
				[
					'http://localhost/wikia.php?controller=CuratedContent&method=getList',
					'http://localhost/wikia.php?controller=CuratedContent&method=getData',
					'http://localhost/wikia.php?controller=CuratedContent&method=getList&section=Mobs',
					// this is caused by unique method run on rawurlencode and urlencode results
					// see: CuratedContentHooks.class.php:27
					4 => 'http://localhost/wikia.php?controller=CuratedContent&method=getList&section=Gameplay',
				]
			]
		];
	}
}
