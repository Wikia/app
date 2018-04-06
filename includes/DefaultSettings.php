<?php
/**
 * @file
 *
 *                 NEVER EDIT THIS FILE
 *
 *
 * To customize your installation, edit "LocalSettings.php". If you make
 * changes here, they will be lost on next upgrade of MediaWiki!
 *
 * In this file, variables whose default values depend on other
 * variables are set to false. The actual default value of these variables
 * will only be set in Setup.php, taking into account any custom settings
 * performed in LocalSettings.php.
 *
 * Documentation is in the source and on:
 * http://www.mediawiki.org/wiki/Manual:Configuration_settings
 */
/**
 * @cond file_level_code
 * This is not a valid entry point, perform no further processing unless MEDIAWIKI is defined
 */
if (!defined('MEDIAWIKI')) {
    echo "This file is part of MediaWiki and is not a valid entry point\n";
    die(1);
}

# Create a site configuration object. Not used for much in a default install.
# Note: this (and other things) will break if the autoloader is not enabled.
# Please include includes/AutoLoader.php before including this file.
$wgConf = new SiteConfiguration;
/** @endcond */
/**
 * URL of the server.
 *
 * Example:
 * <code>
 * $wgServer = 'http://example.com';
 * </code>
 *
 * This is usually detected correctly by MediaWiki. If MediaWiki detects the
 * wrong server, it will redirect incorrectly after you save a page. In that
 * case, set this variable to fix it.
 *
 * If you want to use protocol-relative URLs on your wiki, set this to a
 * protocol-relative URL like '//example.com' and set $wgCanonicalServer
 * to a fully qualified URL.
 */
$wgServer = WebRequest::detectServer();

/* * ********************************************************************* *//**
 * @name   Script path settings
 * @{
 */
/**
 * Whether to support URLs like index.php/Page_title These often break when PHP
 * is set up in CGI mode. PATH_INFO *may* be correct if cgi.fix_pathinfo is set,
 * but then again it may not; lighttpd converts incoming path data to lowercase
 * on systems with case-insensitive filesystems, and there have been reports of
 * problems on Apache as well.
 *
 * To be safe we'll continue to keep it off by default.
 *
 * Override this to false if $_SERVER['PATH_INFO'] contains unexpectedly
 * incorrect garbage, or to true if it is really correct.
 *
 * The default $wgArticlePath will be set based on this value at runtime, but if
 * you have customized it, having this incorrectly set to true can cause
 * redirect loops when "pretty URLs" are used.
 */
$wgUsePathInfo = ( strpos(php_sapi_name(), 'cgi') === false ) &&
        ( strpos(php_sapi_name(), 'apache2filter') === false ) &&
        ( strpos(php_sapi_name(), 'isapi') === false );

/* * ********************************************************************* *//**
 * @name   URLs and file paths
 *
 * These various web and file path variables are set to their defaults
 * in Setup.php if they are not explicitly set from LocalSettings.php.
 *
 * These will relatively rarely need to be set manually, unless you are
 * splitting style sheets or images outside the main document root.
 *
 * In this section, a "path" is usually a host-relative URL, i.e. a URL without
 * the host part, that starts with a slash. In most cases a full URL is also
 * acceptable. A "directory" is a local file path.
 *
 * In both paths and directories, trailing slashes should not be included.
 *
 * @{
 */
/**
 * The URL path of the skins directory. Will default to "{$wgScriptPath}/skins" in Setup.php
 */
$wgStylePath = false;

/**
 * The URL path for primary article page views. This path should contain $1,
 * which is replaced by the article title.
 *
 * Will default to "{$wgScript}/$1" or "{$wgScript}?title=$1" in Setup.php,
 * depending on $wgUsePathInfo.
 */
$wgArticlePath = false;

/**
 * Show EXIF data, on by default if available.
 * Requires PHP's EXIF extension: http://www.php.net/manual/en/ref.exif.php
 *
 * NOTE FOR WINDOWS USERS:
 * To enable EXIF functions, add the following lines to the
 * "Windows extensions" section of php.ini:
 *
 * extension=extensions/php_mbstring.dll
 * extension=extensions/php_exif.dll
 */
$wgShowEXIF = function_exists('exif_read_data');

