<?php

/**
 * @package MediaWiki
 * contains all logic needed for loading and setting configuration data
 * class is used in LocalSettings
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com> for Wikia Inc.
 */

ini_set( "include_path", "{$IP}:{$IP}/includes:{$IP}/languages:{$IP}/lib:.:" );
ini_set( "cgi.fix_pathinfo", 1);

require_once( "$IP/includes/Defines.php" );
require_once( "$IP/includes/DefaultSettings.php" );
require_once( "$IP/includes/GlobalFunctions.php" );
require_once( "$IP/includes/wikia/GlobalFunctions.php" );
require_once( "$IP/includes/Exception.php" );
require_once( "$IP/includes/db/Database.php" );
require_once( "$IP/includes/BagOStuff.php" );
require_once( "$IP/includes/ObjectCache.php" );
require_once( "$IP/extensions/wikia/WikiFactory/WikiFactory.php" );

if( !function_exists("wfProfileIn") ) {
	require_once( "$IP/StartProfiler.php" );
}

/**
 * wfUnserializeErrorHandler
 *
 * @author Emil Podlaszewski <emil@wikia.com>
 */
function wfUnserializeHandler( $errno, $errstr ) {
	global $_variable_key, $_variable_value;
	error_log( $_SERVER['SERVER_NAME'] . " ($_variable_key=$_variable_value): $errno, $errstr" );
}

class WikiFactoryLoader {

	public $mServerName, $mWikiID, $mCityHost, $mCityID, $mOldServerName;
	public $mDomain, $mVariables, $mIsWikiaActive, $mAlwaysFromDB;
	public $mNoRedirect, $mTimestamp, $mAdCategory;
	public $mExpireDomainCacheTimeout = 86400; #--- 24 hours
	public $mExpireValuesCacheTimeout = 86400; #--- 24 hours

	public $mDevelDomains = array();

	public static $mDebug;

	private $mDBhandler;
	private $mDBname;


	/**
	 * __construct
	 *
	 * discover which wikia we handle
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @param integer $id default null	explicite set wiki id
	 * @param string $server_name default null	explicite set server name
	 *
	 * @return WikiFactoryLoader object
	 */
	public function  __construct( $id = null, $server_name = null ) {
		global $wgDBname, $wgSharedDB, $wgDevelEnvironment, $wgDevelDomains;
		global $wgWikiFactoryDomains;

		if( !is_null( $id ) ) {
			/**
			 * central / dofus / memory-alpha case
			 */
			$this->mCityID = $id;
			$this->mServerName = is_null( $server_name )
				? strtolower( $_SERVER['SERVER_NAME'] )
				: $server_name;
		}
		elseif( !empty($_SERVER['SERVER_NAME'])) {
			$this->mServerName = strtolower( $_SERVER['SERVER_NAME'] );
			$this->mCityID = null;
		}
		elseif( !empty($_ENV['SERVER_ID']) ) { #--- interactive/cmdline
			$this->mCityID = $_ENV['SERVER_ID'];
			$this->mServerName = null;
		}
		else { #--- hardcoded exit, nothing can be done at this point
			echo "Cannot tell which wiki it is (neither SERVER_NAME nor SERVER_ID is defined)\n";
			exit(1);
		}

		#--- turn on/off error_log
		self::$mDebug = 0;

		/**
		 * initalizations
		 */
		$this->mOldServerName = false;
		$this->mDBname = "wikicities";
		$this->mDomain = array();
		$this->mVariables = array();
		$this->mIsWikiaActive = 0;
		$this->mAlwaysFromDB = 0;
		$this->mWikiID = 0;
		$this->mSkipFileCache = 1;
		$this->mNoRedirect = false;
		$this->mDBhandler = null;

		if( !empty( $wgDevelEnvironment ) ) {
			$wgWikiFactoryDomains = array_merge( $wgDevelDomains, $wgWikiFactoryDomains );
			self::$mDebug = 1;
			$this->mAlwaysFromDB = 1;
		}

		/**
		 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
		 *
		 * handle additional domains, we have plenty of domains which should
		 * redirect to <wikia>.wikia.com. They should be added to
		 * $wgWikiFactoryDomains variable (which is simple list). When
		 * additional domain is detected we do simple replace:
		 *
		 * muppets.wikia.org => muppets.wikia.com
		 *
		 * additionally we remove www. before matching
		 */
		if( isset( $wgWikiFactoryDomains ) && is_array( $wgWikiFactoryDomains ) ) {
			foreach( $wgWikiFactoryDomains as $domain ) {
				/**
				 * remove www from domain
				 */
				$this->mOldServerName = $this->mServerName;
				$this->mServerName = preg_replace( "/^www\./", "", $this->mServerName );
				$pattern = "/{$domain}$/";
				if( preg_match( $pattern, $this->mServerName ) ) {
					$this->mServerName = str_replace( $domain, "wikia.com", $this->mServerName );
					break;
				}
			}
		}

		WikiFactory::isUsed( true );

		/**
		 * if run via commandline always take data from database,
		 * never from cache
		 */
		if( !is_null($this->mCityID) && $this->mAlwaysFromDB == 0 ) {
			$this->mAlwaysFromDB = 1;
		}
	}

