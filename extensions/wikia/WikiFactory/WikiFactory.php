<?php

/**
 * @package MediaWiki
 * @ingroup WikiFactory
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com> for Wikia Inc.
 */

use Wikia\Logger\WikiaLogger;

$wgExtensionCredits['other'][] = [
	"name" => "WikiFactoryLoader",
	"description" => "MediaWiki configuration loader",
	"svn-revision" => '$Revision$',
	"author" => "[http://www.wikia.com/wiki/User:Eloy.wikia Krzysztof Krzyżaniak (eloy)]"
];

/**
 * define hooks for WikiFactory here
 */
$wgHooks[ "ArticleSaveComplete" ][] = "WikiFactory::updateCityDescription";

class WikiFactoryDuplicateDomain extends Exception {
	public $city_id, $city_url, $duplicate_city_id;

	function __construct( $city_id, $city_url, $duplicate_city_id ) {
		$message = "Cannot set domain for wiki $city_id to '$city_url' because it conflicts with wiki $duplicate_city_id";
		parent::__construct($message);
		$this->city_id = $city_id;
		$this->city_url = $city_url;
		$this->duplicate_city_id = $duplicate_city_id;
	}
}


class WikiFactory {

	const LOG_VARIABLE  = 1;
	const LOG_DOMAIN    = 2;
	const LOG_CATEGORY  = 3;
	const LOG_STATUS    = 4;

	# close Wiki
	const HIDE_ACTION 			= -1;
	const CLOSE_ACTION 			= 0;
	const PUBLIC_WIKI			= 1;
	static public $DUMP_SERVERS = [
		'c1' => 'db2',
		'c2' => 'db-sb2'
	];

	# city_flags
	const FLAG_CREATE_DB_DUMP        = 1; // prepare a database dump and send it to Amazon's s3
	const FLAG_CREATE_IMAGE_ARCHIVE  = 2; // prepare DFS bucket dump and send it to Amazon's s3
	const FLAG_DELETE_DB_IMAGES      = 4; // remove DFS bucket
	const FLAG_FREE_WIKI_URL         = 8; // removes wiki database and WikiFactory settings
	const FLAG_HIDE_DB_IMAGES        = 16;  // images and DB dumps will be hidden on s3
	const FLAG_REDIRECT              = 32;  // this wiki is a redirect - do not remove
	const FLAG_PROTECTED             = 512; //wiki cannot be closed

	const db            	= "wikicities"; // @see $wgExternalSharedDB
	const DOMAINCACHE   	= "/tmp/wikifactory/domains.ser";
	const CACHEDIR      	= "/tmp/wikifactory/wikis";

	// Community Central's city_id in wikicities.city_list.
	const COMMUNITY_CENTRAL = 177;

	// Language wikis index city_id in wikicities.city_list.
	const LANGUAGE_WIKIS_INDEX = 3;

	const SLOT_1 = 'slot1';
	const SLOT_2 = 'slot2';

	static public $types = [
		"integer",
		"long",
		"string",
		"float",
		"array",
		"boolean",
		"text",
		"struct",
		"hash"
	];

	static public $levels = [
		1 => "read only",
		2 => "editable by staff",
		3 => "editable by user"
	];

	static public $mIsUsed = false;

	static protected $variablesCache = [];

	/**
	 * simple accessor and toggle flag method which shows if WikiFactory is used
	 * at all. set in WikiFactoryLoader constructor to true, default false.
	 *
	 * @access public
	 * @static
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @param boolean	$flag	if value set flag to $flag
	 *
	 * @return boolean	current value of static::$mIsUsed
	 */
	static public function isUsed( $flag = null ) {
		if ( $flag !== null ) {
			static::$mIsUsed = (bool) $flag;
		}

		return static::$mIsUsed;
	}

	/**
	 * wrapper for connecting to proper table
	 *
	 * @access public
	 * @static
	 *
	 * @param string $table - table name
	 * @param bool|string $column - column name default false
	 *
	 * @return string - table name with database
	 */
	static public function table( $table, $column = false ) {
		if ( is_string( $column ) ) {
			return sprintf("`%s`.`%s`.`%s`", self::db, $table, $column );
		}
		else {
			return sprintf("`%s`.`%s`", self::db, $table );
		}
	}


	/**
	 * wrapper to database connection for connecting to the database
	 * containing the mappings of wiki to database.
	 *
	 * @access public
	 * @static
	 *
	 * @param integer $db Index of the connection to get. May be DB_MASTER for the
	 *                master (for write queries), DB_SLAVE for potentially lagged
	 *                read queries, or an integer >= 0 for a particular server.
	 *
	 * @return DatabaseBase object
	 */
	static public function db( $db ) {
		global $wgExternalSharedDB;

		return wfGetDB( $db, [], $wgExternalSharedDB );
	}

	/**
	 * getDomains
	 *
	 * get all domains defined in wiki.factory (city_domains table) or
	 * all domains for given wiki identifier. Data from query is
	 * stored in memcache for an hour.
	 *
	 * @access public
	 * @static
	 *
	 * @param integer	$city_id	                wiki identified in city_list
	 * @param boolean	$master   default false	    use master db connection
	 *
	 * @return mixed: array of domains
	 *
	 * if city_id is null it will return empty array
	 */
	static public function getDomains( $city_id, $master = false ) {

		if ( ! static::isUsed() ) {
			WikiaLogger::instance()->error(
				"WikiFactory is not used.",
				[
					"exception" => new Exception()
				]
			);
			return false;
		}

		global $wgMemc;

 		wfProfileIn( __METHOD__ );

		$domains = [];
		if ( !empty( $city_id ) ) {
			/**
			 * skip cache if we want master
			 */
			$key = "wikifactory:domains_by_city_id:".$city_id;
			if ( ! $master ) {
				$domains = $wgMemc->get( $key );

				if ( is_array( $domains ) ) {
					wfProfileOut( __METHOD__ );
					return $domains;
				}
			}

			$dbr = ( $master ) ? static::db( DB_MASTER ) : static::db( DB_SLAVE );
			$oRes = $dbr->select(
				[ "city_domains" ],
				[ "*" ],
				[ "city_id" => $city_id ],
				__METHOD__
			);

			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$domains[] = strtolower( $oRow->city_domain );
			}
			$dbr->freeResult( $oRes );

			$SECONDS_IN_DAY = 60*60*24;
			$wgMemc->set( $key, $domains, $SECONDS_IN_DAY );
		}