/**
 * list of trusted media-types and mime types.
 * Use the MEDIATYPE_xxx constants to represent media types.
 * This list is used by File::isSafeFile
 *
 * Types not listed here will have a warning about unsafe content
 * displayed on the images description page. It would also be possible
 * to use this for further restrictions, like disabling direct
 * [[media:...]] links for non-trusted formats.
 */
$wgTrustedMediaFormats = array(
    MEDIATYPE_BITMAP, //all bitmap formats
    MEDIATYPE_AUDIO, //all audio formats
    MEDIATYPE_VIDEO, //all plain video formats
    "image/svg+xml", //svg (only needed if inline rendering of svg is not supported)
    "application/pdf", //PDF files
        #"application/x-shockwave-flash", //flash/shockwave movie
);

/**
 * Configuration for different virus scanners. This an associative array of
 * associative arrays. It contains one setup array per known scanner type.
 * The entry is selected by $wgAntivirus, i.e.
 * valid values for $wgAntivirus are the keys defined in this array.
 *
 * The configuration array for each scanner contains the following keys:
 * "command", "codemap", "messagepattern":
 *
 * "command" is the full command to call the virus scanner - %f will be
 * replaced with the name of the file to scan. If not present, the filename
 * will be appended to the command. Note that this must be overwritten if the
 * scanner is not in the system path; in that case, plase set
 * $wgAntivirusSetup[$wgAntivirus]['command'] to the desired command with full
 * path.
 *
 * "codemap" is a mapping of exit code to return codes of the detectVirus
 * function in SpecialUpload.
 *   - An exit code mapped to AV_SCAN_FAILED causes the function to consider
 *     the scan to be failed. This will pass the file if $wgAntivirusRequired
 *     is not set.
 *   - An exit code mapped to AV_SCAN_ABORTED causes the function to consider
 *     the file to have an usupported format, which is probably imune to
 *     virusses. This causes the file to pass.
 *   - An exit code mapped to AV_NO_VIRUS will cause the file to pass, meaning
 *     no virus was found.
 *   - All other codes (like AV_VIRUS_FOUND) will cause the function to report
 *     a virus.
 *   - You may use "*" as a key in the array to catch all exit codes not mapped otherwise.
 *
 * "messagepattern" is a perl regular expression to extract the meaningful part of the scanners
 * output. The relevant part should be matched as group one (\1).
 * If not defined or the pattern does not match, the full message is shown to the user.
 */
$wgAntivirusSetup = array(
    #setup for clamav
    'clamav' => array(
        'command' => "clamscan --no-summary ",
        'codemap' => array(
            "0" => AV_NO_VIRUS, # no virus
            "1" => AV_VIRUS_FOUND, # virus found
            "52" => AV_SCAN_ABORTED, # unsupported file format (probably imune)
            "*" => AV_SCAN_FAILED, # else scan failed
        ),
        'messagepattern' => '/.*?:(.*)/sim',
    ),
    #setup for f-prot
    'f-prot' => array(
        'command' => "f-prot ",
        'codemap' => array(
            "0" => AV_NO_VIRUS, # no virus
            "3" => AV_VIRUS_FOUND, # virus found
            "6" => AV_VIRUS_FOUND, # virus found
            "*" => AV_SCAN_FAILED, # else scan failed
        ),
        'messagepattern' => '/.*?Infection:(.*)$/m',
    ),
);

/**
 * Password reminder name
 */
$wgPasswordSenderName = 'MediaWiki Mail';

/**
 * SMTP Mode
 * For using a direct (authenticated) SMTP server connection.
 * Default to false or fill an array :
 * <code>
 * "host" => 'SMTP domain',
 * "IDHost" => 'domain for MessageID',
 * "port" => "25",
 * "auth" => true/false,
 * "username" => user,
 * "password" => password
 * </code>
 */
$wgSMTP = false;

/** Database host name or IP address */
$wgDBserver = 'localhost';

/**
 * Load balancer factory configuration
 * To set up a multi-master wiki farm, set the class here to something that
 * can return a LoadBalancer with an appropriate master on a call to getMainLB().
 * The class identified here is responsible for reading $wgDBservers,
 * $wgDBserver, etc., so overriding it may cause those globals to be ignored.
 *
 * The LBFactory_Multi class is provided for this purpose, please see
 * includes/db/LBFactory_Multi.php for configuration information.
 */
