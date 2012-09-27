<?php

/**
 * This class is responsible for handling interacting with Solr to retrieve results.
 * It uses a custom-modified version of the Solarium library to build out abstracted queries.
 * 
 * @author Robert Elwell
 */
class WikiaSearch extends WikiaObject {

	/**
	 * Number of result groupings we want on a grouped search
	 * @var int
	 */
	const GROUP_RESULTS_GROUPINGS_LIMIT		= 20;
	
	/**
	 * Number of results per grouping we want in a grouped search
	 */
	const GROUP_RESULTS_GROUPING_ROW_LIMIT	= 4;
	
	/**
	 * Time to cache grouped results, in seconds -- 15 minutes.
	 * @var int
	 */
	const GROUP_RESULTS_CACHE_TTL			= 900;

	/**
	 * This is the cityId value for the video wiki, used in video searches.
	 * @var int
	 */
	const VIDEO_WIKI_ID						= 298117;
	
	/**
	 * This was originally used to track which _kind_ of search technology, 
	 * among many candidates, was used. I'd like to see this removed in the future.
	 * @var int
	 */	
	const RELEVANCY_FUNCTION_ID				= 6;
	
	/**
	 * Snippets should be 150 characters long, by default.
	 * @var int
	 */
	const HL_FRAG_SIZE 						= 150;
	
	/**
	 * This should be prepended to matches in Solr snippets.
	 * @var string
	 */
	const HL_MATCH_PREFIX					= '<span class="searchmatch">';
	
	/**
	 * This should be appended to matches in Solr snippets.
	 * @var string
	 */
	const HL_MATCH_POSTFIX					= '</span>';
	
	/**
	 * These fields are actually dynamic language fields supported in 36 different languages
	 * @see WikiaSearch::field
	 * @staticvar array
	 */
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
	
	/**
	 * Used for dynamically composing unstored language fields
	 * @see WikiaSearch::field
	 * @staticvar array
	 */
	private static $dynamicUnstoredFields = array('headings', 'first500', 'beginningText');
	
	/**
	 * Used for dynamically composing multivalued language fields
	 * @see WikiaSearch::field
	 * @staticvar array
	 */
	private static $multiValuedFields = array('categories', 'redirect_titles', 'headings');

	/**
	 * Search client
	 * @var Solarium_Client
	 */
	protected $client;
	
	/**
	 * Used and reused for string preparation
	 * @var Solarium_Query_Helper
	 */
	protected $queryHelper;
	
	/* Boost functions used in interwiki search
	 * @var array
	 */
	protected $interWikiBoostFunctions = array(
		'log(wikipages)^4',
		'log(activeusers)^4',
		'log(revcount)^1',
		'log(views)^8',
		'log(words)^0.5',
	);

	/**
	 * Boost functions for on-wiki search
	 * @var array
	 */
	protected $onWikiBoostFunctions = array(
		'log(views)^0.66', 
		'log(backlinks)'
	);
	
	public function __construct( Solarium_Client $client ) {
		$this->client = $client;
		$this->client->setAdapter('Solarium_Client_Adapter_Curl');
		parent::__construct();
	}

	/**
	 * perform search
	 *
	 * @param WikiaSearchConfig $searchConfig
	 * @return WikiaSearchResultSet
	 */
	public function doSearch( WikiaSearchConfig $searchConfig ) {
		wfProfileIn(__METHOD__);

		if($searchConfig->getGroupResults() == true) {

			$searchConfig	->setLength		( self::GROUP_RESULTS_GROUPINGS_LIMIT )
							->setIsInterWiki( true )
							->setStart		( ( (int) $searchConfig->getLength() ) * ( ( (int) $searchConfig->getPage() ) - 1 ) )
			;

		} else {
			$searchConfig	->setStart		( ( $searchConfig->getPage() - 1 ) * $searchConfig->getLength() );
		}
		
		$queryInstance = $this->client->createSelect();
		$this->prepareQuery( $queryInstance, $searchConfig );
		$result = $this->client->select( $queryInstance );
		$results = F::build('WikiaSearchResultSet', array($result, $searchConfig) );
		// set here due to all the changes we make to the base query
		$results->setQuery($searchConfig->getQuery());
		
		$searchConfig->setResults		( $results )
					 ->setResultsFound	( $results->getResultsFound() )
		;		

		if( $searchConfig->getPage() == 1 ) {
			$resultCount = $results->getResultsFound();
			Track::event( ( !empty( $resultCount ) ? 'search_start' : 'search_start_nomatch' ), 
							array(	'sterm'	=> $searchConfig->getQuery(), 
									'rver'	=> self::RELEVANCY_FUNCTION_ID,
									'stype'	=> ( $searchConfig->getCityId() == 0 ? 'inter' : 'intra' ) 
								 ) 
						);
		}

		wfProfileOut(__METHOD__);
		return $results;
	}
	
