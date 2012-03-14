<?php

class WikiaSearch extends WikiaObject {

	const RESULTS_PER_PAGE = 10;
	const RESULTS_PER_WIKI = 4;
	const GROUP_RESULTS_SEARCH_LIMIT = 500;
	const GROUP_RESULTS_CACHE_TTL = 900; // 15 mins

	/**
	 * Search client
	 * @var WikiaSearchClient
	 */
	protected $client = null;

	public function __construct( WikiaSearchClient $client ) {
		$this->client = $client;
		parent::__construct();
	}

	/**
	 * perform search
	 *
	 * @param string $query
	 * @param int $page
	 * @param int $length
	 * @param int $cityId
	 * @param string $rankExpr
	 * @param bool $groupResults
	 * @return WikiaSearchResultSet
	 */
	public function doSearch( $query, $page = 1, $length = null, $cityId = 0, $rankExpr = '', $groupResults = false ) {
		$length = !empty($length) ? $length : self::RESULTS_PER_PAGE;
		$groupResults = ( empty($cityId) && $groupResults );

		if($groupResults) {
			$results = $this->getGroupResultsFromCache($query, $rankExpr);

			if(empty($results) || isset($_GET['skipCache'])) {
				$results = $this->client->search( $query, 0, self::GROUP_RESULTS_SEARCH_LIMIT, $cityId, $rankExpr );
//echo "<pre>";
//var_dump($results);
//exit;
				$results = $this->groupResultsPerWiki( $results );

				$this->setGroupResultsToCahce( $query, $rankExpr, $results );
			}
			$results->setCurrentPage($page);
			$results->setResultsPerPage($length);
var_dump($results->valid());
		}
		else {
			// no grouping, e.g. intra-wiki searching
			$results = $this->client->search( $query, ( ($page - 1) * $length ), $length, $cityId, $rankExpr );
		}

		return $results;
	}

	private function getGroupResultsFromCache($query, $rankExpr) {
		return $this->wg->Memc->get( $this->getGroupResultsCacheKey($query, $rankExpr) );
	}

	private function setGroupResultsToCahce($query, $rankExpr, WikiaSearchResultSet $resultSet) {
		$this->wg->Memc->set( $this->getGroupResultsCacheKey($query, $rankExpr), $resultSet, self::GROUP_RESULTS_CACHE_TTL );
	}

	private function getGroupResultsCacheKey($query, $rankExpr) {
		return $this->wf->SharedMemcKey( 'WikiaSearchResultSet', md5($query.$rankExpr) );
	}

	private function groupResultsPerWiki(WikiaSearchResultSet $results) {
		$wikiResults = array();
		$wikisByScore = array();

		foreach($results as $result) {
			if($result instanceof WikiaSearchResult) {
				$cityId = $result->getCityId();
				if(!isset($wikiResults[$cityId])) {
					$wikiResultSet = F::build( 'WikiaSearchResultSet' );
					$wikiResultSet->setHeader('cityTitle', WikiFactory::getVarValueByName( 'wgSitename', $cityId ));
					$wikiResultSet->setHeader('cityUrl', WikiFactory::getVarValueByName( 'wgServer', $cityId ));
					$wikiResultSet->setHeader('cityArticlesNum', $result->getVar('cityArticlesNum', false));
					$wikiResultSet->setHeader('1stResultPos', $result->getVar('position', 0));

					$wikiResults[$cityId] = $wikiResultSet;
				}
				$set = $wikiResults[$cityId];
				if($set->getResultsNum() < self::RESULTS_PER_WIKI) {
					$set->addResult($result);
				}

				$set->totalScore += $result->score;

				$set->incrResultsFound();
				$set->setHeader('cityRank', $this->getWikiRank($set));
				$wikisByScore['id:'.$cityId] = $set->totalScore; //((1+$set->totalScore)/log($set->getHeader('1stResultPos')+1, 2));
			} else {
			  $wikisByScore['id'.$result->getCityId()] = $result->score; //(1+$result->score) / log($result->getVar('position')+1, 2);
			}
		}


		arsort($wikisByScore);

		$sortedWikiResults = array();

		# create an ordered result set based on score
		array_walk(array_keys($wikisByScore),
			   function($key) use (&$sortedWikiResults, &$wikiResults) {
			     $sortedWikiResults[] = $wikiResults[str_replace('id:', '', $key)];
			   });

		return F::build( 'WikiaSearchResultSet', array( 'results' => $sortedWikiResults, 'resultsFound' => $results->getResultsFound(), 'resultsStart' => $results->getResultsStart(), 'isComplete' => $results->isComplete() ) );
	}

