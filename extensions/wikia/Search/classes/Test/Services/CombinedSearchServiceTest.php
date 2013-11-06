<?php


namespace Wikia\Search\Test\Services;


use Wikia\Search\Services\CombinedSearchService;
use Wikia\Search\Test\BaseTest;

class CombinedSearchServiceTest extends BaseTest {

	public function testSearch() {
		$combinedSearchServiceMock = $this->getMock('Wikia\Search\Services\CombinedSearchService', ['searchForWikias', 'searchForArticles']);

		$foundWikisMock = [ 'false', 'wiki', 'data' ];
		$foundArticlesMock = [ 'fake', 'articles' ];

		$combinedSearchServiceMock->expects( $this->exactly(1) )
			->method ( 'searchForWikias' )
			->with   ( "foo", ['en', 'de'], ["XYZ"] )
			->will   ( $this->returnValue($foundWikisMock) );

		$combinedSearchServiceMock->expects( $this->exactly(1) )
			->method ( 'searchForArticles' )
			->with   ( "foo", [ 13 ], $foundWikisMock, 4 )
			->will   ( $this->returnValue($foundArticlesMock) );

		/** @var $combinedSearchServiceMock CombinedSearchService */
		$response = $combinedSearchServiceMock->search( "foo", ['en', 'de'], [ 13 ], ["XYZ"], 11);

		$this->assertEquals( ["wikias"=>$foundWikisMock, "articles"=>$foundArticlesMock], $response );
	}

	public function testSearchMaxArticlesPerWikia() {
		$combinedSearchServiceMock = $this->getMock('Wikia\Search\Services\CombinedSearchService', ['searchForWikias', 'searchForArticles']);

		$foundWikisMock = [ 'false', 'wiki', 'data' ];
		$foundArticlesMock = [ 'fake', 'articles' ];

		$combinedSearchServiceMock->expects( $this->exactly(1) )
			->method ( 'searchForWikias' )
			->with   ( "foo", ['en', 'de'], ["XYZ"] )
			->will   ( $this->returnValue($foundWikisMock) );

		$combinedSearchServiceMock->expects( $this->exactly(1) )
			->method ( 'searchForArticles' )
			->with   ( "foo", [ 13 ], $foundWikisMock, 5 )
			->will   ( $this->returnValue($foundArticlesMock) );

		/** @var $combinedSearchServiceMock CombinedSearchService */
		$response = $combinedSearchServiceMock->search( "foo", ['en', 'de'], [ 13 ], ["XYZ"], 13);

		$this->assertEquals( ["wikias"=>$foundWikisMock, "articles"=>$foundArticlesMock], $response );
	}

	public function testSearchMaxArticlesPerWikia2() {
		$combinedSearchServiceMock = $this->getMock('Wikia\Search\Services\CombinedSearchService', ['searchForWikias', 'searchForArticles']);

		$foundWikisMock = [ ];

		$combinedSearchServiceMock->expects( $this->exactly(1) )
			->method ( 'searchForWikias' )
			->with   ( "foo", ['en', 'de'], ["XYZ"] )
			->will   ( $this->returnValue($foundWikisMock) );

		$combinedSearchServiceMock->expects( $this->never() )
			->method ( 'searchForArticles' )
			->withAnyParameters();

		/** @var $combinedSearchServiceMock CombinedSearchService */
		$response = $combinedSearchServiceMock->search( "foo", ['en', 'de'], [ 13 ], ["XYZ"], 11);

		$this->assertEquals( ["wikias"=>[], "articles"=>[]], $response );
	}



	public function testSearchForArticles() {
		$combinedSearchServiceMock = $this->getMock('Wikia\Search\Services\CombinedSearchService', ['querySolrForArticles']);
		$foundResultsMock1 = [ [ 'lang' => 'pl', 'title' => 'a', 'url' => 'b', 'id' => '123_14', 'score' => 3, 'pageid' => 14, 'wid' => 123, 'html_pl' => 'lorem ipsum pl' ] ];
		$foundResultsMock2 = [ [ 'lang' => 'en', 'title' => 'w', 'url' => 'x', 'id' => '124_15', 'score' => 3, 'pageid' => 15, 'wid' => 124, 'html_en' => 'lorem ipsum en' ] ];

		$combinedSearchServiceMock->expects( $this->at(0) )
			->method ( 'querySolrForArticles' )
			->with   ( "foo", [ 13 ], 4, 123, 'pl' )
			->will   ( $this->returnValue($foundResultsMock1) );

		$combinedSearchServiceMock->expects( $this->at(1) )
			->method ( 'querySolrForArticles' )
			->with   ( "foo", [ 13 ], 4, 124, 'en' )
			->will   ( $this->returnValue($foundResultsMock2) );

		/** @var $combinedSearchServiceMock CombinedSearchService */
		$response = $combinedSearchServiceMock->searchForArticles( 'foo', [13], [ [ 'wikiId' => 123, "lang" => 'pl' ], [ 'wikiId' => 124, "lang" => 'en' ] ], 4 );

		$this->assertEquals([
			[
				'wikiId' => 123,
				'articleId' => 14,
				'title' => 'a',
				'url' => 'b',
				'lang' => 'pl',
				'snippet' => 'lorem ipsum pl' ],
			[
				'wikiId' => 124,
				'articleId' => 15,
				'title' => 'w',
				'url' => 'x',
				'lang' => 'en',
				'snippet' => 'lorem ipsum en' ] ],
			$response );
	}
}
