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
		$topContributorsJsonMock
	) {
		$this->getStaticMethodMock( 'MercuryApiArticleHandler', 'getTopContributorsDetails' )
			->expects( $this->once() )
			->method( 'getTopContributorsDetails' )
			->will( $this->returnValue( $topContributorsJsonMock ) );

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
				]
			]
		];
	}
}
