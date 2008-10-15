<?php

/**
 * @package MediaWiki
 * @subpackage WikiFactory
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com> for Wikia Inc.
 */

$wgExtensionCredits['other'][] = array(
	"name" => "WikiFactoryLoader",
	"description" => "MediaWiki configuration loader",
	"version" => preg_replace( '/^.* (\d\d\d\d-\d\d-\d\d).*$/', '\1', '$Id: WikiFactory.php 13985 2008-06-16 15:20:38Z eloy $' ),
	"author" => "[http://www.wikia.com/wiki/User:Eloy.wikia Krzysztof Krzyżaniak (eloy)]"
);

if( ! function_exists( "wfUnserializeHandler" ) ) {
	/**
	 * wfUnserializeErrorHandler
	 *
	 * @author Emil Podlaszewski <emil@wikia.com>
	 */
	function wfUnserializeHandler( $errno, $errstr ) {
		global $_variable_key, $_variable_value;
		error_log( $_SERVER['SERVER_NAME'] . " ($_variable_key=$_variable_value): $errno, $errstr" );
	}
}

class WikiFactory {

	const LOG_VARIABLE = 1;
	const LOG_DOMAIN   = 2;
	const LOG_CATEGORY = 3;
	const LOG_STATUS   = 4;

	const DOMAINCACHE = "/tmp/wikifactory/domains.ser";
	const CACHEDIR = "/tmp/wikifactory/wikis";
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
	 * @param boolean	$flag	if value not null set flag to $flag
	 *
	 * @return boolean	current value of self::$mIsUsed
	 */
	static public function isUsed( $flag = null ) {
		if( !is_null( $flag ) ) {
			self::$mIsUsed = (bool )$flag;
		}
		return self::$mIsUsed;
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
	 * @param integer	$city_id	default null	wiki identified in city_list
	 * @param boolean	$extended	default false	result is whole row not scalar
	 *
	 * @return mixed: array of domains
	 *
	 * if city_id is null it will return such array:
	 *
	 */
	static public function getDomains( $city_id = null, $extended = false ) {

		if( ! self::isUsed() ) {
			wfDebug( __METHOD__ . ": WikiFactory is not used.");
			return null;
		}

		global $wgMemc;

 		wfProfileIn( __METHOD__ );

		$domains = array();
		$condition = is_null( $city_id ) ? null : array( "city_id" => $city_id );
		$key = sprintf( "wikifactory:domains:%d:%d", $city_id, $extended );
		$domains = $wgMemc->get( $key );

		if( is_array( $domains ) ) {
			wfProfileOut( __METHOD__ );
			return $domains;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$oRes = $dbr->select(
			array( wfSharedTable("city_domains") ),
			array( "*" ),
			$condition,
			__METHOD__
		);

		while( $oRow = $dbr->fetchObject( $oRes ) ) {
			if( $extended === false ) {
				$domains[] = strtolower( $oRow->city_domain );
			}
			else {
				$domains[] = $oRow;
			}
		}
		$dbr->freeResult( $oRes );

		$wgMemc->set( $key, $domains, 3600 );

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
	 * @param integer $wiki: wiki identifier in city_list
	 * @param string $domain: domain name
	 *
	 * @return boolean: true - added, false otherwise
	 */
	static public function addDomain( $wiki, $domain ) {

		if( ! self::isUsed() ) {
			wfDebug( __METHOD__ . ": WikiFactory is not used.");
			return null;
		}

		/**
		 * domain should contain at least one dot
		 */
		if( !strpos($domain, ".") ) {
			return false;
		}
		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();

		#--- check if $wiki exists
		$oRow = $dbw->selectRow(
			wfSharedTable( "city_list" ),
			array( "city_id "),
			array( "city_id" => $wiki ),
			__METHOD__
		);
		if( $oRow->city_id != $wiki ) {
			wfProfileOut( __METHOD__ );
			$dbw->rollback();
			return false;
		}
		#--- check if $domain exists
		$oRow = $dbw->selectRow(
			wfSharedTable( "city_domains" ),
			array( "city_domain "),
			array( "city_domain" => strtolower( $domain ) ),
			__METHOD__
		);
		if( strtolower( $oRow->city_domain ) == strtolower( $domain ) ) {
			#--- exists
			wfProfileOut( __METHOD__ );
			$dbw->rollback();
			return false;
		}

		#--- ewentually insert
		$dbw->insert(
			wfSharedTable("city_domains"),
			array(
				"city_domain" => strtolower( $domain ),
				"city_id" => $wiki
			),
			__METHOD__
		);
		self::log( self::LOG_DOMAIN, "{$domain} added.", $wiki );
		$dbw->commit();
		wfProfileOut( __METHOD__ );

		return true;
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
			wfDebug( __METHOD__ . ": WikiFactory is not used.");
			return null;
		}

		wfProfileIn( __METHOD__ );
		$city_id = null;

		$oMemc = wfGetCache( CACHE_MEMCACHED );
		$domains = $oMemc->get( self::getDomainKey( $domain ) );

		if( isset( $domains[ "id" ] ) ) {
			#--- success, we have it from memcached!
			$city_id = $domains[ "id" ];
		}
		else {
			#--- failure, getting from database
			$dbr = wfGetDB( DB_SLAVE );
			$oRow = $dbr->selectRow(
				array( wfSharedTable("city_domains") ),
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
	 * @access public
	 * @author eloy@wikia
	 * @static
	 *
	 * @param integer $cv_variable_id		variable id in city_variables_pool
	 * @param integer $city_id		wiki id in city list
	 * @param mixed $value			new value for variable
	 *
	 * @return boolean: transaction status
	 */
	static public function setVarById( $cv_variable_id, $city_id, $value ) {

		if( ! self::isUsed() ) {
			wfDebug( __METHOD__ . ": WikiFactory is not used.");
			return null;
		}

		global $wgUser;

		if( empty( $cv_variable_id ) || empty( $city_id ) ) {
			return;
		}

		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_MASTER );
		$bStatus = true;

		$dbw->begin();
		try {

			$variable = self::loadVariableFromDB( $cv_variable_id, null, $city_id );

			/**
			 * delete old value
			 */
			$dbw->delete(
				wfSharedTable("city_variables"),
				array (
					"cv_variable_id" => $cv_variable_id,
					"cv_city_id" => $city_id
				),
				__METHOD__
			);

			/**
			 * insert new one
			 */
			$dbw->insert(
				wfSharedTable("city_variables"),
				array(
					"cv_variable_id"    => $cv_variable_id,
					"cv_city_id"        => $city_id,
					"cv_value"          => serialize( $value )
				),
				__METHOD__
			);

			wfProfileIn( __METHOD__."-changelog" );

			if( isset( $variable->cv_value ) ) {
				self::log(
					self::LOG_VARIABLE,
					sprintf("Variable %s changed value from %s to %s",
						$variable->cv_name,
						var_export( unserialize( $variable->cv_value ), true ),
						var_export( $value, true )
					),
					$city_id
				);
			}
			else {
				self::log(
					self::LOG_VARIABLE,
					sprintf("Variable %s set value: %s",
						$variable->cv_name,
						var_export( $value, true )
					),
					$city_id
				);
			}
			wfProfileOut( __METHOD__."-changelog" );

			/**
			 * check if variable is connected with city_list (for example
			 * city_language or city_url)
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
						wfSharedTable("city_list"),
						array("city_url" => $city_url ),
						array("city_id" => $city_id),
						__METHOD__ );
				break;

				case "wgLanguageCode":
					#--- city_lang
					$dbw->update(
						wfSharedTable("city_list"),
						array("city_lang" => $value ),
						array("city_id" => $city_id ),
						__METHOD__ );
					break;

				case "wgSitename":
					#--- city_title
					$dbw->update(
						wfSharedTable("city_list"),
						array("city_title" => $value ),
						array("city_id" => $city_id ),
						__METHOD__ );
					break;

				case "wgDBname":
					#--- city_dbname
					$dbw->update(
						wfSharedTable("city_list"),
						array("city_dbname" => $value ),
						array("city_id" => $city_id ),
						__METHOD__ );
					break;
			}
			wfProfileOut( __METHOD__."-citylist" );
			$dbw->commit();
		}
		catch ( DBQueryError $e ) {
			wfDebug( __METHOD__.": database error, cannot write variable\n" );
			$dbw->rollback();
			$bStatus = false;
			throw $e;
		}

		self::clearCache( $city_id );
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
	 *
	 * @return boolean: transaction status
	 */
	static public function setVarByName( $variable, $wiki, $value ) {
		$oVariable = self::getVarByName( $variable, $wiki );
		return WikiFactory::SetVarByID( $oVariable->cv_variable_id, $wiki, $value );
	}

	/**
	 * getVarById
	 *
	 * get variable data using cv_id field
	 *
	 * @access public
	 * @author eloy@wikia
	 * @static
	 *
	 * @param integer	$cv_id	variable id in city_variables_pool
	 * @param integer	$wiki	wiki id in city_list
	 *
	 * @return mixed	variable data from from city_variables & city_variables_pool
	 */
	static public function getVarById( $cv_id, $wiki ) {
		return self::loadVariableFromDB( $cv_id, null, $wiki );
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
	 *
	 * @return mixed 	variable data from from city_variables & city_variables_pool
	 */
	static public function getVarByName( $cv_name, $wiki ) {
		return self::loadVariableFromDB( null, $cv_name, $wiki );
	}

	/**
	 * getVarValueByName
	 *
	 * return only value of variable not whole data for it
	 *
	 * @access public
	 * @author eloy@wikia
	 * @static
	 *
	 * @param string	$cv_name	variable name in city_variables_pool
	 * @param integer	$city_id	wiki id in city_list
	 *
	 * @return mixed value for variable or null otherwise
	 */
	static public function getVarValueByName( $cv_name, $city_id ) {
		$variable = self::loadVariableFromDB( null, $cv_name, $city_id );
		return isset( $variable->cv_value ) ? unserialize( $variable->cv_value ) : null;
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
	 *
	 * @return id in city_list
	 */
	static public function DBtoID( $city_dbname ) {

		if( ! self::isUsed() ) {
			wfDebug( __METHOD__ . ": WikiFactory is not used.");
			return null;
		}

		$dbr = wfGetDB( DB_SLAVE );

		$oRow = $dbr->selectRow(
			array( wfSharedTable("city_list") ),
			array( "city_id", "city_dbname" ),
			array( "city_dbname" => $city_dbname ),
			__METHOD__
		);

		return isset( $oRow->city_id ) ? $oRow->city_id : null;
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
	 *
	 * @return string	database name from city_list
	 */
	static public function IDtoDB( $city_id ) {

		if( ! self::isUsed() ) {
			wfDebug( __METHOD__ . ": WikiFactory is not used.");
			return null;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$oRow = $dbr->selectRow(
			array( wfSharedTable("city_list") ),
			array( "city_id", "city_dbname" ),
			array( "city_id" => $city_id ),
			__METHOD__
		);

		return isset( $oRow->city_dbname ) ? $oRow->city_dbname : null;
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
			wfDebug( __METHOD__ . ": WikiFactory is not used.");
			return null;
		}

		/**
		 * first from slave
		 */
		$dbr = wfGetDB( DB_SLAVE );
		$oRow = $dbr->selectRow(
			array( wfSharedTable("city_list") ),
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
		$dbr = wfGetDB( DB_MASTER );
		$oRow = $dbr->selectRow(
			array( wfSharedTable("city_list") ),
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
	 * @param $domain string - domain name
	 *
	 * @return string with normalized domain
	 */
	public static function getDomainHash( $domain ) {
		$domain = strtolower( $domain );
		if (substr($domain, 0, 4) === "www." ) {
			#--- cut off www. part
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
			error_log("couldn't unserialize data from {$file}!");
			@unlink($file);
			return false;
		}

		/**
		 * check with change timestamp and with ttl stored in file
		 */
		$now = time();
		$host = isset( $_SERVER['SERVER_NAME'] ) ? $_SERVER['SERVER_NAME'] : "unknown";
		if( ( $now > $data[0] ) || ( !is_null($timestamp) && $timestamp != $data[1] ) ) {
			#--- Unlinking when the file was expired
			$cond1 = ( $now > $data[0] ) ? "y" : "n";
			$cond2 = ( $timestamp != $data[1] ) ? "y" : "n";
			error_log("{$host} expire {$file} now={$now} > ttl={$data[0]} ({$cond1}) or given {$timestamp} != stored {$data[1]} ({$cond2})" );
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
			wfDebug( "wikifactory: Could not write to file {$file}", true );
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
	static public function getVarsKey( $wiki ) {
		if (empty($wiki)) {
			return "wikifactory:variables:v3:0";
		}
		else {
			return "wikifactory:variables:v3:{$wiki}";
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
	 * @param string $domain: wiki domain
	 *
	 * @return boolean status
	 */
	static public function getDomainKey( $domain ) {
		$key = self::getDomainHash( $domain );
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

		if( ! self::isUsed() ) {
			wfDebug( __METHOD__ . ": WikiFactory is not used.");
			return null;
		}

		/**
		 * increase number in city_list
		 */
		if( ! is_numeric( $city_id ) ) {
			return false;
		}
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			wfSharedTable( "city_list" ),
			array(
				"city_factory_timestamp" => wfTimestampNow()
			),
			array(
				"city_id" => $city_id
			),
			__METHOD__
		);

		$oMemc = wfGetCache( CACHE_MEMCACHED );
		$domains = self::getDomains( $city_id );
		if( is_array( $domains ) ) {
			foreach( $domains as $domain ) {
				$oMemc->delete( self::getDomainKey( $domain ) );
			}
		}
		return $oMemc->delete( self::getVarsKey( $city_id ) );
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
			wfDebug( __METHOD__ . ": WikiFactory is not used.");
			return array();
		}

		$groups = array();

		$dbr = wfGetDB( DB_MASTER );

		$oRes = $dbr->select(
			array(
				wfSharedTable("city_variables_pool"),
				wfSharedTable("city_variables_groups")
			), /*from*/
			array(
				"cv_group_id",
				"cv_group_name"
			), /*what*/
			array(
				"cv_group_id in (select cv_variable_group from ". wfSharedTable("city_variables_pool").")"
			), /*where*/
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
			wfDebug( __METHOD__ . ": WikiFactory is not used.");
			return null;
		}

		$aVariables = array();
		$aTables = array(
			wfSharedTable("city_variables_pool"),
			wfSharedTable("city_variables_groups")
		);

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
			$aTables[] = wfSharedTable("city_variables");
			#--- add join
			$where[] = "cv_variable_id = cv_id";
			$where[ "cv_city_id" ] = $wiki;
		}

		#--- now construct query

		$dbr = wfGetDB( DB_MASTER );

		$oRes = $dbr->select(
			$aTables,
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
	 * DomainToID
	 *
	 * @access public
	 * @static
	 * @author Marooned
	 *
	 * @param $domain string - domain name
	 *
	 * @return integer - id in city_list
	 */
	static public function DomainToDB( $domain ) {
		$wikiID = self::DomainToID($domain);
		return is_null($wikiID) ? null : self::IDtoDB($wikiID);
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
	static public function setPublicStatus( $city_public, $city_id ) {

		if( ! self::isUsed() ) {
			wfDebug( __METHOD__ . ": WikiFactory is not used.");
			return null;
		}

		wfProfileIn( __METHOD__ );

		wfRunHooks( 'WikiFactoryPublicStatusChange', array( &$city_public, &$city_id ) );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			wfSharedTable( "city_list" ),
			array( "city_public" => $city_public ),
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
	 *
	 *
	 * @param integer $wiki: identifier from city_list
	 *
	 * @return string: path to file or null if id is not a number
	 */
	static private function loadVariableFromDB( $cv_id, $cv_name, $city_id ) {

		if( ! self::isUsed() ) {
			wfDebug( __METHOD__ . ": WikiFactory is not used.");
			return null;
		}

		/**
		 * $wiki could be empty, but we have to know which variable read
		 */
		if( is_null( $cv_id ) && is_null( $cv_name ) ) {
			return null;
		}

		wfProfileIn( __METHOD__ );

		/**
		 * if both are defined cv_id has precedence
		 */
		if( !is_null( $cv_id ) ) {
			$condition = array( "cv_id" => $cv_id );
		}
		else {
			$condition = array( "cv_name" => $cv_name );
		}

		$dbr = wfGetDB( DB_SLAVE );

		$oRow = $dbr->selectRow(
			wfSharedTable( "city_variables_pool" ),
			array(
				"cv_id",
				"cv_name",
				"cv_description",
				"cv_variable_type",
				"cv_variable_group",
				"cv_access_level"
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
				wfSharedTable("city_variables"),
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
				$oRow->cv_variable_id = $cv_id;
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
			"wgExtraNamespacesLocal|wgContentNamespaces|wgNamespacesWithSubpages|wgNamespacesToBeSearchedDefault"
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
		global $wgUser, $wgCityId;

		if( ! self::isUsed() ) {
			wfDebug( __METHOD__ . ": WikiFactory is not used.");
			return false;
		}

		$city_id = ( $city_id === false ) ? $wgCityId : $city_id;

		$dbw = wfGetDB( DB_MASTER );
		return $dbw->insert(
			wfSharedTable( "city_list_log" ),
			array(
				"cl_city_id" => $city_id,
				"cl_user_id" => $wgUser->getId(),
				"cl_type" => $type,
				"cl_text" => $msg
			),
			__METHOD__
		);
	}
};
