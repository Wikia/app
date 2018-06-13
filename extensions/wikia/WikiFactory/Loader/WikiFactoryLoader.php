<?php
/**
 * @package MediaWiki
 * contains all logic needed for loading and setting configuration data
 * class is used in LocalSettings
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com> for Wikia Inc.
 * @todo change use of mIsWikiaActive to a series of isClosed, isDeleted, etc. methods
 */
class WikiFactoryLoader {
	// Input variables used to identify wiki in HTTPD context

	/** @var mixed $mServerName SERVER_NAME as provided by apache */
	private $mServerName;
	/** @var string $pathParams The part of the request path excluding the language code, without a leading slash */
	private $pathParams = '';
	/** @var string $langCode Language code given in request path, if present, without a leading slash  */
	private $langCode = '';

	// Input variables used to identify wiki in CLI (e.g. maintenance script) context
	private $mCityID;
	private $mCityDB;

	private $mWikiID, $mCityUrl, $mOldServerName;
	public $mAlternativeDomainUsed, $mCityCluster;
	public $mDomain, $mVariables, $mIsWikiaActive, $mAlwaysFromDB;
	public $mTimestamp, $mCommandLine;
	public $mExpireDomainCacheTimeout = 86400; #--- 24 hours
	public $mExpireValuesCacheTimeout = 86400; #--- 24 hours
	public $mSaveDefaults = false;
	public $mCacheAnyway = array( "wgArticlePath" );


	private $mDBhandler, $mDBname;

	const PER_CLUSTER_READ_ONLY_MODE_REASON = 'This cluster is running in read-only mode.';

	/**
	 * __construct
	 *
	 * discover which wikia we handle
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 *
	 * @param array $server
	 * @param array $environment
	 * @param array $wikiFactoryDomains
	 */
	public function  __construct( array $server, array $environment, array $wikiFactoryDomains = [] ) {
		global $wgDevelEnvironment, $wgExternalSharedDB;

		// initializations
		$this->mOldServerName = false;
		$this->mAlternativeDomainUsed = false;
		$this->mDBname = $wgExternalSharedDB;
		$this->mDomain = array();
		$this->mVariables = array();
		$this->mIsWikiaActive = 0;
		$this->mAlwaysFromDB = 0;
		$this->mWikiID = 0;
		$this->mDBhandler  = null;

		if( !empty( $wgDevelEnvironment ) ) {
			$this->mAlwaysFromDB = 1;
		}

		$this->mCommandLine = false;

		if ( !empty( $server['SERVER_NAME'] ) ) {
			// normal HTTP request
			$this->mServerName = strtolower( $server['SERVER_NAME'] );

			$fullUrl =  preg_match( "/^https?:\/\//", $server['REQUEST_URI'] ) ? $server['REQUEST_URI'] :
				$server['REQUEST_SCHEME'] . '://' . $server['SERVER_NAME'] . $server['REQUEST_URI'];
			$path = parse_url( $fullUrl, PHP_URL_PATH );

			$slash = strpos( $path, '/', 1 ) ?: strlen( $path );

			if ( $slash ) {
				$languages = Language::getLanguageNames();
				$langCode = substr( $path, 1, $slash - 1 );

				if ( isset( $languages[$langCode] ) ) {
					$this->langCode = $langCode;
					$this->pathParams = substr( $path, $slash + 1 ) ?: '';
				} else {
					$this->pathParams = substr( $path, 1 );
				}
			}

			$this->mCityID = false;
		} elseif ( isset( $environment["SERVER_ID"] ) ) {
			// interactive/cmdline
			$this->mCityID = $environment["SERVER_ID"];
			$this->mServerName = false;
			$this->mCommandLine = true;
		} elseif ( isset( $environment["SERVER_DBNAME"] ) ) {
			$this->mCityDB = $environment["SERVER_DBNAME"];
			$this->mServerName = false;
			$this->mCommandLine = true;
			$this->mCityID = false;
		} else {
			// nothing can be done at this point
			throw new InvalidArgumentException( "Cannot tell which wiki it is (neither SERVER_NAME, SERVER_ID nor SERVER_DBNAME is defined)" );
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

		// remove www from domain
		$name = preg_replace( "/^www\./", "", $this->mServerName );

		foreach ( $wikiFactoryDomains as $domain ) {
			$tldLength = strlen( $this->mServerName ) - strlen( $domain );

			if ( $domain !== "wikia.com" && strpos( $this->mServerName, $domain ) === $tldLength ) {
				$this->mOldServerName = $this->mServerName;
				$this->mServerName = str_replace( $domain, "wikia.com", $name );
				$this->mAlternativeDomainUsed = true;
				break;
			}
		}

		WikiFactory::isUsed( true );

		/**
		 * if run via commandline always take data from database,
		 * never from cache
		 */
		$this->mAlwaysFromDB = $this->mCommandLine || $wgDevelEnvironment;
	}

	/**
	 * getDB
	 *
	 * Method for getting database handler. It checks if $wgDBservers is
	 * available, if yes it will take one of active slaves.
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

		if( $this->mDBhandler instanceof DatabaseBase ) {
			return $this->mDBhandler;
		}

		/**
		 * get the connection handler using MW DB LoadBalabcer
		 * do not forget about destroying the loadbalancer instance
		 */
		$this->mDBhandler = wfGetDB( $type, array(), $this->mDBname );
		$this->debug( "connecting to {$this->mDBname} via LoadBalancer" );

		Wikia\Util\Assert::true(
			$this->mDBhandler instanceof DatabaseBase && $this->mDBhandler->isOpen(),
			__METHOD__
		);

		return $this->mDBhandler;
	}