	/**
	 * getDB
	 *
	 * Method for getting database handler. It checks if $wgDBservers is
	 * available, if yes it will take one of active slaves. If not it fallbacks
	 * to $wgDBserver
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 * @access public
	 *
	 * @return object Database	database handler
	 */
	public function getDB() {
		global $wgDBserver, $wgDBuser, $wgDBpassword,  $wgDBservers;

		if( is_object( $this->mDBhandler ) ) {
			return $this->mDBhandler;
		}

		if( isset( $wgDBservers ) && !empty( $wgDBservers ) ) {
			$server = array_rand( $wgDBservers );
			$host = $server[0]["host"];
			$this->mDBhandler = new Database( $host, $wgDBuser, $wgDBpassword, $this->mDBname );
			if( !empty( self::$mDebug ) ) {
				error_log("wikifactory: connecting to {$host}");
			}
		}
		/**
		 * and finally fallback to $wgDBserver
		*/
		if( is_null( $this->mDBhandler ) ) {
			$this->mDBhandler = new Database( $wgDBserver, $wgDBuser, $wgDBpassword, $this->mDBname );
			if( !empty( self::$mDebug ) ) {
				error_log("wikifactory: fallback to wgDBserver {$wgDBserver}");
			}
		}

		return $this->mDBhandler;
	}

