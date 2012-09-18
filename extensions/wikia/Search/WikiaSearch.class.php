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
	
	private static $requestedFields = array(
			'id',
	        'wikiarticles',
	        'wikititle',
	        'url',
	        'wid',
	        'canonical',
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

	private $rankOptions = array(	
			'default'			=>	array( 'score',		Solarium_Query_Select::SORT_DESC ),
	        'newest'			=>	array( 'created',	Solarium_Query_Select::SORT_DESC ),
	        'oldest'			=>	array( 'created',	Solarium_Query_Select::SORT_ASC  ),
	        'recently-modified'	=>	array( 'touched',	Solarium_Query_Select::SORT_DESC ),
	        'stable'			=>	array( 'touched',	Solarium_Query_Select::SORT_ASC  ),
	        'most-viewed'		=>	array( 'views',		Solarium_Query_Select::SORT_DESC ),
	        'freshest'			=>	array( 'indexed',	Solarium_Query_Select::SORT_DESC ),
	        'stalest'			=>	array( 'indexed', 	Solarium_Query_Select::SORT_ASC  ),
	);

	/**
	 * Search client
	 * @var WikiaSearchClient
	 */
	protected $client = null;
	protected $parserHookActive = false;
	protected $namespaces = array();
	protected $skipCache = false;
	protected $includeRedirects = true;
	protected $articleMatch = null;

	public function __construct( WikiaSearchClient $client ) {
		$this->client = $client;
		parent::__construct();
	}

	/**
	 * perform search
	 *
	 * @param string $query
	 * @param array $methodParams
	 * @return WikiaSearchResultSet
	 */
	public function doSearch( $query, WikiaSearchConfig $searchConfig ) {
		wfProfileIn(__METHOD__);

		// generate query
		
		$methodParams['page'] = isset($methodParams['page']) ? $methodParams['page'] : 1; // query->setStart()
		$methodParams['length'] = isset($methodParams['length']) ? $methodParams['length'] : null; // query->setRows()
		$methodParams['cityId'] = isset($methodParams['cityId']) ? $methodParams['cityId'] : 0; // this->setCityId
		$methodParams['groupResults'] = isset($methodParams['groupResults']) ? $methodParams['groupResults'] : false; // this->setGroupResults 
		$methodParams['rank'] = isset($methodParams['rank']) ? $methodParams['rank'] : 'default'; // query->addSort()
		$methodParams['hub'] = isset($methodParams['hub']) ? $methodParams['hub'] : false; // this->hub 
		$methodParams['videoSearch'] = isset($methodParams['videoSearch']) ? $methodParams['videoSearch'] : false; // this->videoSearch
		
		extract($methodParams);

		$length = !empty($length) ? $length : self::RESULTS_PER_PAGE;
		$groupResults = ( empty($cityId) && $groupResults );

		if($groupResults) {

			$length = self::GROUP_RESULTS_SEARCH_LIMIT;

			$methodOptions = array( 'rank'=>$rank,
									'hub'=>$hub,
									'size' => $length,
									'cityId' =>  $cityId,
									'isInterWiki' => true,
									'start' => $length * ($page - 1),
								  );
			$results = $this->client->search( $query, $methodOptions );
		}
		else {
			// no grouping, e.g. intra-wiki searching
			if($this->namespaces) {
					$this->client->setNamespaces($this->namespaces);
			} 

			$methodOptions = array('start'  => (($page - 1) * $length), 
					       'size' => $length, 
					       'cityId' => $cityId, 
					       'includeRedirects' => $this->includeRedirects,
					       'rank' => $rank,
						   'videoSearch' => $videoSearch,
					       );
			$results = $this->client->search( $query, $methodOptions);

			if (!$this->namespaces) {
				$this->namespaces = $this->client->getNamespaces();
			}
		}

		if( $page == 1 ) {
			$resultCount = $results->getResultsFound();
			Track::event( ( !empty( $resultCount ) ? 'search_start' : 'search_start_nomatch' ), 
							array(	'sterm' => $query, 
									'rver' => self::RELEVANCY_FUNCTION_ID,
									'stype' => ( empty($cityId) ? 'inter' : 'intra' ) 
								 ) 
						);
		}

		wfProfileOut(__METHOD__);
		return $results;
	}


	public function setClient( WikiaSearchClient $client ) {
		$this->client = $client;
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

	public function searchVideos( $query, array $methodParams = array() )
	{
		$this->namespaces = array(NS_FILE);
		$methodParams['videoSearch'] = true;

		return $this->doSearch($query, $methodParams);
	}

	public function getRelatedVideos(array $params = array('start'=>0, 'size'=>20)) {
	        wfProfileIn(__METHOD__);
	        # going to need an "is_video" field
	        if ( !empty($params['video_wiki_only']) ) {
				$params['fq'] = ' wid:' . self::VIDEO_WIKI_ID .' ';

				
	        } else {
		        $params['fq'] = '(wid:' . $this->wg->cityId . ' OR wid:' . self::VIDEO_WIKI_ID . '^2) ';
	        }
		$params['fq'] .= 'AND is_video:true';

		$query = sprintf('wid:%d', $this->wg->cityId);
		if (isset($params['pageId'])) {
		  $query .= sprintf(' AND pageid:%d', $params['pageId']);
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
				$params['mindf'] = (int) ($data['query']['statistics']['articles'] * .5);
			}
			$query .= ' AND iscontent:true';
		}
		wfProfileOut(__METHOD__);
	        return $this->getSimilarPages($query, $params);
	}

	public function getSimilarPages($query = false, array $params = array()) {

	        wfProfileIn(__METHOD__);
	        if ((!$query) && (isset($params['content.url']) || isset($params['stream.body']))) {
		  $params['fq'] = implode(' AND ', array_merge($this->client->getInterWikiQueryClauses()));
	        }

		$params['mlt.boost'] = 'true';
		#note, mlt.maxnpt might be necessary for performance
		$params['mlt.fl'] = 'title,html';

		$clientResponse = $this->client->getSimilarPages($query, $params);

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

		$clientResponse = $this->client->getSimilarPages($query, $params);

		$response = array();

		$interestingTerms = $clientResponse->interestingTerms;

		#@todo reverse dictionary-based stemming, but need all unique words, then to stem, then to use the most frequent. yuck.

		$this->wg->Memc->set($memkey, $interestingTerms, self::GROUP_RESULTS_CACHE_TTL);
		wfProfileOut(__METHOD__);
		return $interestingTerms;

	}

	public function getKeywords($params) {

	        $query = sprintf('wid:%d', $this->wg->cityId);
		if (isset($params['pageId'])) {
		  $query .= sprintf(' AND pageid:%d', $params['pageId']);
		} else {
		  $query .= ' AND is_main_page:1';
		}
		
		return $this->getInterestingTerms($query, $params);

	}

	public function getTagCloud(array $params = array('maxpages'=>25, 'termcount'=>'20', 'maxfontsize'=>'56', 
                                                          'minfontsize'=>6, 'sizetype'=>'px')) {
	        wfProfileIn(__METHOD__);
	        $wid = $this->wg->cityId;

		$query = 'wid:'.$wid.' AND iscontent:true';

		$methodOptions = array('sort'=>'views desc');

		$response =$this->client->searchByLuceneQuery($query, 0, $params['maxpages'], $methodOptions);
		$docs = $response->response->docs;

		$interestingTerms = array();

		foreach ($docs as $doc) {

		  $termResults = $this->getInterestingTerms('wid:'.$wid.' AND pageid:'.$doc->pageid);

		  foreach ($termResults as $term) {
		    $interestingTerms[$term] = isset($interestingTerms[$term]) ? $interestingTerms[$term]+1 : 1;;
		  }

		}

		arsort($interestingTerms);

		$interestingTerms = array_slice($interestingTerms, 0, $params['termcount']);

		$termsToFontSize = array();

		$min = min(array_values($interestingTerms));
		$max = max(array_values($interestingTerms));

		foreach ($interestingTerms as $term=>$count) {
		  $termsToFontSize[$term] = max(array($params['minfontsize'], 
						      #tagcloud calc
						      round(abs($params['maxfontsize'] * ($count - $min) /  ($max - $min))) 
						      )
						).$params['sizetype'];
		}
		wfProfileOut(__METHOD__);
		return $termsToFontSize;

	}

	private function callMediaWikiAPI( Array $params ) {
		wfProfileIn(__METHOD__);

		$api = F::build( 'ApiMain', array( 'request' => new FauxRequest($params) ) );
		$api->execute();

		wfProfileOut(__METHOD__);
		return  $api->getResultData();
	}


	public function getArticleMatch( $term ) {
		wfProfileIn(__METHOD__);

		if ($this->articleMatch !== null) {
			return $this->articleMatch;
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
		if( !is_null( $title )) {
			$article = new Article( $title );

			if($article->isRedirect()) {
				$target = $article->getRedirectTarget();
				// apparently the target can be null
				if ($target instanceOf Title) {
					$this->articleMatch = array('article'=>new Article($target), 'redirect'=>$article);
				}
			}
			else {
				$this->articleMatch = array('article'=>$article);
			}
			wfProfileOut(__METHOD__);
			return $this->articleMatch;
		}

		wfProfileOut(__METHOD__);
		return null;
	}


	public function setNamespaces( Array $namespaces ) {
		$this->namespaces = $namespaces;
	}

	public function getNamespaces() {
		return $this->namespaces;
	}

	public function setSkipCache($value) {
		$this->skipCache = (bool) $value;
	}

	public function getSkipCache() {
		return $this->skipCache;
	}

	public function setIncludeRedirects($value) {
		$this->includeRedirects = $value;
	}

	public function getIncludeRedirects() {
		return $this->includeRedirects;
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

}