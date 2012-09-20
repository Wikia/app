<?php

class WikiaSolrClient extends WikiaSearchClient {

	const VIDEO_WIKI = 298117;

	protected $solrClient;
	protected $query;
	protected $namespaces = array();
	protected $isInterWiki = false;
	protected $articleMatch;
	protected $paginatedSearch = false;
	protected $articleMatchId;
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

	//@TODO determine what fields are needed in production and what in debug,
	// 		only add fields only needed in debug when debug invoked
	private static $requestedFields = array('id',
											'wikiarticles',
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
											'created',
											'views',
											'categories',
											);

	const DEFAULT_RESULTSET_START = 0;
	const DEFAULT_RESULTSET_SIZE = 20;
	const DEFAULT_CITYID = 0;

	public function __construct( array $solariumConfig ) {
		$this->solrClient = F::build( 'Solarium_Client', $solariumConfig );
	}

	/**
	 *  $methodOptions supports the following possible values:
	 *  	$start=0, $size=20, $cityId = 0, $skipBoostFunctions=false, $namespaces, 
	 *  	$isInterWiki, $includeRedirects = false, $solrDebugWikiId = false, $hub, 
	 *  	$spellCheckHappened, $videoSearch=false
	 **/
	public function search( $query,  array $methodOptions = array() ) {
		wfProfileIn(__METHOD__);

		global $wgLanguageCode, $wgWikiaSearchSupportedLanguages;


		if (!empty($boostFunctions) && !$skipBoostFunctions) {
			$dismaxParams['bf'] = sprintf("'%s'", implode(' ', $boostFunctions));
		}
		

		$subQuery = sprintf('_query_:"{!edismax %s}%s"',
							$paramString,
							$this->sanitizeQuery($sanitizedQuery));

		$sanitizedQuery = sprintf("(%s AND %s)", implode(' AND ', $queryClauses), $subQuery);

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
			  			  'grouped' => null
					      );
		} 

		$docs = ( $this->isInterWiki &&  $response->grouped !== null ) ? $response->grouped->host->groups : $response->response->docs;

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
		if (empty($docs) && is_object($response->grouped)) {
			foreach ($response->grouped->host->groups as $group) {			
				$docs = array();
				foreach ($group->doclist->docs as $doc) {
					$solrDoc = new Apache_Solr_Document();
					foreach ($doc as $key=>$val) {
						$solrDoc->{$key} = $val;
					}
					$docs[] = $solrDoc;
				}
				$group->doclist->docs = $docs;
			}
			$docs = $response->grouped->host->groups;
		}

		if (is_object($response->highlighting)) {
			$highlighting = get_object_vars($response->highlighting);
		} else if (is_array($response->highlighting)) {
			$highlighting = $response->highlighting;
		}
		$highlighting = empty($highlighting) ? array() : $highlighting;

		if (!is_object($response->grouped)) {
			$numFound = $response->response === null ? 0 : $response->response->numFound;
			$resultsStart = $response->response === null ? 0 : $response->response->start;
			$method = 'getWikiaResults';
		} else {
			$numFound = $response->grouped->host->matches ?: 0;
			$resultsStart = $start;
			$method = 'getGroupedWikiaResults';
		}

		$results = call_user_func_array( array($this, $method), array($docs, $highlighting) );

		wfProfileOut(__METHOD__);

		return F::build( 'WikiaSearchResultSet', 
				 array( 'results'      => $results, 
						'resultsFound' => $numFound,
						'resultsStart' => $start,
						'query'        => $this->query,
				 		'queryTime'	   => $response->responseHeader->QTime, 
					  ) 
				 );
	}

	private function getGroupedWikiaResults(Array $groupedSolrDocs, Array $solrHighlighting)
	{
		wfProfileIn(__METHOD__);

		$resultSets = array();
		
		foreach ($groupedSolrDocs as $groupedSolrDoc) {

			$results = array();
			$position = 1;
			$cityId = null;
			$cityArticlesNum = 0;
			$latestResultDate = 0;

			if (empty($groupedSolrDoc->doclist->docs)) {
				continue;
			}

			foreach($groupedSolrDoc->doclist->docs as $doc) {

				$snippetField = self::field('html');
				$docHighlighting = isset($solrHighlighting[$doc->id]) 
											&& isset($solrHighlighting[$doc->id]->{$snippetField}) 
											&& isset($solrHighlighting[$doc->id]->{$snippetField}[0])
								  ? $solrHighlighting[$doc->id]->{$snippetField}[0]
								  : null;

				$result = $this->buildResult($doc, $position, $docHighlighting);
	
				if ($result !== false) {
					$results[] = $result;
					$position++;
					$cityId = $cityId ?: $result->getCityId();
				}

				$resultDate = strtotime($result->getVar('indexed'));
				if ($latestResultDate < $resultDate) {
					$cityArticlesNum = (($val = $result->getVar('cityArticlesNum', false)) && $val) ? $val : $cityArticlesNum;
					$latestResultDate = $resultDate;
				}


			}

			$resultSet = F::build( 'WikiaSearchResultSet', 
									array( 'results'      => $results,
										   'resultsFound' => $groupedSolrDoc->doclist->numFound,
										   'resultsStart' => 0,
										   'query'        => $this->query,
										   'queryTime'	  => 0,
										   'score'		  => $groupedSolrDoc->doclist->maxScore
										 ) 
								  );

			$resultSet->setHeader('cityId', $cityId );
			$resultSet->setHeader('cityTitle', WikiFactory::getVarValueByName( 'wgSitename', $cityId ));
			$resultSet->setHeader('cityUrl', WikiFactory::getVarValueByName( 'wgServer', $cityId ));
			$resultSet->setHeader('cityArticlesNum', $cityArticlesNum);

			$resultSets[] = $resultSet;

		}

		wfProfileOut(__METHOD__);

		return $resultSets;

	}

	private function getWikiaResults(Array $solrDocs, Array $solrHighlighting) {
		wfProfileIn(__METHOD__);

		$results = array();
		$position = 1;

		if ((!$this->paginatedSearch) && (!$this->isInterWiki) && ($articleMatch = $this->getArticleMatch())) {
			global $wgCityId;
			extract($articleMatch);
			$title = $article->getTitle();
			if (in_array($title->getNamespace(), $this->namespaces)) {
			  $articleMatchId = $wgCityId.'_'.$article->getID();
			  $result = F::build( 'WikiaSearchResult', array( 'id' => $articleMatchId) );
			  $articleService = new ArticleService($article->getID());
			  $result->setCityId($wgCityId);
			  $result->setTitle($article->mTitle);
			  $result->setText($articleService->getTextSnippet(250));
			  $result->setUrl(urldecode($title->getFullUrl()));
			  $result->score = '100%';
			  $result->setVar('position', $position);
			  $result->setVar('score', 'PTT');
			  $result->setVar('isArticleMatch', true);
			  $result->setVar('ns', $title->getNamespace());
			  $result->setVar('pageId', $article->getID());

			  if (isset($redirect)) {
			    $result->setVar('redirectTitle', $redirect->getTitle());
			  }

			  $results[] = $result;
			  $position++;

				$this->articleMatchId = $articleMatchId;
			}
		}

		foreach($solrDocs as $doc) {

			$snippetField = self::field('html');
			$docHighlighting = isset($solrHighlighting[$doc->id]) 
										&& isset($solrHighlighting[$doc->id]->{$snippetField}) 
										&& isset($solrHighlighting[$doc->id]->{$snippetField}[0])
							  ? $solrHighlighting[$doc->id]->{$snippetField}[0]
							  : null;

			$result = $this->buildResult($doc, $position, $docHighlighting);

			if ($result !== false) {
				$results[] = $result;
				$position++;
			}
		}
		wfProfileOut(__METHOD__);
		return $results;
	}

	private function buildResult($doc, $position, $solrHighlighting = null)
	{
			global $wgLang;

			if ($this->articleMatchId == $doc->id) {
			  return false;
			}

			$result = F::build( 'WikiaSearchResult', array( 'id' => $doc->id ) );
			$result->setCityId($doc->wid);

			$titleKey = self::field('title');
			$result->setTitle($doc->{$titleKey});

			$html = self::field('html');
			$limit = F::app()->checkSkin( 'wikiamobile' ) ? 100 : 300;
			$text = $solrHighlighting ?: '';

			$result->setText($text);
			$result->setUrl(urldecode($doc->url));
			$result->setScore(($doc->score) ?: 0);
			$result->setVar('ns', $doc->ns);
			$result->setVar('pageId', $doc->pageid);
			$result->setVar('score', sprintf('%.4f', $doc->score));
			$result->setVar('views', $doc->views);

			$result->setVar('indexed', $doc->indexed);

			if ($doc->created !== null && $wgLang) {
				$result->setVar('created', $doc->created);
				$result->setVar('fmt_timestamp', $wgLang->date(wfTimestamp(TS_MW, $doc->created)));
				if ($result->getVar('fmt_timestamp')) {
					$result->setVar('created_30daysago', time() - strtotime($doc->created) > 2592000 );
				}
			}

			if(!empty($doc->canonical)) {
				$result->setCanonical($doc->canonical);
			}
			$cats = self::field('categories');
			if (isset($doc->{$cats})) {
				$resultCategories = is_array($doc->{$cats}) ? $doc->{$cats} : array($doc->{$cats});
			}
			$result->setVar('categories', empty($doc->{$cats}) ? array("NONE") : $resultCategories);
			$result->setVar('backlinks', $doc->backlinks);
			$result->setVar('cityArticlesNum', $doc->wikiarticles);
			$result->setVar('position', $position);
			$result->setVar('cityHost', 'http://'.$doc->host);

			$wikiTitleKey = self::field('wikititle');
			$result->setVar('wikititle', $doc->{$wikiTitleKey});

			return $result;
	}


	public function getSimilarPages($query = false, array $params = array())
	{
		if (! $query && ! isset ( $params ['stream.body'] ) && ! isset ( $params ['stream.url'] )) {
			return json_encode ( array (
					'success' => 1,
					'message' => 'No query or stream provided' 
			) );
		}
		
		if (isset ( $params ['start'] )) {
			$start = $params ['start'];
			unset ( $params ['start'] );
		} else {
			$start = 0;
		}
		
		if (isset ( $params ['size'] )) {
			$size = $params ['size'];
			unset ( $params ['size'] );
		} else {
			$size = 10;
		}
		
		$params = array (
				'mlt.match.include' => 'false',
				'mlt.fl' => 'title,html',
				'mlt.qf' => 'title^10 html^5' 
		) + $params;
		
		try {
			$response = $this->solrClient->moreLikeThis ( $query, $start, $size, $params );
		} catch ( Exception $e ) {
			return json_encode ( array (
					'success' => 0,
					'message' => 'Exception: ' . $e 
			) );
		}
		
		return $response;
	}


	// this lets us directly query the index without any of the preprocessing we have in the search method
	// useful for services, not so much for our search interface
	public function searchByLuceneQuery($query, $start, $size, $params)
	{
	  return $this->solrClient->search($query, $start, $size, $params);
	}


}