		wfProfileOut( __METHOD__ );
		return $domains;
	}

	/**
	 * addDomain
	 *
	 * add domain to wiki.factory (city_domains table). Method checks if
	 * domain already exists in table
	 *
	 * @author eloy@wikia
	 * @access public
	 * @static
	 *
	 * @param integer  $city_id: wiki identifier in city_list
	 * @param string $domain: domain name
	 *
	 * @return boolean: true - added, false otherwise
	 */
	static public function addDomain( $city_id, $domain, $reason = '' ) {
		global $wgWikicitiesReadOnly;

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		/**
		 * domain should contain at least one dot
		 */
		if ( !strpos($domain, ".") ) {
			return false;
		}
		wfProfileIn( __METHOD__ );
		$dbw = static::db( DB_MASTER );
		$dbw->begin();

		/**
		 * check if $wiki exists
		 */
		$oRow = $dbw->selectRow(
			[ "city_list" ],
			[ "city_id " ],
			[ "city_id" => $city_id ],
			__METHOD__
		);
		if ( $oRow->city_id != $city_id ) {
			/**
			 * ... yes it exists
			 */
			wfProfileOut( __METHOD__ );
			$dbw->rollback();
			return false;
		}

		/**
		 * check if $domain exists
		 */
		$oRow = $dbw->selectRow(
			[ "city_domains" ],
			[ "city_domain " ],
			[ "city_domain" => strtolower( $domain ) ],
			__METHOD__
		);
		if ( !empty($oRow) && ( strtolower( $oRow->city_domain ) == strtolower( $domain ) ) ) {
			/**
			 * ... yes it exists
			 */
			wfProfileOut( __METHOD__ );
			$dbw->rollback();
			return false;
		}

		/**
		 * eventually insert
		 */
		$dbw->insert(
			"city_domains",
			[
				"city_domain" => strtolower( $domain ),
				"city_id" => $city_id
			],
			__METHOD__
		);

		$sLogMessage = "{$domain} added.";

		if ( !empty( $reason ) ) {
			$sLogMessage .= "(reason: {$reason})";
		}

		static::log( static::LOG_DOMAIN, htmlspecialchars( $sLogMessage ),  $city_id );
		$dbw->commit();

		/**
		 * clear cache
		 */
		static::clearDomainCache( $city_id );

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * removeDomain
	 *
	 * removes domain from city_domains table
	 *
	 * @author tor@wikia-inc.com
	 *
	 * @param integer $city_id: wiki identifier in city_list
	 * @param string $domain: domain name (on null)
	 *
	 * @return boolean: true - removed, false otherwise
	 */
	static public function removeDomain ( $city_id, $domain = null, $reason = null ) {
		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		wfProfileIn( __METHOD__ );
		$dbw = static::db( DB_MASTER );
		$dbw->begin();

		$cond = [ "city_id" => $city_id ];
		if ( !is_null($domain) ) {
			$cond["city_domain"] = $domain;
		}

		if ( ! $dbw->delete( "city_domains", $cond, __METHOD__ ) ) {
			$dbw->rollback();
			wfProfileOut( __METHOD__ );
			return false;
		}

		$sLogMessage = "{$domain} removed.";
		if ( !empty( $reason ) ) {
			$sLogMessage .= "(reason: {$reason})";
		}

		static::log( static::LOG_DOMAIN, htmlspecialchars( $sLogMessage ), $city_id );
		$dbw->commit();

		static::clearDomainCache( $city_id );

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * setmainDomain
	 *
	 * sets domain as main (wgServer)
	 *
	 * @param integer $city_id: wiki identifier in city_list
	 * @param string $domain: domain name (on null)
	 *
	 * @return boolean: true - set, false otherwise
	 * @throws WikiFactoryDuplicateDomain
	 */
	static public function setmainDomain ( $city_id, $domain = null, $reason = null ) {
		global $wgWikicitiesReadOnly;

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}
		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}
		if ( !preg_match( "/^https?:\/\//", $domain ) ) {
			$domain = 'http://' . $domain;
		}
		if ( !endsWith( $domain, '/' ) ) {
			$domain .= '/';
		}
		wfProfileIn( __METHOD__ );
		$dbw = static::db( DB_MASTER );
		$dbw->begin();
		WikiaLogger::instance()->info( __METHOD__ . " - city_url changed", [
			'exception' => new Exception(),
			'city_url' => $domain,
			'reason' => $reason ?: '',
		] );
		wfProfileIn( __METHOD__."-changelog" );
		$oldValue = self::cityIDtoUrl( $city_id );
		$reason_extra = !empty($reason) ? " (reason: ". htmlspecialchars( $reason ) .")" : '';
		static::log(
			static::LOG_DOMAIN,
			sprintf('Main domain changed from %s to %s %s',
				htmlspecialchars( $oldValue ),
				htmlspecialchars( $domain ),
				$reason_extra
			),
			$city_id
		);
		wfProfileOut( __METHOD__."-changelog" );

		try {
			$dbw->update(
				static::table("city_list"),
				[ "city_url" => $domain ],
				[ "city_id" => $city_id ],
				__METHOD__
			);
		} catch ( DBQueryError $e ) {
			if ( preg_match("/Duplicate entry '[^']*' for key 'urlidx'/", $e->error) ) {
				$res = $dbw->selectRow(
					static::table("city_list"),
					"city_id",
					[ "city_url" => $domain ],
					__METHOD__
				);
				if ( isset($res->city_id) ) {
					$exc = new WikiFactoryDuplicateDomain($city_id, $domain, $res->city_id);
					Wikia::log( __METHOD__, "", $exc->getMessage());
					$dbw->rollback();
					throw $exc;
				}
			}
			throw $e;
		}
		$dbw->commit();
		// Trigger WikiFactoryChanged for backward compatibility and CSRF protection
		Hooks::run( 'WikiFactoryChanged', [ 'wgServer' , $city_id, $domain ] );

		static::clearCache( $city_id );

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * UrlToID
	 *
	 * @access public
	 * @static
	 *
	 * @param $url string - domain name in form:
	 * - http://www.community-name.wikia.com
	 * - http://community-name.wikia.com
	 * - www.community-name.wikia.com
	 * - community-name.wikia.com
	 * - community-name
	 *
	 * @return integer - id of domain or null if not found
	 */
	static public function UrlToID( $url ) {
		$city_id = false;

		$url = static::prepareUrlToParse( $url );
		$parts = parse_url( $url );

		if ( isset( $parts[ "host" ] ) ) {
			$host = static::getDomainHash( $parts[ "host" ] );
			$host = wfNormalizeHost( $host );
			$city_id = static::DomainToId( $host );
		}

		return $city_id;
	}

	/**
	 * Convert url in form of:
	 * - www.community-name.wikia.com
	 * - community-name.wikia.com
	 * - community-name
	 * to full valid url: ( scheme + wikia.com host )
	 * See: testPrepareUrlToParse
	 *
	 * @param $url
	 * @return string
	 */
	static public function prepareUrlToParse( $url ) {
		global $wgWikiaBaseDomain, $wgWikiaOrgBaseDomain, $wgFandomBaseDomain;
		$httpPrefix = 'http://';

		if ( strpos( $url, $httpPrefix ) === false ) {
			$url = $httpPrefix . $url;
		}

		if ( strpos( $url, '.' . $wgWikiaBaseDomain ) === false &&
			 strpos( $url, '.' . $wgFandomBaseDomain ) === false &&
			 strpos( $url, '.' . $wgWikiaOrgBaseDomain ) === false
		) {
			$url = $url . '.' . $wgWikiaBaseDomain;
		}

		return $url;
	}

	/**
	 * DomainToID
	 *
	 * @access public
	 * @static
	 *
	 * @param $domain string - domain name
	 *
	 * @return integer - id of domain or null if not found
	 */
	static public function DomainToID( $domain ) {

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		wfProfileIn( __METHOD__ );
		$city_id = false;

		global $wgWikiFactoryCacheType;
		$oMemc = wfGetCache( $wgWikiFactoryCacheType );
		$domains = $oMemc->get( static::getDomainKey( $domain ) );

		if ( isset($domains["id"]) ) {
			// Success... have the city_id in memcached.
			$city_id = $domains["id"];
		} else {
			/**
			 * failure, getting from database
			 */
			$dbr = static::db( DB_SLAVE );
			$oRow = $dbr->selectRow(
				[ "city_domains" ],
				[ "city_id" ],
				[ "city_domain" => $domain ],
				__METHOD__
			);
			$city_id = is_object( $oRow ) ? $oRow->city_id : null;
		}

		wfProfileOut( __METHOD__ );
		return $city_id;
	}

	/**
	 * Returns a list of wikis hosted under a given domain.
	 *
	 * If used often, put a caching layer on top of it.
	 *
	 * @param string $domain wiki host (without the protocol nor path)
	 * @param bool $includeRoot should the English version be included in the results
	 * @return array list of wikis, each entry is a dict with 'city_id', 'city_url' and 'city_dbname' keys
	 */
	public static function getWikisUnderDomain( $domain, $includeRoot = false ) {
		$domain = wfNormalizeHost( $domain );
		$dbr = static::db( DB_SLAVE );

		return WikiaDataAccess::cache(
			wfSharedMemcKey( 'wikifactory:DomainWikis:v1', $domain, $includeRoot ),
			900,	// 15 minutes
			function () use ( $dbr, $domain, $includeRoot ) {
				$httpPattern = [ "http://{$domain}/" ];
				$httpsPattern = [ "https://{$domain}/" ];

				if ( !$includeRoot ) {
					array_push( $httpPattern, $dbr->anyChar() );
					array_push( $httpsPattern, $dbr->anyChar() );
				}

				array_push( $httpPattern, $dbr->anyString() );
				array_push( $httpsPattern, $dbr->anyString() );

				$where = [
					$dbr->makeList( [
						'city_url ' . $dbr->buildLike( $httpPattern ),
						'city_url ' . $dbr->buildLike( $httpsPattern ),
					], LIST_OR ),
					'city_public' => 1
				];

				$dbResult = $dbr->select(
					[ 'city_list' ],
					[ 'city_id', 'city_url', 'city_dbname', 'city_lang', 'city_title' ],
					$where,
					__METHOD__
				);

				$cities = [];
				while ( $row = $dbr->fetchObject( $dbResult ) ) {
					$cities[] = [
						'city_id' => $row->city_id,
						'city_url' => $row->city_url,
						'city_dbname' => $row->city_dbname,
						'city_lang' => $row->city_lang,
						'city_title' => $row->city_title,
					];
				}
				$dbr->freeResult( $dbResult );
				Hooks::run( 'GetWikisUnderDomain', [ $domain, $includeRoot, &$cities ] );

				// sort the wikis by their url, English wiki should come first
				usort( $cities, function( $a, $b ) { return strcasecmp( $a['city_url'], $b['city_url'] ); } );

				return $cities;
			}
		);
	}

	/**
	 * Returns a list of language wikis hosted under the current domain. This works only for wikis
	 * hosted at the root of the domain, for language path wikis it will return an empty list.
	 *
	 * @return array list of wikis, each entry is a dict with 'city_id', 'city_url' and 'city_dbname' keys
	 */
	public static function getLanguageWikis() {
		global $wgScriptPath, $wgServer;

		if ( $wgScriptPath !== '' ) {
			return [];
		}

		$url = parse_url( $wgServer );
		return self::getWikisUnderDomain( $url['host'], false );
	}

	/**
	 * Checks if a wiki is a non-existing domain root with language wikis underneath
	 *
	 * @param int|null $cityId
	 * @return bool
	 */
	public static function isLanguageWikisIndex( $cityId = null ) {
		global $wgCityId;

		if ( $cityId === null ) {
			$cityId = $wgCityId;
		}

		if ( $cityId == static::LANGUAGE_WIKIS_INDEX ) {
			return true;
		}
		return false;
	}

	/**
	 * Checks if a wiki should display the language wikis index
	 * It returns true in the following cases:
	 * - Wiki is languagewikisindex.fandom.com
	 * - Wiki is closed or disabled and there are language wikis using the same domain
	 *
	 * @param int|null $cityId
	 * @return bool
	 */
	public static function isLanguageWikisIndexOrClosed( $cityId = null ) {
		global $wgCityId;

		if ( $cityId === null ) {
			$cityId = $wgCityId;
		}

		if ( self::isLanguageWikisIndex( $cityId ) ) {
			return true;
		}

		if ( static::isPublic( $cityId ) ) {
			return false;
		}

		$wiki = static::getWikiByID( $cityId );
		$wikiHost = parse_url( $wiki->city_url, PHP_URL_HOST );

		return count( static::getWikisUnderDomain( $wikiHost, false ) ) > 0;
	}

	/**
	 * Strips the language path from city_url.
	 *
	 * @param string $cityUrl
	 *
	 * @return string
	 */
	public static function cityUrlToDomain( $cityUrl ) {
		$url = parse_url( $cityUrl );
		if ( FALSE === $url ) return FALSE;
		return ( ( isset( $url['scheme'] ) ) ? $url['scheme'] . '://' : '//' )
			. ( ( isset( $url['host'] ) ) ? $url['host'] : '' );
	}

	/**
	 * Returns the language path part of the city_url.
	 *
	 * @param string $cityUrl
	 *
	 * @return string
	 */
	public static function cityUrlToLanguagePath( $cityUrl ) {
		$url = parse_url( $cityUrl );
		if ( FALSE !== $url && !empty( $url['path'] ) && $url['path'] !== '/' ) {
			return rtrim( $url['path'], '/' );
		}
		return '';
	}

	/**
	 * Returns the script address relative to wiki domain.
	 *
	 * @param string $cityUrl
	 *
	 * @return string
	 */
	public static function cityUrlToWgScript( $cityUrl ) {
		return static::cityUrlToLanguagePath( $cityUrl ) . '/index.php';
	}

	/**
	 * Returns the article path relative to wiki domain.
	 * todo: Remove $cityId param after corporate wikis are moved to N&S
	 *
	 * @param string $cityUrl
	 * @param int $cityId
	 *
	 * @return string
	 */
	public static function cityUrlToArticlePath( $cityUrl, $cityId ) {
		$path = $cityId == Wikia::CORPORATE_WIKI_ID ? '/$1' : '/wiki/$1';
		return static::cityUrlToLanguagePath( $cityUrl ) . $path;
	}

	/**
	 * @param $varId
	 * @param $cityId
	 * @param $value
	 * @param null $reason
	 * @param bool $ignoreBlacklist=false
	 * @return bool
	 * @throws WikiFactoryVariableParseException
	 */
	static public function validateAndSetVarById( $varId, $cityId, $value, $reason = null, $ignoreBlacklist = false ) {
		global $wgWikicitiesReadOnly;

		if ( !static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		if ( empty( $varId ) || empty( $cityId ) ) {
			return false;
		}

		$variable = static::loadVariableFromDB( $varId, false, $cityId );

		if ( $variable ) {
			$wikiFactoryVariableParser = new WikiFactoryVariableParser( $variable->cv_variable_type );
			$value = $wikiFactoryVariableParser->transformValue( $value );

			return static::setVarById( $varId, $cityId, $value, $reason, $ignoreBlacklist );
		}

		return false;
	}

	/**
	 * isReadonlyBlacklisted
	 *
	 * Checks if the value is listed as read-only in blacklist
	 *
	 * Putting a variable name in the blacklist is going to prevent
	 * all the changes made to it via WikiFactory class.
	 *
	 * @param string cv_variable_id
	 * @return boolean
	 */
	static function isReadonlyBlacklisted( $cv_variable_id ) {
		global $wgWikiFactoryReadonlyBlacklist;

		return in_array( $cv_variable_id, $wgWikiFactoryReadonlyBlacklist, true );
	}

	/**
	 * setVarById
	 *
	 * used for saving new variable value, logging changes and update city_list
	 * values
	 *
	 * Note that this function will return false and not do any updates if
	 * wgWikicitiesReadOnly is true.
	 *
	 * @access public
	 * @author eloy@wikia
	 * @static
	 *
	 * @param integer $cv_variable_id variable id in city_variables_pool
	 * @param integer $city_id        wiki id in city list
	 * @param mixed $value            new value for variable
	 * @param string $reason          optional extra reason text
	 * @param boolean $ignoreBlacklist if the the blacklist check will be ignored
	 *
	 * @return boolean: transaction status
	 */
	static public function setVarById( $cv_variable_id, $city_id, $value, $reason=null, $ignoreBlacklist = false ) {
		global $wgWikicitiesReadOnly;

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		if ( empty( $cv_variable_id ) || empty( $city_id ) ) {
			return false;
		}

		if ( !$ignoreBlacklist && static::isReadonlyBlacklisted( $cv_variable_id ) ) {
			Wikia::log( __METHOD__, "", "Variable is marked as readonly in wgWikiFactoryReadonlyBlacklist");
			return false;
		}

		wfProfileIn( __METHOD__ );
		$dbw = static::db( DB_MASTER );
		$bStatus = true;

		$dbw->begin();
		try {

			/**
			 * use master connection for changing variables
			 */
			$variable = static::loadVariableFromDB( $cv_variable_id, false, $city_id, true );
			$oldValue = isset( $variable->cv_value ) ? $variable->cv_value :  false;

			/**
			 * delete old value
			 */
			$dbw->delete(
				"city_variables",
				[
					"cv_variable_id" => $cv_variable_id,
					"cv_city_id" => $city_id
				],
				__METHOD__
			);

			/**
			 * insert new one
			 */
			$dbw->insert(
				"city_variables",
				[
					"cv_variable_id" => $cv_variable_id,
					"cv_city_id"     => $city_id,
					"cv_value"       => serialize( $value )
				],
				__METHOD__
			);

			$valueExported = var_export( $value, true );
			$valueShortExcerpt = substr($valueExported, 0, 100) . (strlen($valueExported) > 100 ? ' ...' : '');
			$valueLongExcerpt = substr($valueExported, 0, 4000) . (strlen($valueExported) > 4000 ? ' ...' : '');
			$variableName = $variable ? $variable->cv_name : "(id: $cv_variable_id)";
			WikiaLogger::instance()->info( __METHOD__ . " - variable $variableName changed to: $valueShortExcerpt", [
				'exception' => new Exception(),
				'variable_id' => $cv_variable_id,
				'variable_name' => $variableName,
				'variable_value' => $valueLongExcerpt,
				'variable_value_len' => strlen($valueExported),
				'reason' => $reason ?: '',
			] );

			wfProfileIn( __METHOD__."-changelog" );

			# if reason was passed non-null, prepare a string for sprintf, else a zero-len string
			$reason_extra = !empty($reason) ? " (reason: ". (string)$reason .")" : '';


			$needPreformat = in_array( $variable->cv_variable_type, [ 'struct', 'array', 'hash', 'text' ] );


			if ( isset( $variable->cv_value ) ) {

				if ( !$needPreformat ) {
					$message = "Variable <strong>%s</strong> changed value from <strong>%s</strong> to <strong>%s</strong>%s";
				} else {
					$message = '<div>Variable <strong>%s</strong> changed value </div>' .
						'<div class="v1"><strong>Old value:</strong><pre>%s</pre></div> ' .
						'<div class="v2"><strong>New value:</strong><pre>%s</pre></div>' .
						'<div class="clear">%s</div></div>';
				}

				static::log(
					static::LOG_VARIABLE,
					sprintf($message,
						htmlspecialchars( $variable->cv_name ),
						htmlspecialchars( var_export( unserialize( $variable->cv_value, [ 'allowed_classes' => false ] ), true ) ),
						htmlspecialchars( var_export( $value, true ) ),
						htmlspecialchars( $reason_extra )
					),
					$city_id,
					$cv_variable_id
				);
			}
			else {

				if ( !$needPreformat ) {
					$message = 'Variable <strong>%s</strong> set value: <strong>%s</strong> %s';
				} else {
					$message = 'Variable <strong>%s</strong> set value: <pre>%s</pre> %s';
				}

				static::log(
					static::LOG_VARIABLE,
					sprintf($message,
						htmlspecialchars( $variable->cv_name ),
						htmlspecialchars( var_export( $value, true ) ),
						htmlspecialchars( $reason_extra )
					),
					$city_id,
					$cv_variable_id
				);
			}
			wfProfileOut( __METHOD__."-changelog" );

			/**
			 * check if variable is connected with city_list (for example
			 * city_language or city_url) and do some basic validation
			 */
			wfProfileIn( __METHOD__."-citylist" );
			Hooks::run( 'WikiFactoryChanged', [ $variable->cv_name , $city_id, $value ] );
			switch ( $variable->cv_name ) {
				case "wgLanguageCode":
					#--- city_lang
					$dbw->update(
						static::table("city_list"),
						[ "city_lang" => $value ],
						[ "city_id" => $city_id ],
						__METHOD__ );

				case "wgSitename":
					#--- city_title
					$dbw->update(
						static::table("city_list"),
						[ "city_title" => $value ],
						[ "city_id" => $city_id ],
						__METHOD__ );
					break;

				case 'wgMetaNamespace':
				case 'wgMetaNamespaceTalk':
					#--- these cannot contain spaces!
					if ( strpos($value, ' ') !== false ) {
						$value = str_replace(' ', '_', $value);
						$dbw->update(
							static::table('city_variables'),
							[ 'cv_value' => serialize($value) ],
							[
								'cv_city_id' => $city_id,
								'cv_variable_id' => $variable->cv_id
							],
							__METHOD__);
					}
					break;

			}
			wfProfileOut( __METHOD__."-citylist" );
			$dbw->commit();

			// clear wiki metadata
			static::clearCache( $city_id );

			// update the memcache entry for the variable, instead of deleting it from the cache
			// and forcing a SELECT query
			global $wgMemc;
			$variable->cv_value = serialize( $value );
			$wgMemc->set(  static::getVarValueKey( $city_id, $variable->cv_id ), $variable, WikiaResponse::CACHE_STANDARD );
		} catch ( DBQueryError $e ) {
			Wikia::log( __METHOD__, "", "Database error, cannot write variable." );
			$dbw->rollback();
			$bStatus = false;
		}

		wfProfileOut( __METHOD__ );
		return $bStatus;
	}


	/**
	 * removeVarByName
	 *
	 * handy wrapper for removeVarById
	 *
	 * @access public
	 * @author tor@wikia-inc.com
	 * @static
	 *
	 * @param string $variable: variable name in city_variables_pool
	 * @param integer $wiki: wiki id in city list
	 * @param string $reason: optional reason text
	 *
	 * @return boolean: transaction status
	 */
	static public function removeVarByName( $variable, $wiki, $reason=null ) {
		$oVariable = static::getVarByName( $variable, $wiki );
		return WikiFactory::removeVarById( $oVariable->cv_variable_id, $wiki, $reason );
	}


	/**
	 * removeVarById
	 *
	 * remove variable's value from DB
	 *
	 * @access public
	 * @author moli@wikia
	 * @static
	 *
	 * @param string $variable_id: variable id in city_variables_pool
	 * @param integer $wiki: wiki id in city list
	 * @param string $reason: optional reason text
	 *
	 * @throws DBQueryError|Exception
	 * @return boolean true on success, false on failure
	 */
	static public function removeVarById( $variable_id, $wiki, $reason=null ) {
		$bStatus = false;
		wfProfileIn( __METHOD__ );

		// SUS-1634 added per-cluster control of database read-only mode. It sets $wgReadOnly global variable
		// than affects read-only checks that take place before queries are made to other database clusters.
		// This ugly hack makes removing wgReadOnlyCluster value possible when it was used to put A cluster into read-only mode.
		global $wgReadOnly, $wgDBReadOnly;
		if ( $wgReadOnly === WikiFactoryLoader::PER_CLUSTER_READ_ONLY_MODE_REASON ) {
			$wgReadOnly = false;
			$wgDBReadOnly = false;
			wfDebug( __METHOD__ . " - removed read-only flag triggered by wgReadOnlyCluster variable\n" );
		}

		$variable = static::getVarById( $variable_id, $wiki );
		$dbw = static::db( DB_MASTER );
		$dbw->begin();
		try {
			if ( isset($variable_id) && isset($wiki) ) {
				$dbw->delete(
					"city_variables",
					array (
						"cv_variable_id" => $variable_id,
						"cv_city_id" => $wiki
					),
					__METHOD__
				);
				$reason2 = ( !empty($reason) ) ? " (reason: ". (string)$reason .")" : '';
				static::log(
					static::LOG_VARIABLE,
					sprintf("Variable %s removed%s",
						static::getVarById($variable_id, $wiki)->cv_name,
						$reason2),
					$wiki,
					$variable_id);
				$variableName = $variable ? $variable->cv_name : "(id: $variable_id)";
				WikiaLogger::instance()->info( __METHOD__ . " - variable $variableName removed", [
					'exception' => new Exception(),
					'variable_id' => $variable_id,
					'variable_name' => $variableName,
					'reason' => $reason ?: '',
				] );
				$dbw->commit();
				$bStatus = true;

				static::clearCache( $wiki );
				global $wgMemc;
				$wgMemc->delete( static::getVarValueKey( $wiki, $variable_id ) );

				Hooks::run( 'WikiFactoryVariableRemoved', [ $variable->cv_name , $wiki ] );
			}
		}
		catch ( DBQueryError $e ) {
			Wikia::log( __METHOD__, "", "Database error, cannot remove variable." );
			$dbw->rollback();
			$bStatus = false;
			throw $e;
		}
		wfProfileOut( __METHOD__ );
		return $bStatus;
	}

	/**
	 * setVarByName
	 *
	 * used for saving new variable value, logging changes and update city_list
	 * values
	 *
	 * @access public
	 * @author eloy@wikia
	 * @static
	 *
	 * @param string $variable: variable name in city_variables_pool
	 * @param integer $wiki: wiki id in city list
	 * @param mixed $value: new value for variable
	 * @param string $reason: optional reason text
	 *
	 * @return boolean: transaction status
	 */
	static public function setVarByName( $variable, $wiki, $value, $reason=null ) {
		$oVariable = static::getVarByName( $variable, $wiki );
		return WikiFactory::setVarByID( $oVariable->cv_variable_id, $wiki, $value, $reason );
	}

	/**
	 * getVarById
	 *
	 * get variable data using cv_id field
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
	 * @static
	 *
	 * @param integer $cv_id: variable id in city_variables_pool
	 * @param $city_id
	 * @param boolean $master: choose between master and slave connection
	 *
	 * @return mixed: variable data from from city_variables & city_variables_pool
	 */
	static public function getVarById( $cv_id, $city_id, $master = false ) {
		return static::loadVariableFromDB( $cv_id, false, $city_id, $master );
	}

	/**
	 * getVarByName
	 *
	 * get variable data using cv_id field
	 *
	 * @access public
	 * @author eloy@wikia
	 * @static
	 *
	 * @param string	$cv_name	variable name in city_variables_pool
	 * @param integer	$wiki		wiki id in city_list
	 * @param boolean	$master		choose between master & slave connection
	 *
	 * @return mixed 	variable data from from city_variables & city_variables_pool
	 */
	static public function getVarByName( $cv_name, $wiki, $master = false ) {
		return static::loadVariableFromDB( false, $cv_name, $wiki, $master );
	}

	/**
	 * getVarIdByName
	 *
	 * gets variable id using cv_name field
	 *
	 * @access public
	 * @static
	 *
	 * @param string	$cv_name	variable name in city_variables_pool
	 * @param boolean	$master		choose between master & slave connection
	 *
	 * @return mixed 	variable id or false if not found city_variables & city_variables_pool
	 */
	static public function getVarIdByName( $cv_name, $master = false ) {
		$varId = 0;
		$varData = static::loadVariableFromDB( false, $cv_name, false, $master );

		if ( $varData ) {
			$varId = (int) $varData->cv_id;
		}

		return ($varId > 0) ? $varId : false;
	}

	/**
	 * getVarValueByName
	 *
	 * return only value of variable not whole data for it, this value will be:
	 * - unserialized
	 * - all internal variables will be replaced by their values
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak (eloy)
	 * @static
	 *
	 * @param string	$cv_name	variable name in city_variables_pool
	 * @param mixed		$city_id	wiki id in city_list (or array of those)
	 * @param boolean	$master		choose between master & slave connection
	 * @param mixed		$default	value to return if no value set in WikiFactory for any city_id
	 *
	 * @return mixed value for variable or false otherwise
	 */
	static public function getVarValueByName( $cv_name, $city_id, $master = false, $default = false ) {
		// Don't hit memcache (or make DB query) when getting values for a current wiki (BAC-552)
		global $wgCityId;
		if ( $city_id == $wgCityId ) {
			return isset($GLOBALS[$cv_name]) ? $GLOBALS[$cv_name] : null;
		}

		wfProfileIn( __METHOD__ );

		if ( is_array( $city_id ) ) {
			$cityIds = $city_id;
		} else {
			$cityIds = [ $city_id ];
		}

		global $wgWikiFactoryCacheType;
		$oMemc = wfGetCache( $wgWikiFactoryCacheType );

		foreach ( $cityIds as $city_id ) {
			$value = null;

			// First read WF Cache for city_id -- maybe value is already stored in memcached?
			if ( !$master ) {
				$variables = $oMemc->get( static::getVarsKey( $city_id ) );
				$value = isset( $variables[ "data" ][ $cv_name ] )
					? static::substVariables( $variables[ "data" ][ $cv_name ], $city_id )
					: null;
			}

			// Then ask memcached or DB for specific var
			if ( is_null( $value ) ) {
				$variable = static::loadVariableFromDB( false, $cv_name, $city_id, $master );
				$value = isset( $variable->cv_value )
					? static::substVariables( unserialize( $variable->cv_value, [ 'allowed_classes' => false ] ), $city_id )
					: null;
			}

			// If we found the value return, else proceed to the next city_id
			if ( !is_null($value) ) {
				wfProfileOut( __METHOD__ );
				return $value;
			}
		}

		wfProfileOut( __METHOD__ );
		return $default;
	}

	/**
	 * substVariables
	 *
	 * method for resolving variable values uses in other variables
	 * i.e.
	 *	'$wgUploadPath/6/64/Favicon.ico'
	 * will be resolved to
	 *	'http://wikia.com/images/wikia/6/64/Favicon.ico'
	 *
	 * it's not recursive yet, maybe it should?
	 *
	 * @access public
	 * @author eloy@wikia-inc.com
	 * @static
	 */
	static public function substVariables( $cv_value, $city_id ) {
		/**
		 * if there's no $ there is nothing to work
		 */
		$value = $cv_value;
		if ( is_string( $cv_value ) && preg_match_all('/(\$\w+)/', $cv_value, $matches ) ) {
			if ( is_array( $matches ) ) {
				foreach ( $matches[ 1 ] as $idx => $key ) {
					if ( !is_numeric( ltrim( $key, '$' ) ) ) {
						/**
						 * get value for key
						 */
						$val = static::getVarValueByName( ltrim( $key, '$' ), $city_id );
						if ( $val ) {
							$value = str_replace( $key, $val, $value );
						}
					}
				}
			}
		}

		return $value;
	}

	/**
	 * DBtoID
	 *
	 * replaces wfWikiFactoryDBtoID
	 *
	 * @access public
	 * @author eloy@wikia
	 * @static
	 *
	 * @param string $city_dbname	name of database
	 * @param boolean $master	use master or slave connection
	 *
	 * @return integer The ID in city_list
	 */
	static public function DBtoID( $city_dbname, $master = false ) {

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		$oRow = static::getWikiByDB( $city_dbname, $master );

		return isset( $oRow->city_id ) ? $oRow->city_id : false;
	}

	/**
	 * IDtoDB
	 *
	 * return database name used by wikia
	 *
	 * @access public
	 * @author eloy@wikia
	 * @static
	 *
	 * @param string	$city_id	wiki id in city_list
	 * @param boolean $master	use master or slave connection
	 *
	 * @return string	database name from city_list
	 */
	static public function IDtoDB( $city_id, $master = false ) {

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		$oRow = static::getWikiByID( $city_id, $master );

		return isset( $oRow->city_dbname ) ? $oRow->city_dbname : false;
	}

	/**
	 * getLocalEnvURL
	 *
	 * return URL specific to current env:
	 * (production, preview, verify, devbox, sandbox)
	 * or forced one:
	 * (production, preview, verify)
	 *
	 * Handled server patterns
	 * en.wikiname.wikia.com
	 * wikiname.wikia.com
	 * (preview/verify/sandbox).en.wikiname.wikia.com
	 * (preview/verify/sandbox).wikiname.wikia.com
	 * en.wikiname.developer.wikia-dev.com
	 * wikiname.developer.wikia-dev.com
	 * @access public
	 * @author pbablok@wikia
	 * @static
	 *
	 * @param string $url general URL pointing to any server
	 * @return string url pointing to local env
	 * @throws \Exception
	 */
	static public function getLocalEnvURL( $url ) {
		global $wgWikiaBaseDomainRegex, $wgEnvironmentDomainMappings;

		// first - normalize URL
		$regexp = '/^(https?:)?\/\/([^\/]+)\/?(.*)?$/';
		if ( preg_match( $regexp, $url, $groups ) === 0 ||
		     preg_match( '/' . $wgWikiaBaseDomainRegex . '$/', $groups[2] ) === 0 ||
		     $groups[2] === 'fandom.wikia.com'
		) {
			// on fail at least return original url
			return $url;
		}
		$protocol = $groups[1];
		$server = $groups[2];
		$address = $groups[3];

		if ( !empty( $address ) ) {
			$address = '/' . $address;
		}

		$server = wfNormalizeHost( $server );

		$envSpecificDomainMap = array_flip( $wgEnvironmentDomainMappings );

		foreach ( $envSpecificDomainMap as $envAgnosticDomain => $envSpecificDomain ) {
			if ( endsWith( $server, ".$envAgnosticDomain" ) ) {
				$server = str_replace( ".$envAgnosticDomain", ".$envSpecificDomain", $server );
				break;
			}
		}

		return "$protocol//$server$address";
	}

	/**
	 * getWikiByID
	 *
	 * get wiki params from city_lists (shared database)
	 *
	 * @access public
	 * @author eloy@wiki
	 *
	 * @param integer $id: wiki id in city_list
	 * @param bool $master
	 * @return object|false: database row with wiki params
	 */
	static public function getWikiByID( int $id, $master = false ) {

		// SUS-2983 | do not make queries when provided city_id will not return any row
		if ( empty( $id ) ) {
			return false;
		}

		global $wgWikiFactoryCacheType;
		$oMemc = wfGetCache( $wgWikiFactoryCacheType );
		$memkey = static::getWikiaCacheKey( $id );
		$cached = ( empty($master) ) ? $oMemc->get( $memkey ) : null;
		if ( empty($cached) || !is_object( $cached ) ) {

			$dbr = static::db( ( $master ) ? DB_MASTER : DB_SLAVE );
			$oRow = $dbr->selectRow(
				[ "city_list" ],
				[ "*" ],
				[ "city_id" => $id ],
				__METHOD__
			);

			$oMemc->set($memkey, $oRow, 60*60*24);
		} else {
			$oRow = $cached;
		}

		return $oRow;
	}

	/**
	 * getWikisByID
	 *
	 * get multiple wikis params from city_list (shared database) in a single query
	 *
	 * @access public
	 * @static
	 * @author Michał Roszka (Mix) <michal@wikia-inc.com>
	 *
	 * @param array $ids an array containing IDs of wikis
	 * @param bool $master query master or slave
	 *
	 * @return array an array of objects, keys are wikis ids.
	 */
	static public function getWikisByID( array $ids, $master = false ) {
		if ( !static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		// do nothing if input is empty
		if ( empty( $ids ) ) {
			return [];
		}

		global $wgWikiFactoryCacheType;
		$oMemc = wfGetCache( $wgWikiFactoryCacheType );

		$aOut = [];

		// Retrieve cached data.
		foreach ( $ids as $k => $id ) {
			$sMemKey = static::getWikiaCacheKey( $id );
			$cached = ( empty( $master ) ) ? $oMemc->get( $sMemKey ) : null;
			if ( is_object( $cached ) ) {
				// append to the output
				$aOut[$id] = $cached;
				// remove from the list, we won't need to query the DB for it.
				unset( $ids[$k] );
			}
		}

		if ( empty( $ids ) ) {
			// if this is empty, then we have every thing we need from cache
			return $aOut;
		}

		// Query the DB for the data we don't have cached yet.
		$dbr = static::db( ( $master ) ? DB_MASTER : DB_SLAVE );
		$oRes = $dbr->select(
			[ "city_list" ],
			[ "*" ],
			[ "city_id" => $ids ],
			__METHOD__
		);

		while ( $oRow = $dbr->fetchObject( $oRes ) ) {
			// Cache single entries so other methods could use the cache
			$sMemKey = static::getWikiaCacheKey( $oRow->city_id );
			$oMemc->set( $sMemKey, $oRow, 60*60*24 );

			// append to the output
			$aOut[$oRow->city_id] = $oRow;
		}

		$dbr->freeResult( $oRes );
		return $aOut;
	}

	/**
	 * getWikiByDB
	 *
	 * @access public
	 * @author moli@wikia
	 * @static
	 *
	 * @param string $city_dbname	name of database
	 * @param boolean $master	use master or slave connection
	 *
	 * @return ResultWrapper|object The ID in city_list
	 */
	static public function getWikiByDB( $city_dbname, $master = false ) {

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		global $wgWikiFactoryCacheType;
		$oMemc = wfGetCache( $wgWikiFactoryCacheType );
		$memkey = static::getWikiaDBCacheKey( $city_dbname );
		$cached = ( empty($master) ) ? $oMemc->get( $memkey ) : null;
		if ( empty($cached) || !is_object( $cached ) ) {

			$dbr = static::db( ( $master ) ? DB_MASTER : DB_SLAVE );
			$oRow = $dbr->selectRow(
				[ "city_list" ],
				[ "*" ],
				[ "city_dbname" => $city_dbname ],
				__METHOD__
			);

			$oMemc->set($memkey, $oRow, 60*60*24);
		} else {
			$oRow = $cached;
		}

		return $oRow;
	}

	/**
	 * getDomainHash
	 *
	 * create key for domain, strip www if it's in address
	 *
	 * @access public
	 * @author eloy@wikia-inc.com
	 * @static
	 *
	 * @param string  $domain	domain name
	 *
	 * @return string with normalized domain
	 */
	public static function getDomainHash( $domain ) {

		$domain = strtolower( $domain );
		if ( substr($domain, 0, 4) === "www." ) {
			/**
			 * cut off www. part
			 */
			$domain = substr($domain, 4, strlen($domain) - 4 );
		}

		return $domain;
	}

	/**
	 * fetch
	 *
	 * simple caching, get serialized variable from file
	 *
	 * @access public
	 * @author eloy@wikia-inc.com
	 * @static
	 *
	 * @param string $file: file name with stored information
	 * @param string $timestamp: timestamp of last change
	 *
	 * @return unserialized structure
	 */
	public static function fetch( $file, $timestamp = null ) {
		if ( !file_exists($file) ) {
			return false;
		}

		set_error_handler( 'WikiFactory::unserializeHandler' );
		$_variable_key = "";
		$_variable_value = "";
		$data = unserialize( file_get_contents( $file ) );
		restore_error_handler();

		if ( !$data ) {
			#--- If unserializing somehow didn't work, we delete the file
			Wikia::log( __METHOD__, "", "Could not unserialize data from {$file}!" );;
			@unlink($file);
			return false;
		}

		/**
		 * check with change timestamp and with ttl stored in file
		 */
		$now = time();
		$host = isset( $_SERVER['SERVER_NAME'] ) ? $_SERVER['SERVER_NAME'] : "unknown";
		if ( ( $now > $data[0] ) || ( !is_null($timestamp) && $timestamp != $data[1] ) ) {
			/**
			 * Unlinking when the file was expired
			 */
			$cond1 = ( $now > $data[0] ) ? "y" : "n";
			$cond2 = ( $timestamp != $data[1] ) ? "y" : "n";
			@unlink($file);
			return false;
		}

		return $data[2];
	}

	/**
	 * store
	 *
	 * @access public
	 * @author eloy@wikia-inc.com
	 * @static
	 *
	 * simple caching, store serialized variable in file
	 *
	 * @param string $file: file name with stored information
	 * @param mixed $data: structure we want to store
	 * @param integer $ttl: time to live (expiration time)
	 * @param string $timestamp: timestamp of last change
	 *
	 * @return boolean status: true = success, false = failure
	 */
	public static function store( $file, $data, $ttl, $timestamp = null ) {
		global $wgCommandLineMode;

		if ( $wgCommandLineMode ) {
			return false;
		}

		if ( !file_exists( dirname( $file ) ) ) {
			wfMkdirParents( dirname( $file ) );
		}

		/**
		 * Serializing along with the TTL
		 */
		$data = serialize( [ time() + $ttl, $timestamp, $data ] );
		if ( file_put_contents( $file, $data, LOCK_EX ) === false ) {
			Wikia::log( __METHOD__, "", "Could not write to file {$file}" );
			return false;
		}
		return true;
	}

	/**
	 * getVarsKey
	 *
	 * get memcached key for given wiki id
	 *
	 * @access public
	 * @author eloy@wikia
	 * @static
	 *
	 * @param $city_id: wiki id in city list
	 *
	 * @return string - variables key for memcached
	 */
	static public function getVarsKey( $city_id ) {
		if ( empty( $city_id ) ) {
			return "wikifactory:variables:v5:0";
		}
		else {
			return "wikifactory:variables:v5:{$city_id}";
		}
	}

	/**
	 * Get memcache key for given WF variable metadata
	 *
	 * @param string $id can be either "id:<var id>" or "name:<var name>"
	 * @return string formatted memcache key
	 */
	static protected function getVarMetadataKey( $id ) {
		return wfSharedMemcKey( 'wikifactory:variables:metadata:v5', $id );
	}

	/**
	 * Get memcache key for given WF variable data
	 *
	 * @param int $city_id wiki ID
	 * @param int $var_id variable ID
	 * @return string formatted memcache key
	 */
	static protected function getVarValueKey( $city_id, $var_id ) {
		return wfSharedMemcKey( 'wikifactory:variables:value:v5', $city_id, $var_id );
	}

	/**
	 * getDomainKey
	 *
	 * get memcached key for domain info
	 *
	 * @author eloy@wikia
	 * @access public
	 * @static
	 *
	 * @param string  $domain       wiki domain-name
	 *
	 * @return string memcached key for where the info will be cached for the given city_id
	 */
	static public function getDomainKey( $domain ) {
		$domainHash = static::getDomainHash($domain);
		return "wikifactory:domains:by_domain_hash:{$domainHash}:v3";
	}

	/**
	 * clearCache
	 *
	 * clear memcached key for city
	 *
	 * @author eloy@wikia
	 * @access public
	 * @static
	 *
	 * @param integer $city_id: wiki id in city_list
	 *
	 * @return boolean status
	 */
	static public function clearCache( $city_id ) {
		global $wgWikicitiesReadOnly;

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if ( ! is_numeric( $city_id ) ) {
			return false;
		}

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
		}
		else {
			/**
			 * increase number in city_list
			 */
			$dbw = static::db( DB_MASTER );
			$dbw->update(
				"city_list",
				[ "city_factory_timestamp" => wfTimestampNow() ],
				[ "city_id" => $city_id ],
				__METHOD__
			);
		}

		global $wgMemc;

		/**
		 * clear domains cache
		 */
		static::clearDomainCache( $city_id );

		/**
		 * clear variables cache
		 */
		$wgMemc->delete( "WikiFactory::getCategory:" . $city_id ); //ugly cat clearing (fb#9937)
		$wgMemc->delete( static::getVarsKey( $city_id ) );

		$city_dbname = static::IDtoDB( $city_id );
		$wgMemc->delete( static::getWikiaCacheKey( $city_id ) );
		if ( !empty( $city_dbname ) ) {
			$wgMemc->delete( static::getWikiaDBCacheKey( $city_dbname ) );
		}

		return true;
	}

	/**
	 * Given a city_id, removes the domain-data array from memcached.
	 * @param $city_id
	 */
	static public function clearDomainCache( $city_id ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$domains = static::getDomains( $city_id, true );
		if ( is_array( $domains ) ) {
			foreach ( $domains as $domain ) {
				$wgMemc->delete( static::getDomainKey( $domain ) );
				wfDebugLog( "wikifactory", __METHOD__ . ": Remove {$domain} from wikifactory cache.\n", true );
			}
		}

		wfProfileOut( __METHOD__ );
	} // end clearDomainCache()

	/**
	 * getGroups
	 *
	 * get groups for variables, return only non-empty groups
	 *
	 * @static
	 * @access public
	 * @author eloy@wikia
	 *
	 * @return mixed: array with groups
	 */
	static public function getGroups() {

		if ( ! static::isUsed() ) {
			wfDebugLog( "wikifactory", __METHOD__ . ": WikiFactory is not used.\n", true );
			return [];
		}

		$groups = [];

		$dbr = static::db( DB_MASTER );

		$oRes = $dbr->select(
			[ "city_variables_groups" ], /*from*/
			[ "cv_group_id", "cv_group_name" ], /*what*/
			[ "cv_group_id in (select cv_variable_group from city_variables_pool)" ], /*where*/
			__METHOD__
		);

		while ( $oRow = $dbr->fetchObject( $oRes ) ) {
			$groups[$oRow->cv_group_id] = $oRow->cv_group_name;
		}
		$dbr->freeResult( $oRes );

		return $groups;
	}

	/**
	 * getVariables
	 *
	 * get all defined variables in city_variables_pool
	 *
	 * @static
	 * @access public
	 * @author eloy@wikia
	 *
	 * @param string $sort default 'cv_name': sorting order
	 * @param integer $wiki default 0: wiki identifier from city_list
	 * @param integer $group default 0: variable group
	 * @param boolean $defined default false: only with values in city_variables
	 * @param boolean $editable default false: only with cv_access_level > 1
	 * @param boolean $string	default false	only with $string in names
	 *
	 * @return mixed: array with variables
	 */
	static public function getVariables( $sort = "cv_name", $wiki = 0, $group = 0,
		$defined = false, $editable = false, $string = false ) {
		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}
		$dbr = static::db( DB_MASTER );

		$aVariables = [];
		$tables = [ "city_variables_pool", "city_variables_groups" ];
		$where = [ "cv_group_id = cv_variable_group" ];

		$aAllowedOrders = [
			"cv_id", "cv_name", "cv_variable_type",
			"cv_variable_group", "cv_access_level"
		];
		if ( !empty( $group ) ) {
			$where["cv_variable_group"] = $group;
		}

		if ( $editable === true ) {
			$where[] = "cv_access_level > 1";
		}

		if ( $string ) {
			$where[] = 'cv_name' . $dbr->buildLike( $dbr->anyString(), $string, $dbr->anyString() );
		}

		if ( $defined === true && $wiki != 0 ) {
			#--- add city_variables table
			$tables[] = "city_variables";
			#--- add join
			$where[] = "cv_variable_id = cv_id";
			$where[ "cv_city_id" ] = $wiki;
		}

		#--- now construct query

		$oRes = $dbr->select(
			$tables,
			[ "*" ],
			$where,
			__METHOD__,
			[ "ORDER BY" => $sort ]
		);

		while ( $oRow = $dbr->fetchObject($oRes) ) {
			$aVariables[] = $oRow;
		}
		$dbr->freeResult( $oRes );

		return $aVariables;
	}

	/**
	 * DomainToDB
	 *
	 * @access public
	 * @static
	 * @author Marooned
	 *
	 * @param $domain string - domain name
	 *
	 * @return integer - id in city_list or null on failure.
	 */
	static public function DomainToDB( $domain ) {
		$wikiID = static::DomainToID($domain);
		return is_null($wikiID) ? null : static::IDtoDB($wikiID);
	}

	/**
	* DBtoDomain
	*
	* @access public
	* @static
	* @author Sean Colombo
	*
	* @param $db string - database name
	*
	* @return string - a domain name for the wiki whose database was
	*                  passed in or null on failure.
	*/
	static public function DBtoDomain( $db ) {
		$wikiID = static::DBtoID($db);
		if ( is_null($wikiID) ) {
			$retVal = null;
		} else {
			$domains = static::getDomains($wikiID);
			if ( count($domains) == 0 ) {
				$retVal = null;
			} else {
				$retVal = array_shift($domains);
			}
		}
		return $retVal;
	}

	/**
	 * setPublicStatus
	 *
	 * method for changing city_public value in city_list table
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 * @access public
	 * @static
	 *
	 * @param integer $city_public    status in city_list
	 * @param integer $city_id        wikia identifier in city_list
	 *
	 * @param string $reason
	 * @param null $user
	 * @return string: HTML form
	 */
	static public function setPublicStatus(
		$city_public,
		$city_id,
		$reason = "",
		$user = null,
		$shouldUseMasterDbOnCheckFlags = false
	) {
		global $wgWikicitiesReadOnly;

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		if ( ( static::getFlags( $city_id, $shouldUseMasterDbOnCheckFlags ) & static::FLAG_PROTECTED ) && $city_public != 1 ) {
			Wikia::log( __METHOD__, "", "Wiki is protected. Skipping update.");
			return false;
		}

		wfProfileIn( __METHOD__ );

		Hooks::run( 'WikiFactoryPublicStatusChange', [ &$city_public, &$city_id, $reason, $user ] );

		$update = [
			"city_public" => $city_public,
			"city_last_timestamp" => wfTimestamp( TS_DB ),
		];

		$sLogMessage = "Status of wiki changed to {$city_public}.";

		if ( !empty($reason) ) {
			$update["city_additional"] = $reason;
			$sLogMessage .= " (reason: {$reason})";
		}

		$dbw = static::db( DB_MASTER );
		$dbw->update(
			"city_list",
			$update,
			[ "city_id" => $city_id ],
			__METHOD__
		);

		static::log( static::LOG_STATUS, htmlspecialchars( $sLogMessage ), $city_id, null, $user );

		wfProfileOut( __METHOD__ );

		return $city_public;
	}

	/**
	 * getPublic
	 *
	 * method for getting city_public value in city_list table
	 *
	 * @author Andrzej 'nAndy' Lukaszewski <nandy@wikia-inc.com>
	 * @access private
	 * @static
	 *
	 * @param integer $city_id wikia identifier in city_list
	 *
	 * @return integer | boolean false if WikiFactory is not used; integer otherwise
	 */
	static private function getPublic( $city_id ) {
		if ( !static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		wfProfileIn( __METHOD__ );

		$oWikia = static::getWikiByID( $city_id );

		$city_public = ( isset( $oWikia->city_id ) ) ? $oWikia->city_public : 0;

		wfProfileOut( __METHOD__ );

		return intval($city_public);
	}

	/**
	 * getCityPath
	 *
	 * Method for getting city_path value from city_list table
	 *
	 * @access private
	 * @static
	 *
	 * @param integer $city_id
	 *
	 * @return string | bool
	 */
	static private function getCityPath( $city_id ) {
		if ( !static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}
		return static::getWikiByID( $city_id )->city_path;
	}

	/**
	 * @brief Returns true if wiki is public ("probably" its database exists)
	 *
	 * @desc Returns true if wiki is public which should mean its database exists.
	 * However we noticed one case when wiki was public and its database doesn't exist.
	 * If this case wasn't singular we'll be having to create maintance script which
	 * will check wikis' databases and set right value to city_public field in DB.
	 *
	 * @author Andrzej 'nAndy' Lukaszewski <nandy@wikia-inc.com>
	 * @access public
	 * @static
	 *
	 * @param integer $city_id wikia identifier in city_list
	 *
	 * @return boolean
	 */
	static public function isPublic( $city_id ) {
		if ( WikiFactory::getPublic($city_id) === 1 ) {
			return true;
		}

		return false;
	}

	/**
	 * disableWiki
	 *
	 * Disables wiki, users won't be able to access it,
	 * database and files are still in place
	 *
	 * @author wladek
	 * @static
	 *
	 * @param integer $wikiId wiki id
	 * @param integer $flags close flags
	 * @param string  $reason [optional] reason text
	 * @return string
	 */
	static public function disableWiki( $wikiId, $flags, $reason = '' ) {
		static::setFlags( $wikiId, $flags );
		$res = static::setPublicStatus( static::CLOSE_ACTION, $wikiId, $reason );
		static::clearCache( $wikiId );
		return $res;
	}

	/**
	 * loadVariableFromDB
	 *
	 * Read variable data from database in most efficient way. If you've found
	 * faster version - fix this one.
	 *
	 * @author eloy@wikia
	 * @access private
	 * @static
	 *
	 * @param integer $cv_id        variable id in city_variables_pool
	 * @param string $cv_name    variable name in city_variables_pool
	 * @param integer $city_id    wiki id in city_list
	 * @param boolean $master        use master or slave connection
	 *
	 * @return object|false
	 */
	static private function loadVariableFromDB( $cv_id, $cv_name, $city_id, $master = false ) {

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		/**
		 * $wiki could be empty, but we have to know which variable read
		 */
		if ( ! $cv_id && ! $cv_name ) {
			return false;
		}

		wfProfileIn( __METHOD__ );

		/**
		 * if both are defined cv_id has precedence
		 */
		if ( $cv_id ) {
			$condition = [ "cv_id" => $cv_id ];
			$cacheKey = "id:$cv_id";
		}
		else {
			$condition = [ "cv_name" => $cv_name ];
			$cacheKey = "name:$cv_name";
		}

		$dbr = ( $master ) ? static::db( DB_MASTER ) : static::db( DB_SLAVE );

		$caller = wfGetCallerClassMethod(__CLASS__);
		$fname = __METHOD__ . " (from {$caller})";

		if ( $master || !isset( static::$variablesCache[$cacheKey] ) ) {
			$oRow = WikiaDataAccess::cache(
				static::getVarMetadataKey( $cacheKey ),
				WikiaResponse::CACHE_STANDARD,
				function() use ( $dbr, $condition, $fname ) {
					$oRow = $dbr->selectRow(
						[ "city_variables_pool" ],
						[
							"cv_id",
							"cv_name",
							"cv_description",
							"cv_variable_type",
							"cv_variable_group",
							"cv_access_level",
							"cv_is_unique"
						],
						$condition,
						$fname
					);

					// log typos in calls to WikiFactory::loadVariableFromDB
					if ( !is_object( $oRow ) ) {
						WikiaLogger::instance()->error(__METHOD__. ' - variable not found', [
							'condition' => $condition,
							'exception' => new Exception()
						]);
					}

					return $oRow;
				},
				// always hit the database when $master set to true
				$master ? WikiaDataAccess::REFRESH_CACHE : WikiaDataAccess::USE_CACHE
			);

			static::$variablesCache[$cacheKey] = $oRow;
		}
		$oRow = static::$variablesCache[$cacheKey];
		if ( is_object( $oRow ) ) {
			$oRow = clone $oRow;
		}

		if ( !isset( $oRow->cv_id ) ) {
			/**
			 * variable doesn't exist
			 */
			wfProfileOut( __METHOD__ );
			return null;
		}

		$oVariableValue = WikiaDataAccess::cache(
			static::getVarValueKey( $city_id, $oRow->cv_id ),
			WikiaResponse::CACHE_STANDARD,
			function() use ($dbr, $oRow, $city_id, $fname) {
				$row = $dbr->selectRow(
					[ "city_variables" ],
					[
						"cv_city_id",
						"cv_variable_id",
						"cv_value"
					],
					[
						"cv_variable_id" => $oRow->cv_id,
						"cv_city_id" => $city_id
					],
					$fname
				);

				// SUS-4761 | variable is NOT set in database, still cache it
				if ( !isset( $row->cv_variable_id ) ) {
					$row = new stdClass();
					$row->cv_city_id = $city_id;
					$row->cv_variable_id = $oRow->cv_id;
					$row->cv_value = null;
				}

				return $row;
			}
		);

		// merge variable value with variable's metadata
		$oRow->cv_city_id = $oVariableValue->cv_city_id;
		$oRow->cv_variable_id = $oVariableValue->cv_variable_id;
		$oRow->cv_value = $oVariableValue->cv_value;

		wfProfileOut( __METHOD__ );
		return $oRow;
	}

	/**
	 * clearInterwikiCache
	 *
	 * clear the interwiki links for ALL languages in memcached.
	 *
	 * @author Piotr Molski <moli@wikia.com>
	 * @access public
	 * @static
	 *
	 * @return string: path to file or null if id is not a number
	 */
	static public function clearInterwikiCache() {
		global $wgLocalDatabases, $wgDBname;
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		if ( empty($wgLocalDatabases) ) {
			$wgLocalDatabases = [];
		}
		$wgLocalDatabases[] = $wgDBname;

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'interwiki', [ 'iw_prefix' ], false );
		$prefixes = [];
		$loop = 0;
		while ( $row = $dbr->fetchObject( $res ) ) {
			foreach ( $wgLocalDatabases as $db ) {
				$wgMemc->delete("$db:interwiki:" . $row->iw_prefix);
				$loop++;
			}
		}

		wfProfileOut( __METHOD__ );
		return $loop;
	}

	/**
	 * getTiedVariables
	 *
	 * return variables connected somehow to given variable. Used
	 * for displaying hints after saving variable ("you should edit these
	 * variables as well"), Ticket #3387. So far it uses hardcoded
	 * values.
	 *
	 * @todo Move hardcoded values to MediaWiki message.
	 *
	 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
	 * @access public
	 * @static
	 *
	 * @param string	$cv_name	variable name
	 *
	 * @return array: names of tied variables or false if nothing matched
	 */
	static public function getTiedVariables( $cv_name ) {
		$tied = [
			#"wgExtraNamespacesLocal|wgContentNamespaces|wgNamespacesWithSubpagesLocal|wgNamespacesToBeSearchedDefault"
		];
		foreach ( $tied as $group ) {
			$pattern = "/\b{$cv_name}\b/";
			if ( preg_match( $pattern, $group ) ) {
				return explode( "|", $group );
			}
		}

		return false;
	}


	/**
	 * log
	 *
	 * log information about changes in wiki factory system, very simple.
	 * Use city_list_log table in shared database.
	 *
	 * @access public
	 * @static
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 *
	 * @param integer $type    type of message, use constants from class
	 * @param string $msg    message to be logged
	 * @param bool|int $city_id default false    wiki id from city_list
	 *
	 * @param null $variable_id
	 * @param null $user
	 * @return boolean    status of insert operation
	 */
	static public function log( $type, $msg, $city_id = false, $variable_id = null, $user = null ) {
		global $wgUser, $wgCityId, $wgWikicitiesReadOnly;

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		$city_id = ( $city_id === false ) ? $wgCityId : $city_id;

		$dbw = static::db( DB_MASTER );
		return $dbw->insert(
			"city_list_log",
			[
				"cl_city_id" => $city_id,
				"cl_user_id" => ($user != null) ? $user->getId() : $wgUser->getId(),
				"cl_type" => $type,
				"cl_text" => $msg,
				"cl_var_id" => $variable_id,
			],
			__METHOD__
		);
	}

	/**
	 * VarValueToID
	 *
	 * Read variable data from database by value of this variable
	 *
	 * @author moli@wikia
	 * @access public
	 * @static
	 *
	 * @param string	$cv_value	variable value
	 *
	 *
	 * @return integer: city ID or null if not found
	 */
	static public function VarValueToID( $cv_value ) {

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return null;
		}

		/**
		 * $wiki could be empty, but we have to know which variable read
		 */
		if ( is_null( $cv_value ) ) {
			return null;
		}

		wfProfileIn( __METHOD__ );

		$dbr = static::db( DB_SLAVE );

		$oRow = $dbr->selectRow(
			[ "city_variables" ],
			[ "cv_city_id" ],
			[ "cv_value" => @serialize($cv_value) ],
			__METHOD__
		);

		wfProfileOut( __METHOD__ );
		return isset( $oRow->cv_city_id ) ? $oRow->cv_city_id : null;
	}


	/**
	 * redirectDomains
	 *
	 * move domains from one to other Wiki
	 *
	 * @author moli@wikia
	 * @access public
	 * @static
	 *
	 * @param integer	$city_id	source Wiki ID
	 * @param integer	$new_city_id	target Wiki ID
	 * @param array $skip_domains List of domains to be skipped from the process
	 *
	 *
	 * @return integer: city ID or null if not found
	 */
	static public function redirectDomains( $city_id, $new_city_id, $skip_domains = [] ) {
		global $wgExternalArchiveDB,$wgWikicitiesReadOnly;

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		wfProfileIn( __METHOD__ );
		$res = true;

		$domains = static::getDomains( $city_id, true );

		$dbw = static::db( DB_MASTER );

		$where_cond = [
				"city_id" => $city_id
		];

		if ( count($skip_domains) > 0 ) {
			$where_cond[] = "city_domain NOT IN (" .$dbw->makeList( $skip_domains ) . ")";
		}

		$dbw->begin();
		$db = $dbw->update(
			static::table("city_domains"),
			[ "city_id" => $new_city_id ],
			$where_cond,
			__METHOD__ );
		if ( $db ) {
			$dbw->commit();
		} else {
			$dbw->rollback();
			$res = false;
		}

		if ( $res !== false ) {
			if ( !empty($domains) ) {
				/**
				 * copy domains to archive
				 */
				$dba = wfGetDB( DB_MASTER, [], $wgExternalArchiveDB );
				foreach ( $domains as $domain ) {
					if ( !in_array( $domain, $skip_domains ) ) {
						$dba->insert(
							"city_domains",
							[
								"city_id"         => $city_id,
								"city_domain"     => $domain,
								"city_new_id"     => $new_city_id,
								"city_timestamp"  => wfTimestampNow()
							],
							__METHOD__
						);
					}
				}
			}
		}

		static::clearDomainCache( $city_id );
		static::clearDomainCache( $new_city_id );

		wfProfileOut( __METHOD__ );
		return $res;
	}

	/**
	 * isInArchive
	 *
	 * Checks if a given wiki is already in archive db
	 *
	 * @param integer $cityId Wiki ID
	 *
	 * @return bool
	 */
	static public function isInArchive( $city_id ) {
		global $wgExternalArchiveDB;

		$wiki = WikiFactory::getWikiByID( $city_id );
		if ( isset( $wiki->city_id ) ) {
			$dba = wfGetDB( DB_MASTER, [], $wgExternalArchiveDB );
			$sth = $dba->select(
				[ 'city_domains' ],
				[ '1' ],
				[ 'city_id' => $city_id ],
				__METHOD__
			);

			return $sth->numRows() > 0;
		}

		return false;
	}

	/**
	 * copyToArchive
	 *
	 * copy data from WikiFactory database to Archive database
	 *
	 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
	 * @access public
	 * @static
	 *
	 * @param integer	$city_id	source Wiki ID
	 * @return bool
	 */
	static public function copyToArchive( $city_id ) {
		global $wgExternalArchiveDB, $wgWikicitiesReadOnly;

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		wfProfileIn( __METHOD__ );
		/**
		 * do only on inactive wikis
		 */
		$wiki = WikiFactory::getWikiByID( $city_id );
		if ( isset( $wiki->city_id ) ) {

			$timestamp = wfTimestampNow();
			$dbw = static::db( DB_MASTER );
			$dba = wfGetDB( DB_MASTER, [], $wgExternalArchiveDB );

			$dba->begin( __METHOD__ );

			/**
			 * copy city_list to archive
			 */
			$dba->insert(
				"city_list",
				[
					"city_id"                => $wiki->city_id,
					"city_path"              => $wiki->city_path,
					"city_dbname"            => $wiki->city_dbname,
					"city_sitename"          => $wiki->city_sitename,
					"city_url"               => $wiki->city_url,
					"city_created"           => $wiki->city_created,
					"city_founding_user"     => $wiki->city_founding_user,
					"city_adult"             => $wiki->city_adult,
					"city_public"            => $wiki->city_public,
					"city_additional"        => $wiki->city_additional,
					"city_description"       => $wiki->city_description,
					"city_title"             => $wiki->city_title,
					"city_founding_email"    => $wiki->city_founding_email,
					"city_founding_ip_bin"   => inet_pton(inet_ntop($wiki->city_founding_ip_bin)),
					"city_lang"              => $wiki->city_lang,
					"city_special_config"    => $wiki->city_special_config,
					"city_umbrella"          => $wiki->city_umbrella,
					"city_ip"                => $wiki->city_ip,
					"city_google_analytics"  => $wiki->city_google_analytics,
					"city_google_search"     => $wiki->city_google_search,
					"city_google_maps"       => $wiki->city_google_maps,
					"city_indexed_rev"       => $wiki->city_indexed_rev,
					"city_lastdump_timestamp"=> $timestamp,
					"city_factory_timestamp" => $timestamp,
					"city_useshared"         => $wiki->city_useshared,
					"city_flags"			 => $wiki->city_flags,
					"city_cluster"			 => $wiki->city_cluster
				],
				__METHOD__,
				[ "IGNORE" ]
			);

			/**
			 * copy city_variables to archive
			 */
			$sth = $dbw->select(
				[ "city_variables" ],
				[ "cv_city_id", "cv_variable_id", "cv_value" ],
				[ "cv_city_id" => $city_id ],
				__METHOD__
			);
			while ( $row = $dbw->fetchObject( $sth ) ) {
				$dba->insert(
					"city_variables",
					[
						"cv_city_id"     => $row->cv_city_id,
						"cv_variable_id" => $row->cv_variable_id,
						"cv_value"       => $row->cv_value,
						"cv_timestamp"   => $timestamp
					],
					__METHOD__
				);
			}
			$dbw->freeResult( $sth );

			/**
			 * copy domains to archive
			 */
			$sth = $dbw->select(
				[ 'city_domains' ],
				[ '*' ],
				[ 'city_id' => $city_id ],
				__METHOD__
			);
			while ( $row = $dbw->fetchObject( $sth ) ) {
				$dba->insert(
					"city_domains",
					[
						"city_id"         => $row->city_id,
						"city_domain"     => $row->city_domain,
						"city_new_id"     => $row->city_id,
						"city_timestamp"  => $timestamp
					],
					__METHOD__
				);

				static::clearDomainCache( $row->city_id );
			}
			$dbw->freeResult( $sth );
			$dba->commit( __METHOD__ );
		}
		wfProfileOut( __METHOD__ );
	}


	/**
	 * prepareDBName
	 *
	 * check if database name is used, if it's used prepare another one
	 *
	 * @author Piotr Molski <moli@wikia-inc.com>
	 * @access public
	 * @static
	 *
	 * @param integer	$dbname		name of DB to check
	 * @deprecated
	 * @todo remove it, moved as private method in AWC
	 *
	 * @return string: fixed name of DB
	 */
	static public function prepareDBName( $dbname ) {
		wfProfileIn( __METHOD__ );

		$dbwf = static::db( DB_SLAVE );
		$dbr  = wfGetDB( DB_MASTER );

		#-- check city_list
		$exists = 1; $suffix = "";
		while ( $exists == 1 ) {
			$dbname = sprintf("%s%s", $dbname, $suffix);
			Wikia::log( __METHOD__, "", "Checking if database {$dbname} already exists in city_list" );
			$Row = $dbwf->selectRow(
				[ "city_list" ],
				[ "count(*) as count" ],
				[ "city_dbname" => $dbname ],
				__METHOD__
			);
			$exists = 0;
			if ( $Row->count > 0 ) {
				Wikia::log( __METHOD__, "", "Database {$dbname} exists in city_list!" );
				$exists = 1;
			} else {
				Wikia::log( __METHOD__, "", "Checking if database {$dbname} already exists in database" );
				$oRes = $dbr->query( sprintf( "show databases like '%s'", $dbname) );
				if ( $dbr->numRows( $oRes ) > 0 ) {
					Wikia::log( __METHOD__, "", "Database {$dbname} exists in database!" );
					$exists = 1;
				}
			}
			# add suffix
			if ( $exists == 1 ) {
				$suffix = rand(1,999);
			}
		}
		wfProfileOut( __METHOD__ );
		return $dbname;
	}

	/**
	 * resetFlags
	 *
	 * remove binary flags for city, value will be removed from existing flags
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 * @access public
	 * @static
	 *
	 * @param integer	$city_id		wikia identifier in city_list
	 * @param integer	$city_flags		binary flags
	 * @param boolean	$skip			skip logging
	 *
	 * @return boolean, usually true when success
	 */
	static public function resetFlags( $city_id, $city_flags, $skip=false, $reason = '' ) {
		global $wgWikicitiesReadOnly;

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "info", "WikiFactory is not used." );
			return false;
		}

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		wfProfileIn( __METHOD__ );

		$dbw = static::db( DB_MASTER );
		$dbw->update(
			"city_list",
			[ "city_flags = ( city_flags &~ {$city_flags} )" ],
			[ "city_id" => $city_id ],
			__METHOD__
		);
		if ( $skip) {
			Wikia::log( __METHOD__, "", "skip logging.");
		} else {
			if ( !empty( $reason ) ) {
				$reason = " (reason: {$reason})";
			}
			static::log( static::LOG_STATUS, htmlspecialchars( sprintf("Binary flags %s removed from city_flags.%s", decbin( $city_flags ), $reason ) ), $city_id );
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * setFlags
	 *
	 * set binary flags for city, value will be added to existed flags
	 *
	 * @author Piotr Molski <moli@wikia-inc.com>
	 * @access public
	 * @static
	 *
	 * @param integer	$city_id		wikia identifier in city_list
	 * @param integer	$city_flags		binary flags
	 * @param boolean	$skip			skip logging
	 * @param null 		$user
	 * @return boolean, usually true when success
	 */
	static public function setFlags( $city_id, $city_flags, $skip=false, $reason = '', $user = null
	) {
		global $wgWikicitiesReadOnly;

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "info", "WikiFactory is not used." );
			return false;
		}

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		wfProfileIn( __METHOD__ );

		$dbw = static::db( DB_MASTER );
		$dbw->update(
			"city_list",
			[ "city_flags = ( city_flags | {$city_flags} )" ],
			[ "city_id" => $city_id ],
			__METHOD__
		);

		if ( $skip) {
			Wikia::log( __METHOD__, "", "skip logging.");
		} else {
			if ( !empty( $reason ) ) {
				$reason = " (reason: {$reason})";
			}
			static::log( static::LOG_STATUS, htmlspecialchars( sprintf("Binary flags %s added to city_flags.%s", decbin( $city_flags ), $reason ) ), $city_id, null, $user );
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * getFlags
	 *
	 * get binary flags for city
	 *
	 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
	 * @access public
	 * @static
	 *
	 * @param integer	$city_id		wikia identifier in city_list
	 *
	 * @return flags
	 */
	static public function getFlags( $city_id, $shouldUseMasterDb = false ) {
		if ( !static::isUsed() ) {
			Wikia::log( __METHOD__, 'info', 'WikiFactory is not used.' );
			return false;
		}

		wfProfileIn( __METHOD__ );

		$dbw = ( $shouldUseMasterDb ) ? static::db( DB_MASTER ) : static::db( DB_SLAVE );

		$city_flags = $dbw->selectField(
			'city_list',
			'city_flags',
			[ 'city_id' => $city_id ],
			__METHOD__
		);
		//reduce log spam in wikifactory logs
		//static::log( static::LOG_STATUS, sprintf('Binary flags %s read from city_flags', decbin( $city_flags ) ), $city_id );

		wfProfileOut( __METHOD__ );

		return $city_flags;
	}

	/**
	 * get legacy category/hub name and number for $city_id
	 *
	 * @param integer	$city_id		wikia identifier in city_list
	 *
	 * @return stdClass ($row->cat_id $row->cat_name) or 0
	 * @deprecated
	 */

	static public function getCategory ( int $city_id ) {
		// return deprecated category list
		$categories = self::getCategories( $city_id, true );
		return !empty($categories) ? $categories[0] : 0;
	}


	/**
	 * get new category id and name for $city_id
	 *
	 * @param int	$city_id		wikia identifier in city_list
	 * @param bool $deprecated
	 * @return array of stdClass ($row->cat_id $row->cat_name) or empty array
	 *
	 */
	static private function getCategories( int $city_id, $deprecated = false ) {
		global $wgRunningUnitTests, $wgNoDBUnits;

		$aCategories = [];

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return $aCategories;
		}

		if ($wgRunningUnitTests && $wgNoDBUnits) {
			return $aCategories;
		}

		// Default query using this function is to get all the new/active categories
		$aFilter = "city_cats.cat_active = 1";
		$aOptions = [];

		if ( $deprecated ) {
			$aFilter = "city_cats.cat_deprecated = 1";
			$aOptions = array ("LIMIT" => 1);
		}

		/**
		 * it is called in includes/wikia/Extensions.php and wgMemc is not initialized there
		 */
		global $wgWikiFactoryCacheType;
		$oMemc = wfGetCache( $wgWikiFactoryCacheType );
		$memkey = sprintf("%s:%d", __METHOD__, intval($city_id));
		$cached = $oMemc->get($memkey);

		if ( !is_array($cached) ) {
			$dbr = static::db( DB_SLAVE );

			$oRes = $dbr->select(
				[ "city_cat_mapping", "city_cats" ],
				[ "city_cats.cat_id as cat_id", "city_cats.cat_name as cat_name" ],
				[
					"city_id" => $city_id,
					"city_cats.cat_id = city_cat_mapping.cat_id",
					$aFilter
				],
				__METHOD__,
				$aOptions
			);

			$aCategories = [];
			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$aCategories[] = $oRow;
			}
			$oMemc->set( $memkey, $aCategories, WikiaResponse::CACHE_LONG );
		} else {
			$aCategories = $cached;
		}

		return $aCategories;
	}

	/**
	 * MultipleVarsToID
	 *
	 * Find city_id matching one or more name+val config variables
	 *
	 * @author Nef
	 * @access public
	 * @static
	 *
	 * @param array	$data	table of name+val config variables
	 *
	 *
	 * @return integer: city ID or null if not found
	 */
	static public function MultipleVarsToID( $data ) {

		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return null;
		}

		if ( !is_array( $data ) ) {
			return null;
		}

		$i = 0;
		$tables = [];
		$where = [];
		foreach ( $data as $key => $val ) {
			$i++;
			$tables[] = "city_variables AS cv{$i}";

			$where[] = "cv1.cv_city_id = cv{$i}.cv_city_id";
			$where["cv{$i}.cv_variable_id"] = static::getVarByName($key, static::COMMUNITY_CENTRAL)->cv_variable_id;
			$where["cv{$i}.cv_value"] = @serialize($val);
		}

		if ( !$i ) {
			return null;
		}

		wfProfileIn( __METHOD__ );

		$dbr = static::db( DB_SLAVE );

		$oRow = $dbr->selectRow(
			$tables,
			[ "cv1.cv_city_id" ],
			$where,
			__METHOD__
		);

		wfProfileOut( __METHOD__ );
		return isset( $oRow->cv_city_id ) ? $oRow->cv_city_id : null;
	}

	/**
	 * Introduces a new variable to be managed by WikiFactory.
	 *
	 * @author Sean Colombo
	 * @access public
	 * @static
	 *
	 * @param string $cv_name - name of the variable.
	 * @param $cv_variable_type - type of the variable, must be one of the values in WikiFactory::types.
	 * @param int $cv_access_level - key from the WikiFactory::$levels array representing the access-level.
	 * @param $cv_variable_group - the cv_group_id of the group this variable belongs in from the city_variables_groups table.
	 * @param string $cv_description - human-readable description of what the variable is used for.  If this is an empty
	 *                                string, then "(unknown)" will be substituted.
	 * @param bool $cv_is_unique
	 * @throws DBQueryError|Exception
	 * @return boolean true on success, false on failure
	 */
	static public function createVariable( $cv_name, $cv_variable_type, $cv_access_level, $cv_variable_group, $cv_description, $cv_is_unique = false ) {
		$bStatus = false;
		wfProfileIn( __METHOD__ );
		$dbw = static::db( DB_MASTER );

		// Follow the convention already started in the database of putting "(unknown)" for non-descriptions.
		if ( $cv_description == "" ) {
			$cv_description = "(unknown)";
		}

		$cv_name = htmlspecialchars( trim( trim( $cv_name ), '$' ) );
		$cv_variable_group = trim($cv_variable_group);
		$dbw->begin();
		try {
			// Don't re-check validity of variables, they are a precondition.  Do the queries here.
			$dbw->insert(
				"city_variables_pool",
				[
					"cv_name" => $cv_name,
					"cv_variable_type" => $cv_variable_type,
					"cv_access_level" => $cv_access_level,
					"cv_variable_group" => $cv_variable_group,
					"cv_description" => $cv_description,
					"cv_is_unique" => $cv_is_unique
				],
				__METHOD__
			);
			static::log(static::LOG_VARIABLE, "Variable \"$cv_name\" created");
			$dbw->commit();
			$bStatus = true;
		} catch ( DBQueryError $e ) {
			Wikia::log( __METHOD__, "", "Database error, cannot create WikiFactory variable." );
			$dbw->rollback();
			$bStatus = false;
			throw $e;
		}

		wfProfileOut( __METHOD__ );
		return $bStatus;
	} // end createVariable()

	/**
	 * Modifies the properties of a variable managed by WikiFactory.  This does
	 * not change the VALUE of that variable on wikis.
	 *
	 * @author Sean Colombo
	 * @access public
	 * @static
	 *
	 * @param int $cv_variable_id - the id of the variable to change.
	 * @param string $cv_name - new name of the variable.
	 * @param string $cv_variable_type - CURRENTLY IGNORED!  Doesn't seem like a good idea to have this value be changable.
	 * @param int $cv_access_level  - key from the WikiFactory::$levels array representing the new access-level.
	 * @param int $cv_variable_group - the new cv_group_id of the group this variable belongs in from the city_variables_groups table.
	 * @param string $cv_description - new human-readable description of what the variable is used for.  If this is an empty
	 *                                string, then "(unknown)" will be substituted.
	 *
	 * @throws DBQueryError|Exception
	 * @return boolean true on success, false on failure
	 */
	static public function changeVariable( $cv_variable_id, $cv_name, $cv_variable_type, $cv_access_level, $cv_variable_group, $cv_description ) {
		$bStatus = false;
		wfProfileIn( __METHOD__ );
		$dbw = static::db( DB_MASTER );

		// Follow the convention already started in the database of putting "(unknown)" for non-descriptions.
		if ( $cv_description == "" ) {
			$cv_description = "(unknown)";
		}

		$cv_name = htmlspecialchars( trim( $cv_name ) );
		$cv_variable_group = trim($cv_variable_group);
		$dbw->begin();
		try {
			// Don't re-check validity of variables, they are a precondition.  Do the queries here.
			$dbw->update(
				"city_variables_pool",
				[
					"cv_name" => $cv_name,
					//"cv_variable_type" => $cv_variable_type // Currently seems dangerous
					"cv_access_level" => $cv_access_level,
					"cv_variable_group" => $cv_variable_group,
					"cv_description" => $cv_description
				],
				[ "cv_id" => $cv_variable_id ],
				__METHOD__
			);
			static::log(static::LOG_VARIABLE, "Variable id $cv_variable_id (now called \"$cv_name\") changed");
			$dbw->commit();
			$bStatus = true;
		} catch ( DBQueryError $e ) {
			Wikia::log( __METHOD__, "", "Database error, cannot modify properties of WikiFactory variable $cv_variable_id (when setting name \"$cv_name\")." );
			$dbw->rollback();
			$bStatus = false;
			throw $e;
		}

		global $wgMemc;
		$wgMemc->delete( static::getVarMetadataKey( 'id:' . $cv_variable_id ) );

		wfProfileOut( __METHOD__ );
		return $bStatus;
	} // end createVariable()

	/**
	 * updateCityDescription
	 *
	 * static method called as hook
	 *
	 * @static
	 * @access public
	 *
	 * @param WikiPage $article
	 * @param $user
	 * @return bool
	 */
	static public function updateCityDescription( WikiPage $article, User $user ): bool {
		global $wgCityId;

		if ( strtolower($article->getTitle()) == "mediawiki:description" ) {
			$out = trim( strip_tags( wfMsg('description') ) );
			$db = WikiFactory::db( DB_MASTER );
			$db->update(
				"city_list",
				[ "city_description" => $out ],
				[ "city_id" => $wgCityId ],
				__METHOD__
			);
		}

		return true;
	}

	/**
	 * LangCodeToId
	 *
	 * replaces wfWikiFactoryDBtoID
	 *
	 * @access public
	 * @author moli@wikia
	 * @static
	 *
	 * @param string $lang_code	language code ('en', 'de' ... )
	 *
	 * @return int|bool ID from city_lang table
	 */
	static public function LangCodeToId( $lang_code ) {
		if ( ! static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}
		global $wgMemc;
 		wfProfileIn( __METHOD__ );

		$lang_id = 0;
		if ( !empty( $lang_code ) ) {
			$key = sprintf( "wikifactory:languages" );
			$languages = $wgMemc->get( $key );

			if ( !isset( $languages[$lang_code] ) ) {
				$dbr = static::db( DB_SLAVE );
				$oRes = $dbr->select(
					[ "city_lang" ],
					[ "lang_id", "lang_code" ],
					false,
					__METHOD__
				);

				while ( $oRow = $dbr->fetchObject( $oRes ) ) {
					$languages[$oRow->lang_code] = intval($oRow->lang_id);
				}
				$dbr->freeResult( $oRes );

				$wgMemc->set( $key, $languages, 60 * 60 * 24 );
			}

			$lang_id = $languages[$lang_code];
		}

		wfProfileOut( __METHOD__ );

		return isset( $lang_id ) && $lang_id > 0 ? $lang_id : false;
	}

	/**
	 * getCityIDsFromVarValue
	 *
	 * Gets a list of city ID's from a variable id/value
	 *
	 * @access public
	 * @author nef@wikia-inc.com, federico@wikia-inc.com
	 * @static
	 *
	 * @param int $varID: the varjable ID as defined in the city_variables table
	 * @param mixed $val: the value to search for
	 * @param bool $cond: the SQL operator to use for matching the value, 'LIKE' and 'NOT LIKE' are accepted (% signs are added automatically), 'IS' and 'IS NOT' too
	 *
	 * @return array an array containing the list of city ID's matching the variable's value, an empty array if none matches
	 */
	static function getCityIDsFromVarValue( $varID, $val, $cond ) {

		wfProfileIn(__METHOD__);

		$varID = ( int ) $varID;
		$cond = strtoupper( str_replace( "'", null, trim( $cond ) ) );
		$aWhere = [
			'cv_variable_id' => $varID
		];

		$dbr = static::db( DB_SLAVE );

		if ( in_array( $cond, [ 'LIKE', 'NOT LIKE' ] ) ) {
			$aWhere[ ] = "cv_value " . str_replace( 'LIKE', '', $cond ) . $dbr->buildLike( $dbr->anyString(), serialize( $val ), $dbr->anyString() );
		} elseif ( $val === 'NULL' && in_array( $cond, [ 'IS', 'IS NOT' ] ) ) {
			$aWhere[ ] = "cv_value {$cond} NULL";
		} else {
			$aWhere[ ] = "cv_value {$cond} '" . serialize( $val ) . "'";
		}

		$oRes = $dbr->select(
			'city_variables',
			'cv_city_id',
			$aWhere,
			__METHOD__
		);

		$aWikis = [];

		while ( $oRow = $dbr->fetchObject( $oRes ) ) {
			$aWikis[] = (int) $oRow->cv_city_id;
		}

		$dbr->freeResult( $oRes );

		wfProfileOut(__METHOD__);

		return $aWikis;
	}

	/**
	 * getWikiaCacheKey
	 *
	 * get memcached key for Wiki ID
	 *
	 * @access public
	 * @author moli@wikia
	 * @static
	 *
	 * @param integer $city_id: wiki id in city list
	 *
	 * @return string - variables key for memcached
	 */
	static protected function getWikiaCacheKey( $city_id ) {
		return "wikifactory:wikia:v1:{$city_id}";
	}

	/**
	 * getWikiaDBCacheKey
	 *
	 * get memcached key for Wiki DB
	 *
	 * @access public
	 * @author moli@wikia
	 * @static
	 *
	 * @param String $city_dbname: wiki dbname in city list
	 *
	 * @return string - variables key for memcached
	 */
	static protected function getWikiaDBCacheKey( $city_dbname ) {
		return "wikifactory:wikia:db:v1:{$city_dbname}";
	}

	/**
	 * Gets a list of all secondary database clusters, i.e. wikicities_c1, etc.
	 */

	static public function getSecondaryClusters() {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$key = "wikifactory:clusters";
		$clusters = $wgMemc->get( $key );
		if ( !is_array( $clusters ) ) {

			$dbr = static::db( DB_SLAVE );
			$oRes = $dbr->select(
				[ "city_list" ],
				[ "city_cluster  as cluster" ],
				'',
				__METHOD__,
				[ "GROUP BY" => "city_cluster" ]
			);

			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$clusters[] = strtolower( $oRow->cluster );
			}
			$dbr->freeResult( $oRes );

			$wgMemc->set( $key, $clusters, 60*60*12 );
		}

		wfProfileOut( __METHOD__ );
		return $clusters;
	}

	/**
	 * fetching wiki list with selected variable set to $val
	 * @param int|string $varId
	 * @param string $type
	 * @param $selectedCond
	 * @param unknown_type $val
	 * @param string $likeVal
	 * @param null $offset
	 * @param null $limit
	 * @return array
	 */

	static public function getListOfWikisWithVar( $varId, $type, $selectedCond ,$val, $likeVal = '', $offset = null, $limit = null ) {
		global $wgExternalSharedDB;
		$dbr = wfGetDB(DB_SLAVE, [], $wgExternalSharedDB);

		$aWikis = [];
		$selectedVal = serialize($val);

		$aTables = [
			'city_variables',
			'city_list',
		];
		$aWhere = [ 'city_id = cv_city_id' ];

		$aOptions = [ 'ORDER BY' => 'city_title ASC' ];

                if ( isset( $limit ) ) {
                    $aOptions['LIMIT'] = $limit;
                }

                if ( isset( $offset ) ) {
                    $aOptions['OFFSET'] = $offset;
                }

		if ( $type == "full" ) {
			$aWhere[] = "cv_value " . $dbr->buildLike( $dbr->anyString(), $likeVal, $dbr->anyString() );
		} else {
			$aWhere[] = "cv_value $selectedCond '$selectedVal'";
		}

		$aWhere['cv_variable_id'] = $varId;


		$oRes = $dbr->select(
			$aTables,
			[ 'city_id', 'city_title', 'city_url', 'city_public', 'city_dbname', 'city_lang' ],
			$aWhere,
			__METHOD__,
			$aOptions
		);

		while ( $oRow = $dbr->fetchObject($oRes) ) {
			$aWikis[$oRow->city_id] = [
				'u' => $oRow->city_url,
				't' => $oRow->city_title,
				'p' => ( !empty($oRow->city_public) ? true : false ),
				'd' => $oRow->city_dbname,
				'l' => $oRow->city_lang
			];
		}
		$dbr->freeResult( $oRes );

		return $aWikis;
	}

	/**
	 * fetching a number of wikis with select variable set to $val
	 * @param integer $varId
	 * @param string $type
	 * @param $selectedCond
	 * @param mixed $val
	 * @param string $likeVal
	 * @return
	 */

	static public function getCountOfWikisWithVar( $varId, $type, $selectedCond ,$val, $likeVal = '' ) {
		global $wgExternalSharedDB;
		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		$selectedVal = serialize( $val );
		$aTables = [ 'city_variables', 'city_list' ];
		$aWhere = [
			'city_id = cv_city_id',
			'cv_variable_id' => $varId,
		];

		if ( 'full' == $type ) {
			$aWhere[] = "cv_value " . $dbr->buildLike( $dbr->anyString(), $likeVal, $dbr->anyString() );
		} else {
			$aWhere[] = "cv_value $selectedCond '$selectedVal'";
		}

		$oRow = $dbr->selectRow( $aTables, 'COUNT(1) AS cnt', $aWhere, __METHOD__ );
		return $oRow->cnt;
	}

	/**
	 * Checks if a wiki is "restricted", or "private" (i.e. users need to log in to read,
	 * e.g. communitycouncil.wikia.com)
	 *
	 * @param integer $wikiId The ID of the wiki to check
	 *
	 * @return boolean true if it's restricted, false otherwise
	 */
	static public function isWikiPrivate( $wikiId ) {
		wfProfileIn( __METHOD__ );

		//restricting a wiki is done by setting the "read" permission
		//to 0 (false) for the "*" group via a WF variable (source: Tor),
		//if the above will change in the future then this will stop working (duh),
		//we should probably introduce a WF flag to handle this case in a much more
		//clean and portable way
		$permissions =  static::getVarValueByName( 'wgGroupPermissionsLocal', $wikiId );
		$ret = false;

		if ( !empty( $permissions ) ) {
			$permissions = WikiFactoryLoader::parsePermissionsSettings( $permissions );
		}

		if (
			isset( $permissions['*'] ) &&
			is_array( $permissions['*'] ) &&
			isset( $permissions['*']['read'] ) &&
			$permissions['*']['read'] === false
		) {
			$ret = true;
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * get environment-ready url from dbname
	 * @param string $dbname	name of database
	 * @param boolean $master	use master or slave connection
	 * @return url in city_list with sandbox/devbox subdomain added if needed
	 */
	static public function DBtoUrl( $dbname, $master = false ) {
		if ( !static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		$oRow = static::getWikiByDB( $dbname, $master );

		return isset( $oRow->city_url ) ? WikiFactory::getLocalEnvURL( rtrim( $oRow->city_url, '/' ) ) : false;
	}

	/**
	 * get environment-ready url from city_id
	 * @param int $city_id	wiki id
	 * @param boolean $master	use master or slave connection
	 * @return string url in city_list with sandbox/devbox subdomain added if needed
	 */
	static public function cityIDtoUrl( $city_id, $master = false ) {
		if ( !static::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		$oRow = static::getWikiByID( $city_id, $master );

		return isset( $oRow->city_url ) ? WikiFactory::getLocalEnvURL( rtrim( $oRow->city_url, '/' ) ) : false;
	}

	/**
	 * Returns the domain address of a wiki.
	 *
	 * @param int $city_id	wiki id
	 * @param boolean $master	use master or slave connection
	 * @return string city domain
	 */
	static public function cityIDtoDomain( $city_id, $master = false ) {
		$url = static::cityIDtoUrl( $city_id, $master );
		if ( $url ) {
			$url = static::cityUrlToDomain( $url );
		}
		return $url;
	}

	/**
	 * Returns language path for a given wiki.
	 *
	 * @param int $cityId
	 * @param string $href
	 * @return string
	 */
	static public function cityIdToLanguagePath( $cityId ) {
		return static::cityUrlToLanguagePath( static::cityIDtoUrl( $cityId ) );
	}

	/**
	 * Renders community's value of given variable
	 *
	 * @access public
	 * @static
	 *
	 * @param string $name name of wg variable
	 * @param string $type type of variable ($variable->cv_variable_type)
	 *
	 * @return string
	 */
	static public function renderValueOnCommunity( $name, $type ) {
		global $preWFValues;

		$value = "";

		if( isset( $preWFValues[$name] ) ) {
			// was modified, spit out saved default
			$value = static::parseValue( $preWFValues[$name], $type );
		} elseif( isset( $GLOBALS[$name] ) ) {
			// was not modified, spit out actual value
			$value = static::parseValue( $GLOBALS[$name], $type );
		}
		return htmlspecialchars( $value );
	}

	/**
	 * Renders wg variable
	 *
	 * @access public
	 * @static
	 *
	 * @param object $variable parameter passed to variable.tmpl.php
	 *
	 * @return string
	 */
	static public function renderValue( $variable ) {
		if ( !isset( $variable->cv_value ) ) {
			return "";
		}

		return static::parseValue( unserialize( $variable->cv_value, [ 'allowed_classes' => false ] ), $variable->cv_variable_type );
	}

	/**
	 * Returns printable value based on type
	 *
	 * @access private
	 * @static
	 *
	 * @param mixed  $value
	 * @param string $type
	 *
	 * @return string
	 */
	static private function parseValue( $value, $type ) {
		if ( $type == "string" || $type == "text" || $type == "integer" ) {
			return htmlspecialchars( $value );
		} elseif ( $type == "array" || $type == "struct" || $type == "hash" ) {
			return json_encode( $value, JSON_PRETTY_PRINT );
		}

		return htmlspecialchars( var_export( $value, true ) );
	}

	/**
	 * Returns value of a given variable for all wikis
	 *
	 * @param $variableName String Name of variable to get
	 * @param $limit Int Limit of rows
	 * @param $afterWikiId Int get value for wikis with id greater than this value. Optional, used for pagination.
	 * @return array list of wiki ids and variable values
	 */
	static public function getVariableForAllWikis( $variableName, $limit, $afterWikiId = null ) {

		$db = static::db( DB_SLAVE );

		$variableId = static::getVarIdByName( $variableName );
		$where = [ 'cv_variable_id = '.$variableId ];
		if ( isset( $afterWikiId ) ) {
			array_push( $where, 'cv_city_id > '.$afterWikiId );
		}
		$dbResult = $db->select(
			[ 'city_variables' ],
			[ 'cv_city_id', 'cv_value' ],
			$where,
			__METHOD__,
			[
				'ORDER BY' => 'cv_city_id',
				'LIMIT' => $limit
			]
		);

		$result = [];
		while ($row = $db->fetchObject( $dbResult ) ) {
			$result[] = [
				'city_id' => $row->cv_city_id,
				'value' => unserialize( $row->cv_value, [ 'allowed_classes' => false ] ) ];
		}
		$db->freeResult( $dbResult );
		return $result;
	}

        /**
         * unserializeErrorHandler
         *
         * @author Emil Podlaszewski <emil@wikia-inc.com>
         */
        static public function unserializeHandler( $errno, $errstr ) {
                global $_variable_key, $_variable_value;
                WikiaLogger::instance()->error(
                        'WikiFactory unserialize error',
                        [
                            'variable_key' => $_variable_key,
                            'variable_value' => $_variable_value,
                            'errno' => $errno,
                            'errstr' => $errstr
                        ]
                );
        }

	public static function clearVariablesCache() {
		static::$variablesCache = [];
	}

	/**
	 * Returns true if a given city path is equal to static::SLOT_2
	 *
	 * @access public
	 * @static
	 *
	 * @param string $city_path
	 *
	 * @return boolean
	 */
	static public function isUCPPath( $city_path ) {
		return $city_path === static::SLOT_2;
	}

	/**
	 * Returns true for UCP wikis
	 *
	 * @access public
	 * @static
	 *
	 * @param integer $city_id
	 *
	 * @return boolean
	 */
	static public function isUCPWiki( $city_id ) {
		return self::isUCPPath( self::getCityPath( $city_id ) );
	}
}
