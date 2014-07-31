<?php

use Wikia\Search\Test\BaseTest;

include_once dirname( __FILE__ ) . '/../' . "QuestDetailsSearchService.class.php";

/**
 * Class QuestDetailsSearchServiceMock - used to mock calls of static methods (which must not be tested)
 */
class QuestDetailsSearchServiceMock extends QuestDetailsSearchService {

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

	public function testShouldReturnCorrectResponseFormat() {

		$questDetailsSearch = $this->getMockedQuestDetailsSearchService();

		$result = $questDetailsSearch->query( 'test' );

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

		$questDetailsSearch = new QuestDetailsSearchServiceMock( $mock );

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
        "nolang_txt": [
          "The Letter B",
          "The Letter B",
          "\"The Letter B\" is a Sesame Street song from a 1983 episode. Oscar the Grouch finds a letter B by his trash can and wonders aloud what it's doing there. He immediately wishes he hadn't asked, because Gilbert and Sullivan show up to answer his question in song. Each verse to the song concerns different categories of B items. First, Olivia, dressed in a fancy gown and bonnet, demonstrates the various foods whose names start with that letter. Maria, in a baseball uniform, sings about sports and games, and Bob, as a zookeeper, lists off several B animals before being"
        ],
        "wid": 831,
        "words": 126,
        "wiki_images": 92955,
        "wiki_official_b": false,
        "revcount": 7,
        "id": "831_155836",
        "is_main_page": false,
        "wam": 99,
        "pageid": 155836,
        "backlinks": 3,
        "categories_mv_en": [
          "Sesame Street Songs",
          "Alphabet"
        ],
        "wiki_description_txt": [
          "With more than 25,000 pages and 75,000 pictures, Muppet Wiki is a collaborative, comprehensive encyclopedia for everything related to Jim Henson, Sesame Street, The Muppet Show, and the Muppets Studio. We have pages for the shows, the movies, the characters, the actors, the crew, the music, the merchandise and more. \"It's time to meet the Muppets\"... on Muppet Wiki!"
        ],
        "touched": "2014-06-10T04:17:50Z",
        "ns": 0,
        "wikipages": 164135,
        "wikiviews_weekly": 0,
        "wikiviews_monthly": 5399958,
        "hub": "Entertainment",
        "views": 84,
        "html_en": "\"The Letter B\" is a Sesame Street song from a 1983 episode. Oscar the Grouch finds a letter B by his trash can and wonders aloud what it's doing there. He immediately wishes he hadn't asked, because Gilbert and Sullivan show up to answer his question in song. Each verse to the song concerns different categories of B items. First, Olivia, dressed in a fancy gown and bonnet, demonstrates the various foods whose names start with that letter. Maria, in a baseball uniform, sings about sports and games, and Bob, as a zookeeper, lists off several B animals before being pounced on by Barkley. A much annoyed Oscar remarks \"you have to be careful asking a question around here. Sometimes, you get a really silly answer.\" Notes Maria's verse is based on \"Take Me Out to the Ball Game.\" See also Letter B Music by Joe Raposo Lyrics by Emily Kingsley Date 1983 Publisher Jonico Music, Inc., Sesame Street, Inc.",
        "wikiarticles": 26966,
        "title_en": "The Letter B",
        "page_images": 1,
        "host": "muppet.wikia.com",
        "outbound_links_txt": [
          "831_960 | Joe Raposo",
          "831_4542 | Emily Kingsley",
          "831_5090 | 1983",
          "831_258 | Sesame Street",
          "831_46189 | a 1983 episode",
          "831_68 | Oscar the Grouch",
          "831_19410 | B",
          "831_12013 | Gilbert and Sullivan",
          "831_1531 | Olivia",
          "831_1193 | Maria",
          "831_1194 | Bob",
          "831_445 | Barkley",
          "831_14457 | Letter B"
        ],
        "iscontent": true,
        "lang": "en",
        "wiki_new_b": false,
        "titleStrict": "The Letter B",
        "created": "2012-05-23T00:38:31Z",
        "url": "http://muppet.wikia.com/wiki/The_Letter_B",
        "activeusers": 136,
        "wiki_promoted_b": false,
        "headings_mv_en": [
          "Notes",
          "See also"
        ],
        "wikititle_en": "Muppet Wiki",
        "wiki_hot_b": false,
        "indexed": "2014-06-10T04:19:58.222Z",
        "is_closed_wiki": false,
        "article_quality_i": 44,
        "title_em": "The Letter B",
        "article_type_s": "other",
        "snippet_s": "\"The Letter B\" is a Sesame Street song from a 1983 episode. Oscar the Grouch finds a letter B by his trash can and wonders aloud what it's doing there. He immediately wishes he hadn't asked, because Gilbert and Sullivan show up to answer his question in song. Each verse to the song concerns different categories of B items. First, Olivia, dressed in a fancy gown and bonnet, demonstrates the various foods whose names start with that letter. Maria, in a baseball uniform, sings about sports and games, and Bob, as a zookeeper, lists off several B animals before being pounced on by Barkley. A much annoyed Oscar remarks \"you have to be careful asking a question around here. Sometimes, you get a really silly answer.\"",
        "metadata_fingerprint_ids_ss": [
          "amazing",
          "great_job",
          "best"
        ],
        "metadata_quest_id_s": "very_good",
        "metadata_map_location_sr": "1.11244,-1.21412",
        "metadata_map_region_s": "Map_Region_1",
        "_version_": 1475135582441046000
      },
      {
        "nolang_txt": [
          "Ruby",
          "Ruby",
          "Ruby is a yellow monster from Sesame Street who is very curious and loves to conduct experiments. For instance, in one episode, Ruby wanted to find out what it was like to be blind, so she spent the entire day wearing a blindfold. She debuted in Season 19 and appeared on the show through Season 23. Ruby appeared in the Monsterpiece Theater segment \"Guys and Dolls,\" where she sang about her love for trucks. She also appeared on the bus with Farley in the song \"Forty Blocks From My Home.\""
        ],
        "wid": 831,
        "words": 90,
        "wiki_images": 92665,
        "wiki_official_b": false,
        "revcount": 31,
        "id": "831_8938",
        "is_main_page": false,
        "wam": 98,
        "pageid": 8938,
        "backlinks": 50,
        "categories_mv_en": [
          "Sesame Street Characters",
          "Muppet Characters",
          "Sesame Street Monsters"
        ],
        "wiki_description_txt": [
          "With more than 25,000 pages and 75,000 pictures, Muppet Wiki is a collaborative, comprehensive encyclopedia for everything related to Jim Henson, Sesame Street, The Muppet Show, and the Muppets Studio. We have pages for the shows, the movies, the characters, the actors, the crew, the music, the merchandise and more. \"It's time to meet the Muppets\"... on Muppet Wiki!"
        ],
        "touched": "2014-05-12T23:14:09Z",
        "redirect_titles_mv_en": [
          "Ruby Monster"
        ],
        "ns": 0,
        "wikipages": 163385,
        "wikiviews_weekly": 0,
        "wikiviews_monthly": 6264907,
        "hub": "Entertainment",
        "views": 7913,
        "html_en": "Ruby is a yellow monster from Sesame Street who is very curious and loves to conduct experiments. For instance, in one episode, Ruby wanted to find out what it was like to be blind, so she spent the entire day wearing a blindfold. She debuted in Season 19 and appeared on the show through Season 23. Ruby appeared in the Monsterpiece Theater segment \"Guys and Dolls,\" where she sang about her love for trucks. She also appeared on the bus with Farley in the song \"Forty Blocks From My Home.\" Ruby and Gina graduating, Screenshot taken from a clip in Stars and Street Forever! Ruby and Prairie Dawn. Screenshot taken from a clip in Sesame Street: 20 and Still Counting Ruby and Bob rollerskating. Screenshot taken from a clip in Big Bird's Birthday or Let Me Eat Cake Add a photo to this gallery Add a photo to this gallery Appearances Sesame Street Sesame Street: 20 and Still Counting Big Bird's Birthday or Let Me Eat Cake Book appearances What Do You Do? (1992 edition) See also Sesame Street Monsters Performer: Camille Bonora",
        "wikiarticles": 26880,
        "title_en": "Ruby",
        "page_images": 4,
        "host": "muppet.wikia.com",
        "iscontent": true,
        "lang": "en",
        "wiki_new_b": false,
        "titleStrict": "Ruby",
        "created": "2006-01-21T05:39:10Z",
        "url": "http://muppet.wikia.com/wiki/Ruby",
        "activeusers": 173,
        "wiki_promoted_b": false,
        "headings_mv_en": [
          "Appearances",
          "Book appearances",
          "See also"
        ],
        "wikititle_en": "Muppet Wiki",
        "wiki_hot_b": false,
        "indexed": "2014-05-12T23:16:03.831Z",
        "is_closed_wiki": false,
        "outbound_links_txt": [
          "831_1181 | Gina",
          "831_2253 | Stars and Street Forever!",
          "831_153 | Prairie Dawn",
          "831_1413 | Sesame Street: 20 and Still Counting",
          "831_1194 | Bob",
          "831_5947 | Big Bird's Birthday or Let Me Eat Cake",
          "831_597 | Camille Bonora",
          "831_258 | Sesame Street",
          "831_1537 | Season 19",
          "831_3086 | Season 23",
          "831_1092 | Monsterpiece Theater",
          "831_10564 | Farley",
          "831_10565 | Forty Blocks From My Home",
          "831_37276 | What Do You Do?",
          "831_48920 | Sesame Street Monsters"
        ],
        "article_quality_i": 72,
        "redirect_titles_mv_em": [
          "Ruby Monster"
        ],
        "title_em": "Ruby",
        "article_type_s": "character",
        "snippet_s": "Ruby is a yellow monster from Sesame Street who is very curious and loves to conduct experiments. For instance, in one episode, Ruby wanted to find out what it was like to be blind, so she spent the entire day wearing a blindfold. She debuted in Season 19 and appeared on the show through Season 23. Ruby appeared in the Monsterpiece Theater segment \"Guys and Dolls,\" where she sang about her love for trucks. She also appeared on the bus with Farley in the song \"Forty Blocks From My Home.\"",
        "metadata_fingerprint_ids_ss": [
          "amazing",
          "great_job",
          "best"
        ],
        "metadata_quest_id_s": "very_good",
        "metadata_map_location_sr": "1.11244,1.11412",
        "metadata_map_region_s": "Map_Region_1",
        "_version_": 1475135582449434600
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
}