$wgLBFactoryConf = array('class' => 'LBFactory_Simple');

/** How long to wait for a slave to catch up to the master */
$wgMasterWaitTimeout = 10;

/**
 * Scale load balancer polling time so that under overload conditions, the database server
 * receives a SHOW STATUS query at an average interval of this many microseconds
 */
$wgDBAvgStatusPoll = 2000;

/**
 * The place to put new revisions, false to put them in the local text table.
 * Part of a URL, e.g. DB://cluster1
 *
 * Can be an array instead of a single string, to enable data distribution. Keys
 * must be consecutive integers, starting at zero. Example:
 *
 * $wgDefaultExternalStore = array( 'DB://cluster1', 'DB://cluster2' );
 *
 * @var array
 */
$wgDefaultExternalStore = false;

/**
 * Directory for caching data in the local filesystem. Should not be accessible
 * from the web. Set this to false to not use any local caches.
 *
 * Note: if multiple wikis share the same localisation cache directory, they
 * must all have the same set of extensions. You can set a directory just for
 * the localisation cache using $wgLocalisationCacheConf['storeDirectory'].
 */
$wgCacheDirectory = false;

/**
 * Main cache type. This should be a cache with fast access, but it may have
 * limited space. By default, it is disabled, since the database is not fast
 * enough to make it worthwhile.
 *
 * The options are:
 *
 *   - CACHE_ANYTHING:   Use anything, as long as it works
 *   - CACHE_NONE:       Do not cache
 *   - CACHE_MEMCACHED:  MemCached, must specify servers in $wgMemCachedServers
 *   - CACHE_ACCEL:      APC, XCache or WinCache
 *   - CACHE_DBA:        Use PHP's DBA extension to store in a DBM-style
 *                       database. This is slow, and is not recommended for
 *                       anything other than debugging.
 *   - (other):          A string may be used which identifies a cache
 *                       configuration in $wgObjectCaches.
 *
 * @see $wgMessageCacheType, $wgParserCacheType
 */
$wgMainCacheType = CACHE_NONE;

/**
 * The cache type for storing the contents of the MediaWiki namespace. This
 * cache is used for a small amount of data which is expensive to regenerate.
 *
 * For available types see $wgMainCacheType.
 */
$wgMessageCacheType = CACHE_ANYTHING;

/**
 * The cache type for storing article HTML. This is used to store data which
 * is expensive to regenerate, and benefits from having plenty of storage space.
 *
 * For available types see $wgMainCacheType.
 */
$wgParserCacheType = CACHE_ANYTHING;

/**
 * Advanced object cache configuration.
 *
 * Use this to define the class names and constructor parameters which are used
 * for the various cache types. Custom cache types may be defined here and
 * referenced from $wgMainCacheType, $wgMessageCacheType or $wgParserCacheType.
 *
 * The format is an associative array where the key is a cache identifier, and
 * the value is an associative array of parameters. The "class" parameter is the
 * class name which will be used. Alternatively, a "factory" parameter may be
 * given, giving a callable function which will generate a suitable cache object.
 *
 * The other parameters are dependent on the class used.
 * - CACHE_DBA uses $wgTmpDirectory by default. The 'dir' parameter let you
 *   overrides that.
 */
$wgObjectCaches = array(
    CACHE_NONE => array('class' => 'EmptyBagOStuff'),
    CACHE_DBA => array('class' => 'DBABagOStuff'),
    CACHE_ANYTHING => array('factory' => 'ObjectCache::newAnything'),
    CACHE_ACCEL => array('factory' => 'ObjectCache::newAccelerator'),
    CACHE_MEMCACHED => array('factory' => 'ObjectCache::newMemcached'),
    'apc' => array('class' => 'APCBagOStuff'),
    'xcache' => array('class' => 'XCacheBagOStuff'),
    'wincache' => array('class' => 'WinCacheBagOStuff'),
    'memcached-php' => array('class' => 'MemcachedPhpBagOStuff'),
    'hash' => array('class' => 'HashBagOStuff'),
);

/** If enabled, will send MemCached debugging information to $wgDebugLogFile */
$wgMemCachedDebug = false;

/** The list of MemCached servers and port numbers */
$wgMemCachedServers = array('127.0.0.1:11000');

