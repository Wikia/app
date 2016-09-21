<?php

/**
 * @package MediaWiki
 * contains all logic needed for loading and setting configuration data
 * class is used in LocalSettings
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com> for Wikia Inc.
 * @todo change use of mIsWikiaActive to a series of isClosed, isDeleted, etc. methods
 */

ini_set( "include_path", "{$IP}:{$IP}/includes:{$IP}/languages:{$IP}/lib/vendor:.:" );
ini_set( "cgi.fix_pathinfo", 1);

require_once( "$IP/includes/Defines.php" );
require_once( "$IP/includes/DefaultSettings.php" );
require_once( "$IP/includes/Hooks.php" );
require_once( "$IP/includes/GlobalFunctions.php" );
require_once( "$IP/includes/wikia/GlobalFunctions.php" );
require_once( "$IP/includes/Exception.php" );
require_once( "$IP/includes/db/Database.php" );
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

	$serverMame = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
	error_log("$serverMame ($_variable_key=$_variable_value): $errno, $errstr");
}

class WikiFactoryLoader {

	// TODO: FIXME: Why is there a mWikiID and an mCityID?
	public $mServerName, $mWikiID, $mCityHost, $mCityID, $mOldServerName;
	public $mAlternativeDomainUsed, $mCityDB, $mCityCluster, $mDebug;
	public $mDomain, $mVariables, $mIsWikiaActive, $mAlwaysFromDB;
	public $mTimestamp, $mCommandLine;
	public $mExpireDomainCacheTimeout = 86400; #--- 24 hours
	public $mExpireValuesCacheTimeout = 86400; #--- 24 hours
	public $mSaveDefaults = false;
	public $mCacheAnyway = array( "wgArticlePath" );
	public $mCheckUpgrade = false;

	private $mDBhandler, $mDBname;

	/**
	 * __construct
	 *
	 * discover which wikia we handle
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 *
	 * @param integer $id default null    explicit set wiki id
	 * @param bool|string $server_name default false    explicit set server name
	 *
	 * @return WikiFactoryLoader object
	 */
	public function  __construct( $id = null, $server_name = false ) {
		global $wgDBname, $wgDevelEnvironment, $wgDevelDomains;
		global $wgWikiFactoryDomains, $wgExternalSharedDB;

		$this->mCommandLine = false;

		if( !is_null( $id ) ) {
			/**
			 * central / dofus / memory-alpha case
			 */
			$this->mCityID = $id;
			if( $server_name === false ) {
				$this->mServerName =  empty( $_SERVER['SERVER_NAME'] )
					? false
					: $_SERVER['SERVER_NAME'];
			}
			else {
				$this->mServerName = $server_name;
			}
		}
		elseif( !empty($_SERVER['SERVER_NAME'])) {
			/**
			 * normal http request
			 */
			$this->mServerName = strtolower( $_SERVER['SERVER_NAME'] );
			$this->mCityID = false;
		}
		elseif( getenv( "SERVER_ID" ) ) {
			/**
			 * interactive/cmdline
			 */
			$this->mCityID = getenv( "SERVER_ID" );
			$this->mServerName = false;
			$this->mCommandLine = true;
		}
		elseif( getenv( "SERVER_DBNAME") ) {
			$this->mCityDB = getenv( "SERVER_DBNAME" );
			$this->mServerName = false;
			$this->mCommandLine = true;
			$this->mCityID = false;
		}
		else {
			/**
			 * hardcoded exit, nothing can be done at this point
			 */
			echo "Cannot tell which wiki it is (neither SERVER_NAME, SERVER_ID nor SERVER_DBNAME is defined)\n";
			exit(1);
		}

		/**
		 * initalizations
		 */
		$this->mDebug = false;
		$this->mOldServerName = false;
		$this->mAlternativeDomainUsed = false;
		$this->mDBname = !empty( $wgExternalSharedDB ) ? $wgExternalSharedDB : "wikicities";
		$this->mDomain = array();
		$this->mVariables = array();
		$this->mIsWikiaActive = 0;
		$this->mAlwaysFromDB = 0;
		$this->mWikiID = 0;
		$this->mDBhandler  = null;
		$this->mCityDB     = false;

		if( !empty( $wgDevelEnvironment ) ) {
			$this->mDebug = true;
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
				$name = preg_replace( "/^www\./", "", $this->mServerName );
				$pattern = "/{$domain}$/";
				if( $domain !== "wikia.com" && preg_match( $pattern, $name ) ) {
					$this->mOldServerName = $this->mServerName;
					$this->mServerName = str_replace( $domain, "wikia.com", $name );
					$this->mAlternativeDomainUsed = true;
					break;
				}
			}
		}

