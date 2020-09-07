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
	/** @var array parsedUrl Parsed request url with language code removed from the path */
	private $parsedUrl = '';
	/** @var string $langCode Language code given in request path, if present, without a leading slash  */
	private $langCode = '';
	/** @var bool $mWikiIdForced set to true if a wiki was forced via X-Mw-Wiki-Id header */
	private $mWikiIdForced = false;

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
		global $wgDevelEnvironment, $wgExternalSharedDB, $wgWikiaBaseDomain, $wgEnvironmentDomainMappings,
			   $wgCommandLineMode, $wgKubernetesDeploymentName;

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

		/**
		 * Check if we're running in command line mode
		 *
		 * Set a default value of the flag below to avoid /proxy.php requests for closed wikis
		 * to render a "this wiki is closed" web page
		 *
		 * @see SUS-6026
		 */
		$this->mCommandLine = $wgCommandLineMode || (
				// SER-3981 RTBF process has been moved to UCP, the tasks need to be run on closed wikis
				!empty( $server['HTTP_X_DISABLE_CLOSED_WIKI_HANDLING'] )
				&& !empty( $server['HTTP_X_WIKIA_INTERNAL_REQUEST'] )
			);

		if ( !empty( $server['HTTP_X_MW_WIKI_ID'] ) ) {
			// SUS-5816 | a special HTTP request with wiki ID forced via request header
			$this->mCityID = (int) $server['HTTP_X_MW_WIKI_ID'];

			// fill all required fields so that caching works correctly in
			// WikiFactoryLoader::execute()
			$this->parsedUrl = parse_url( WikiFactory::getWikiByID( $this->mCityID )->city_url );
			$this->mServerName = $this->parsedUrl['host'];
			$this->langCode = $this->parsedUrl['path'];
			$this->mWikiIdForced = true;

			// differ CDN caching on X-Mw-Wiki-Id request header value
			RequestContext::getMain()->getOutput()->addVaryHeader( WebRequest::MW_WIKI_ID_HEADER );
		}
		elseif ( !empty( $server['SERVER_NAME'] ) ) {
			// normal HTTP request
			$this->mServerName = strtolower( $server['SERVER_NAME'] );
			$fullUrl =  self::getCurrentRequestUri( $server );
			$this->parsedUrl = parse_url( $fullUrl );

			$slash = strpos( $this->parsedUrl['path'], '/', 1 ) ?: strlen( $this->parsedUrl['path'] );

			if ( $slash ) {
				$languages = Language::getLanguageNames();
				$langCode = substr( $this->parsedUrl['path'], 1, $slash - 1 );

				if ( isset( $languages[$langCode] ) ) {
					$this->langCode = $langCode;
					$this->parsedUrl['path'] = substr( $this->parsedUrl['path'], $slash ) ?: '/';
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

		$this->mServerName = wfNormalizeHost( $this->mServerName );

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
		 * additionally we remove www. prefix
		 */
		foreach ( $wikiFactoryDomains as $domain ) {
			$tldLength = strlen( $this->mServerName ) - strlen( $domain );

			if ( $domain !== $wgWikiaBaseDomain && strpos( $this->mServerName, $domain ) === $tldLength ) {
				$this->mOldServerName = $this->mServerName;
				$this->mServerName = str_replace( $domain, $wgWikiaBaseDomain, $this->mServerName );
				// remove extra www. prefix from domain
				if ( $this->mServerName !== ( 'www.' . $wgWikiaBaseDomain ) ) {  // skip canonical wikia global host
					$this->mServerName = preg_replace( "/^www\./", "", $this->mServerName );
				}
				$this->mAlternativeDomainUsed = true;
				break;
			}
		}

		WikiFactory::isUsed( true );

		/**
		 * if run via commandline always take data from database,
		 * never from cache
		 */
		$this->mAlwaysFromDB = $this->mCommandLine || $this->mAlwaysFromDB;

		if ( empty( $wgKubernetesDeploymentName ) ) {
			// PLATFORM-4104 on apaches log request details
			$log = \Wikia\Logger\WikiaLogger::instance();
			$details = [
				'parsedUrl' => json_encode( $this->parsedUrl )
			];
			foreach([
				'HTTP_X_WIKIA_INTERNAL_REQUEST' => 'wikiaInternalRequest',
				'HTTP_USER_AGENT' => 'userAgent',
				'HTTP_X_TRACE_ID' => 'traceId',
				'HTTP_X_CLIENT_IP' => 'client_ip',
				'REQUEST_URI' => 'requestUri',
				'REQUEST_METHOD' => 'requestMethod'
					] as $header => $key) {
				$details[ $key ] = isset( $server[$header] ) ? $server[$header] : '';
			}
			$log->info('apache request received', $details );
		}

	}

	/**
	 * Return current request uri received by the HTTP server.
	 *
	 * @param $server array of server variables (usually $_SERVER)
	 * @param $localEnvUrl if true, includes staging/dev env part of the address, when false, returns wiki canonical url
	 * @param $detectHttps detect and return https requests based on Fastly headers
	 */
	public static function getCurrentRequestUri( $server, $localEnvUrl=false, $detectHttps=false ) {
		$uri = preg_match( "/^https?:\/\//", $server['REQUEST_URI'] ) ? $server['REQUEST_URI'] :
			$server['REQUEST_SCHEME'] . '://' . $server['SERVER_NAME'] . $server['REQUEST_URI'];
		if ( $localEnvUrl ) {
			$uri = WikiFactory::getLocalEnvURL( $uri );
		}
		if ( $detectHttps && !empty( $server['HTTP_FASTLY_FF'] ) && !empty( $server['HTTP_FASTLY_SSL'] ) ) {
			$uri = wfHttpToHttps( $uri );
		}
		return $uri;
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
		global $wgCityId, $wgDBservers, $wgLBFactoryConf, $wgDBserver, $wgContLang, $wgFandomBaseDomain,
			   $wgWikiaBaseDomain, $wgWikiaOrgBaseDomain, $wgDevelEnvironment, $wgIncludeClosedWikiHandler;

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

		// Override wikia.com related config early when requesting a fandom.com wiki
		if ( !$wgDevelEnvironment && strpos( $this->mServerName, '.' . $wgFandomBaseDomain ) !== false ) {
			$GLOBALS['wgServicesExternalDomain'] = "https://services.{$wgFandomBaseDomain}/";
			$GLOBALS['wgCookieDomain'] = ".{$wgFandomBaseDomain}";
		}

		// Override wikia.org related config
		if ( !$wgDevelEnvironment && strpos( $this->mServerName, '.' . $wgWikiaOrgBaseDomain ) !== false ) {
			$GLOBALS['wgServicesExternalDomain'] = "https://services.{$wgWikiaOrgBaseDomain}/";
			$GLOBALS['wgCookieDomain'] = ".{$wgWikiaOrgBaseDomain}";
		}

		/**
		 * load balancer uses one method which demand wgContLang defined
		 * See BugId: 12474
		 * temporarily set it to English as $wgContLang is required when reading query paramaters
		 * in the WebRequest class. Later on this variable is overridden with the correct language
		 * in Setup.php
		 */
		$wgContLang = Language::factory( 'en' );

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
				} elseif ( empty( $this->mWikiID ) && $this->hasLanguagePathWikis() ) {
					// // no city was found but this is a language wikis index page

					// load the wikis index data from the DB and prepare this->mDomain so this gets cached for the
					// requested domain
					$oRow = $dbr->selectRow( ["city_list"],
						array(
							"city_public",
							"city_factory_timestamp",
							"city_dbname",
							"city_cluster"
						),
						[ "city_id" => WikiFactory::LANGUAGE_WIKIS_INDEX ],
						__METHOD__ . ':languagewikisindex'
					);
					if( isset( $oRow->city_dbname ) ) {
						$this->mWikiID = WikiFactory::LANGUAGE_WIKIS_INDEX;
						$this->mCityUrl = 'https://' . $this->mServerName;
						$this->mIsWikiaActive = $oRow->city_public;
						$this->mCityDB   = $oRow->city_dbname;
						$this->mCityCluster = $oRow->city_cluster;
						$this->mTimestamp = $oRow->city_factory_timestamp;
						// note, the data below will be cached for 1 day ($this->mExpireDomainCacheTimeout)
						$this->mDomain = [
							"id"     => $this->mWikiID,
							"url"   => $this->mCityUrl,
							"active" => $oRow->city_public,
							"time"   => $oRow->city_factory_timestamp,
							"db"     => $oRow->city_dbname,
							"cluster" => $oRow->city_cluster,
						];
					}
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
				if (  wfHttpsAllowedForURL( $redirect ) && !empty( $_SERVER['HTTP_FASTLY_FF'] ) ) {
					$redirect = wfHttpToHttps( $redirect );
				}
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

		// Emit surrogate keys now so every wiki response is covered
		$surrogateKey = Wikia::wikiSurrogateKey( $this->mWikiID );
		if ( $surrogateKey ) {
			// also add mediawiki-specific key
			$surrogateKeys = [$surrogateKey, $surrogateKey . '-mediawiki'];
			Wikia::setSurrogateKeysHeaders( $surrogateKeys, true );
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

		// PLATFORM-3878 - needed while switching community to fandom.com, to be removed afterwards.
		// For api calls to community, fake the mServerName value so it matches city_url. This
		// stops the redirects and allows the api to be used on every community domain configured
		// in WikiFactory.
		if ( $this->mWikiID == WikiFactory::COMMUNITY_CENTRAL && isset( $this->parsedUrl['path'] ) ) {
			if ( strpos( $this->parsedUrl['path'], '/api.php' ) === 0 ||
				 strpos( $this->parsedUrl['path'], '/wikia.php' ) === 0 ||
				 strpos( $this->parsedUrl['path'], '/api/v1' ) === 0 ) {
				$this->mServerName = strtolower( $url['host'] );
			}
		}
		// end of PLATFORM-3878 hack

		// PLATFORM-4025 - needed to migrate slot1.wikia.com to fandom.com, to be removed afterwards.
		// Allows everything but the article path (/wiki/) to work over every community domain configured
		// in WikiFactory.
		if ( $this->mWikiID == 470538
			&& isset( $this->parsedUrl['path'] )
			&& strpos( $this->parsedUrl['path'], '/wiki/' ) !== 0
		) {
			$this->mServerName = strtolower( $url['host'] );
		}
		// end of PLATFORM-4025 hack

		// check if domain from browser is different than main domain for wiki
		$cond1 = !empty( $this->mServerName ) && $this->mWikiIdForced === false &&
				 ( strtolower( $url['host'] ) != $this->mServerName || rtrim( $url['path'] ?? '', '/' ) !== rtrim( "/{$this->langCode}", '/' ) );

		/**
		 * check if not additional domain was used (then we redirect anyway)
		 */
		$cond2 = $this->mAlternativeDomainUsed &&
			( $url['host'] != wfNormalizeHost( $this->mOldServerName ) );

		$redirectUrl = WikiFactory::getLocalEnvURL( $this->mCityUrl );
		$shouldUseHttps = wfHttpsAllowedForURL( $redirectUrl ) &&
			// don't redirect internal clients
			!empty( $_SERVER['HTTP_FASTLY_FF'] );

		$shouldUpgradeToHttps = $shouldUseHttps && empty( $_SERVER['HTTP_FASTLY_SSL'] );

		if ( $cond1 || $cond2 || $shouldUpgradeToHttps ) {
			if ( $shouldUseHttps ) {
				$redirectUrl = wfHttpToHttps( $redirectUrl );
			}
			if ( isset( $this->parsedUrl['path'] ) ) {
				$redirectUrl .= $this->parsedUrl['path'];
			}
			if ( isset( $this->parsedUrl['query'] ) ) {
				$redirectUrl .= '?' . $this->parsedUrl['query'];
			}
			if ( isset( $this->parsedUrl['fragment'] ) ) {
				$redirectUrl .= '#' . $this->parsedUrl['fragment'];
			}

			$redirectedBy = [];
			if ( $shouldUpgradeToHttps ) $redirectedBy[] = 'AnonsHTTPSUpgrade';
			if ( $cond1 ) $redirectedBy[] = 'NotPrimary';
			if ( $cond2 ) $redirectedBy[] = 'AlternativeDomain';
			$redirectedBy = join( ' ', $redirectedBy );

			global $wgSkipWFLRedirect;
			if ( !empty( $wgSkipWFLRedirect ) ) {
				RequestContext::getMain()->getOutput()->redirect(
					$redirectUrl, 301, $redirectedBy );
			} else {
				header( 'X-Redirected-By-WF: ' . $redirectedBy );
				header( RequestContext::getMain()->getOutput()->getVaryHeader() );

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

				header( "Location: {$redirectUrl}", true, 301 );
				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		/**
		 * if wikia is disabled and is not Commandline mode we redirect it to
		 * dump directory.
		 */
		if( empty( $this->mIsWikiaActive ) || $this->mIsWikiaActive == -2 /* spam */ ) {
			if( ! $this->mCommandLine ) {
				if ( $this->mCityDB ) {
					$wgIncludeClosedWikiHandler = true;
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

		#Fix shared uploads to UCP wikis
		if (
			!empty( $this->mVariables['wgUseSharedUploads'] ) &&
			!empty( $this->mVariables['wgSharedUploadDBname'] ) &&
			$this->mWikiID !== Wikia::COMMUNITY_WIKI_ID
		) {
			$dbr = $this->getDB();
			$partnerWikiData = $dbr->selectRow(
				[ "city_list" ],
				[
					"city_id",
					"city_url",
					"city_dbname",
					"city_path",
				],
				[ "city_dbname" => $this->mVariables[ 'wgSharedUploadDBname' ] ]
			);

			if ( !empty( $partnerWikiData ) && WikiFactory::isUCPWiki( $partnerWikiData->city_id ) ) {
				unset( $this->mVariables[ 'wgSharedUploadDBname' ] );
				unset( $this->mVariables[ 'wgUseSharedUploads' ] );

				$url = rtrim( WikiFactory::getLocalEnvURL( $partnerWikiData->city_url ), '/' ) . '/api.php';

				$this->mVariables['wgForeignFileRepos'][] = [
					'name' => 'sharedUploadHack',
					'class' => 'ForeignAPIRepo',
					'apibase' => $url,
					'hashLevels' => 2,
					'apiThumbCacheExpiry' => 0
				];

			}

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
	 * Check whether the current wiki is at the root of the domain and has language wikis hosted under path prefixes.
	 * @return bool
	 */
	private function hasLanguagePathWikis() {
		if ( empty( $this->langCode ) ) {
			if ( count( WikiFactory::getWikisUnderDomain( $this->mServerName, false ) ) > 0 ) {
				return true;
			}
		}
		return false;
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
