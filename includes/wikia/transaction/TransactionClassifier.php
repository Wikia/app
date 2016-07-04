<?php

/**
 * Class TransactionClassifier generates a string that represents transaction type
 * based on chosen set of attributes. The name is than used to label all
 * performance-related reports including Newrelic, RUM and profilers.
 */
class TransactionClassifier {

	const OTHER = 'other';

	const ACTION_VIEW = 'view';

	// copied from extensions/wikia/Wall/WallNamespaces.php to use a constant below
	// while not being dependant on Wall extension inclusion
	const NS_USER_WALL = 1200;
	const NS_USER_WALL_MESSAGE = 1201;
	const NS_USER_WALL_MESSAGE_GREETING = 1202;

	// copied from extensions/wikia/Forum/ForumNamespaces.php to use a constant below
	// while not being dependant on Forum extension inclusion
	const NS_WIKIA_FORUM_BOARD = 2000;
	const NS_WIKIA_FORUM_BOARD_THREAD = 2001;
	const NS_WIKIA_FORUM_TOPIC_BOARD = 2002;

	// copied from extensions/wikia/Blogs/Blogs.php to use a constant below
	// while not being dependant on Blogs extension inclusion
	const NS_BLOG_ARTICLE = 500;
	const NS_BLOG_ARTICLE_TALK = 501;
	const NS_BLOG_LISTING = 502;
	const NS_BLOG_LISTING_TALK = 503;

	// copied from extensions/wikia/SemanticMediaWiki/includes/SMW_Setup.php to use a constant below
	// NOTE: this assumes $smwgNamespaceIndex is set to 300 (set in CommonExtensions.php)
	// while not being dependant on SMW extension inclusion
	const SMW_NS_PROPERTY = 302;
	const SMW_NS_TYPE = 304;
	const SF_NS_FORM = 306;
	const SMW_NS_CONCEPT = 308;

	protected static $FILTER_ARTICLE_ACTIONS = array(
		'view',
		'edit',
		'submit',
		'diff',
	);

	protected static $FILTER_SPECIAL_PAGES = array(
		'Search',
		'HealthCheck',
		'WikiActivity',
		'Our404Handler',
		'Recentchanges',
		'UserLogin',
		'UserSignup',
		'Chat',
		'Newimages',
		'Videos',
		'Contributions',
	);

	protected static $FILTER_AJAX_FUNCTIONS = array(
		'getLinkSuggest',
		'CategoryExhibitionAjax',
		'ChatAjax',
		'ActivityFeedAjax',
		'RTEAjax',
		'EditPageLayoutAjax',
		'WMU',
		'WikiaPhotoGalleryAjax',
	);

	protected static $FILTER_API_CALLS = array(
		'query',
		'opensearch',
		'parse',
		'lyrics',
		'visualeditor',
		'visualeditoredit',
	);

	protected static $MAP_ARTICLE_NAMESPACES = array(
		NS_MAIN => 'main',
		NS_USER => 'user',
		NS_USER_TALK => 'user_talk',
		NS_FILE => 'file',
		NS_CATEGORY => 'category',

		self::NS_USER_WALL => 'message_wall',
		self::NS_USER_WALL_MESSAGE => 'message_wall',
		self::NS_USER_WALL_MESSAGE_GREETING => 'message_wall',

		self::NS_WIKIA_FORUM_BOARD => 'forum',
		self::NS_WIKIA_FORUM_BOARD_THREAD => 'forum',
		self::NS_WIKIA_FORUM_TOPIC_BOARD => 'forum',

		self::NS_BLOG_ARTICLE => 'blog',
		self::NS_BLOG_ARTICLE_TALK => 'blog',
		self::NS_BLOG_LISTING => 'blog',
		self::NS_BLOG_LISTING_TALK => 'blog',

		self::SMW_NS_PROPERTY => 'semantic_mediawiki',
		self::SMW_NS_TYPE => 'semantic_mediawiki',
		self::SMW_NS_CONCEPT => 'semantic_mediawiki',
		self::SF_NS_FORM => 'semantic_form',
	);

	protected static $MAP_PARSER_CACHED_USED = array(
		false => 'parser',
		true => 'no_parser',
	);

	protected static $MAP_PARSER_CACHE_DISABLED = array(
		true => 'parser_cache_disabled',
	);

	protected static $MAP_DPL = array(
		true => 'dpl',
	);

	protected static $MAP_SEMANTIC_MEDIAWIKI = array(
		true => 'semantic_mediawiki',
	);

	protected $dependencies = array( Transaction::PARAM_ENTRY_POINT );
	protected $attributes = array();
	protected $nameParts = null;
	protected $name = null;

	/**
	 * Returns the transaction name applicable for the current set of recorded attributes
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Notifies the classifies about attribute change that results in transaction name regeneration
	 * if needed. Returns then an updated transaction name.
	 *
	 * @param string $key Attribute key
	 * @param string $value Attribute value
	 * @return string
	 */
	public function update( $key, $value ) {
		$this->attributes[$key] = $value;
		if ( in_array( $key, $this->dependencies ) ) {
			$this->dependencies = array();
			$this->nameParts = array();
			$this->build();
			$this->name = implode( '/', $this->nameParts );
		}
		return $this->name;
	}

