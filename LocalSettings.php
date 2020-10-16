<?php
/**
 * IP stands for Installation Path, the top folder of MediaWiki codebase.
 */
$IP = __DIR__;

/**
 * Register some $IP subdirectories in include_path to speed up imports with
 * relative paths.
 */
ini_set( 'include_path', "$IP:$IP/includes:$IP/languages:$IP/lib/vendor:.:" );

/**
 * FANDOM-specific constants.
 */
require "$IP/includes/wikia/Defines.php";

/**
 * This is used by some maintenance scripts that execute other maintenance
 * scripts and need to point them to the right LocalSettings.php.
 * @deprecated Maintenance scripts must not require --conf
 * @var string $wgWikiaLocalSettingsPath
 */
$wgWikiaLocalSettingsPath = __FILE__;

/**
 * Runtime datacenter discovered from the environment variable.
 * @deprecated Code portability: do not add more dc-specific code.
 * @var string $wgWikiaDatacenter
 */
$wgWikiaDatacenter = getenv( 'WIKIA_DATACENTER' );

if ( empty( $wgWikiaDatacenter ) ) {
    throw new RuntimeException( 'Datacenter not configured in WIKIA_DATACENTER env variable.' );
}

/**
 * Runtime environment discovered from the environment variable.
 * @deprecated Code portability: do not add more environment-specific code.
 * @see https://github.com/Wikia/chef-repo/blob/master/cookbooks/common/attributes/default.rb
 * @var string $wgWikiaEnvironment
 */
$wgWikiaEnvironment = getenv( 'WIKIA_ENVIRONMENT' );

/**
 * Force override consul suffix
 * @var string $wgForceConsulDatacenter
 */
$wgForceConsulDatacenter = getenv( 'WIKIA_FORCE_CONSUL_DATACENTER' );

// CONFIG_REVISION: remove $wgWikiaDatacenter and $wgWikiaEnvironment from the global scope and only use it to load configuration
if ( empty( $wgWikiaEnvironment ) ) {
    throw new RuntimeException( 'Environment not configured in WIKIA_ENVIRONMENT env variable.' );
}

// /docker/devbox/docker-compose web setup is not allowed to connect to production
if ( !empty( getenv( 'WIKIA_FORCE_DEV_ONLY' ) ) &&
	 $wgWikiaEnvironment !== WIKIA_ENV_DEV &&
	 !$wgCommandLineMode ) {
	throw new RuntimeException( 'This setup is not allowed to connect to production.' );
}

/**
 * Temporary variable for Kubernetes migration
 * If {@code true}, then logs will be sent to the configured socket address formatted as JSON, instead of using syslog.
 */
$wgLoggerLogToSocketOnly = $_ENV['LOG_SOCKET_ONLY'] ?? false;
$wgLoggerSocketAddress = $_ENV['LOG_SOCKET_ADDRESS'] ?? 'tcp://127.0.0.1:9999';

/* if {@code true}, then logs will be sent to STDOUT, overrides LOG_SOCKET_ONLY */
$wgLoggerLogToStdOutOnly = $_ENV['LOG_STDOUT_ONLY'] ?? false;

/**
 * Name of the Kubernetes deployment, defined if the application is running in k8s.
 * @var string|null $wgKubernetesDeploymentName
 */
$wgKubernetesDeploymentName = getenv( 'KUBERNETES_DEPLOYMENT_NAME' );

/**
 * Kubernetes namespace name, defined if the application is running in k8s.
 * @var string|null $wgKubernetesNamespace
 */
$wgKubernetesNamespace = getenv( 'KUBERNETES_NAMESPACE' );

/**
 * Proxy to use for CURL requests.
 * @see PLATFORM-1745
 * @see includes/wikia/CurlMultiClient.php
 * @see includes/HttpFunctions.php
 * @var string $wgHTTPProxy
 */
if ( !empty( $wgKubernetesDeploymentName ) ) {
	// SUS-5499: Use internal host name for MW->MW requests when running on Kubernetes
	$wgHTTPProxy = "$wgKubernetesDeploymentName.$wgKubernetesNamespace:80";
}
else {
	// SUS-5675 | TODO: remove when we switch fully to Kubernetes
	$wgHTTPProxy = 'prod.border.service.consul:80';
}

