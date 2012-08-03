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
	private static $languageFields  = array('title',
											'html',
											'wikititle',
											'first500',
											'beginningText',
											'headings',
											'redirect_titles',
											'categories',
											);

	private static $dynamicUnstoredFields = array('headings', 'first500', 'beginningText');

	private static $multiValuedFields = array('categories', 'redirect_titles', 'headings');

	private static $requestedFields = array('id',
											'wikiarticles',
											'bytes',
											'words',
											'wikititle',
											'wikipages',
											'pageid',
											'url',
											'wid',
											'canonical',
											'hub',
											'lang',
											'host',
											'ns',
											'indexed',
											'backlinks',
											'title',
											'score',
											);

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
	 *  $start=0, $size=20, $cityId = 0, $skipBoostFunctions=false, $namespaces, $isInterWiki, $includeRedirects = false, $solrDebugWikiId = false, $hub, $spellCheckHappened
	 **/
	public function search( $query,  array $methodOptions = array() ) {
		wfProfileIn(__METHOD__);

		global $wgLanguageCode, $wgWikiaSearchSupportedLanguages;

		extract($methodOptions);

		$start              = isset($start)              ? $start              : self::DEFAULT_RESULTSET_START;
		$size               = isset($size)               ? $size               : self::DEFAULT_RESULTSET_SIZE;
		$cityId             = isset($cityId)             ? $cityId             : self::DEFAULT_CITYID;
		$skipBoostFunctions = isset($skipBoostFunctions) ? $skipBoostFunctions : false;
		$includeRedirects   = isset($includeRedirects)   ? $includeRedirects   : false;
		$rank               = isset($rank)               ? $rank               : 'default';
		$solrDebugWikiId    = isset($solrDebugWikiId)    ? $solrDebugWikiId    : false;
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

		$fields = array();
		array_walk(self::$requestedFields, function($val) use(&$fields) { $fields[] = WikiaSolrClient::field($val); } );

		$isMobile = F::app()->checkSkin( 'wikiamobile' );

		$params = array(
						# html makes the response too big
				'fl' => implode(',', $fields),
				'qf' => sprintf('%s^5 %s', self::field('title'), self::field('html')), 
				'hl' => 'true',
				'hl.fl' => sprintf('%s', self::field('html')),
				'hl.requireFieldMatch' => 'true',
				'hl.snippets' => '1', // number of snippets per field
				'hl.fragsize' => '150', // snippet size in characters
				'hl.simple.pre' => '<span class="searchmatch">',
				'hl.simple.post' => '</span>',
				'f.html.hl.alternateField' => 'html',
				'f.html.hl.maxAlternateFieldLength' => $isMobile ? 100 : 300,
				'indent' => 1,
				'timeAllowed' => 5000,
				);

		$params['sort'] = $this->getRankSort($rank);

		$queryClauses = array();
		$sanitizedQuery = $this->sanitizeQuery($query);

		$onWikiId = ( !empty( $solrDebugWikiId ) ) ? $solrDebugWikiId : $cityId;

		$queryNoQuotes = self::sanitizeQuery(preg_replace("/['\"]/", '', $query));

		$boostQueries = array(	self::valueForField('html', $queryNoQuotes, array('boost'=>5, 'quote'=>'\"')),
								self::valueForField('title', $queryNoQuotes, array('boost'=>10, 'quote'=>'\"')),
							 );

		$boostFunctions = array();

		$queryFields = array('html'=>1.5, 'title'=>5);

		if( $this->isInterWiki ) {
			$queryClauses += $this->getInterWikiQueryClauses($hub);

			// this is still pretty important!
			$boostQueries[] = self::valueForField('wikititle', $queryNoQuotes, array('boost'=>15, 'quote'=>'\"'));
			$queryFields['wikititle'] = 7;

			# we can do this because the host is a text field
			if (!$this->includeAnswers($query)) {
				$boostQueries[] = '-host:\"answers\"^10';
				$boostQueries[] = '-host:\"respuestas\"^10';
			}

			if (!$skipBoostFunctions) {
				$boostFunctions = array_merge($boostFunctions, $this->getInterWikiBoostFunctions());
			}

			$params += array(	'group' => 'true',
								'group.field' => 'host',
								'group.limit' => '4',
								'group.start' => $start,
								'group.rows' => 40,
								'group.format' => 'simple' //@todo implement grouped format?
							); 
		}
		else {
			// for caching, hopefully
			$params['fq'] = "wid:{$onWikiId}";

			$nsQuery = '';
			foreach($this->namespaces as $namespace) {
				$nsQuery .= ( !empty($nsQuery) ? ' OR ' : '' ) . 'ns:' . $namespace;
			}
		  
			$queryClauses[] = "({$nsQuery})";

			array_unshift($queryClauses, "wid:{$onWikiId}");
		}

		if (!$includeRedirects) {
			$queryClauses[] = "is_redirect:false";
			$params['fq'] = (isset($params['fq']) ? $params['fq'] . ' AND ' : '') . 'is_redirect:false';
		}




		$qfString = "\'";
		array_walk($queryFields, function($val, $key) use (&$qfString) { $qfString .= WikiaSolrClient::field($key)."^{$val} "; }) ;
		$qfString .= "\'";

		$dismaxParams = array(	'qf'	=>	$qfString,
								'pf'	=>	$qfString,
								'ps'	=>	'3',
								'tie'	=>	'0.01',
								'bq'	=>	"\'".implode(' ', $boostQueries)."\'",
								'mm'    =>  '66%'
								);

		if (!empty($boostFunctions) && !$skipBoostFunctions) {
			$dismaxParams['bf'] = sprintf("'%s'", implode(' ', $boostFunctions));
		}

		array_walk($dismaxParams, function($val,$key) use (&$paramString) {$paramString .= "{$key}={$val} "; });

		$queryClauses[] = sprintf('_query_:"{!edismax %s}%s"',
					  $paramString,
					  str_replace("\\", "\\\\", $sanitizedQuery));

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

		$docs = $this->isInterWiki ? $response->grouped->host->doclist->docs : $response->response->docs;

		// @todo: this is just for automated spelling correction. we should also provide "did you mean"
		if ( $response instanceOf Apache_Solr_Response &&
		     empty($docs)) {

			if (  empty($this->articleMatch) &&
				! $spellCheckHappened &&
				! empty($response->spellcheck->collations)
				) {

				$collationsByHits = array();

				foreach ($response->spellcheck->collations as $collation) {
					$collationsByHits[(int)$collation->hits] = $collation->collationQuery;
				}
				ksort($collationsByHits);

				$newQuery = end($collationsByHits);

				$methodOptions['spellCheckHappened'] = true;

				return $this->search($newQuery, $methodOptions);
			} 
			
		} 

		$docs = empty( $response->response->docs ) ? array() : $response->response->docs;

		// @todo replace Apache_Solr_Service with something more sensible. maybe homegrown.
		if (empty($docs) && $response->grouped !== null) {
			$docs = array();
			foreach ($response->grouped->host->doclist->docs as $doc) {
				$solrDoc = new Apache_Solr_Document();
				foreach ($doc as $key=>$val) {
					$solrDoc->{$key} = $val;
				}
				$docs[] = $solrDoc;
			}
		}

		if (is_object($response->highlighting)) {
			$highlighting = get_object_vars($response->highlighting);
		} else if (is_array($response->highlighting)) {
			$highlighting = $response->highlighting;
		}
		$highlighting = empty($highlighting) ? array() : $highlighting;

		$numFound = $response->response === null ? ($response->grouped === null ? 0 : $response->grouped->host->doclist->numFound) : $response->response->numFound;

		$resultsStart = $response->response === null ? 0 : $response->response->start;

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

			$titleKey = self::field('title');
			$result->setTitle($doc->{$titleKey});

			$text = '';
			$snippetField = self::field('html');

			if (   isset($solrHighlighting[$doc->id]) 
				&& isset($solrHighlighting[$doc->id]->{$snippetField}) 
				&& isset($solrHighlighting[$doc->id]->{$snippetField}[0])) {
				$text = $solrHighlighting[$doc->id]->{$snippetField}[0];
			} 

			$result->setText($text);
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

			$wikiTitleKey = self::field('wikititle');
			$result->setVar('wikititle', $doc->{$wikiTitleKey});

			$results[] = $result;
			$position++;
		}
		wfProfileOut(__METHOD__);
		return $results;
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
		global $wgContLang;

		$queryClauses = array();

		$widQuery = '';

		foreach ($this->getInterWikiSearchExcludedWikis() as $excludedWikiId) {
			$widQuery .= ( !empty($widQuery) ? ' AND ' : '' ) . '!wid:' . $excludedWikiId;
		}
	  
		$queryClauses[] = $widQuery;

		$queryClauses[] = "lang:".$wgContLang->mCode;

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


	public static function valueForField ( $field, $value, array $params = array() )
	{
		$boostVal = isset($params['boost']) && $params['boost'] !== false ? '^'.$params['boost'] : '';

		$evaluate = isset($params['quote']) && $params['quote'] !== false ? "(%s:{$params['quote']}%s{$params['quote']})%s" : '(%s:%s)%s';

		return sprintf( $evaluate, self::field( $field ), $value, $boostVal );
	}

	public static function field ( $field )
	{
		global $wgLanguageCode, $wgWikiaSearchSupportedLanguages;
		$lang = preg_replace('/-.*/', '', $wgLanguageCode);
		if ( in_array($field, self::$languageFields) &&
			 in_array($wgLanguageCode, $wgWikiaSearchSupportedLanguages) ) {

			$us = in_array($field, self::$dynamicUnstoredFields) ? '_us' : '';

			$mv = in_array($field, self::$multiValuedFields) ? '_mv' : '';

			$field .= $us . $mv . '_' . $lang;

		}

		return $field;

	}

}