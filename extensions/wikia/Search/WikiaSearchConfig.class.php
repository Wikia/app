<?php 

/**
 * A config class intended to handle variable flags for search
 * Intended to be a dependency-injected receptacle for different search requirements
 * 
 * @author Robert Elwell
 *
 */

class WikiaSearchConfig extends WikiaObject implements ArrayAccess
{
	/**
	 * Default number of results per page. Usually overwritten. 
	 * @var int
	 */
	const RESULTS_PER_PAGE	=	10;
	
	/**
	 * Constant for retrieving query -- default behavior
	 * @var int
	 */
	const QUERY_DEFAULT		=	1;
	
	/**
	 * Constant for retrieving query -- retrieve query without escaping
	 * @var int
	 */
	const QUERY_RAW			=	2;
	
	/**
	 * Constant for retrieving query -- retrieve unescaped query with HTML entities encoded
	 * @var int
	 */
	const QUERY_ENCODED		=	3;
	
	/**
	 * Default parameters for a number of values that come up regularly in search
	 * @var array
	 */
	private $params = array(
			'page'			=>	1,
			'length'		=>	self::RESULTS_PER_PAGE,
			'cityId'		=>	0,
			'rank'			=>	'default',
			'start'			=>	0,
			'minimumMatch'	=> '66%',
			);
	
