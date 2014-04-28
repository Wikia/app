<?php
namespace Wikia\Search\Test\Services;

use Wikia\Search\Services\MovieEntitySearchService;
use Wikia\Search\Test\BaseTest;

class MovieEntitySearchServiceTest extends BaseTest {

	/** @test */
	public function shouldReturnCorrectQuery() {
		$service = new MovieEntitySearchService();
		$service->setLang( 'en' );

		$query = 'terminator 2';
		$client = new \Solarium_Client();
		$mocked = $client->createSelect();
		$mocked->setQuery( '+("' . $query . '")' );
		$mocked->setRows(1);
		$dismax = $mocked->getDisMax();
		$dismax->setQueryParser('edismax');
		$mocked->createFilterQuery( 'ns' )->setQuery('+(ns:0)');
		$mocked->createFilterQuery( 'type' )->setQuery('+(article_type_s:movie)');
		$mocked->createFilterQuery( 'excl' )->setQuery('-(host:uncyclopedia.wikia.com)');
		$dismax->setQueryFields('title_em^10 titleStrict title_en redirect_titles_mv_en');
		$dismax->setPhraseFields('titleStrict^8 title_en^2 redirect_titles_mv_en^2');

		$select = $service->prepareQuery( $query, 'en' );

		$this->assertEquals( $select, $mocked );
	}

}