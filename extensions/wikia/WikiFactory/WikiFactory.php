<?php

/**
 * @package MediaWiki
 * @ingroup WikiFactory
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com> for Wikia Inc.
 */

$wgExtensionCredits['other'][] = array(
	"name" => "WikiFactoryLoader",
	"description" => "MediaWiki configuration loader",
	"svn-revision" => '$Revision$',
	"author" => "[http://www.wikia.com/wiki/User:Eloy.wikia Krzysztof Krzyżaniak (eloy)]"
);

if( ! function_exists( "wfUnserializeHandler" ) ) {
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
#$wgHooks[ "RecentChange_save" ][] = "WikiFactoryUpdate::addPostCommitUpdate";

class WikiFactory {

	const LOG_VARIABLE  = 1;
	const LOG_DOMAIN    = 2;
	const LOG_CATEGORY  = 3;
	const LOG_STATUS    = 4;

	# close Wiki
	const HIDE_ACTION 			= -1;
	const CLOSE_ACTION 			= 0;
	static public $DUMP_SERVERS = array(
		'c1' => 'db2',
		'c2' => 'db-sb2'
	);

	# city_flags
	const FLAG_CREATE_DB_DUMP 			= 1;
	const FLAG_CREATE_IMAGE_ARCHIVE 	= 2;
	const FLAG_DELETE_DB_IMAGES 		= 4;
	const FLAG_FREE_WIKI_URL 			= 8;
	const FLAG_HIDE_DB_IMAGES 			= 16;
	const FLAG_REDIRECT 				= 32;

	const db            = "wikicities"; // @see $wgExternalSharedDB
	const DOMAINCACHE   = "/tmp/wikifactory/domains.ser";
	const CACHEDIR      = "/tmp/wikifactory/wikis";

	static public $types = array(
		"integer",
		"long",
		"string",
		"float",
		"array",
		"boolean",
		"text",
		"struct",
		"hash"
	);

	static public $levels = array(
		1 => "read only",
		2 => "editable by staff",
		3 => "editable by user"
	);

	static public $mIsUsed = false;

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
		if( $flag ) {
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
	 * @param string	$table	table name
	 * @param string	$column	column name default false
	 *
	 * @return string	table name with database
	 */
	static public function table( $table, $column = false ) {
		global $wgExternalSharedDB;

		$database = !empty( $wgExternalSharedDB ) ? $wgExternalSharedDB : self::db;
		if( $column ) {
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
	 * @return Database object
	 */
	static public function db( $db ) {
		global $wgExternalSharedDB;

		return wfGetDB( $db, array(), $wgExternalSharedDB );
	}

	/**
	 * getDomains
	 *
	 * get all domains defined in wiki.factory (city_domains table) or
	 * all domains for given wiki ideintifier. Data from query is
	 * stored in memcache for hour.
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

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		global $wgMemc;

 		wfProfileIn( __METHOD__ );

		$domains = array();
		if( !empty( $city_id ) ) {
			/**
			 * skip cache if we want master
			 */
			$key = sprintf( "wikifactory:domains:%d", $city_id );
			if( ! $master ) {
				$domains = $wgMemc->get( $key );

				if( is_array( $domains ) ) {
					wfProfileOut( __METHOD__ );
					return $domains;
				}
			}

			$dbr = ( $master ) ? self::db( DB_MASTER ) : self::db( DB_SLAVE );
			$oRes = $dbr->select(
				array( "city_domains" ),
				array( "*" ),
				array( "city_id" => $city_id ),
				__METHOD__
			);

			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				$domains[] = strtolower( $oRow->city_domain );
			}
			$dbr->freeResult( $oRes );

			$wgMemc->set( $key, $domains, 3600 );
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
	static public function addDomain( $city_id, $domain ) {
		global $wgMemc,$wgWikicitiesReadOnly;

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if($wgWikicitiesReadOnly){
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		/**
		 * domain should contain at least one dot
		 */
		if( !strpos($domain, ".") ) {
			return false;
		}
		wfProfileIn( __METHOD__ );
		$dbw = self::db( DB_MASTER );
		$dbw->begin();

		/**
		 * check if $wiki exists
		 */
		$oRow = $dbw->selectRow(
			array( "city_list" ),
			array( "city_id "),
			array( "city_id" => $city_id ),
			__METHOD__
		);
		if( $oRow->city_id != $city_id ) {
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
			array( "city_domains" ),
			array( "city_domain "),
			array( "city_domain" => strtolower( $domain ) ),
			__METHOD__
		);
		if( strtolower( $oRow->city_domain ) == strtolower( $domain ) ) {
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
			array(
				"city_domain" => strtolower( $domain ),
				"city_id" => $city_id
			),
			__METHOD__
		);
		self::log( self::LOG_DOMAIN, "{$domain} added.",  $city_id );
		$dbw->commit();

		/**
		 * clear cache
		 */
		$wgMemc->delete( sprintf( "wikifactory:domains:%d:%d", $city_id, true ) );
		$wgMemc->delete( sprintf( "wikifactory:domains:%d:%d", $city_id, false ) );

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
	 * @param integer $wiki: wiki identifier in city_list
	 * @param string $domain: domain name (on null)
	 *
	 * @return boolean: true - removed, false otherwise
	 */
	static public function removeDomain ( $wiki, $domain = null ) {
		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		wfProfileIn( __METHOD__ );
		$dbw = self::db( DB_MASTER );
		$dbw->begin();

		$cond = array( "city_id" => $wiki );
		if ( !is_null($domain) ) {
			$cond["city_domain"] = $domain;
		}

		if ( ! $dbw->delete( "city_domains", $cond, __METHOD__ ) ) {
			$dbw->rollback();
			wfProfileOut( __METHOD__ );
			return false;
		}

		self::log( self::LOG_DOMAIN, "{$domain} removed.", $wiki );
		$dbw->commit();

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * setmainDomain
	 *
	 * sets domain as main (wgServer)
	 *
	 * @param integer $wiki: wiki identifier in city_list
	 * @param string $domain: domain name (on null)
	 *
	 * @return boolean: true - set, false otherwise
	 */
	static public function setmainDomain ( $wiki, $domain = null ) {
		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if ('http://' != strpos($domain, 0, 7)) {
			$domain = 'http://' . $domain;
		}

		return WikiFactory::setVarByName("wgServer", $wiki, $domain);
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
		if( isset( $parts[ "host" ] ) ) {
			$host = self::getDomainHash( $parts[ "host" ] );

			if( $host === "memory-alpha.org" ) {
				/**
				 * for memory-alpha check first element of path
				 */
				$parts = explode( "/", $parts[ "path" ] );
				$host = sprintf( "%s.%s", $parts[ 1 ], $host );
				$city_id = self::DomainToId( $host );
			}
			else {
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

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		wfProfileIn( __METHOD__ );
		$city_id = false;

		$oMemc = wfGetCache( CACHE_MEMCACHED );
		$domains = $oMemc->get( self::getDomainKey( $domain ) );

		if( isset( $domains[ "id" ] ) ) {
			/**
			 * success, we have it from memcached!
			 */
			$city_id = $domains[ "id" ];
		}
		else {
			/**
			 * failure, getting from database
			 */
			$dbr = self::db( DB_SLAVE );
			$oRow = $dbr->selectRow(
				array( "city_domains" ),
				array( "city_id" ),
				array( "city_domain" => $domain ),
				__METHOD__
			);
			$city_id = is_object( $oRow ) ? $oRow->city_id : null;
		}

		wfProfileOut( __METHOD__ );
		return $city_id;
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
	 * @param integer $cv_variable_id		variable id in city_variables_pool
	 * @param integer $city_id		wiki id in city list
	 * @param mixed $value			new value for variable
	 * @param string $reason		optional extra reason text
	 *
	 * @return boolean: transaction status
	 */
	static public function setVarById( $cv_variable_id, $city_id, $value, $reason=null ) {
		global $wgWikicitiesReadOnly;

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if($wgWikicitiesReadOnly){
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		global $wgUser;

		if( empty( $cv_variable_id ) || empty( $city_id ) ) {
			return;
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
				array(
					"cv_variable_id" => $cv_variable_id,
					"cv_city_id" => $city_id
				),
				__METHOD__
			);

			/**
			 * insert new one
			 */
			$dbw->insert(
				"city_variables",
				array(
					"cv_variable_id" => $cv_variable_id,
					"cv_city_id"     => $city_id,
					"cv_value"       => serialize( $value )
				),
				__METHOD__
			);

			wfProfileIn( __METHOD__."-changelog" );

			# if reason was passed non-null, prepare a string for sprintf, else a zero-len string
			$reason_extra = !empty($reason) ? " (reason: ". (string)$reason .")" : '';

			if( isset( $variable->cv_value ) ) {
				self::log(
					self::LOG_VARIABLE,
					sprintf("Variable %s changed value from %s to %s%s",
						$variable->cv_name,
						var_export( unserialize( $variable->cv_value ), true ),
						var_export( $value, true ),
						$reason_extra
					),
					$city_id
				);
			}
			else {
				self::log(
					self::LOG_VARIABLE,
					sprintf("Variable %s set value: %s%s",
						$variable->cv_name,
						var_export( $value, true ),
						$reason_extra
					),
					$city_id
				);
			}
			wfProfileOut( __METHOD__."-changelog" );

			/**
			 * check if variable is connected with city_list (for example
			 * city_language or city_url) and do some basic validation
			 */
			wfProfileIn( __METHOD__."-citylist" );
			wfRunHooks( 'WikiFactoryChanged', array( $variable->cv_name , $city_id, $value ) );
			switch( $variable->cv_name ) {
				case "wgServer":
				case "wgScriptPath":
					/**
					 * city_url is combination of $wgServer & $wgScriptPath
					 */

					/**
					 * ...so get the other variable
					 */
					if( $variable->cv_name === "wgServer" ) {
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
					$dbw->update(
						self::table("city_list"),
						array("city_url" => $city_url ),
						array("city_id" => $city_id),
						__METHOD__
					);

					/**
					 * clear cache with old domain (stored in $oldValue)
					 */
				break;

				case "wgLanguageCode":
					#--- city_lang
					$dbw->update(
						self::table("city_list"),
						array("city_lang" => $value ),
						array("city_id" => $city_id ),
						__METHOD__ );
					break;

				case "wgSitename":
					#--- city_title
					$dbw->update(
						self::table("city_list"),
						array("city_title" => $value ),
						array("city_id" => $city_id ),
						__METHOD__ );
					break;

				case "wgDBname":
					#--- city_dbname
					$dbw->update(
						self::table("city_list"),
						array("city_dbname" => $value ),
						array("city_id" => $city_id ),
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
						array("city_cluster" => $value ),
						array("city_id" => $city_id ),
						__METHOD__ );
					break;

				case 'wgMetaNamespace':
				case 'wgMetaNamespaceTalk':
					#--- these cannot contain spaces!
					if (strpos($value, ' ') !== false) {
						$value = str_replace(' ', '_', $value);
						$dbw->update(
							self::table('city_variables'),
							array('cv_value' => serialize($value)),
							array(
								'cv_city_id' => $city_id,
								'cv_variable_id' => $variable->cv_id
							),
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
			throw $e;
		}

		self::clearCache( $city_id );
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
	 * @throws a DBQueryError if there is an error with the deletion.
	 * @return boolean true on success, false on failure
	 */
	static public function removeVarById( $variable_id, $wiki, $reason=null ) {
		$bStatus = false;
		wfProfileIn( __METHOD__ );
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
				self::log(self::LOG_VARIABLE, sprintf("Variable %s removed%s", self::getVarById($variable_id, $wiki)->cv_name, $reason2), $wiki);
				$dbw->commit();
				$bStatus = true;
				self::clearCache( $wiki );
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
	 * @param integer	$cv_id	variable id in city_variables_pool
	 * @param integer	$wiki	wiki id in city_list
	 * @param boolean	$master	choose between master and slave connection
	 *
	 * @return mixed	variable data from from city_variables & city_variables_pool
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
	 * getVarValueByName
	 *
	 * return only value of variable not whole data for it, this value will be:
	 * - unserialized
	 * - all internal variables will be replace by their values
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak (eloy)
	 * @static
	 *
	 * @param string	$cv_name	variable name in city_variables_pool
	 * @param integer	$city_id	wiki id in city_list
	 * @param boolean	$master		choose between master & slave connection
	 *
	 * @return mixed value for variable or null otherwise
	 */
	static public function getVarValueByName( $cv_name, $city_id, $master = false ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );

		$value = false;
		/**
		 * first read WF Cache for city_id -- maybe value is already stored
		 * in memcached?
		 */
		if( !$master ) {
			$variables = $wgMemc->get( self::getVarsKey( $city_id ) );
			$value = isset( $variables[ "data" ][ $cv_name ] )
				? self::substVariables( $variables[ "data" ][ $cv_name ], $city_id )
				: false;
		}

		if( !$value ) {
			$variable = self::loadVariableFromDB( false, $cv_name, $city_id, $master );
			$value = isset( $variable->cv_value )
				? self::substVariables( unserialize( $variable->cv_value ), $city_id )
				: false;
		}

		wfProfileOut( __METHOD__ );

		return $value;
	}

	/**
	 * substVariables
	 *
	 * metod for resolving variable values uses in other variables
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
		if( is_string( $cv_value ) && preg_match_all('/(\$\w+)/', $cv_value, $matches ) ) {
			if( is_array( $matches ) ) {
				foreach( $matches[ 1 ] as $idx => $key ) {
					if( !is_numeric( ltrim( $key, '$' ) ) ) {
						/**
						 * get value for key
						 */
						$val = self::getVarValueByName( ltrim( $key, '$' ), $city_id );
						if( $val ) {
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
	 * @return id in city_list
	 */
	static public function DBtoID( $city_dbname, $master = false ) {

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		$dbr = ( $master ) ? self::db( DB_MASTER ) : self::db( DB_SLAVE );

		$oRow = $dbr->selectRow(
			array( "city_list" ),
			array( "city_id", "city_dbname" ),
			array( "city_dbname" => $city_dbname ),
			__METHOD__
		);

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

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		$dbr = ( $master ) ? self::db( DB_MASTER ) : self::db( DB_SLAVE );
		$oRow = $dbr->selectRow(
			array( "city_list" ),
			array( "city_id", "city_dbname" ),
			array( "city_id" => $city_id ),
			__METHOD__
		);

		return isset( $oRow->city_dbname ) ? $oRow->city_dbname : false;
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
	 *
	 * @return mixed: database row with wiki params
	 */
	static public function getWikiByID( $id ) {

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		/**
		 * first from slave
		 */
		$dbr = self::db( DB_SLAVE );
		$oRow = $dbr->selectRow(
			array( "city_list" ),
			array( "*" ),
			array( "city_id" => $id ),
			__METHOD__
		);

		if( isset( $oRow->city_id ) ) {
			return $oRow;
		}
		/**
		 * if not then from master
		 */
		$dbr = self::db( DB_MASTER );
		$oRow = $dbr->selectRow(
			array( "city_list" ),
			array( "*" ),
			array( "city_id" => $id ),
			__METHOD__
		);
		return $oRow;
	}

	/**
	 * getDomainHash
	 *
	 * create key for domain, strip www if it's in address
	 *
	 * @access public
	 * @autor eloy@wikia
	 * @static
	 *
	 * @param string  $domain	domain name
	 * @param integer $city_id	wiki identifier in city_list table
	 *
	 * @return string with normalized domain
	 */
	public static function getDomainHash( $domain, $city_id = false ) {

		$domain = strtolower( $domain );
		if( substr($domain, 0, 4) === "www." ) {
			/**
			 * cut off www. part
			 */
			$domain = substr($domain, 4, strlen($domain) - 4 );
		}
		if( $city_id ) {
			/**
			 * if city_id is defined it means that we have www/dofus/memory-alpha
			 * case.
			 */
			$domain = sprintf( "%d.$domain", $city_id );
		}
		return $domain;
	}

	/**
	 * fetch
	 *
	 * simple caching, get serialized variable from file
	 *
	 * @access public
	 * @autor eloy@wikia
	 * @static
	 *
	 * @param string $file file name with stored information
	 * @param string $timestamp: timestamp of last change
	 *
	 * @return unserialized structure
	 */
	public static function fetch( $file, $timestamp = null ) {
		if( !file_exists($file) ) {
			return false;
		}

		set_error_handler( "wfUnserializeHandler" );
		$_variable_key = "";
		$_variable_value = "";
		$data = unserialize( file_get_contents( $file ) );
		restore_error_handler();

		if( !$data ) {
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
		if( ( $now > $data[0] ) || ( !is_null($timestamp) && $timestamp != $data[1] ) ) {
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
	 * @autor eloy@wikia
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

		if( $wgCommandLineMode ) {
			return false;
		}

		if( !file_exists( dirname( $file ) ) ) {
			wfMkdirParents( dirname( $file ) );
		}

		/**
		 * Serializing along with the TTL
		 */
		$data = serialize( array(time() + $ttl, $timestamp, $data) );
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
	 * @param integer $wiki: wiki id in city list
	 *
	 * @return string - variables key for memcached
	 */
	static public function getVarsKey( $city_id ) {
		if( empty( $city_id ) ) {
			return "wikifactory:variables:v3:0";
		}
		else {
			return "wikifactory:variables:v3:{$city_id}";
		}
	}

	/**
	 * getDomainKey
	 *
	 * get memcached key for domain
	 *
	 * @author eloy@wikia
	 * @access public
	 * @static
	 *
	 * @param string  $domain	wiki domain
	 * @param integer $city_id	wiki identifier in city_list table
	 *
	 * @return boolean status
	 */
	static public function getDomainKey( $domain, $city_id = false ) {
		$key = self::getDomainHash( $domain, $city_id );
		return "wikifactory:domains:{$key}";
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

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if( ! is_numeric( $city_id ) ) {
			return false;
		}

		wfProfileIn( __METHOD__ );

		if( $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
		}
		else {
			/**
			 * increase number in city_list
			 */
			$dbw = self::db( DB_MASTER );
			$dbw->update(
				"city_list",
				array( "city_factory_timestamp" => wfTimestampNow()	),
				array( "city_id" => $city_id ),
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
		$domains = self::getDomains( $city_id, true );
		if( is_array( $domains ) ) {
			foreach( $domains as $domain ) {
				$wgMemc->delete( self::getDomainKey( $domain ) );
				Wikia::log( __METHOD__, "", "Remove {$domain} from wikifactory cache" );
			}
		}

		/**
		 * clear variables cache
		 */
		$wgMemc->delete( self::getVarsKey( $city_id ) );

		wfProfileOut( __METHOD__ );

		return true;
	}

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

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return array();
		}

		$groups = array();

		$dbr = self::db( DB_MASTER );

		$oRes = $dbr->select(
			array( "city_variables_pool", "city_variables_groups" ), /*from*/
			array( "cv_group_id", "cv_group_name" ), /*what*/
			array( "cv_group_id in (select cv_variable_group from city_variables_pool)"	), /*where*/
			__METHOD__
		);

		while( $oRow = $dbr->fetchObject( $oRes ) ) {
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
		$defined = false, $editable = false, $string = false )
	{
		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		$aVariables = array();
		$tables = array( "city_variables_pool", "city_variables_groups" );
		$where = array( "cv_group_id = cv_variable_group" );

		$aAllowedOrders = array(
			"cv_id", "cv_name", "cv_variable_type",
			"cv_variable_group", "cv_access_level"
		);
		if (!empty( $group )) {
			$where["cv_variable_group"] = $group;
		}

		if ( $editable === true ) {
			$where[] = "cv_access_level > 1";
		}

		if( $string ) {
			$where[] = "cv_name like '%$string%'";
		}

		if ( $defined === true && $wiki != 0 ) {
			#--- add city_variables table
			$tables[] = "city_variables";
			#--- add join
			$where[] = "cv_variable_id = cv_id";
			$where[ "cv_city_id" ] = $wiki;
		}

		#--- now construct query

		$dbr = self::db( DB_MASTER );

		$oRes = $dbr->select(
			$tables,
			array( "*" ),
			$where,
			__METHOD__,
			array( "ORDER BY" => $sort )
		);

		while ($oRow = $dbr->fetchObject($oRes)) {
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
		if(is_null($wikiID)){
			$retVal = null;
		} else {
			$domains = self::getDomains($wikiID);
			if(count($domains) == 0){
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
		if( is_null( $city_id ) || empty( $city_id ) ) {
			return null;
		}
		wfProfileIn( __METHOD__ );

		$intid = $city_id;
		$strid = (string)$intid;
		$path = "";
		if( $intid < 10 ) {
			$path = sprintf( "%s/%d.ser", self::CACHEDIR, $intid );
		}
		elseif( $intid < 100 ) {
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
	 * @param integer	$city_public	status in city_list
	 * @param integer	$city_id		wikia identifier in city_list
	 *
	 * @return string: HTML form
	 */
	static public function setPublicStatus( $city_public, $city_id, $reason = "" ) {

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if($wgWikicitiesReadOnly){
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		wfProfileIn( __METHOD__ );

		wfRunHooks( 'WikiFactoryPublicStatusChange', array( &$city_public, &$city_id ) );

		$update = array( "city_public" => $city_public );
		if ( !empty($reason) ) {
			$update["city_additional"] = $reason;
		}

		$dbw = self::db( DB_MASTER );
		$dbw->update(
			"city_list",
			$update,
			array( "city_id" => $city_id ),
			__METHOD__
		);
		self::log( self::LOG_STATUS, "Status of wiki changed to {$city_public}.", $city_id );

		wfProfileOut( __METHOD__ );

		return $city_public;
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
	 * @param integer	$cv_id		variable id in city_variables_pool
	 * @param string	$cv_name	variable name in city_variables_pool
	 * @param integer	$city_id	wiki id in city_list
	 * @param boolean	$master		use master or slave connection
	 *
	 *
	 * @param integer $wiki: identifier from city_list
	 *
	 * @return string: path to file or null if id is not a number
	 */
	static private function loadVariableFromDB( $cv_id, $cv_name, $city_id, $master = false ) {

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		/**
		 * $wiki could be empty, but we have to know which variable read
		 */
		if( ! $cv_id && ! $cv_name ) {
			return false;
		}

		wfProfileIn( __METHOD__ );

		/**
		 * if both are defined cv_id has precedence
		 */
		if( $cv_id ) {
			$condition = array( "cv_id" => $cv_id );
		}
		else {
			$condition = array( "cv_name" => $cv_name );
		}

		$dbr = ( $master ) ? self::db( DB_MASTER ) : self::db( DB_SLAVE );

		$oRow = $dbr->selectRow(
			array( "city_variables_pool" ),
			array(
				"cv_id",
				"cv_name",
				"cv_description",
				"cv_variable_type",
				"cv_variable_group",
				"cv_access_level",
				"cv_is_unique"
			),
			$condition,
			__METHOD__
		);

		if( !isset( $oRow->cv_id ) ) {
			/**
			 * variable doesn't exist
			 */
			wfProfileOut( __METHOD__ );
			return null;
		}

		if( !empty( $city_id ) ) {
			$oRow2 = $dbr->selectRow(
				array("city_variables"),
				array(
					"cv_city_id",
					"cv_variable_id",
					"cv_value"
				),
				array(
					"cv_variable_id" => $oRow->cv_id,
					"cv_city_id" => $city_id
				),
				__METHOD__
			);
			if( isset( $oRow2->cv_variable_id ) ) {

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
		if (empty($wgLocalDatabases)) {
			$wgLocalDatabases = array();
		}
		$wgLocalDatabases[] = $wgDBname;

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'interwiki', array( 'iw_prefix' ), false );
		$prefixes = array();
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
		$tied = array(
			#"wgExtraNamespacesLocal|wgContentNamespaces|wgNamespacesWithSubpagesLocal|wgNamespacesToBeSearchedDefault"
		);
		foreach( $tied as $group ) {
			$pattern = "/\b{$cv_name}\b/";
			if( preg_match( $pattern, $group ) ) {
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
	 * @param integer	$type	type of message, use constants from class
	 * @param string	$msg	message to be logged
	 * @param integer	$city_id default false	wiki id from city_list
	 *
	 * @return boolean	status of insert operation
	 */
	static public function log( $type, $msg, $city_id = false ) {
		global $wgUser, $wgCityId, $wgWikicitiesReadOnly;

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		if($wgWikicitiesReadOnly){
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		$city_id = ( $city_id === false ) ? $wgCityId : $city_id;

		$dbw = self::db( DB_MASTER );
		return $dbw->insert(
			"city_list_log",
			array(
				"cl_city_id" => $city_id,
				"cl_user_id" => $wgUser->getId(),
				"cl_type" => $type,
				"cl_text" => $msg
			),
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

		if( ! self::isUsed() ) {
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
			array( "city_variables" ),
			array( "cv_city_id" ),
			array( "cv_value" => @serialize($cv_value) ),
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
	 *
	 *
	 * @return integer: city ID or null if not found
	 */
	static public function redirectDomains($city_id, $new_city_id) {
		global $wgExternalArchiveDB,$wgWikicitiesReadOnly;

		if($wgWikicitiesReadOnly){
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		wfProfileIn( __METHOD__ );
		$res = true;

		$domains = self::getDomains( $city_id, true );

		$dbw = self::db( DB_MASTER );
		$dbw->begin();
		$db = $dbw->update(
			self::table("city_domains"),
			array( "city_id" => $new_city_id ),
			array( "city_id" => $city_id ),
			__METHOD__ );
		if ($db) {
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
				$dba = wfGetDB( DB_MASTER, array(), $wgExternalArchiveDB );
				foreach ( $domains as $domain ) {
					$dba->insert(
						"city_domains",
						array(
							"city_id"         => $city_id,
							"city_domain"     => $domain,
							"city_new_id"     => $new_city_id,
							"city_timestamp"  => wfTimestampNow()
						),
						__METHOD__
					);
				}
			}
		}

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
	 */
	static public function copyToArchive( $city_id ) {
		global $wgExternalArchiveDB, $wgWikicitiesReadOnly;

		if($wgWikicitiesReadOnly){
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		wfProfileIn( __METHOD__ );
		/**
		 * do only on inactive wikis
		 */
		$wiki = WikiFactory::getWikiByID( $city_id );
		if( isset( $wiki->city_id ) ) {

			$timestamp = wfTimestampNow();
			$dbw = self::db( DB_MASTER );
			$dba = wfGetDB( DB_MASTER, array(), $wgExternalArchiveDB );

			$dba->begin();

			/**
			 * copy city_list to archive
			 */
			$dba->insert(
				"city_list",
				array(
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
					"ad_cat"                 => $wiki->ad_cat,
					"city_flags"			 => $wiki->city_flags,
					"city_cluster"			 => $wiki->city_cluster
				),
				__METHOD__
			);

			/**
			 * copy city_variables to archive
			 */
			$sth = $dbw->select(
				array( "city_variables" ),
				array( "cv_city_id", "cv_variable_id", "cv_value" ),
				array( "cv_city_id" => $city_id ),
				__METHOD__
			);
			while( $row = $dbw->fetchObject( $sth ) ) {
				$dba->insert(
					"city_variables",
					array(
						"cv_city_id"     => $row->cv_city_id,
						"cv_variable_id" => $row->cv_variable_id,
						"cv_value"       => $row->cv_value,
						"cv_timestamp"   => $timestamp
					),
					__METHOD__
				);
			}
			$dbw->freeResult( $sth );

			/**
			 * copy domains to archive
			 */
			$sth = $dbw->select(
				array( "city_domains" ),
				array( "*" ),
				array( "city_id" => $city_id ),
				__METHOD__
			);
			while( $row = $dbw->fetchObject( $sth ) ) {
				$dba->insert(
					"city_domains",
					array(
						"city_id"         => $row->city_id,
						"city_domain"     => $row->city_domain,
						"city_new_id"     => $row->city_id,
						"city_timestamp"  => $timestamp
					),
					__METHOD__
				);
			}
			$dbw->freeResult( $sth );
			$dba->commit();
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
	static public function prepareDBName($dbname) {
		wfProfileIn( __METHOD__ );

		$dbwf = self::db( DB_SLAVE );
		$dbr  = wfGetDB( DB_MASTER );

		#-- check city_list
		$exists = 1; $suffix = "";
		while ( $exists == 1 ) {
			$dbname = sprintf("%s%s", $dbname, $suffix);
			Wikia::log( __METHOD__, "", "Checking if database {$dbname} already exists in city_list" );
			$Row = $dbwf->selectRow(
				array( "city_list" ),
				array( "count(*) as count" ),
				array( "city_dbname" => $dbname ),
				__METHOD__
			);
			$exists = 0;
			if( $Row->count > 0 ) {
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
			if ($exists == 1) {
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
	 * @param integer	$city_public	status in city_list
	 * @param integer	$city_id		wikia identifier in city_list
	 *
	 * @return boolean, usually true when success
	 */
	static public function resetFlags( $city_id, $city_flags ) {
		global $wgWikicitiesReadOnly;

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "info", "WikiFactory is not used." );
			return false;
		}

		if($wgWikicitiesReadOnly){
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		wfProfileIn( __METHOD__ );

		$dbw = self::db( DB_MASTER );
		$dbw->update(
			"city_list",
			array( "city_flags = ( city_flags &~ {$city_flags} )" ),
			array( "city_id" => $city_id ),
			__METHOD__
		);
		self::log( self::LOG_STATUS, sprintf("Binary flags %s removed from city_flags", decbin( $city_flags ) ), $city_id );

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
	 * @param integer	$city_public	status in city_list
	 * @param integer	$city_id		wikia identifier in city_list
	 *
	 * @return boolean, usually true when success
	 */
	static public function setFlags( $city_id, $city_flags ) {
		global $wgWikicitiesReadOnly;

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "info", "WikiFactory is not used." );
			return false;
		}

		if($wgWikicitiesReadOnly){
			Wikia::log( __METHOD__, "", "wgWikicitiesReadOnly mode. Skipping update.");
			return false;
		}

		wfProfileIn( __METHOD__ );

		$dbw = self::db( DB_MASTER );
		$dbw->update(
			"city_list",
			array( "city_flags = ( city_flags | {$city_flags} )" ),
			array( "city_id" => $city_id ),
			__METHOD__
		);
		self::log( self::LOG_STATUS, sprintf("Binary flags %s added to city_flags", decbin( $city_flags ) ), $city_id );

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * get category/hub name and number for $city_id
	 *
	 * @param integer	$city_id		wikia identifier in city_list
	 *
	 * @return StdObject ($row->cat_id $row->cat_name) or false
	 */
	static public function getCategory( $city_id ) {

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		$oMemc = wfGetCache( CACHE_MEMCACHED );
		$memkey = sprintf("%s:%d", __METHOD__, intval($city_id));
		$cached = $oMemc->get($memkey);
		if ( empty($cached) ) {
			$dbr = self::db( DB_SLAVE );

			$row = $dbr->selectRow(
				array( "city_cat_mapping", "city_cats" ),
				array( "city_cats.cat_id as cat_id", "city_cats.cat_name as cat_name" ),
				array(
					"city_id" => $city_id,
					"city_cats.cat_id = city_cat_mapping.cat_id"
				),
				__METHOD__
			);
			$oMemc->set($memkey, $row, 60*60*24);
		} else {
			$row = $cached;
		}

		return empty( $row ) ? false : $row;
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
	 * @return id in city_list
	 */
	static public function getWikiByDB( $city_dbname, $master = false ) {

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return false;
		}

		$dbr = ( $master ) ? self::db( DB_MASTER ) : self::db( DB_SLAVE );

		$oRow = $dbr->selectRow(
			array( "city_list" ),
			array( "*" ),
			array( "city_dbname" => $city_dbname ),
			__METHOD__
		);

		return isset( $oRow->city_id ) ? $oRow : false;
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
	static public function MultipleVarsToID($data) {

		if( ! self::isUsed() ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used." );
			return null;
		}

		if (!is_array($data)) {
			return null;
		}

		$i = 0;
		$tables = array();
		$where = array();
		foreach ($data as $key => $val) {
			$i++;
			$tables[] = "city_variables AS cv{$i}";

			$where[] = "cv1.cv_city_id = cv{$i}.cv_city_id";
			$where["cv{$i}.cv_variable_id"] = self::getVarByName($key, 177)->cv_variable_id;
			$where["cv{$i}.cv_value"] = @serialize($val);
		}

		if (!$i) {
			return null;
		}

		wfProfileIn( __METHOD__ );

		$dbr = self::db( DB_SLAVE );

		$oRow = $dbr->selectRow(
			$tables,
			array("cv1.cv_city_id"),
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
	 * @param cv_name string - name of the variable.
	 * @param cv_variabe_type string - type of the variable, must be one of the values in WikiFactory::types.
	 * @param cv_access_level integer - key from the WikiFactory::$levels array representing the access-level.
	 * @param group integer - the cv_group_id of the group this variable belongs in from the city_variables_groups table.
	 * @param cv_description string - human-readable description of what the variable is used for.  If this is an empty
	 *                                string, then "(unknown)" will be substituted.
	 *
	 * @throws a DBQueryError if there is an error with any of the queries used.
	 * @return boolean true on success, false on failure
	 */
	static public function createVariable($cv_name, $cv_variable_type, $cv_access_level, $cv_variable_group, $cv_description, $cv_is_unique = false){
		$bStatus = false;
		wfProfileIn( __METHOD__ );
		$dbw = self::db( DB_MASTER );

		// Follow the convention already started in the database of putting "(unknown)" for non-descriptions.
		if($cv_description == ""){
			$cv_description = "(unknown)";
		}

		$cv_name = trim(trim($cv_name), '$');
		$cv_variable_group = trim($cv_variable_group);
		$dbw->begin();
		try {
			// Don't re-check validity of variables, they are a precondition.  Do the queries here.
			$dbw->insert(
				"city_variables_pool",
				array(
					"cv_name" => $cv_name,
					"cv_variable_type" => $cv_variable_type,
					"cv_access_level" => $cv_access_level,
					"cv_variable_group" => $cv_variable_group,
					"cv_description" => $cv_description,
                                        "cv_is_unique" => $cv_is_unique
				),
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
	 * @param cv_variable_id integer - the id of the variable to change.
	 * @param cv_name string - new name of the variable.
	 * @param cv_variabe_type string - CURRENTLY IGNORED!  Doesn't seem like a good idea to have this value be changable.
	 * @param cv_access_level integer - key from the WikiFactory::$levels array representing the new access-level.
	 * @param group integer - the new cv_group_id of the group this variable belongs in from the city_variables_groups table.
	 * @param cv_description string - new human-readable description of what the variable is used for.  If this is an empty
	 *                                string, then "(unknown)" will be substituted.
	 *
	 * @throws a DBQueryError if there is an error with any of the queries used.
	 * @return boolean true on success, false on failure
	 */
	static public function changeVariable($cv_variable_id, $cv_name, $cv_variable_type, $cv_access_level, $cv_variable_group, $cv_description){
		$bStatus = false;
		wfProfileIn( __METHOD__ );
		$dbw = self::db( DB_MASTER );

		// Follow the convention already started in the database of putting "(unknown)" for non-descriptions.
		if($cv_description == ""){
			$cv_description = "(unknown)";
		}

		$cv_name = trim($cv_name);
		$cv_variable_group = trim($cv_variable_group);
		$dbw->begin();
		try {
			// Don't re-check validity of variables, they are a precondition.  Do the queries here.
			$dbw->update(
				"city_variables_pool",
				array(
					"cv_name" => $cv_name,
					//"cv_variable_type" => $cv_variable_type // Currently seems dangerous
					"cv_access_level" => $cv_access_level,
					"cv_variable_group" => $cv_variable_group,
					"cv_description" => $cv_description
				),
				array( "cv_id" => $cv_variable_id ),
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
	 * @param update description in city list base on msg in city
	 *
	 */

	static public function updateCityDescription (&$article, &$user ) {
		global $wgCityId;

		if( strtolower($article->getTitle()) == "mediawiki:description" ) {
			$out = trim( strip_tags( wfMsg('description') ) );
			$db = WikiFactory::db( DB_MASTER );
			$sql = " UPDATE city_list SET city_description =" . $db->addQuotes($out) . " where city_id= '".$wgCityId."' ;\n";
			$db->query($sql);
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
	 * @return id from coty_lang
	 */
	static public function LangCodeToId( $lang_code ) {
		if( ! self::isUsed() ) {
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
					array( "city_lang" ),
					array( "lang_id", "lang_code" ),
					false,
					__METHOD__
				);

				while( $oRow = $dbr->fetchObject( $oRes ) ) {
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
	 * @param int $varId the varjable ID as defined in the city_variables table
	 * @param mixed $val the value to search for
	 * @param bool $cond the SQL operator to use for matching the value, 'LIKE' and 'NOT LIKE' are accepted (% signs are added automatically), 'IS' and 'IS NOT' too
	 * @return array an array containing the list of city ID's matching the variable's value, an empty array if none matches
	 */
	static function getCityIDsFromVarValue( $varID, $val, $cond ) {

		wfProfileIn(__METHOD__);

		$varID = ( int ) $varID;
		$cond = strtoupper( str_replace( "'", null, trim( $cond ) ) );
		$aWhere = array(
			'cv_variable_id' => $varID
		);

		$dbr = self::db( DB_SLAVE );

		if ( in_array($cond, array( 'LIKE', 'NOT LIKE' ) ) ) {
			$aWhere[ ] = "cv_value {$cond} '%" . $dbr->escapeLike( serialize( $val ) ) . "%'";
		} elseif ( $val === 'NULL' && in_array($cond, array( 'IS', 'IS NOT' ) ) ) {
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

		$aWikis = array( );

		while ( $oRow = $dbr->fetchObject( $oRes ) ) {
			$aWikis[] = $oRow->cv_city_id;
		}

		$dbr->freeResult( $oRes );

		wfProfileOut(__METHOD__);

		return $aWikis;
	}
};

/**
 * update city_last_timestamp in city_list table with current timestamp
 *
 * @author Krzysztof Krzyżaniak (eloy)
 */
class WikiFactoryUpdate {

	private $mCityId;

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct( $city_id ) {
		$this->mCityId = $city_id;
	}

	/**
	 * doUpdate -- called on deferred update loop
	 *
	 * update city_last_timestamp in city_list table with current timestamp
	 *
	 * @access public
	 * @static
	 *
	 * @param RecentChanges $rc	instance of RecentChanges class
	 *
	 */
	public function doUpdate() {
		global $wgWikicitiesReadOnly;

		if( ! WikiFactory::isUsed() || $wgWikicitiesReadOnly ) {
			Wikia::log( __METHOD__, "", "WikiFactory is not used or in read-only mode." );
			return false;
		}

		$dbw = WikiFactory::db( DB_MASTER );
		return $dbw->update(
			"city_list",
			array( "city_last_timestamp" => wfTimestamp( TS_DB, time() ) ),
			array( "city_id" => $this->mCityId ),
			__METHOD__
		);
	}

	/**
	 * addPostCommitUpdate
	 *
	 * static method called as hook
	 *
	 * @static
	 * @access public
	 *
	 * @param RecentChanges	$rc	RecentChanges object
	 *
	 * @return true means process other hooks
	 */
	static public function addPostCommitUpdate( &$rc ) {
		global $wgPostCommitUpdateList, $wgCityId;

		if( ! wfReadOnly() ) {
			$deffUpdate = new WikiFactoryUpdate( $wgCityId );
			array_push( $wgPostCommitUpdateList, $deffUpdate );
		}
		return true;
	}
}
