<?php


namespace Wikia\Search\Test\Services;


use Wikia\Search\Services\CombinedSearchService;
use Wikia\Search\Test\BaseTest;

class CombinedSearchServiceTest extends BaseTest {

	public function testSearch() {
		$combinedSearchServiceMock = $this->getMock('Wikia\Search\Services\CombinedSearchService', ['phraseSearchForWikias', 'phraseSearchForArticles']);

		$foundWikisMock = [ 'false', 'wiki', 'data' ];
		$foundArticlesMock = [ 'fake', 'articles' ];

		$combinedSearchServiceMock->expects( $this->exactly(1) )
			->method ( 'phraseSearchForWikias' )
			->with   ( "foo", ['en', 'de'], ["XYZ"] )
			->will   ( $this->returnValue($foundWikisMock) );

		$combinedSearchServiceMock->expects( $this->exactly(1) )
			->method ( 'phraseSearchForArticles' )
			->with   ( "foo", [ 13 ], ['en', 'de'] )
			->will   ( $this->returnValue($foundArticlesMock) );

		/** @var $combinedSearchServiceMock CombinedSearchService */
		$response = $combinedSearchServiceMock->search( "foo", ['en', 'de'], [ 13 ], ["XYZ"], 11);

		$this->assertEquals( ["wikias"=>$foundWikisMock, "articles"=>$foundArticlesMock], $response );
	}

	public function testSearchMaxArticlesPerWikia() {
		$combinedSearchServiceMock = $this->getMock('Wikia\Search\Services\CombinedSearchService', ['phraseSearchForWikias', 'phraseSearchForArticles']);

		$foundWikisMock = [ 'false', 'wiki', 'data' ];
		$foundArticlesMock = [ 'fake', 'articles' ];

		$combinedSearchServiceMock->expects( $this->exactly(1) )
			->method ( 'phraseSearchForWikias' )
			->with   ( "foo", ['en', 'de'], ["XYZ"] )
			->will   ( $this->returnValue($foundWikisMock) );

		$combinedSearchServiceMock->expects( $this->exactly(1) )
			->method ( 'phraseSearchForArticles' )
			->with   ( "foo", [ 13 ], ['en', 'de'] )
			->will   ( $this->returnValue($foundArticlesMock) );

		/** @var $combinedSearchServiceMock CombinedSearchService */
		$response = $combinedSearchServiceMock->search( "foo", ['en', 'de'], [ 13 ], ["XYZ"], 13);

		$this->assertEquals( ["wikias"=>$foundWikisMock, "articles"=>$foundArticlesMock], $response );
	}

	public function testSearchMaxArticlesPerWikia2() {
		$combinedSearchServiceMock = $this->getMock('Wikia\Search\Services\CombinedSearchService', ['phraseSearchForWikias', 'phraseSearchForArticles']);

		$foundWikisMock = [ ];
		$foundArticlesMock = [ 'fake', 'articles' ];

		$combinedSearchServiceMock->expects( $this->exactly(1) )
			->method ( 'phraseSearchForWikias' )
			->with   ( "foo", ['en', 'de'], ["XYZ"] )
			->will   ( $this->returnValue($foundWikisMock) );

		$combinedSearchServiceMock->expects( $this->exactly(1) )
			->method ( 'phraseSearchForArticles' )
			->with   ( "foo", [ 13 ], ['en', 'de'] )
			->will   ( $this->returnValue($foundArticlesMock) );

		/** @var $combinedSearchServiceMock CombinedSearchService */
		$response = $combinedSearchServiceMock->search( "foo", ['en', 'de'], [ 13 ], ["XYZ"], 11);

		$this->assertEquals( ["wikias"=>[], "articles"=>$foundArticlesMock], $response );
	}



