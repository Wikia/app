<?php
/**
 * Class definition for Wikia\Search\Config
 */
namespace Wikia\Search;
use Wikia\Search\MediaWikiService, Wikia\Search\Match;
use Wikia\Search\TestProfile\Base as BaseProfile;
use Wikia\Search\Query\Select as Query;
use Solarium_Query_Select, Wikia\Search\Traits\ArrayConfigurableTrait;
/**
 * A config class intended to handle variable flags for search
 * Intended to be a dependency-injected receptacle for different search requirements
 * @author Robert Elwell
 * @package Search
 */
class Config
{
	use ArrayConfigurableTrait;

	/**
	 * Default number of results per page. Usually overwritten.
	 * @var int
	 */
	const RESULTS_PER_PAGE = 10;

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
	 * Constants for string names for rank-to-sort resolution
	 */
	const RANK_DEFAULT              = 'default';
	const RANK_NEWEST               = 'newest';
	const RANK_OLDEST               = 'oldest';
	const RANK_RECENTLY_MODIFIED    = 'recently-modified';
	const RANK_STABLE               = 'stable';
	const RANK_MOST_VIEWED          = 'most-viewed';
	const RANK_FRESHEST             = 'freshest';
	const RANK_STALEST              = 'stalest';
	const RANK_SHORTEST             = 'shortest';
	const RANK_LONGEST              = 'longest';

	/**
	 * The value we use for pagination
	 * @var int
	 */
	protected $page = 1;

	/**
	 * Any namespace matching the query prefix
	 * @var int
	 */
	protected $queryNamespace;

	/**
	 * An array of the int values of each  namespace to be searched.
	 * @var array
	 */
	protected $namespaces = [];

	/**
	 * Default number of results per page
	 * @var int
	 */
	protected $limit = self::RESULTS_PER_PAGE;

	/**
	 * Refers to the wiki we're on
	 * @var int
	 */
	protected $wikiId = 0;

	/**
	 * Result offset for our query
	 * @var int
	 */
	protected $start = 0;

	/**
	 * This value is used to restrain results by the number of matching clauses.
	 * For more info check out http://wiki.apache.org/solr/DisMaxQParserPlugin#mm_.28Minimum_.27Should.27_Match.29
	 * @var string
	 */
	protected $minimumMatch = '80%';

	/**
	 * Whether we're in an "advanced search" context
	 * @var bool
	 */
	protected $advanced = false;

	/**
	 * If we're doing a hub search, the hub we're on
	 * @var string
	 */
	protected $hub;

	/**
	 * Here is where we store the user's query
	 * @var Wikia\Search\Query\Select
	 */
	protected $query;

	/**
	 * Two letter wiki language code
	 * @var string
	 */
	protected $languageCode;

	/**
	 * The search profile for A/B testing
	 * @var Wikia\Search\TestProfile\Base
	 */
	protected $testProfile;

	/**
	 * The letter value of the test group.
	 * Null means we aren't participating in a test.
	 * @var string
	 */
	protected $ABTestGroup;

	/**
	 * Storage for client-configured requested fields
	 * @array
	 */
	protected $requestedFields = [];

	/**
	 * Stores field and direction as a two-value array
	 * @var array
	 */
	protected $sort = [ 'score', Solarium_Query_Select::SORT_DESC ];

	/**
	 * The single-value string key we are using to handle client-facing sorting
	 * @var string
	 */
	protected $rank = self::RANK_DEFAULT;

	/**
	 * The resultset returned from a successful search
	 * @var Wikia\Search\ResultSet\AbstractResultSet
	 */
	protected $results;

	/**
	 * Set true if we need to apply some special treatment for commercial clients i.e. filter wikis with non-commercial license
	 * @var bool
	 */
	protected $commercialUse;