	/**
	 * Build transaction name based on current attributes
	 */
	protected function build() {
		$entryPoint = $this->add( Transaction::PARAM_ENTRY_POINT );
		switch ( $entryPoint ) {
			// article page
			case Transaction::ENTRY_POINT_PAGE:
				$this->buildPage();
				break;
			// special page
			case Transaction::ENTRY_POINT_SPECIAL_PAGE:
				$this->addByList( Transaction::PARAM_SPECIAL_PAGE_NAME, self::$FILTER_SPECIAL_PAGES );
				break;
			// nirvana call - wikia.php
			case Transaction::ENTRY_POINT_NIRVANA:
				$this->add( Transaction::PARAM_CONTROLLER );
				break;
			// foo.wikia.com/api/v1 calls
			case Transaction::ENTRY_POINT_API_V1:
				$this->add( Transaction::PARAM_CONTROLLER );
				break;
			// ajax call - action=ajax
			case Transaction::ENTRY_POINT_AJAX:
				$this->addByList( Transaction::PARAM_FUNCTION, self::$FILTER_AJAX_FUNCTIONS );
				break;
			// api call - api.php
			case Transaction::ENTRY_POINT_API:
				$this->addByList( Transaction::PARAM_API_ACTION, self::$FILTER_API_CALLS );
				$this->add( Transaction::PARAM_API_LIST );
				break;
			// MediaWiki maintenance scripts
			case Transaction::ENTRY_POINT_MAINTENANCE:
				$this->add( Transaction::PARAM_MAINTENANCE_SCRIPT );
				break;
		}
	}

	/**
	 * Build transaction name when it's an article transaction
	 */
	protected function buildPage() {
		// add namespace (with mapping)
		$namespace = $this->addByMap( Transaction::PARAM_NAMESPACE, self::$MAP_ARTICLE_NAMESPACES );
		if ( $namespace !== NS_MAIN ) {
			return;
		}
		// add action (with filter)
		$action = $this->addByList( Transaction::PARAM_ACTION, self::$FILTER_ARTICLE_ACTIONS );
		if ( $action !== self::ACTION_VIEW ) {
			return;
		}
		// add skin name
		if ( $this->add( Transaction::PARAM_SKIN ) === null ) {
			return;
		}
		// add parser_cache_disabled indicator
		if ( $this->addByMap( Transaction::PARAM_PARSER_CACHE_DISABLED, self::$MAP_PARSER_CACHE_DISABLED, null ) === true ) {

		}
		// add parser_cached_used indicator
		else if ( $this->addByMap( Transaction::PARAM_PARSER_CACHE_USED, self::$MAP_PARSER_CACHED_USED ) === null ) {
			return;
		}

		// add "DPL was used" information
		$this->addByMap( Transaction::PARAM_DPL, self::$MAP_DPL );

		// add "SMW was used" information
		$this->addByMap( Transaction::PARAM_SEMANTIC_MEDIAWIKI, self::$MAP_SEMANTIC_MEDIAWIKI );

		// add size category
		if ( $this->add( Transaction::PARAM_SIZE_CATEGORY ) === null ) {
			return;
		}
	}

	/**
	 * Add new transaction name part from the specified attribute value. Optionally transform
	 * the value using given callback
	 *
	 * Returns the specified attribute value
	 *
	 * @param string $key Attribute key
	 * @param callable $valueTransform (optional) Value transform callback
	 * @return mixed
	 */
	protected function add( $key, callable $valueTransform = null ) {
		$this->dependencies[] = $key;
		if ( !isset( $this->attributes[$key] ) ) {
			return null;
		}
		$value = $this->attributes[$key];
		$nameValue = $valueTransform ? $valueTransform( $value ) : $value;
		if ( !is_null( $nameValue ) ) {
			$this->nameParts[] = $nameValue;
		};
		return $value;
	}

	/**
	 * Add new transaction name part from the specified attribute value if it's in the supplied list.
	 * Otherwise add a special "other" token
	 *
	 * Returns the specified attribute value
	 *
	 * @param string $key Attribute key
	 * @param array $filter List of values that will be left untouched. Others will be replaced by "other"
	 * @return mixed
	 */
	protected function addByList( $key, $filter ) {
		return $this->add( $key, function ( $value ) use ( $filter ) {
			if ( in_array( $value, $filter ) ) {
				return $value;
			} else {
				return self::OTHER;
			}
		} );
	}

	/**
	 * Add new transaction name part from the specified attribute value if it's in the supplied map.
	 * The map is used and the value from the map is added instead. If the map doesn't have the actual value
	 * it adds a special "other" token
	 *
	 * @param string $key Attribute key
	 * @param array $map Map of raw values and tokens to be included in transaction name. Non-existent items are replaced by "other"
	 * @param string $defaulty The value to use if the key is not set
	 * @return mixed
	 */
	protected function addByMap( $key, $map, $default = self::OTHER ) {
		return $this->add( $key, function ( $value ) use ( $map, $default ) {
			if ( isset( $map[$value] ) ) {
				return $map[$value];
			} else {
				return $default;
			}
		} );
	}

}
