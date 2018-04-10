<?php
/**
 * If wgAllowExternalImages is false, you can specify an exception here. Image
 * URLs that start with this string are then rendered, while all others are not.
 * You can use this to set up a trusted, simple repository of images. You may
 * also specify an array of strings to allow multiple sites.
 * @example $wgAllowExternalImagesFrom = 'http://127.0.0.1/';
 * @example $wgAllowExternalImagesFrom = array( 'http://127.0.0.1/', 'http://example.com' );
 * @see includes/parser/ParserOptions.php
 * @var Array|string $wgAllowExternalImagesFrom
 */
$wgAllowExternalImagesFrom = "http://images.$wgWikiaBaseDomain/";

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
 *   - You may use "*" as a key in the array to catch all exit codes not mapped
 *     otherwise.
 *
 * "messagepattern" is a perl regular expression to extract the meaningful part
 * of the scanners output. The relevant part should be matched as group one
 * (\1). If not defined or the pattern does not match, the full message is shown
 * to the user.
 * 
 * @see includes/upload/UploadBase.php
 * @see $wgAntivirus
 * @var Array $wgAntivirusSetup
 */
$wgAntivirusSetup = [
    // setup for clamav
    'clamav' => [
        'command' => 'clamscan --no-summary ',
        'codemap' => [
            '0' => AV_NO_VIRUS, // no virus
            '1' => AV_VIRUS_FOUND, // virus found
            '52' => AV_SCAN_ABORTED, // unsupported file format (probably imune)
            '*' => AV_SCAN_FAILED, // else scan failed
        ],
        'messagepattern' => '/.*?:(.*)/sim',
    ],
    // setup for f-prot
    'f-prot' => [
        'command' => 'f-prot ',
        'codemap' => [
            '0' => AV_NO_VIRUS, // no virus
            '3' => AV_VIRUS_FOUND, // virus found
            '6' => AV_VIRUS_FOUND, // virus found
            '*' => AV_SCAN_FAILED, // else scan failed
        ],
        'messagepattern' => '/.*?Infection:(.*)$/m',
    ],
];

/**
 * The URL path for primary article page views. This path should contain $1,
 * which is replaced by the article title. Will default to "{$wgScript}/$1" or
 * "{$wgScript}?title=$1" in Setup.php, depending on $wgUsePathInfo.
 * @see $wgUsePathInfo
 * @see $wgScriptPath
 * @var string $wgArticlePath
 */
$wgArticlePath = "$wgScriptPath/wiki/$1";

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
 * 
 * @see includes/Autopromote.php
 * @var Array $wgAutopromote
 */
$wgAutopromote = [
    'autoconfirmed' => [
        '&',
        [ APCOND_EDITCOUNT, &$wgAutoConfirmCount ],
        [ APCOND_AGE, &$wgAutoConfirmAge ],
    ],
];

/**
 * Directory for caching data in the local filesystem. Should not be accessible
 * from the web. Set this to false to not use any local caches. Note: if
 * multiple wikis share the same localisation cache directory, they must all
 * have the same set of extensions. You can set a directory just for the
 * localisation cache using $wgLocalisationCacheConf['storeDirectory'].
 * @see includes/cache/MessageCache.php
 * @see includes/LocalisationCache.php
 * @see maintenance/rebuildLocalisationCache.php
 * @var string $wgCacheDirectory
 */
$wgCacheDirectory = "$IP/../cache/messages";

/**
 * Array of namespaces which can be deemed to contain valid "content", as far
 * as the site statistics are concerned. Useful if additional namespaces also
 * contain "content" which should be considered when generating a count of the
 * number of articles in the wiki. Extensions should add to this array in their
 * setup files.
 * @var Array $wgContentNamespaces
 */
$wgContentNamespaces = [ NS_MAIN ];

/**
 * Domain for cookies.
 * @example 'justthis.domain.org'
 * @example '.any.subdomain.net'
 * @bvar string $wgCookieDomain
 */
$wgCookieDomain = ".$wgWikiaBaseDomain";

/**
 * Default community for UserPageRedirects. It's very old. It mentions corporate
 * but has nothing to do with the actual FANDOM corporate pages.
 * @see extensions/wikia/UserPageRedirects
 * @var string $wgCorporatePageRedirectWiki
 */
$wgCorporatePageRedirectWiki = "http://community.$wgWikiaBaseDomain/wiki/";

/**
 * Settings for incoming cross-site AJAX requests. Newer browsers support
 * cross-site AJAX when the target resource allows requests from the origin
 * domain by the Access-Control-Allow-Origin header. $wgCrossSiteAJAXdomains can
 * be set using a wildcard syntax where '*' matches any number of characters and
 * '?' matches any 1 character.
 * @example  $wgCrossSiteAJAXdomains = [ 'www.wikia.com', '*.wikia.com' ];
 * @see PLATFORM-1719
 * @see wfHandleCrossSiteAJAXdomain()
 * @var string $wgCrossSiteAJAXdomains
 */
