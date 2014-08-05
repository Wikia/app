<?php

use Wikia\Search\Test\BaseTest;

include_once dirname( __FILE__ ) . '/../../../Services/QuestDetails/' . "QuestDetailsSolrHelper.class.php";
include_once dirname( __FILE__ ) . '/../../../Services/QuestDetails/' . "QuestDetailsSearchService.class.php";

/**
 * Class QuestDetailsSearchServiceMock - used to mock calls of static methods (which must not be tested)
 */
class QuestDetailsSearchSolrHelperMock extends QuestDetailsSolrHelper {

	protected function getRevision( &$item ) {
		$revision = [
			'id' => 1234,
			'user' => 'test_user',
			'user_id' => 1111,
			'timestamp' => '1234567'
		];
		return $revision;
	}

	protected function getCommentsNumber( &$item ) {
		return 0;
	}

	protected function getArticlesThumbnails( $articles, $width = self::DEFAULT_THUMBNAIL_WIDTH, $height = self::DEFAULT_THUMBNAIL_HEIGHT ) {
		$ids = !is_array( $articles ) ? [ $articles ] : $articles;
		$result = [ ];
		foreach ( $ids as $id ) {
			$data = [
				'thumbnail' => null,
				'original_dimensions' => null
			];
			$result[ $id ] = $data;
		}
		return $result;
	}
}

class QuestDetailsSearchServiceTest extends WikiaBaseTest {

	protected static function getFn( $obj, $name ) {
		$class = new ReflectionClass( get_class( $obj ) );
		$method = $class->getMethod( $name );
		$method->setAccessible( true );

		return function () use ( $obj, $method ) {
			$args = func_get_args();
			return $method->invokeArgs( $obj, $args );
		};
	}

	/**
	 * @covers       QuestDetailsSearchService::constructQuery
	 * @dataProvider makeCriteriaQuery_Provider
	 */
	public function testCorrectnessOfQueryBuilding( $criteria, $expectedQuery ) {
		$questDetailsSearch = new QuestDetailsSearchService();

		if( empty( $criteria[ 'fingerprint' ] ) ) {
			$criteria[ 'fingerprint' ] = null;
		}
		if( empty( $criteria[ 'questId' ] ) ) {
			$criteria[ 'questId' ] = null;
		}
		if( empty( $criteria[ 'category' ] ) ) {
			$criteria[ 'category' ] = null;
		}

		$this->assertEquals(
			$expectedQuery,
			$questDetailsSearch->newQuery()
				->withFingerprint( $criteria[ 'fingerprint' ] )
				->withQuestId( $criteria[ 'questId' ] )
				->withCategory( $criteria[ 'category' ] )
				->makeQuery()
		);
	}

	/**
	 * @covers       QuestDetailsSolrHelper::parseCoordinates
	 * @dataProvider makeParseCoordinates_Provider
	 */
	public function testParseCoordinatesString( $str, $x, $y ) {
		$solrHelper = new QuestDetailsSolrHelper();

		$parseCoordinates = self::getFn( $solrHelper, 'parseCoordinates' );

		$result = $parseCoordinates( $str );

		$this->assertEquals( $x, $result[ 'x' ] );
		$this->assertEquals( $y, $result[ 'y' ] );
	}

	/**
	 * @covers       QuestDetailsSolrHelper::parseCoordinates
	 */
	public function testParseCoordinatesInvalidString() {
		$solrHelper = new QuestDetailsSolrHelper();

		$parseCoordinates = self::getFn( $solrHelper, 'parseCoordinates' );

		$exceptionBeenThrown = false;
		try {
			$parseCoordinates( 'invalid' );
		} catch ( Exception $e ) {
			$exceptionBeenThrown = true;
		}

		if ( !$exceptionBeenThrown ) {
			$this->fail( 'Whet parsing invalid coordinates - exception must be thrown' );
		}
	}

