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
	
	public function __construct( array $params = array() ) {
		$this->params = array_merge( $this->params, 
									 array( 'requestedFields' => $this->requestedFields ), 
									 $params );
	}

	/**
	 * Magic getters and setters used to make it ease array access.
	 * Setter provides fluent interface. 
	 * @param string $method
	 * @param array  $params
	 * @return Ambigous <NULL, multitype:>|WikiaSearchConfig
	 */
	public function __call($method, $params) {
		if ( substr($method, 0, 3) == 'get' ) {
			return $this->offsetGet( strtolower($method[3]).substr($method, 4) );
		} else if ( substr($method, 0, 3) == 'set' ) {
			$this->offsetSet( strtolower($method[3]).substr($method, 4), $params[0] );
			return $this; // fluent
		}
	}
	
	/**
	 * @see ArrayAccess::offsetExists()
	 */
	public function offsetExists ($offset) {
		return isset($this->params[$offset]);
	}

	/**
	 * @see ArrayAccess::offsetGet()
	 */
	public function offsetGet ($offset) {
		return isset($this->params[$offset]) ? $this->params[$offset] : null;
	}

	/**
	 * @see ArrayAccess::offsetSet()
	 */
	public function offsetSet ($offset, $value) {
		$this->params[$offset] = $value;
	}

	/**
	 * @see ArrayAccess::offsetUnset()
	 */
	public function offsetUnset ($offset) {
		unset($this->params[$offset]);
	}
	
	/**
	 * Synonym function for backwards compatibility
	 * @return integer
	 */
	public function getSize() {
		return $this->getLength();
	}
	
	/**
	 * Provides the appropriate search result length based on whether we have an article match or not
	 * @return integer
	 */
	public function getLength()
	{
		return ( $this->getArticleMatch() !== null && $this->getStart() === 0 ) 
			? ( (int) $this->params['length'] ) - 1 
			: $this->params['length'];
	}
	
	/**
	 * Used to store the query from the request as passed by the controller.
	 * We remove any namespaces prefixes, but store the original query under the originalQuery param.
	 * @param string $query
	 * @return WikiaSearchConfig provides fluent interface
	 */
	public function setQuery( $query )
	{
		$this->params['originalQuery'] = $query;
		
		$queryNamespace = MWNamespace::getCanonicalIndex( array_shift( explode( ':', strtolower( $query ) ) ) );
		if ( $queryNamespace ) {
		    if (!in_array($queryNamespace, $this->params['namespaces'])) {
		        $this->params['queryNamespace'] = $queryNamespace;
		    } 
		    $query = implode(':', array_slice(explode(':', $query), 1));
		}
		
		$this->params['query'] = $query;
		
		return $this;
	}
	
	/**
	 * Returns the namespaces that were set if they have been set, otherwise returns default namespaces.
	 * If a query with a namespace prefix has been set, we also include this value in the namespace array.
	 * @return array
	 */
	public function getNamespaces()
	{
		$namespaces = ( isset($this->params['namespaces']) && !empty($this->params['namespaces']) ) 
					? $this->params['namespaces'] 
					: SearchEngine::DefaultNamespaces();
		
		$queryNamespaceArray = (isset($this->params['queryNamespace'])) ? array($this->params['queryNamespace']) : array(); 
		$this->params['namespaces'] = array_merge($namespaces, $queryNamespaceArray);
		return $this->params['namespaces'];
	}
	
	/**
	 * Provides the appropriate values for Solarium sorting based on our sort names
	 * @return array where index 0 is the field name and index 1 is the constant used for ASC or DESC in solarium
	 */
	public function getSort()
	{
		$rank = $this->getRank();
		return isset($this->rankOptions[$rank]) ? $this->rankOptions[$rank] : $this->rankOptions['default']; 
	}
	
	/**
	 * Determines whether an article match has been set
	 * @return boolean
	 */
	public function hasArticleMatch()
	{
		return isset($this->params['articleMatch']) && !empty($this->params['articleMatch']);
	}
	
	/**
	 * Returns desired number of results WITHOUT consideration for article match
	 * @return int
	 */
	public function getLimit()
	{
		return $this->params['length'];
	}
	
	/**
	 * Sets length value, so we don't get confused
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
		foreach ($this->requestedFields as $field) {
			$fieldsPrepped[] = WikiaSearch::field($field);
		}
		
		return $fieldsPrepped;
	}
	
	/**
	 * Synonym function for backwards compatibility
	 * @return boolean
	 */
	public function isInterWiki() {
		return $this->getInterWiki();
	}
	
	/**
	 * Synonym function for backward compatbility
	 * @param  boolean $value
	 * @return WikiaSearchConfig provides fluent interface
	 */
	public function setIsInterWiki( $value ) {
		$this->params['interWiki'] = $value;
		return $this; 
	}
	
	/**
	 * Returns results number based on a truncated heuristic
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
	    $nsAllSet = array_keys( SearchEngine::searchableNamespaces() );
	    $profiles = array(
	            'default' => array(
	                    'message' => 'wikiasearch2-tabs-articles',
	                    'tooltip' => 'searchprofile-articles-tooltip',
	                    'namespaces' => SearchEngine::defaultNamespaces(),
	                    'namespace-messages' => SearchEngine::namespacesAsText(
	                            SearchEngine::defaultNamespaces()
	                    ),
	            ),
	            'images' => array(
	                    'message' => 'wikiasearch2-tabs-photos-and-videos',
	                    'tooltip' => 'searchprofile-images-tooltip',
	                    'namespaces' => array( NS_FILE ),
	            ),
	            'users' => array(
	                    'message' => 'wikiasearch2-users',
	                    'tooltip' => 'wikiasearch2-users-tooltip',
	                    'namespaces' => array( NS_USER )
	            ),
	            'all' => array(
	                    'message' => 'searchprofile-everything',
	                    'tooltip' => 'searchprofile-everything-tooltip',
	                    'namespaces' => $nsAllSet,
	            ),
	            'advanced' => array(
	                    'message' => 'searchprofile-advanced',
	                    'tooltip' => 'searchprofile-advanced-tooltip',
	                    'namespaces' => $this->getNamespaces(),
	                    'parameters' => array( 'advanced' => 1 ),
	            )
	    );
	
	    wfRunHooks( 'SpecialSearchProfiles', array( &$profiles ) );
	
	    foreach( $profiles as $key => &$data ) {
	        sort($data['namespaces']);
	    }
	
	    return $profiles;
	}

	/**
	 * Uses search profiles to determine the active tab in the view
	 * @return string
	 */
	public function getActiveTab() {
		
		if( $this->getAdvanced() ) {
		    return 'advanced';
		}
		
		$searchableNamespaces = array_keys( SearchEngine::searchableNamespaces() );
		$nsVals = $this->getNamespaces();
		
		if(empty($nsVals)) {
		    return $this->wg->User->getOption('searchAllNamespaces') ? 'all' :  'default';
		}
		
		foreach( $this->getSearchProfiles() as $name => $profile ) {
		    if ( !count( array_diff( $nsVals, $profile['namespaces'] ) ) && !count( array_diff($profile['namespaces'], $nsVals ) )) {
		        return $name;
		    }
		}
		
		return 'advanced';
	}
	
	/**
	 * Determines the number of pages based on the desired number of results per page
	 * @return integer 
	 */
	public function getNumPages() {
		return $this->getResultsFound() ? ceil( $this->getResultsFound() / $this->getLimit() ) : 0;
	
	}

	/**
	 * If the cityId hasn't been set, and we're not interwiki, we use $wgCityId. 
	 * Otherwise, return the set value.
	 * @return int
	 */
	public function getCityId() {
		if ( ( $this->params['cityId'] == 0 ) && (! $this->isInterWiki() ) ) {
			$this->setCityId( $this->wg->CityId )->getCityId();
		}
		return $this->params['cityId'];
	}
	
	/**
	 * Normalizes the cityId value in case of mistyping
	 * @param int $value
	 */
	public function setCityID( $value ) {
		return $this->__call( 'setCityId', array( $value ) );
	}
}