	/**
	 * execute
	 *
	 * Main entry point for class
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @return integer: wikia id or null if wikia is not handled by WikiFactory
	 */
	public function execute() {

		wfProfileIn(__METHOD__);
		global $wgCityId, $wgDevelEnvironment, $wgWikiaAdvertiserCategory;

		/**
		 * local cache, change to CACHE_ACCEL for local
		 */
		$oMemc = wfGetCache( CACHE_MEMCACHED );

		if( empty( $this->mAlwaysFromDB ) ) {
			wfProfileIn( __METHOD__."-domaincache" );
			$key = WikiFactory::getDomainKey( $this->mServerName );
			$this->mDomain = $oMemc->get( $key );
			$this->mDomain = isset( $this->mDomain["id"] ) ? $this->mDomain : array ();
			if( !empty( self::$mDebug ) ) {
				error_log("wikifactory: reading from cache, key {$key}");
			}
			wfProfileOut( __METHOD__."-domaincache" );
		}

		if( !isset( $this->mDomain["id"] ) || $this->mAlwaysFromDB ) {
			wfProfileIn( __METHOD__."-domaindb" );

			/**
			 * first run or cache expired
			 */
			$dbr = $this->getDB();

			/**
			 * interactive/cmdline case. We know city_id so we don't have to
			 * ask city_domains table
			 */
			if( !is_null( $this->mCityID ) ) {
				$oRow = $dbr->selectRow(
					array( "city_list" ),
					array(
						"city_id",
						"city_public",
						"city_factory_timestamp",
						"city_url",
						"ad_cat"
					),
					array( "city_list.city_id" => $this->mCityID ),
					__METHOD__
				);
				if( $this->mCityID == $oRow->city_id ) {
					preg_match( "/http[s]*\:\/\/(.+)$/", $oRow->city_url, $matches );
					$host = rtrim( $matches[1],  "/" );

					$this->mWikiID =  $oRow->city_id;
					$this->mIsWikiaActive = $oRow->city_public;
					$this->mCityHost = $host;
					$this->mTimestamp = $oRow->city_factory_timestamp;
					$this->mAdCategory = empty( $oRow->ad_cat  ) ?  $oRow->ad_cat : "NONE";
					$this->mDomain = array(
						"id" => $oRow->city_id,
						"host" => $host,
						"active" => $oRow->city_public,
						"time" =>  $oRow->city_factory_timestamp,
						"ad" => $oRow->ad_cat
					);
				}
			}
			else {
				/**
				 * request from HTTPD case. We only know server name so we
				 * have to ask city_domains table
				 */
				$oRow = $dbr->selectRow(
					array(
						"city_domains",
						"city_list"
					),
					array(
						"city_list.city_id",
						"city_public",
						"city_factory_timestamp",
						"city_domain",
						"city_url",
						"ad_cat"
					),
					array(
						"city_domains.city_id = city_list.city_id",
						"lower( city_domains.city_domain )" => $this->mServerName
					),
					__METHOD__
				);
				if( isset( $oRow->city_id ) &&  $oRow->city_id > 0 ) {
					$oRow->city_domain = strtolower( $oRow->city_domain );
					preg_match( "/http[s]*\:\/\/(.+)$/", $oRow->city_url, $matches );
					$host = rtrim( $matches[1],  "/" );

					if( $oRow->city_domain == $this->mServerName && !is_null($this->mServerName) ) {
						$this->mWikiID =  $oRow->city_id;
						$this->mIsWikiaActive = $oRow->city_public;
						$this->mCityHost = $host;
						$this->mTimestamp = $oRow->city_factory_timestamp;
						$this->mAdCategory = empty( $oRow->ad_cat  ) ?  $oRow->ad_cat : "NONE";
						$this->mDomain = array(
							"id" => $oRow->city_id,
							"host" => $host,
							"active" => $oRow->city_public,
							"time" =>  $oRow->city_factory_timestamp,
							"ad" => $oRow->ad_cat
						);
					}
				}
			}
			if( empty($this->mAlwaysFromDB) && !empty( $this->mWikiID ) ) {
				/**
				 * store value in cache
				 */
				$oMemc->set(
					WikiFactory::getDomainKey( $this->mServerName ),
					$this->mDomain,
					$this->mExpireDomainCacheTimeout
				);
			}
			wfDebug("wikifactory: {$this->mWikiID}:{$this->mServerName} (from database)", true);
			if( !empty( self::$mDebug ) ) {
				error_log("wikifactory: reading from database {$this->mServerName}");
			}
			wfProfileOut( __METHOD__."-domaindb" );
		}
		else {
			/**
			 * data taken from cache
			*/
			$this->mWikiID = $this->mDomain["id"];
			$this->mCityHost = $this->mDomain["host"];
			$this->mIsWikiaActive = $this->mDomain["active"];
			$this->mTimestamp = isset( $this->mDomain["time"] ) ? $this->mDomain["time"] : null;
			$this->mAdCategory = empty( $this->mDomain["ad"] ) ? "NONE" : $this->mDomain["ad"];
		}

		if( ( strpos($this->mServerName, "gamespot") != 0 ) ||
			( strpos($this->mServerName, "-abc.") != 0 ) ||
			( strpos( $this->mServerName, "beta." ) === 0 )
		) {
			$this->mNoRedirect = true;
		}

		/**
		 * redirection to another url
		 */
		if( $this->mIsWikiaActive == 2 ) {
			wfDebug("wikifactory: {$this->mWikiID}:{$this->mIsWikiaActive}) redirected to {$this->mCityHost}", true);
			if ( !empty( self::$mDebug ) ) {
				error_log( "wikifactory: redirected to {$this->mCityHost}" );
			}
			header( "Location: http://{$this->mCityHost}/", true, 301 );
			wfProfileOut( __METHOD__ );
			exit(0);
		}

		/**
		 * if $this->mCityURL different from city_url we redirect to city_url
		 * (as main server)
		 *
		 * mCityHost may contain path after url (memory-alpha, dofus), we just
		 * split this for comparing hosts.
		 */
		list( $host, $path ) = array_pad( explode( "/", $this->mCityHost, 2 ), 2, false );

		/**
		 * check if domain from browser is different than main domain for wiki
		 */
		$cond1 = !empty( $host ) && !empty( $this->mServerName ) && strtolower( $host ) != $this->mServerName;

		/**
		 * check if not additional domain was used (then we redirect anyway)
		 */
		$cond2 = $host != $this->mOldServerName;

		if( ( $cond1 || $cond2 ) && empty( $wgDevelEnvironment ) && $this->mNoRedirect === false ) {
			$url = wfGetCurrentUrl();
			/**
			 * dofus exception
			 */
			$dofus =  array( 602, 1982, 4533, 1177, 1630, 1112, 7491, 4763, 2278, 1922, 1809, 2791, 2788, 7645 );
			if( in_array( $this->mWikiID, $dofus ) ) {
				/**
				 * replace /wiki/ with /dofus/ in obsoleted links
				 * $this->mCityHost in dofus used to have
				 * http://<language>.dofus.wikia.com/wiki
				 * now it have http://<language>.wikia.com/dofus
				 */
				$url[ "path" ] = preg_replace( "!^(/wiki)!", "", $url[ "path" ] );
			}

			/**
			 * now recombine url from parts
			 */
			if( preg_match( "!^/$path!", $url[ "path" ] ) == 0 ) {
				$url[ "path" ] = "/{$path}" . $url[ "path" ];
			}

			$target = $url[ "scheme" ] . "://" . $host . $url[ "path" ];
			$target = isset( $url[ "query" ] ) ? $target . "?" . $url[ "query" ] : $target;

			wfDebug("wikifactory: redirected from {$url[ "url" ]} to {$target}", true);
			if( !empty( self::$mDebug ) ) {
				error_log( "wikifactory: redirected from {$url[ "url" ]} to {$target}" );
			}
			header( "Location: {$target}", true, 301 );
			wfProfileOut( __METHOD__ );
			exit(0);
		}

		/**
		 * if wikia is not defined or is disabled we redirecting to Not_a_valid_Wikia
		 */
		if( empty( $this->mWikiID ) || empty( $this->mIsWikiaActive ) ) {
			global $wgNotAValidWikia;
			wfDebug("wikifactory: {$this->mWikiID}:{$this->mIsWikiaActive}) wiki id empty or Wikia disabled", true);
			if ( !empty( self::$mDebug ) ) {
				error_log("wikifactory: redirected to $wgNotAValidWikia");
			}
			header("Location: $wgNotAValidWikia");
			wfProfileOut( __METHOD__ );
			exit(0);
		}

		/**
		 * for yellowikis.wikia check geolocation and for GB -> redirect to owikis
		 * @author Przemek Piotrowski (Nef)
		 */
		if( 0 === strpos($this->mServerName, 'yellowikis.') ) {
			global $wgLocationOfGeoIPDatabase;
			if( !empty($wgLocationOfGeoIPDatabase) && file_exists($wgLocationOfGeoIPDatabase) ) {
				/**
				 * ProxyTools methods cannot be used because PT is not loaded at this point.
				 * PT cannot be just included as it requires a lot to be initialized first )-:
				 *
				 * Order is *important* here! Proxy are added "from the right side"
				 * to the combined HTTP_X_FORWARDED_FOR + REMOTE_ADDR.
				 */
				$ips = array();
				if( !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
					$ips = preg_split('/\s*,\s*/', $_SERVER['HTTP_X_FORWARDED_FOR']);
				}
				if (!empty($_SERVER['REMOTE_ADDR'])) {
					$ips[] = $_SERVER['REMOTE_ADDR'];
				}
				if( !empty( self::$mDebug ) ) {
					error_log(print_r($ips, true));
				}

				if( !empty($ips[0]) ) {
					require_once 'Net/GeoIP.php';
					try {
						$geoip = Net_GeoIP::getInstance($wgLocationOfGeoIPDatabase);
						if( 'GB' == $geoip->lookupCountryCode($ips[0]) ) {
							header('Location: http://www.owikis.co.uk', true, 301);
							wfProfileOut( __METHOD__ );
							exit( 0 );
						}
					}
					catch (Exception $e) {
						#--- ignore exception, redirect is an option, not a necessity
					}
				}
			}
		}

		/**
		 * get info about city variables from memcached and then check,
		 * maybe memcached is down and returned only error code
		 */
		if( empty( $this->mAlwaysFromDB ) ) {
			wfProfileIn( __METHOD__."-varscache" );
			/**
			 * first from serialized file
			 */
			$key = WikiFactory::getVarsKey( $this->mWikiID );
			$data = $oMemc->get( $key );

			if( isset( $data["stamp"] ) &&  $data["stamp"] == $this->mTimestamp ) {
				$this->mVariables = isset( $data["data"] ) && is_array( $data["data"] )
					? $data["data"]
					: array ();
				if( !empty( self::$mDebug ) ) {
					error_log("wikifactory: reading from cache, key {$key}, count ".count( $this->mVariables ));
				}
			}
			else {
				wfDebug("wikifactory: timestamp doesn't match. Cache expired", true);
				if( !empty( self::$mDebug ) ) {
					error_log("wikifactory: timestamp doesn't match. Cache expired");
				}
			}
			wfProfileOut( __METHOD__."-varscache" );
		}

		/**
		 * if wgDBname is not defined we get all variables from database
		 */
		if( ! isset( $this->mVariables["wgDBname"] ) ) {
			wfProfileIn( __METHOD__."-varsdb" );
			$dbr = $this->getDB();
			$oRes = $dbr->select(
				array(
					"city_variables",
					"city_variables_pool"
				),
				array(
					"cv_name",
					"cv_value"
				),
				array(
					"cv_id = cv_variable_id",
					"cv_city_id = {$this->mWikiID}"
				),
				__METHOD__
			);
			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				#--- some magic, rewritting path, etc legacy data
				set_error_handler( "wfUnserializeHandler" );
				$_variable_key = $oRow->cv_name;
				$_variable_value = $oRow->cv_value;
				$tUnserVal = unserialize( $oRow->cv_value );
				restore_error_handler();

				if( !empty( $wgDevelEnvironment ) && $oRow->cv_name === "wgServer" ) {
					/**
					 * skip this variable
					 */
					$this->debug( "{$oRow->cv_name} with value {$tUnserVal} skipped" );
				}
				else {
					$this->mVariables[ $oRow->cv_name ] = $tUnserVal;
				}
			}
			$dbr->freeResult( $oRes );

			if( empty($this->mAlwaysFromDB) ) {
			   /**
				* store values in memcache
				*/
			   $oMemc->set(
					WikiFactory::getVarsKey($this->mWikiID),
					array(
						"stamp" => $this->mTimestamp,
						"data" => $this->mVariables
					),
					$this->mExpireValuesCacheTimeout
				);
			}
			$this->debug( "reading from database, id {$this->mWikiID}, count ".count( $this->mVariables ) );
			wfProfileOut( __METHOD__."-varsdb" );
		}

