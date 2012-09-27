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
	 * @return Solarium_Result_MoreLikeThis
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

	/**
	 * A more textual interface to the MoreLikeThis functionality
	 * @param  WikiaSearchConfig $searchConfig
	 * @return array of urls to array of wid and pageid
	 */
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

		$response = array();
		foreach ( $clientResponse->getDocuments() as $similarPage ) {
		    $response[$similarPage['url']] = array(
		    		'wid'		=>	$similarPage['wid'], 
		    		'pageid'	=>	$similarPage['pageid']
    		);
		}
		wfProfileOut(__METHOD__);
		return $response;
	}
	
	/**
	 * Utilizes Solr's MoreLikeThis component to return similar pages
	 * @param  WikiaSearchConfig $searchConfig
	 * @return Solarium_Result_MoreLikeThis
	 */
	private function moreLikeThis( WikiaSearchConfig $searchConfig )
	{
		$query = $searchConfig->getQuery();
		$streamBody = $searchConfig->getStreamBody();
		$streamUrl = $searchConfig->getStreamUrl();
		
		if (! ( $query || $streamBody || $streamUrl ) ) {
	        throw new Exception("A query, url, or stream is required.");
	    }
	    
	    $mlt = $this->client->createMoreLikeThis();
	    $mlt->setMltFields		( $searchConfig->getMltFields() )
	    	->addParam			( 'mlt.match.include', 'false' )
	    	->setStart			( $searchConfig->getStart() )
	    	->setRows			( $searchConfig->getRows() )
	    ;
	    
	    if ( $searchConfig->getFilterQuery() ) {
	    	$mlt->addFilterQuery( $mlt->createFilterQuery()->getQuery( $searchConfig->getFilterQuery() ) );
	    }
	    if ( $query !== false ) { 
	    	$mlt->setQuery( $query );
	    } else if ( $streamBody ) {
	    	$mlt->setQueryStream	( true )
	    		->setQuery			( $streamBody )
    		;
	    } else if ($streamUrl ) {
	    	$mlt->addParam( 'mlt.url', $streamUrl );
	    }
	    
	    return $this->client->moreLikeThis( $mlt );
	}

	/**
	 * Retrives interesting terms from a MoreLikeThis search
	 * @param  WikiaSearchConfig $searchConfig
	 * @return array of interesting terms
	 */
	public function getInterestingTerms( WikiaSearchConfig $searchConfig ) {
        wfProfileIn(__METHOD__);
        
        $searchConfig->setInterestingTerms	( 'list' )
        			 ->setMltFields			( array( self::field( 'title' ), self::field( 'html' ) ) )
        			 ->setMltBoost			( true )
		;
        
		$result = $this->moreLikeThis( $searchConfig );
		
		wfProfileOut(__METHOD__);
		return $result->getInterestingTerms();
	}

	/**
	 * Used to return interesting terms for a given page
	 * @param  WikiaSearchConfig $searchConfig
	 * @return array of interesting terms
	 */
	public function getKeywords( WikiaSearchConfig $searchConfig ) {
		wfProfileIn(__METHOD__);
		$query = sprintf('wid:%d', $searchConfig->getCityId() );
		if ( $searchConfig->getPageId() !== false ) {
			$query .= sprintf(' AND pageid:%d', $searchConfig->getPageId() );
		} else {
			$query .= ' AND is_main_page:1';
		}
		
		$searchConfig->setQuery($query);
		
		wfProfileOut(__METHOD__);
		return $this->getInterestingTerms( $searchConfig );
	}

	/**
	 * Used to access API data from various MediaWiki services
	 * @param  array $params
	 * @return array result data
	 **/
	private function callMediaWikiAPI( Array $params ) {
		wfProfileIn(__METHOD__);

		$api = F::build( 'ApiMain', array( 'request' => new FauxRequest($params) ) );
		$api->execute();

		wfProfileOut(__METHOD__);
		return  $api->getResultData();
	}

	/**
	 * Finds an article match and sets the value in the search config
	 * @param WikiaSearchConfig $config
	 * @return Article|null
	 */
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

	/**
	 * Used to configure the user preference pane settings for search. 
	 * This is a registered hook function of the samme name.
	 * @param User $user
	 * @param 
	 */ 
	public static function onGetPreferences($user, &$defaultPreferences) {
		wfProfileIn( __METHOD__ );

		// removes core mw search prefs
		$defunctPreferences = array(
			'searchlimit',
			'contextlines',
			'contextchars',
			'disablesuggest',
			'searcheverything',
			'searchnamespaces',
		);

		foreach ( $defunctPreferences as $goAway ) {
			unset( $defaultPreferences[$goAway] );
		}

		$defaultPreferences["enableGoSearch"] = array(
			'type'			=> 'toggle',
			'label-message'	=> array('wikiasearch2-enable-go-search'),
			'section'		=> 'under-the-hood/advanced-displayv2',
		);

		$defaultPreferences["searchAllNamespaces"] = array(
			'type'			=> 'toggle',
			'label-message'	=> array('wikiasearch2-search-all-namespaces'),
			'section'		=> 'under-the-hood/advanced-displayv2',
		);

		wfProfileOut( __METHOD__ );
		return true;
	}
    
	/**
	 * Used to compose field name, value, boosts, and quotes in support of dynamic language fields
	 * @param  string $field
	 * @param  string $value
	 * @param  array  $params
	 * @return string the lucene-ready string 
	 **/
    public static function valueForField ( $field, $value, array $params = array() )
    {
        $boostVal = isset($params['boost']) && $params['boost'] !== false ? '^'.$params['boost'] : '';
    
        $evaluate = isset($params['quote']) && $params['quote'] !== false ? "(%s:{$params['quote']}%s{$params['quote']})%s" : '(%s:%s)%s';
    
        return sprintf( $evaluate, self::field( $field ), $value, $boostVal );
    }
    
    /**
     * Accepts a string and, checks it against a known set of dynamic language fields, and composes 
     * a field namebased on the language context and field set membership.
     * @param  string $field
     * @return string the dynamic field, or the field name if not dynamic  
     **/
    public static function field ( $field )
    {
        $lang = preg_replace( '/-.*/', '', $this->wg->LanguageCode );
        if ( 		in_array( $field, self::$languageFields ) 
        		&&	in_array( $this->wg->LanguageCode, $this->wg->WikiaSearchSupportedLanguages ) ) {
    
            $us = in_array( $field, self::$dynamicUnstoredFields ) ? '_us' : '';
    
            $mv = in_array( $field, self::$multiValuedFields ) ? '_mv' : '';
    
            $field .= $us . $mv . '_' . $lang;
        }
    
        return $field;
    }
    
    /**
     * get list of wikis excluded from inter-wiki searching
     * @param  int $currentWikiId
     * @return array
     */
    private function getInterWikiSearchExcludedWikis($currentWikiId = 0) {
        wfProfileIn(__METHOD__);
    
        $cacheKey		= $this->wf->SharedMemcKey( 'crossWikiaSearchExcludedWikis' );
        $privateWikis	= $this->wg->Memc->get( $cacheKey );
    
        if(! is_array( $privateWikis ) ) {
            // get private wikis from db
            $wgIsPrivateWiki	= WikiFactory::getVarByName( 'wgIsPrivateWiki', $currentWikiId );
            $privateWikis		= WikiFactory::getCityIDsFromVarValue( $wgIsPrivateWiki->cv_id, true, '=' );
            $wg->Memc->set( $cacheKey, $privateWikis, 3600 ); // cache for 1 hour
        }
    
        wfProfileOut(__METHOD__);
        return count( $privateWikis ) ? array_merge( $privateWikis, $this->wg->CrossWikiaSearchExcludedWikis ) : $this->wg->CrossWikiaSearchExcludedWikis;
    }
}