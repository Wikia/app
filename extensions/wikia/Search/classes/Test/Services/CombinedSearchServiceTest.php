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
}
