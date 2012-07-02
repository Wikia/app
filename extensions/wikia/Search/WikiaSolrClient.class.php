<?php

class WikiaSolrClient extends WikiaSearchClient {

	protected $solrClient;
	protected $solrPort;
	protected $solrHost;
	protected $query;
	protected $namespaces = array();
	protected $isInterWiki = false;
	protected $articleMatch;
	protected $paginatedSearch = false;

	const DEFAULT_RESULTSET_START = 0;
	const DEFAULT_RESULTSET_SIZE = 20;
	const DEFAULT_CITYID = 0;

	public function __construct( $solrHost, $solrPort ) {
		$this->solrHost = $solrHost;
		$this->solrPort = $solrPort;
		$this->solrClient = F::build( 'Apache_Solr_Service', array( 'host' => $solrHost, 'port' => $solrPort, 'path' => '/solr' ) );
	}

	/**
	 *  $methodOptions supports the following possible values:
	 *  $start=0, $size=20, $cityId = 0, $skipBoostFunctions=false, $namespaces, $isInterWiki, $includeRedirects = true, $solrDebugWikiId = false, $spellCheck, $hub
	 **/
	public function search( $query,  array $methodOptions = array() ) {
		wfProfileIn(__METHOD__);

		extract($methodOptions);

		$start              = isset($start)              ? $start              : self::DEFAULT_RESULTSET_START;
		$size               = isset($size)               ? $size               : self::DEFAULT_RESULTSET_SIZE;
		$cityId             = isset($cityId)             ? $cityId             : self::DEFAULT_CITYID;
		$skipBoostFunctions = isset($skipBoostFunctions) ? $skipBoostFunctions : false;
		$includeRedirects   = isset($includeRedirects)   ? $includeRedirects   : true;
		$rank               = isset($rank)               ? $rank               : 'default';
		$solrDebugWikiId    = isset($solrDebugWikiId)    ? $solrDebugWikiId    : false;
		$spellCheck         = isset($spellCheck)         ? $spellCheck         : false;
		$hub				= isset($hub)				 ? $hub				   : false;
		$spellCheckHappened = isset($spellCheckHappened) ? $spellCheckHappened : false;

		if (!isset($namespaces)) {
			$namespaces = $this->namespaces ?: SearchEngine::DefaultNamespaces();
		} 

		$this->query = $query;

		$this->paginatedSearch = $start != self::DEFAULT_RESULTSET_START;

		if ($queryNamespace = MWNamespace::getCanonicalIndex(array_shift(explode(':', strtolower($query))))) {
			if (!in_array($queryNamespace, $namespaces)) {
				$namespaces[] = $queryNamespace;
			}
			$query = implode(':', array_slice(explode(':', $query), 1));
		}

		$this->setNamespaces($namespaces);

		$this->isInterWiki = isset($isInterWiki) ? $isInterWiki : false;

		$params = array(
						# html makes the response too big
				'fl' => 'wikiarticles,bytes,words,wikititle,wikipages,pageid,url,wid,canonical,hub,lang,host,ns,indexed,title,score,backlinks',
				'qf' => 'title^5 html',
				'hl' => 'true',
				'hl.fl' => 'html,title', // highlight field
				'hl.requireFieldMatch' => 'true',
				'hl.snippets' => '1', // number of snippets per field
				'hl.fragsize' => '150', // snippet size in characters
				'hl.simple.pre' => '<span class="searchmatch">',
				'hl.simple.post' => '</span>',
				'f.html.hl.alternateField' => 'html',
				'f.html.hl.maxAlternateFieldLength' => 300,
				'indent' => 1,
				'timeAllowed' => 5000,
				);

		$params['sort'] = $this->getRankSort($rank);

		$queryClauses = array();
		$sanitizedQuery = $this->sanitizeQuery($query);

		if ($spellCheck) {
			$params += array('spellcheck' => 'true',
							 'spellcheck.onlyMorePopular' => 'true',
							 'spellcheck.collate' => 'true',
							 'spellcheck.q' => $sanitizedQuery
							);
		}

		$onWikiId = ( !empty( $solrDebugWikiId ) ) ? $solrDebugWikiId : $cityId;

		if( $this->isInterWiki ) {
			$queryClauses += $this->getInterWikiQueryClauses($hub);
		}
		else {

		  $nsQuery = '';
		  foreach($this->namespaces as $namespace) {
		    $nsQuery .= ( !empty($nsQuery) ? ' OR ' : '' ) . 'ns:' . $namespace;
		  }
		  
		  $queryClauses[] = "({$nsQuery})";

		  if (!$includeRedirects) {
		    $queryClauses[] = "canonical:['' TO *]";
		  }

		  array_unshift($queryClauses, "wid: {$onWikiId}");
		}

		$queryNoQuotes = self::sanitizeQuery(preg_replace("/['\"]/", '', $query));

		$boostQueries = array('html:\"'.$queryNoQuotes.'\"^5',
				      'title:\"'.$queryNoQuotes.'\"^10');

		$boostFunctions = array();

		if ($this->isInterWiki) {
		  // this is still pretty important!
		  $boostQueries[] = 'wikititle:\"'.$queryNoQuotes.'\"^15';

		  # we can do this because the host is a text field
		  if (!$this->includeAnswers($query)) {
		    $boostQueries[] = '-host:\"answers\"^10';
		    $boostQueries[] = '-host:\"respuestas\"^10';
		  }

		  if (!$skipBoostFunctions) {
		    $boostFunctions = array_merge($boostFunctions, $this->getInterWikiBoostFunctions());
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
		    $methodOptions['skipBoostFunctions'] = true;

				wfProfileOut(__METHOD__);
				return $this->search($query, $methodOptions);
		  }
		}

		if (!isset($response)) {
		  // we have a lot of code dependent on this class, so we'll just mock it up to prevent errors
		  $response = (object) array( 'response'     => (object) array( 'docs'     => array(),
										 'numFound' => 0,
										 'start'    => 0
										 ),
					      'spellcheck'   => (object) array( 'suggestions' => (object) array( 'collation' => array() ) ),
					      'highlighting' => (object) array(),
					      );
		} 

		if ( $response instanceOf Apache_Solr_Response &&
		     empty($response->response->docs)) {

			if ($spellCheck && 
				! empty($this->articleMatch) &&
				! $spellCheckHappened &&
				! empty($response->spellcheck->suggestions) && 
				! empty($response->spellcheck->suggestions->collation)
				) {

				$newQuery = $response->spellcheck->suggestions->collation;

				// stop infinite loop... i know this is stupid, but we're gutting this come 3.6
				$methodOptions['spellCheckHappened'] = true;

				return $this->search($newQuery, $methodOptions);
			} else if (!$spellCheck && empty($this->articleMatch)) {
				#research with spellcheck @todo spellcheck request handler
				$methodOptions['spellCheck'] = true;
				return $this->search($query, $methodOptions);
			}
			
		} 

		$docs = empty( $response->response->docs ) ? array() : $response->response->docs;
		
		if (is_object($response->highlighting)) {
			$highlighting = get_object_vars($response->highlighting);
		} else if (is_array($response->highlighting)) {
			$highlighting = $response->highlighting;
		}
		$highlighting = empty($highlighting) ? array() : $highlighting;

		$numFound = $response->response->numFound ?: 0;
		$resultsStart = $response->response->start ?: 0;

		$results = $this->getWikiaResults( $docs, $highlighting );

		wfProfileOut(__METHOD__);
		return F::build( 'WikiaSearchResultSet', 
				 array( 'results'      => $results, 
					'resultsFound' => $numFound,
					'resultsStart' => $start,
					'isComplete'   => false, 
					'query'        => $this->query 
					) 
				 );
	}

