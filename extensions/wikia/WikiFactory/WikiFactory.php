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

if ( ! function_exists( "wfUnserializeHandler" ) ) {
	/**
	 * wfUnserializeErrorHandler
	 *
	 * @author Emil Podlaszewski <emil@wikia-inc.com>
	 */
	function wfUnserializeHandler( $errno, $errstr ) {
		global $_variable_key, $_variable_value;
		Wikia::log( __FUNCTION__, $_SERVER['SERVER_NAME'], "({$_variable_key}={$_variable_value}): {$errno}, {$errstr}" );
	}
}

/**
 * define hooks for WikiFactory here
 */
$wgHooks[ "ArticleSaveComplete" ][] = "WikiFactory::updateCityDescription";

class WikiFactoryDuplicateWgServer extends Exception {
	public $city_id, $city_url, $duplicate_city_id;

	function __construct( $city_id, $city_url, $duplicate_city_id ) {
		$message = "Cannot set wgServer for wiki $city_id to '$city_url' because it conflicts with wiki $duplicate_city_id";
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
	static public $DUMP_SERVERS = [
		'c1' => 'db2',
		'c2' => 'db-sb2'
	];

	# city_flags
	const FLAG_CREATE_DB_DUMP        = 1;
	const FLAG_CREATE_IMAGE_ARCHIVE  = 2;
	const FLAG_DELETE_DB_IMAGES      = 4;
	const FLAG_FREE_WIKI_URL         = 8;
	const FLAG_HIDE_DB_IMAGES        = 16;
	const FLAG_REDIRECT              = 32;
	const FLAG_ADOPTABLE             = 64;  //used by AutomaticWikiAdoption
	const FLAG_ADOPT_MAIL_FIRST      = 128; //used by AutomaticWikiAdoption
	const FLAG_ADOPT_MAIL_SECOND     = 256; //used by AutomaticWikiAdoption
	const FLAG_PROTECTED             = 512; //wiki cannot be closed

	const db            = "wikicities"; // @see $wgExternalSharedDB
	const DOMAINCACHE   = "/tmp/wikifactory/domains.ser";
	const CACHEDIR      = "/tmp/wikifactory/wikis";

	// Community Central's city_id in wikicities.city_list.
	const COMMUNITY_CENTRAL = 177;

	const PREFETCH_WIKI_METADATA = 1;
	const PREFETCH_VARIABLES = 2;
	const PREFETCH_ALL = 255;
	const PREFETCH_DEFAULT = self::PREFETCH_ALL;

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
	 * @return boolean	current value of self::$mIsUsed
	 */
	static public function isUsed( $flag = false ) {
		if ( $flag ) {
			self::$mIsUsed = (bool )$flag;
		}
		return self::$mIsUsed;
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
		global $wgExternalSharedDB;

		$database = !empty( $wgExternalSharedDB ) ? $wgExternalSharedDB : self::db;
		if ( $column ) {
			return sprintf("`%s`.`%s`.`%s`", $database, $table, $column );
		}
		else {
			return sprintf("`%s`.`%s`", $database, $table );
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

		if ( ! self::isUsed() ) {
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

			$dbr = ( $master ) ? self::db( DB_MASTER ) : self::db( DB_SLAVE );
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

		if ( ! self::isUsed() ) {
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
		$dbw = self::db( DB_MASTER );
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

		self::log( self::LOG_DOMAIN, $sLogMessage,  $city_id );
		$dbw->commit();

		/**
		 * clear cache
		 */
		self::clearDomainCache( $city_id );

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
		if ( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		wfProfileIn( __METHOD__ );
		$dbw = self::db( DB_MASTER );
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

		self::log( self::LOG_DOMAIN, $sLogMessage, $city_id );
		$dbw->commit();

		self::clearDomainCache( $city_id );

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
	 */
	static public function setmainDomain ( $city_id, $domain = null, $reason = null ) {
		if ( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if ( 'http://' != strpos($domain, 0, 7) ) {
			$domain = 'http://' . $domain;
		}

		$retVal = WikiFactory::setVarByName("wgServer", $city_id, $domain, $reason);

		self::clearDomainCache( $city_id );

		return $retVal;
	}

	/**
	 * UrlToID
	 *
	 * @access public
	 * @static
	 *
	 * @param $url string - domain name
	 *
	 * @return integer - id of domain or null if not found
	 */
	static public function UrlToID( $url ) {

		$city_id = false;
		$parts = parse_url( $url );
		if ( isset( $parts[ "host" ] ) ) {
			$host = self::getDomainHash( $parts[ "host" ] );

			// TODO: Eloy: Can this hack be removed?
			if ( $host === "memory-alpha.org" ) {
				/**
				 * for memory-alpha check first element of path
				 */
				$parts = explode( "/", $parts[ "path" ] );
				$host = sprintf( "%s.%s", $parts[ 1 ], $host );
				$city_id = self::DomainToId( $host );
			}
			else {
				$host = preg_replace('/^(?:preview\.|verify\.)/i', '', $host);
				$city_id = self::DomainToId( $host );
			}
		}

		return $city_id;
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

		if ( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		wfProfileIn( __METHOD__ );
		$city_id = false;

		global $wgWikiFactoryCacheType;
		$oMemc = wfGetCache( $wgWikiFactoryCacheType );
		$domains = $oMemc->get( self::getDomainKey( $domain ) );

		if ( isset($domains["id"]) ) {
			// Success... have the city_id in memcached.
			$city_id = $domains["id"];
		} else {
			/**
			 * failure, getting from database
			 */
			$dbr = self::db( DB_SLAVE );
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
	 * Given a wiki's dbName, return the wgServer value properly altered to reflect the current environment.
	 *
	 * @param int $dbName
	 *
	 * @return string
	 */
	public static function getHostByDbName( $dbName ) {

		$cityId = \WikiFactory::DBtoID( $dbName );

		return self::getHostById($cityId);
	}

	/**
	 * Given a wiki's id, return the wgServer value properly altered to reflect the current environment.
	 *
	 * @param int $cityId
	 *
	 * @return string
	 */
	public static function getHostById( $cityId ) {
		global $wgDevelEnvironment, $wgDevelEnvironmentName;

		$hostName = \WikiFactory::getVarValueByName( 'wgServer', $cityId );

		if ( !empty( $wgDevelEnvironment ) ) {
			if ( strpos( $hostName, "wikia.com" ) ) {
				$hostName = str_replace( "wikia.com", "{$wgDevelEnvironmentName}.wikia-dev.com", $hostName );
			} else {
				$hostName = \WikiFactory::getLocalEnvURL( $hostName );
			}
		}

		return rtrim( $hostName, '/' );
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
	 *
	 * @throws WikiFactoryDuplicateWgServer
	 * @return boolean: transaction status
	 */
	static public function setVarById( $cv_variable_id, $city_id, $value, $reason=null ) {
		global $wgWikicitiesReadOnly;

		if ( ! self::isUsed() ) {
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

		wfProfileIn( __METHOD__ );
		$dbw = self::db( DB_MASTER );
		$bStatus = true;

		$dbw->begin();
		try {

			/**
			 * use master connection for changing variables
			 */
			$variable = self::loadVariableFromDB( $cv_variable_id, false, $city_id, true );
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

				self::log(
					self::LOG_VARIABLE,
					sprintf($message,
						$variable->cv_name,
						var_export( unserialize( $variable->cv_value ), true ),
						var_export( $value, true ),
						$reason_extra
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

				self::log(
					self::LOG_VARIABLE,
					sprintf($message,
						$variable->cv_name,
						var_export( $value, true ),
						$reason_extra
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
			wfRunHooks( 'WikiFactoryChanged', [ $variable->cv_name , $city_id, $value ] );
			switch ( $variable->cv_name ) {
				case "wgServer":
				case "wgScriptPath":
					/**
					 * city_url is combination of $wgServer & $wgScriptPath
					 */

					/**
					 * ...so get the other variable
					 */
					if ( $variable->cv_name === "wgServer" ) {
						$tmp = self::getVarValueByName( "wgScriptPath", $city_id );
						$server = is_null( $value ) ? "" : $value;
						$script_path = is_null( $tmp ) ? "/" : $tmp . "/";
					}
					else {
						$tmp = self::getVarValueByName( "wgServer", $city_id );
						$server = is_null( $tmp ) ? "" : $tmp;
						$script_path = is_null( $value ) ? "/" : $value . "/";
					}
					$city_url = $server . $script_path;
					try {
						$dbw->update(
							self::table("city_list"),
							[ "city_url" => $city_url ],
							[ "city_id" => $city_id ],
							__METHOD__
						);
					} catch ( DBQueryError $e ) {
						if ( preg_match("/Duplicate entry '[^']*' for key 'urlidx'/", $e->error) ) {
							$res = $dbw->selectRow(
								self::table("city_list"),
								"city_id",
								[ "city_url" => $city_url ],
								__METHOD__
							);
							if ( isset($res->city_id) ) {
								$exc = new WikiFactoryDuplicateWgServer($city_id, $city_url, $res->city_id);
								Wikia::log( __METHOD__, "", $exc->getMessage());
								$dbw->rollback();
								throw $exc;
							}
						}
						throw $e;
					}

					break;

				case "wgLanguageCode":
					#--- city_lang
					$dbw->update(
						self::table("city_list"),
						[ "city_lang" => $value ],
						[ "city_id" => $city_id ],
						__METHOD__ );

					#--- update language tags
					$tags = new WikiFactoryTags( $city_id );
					$tags->removeTagsByName( $oldValue );
					$tags->addTagsByName( $value );
					break;

				case "wgSitename":
					#--- city_title
					$dbw->update(
						self::table("city_list"),
						[ "city_title" => $value ],
						[ "city_id" => $city_id ],
						__METHOD__ );
					break;

				case "wgDBname":
					#--- city_dbname
					$dbw->update(
						self::table("city_list"),
						[ "city_dbname" => $value ],
						[ "city_id" => $city_id ],
						__METHOD__ );
					break;

				case "wgDBcluster":
					/**
					 * city_cluster
					 *
					 * city_cluster = null for first cluster
					 * @todo handle deleting values of this variable
					 */
					$dbw->update(
						self::table("city_list"),
						[ "city_cluster" => $value ],
						[ "city_id" => $city_id ],
						__METHOD__ );
					break;

				case 'wgMetaNamespace':
				case 'wgMetaNamespaceTalk':
					#--- these cannot contain spaces!
					if ( strpos($value, ' ') !== false ) {
						$value = str_replace(' ', '_', $value);
						$dbw->update(
							self::table('city_variables'),
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
		}
		catch ( DBQueryError $e ) {
			Wikia::log( __METHOD__, "", "Database error, cannot write variable." );
			$dbw->rollback();
			$bStatus = false;
			// rethrowing here does not seem to be right. Callers expect success or failure
			// as result value, not DBQueryError exception
			// throw $e;
		}


		self::clearCache( $city_id );

		global $wgMemc;
		$wgMemc->delete( self::getVarValueKey( $city_id, $variable->cv_id ) );

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
		$oVariable = self::getVarByName( $variable, $wiki );
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

		$variable = self::getVarById( $variable_id, $wiki );
		$dbw = self::db( DB_MASTER );
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
				self::log(
					self::LOG_VARIABLE,
					sprintf("Variable %s removed%s",
						self::getVarById($variable_id, $wiki)->cv_name,
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

				self::clearCache( $wiki );
				global $wgMemc;
				$wgMemc->delete( self::getVarValueKey( $wiki, $variable_id ) );

				wfRunHooks( 'WikiFactoryVariableRemoved', [ $variable->cv_name , $wiki ] );
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
		$oVariable = self::getVarByName( $variable, $wiki );
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
		return self::loadVariableFromDB( $cv_id, false, $city_id, $master );
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
		return self::loadVariableFromDB( false, $cv_name, $wiki, $master );
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
		$varData = self::loadVariableFromDB( false, $cv_name, false, $master );

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
				$variables = $oMemc->get( self::getVarsKey( $city_id ) );
				$value = isset( $variables[ "data" ][ $cv_name ] )
					? self::substVariables( $variables[ "data" ][ $cv_name ], $city_id )
					: null;
			}

			// Then ask memcached or DB for specific var
			if ( is_null( $value ) ) {
				$variable = self::loadVariableFromDB( false, $cv_name, $city_id, $master );
				$value = isset( $variable->cv_value )
					? self::substVariables( unserialize( $variable->cv_value ), $city_id )
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
						$val = self::getVarValueByName( ltrim( $key, '$' ), $city_id );
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

		if ( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		$oRow = self::getWikiByDB( $city_dbname, $master );

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

		if ( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		$oRow = self::getWikiByID( $city_id, $master );

		return isset( $oRow->city_dbname ) ? $oRow->city_dbname : false;
	}


	/**
	 * Convert given host to current environment (devbox or sandbox).
	 * @param string $dbName
	 * @param string $default if on main wikia
	 * @param string $host for testing
	 * @return string changed host or $default
	 */
	public static function getCurrentStagingHost( $dbName='', $default='', $host = null) {
		global $wgStagingList;

		if ( $host === null ) {
			$host = gethostname();
		}

		if ( preg_match( '/^(demo-[a-z0-9]+)-[s|r][0-9]+$/i', $host, $m ) ) {
			return $m[ 1 ] . '.' . ( $dbName ? $dbName : 'www' ) . '.wikia.com';
		}

		if ( in_array( $host, $wgStagingList ) ) {
			return $host . '.' . ( $dbName ? $dbName : 'www' ) . '.wikia.com';
		}

		if ( preg_match( '/^dev-([a-z0-9]+)$/i', $host, $m ) ) {
			return $dbName . '.' . $m[ 1 ] . '.wikia-dev.com';
		}

		return $default;
	}

	/**
	 * getLocalEnvURL
	 *
	 * return URL specific to current env
	 * (production, preview, verify, devbox, sandbox)
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
	 * @param string $url	general URL pointing to any server
	 *
	 * @return string	url pointing to local env
	 */
	static public function getLocalEnvURL( $url ) {
		global $wgWikiaEnvironment;

		// first - normalize URL
		$regexp = '/^http:\/\/([^\/]+)\/?(.*)?$/';
		if ( preg_match( $regexp, $url, $groups ) === 0 ) {
			// on fail at least return original url
			return $url;
		}
		$server = $groups[1];
		$address = $groups[2];

		if ( !empty($address) ) {
			$address = '/' . $address;
		}

		// strip env-specific pre- and suffixes for staging environment
		$server = preg_replace( '/^(preview|verify|sandbox-[a-z0-9]+)\./', '', $server );
		$devboxRegex = '/\.([^\.]+)\.wikia-dev\.com$/';

		if ( preg_match( $devboxRegex, $server, $groups ) === 1 ) {
			$devbox = $groups[1];
		} else {
			$devbox = '';
		}

		$server = str_replace( '.' . $devbox . '.wikia-dev.com', '', $server );
		$server = str_replace( '.wikia.com', '', $server );

		// put the address back into shape and return
		switch($wgWikiaEnvironment) {
			case WIKIA_ENV_PREVIEW:
				return 'http://preview.' . $server . '.wikia.com'.$address;
			case WIKIA_ENV_VERIFY:
				return 'http://verify.' . $server . '.wikia.com'.$address;
			case WIKIA_ENV_SANDBOX:
				return 'http://' . self::getExternalHostName() . '.' . $server . '.wikia.com' . $address;
			case WIKIA_ENV_DEV:
				return 'http://' . $server . '.' . self::getExternalHostName() . '.wikia-dev.com'.$address;
		}

		// by default return original address
		return $url;
	}

	/**
	 * returns externally-facing hostname, i.e.
	 * dev-devbox (as in devbox.wikia-dev.com ) => devbox
	 */
	public static function getExternalHostName() {
		global $wgWikiaEnvironment;

		$hostname = gethostname();
		if ( $wgWikiaEnvironment == WIKIA_ENV_DEV ) {
			return mb_ereg_replace( '^dev-', '', $hostname );
		}

		return $hostname;
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
	 * @return mixed: database row with wiki params
	 */
	static public function getWikiByID( $id, $master = false ) {

		if ( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		global $wgWikiFactoryCacheType;
		$oMemc = wfGetCache( $wgWikiFactoryCacheType );
		$memkey = self::getWikiaCacheKey( $id );
		$cached = ( empty($master) ) ? $oMemc->get( $memkey ) : null;
		if ( empty($cached) || !is_object( $cached ) ) {

			$dbr = self::db( ( $master ) ? DB_MASTER : DB_SLAVE );
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
		if ( !self::isUsed() ) {
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
			$sMemKey = self::getWikiaCacheKey( $id );
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
		$dbr = self::db( ( $master ) ? DB_MASTER : DB_SLAVE );
		$oRes = $dbr->select(
			[ "city_list" ],
			[ "*" ],
			[ "city_id" => $ids ],
			__METHOD__
		);

		while ( $oRow = $dbr->fetchObject( $oRes ) ) {
			// Cache single entries so other methods could use the cache
			$sMemKey = self::getWikiaCacheKey( $oRow->city_id );
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

		if ( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		global $wgWikiFactoryCacheType;
		$oMemc = wfGetCache( $wgWikiFactoryCacheType );
		$memkey = self::getWikiaDBCacheKey( $city_dbname );
		$cached = ( empty($master) ) ? $oMemc->get( $memkey ) : null;
		if ( empty($cached) || !is_object( $cached ) ) {

			$dbr = self::db( ( $master ) ? DB_MASTER : DB_SLAVE );
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

		set_error_handler( "wfUnserializeHandler" );
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
		$domainHash = self::getDomainHash($domain);
		return "wikifactory:domains:by_domain_hash:{$domainHash}";
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
		global $wgMemc,$wgWikicitiesReadOnly;

		if ( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if ( ! is_numeric( $city_id ) ) {
			return false;
		}

		wfProfileIn( __METHOD__ );

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
		}
		else {
			/**
			 * increase number in city_list
			 */
			$dbw = self::db( DB_MASTER );
			$dbw->update(
				"city_list",
				[ "city_factory_timestamp" => wfTimestampNow() ],
				[ "city_id" => $city_id ],
				__METHOD__
			);
		}

		/**
		 * clear tags cache
		 */
		$tags = new WikiFactoryTags( $city_id );
		$tags->clearCache();

		/**
		 * clear domains cache
		 */
		self::clearDomainCache( $city_id );

		/**
		 * clear variables cache
		 */
		$wgMemc->delete( "WikiFactory::getCategory:" . $city_id ); //ugly cat clearing (fb#9937)
		$wgMemc->delete( self::getVarsKey( $city_id ) );

		$city_dbname = self::IDtoDB( $city_id ) ;
		$wgMemc->delete( self::getWikiaCacheKey( $city_id ) );
		if ( !empty( $city_dbname ) ) {
			$wgMemc->delete( self::getWikiaDBCacheKey( $city_dbname ) );
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * Given a city_id, removes the domain-data array from memcached.
	 * @param $city_id
	 */
	static public function clearDomainCache( $city_id ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$domains = self::getDomains( $city_id, true );
		if ( is_array( $domains ) ) {
			foreach ( $domains as $domain ) {
				$wgMemc->delete( self::getDomainKey( $domain ) );
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

		if ( ! self::isUsed() ) {
			wfDebugLog( "wikifactory", __METHOD__ . ": WikiFactory is not used.\n", true );
			return [];
		}

		$groups = [];

		$dbr = self::db( DB_MASTER );

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
		if ( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}
		$dbr = self::db( DB_MASTER );

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
		$wikiID = self::DomainToID($domain);
		return is_null($wikiID) ? null : self::IDtoDB($wikiID);
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
		$wikiID = self::DBtoID($db);
		if ( is_null($wikiID) ) {
			$retVal = null;
		} else {
			$domains = self::getDomains($wikiID);
			if ( count($domains) == 0 ) {
				$retVal = null;
			} else {
				$retVal = array_shift($domains);
			}
		}
		return $retVal;
	}

	/**
	 * getFileCachePath
	 *
	 * build path to file based on id of wikia
	 *
	 *
	 * @author eloy@wikia
	 * @access public
	 * @static
	 *
	 * @param integer	$city_id	identifier from city_list
	 *
	 * @return string: path to file or null if id is not a number
	 */
	static public function getFileCachePath( $city_id ) {
		if ( is_null( $city_id ) || empty( $city_id ) ) {
			return null;
		}
		wfProfileIn( __METHOD__ );

		$intid = $city_id;
		$strid = (string)$intid;
		$path = "";
		if ( $intid < 10 ) {
			$path = sprintf( "%s/%d.ser", self::CACHEDIR, $intid );
		}
		elseif ( $intid < 100 ) {
			$path = sprintf(
				"%s/%s/%d.ser",
				self::CACHEDIR,
				substr($strid, 0, 1),
				$intid
			);
		}
		else {
			$path = sprintf(
				"%s/%s/%s/%d.ser",
				self::CACHEDIR,
				substr($strid, 0, 1),
				substr($strid, 0, 2),
				$intid
			);
		}
		wfProfileOut( __METHOD__ );
		return $path;
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
	 * @return string: HTML form
	 */
	static public function setPublicStatus( $city_public, $city_id, $reason = "" ) {
		global $wgWikicitiesReadOnly;
		if ( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		if ( (self::getFlags($city_id) & self::FLAG_PROTECTED) && $city_public != 1 ) {
			Wikia::log( __METHOD__, "", "Wiki is protected. Skipping update.");
			return false;
		}

		wfProfileIn( __METHOD__ );

		wfRunHooks( 'WikiFactoryPublicStatusChange', [ &$city_public, &$city_id, $reason ] );

		$update = [
			"city_public" => $city_public,
			"city_last_timestamp" => wfTimestamp( TS_DB ),
		];

		$sLogMessage = "Status of wiki changed to {$city_public}.";

		if ( !empty($reason) ) {
			$update["city_additional"] = $reason;
			$sLogMessage .= " (reason: {$reason})";
		}

		$dbw = self::db( DB_MASTER );
		$dbw->update(
			"city_list",
			$update,
			[ "city_id" => $city_id ],
			__METHOD__
		);

		self::log( self::LOG_STATUS, $sLogMessage, $city_id );

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
		if ( !self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		wfProfileIn( __METHOD__ );

		$oWikia = self::getWikiByID( $city_id );

		$city_public = ( isset( $oWikia->city_id ) ) ? $oWikia->city_public : 0;

		wfProfileOut( __METHOD__ );

		return intval($city_public);
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
		self::setFlags( $wikiId, $flags );
		$res = self::setPublicStatus( self::CLOSE_ACTION, $wikiId, $reason );
		self::clearCache( $wikiId );
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

		if ( ! self::isUsed() ) {
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

		$dbr = ( $master ) ? self::db( DB_MASTER ) : self::db( DB_SLAVE );

		$caller = wfGetCallerClassMethod(__CLASS__);
		$fname = __METHOD__ . " (from {$caller})";

		if ( $master || !isset( self::$variablesCache[$cacheKey] ) ) {
			$oRow = WikiaDataAccess::cache(
				self::getVarMetadataKey( $cacheKey ),
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

			self::$variablesCache[$cacheKey] = $oRow;
		}
		$oRow = self::$variablesCache[$cacheKey];
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

		if ( !empty( $city_id ) ) {
			$oRow2 = WikiaDataAccess::cache(
				self::getVarValueKey( $city_id, $oRow->cv_id ),
				3600,
				function() use ($dbr, $oRow, $city_id, $fname) {
					return $dbr->selectRow(
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
				}
			);

			if ( isset( $oRow2->cv_variable_id ) ) {

				$oRow->cv_city_id = $oRow2->cv_city_id;
				$oRow->cv_variable_id = $oRow2->cv_variable_id;
				$oRow->cv_value = $oRow2->cv_value;
			}
			else {
				$oRow->cv_city_id = $city_id;
				$oRow->cv_variable_id = $oRow->cv_id;
				$oRow->cv_value = null;
			}
		}
		else {
			$oRow->cv_city_id = null;
			$oRow->cv_variable_id = $oRow->cv_id;
			$oRow->cv_value = null;
		}

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
	 * @return boolean    status of insert operation
	 */
	static public function log( $type, $msg, $city_id = false, $variable_id = null ) {
		global $wgUser, $wgCityId, $wgWikicitiesReadOnly;

		if ( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		$city_id = ( $city_id === false ) ? $wgCityId : $city_id;

		$dbw = self::db( DB_MASTER );
		return $dbw->insert(
			"city_list_log",
			[
				"cl_city_id" => $city_id,
				"cl_user_id" => $wgUser->getId(),
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

		if ( ! self::isUsed() ) {
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

		$dbr = self::db( DB_SLAVE );

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

		$domains = self::getDomains( $city_id, true );

		$dbw = self::db( DB_MASTER );

		$where_cond = [
				"city_id" => $city_id
		];

		if ( count($skip_domains) > 0 ) {
			$where_cond[] = "city_domain NOT IN (" .$dbw->makeList( $skip_domains ) . ")";
		}

		$dbw->begin();
		$db = $dbw->update(
			self::table("city_domains"),
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

		self::clearDomainCache( $city_id );
		self::clearDomainCache( $new_city_id );

		wfProfileOut( __METHOD__ );
		return $res;
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
			$dbw = self::db( DB_MASTER );
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
					"city_founding_ip"       => $wiki->city_founding_ip,
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
				__METHOD__
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

				self::clearDomainCache( $row->city_id );
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

		$dbwf = self::db( DB_SLAVE );
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

		if ( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "info", "WikiFactory is not used." );
			return false;
		}

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		wfProfileIn( __METHOD__ );

		$dbw = self::db( DB_MASTER );
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
			self::log( self::LOG_STATUS, sprintf("Binary flags %s removed from city_flags.%s", decbin( $city_flags ), $reason ), $city_id );
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
	 *
	 * @return boolean, usually true when success
	 */
	static public function setFlags( $city_id, $city_flags, $skip=false, $reason = '' ) {
		global $wgWikicitiesReadOnly;

		if ( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "info", "WikiFactory is not used." );
			return false;
		}

		if ( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		wfProfileIn( __METHOD__ );

		$dbw = self::db( DB_MASTER );
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
			self::log( self::LOG_STATUS, sprintf("Binary flags %s added to city_flags.%s", decbin( $city_flags ), $reason ), $city_id );
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
	static public function getFlags( $city_id ) {
		global $wgWikicitiesReadOnly;

		if ( !self::isUsed() ) {
			Wikia::log( __METHOD__, 'info', 'WikiFactory is not used.' );
			return false;
		}

		wfProfileIn( __METHOD__ );

		$dbw = self::db( DB_SLAVE );
		$city_flags = $dbw->selectField(
			'city_list',
			'city_flags',
			[ 'city_id' => $city_id ],
			__METHOD__
		);
		//reduce log spam in wikifactory logs
		//self::log( self::LOG_STATUS, sprintf('Binary flags %s read from city_flags', decbin( $city_flags ) ), $city_id );

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

	static public function getCategory ( $city_id ) {
		// return deprecated category list
		$categories = self::getCategories( $city_id, true );
		return !empty($categories) ? $categories[0] : 0;
	}


	/**
	 * get new category id and name for $city_id
	 *
	 * @param integer	$city_id		wikia identifier in city_list
	 *
	 * @return array of stdClass ($row->cat_id $row->cat_name) or empty array
	 *
	 */

	static public function getCategories( $city_id, $deprecated = false ) {
		global $wgRunningUnitTests, $wgNoDBUnits;

		$aCategories = [];

		if ( ! self::isUsed() ) {
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
		 * it is called in CommonExtensions.php and wgMemc is not initialized there
		 */
		global $wgWikiFactoryCacheType;
		$oMemc = wfGetCache( $wgWikiFactoryCacheType );
		$memkey = sprintf("%s:%d", __METHOD__, intval($city_id));
		$cached = $oMemc->get($memkey);

		if ( empty($cached) ) {
			$dbr = self::db( DB_SLAVE );

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

			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$aCategories[] = $oRow;
			}
			$oMemc->set($memkey, $aCategories, 60*60*24);
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

		if ( ! self::isUsed() ) {
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
			$where["cv{$i}.cv_variable_id"] = self::getVarByName($key, self::COMMUNITY_CENTRAL)->cv_variable_id;
			$where["cv{$i}.cv_value"] = @serialize($val);
		}

		if ( !$i ) {
			return null;
		}

		wfProfileIn( __METHOD__ );

		$dbr = self::db( DB_SLAVE );

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
		$dbw = self::db( DB_MASTER );

		// Follow the convention already started in the database of putting "(unknown)" for non-descriptions.
		if ( $cv_description == "" ) {
			$cv_description = "(unknown)";
		}

		$cv_name = trim(trim($cv_name), '$');
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
			self::log(self::LOG_VARIABLE, "Variable \"$cv_name\" created");
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
		$dbw = self::db( DB_MASTER );

		// Follow the convention already started in the database of putting "(unknown)" for non-descriptions.
		if ( $cv_description == "" ) {
			$cv_description = "(unknown)";
		}

		$cv_name = trim($cv_name);
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
			self::log(self::LOG_VARIABLE, "Variable id $cv_variable_id (now called \"$cv_name\") changed");
			$dbw->commit();
			$bStatus = true;
		} catch ( DBQueryError $e ) {
			Wikia::log( __METHOD__, "", "Database error, cannot modify properties of WikiFactory variable $cv_variable_id (when setting name \"$cv_name\")." );
			$dbw->rollback();
			$bStatus = false;
			throw $e;
		}

		global $wgMemc;
		$wgMemc->delete( self::getVarMetadataKey( 'id:' . $cv_variable_id ) );

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
	static public function updateCityDescription( &$article, &$user ) {
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
		if ( ! self::isUsed() ) {
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
				$dbr = self::db( DB_SLAVE );
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

		$dbr = self::db( DB_SLAVE );

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
	 * Gets a list of all secondary database clusters, e.g. c1, c2, c3.  These are
	 * used as the suffix for the cluster DB name, e.g., wikicities_c1
	 *
	 * @return array
	 */
	static public function getSecondaryClusters() {
		global $wgMemc;

		$key = "wikifactory:clusters";
		$clusters = $wgMemc->get( $key );
		if ( !is_array( $clusters ) ) {

			$dbr = self::db( DB_SLAVE );
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
		$permissions =  self::getVarValueByName( 'wgGroupPermissionsLocal', $wikiId );
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
	 * get url from dbname
	 * @param string $dbname	name of database
	 * @param boolean $master	use master or slave connection
	 * @return url in city_list
	 */
	static public function DBtoUrl( $dbname, $master = false ) {
		if ( !self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		$oRow = self::getWikiByDB( $dbname, $master );

		return isset( $oRow->city_url ) ? $oRow->city_url : false;
	}

	/**
	 * Prefetch specified data for given set of wikis
	 *
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 *
	 * @param $ids array List of wiki ids
	 * @param $what int Flags specifying what data to prefetch
	 */
	static public function prefetchWikisById( $ids, $what = self::PREFETCH_DEFAULT ) {
		global $wgMemc;
		if ( !is_array( $ids ) ) $ids = [ $ids ];
		$keys = [];
		$added = [];
		foreach ( $ids as $id ) {
			$id = intval($id);

			// don't add the same wiki twice
			if ( !empty($added[$id]) ) continue;
			$added[$id] = true;


			if ( $what & self::PREFETCH_WIKI_METADATA ) {
				$keys[] = self::getVarsKey($id);
			}
			if ( $what & self::PREFETCH_VARIABLES ) {
				$keys[] = self::getWikiaCacheKey($id);
			}
		}
		$wgMemc->prefetch($keys);
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
			$value = self::parseValue( $preWFValues[$name], $type );
		} elseif( isset( $GLOBALS[$name] ) ) {
			// was not modified, spit out actual value
			$value = self::parseValue( $GLOBALS[$name], $type );
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
		$value = self::parseValue( unserialize( $variable->cv_value ), $variable->cv_variable_type );
		return htmlspecialchars( $value );
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
		if ( $type == "string" || $type == "integer"  ) {
			return $value;
		}

		if ( $type == "array" ) {
			$json = json_encode ( $value );
			if ( !preg_match_all( "/\".*\":/U", $json ) ) {
				return $json;
			}
		}

		return var_export( $value, true );
	}

	static public function getCityLink( $cityId ) {
		global $wgCityId, $wgSitename;

		$domains = self::getDomains( $cityId );

		if ( $wgCityId == $cityId ) {
			// Hack based on the fact we should only ask for current wiki's sitename
			$text = $wgSitename;
		} else {
			// The fallback to return anything
			$text = "[" . self::IDtoDB( $cityId ) . ":{$cityId}]";
		}

		if ( !empty( $domains ) ) {
			$text = Xml::tags( 'a', array( "href" => "http://" . $domains[0] ), $text );
		}

		return $text;
	}
};
