<?php
namespace Wikia\Search\Test\Services;

use Wikia\Search\Services\MovieEntitySearchService;
use Wikia\Search\Test\BaseTest;

class MovieEntitySearchServiceTest extends BaseTest {

	/** @test */
	public function shouldReturnCorrectArticleFormat() {
		$this->getStaticMethodMock( '\WikiFactory', 'getLocalEnvURL' )
			->expects( $this->any() )
			->method( 'getLocalEnvURL' )
			->will( $this->returnCallback( [ $this, 'mock_getLocalEnvURL' ] ) );

		$mock = $this->getSolariumMock();
		$mock->expects( $this->once() )
			->method( 'select' )
			->will( $this->returnValue( $this->getResultMock( 'getSolariumMainResponse' ) ) );
		$movieSearch = new MovieEntitySearchService( $mock );

		$movieSearch->setLang('en');
		$res = $movieSearch->query('The Rains of Castamere');

		$this->assertEquals( [
			'articleId' => 13508,
			'title' => "The Rains of Castamere (episode)",
			'url' => "http://newhost/wiki/The_Rains_of_Castamere_(episode)",
			'quality' => 99,
			'wikiId' => 1,
			'contentUrl' => 'http://newhost/api/v1/Articles/AsSimpleJson?id=13508'
		], $res );
	}

	public function mock_getLocalEnvURL($arg1, $arg2)
	{
		return preg_replace('/https?:\/\/[^\/]+/', 'http://newhost', $arg1, 1);
	}

	private function getSolariumMock() {
		$client = new \Solarium_Client();
		$mock = $this->getMockBuilder( '\Solarium_Client' )
			->getMock();

		$mock->expects( $this->any() )
			->method( 'createSelect' )
			->will( $this->returnValue( $client->createSelect() ) );

		return $mock;
	}

	private function getResultMock( $responseType ) {
		$client = new \Solarium_Client();
		$mock = new \Solarium_Result_Select(
			$client,
			$client->createSelect(),
			$this->{$responseType}()
		);

		return $mock;
	}

	private function getSolariumMainResponse() {
		$body = '{"responseHeader":{"status":0,"QTime":6,"params":{"pf":"titleStrict^8 title_en^2 redirect_titles_mv_en^2","fl":"*,score","start":"0","q":"+(\"The Rains of Castamere\") AND +(wid:130814)","qf":"titleStrict title_en redirect_titles_mv_en","wt":"json","fq":["+(ns:0)","+(article_type_s:tv_episode)"],"defType":"edismax","rows":"1"}},"response":{"numFound":1,"start":0,"maxScore":12.947323,"docs":[{"wid":"1","host":"gameofthrones.wikia.com","pageid":13508,"id":"130814_13508","title_en":"The Rains of Castamere (episode)","url":"http://gameofthrones.wikia.com/wiki/The_Rains_of_Castamere_(episode)","article_quality_i":99,"score":12.947323}]}}';
		$mock = new \Solarium_Client_Response(
			$body,
			[ 'HTTP/1.1 200 OK' ]
		);
		return $mock;
	}

}