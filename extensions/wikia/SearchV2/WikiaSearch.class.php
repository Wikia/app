<?php

class WikiaSearch extends WikiaObject {

	const RESULTS_PER_PAGE = 10;
	const RESULTS_PER_WIKI = 4;
	const GROUP_RESULTS_SEARCH_LIMIT = 500;
	const GROUP_RESULTS_CACHE_TTL = 900; // 15 mins
	const WIKIPAGES_CACHE_TTL = 604800; // 7 days
	const VIDEO_WIKI_ID = 298117;

	/**
	 * Search client
	 * @var WikiaSearchClient
	 */
	protected $client = null;
	protected $parserHookActive = false;
	protected $namespaces = array();

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
			        $methodOptions = array('size'   =>  self::GROUP_RESULTS_SEARCH_LIMIT,
						       'cityId' =>  $cityId );
				$results = $this->client->search( $query, $methodOptions );
				$results = $this->groupResultsPerWiki( $results );

				$this->setGroupResultsToCache( $query, $rankExpr, $results );
			}
			$results->setCurrentPage($page);
			$results->setResultsPerPage($length);

			if(!$results->valid() && $results->hasResults()) {
				// no more results in set, fetch more from backend
				// @todo implement
			}
		}
		else {
			// no grouping, e.g. intra-wiki searching

		        if ($this->namespaces) {
		            $this->client->setNamespaces($this->namespaces);
		        }

			$methodOptions = array('start'  => (($page - 1) * $length),
					       'length' => $length,
					       'cityId' => $cityId);

			$results = $this->client->search( $query, $methodOptions);
		}

		return $results;
	}

	/**
	 * @param string $query
	 * @param string $rankExpr
	 * @return WikiaSearchResultSet
	 */
	private function getGroupResultsFromCache($query, $rankExpr) {
		return $this->wg->Memc->get( $this->getGroupResultsCacheKey($query, $rankExpr) );
	}

	private function setGroupResultsToCache($query, $rankExpr, WikiaSearchResultSet $resultSet) {
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

				$set->totalScore += ($result->score > 0) ? $result->score : 0;

				$set->incrResultsFound();
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

		return F::build( 'WikiaSearchResultSet', array( 'results' => $sortedWikiResults, 'resultsFound' => $results->getResultsFound(), 'resultsStart' => $results->getResultsStart(), 'isComplete' => $results->isComplete(), 'query' => $results->getQuery() ) );
	}

	public function setClient( WikiaSearchClient $client ) {
		$this->client = $client;
	}

	public function getPages( $pageIds, $withMetaData = true ) {

	  $result = array('pages'=>array(), 'missingPages'=>array());

	  foreach (explode('|', $pageIds) as $pageId) {
	    try {
	      $result['pages'][$pageId] = $this->getPage( $pageId, $withMetaData );
	    } catch (WikiaException $e) {
	      /**
	       * here's how we will pretend that a page is empty for now. the risk is that if any of the 
	       * API code is broken in the getPage() method, it will tell the indexer to queue the page up 
	       * for removal from the index.
	       **/

	      $result['missingPages'][] = $pageId;
	    }

	  }

	  return $result;

	}

	/**
	 * ParserClearState hook handler
	 * @static
	 * @param $parser Parser
	 * @return bool
	 */
	public static function onParserClearState( &$parser ) {
		// prevent from caching when indexer is running to avoid infrastructure overload
		$parser->getOutput()->setCacheTime(-1);
		return true;
	}

	public function getPage( $pageId, $withMetaData = true ) {
		$result = array();

		$page = F::build( 'Article', array( $pageId ), 'newFromID' );

		if(!($page instanceof Article)) {
			throw new WikiaException('Invalid Article ID');
		}

		if(!$this->parserHookActive) {
			$this->app->registerHook('ParserClearState', 'WikiaSearch', 'onParserClearState');
			$this->parserHookActive = true;
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

		// clear output buffer in case we want get more pages
		$this->wg->Out->clearHTML();

		$result['wid'] = (int) $this->wg->CityId;
		$result['pageid'] = $page->getId();
		$result['sitename'] = $this->wg->Sitename;
		$result['title'] = $page->getTitle()->getText();
		$result['canonical'] = $canonical;
		$result['html'] = html_entity_decode($html, ENT_COMPAT, 'UTF-8'); // where are the other constants?
		$result['url'] = $page->getTitle()->getFullUrl();
		$result['ns'] = $page->getTitle()->getNamespace();
		$result['host'] = substr($this->wg->Server, 7);
		$result['lang'] = $this->wg->Lang->mCode;

		$result['iscontent'] = in_array( $result['ns'], $this->wg->ContentNamespaces );

		$result['is_main_page'] = ($page->getId() == Title::newMainPage()->getArticleId() && $page->getId() != 0);


		if( $withMetaData ) {
		  
		  $result = array_merge($result, $this->getPageMetaData($page));

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
			'inprop' => 'url|created|views|revcount',
			'meta' => 'siteinfo',
			'siprop' => 'statistics|wikidesc|variables|namespaces|category'
		));

		if( isset( $data['query']['pages'][$page->getId()] ) ) {
			$pageData = $data['query']['pages'][$page->getId()];
			$result['views'] = $pageData['views'];
			$result['revcount'] = $pageData['revcount'];
			$result['created'] = $pageData['created'];
			$result['touched'] = $pageData['touched'];
		}

		$result['hub'] = isset($data['query']['category']['catname']) ? $data['query']['category']['catname'] : '';
		$result['wikititle'] = isset($data['query']['wikidesc']['pagetitle']) ? $data['query']['wikidesc']['pagetitle'] : '';

		$statistics = $data['query']['statistics'];
		if(is_array($statistics)) {
			$result['wikipages'] = $statistics['pages'];
			$result['wikiarticles'] = $statistics['articles'];
			$result['activeusers'] = $statistics['activeusers'];
			$result['wiki_images'] = $statistics['images'];
		}
		
		$result['redirect_titles'] = $this->getRedirectTitles($page);

		$wikiViews = $this->getWikiViews($page);

		$result['wikiviews_weekly'] = (int) $wikiViews->weekly;
		$result['wikiviews_monthly'] = (int) $wikiViews->monthly;

		return $result;
	}

	
	private function getRedirectTitles( Article $page ) {

	        $result = $page->getDB()->selectRow(array('redirect', 'page'), 
						    array('GROUP_CONCAT(page_title SEPARATOR " | ") AS redirect_titles'), 
						    array(),
						    __METHOD__,
						    array('GROUP'=>'rd_title'),
						    array('page' => array('INNER JOIN', array('rd_title'=>$page->mTitle->getDbKey(), 'page_id = rd_from')))
						    );

		return (!empty($result)) ? str_replace('_', ' ', $result->redirect_titles) : '';

	}


	private function getWikiViews( Article $page ) {

	        $key = $this->wf->SharedMemcKey( 'WikiaSearchPageViews', $this->wg->CityId );

		// should probably re-poll for wikis without much love
	        if ( ($result = $this->wg->Memc->get( $key )) && ($result->weekly > 0 || $result->monthly > 0) ) {

		    return $result;

		}

	        $db = wfGetDB( DB_SLAVE, array(), $this->wg->statsDB );
		
	        $row = $db->selectRow(array('page_views'),
				      array('SUM(pv_views) as "monthly"',
					    'SUM(CASE WHEN pv_ts >= DATE_SUB(DATE(NOW()), INTERVAL 7 DAY) THEN pv_views ELSE 0 END) as "weekly"'),
				      array('pv_city_id' => (int) $this->wg->CityId,
					    'pv_ts >= DATE_SUB(DATE(NOW()), INTERVAL 30 DAY)'),
				      __METHOD__
						 );

		// a pinch of defensive programming
		if (!$row) {

		   $row = new stdClass();
		   $row->weekly = 0;
		   $row->monthly = 0;

		}

		$this->wg->Memc->set( $key, $row, self::WIKIPAGES_CACHE_TTL );

		return $row;
	}


	public function getRelatedVideos($pageId, $start=0, $size=20) {

	         # going to need an "is_video" field
	         $params['fq'] = '(wid:' . $this->wg->cityId . ' OR wid:' . self::VIDEO_WIKI_ID . '^10) '
		               . 'AND ns:6 AND -title:(jpg gif png jpeg)';
		 $params['mlt.boost'] = 'true';
		 $params['mpt.maxnpt'] = '200';
		 $params['mlt.fl'] = 'title,html';
		 $params['start'] = $start;
		 $params['size'] = $size;

		 $query = sprintf('wid:%d AND pageid:%d', $this->wg->cityId, $pageId);

	         $similarPages = $this->client->getSimilarPages($query, $params);

		 $response = array();
		 foreach ($similarPages as $similarPage)
		 {
		     $response[$similarPage->url] = array('wid'=>$similarPage->wid, 'pageid'=>$similarPage->pageid);
		 }

		 return $response;
	}




	private function callMediaWikiAPI( Array $params ) {
		$api = F::build( 'ApiMain', array( 'request' => new FauxRequest($params) ) );
		$api->execute();

		return  $api->getResultData();
	}


	public function setNamespaces(array $namespaces)
	{
	       $this->namespaces = $namespaces;
	}

	public function getNamespaces()
	{
	       return $this->namespaces;
	}

}