	private function getWikiaResults(Array $solrDocs, Array $solrHighlighting) {
		wfProfileIn(__METHOD__);

		$results = array();
		$position = 1;

		$articleMatchId = '';

		if ((!$this->paginatedSearch) && (!$this->isInterWiki) && ($articleMatch = $this->getArticleMatch())) {
			global $wgCityId;
			extract($articleMatch);
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
			  $result->setVar('ns', $title->getNamespace());
			  $result->setVar('pageId', $article->getID());

			  if (isset($redirect)) {
			    $result->setVar('redirectTitle', $redirect->getTitle());
			  }

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
			$result->setVar('ns', $doc->ns);
			$result->setVar('pageId', $doc->pageid);

			if(!empty($doc->canonical)) {
				$result->setCanonical($doc->canonical);
			}

			$result->setVar('backlinks', $doc->backlinks);
			$result->setVar('cityArticlesNum', $doc->wikiarticles);
			$result->setVar('position', $position);
			$result->setVar('cityHost', 'http://'.$doc->host);
			$result->setVar('wikititle', $doc->wikititle);

			$results[] = $result;
			$position++;
		}

		$deDupedResults = $this->deDupeResults($results);

		wfProfileOut(__METHOD__);
		return $deDupedResults;
	}

	private function deDupeResults(Array $results) {
		wfProfileIn(__METHOD__);

		$canonicals = array();
		$deDupedResults = array();

		/**
		 * @var $result WikiaSearchResult
		 */
		foreach($results as $result) {
			if(!isset($canonicals[$result->getCityId()])) {
				$canonicals[$result->getCityId()] = array();
			}

			$hadCanonical = $result->hasCanonical();

			if($hadCanonical) {
				$result->deCanonize();
			}

			if(!in_array($result->getTitle(), $canonicals[$result->getCityId()])) {
				$canonicals[$result->getCityId()][] = $result->getTitle();
				$deDupedResults[md5($result->getCityId().$result->getVar('ns').$result->getTitle())] = $result;
			}
			else if (!$hadCanonical) {
				// redirect was first for this document, replace it
				$deDupedResults[md5($result->getCityId().$result->getVar('ns').$result->getTitle())] = $result;
			}
		}

		wfProfileOut(__METHOD__);
		return array_values($deDupedResults);
	}