	/**
	 * This array allows us to associate sort arguments from the request with the appropriate sorting format
	 * @var array
	 */
	protected $rankOptions = [
			self::RANK_DEFAULT           => [ 'score', Solarium_Query_Select::SORT_DESC ],
			self::RANK_NEWEST            => [ 'created', Solarium_Query_Select::SORT_DESC ],
			self::RANK_OLDEST            => [ 'created', Solarium_Query_Select::SORT_ASC  ],
			self::RANK_RECENTLY_MODIFIED => [ 'touched', Solarium_Query_Select::SORT_DESC ],
			self::RANK_STABLE            => [ 'touched', Solarium_Query_Select::SORT_ASC  ],
			self::RANK_MOST_VIEWED       => [ 'views', Solarium_Query_Select::SORT_DESC ],
			self::RANK_FRESHEST          => [ 'indexed', Solarium_Query_Select::SORT_DESC ],
			self::RANK_STALEST           => [ 'indexed', Solarium_Query_Select::SORT_ASC  ],
			self::RANK_SHORTEST          => [ 'video_duration_i', Solarium_Query_Select::SORT_ASC ],
			self::RANK_LONGEST           => [ 'video_duration_i', Solarium_Query_Select::SORT_DESC ],
	];

	/**
	 * These are the filter keys that can be invoked directly from the controller.
	 * @var array
	 */
	protected $publicFilterKeys = [
			self::FILTER_VIDEO,
			self::FILTER_IMAGE,
			self::FILTER_HD,
			self::FILTER_CAT_VIDEOGAMES,
			self::FILTER_CAT_ENTERTAINMENT,
			self::FILTER_CAT_LIFESTYLE,
	];

	/**
	 * Associates short key names with filter queries.
	 * This approach doesn't support on-the-fly language fields.
	 * We could still append a key in __construct() if it becomes an issue.
	 * @var array
	 */
	protected $filterCodes = [
			self::FILTER_VIDEO => '(is_video:true AND -is_image:true)',
			self::FILTER_IMAGE => '(is_image:true AND -is_video:true)',
			self::FILTER_HD    => 'video_hd_b:true',
	];

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
	protected $filterQueries = [];

	/**
	 * If a query matches an article, it may be stored here.
	 * @var Wikia\Search\Match\Article
	 */
	protected $articleMatch;

	/**
	 * If a query matches a wiki, it may be stored here.
	 * @var Wikia\Search\Match\Wiki
	 */
	protected $wikiMatch;

	/**
	 * If an error occurred during search, we store it here.
	 * @var Exception
	 */
	protected $error;

	/**
	 * When set to true, we don't use boost functions in our query
	 * @var bool
	 */
	protected $skipBoostFunctions = false;

	/**
	 * Allows us to tell the factory which service we want
	 * @var string
	 */
	protected $queryService;

	/**
	 * Used to shift all MediaWiki logic elsewhere.
	 * @var MediaWikiService
	 */
	protected $service;

	/**
	 * Allows us to specify the use case for Wikia\Search\QueryService\Select\Dismax\CombinedMedia
	 * By default, it's video-only. We can include images by changing this value to false.
	 * @var bool
	 */
	protected $combinedMediaSearchIsVideoOnly = true;

	/**
	 * Allows us to specify the use case for Wikia\Search\QueryService\Select\Dismax\CombinedMedia
	 * @var bool
	 */
	protected $combinedMediaSearchIsImageOnly = false;

	/**
	 * Constructor method
	 * @param array $params
	 */
	public function __construct( array $params = [] ) {

		$dynamicFilterCodes = [
				self::FILTER_CAT_VIDEOGAMES    => Utilities::valueForField( 'categories', 'Video Games', [ 'quote'=>'"' ] ),
				self::FILTER_CAT_ENTERTAINMENT => Utilities::valueForField( 'categories', 'Entertainment' ),
				self::FILTER_CAT_LIFESTYLE     => Utilities::valueForField( 'categories', 'Lifestyle'),
				];

		$this->filterCodes = array_merge( $this->filterCodes, $dynamicFilterCodes );

		$this->configureByArray( $params );
	}

	/**
	 * Sets the starting offset for result documents
	 * @param int $start
	 * @return Wikia\Search\Config
	 */
	public function setStart( $start ) {
		$this->start = $start;
		return $this;
	}