/**
 * Whether to use Kubernetes internal ingress for making requests to service dependencies on Kubernetes.
 * This is only enabled if app itself is running on Kubernetes.
 * @var bool $wgUseKubernetesInternalIngress
 */
$wgUseKubernetesInternalIngress = (bool) getenv( 'KUBERNETES_POD' );

/**
 * Some environments share components (e.g. preview, verify, sandbox and stable
 * use prod databases). This variable represents that.
 * @var string $wgRealEnvironment
 */
$wgRealEnvironment = $wgWikiaEnvironment;

/**
 * Indicate the runtime environment as dev.
 * @deprecated Code portability: do not add more environment-specific code.
 * @var bool $wgDevelEnvironment
 */
$wgDevelEnvironment = ( $wgWikiaEnvironment == WIKIA_ENV_DEV );

/**
 * Create a site configuration object. Not used for much in a default install.
 * @see includes/SiteConfiguration.php
 * @var SiteConfiguration $wgConf
 */
$wgConf = new SiteConfiguration;

/**
 * URL of the server, containing scheme and host. This is usually detected
 * correctly by MediaWiki based on information from $_SERVER. If MediaWiki
 * detects the wrong server, it will redirect incorrectly after you save a page.
 * In that case, set this variable to fix it. If you want to use
 * protocol-relative URLs on your wiki, set this to a protocol-relative URL like
 * '//example.com' and set $wgCanonicalServer to a fully qualified URL.
 * @example $wgServer = 'http://example.com';
 * @var string $wgServer
 */
$wgServer = WebRequest::detectServer();

/**
 * Whether to support URLs like index.php/Page_title These often break when PHP
 * is set up in CGI mode. PATH_INFO *may* be correct if cgi.fix_pathinfo is set,
 * but then again it may not; lighttpd converts incoming path data to lowercase
 * on systems with case-insensitive filesystems, and there have been reports of
 * problems on Apache as well. To be safe we'll continue to keep it off by
 * default. Override this to false if $_SERVER['PATH_INFO'] contains
 * unexpectedly incorrect garbage, or to true if it is really correct. The
 * default $wgArticlePath will be set based on this value at runtime, but if
 * you have customized it, having this incorrectly set to true can cause
 * redirect loops when "pretty URLs" are used.
 * @var bool $wgUsePathInfo
 */
$wgUsePathInfo = ( php_sapi_name() == 'apache2handler' ) || ( php_sapi_name() == 'fpm-fcgi' ); # Wikia change - SUS-5825

/**
 * Show EXIF data, on by default if available. Requires PHP's EXIF extension.
 * @see http://www.php.net/manual/en/ref.exif.php
 * @see includes/media
 * @see includes/ImagePage.php
 * @var boolean $wgShowEXIF
 */
$wgShowEXIF = function_exists( 'exif_read_data' );

/**
 * Use Tidy from PHP extension ("internal") rather than external binary.
 * @see $wgUseTidy
 * @var bool $wgTidyInternal
 */
$wgTidyInternal = extension_loaded( 'tidy' );

/**
 * Set $wgCommandLineMode if it's not set already, to avoid notices
 */
if (!isset($wgCommandLineMode)) {
    // TODO:log those as suspicious cases
    // is wikia logger here?
    $wgCommandLineMode = false;
}

/**
 * Global list of hooks.
 * Add a hook by doing:
 *     $wgHooks['event_name'][] = $function;
 * or:
 *     $wgHooks['event_name'][] = array($function, $data);
 * or:
 *     $wgHooks['event_name'][] = array($object, 'method');
 * or:
 *     Hooks::register($name, $callback);
 */
$wgHooks = &Hooks::getHandlersArray();

/**
 * Timeout for HTTP requests done internally
 *
 * Let's use different values when running a maintenance script (that includes Wikia Tasks)
 * and when serving HTTP request
 *
 * @see PLATFORM-2385
 * @see includes/HttpFunctions.php
 * @var int $wgHTTPTimeout
 */
$wgHTTPTimeout = ( $wgCommandLineMode ) ? 25 : 5; # Wikia change

