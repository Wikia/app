<?php
/**
 * Created by PhpStorm.
 * User: jacek
 * Date: 20.02.14
 * Time: 16:26
 */

namespace Wikia\Search;
use Wikia\Search\Config, Wikia\Search\QueryService\Factory, Wikia\Search\QueryService\DependencyContainer;

class KeywordSearch {

	protected $client;

	public function __construct() {
		$config = (new Factory())->getSolariumClientConfig();
		$this->client = new \Solarium_Client($config);
	}

	//FIXME: temporary, for spike purposes we are testing a few methods
	public function getResults( $query, $mode = 'default' ) {
		$method = 'getResults'.ucfirst($mode);
		if ( !method_exists( $this, $method ) ) {
			$method = 'getResultsDefault';
		}
		return $this->$method( $query );
	}

	public function getResultsDefault( $query ) {

		$select = $this->client->createSelect();
		$dismax = $select->getDisMax();
		$dismax->setQueryParser('edismax');
		$select->setRows(10);
		$select->setQuery( "nolang_txt:($query) AND article_quality_i:[50 TO *] lang:en" );

		//add filters
		$select->createFilterQuery( 'ns' )->setQuery('ns:0');


		$result = $this->client->select( $select );
		$res = [];
		foreach( $result->getDocuments() as $doc ) {
			$res[] = $doc->url;
		}

		return $res;
	}

} 