	/**
	 * Returns the starting offset
	 * @return int
	 */
	public function getStart() {
		return $this->start;
	}

	/**
	 * Sets the minimum match value
	 * @param string $mm
	 * @return Wikia\Search\Config
	 */
	public function setMinimumMatch( $mm ) {
		$this->minimumMatch = $mm;
		return $this;
	}

	/**
	 * Returns the minimum match value
	 * @return string
	 */
	public function getMinimumMatch() {
		return $this->minimumMatch;
	}

	/**
	 * Provides the appropriate search result length based on whether we have an article match or not.
	 * We use this because Solr has a concept of "length" but not limit, so we're passing the appropriate value to Solr.
	 * However, we want to keep track of what our actual result limit is.
	 * @return integer
	 */
	public function getLength() {
		return ( $this->hasMatch() && $this->getStart() === 0 )
			? $this->limit - 1
			: $this->limit;
	}


	/**
	 * Allows us to set the number of documents returned.
	 * @param int $limit
	 * @return Wikia\Search\Config provides fluent interface
	 */
	public function setLimit( $limit ) {
		$limit = $limit < 200 ? $limit : 200;
		$this->limit = $limit;
		return $this;
	}

	/**
	 * Receives a possibly dirty user input string and stores it in an
	 * instance of Wikia\Search\Query\Select.
	 * Uses the methods within that class to determine if we need to
	 * record a specific namespace associated with that query.
	 *
	 * @param  string $query
	 * @return Wikia\Search\Config provides fluent interface
	 */
	public function setQuery( $query ) {

		$this->query = new Query( $query );

		$namespace = $this->query->getNamespaceId();
		if ( $namespace !== null ) {
			$namespaces = $this->getNamespaces();
			if ( empty( $namespaces ) || (! in_array( $namespace, $namespaces ) ) ) {
				$this->queryNamespace = $namespace;
			}
		}
		return $this;
	}

	/**
	 * Returns the query we've stored.
	 * @return Wikia\Search\Query\Select
	 */
	public function getQuery() {
		return $this->query;
	}

	/**
	 * Allows us to specify what namespaces we want to search against.
	 * @param array $namespaces
	 * @return Wikia\Search\Config
	 */
	public function setNamespaces( array $namespaces ) {
		$this->namespaces = $namespaces;
		return $this;
	}

	/**
	 * Returns the namespaces that were set if they have been set.
	 * If they haven't been set, lazy-loads default namespaces.
	 * If a query with a namespace prefix has been set and is not included in the namespaces, we also include this value in the namespace array.
	 * @return array
	 */
	public function getNamespaces() {
		if ( empty( $this->namespaces ) ) {
			$this->namespaces = $this->getService()->getDefaultNamespacesFromSearchEngine();
		}
		if ( $this->queryNamespace !== null && !in_array( $this->queryNamespace, $this->namespaces ) ) {
			$this->namespaces[] = $this->queryNamespace;
		}
		return $this->namespaces;
	}

	/**
	 * Sets how we sort our results by a single string value, "rank"
	 * @param string $rank
	 * @return Wikia\Search\Config
	 */
	public function setRank( $rank ) {
		if ( isset( $this->rankOptions[$rank] ) ) {
			$this->rank = $rank;
			$sort = $this->rankOptions[$rank];
			$this->setSort( $sort[0], $sort[1] );
		}
		return $this;
	}

	/**
	 * Returns the currently registered rank
	 * @return string
	 */
	public function getRank() {
		return $this->rank;
	}

	/**
	 * Provides the appropriate values for Solarium sorting based on our sort names
	 * @return array where index 0 is the field name and index 1 is the constant used for ASC or DESC in solarium
	 */
	public function getSort() {
		return $this->sort;
	}

	/**
	 * Stores sort field and direction in a two-value array.
	 * This is protected to prevent weird sorting. You should use the "rank" functionality instead.
	 * @param string $field
	 * @param string $direction
	 * @return Wikia\Search\Config
	 */
	protected function setSort( $field, $direction ) {
		$this->sort = [ $field, $direction ];
		return $this;
	}