		/**
		 * transfer configuration variables from database to GLOBALS
		 */
		if( is_array($this->mVariables) ) {
			global $_variable_key, $_variable_value;
			foreach ($this->mVariables as $key => $value) {
				$tValue = $value;
				#--- check, maybe there are variables in variable
				if( is_string($tValue) ) {
					preg_match_all('/(\$\w+)[^\w]*/', $tValue, $aMatches);
					if( is_array($aMatches[1]) ) {
						foreach( $aMatches[1] as $tKey ){
							/**
							 * dolar sign in key should be removed
							 * (str_replace is faster than regexp)
							 */
							$tKeyParsed = str_replace('$', '', $tKey);
							if( !is_numeric($tKeyParsed) ) {
								#--- replace only if key is not $1, $2 etc.
								if( array_key_exists($tKeyParsed, $this->mVariables) ) {
									$tValue = str_replace($tKey, $this->mVariables[$tKeyParsed], $tValue);
								}
								else {
									$tValue = str_replace($tKey, $GLOBALS[$tKeyParsed], $tValue);
								}
							}
						}
					}
				}
				/**
				 * merge local values with global
				 */
				switch( $key ) {
					case "wgGroupPermissionsLocal":
						$this->LocalToGlobalPermissions( $tValue );
						break;

					case "wgNamespacesWithSubpagesLocal":
						$this->LocalToGlobalArray( $tValue, $GLOBALS["wgNamespacesWithSubpages"] );
						break;

					case "wgExtraNamespacesLocal":
						$this->LocalToGlobalArray( $tValue, $GLOBALS["wgExtraNamespaces"] );
						break;

					case "wgFileExtensionsLocal":
						$this->LocalToGlobalArray( $tValue, $GLOBALS["wgFileExtensions"], true );
						break;
				}

				try {
					$GLOBALS[$key] = $tValue;
				}
				catch( Exception $e ) {
					#--- so far do nothing
				}
			}
		}
		$wgCityId = $this->mWikiID;