$wgCrossSiteAJAXdomains = [ "internal-vstf.$wgWikiaBaseDomain" ];

/**
 * Filesystem extensions directory. Defaults to $IP/../extensions. To compile
 * extensions with HipHop, set $wgExtensionsDirectory correctly, and use code
 * like:
 *
 *    require( MWInit::extensionSetupPath( 'Extension/Extension.php' ) );
 *
 * to include the extension setup file from LocalSettings.php. It is not
 * necessary to set this variable unless you use MWInit::extensionSetupPath().
 * @see includes/Init.php
 * @var string $wgExtensionsDirectory
 */
$wgExtensionsDirectory = "$IP/extensions";

/**
 * Localized central wikis.
 * @see extensions/wikia/WikiaLogo/WikiaLogoHelper.class.php
 * @var Array $wgLangToCentralMap
 */
$wgLangToCentralMap = [
    'de' => "http://de.$wgWikiaBaseDomain/wiki/Wikia",
    'es' => "http://es.$wgWikiaBaseDomain/wiki/Wikia",
    'fr' => "http://fr.$wgWikiaBaseDomain/wiki/Accueil",
    'ja' => "http://ja.$wgWikiaBaseDomain/wiki/Wikia",
    'pl' => "http://pl.$wgWikiaBaseDomain/wiki/Wikia_Polska",
    'pt' => "http://pt-br.$wgWikiaBaseDomain/wiki/Wikia_em_Português",
    'ru' => "http://ru.$wgWikiaBaseDomain/wiki/Викия_на_русском",
    'zh' => "http://zh-tw.$wgWikiaBaseDomain/wiki/Wikia中文"
];

/**
 * Legacy base URL to Vignette.
 * @see includes/wikia/vignette/VignetteRequest.php
 * @var string $wgLegacyVignetteUrl
 */
$wgLegacyVignetteUrl = "https://vignette<SHARD>.$wgWikiaNocookieDomain";

/**
 * The interwiki prefix of the current wiki, or false if it doesn't have one.
 * @see includes/Title.php
 * @see includes/RecentChange.php
 * @var string|bool $wgLocalInterwiki
 */
$wgLocalInterwiki = $wgSitename;

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
 * @see includes/objectcache/ObjectCache.php
 * @var int $wgMainCacheType
 */
$wgMainCacheType = CACHE_MEMCACHED;

/**
 * The cache type for storing the contents of the MediaWiki namespace. This
 * cache is used for a small amount of data which is expensive to regenerate.
 * @see $wgMainCacheType
 * @see includes/objectcache/ObjectCache.php
 * @var int $wgMessageCacheType
 */
$wgMessageCacheType = CACHE_MEMCACHED;

/**
 * Set the minimum permissions required to edit pages in each namespace. If you
 * list more than one permission, a user must have all of them to edit pages in
 * that namespace. NS_MEDIAWIKI is implicitly restricted to 'editinterface'.
 * @see includes/Namespace.php
 * @see includes/Setup.php
 * @see includes/Title.php
 * @var Array $wgNamespaceProtection
 */
$wgNamespaceProtection = [
    NS_TEMPLATE => [ 'edittemplates' ]
];

/**
 * List of namespaces which are searched by default.
 * @example $wgNamespacesToBeSearchedDefault[NS_MAIN] = true;
 * @example $wgNamespacesToBeSearchedDefault[NS_PROJECT] = true;
 * @see includes/search/SearchEngine.php
 * @global Array $wgNamespacesToBeSearchedDefault
 */
$wgNamespacesToBeSearchedDefault = [
    NS_MAIN     => true,
    NS_CATEGORY => true,
];

/**
 * Namespaces to be searched when user clicks the "Help" tab on Special:Search.
 * @see includes/search/SearchEngine.php
 * @global Array $wgNamespacesToBeSearchedHelp
 */
$wgNamespacesToBeSearchedHelp = [
    NS_PROJECT => true,
    NS_HELP    => true,
];

/**
 * Namespaces supporting subpages.
 * @see includes/Namespace.php
 * @var Array $wgNamespacesWithSubpages
 */