	/**
	 * Determines whether an article match has been set
	 * @return boolean
	 */
	public function hasArticleMatch() {
		return $this->articleMatch !== null;
	}

	/**
	 * Determines whether a wiki match has been set
	 * @return boolean
	 */
	public function hasWikiMatch() {
		return $this->wikiMatch !== null;
	}

	/**
	 * Stores the current article match ONLY IF IT PASSES OUR ESTABLISHED FILTERS
	 * @param  \Wikia\Search\Match\Article $articleMatch
	 * @return \Wikia\Search\Config provides fluent interface
	 */
	public function setArticleMatch( Match\Article $articleMatch ) {
		if ( $this->articleMatchPassesFilters( $articleMatch ) ) {
			$this->articleMatch = $articleMatch;
		}
		return $this;
	}

	/**
	 * Here, we're checking for conditions that should preclude a match, given our current environment settings.
	 * We're using DeMorgan's theorem here. So write FOR the condition you're trying to filter out.
	 * @param \Wikia\Search\Match\Article $match
	 * @return boolean
	 */
	protected function articleMatchPassesFilters( \Wikia\Search\Match\Article $match ) {
		$result = $match->getResult();
		$filterKeys = $this->getPublicFilterKeys();
		$isVideoFile = $this->getService()->pageIdIsVideoFile( $result['pageid'] );
		return ! (
				( // We have a file that is video, but we only want images.
						$result['ns'] == NS_FILE
						&&
						in_array( \Wikia\Search\Config::FILTER_IMAGE, $filterKeys )
						&&
						$isVideoFile
				) || ( // We have a file that is not a video, but we only want videos.
						$result['ns'] == NS_FILE
						&&
						in_array( \Wikia\Search\Config::FILTER_VIDEO, $filterKeys )
						&&
						!$isVideoFile
				)
		);
	}

	/**
	 * Overloading __set to type hint
	 * @param  \Wikia\Search\Match\Wiki $wikiMatch
	 * @return \Wikia\Search\Config provides fluent interface
	 */
	public function setWikiMatch( Match\Wiki $wikiMatch ) {
		$this->wikiMatch = $wikiMatch;
		return $this;
	}

	/**
	 * Returns the article match, if registered.
	 * @return Wikia\Search\Match\Article
	 */
	public function getArticleMatch() {
		return $this->articleMatch;
	}

	/**
	 * Returns the wiki match, if registered.
	 * @return Wikia\Search\Match\Wiki
	 */
	public function getWikiMatch() {
		return $this->wikiMatch;
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
		return $this->limit;
	}

	/**
	 * Allows us to set the fields we want to get back from Solr for each document.
	 * You can provide either dynamic fields or base fields that are then language-ified.
	 *
	 * @param array $fields
	 * @return Wikia\Search\Config
	 */
	public function setRequestedFields( array $fields ) {
		$this->requestedFields = $fields;
		return $this;
	}

	/**
	 * Returns the requested fields, usually to the query service, to _append_ to default requested fields.
	 * @return array
	 */
	public function getRequestedFields() {
		return $this->requestedFields;
	}

	/**
	 * Sets what hub we're on
	 * @param string $hub
	 * @return Wikia\Search\Config
	 */
	public function setHub( $hub ) {
		$this->hub = $hub;
		return $this;
	}

	/**
	 * Returns hub value
	 * @return string|null
	 */
	public function getHub() {
		return $this->hub;
	}

	/**
	 * Sets whether we're in an 'advanced search' context
	 * @param bool $bool
	 * @return Wikia\Search\Config
	 */
	public function setAdvanced( $bool ) {
		$this->advanced = $bool;
		return $this;
	}

	/**
	 * Whether we're in advanced search
	 * @return bool
	 */
	public function getAdvanced() {
		return $this->advanced;
	}

	/**
	 * We set any exceptions called during Wikia\Search\QueryService\Select\AbstractSelect::search here
	 * @param Exception $error
	 * @return Wikia\Search\Config
	 */
	public function setError( \Exception $error ) {
		$this->error = $error;
		return $this;
	}

