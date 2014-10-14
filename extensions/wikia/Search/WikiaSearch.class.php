<?php
/**
 * Class definition for WikiaSearch
 */
use Wikia\Search\MediaWikiInterface;
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
	 * Sets max collation tries when spellchecking
	 * @var int
	 */
	const SPELLING_MAX_COLLATION_TRIES		= 20;
	
	/**
	 * Sets max collations when spellchecking
	 * @var int
	 */
	const SPELLING_MAX_COLLATIONS			= 5;
	
	/**
	 * Sets the max number of results to return when spellchecking
	 * @var int
	 */
	const SPELLING_RESULT_COUNT				= 20;
	
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
	private static $dynamicUnstoredFields = array();
	
	/**
	 * Used for dynamically composing multivalued language fields
	 * @see WikiaSearch::field
	 * @staticvar array
	 */
	public static $multiValuedFields = array('categories', 'redirect_titles', 'headings');

	/**
	 * Search client
	 * @var Solarium_Client
	 */
	protected $client;
	
	/**
	 * Allows us to put all MW logic in a separate class.
	 * @var MediaWikiInterface
	 */
	protected $interface;
	
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
		$this->interface = MediaWikiInterface::getInstance();
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

		$this->preSearch( $searchConfig );
		$result = $this->search( $searchConfig );
		$this->postSearch( $searchConfig, $result );

		wfProfileOut(__METHOD__);
		return $searchConfig->getResults();
	}
	
	/**
	 * Searches using strict lucene query syntax -- no dismax here. 
	 * What you set in the query value of the searchconfig is what we search for.
	 * Please note the risk of not getting results 
	 * @param  WikiaSearchConfig $searchConfig
	 * @return WikiaSearchResultSet
	 */
	public function searchByLuceneQuery( WikiaSearchConfig $searchConfig ) {
		$this->wf->ProfileIn( __METHOD__ );
		
		$query = $this->client->createSelect();
		$query->setDocumentClass( 'WikiaSearchResult' );
		
		$sort = $searchConfig->getSort();
		
		$query	->addFields		( $searchConfig->getRequestedFields() )
				->removeField	('*')
			  	->setStart		( $searchConfig->getStart() )
				->setRows		( $searchConfig->getLength() )
				->addSort		( $sort[0], $sort[1] )
				->addParam		( 'timeAllowed', 5000 )
				->setQuery		( $searchConfig->getQuery( WikiaSearchConfig::QUERY_RAW ) )
		;
		
		try {
			
			$result = $this->client->select( $query );
			
		} catch ( Exception $e ) {
			F::build('Wikia')->log(__METHOD__, 'Querying Solr First Time', $e);
			$searchConfig->setError( $e );
			$result = F::build('Solarium_Result_Select_Empty');
		}
		
		$results = F::build('WikiaSearchResultSet', array($result, $searchConfig) );
		
		$searchConfig->setResults		( $results )
					 ->setResultsFound	( $results->getResultsFound() )
		;
		
		$this->wf->ProfileOut( __METHOD__ );
		
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
		$filterQuery = sprintf( '%s AND %s AND %s', 
	    							self::valueForField( 'wid', $searchConfig->getCityId() ), 
	    							self::valueForField( 'is_video', 'true' ),
	    							self::valueForField( 'ns',			NS_FILE ) 
	    							);
	
	    $query = self::valueForField( 'wid', $searchConfig->getCityId() );
	    if ( $searchConfig->getPageId() != false ) {
	        $query .= sprintf(' AND %s', self::valueForField( 'pageid', $searchConfig->getPageId() ) );
	    } else {
	        // tweakable heuristic:
	        // the document frequency for the interesting terms needs to be at least 50% of the wiki's pages

	    	$params = array('action'	=> 'query',
			                'prop'		=> 'info|categories',
			                'inprop'	=> 'url|created|views|revcount',
			                'meta'		=> 'siteinfo',
			                'siprop'	=> 'statistics|wikidesc|variables|namespaces|category'
                			);
	    	// I think it's lame I have to do this to get unit tests to work. Just sayin'.
			$data = F::build( 'ApiService' )->call( $params );
	
			if ( isset( $data['query'] ) && isset( $data['query']['statistics'] ) && isset( $data['query']['statistics']['articles'] ) ) {
				$searchConfig->setMindf( (int) ($data['query']['statistics']['articles'] * .5) );
	    	}
			$query .= ' AND ' . self::valueForField( 'iscontent', 'true' );
		}

		$searchConfig
			->setQuery			( $query )
			->setFilterQuery	( $filterQuery )
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
	 * Strategy for getting the right kind of match
	 * @param  WikiaSearchConfig $config
	 * @return WikiaSearchArticleMatch|WikiSearchWikiMatch|null
	 */
	public function getMatch( WikiaSearchConfig $config ) {
		return $config->isInterWiki() ? $this->getWikiMatch( $config ) : $this->getArticleMatch( $config );
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
			wfProfileOut(__METHOD__);
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
	
	public function getWikiMatch( WikiaSearchConfig $config ) {
		wfProfileIn(__METHOD__);
		
		if ( $config->hasWikiMatch() ) {
			wfProfileOut(__METHOD__);
			return $config->getWikiMatch();
		}
		
		$domain = preg_replace(
				'/[^a-zA-Z]/',
				'',
				strtolower( $config->getQuery( WikiaSearchConfig::QUERY_RAW ) ) 
				);
		$dbr = $this->wf->GetDB( DB_SLAVE, array(), $this->wg->ExternalSharedDB );
		$query = $dbr->select(
				array( 'city_domains' ),
				array( 'city_id' ),
				array( 'city_domain' => "{$domain}.wikia.com" )
				);
		if ( $row = $dbr->fetchObject( $query ) ) {
			$config->setWikiMatch( new WikiaSearchWikiMatch( $row->city_id ) );
			wfProfileOut(__METHOD__);
			return $config->getWikiMatch();
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
		$lang 		= isset( $params['lang']   ) && $params['lang']   !== false ? $params['lang'] : null;
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
	 * Protected functions -- used mostly for query preparation and configuration
	 *------------------------------------------------------------------------*/
	
	/**
	 * Creates an instance of Solarium_Query_Select configured by searchconfig.
	 * @see    WikiaSearchTest::testGetQuery
	 * @param  Solarium_Query_Select $query
	 * @param  WikiaSearchConfig $searchConfig
	 * @return Solarium_Query_Select
	 */
	protected function getSelectQuery( WikiaSearchConfig $searchConfig )
	{
		wfProfileIn(__METHOD__);
		$query = $this->client->createSelect();
		$query->setDocumentClass( 'WikiaSearchResult' );
		
		$this->registerQueryParams   ( $query, $searchConfig )
		     ->registerHighlighting  ( $query, $searchConfig )
		     ->registerFilterQueries ( $query, $searchConfig )
		     ->registerGrouping      ( $query, $searchConfig )
		     ->registerSpellcheck    ( $query, $searchConfig )
		;
		
		$formulatedQuery = sprintf('%s AND (%s)', $this->getQueryClausesString( $searchConfig ), $this->getNestedQuery( $searchConfig ));
		$query->setQuery( $formulatedQuery );
		
		wfProfileOut(__METHOD__);
		return $query;
	}
	
	/**
	 * Registers meta-parameters for the query
	 * @param Solarium_Query_Select $query
	 * @param WikiaSearchConfig $searchConfig
	 * @return WikiaSearch
	 */
	protected function registerQueryParams( Solarium_Query_Select $query, WikiaSearchConfig $searchConfig ) {
		$sort = $searchConfig->getSort();
		$query->addFields      ( $searchConfig->getRequestedFields() )
		      ->removeField    ('*')
		      ->setStart       ( $searchConfig->getStart() )
		      ->setRows        ( $searchConfig->getLength() )
		      ->addSort        ( $sort[0], $sort[1] )
		      ->addParam       ( 'timeAllowed', $searchConfig->isInterWiki() ? 7500 : 5000 )
		;
		return $this;
	}
	
	/**
	 * Sets grouping params given a configuration
	 * @param Solarium_Query_Select $query
	 * @param WikiaSearchConfig $searchConfig
	 * @return WikiaSearch
	 */
	protected function registerGrouping( Solarium_Query_Select $query, WikiaSearchConfig $searchConfig ) {
	    if ( $searchConfig->isInterWiki() ) {
			$grouping = $query->getGrouping();
			$grouping	->setLimit			( self::GROUP_RESULTS_GROUPING_ROW_LIMIT )
						->setOffset			( $searchConfig->getStart() )
						->setFields			( array( self::GROUP_RESULTS_GROUPING_FIELD ) )
			;
		}
		return $this;
	}
	
	/**
	 * Configures filter queries to, for instance, prevent duplicate results from PTT, or enable better caching.
	 * @param Solarium_Query_Select $query
	 * @param WikiaSearchConfig $searchConfig
	 * @return WikiaSearch
	 */
	protected function registerFilterQueries( Solarium_Query_Select $query, WikiaSearchConfig $searchConfig ) {
		
		$searchConfig->setFilterQuery( $this->getFilterQueryString( $searchConfig ) );
		
		if ( $searchConfig->hasArticleMatch() ) {
			$am       = $searchConfig->getArticleMatch();
			$article  = $am->getArticle();  
			$noPtt    = self::valueForField( 'id', sprintf( '%s_%s', $searchConfig->getCityId(), $article->getID() ), array( 'negate' => true ) ) ;
			$searchConfig->setFilterQuery( $noPtt, 'ptt' );
		} else if ( $searchConfig->hasWikiMatch() ) {
			$noPtt    = self::valueForField( 'wid', $searchConfig->getWikiMatch()->getId(), array( 'negate' => true ) );
			$searchConfig->setFilterQuery( $noPtt, 'wikiptt' );
		}
		
		$query->addFilterQueries( $searchConfig->getFilterQueries() );
		
		return $this;
	}
	
	/**
	 * Configures result snippet highlighting
	 * @param Solarium_Query_Select $query
	 * @param WikiaSearchConfig $searchConfig -- not used now, but we will likely want config to control some values
	 * @return WikiaSearch
	 */
	protected function registerHighlighting( Solarium_Query_Select $query, WikiaSearchConfig $searchConfig ) {
		$highlighting = $query->getHighlighting();
		$highlighting->addField                     ( self::field( 'html' ) )
		             ->setSnippets                  ( 1 )
		             ->setRequireFieldMatch         ( true )
		             ->setFragSize                  ( self::HL_FRAG_SIZE )
		             ->setSimplePrefix              ( self::HL_MATCH_PREFIX )
		             ->setSimplePostfix             ( self::HL_MATCH_POSTFIX )
		             ->setAlternateField            ( 'nolang_txt' )
		             ->setMaxAlternateFieldLength   ( 100 )
		;
		return $this;
	}
	
	/**
	 * Configures spellcheck per our desired settings
	 * @param Solarium_Query_Select $query
	 * @param WikiaSearchConfig $searchConfig
	 * @return WikiaSearch
	 */
	protected function registerSpellcheck( Solarium_Query_Select $query, WikiaSearchConfig $searchConfig ) {
		if ( $this->wg->WikiaSearchSpellcheckActivated ) {
			$query	->getSpellcheck()
					->setQuery( $searchConfig->getQueryNoQuotes( true ) )
					->setCollate( true )
					->setCount( self::SPELLING_RESULT_COUNT )
					->setMaxCollationTries( self::SPELLING_MAX_COLLATION_TRIES )
					->setMaxCollations( self::SPELLING_MAX_COLLATIONS )
					->setExtendedResults( true )
					->setCollateParam( 'fq', 'is_content:true AND wid:'.$searchConfig->getCityId() )
					->setOnlyMorePopular( true )
					->setDictionary( in_array( $this->wg->LanguageCode, $this->wg->WikiaSearchSupportedLanguages ) ? $this->wg->LanguageCode : 'default'   )
					->setCollateExtendedResults( true )
			;
		}
		return $this;
	}
	
	/**
	 * Responsible for the initial query to Solr, with some error handling built in
	 * @param WikiaSearchConfig $searchConfig
	 * @return Solarium_Result_Select
	 */
	protected function search( WikiaSearchConfig $searchConfig ) {
		try {
			return $this->client->select( $this->getSelectQuery( $searchConfig ) );
		} catch ( Exception $e ) {
			if ( $searchConfig->getError() !== null ) {
				$searchConfig->setError( $e );
				F::build('Wikia')->log(__METHOD__, 'Querying Solr With No Boost Functions', $e);
				return F::build('Solarium_Result_Select_Empty');
			} else {
				F::build('Wikia')->log(__METHOD__, 'Querying Solr First Time', $e);
				
				$searchConfig	->setSkipBoostFunctions( true )
								->setError( $e );

				return $this->search( $searchConfig );
			}
		}
	}
	
	/**
	 * Handles initial configuration when invoking doSearch
	 * @param WikiaSearchConfig $searchConfig
	 */
	protected function preSearch( WikiaSearchConfig $searchConfig ) {
		if($searchConfig->getGroupResults() == true) {

			$searchConfig	->setLength		( self::GROUP_RESULTS_GROUPINGS_LIMIT )
							->setIsInterWiki( true )
			;

		}

		if ( $searchConfig->getPage() > 1 ) {
			$searchConfig	->setStart		( ( $searchConfig->getPage() - 1 ) * $searchConfig->getLength() );
		}
	}
	
	/**
	 * Handles tracking and preparation of search result set
	 * Also handles going back through to perform a spelling-corrected search
	 * @param WikiaSearchConfig $searchConfig
	 * @param Solarium_Result $result
	 */
	protected function postSearch( WikiaSearchConfig $searchConfig, Solarium_Result_Select $result ) {
		
		if ( $this->wg->WikiaSearchSpellcheckActivated 
				&& $result->getNumFound() == 0
				&& !$searchConfig->hasArticleMatch() ) {
			if ( $collation = $result->getSpellcheck()->getCollation() ) {
				$searchConfig->setQuery( $collation->getQuery() );
				$result = $this->search( $searchConfig );
			}
		}
		
		$results = F::build('WikiaSearchResultSet', array($result, $searchConfig) );

		$resultCount = $results->getResultsFound();
		
		$searchConfig->setResults		( $results )
					 ->setResultsFound	( $resultCount )
		;
		if( $searchConfig->getPage() == 1 ) {
			F::build( 'Track' )->event( ( !empty( $resultCount ) ? 'search_start' : 'search_start_nomatch' ), 
										array(	'sterm'	=> $searchConfig->getQuery(), 
												'rver'	=> self::RELEVANCY_FUNCTION_ID,
												'stype'	=> ( $searchConfig->getIsInterWiki() ? 'inter' : 'intra' ) 
											 ) 
						);
		}
	}
	
	/**
	 * Creates a nested query using dismax.
	 * @see    WikiaSearchTest::testGetNestedQuery
	 * @param  WikiaSearchConfig $searchConfig
	 * @return Solarium_Query_Select
	 */
	protected function getNestedQuery( WikiaSearchConfig $searchConfig ) {
		wfProfileIn( __METHOD__ );
		$nestedQuery = $this->client->createSelect();
		$nestedQuery->setQuery( $searchConfig->getQuery() );
		
		$dismax = $nestedQuery->getDismax();
		
		$boostQueryString = $this->getBoostQueryString( $searchConfig );
		
		$queryFieldsString = $this->getQueryFieldsString( $searchConfig );
		
		$dismax	->setQueryFields		( $queryFieldsString )
				->setQueryParser		( 'edismax' )
		;
		
		if (! empty( $this->wg->ExternalSharedDB ) ) {
			$dismax
				->setPhraseFields		( $queryFieldsString )
				->setBoostQuery			( $this->getBoostQueryString( $searchConfig ) )
				->setMinimumMatch		( $searchConfig->getMinimumMatch() )
				->setPhraseSlop			( 3 )
				->setTie				( 0.01 )
			;
			if (! $searchConfig->getSkipBoostFunctions() || $this->interface->getGlobal( 'wgSearchSkipBoostFunctions' ) ) {
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
	protected function getQueryFieldsString( WikiaSearchConfig $searchConfig ) {
		if ( $searchConfig->getVideoSearch() && $this->wg->LanguageCode !== 'en' ) {
			// video wiki requires english field search
			$searchConfig->addQueryFields( array(
					self::field( 'title', 'en' )           => 5, 
					self::field( 'html', 'en' )            => 1.5, 
					self::field( 'redirect_titles', 'en' ) => 4
					));
		}
		if ( $searchConfig->isInterWiki() ) {
			$searchConfig->setQueryField( 'wikititle', 7 );
		}
		$queryFieldsString = '';
		foreach ( $searchConfig->getQueryFieldsToBoosts()  as $field => $boost ) {
			$queryFieldsString .= sprintf( '%s^%s ', self::field( $field ), $boost );
		}
		return trim( $queryFieldsString );
	}
	
	/**
	 * Builds the string used with filter queries based on search config
	 * @see WikiaSearchTest::testGetFilterQueryString
	 * @param WikiaSearchConfig $searchConfig
	 * @return string
	 */
	protected function getFilterQueryString( WikiaSearchConfig $searchConfig )
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
			$filterQueries[] = self::valueForField( 'wid', $searchConfig->getCityId() );
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
	protected function getQueryClausesString( WikiaSearchConfig $searchConfig )
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
		
		return sprintf( '(%s)', implode( ' AND ', $queryClauses ) );
	}
	
	/**
	 * Returns the string used to build out a boost query with Solarium
	 * @see    WikiaSearchTest::testGetBoostQueryString
	 * @param  WikiaSearchConfig $searchConfig
	 * @return string
	 */
	protected function getBoostQueryString( WikiaSearchConfig $searchConfig )
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
	protected function moreLikeThis( WikiaSearchConfig $searchConfig )
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
		
		if ( $searchConfig->getMindf() !== false ) {
			$mlt->setMinimumDocumentFrequency( $searchConfig->getMindf() );
		}

		if ( $searchConfig->hasFilterQueries() ) {
			$mlt->addFilterQueries( $searchConfig->getFilterQueries() );
		}
		
		if (! empty( $query ) ) { 
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
			F::build( 'Wikia' )->log( __METHOD__, '', $e );
		}
		
		$results = F::build('WikiaSearchResultSet', array($mltResult, $searchConfig) );
		
		return $results;
	}

	/**
	 * get list of wikis excluded from inter-wiki searching
	 * @param  int $currentWikiId
	 * @return array
	 */
	protected function getInterWikiSearchExcludedWikis( $currentWikiId = 0 ) {
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