	/**
	 * Takes a query we've created and configures it based on the values set in the SearchConfig
	 * @param Solarium_Query_Select $query
	 * @param WikiaSearchConfig $searchConfig
	 * @return WikiaSearch provides fluent interface
	 */
	private function prepareQuery( Solarium_Query_Select $query, WikiaSearchConfig $searchConfig )
	{
		wfProfileIn(__METHOD__);
		$query->setDocumentClass( 'WikiaSearchResult' );
		
		$sort = $searchConfig->getSort();
		
		$query	->setFields		( $searchConfig->getRequestedFields() )
			  	->setStart		( $searchConfig->getStart() )
				->setRows		( $searchConfig->getLength() )
				->addSort		( $sort[0], $sort[1] )
				->addParam		( 'timeAllowed', $searchConfig->isInterWiki() ? 7500 : 5000 )
		;
		
		$highlighting = $query->getHighlighting();
		$highlighting->addField						( self::field( 'html' ) )
					 ->setSnippets					( 1 )
					 ->setRequireFieldMatch			( true )
					 ->setFragSize					( self::HL_FRAG_SIZE )      
					 ->setSimplePrefix				( self::HL_MATCH_PREFIX )
					 ->setSimplePostfix				( self::HL_MATCH_POSTFIX )
					 ->setAlternateField			( 'html' )
					 ->setMaxAlternateFieldLength	( F::app()->checkSkin( 'wikiamobile' ) ? 100 : 300 )
		;
		
		$queryFieldsString = sprintf( '%s^5 %s %s^4', self::field( 'title' ), self::field( 'html' ), self::field( 'redirect_titles' ) );
		
		if ( $searchConfig->isInterWiki() ) {
			$grouping = $query->getGrouping();
			$grouping	->setLimit			( self::GROUP_RESULTS_GROUPING_ROW_LIMIT )
						->setOffset			( $searchConfig->getStart() )
						->setFields			( array( 'host' ) )
			;
			
			$queryFieldsString .= sprintf( ' %s^7', self::field( 'wikititle' ) );
		}
		
		$query->addFilterQuery( $query->createFilterQuery()->setQuery( $this->getFilterQueryString( $searchConfig ) ) );
		
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
			$dismax->setBoostFunctions( implode(' ', 
												$searchConfig->isInterWiki() 
												? $this->interWikiBoostFunctions 
												: $this->onWikiBoostFunctions 
												)
										);
		}
		
		// this is how we prevent duplicate results when we already have PTT
		$noPtt = '';
		if ( $searchConfig->hasArticleMatch() ) {
			$am			= $searchConfig->getArticleMatch();
			$article	= ( isset( $am['redirect'] ) ) ? $am['redirect'] : $am['article'];  
			$noPtt		= sprintf( ' AND -(id:%s_%s)', $searchConfig->getCityId(), $article->getID() );
		}
		
		$formulatedQuery = sprintf('%s AND (%s)%s', $this->getQueryClausesString( $searchConfig ), $nestedQuery, $noPtt);
		