		WikiFactory::isUsed( true );

		/**
		 * if run via commandline always take data from database,
		 * never from cache
		 */
		if( $this->mCommandLine && $this->mAlwaysFromDB == 0 ) {
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
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 * @access public
	 *
	 * @todo change new Database to LoadBalancer factory
	 *
	 * @param int $type
	 * @return DatabaseBase database handler
	 */
	public function getDB( $type = DB_SLAVE ) {
		global $wgDBserver, $wgDBuser, $wgDBpassword;

		if( $this->mDBhandler instanceof DatabaseBase ) {
			return $this->mDBhandler;
		}

		/**
		 * get the connection handler using MW DB LoadBalabcer
		 * do not forget about destroying the loadbalancer instance
		 */
		$this->mDBhandler = wfGetDB( $type, array(), $this->mDBname );
		$this->debug( "connecting to {$this->mDBname} via LoadBalancer" );

		/**
		 * if something goes wrong just fallback to $wgDBserver
		 */
		if( !$this->mDBhandler || !$this->mDBhandler->isOpen() ) {
			error_log( "WikiFactoryLoader[{$this->mCityID}]: fallback to {$wgDBserver}" );
			$this->mDBhandler = new DatabaseMysqli( $wgDBserver, $wgDBuser, $wgDBpassword, $this->mDBname );
			$this->debug( "fallback to wgDBserver {$wgDBserver}" );
		}

		return $this->mDBhandler;
	}

	/**
	 * execute
	 *
	 * Main entry point for class
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 *
	 * @return integer: wikia id or null if wikia is not handled by WikiFactory
	 */
	public function execute() {
		global $wgCityId, $wgDevelEnvironment,
			$wgDBservers, $wgLBFactoryConf, $wgDBserver, $wgContLang, $wgWikiaBaseDomain;

		wfProfileIn(__METHOD__);

		/**
		 * Hook to allow extensions to alter the initialization.  For example,
		 * setting the mCityID then returning true will override which wiki
		 * to use.
		 *
		 * @author Sean Colombo
		 */
		if( !wfRunHooks( 'WikiFactory::execute', array( &$this ) ) ) {
			wfProfileOut(__METHOD__);
			return $this->mWikiID;
		}

		/**
		 * load balancer uses one method which demand wgContLang defined
		 * See BugId: 12474
		 */
		$wgContLang = new StubObject('wgContLang');


		/**
		 * local cache, change to CACHE_ACCEL for local
		 */
		global $wgWikiFactoryCacheType;
		$oMemc = wfGetCache( $wgWikiFactoryCacheType );

		if( empty( $this->mAlwaysFromDB ) ) {
			/**
			 * remember! for http requests we only known $this->mServerName
			 * (domain), $this->mCityId is unknown (set to false in constructor)
			 */
			wfProfileIn( __METHOD__."-domaincache" );
			$key = WikiFactory::getDomainKey( $this->mServerName );
			$this->mDomain = $oMemc->get( $key );
			$this->mDomain = isset( $this->mDomain["id"] ) ? $this->mDomain : array ();
			$this->debug( "reading from cache, key {$key}" );
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
			if( $this->mCityID || $this->mCityDB) {
				$oRow = $dbr->selectRow(
						array( "city_list" ),
						array(
							"city_id",
							"city_public",
							"city_factory_timestamp",
							"city_url",
							"city_dbname",
							"city_cluster"
						),
						($this->mCityID) ? array( "city_list.city_id" => $this->mCityID ) : array( "city_list.city_dbname" => $this->mCityDB ),
						__METHOD__ . '::domaindb'
					);

				if( isset( $oRow->city_id ) )  {
					preg_match( "/http[s]*\:\/\/(.+)$/", $oRow->city_url, $matches );
					$host = rtrim( $matches[1],  "/" );

					$this->mCityID = $oRow->city_id;
					$this->mWikiID =  $oRow->city_id;
					$this->mIsWikiaActive = $oRow->city_public;
					$this->mCityHost = $host;
					$this->mCityDB   = $oRow->city_dbname;
					$this->mCityCluster = $oRow->city_cluster;
					$this->mTimestamp = $oRow->city_factory_timestamp;
					$this->mDomain = array(
						"id" => $oRow->city_id,
						"host" => $host,
						"active" => $oRow->city_public,
						"time" =>  $oRow->city_factory_timestamp,
						"db" => $this->mCityDB
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
						"city_dbname"
					),
					array(
						"city_domains.city_id = city_list.city_id",
						"city_domains.city_domain" => $this->mServerName
					),
					__METHOD__ . '::servername'
				);
				if( isset( $oRow->city_id ) &&  $oRow->city_id > 0 ) {
					$oRow->city_domain = strtolower( $oRow->city_domain );
					preg_match( "/http[s]*\:\/\/(.+)$/", $oRow->city_url, $matches );
					$host = rtrim( $matches[1],  "/" );

					if( $oRow->city_domain == $this->mServerName && $this->mServerName ) {
						$this->mWikiID =  $oRow->city_id;
						$this->mIsWikiaActive = $oRow->city_public;
						$this->mCityHost = $host;
						$this->mCityDB   = $oRow->city_dbname;
						$this->mTimestamp = $oRow->city_factory_timestamp;
						$this->mDomain = array(
							"id"     => $oRow->city_id,
							"host"   => $host,
							"active" => $oRow->city_public,
							"time"   => $oRow->city_factory_timestamp,
							"db"     => $oRow->city_dbname
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
			$this->debug( "city_id={$this->mWikiID}, reading from database key {$this->mServerName}" );
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
			$this->mCityDB = isset( $this->mDomain[ "db" ] ) ? $this->mDomain[ "db" ] : false;
		}


		/**
		 * save default var values for Special:WikiFactory
		 * @todo this should be smarter...
		 */
		if ( $this->mWikiID == 177 ) {
			$this->mSaveDefaults = true;
		}

		/**
		 * redirection to another url
		 */
		if( $this->mIsWikiaActive == 2 ) {
			$this->debug( "city_id={$this->mWikiID};city_public={$this->mIsWikiaActive}), redirected to {$this->mCityHost}" );
			header( "X-Redirected-By-WF: 2" );
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
		$cond2 = !empty( $host ) && $this->mAlternativeDomainUsed && ( $host != $this->mOldServerName );

		if( ( $cond1 || $cond2 ) && empty( $wgDevelEnvironment ) ) {
			$url = wfGetCurrentUrl();
			/**
			 * now recombine url from parts
			 */
			if( preg_match( "!^/$path!", $url[ "path" ] ) == 0 ) {
				$url[ "path" ] = "/{$path}" . $url[ "path" ];
			}

			$target = WikiFactory::getLocalEnvURL( $url[ "scheme" ] . "://" . $host . $url[ "path" ] );
			$target = isset( $url[ "query" ] ) ? $target . "?" . $url[ "query" ] : $target;

			$this->debug( "redirected from {$url[ "url" ]} to {$target}" );

			header( "X-Redirected-By-WF: NotPrimary" );
			header( "Location: {$target}", true, 301 );
			wfProfileOut( __METHOD__ );
			exit(0);
		}

		/**
		 * if wikia is not defined or is marked for closing we redirect to
		 * Not_a_valid_Wikia
		 * @todo the -1 status should probably be removed or defined more precisely
		 */
		if( empty( $this->mWikiID ) || $this->mIsWikiaActive == -1 ) {
			if( ! $this->mCommandLine ) {
				global $wgNotAValidWikia;
				$redirect = $wgNotAValidWikia . '?from=' . rawurlencode( $this->mServerName );
				$this->debug( "redirected to {$redirect}, {$this->mWikiID} {$this->mIsWikiaActive}" );
				if( $this->mIsWikiaActive < 0 ) {
					header( "X-Redirected-By-WF: MarkedForClosing" );
				}
				else {
					header( "X-Redirected-By-WF: NotAValidWikia" );
				}
				header( "Location: $redirect" );
				wfProfileOut( __METHOD__ );
				exit(0);
			}
		}

		/**
		 * if wikia is disabled and is not Commandline mode we redirect it to
		 * dump directory.
		 */
		if( empty( $this->mIsWikiaActive ) || $this->mIsWikiaActive == -2 /* spam */ ) {
			if( ! $this->mCommandLine ) {
				global $wgNotAValidWikia;
				if( $this->mCityDB ) {
					$database = strtolower( $this->mCityDB );
					$redirect = sprintf(
						"http://%s/wiki/Special:CloseWiki/information/%s",
						($wgDevelEnvironment) ? "www.awc.wikia-inc.com" : "community.{$wgWikiaBaseDomain}",
						$database
					);
				}
				else {
					$redirect = $wgNotAValidWikia . '?from=' . rawurlencode( $this->mServerName );
				}
				$this->debug( "disabled and not commandline, redirected to {$redirect}, {$this->mWikiID} {$this->mIsWikiaActive}" );
				header( "X-Redirected-By-WF: Dump" );
				header( "Location: $redirect" );
				wfProfileOut( __METHOD__ );
				exit(0);
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
				$this->debug( "wikifactory: reading from cache, key {$key}, count ".count( $this->mVariables ) );
			}
			else {
				$this->debug( "wikifactory: timestamp doesn't match. Cache expired" );
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
				__METHOD__ . '::varsdb'
			);
			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				#--- some magic, rewritting path, etc legacy data
				global $_variable_key, $_variable_value;

				set_error_handler( "wfUnserializeHandler" );
				$_variable_key = $oRow->cv_name;
				$_variable_value = $oRow->cv_value;
				$tUnserVal = unserialize( $oRow->cv_value );
				restore_error_handler();

				if( !empty( $wgDevelEnvironment ) && $oRow->cv_name === "wgServer" ) {
					/**
					 * skip this variable
					 */
					unset($this->mVariables[ $oRow->cv_name ]);
					$this->debug( "{$oRow->cv_name} with value {$tUnserVal} skipped" );
				}
				else {
					$this->mVariables[ $oRow->cv_name ] = $tUnserVal;
				}
			}
			$dbr->freeResult( $oRes );

			/**
			 * wgArticlePath
			 */
			if ( !isset( $this->mVariables['wgArticlePath'] ) ) {
				$this->mVariables['wgArticlePath'] = $GLOBALS['wgArticlePath'];
			}

			/**
			 * read tags for this wiki, store in global variable as array
			 * @name $wgWikiFactoryTags
			 */
			wfProfileIn( __METHOD__."-tagsdb" );
			$this->mVariables[ "wgWikiFactoryTags" ] = array();
			$sth = $dbr->select(
				array( "city_tag", "city_tag_map" ),
				array( "id", "name"	),
				array(
					"city_tag.id = city_tag_map.tag_id",
					"city_id = {$this->mWikiID}"
				),
				__METHOD__ . '::tagsdb'
			);
			while( $row = $dbr->fetchObject( $sth ) ) {
				$this->mVariables[ "wgWikiFactoryTags" ][ $row->id ] = $row->name;
			}
			$dbr->freeResult( $sth );
			$this->debug( "reading tags from database, id {$this->mWikiID}, count ".count( $this->mVariables[ "wgWikiFactoryTags" ] ) );
			wfProfileOut( __METHOD__."-tagsdb" );

			if( empty($this->mAlwaysFromDB) ) {
				/**
				 * cache as well some values even if they are not defined in database
				 * it will prevent GlobalTitle from doing empty selects
				 * BugId: 12463
				 */
				foreach( $this->mCacheAnyway as $cvar ) {
					if( !isset( $this->mVariables[ $cvar ] ) && isset( $GLOBALS[ $cvar ] ) ) {
						$this->mVariables[ $cvar ] = $GLOBALS[ $cvar ];
					}
				}

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

			/**
			 * maybe upgrade database to current schema
			 */
			if( $this->mCheckUpgrade === true ) {
				$this->maybeUpgrade();
			}
		}

		# take some WF variables values from city_list
		$this->mVariables["wgDBname"] = $this->mCityDB;
		$this->mVariables["wgDBCluster"] = $this->mCityCluster;

		// @author macbre
		wfRunHooks( 'WikiFactory::executeBeforeTransferToGlobals', array( &$this ) );

		/**
		 * transfer configuration variables from database to GLOBALS
		 */
		if( is_array($this->mVariables) ) {
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
									if (isset($GLOBALS[$tKeyParsed])) {
										$tValue = str_replace($tKey, $GLOBALS[$tKeyParsed], $tValue);
									}
								}
							}
						}
					}
				}
				/**
				 * merge local values with global
				 */
				switch( $key ) {
					case "wgNamespacesWithSubpagesLocal":
						$this->LocalToGlobalArray( $tValue, $GLOBALS["wgNamespacesWithSubpages"] );
						break;

					case "wgExtraNamespacesLocal":
						$this->LocalToGlobalArray( $tValue, $GLOBALS["wgExtraNamespaces"] );
						break;

					case "wgFileExtensionsLocal":
						$this->LocalToGlobalArray( $tValue, $GLOBALS["wgFileExtensions"], true );
						break;

					case "wgTrustedMediaFormatsLocal":
						$this->LocalToGlobalArray( $tValue, $GLOBALS["wgTrustedMediaFormats"] );
						break;

					case "wgFileBlacklistLocal":
						$this->LocalToGlobalArray( $tValue, $GLOBALS["wgFileBlacklist"] );
						break;
				}

				if ($key == 'wgServer') {
					if ( !empty( $_SERVER['HTTP_X_ORIGINAL_HOST'] ) ) {
						global $wgConf;

						$stagingServer = $_SERVER['HTTP_X_ORIGINAL_HOST'];

						$tValue = 'http://'.$stagingServer;
						$wgConf->localVHosts = array_merge( $wgConf->localVHosts, [ $stagingServer ] );
					}
				}

				try {
					if ( $this->mSaveDefaults ) {
						$GLOBALS['wgPreWikiFactoryValues'][$key] = $tValue;
					}
					$GLOBALS[$key] = $tValue;
				}
				catch( Exception $e ) {
					#--- so far do nothing
				}
			}
		}
		$wgCityId = $this->mWikiID;

		/**
		 * set/replace $wgDBname in $wgDBservers
		 */
		if( isset( $wgDBservers ) && is_array( $wgDBservers ) && isset( $this->mVariables["wgDBname"] ) ) {
			foreach( $wgDBservers as $index => $server ) {
				$wgDBservers[ $index ][ "dbname" ] = $this->mVariables["wgDBname"];
			}
		}
		if( isset( $wgLBFactoryConf ) && is_array( $wgLBFactoryConf ) && isset( $this->mVariables["wgDBname"] ) ) {
			$wgLBFactoryConf['serverTemplate']['dbname'] = $this->mVariables["wgDBname"];

			/**
			 * set wgDBserver for cluster based on $wgLBFactoryConf
			 */
			$cluster = isset( $this->mVariables["wgDBcluster"] )
				? $this->mVariables["wgDBcluster"]
				: "DEFAULT";

			if( isset( $wgLBFactoryConf[ "sectionLoads" ][ $cluster ] )) {
				$keys = array_keys( $wgLBFactoryConf[ "sectionLoads" ][ $cluster ] );
				$db = array_shift( $keys );
				if( isset( $wgLBFactoryConf[ "hostsByName" ][ $db ] ) ) {
					$wgDBserver = $wgLBFactoryConf[ "hostsByName" ][ $db ];
					$this->debug( "wgDBserver for cluster {$cluster} set to {$wgDBserver}" );
				}
			}
		}

		wfRunHooks( 'WikiFactory::onExecuteComplete', array( &$this ) );

		wfProfileOut( __METHOD__ );

		/**
		 * cleanup and finally return wiki id
		 */
		LBFactory::destroyInstance();
		return $this->mWikiID;
	}

