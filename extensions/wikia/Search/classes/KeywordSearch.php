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


	public function getResultsMode2( $query ) {

		$maxPhrases = 10;
		$phrases = array_slice( explode(",", $query), 0, $maxPhrases );

		$phraseQuery = [];
		foreach ( $phrases as $phrase ) {
			$phraseQuery[] = ' nolang_txt:("' . $phrase . '") ';
		}

		$select = $this->client->createSelect();
		$dismax = $select->getDisMax();
		$dismax->setQueryParser('edismax');
		$select->setRows(10);
		$select->setQuery( "( " . implode(" OR ", $phraseQuery) . ") AND article_quality_i:[50 TO *] lang:en" );

		//add filters
		$select->createFilterQuery( 'ns' )->setQuery('ns:0');


		$result = $this->client->select( $select );
		$res = [];
		foreach( $result->getDocuments() as $doc ) {
			$res[] = $doc->url;
		}

		return $res;
	}

	public function getResultsMode3( $query ) {
		$maxPhrases = 5;
		$phrases = array_slice( explode(",", $query), 0, $maxPhrases );
		$phraseQuery = [];
		foreach ( $phrases as $phrase ) {
			$phraseQuery[] = ' title_en:("' . $phrase . '") ';
		}

		$select = $this->client->createSelect();
		$dismax = $select->getDisMax();
		$dismax->setQueryParser('edismax');
		$select->setRows(10);
		$select->setQuery( "( " . implode(" OR ", $phraseQuery) . ") AND article_quality_i:[50 TO *] lang:en" );

		//add filters
		$select->createFilterQuery( 'ns' )->setQuery('ns:0');


		$result = $this->client->select( $select );
		$res = [];
		foreach( $result->getDocuments() as $doc ) {
			$res[] = $doc->url;
		}

		return $res;
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

	public function getResultsSimple( $query ) {
		wfProfileIn(__METHOD__);

		$select = $this->client->createSelect();
		$dismax = $select->getDisMax();
		$dismax->setQueryParser('edismax');
		$select->setRows(10);
		$select->setQuery( "nolang_txt:(\"".implode('" "',$query)."\") AND +(article_quality_i:[50 TO *] AND lang:en)" );

		//add filters
		$select->createFilterQuery( 'ns' )->setQuery('ns:0');

		$result = $this->client->select( $select );
		$res = [];
		foreach( $result->getDocuments() as $doc ) {
			$res[] = $doc->url;
		}
		wfProfileOut(__METHOD__);
		return $res;
	}

	public function getResults5only( $query ) {
		wfProfileIn(__METHOD__);

		$query = array_slice($query, 0, 5);

		$select = $this->client->createSelect();
		$dismax = $select->getDisMax();
		$dismax->setQueryParser('edismax');
		$select->setRows(10);
		$select->setQuery( "nolang_txt:(\"".implode('" "',$query)."\") AND +(article_quality_i:[50 TO *] AND lang:en)" );

		//add filters
		$select->createFilterQuery( 'ns' )->setQuery('ns:0');

		$result = $this->client->select( $select );
		$res = [];
		foreach( $result->getDocuments() as $doc ) {
			$res[] = $doc->url;
		}
		wfProfileOut(__METHOD__);
		return $res;
	}

	public function getResults5onlyhtml( $query ) {
		wfProfileIn(__METHOD__);

		$query = array_slice($query, 0, 5);

		$select = $this->client->createSelect();
		$dismax = $select->getDisMax();
		$dismax->setQueryParser('edismax');
		$select->setRows(10);
		$select->setQuery( "html_en:(\"".implode('" "',$query)."\") AND +(article_quality_i:[50 TO *] AND lang:en)" );

		//add filters
		$select->createFilterQuery( 'ns' )->setQuery('ns:0');

		$result = $this->client->select( $select );
		$res = [];
		foreach( $result->getDocuments() as $doc ) {
			$res[] = $doc->url;
		}
		wfProfileOut(__METHOD__);
		return $res;
	}

	public function getResultsTitle( $query ) {
		wfProfileIn(__METHOD__);

		$qs = [];
		foreach( $query as $q ) {
			$qs = array_merge( $qs, explode(" ", $q) );
		}

		$select = $this->client->createSelect();
		$dismax = $select->getDisMax();
		$dismax->setQueryParser('edismax');
		$select->setRows(10);
		$select->setQuery( "html_en:(".implode(' ',$qs).") AND +(article_quality_i:[50 TO *] AND lang:en)" );

		//add filters
		$select->createFilterQuery( 'ns' )->setQuery('ns:0');
		$select->createFilterQuery( 'lyrcis' )->setQuery('-(wid:43339)');

		$result = $this->client->select( $select );
		$res = [];
		foreach( $result->getDocuments() as $doc ) {
			$res[] = $doc->url;
		}
		wfProfileOut(__METHOD__);
		return $res;
	}

} 