/**
/**
 * Localisation cache configuration. Associative array with keys:
 *     class:       The class to use. May be overridden by extensions.
 *
 *     store:       The location to store cache data. May be 'files', 'db' or
 *                  'detect'. If set to "files", data will be in CDB files. If set
 *                  to "db", data will be stored to the database. If set to
 *                  "detect", files will be used if $wgCacheDirectory is set,
 *                  otherwise the database will be used.
 *
 *     storeClass:  The class name for the underlying storage. If set to a class
 *                  name, it overrides the "store" setting.
 *
 *     storeDirectory:  If the store class puts its data in files, this is the
 *                      directory it will use. If this is false, $wgCacheDirectory
 *                      will be used.
 *
 *     manualRecache:   Set this to true to disable cache updates on web requests.
 *                      Use maintenance/rebuildLocalisationCache.php instead.
 */
$wgLocalisationCacheConf = array(
    'class' => 'LocalisationCache',
    'store' => 'detect',
    'storeClass' => false,
    'storeDirectory' => false,
    'manualRecache' => false,
);

/**
 * Bump this number when changing the global style sheets and JavaScript.
 * It should be appended in the query string of static CSS and JS includes,
 * to ensure that client-side caches do not keep obsolete copies of global
 * styles.
 */
$wgStyleVersion = '303';

/** List of language names or overrides for default names in Names.php */
$wgExtraLanguageNames = array();

/**
 * Default skin, for new users and anonymous visitors. Registered users may
 * change this to any one of the other available skins in their preferences.
 * This has to be completely lowercase; see the "skins" directory for the list
 * of available skins.
 */
$wgDefaultSkin = 'oasis';

/**
 * Default 'remoteBasePath' value for resource loader modules.
 * If not set, then $wgScriptPath will be used as a fallback.
 */
$wgResourceBasePath = null;

/**
 * The interwiki prefix of the current wiki, or false if it doesn't have one.
 */
$wgLocalInterwiki = false;

/** Which namespaces should support subpages?
 * See Language.php for a list of namespaces.
 */
$wgNamespacesWithSubpages = array(
    NS_TALK => true,
    NS_USER => true,
    NS_USER_TALK => true,
    NS_PROJECT_TALK => true,
    NS_FILE_TALK => true,
    NS_MEDIAWIKI => true,
    NS_MEDIAWIKI_TALK => true,
    NS_TEMPLATE_TALK => true,
    NS_HELP_TALK => true,
    NS_CATEGORY_TALK => true
);

/**
 * Array of namespaces which can be deemed to contain valid "content", as far
 * as the site statistics are concerned. Useful if additional namespaces also
 * contain "content" which should be considered when generating a count of the
 * number of articles in the wiki.
 */
$wgContentNamespaces = array(NS_MAIN);

/** @see $wgUseTidy */
$wgTidyConf = $IP . '/includes/tidy.conf';

/** @see $wgUseTidy */
$wgTidyInternal = extension_loaded('tidy');

/**
 * Set the minimum permissions required to edit pages in each
 * namespace.  If you list more than one permission, a user must
 * have all of them to edit pages in that namespace.
 *
 * Note: NS_MEDIAWIKI is implicitly restricted to editinterface.
 */
$wgNamespaceProtection = array();

/**
 * Automatically add a usergroup to any user who matches certain conditions.
 * The format is
 *   array( '&' or '|' or '^' or '!', cond1, cond2, ... )
 * where cond1, cond2, ... are themselves conditions; *OR*
 *   APCOND_EMAILCONFIRMED, *OR*
 *   array( APCOND_EMAILCONFIRMED ), *OR*
 *   array( APCOND_EDITCOUNT, number of edits ), *OR*
 *   array( APCOND_AGE, seconds since registration ), *OR*
 *   array( APCOND_INGROUPS, group1, group2, ... ), *OR*
 *   array( APCOND_ISIP, ip ), *OR*
 *   array( APCOND_IPINRANGE, range ), *OR*
 *   array( APCOND_AGE_FROM_EDIT, seconds since first edit ), *OR*
 *   array( APCOND_BLOCKED ), *OR*
 *   array( APCOND_ISBOT ), *OR*
 *   similar constructs defined by extensions.
 *
 * If $wgEmailAuthentication is off, APCOND_EMAILCONFIRMED will be true for any
 * user who has provided an e-mail address.
 */
