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
    throw new ConfigException( 'Datacenter not configured in /etc/environment.' ); 
}

/**
 * Runtime environment discovered from the environment variable.
 * @deprecated Code portability: do not add more environment-specific code.
 * @var string $wgWikiaEnvironment
 */
$wgWikiaEnvironment = getenv( 'WIKIA_ENVIRONMENT' );

if ( empty( $wgWikiaEnvironment ) ) {
    throw new ConfigException( 'Environment not configured in /etc/environment.' ); 
}

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
$wgUsePathInfo = ( strpos(php_sapi_name(), 'cgi') === false ) &&
        ( strpos(php_sapi_name(), 'apache2filter') === false ) &&
        ( strpos(php_sapi_name(), 'isapi') === false );

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
$wgHTTPTimeout = defined( 'RUN_MAINTENANCE_IF_MAIN' ) ? 25 : 5; # Wikia change

/**
 * Elementary variables.
 */
require_once "$IP/includes/wikia/VariablesBase.php";

/**
 * Variable expansions.
 */
require_once "$IP/includes/wikia/VariablesExpansions.php";

/**
 * FANDOM-specific general settings.
 */
require_once "$IP/includes/wikia/DefaultSettings.php";

/**
 * Settings from Wikia/config
 */
require_once "$IP/../config/LocalSettings.php";

/**
 * Load legacy overrides. Do not add to that file
 */
require_once "$IP/../config/overrides_to_remove.php";

/**
 * Recalculate $wgScript and $wgArticlePath for wikis with language code path
 * component.
 * @see SUS-3851
 */
if ( !empty( $wgScriptPath ) ) {
       $wgScript = $wgScriptPath . $wgScript;
       $wgArticlePath = $wgScriptPath . $wgArticlePath;
}

/**
 * In some cases $wgMemc is still null at this point. Let's initialize it.
 * @see SUS-2699
 * @var string $wgDBcluster
 */
$wgMemc = wfGetMainCache();

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

require_once "$IP/includes/wikia/Extensions.php";