<?php
/**
 * Class definition for Wikia\Search\Config
 */
namespace Wikia\Search;
use Wikia\Search\MediaWikiService, \Sanitizer, \Solarium_Query_Select, \Wikia\Search\Match, \ArrayAccess;
/**
 * A config class intended to handle variable flags for search
 * Intended to be a dependency-injected receptacle for different search requirements
 * @author Robert Elwell
 * @package Search
 */
class Config implements ArrayAccess
{
	/**
	 * Default number of results per page. Usually overwritten. 
	 * @var int
	 */
	const RESULTS_PER_PAGE = 10;
	
	/**
	 * Constant for retrieving query -- default behavior
	 * @var int
	 */
	const QUERY_DEFAULT = 1;
	
	/**
	 * Constant for retrieving query -- retrieve query without escaping
	 * @var int
	 */
	const QUERY_RAW = 2;
	
	/**
	 * Constant for retrieving query -- retrieve unescaped query with HTML entities encoded
	 * @var int
	 */
	const QUERY_ENCODED = 3;
	
	/**
	 * Constants for public filter queries
	 *
	 */
	const FILTER_VIDEO              = 'is_video';
	const FILTER_IMAGE              = 'is_image';
	const FILTER_HD                 = 'is_hd';
	const FILTER_CAT_VIDEOGAMES     = 'cat_videogames';
	const FILTER_CAT_ENTERTAINMENT  = 'cat_entertainment';
	const FILTER_CAT_LIFESTYLE      = 'cat_lifestyle';
	
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
			'pageid',
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
			'hub',
	);
	
	/**
	 * Allows us to configure boosts for the provided fields.
	 * Use the non-translated version.
	 * @var array
	 */
	private $queryFieldsToBoosts = array(
			'title'             => 5,
			'html'              => 1.5,
			'redirect_titles'   => 4,
			'categories'        => 1,
			'nolang_txt'        => 7
			);
	

	/**
	 * This array allows us to associate sort arguments from the request with the appropriate sorting format
	 * @var array
	 */
	private $rankOptions = array(
			'default'           =>	array( 'score', Solarium_Query_Select::SORT_DESC ),
			'newest'            =>	array( 'created', Solarium_Query_Select::SORT_DESC ),
			'oldest'            =>	array( 'created', Solarium_Query_Select::SORT_ASC  ),
			'recently-modified' =>	array( 'touched', Solarium_Query_Select::SORT_DESC ),
			'stable'            =>	array( 'touched', Solarium_Query_Select::SORT_ASC  ),
			'most-viewed'       =>	array( 'views', Solarium_Query_Select::SORT_DESC ),
			'freshest'          =>	array( 'indexed', Solarium_Query_Select::SORT_DESC ),
			'stalest'           =>	array( 'indexed', Solarium_Query_Select::SORT_ASC  ),
			'shortest'          =>	array( 'video_duration_i', Solarium_Query_Select::SORT_ASC ),
			'longest'           =>	array( 'video_duration_i', Solarium_Query_Select::SORT_DESC ),
	);

	/**
	 * These are the filter keys that can be invoked directly from the controller.
	 * @var array
	 */
	private $publicFilterKeys = array(
			self::FILTER_VIDEO,
			self::FILTER_IMAGE,
			self::FILTER_HD,
			self::FILTER_CAT_VIDEOGAMES,
			self::FILTER_CAT_ENTERTAINMENT,
			self::FILTER_CAT_LIFESTYLE,
	);
	
	/**
	 * Associates short key names with filter queries.
	 * This approach doesn't support on-the-fly language fields.
	 * We could still append a key in __construct() if it becomes an issue.
	 * @var array
	 */
	private $filterCodes = array(
			self::FILTER_VIDEO => 'is_video:true',
			self::FILTER_IMAGE => 'is_image:true',
			self::FILTER_HD    => 'video_hd_b:true',
	);
	
	/**
	 * This is used to keep non-keyed filter queries unique in Solarium
	 * @var int
	 */
	public static $filterQueryIncrement = 0;
	
	/**
	 * Filter queries stored by "key"
	 * Separate from traditional storage because the requirements are a bit more complex
	 * @var array
	 */
	private $filterQueries = array();
	
	/**
	 * Used to shift all MediaWiki logic elsewhere.
	 * @var MediaWikiService
	 */
	protected $service;
	
	/**
	 * Constructor method
	 * @param array $params
	 */
	public function __construct( array $params = array() ) {
		$this->interface = new MediaWikiService;
		
		$dynamicFilterCodes = array(
				self::FILTER_CAT_VIDEOGAMES    => Utilities::valueForField( 'categories', 'Video Games', array( 'quote'=>'"' ) ),
				self::FILTER_CAT_ENTERTAINMENT => Utilities::valueForField( 'categories', 'Entertainment' ),
				self::FILTER_CAT_LIFESTYLE     => Utilities::valueForField( 'categories', 'Lifestyle'),
				);
		
		$this->filterCodes = array_merge( $this->filterCodes, $dynamicFilterCodes );
		
		$this->importQueryFieldBoosts();
		
		$this->params = array_merge( $this->params, 
									 array( 'requestedFields' => $this->requestedFields ), 
									 $params );
	}

	/**
	 * Magic getters and setters used to make it ease array access.
	 * Setter provides fluent interface.
	 * @param  string $method
	 * @param  array  $params
	 * @throws \BadMethodCallException
	 * @return Ambigous <NULL, multitype:>|Wikia\Search\Config
	 */
	public function __call($method, $params) {
		if ( substr($method, 0, 3) == 'get' ) {
			return $this->offsetGet( strtolower($method[3]).substr($method, 4) );
		} else if ( substr($method, 0, 3) == 'set' ) {
			$this->offsetSet( strtolower($method[3]).substr($method, 4), $params[0] );
			return $this; // fluent
		}
		throw new \BadMethodCallException( "Unknown method: {$method}" );
	}
	
	/**
	 * Determines if the value is set.
	 * @param mixed $offset
	 * @return mixed
	 */
	public function offsetExists( $offset ) {
		return isset( $this->params[$offset] );
	}

	/**
	 * Returns the value requested
	 * @param mixed $offset
	 * @return mixed
	 */
	public function offsetGet( $offset ) {
		return isset( $this->params[$offset] ) ? $this->params[$offset] : null;
	}

	/**
	 * Sets a value.
	 * @param mixed $offset
	 * @param mixed $value
	 */
	public function offsetSet( $offset, $value ) {
		$this->params[$offset] = $value;
	}

	/**
	 * Unsets a value from params.
	 * @param mixed $offset
	 */
	public function offsetUnset( $offset ) {
		unset( $this->params[$offset] );
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
	public function getLength() {
		return ( $this->getArticleMatch() !== null && $this->getStart() === 0 ) 
			? ( (int) $this->params['length'] ) - 1 
			: $this->params['length'];
	}
	
	/**
	 * Used to store the query from the request as passed by the controller.
	 * We remove any namespaces prefixes, but store the original query under the originalQuery param.
	 * @param  string $query
	 * @return Wikia\Search\Config provides fluent interface
	 */
	public function setQuery( $query ) {
		
		$query = html_entity_decode( Sanitizer::StripAllTags ( $query ), ENT_COMPAT, 'UTF-8');
		
		$this->params['originalQuery'] = $query;
		
		if ( strpos( $query, ':' ) !== false ) {
			$queryNsExploded = explode( ':', $query );
			$queryNamespaceStr = array_shift( $queryNsExploded );
			$queryNamespace	= $this->interface->getNamespaceIdForString( $queryNamespaceStr );
			if ( $queryNamespace ) {
				$namespaces = $this->getNamespaces();
			    if ( empty( $namespaces ) || (! in_array( $queryNamespace, $namespaces ) ) ) {
			        $this->params['queryNamespace'] = $queryNamespace;
			    } 
			    $query = implode( ':', $queryNsExploded );
			}
		}
		
		$this->params['query'] = $query;
		
		return $this;
	}
	
	/**
	 * Most of the time, we want the query escaped for XSS and Lucene syntax well-formedness
	 * @param  int $strategy one of the self::QUERY_ constants
	 * @return string
	 */
	public function getQuery( $strategy = self::QUERY_DEFAULT ) {
		if (! isset( $this->params['query'] ) ) {
			return false;
		}
		$query = $strategy !== self::QUERY_DEFAULT ? $this->params['query'] : Utilities::sanitizeQuery( $this->params['query'] );
		$query = $strategy === self::QUERY_ENCODED ? htmlentities( $query, ENT_COMPAT, 'UTF-8' ) : $query;
		
		if ( $this->isInterWiki() ) {
			$query = preg_replace( '/ wiki\b/i', '', $query);
		}
		return $query;
	}
	
	/**
	 * Strips out quotes, and sanitizes the query for Lucene query syntax (can be deactivated by passing true)
	 * @param  boolean $raw
	 * @return string
	 */
	public function getQueryNoQuotes( $raw = false ) {
		$query = preg_replace( "/['\"]/", '', preg_replace( "/(\\w)['\"](\\w)/", '$1 $2',  $this->getQuery( self::QUERY_RAW ) ) );
		return $raw ? $query : Utilities::sanitizeQuery( $query );
	}
	
	/**
	 * Returns the namespaces that were set if they have been set, otherwise returns default namespaces.
	 * If a query with a namespace prefix has been set, we also include this value in the namespace array.
	 * @return array
	 */
	public function getNamespaces() {
		if ( empty( $this->params['namespaces'] ) || (! is_array( $this->params['namespaces'] ) ) ) { 
			$this->params['namespaces'] = array();
		}
		$namespaces = ( isset($this->params['namespaces']) && !empty( $this->params['namespaces'] ) ) 
					? $this->params['namespaces'] 
					: $this->interface->getDefaultNamespacesFromSearchEngine();
		
		$queryNamespaceArray = ( isset( $this->params['queryNamespace'] ) ) ? array( $this->params['queryNamespace'] ) : array(); 
		$this->params['namespaces'] = array_unique( array_merge( $namespaces, $queryNamespaceArray ) );

		return $this->params['namespaces'];
	}
	
	/**
	 * Provides the appropriate values for Solarium sorting based on our sort names
	 * @return array where index 0 is the field name and index 1 is the constant used for ASC or DESC in solarium
	 */
	public function getSort() {
		// Allows you to override our default keyword-based ranking functionality. Don't abuse this.
		// I have aggressively validated this value to protect your query.
		if ( isset( $this->params['sort'] ) && is_array( $this->params['sort'] ) && count( $this->params['sort'] ) == 2 ) {
			return $this->params['sort'];
		}
		$rank = $this->getRank();
		return isset( $this->rankOptions[$rank] ) ? $this->rankOptions[$rank] : $this->rankOptions['default']; 
	}
	
	/**
	 * Determines whether an article match has been set
	 * @return boolean
	 */
	public function hasArticleMatch() {
		return isset( $this->params['articleMatch'] ) && !empty( $this->params['articleMatch'] );
	}
	
	/**
	 * Determines whether a wiki match has been set
	 * @return boolean
	 */
	public function hasWikiMatch() {
		return isset( $this->params['wikiMatch'] ) && !empty( $this->params['wikiMatch'] );
	}
	
	/**
	 * Overloading __set to type hint
	 * @param  \Wikia\Search\Match\Article $articleMatch
	 * @return \Wikia\Search\Config provides fluent interface
	 */
	public function setArticleMatch( Match\Article $articleMatch ) {
		$this->params['articleMatch'] = $articleMatch;
		return $this;
	}
	
	/**
	 * Overloading __set to type hint
	 * @param  \Wikia\Search\Match\Wiki $wikiMatch
	 * @return \Wikia\Search\Config provides fluent interface
	 */
	public function setWikiMatch( Match\Wiki $wikiMatch ) {
		$this->params['wikiMatch'] = $wikiMatch;
		return $this;
	}
	
	/**
	 * For IDE type-hinting
	 * @return Wikia\Search\Match\Article
	 */
	public function getArticleMatch() {
		return isset( $this['articleMatch'] ) ? $this['articleMatch'] : null;
	}
	
	/**
	 * For IDE type-hinting
	 * @return Wikia\Search\Match\Wiki
	 */
	public function getWikiMatch() {
		return isset( $this['wikiMatch'] ) ? $this['wikiMatch'] : null;
	}
	
	
	/**
	 * Agnostic match verifier
	 * @return boolean
	 */
	public function hasMatch() {
		return $this->hasArticleMatch() || $this->hasWikiMatch();
	}
	
	/**
	 * Agnostic match accessor
	 * @return Wikia\Search\Match\Article|Wikia\Search\Match\Wiki|false
	 */
	public function getMatch() {
		return $this->getArticleMatch() ?: $this->getWikiMatch();
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
	 * @return Wikia\Search\Config provides fluent interface
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
		foreach ( $this['requestedFields'] as $field ) {
			$fieldsPrepped[] = Utilities::field( $field );
		}
		
		if (! ( in_array( 'id', $fieldsPrepped ) || in_array( '*', $fieldsPrepped ) ) ) {
			$fieldsPrepped[] = 'id';
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
	 * Synonym function for backwards compatibility
	 * @return boolean
	 */
	public function getIsInterWiki() {
		return $this->getInterWiki();
	}
	
	/**
	 * Synonym function for backward compatbility
	 * @param  boolean $value
	 * @return Wikia\Search\Config provides fluent interface
	 */
	public function setIsInterWiki( $value ) {
		$this->params['interWiki'] = $value;
		return $this; 
	}
	
	/**
	 * Returns results number based on a truncated heuristic
	 * @param boolean $formatted whether we should also format the number
	 * @return integer
	 */
	public function getTruncatedResultsNum( $formatted = false ) 
	{
		$resultsNum = $this->getResultsFound();
		
		$result = $resultsNum;
	
		$digits = strlen( $resultsNum );
		if( $digits > 1 ) {
			$zeros = ( $digits > 3 ) ? ( $digits - 1 ) : $digits;
			$result = round( $resultsNum, ( 0 - ( $zeros - 1 ) ) );
		}
		
		if ( $formatted ) {
			$result = $this->interface->formatNumber( $result ); 
		}
		return $result;
	}
	
	/**
	 * These search profiles are used to figure out what tab we're on and how we should be searching based on that
	 * While kind of a view concern, moved here so it can play nicely with the namespaces value
	 * @return array
	 */
	public function getSearchProfiles() {
		$nsAllSet = array_keys( $this->interface->getSearchableNamespacesFromSearchEngine() );
		$defaultNamespaces = $this->interface->getDefaultNamespacesFromSearchEngine();

	    $profiles = array(
	            SEARCH_PROFILE_DEFAULT => array(
	                    'message' => 'wikiasearch2-tabs-articles',
	                    'tooltip' => 'searchprofile-articles-tooltip',
	                    'namespaces' => $defaultNamespaces,
	                    'namespace-messages' => $this->interface->getTextForNamespaces( $defaultNamespaces ),
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
	    
	    $this->interface->invokeHook( 'SpecialSearchProfiles', array( &$profiles ) );

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
		if ( empty( $this->params['cityId'] ) && (! $this->isInterWiki() ) ) {
			return $this->setCityId( $this->interface->getWikiId() )->getCityId();
		}
		return $this->params['cityId'];
	}
	
	/**
	 * Normalizes the cityId value in case of mistyping
	 * @param  int $value
	 * @return Wikia\Search\Config
	 */
	public function setCityID( $value ) {
		return $this->__call( 'setCityId', array( $value ) );
	}
	
	/**
	 * Adds a filter query based on the optional key, or automatically incremented key
	 * Note that if you provide a key that already exists, you are overwriting that filter query.
	 * @param  string $queryString
	 * @param  string $key
	 * @return Wikia\Search\Config
	 */
	public function setFilterQuery( $queryString, $key = null ) {
		$key = $key ?: sprintf( 'fq%d', ++self::$filterQueryIncrement );
		$this->filterQueries[$key] = array( 
				'key' => $key, 
				'query' => $queryString 
		);
		return $this;
	}
	
	/**
	 * Allows you to set all filter queries wholesale.
	 * Pass an empty array if you want to reinitialize this property.
	 * @param  array $filterQueries
	 * @return Wikia\Search\Config
	 */
	public function setFilterQueries( array $filterQueries ) {
		$newFilterQueries = array();
		$this->filterQueries = array();
		self::$filterQueryIncrement = 0;
		foreach ( $filterQueries as $filterQuery ) {
			if ( is_array( $filterQuery ) && isset( $filterQuery['query'] ) ) {
				$this->setFilterQuery( $filterQuery['query'], ( isset( $filterQuery['key'] ) ? $filterQuery['key'] : null ) );
			} else if ( is_string( $filterQuery ) ) {
				$this->setFilterQuery( $filterQuery );
			} 
		}
		return $this;
	}
	
	/**
	 * Returns filter query associative array
	 * @return array
	 */
	public function getFilterQueries() {
		return $this->filterQueries;
	}

	/**
	 * Returns public filter query keys
	 * @return array
	 */
	public function getPublicFilterKeys() {
		$publicKeys = $this->publicFilterKeys;
		$filterKeys = array_keys( $this->filterQueries );
		return array_filter( $filterKeys, function ( $key ) use ( $publicKeys ) { return in_array($key, $publicKeys); } );
	}
	
	/**
	 * Returns true or false depending on whether we've got filter queries set
	 * @return bool
	 */
	public function hasFilterQueries() {
		return !empty( $this->filterQueries );
	}
	
	/**
	 * Uses pre-determined filter queries that can be set by the controller (e.g. video filtering)
	 * @param  string $code
	 * @return Wikia\Search\Config
	 */
	public function setFilterQueryByCode( $code ) {
		if ( isset( $this->filterCodes[$code] ) ) {
			$this->setFilterQuery( $this->filterCodes[$code], $code );
		}
		return $this;
	}
	
	/**
	 * Allows us to use pass array of codes in the controller to the search config
	 * @param  array $codes
	 * @return Wikia\Search\Config
	 */
	public function setFilterQueriesFromCodes( array $codes ) {
		foreach ( $codes as $code ) {
			$this->setFilterQueryByCode( $code );
		}
		return $this;
	}
	
	/**
	 * Allows us to add additional query fields, with a given boost.
	 * @param string $field
	 * @param int $boost
	 * @return Wikia\Search\Config
	 */
	public function setQueryField( $field, $boost = 1 ) {
		$this->queryFieldsToBoosts[$field] = $boost;
		return $this;
	}
	
	/**
	 * Lets us add multiple fields. Can handle both associative with boosts as value and flat.
	 * @param array $fields
	 * @return Wikia\Search\Config
	 */
	public function addQueryFields( array $fields ) {
		if ( array_values( $fields ) === $fields ) {
			foreach ( $fields as $field ) {
				$this->setQueryField( $field );
			}
		} else {
			foreach ( $fields as $field => $boost ) {
				$this->setQueryField( $field, $boost );
			}
		}
		return $this;
	}
	
	/**
	 * Returns the associative array of query fields to boosts.
	 * @return array
	 */
	public function getQueryFieldsToBoosts() {
		return $this->queryFieldsToBoosts;
	}
	
	/**
	 * Allows us to manually set query fields externally. Supports flat and associative.
	 * @param array $fields
	 * @return Wikia\Search\Config
	 */
	public function setQueryFields( array $fields ) {
		if ( array_values( $fields ) === $fields ) {
			$this->queryFieldsToBoosts = array();
			foreach ( $fields as $field ) {
				$this->setQueryField( $field );
			}
		} else {
			$this->queryFieldsToBoosts = $fields;
		}
		return $this;
	}
	
	/**
	 * Lets us grab just the query fields.
	 * @return array
	 */
	public function getQueryFields() {
		return array_keys( $this->queryFieldsToBoosts );
	}
	
	/**
	 * Allows global variables like $wgSearchBoostFor_title to overwrite default boost values defined in this class.
	 * Run during __construct().
	 * @return Wikia\Search\Config
	 */
	protected function importQueryFieldBoosts() {
		foreach ( $this->queryFieldsToBoosts as $field => $boost ) {
			$this->setQueryField( $field, $this->interface->getGlobalWithDefault( "SearchBoostFor_{$field}", $boost ) );
		}
		return $this;
	}
}