/**
 * If true, will send MemCached debugging information to $wgDebugLogFile.
 * @see $wgDebugLogFile
 * @see includes/cache/wikia/LibmemcachedBagOStuff.php
 * @see includes/cache/MemcachedSessions.php
 * @see includes/objectcache/MemcachedPhpBagOStuff.php
 * @var bool $wgMemCachedDebug
 */
$wgMemCachedDebug = ! $wgCommandLineMode; // true unless in command line mode

/**
 * Elementary variables.
 */
require_once "$IP/includes/wikia/VariablesBase.php";
/**
 * Override some of the consul url's.
 */
if ( $wgForceConsulDatacenter ) {
	require_once "$IP/includes/wikia/VariablesDatacenterOverrides.php";
}

/**
 * Access credentials from private repository.
 */
require_once "$IP/../config/secrets.php";

/**
 * Variable expansions.
 */
require_once "$IP/includes/wikia/VariablesExpansions.php";

/**
 * FANDOM-specific general settings.
 */
require_once "$IP/includes/wikia/DefaultSettings.php";

/**
 * @see BAC-1235
 */
if ( !empty( $maintClass ) && $maintClass == 'RebuildLocalisationCache' ) {
    $wgLocalisationCacheConf['manualRecache'] = false;
}

/**
 * A collection of general-purpose functions, wf*() family.
 */
require_once "$IP/includes/GlobalFunctions.php";
require_once "$IP/includes/wikia/GlobalFunctions.php";


/**
 * Manipulate IEUrlExtension::areServerVarsBad() to work well with our Apache
 * mod_rewrite rules.
 * @see IEUrlExtension::areServerVarsBad()
 * @see includes/WebRequest.php
 */
unset( $_SERVER[ 'SERVER_SOFTWARE' ] );

/**
 * The file is generated by deploy tools upon release. It sets $wgStyleVersion
 * to proper value.
 * @see $wgStyleVersion
 */
require_once "$IP/wgStyleVersion.php";

/**
 * Set domains that should be considered local ones.
 * @see $wgConf
 * @see includes/HttpFunctions.php
 */
$wgConf->localVHosts = array_merge(
    $wgWikiFactoryDomains,
    [
        $wgWikiaBaseDomain,
        $wgFandomBaseDomain,
        $wgWikiaOrgBaseDomain,
        'memory-alpha.org',
        'wowwiki.com',
    ]
);

/**
 * Load environment-specific settings.
 * @see https://github.com/Wikia/chef-repo/blob/master/cookbooks/common/attributes/default.rb
 * @see $wgWikiaEnvironment
 */
require_once "$IP/../config/$wgWikiaEnvironment.php";

/** Load ondemand profiler configuration */
require_once "$IP/includes/wikia/Profiler.php";

/**
 * Example read-only settings.
 * @see $wgLBFactoryConf
 * @see includes/db/LBFactory.php
 * @see includes/api/wikia/ApiFetchBlob.php
 */
// $wgLBFactoryConf['readOnlyBySection']['DEFAULT'] = 'We apologise, the site is temporarily in read-only state';
// $wgLBFactoryConf['readOnlyBySection']['central'] = 'We apologise, this wiki is temporarily in read-only state';
// $wgLBFactoryConf['readOnlyBySection']['semanticdb'] = 'We apologise, this wiki will be in read-only state till about 15:00 UTC';
// $wgLBFactoryConf['readOnlyBySection']['c4'] = 'We apologise, this wiki is temporarily in read-only state';
// $wgReadOnly = 'We apologize, database maintenance in progress. Editing is locked while we update our system.';
// $wgLBFactoryConf['readOnlyBySection']['mail'] = 'We apologize, database maintenance in progress.';
// $wgLBFactoryConf['readOnlyBySection']['specials'] = 'We apologize, specials database maintenance in progress.';

/**
 * Calculate configuration for SwiftFileBackend.
 * @see includes/filerepo/backend/SwiftFileBackend.php
 * @var Array $wgFSSwiftServer
 * @var Array $wgFSSwiftConfig
 */
