<?php

namespace Wikia\Search\Test\Services;

use Wikia\Search\Services\TvSearchService;
use Wikia\Search\Test\BaseTest;

class TvSearchServiceTest extends BaseTest {

	/**
	 * @test
	 */
	public function shouldReturnCorrectArticleFormatForNoWikiIdQuery() {
		$mock = $this->getSolariumMock();
		$mock->expects( $this->once() )
			->method( 'select' )
			->will( $this->returnValue( $this->getResultMock( 'getSolariumMainResponse' ) ) );
		$tvs = new TvSearchService( $mock );

		$res = $tvs->queryMain( 'The Rains of Castamere', 'en' );

		$this->assertEquals( [
			'articleId' => 13508,
			'title' => "The Rains of Castamere (episode)",
			'url' => "http://gameofthrones.wikia.com/wiki/The_Rains_of_Castamere_(episode)",
			'quality' => 99,
			'wikiId' => 1,
			'wikiHost' => 'gameofthrones.wikia.com'
		], $res );
	}

	/**
	 * @test
	 */
	public function shouldReturnCorrectWikiFormat() {
		$mock = $this->getSolariumMock();
		$mock->expects( $this->once() )
			->method( 'select' )
			->will( $this->returnValue( $this->getResultMock( 'getSolariumWikiResponse' ) ) );
		$tvs = new TvSearchService( $mock );

		$res = $tvs->queryXWiki( 'game of thrones', 'en' );

		$this->assertEquals( [ ['id' => '130814', 'wikiHost' => 'http://gameofthrones.wikia.com/' ] ], $res );
	}

	/**
	 * @test
	 */
	public function shouldReturnCorrectArticleFormat() {
		$mock = $this->getSolariumMock();
		$mock->expects( $this->once() )
			->method( 'select' )
			->will( $this->returnValue( $this->getResultMock( 'getSolariumMainResponse' ) ) );
		$tvs = new TvSearchService( $mock );

		$res = $tvs->queryMain( 'The Rains of Castamere', 'en' );

		$this->assertEquals( [
			'articleId' => 13508,
			'title' => "The Rains of Castamere (episode)",
			'url' => "http://gameofthrones.wikia.com/wiki/The_Rains_of_Castamere_(episode)",
			'quality' => 99,
			'wikiId' => 1,
			'wikiHost' => 'gameofthrones.wikia.com'
		], $res );
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

	private function getSolariumWikiResponse() {
		$body = '{"responseHeader":{"status":0,"QTime":116,"params":{"pf":"series_mv_tm^10 sitename_txt^5","bq":"domains_txt:\"www.gameofthrones.wikia.com\"^10 domains_txt:\"gameofthrones.wikia.com\"^10","fl":"*,score","start":"0","q":"+(\"game of thrones\") AND +(lang_s:en)","bf":"wam_i^2","qf":"series_mv_tm^10 description_txt categories_txt top_categories_txt top_articles_txt sitename_txt^4 domains_txt","wt":"json","fq":"-(hostname_s:*fanon.wikia.com) AND -(hostname_s:*answers.wikia.com)","defType":"edismax","rows":"1"}},"response":{"numFound":61,"start":0,"maxScore":14.198625,"docs":[{"id":"130814","url":"http://gameofthrones.wikia.com/","articles_i":100,"score":14.198625}]}}';
		$mock = new \Solarium_Client_Response(
			$body,
			[ 'HTTP/1.1 200 OK' ]
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