<?php

/**
 * Base class for different kinds of blacklists
 */
abstract class BaseBlacklist {

	/**
	 * Array of blacklist sources
	 *
	 * @var array
	 */
	public $files = array();

	/**
	 * Array containing regexes to test against
	 *
	 * @var bool|array
	 */
	protected $regexes = false;

	/**
	 * Chance of receiving a warning when the filter is hit
	 *
	 * @var int
	 */
	public $warningChance = 100;

	/**
	 * @var int
	 */
	public $warningTime = 600;

	/**
	 * @var int
	 */
	public $expiryTime = 900;

	/**
	 * Array containing blacklists that extend BaseBlacklist
	 *
	 * @var array
	 */
	private static $blacklistTypes = array(
		'spam' => 'SpamBlacklist',
		'email' => 'EmailBlacklist',
	);

	/**
	 * Array of blacklist instances
	 *
	 * @var array
	 */
	private static $instances = array();

	/**
	 * Constructor
	 *
	 * @param array $settings
	 */
	function __construct( $settings = array() ) {
		foreach ( $settings as $name => $value ) {
			$this->$name = $value;
		}
	}

	/**
	 * Adds a blacklist class to the registry
	 *
	 * @param $type string
	 * @param $class string
	 */
	public static function addBlacklistType( $type, $class ) {
		self::$blacklistTypes[$type] = $class;
	}

	/**
	 * Return the array of blacklist types currently defined
	 *
	 * @return array
	 */
	public static function getBlacklistTypes() {
		return self::$blacklistTypes;
	}

	/**
	 * Returns an instance of the given blacklist
	 *
	 * @param $type string Code for the blacklist
	 * @return BaseBlacklist
	 * @throws MWException
	 */
	public static function getInstance( $type ) {
		if ( !isset( self::$blacklistTypes[$type] ) ) {
			throw new MWException( "Invalid blacklist type '$type' passed to " . __METHOD__ );
		}

		if ( !isset( self::$instances[$type] ) ) {
			global $wgBlacklistSettings;

			// Prevent notices
			if ( !isset( $wgBlacklistSettings[$type] ) ) {
				$wgBlacklistSettings[$type] = array();
			}

			$className = self::$blacklistTypes[$type];
			self::$instances[$type] = new $className( $wgBlacklistSettings[$type] );
		}

		return self::$instances[$type];
	}

	/**
	 * Returns the code for the blacklist implementation
	 *
	 * @return string
	 */
	abstract protected function getBlacklistType();

	/**
	 * Check if the given local page title is a spam regex source.
	 *
	 * @param Title $title
	 * @return bool
	 */
	public static function isLocalSource( Title $title ) {
		global $wgDBname, $wgBlacklistSettings;

		if( $title->getNamespace() == NS_MEDIAWIKI ) {
			$sources = array();
			foreach ( self::$blacklistTypes as $type => $class ) {
				$type = ucfirst( $type );
				$sources += array(
					"$type-blacklist",
					"$type-whitelist"
				);
			}

			if( in_array( $title->getDBkey(), $sources ) ) {
				return true;
			}
		}

		$thisHttp = wfExpandUrl( $title->getFullUrl( 'action=raw' ), PROTO_HTTP );
		$thisHttpRegex = '/^' . preg_quote( $thisHttp, '/' ) . '(?:&.*)?$/';

		$files = array();
		foreach ( self::$blacklistTypes as $type => $class ) {
			if ( isset( $wgBlacklistSettings[$type]['files'] ) ) {
				$files += $wgBlacklistSettings[$type]['files'];
			}
		}

		foreach( $files as $fileName ) {
			$matches = array();
			if ( preg_match( '/^DB: (\w*) (.*)$/', $fileName, $matches ) ) {
				if ( $wgDBname == $matches[1] ) {
					if( $matches[2] == $title->getPrefixedDbKey() ) {
						// Local DB fetch of this page...
						return true;
					}
				}
			} elseif( preg_match( $thisHttpRegex, $fileName ) ) {
				// Raw view of this page
				return true;
			}
		}

		return false;
	}

	/**
	 * Returns the type of blacklist from the given title
	 *
	 * @param Title $title
	 * @return bool|string
	 */
	public static function getTypeFromTitle( Title $title ) {
		$types = array_map( 'preg_quote', array_keys( self::$blacklistTypes ), array( '/' ) );
		$regex = '/(' . implode( '|', $types ).  ')-(?:Blacklist|Whitelist)/';

		if ( preg_match( $regex, $title->getDBkey(), $m ) ) {
			return strtolower( $m[1] );
		}

		return false;
	}

	/**
	 * Fetch local and (possibly cached) remote blacklists.
	 * Will be cached locally across multiple invocations.
	 * @return array set of regular expressions, potentially empty.
	 */
	function getBlacklists() {
		if( $this->regexes === false ) {
			$this->regexes = array_merge(
				$this->getLocalBlacklists(),
				$this->getSharedBlacklists() );
		}
		return $this->regexes;
	}

	/**
	 * Returns the local blacklist
	 *
	 * @return array Regular expressions
	 */
	public function getLocalBlacklists() {
		return SpamRegexBatch::regexesFromMessage( "{$this->getBlacklistType()}-blacklist", $this );
	}

	/**
	 * Returns the (local) whitelist
	 *
	 * @return array Regular expressions
	 */
	public function getWhitelists() {
		return SpamRegexBatch::regexesFromMessage( "{$this->getBlacklistType()}-whitelist", $this );
	}

