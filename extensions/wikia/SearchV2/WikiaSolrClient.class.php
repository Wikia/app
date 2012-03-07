<?php

class WikiaSolrClient extends WikiaSearchClient {

	protected $solrClient = null;

	public function __construct( $solrHost, $solrPort ) {
		$this->solrClient = F::build( 'Apache_Solr_Service', array( 'host' => $solrHost, 'port' => $solrPort, 'path' => '/solr' ) );
	}

	public function search( $query, $start, $size, $cityId = 0, $rankExpr = '' ) {
		$params = array(
			'fl' => 'title,canonical,url,host,bytes,words,ns,lang,indexed,created,views,wid,pageid,revcount,backlinks,wikititle,wikiarticles,wikipages,activeusers', // fields we want to fetch back
			'qf' => 'title^5 html',
			'hl' => 'true',
			'hl.fl' => 'html,title', // highlight field
			'hl.snippets' => '1', // number of snippets per field
			'hl.fragsize' => '150', // snippet size in characters
			'hl.simple.pre' => '<span class="searchmatch">',
			'hl.simple.post' => '</span>',
			'f.html.hl.alternateField' => 'html',
			'f.html.hl.maxAlternateFieldLength' => 300,
			'indent' => 1,
			'timeAllowed' => 5000
		);

		$queryClauses = array();
		$sanitizedQuery = $this->sanitizeQuery($query);

		$onWikiId = ( !empty( $this->wg->SolrDebugWikiId ) ) ? $this->wg->SolrDebugWikiId : $cityId;

		if( empty($onWikiId) ) {
			// Inter-wiki searching mode
			$widQuery = '';

			foreach ($this->getInterWikiSearchExcludedWikis($onWikiId) as $excludedWikiId) {
				if($onWikiId == $excludedWikiId) {
					continue;
				}

				$widQuery .= ( !empty($widQuery) ? ' AND ' : '' ) . '!wid:' . $excludedWikiId;
			}

			$queryClauses[] = $widQuery;

			$params['bf'] = 'map(backlinks,100,1000,100)^2';
			$params['bq'] = '(*:* -html:(' . $sanitizedQuery . '))^10 host:(' . $sanitizedQuery . '.wikia.com)^20';
			$params['fq'] = ( !empty( $params['fq'] ) ? "(" . $params['fq'] . ") AND " : "" ) . $widQuery . " AND lang:en AND iscontent:true";
		}
		else {
			// Intra-wiki searching mode

			/* tmp hack: content namespaces only
			if(count($namespaces)) {
				$nsQuery = '';
				foreach($namespaces as $namespace) {
					$nsQuery .= ( !empty($nsQuery) ? ' OR ' : '' ) . 'ns:' . $namespace;
				}
				$queryClauses[] = "({$nsQuery})";
			}
			*/
			$queryClauses[] = "iscontent: true";

			array_unshift($queryClauses, "wid: {$onWikiId}");
		}

		$dismaxParams = "{!dismax qf='html^0.8"
						." title^5'"
						." pf='html^0.8"
						." title^5'"
						." mm=75"
						." ps=10"
						." tie=1"
						. "}";

		$queryClauses[] = '_query_:"' . $dismaxParams . $sanitizedQuery . '"';
		$sanitizedQuery = implode(' AND ', $queryClauses);

		try {
			$response = $this->solrClient->search($sanitizedQuery, $start, $size, $params);
		}
		catch (Exception $exception) {
			// error logging, fallback etc.
		}

		$results = $this->getWikiaResults($response->response->docs, ( is_object($response->highlighting) ? get_object_vars($response->highlighting) : array() ) );

		return F::build( 'WikiaSearchResultSet', array( 'results' => $results, 'resultsFound' => $response->response->numFound, 'resultsStart' => $response->response->start ) );
	}

	private function getWikiaResults(Array $solrDocs, Array $solrHighlighting) {
		$results = array();
		foreach($solrDocs as $doc) {
			$result = F::build( 'WikiaSearchResult', array( 'id' => 'c'.$doc->wid.'p'.$doc->pageid ) );
			$result->setCityId($doc->wid);
			$result->setTitle($doc->title);
			$result->setText($solrHighlighting[$doc->url]->html[0]);
			$result->setUrl($doc->url);
			if(!empty($doc->canonical)) {
				$result->setCanonical($doc->canonical);
			}

			$result->setVar('backlinks', $doc->backlinks);
			$result->setVar('cityArticlesNum', $doc->wikiarticles);

			$results[] = $result;
		}

		return $results;
	}


	/**
	 * any query string transformation before sending to backend should be placed here
	 */
	private function sanitizeQuery($query) {
		// non-indexed number-string phrases issue workaround (RT #24790)
		$query = preg_replace('/(\d+)([a-zA-Z]+)/i', '$1 $2', $query);

		// escape all lucene special characters: + - && || ! ( ) { } [ ] ^ " ~ * ? : \ (RT #25482)
		$query = Apache_Solr_Service::escape($query);

		return $query;
	}

/**
	 * get list of wikis excluded from inter-wiki searching
	 * @return array
	 */
	private function getInterWikiSearchExcludedWikis($currentWikiId = 0) {
		$wg = F::app()->wg;
		$cacheKey = F::app()->wf->SharedMemcKey( 'crossWikiaSearchExcludedWikis' );
		$privateWikis = $wg->Memc->get( $cacheKey );

		if(!is_array($privateWikis)) {
			// get private wikis from db
			$wgIsPrivateWiki = WikiFactory::getVarByName( 'wgIsPrivateWiki', $currentWikiId );
			$privateWikis = WikiFactory::getCityIDsFromVarValue( $wgIsPrivateWiki->cv_id, true, '=' );
			$wg->Memc->set( $cacheKey, $privateWikis, 3600 ); // cache for 1 hour
		}

		return count( $privateWikis ) ? array_merge( $privateWikis, $wg->CrossWikiaSearchExcludedWikis ) : $wg->CrossWikiaSearchExcludedWikis;
	}

}