	/**
	 * This routine is used for converting string with permissions stored
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
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 * @access public
	 * @static
	 *
	 * @param string $settings: string with permissions
	 *
	 * @return array with permissions
	 */
	static public function parsePermissionsSettings( $settings ) {
		wfProfileIn( __METHOD__ );

		$lines = explode( ",", $settings );
		$permissions = array();

		foreach( $lines as $line ) {
			$parts = explode( "|", $line );
			/**
			 * only 3 parts counts
			 */
			if ( count( $parts ) != 3 ) {
				continue;
			}

			$permissions[trim($parts[0])][trim($parts[1])] = (bool)trim($parts[2]);
		}

		wfProfileOut( __METHOD__ );
		return $permissions;
	}

	/**
	 * LocalToGlobalPermissions
	 *
	 * Merges per-wiki permissions settings set in WF
	 * with the global ones in wgGroupPermissions
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 * @access public
	 * @static
	 *
	 * @param string $local: string with permissions
	 *
	 * @see parsePermissionsSettings
	 */
	static public function LocalToGlobalPermissions( $local ) {
		global $wgGroupPermissions;
		$permissions = self::parsePermissionsSettings( $local );

		foreach ( $permissions as $group => $rights ) {
			//override or add groups and rights
			$wgGroupPermissions[$group] = ( isset( $wgGroupPermissions[$group] ) ) ?
				array_merge( $wgGroupPermissions[$group], $rights ) :
				$rights;
		}
	}