	public function testSearchForArticles() {
		$combinedSearchServiceMock = $this->getMock('Wikia\Search\Services\CombinedSearchService', ['queryPhraseSolrForArticles', 'getImage']);
		$foundResultsMock1 = [ [
			'lang' => 'pl', 'title' => 'a', 'url' => 'b', 'id' => '123_14', 'score' => 3,
			'pageid' => 14, 'wid' => 123, 'html_pl' => 'lorem ipsum pl', 'quality' => 0,
			'article_type_s' => 'something weird'
		] ];

		$foundResultsMock2 = [ [
			'lang' => 'en', 'title' => 'w', 'url' => 'x', 'id' => '124_15', 'score' => 3,
			'pageid' => 15, 'wid' => 124, 'html_en' => 'lorem ipsum en', 'quality' => 0,
			'article_type_s' => 'book'
		] ];

		$combinedSearchServiceMock->expects( $this->at(0) )
			->method ( 'queryPhraseSolrForArticles' )
			->with   ( "foo", [ 13 ], 'pl' )
			->will   ( $this->returnValue($foundResultsMock1) );

		$combinedSearchServiceMock->expects( $this->at(1) )
			->method ( 'getImage' )
			->withAnyParameters()
			->will   ( $this->returnValue(null) );

		$combinedSearchServiceMock->expects( $this->at(2) )
			->method ( 'queryPhraseSolrForArticles' )
			->with   ( "foo", [ 13 ], 'en' )
			->will   ( $this->returnValue($foundResultsMock2) );

		$combinedSearchServiceMock->expects( $this->at(3) )
			->method ( 'getImage' )
			->withAnyParameters()
			->will   ( $this->returnValue(null) );

		/** @var $combinedSearchServiceMock CombinedSearchService */
		$response = $combinedSearchServiceMock->phraseSearchForArticles( 'foo', [13], [ 'pl', 'en' ] );

		$this->assertEquals([
			[
				'wikiId' => 123,
				'articleId' => 14,
				'title' => 'a',
				'url' => 'b',
				'lang' => 'pl',
				'snippet' => 'lorem ipsum pl',
				'quality' => 0,
				'type' => 'other' ],
			[
				'wikiId' => 124,
				'articleId' => 15,
				'title' => 'w',
				'url' => 'x',
				'lang' => 'en',
				'snippet' => 'lorem ipsum en',
				'quality' => 0,
				'type' => 'book' ]],
			$response );
	}


	public function testSearchForWikias() {
		$combinedSearchServiceMock = $this->getMock('Wikia\Search\Services\CombinedSearchService', ['queryPhraseForWikias', 'getTopArticles']);

		$foundResultsMockPL = [ [ 'sitename_txt' => 'a', 'url' => 'b', 'id' => '125', 'score' => 3, 'description_txt' => 'lorem ipsum pl', 'lang_s' => 'pl' ] ];
		$foundResultsMockEN = [ [ 'sitename_txt' => 'w', 'url' => 'x', 'id' => '126', 'score' => 3, 'description_txt' => 'lorem ipsum en', 'lang_s' => 'en' ] ];

		$combinedSearchServiceMock->expects( $this->at(0) )
			->method ( 'queryPhraseForWikias' )
			->with   ( "foobar", ['FOO'], 'en' )
			->will   ( $this->returnValue($foundResultsMockEN) );

		$combinedSearchServiceMock->expects( $this->never() )
			->method ( 'getTopArticles' )
			->withAnyParameters()
			->will   ( $this->returnValue(['fake1']) );

		$combinedSearchServiceMock->expects( $this->at(1) )
			->method ( 'queryPhraseForWikias' )
			->with   ( "foobar", ['FOO'], 'pl' )
			->will   ( $this->returnValue($foundResultsMockPL) );

		$combinedSearchServiceMock->expects( $this->never() )
			->method ( 'getTopArticles' )
			->withAnyParameters()
			->will   ( $this->returnValue(['fake2']) );

		$wikiServiceMock = $this->getMock('WikiService', ['getWikiWordmark']);

		$wikiServiceMock->expects( $this->any() )
			->method( 'getWikiWordmark' )
			->withAnyParameters()
			->will( $this->returnValue( 'fake wordmarkUrl' ) );

		/** @var $combinedSearchServiceMock CombinedSearchService */
		$combinedSearchServiceMock->setWikiService( $wikiServiceMock );

		$response = $combinedSearchServiceMock->phraseSearchForWikias( 'foobar', ['en', 'pl'], ['FOO']);

		$this->assertEquals([
				[
					'wikiId' => 126,
					'name' => 'w',
					'url' => 'x',
					'lang' => 'en',
					'snippet' => 'lorem ipsum en',
					'wordmark' => 'fake wordmarkUrl',
				],
				[
					'wikiId' => 125,
					'name' => 'a',
					'url' => 'b',
					'lang' => 'pl',
					'snippet' => 'lorem ipsum pl',
					'wordmark' => 'fake wordmarkUrl',
				]
			], $response );
	}
}