	/**
	 * execute
	 *
	 * Main entry point for class
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 *
	 * @return int|bool wiki ID if wiki was found, false if wiki was not found, is a redirect etc.
	 * If false is returned, the caller must stop processing the request and exit immediately,
	 * as WikiFactoryLoader will have already taken the required steps to serve the request
	 * (e.g. setting 301 redirect status code).
	 */
	public function execute() {
		global $wgCityId, $wgDevelEnvironment,
			$wgDBservers, $wgLBFactoryConf, $wgDBserver, $wgContLang, $wgWikiaBaseDomain, $wgArticlePath;

		wfProfileIn(__METHOD__);

		/**
		 * Hook to allow extensions to alter the initialization.  For example,
		 * setting the mCityID then returning true will override which wiki
		 * to use.
		 *
		 * @author Sean Colombo
		 */
		if ( !Hooks::run( 'WikiFactory::execute', [ $this ] ) ) {
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
			$key = WikiFactory::getDomainKey( rtrim( $this->mServerName . '/' . $this->langCode, '/' ) );
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
					$this->mCityID = $oRow->city_id;
					$this->mWikiID =  $oRow->city_id;
					$this->mIsWikiaActive = $oRow->city_public;
					$this->mCityUrl = rtrim( $oRow->city_url, '/' );
					$this->mCityDB   = $oRow->city_dbname;
					$this->mCityCluster = $oRow->city_cluster;
					$this->mTimestamp = $oRow->city_factory_timestamp;
					$this->mDomain = array(
						"id" => $oRow->city_id,
						"url" => $oRow->city_url,
						"active" => $oRow->city_public,
						"time" =>  $oRow->city_factory_timestamp,
						"db" => $this->mCityDB,
						"cluster" => $oRow->city_cluster,
					);
				}
			} else {
				// request from HTTPD case.
				// We only know server name so we have to ask city_domains table

				$where = [
					'city_domains.city_id = city_list.city_id',
					'city_domains.city_domain' => rtrim( $this->mServerName . '/' . $this->langCode, '/' )
				];

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
						"city_dbname",
						"city_cluster"
					),
					$where,
					__METHOD__ . '::servername'
				);
				if( isset( $oRow->city_id ) &&  $oRow->city_id > 0 ) {
					$oRow->city_domain = strtolower( $oRow->city_domain );

					$this->mWikiID =  $oRow->city_id;
					$this->mIsWikiaActive = $oRow->city_public;
					$this->mCityUrl = rtrim( $oRow->city_url, '/' );
					$this->mCityDB   = $oRow->city_dbname;
					$this->mCityCluster = $oRow->city_cluster;
					$this->mTimestamp = $oRow->city_factory_timestamp;
					$this->mDomain = array(
						"id"     => $oRow->city_id,
						"url"   => $this->mCityUrl,
						"active" => $oRow->city_public,
						"time"   => $oRow->city_factory_timestamp,
						"db"     => $oRow->city_dbname,
						"cluster" => $oRow->city_cluster,
					);
				}
			}
			if( empty($this->mAlwaysFromDB) && !empty( $this->mWikiID ) ) {
				/**
				 * store value in cache
				 */
				$oMemc->set(
					WikiFactory::getDomainKey( rtrim( $this->mServerName . '/' . $this->langCode, '/' ) ),
					$this->mDomain,
					$this->mExpireDomainCacheTimeout
				);
			}
			$this->debug( "city_id={$this->mWikiID}, reading from database key {$this->mServerName}" );
			wfProfileOut( __METHOD__."-domaindb" );
		} else {
			/**
			 * data taken from cache
			 */
			$this->mWikiID = $this->mDomain["id"];
			$this->mCityUrl = $this->mDomain["url"];
			$this->mIsWikiaActive = $this->mDomain["active"];
			$this->mTimestamp = isset( $this->mDomain["time"] ) ? $this->mDomain["time"] : null;
			$this->mCityDB = isset( $this->mDomain[ "db" ] ) ? $this->mDomain[ "db" ] : false;
			$this->mCityCluster = $this->mDomain["cluster"];
		}


		/**
		 * if wikia is not defined or is marked for closing we redirect to
		 * Not_a_valid_Wikia
		 * @todo the -1 status should probably be removed or defined more precisely
		 */
		if ( empty( $this->mWikiID ) || $this->mIsWikiaActive == - 1 ) {
			if ( !$this->mCommandLine ) {
				global $wgNotAValidWikia;
				$redirect = $wgNotAValidWikia . '?from=' . rawurlencode( $this->mServerName );
				$this->debug( "redirected to {$redirect}, {$this->mWikiID} {$this->mIsWikiaActive}" );
				if ( $this->mIsWikiaActive < 0 ) {
					header( "X-Redirected-By-WF: MarkedForClosing" );
				} else {
					header( "X-Redirected-By-WF: NotAValidWikia" );
				}
				header( "Location: $redirect" );
				wfProfileOut( __METHOD__ );

				return false;
			}
		}

		/**
		 * save default var values for Special:WikiFactory
		 */
		if ( $this->mWikiID == Wikia::COMMUNITY_WIKI_ID ) {
			$this->mSaveDefaults = true;
		}

		/**
		 * redirection to another url
		 * Make sure we are not running in command line mode where redirects have no sense at all
		 */
		if( $this->mIsWikiaActive == 2 && !$this->mCommandLine ) {
			$this->debug( "city_id={$this->mWikiID};city_public={$this->mIsWikiaActive}), redirected to {$this->mCityUrl}" );
			header( "X-Redirected-By-WF: 2" );
			header( "Location: {$this->mCityUrl}/", true, 301 );
			wfProfileOut( __METHOD__ );
			return false;
		}

		$url = parse_url( $this->mCityUrl );

		// check if domain from browser is different than main domain for wiki
		$cond1 = !empty( $this->mServerName ) &&
				 ( strtolower( $url['host'] ) != $this->mServerName || rtrim( $url['path'] ?? '', '/' ) !== rtrim( "/{$this->langCode}", '/' ) );

		/**
		 * check if not additional domain was used (then we redirect anyway)
		 */
		$cond2 = $this->mAlternativeDomainUsed && ( $url['host'] != $this->mOldServerName );

		if( ( $cond1 || $cond2 ) && empty( $wgDevelEnvironment ) ) {
			$redirectUrl = WikiFactory::getLocalEnvURL( $this->mCityUrl );

			if ( !empty( $_SERVER['HTTP_FASTLY_SSL'] ) &&
				 !empty( $_SERVER['HTTP_FASTLY_FF'] ) &&
				 wfHttpsAllowedForURL( $redirectUrl )
			) {
				$redirectUrl = wfHttpToHttps( $redirectUrl );
			}
			$target = rtrim( $redirectUrl, '/' ) . '/' . $this->pathParams;

			$queryParams = $_GET;
			$localArticlePathClean = str_replace( '$1', '', $wgArticlePath );
			if ( !empty( $localArticlePathClean ) &&
				!empty( $queryParams['title'] ) &&
				startsWith( $this->pathParams,  ltrim( $localArticlePathClean, '/' ) ) ) {
				// skip the 'title' which is part of the $target, but append remaining parameters
				unset( $queryParams['title'] );
			}

			if ( !empty( $queryParams ) ) {
				$target .= '?' . http_build_query( $queryParams );
			}

			header( "X-Redirected-By-WF: NotPrimary" );
			header( 'Vary: Cookie,Accept-Encoding' );

			global $wgCookiePrefix;
			$hasAuthCookie = !empty( $_COOKIE[\Wikia\Service\User\Auth\CookieHelper::ACCESS_TOKEN_COOKIE_NAME] ) ||
				!empty( $_COOKIE[session_name()] ) ||
				!empty( $_COOKIE["{$wgCookiePrefix}Token"] ) ||
				!empty( $_COOKIE["{$wgCookiePrefix}UserID"] );

			if ( $hasAuthCookie ) {
				header( 'Cache-Control: private, must-revalidate, max-age=0' );
			} else {
				header( 'Cache-Control: s-maxage=86400, must-revalidate, max-age=0' );
			}

			header( "Location: {$target}", true, 301 );
			wfProfileOut( __METHOD__ );
			return false;
		}

		/**
		 * if wikia is disabled and is not Commandline mode we redirect it to
		 * dump directory.
		 */
		if( empty( $this->mIsWikiaActive ) || $this->mIsWikiaActive == -2 /* spam */ ) {
			if( ! $this->mCommandLine ) {
				if ( $this->mCityDB ) {
					include __DIR__ . '/closedWikiHandler.php';
				} else {
					global $wgNotAValidWikia;
					$redirect = $wgNotAValidWikia . '?from=' . rawurlencode( $this->mServerName );
					$this->debug( "disabled and not commandline, redirected to {$redirect}, {$this->mWikiID} {$this->mIsWikiaActive}" );
					header( "X-Redirected-By-WF: Dump" );
					header( "Location: $redirect" );

					wfProfileOut( __METHOD__ );
					return false;
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
				$this->debug( "wikifactory: reading from cache, key {$key}, count ".count( $this->mVariables ) );
			}
			else {
				$this->debug( "wikifactory: timestamp doesn't match. Cache expired" );
			}
			wfProfileOut( __METHOD__."-varscache" );
		}

		/**
		 * the list of variables is empty (cache miss), get them from the database
		 */
		if( empty( $this->mVariables ) ) {
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

				set_error_handler( 'WikiFactory::unserializeHandler' );
				$_variable_key = $oRow->cv_name;
				$_variable_value = $oRow->cv_value;
				$tUnserVal = unserialize( $oRow->cv_value, [ 'allowed_classes' => false ] );
				restore_error_handler();

				$this->mVariables[ $oRow->cv_name ] = $tUnserVal;
			}
			$dbr->freeResult( $oRes );

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
		}

		# take some WF variables values from city_list
		$this->mVariables['wgDBname'] = $this->mCityDB;
		$this->mVariables['wgDBcluster'] = $this->mCityCluster;
		$this->mVariables['wgServer'] = WikiFactory::getLocalEnvURL( WikiFactory::cityUrlToDomain( $this->mCityUrl ) );
		$this->mVariables['wgScriptPath'] = WikiFactory::cityUrlToLanguagePath( $this->mCityUrl );
		$this->mVariables['wgScript'] = WikiFactory::cityUrlToWgScript( $this->mCityUrl );
		$this->mVariables['wgArticlePath'] = WikiFactory::cityUrlToArticlePath( $this->mCityUrl, $this->mWikiID );

		// @author macbre
		Hooks::run( 'WikiFactory::executeBeforeTransferToGlobals', [ $this ] );

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
					// TODO - what about wgServer value for requests that did not go through Fastly?
					if ( !empty( $_SERVER['HTTP_FASTLY_SSL'] ) ) {
						$tValue = wfHttpToHttps( $tValue );
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

		Hooks::run( 'WikiFactory::onExecuteComplete', [ $this ] );

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
	 */
	private function debug( $message ) {
		wfDebug("wikifactory: {$message}", true);
	}

	/**
	 * Check the value of "wgReadOnlyCluster" WikiFactory variable defined for community.wikia.com
	 * that controls which DB cluster is in read-only mode.
	 *
	 * @author macbre
	 * @see SUS-1634
	 *
	 * An example:
	 * $wgReadOnlyCluster = "c1"; // this will turn on read-only mode on all c1 wikis
	 *
	 * @param string $cluster
	 * @return bool if true is returned, the caller should set $wgReadOnly flag
	 */
	public static function checkPerClusterReadOnlyFlag( string $cluster ) : bool {
		// we're already in DB read-only mode (are we in Reston DC?), leave early
		global $wgDBReadOnly;
		if ( $wgDBReadOnly === true ) {
			return false;
		}

		$readOnlyCluster = WikiFactory::getVarValueByName( 'wgReadOnlyCluster', Wikia::COMMUNITY_WIKI_ID );
		return $readOnlyCluster === $cluster;
	}
}