	/**
	 * LocalToGlobalArray
	 *
	 * this routine is used for converting local array stored
	 * in WikiFactory variable to global mediawiki variable. Works only
	 * with flat arrays. Why not array_merge? For safety.
	 *
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 * @access public
	 *
	 * @param array $local: array with local values
	 * @param array $target: array with global values; by reference - local is appended here
	 * @param bool  $ignore_keys: treat $local as a hash (false) or as an array (true)
	 */
	public function LocalToGlobalArray( $local, &$target, $ignore_keys = false ) {
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
		if( !empty( $this->mDebug ) ) {
			error_log("wikifactory: {$message}");
		}
	}

	/**
	 * maybeUpgrade
	 *
	 * look for existence of some columns in database. If they are not exist
	 * run database upgrade  on first request. Not very efficient for regular
	 * usage but good for transition time
	 */
	private function maybeUpgrade( ) {
		wfProfileIn( __METHOD__ . "-upgradedb" );
		$dbr = $this->getDB();

		/**
		 * look for rev_sha1 in revision table
		 */
		if( !$dbr->fieldExists( "revision", "rev_sha1", __METHOD__ ) ) {
			$ret = true;
			ob_start( array( $this, 'outputHandler' ) );
			try {
				$up = DatabaseUpdater::newForDB( $this->db );
				$up->doUpdates();
			} catch ( MWException $e ) {
				$this->debug( "An error occured: " . $e->getText() );
				$ret = false;
			}
			ob_end_flush();
			wfProfileOut( __METHOD__ . "-upgradedb" );
			return $ret;
		}

		wfProfileOut( __METHOD__ . "-upgradedb" );
	}
};