$wgFSSwiftServer = $wgFSSwiftDC[$wgWikiaDatacenter]['server'];
$wgFSSwiftConfig = $wgFSSwiftDC[$wgWikiaDatacenter]['config'];

/**
 * The URL path of the skins directory. Will default to "{$wgScriptPath}/skins"
 * in Setup.php.
 */
$wgStylePath = "$wgResourceBasePath/skins";

/**
 *
 */
$wgExtensionsPath = "$wgResourceBasePath/extensions";

/**
 * Declare permission settings.
 */
require "$IP/lib/Wikia/src/Service/User/Permissions/data/PermissionsDefinesBeforeWikiFactory.php";

/**
 * In some cases $wgMemc is still null at this point. Let's initialize it.
 * It is needed for loading WikiFactory variables, as that code relies on WikiDataAccess which uses memcache
 */
$wgMemc = wfGetMainCache();

/**
 * Apply WikiFactory settings.
 */
try {
    $oWiki = new WikiFactoryLoader( $_SERVER, $_ENV, $wgWikiFactoryDomains );
    $result = $oWiki->execute();

    if ( !$result ) {
        // wiki does not exist, is a redirect etc. — WikiFactoryLoader has already handled the case internally
		// we can stop processing the request here
        exit( 0 );
    }

    $wgCityId = $result;

    // we do not need the loader and the result in the global scope.
    unset( $oWiki, $result );
} catch ( InvalidArgumentException $invalidArgumentException ) {
	// SUS-5855 | the server could not understand the request due to invalid syntax, highly
	// likely host is not set properly in a HTTP request
	header( 'HTTP/1.1 400 Bad Request' );
	echo $invalidArgumentException->getMessage() . PHP_EOL;
	exit( 1 );
}

/**
 * Disabled wikis do not have $wgDBcluster set at this point. We need to skip
 * this check to allow update.php and other maintenance scripts to process
 * those wikis.
 * @see SUS-3589
 * @see maintenance/update.php
 */
if ( is_string( $wgDBcluster ) && WikiFactoryLoader::checkPerClusterReadOnlyFlag( $wgDBcluster ) ) {
    $wgReadOnly = WikiFactoryLoader::PER_CLUSTER_READ_ONLY_MODE_REASON;
}

/**
 * Discard permission settings made by WikiFactory and extensions setups.
 */
require "$IP/lib/Wikia/src/Service/User/Permissions/data/PermissionsDefinesAfterWikiFactory.php";

// The above has originally been loaded before the statement below. Yet, the
// old comment brings confusion:
//
// this has to be fired after extensions - because any extension may add some
// new permissions (initialized with their default values)
if ( !empty( $wgGroupPermissionsLocal ) ) {
    WikiFactoryLoader::LocalToGlobalPermissions( $wgGroupPermissionsLocal );
}

/**
 * User attributes that show up on the Special:Preferences page.
 * @see $wgPublicUserAttributes
 * @see $wgPrivateUserAttributes
 * @see includes/Preferences.php
 * @var Array $wgUserAttributeWhitelist
 */
$wgUserAttributeWhitelist = array_merge( $wgPublicUserAttributes, $wgPrivateUserAttributes );

require_once "$IP/includes/wikia/Emergency.php";

if ( $wgDevelEnvironment && empty( $wgRunningUnitTests ) ) {
    $wgDevBoxSettings = sprintf( '%s/../config/%s.php', $IP, wfGetEffectiveHostname() );
    if ( file_exists( $wgDevBoxSettings ) ) {
        require_once( $wgDevBoxSettings );
    }
    unset( $wgDevBoxSettings );
}

// No profiler configuration has been supplied but profiling has been explicitly requested
if ( !empty( $_GET['forceprofile'] ) && Profiler::instance() instanceof ProfilerStub ) {
	Profiler::replaceStubInstance( new ProfilerXhprof( [
		'flags' => TIDEWAYS_FLAGS_NO_BUILTINS | TIDEWAYS_FLAGS_CPU,
		'threshold' => $wgProfileLimit,
		'output' => [ 'text' ],
		'visible' => isset( $_GET['showprofile'] ),
	] ) );
}

require_once "$IP/includes/wikia/Extensions.php";
