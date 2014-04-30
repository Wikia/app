<?php

class ReadMoreModelTest extends WikiaBaseTest {

	public $titles;
	public $images;
	public $articles;

	public function setUp() {
		$this->titles = $this->getTitles();
		$this->images = $this->getImages();
		$this->articles = $this->getArticlesData();
		parent::setUp();
	}

	/**
	 * @dataProvider getRecommendedArticleIdsDataProvider
	 */
	public function testGetRecommendedArticleIds( $wiki, $recommendationKeys, $expected ) {
		$this->mockGlobalVariable('wgCityId', $wiki['wikiId']);
		$readMoreModel = new ReadMoreModel( 100 );
		$articleIds = $readMoreModel->getRecommendedArticleIds( $recommendationKeys );
		$this->assertEquals($expected, $articleIds);
	}

	/**
	 * @dataProvider getRecommendationDataDataProvider
	 */
	public function testGetRecommendationData( $articleId, $titleExists, $isRedirect, $expected ) {
		$articleServiceMock = $this->getMock('ArticleService', ['setArticleById']);
		$articleMock = $this->getMock('Article', ['getTextSnippet'], [], '', false);
		$titleMock = $this->getMock('Title', ['exists', 'isRedirect', 'getPrefixedText', 'getLocalUrl', 'getArticleID']);

		$titleMock->expects($this->any())
			->method('exists')
			->will($this->returnValue($titleExists));

		$titleMock->expects($this->any())
			->method('isRedirect')
			->will($this->returnValue($isRedirect));

		if (isset($this->titles[$articleId])) {
			$titleMock->expects($this->any())
				->method('getArticleID')
				->will($this->returnValue($articleId));

			$articleMock->expects($this->any())
				->method('getTextSnippet')
				->will($this->returnValue($this->articles[$articleId]['text']));

			$articleServiceMock->expects($this->any())
				->method('setArticleById')
				->with($articleId)
				->will($this->returnValue(($articleMock)));

			$titleMock->expects($this->any())
				->method('getPrefixedText')
				->will($this->returnValue($this->titles[$articleId]['title']));

			$titleMock->expects($this->any())
				->method('getLocalURL')
				->will($this->returnValue($this->titles[$articleId]['url']));

		}

		$readMoreModelMock = new ReadMoreModel( 100 );
		$recommendation = $readMoreModelMock->getRecommendationData($articleServiceMock, $titleMock, $this->images);

		$this->assertEquals($expected, $recommendation);
	}

	public function getRecommendedArticleIdsDataProvider() {
		return [
			[
				['wikiId' => 123],
				[
					'123_1',
					'123_5',
					'123_43',
					'123_55',
					'123_123',
					'123_200',
					'123_321'
				],
				[
					'1' => '1',
					'5' => '5',
					'43' => '43',
					'55' => '55',
					'123' => '123',
					'200' => '200',
					'321' => '321'
				]
			],
			[
				['wikiId' => 123],
				[
					'123_1',
					'123_5',
					'126_43',
					'127_55',
					'123_123',
					'123_200',
					'123_321'
				],
				[
					'1' => '1',
					'5' => '5',
					'123' => '123',
					'200' => '200',
					'321' => '321'
				]
			],
			[
				['wikiId' => 125],
				[
					'123_1',
					'123_5',
					'123_43',
					'123_55',
					'123_123',
					'123_200',
					'123_321'
				],
				[]
			],
			[
				['wikiId' => 123],
				[
					'123_1',
					'_5',
				],
				[
					'1' => '1',
				]
			],
			[
				['wikiId' => 123],
				[
					'1231'
				],
				[]
			],
			[
				['wikiId' => 123],
				[
					'123_1',
					'123_'
				],
				[
					'1' => '1',
				]
			]
		];
	}

	public function getRecommendationDataDataProvider() {
		$titles = $this->getTitles();
		$articles = $this->getArticlesData();
		$images = $this->getImages();

		return [
			// Existing article
			[
				1,
				true, // Title exists
				false, // Title is redirected
				[
					'title' => $titles[1]['title'],
					'url' =>  $titles[1]['url'],
					'text' => $articles[1]['text'],
					'image' => $images[1][0]['url'],
				]
			],
			// Existing article
			[
				123,
				true, // Title exists
				false, // Title is redirected
				[
					'title' => $titles[123]['title'],
					'url' =>  $titles[123]['url'],
					'text' => $articles[123]['text'],
					'image' => $images[123][0]['url'],
				]
			],
			// Existing article without image
			[
				200,
				true, // Title exists
				false, // Title is redirected
				[
					'title' => $titles[200]['title'],
					'url' =>  $titles[200]['url'],
					'text' => $articles[200]['text'],
					'image' => null,
				]
			],
			// Not existing article (article id is null)
			[
				111,
				true, // Title exists
				false, // Title is redirected
				[]
			],
			// Not existing Title
			[
				33,
				false, // Title exists
				false, // Title is redirected
				[]
			],
			// is redirected
			[
				333,
				false, // Title exists
				true, // Title is redirected
				[]
			]
		];
	}

	private function getArticlesData() {
		return [
			1 => [
				'text' => 'Article 1 Text',
			],
			5 => [
				'text' => 'Article 5 Text',
			],
			43 => [
				'text' => 'Article 43 Text',
			],
			55 => [
				'text' => 'Article 55 Text',
			],
			123 => [
				'text' => 'Article 123 Text',
			],
			200 => [
				'text' => 'Article 200 Text',
			],
			321 => [
				'text' => 'Article 321 Text',
			],
		];
	}

	private function getImages() {
		return [
			1 => [
				0 => [
					'url' => 'http://image.testlink/article1.jpg',
				]
			],
			5 => [
				0 => [
					'url' => 'http://image.testlink/article5.jpg',
				]
			],
			43 => [
				0 => [
					'url' => 'http://image.testlink/article43.jpg',
				]
			],
			55 => [
				0 => [
					'url' => 'http://image.testlink/article55.jpg',
				]
			],
			123 => [
				0 => [
					'url' => 'http://image.testlink/article123.jpg',
				]
			],
			321 => [
				0 => [
					'url' => 'http://image.testlink/article321.jpg',
				]
			]
		];
	}

	private function getTitles() {
		return [
			1 => [
				'title' => 'Article 1 Title',
				'url' => 'http://muppet.wikia.com/Article1',
			],
			5 => [
				'title' => 'Article 5 Title',
				'url' => 'http://muppet.wikia.com/Article5',
			],
			43 => [
				'title' => 'Article 43 Title',
				'url' => 'http://muppet.wikia.com/Article43',
			],
			55 => [
				'title' => 'Article 55 Title',
				'url' => 'http://muppet.wikia.com/Article55',
			],
			123 => [
				'title' => 'Article 123 Title',
				'url' => 'http://muppet.wikia.com/Article123',
			],
			200 => [
				'title' => 'Article 200 Title',
				'url' => 'http://muppet.wikia.com/Article200',
			],
			321 => [
				'title' => 'Article 321 Title',
				'url' => 'http://muppet.wikia.com/Article321',
			],
		];
	}
} 