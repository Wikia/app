<?php
// IP stands for Installation Path, the top folder of MediaWiki codebase.
$IP = __DIR__;

// Register some $IP subdirectories in include_path to speed up imports with
// relative paths.
ini_set( 'include_path', "$IP:$IP/includes:$IP/languages:$IP/lib/vendor:.:" );

// FANDOM-specific constants.
require "$IP/includes/wikia/Defines.php";

/**
 * @global string $wgWikiaLocalSettingsPath
 * This is used by some maintenance scripts that execute other maintenance
 * scripts and need to point them to the right LocalSettings.php.
 * @deprecated Maintenance scripts must not require --conf
 */
$wgWikiaLocalSettingsPath = __FILE__;
// CONFIG_REVISION: retire $wgWikiaLocalSettingsPath completely

/**
 * @global string $wgWikiaDatacenter
 * Runtime datacenter discovered from the environment variable.
 * @deprecated Code portability: do not add more dc-specific code.
 */
$wgWikiaDatacenter = getenv( 'WIKIA_DATACENTER' );

/**
 * @global string $wgWikiaEnvironment
 * Runtime environment discovered from the environment variable.
 * @deprecated Code portability: do not add more environment-specific code.
 */
$wgWikiaEnvironment = getenv( 'WIKIA_ENVIRONMENT' );

// CONFIG_REVISION: remove $wgWikiaDatacenter and $wgWikiaEnvironment from the global scope and only use it to load configuration

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

/** @see $wgUseTidy */
$wgTidyInternal = extension_loaded( 'tidy' );

/**
 * @cond file_level_code
 * Set $wgCommandLineMode if it's not set already, to avoid notices
 */
if (!isset($wgCommandLineMode)) {
    // TODO:log those as suspicious cases
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
 *      Hooks::register ...
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

require_once "$IP/includes/wikia/VariablesBase.php";
require_once "$IP/includes/wikia/VariablesExpansions.php";
require_once "$IP/includes/wikia/DefaultSettings.php";

/** TEMPORARY TO OVERRIDE VARIABLES CHANGED BY CLASS AUTOLOADER **/
/**
 * Geographical names service for Maps extension.
 * @see extensions/Maps/
 * @var string $egMapsDefaultGeoService
 */
$egMapsDefaultGeoService = 'nominatim';

/**
 * Maps service for Maps extension.
 * @see extensions/Maps/
 * @var string $egMapsDefaultService
 */
$egMapsDefaultService = 'googlemaps3';
/** END OF TEMPORARY **/


// the rest of the old contents
require "$IP/../config/LocalSettings.php";
require_once "$IP/includes/wikia/Extensions.php";

// SUS-3851 - if the wiki has a language code path component, recalculate wgScript and wgArticlePath with its value
if ( !empty( $wgScriptPath ) ) {
       $wgScript = $wgScriptPath . $wgScript;
       // CONFIG_REVISION: $wgArticlePath is set in CommonSettings.php, below is a conditional override.
       $wgArticlePath = $wgScriptPath . $wgArticlePath;
}

/* @var $wgDBcluster string */
// in some cases $wgMemc is still null at this point, let's initialize it (SUS-2699)
$wgMemc = wfGetMainCache();

// disabled wikis do not have $wgDBcluster set at this point, skip the following check
// to allow update.php and other maintenance scripts to process such wikis (SUS-3589)
if ( is_string( $wgDBcluster ) && WikiFactoryLoader::checkPerClusterReadOnlyFlag( $wgDBcluster ) ) {
	$wgReadOnly = WikiFactoryLoader::PER_CLUSTER_READ_ONLY_MODE_REASON;
}

// This is to discard permission changes made by WikiFactory and extensions
// setups.
require "$IP/lib/Wikia/src/Service/User/Permissions/data/PermissionsDefinesAfterWikiFactory.php";

// The above has originally been loaded before the statement below. Yet, the
// old comment brings confusion:
// 
// this has to be fired after extensions - because any extension may add some
// new permissions (initialized with their default values)
// CONFIG_REVISION: clarify the confusion with permissions and WikiFactory
if ( !empty( $wgGroupPermissionsLocal ) ) {
	WikiFactoryLoader::LocalToGlobalPermissions( $wgGroupPermissionsLocal );
}
