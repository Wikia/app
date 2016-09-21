<?php
require_once( $IP . '/extensions/wikia/GameGuides/GameGuidesController.class.php' );

class CuratedContentToGameGuidesRegressionTest extends WikiaBaseTest {

	/**
	 * @param String $message
	 * @param String $input
	 * @param String $expected
	 *
	 * @dataProvider gameGuidesContentDataProvider
	 */
	public function testConvertGameGuideContentToCuratedContent( $message, $input, $expected ) {
		$controller = new GameGuidesController();
		$this->assertEquals( $expected, $controller->curatedContentToGameGuides( $input ), $message );
	}

	public function gameGuidesContentDataProvider() {
		return [
			[
				'empty content',
				[ ],
				[ ]
			],
			[
				'simple one',
				//Curated Content
				[
					[
						'label' => 'awfaw',
						'image_id' => 7,
						'items' =>
							[
								0 =>
									[
										'title' => 'Category:Samantha Carter images',
										'label' => 'Samantha',
										'image_id' => 0,
										'article_id' => 22245,
										'type' => 'category'
									],
								1 =>
									[
										'title' => 'Category:Sun Tzu crew',
										'label' => 'Sun Tzu crew',
										'image_id' => 15,
										'article_id' => 43626,
										'type' => 'category'
									],
								2 =>
									[
										'title' => 'Kategoria:Apophis',
										'label' => 'Apophis',
										'article_id' => 43626,
										'type' => 'category'
									],
								3 =>
									[
										'title' => 'Sun Tzu',
										'label' => 'Sun Tzu',
										'image_id' => 0,
										'article_id' => 43626,
										'type' => 'article'
									],
							],
					],
					[
						'label' => '',
						'image_id' => 0,
						'items' =>
							[
								0 =>
									[
										'title' => 'Category:Carson Beckett (clone) images',
										'label' => 'Carson Beckett (clone) images',
										'image_id' => 0,
										'article_id' => 38761,
										'type' => 'category'
									],
							],
					],
					[
						'label' => '',
						'image_id' => 0,
						'items' => [ ],
					]
				],
				//GameGuide Content
				[
					0 =>
						[
							'title' => 'awfaw',
							'image_id' => 7,
							'categories' =>
								[
									0 =>
										[
											'title' => 'Samantha Carter images',
											'label' => 'Samantha',
											'image_id' => 0,
											'id' => 22245,
										],
									1 =>
										[
											'title' => 'Sun Tzu crew',
											'label' => 'Sun Tzu crew',
											'image_id' => 15,
											'id' => 43626,
										],
									2 =>
										[
											'title' => 'Apophis',
											'label' => 'Apophis',
											'image_id' => 0,
											'id' => 43626,
										]
								],
						],
					1 =>
						[
							'title' => '',
							'image_id' => 0,
							'categories' =>
								[
									0 =>
										[
											'title' => 'Carson Beckett (clone) images',
											'label' => 'Carson Beckett (clone) images',
											'image_id' => 0,
											'id' => 38761,
										],
								],
						],
					2 =>
						[
							'title' => '',
							'image_id' => 0,
							'categories' => [ ]
						],
				]
			],
		];
	}
}