	/**
	 * any query string transformation before sending to backend should be placed here
	 */
	private function sanitizeQuery($query) {
		// non-indexed number-string phrases issue workaround (RT #24790)
		$query = preg_replace('/(\d+)([a-zA-Z]+)/i', '$1 $2', $query);

		// escape all lucene special characters: + - && || ! ( ) { } [ ] ^ " ~ * ? : \ (RT #25482)
		// added html entity decoding now that we're doing extra work to prevent xss o
		$query = Apache_Solr_Service::escape(html_entity_decode($query,  ENT_COMPAT, 'UTF-8'));

		return $query;
	}

	/**
	 * get list of wikis excluded from inter-wiki searching
	 * @return array
	 */
	private function getInterWikiSearchExcludedWikis($currentWikiId = 0) {
		wfProfileIn(__METHOD__);

		$wg = F::app()->wg;
		$cacheKey = F::app()->wf->SharedMemcKey( 'crossWikiaSearchExcludedWikis' );
		$privateWikis = $wg->Memc->get( $cacheKey );

		if(!is_array($privateWikis)) {
			// get private wikis from db
			$wgIsPrivateWiki = WikiFactory::getVarByName( 'wgIsPrivateWiki', $currentWikiId );
			$privateWikis = WikiFactory::getCityIDsFromVarValue( $wgIsPrivateWiki->cv_id, true, '=' );
			$wg->Memc->set( $cacheKey, $privateWikis, 3600 ); // cache for 1 hour
		}

		wfProfileOut(__METHOD__);
		return count( $privateWikis ) ? array_merge( $privateWikis, $wg->CrossWikiaSearchExcludedWikis ) : $wg->CrossWikiaSearchExcludedWikis;
	}

