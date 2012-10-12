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
	 * @var int
	 */
	const GROUP_RESULTS_GROUPING_ROW_LIMIT	= 4;
	
	/**
	 * The field(s) to group over.
	 * @var array
	 */
	const GROUP_RESULTS_GROUPING_FIELD		= 'host';
	
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
	public static $languageFields  = array(
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
	private static $queryHelper;
	
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
	
	/**
	 * Instantiates the class; sets and configures the Solarium client
	 * @param Solarium_Client $client
	 */
	public function __construct( Solarium_Client $client ) {
		$this->client = $client;
		$this->client->setAdapter('Solarium_Client_Adapter_Curl');
		parent::__construct();
	}

	/**
	 * Public methods -- these generally speak with controllers 
	 * (Search, Related Videos, Game Guide)
	 *------------------------------------------------------------------------*/
	
	/**
	 * perform search
	 * @param  WikiaSearchConfig $searchConfig
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
		
		try {
			$result = $this->client->select( $this->getSelectQuery( $searchConfig ) );
			
		} catch ( Exception $e ) {
			Wikia::log(__METHOD__, 'Querying Solr First Time', $e);
			$searchConfig->setSkipBoostFunctions( true );
			try {
				$result = $this->client->select( $this->getSelectQuery( $searchConfig ) );
			} catch ( Exception $e ) {
				Wikia::log(__METHOD__, 'Querying Solr With No Boost Functions', $e);
				$result = F::build('Solarium_Result_Select_Empty');
			}
		}
		
		$results = F::build('WikiaSearchResultSet', array($result, $searchConfig) );
		
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
	 * Retrives interesting terms from a MoreLikeThis search
	 * @param  WikiaSearchConfig $searchConfig
	 * @return array of interesting terms
	 */
	public function getInterestingTerms( WikiaSearchConfig $searchConfig ) {
	    wfProfileIn(__METHOD__);
	
	    $searchConfig	->setInterestingTerms	( 'list' )
	    				->setMltFields			( array( self::field( 'title' ), self::field( 'html' ), 'title' ) )
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
	    $query = self::valueForField( 'wid', $searchConfig->getCityId() );
	    if ( $searchConfig->getPageId() !== false ) {
	        $query .= sprintf(' AND %s', self::valueForField( 'pageid', $searchConfig->getPageId() ) );
	    } else {
	        $query .= sprintf(' AND %s', self::valueForField( 'is_main_page', '1' ) );
	    }
	
	    $searchConfig	->setQuery($query)
	    				->setMltFields	( array( self::field( 'title' ), self::field( 'html' ), 'title' ) );
	    
	
	    wfProfileOut(__METHOD__);
	    return $this->getInterestingTerms( $searchConfig );
	}

	/**
	 * Used in the related videos module to get both premium and on-wiki videos.
	 * @param  WikiaSearchConfig $searchConfig
	 * @return WikiaSearchResultSet
	 */
	public function getRelatedVideos( WikiaSearchConfig $searchConfig ) {
	    wfProfileIn(__METHOD__);
	
	    $filterQuery = sprintf( '(%s OR %s) AND %s', 
	    						self::valueForField( 'wid', 		$searchConfig->getCityId() ),
	    						self::valueForField( 'wid', 		self::VIDEO_WIKI_ID, array( 'boost' => 2 ) ),
	    						self::valueForField( 'is_video', 	'true' )
	    						);
	    								
	
	    $query = self::valueForField( 'wid', $searchConfig->getCityId() );
	    if ( $searchConfig->getPageId() != false ) {
	        $query .= sprintf(' AND %s', self::valueForField( 'pageid', $searchConfig->getPageId() ) );
	    } else {
	        // tweakable heuristic:
	        // the document frequency for the interesting terms needs to be at least 50% of the wiki's pages
	        $data = $this->callMediaWikiAPI( array( 'action'	=> 'query',
									                'prop'		=> 'info|categories',
									                'inprop'	=> 'url|created|views|revcount',
									                'meta'		=> 'siteinfo',
									                'siprop'	=> 'statistics|wikidesc|variables|namespaces|category'
	                						));
	
			if ( isset( $data['query'] ) && isset( $data['query']['statistics'] ) && isset( $data['query']['statistics']['articles'] ) ) {
				$searchConfig->setMindf( (int) ($data['query']['statistics']['articles'] * .5) );
	    	}
			$query .= ' AND ' . self::valueForField( 'iscontent', 'true' );
		}

		$searchConfig
			->setQuery			( $query )
			->setMltFilterQuery	( $filterQuery )
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
	
		$streamUrl = false;
		$streamBody = false;
		$query = $searchConfig->getQuery();
	
		if ( $query == false ) {
			$streamUrl = $searchConfig->getStreamUrl();
			if ( $streamUrl === false ) {
				$streamBody = $searchConfig->getStreamBody();
			}
		}
	
		if ( $streamUrl || $streamBody ) {
			$searchConfig->setFilterQuery( $this->getQueryClausesString( $searchConfig ) );
		}
	
		$searchConfig	->setMltBoost( true )
						->setMltFields( array( self::field( 'title' ), self::field( 'html' ), 'title' ) );
	
		$resultSet = $this->moreLikeThis( $searchConfig );
	
		$response = array();
		foreach ( $resultSet as $similarPage ) {
			$response[$similarPage['url']] = array(
				'wid'		=>	$similarPage['wid'],
				'pageid'	=>	$similarPage['pageid']
			);
		}
		wfProfileOut(__METHOD__);
		return $response;
	}
	

	/**
	 * Finds an article match and sets the value in the search config
	 * @see    WikiaSearchTest::testGetArticleMatch
	 * @see    WikiaSearchTest::testGetArticleMatchWithNoMatch
	 * @see    WikiaSearchTest::testGetArticleMatchWithMatchFirstCall
	 * @see    WikiaSearchTest::testGetArticleMatchWithMatchFirstCallMismatchedNamespaces
	 * @param  WikiaSearchConfig $config
	 * @return WikiaSearchArticleMatch|null
	 */
	public function getArticleMatch( WikiaSearchConfig $config ) {
	    wfProfileIn(__METHOD__);
	
	    if ( $config->hasArticleMatch() ) {
	        return $config->getArticleMatch();
	    }
	    
	    $term 			= $config->getOriginalQuery();
	    $searchEngine	= F::build( 'SearchEngine' );
    	$title			= $searchEngine->getNearMatch( $term );
    	
	    if( ( $title !== null ) && ( in_array( $title->getNamespace(), $config->getNamespaces() ) ) ) {
	        $article		= F::build( 'Article',					array( $title, RequestContext::getMain() ), 'newFromTitle' );
	        $articleMatch	= F::build( 'WikiaSearchArticleMatch',	array( $article ) );
	
	        $config->setArticleMatch( $articleMatch );
	        
	        wfProfileOut(__METHOD__);
	        return $articleMatch;
	    }
	    wfProfileOut(__METHOD__);
	    return null;
	}
	
	/**
	 * Public static helper functions for dynamic language support
	 *------------------------------------------------------------------------*/
	
	/**
	 * Used to compose field name, value, boosts, and quotes in support of dynamic language fields
	 * @see    WikiaSearchTest::testFieldMethods
	 * @param  string $field
	 * @param  string $value
	 * @param  array  $params
	 * @return string the lucene-ready string
	 **/
	public static function valueForField ( $field, $value, array $params = array() )
	{
		wfProfileIn( __METHOD__ );
		$lang 		= isset( $params['lang']   ) && $params['lang']   !== false ? $lang : null;
		$negate		= isset( $params['negate'] ) && $params['negate'] !== false ? '-' : '';
	    $boostVal	= isset( $params['boost']  ) && $params['boost']  !== false ? '^'.$params['boost'] : '';
	    $evaluate	= isset( $params['quote']  ) && $params['quote']  !== false ? "%s(%s:{$params['quote']}%s{$params['quote']})%s" : '%s(%s:%s)%s';
	
	    wfProfileOut( __METHOD__ );
	    return sprintf( $evaluate, $negate, self::field( $field, $lang ), self::sanitizeQuery( $value ), $boostVal );
	}
	
	/**
	 * Accepts a string and, checks it against a known set of dynamic language fields, and composes
	 * a field namebased on the language context and field set membership.
	 * @see    WikiaSearchTest::testFieldMethods
	 * @param  string $field
	 * @return string the dynamic field, or the field name if not dynamic
	 **/
	public static function field ( $field, $lang = null )
	{
		wfProfileIn( __METHOD__ );
		global $wgLanguageCode, $wgWikiaSearchSupportedLanguages;
	    $lang = $lang ?: preg_replace( '/-.*/', '', $wgLanguageCode );
	    if ( 		in_array( $field,	self::$languageFields )
	            &&	in_array( $lang,	$wgWikiaSearchSupportedLanguages ) ) {
	
	        $us = in_array( $field, self::$dynamicUnstoredFields )	? '_us' : '';
	        $mv = in_array( $field, self::$multiValuedFields )		? '_mv' : '';
	        $field .= $us . $mv . '_' . $lang;
	    }
	    wfProfileOut( __METHOD__ );
	    return $field;
	}
	
	/**
	 * Prevents XSS and escapes characters used in Lucene query syntax.
	 * Any query string transformations before sending to backend should be placed here.
	 * @see    WikiaSearchTest::testSanitizeQuery
	 * @param  string $query
	 * @return string
	 */
	public static function sanitizeQuery( $query )
	{
		wfProfileIn( __METHOD__ );
	    if ( self::$queryHelper === null ) {
	        self::$queryHelper = new Solarium_Query_Helper();
	    }
	
	    // non-indexed number-string phrases issue workaround (RT #24790)
	    $query = preg_replace('/(\d+)([a-zA-Z]+)/i', '$1 $2', $query);
	
	    // escape all lucene special characters: + - && || ! ( ) { } [ ] ^ " ~ * ? : \ (RT #25482)
	    // added html entity decoding now that we're doing extra work to prevent xss
	    $query = self::$queryHelper->escapeTerm( html_entity_decode( $query,  ENT_COMPAT, 'UTF-8' ) );
		wfProfileOut( __METHOD__ );
	    return $query;
	}
	
	/**
	 * Private functions -- used mostly for query preparation and configuration
	 *------------------------------------------------------------------------*/
	
	/**
	 * Creates an instance of Solarium_Query_Select configured by searchconfig.
	 * @see    WikiaSearchTest::testGetQuery
	 * @param  Solarium_Query_Select $query
	 * @param  WikiaSearchConfig $searchConfig
	 * @return Solarium_Query_Select
	 */
	private function getSelectQuery( WikiaSearchConfig $searchConfig )
	{
		wfProfileIn(__METHOD__);
		$query = $this->client->createSelect();
		$query->setDocumentClass( 'WikiaSearchResult' );
		
		$sort = $searchConfig->getSort();
		
		$query	->addFields		( $searchConfig->getRequestedFields() )
				->removeField	('*')
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
					 ->setMaxAlternateFieldLength	( 100 )
		;
		
		$query->addFilterQuery( array(
				'query'		=>		$this->getFilterQueryString( $searchConfig ),
				'key'		=>		'fq1' // constraint of library
		) );
		
		if ( $searchConfig->isInterWiki() ) {
			$grouping = $query->getGrouping();
			$grouping	->setLimit			( self::GROUP_RESULTS_GROUPING_ROW_LIMIT )
						->setOffset			( $searchConfig->getStart() )
						->setFields			( array( self::GROUP_RESULTS_GROUPING_FIELD ) )
			;
		}
		
		// this is how we prevent duplicate results when we already have PTT
		$noPtt = '';
		if ( $searchConfig->hasArticleMatch() ) {
			$am			= $searchConfig->getArticleMatch();
			$article	= $am->getArticle();  
			$noPtt		= self::valueForField( 'id', sprintf( '%s_%s', $searchConfig->getCityId(), $article->getID() ), array( 'negate' => true ) ) ;
			
			$query->addFilterQuery( array(
					'query'		=>	$noPtt,
					'key'		=>	'ptt'
			) );
		}
		
		$formulatedQuery = sprintf('%s AND (%s)', $this->getQueryClausesString( $searchConfig ), $this->getNestedQuery( $searchConfig ));
		$query->setQuery( $formulatedQuery );
		wfProfileOut(__METHOD__);
		return $query;
	}
	
	/**
	 * Creates a nested query using dismax.
	 * @see    WikiaSearchTest::testGetNestedQuery
	 * @param  WikiaSearchConfig $searchConfig
	 * @return Solarium_Query_Select
	 */
	private function getNestedQuery( WikiaSearchConfig $searchConfig ) {
		wfProfileIn( __METHOD__ );
		$nestedQuery = $this->client->createSelect();
		$nestedQuery->setQuery( $searchConfig->getQuery() );
		
		$dismax = $nestedQuery->getDismax();
		
		$boostQueryString = $this->getBoostQueryString( $searchConfig );
		
		$queryFieldsString = $this->getQueryFieldsString( $searchConfig );
		
		$dismax	->setQueryFields		( $queryFieldsString )
				->setQueryParser		( 'edismax' )
		;
		
		if ( $this->wg->SharedExternalDB !== null ) {
			$dismax
				->setPhraseFields		( $queryFieldsString )
				->setBoostQuery			( $this->getBoostQueryString( $searchConfig ) )
				->setMinimumMatch		( $searchConfig->getMinimumMatch() )
				->setPhraseSlop			( 3 )
				->setTie				( 0.01 )
			;
			if (! $searchConfig->getSkipBoostFunctions() ) {
			    $dismax->setBoostFunctions(
			            implode(' ',
			                    $searchConfig->isInterWiki()
			                    ? $this->interWikiBoostFunctions
			                    : $this->onWikiBoostFunctions
			            )
			    );
			}
		}
		
		wfProfileOut( __METHOD__ );
		return $nestedQuery;
	}
	
	/**
	 * Return a string of query fields based on configuration
	 * @see    WikiaSearchTest::testGetQueryFieldsString
	 * @param  WikiaSearchConfig $searchConfig
	 * @return string
	 */
	private function getQueryFieldsString( WikiaSearchConfig $searchConfig ) {

		$queryFieldsString = sprintf( '%s^5 %s^1.5 %s^4 %s^1', self::field( 'title' ), self::field( 'html' ), self::field( 'redirect_titles' ), self::field( 'categories' ) );

		if ( $searchConfig->getVideoSearch() && $this->wg->LanguageCode !== 'en' ) {
		    // video wiki requires english field search
		    $queryFieldsString .= sprintf( ' %s^5 %s^1.5 %s^4', self::field( 'title', 'en' ), self::field( 'html', 'en' ), self::field( 'redirect_titles', 'en' ) );
		}
		
		if ( $searchConfig->isInterWiki() ) {
		    $queryFieldsString .= sprintf( ' %s^7', self::field( 'wikititle' ) );
		}
		
		return $queryFieldsString;
	}
	
	/**
	 * Builds the string used with filter queries based on search config
	 * @see WikiaSearchTest::testGetFilterQueryString
	 * @param WikiaSearchConfig $searchConfig
	 * @return string
	 */
	private function getFilterQueryString( WikiaSearchConfig $searchConfig )
	{
		wfProfileIn(__METHOD__);
		$filterQueries = array();
		if ( $searchConfig->isInterWiki() ) {
			
			$filterQueries[] = self::valueForField( 'iscontent', 'true');
			
			$hub = $searchConfig->getHub();
			if (! empty( $hub ) ) {
			    $filterQueries[] = self::valueForField( 'hub', $hub );
			}
		}
		else {
			$filterQueries[] 	= $searchConfig->getVideoSearch() 
								? sprintf('(%s OR %s)', self::valueForField( 'wid', $searchConfig->getCityId() ), self::valueForField( 'wid', self::VIDEO_WIKI_ID ) )
								: self::valueForField( 'wid', $searchConfig->getCityId() );
		}
		
		if (! $searchConfig->getIncludeRedirects() ) {
			$filterQueries[] = self::valueForField( 'is_redirect', 'false');
		}
		wfProfileOut(__METHOD__);
		return implode( ' AND ', $filterQueries );
	}
	
	/**
	 * Builds the necessary query clauses based on values set in the searchconfig object
	 * @see    WikiaSearchTest::testGetQueryClausesString
	 * @param  WikiaSearchConfig $searchConfig
	 * @return string
	 */
	private function getQueryClausesString( WikiaSearchConfig $searchConfig )
	{
		$queryClauses = array();
		
		if ( $searchConfig->isInterWiki() ) {
			
			$widQueries = array();
			foreach ( $this->getInterWikiSearchExcludedWikis() as $excludedWikiId ) {
			    $widQueries[] = self::valueForField( 'wid',  $excludedWikiId, array( 'negate' => true ) );
			}
			 
			$queryClauses[] = implode( ' AND ', $widQueries );
			
			$queryClauses[] = self::valueForField( 'lang', $this->wg->ContLang->mCode );
			
			$queryClauses[] = self::valueForField( 'iscontent', 'true' );
			
			$hub = $searchConfig->getHub();
			if (! empty( $hub ) ) {
			    $queryClauses[] = self::valueForField( 'hub', $hub );
			}
		}
		else {
			if ( $searchConfig->getVideoSearch() ) {
				$searchConfig->setNamespaces( array( NS_FILE ) );
				$queryClauses[] = self::valueForField( 'is_video', 'true' );
				$queryWithVideo = sprintf('(%s OR %s)', self::valueForField( 'wid', $searchConfig->getCityId() ), self::valueForField( 'wid', self::VIDEO_WIKI_ID ) );
				array_unshift( $queryClauses, $queryWithVideo );
			} else {
				array_unshift( $queryClauses, self::valueForField( 'wid', $searchConfig->getCityId() ) );
			}
			
			$nsQuery = '';
			foreach ( $searchConfig->getNamespaces() as $namespace ) {
				$nsQuery .= ( !empty($nsQuery) ? ' OR ' : '' ) . self::valueForField( 'ns', $namespace );
			}
			$queryClauses[] = "({$nsQuery})";
		}
		
		if (! $searchConfig->getIncludeRedirects() ) {
			$queryClauses[] = self::valueForField( 'is_redirect', 'false' );
		}
		
		return sprintf( '(%s)', implode( ' AND ', $queryClauses ) );
	}
	
	/**
	 * Returns the string used to build out a boost query with Solarium
	 * @see    WikiaSearchTest::testGetBoostQueryString
	 * @param  WikiaSearchConfig $searchConfig
	 * @return string
	 */
	private function getBoostQueryString( WikiaSearchConfig $searchConfig )
	{
		$queryNoQuotes = $searchConfig->getQueryNoQuotes( true );
		
		if ( $searchConfig->isInterWiki() ) {
			$queryNoQuotes = preg_replace( '/ wiki\b/i', '', $queryNoQuotes );
		}

		$boostQueries = array(
				self::valueForField( 'html', $queryNoQuotes, array( 'boost'=>5, 'quote'=>'\"' ) ),
		        self::valueForField( 'title', $queryNoQuotes, array( 'boost'=>10, 'quote'=>'\"' ) ),
		);
		
		if ( $searchConfig->isInterWiki() ) {
			$boostQueries[] = self::valueForField( 'wikititle',	$queryNoQuotes,	array( 'boost' => 15, 'quote' => '\"' )		);
			$boostQueries[] = self::valueForField( 'host',		'answers', 		array( 'boost' => 10, 'negate' => true )	);
			$boostQueries[] = self::valueForField( 'host',		'respuestas',	array( 'boost' => 10, 'negate' => true )	);
		}
		
		return implode( ' ', $boostQueries );
	}
	
	/**
	 * Utilizes Solr's MoreLikeThis component to return similar pages
	 * @see    WikiaSearchTest::testMoreLikeThis
	 * @param  WikiaSearchConfig $searchConfig
	 * @return WikiaSearchResultSet
	 */
	private function moreLikeThis( WikiaSearchConfig $searchConfig )
	{
		$query		= $searchConfig->getQuery( WikiaSearchConfig::QUERY_RAW );
		$streamBody	= $searchConfig->getStreamBody();
		$streamUrl	= $searchConfig->getStreamUrl();
		
		if (! ( $query || $streamBody || $streamUrl ) ) {
			throw new Exception("A query, url, or stream is required.");
		}
	    
		$mlt = $this->client->createMoreLikeThis();
		$mlt->setMltFields		( implode( ',', $searchConfig->getMltFields() ) )
			->setFields			( $searchConfig->getRequestedFields() )
			->addParam			( 'mlt.match.include', 'false' )
			->setStart			( $searchConfig->getStart() )
			->setRows			( $searchConfig->getRows() )
			->setDocumentClass	( 'WikiaSearchResult' )
		;
		
		if ( $searchConfig->getInterestingTerms() == 'list' ) {
			$mlt->setInterestingTerms( 'list' );
		}

		if ( $searchConfig->getMltFilterQuery() ) {
			$mlt->addFilterQuery( array(
				'query'	=>	$searchConfig->getMltFilterQuery(),
				'key'	=>	'mltfilterquery'
			) );
		}
		if ( $query !== null ) { 
			$mlt->setQuery( $query );
		} else if ( $streamBody ) {
			$mlt->addParam( 'stream.body', $streamBody );
		} else if ($streamUrl ) {
			$mlt->addParam( 'stream.url', $streamUrl );
		}
	    
		try {
			$mltResult = $this->client->moreLikeThis( $mlt );
		} catch ( Exception $e ) {
			$mltResult = F::build('Solarium_Result_Select_Empty');
			Wikia::Log( __METHOD__, '', $e );
		}
		
		$results = F::build('WikiaSearchResultSet', array($mltResult, $searchConfig) );
		
		return $results;
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
	 * get list of wikis excluded from inter-wiki searching
	 * @param  int $currentWikiId
	 * @return array
	 */
	private function getInterWikiSearchExcludedWikis( $currentWikiId = 0 ) {
	    wfProfileIn(__METHOD__);
	
	    $cacheKey		= $this->wf->SharedMemcKey( 'crossWikiaSearchExcludedWikis' );
	    $privateWikis	= $this->wg->Memc->get( $cacheKey );

	    if(! is_array( $privateWikis ) ) {
	        // get private wikis from db
	        $wikiFactory		= F::build( 'WikiFactory' );
	        $wgIsPrivateWiki	= $wikiFactory->getVarByName( 'wgIsPrivateWiki', $currentWikiId );
	        $privateWikis		= $wikiFactory->getCityIDsFromVarValue( $wgIsPrivateWiki === null ? null : $wgIsPrivateWiki->cv_id , true, '=' );
	        $this->wg->Memc->set( $cacheKey, $privateWikis, 3600 ); // cache for 1 hour
	    }
	
	    wfProfileOut(__METHOD__);
	    return count( $privateWikis ) ? array_merge( $privateWikis, $this->wg->CrossWikiaSearchExcludedWikis ) : $this->wg->CrossWikiaSearchExcludedWikis;
	}

	/**
	 * Hooks
	 *------------------------------------------------------------------------*/
	
	/**
	 * Used to configure the user preference pane settings for search. 
	 * This is a registered hook function of the samme name.
	 * 
	 * @param User $user
	 * @param array $defaultPreferences
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

}