	public function testShouldReturnCorrectResponseFormat() {
		$questDetailsSearch = $this->getMockedQuestDetailsSearchService();

		$result = $questDetailsSearch->newQuery()->search();

		$expected = [
			[
				"id" => 155836,
				"title" => "The Letter B",
				"url" => "http://muppet.wikia.com/wiki/The_Letter_B",
				"ns" => 0,
				"revision" => [
					"id" => 1234,
					"user" => "test_user",
					"user_id" => 1111,
					"timestamp" => "1234567"
				],
				"comments" => 0,
				"type" => "other",
				"categories" => [
					"Sesame Street Songs",
					"Alphabet"
				],
				"abstract" => "\"The Letter B\" is a Sesame Street song from a 1983 episode. Oscar the Grouch finds a letter B by his trash can and wonders aloud what it's doing there. He immediately wishes he hadn't asked...",
				"metadata" => [
					"fingerprints" => [
						"amazing",
						"great_job",
						"best"
					],
					"quest_id" => "very_good",
					"map_location" => [
						"location_x" => 1.11244,
						"location_y" => -1.21412,
						"region" => "Map_Region_1"
					]
				],
				"thumbnail" => null,
				"original_dimensions" => null
			],
			[
				"id" => 8938,
				"title" => "Ruby",
				"url" => "http://muppet.wikia.com/wiki/Ruby",
				"ns" => 0,
				"revision" => [
					"id" => 1234,
					"user" => "test_user",
					"user_id" => 1111,
					"timestamp" => "1234567"
				],
				"comments" => 0,
				"type" => "character",
				"categories" => [
					"Sesame Street Characters",
					"Muppet Characters",
					"Sesame Street Monsters"
				],
				"abstract" => "Ruby is a yellow monster from Sesame Street who is very curious and loves to conduct experiments. For instance, in one episode, Ruby wanted to find out what it was like to be blind, so she spent...",
				"metadata" => [
					"fingerprints" => [
						"amazing",
						"great_job",
						"best"
					],
					"quest_id" => "very_good",
					"map_location" => [
						"location_x" => 1.11244,
						"location_y" => 1.11412,
						"region" => "Map_Region_1"
					]
				],
				"thumbnail" => null,
				"original_dimensions" => null
			]
		];

		$this->assertEquals( $expected, $result );
	}

	protected function getMockedQuestDetailsSearchService() {

		$this->getStaticMethodMock( '\WikiFactory', 'getCurrentStagingHost' )
			->expects( $this->any() )
			->method( 'getCurrentStagingHost' )
			->will( $this->returnCallback( [ $this, 'mock_getCurrentStagingHost' ] ) );

		$mock = $this->getSolariumMock();
		$mock->expects( $this->once() )
			->method( 'select' )
			->will( $this->returnValue( $this->getResultMock( 'getSolariumMainResponse' ) ) );

		$questDetailsSearch = new QuestDetailsSearchService( $mock );

		$questDetailsSearch->setSolrHelper( new QuestDetailsSearchSolrHelperMock() );

		return $questDetailsSearch;
	}

	protected function mock_getCurrentStagingHost( $arg1, $arg2 ) {
		return 'newhost';
	}

	protected function getSolariumMock() {
		$client = new \Solarium_Client();
		$mock = $this->getMockBuilder( '\Solarium_Client' )
			->getMock();

		$mock->expects( $this->any() )
			->method( 'createSelect' )
			->will( $this->returnValue( $client->createSelect() ) );

		return $mock;
	}

	protected function getResultMock( $responseType ) {
		$client = new \Solarium_Client();
		$mock = new \Solarium_Result_Select(
			$client,
			$client->createSelect(),
			$this->{$responseType}()
		);

		return $mock;
	}