$wgAutopromote = array(
    'autoconfirmed' => array('&',
        array(APCOND_EDITCOUNT, &$wgAutoConfirmCount),
        array(APCOND_AGE, &$wgAutoConfirmAge),
    ),
);

/**
 * Script used to scan IPs for open proxies.
 */
$wgProxyScriptPath = "$IP/maintenance/proxy_check.php";

/**
 * Set to set an explicit domain on the login cookies eg, "justthis.domain.org"
 * or ".any.subdomain.net"
 */
$wgCookieDomain = '';

/**
 * Filename for debug logging. See http://www.mediawiki.org/wiki/How_to_debug
 * The debug log file should be not be publicly accessible if it is used, as it
 * may contain private data.
 */
$wgDebugLogFile = '';

/**
 * If set to true, uncaught exceptions will print a complete stack trace
 * to output. This should only be used for debugging, as it may reveal
 * private information in function parameters due to PHP's backtrace
 * formatting.
 */
$wgShowExceptionDetails = false;

/**
 * List of namespaces which are searched by default. Example:
 *
 * <code>
 * $wgNamespacesToBeSearchedDefault[NS_MAIN] = true;
 * $wgNamespacesToBeSearchedDefault[NS_PROJECT] = true;
 * </code>
 */
$wgNamespacesToBeSearchedDefault = array(
    NS_MAIN => true,
);

/**
 * Namespaces to be searched when user clicks the "Help" tab
 * on Special:Search
 *
 * Same format as $wgNamespacesToBeSearchedDefault
 */
$wgNamespacesToBeSearchedHelp = array(
    NS_PROJECT => true,
    NS_HELP => true,
);

/**
 * Which namespaces have special treatment where they should be preview-on-open
 * Internaly only Category: pages apply, but using this extensions (e.g. Semantic MediaWiki)
 * can specify namespaces of pages they have special treatment for
 */
$wgPreviewOnOpenNamespaces = array(
    NS_CATEGORY => true
);

/**
 * @cond file_level_code
 * Set $wgCommandLineMode if it's not set already, to avoid notices
 */
if (!isset($wgCommandLineMode)) {
    $wgCommandLineMode = false;
}

/**
 * Set this to a string to put the wiki into read-only mode. The text will be
 * used as an explanation to users.
 *
 * This prevents most write operations via the web interface. Cache updates may
 * still be possible. To prevent database writes completely, use the read_only
 * option in MySQL.
 */
$wgReadOnly = null;


/**
 * Set this to specify an external URL containing details about the content license used on your wiki.
 * If $wgRightsPage is set then this setting is ignored.
 */
$wgRightsUrl = null;

/**
 * Global list of hooks.
 * Add a hook by doing:
 *     $wgHooks['event_name'][] = $function;
 * or:
 *     $wgHooks['event_name'][] = array($function, $data);
 * or:
 *     $wgHooks['event_name'][] = array($object, 'method');
 */
// Wikia change - begin - @author: wladek
//$wgHooks = array();
$wgHooks = &Hooks::getHandlersArray();
// Wikia change - end

/**
 * Default robot policy.  The default policy is to encourage indexing and fol-
 * lowing of links.  It may be overridden on a per-namespace and/or per-page
 * basis.
 */
$wgDefaultRobotPolicy = 'index,follow';

/**
 * Timeout for HTTP requests done internally
 *
 * Let's use different values when running a maintenance script (that includes Wikia Tasks)
 * and when serving HTTP request
 *
 * @see PLATFORM-2385
 */
$wgHTTPTimeout = defined( 'RUN_MAINTENANCE_IF_MAIN' ) ? 25 : 5; # Wikia change

/**
 * Proxy to use for CURL requests.
 */
$wgHTTPProxy = false;

/**
 * Filesystem extensions directory. Defaults to $IP/../extensions.
 *
 * To compile extensions with HipHop, set $wgExtensionsDirectory correctly,
 * and use code like:
 *
 *    require( MWInit::extensionSetupPath( 'Extension/Extension.php' ) );
 *
 * to include the extension setup file from LocalSettings.php. It is not
 * necessary to set this variable unless you use MWInit::extensionSetupPath().
 * @global string $wgExtensionsDirectory
 */
$wgExtensionsDirectory = "$IP/extensions";
