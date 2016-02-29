<?php

class MercuryApiArticleHandlerTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/MercuryApi/MercuryApi.setup.php";
		parent::setUp();
	}

	/**
	 * @dataProvider getArticleDataProvider
	 *
	 * @param $expected
	 * @param $articleDetailsMock
	 * @param $articleJsonMock
	 * @param $topContributorsJsonMock
	 * @param $relatedPagesMock
	 */
	public function testGetArticleData(
		$expected,
		$articleDetailsMock,
		$articleJsonMock,
		$topContributorsJsonMock,
		$relatedPagesMock
	) {
		$this->getStaticMethodMock( 'MercuryApiArticleHandler', 'getArticleDetails' )
			->expects( $this->once() )
			->method( 'getArticleDetails' )
			->will( $this->returnValue( $articleDetailsMock ) );

		$this->getStaticMethodMock( 'MercuryApiArticleHandler', 'getArticleJson' )
			->expects( $this->once() )
			->method( 'getArticleJson' )
			->will( $this->returnValue( $articleJsonMock ) );

		$this->getStaticMethodMock( 'MercuryApiArticleHandler', 'getTopContributorsDetails' )
			->expects( $this->once() )
			->method( 'getTopContributorsDetails' )
			->will( $this->returnValue( $topContributorsJsonMock ) );

		$this->getStaticMethodMock( 'MercuryApiArticleHandler', 'getRelatedPages' )
			->expects( $this->once() )
			->method( 'getRelatedPages' )
			->will( $this->returnValue( $relatedPagesMock ) );

		$article = new Article( new Title() );
		$request = new WikiaRequest( [ ] );
		$mercuryApi = new MercuryApi();

		$this->assertEquals( $expected, MercuryApiArticleHandler::getArticleData( $request, $mercuryApi, $article ) );
	}

	public function getArticleDataProvider() {
		return [
			[
				'$expected' => [
					'details' => [ ],
					'article' => [ ],
					'topContributors' => [ ],
				],
				'$articleDetailsMock' => [ ],
				'$articleJsonMock' => [ ],
				'$topContributorsJsonMock' => [ ],
				'$relatedPagesMock' => [ ]
			],
			[
				'$expected' => [
					'details' => [
						'id' => 56921,
						'title' => "Iron Dagger (Skyrim)",
					],
					'article' => [
						'content' => 'The Iron Dagger is a one-handed weapon that appears in The Elder Scrolls V: Skyrim.',
						'media' => [
							[
								'type' => "image",
								'title' => "DamageIcon.png",
							],
							[
								'type' => "image",
								'title' => "IronDagger SK.png",
							],
						]
					],
					'topContributors' => [
						[
							'user_id' => 3186827,
							'title' => "Jimeee",
						],
						[
							'user_id' => 4891020,
							'title' => "Ghrd224",
						]
					],
					'relatedPages' => [
						[
							'url' => "/wiki/Nettlebane",
							'title' => "Nettlebane"
						],
						[
							'url' => "/wiki/Orcish_Dagger",
							'title' => "Orcish Dagger",
						]
					]
				],
				'$articleDetailsMock' => [
					'id' => 56921,
					'title' => "Iron Dagger (Skyrim)",
				],
				'$articleJsonMock' => [
					'content' => 'The Iron Dagger is a one-handed weapon that appears in The Elder Scrolls V: Skyrim.',
					'media' => [
						[
							'type' => "image",
							'title' => "DamageIcon.png",
						],
						[
							'type' => "image",
							'title' => "IronDagger SK.png",
						],
					]
				],
				'$topContributorsJsonMock' => [
					[
						'user_id' => 3186827,
						'title' => "Jimeee",
					],
					[
						'user_id' => 4891020,
						'title' => "Ghrd224",
					]
				],
				'$relatedPagesMock' => [
					[
						'url' => "/wiki/Nettlebane",
						'title' => "Nettlebane"
					],
					[
						'url' => "/wiki/Orcish_Dagger",
						'title' => "Orcish Dagger",
					]
				]
			]
		];
	}
}
