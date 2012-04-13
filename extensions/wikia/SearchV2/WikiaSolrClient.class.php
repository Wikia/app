<?php

class WikiaSolrClient extends WikiaSearchClient {

        protected $solrClient, $solrPort, $solrHost, $query;
	protected $namespaces = array();
	protected $isInterWiki = false;

	public function __construct( $solrHost, $solrPort ) {
	        $this->solrHost = $solrHost;
	        $this->solrPort = $solrPort;
		$this->solrClient = F::build( 'Apache_Solr_Service', array( 'host' => $solrHost, 'port' => $solrPort, 'path' => '/solr' ) );
	}

	public function search( $query, $start, $size, $cityId = 0, $rankExpr = '', $skipBoostFunctions=false ) {
	        $this->query = $query;
		$this->isInterWiki = false;

		$params = array(
			'fl' => '*,score',
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

		$params['spellcheck'] = 'true';
		$params['spellcheck.q'] = $sanitizedQuery;
		$params['spellcheck.onlyMorePopular'] = 'true';
		$params['spellcheck.collate'] = 'true';

		$onWikiId = ( !empty( $this->wg->SolrDebugWikiId ) ) ? $this->wg->SolrDebugWikiId : $cityId;

		if( empty($onWikiId) ) {
			// Inter-wiki searching mode
			$widQuery = '';
			$this->isInterWiki == true;

			foreach ($this->getInterWikiSearchExcludedWikis($onWikiId) as $excludedWikiId) {
				if($onWikiId == $excludedWikiId) {
					continue;
				}

				$widQuery .= ( !empty($widQuery) ? ' AND ' : '' ) . '!wid:' . $excludedWikiId;
			}

			$queryClauses[] = $widQuery;

			// disabled because of indexing problem
			
			if ($this->solrHost != 'search-s1') {
			    $queryClauses[] = "lang:en";
			}
			$queryClauses[] = "iscontent:true";
		}
		else {

		  if (  empty($this->namespaces) ) {

			$queryClauses[] = "(ns:0 OR ns:14)";
			$this->namespaces = array(0, 14);

		  } else { 

			$nsQuery = '';
			foreach($this->namespaces as $namespace) {
				$nsQuery .= ( !empty($nsQuery) ? ' OR ' : '' ) . 'ns:' . $namespace;
			}

			$queryClauses[] = "({$nsQuery})";
		  }

			array_unshift($queryClauses, "wid: {$onWikiId}");
		}

		$queryNoQuotes = self::sanitizeQuery(preg_replace("/['\"]/", '', $query));

		$boostQueries = array('html:\"'.$queryNoQuotes.'\"^5',
				      'title:\"'.$queryNoQuotes.'\"^10');

		$boostFunctions = array();

		if (empty($onWikiId)) {
		  // this is still pretty important!
		  $boostQueries[] = 'wikititle:\"'.$queryNoQuotes.'\"^15';

		  # we can do this because the host is a text field
		  if (!$this->includeAnswers($query)) {
		    $boostQueries[] = '-host:\"answers\"^10';
		    $boostQueries[] = '-host:\"respuestas\"^10';
		  }

		  if (!$skipBoostFunctions) {
		    global $wikipagesBoost, $activeusersBoost, $revcountBoost, $viewBoost;

		    $wikipagesBoost = isset($_GET['page_boost']) ? $_GET['page_boost'] : 4 ;
		    $boostFunctions[] = 'log(wikipages)^'.$wikipagesBoost;

		    $activeusersBoost = isset($_GET['activeusers_boost']) ? $_GET['activeusers_boost'] : 4;
		    $boostFunctions[] = 'log(activeusers)^'.$activeusersBoost;

		    $revcountBoost = isset($_GET['revcount_boost']) ? $_GET['revcount_boost'] : 1;
		    $boostFunctions[] = 'log(revcount)^'.$revcountBoost;


		    $viewBoost = isset($_GET['views_boost']) ? $_GET['views_boost'] : 8;
		    $boostFunctions[] = 'log(views)^'.$viewBoost;

		    $boostFunctions[] = 'log(words)^0.5';
		  }

		}

		$dismaxParams = array('qf'	=>	"'html^0.8 title^5'",
				      'pf'	=>	"'html^0.8 title^5'",
				      'ps'	=>	'3',
				      'tie'	=>	'0.01',
				      'bq'	=>	"\'".implode(' ', $boostQueries)."\'",
				      'mm'      =>      '66%'
				     );

		if (!empty($boostFunctions)) {
		  $dismaxParams['bf'] = sprintf("'%s'", implode(' ', $boostFunctions));
		}

		array_walk($dismaxParams, function($val,$key) use (&$paramString) {$paramString .= "{$key}={$val} "; });

		$queryClauses[] = sprintf('_query_:"{!dismax %s}%s"',
					  $paramString,
					  $sanitizedQuery);

		$sanitizedQuery = implode(' AND ', $queryClauses);

		try {
			$response = $this->solrClient->search($sanitizedQuery, $start, $size, $params);
		}
		catch (Exception $exception) {
		  if (!$skipBoostFunctions) {
		    return $this->search($query, $start, $size, $cityId, $rankExpr, true);
		  }
		}


		if (empty($response->response->docs) &&
		   !empty($response->spellcheck->suggestions) && 
		    $response instanceOf Apache_Solr_Response) {

		    $newQuery = $response->spellcheck->suggestions->collation;

		    return $this->search($newQuery, $start, $size, $cityId, $rankExpr);

		} 

		$docs = ($response->response->docs) ?: array();

		$results = $this->getWikiaResults($docs, ( is_object($response->highlighting) ? get_object_vars($response->highlighting) : array() ) );

		return F::build( 'WikiaSearchResultSet', array( 'results' => $results, 'resultsFound' => $response->response->numFound, 'resultsStart' => $response->response->start, 'isComplete' => false, 'query' => $query ) );
	}

	private function getWikiaResults(Array $solrDocs, Array $solrHighlighting) {
		$results = array();
		$position = 1;

		$articleMatchId = '';

		if ((!$this->isInterWiki) && ($article = self::createArticleMatch($this->query))) {
		        global $wgCityId, $wgUser;
			$title = $article->getTitle();
			if (in_array($title->getNamespace(), $this->namespaces)) {
			  $articleMatchId = 'c'.$wgCityId.'p'.$article->getID();
			  $result = F::build( 'WikiaSearchResult', array( 'id' => $articleMatchId) );
			  $articleService = new ArticleService($article->getID());
			  $result->setCityId($wgCityId);
			  $result->setTitle($article->mTitle);
			  $result->setText($articleService->getTextSnippet(250));
			  $result->setUrl(urldecode($title->getFullUrl()));
			  $result->score = '100%';
			  $result->setVar('position', $position);
			  $result->setVar('isArticleMatch', true);
			  $results[] = $result;
			  $position++;
			}
		}

		foreach($solrDocs as $doc) {
		        $id = 'c'.$doc->wid.'p'.$doc->pageid;
			if ($articleMatchId == $id) {
			  continue;
			}
			$result = F::build( 'WikiaSearchResult', array( 'id' => $id ) );
			$result->setCityId($doc->wid);
			$result->setTitle($doc->title);
			$result->setText($solrHighlighting[$doc->url]->html[0]);
			$result->setUrl(urldecode($doc->url));
			$result->setScore(($doc->score) ?: 0);

			if(!empty($doc->canonical)) {
				$result->setCanonical($doc->canonical);
			}

			$result->setVar('backlinks', $doc->backlinks);
			$result->setVar('cityArticlesNum', $doc->wikiarticles);
			$result->setVar('position', $position);
			$result->setVar('cityHost', 'http://'.$doc->host);

			$results[] = $result;
			$position++;
		}

		return $this->deDupeResults($results);
	}

	private function deDupeResults(Array $results) {
		$canonicals = array();
		$deDupedResults = array();

		/**
		 * @var $result WikiaSearchResult
		 */
		foreach($results as $result) {
			if(!isset($canonicals[$result->getCityId()])) {
				$canonicals[$result->getCityId()] = array();
			}

			if($result->hasCanonical()) {
				if(!in_array($result->getCanonical(), $canonicals[$result->getCityId()])) {
					$canonicals[$result->getCityId()][] = $result->getCanonical();
					$deDupedResults[md5($result->getCityId().$result->getCanonical())] = $result->deCanonize();
				}
				else {
					// already have redirected document, do nothing
					continue;
				}
			}
			else if(!in_array($result->getTitle(), $canonicals[$result->getCityId()])) {
				$canonicals[$result->getCityId()][] = $result->getTitle();
				$deDupedResults[md5($result->getCityId().$result->getTitle())] = $result;
			}
			else {
				// redirect was first for this document, replace it
				$deDupedResults[md5($result->getCityId().$result->getTitle())] = $result;
			}
		}

		return array_values($deDupedResults);
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

	/**
	 * Designed as a method so we can make it more complex if we want to -- ex: syntactic parsing to determine question
	 *
	 */
	protected function includeAnswers($query)
	{
	  return substr_count($query, "answers") > 0;
	}

	public function getSimilarPages($wid, $pageId, array $params = array())
	{

	      $query = sprintf('wid:%d AND pageid:%d', $wid, $pageId);

	      if (isset($params['start'])) {
		  $start = $params['start'];
		  unset($params['start']);
	      } else {
		  $start = 0;
	      }

	      if (isset($params['size'])) {
		  $size = $params['size'];
		  unset($params['size']);
	      } else {
		  $size = 10;
	      }

	      $params = array('mlt.match.include' => 'false',
			      'mlt.fl' => 'html',
			     ) + $params;
	      

	      try {
		$response = $this->solrClient->moreLikeThis($query, $start, $size, $params);
	      } catch (Exception $e) {
		echo $e; die;
	      }


	      return $response->response->docs;

	}

	public function setNamespaces(array $namespaces)
	{
	       $this->namespaces = $namespaces;
	}

	public function getNamespaces()
	{
	       return $this->namespaces;
	} 

	public static function createArticleMatch( $term ) {
		// Try to go to page as entered.
		$title = Title::newFromText( $term );
		# If the string cannot be used to create a title
		if( is_null( $title ) ) {
			return null;
		}

		$searchWithNamespace = $title->getNamespace() != 0 ? true : false;
		// If there's an exact or very near match, jump right there.
		$title = SearchEngine::getNearMatch( $term );
		if( !is_null( $title ) && ( $searchWithNamespace || $title->getNamespace() == NS_MAIN || $title->getNamespace() == NS_CATEGORY) ) {
			$article = new Article( $title );
			if($article->isRedirect()) {
				return new Article($article->getRedirectTarget());
			}
			else {
				return $article;
			}
		}

		return null;
	}



}