$wgNamespacesWithSubpages = [
    NS_MAIN           => true,
    NS_TALK           => true,
    NS_USER           => true,
    NS_USER_TALK      => true,
    NS_PROJECT        => true,
    NS_PROJECT_TALK   => true,
    NS_FILE_TALK      => true,
    NS_IMAGE          => true,
    NS_IMAGE_TALK     => true,
    NS_MEDIAWIKI      => true,
    NS_MEDIAWIKI_TALK => true,
    NS_TEMPLATE       => true,
    NS_TEMPLATE_TALK  => true,
    NS_HELP           => true,
    NS_HELP_TALK      => true,
    NS_CATEGORY       => true,
    NS_CATEGORY_TALK  => true
];

/**
 * While trying to access a non-existing community, client will be redirected
 * to this URL.
 * @see $wgEnableNotAValidWikiaExt
 * @see extensions/wikia/WikiFactory/Loader/WikiFactoryLoader.php
 * @see extensions/wikia/NotAValidWikia
 * @see extensions/wikia/InterwikiDispatcher
 * @var string $wgNotAValidWikia
 */
$wgNotAValidWikia = "http://community.$wgWikiaBaseDomain/wiki/Community_Central:Not_a_valid_community";

/**
 * The cache type for storing article HTML. This is used to store data which
 * is expensive to regenerate, and benefits from having plenty of storage space.
 * @see $wgMainCacheType
 * @see includes/objectcache/ObjectCache.php
 * @var int $wgParserCacheType
 */
$wgParserCacheType = CACHE_MEMCACHED;

/**
 * Which namespaces have special treatment where they should be preview-on-open
 * Internaly only Category: pages apply, but using this extensions (e.g.
 * Semantic MediaWiki) can specify namespaces of pages they have special
 * treatment for.
 * @see includes/EditPage.php
 * @var Array $wgPreviewOnOpenNamespaces
 */
$wgPreviewOnOpenNamespaces = [
    NS_CATEGORY => true
];

/**
 * Script used to scan IPs for open proxies.
 * @see includes/ProxyTools.php
 * @var string $wgProxyScriptPath
 */
$wgProxyScriptPath = "$IP/maintenance/proxy_check.php";

/**
 * Copyright icon.
 * @see includes/Skin.php
 * @global string $wgRightsIcon
 */
$wgRightsIcon = "https://vignette.$wgWikiaNocookieDomain/messaging/images/a/a9/CC-BY-SA.png?1";

/**
 * Custom rules for robots.txt. Supported rules: allowSpecialPage and
 * disallowNamespace.
 * @see string extensions/wikia/RobotsTxt/classes/WikiaRobots.class.php
 * @var Array $wgRobotsTxtCustomRules
 */
$wgRobotsTxtCustomRules = [ 'disallowNamespace' => [ NS_HELP, NS_USER ] ];

/**
 * @var string $wgServicesExternalDomain
 */
$wgServicesExternalDomain = "https://services.$wgWikiaBaseDomain/";

/**
 * Configuration file for external Tidy.
 * @see $wgTidyBin
 * @see $wgTidyInternal
 * @see $wgUseTidy
 * @var string $wgTidyConf
 */
$wgTidyConf = "$IP/includes/tidy.conf";

/**
 * Trusted media-types and mime types. Use the MEDIATYPE_xxx constants to
 * represent media types. Types not listed here will have a warning about unsafe
 * content displayed on the images description page. It would also be possible
 * to use this for further restrictions, like disabling direct [[media:...]]
 * links for non-trusted formats.
 * @see File::isSafeFile()
 * @var Array $wgTrustedMediaFormats
 */
$wgTrustedMediaFormats = [
    MEDIATYPE_AUDIO, // all audio formats
    MEDIATYPE_BITMAP, // all bitmap formats
    MEDIATYPE_VIDEO, // all plain video formats
    'application/pdf', // PDF files
    'image/svg+xml', // svg (only needed if inline rendering of svg is not supported)
];

/**
 * The URL path for the images directory. Defaults to "{$wgScriptPath}/images"
 * in Setup.php, but there are variables declared earlier that depend on it
 * so it has to be declared explicitly here.
 * @see app/includes/Setup.php
 * @var string|bool $wgUploadPath
 */
$wgUploadPath = "$wgScriptPath/images";

/**
 * The URL path of the wiki logo. Will default to
 * "{$wgStylePath}/common/images/wiki.png" in Setup.php.
 * @see Setup.php
 * @see $wgUploadPath
 * @global string|bool $wgLogo
 */
$wgLogo = "$wgUploadPath/b/bc/Wiki.png";

/**
 * The base URL to Vignette.
 * @see includes/wikia/vignette/VignetteRequest.php
 * @see includes/wikia/services/AvatarService.class.php
 * @see extensions/wikia/UserProfilePageV3/Masthead.class.php
 * @var string $wgVignetteUrl
 */
$wgVignetteUrl = "https://vignette.$wgWikiaNocookieDomain";