	private function getWikiRank(WikiaSearchResultSet $wikiResults) {
		$articlesNum = (int) $wikiResults->getHeader('cityArticlesNum');
		$resultsNum = $wikiResults->getResultsFound();
		$firstResultPos = $wikiResults->getHeader('1stResultPos');
		return round(( 1 / $firstResultPos ) * ( 1 + log($articlesNum))) + $resultsNum; //round( ( ( 1 / $firstResultPos ) * ( 1 + ln($articlesNum) ) ) + $resultsNum );
	}

	public function setClient( WikiaSearchClient $client ) {
		$this->client = $client;
	}

	public function getPage( $pageId, $withMetaData = true ) {
		$result = array();

		$page = F::build( 'Article', array( $pageId ), 'newFromID' );

		if(!($page instanceof Article)) {
			throw new WikiaException('Invalid Article ID');
		}

		// hack: setting wgTitle as rendering fails otherwise
		$wgTitle = $this->wg->Title;
		$this->wg->Title = $page->getTitle();

		// hack: setting action=render to exclude "Related Pages" and other unwanted stuff
		$wgRequest = $this->wg->Request;
		$this->wg->Request->setVal('action', 'render');

		if( $page->isRedirect() ) {
			$redirectPage = F::build( 'Article', array( $page->getRedirectTarget() ) );
			$redirectPage->loadContent();

			// hack: setting wgTitle as rendering fails otherwise
			$this->wg->Title = $page->getRedirectTarget();

			$redirectPage->render();
			$canonical = $page->getRedirectTarget()->getPrefixedText();
		}
		else {
			$page->render();
			$canonical = '';
		}

		$html = $this->wg->Out->getHTML();
		$result['wid'] = (int) $this->wg->CityId;
		$result['pageid'] = $page->getId();
		$result['sitename'] = $this->wg->Sitename;
		$result['title'] = $page->getTitle()->getText();
		$result['canonical'] = $canonical;
		$result['html'] = $html;
		$result['bytes'] = strlen($html);
		$result['words'] = count( preg_split('/\w+/', $html) );
		$result['url'] = $page->getTitle()->getFullUrl();
		$result['ns'] = $page->getTitle()->getNamespace();
		$result['host'] = substr($this->wg->Server, 7);

		$result['iscontent'] = in_array( $result['ns'], $this->wg->ContentNamespaces );
		if($page->getId() == Title::newMainPage()->getArticleId() && $page->getId() != 0) {
			$result['ismainpage'] = true;
		}
		else {
			$result['ismainpage'] = false;
		}

		if( $withMetaData ) {
			$result['metadata'] = $this->getPageMetaData( $page );
		}

		// restore global state
		$this->wg->Title = $wgTitle;
		$this->wg->Request = $wgRequest;

		return $result;
	}

	public function getPageMetaData( $page ) {
		$result = array();

		$data = $this->callMediaWikiAPI( array(
			'titles' => $page->getTitle(),
			'bltitle' => $page->getTitle(),
			'action' => 'query',
			'list' => 'backlinks',
			'blcount' => 1
		));

		if( isset($data['query']['backlinks_count'] ) ) {
			$result['backlinks'] = $data['query']['backlinks_count'];
		}
		else {
			$result['backlinks'] = 0;
		}


		$data = $this->callMediaWikiAPI( array(
			'pageids' => $page->getId(),
			'action' => 'query',
			'prop' => 'info',
			'inprop' => 'url|created|views|revcount'
		));

		if( isset( $data['query']['pages'][$page->getId()] ) ) {
			$pageData = $data['query']['pages'][$page->getId()];
			$result['views'] = $pageData['views'];
			$result['revcount'] = $pageData['revcount'];
			$result['created'] = $pageData['created'];
			$result['touched'] = $pageData['touched'];
		}

		$data = $this->callMediaWikiAPI( array(
			'action' => 'query',
			'meta' => 'siteinfo',
			'siprop' => 'statistics|wikidesc|variables|namespaces|category'
		));

		$result['hub'] = isset($data['query']['category']['catname']) ? $data['query']['category']['catname'] : '';
		$result['wikititle'] = isset($data['query']['wikidesc']['pagetitle']) ? $data['query']['wikidesc']['pagetitle'] : '';

		$statistics = $data['query']['statistics'];
		if(is_array($statistics)) {
			$result['wikipages'] = $statistics['pages'];
			$result['wikiarticles'] = $statistics['articles'];
			$result['activeusers'] = $statistics['activeusers'];
		}

		return $result;
	}

	private function callMediaWikiAPI( Array $params ) {
		$api = F::build( 'ApiMain', array( 'request' => new FauxRequest($params) ) );
		$api->execute();

		return  $api->getResultData();
	}

}