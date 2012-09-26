<?php

class WikiaSearch extends WikiaObject {

	const RESULTS_PER_PAGE = 10;
	const RESULTS_PER_WIKI = 4;
	const GROUP_RESULTS_SEARCH_LIMIT = 20;
	const GROUP_RESULTS_CACHE_TTL = 900; // 15 mins
	const WIKIPAGES_CACHE_TTL = 604800; // 7 days
	const VIDEO_WIKI_ID = 298117;
	const GROUP_RESULT_MAX_FETCHES = 30;
	const RELEVANCY_FUNCTION_ID = 6;
	
	const HL_FRAG_SIZE = 150;
	const HL_MATCH_PREFIX = '<span class="searchmatch">';
	const HL_MATCH_POSTFIX = '</span>';
	
	private static $languageFields  = array(
			'title',
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


	/**
	 * Search client
	 * @var Solarium_Client
	 */
	protected $client = null;
	protected $parserHookActive = false;
	protected $articleMatch = null;

	public function __construct( Solarium_Client $client ) {
		$this->client = $client;
		$this->client->setAdapter('Solarium_Client_Adapter_Curl');
		parent::__construct();
	}

	/**
	 * perform search
	 *
	 * @param string $query
	 * @param WikiaSearchConfig $searchConfig
	 * @return WikiaSearchResultSet
	 */
	public function doSearch( WikiaSearchConfig $searchConfig ) {
		wfProfileIn(__METHOD__);

		if($searchConfig->getGroupResults() == true) {

			$searchConfig	->setLength		( self::GROUP_RESULTS_SEARCH_LIMIT )
							->setIsInterWiki( true )
							->setStart		( ((int) $searchConfig->getLength()) * (((int)$searchConfig->getPage()) - 1) )
			;

		} else {
			$searchConfig	->setStart		( ($searchConfig->getPage() - 1) * $searchConfig->getLength() );
		}
		
		$queryInstance = $this->client->createSelect();
		$this->prepareQuery( $queryInstance, $searchConfig );
		$result = $this->client->select( $queryInstance );
		$results = F::build('WikiaSearchResultSet', array($result, $searchConfig) );

		// set here due to all the changes we make to the base query
		$results->setQuery($searchConfig->getQuery());
		$searchConfig->setResults($results);
		$searchConfig->setResultsFound( $results->getResultsFound() );		

		if( $searchConfig->getPage() == 1 ) {
			$resultCount = $results->getResultsFound();
			Track::event( ( !empty( $resultCount ) ? 'search_start' : 'search_start_nomatch' ), 
							array(	'sterm' => $searchConfig->getQuery(), 
									'rver' => self::RELEVANCY_FUNCTION_ID,
									'stype' => ( $searchConfig->getCityId() == 0 ? 'inter' : 'intra' ) 
								 ) 
						);
		}

		wfProfileOut(__METHOD__);
		return $results;
	}
	
	private function prepareQuery( Solarium_Query_Select $query, WikiaSearchConfig $searchConfig )
	{
		$query->setDocumentClass('WikiaSearchResult');
		
		$sort = $searchConfig->getSort();
		
		$query	->setFields		( $searchConfig->getRequestedFields() )
			  	->setStart		( $searchConfig->getStart() )
				->setRows		( $searchConfig->getLength() )
				->addSort		( $sort[0], $sort[1] )
				->addParam		( 'timeAllowed', $searchConfig->isInterWiki() ? 7500 : 5000 )
		;
		
		$highlighting = $query->getHighlighting();
		$highlighting->addField						( self::field('html') )
					 ->setSnippets					( 1 )
					 ->setRequireFieldMatch			( true )
					 ->setFragSize					( self::HL_FRAG_SIZE )      // @todo determine if these should go in wikiasearchconfig?
					 ->setSimplePrefix				( self::HL_MATCH_PREFIX )
					 ->setSimplePostfix				( self::HL_MATCH_POSTFIX )
					 ->setAlternateField			( 'html' )
					 ->setMaxAlternateFieldLength	( $searchConfig->isMobile() ? 100 : 300 )
		;
		
		$queryFieldsString = sprintf('%s^5 %s %s^4', self::field('title'), self::field('html'), self::field('redirect_titles'));
		
		if ( $searchConfig->isInterWiki() ) {
			$grouping = $query->getGrouping();
			$grouping	->setLimit			( 4 )
						->setOffset			( $searchConfig->getStart() )
						->setFields			( array( 'host' ) )
			;
			
			$queryFieldsString .= sprintf(' %s^7', self::field('wikititle'));
		}
		
		$query->createFilterQuery()->setQuery( $this->getFilterQueryString( $searchConfig ) );
		
		$nestedQuery = $this->client->createSelect();
		$nestedQuery->setQuery( $searchConfig->getQuery() );
		
		$dismax = $nestedQuery->getDismax();
		
		$boostQueryString = $this->getBoostQueryString( $query, $searchConfig );
		
		$dismax	->setQueryFields		( $queryFieldsString )
				->setPhraseFields		( $queryFieldsString )
				->setBoostQuery			( $this->getBoostQueryString( $query, $searchConfig ) )
				->setMinimumMatch		( $searchConfig->getMinimumMatch() )
				->setQueryParser		( 'edismax' )
				->setPhraseSlop			( 3 )
				->setTie				( 0.01 )
		;
		
		if (! $searchConfig->getSkipBoostFunctions() ) {
			$dismax->setBoostFunctions( $this->getBoostFunctionsString( $searchConfig) );
		}
		
		// this is how we prevent the PTT from messing with results
		$noPtt = '';
		if ( $searchConfig->hasArticleMatch() ) {
			$am = $searchConfig->getArticleMatch();
			$article = ( isset($am['redirect']) ) ? $am['redirect'] : $am['article'];  
			$noPtt = sprintf(' AND -(id:%s_%s)', $searchConfig->getCityId(), $article->getID());
		}
		
		$formulatedQuery = sprintf('%s AND (%s)%s', $this->getQueryClausesString( $searchConfig ), $nestedQuery, $noPtt);
		
		$query->setQuery( $formulatedQuery );
	}
	
	private function getFilterQueryString( WikiaSearchConfig $searchConfig )
	{
		$fqString = '';
		if ( $searchConfig->isInterWiki() ) {
			
			$fqString .= 'iscontent:true';
				
			if ( $hub = $searchConfig->getHub() ) {
			    $fqString .= ' hub:'.$this->sanitizeQuery($hub);
			}
		}
		else {
			$fqString .= 'wid:'.$searchConfig->getCityId();
		}
		
		if (! $searchConfig->getIncludeRedirects() ) {
			$fqString = "({$fqString}) AND is_redirect:false";
		}
		
		return $fqString;
	}
	
	private function getBoostFunctionsString( WikiaSearchConfig $searchConfig )
	{
		if ( $searchConfig->isInterWiki() ) {
			$boostFunctions = array(
					'log(wikipages)^4',
					'log(activeusers)^4',
					'log(revcount)^1',
					'log(views)^8',
					'log(words)^0.5',
			);
		}
		else {
			$boostFunctions = array(
					'log(views)^0.66', 
					'log(backlinks)'
			);
		}
		
		return implode(' ', $boostFunctions);
	}
	
	private function getQueryClausesString( WikiaSearchConfig $searchConfig )
	{
		if ( $searchConfig->isInterWiki() ) {
			global $wgContLang;
			
			$queryClauses = array();
			
			$widQuery = '';
			
			foreach ($this->getInterWikiSearchExcludedWikis() as $excludedWikiId) {
			    $widQuery .= ( !empty($widQuery) ? ' AND ' : '' ) . '!wid:' . $excludedWikiId;
			}
			 
			$queryClauses[] = $widQuery;
			
			$queryClauses[] = "lang:".$wgContLang->mCode;
			
			$queryClauses[] = "iscontent:true";
			
			if ( $hub = $searchConfig->getHub() ) {
			    $queryClauses[] = "hub:".$this->sanitizeQuery($hub);
			}
			
			
		}
		else {
			if ( $searchConfig->isVideoSearch() ) {
				$searchConfig->setNamespaces(array(NS_FILE));
				$queryClauses[] = 'is_video:true';
			}
			
			$nsQuery = '';
			foreach ( $searchConfig->getNamespaces() as $namespace ) {
				$nsQuery .= ( !empty($nsQuery) ? ' OR ' : '' ) . 'ns:' . $namespace;
			}
			$queryClauses[] = "({$nsQuery})";
			
			array_unshift($queryClauses, 'wid:'.$searchConfig->getCityId());
		}
		
		return sprintf( '(%s)', implode(' AND ', $queryClauses) );
	}
	
	private function getBoostQueryString( Solarium_Query_Select $query, WikiaSearchConfig $searchConfig )
	{
		$sanitizedQuery = $query->getQuery();
		
		if ( $searchConfig->isInterWiki() ) {
			$sanitizedQuery = preg_replace('/\bwiki\b/i', '', $sanitizedQuery);
		}
		
		$queryNoQuotes = preg_replace("/['\"]/", '', html_entity_decode($query->getQuery(), ENT_COMPAT, 'UTF-8'));
		
		$boostQueries = array(
				self::valueForField('html', $queryNoQuotes, array('boost'=>5, 'quote'=>'\"')),
		        self::valueForField('title', $queryNoQuotes, array('boost'=>10, 'quote'=>'\"')),
		);
		
		if ( $searchConfig->isInterWiki() ) {
			$boostQueries[] = self::valueForField('wikititle', $queryNoQuotes, array('boost'=>15, 'quote'=>'\"'));
			$boostQueries[] = '-host:\"answers\"^10';
			$boostQueries[] = '-host:\"respuestas\"^10';
		}
		
		return implode(' ', $boostQueries);
	}

	/**
	 * any query string transformation before sending to backend should be placed here
	 */
	private function sanitizeQuery($query) 
	{
		if ( $this->queryHelper === null ) {
			$this->queryHelper = new Solarium_Query_Helper();
		}

		// non-indexed number-string phrases issue workaround (RT #24790)
	    $query = preg_replace('/(\d+)([a-zA-Z]+)/i', '$1 $2', $query);
	
	    // escape all lucene special characters: + - && || ! ( ) { } [ ] ^ " ~ * ? : \ (RT #25482)
	    // added html entity decoding now that we're doing extra work to prevent xss o
	    $query = $this->queryHelper->escapeTerm(html_entity_decode($query,  ENT_COMPAT, 'UTF-8'));
		// @todo make sure this works i'm iffy about it
	    return $query;
	}

	public function getPages( $pageIds, $withMetaData = true ) {
		wfProfileIn(__METHOD__);
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

		wfProfileOut(__METHOD__);
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
		wfProfileIn(__METHOD__);
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

		$namespace = $this->wg->Title->getNamespace();

		$isVideo = false;
		$isImage = false;
		if ( $namespace == NS_FILE && ($file = $this->wf->findFile( $this->wg->Title->getText() )) ) {

			$detail = WikiaFileHelper::getMediaDetail( $this->wg->Title );

			$isVideo = WikiaFileHelper::isVideoFile( $file );
			$isImage = $detail['mediaType'] == 'image' && !$isVideo;

			$metadata = $file->getMetadata();

			if ($metadata !== "0") {
				$metadata = unserialize( $metadata );

				$fileParams = array('description', 'keywords')
							+ ($isVideo ? array('movieTitleAndYear', 'videoTitle') : array());

				foreach ($fileParams as $datum) {
					$html .= isset( $metadata[$datum] ) ? ' ' . $metadata[$datum] : '';
				}
			}
		}

		$title = $page->getTitle()->getText();

		// if it's the namespace for forum thread post... <-- 2001 (forum) 1201 (wall)
		// @todo -- replace numbers with constants
		if ( in_array( $namespace, array(2001, 1201) ) ){
			$wm = WallMessage::newFromId($page->getId());
			$wm->load();
			if ($wm->isMain()) {
				$title = $wm->getMetaTitle();
			} else {
				if ($main = $wm->getTopParentObj() and !empty($main)) {
					$main->load();
					$title = $main->getMetaTitle();
				}
			}
		}
		

		// clear output buffer in case we want get more pages
		$this->wg->Out->clearHTML();

		$result['wid'] = (int) $this->wg->CityId;
		$result['pageid'] = $page->getId();
		$result['id'] = $result['wid'] . '_' . $result['pageid'];
		$result['sitename'] = $this->wg->Sitename;
		$result['title'] = $title;
		$result['canonical'] = $canonical;
		$result['html'] = html_entity_decode($html, ENT_COMPAT, 'UTF-8'); // where are the other constants?
		$result['url'] = $page->getTitle()->getFullUrl();
		$result['ns'] = $page->getTitle()->getNamespace();
		$result['host'] = substr($this->wg->Server, 7);
		$result['lang'] = $this->wg->Lang->mCode;

		# these need to be strictly typed as bool strings since they're passed via http when in the hands of the worker
		$result['iscontent'] = in_array( $result['ns'], $this->wg->ContentNamespaces ) ? 'true' : 'false';
		$result['is_main_page'] = ($page->getId() == Title::newMainPage()->getArticleId() && $page->getId() != 0) ? 'true' : 'false';
		$result['is_redirect'] = ($canonical == '') ? 'false' : 'true';
		$result['is_video'] = $isVideo ? 'true' : 'false';
		$result['is_image'] = $isImage ? 'true' : 'false';


		if ( $this->wg->EnableBacklinksExt && $this->wg->IndexBacklinks ) {
			$result['backlink_text'] = Backlinks::getForArticle($page);
		}


		if( $withMetaData ) {
			$result = array_merge($result, $this->getPageMetaData($page));
		}

		// restore global state
		$this->wg->Title = $wgTitle;
		$this->wg->Request = $wgRequest;

		wfProfileOut(__METHOD__);
		return $result;
	}

	public function getPageMetaData( $page ) {
		wfProfileIn(__METHOD__);
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
			'prop' => 'info|categories',
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

		$result['categories'] = array();

		if (isset($pageData['categories'])) {
			foreach ($pageData['categories'] as $category) {

				$result['categories'][] = implode(':', array_slice(explode(':', $category['title']), 1));

			}
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

		wfProfileOut(__METHOD__);
		return $result;
	}
	
	private function getRedirectTitles( Article $page ) {
		wfProfileIn(__METHOD__);

		$dbr = wfGetDB(DB_SLAVE);

		$result = $dbr->selectRow(array('redirect', 'page'),
				array('GROUP_CONCAT(page_title SEPARATOR " | ") AS redirect_titles'),
				array(),
				__METHOD__,
				array('GROUP'=>'rd_title'),
				array('page' => array('INNER JOIN', array('rd_title'=>$page->mTitle->getDbKey(), 'page_id = rd_from')))
			);

		wfProfileOut(__METHOD__);
		return (!empty($result)) ? str_replace('_', ' ', $result->redirect_titles) : '';
	}

	private function getWikiViews( Article $page ) {
		wfProfileIn(__METHOD__);
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

		wfProfileOut(__METHOD__);
		return $row;
	}

	public function searchVideos( $query, WikiaSearchConfig $searchConfig )
	{
		$searchConfig
			->setNamespaces		(array(NS_FILE))
			->setVideoSearch	(true)
		;

		return $this->doSearch($query, $searchConfig);
	}

	public function getRelatedVideos( WikiaSearchConfig $searchConfig ) {
		wfProfileIn(__METHOD__);
		
        $filterQuery = '(wid:' . $this->wg->cityId . ' OR wid:' . self::VIDEO_WIKI_ID . '^2) AND is_video:true';

		$query = sprintf('wid:%d', $this->wg->cityId);
		if ( $searchConfig->getPageId() !== false ) {
			$query .= sprintf(' AND pageid:%d', $searchConfig->getPageId() );
		} else {

			// tweakable heuristic:
			// the document frequency for the interesting terms needs to be at least 50% of the wiki's pages
			$data = $this->callMediaWikiAPI( array( 'action' => 'query',
													'prop' => 'info|categories',
													'inprop' => 'url|created|views|revcount',
													'meta' => 'siteinfo',
													'siprop' => 'statistics|wikidesc|variables|namespaces|category'
													));

			if (isset($data['query']) && isset($data['query']['statistics']) && isset($data['query']['statistics']['articles'])) {
				$searchConfig->setMindf( (int) ($data['query']['statistics']['articles'] * .5) );
			}
			$query .= ' AND iscontent:true';
		}
		
		$searchConfig
			->setQuery			($query)
			->setFilterQuery	($filterQuery)
			->setMltFields		(array(self::field('title'), self::field('html')));
		
		wfProfileOut(__METHOD__);
		return $this->moreLikeThis( $searchConfig );
	}

	public function getSimilarPages( WikiaSearchConfig $searchConfig ) {
		wfProfileIn(__METHOD__);
		
		$contentUrl = false;
		$streamBody = false;
		$query = $searchConfig->getQuery();
		
		if ( $query == false ) {
			$contentUrl = $searchConfig->getContentUrl();
			if ( $contentUrl === false ) {
				$streamBody = $searchConfig->getStreamBody();
			}
		}
		
		if ( $contentUrl || $streamBody ) {
			$searchConfig->setFilterQuery(implode(' AND ', array_merge($this->getInterWikiQueryClauses())));
		}

		$searchConfig->setMltBoost(true);
		$searchConfig->setMltFields(array('title', 'html'));

		$clientResponse = $this->moreLikeThis( $searchConfig );

		$similarPages = array();
		if ( is_object($clientResponse->response) ) {
			$similarPages = $clientResponse->response->docs;
		}

		$response = array();
		foreach ($similarPages as $similarPage)
		{
		    $response[$similarPage->url] = array('wid'=>$similarPage->wid, 'pageid'=>$similarPage->pageid);
		}
		wfProfileOut(__METHOD__);
		return $response;
	}
	
	public function moreLikeThis( WikiaSearchConfig $searchConfig )
	{
		$query = $searchConfig->getQuery();
		$streamBody = $searchConfig->getStreamBody();
		$streamUrl = $searchConfig->getStreamUrl();
		
		if (! ( $query || $streamBody || $streamUrl ) ) {
	        throw new Exception("A query, url, or stream is required.");
	    }
	    
	    
	    $mlt = $this->client->createMoreLikeThis();
	    $mlt->setMltFields		( $searchConfig->getMltFields() )
	    	->addFilterQuery	( $searchConfig->getFilterQuery() )
	    	->addParam			( 'mlt.match.include', 'false' )
	    	->setStart			( $searchConfig->getStart() )
	    	->setRows			( $searchConfig->getRows() )
	    ;
	    
	    if ( $query !== false ) { 
	    	$mlt->setQuery($query);
	    } else if ( $streamBody ) {
	    	$mlt->setQueryStream	( true )
	    		->setQuery			( $streamBody )
    		;
	    } else if ($streamUrl ) {
	    	$mlt->addParam('mlt.url', $streamUrl);;
	    }
	    
	    $mltResults = $this->client->moreLikeThis( $mlt );
	    
	}

	public function getInterestingTerms($query = false, array $params = array()) {

        wfProfileIn(__METHOD__);
		$params['mlt.fl'] = 'title,headings,first500,redirect_text,html';
		$params['mlt.fl'] = 'title, html';
		$params['mlt.boost'] = 'true';
		#note, mlt.maxnpt might be necessary for performance
		$params['mlt.interestingTerms'] = 'list';

		$params['size'] = 0;

		$memkey = $this->wf->SharedMemcKey( 'WikiaInterestingTerms', md5($query.serialize($params)) );
		
		if ($interestingTerms = $this->wg->Memc->get($memkey)) {
		  return $interestingTerms;
		}

		$clientResponse = $this->getSimilarPages($query, $params);

		$response = array();

		$interestingTerms = $clientResponse->interestingTerms;

		#@todo reverse dictionary-based stemming, but need all unique words, then to stem, then to use the most frequent. yuck.

		$this->wg->Memc->set($memkey, $interestingTerms, self::GROUP_RESULTS_CACHE_TTL);
		wfProfileOut(__METHOD__);
		return $interestingTerms;

	}

	public function getKeywords( WikiaSearchConfig $searchConfig ) {

		$query = sprintf('wid:%d', $this->wg->cityId);
		if ( $searchConfig->getPageId() !== false ) {
			$query .= sprintf(' AND pageid:%d', $searchConfig->getPageId() );
		} else {
			$query .= ' AND is_main_page:1';
		}
		
		$searchConfig->setQuery($query);
		
		return $this->getInterestingTerms( $searchConfig );

	}

	private function callMediaWikiAPI( Array $params ) {
		wfProfileIn(__METHOD__);

		$api = F::build( 'ApiMain', array( 'request' => new FauxRequest($params) ) );
		$api->execute();

		wfProfileOut(__METHOD__);
		return  $api->getResultData();
	}


	public function getArticleMatch( WikiaSearchConfig $config ) {
		wfProfileIn(__METHOD__);

		$term = $config->getQuery();

		if ( $config->hasArticleMatch() ) {
			return $config->getArticleMatch();
		}

		// Try to go to page as entered.
		$title = Title::newFromText( $term );
		# If the string cannot be used to create a title
		if( is_null( $title ) ) {
			wfProfileOut(__METHOD__);
			return null;
		}
		
		// If there's an exact or very near match, jump right there.
		$title = SearchEngine::getNearMatch( $term );
		if( !is_null( $title ) && ( in_array($title->getNamespace(), $config->getNamespaces()) ) ) {
			$article = new Article( $title );

			if($article->isRedirect()) {
				$target = $article->getRedirectTarget();
				// apparently the target can be null
				if ($target instanceOf Title) {
					$config->setArticleMatch(array('article'=>new Article($target), 'redirect'=>$article));
				}
			}
			else {
				$config->setArticleMatch(array('article'=>$article));
			}
			wfProfileOut(__METHOD__);
			return $config->getArticleMatch();
		}

		wfProfileOut(__METHOD__);
		return null;
	}

	public static function onGetPreferences($user, &$defaultPreferences) {
		wfProfileIn( __METHOD__ );

		// removes core mw search prefs
		$defunctPreferences = array('searchlimit',
									'contextlines',
									'contextchars',
									'disablesuggest',
									'searcheverything',
									'searchnamespaces',
									);

		foreach ($defunctPreferences as $goAway) {
			unset($defaultPreferences[$goAway]);
		}

		$defaultPreferences["enableGoSearch"] = array(
			'type' => 'toggle',
			'label-message' => array('wikiasearch2-enable-go-search'),
			'section' => 'under-the-hood/advanced-displayv2',
		);

		$defaultPreferences["searchAllNamespaces"] = array(
			'type' => 'toggle',
			'label-message' => array('wikiasearch2-search-all-namespaces'),
			'section' => 'under-the-hood/advanced-displayv2',
		);

		wfProfileOut( __METHOD__ );
		return true;
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
    

}