	/**
	 * Returns the currently stored error.
	 * @return null|Exception
	 */
	public function getError() {
		return $this->error;
	}

	/**
	 * Tells query service not to use boost functions
	 * @param bool $bool
	 * @return Wikia\Search\Config
	 */
	public function setSkipBoostFunctions( $bool = true ) {
		$this->skipBoostFunctions = $bool;
		return $this;
	}

	/**
	 * Returns the skipBoostFunctions flag
	 * @return bool
	 */
	public function getSkipBoostFunctions() {
		return $this->skipBoostFunctions;
	}

	/**
	 * Allows us to abstract how we handle query service configuration
	 * @param string $service the query service without \\Wikia\\Search\\QueryService\\
	 * @param bool $apply if set to false, we unset the queryservice if it's that value
	 * @return Wikia\Search\Config
	 */
	protected function setQueryService( $service, $apply ) {
		if (! class_exists( '\\Wikia\\Search\\QueryService\\'.$service ) ) {
			throw new \Exception( "Query service {$service} is not registered." );
		}
		if ( $apply ) {
			$this->queryService = $service;
		} else if ( $this->queryService == $service ) {
			$this->queryService = null;
		}
		return $this;
	}

	/**
	 * Allows us to inject logic for lazy-loading query service based on other config settings
	 * @return string
	 */
	protected function bootstrapQueryService() {
		$service = 'Select\\Dismax\\OnWiki';
		if ( $this->getWikiId() == \Wikia\Search\QueryService\Select\Dismax\Video::VIDEO_WIKI_ID ) {
			$service = 'Select\\Dismax\\Video';
		}
		if ( $this->getService()->getGlobal( 'EnableWikiaHomePageExt' ) ) {
			$service = 'Select\\Dismax\\InterWiki';
		}
		return $service;
	}

	/**
	 * Used by the factory to create a query service.
	 * We lazy-load the default value using bootstrapQueryService
	 * @return string
	 */
	public function getQueryService() {
		$this->queryService = $this->queryService ?: $this->bootstrapQueryService();
		return '\\Wikia\\Search\\QueryService\\' . $this->queryService;
	}

	/**
	 * Determines if current query service set is interwiki
	 * @return bool
	 */
	public function getInterWiki() {
		if ( $this->queryService === null ) {
			$this->queryService = $this->bootstrapQueryService();
		}
		return $this->queryService == 'Select\\Dismax\\InterWiki';
	}

	/**
	 * Synonym function for backward compatbility
	 * @param  boolean $apply
	 * @return Wikia\Search\Config provides fluent interface
	 */
	public function setInterWiki( $apply ) {
		return $this->setQueryService( 'Select\\Dismax\\InterWiki', $apply );
	}


	/**
	 * Synonym function for backward compatbility
	 * @param  boolean $apply
	 * @return Wikia\Search\Config provides fluent interface
	 */
	public function setOnWiki( $apply ) {
		return $this->setQueryService( 'Select\\Dismax\\OnWiki', $apply );
	}

	/**
	 * Sets (or unsets) video search as query service
	 * @param bool $apply
	 * @return Wikia\Search\Config
	 */
	public function setVideoSearch( $apply ) {
		return $this->setQueryService( 'Select\\Dismax\\Video', $apply );
	}

	/**
	 * Sets (or unsets) video embed tool search as query service
     * @param bool $apply
	 * @param Wikia\Search\Config
     */
	public function setVideoEmbedToolSearch( $apply ) {
		return $this->setQueryService( 'Select\\Dismax\\VideoEmbedTool', $apply );
	}

	/**
	 * Sets or unsets Lucene as our query service
	 * @param bool $apply
	 * @return Wikia\Search\Config
	 */
	public function setDirectLuceneQuery( $apply ) {
		return $this->setQueryService( 'Select\\Lucene\\Lucene', $apply );
	}