	public function getInterWikiQueryClauses($hub = false)
	{
	  $queryClauses = array();

	  $widQuery = '';

	  foreach ($this->getInterWikiSearchExcludedWikis() as $excludedWikiId) {
	    $widQuery .= ( !empty($widQuery) ? ' AND ' : '' ) . '!wid:' . $excludedWikiId;
	  }
	  
	  $queryClauses[] = $widQuery;

	  $queryClauses[] = "lang:en";

	  $queryClauses[] = "iscontent:true";

	  if ($hub) {
		$queryClauses[] = "hub:".$this->sanitizeQuery($hub);
	  }

	  return $queryClauses;

	}


	public function getInterWikiBoostFunctions()
	{
	  global $wikipagesBoost, $activeusersBoost, $revcountBoost, $viewBoost;
	  $boostFunctions = array();

	  $wikipagesBoost = isset($_GET['page_boost']) ? $_GET['page_boost'] : 4 ;
	  $boostFunctions[] = 'log(wikipages)^'.$wikipagesBoost;
	  
	  $activeusersBoost = isset($_GET['activeusers_boost']) ? $_GET['activeusers_boost'] : 4;
	  $boostFunctions[] = 'log(activeusers)^'.$activeusersBoost;
	  
	  $revcountBoost = isset($_GET['revcount_boost']) ? $_GET['revcount_boost'] : 1;
	  $boostFunctions[] = 'log(revcount)^'.$revcountBoost;
	  
	  $viewBoost = isset($_GET['views_boost']) ? $_GET['views_boost'] : 8;
	  $boostFunctions[] = 'log(views)^'.$viewBoost;
	  
	  $boostFunctions[] = 'log(words)^0.5';

	  return $boostFunctions;
	}

	/**
	 * Designed as a method so we can make it more complex if we want to -- ex: syntactic parsing to determine question
	 *
	 */
	protected function includeAnswers($query) {
	  return substr_count($query, "answers") > 0;
	}

	public function getSimilarPages($query = false, array $params = array())
	{
	      if (!$query && !isset($params['stream.body']) && !isset($params['stream.url'])) {
		return json_code(array('success'=>1, 'message'=>'No query or stream provided'));
	      }

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
			      'mlt.fl' => 'title,html',
				  'mlt.qf' => 'title^10 html^5',
			     ) + $params;

	      try {
		$response = $this->solrClient->moreLikeThis($query, $start, $size, $params);
	      } catch (Exception $e) {
		return json_encode(array('success'=>0,'message'=>'Exception: '.$e));
	      }

	      return $response;

		wfProfileOut(__METHOD__);
		return $response->response->docs;
	}

	public function setNamespaces(array $namespaces) {
		$this->namespaces = $namespaces;
	}

	public function getNamespaces() {
		return $this->namespaces;
	} 

	public function setArticleMatch($article)
	{
	  $this->articleMatch = $article;
	}

	public function getArticleMatch()
	{
	  return $this->articleMatch;
	}


	private $rankOptions = array(	'default'			=>	'score desc',
									'newest'			=>	'created desc',
									'oldest'			=>	'created asc',
									'recently-modified'	=>	'touched desc',
									'stable'			=>	'touched asc',
									'most-viewed'		=>	'views desc',
									'freshest'			=>	'indexed desc',
									'stalest'			=>	'indexed asc'
								);

	public function getRankSort($rank = 'default')
	{
		return isset($this->rankOptions[$rank]) ? $this->rankOptions[$rank] : $this->rankOptions['default'];
	}



	// this lets us directly query the index without any of the preprocessing we have in the search method
	// useful for services, not so much for our search interface
	public function searchByLuceneQuery($query, $start, $size, $params)
	{
	  return $this->solrClient->search($query, $start, $size, $params);
	}

}