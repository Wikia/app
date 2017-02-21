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
	 * @param $topContributorsJsonMock
	 * @param $relatedPagesMock
	 */
	public function testGetArticleData(
		$expected,
		$topContributorsJsonMock,
		$relatedPagesMock
	) {
		$this->getStaticMethodMock( 'MercuryApiArticleHandler', 'getTopContributorsDetails' )
			->expects( $this->once() )
			->method( 'getTopContributorsDetails' )
			->will( $this->returnValue( $topContributorsJsonMock ) );

		$this->getStaticMethodMock( 'MercuryApiArticleHandler', 'getRelatedPages' )
			->expects( $this->once() )
			->method( 'getRelatedPages' )
			->will( $this->returnValue( $relatedPagesMock ) );

		$article = new Article( new Title() );
		$mercuryApi = new MercuryApi();

		$this->assertEquals( $expected, MercuryApiArticleHandler::getArticleData( $mercuryApi, $article ) );
	}

	public function getArticleDataProvider() {
		return [
			[
				'$expected' => [
					'topContributors' => [ ],
				],
				'$topContributorsJsonMock' => [ ],
				'$relatedPagesMock' => [ ]
			],
			[
				'$expected' => [
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
