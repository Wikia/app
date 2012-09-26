<?php 

/**
 * A config class intended to handle variable flags for search
 * Intended to be a dependency-injected receptacle for different search requirements
 * @author relwell
 *
 */

class WikiaSearchConfig extends WikiaObject implements ArrayAccess
{
	private $params = array(
			'page'			=>	1,
			'length'		=>	WikiaSearch::RESULTS_PER_PAGE,
			'cityId'		=>	0,
			'rank'			=>	'default',
			'start'			=>	0,
			'minimumMatch'	=> '66%',
			);
	
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
	
	public function __construct( array $params = array() )
	{
		$this->params = array_merge( $this->params, 
									 array( 'requestedFields' => $this->requestedFields ), 
									 $params );
	}

	// getter and setter shortcuts
	public function __call($method, $params)
	{
		if ( substr($method, 0, 3) == 'get' ) {
			return $this->offsetGet( strtolower($method[3]).substr($method, 4) );
		} else if ( substr($method, 0, 3) == 'set' ) {
			$this->offsetSet( strtolower($method[3]).substr($method, 4), $params[0] );
			return $this; // fluent
		}
	}
	
	public function offsetExists ($offset)
	{
		return isset($this->params[$offset]);
	}

	public function offsetGet ($offset)
	{
		return isset($this->params[$offset]) ? $this->params[$offset] : null;
	}

	public function offsetSet ($offset, $value)
	{
		$this->params[$offset] = $value;
	}

	public function offsetUnset ($offset)
	{
		unset($this->params[$offset]);
	}
	
	public function getSize()
	{
		// backwards compatibility, of sorts
		return $this->getLength();
	}
	
	public function getLength()
	{
		// handles PTT
		return ( $this->getArticleMatch() !== null && $this->getStart() === 0 ) 
			? ((int)$this->params['length']) - 1 
			: $this->params['length'];
	}
	
	public function getStart()
	{
		return ( $this->getArticleMatch() !== null && $this->params['start'] !== 0) 
			? ((int)$this->params['start'] - 1) 
			: $this->params['start'];
	}
	
	public function getPaginatedSearch()
	{
		return $this->getStart() !== 0;
	}
	
	public function setQuery( $query )
	{
		$this->params['originalQuery'] = $query;
		
		if ($queryNamespace = MWNamespace::getCanonicalIndex(array_shift(explode(':', strtolower($query))))) {
		    if (!in_array($queryNamespace, $this->params['namespaces'])) {
		        $this->params['queryNamespace'] = $queryNamespace;
		    } 
		    $query = implode(':', array_slice(explode(':', $query), 1));
		}
		
		$this->params['query'] = $query;
		
		return $this;
	}
	
	public function getNamespaces()
	{
		$namespaces = ( isset($this->params['namespaces']) && !empty($this->params['namespaces']) ) 
					? $this->params['namespaces'] 
					: SearchEngine::DefaultNamespaces();
		
		$queryNamespaceArray = (isset($this->params['queryNamespace'])) ? array($this->params['queryNamespace']) : array(); 
		$this->params['namespaces'] = array_merge($namespaces, $queryNamespaceArray);
		return $this->params['namespaces'];
	}
	
	public function isMobile()
	{
		return F::app()->checkSkin( 'wikiamobile' );
	}
	
	public function getSort()
	{
		$rank = $this->getRank();
		return isset($this->rankOptions[$rank]) ? $this->rankOptions[$rank] : $this->rankOptions['default']; 
	}
	
	public function hasArticleMatch()
	{
		return isset($this->params['articleMatch']);
	}
	
	public function getLimit()
	{
		return $this->params['length'];
	}
	
	public function getRequestedFields()
	{
		$fieldsPrepped = array();
		foreach ($this->requestedFields as $field) {
			$fieldsPrepped[] = WikiaSearch::field($field);
		}
		
		return $fieldsPrepped;
	}
	
	public function isInterWiki()
	{
		return $this->getIsInterWiki();
	}
	
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
	
	public function getNumPages() {
		return $this->getResultsFound() ? ceil( $this->getResultsFound() / $this->getLimit() ) : 0;
	}
}