	protected function getSolariumMainResponse() {
		$body = <<<SOLR_RESPONSE_MOCK
{
  "responseHeader": {
    "status": 0,
    "QTime": 0,
    "params": {
      "fl": "pageid,title_*,url,ns,article_type_s,categories_*,html_*,metadata_*",
      "indent": "true",
      "q": "metadata_fingerprint_ids_ss:*",
      "wt": "json"
    }
  },
  "response": {
    "numFound": 2,
    "start": 0,
    "docs": [
      {
        "pageid": 155836,
        "categories_mv_en": [
          "Sesame Street Songs",
          "Alphabet"
        ],
        "ns": 0,
        "html_en": "\"The Letter B\" is a Sesame Street song from a 1983 episode. Oscar the Grouch finds a letter B by his trash can and wonders aloud what it's doing there. He immediately wishes he hadn't asked, because Gilbert and Sullivan show up to answer his question in song. Each verse to the song concerns different categories of B items. First, Olivia, dressed in a fancy gown and bonnet, demonstrates the various foods whose names start with that letter. Maria, in a baseball uniform, sings about sports and games, and Bob, as a zookeeper, lists off several B animals before being pounced on by Barkley. A much annoyed Oscar remarks \"you have to be careful asking a question around here. Sometimes, you get a really silly answer.\" Notes Maria's verse is based on \"Take Me Out to the Ball Game.\" See also Letter B Music by Joe Raposo Lyrics by Emily Kingsley Date 1983 Publisher Jonico Music, Inc., Sesame Street, Inc.",
        "title_en": "The Letter B",
        "url": "http://muppet.wikia.com/wiki/The_Letter_B",
        "title_em": "The Letter B",
        "article_type_s": "other",
        "metadata_fingerprint_ids_ss": [
          "amazing",
          "great_job",
          "best"
        ],
        "metadata_quest_id_s": "very_good",
        "metadata_map_location_sr": "1.11244,-1.21412",
        "metadata_map_region_s": "Map_Region_1"
      },
      {
        "pageid": 8938,
        "categories_mv_en": [
          "Sesame Street Characters",
          "Muppet Characters",
          "Sesame Street Monsters"
        ],
        "ns": 0,
        "html_en": "Ruby is a yellow monster from Sesame Street who is very curious and loves to conduct experiments. For instance, in one episode, Ruby wanted to find out what it was like to be blind, so she spent the entire day wearing a blindfold. She debuted in Season 19 and appeared on the show through Season 23. Ruby appeared in the Monsterpiece Theater segment \"Guys and Dolls,\" where she sang about her love for trucks. She also appeared on the bus with Farley in the song \"Forty Blocks From My Home.\" Ruby and Gina graduating, Screenshot taken from a clip in Stars and Street Forever! Ruby and Prairie Dawn. Screenshot taken from a clip in Sesame Street: 20 and Still Counting Ruby and Bob rollerskating. Screenshot taken from a clip in Big Bird's Birthday or Let Me Eat Cake Add a photo to this gallery Add a photo to this gallery Appearances Sesame Street Sesame Street: 20 and Still Counting Big Bird's Birthday or Let Me Eat Cake Book appearances What Do You Do? (1992 edition) See also Sesame Street Monsters Performer: Camille Bonora",
        "title_en": "Ruby",
        "url": "http://muppet.wikia.com/wiki/Ruby",
        "title_em": "Ruby",
        "article_type_s": "character",
        "metadata_fingerprint_ids_ss": [
          "amazing",
          "great_job",
          "best"
        ],
        "metadata_quest_id_s": "very_good",
        "metadata_map_location_sr": "1.11244,1.11412",
        "metadata_map_region_s": "Map_Region_1"
      }
    ]
  }
}
SOLR_RESPONSE_MOCK;

		$mock = new \Solarium_Client_Response(
			$body,
			[ 'HTTP/1.1 200 OK' ]
		);
		return $mock;
	}

	public function makeCriteriaQuery_Provider() {
		return [
			[ [ 'fingerprint' => 'test' ], 'metadata_fingerprint_ids_ss:"test"' ],
			[ [ 'fingerprint' => 'test', 'questId' => null, 'category' => null ], 'metadata_fingerprint_ids_ss:"test"' ],
			[ [ 'fingerprint' => 'test', 'questId' => '', 'category' => '' ], 'metadata_fingerprint_ids_ss:"test"' ],
			[ [ 'questId' => '123' ], 'metadata_quest_id_s:"123"' ],
			[ [ 'category' => 'Test' ], 'categories_mv_en:"Test"' ],
			[ [ 'fingerprint' => 'test', 'questId' => '123' ], 'metadata_fingerprint_ids_ss:"test" AND metadata_quest_id_s:"123"' ],
			[ [ 'fingerprint' => 'test', 'category' => 'Test' ], 'metadata_fingerprint_ids_ss:"test" AND categories_mv_en:"Test"' ],
			[ [ 'questId' => '123', 'category' => 'Test' ], 'metadata_quest_id_s:"123" AND categories_mv_en:"Test"' ],
		];
	}

	public function makeParseCoordinates_Provider() {
		return [
			[ '1, 1', 1, 1 ],
			[ '1, -1', 1, -1 ],
			[ '-1, 1', -1, 1 ],
			[ '1.0, 1.0', 1, 1 ],
			[ '1.23, 4.56', 1.23, 4.56 ],
			[ '1.23, -4.56', 1.23, -4.56 ],
			[ '-1.23, 4.56', -1.23, 4.56 ],
			[ '-1.23, -4.56', -1.23, -4.56 ],
		];
	}
}