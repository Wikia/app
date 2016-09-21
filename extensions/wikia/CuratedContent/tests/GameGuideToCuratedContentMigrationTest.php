<?php
require_once( $IP . '/extensions/wikia/CuratedContent/maintenance/GameGuideToCuratedContentHelper.php' );

class GameGuideToCuratedContentMigrationTest extends WikiaBaseTest {

	/**
	 * @param String $message
	 * @param String $input
	 * @param String $expected
	 *
	 * @dataProvider gameGuidesContentDataProvider
	 */
	public function testConvertGameGuideContentToCuratedContent( $message, $input, $expected ) {
		$this->assertEquals( $expected, GameGuideToCuratedContentHelper::ConvertGameGuideToCuratedContent( $input ), $message );
	}

	public function gameGuidesContentDataProvider() {
		return [
			[
				'empty content',
				'',
				[]
			],
			[
				'simple one',
				// GameGuide Content
				[
					0 =>
						[
							'title' => 'awfaw',
							'image_id' => 0,
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
											'label' => '',
											'image_id' => 0,
											'id' => 43626,
										],
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
											'label' => '',
											'image_id' => 0,
											'id' => 38761,
										],
								],
						],
				],
				// Curated Content
				[
					0 =>
						[
							'title' => 'awfaw',
							'image_id' => 0,
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
											'image_id' => 0,
											'article_id' => 43626,
											'type' => 'category'
										],
								],
						],
					1 =>
						[
							'title' => '',
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
				],
			],
		];
	}
}