		/**
		 * set advertising category
		 */
		$wgWikiaAdvertiserCategory = $this->mAdCategory;


		wfProfileOut( __METHOD__ );

		/**
		 * and finally return wiki id
		 */
		return $this->mWikiID;
	}

	/**
	 * LocalToGlobalPermissions
	 *
	 * this routine is used for converting string with permissions stored
	 * in WikiFactory variable
	 *
	 * variable value (string) looks like:
	 * <who>|<what permission>|<0|1>
	 *
	 * for example:
	 *
	 * *|createaccount|1,
	 * staff|edit|1,
	 * users|move|0
	 *
	 * @author eloy@wikia
	 * @access public
	 * @static
	 *
	 * @param string $local: string with permissions
	 *
	 * @return array with permissions
	 */
	static public function LocalToGlobalPermissions( $local ) {
		global $wgGroupPermissions;

		wfProfileIn( __METHOD__ );
		$lines = explode( ",", $local );
		foreach( $lines as $line ) {
			$parts = explode( "|", $line );
			/**
			 * only 3 parts counts
			 */
			if ( count( $parts ) != 3 ) {
				wfDebug( __METHOD__." not 3 parts." );
				continue;
			}
			$wgGroupPermissions[trim($parts[0])][trim($parts[1])] = (bool)trim($parts[2]);
		}
		wfProfileOut( __METHOD__ );
		return $wgGroupPermissions;
	}

	/**
	 * LocalToGlobalArray
	 *
	 * this routine is used for converting local array stored
	 * in WikiFactory variable to global mediawiki variable. Works only
	 * with flat arrays. Why not array_merge? For safety.
	 *
	 *
	 * @author eloy@wikia-inc.com
	 * @access public
	 * @static
	 *
	 * @param array $local: array with local values
	 * @param array $target: array with global values; by reference - local is appended here
	 * @param bool  $ignore_keys: treat $local as a hash (false) or as an array (true)
	 */
	static public function LocalToGlobalArray( $local, &$target, $ignore_keys = false ) {
		if( is_array( $local ) && count($local) ) {
			#--- target may not be initialised yet
			if( !is_array( $target ) ) {
				$target = array();
			}
			foreach( $local as $key => $value ) {
				if( is_scalar( $value ) ) {
					if ($ignore_keys) {
						$target[] = $value;
					}
					else {
						$target[ $key ] = $value;
					}
				}
			}
		}
	}

	/**
	 * debug
	 *
	 * simple conditional function for logging infos and errors
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 * @access private
	 *
	 * @param	string	$message	log message
	 *
	 * @return nothing
	 */
	private function debug( $message ) {
		wfDebug("wikifactory: {$message}", true);
		if( !empty( self::$mDebug ) ) {
			error_log("wikifactory: {$message}");
		}
	}
};