	/**
	 * Fetch (possibly cached) remote blacklists.
	 * @return array
	 */
	function getSharedBlacklists() {
		global $wgMemc, $wgDBname;
		$listType = $this->getBlacklistType();
		$fname = 'SpamBlacklist::getRegex';
		wfProfileIn( $fname );

		wfDebugLog( 'SpamBlacklist', "Loading $listType regex..." );

		if ( count( $this->files ) == 0 ){
			# No lists
			wfDebugLog( 'SpamBlacklist', "no files specified\n" );
			wfProfileOut( $fname );
			return array();
		}

		// This used to be cached per-site, but that could be bad on a shared
		// server where not all wikis have the same configuration.
		$cachedRegexes = $wgMemc->get( "$wgDBname:{$listType}_blacklist_regexes" );
		if( is_array( $cachedRegexes ) ) {
			wfDebugLog( 'SpamBlacklist', "Got shared spam regexes from cache\n" );
			wfProfileOut( $fname );
			return $cachedRegexes;
		}

		$regexes = $this->buildSharedBlacklists();
		$wgMemc->set( "$wgDBname:{$listType}_blacklist_regexes", $regexes, $this->expiryTime );

		wfProfileOut( $fname );

		return $regexes;
	}

	function clearCache() {
		global $wgMemc, $wgDBname;
		$listType = $this->getBlacklistType();

		$wgMemc->delete( "$wgDBname:{$listType}_blacklist_regexes" );
		wfDebugLog( 'SpamBlacklist', "$listType blacklist local cache cleared.\n" );
	}

	function buildSharedBlacklists() {
		$regexes = array();
		$listType = $this->getBlacklistType();
		# Load lists
		wfDebugLog( 'SpamBlacklist', "Constructing $listType blacklist\n" );
		foreach ( $this->files as $fileName ) {
			$matches = array();
			if ( preg_match( '/^DB: ([\w-]*) (.*)$/', $fileName, $matches ) ) {
				$text = $this->getArticleText( $matches[1], $matches[2] );
			} elseif ( preg_match( '/^http:\/\//', $fileName ) ) {
				$text = $this->getHttpText( $fileName );
			} else {
				$text = file_get_contents( $fileName );
				wfDebugLog( 'SpamBlacklist', "got from file $fileName\n" );
			}

			// Build a separate batch of regexes from each source.
			// While in theory we could squeeze a little efficiency
			// out of combining multiple sources in one regex, if
			// there's a bad line in one of them we'll gain more
			// from only having to break that set into smaller pieces.
			$regexes = array_merge( $regexes,
				SpamRegexBatch::regexesFromText( $text, $this, $fileName ) );
		}

		return $regexes;
	}

	function getHttpText( $fileName ) {
		global $wgDBname, $messageMemc;
		$listType = $this->getBlacklistType();

		# HTTP request
		# To keep requests to a minimum, we save results into $messageMemc, which is
		# similar to $wgMemc except almost certain to exist. By default, it is stored
		# in the database
		#
		# There are two keys, when the warning key expires, a random thread will refresh
		# the real key. This reduces the chance of multiple requests under high traffic
		# conditions.
		$key = "{$listType}_blacklist_file:$fileName";
		$warningKey = "$wgDBname:{$listType}filewarning:$fileName";
		$httpText = $messageMemc->get( $key );
		$warning = $messageMemc->get( $warningKey );

		if ( !is_string( $httpText ) || ( !$warning && !mt_rand( 0, $this->warningChance ) ) ) {
			wfDebugLog( 'SpamBlacklist', "Loading $listType blacklist from $fileName\n" );
			$httpText = Http::get( $fileName );
			if( $httpText === false ) {
				wfDebugLog( 'SpamBlacklist', "Error loading $listType blacklist from $fileName\n" );
			}
			$messageMemc->set( $warningKey, 1, $this->warningTime );
			$messageMemc->set( $key, $httpText, $this->expiryTime );
		} else {
			wfDebugLog( 'SpamBlacklist', "Got $listType blacklist from HTTP cache for $fileName\n" );
		}
		return $httpText;
	}

	/**
	 * Fetch an article from this or another local MediaWiki database.
	 * This is probably *very* fragile, and shouldn't be used perhaps.
	 *
	 * @param string $db
	 * @param string $article
	 * @return string
	 */
	function getArticleText( $db, $article ) {
		wfDebugLog( 'SpamBlacklist', "Fetching {$this->getBlacklistType()} spam blacklist from '$article' on '$db'...\n" );
		global $wgDBname;
		$dbr = wfGetDB( DB_READ );
		$dbr->selectDB( $db );
		$text = false;
		if ( $dbr->tableExists( 'page' ) ) {
			// 1.5 schema
			$dbw = wfGetDB( DB_READ );
			$dbw->selectDB( $db );
			$revision = Revision::newFromTitle( Title::newFromText( $article ) );
			if ( $revision ) {
				$text = $revision->getText();
			}
			$dbw->selectDB( $wgDBname );
		} else {
			// 1.4 schema
			$title = Title::newFromText( $article );
			$text = $dbr->selectField( 'cur', 'cur_text', array( 'cur_namespace' => $title->getNamespace(),
				'cur_title' => $title->getDBkey() ), __METHOD__ );
		}
		$dbr->selectDB( $wgDBname );
		return strval( $text );
	}

	/**
	 * Returns the start of the regex for matches
	 *
	 * @return string
	 */
	public function getRegexStart() {
		return '/[a-z0-9_\-.]*';
	}

	/**
	 * Returns the end of the regex for matches
	 *
	 * @param $batchSize
	 * @return string
	 */
	public function getRegexEnd( $batchSize ) {
		return ($batchSize > 0 ) ? '/Sim' : '/im';
	}

}