		$query->setQuery( $formulatedQuery );
		wfProfileOut(__METHOD__);
		return $this;
	}
	
	/**
	 * Builds the string used with filter queries based on search config
	 * @param WikiaSearchConfig $searchConfig
	 * @return string
	 */
	private function getFilterQueryString( WikiaSearchConfig $searchConfig )
	{
		wfProfileIn(__METHOD__);
		$fqString = '';
		if ( $searchConfig->isInterWiki() ) {
			
			$fqString .= 'iscontent:true';
				
			if ( $searchConfig->getHub() !== false ) {
			    $fqString .= ' hub:' . $this->sanitizeQuery( $searchConfig->getHub() );
			}
		}
		else {
			$fqString .= 'wid:' . $searchConfig->getCityId();
		}
		
		if (! $searchConfig->getIncludeRedirects() ) {
			$fqString = "({$fqString}) AND is_redirect:false";
		}
		wfProfileOut(__METHOD__);
		return $fqString;
	}
	
	/**
	 * Builds the necessary query clauses based on values set in the searchconfig object
	 * @param  WikiaSearchConfig $searchConfig
	 * @return string
	 */
	private function getQueryClausesString( WikiaSearchConfig $searchConfig )
	{
		if ( $searchConfig->isInterWiki() ) {
			
			$queryClauses = array();
			
			$widQuery = '';
			
			foreach ( $this->getInterWikiSearchExcludedWikis() as $excludedWikiId ) {
			    $widQuery .= ( !empty($widQuery) ? ' AND ' : '' ) . '!wid:' . $excludedWikiId;
			}
			 
			$queryClauses[] = $widQuery;
			
			$queryClauses[] = "lang:" . $this->wg->ContLang->mCode;
			
			$queryClauses[] = "iscontent:true";
			
			if ( $searchConfig->getHub() !== false ) {
			    $queryClauses[] = "hub:".$this->sanitizeQuery( $searchConfig->getHub() );
			}
		}
		else {
			if ( $searchConfig->isVideoSearch() ) {
				$searchConfig->setNamespaces( array( NS_FILE ) );
				$queryClauses[] = 'is_video:true';
			}
			
			$nsQuery = '';
			foreach ( $searchConfig->getNamespaces() as $namespace ) {
				$nsQuery .= ( !empty($nsQuery) ? ' OR ' : '' ) . 'ns:' . $namespace;
			}
			$queryClauses[] = "({$nsQuery})";
			
			// first priority is to filter by wid; that's why it's prepended
			array_unshift( $queryClauses, 'wid:' . $searchConfig->getCityId() );
		}
		
		return sprintf( '(%s)', implode( ' AND ', $queryClauses ) );
	}
	
	/**
	 * Returns the string used to build out a boost query with Solarium
	 * @param  Solarium_Query_Select $query
	 * @param  WikiaSearchConfig $searchConfig
	 * @return string
	 */
	private function getBoostQueryString( Solarium_Query_Select $query, WikiaSearchConfig $searchConfig )
	{
		$sanitizedQuery = $query->getQuery();
		
		if ( $searchConfig->isInterWiki() ) {
			$sanitizedQuery = preg_replace( '/\bwiki\b/i', '', $sanitizedQuery );
		}
		
		$queryNoQuotes = preg_replace( "/['\"]/", '', html_entity_decode( $query->getQuery(), ENT_COMPAT, 'UTF-8' ) );
		
		$boostQueries = array(
				self::valueForField( 'html', $queryNoQuotes, array( 'boost'=>5, 'quote'=>'\"' ) ),
		        self::valueForField( 'title', $queryNoQuotes, array( 'boost'=>10, 'quote'=>'\"' ) ),
		);
		
		if ( $searchConfig->isInterWiki() ) {
			$boostQueries[] = self::valueForField( 'wikititle', $queryNoQuotes, array( 'boost'=>15, 'quote'=>'\"' ) );
			$boostQueries[] = '-host:\"answers\"^10';
			$boostQueries[] = '-host:\"respuestas\"^10';
		}
		
		return implode( ' ', $boostQueries );
	}

	/**
	 * Prevents XSS and escapes characters used in Lucene query syntax.
	 * Any query string transformations before sending to backend should be placed here.
	 * @param  string $query
	 * @return string
	 */
	private function sanitizeQuery( $query ) 
	{
		if ( $this->queryHelper === null ) {
			$this->queryHelper = new Solarium_Query_Helper();
		}

		// non-indexed number-string phrases issue workaround (RT #24790)
	    $query = preg_replace('/(\d+)([a-zA-Z]+)/i', '$1 $2', $query);
	
	    // escape all lucene special characters: + - && || ! ( ) { } [ ] ^ " ~ * ? : \ (RT #25482)
	    // added html entity decoding now that we're doing extra work to prevent xss
	    $query = $this->queryHelper->escapeTerm( html_entity_decode( $query,  ENT_COMPAT, 'UTF-8' ) );

	    return $query;
	}
	
	/**
	 * Used in the related videos module to get both premium and on-wiki videos.
	 * @param  WikiaSearchConfig $searchConfig
	 * @return WikiaSearchResultSet
	 */
	public function getRelatedVideos( WikiaSearchConfig $searchConfig ) {
		wfProfileIn(__METHOD__);
		
        $filterQuery = '(wid:' . $searchConfig->getCityId() . ' OR wid:' . self::VIDEO_WIKI_ID . '^2) AND is_video:true';

		$query = sprintf( 'wid:%d', $searchConfig->getCityId() );
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

			if ( isset( $data['query'] ) && isset( $data['query']['statistics'] ) && isset( $data['query']['statistics']['articles'] ) ) {
				$searchConfig->setMindf( (int) ($data['query']['statistics']['articles'] * .5) );
			}
			$query .= ' AND iscontent:true';
		}
		
		$searchConfig
			->setQuery			($query)
			->setFilterQuery	($filterQuery)
								// note that we're also adding the default title field 
								// for slightly better foreign language coverage
			->setMltFields		( array( self::field( 'title' ), self::field('html'), 'title' ) );
		
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
			$searchConfig->setFilterQuery( $this->getQueryClausesString( $searchConfig ) );
		}

		$searchConfig	->setMltBoost( true )
						->setMltFields( array( self::field( 'title' ), self::field( 'html' ), 'title' ) );

		$clientResponse = $this->moreLikeThis( $searchConfig );

		$similarPages = array();
		if ( is_object( $clientResponse->response ) ) {
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
		$interestingTerms = $this->wg->Memc->get($memkey);
		if ( !empty( $interestingTerms ) ) {
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

		$query = sprintf('wid:%d', $searchConfig->getCityId() );
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
        $lang = preg_replace('/-.*/', '', $this->wg->LanguageCode);
        if ( in_array($field, self::$languageFields) &&
                in_array($this->wg->LanguageCode, $this->wg->WikiaSearchSupportedLanguages) ) {
    
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