	/**
	 * Sets or unsets combined media search as our query service
	 * @param bool $apply
	 * @return Wikia\Search\Config
	 */
	public function setCombinedMediaSearch( $apply ) {
		return $this->setQueryService( 'Select\\Dismax\\CombinedMedia', $apply );
	}

	/**
	 * Sets or unsets crosswiki lucene query as the query service
	 * @param bool $apply
	 * @return Wikia\Search\Config
	 */
	public function setCrossWikiLuceneQuery( $apply ) {
		return $this->setQueryService( 'Select\\Lucene\\CrossWikiLucene', $apply );
	}

	/**
	 * Sets or unsets VideoTitle as our query service
	 * @param bool $apply
	 * @return Wikia\Search\Config
	 */
	public function setVideoTitleSearch( $apply ) {
		return $this->setQueryService( 'Select\\Dismax\\VideoTitle', $apply );
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
			$result = $this->getService()->formatNumber( $result );
		}
		return $result;
	}

	/**
	 * These search profiles are used to figure out what tab we're on and how we should be searching based on that
	 * While kind of a view concern, moved here so it can play nicely with the namespaces value
	 * @return array
	 */
	public function getSearchProfiles() {
		$nsAllSet = array_keys( $this->getService()->getSearchableNamespacesFromSearchEngine() );
		$defaultNamespaces = $this->getService()->getDefaultNamespacesFromSearchEngine();

	    $profiles = array(
	            SEARCH_PROFILE_DEFAULT => array(
	                    'message' => 'wikiasearch2-tabs-articles',
	                    'tooltip' => 'searchprofile-articles-tooltip',
	                    'namespaces' => $defaultNamespaces,
	                    'namespace-messages' => $this->getService()->getTextForNamespaces( $defaultNamespaces ),
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

	    $this->getService()->invokeHook( 'SpecialSearchProfiles', array( &$profiles ) );

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
	 * Returns the wiki ID to search against.
	 * Lazy-loads current wiki ID if not set.
	 *
	 * @return int
	 */
	public function getWikiId() {
		if ( empty( $this->wikiId ) ) {
			$this->wikiId = $this->getService()->getWikiId();
		}
		return $this->wikiId;
	}

	/**
	 * Sets the wiki we should be searching against, if used for that query service.
	 * @param  int $id
	 * @return Wikia\Search\Config
	 */
	public function setWikiId( $id ) {
		$this->wikiId = $id;
		//die("wikiid:$id");
		return $this;
	}

	/**
	 * Backwards compatibility
	 * @return int
	 */
	public function getCityId() {
		return $this->getWikiId();
	}

	/**
	 * Backwards compatibility
	 * @param  int $value
	 * @return Wikia\Search\Config
	 */
	public function setCityId( $value ) {
		return $this->setWikiId( $value );
	}

	/**
	 * Sets the page, which is a shortcut for offset/limit handling
	 * @param int value
	 * @return Wikia\Search\Config
	 */
	public function setPage( $value ) {
		$this->page = $value;
		return $this;
	}

	/**
	 * Returns the page we're on.
	 * @return int
	 */
	public function getPage() {
		return $this->page;
	}

	/**
	 * Sets the result set
	 * @param \Wikia\Search\ResultSet\AbstractResultSet $results
	 * @return Wikia\Search|Config
	 */
	public function setResults( \Wikia\Search\ResultSet\AbstractResultSet $results ) {
		$this->results = $results;
		return $this;
	}

	/**
	 * Returns our results set
	 * @return \Wikia\Search\ResultSet\AbstractResultSet|null
	 */
	public function getResults() {
		return $this->results;
	}

	/**
	 * Returns the number of results found from the result set, or 0 if not set.
	 * @return int
	 */
	public function getResultsFound() {
		$results = $this->getResults();
		return $results === null ? 0 : $results->getResultsFound();
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
	 * Allows you to specify group by letter (e.g. A, B, C)
	 * @param string $group
	 * @return Wikia\Search\Config
	 */
	public function setABTestGroup( $group ) {
		$this->ABTestGroup = $group;
		return $this;
	}

	/**
	 * Tells you which test group is currently registred.
	 * Null means that we aren't performing an A/B test right now.
	 * @return string
	 */
	public function getABTestGroup() {
		return $this->ABTestGroup;
	}

	/**
	 * Loads the appropriate test profile.
	 * Always at least returns the base profile, in case the group passed doesn't exist.
	 * @return Wikia\Search\Config
	 */
	protected function initiateTestProfile() {
		$nsPrefix = '\\Wikia\\Search\\TestProfile\\';
		$class = "{$nsPrefix}Base";
		$abTestGroup = $this->getABTestGroup();
		if ( $abTestGroup !== null && class_exists( "{$nsPrefix}Group{$abTestGroup}" ) ) {
			$class = "{$nsPrefix}Group{$abTestGroup}";
		}
		$this->testProfile = new $class();
		return $this;
	}

	/**
	 * Lazy-loads the default test profile.
	 * @return Wikia\Search\TestProfile\Base
	 */
	public function getTestProfile() {
		if ( $this->testProfile == null ) {
			$this->initiateTestProfile();
		}
		return $this->testProfile;
	}

	/**
	 * Returns the associative array of query fields to boosts.
	 * @return array
	 */
	public function getQueryFieldsToBoosts() {
		return $this->getTestProfile()->getQueryFieldsToBoosts( $this->getQueryService() );
	}

	/**
	 * Lets us grab just the query fields.
	 * @return array
	 */
	public function getQueryFields() {
		return array_keys( $this->getQueryFieldsToBoosts() );
	}

	/**
	 * Setter for language code
	 * @param $code string language code to set
	 * @return $this
	 */
	public function setLanguageCode( $code ) {
		$this->languageCode = $code;
		return $this;
	}

	/**
	 * Getter for language code, if not set will load content language
	 * @return string
	 */
	public function getLanguageCode() {
		//if language not set, load content language
		if ( !isset( $this->languageCode ) ) {
			$this->languageCode = $this->getService()->getLanguageCode();
		}
		return $this->languageCode;
	}

	/**
	 * Returns the tie param as configured with our AB testing plugin
	 * @return int
	 */
	public function getTie() {
		return $this->getTestProfile()->getTieParam( $this->getQueryService() );
	}

	/**
	 * Dependency lazy-loading.
	 * @return Wikia\Search\MediaWikiService
	 */
	protected function getService() {
		if ( $this->service === null ) {
			$this->service = (new \Wikia\Search\ProfiledClassFactory)->get( 'Wikia\Search\MediaWikiService' );
		}
		return $this->service;
	}

	/**
	 * Flag for whether to include images in combined media search query service
	 * @return bool
	 */
	public function getCombinedMediaSearchIsVideoOnly() {
		return $this->combinedMediaSearchIsVideoOnly;
	}

	/**
	 * Flag for whether to include videos in combined media search query service
	 * @return bool
	 */
	public function getCombinedMediaSearchIsImageOnly() {
		return $this->combinedMediaSearchIsImageOnly;
	}

	/**
	 * Lets us tell the combined media search service whether or not to include images
	 * @param bool $bool
	 * @return Wikia\Search\Config
	 */
	public function setCombinedMediaSearchIsVideoOnly( $bool ) {
		$this->combinedMediaSearchIsVideoOnly = $bool;
		return $this;
	}

	/**
	 * Lets us tell the combined media search service whether or not to include videos
	 * @param bool $bool
	 * @return Wikia\Search\Config
	 */
	public function setCombinedMediaSearchIsImageOnly( $bool ) {
		$this->combinedMediaSearchIsImageOnly = $bool;
		return $this;
	}

	/**
	 * Set true if we need to apply some special treatment for commercial clients i.e. filter wikis with non-commercial license
	 * @param boolean $commercialUse
	 */
	public function setCommercialUse($commercialUse) {
		$this->commercialUse = $commercialUse;
		return $this;
	}

	/**
	 * Set true if we need to apply some special treatment for commercial clients i.e. filter wikis with non-commercial license
	 * @return boolean
	 */
	public function getCommercialUse() {
		return $this->commercialUse;
	}
}