	/**
	 * The usual requested fields, stored here so we dont have to add them all to the default params array
	 * @var array
	 */
	private $requestedFields = array(
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

	/**
	 * This array allows us to associate sort arguments from the request with the appropriate sorting format
	 * @var array
	 */
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
	 * Constructor method
	 * @see   WikiaSearchConfigTest::testConstructor
	 * @param array $params
	 */
	public function __construct( array $params = array() ) {
		parent::__construct();
		$this->params = array_merge( $this->params, 
									 array( 'requestedFields' => $this->requestedFields ), 
									 $params );
	}

	/**
	 * Magic getters and setters used to make it ease array access.
	 * Setter provides fluent interface.
	 * @see    WikiaSearchConfigTest::testMagicMethods 
	 * @param  string $method
	 * @param  array  $params
	 * @throws  BadMethodCallException
	 * @return Ambigous <NULL, multitype:>|WikiaSearchConfig
	 */
	public function __call($method, $params) {
		if ( substr($method, 0, 3) == 'get' ) {
			return $this->offsetGet( strtolower($method[3]).substr($method, 4) );
		} else if ( substr($method, 0, 3) == 'set' ) {
			$this->offsetSet( strtolower($method[3]).substr($method, 4), $params[0] );
			return $this; // fluent
		}
		throw new BadMethodCallException( "Unknown method: {$method}" );
	}
	
	/**
	 * @see WikiaSearchConfigTest::testArrayAccessMethods
	 * @see ArrayAccess::offsetExists()
	 */
	public function offsetExists ($offset) {
		return isset($this->params[$offset]);
	}

	/**
	 * @see WikiaSearchConfigTest::testArrayAccessMethods
	 * @see ArrayAccess::offsetGet()
	 */
	public function offsetGet ($offset) {
		return isset($this->params[$offset]) ? $this->params[$offset] : null;
	}

	/**
	 * @see WikiaSearchConfigTest::testArrayAccessMethods
	 * @see ArrayAccess::offsetSet()
	 */
	public function offsetSet ($offset, $value) {
		$this->params[$offset] = $value;
	}

	/**
	 * @see WikiaSearchConfigTest::testArrayAccessMethods
	 * @see ArrayAccess::offsetUnset()
	 */
	public function offsetUnset ($offset) {
		unset($this->params[$offset]);
	}
	
	/**
	 * Synonym function for backwards compatibility
	 * @see    WikiaSearchConfigTest::testGetSize
	 * @return integer
	 */
	public function getSize() {
		return $this->getLength();
	}
	
	/**
	 * Provides the appropriate search result length based on whether we have an article match or not
	 * @see    WikiaSearchConfigTest::testGetSize
	 * @return integer
	 */
	public function getLength() {
		return ( $this->getArticleMatch() !== null && $this->getStart() === 0 ) 
			? ( (int) $this->params['length'] ) - 1 
			: $this->params['length'];
	}
	
	/**
	 * Used to store the query from the request as passed by the controller.
	 * We remove any namespaces prefixes, but store the original query under the originalQuery param.
	 * @see    WikiaSearchConfigTest::testQueryAndNamespaceMethods
	 * @param  string $query
	 * @return WikiaSearchConfig provides fluent interface
	 */
	public function setQuery( $query ) {
		
		$query = html_entity_decode( Sanitizer::StripAllTags ( $query ), ENT_COMPAT, 'UTF-8');
		
		$this->params['originalQuery'] = $query;
		$queryNamespace	= $this->wg->ContLang->getNsIndex( preg_replace( '/^(.*):.*$/', '$1', strtolower( $query ) ) );
		if ( $queryNamespace ) {
			$namespaces = $this->getNamespaces();
		    if ( empty( $namespaces ) || (! in_array( $queryNamespace, $namespaces ) ) ) {
		        $this->params['queryNamespace'] = $queryNamespace;
		    } 
		    $query = implode( ':', array_slice( explode( ':', $query ), 1 ) );
		}
		
		$this->params['query'] = $query;
		
		return $this;
	}
	
	/**
	 * Most of the time, we want the query escaped for XSS and Lucene syntax well-formedness
	 * @see    WikiaSearchConfigTest::testQueryAndNamespaceMethods
	 * @param  int $strategy one of the self::QUERY_ constants
	 * @return string
	 */
	public function getQuery( $strategy = self::QUERY_DEFAULT ) {
		if (! isset( $this->params['query'] ) ) {
			return false;
		}
		
		$query = $strategy !== self::QUERY_DEFAULT	? $this->params['query'] : WikiaSearch::sanitizeQuery( $this->params['query'] );
		$query = $strategy === self::QUERY_ENCODED	? htmlentities( $query, ENT_COMPAT, 'UTF-8' ) : $query;
		
		if ( $this->isInterWiki() ) {
			$query = preg_replace( '/ wiki\b/i', '', $query);
		}
		
		return $query;
	}
	
	/**
	 * Strips out quotes, and optionally
	 * @see    WikiaSearchConfigTest::testQueryAndNamespaceMethods 
	 * @param  boolean $raw
	 * @return string
	 */
	public function getQueryNoQuotes( $raw = false ) {
		$query = preg_replace( "/['\"]/", '', preg_replace( "/(\\w)['\"](\\w)/", '$1 $2',  $this->getQuery( self::QUERY_RAW ) ) );
		return $raw ? $query : WikiaSearch::sanitizeQuery( $query );
	}
	
	/**
	 * Returns the namespaces that were set if they have been set, otherwise returns default namespaces.
	 * If a query with a namespace prefix has been set, we also include this value in the namespace array.
	 * @see    WikiaSearchConfigTest::testQueryAndNamespaceMethods
	 * @return array
	 */
	public function getNamespaces()	{
		$searchEngine = F::build( 'SearchEngine' );
		$namespaces = ( isset($this->params['namespaces']) && !empty($this->params['namespaces']) ) 
					? $this->params['namespaces'] 
					: $searchEngine->defaultNamespaces();
		if (! is_array( $namespaces ) ) { 
			$namespaces = array();
		}
		$queryNamespaceArray = ( isset( $this->params['queryNamespace'] ) ) ? array( $this->params['queryNamespace'] ) : array(); 
		$this->params['namespaces'] = array_unique( array_merge( $namespaces, $queryNamespaceArray ) );
		
		return $this->params['namespaces'];
	}
	
	/**
	 * Provides the appropriate values for Solarium sorting based on our sort names
	 * @see    WikiaSearchConfigTest::testGetSort
	 * @return array where index 0 is the field name and index 1 is the constant used for ASC or DESC in solarium
	 */
	public function getSort() {
		$rank = $this->getRank();
		return isset($this->rankOptions[$rank]) ? $this->rankOptions[$rank] : $this->rankOptions['default']; 
	}
	
	/**
	 * Determines whether an article match has been set
	 * @see    WikiaSearchConfigTest::testArticleMatching
	 * @return boolean
	 */
	public function hasArticleMatch() {
		return isset($this->params['articleMatch']) && !empty($this->params['articleMatch']);
	}
	
	/**
	 * Overloading __set to type hint
	 * @see    WikiaSearchConfigTest::testArticleMatching
	 * @param  WikiaSearchArticleMatch $articleMatch
	 * @return WikiaSearchConfig provides fluent interface
	 */
	public function setArticleMatch( WikiaSearchArticleMatch $articleMatch ) {
		$this->params['articleMatch'] = $articleMatch;
		return $this;
	}
	
	/**
	 * For IDE type-hinting
	 * @see    WikiaSearchConfigTest::testArticleMatching
	 * @return WikiaSearchArticleMatch
	 */
	public function getArticleMatch() {
		return isset( $this['articleMatch'] ) ? $this['articleMatch'] : null;
	}
	
	/**
	 * Returns desired number of results WITHOUT consideration for article match
	 * @see    WikiaSearchConfigTest::testGetSize
	 * @return int
	 */
	public function getLimit()
	{
		return $this->params['length'];
	}
	
	/**
	 * Sets length value, so we don't get confused
	 * @see    WikiaSearchConfigTest::testGetSize
	 * @param  int $val
	 * @return WikiaSearchConfig provides fluent interface
	 */
	public function setLimit( $val )
	{
		$this->params['length'] = $val;
		return $this;
	}
	
	/**
	 * Provides the requested fields with respect to dynamic language fields
	 * @return array
	 */
	public function getRequestedFields()
	{
		$fieldsPrepped = array();
		foreach ($this['requestedFields'] as $field) {
			$fieldsPrepped[] = WikiaSearch::field($field);
		}
		
		return $fieldsPrepped;
	}
	
	/**
	 * Synonym function for backwards compatibility
	 * @see    WikiaSearchConfigTest::testInterWiki
	 * @return boolean
	 */
	public function isInterWiki() {
		return $this->getInterWiki();
	}
	
	/**
	 * Synonym function for backwards compatibility
	 * @see    WikiaSearchConfigTest::testInterWiki
	 * @return boolean
	 */
	public function getIsInterWiki() {
	    return $this->getInterWiki();
	}
	
	/**
	 * Synonym function for backward compatbility
	 * @see    WikiaSearchConfigTest::testInterWiki
	 * @param  boolean $value
	 * @return WikiaSearchConfig provides fluent interface
	 */
	public function setIsInterWiki( $value ) {
		$this->params['interWiki'] = $value;
		return $this; 
	}
	
	/**
	 * Returns results number based on a truncated heuristic
	 * @see    WikiaSearchConfigTest::testTruncatedResultsNum
	 * @return integer
	 */
	public function getTruncatedResultsNum() 
	{
		$resultsNum = $this->getResultsFound();
		
	    $result = $resultsNum;
	
	    $digits = strlen( $resultsNum );
	    if( $digits > 1 ) {
	        $zeros = ( $digits > 3 ) ? ( $digits - 1 ) : $digits;
	        $result = round( $resultsNum, ( 0 - ( $zeros - 1 ) ) );
	    }
	
	    return $result;
	}
	
	/**
	 * These search profiles are used to figure out what tab we're on and how we should be searching based on that
	 * While kind of a view concern, moved here so it can play nicely with the namespaces value
	 * @return array
	 */
	public function getSearchProfiles() {
	    // Builds list of Search Types (profiles)
	    $searchEngine = F::build( 'SearchEngine' );
	    $nsAllSet = array_keys( $searchEngine->searchableNamespaces() );
	    $defaultNamespaces = $searchEngine->defaultNamespaces();

	    $profiles = array(
	            SEARCH_PROFILE_DEFAULT => array(
	                    'message' => 'wikiasearch2-tabs-articles',
	                    'tooltip' => 'searchprofile-articles-tooltip',
	                    'namespaces' => $defaultNamespaces,
	                    'namespace-messages' => $searchEngine->namespacesAsText( $defaultNamespaces ),
	            ),
	            SEARCH_PROFILE_IMAGES => array(
	                    'message' => 'wikiasearch2-tabs-photos-and-videos',
	                    'tooltip' => 'searchprofile-images-tooltip',
	                    'namespaces' => array( NS_FILE ),
	            ),
	            SEARCH_PROFILE_USERS => array(
	                    'message' => 'wikiasearch2-users',
	                    'tooltip' => 'wikiasearch2-users-tooltip',
	                    'namespaces' => array( NS_USER )
	            ),
	            SEARCH_PROFILE_ALL => array(
	                    'message' => 'searchprofile-everything',
	                    'tooltip' => 'searchprofile-everything-tooltip',
	                    'namespaces' => $nsAllSet,
	            ),
	            SEARCH_PROFILE_ADVANCED => array(
	                    'message' => 'searchprofile-advanced',
	                    'tooltip' => 'searchprofile-advanced-tooltip',
	                    'namespaces' => $this->getNamespaces(),
	                    'parameters' => array( 'advanced' => 1 ),
	            )
	    );
	    
	    $this->wf->RunHooks( 'SpecialSearchProfiles', array( &$profiles ) );
	
	    foreach( $profiles as $key => &$data ) {
	        sort( $data['namespaces'] );
	    }
	
	    return $profiles;
	}

	/**
	 * Uses search profiles to determine the active tab in the view
	 * @return string
	 */
	public function getActiveTab() {
		
		if( $this->getAdvanced() ) {
		    return SEARCH_PROFILE_ADVANCED;
		}
		$searchEngine = F::build( 'SearchEngine' ); 
		$searchableNamespaces = array_keys( $searchEngine->searchableNamespaces() );
		
		// $nsVals should always have a value at this point
		$nsVals = $this->getNamespaces();
		
		// we will always return at least SEARCH_PROFILE_ADVANCED, because it is identical to the return value of getNamespaces
		$searchProfile = SEARCH_PROFILE_ADVANCED;
		foreach( $this->getSearchProfiles() as $name => $profile ) {
		    if (   ( count( array_diff( $nsVals, $profile['namespaces'] ) ) == 0 ) 
		    	&& ( count( array_diff($profile['namespaces'], $nsVals ) ) == 0 ) ) {
	        	$searchProfile = $name !== SEARCH_PROFILE_ADVANCED ? $name : $searchProfile;
		    }
		}
		return $searchProfile;
	}
	
	/**
	 * Determines the number of pages based on the desired number of results per page
	 * @see    WikiaSearchConfigTest::testGetNumPages
	 * @return integer 
	 */
	public function getNumPages() {
		return $this->getResultsFound() ? ceil( $this->getResultsFound() / $this->getLimit() ) : 0;
	}

	/**
	 * If the cityId hasn't been set, and we're not interwiki, we use $wgCityId. 
	 * Otherwise, return the set value.
	 * @see    WikiaSearchConfigTest::testGetCityId
	 * @return int
	 */
	public function getCityId() {
		if ( ( $this->params['cityId'] == 0 ) && (! $this->isInterWiki() ) ) {
			
			$cityId = (! empty( $this->wg->SearchWikiId ) ) ? $this->wg->SearchWikiId : $this->wg->CityId; 
			
			return $this->setCityId( $cityId )->getCityId();
		}
		return $this->params['cityId'];
	}
	
	/**
	 * Normalizes the cityId value in case of mistyping
	 * @see   WikiaSearchConfigTest::testGetCityId
	 * @param int $value
	 */
	public function setCityID( $value ) {
		return $this->__call( 'setCityId', array( $value ) );
	}
}