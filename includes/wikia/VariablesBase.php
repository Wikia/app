<?php
/*******************************************************************************
 * This file is the starting point of MediaWiki configuration. It contains
 * elementary configuration variables that can later be changed or expanded.
 * You know, the BASE.
 *
 * This file is meant to be stateless. As such, it cannot contain any logic.
 * Just simple declarations. In other words, the state must be irrelevant
 * within this file. All information here must be applied in a single atomic
 * operation and only can be modified after it is imported.
 *
 * The reason behind the above is that at some point we may manage the
 * configuration with some proper configuration management system and store
 * it in a different format.
 *
 * Here are some kind suggestions to help us keeping this file clean and tidy.
 *
 * 1. Only declare global variables here. Do not assign values to class
 *    properties, such as $wgConf->foo = 'Foo'.
 * 2. Put declarations in alphabetical order. This enforces strict and
 *    and grep-friendly naming convention to keep relevant variables together.
 *    Use alphabetical order in associative arrays, too, unless they are short.
 * 3. Only put elementary declarations here: declare variables that do not
 *    depend on other variables. Do not declare expansions such as $a = "$b-foo"
 *    or $a = 24 * $b or $a = SOME_NAMED_CONSTANT.
 * 4. No logic here. No if statements, no switch statements. For environment-
 *    specific variables use environment-specific files. For declarations based
 *    on the state, well... they must not be part of the config, as they
 *    actually are part of the application. Not every global variable is
 *    a config variable. It is OK to declare global variables in the
 *    application.
 * 5. Always provide a docblock. There are many examples how to do it.
 * 6. Use common sense.
 *
 ******************************************************************************/

/**
 * OpenGraphMeta application ID to display in <meta property="fb:app_id">.
 * @see extensions/OpenGraphMeta
 * @var string $egFacebookAppId
 */
$egFacebookAppId = '112328095453510';

/**
 * Default block duration for Abuse Filter.
 * @see SpecialBlock::parseExpiryInput
 * @see extensions/AbuseFilter
 * @var string $wgAbuseFilterBlockDuration
 */
$wgAbuseFilterBlockDuration = 'indefinite';

/**
 * Number of accounts each IP address may create, 0 to disable. Requires
 * memcached.
 * @var int $wgAccountCreationThrottle
 */
$wgAccountCreationThrottle = 5;

/**
 * The limit of registered accounts per email. Set to null for unlimited
 * accounts.
 * @var int $wgAccountsPerEmail
 */
$wgAccountsPerEmail = 10;
// CONFIG_REVISION: verify whether this is still used and effective

/**
 * To set 'pretty' URL paths for actions other than plain page views, add to
 * this array. There must be an appropriate script or rewrite rule in place to
 * handle these URLs.
 * @example 'edit' => "$wgScriptPath/edit/$1"
 * @var Array $wgActionPaths
 */
$wgActionPaths = [];

/**
 * Array of allowed values for the title=foo&action=<action> parameter. Syntax is:
 *     'foo' => 'ClassName'    Load the specified class which subclasses Action
 *     'foo' => true           Load the class FooAction which subclasses Action
 *                             If something is specified in the getActionOverrides()
 *                             of the relevant Page object it will be used
 *                             instead of the default class.
 *     'foo' => false          The action is disabled; show an error message
 * Unsetting core actions will probably cause things to complain loudly.
 * @var Array $wgActions
 */
$wgActions = [
	'credits'        => true,
	'delete'         => true,
	'edit'           => true,
	'history'        => true,
	'info'           => true,
	'markpatrolled'  => true,
	'protect'        => true,
	'purge'          => true,
	'raw'            => true,
	'render'         => true,
	'revert'         => true,
	'revisiondelete' => true,
	'rollback'       => true,
	'submit'         => true,
	'unprotect'      => true,
	'unwatch'        => true,
	'view'           => true,
	'watch'          => true,
];

/**
 * How many days user must be idle before he is considered inactive. Will affect
 * the number shown on Special:Statistics and Special:ActiveUsers special page.
 * You might want to leave this as the default value, to provide comparable
 * numbers between different wikis.
 * @var int $wgActiveUserDays
 */
$wgActiveUserDays = 30;

/**
 * Instead of caching everything, keep track which messages are requested and
 * load only most used messages. This only makes sense if there is lots of
 * interface messages customised in the wiki (like hundreds in many languages).
 * @var bool $wgAdaptiveMessageCache
 */
$wgAdaptiveMessageCache = false;

/**
 * Additional email parameters, will be passed as the last argument to mail() call.
 * If using safe_mode this has no effect
 * @see http://php.net/manual/en/function.mail.php
 * @var string $wgAdditionalMailParams
 */
$wgAdditionalMailParams = null;

/**
 * Set to true to have nicer highligted text in search results, by default off
 * due to execution overhead.
 * @var bool $wgAdvancedSearchHighlighting
 */
$wgAdvancedSearchHighlighting = false;

/**
 * Which feed types should we provide by default?  This can include 'rss',
 * 'atom', neither, or both.
 * @var Array $wgAdvertisedFeedTypes
 */
$wgAdvertisedFeedTypes = [ 'atom' ];

/**
 * When $wgStatsMethod is 'udp', setting this to a string allows statistics to
 * be aggregated over more than one wiki. The string will be used in place of
 * the DB name in outgoing UDP packets. If this is set to false, the DB name
 * will be used.
 * @var bool $wgAggregateStatsID
 */
$wgAggregateStatsID = false;

/**
 * List of Ajax-callable functions.
 * Extensions acting as Ajax callbacks must add their items to this array.
 * @var Array $wgAjaxExportList
 */
$wgAjaxExportList = [];

/**
 * Enable previewing licences via AJAX. Also requires $wgEnableAPI to be true.
 * @var bool $wgAjaxLicensePreview
 */
$wgAjaxLicensePreview = true;

/**
 * Enable AJAX check for file overwrite, pre-upload.
 * @var bool $wgAjaxUploadDestCheck
 */
$wgAjaxUploadDestCheck = true;

/**
 * Enable watching/unwatching pages using AJAX.
 * Requires $wgUseAjax to be true too.
 * @var bool $wgAjaxWatch
 */
$wgAjaxWatch = true;

/**
 * Make all database connections secretly go to localhost. Fool the load
 * balancer thinking there is an arbitrarily large cluster of servers to connect
 * to. Useful for debugging.
 * @var bool $wgAllDBsAreLocalhost
 */
$wgAllDBsAreLocalhost = false;

/**
 * Merge all JavaScript / CSS files together.
 * @see extensions/wikia/AssetsManager
 * @var bool $wgAllInOne
 */
$wgAllInOne = true;

/**
 * Enable filtering of categories in Recentchanges.
 * @var bool $wgAllowCategorizedRecentChanges
 */
$wgAllowCategorizedRecentChanges = false;

/**
 * Allow for upload to be copied from an URL. Requires Special:Upload?source=web
 * The timeout for copy uploads is set by $wgHTTPTimeout.
 * @var bool $wgAllowCopyUploads
 */
$wgAllowCopyUploads = false;

/**
 * Allow DISPLAYTITLE to change title display.
 * @var bool $wgAllowDisplayTitle
 */
$wgAllowDisplayTitle = true;

/**
 * Whether to allow inline image pointing to other websites.
 * @var bool $wgAllowExternalImages
 */
$wgAllowExternalImages = false;

/**
 * Enable external image white-list.
 * @see /extensions/wikia/WikiaWhiteList/
 * @var bool $wgAllowExternalWhitelistImages
 */
$wgAllowExternalWhitelistImages = true;

/**
 * Allows to move images and other media files.
 * @var bool $wgAllowImageMoving
 */
$wgAllowImageMoving = true;

/**
 * A different approach to the above: simply allow the <img> tag to be used.
 * This allows you to specify alt text and other attributes, copy-paste HTML to
 * your wiki more easily, etc.  However, allowing external images in any manner
 * will allow anyone with editing rights to snoop on your visitors' IP
 * addresses and so forth, if they wanted to, by inserting links to images on
 * sites they control.
 * @var bool $wgAllowImageTag
 */
$wgAllowImageTag = false;

/**
 * Allow Java archive uploads. This is not recommended for public wikis since a
 * maliciously-constructed applet running on the same domain as the wiki can
 * steal the user's cookies.
 * @var bool $wgAllowJavaUploads
 */
$wgAllowJavaUploads = false;

/**
 * Allow Memcache overrides such as: &mpurge=none|readonly|writeonly.
 * @see includes/objectcache/MemcachedClient.php
 * @see includes/wikia/Wikia.php
 * @var bool $wgAllowMemcacheDisable
 * @var bool $wgAllowMemcacheReads
 * @var bool $wgAllowMemcacheWrites
 */
$wgAllowMemcacheDisable = true;
$wgAllowMemcacheReads = true;
$wgAllowMemcacheWrites = true;

/**
 * Enabled HTML5 microdata attributes for use in wikitext, if $wgHtml5 is also
 * true.
 * @see $wgHtml5
 * @var bool $wgAllowMicrodataAttributes
 */
$wgAllowMicrodataAttributes = false;

/**
 * Allow the "info" action (very inefficient in MediaWiki 1.19).
 * @var bool $wgAllowPageInfo
 */
$wgAllowPageInfo = false;

/**
 * Policies for how each preference is allowed to be changed, in the presence
 * of external authentication.  The keys are preference keys, e.g., 'password'
 * or 'emailaddress' (see Preferences.php et al.).  The value can be one of the
 * following:
 *
 * - local: Allow changes to this pref through the wiki interface but only
 * apply them locally (default).
 * - semiglobal: Allow changes through the wiki interface and try to apply them
 * to the foreign database, but continue on anyway if that fails.
 * - global: Allow changes through the wiki interface, but only let them go
 * through if they successfully update the foreign database.
 * - message: Allow no local changes for linked accounts; replace the change
 * form with a message provided by the auth plugin, telling the user how to
 * change the setting externally (maybe providing a link, etc.).  If the auth
 * plugin provides no message for this preference, hide it entirely.
 *
 * Accounts that are not linked to an external account are never affected by
 * this setting.  You may want to look at $wgHiddenPrefs instead.
 * $wgHiddenPrefs supersedes this option.
 *
 * TODO: Implement message, global.
 * @var Array $wgAllowPrefChange
 */
$wgAllowPrefChange = [];

/**
 * Enabled RDFa attributes for use in wikitext. NOTE: Interaction with HTML5 is
 * somewhat underspecified.
 * @var bool $wgAllowRdfaAttributes
 */
$wgAllowRdfaAttributes = false;

/**
 * Whether or not to allow and use real name fields.
 * @deprecated since 1.16, use $wgHiddenPrefs[] = 'realname' below to disable real
 * names
 * @var bool $wgAllowRealName
 */
$wgAllowRealName = true;

/**
 * Allow schema updates.
 * @var bool $wgAllowSchemaUpdates
 */
$wgAllowSchemaUpdates = true;

/**
 * Whether to allow site-wide CSS (MediaWiki:Common.css and friends) on
 * restricted pages like Special:UserLogin or Special:Preferences where
 * JavaScript is disabled for security reasons. As it is possible to execute
 * JavaScript through CSS, setting this to true opens up a potential security
 * hole. Some sites may "skin" their wiki by using site-wide CSS, causing
 * restricted pages to look unstyled and different from the rest of the site.
 *
 * @since 1.25
 * @var bool $wgAllowSiteCSSOnRestrictedPages
 */
$wgAllowSiteCSSOnRestrictedPages = false;

/**
 * Enable slow parser functions.
 * @var bool $wgAllowSlowParserFunctions
 */
$wgAllowSlowParserFunctions = false;

/**
 * Allow special page inclusions such as {{Special:Allpages}}
 * @var bool $wgAllowSpecialInclusion
 */
$wgAllowSpecialInclusion = true;

/**
 * MediaWiki will reject HTMLesque tags in uploaded files due to idiotic
 * browsers which can't perform basic stuff like MIME detection and which are
 * vulnerable to further idiots uploading crap files as images. When this
 * directive is on, <title> will be allowed in files with an "image/svg+xml"
 * MIME type. You should leave this disabled if your web server is misconfigured
 * and doesn't send appropriate MIME types for SVG images.
 * @var bool $wgAllowTitlesInSVG
 */
$wgAllowTitlesInSVG = false;

/**
 * Allow user Cascading Style Sheets (CSS)? This enables a lot of neat
 * customizations, but may increase security risk to users and server load.
 * @var bool $wgAllowUserCss
 */
$wgAllowUserCss = true;

/**
 * Allow user-preferences implemented in CSS? This allows users to customise the
 * site appearance to a greater degree; disabling it will improve page load
 * times.
 * @var bool $wgAllowUserCssPrefs
 */
$wgAllowUserCssPrefs = true;

/**
 * Allow user Javascript page? This enables a lot of neat customizations, but
 * may increase security risk to users and server load.
 * @var bool $wgAllowUserJs
 */
$wgAllowUserJs = true;

/**
 * Set this to always convert certain Unicode sequences to modern ones
 * regardless of the content language. This has a small performance impact.
 * @see $wgFixArabicUnicode
 * @see $wgFixMalayalamUnicode
 * @since 1.17
 * @var bool $wgAllUnicodeFixes
 */
$wgAllUnicodeFixes = false;

/**
 * Restrict video upload to admin/sysop only.
 * @see lib/Wikia/src/Service/User/Permissions/data/PermissionsDefinesAfterWikiFactory.php
 * @see extensions/wikia/YouTube/YouTube.php
 * @var bool $wgAllVideosAdminOnly
 */
$wgAllVideosAdminOnly = false;

/**
 * Tidy is a free tool that fixes broken HTML. When $wgUseTidy is true,
 * $wgAlwaysUseTidy adds a few extra cases, when Tidy is executed.
 * @see $wgUseTidy
 * @var bool $wgAlwaysUseTidy
 */
$wgAlwaysUseTidy = false;

/**
 * Enable dates like 'May 12' instead of '12 May', this only takes effect if
 * the interface is set to English.
 * @var bool $wgAmericanDates
 */
$wgAmericanDates = true;

/**
 * Anti-lock flags - bitfield
 *   - ALF_PRELOAD_LINKS:
 *       Preload links during link update for save
 *   - ALF_PRELOAD_EXISTENCE:
 *       Preload cur_id during replaceLinkHolders
 *   - ALF_NO_LINK_LOCK:
 *       Don't use locking reads when updating the link table. This is
 *       necessary for wikis with a high edit rate for performance
 *       reasons, but may cause link table inconsistency
 *   - ALF_NO_BLOCK_LOCK:
 *       As for ALF_LINK_LOCK, this flag is a necessity for high-traffic
 *       wikis.
 * @see includes/LinksUpdate.php
 * @see includes/cache/LinkCache.php
 * @var int $wgAntiLockFlags
 */
$wgAntiLockFlags = ALF_NO_LINK_LOCK;

/**
 * Internal name of virus scanner. This servers as a key to the
 * $wgAntivirusSetup array. Set this to NULL to disable virus scanning. If not
 * null, every file uploaded will be scanned for viruses.
 * @var string $wgAntivirus
 */
$wgAntivirus = null;

/**
 * Determines if a failed virus scan (AV_SCAN_FAILED) will cause the file to be
 * rejected.
 * @var bool $wgAntivirusRequired
 */
$wgAntivirusRequired = true;

/**
 * Set the timeout for the API help text cache. If set to 0, Memcached default
 * will be used.
 * @var int $wgAPICacheHelpTimeout
 */
$wgAPICacheHelpTimeout = 3600; // 1 hour

/**
 * Disallow framing of API pages directly, by setting the X-Frame-Options
 * header. Since the API returns CSRF tokens, allowing the results to be
 * framed can compromise your user's account security.
 * Options are:
 *   - 'DENY': Do not allow framing. This is recommended for most wikis.
 *   - 'SAMEORIGIN': Allow framing by pages on the same domain.
 *   - false: Allow all framing.
 * @var string|bool $wgApiFrameOptions
 */
$wgApiFrameOptions = 'DENY';

/**
 * API module extensions. Associative array mapping module name to class name.
 * Extension modules may override the core modules.
 * @var Array $wgAPIListModules
 */
$wgAPIListModules = [];

/**
 * Maximum amount of rows to scan in a DB query in the API.
 * @var int $wgAPIMaxDBRows
 */
$wgAPIMaxDBRows = 5000;

/**
 * The maximum size (in bytes) of an API result.
 * Don't set this lower than $wgMaxArticleSize*1024.
 * @see $wgMaxArticleSize
 * @var int $wgAPIMaxResultSize
 */
$wgAPIMaxResultSize = 8388608; // 8MiB

/**
 * The maximum number of uncached diffs that can be retrieved in one API
 * request. Set this to 0 to disable API diffs altogether.
 * @var int $wgAPIMaxUncachedDiffs
 */
$wgAPIMaxUncachedDiffs = 1;

/**
 * API module extensions. Associative array mapping module name to class name.
 * Extension modules may override the core modules.
 * @var Array $wgAPIMetaModules
 */
$wgAPIMetaModules = [];

/**
 * API module extensions. Associative array mapping module name to class name.
 * Extension modules may override the core modules.
 * @var Array $wgAPIModules
 */
$wgAPIModules = [];

/**
 * API module extensions. Associative array mapping module name to class name.
 * Extension modules may override the core modules.
 * @var Array $wgAPIPropModules
 */
$wgAPIPropModules = [];

/**
 * Log file or URL (TCP or UDP) to log API requests to, or false to disable
 * API request logging.
 * @var string|bool $wgAPIRequestLog
 */
$wgAPIRequestLog = false;

/**
 * Whether or not to purge squid proxy URLs lazy-loaded ArticleComments. This
 * is a legacy variable and its name does no longer reflect its purpose.
 * @see ArticleComment::doPurge()
 * @var bool $wgArticleCommentsLoadOnDemand
 */
$wgArticleCommentsLoadOnDemand = true;

/**
 * Maximum number of comments per page.
 * @see extensions/wikia/ArticleComments
 * @var bool $wgArticleCommentsMaxPerPage
 */
$wgArticleCommentsMaxPerPage = 25;

/**
 * Method used to determine if a page in a content namespace should be counted
 * as a valid article.
 *
 * Redirect pages will never be counted as valid articles.
 *
 * This variable can have the following values:
 * - 'any': all pages as considered as valid articles
 * - 'comma': the page must contain a comma to be considered valid
 * - 'link': the page must contain a [[wiki link]] to be considered valid
 * - null: the value will be set at run time depending on $wgUseCommaCount:
 *         if $wgUseCommaCount is false, it will be 'link', if it is true
 *         it will be 'comma'
 *
 * @see http://www.mediawiki.org/wiki/Manual:Article_count
 *
 * Retroactively changing this variable will not affect the existing count,
 * to update it, you will need to run the maintenance/updateArticleCount.php
 * script.
 *
 * @var string $wgArticleCountMethod
 */
$wgArticleCountMethod = 'any';

/**
 * Robot policies per article. These override the per-namespace robot policies.
 * Must be in the form of an array where the key part is a properly canonical-
 * ised text form title and the value is a robot policy.
 * Example:
 *   $wgArticleRobotPolicies = array( 'Main Page' => 'noindex,follow',
 *     'User:Bob' => 'index,follow' );
 * Example that DOES NOT WORK because the names are not canonical text forms:
 *   $wgArticleRobotPolicies = array(
 *     # Underscore, not space!
 *     'Main_Page' => 'noindex,follow',
 *     # "Project", not the actual project name!
 *     'Project:X' => 'index,follow',
 *     # Needs to be "Abc", not "abc" (unless $wgCapitalLinks is false for that namespace)!
 *     'abc' => 'noindex,nofollow'
 *   );
 * @var Array $wgArticleRobotPolicies
 */
$wgArticleRobotPolicies = [];

/**
 * Timeout for Asynchronous (background) HTTP requests.
 * @var int $wgAsyncHTTPTimeout
 */
$wgAsyncHTTPTimeout = 25;

/**
 * Authentication plugin.
 * @var $wgAuth AuthPlugin
 */
$wgAuth = null;

/**
 * Number of seconds before autoblock entries expire.
 * @var int $wgAutoblockExpiry
 */
$wgAutoblockExpiry = 24 * 3600; // 1 day

/**
 * Number of seconds an account is required to age before it's given the
 * implicit 'autoconfirm' group membership. This can be used to limit
 * privileges of new accounts. Accounts created by earlier versions of the
 * software may not have a recorded creation date, and will always be considered
 * to pass the age test. When left at 0, all registered accounts will pass.
 * @var int $wgAutoConfirmAge
 */
$wgAutoConfirmAge = 4 * 24 * 3600; // 4 days

/**
 * Number of edits an account requires before it is autoconfirmed.
 * Passing both this AND the time requirement is needed.
 * @var int $wgAutoConfirmCount
 */
$wgAutoConfirmCount = 0;

/**
 * Array mapping class names to filenames, for autoloading. Extensions should
 * add their classes in their setup files.
 * @var Array $wgAutoloadClasses
 */
$wgAutoloadClasses = [];

/**
 * Disable UserSignup captcha for these IPs.
 * @see extensions/wikia/UserLogin/UserSignupSpecialController.class.php
 * @var Array $wgAutomatedTestsIPsList
 */
$wgAutomatedTestsIPsList = [];

/**
 * Languages supported by HAWelcome.
 * @see extensions/wikia/HAWelcome/
 * @var Array $wgEnableHAWelcomeExt
 */
$wgAvailableHAWLang = [
	'br', 'ca', 'de', 'en', 'es', 'fa', 'fi', 'fr', 'gl', 'he', 'hu', 'ia',
	'id', 'it', 'ja', 'mk', 'nl', 'no', 'oc', 'pl', 'pms', 'pt', 'pt-br', 'ru',
	'sv', 'tl', 'uk', 'vi', 'zh', 'zh-classical', 'zh-cn', 'zh-hans', 'zh-hant',
	'zh-hk', 'zh-min-nan', 'zh-mo', 'zh-my', 'zh-sg', 'zh-tw', 'zh-yue' ];

/**
 * Language - Help wiki mapping.
 * @see /extensions/wikia/SharedHelp
 * @var Array $wgAvailableHelpLang
 */
$wgAvailableHelpLang = [
	'ca'           => 3487, // Catalan, Help wiki same as for Spanish (es)
	'de'           => 1779,
	'en'           => 177, /* default */
	'es'           => 3487,
	'fi'           => 3083,
	'fr'           => 10261,
	'it'           => 11250,
	'ja'           => 3439,
	'ko'           => 10465,
	'nl'           => 10466,
	'pl'           => 1686,
	'pt'           => 696403,
	'pt-br'        => 696403,
	'ru'           => 3321,
	'uk'           => 791363,
	'vi'           => 423369,
	'zh'           => 4079,
	'zh-classical' => 4079,
	'zh-cn'        => 4079,
	'zh-hans'      => 4079,
	'zh-hant'      => 4079,
	'zh-hk'        => 4079,
	'zh-min-nan'   => 4079,
	'zh-mo'        => 4079,
	'zh-my'        => 4079,
	'zh-sg'        => 4079,
	'zh-tw'        => 4079,
	'zh-yue'       => 4079,
];

/**
 * Disable avatars related operations (uploads and deletes) for maintenance.
 *
 * As a side note, as a client of the service, MediaWiki shouldn't care whether
 * the service is undergoing maintenance or not. If the service is not
 * operational, MediaWiki _must_ display some fallback image and _should_ log
 * the event.
 *
 * @var bool $wgAvatarsMaintenance
 */
$wgAvatarsMaintenance = false;

/**
 * Index outbound links for backlink support in Solr.
 * @see app/extensions/wikia/Search/classes/IndexService/DefaultContent.php
 * @var bool $wgBacklinksEnabled
 */
$wgBacklinksEnabled = false;

/**
 * Directionality support, removed in 1.18, still kept here for LiquidThreads
 * backwards compatibility.
 * @deprecated since 1.18
 * @var bool $wgBetterDirectionality
 */
$wgBetterDirectionality = true;

/**
 * Pages from these categories will not be shown as Related Pages.
 * @see includes/wikia/services/CategoriesService.class.php
 * @see extensions/wikia/RelatedPages/RelatedPages.class.php
 * @var Array $wgBiggestCategoriesBlacklist
 */
$wgBiggestCategoriesBlacklist = [
	'Administración_del_sitio', 'Administration', 'Allgemeine_Vorlagen',
	'Article', 'Article_management_templates', 'articles', 'Artikel-Vorlagen',
	'attention', 'Ayuda', 'Banned', 'Begriffsklärung', 'Bildzitat', 'Browse',
	'Candidatas_para_borrado', 'candidate', 'candidates', 'Category_templates',
	'CC-by', 'CC-by-1.0', 'CC-by-2.0', 'CC-by-2.5', 'CC-by-sa', 'CC-by-sa-1.0',
	'CC-by-sa-2.0', 'CC-by-sa-2.5', 'CC-sa-1.0', 'cleanup', 'Code-Vorlagen',
	'Community', 'Comunidad', 'Contenidos', 'Content', 'Copy_edit', 'Copyright',
	'Copyrighted_free_use', 'Datei-Vorlagen', 'Dateien', 'Dateien_nach_Lizenz',
	'Dateien_von_flickr', 'Delete', 'deleting', 'deletion', 'Desambiguaciones',
	'Desambiguaciones', 'Destruir', 'Dringende_Löschanträge', 'Emoticons',
	'Esbozo', 'Esbozos', 'Fair_use', 'FAL', 'File', 'files', 'Forenbeiträge',
	'Foros', 'Forum', 'Forums', 'General', 'General_wiki_templates', 'GFDL',
	'GPL', 'Help', 'Help_desk', 'Hidden_categories', 'Image',
	'Image_wiki_templates', 'images', 'Imágenes', 'infobox', 'Infobox-Vorlagen',
	'Infobox_templates', 'Inhalt', 'Instandhaltung', 'Kategorie-Vorlagen',
	'LGPL', 'Lizenz_unbekannt', 'Lizenzvorlagen', 'Löschanträge', 'merge',
	'merged', 'Mesa_de_ayuda', 'need', 'needed', 'needing', 'needs',
	'Neue_Seiten', 'nominated', 'nomination', 'Opisy_licencji', 'page', 'pages',
	'Panel', 'panels', 'PD', 'Plantillas', 'Plantillas_de_categoría',
	'Plantillas_de_imágenes', 'Plantillas_de_mantenimiento',
	'Plantillas_generales', 'Policy', 'Políticas', 'Public_domain_files',
	'Redirect', 'redirects', 'request', 'requested', 'requests', 'Screencap',
	'screencaps', 'Screenshot', 'screenshots', 'Site_administration',
	'Site_maintenance', 'Skript-Benutzerkonten_von_Wikia', 'Stub', 'stubs',
	'Szablony', 'TagSynced', 'Template', 'Template_documentation', 'templated',
	'templates', 'Vorlagen', 'Vídeos', 'Watercooler', 'wiki', 'wikify',
];

/**
 * Servers in blobs cluster (blobs, etc.)
 * @var Array $wgBlobs001Cluster
 */
$wgBlobs001Cluster = [
	'geo-db-blobs-a-master.query.consul' => 0,
	'geo-db-blobs-a-slave.query.consul' => 1000
];

/**
 * Set this to true to allow blocked users to edit their own user talk page.
 * @var bool $wgBlockAllowsUTEdit
 */
$wgBlockAllowsUTEdit = true;

/**
 * Limits on the possible sizes of range blocks.
 *
 * CIDR notation is hard to understand, it's easy to mistakenly assume that a
 * /1 is a small range and a /31 is a large range. For IPv4, setting a limit of
 * half the number of bits avoids such errors, and allows entire ISPs to be
 * blocked using a small number of range blocks.
 *
 * For IPv6, RFC 3177 recommends that a /48 be allocated to every residential
 * customer, so range blocks larger than /64 (half the number of bits) will
 * plainly be required. RFC 4692 implies that a very large ISP may be
 * allocated a /19 if a generous HD-Ratio of 0.8 is used, so we will use that
 * as our limit. As of 2012, blocking the whole world would require a /4 range.
 * @var Array $wgBlockCIDRLimit
 */
$wgBlockCIDRLimit = [
	'IPv4' => 16, # Blocks larger than a /16 (64k addresses) will not be allowed
	'IPv6' => 19,
];

/**
 * If true, blocked users will not be allowed to login. When using this with
 * a public wiki, the effect of logging out blocked users may actually be
 * avers: unless the user's address is also blocked (e.g. auto-block),
 * logging the user out will again allow reading and editing, just as for
 * anonymous visitors.
 * @var bool $wgBlockDisablesLogin
 */
$wgBlockDisablesLogin = false;

/**
 * Banned analytics providers.
 * @see extensions/wikia/AnalyticsEngine/AnalyticsEngine.php
 * @var Array $wgBlockedAnalyticsProviders
 */
$wgBlockedAnalyticsProviders = [ 'IVW' ];

/**
 * If you enable this, every editor's IP address will be scanned for open HTTP
 * proxies. Don't enable this. Many sysops will report "hostile TCP port scans"
 * to your ISP and ask for your server to be shut down. You have been warned.
 * @var bool $wgBlockOpenProxies
 */
$wgBlockOpenProxies = false;

/**
 * Break out of framesets. This can be used to prevent clickjacking attacks,
 * or to prevent external sites from framing your site with ads.
 * @var bool $wgBreakFrames
 */
$wgBreakFrames = false;

/**
 * Browser Blacklist for unicode non compliant browsers. Contains a list of
 * regexps : "/regexp/"  matching problematic browsers. These browsers will
 * be served encoded unicode in the edit box instead of real unicode.
 * @var Array $wgBrowserBlackList
 */
$wgBrowserBlackList = [
	/**
	 * Netscape 2-4 detection
	 * The minor version may contain strings such as "Gold" or "SGoldC-SGI"
	 * Lots of non-netscape user agents have "compatible", so it's useful to check for that
	 * with a negative assertion. The [UIN] identifier specifies the level of security
	 * in a Netscape/Mozilla browser, checking for it rules out a number of fakers.
	 * The language string is unreliable, it is missing on NS4 Mac.
	 *
	 * Reference: http://www.psychedelix.com/agents/index.shtml
	 */
	'/^Mozilla\/2\.[^ ]+ [^(]*?\((?!compatible).*; [UIN]/',
	'/^Mozilla\/3\.[^ ]+ [^(]*?\((?!compatible).*; [UIN]/',
	'/^Mozilla\/4\.[^ ]+ [^(]*?\((?!compatible).*; [UIN]/',
	/**
	 * MSIE on Mac OS 9 is teh sux0r, converts þ to <thorn>, ð to <eth>, Þ to <THORN> and Ð to <ETH>
	 *
	 * Known useragents:
	 * - Mozilla/4.0 (compatible; MSIE 5.0; Mac_PowerPC)
	 * - Mozilla/4.0 (compatible; MSIE 5.15; Mac_PowerPC)
	 * - Mozilla/4.0 (compatible; MSIE 5.23; Mac_PowerPC)
	 * - [...]
	 *
	 * @see http://en.wikipedia.org/w/index.php?title=User%3A%C6var_Arnfj%F6r%F0_Bjarmason%2Ftestme&diff=12356041&oldid=12355864
	 * @see http://en.wikipedia.org/wiki/Template%3AOS9
	 */
	'/^Mozilla\/4\.0 \(compatible; MSIE \d+\.\d+; Mac_PowerPC\)/',
	/**
	 * Google wireless transcoder, seems to eat a lot of chars alive
	 * http://it.wikipedia.org/w/index.php?title=Luciano_Ligabue&diff=prev&oldid=8857361
	 */
	'/^Mozilla\/4\.0 \(compatible; MSIE 6.0; Windows NT 5.0; Google Wireless Transcoder;\)/'
];

/**
 * If set to true, this will roll back a few bug fixes introduced in 1.19,
 * emulating the 1.18 behaviour, to avoid introducing bug 34832. In 1.19,
 * language variant conversion is disabled in interface messages. Setting this
 * to true re-enables it. This variable should be removed (implicitly false) in
 * 1.20 or earlier.
 * @var bool $wgBug34832TransitionalRollback
 */
$wgBug34832TransitionalRollback = true;

/**
 * Set this to current time to invalidate all prior cached pages. Affects both
 * client- and server-side caching. You can get the current date on your server
 * by using the command: date +%Y%m%d%H%M%S
 * @var string $wgCacheEpoch
 */
$wgCacheEpoch = '20080205154442';

/**
 * Allow client-side caching of pages.
 * @var bool $wgCachePages
 */
$wgCachePages = true;

/**
 * Overwrite the caching key prefix with custom value.
 * @since 1.19
 * @var bool $wgCachePrefix
 */
$wgCachePrefix = false;

/**
 * Cache shared metadata in memcached. Don't do this if the commons wiki is in
 * a different memcached domain.
 * @var bool $wgCacheSharedUploads
 */
$wgCacheSharedUploads = true;

/**
 * A list of cookies that vary the cache (for use by extensions.
 * @var Array $wgCacheVaryCookies
 */
$wgCacheVaryCookies = [];

/**
 * Whether to enable canonical language links in meta data.
 * @var bool $wgCanonicalLanguageLinks
 */
$wgCanonicalLanguageLinks = true;

/**
 * Canonical URL of the server, to use in IRC feeds and notification e-mails.
 * Must be fully qualified, even if $wgServer is protocol-relative.
 *
 * Defaults to $wgServer, expanded to a fully qualified http:// URL if needed.
 * @see $wgServer
 * @var string|bool $wgCanonicalServer
 */
$wgCanonicalServer = false;

/**
 * @since 1.16 - This can now be set per-namespace. Some special namespaces
 * (such as Special, see MWNamespace::$alwaysCapitalizedNamespaces for the full
 * list) must be true by default (and setting them has no effect), due to
 * various things that require them to be so. Also, since Talk namespaces need
 * to directly mirror their associated content namespaces, the values for those
 * are ignored in favor of the subject namespace's setting. Setting for NS_MEDIA
 * is taken automatically from NS_FILE.
 * @example $wgCapitalLinkOverrides[ NS_FILE ] = false;
 * @var Array $wgCapitalLinkOverrides
 */
$wgCapitalLinkOverrides = [];

/**
 * Set this to false to avoid forcing the first letter of links to capitals.
 * WARNING: may break links! This makes links COMPLETELY case-sensitive. Links
 * appearing with a capital at the beginning of a sentence will *not* go to the
 * same place as links in the middle of a sentence using a lowercase initial.
 * @var bool $wgCapitalLinks
 */
$wgCapitalLinks = true;

/**
 * Amazon's S3 storage with captcha files
 * @see extensions/wikia/Captcha/Module/FancyCaptcha.class.php
 * @see SUS-5790
 * @var string $wgCaptchaS3Bucket
 * @var string $wgCaptchaS3Path
 */
$wgCaptchaS3Bucket = 'fancy-captcha';
$wgCaptchaS3Path = 'images-20111115';

/**
 * Specify how category names should be sorted, when listed on a category page.
 * A sorting scheme is also known as a collation.
 *
 * Available values are:
 *
 *   - uppercase: Converts the category name to upper case, and sorts by that.
 *
 *   - identity: Does no conversion. Sorts by binary value of the string.
 *
 *   - uca-default: Provides access to the Unicode Collation Algorithm with
 *     the default element table. This is a compromise collation which sorts
 *     all languages in a mediocre way. However, it is better than "uppercase".
 *
 * To use the uca-default collation, you must have PHP's intl extension
 * installed. See http://php.net/manual/en/intl.setup.php . The details of the
 * resulting collation will depend on the version of ICU installed on the
 * server.
 *
 * After you change this, you must run maintenance/updateCollation.php to fix
 * the sort keys in the database.
 *
 * Extensions can define there own collations by subclassing Collation
 * and using the Collation::factory hook.
 *
 * @var string $wgCategoryCollation
 */
$wgCategoryCollation = 'uppercase';

/**
 * Default configuration for Category Exhibition extension.
 * @see extensions/wikia/CategoryExhibition/CategoryExhibitionSectionPages.class.php
 * @var int $wgCategoryExhibitionBlogsSectionRows
 */
$wgCategoryExhibitionBlogsSectionRows = 4;

/**
 * Default configuration for Category Exhibition extension.
 * @see extensions/wikia/CategoryExhibition/CategoryExhibitionSectionMedia.class.php
 * @var int $wgCategoryExhibitionMediaSectionRows
 */
$wgCategoryExhibitionMediaSectionRows = 4;

/**
 * Default configuration for Category Exhibition extension.
 * @see extensions/wikia/CategoryExhibition/CategoryExhibitionSectionPages.class.php
 * @var int $wgCategoryExhibitionPagesSectionRows
 */
$wgCategoryExhibitionPagesSectionRows = 4;

/**
 * Default configuration for Category Exhibition extension.
 * @see extensions/wikia/CategoryExhibition/CategoryExhibitionSectionSubcategories.class.php
 * @var int $wgCategoryExhibitionSubCategoriesSectionRows
 */
$wgCategoryExhibitionSubCategoriesSectionRows = 4;

/**
 * Show Category Gallery by default.
 * @see extensions/wikia/CategoryGalleries
 * @var bool $wgCategoryGalleryEnabledByDefault
 */
$wgCategoryGalleryEnabledByDefault = true;

/**
 * On category pages, show thumbnail gallery for images belonging to that
 * category instead of listing them as articles.
 * @var bool $wgCategoryMagicGallery
 */
$wgCategoryMagicGallery = true;

/**
 * Paging limit for categories.
 * @var int $wgCategoryPagingLimit
 */
$wgCategoryPagingLimit = 200;

/**
 * Points to ucp.fandom.com.
 * Should be switched to ucp.fandom.com for initial rollout and to community.fandom.com after
 * Community Central has been migrated to UCP.
 */
$wgCentralWikiId = 2182188;

/**
 * Chat server API address. Normally it is resolved by consul, but for
 * development and testing purposes you can specify it here.
 * @see ChatConfig::getApiServer()
 * @example example.com:80
 * @var string $wgChatPrivateServerOverride
 */
$wgChatPrivateServerOverride = null;

/**
 * Default chat host. Will be prefixed, based on the environment.
 * @see $wgWikiaEnvironment
 * @see extensions/wikia/Chat2/ChatConfig.class.php
 * @var string $wgChatPublicHost
 */
$wgChatPublicHost = 'chat.wikia-services.com:443';

/**
 * This is a flag to determine whether or not to check file extensions on
 * upload. WARNING: setting this to false is insecure for public wikis.
 * @var bool $wgCheckFileExtensions
 */
$wgCheckFileExtensions = true;

/**
 * Legacy variable, no longer used. Used to point to a file in the server where
 * CheckUser would log all queries done through Special:CheckUser. If this file
 * exists, the installer will try to import data from this file to the 'cu_log'
 * table in the database. Set to false disable.
 * @deprecated
 * @see extensions/CheckUser
 * @var string|bool $wgCheckUserLog
 */
$wgCheckUserLog = false;

/**
 * Wikis with CK editor as default (unless users set otherwise).
 * @see includes/wikia/Extensions.php
 * @var Array $wgCKEdefaultEditorTestWikis
 */
// TODO: Clean up after CK editor as default test is finished, used in app/includes/wikia/Extensions.php
// list of test wikis on which CK editor is the default editor (unless user explicitly sets different one)
$wgCKEdefaultEditorTestWikis = [
	// group 1
	544934, 14316, 130814, 14764, 490, 3469, 185111, 277, 38969, 1241752, 710900, 2569, 2180, 831, 105, 638551, 5975,
	68154, 175043, 643102, 750919, 31618, 9768, 1268, 6527, 12244, 985887, 677654, 659, 653222, 1426824, 1139, 6279, 766,
	271325, 667, 633820, 7193, 702401, 11344, 1166, 342218, 1030786, 312, 8221, 604797, 381, 824677, 134307, 212757,
	166617, 997, 14161, 1346, 4097, 321995, 525179, 536811, 8322, 5473, 1573, 175944, 880093, 1458654, 912, 1049,
	575144, 430, 1000027, 896, 1209305, 598369, 1138138, 977, 1163770, 11649, 12747, 1130468, 10178, 812244, 78127,
	66452, 670464, 3534, 1766, 4531, 594035, 699353, 5481, 12113, 44531, 1377985, 38926, 2022, 6877, 617245, 807122,
	718954, 4470, 427912, 310, 3066, 2531, 981708, 6708, 291796, 707903, 1013286, 1114574, 5682, 37152, 9637, 6139, 635,
	586931, 13501, 790642, 749375, 6390, 891, 4907, 435087, 7052, 553933, 594611, 468156, 401001, 534, 793375, 601762,
	1019331, 89210, 3395, 4267, 749, 1090910, 1473, 91051, 7439, 55445, 161263, 422454, 833147, 6521, 7639, 639206,
	112657, 8035, 989, 480886, 1248, 1110714, 8311, 470973, 544777, 768449, 189030, 122722, 7542, 480276, 1051712,
	614094, 1228271, 5618, 2459, 571430, 1097470, 1020891, 357399, 85103, 6342, 3212, 345416, 1304636, 989102, 2897,
	759, 2514, 57800, 580383, 1134817, 770288, 1021507, 1061981, 590987, 284111, 101230, 360967, 11115, 1023891, 822,
	792310, 12734, 593209, 265480, 1361490, 525359, 1055644, 1282596, 1199146, 5942, 1720, 8681, 392, 434195, 487467,
	764816, 1863, 580809, 570658, 1280124, 1178, 150738, 2781, 916058,
	// group 2
	530, 1081, 2520, 1254589, 1249, 3443, 1079837, 5278, 1544, 621556, 255, 3775, 169605, 3510, 24357, 462, 5813, 1744,
	769303, 458479, 35322, 22439, 867635, 260936, 1071836, 443588, 3313, 629, 2857, 376, 276141, 1332299, 13367, 608783,
	401, 18751, 295658, 249133, 151693, 245424, 458381, 848200, 20780, 941394, 740935, 1012029, 51, 7434, 3405, 118480,
	681379, 2866, 1153146, 2154, 1258949, 1114809, 801751, 11106, 724592, 9144, 3144, 1149584, 803756, 955166, 3489,
	124137, 823, 1062439, 79888, 543435, 1407, 602, 297767, 1053611, 665, 281135, 44732, 6216, 87205, 5748, 95, 91319,
	750, 6092, 204565, 27822, 47276, 140095, 7976, 146012, 453462, 123411, 10994, 5858, 1048673, 305850, 3626, 644564,
	554951, 711765, 1024023, 1016456, 7727, 86644, 52685, 351990, 6236, 3289, 149192, 558403, 611971, 6546, 8015, 746358,
	765031, 3468, 745286, 1425, 130547, 558705, 1903, 1109913, 120639, 1206155, 3155, 1264671, 1015651, 1030684, 39401,
	2777, 1063533, 833670, 704662, 677670, 524772, 1391253, 6961, 296530, 547034, 636376, 7852, 9565, 1229499, 115238,
	1368, 1365085, 9252, 767758, 6013, 1464550, 3989, 1362292, 437084, 2334, 133392, 764460, 63627, 1872, 936541, 4396,
	410236, 2188, 5935, 744227, 281465, 1199421, 42426, 863039, 6786, 4156, 2794, 229033, 1204308, 2390, 114341, 2889,
	642, 566695, 3502, 598051, 781890, 736299, 6840, 3207, 930697, 849806, 1036242, 38188, 912119, 1066675, 953630,
	285136, 679923, 142503, 265126, 504037, 286083, 351776, 1393535, 3473, 73495, 1447835, 88531, 1084546, 6051, 643051,
	11764, 7060, 1337446, 26903, 351441, 1065217, 1715, 4951, 60471, 1718, 13022
];

/**
 * If true, removes (substitutes) templates in "~~~~" signatures.
 * @var bool $wgCleanSignatures
 */
$wgCleanSignatures = true;

/**
 * Cleanup as much presentational html like valign -> css vertical-align as we
 * can.
 * @var bool $wgCleanupPresentationalAttributes
 */
$wgCleanupPresentationalAttributes = true;

/**
 * Clock skew or the one-second resolution of time() can occasionally cause
 * cache problems when the user requests two pages within a short period of
 * time. This variable adds a given number of seconds to vulnerable timestamps,
 * thereby giving a grace period.
 * @var int $wgClockSkewFudge
 */
$wgClockSkewFudge = 5;

/**
 * For colorized maintenance script output, is your terminal background dark?
 * @var bool $wgCommandLineDarkBg
 */
$wgCommandLineDarkBg = false;

/**
 * Hide Top Contributors in Community Page.
 * @see app/extensions/wikia/CommunityPage/
 * @var bool $wgCommunityPageDisableTopContributors
 */
$wgCommunityPageDisableTopContributors = false;

/**
 * A list of files that should be compiled into a HipHop build, in addition to
 * those listed in $wgAutoloadClasses. Add to this array in an extension setup
 * file in order to add files to the build.
 *
 * The files listed here must either be either absolute paths under $IP or
 * under $wgExtensionsDirectory, or paths relative to the virtual source root
 * "$IP/..", i.e. starting with "phase3" for core files, and "extensions" for
 * extension files.
 * @var Array $wgCompiledFiles
 */
$wgCompiledFiles = [];

/**
 * We can also compress text stored in the 'text' table. If this is set on, new
 * revisions will be compressed on page save if zlib support is available. Any
 * compressed revisions will be decompressed on load regardless of this setting
 * *but will not be readable at all* if zlib support is not available.
 * @var bool $wgCompressRevisions
 */
$wgCompressRevisions = true;

/**
 * Hardcoded list of data-centers by environment
 *
 * Avoid costly HTTP calls on production to Consul agents in data centers like 'poz' or 'fra'
 *
 * @see SUS-4805
 *
 * @see lib/Wikia/src/Consul/Client.php
 * @var array $wgConsulDataCenters
 */
$wgConsulDataCenters = [
	'dev' => [
		'sjc',
		'poz',
	],
	'prod' => [
		'sjc',
		'res',
	],
	'sandbox' => [
		'sjc',
		'res',
	],
	'preview' => [
		'sjc',
		'res',
	],
	'verify' => [
		'sjc',
		'res',
	],
	'stable' => [
		'sjc',
		'res',
	],
];

/**
 * Default cookie expiration time. Setting to 0 makes all cookies session-only.
 * @var int $wgCookieExpiration
 */
$wgCookieExpiration = 180 * 24 * 3600; // 180 days

/**
 * Set authentication cookies to HttpOnly to prevent access by JavaScript,
 * in browsers that support this feature. This can mitigates some classes of
 * XSS attack.
 * @var bool $wgCookieHttpOnly
 */
$wgCookieHttpOnly = true;

/**
 * Set this variable if you want to restrict cookies to a certain path within
 * the domain specified by $wgCookieDomain.
 * @var string $wgCookiePath
 */
$wgCookiePath = '/';

/**
 * Cookies generated by MediaWiki have names starting with this prefix. Set it
 * to a string to use a custom prefix. Setting it to false causes the database
 * name to be used as a prefix.
 * @var string $wgCookiePrefix
 */
$wgCookiePrefix = 'wikicities';

/**
 * Whether the "secure" flag should be set on the cookie. This can be:
 *   - true:      Set secure flag
 *   - false:     Don't set secure flag
 *   - "detect":  Set the secure flag if $wgServer is set to an HTTPS URL
 * @var bool|string $wgCookieSecure
 */
$wgCookieSecure = 'detect';

/**
 * Set this to some HTML to override the rights icon with an arbitrary logo.
 * @deprecated since 1.18 Use $wgFooterIcons['copyright']['copyright']
 * @var string $wgCopyrightIcon
 */
$wgCopyrightIcon = null;

/**
 * On Special:Unusedimages, consider images "used", if they are put into
 * a category. Default (false) is not to count those as used.
 * @var bool $wgCountCategorizedImagesAsUsed
 */
$wgCountCategorizedImagesAsUsed = false;

/**
 * Set to true to have the search engine count total search matches to present
 * in the Special:Search UI. Not supported by every search engine shipped with
 * MW. This could however be slow on larger wikis, and is pretty flaky with the
 * current title vs content split. Recommend avoiding until that's been worked
 * out cleanly; but this may aid in testing the search UI and API to confirm
 * that the result count works.
 * @var bool $wgCountTotalSearchHits
 */
$wgCountTotalSearchHits = false;

/**
 * Create new communities on this cluster.
 * @see extensions/wikia/CreateNewWiki
 * @var string $wgCreateDatabaseActiveCluster
 */
$wgCreateDatabaseActiveCluster = 'c7';

/**
 * Domains that should not be allowed to make AJAX requests,
 * even if they match one of the domains allowed by $wgCrossSiteAJAXdomains
 * Uses the same syntax as $wgCrossSiteAJAXdomains
 *
 * @see $wgCrossSiteAJAXdomains
 * @var Array $wgCrossSiteAJAXdomainExceptions
 */
$wgCrossSiteAJAXdomainExceptions = [];

/**
 * Wikis that should not be searched (Wikia Search Extension).
 * @see extensions/wikia/Search/classes/QueryService/
 * @var Array $wgCrossWikiaSearchExcludedWikis
 */
$wgCrossWikiaSearchExcludedWikis = [
	// Answers
	11557,
	// Spademanns wiki
	1524,
	// Community Central
	177,
	// Scratchpad
	95,
	// QA Wikis
	13604, 40726, 46734, 43960, 43963, 43964, 43965, 43966, 43967, 43952,
];

/**
 * Use another resizing converter, e.g. GraphicMagick %s will be replaced with
 * the source path, %d with the destination %w and %h will be replaced with the
 * width and height. Leave as false to skip this.
 * @example $wgCustomConvertCommand = "gm convert %s -resize %wx%h %d"
 * @var string|bool $wgCustomConvertCommand
 */
$wgCustomConvertCommand = false;

/**
 * Select which DBA handler to use as CACHE_DBA backend.
 * @see http://www.php.net/manual/en/dba.requirements.php
 * @var string $wgDBAhandler
 */
$wgDBAhandler = 'db3';

/**
 * Servers in archive cluster (blobs, dataware, etc.)
 * @var Array $wgDBArchiveCluster
 */
$wgDBArchiveCluster = [
	'geo-db-archive-master.query.consul' => 0,
	'geo-db-archive-slave.query.consul' => 1000
];

/**
 * Scale load balancer polling time so that under overload conditions, the
 * database server receives a SHOW STATUS query at an average interval of this
 * many microseconds.
 * @see includes/db/LoadBalancer.php
 * @var int $wgDBAvgStatusPoll
 */
$wgDBAvgStatusPoll = 30000; // 0.03 ms

/**
 * Issue a warning when database server lag is higher than this number of
 * seconds.
 * @var int $wgDBClusterTimeout
 */
$wgDBClusterTimeout = 10;

/**
 * File to log database errors to.
 * @var string|bool $wgDBerrorLog
 */
$wgDBerrorLog = false;

/**
 * Mediawiki schema.
 * @var string $wgDBmwschema
 */
$wgDBmwschema = 'mediawiki';

/**
 * Set to true to engage MySQL 4.1/5.0 charset-related features; for now will
 * just cause sending of 'SET NAMES=utf8' on connect. WARNING: THIS IS
 * EXPERIMENTAL! May break if you're not using the table defs from
 * mysql5/tables.sql. May break if you're upgrading an existing wiki if set
 * differently. Broken symptoms likely to include incorrect behavior with page
 * titles, usernames, comments etc containing non-ASCII characters. Might also
 * cause failures on the object cache and other things. Even correct usage may
 * cause failures with Unicode supplementary characters (those not in the Basic
 * Multilingual Plane) unless MySQL has enhanced their Unicode support.
 * @var true $wgDBmysql5
 */
$wgDBmysql5 = false;

/**
 * Name of the database.
 * @var string $wgDBname
 */
$wgDBname = 'my_wiki';

/**
 * Database port number (for PostgreSQL).
 * @var int $wgDBport
 */
$wgDBport = 5432;

/**
 * Table name prefix.
 * @var string $wgDBprefix
 */
$wgDBprefix = '';

/**
 * Database load balancer
 * This is a two-dimensional array, an array of server info structures
 * Fields are:
 *   - host:        Host name
 *   - dbname:      Default database name
 *   - user:        DB user
 *   - password:    DB password
 *   - type:        "mysql" or "postgres"
 *   - load:        ratio of DB_SLAVE load, must be >=0, the sum of all loads must be >0
 *   - groupLoads:  array of load ratios, the key is the query group name. A query may belong
 *                  to several groups, the most specific group defined here is used.
 *
 *   - flags:       bit field
 *                  - DBO_DEFAULT -- turns on DBO_TRX only if !$wgCommandLineMode (recommended)
 *                  - DBO_DEBUG -- equivalent of $wgDebugDumpSql
 *                  - DBO_TRX -- wrap entire request in a transaction
 *                  - DBO_IGNORE -- ignore errors (not useful in LocalSettings.php)
 *                  - DBO_NOBUFFER -- turn off buffering (not useful in LocalSettings.php)
 *
 *   - max lag:     (optional) Maximum replication lag before a slave will taken out of rotation
 *   - max threads: (optional) Maximum number of running threads
 *
 *   These and any other user-defined properties will be assigned to the mLBInfo member
 *   variable of the Database object.
 *
 * Leave at false to use the single-server variables above. If you set this
 * variable, the single-server variables will generally be ignored (except
 * perhaps in some command-line scripts).
 *
 * The first server listed in this array (with key 0) will be the master. The
 * rest of the servers will be slaves. To prevent writes to your slaves due to
 * accidental misconfiguration or MediaWiki bugs, set read_only=1 on all your
 * slaves in my.cnf. You can set read_only mode at runtime using:
 *
 * <code>
 *     SET @@read_only=1;
 * </code>
 *
 * Since the effect of writing to a slave is so damaging and difficult to clean
 * up, we at Wikimedia set read_only=1 in my.cnf on all our DB servers, even
 * our masters, and then set read_only=0 on masters at runtime.
 *
 * @var Array|bool $wgDBservers
 */
$wgDBservers = false;

/**
 * MySQL table options to use during installation or update.
 * @var string $wgDBTableOptions
 */
$wgDBTableOptions = 'ENGINE=InnoDB';

/**
 * Selenium database user's password.
 * @see app/includes/SeleniumWebSettings.php
 * @var string $wgDBtestpassword
 */
$wgDBtestpassword = '';

/**
 * Selenium database user (only to create and drop test databases)
 * @see app/includes/SeleniumWebSettings.php
 * @var string $wgDBtestuser
 */
$wgDBtestuser = '';

/**
 * Database engine / type.
 * @var string $wgDBtype
 */
$wgDBtype = 'mysql';

/**
 * Database username.
 * @var string $wgDBuser
 */
$wgDBuser = 'mw_only';

/**
 * Send debug data to an HTML comment in the output. This may occasionally be
 * useful when supporting a non-technical end-user. It's more secure than
 * exposing the debug log file to the web, since the output only contains
 * private data for the current user. But it's not ideal for development use
 * since data is lost on fatal errors and redirects.
 * @var bool $wgDebugComments
 */
$wgDebugComments = false;

/**
 * Write SQL queries to the debug log.
 * @var bool $wgDebugDumpSql
 */
$wgDebugDumpSql = false;

/**
 * Output debug message on every wfProfileIn/wfProfileOut.
 * @var bool $wgDebugFunctionEntry
 */
$wgDebugFunctionEntry = false;

/**
 * Filename for debug logging. See http://www.mediawiki.org/wiki/How_to_debug
 * The debug log file should be not be publicly accessible if it is used, as it
 * may contain private data.
 * @see wfDebug()
 * @see $wgShowDebug
 * @var string $wgDebugLogFile
 */
$wgDebugLogFile = '';

/**
 * Set to an array of log group keys to filenames. If set, wfDebugLog() output
 * for that group will go to that file instead of the regular $wgDebugLogFile.
 * Useful for enabling selective logging in production.
 * @var Array $wgDebugLogGroups
 */
$wgDebugLogGroups = [
	'ExternalStorage' => true,
	'ExternalStoreDB' => true,
	'MessageCache' => true,
	'poolcounter' => true,  // errors from PoolCounterWork
	'replication' => true,  // replication errros / excessive lags
	'squid' => true,        // timeouts and errors from SquidPurgeClient
	'createwiki' => true,   // CreateWiki process
];

/**
 * Prefix for debug log lines.
 * @var string $wgDebugLogPrefix
 */
$wgDebugLogPrefix = '';

/**
 * Print HTTP headers for every request in the debug information.
 * @var bool $wgDebugPrintHttpHeaders
 */
$wgDebugPrintHttpHeaders = true;

/**
 * Detects non-matching wfProfileIn/wfProfileOut calls.
 * @var bool $wgDebugProfiling
 */
$wgDebugProfiling = false;

/**
 * If true, log debugging data from action=raw and load.php. This is normally
 * false to avoid overlapping debug entries due to gen=css and gen=js requests.
 * @var bool $wgDebugRawPage = false;
 */
$wgDebugRawPage = false;

/**
 * If true, instead of redirecting, show a page with a link to the redirect
 * destination. This allows for the inspection of PHP error messages, and easy
 * resubmission of form data. For developer use only.
 * @var bool $wgDebugRedirects
 */
$wgDebugRedirects = false;

/**
 * Put tidy warnings in HTML comments. Only works for internal tidy.
 * @var bool $wgDebugTidy
 */
$wgDebugTidy = false;

/**
 * Prefix debug messages with relative timestamp. Very-poor man's profiler.
 * Since 1.19 also includes memory usage.
 * @var bool $wgDebugTimestamps
 */
$wgDebugTimestamps = false;

/**
 * Display the new debugging toolbar. This also enables profiling on database
 * queries and other useful output. Will disable file cache.
 *
 * @since 1.19
 * @var bool $wgDebugToolbar
 */
$wgDebugToolbar = false;

/**
 * Storage for revision contents. If false, contents will be stored in the local
 * per-wiki text table. Can be a string or an array for data distribution. Keys
 * must be consecutive integers, starting at zero.
 * @var Array $wgDefaultExternalStore
 */
$wgDefaultExternalStore = [ 'DB://blobs20141' ];

/**
 * Default variant code, if false, the default will be the language code.
 * @var string|bool $wgDefaultLanguageVariant
 */
$wgDefaultLanguageVariant = false;

/**
 * Default robot policy.  The default policy is to encourage indexing and
 * following of links.  It may be overridden on a per-namespace and/or per-page
 * basis.
 * @see includes/Article.php
 * @global string $wgDefaultRobotPolicy
 */
$wgDefaultRobotPolicy = 'index,follow';

/**
 * Default search profile.
 * @see extensions/wikia/Search
 * @see skins/oasis/modules/SearchController.class.php
 * @var string $wgDefaultSearchProfile
 */
$wgDefaultSearchProfile = 'default';

/**
 * Settings added to this array will override the default globals for the user
 * preferences used by anonymous visitors and newly created accounts.
 * For instance, to disable section editing links:
 *
 * @example $wgDefaultUserOptions ['editsection'] = 0;
 * @var Array $wgDefaultUserOptions
 */
$wgDefaultUserOptions = [
	'ccmeonemails' => 0,
	'cols' => 80,
	'date' => 'default',
	'diffonly' => 0,
	'disablefeaturedvideo' => 1,
	'disablemail' => 0,
	'disablesuggest' => 0,
	'editfont' => 'default',
	'editondblclick' => 0,
	/*
	 * Default editor is VisualEditor. This is used in
	 * app/extensions/wikia/EditorPreference/EditorPreference.class.php
	 */
	'editor' => 2,
	'editsection' => 1,
	'editsectiononrightclick' => 0,
	'enotifdiscussionsfollows' => 1,
	'enotifdiscussionsvotes' => 1,
	'enotifminoredits' => 1,
	'enotifrevealaddr' => 0,
	'enotifusertalkpages' => 1,
	'enotifwatchlistpages' => 1,
	'extendwatchlist' => 0,
	'externaldiff' => 0,
	'externaleditor' => 0,
	'fancysig' => 0,
	'forceeditsummary' => 0,
	'gender' => 'unknown',
	'hideminor' => 0,
	'hidepatrolled' => 0,
	'highlightbroken' => 1,
	'htmlemails' => 1,
	'imagesize' => 1,
	'justify' => 0,
	'math' => 1,
	'minordefault' => 0,
	'newpageshidepatrolled' => 0,
	'nocache' => 0,
	'noconvertlink' => 0,
	'norollbackdiff' => 0,
	'numberheadings' => 0,
	'previewonfirst' => 0,
	'previewontop' => 1,
	'quickbar' => 5,
	'rcdays' => 7,
	'rclimit' => 50,
	'rememberpassword' => 0,
	'rows' => 25,
	'searchlimit' => 20,
	'showhiddencats' => 0,
	'showjumplinks' => 1,
	'shownumberswatching' => 1,
	'showtoc' => 1,
	'showtoolbar' => 1,
	'skin' => 'oasis',
	'stubthreshold' => 0,
	'timecorrection' => 'System|0',
	'thumbsize' => 2,
	'underline' => 2,
	'uselivepreview' => 0,
	'usenewrc' => 1,
	'watchcreations' => 1,
	'watchdefault' => 1,
	'watchdeletion' => 0,
	'watchlistdays' => 3.0,
	'watchlistdigest' => 1,
	'watchlisthideanons' => 0,
	'watchlisthidebots' => 0,
	'watchlisthideliu' => 0,
	'watchlisthideminor' => 0,
	'watchlisthideown' => 0,
	'watchlisthidepatrolled' => 0,
	'watchmoves' => 0,
	'wllimit' => 250,
];

/**
 * What directory to place deleted uploads in. If false,
 * $wgUploadDirectory/deleted will be used.
 * @see $wgUploadDirectory
 * @var string|bool $wgDeletedDirectory
 */
$wgDeletedDirectory = false;

/**
 * Optional to restrict deletion of pages with higher revision counts
 * to users with the 'bigdelete' permission. (Default given to sysops.)
 * @var int $wgDeleteRevisionsLimit
 */
$wgDeleteRevisionsLimit = 0;

/**
 * Release limitation to wfDeprecated warnings, if set to a release number
 * development warnings will not be generated for deprecations added in releases
 * after the limit.
 * @var string $wgDeprecationReleaseLimit
 */
$wgDeprecationReleaseLimit = '1.17';

/**
 * If set to true MediaWiki will throw notices for some possible error
 * conditions and for deprecated functions.
 * @var bool false
 */
$wgDevelopmentWarnings = false;

/**
 * Path to the GNU diff utility.
 * @var string $wgDiff
 */
$wgDiff = '/usr/bin/diff';

/**
 * Path to the GNU diff3 utility. If the file doesn't exist, edit conflicts will
 * fall back to the old behaviour (no merging).
 * @var string $wgDiff3
 */
$wgDiff3 = '/usr/bin/diff3';

/**
 * Default value for chmoding of new directories.
 * @see http://php.net/manual/en/function.mkdir.php
 * @see wfMkdirParents()
 * @var int $wgDirectoryMode
 */
$wgDirectoryMode = 0777;

/**
 * Turn off all email delivery.
 * @see includes/UserMailer.php
 * @var bool $wgDisableAllEmail
 */
$wgDisableAllEmail = false;

/**
 * Disable links to talk pages of anonymous users (IPs) in listings on special
 * pages like page history, Special:Recentchanges, etc.
 * @var bool $wgDisableAnonTalk
 */
$wgDisableAnonTalk = false;

/**
 * Disallow anonymous contributions.
 * @see VisualEditor
 * @see Mercury
 * @var bool $wgDisableAnonymousEditing
 */
$wgDisableAnonymousEditing = false;

/**
 * We are enabling photo upload from mercury for JP wiki
 * without login. This is temporary solution to disable such uploads.
 * @see https://wikia-inc.atlassian.net/browse/INT-155
 * @see extensions/wikia/MercuryApi
 * @var bool $wgDisableAnonymousUploadForMercury
 */
$wgDisableAnonymousUploadForMercury = false;

/**
 * By default, MediaWiki checks if the client supports cookies during the
 * login process, so that it can display an informative error message if
 * cookies are disabled. Set this to true if you want to disable this cookie
 * check.
 * @var bool $wgDisableCookieCheck
 */
$wgDisableCookieCheck = false;

/**
 * Array of disabled article actions, e.g. view, edit, delete, etc.
 * @deprecated since 1.18; just set $wgActions['action'] = false instead
 * @var Array $wgDisabledActions
 */
$wgDisabledActions = [];

/**
 * Disabled variants array of language variant conversion.
 * @example $wgDisabledVariants[] = 'zh-mo';
 * @example $wgDisabledVariants[] = 'zh-my';
 * @example $wgDisabledVariants = array('zh-mo', 'zh-my');
 * @var Array $wgDisabledVariants
 */
$wgDisabledVariants = [];

/**
 * Disable redirects to special pages and interwiki redirects, which use a 302
 * and have no "redirected from" link. Note this is only for articles with
 * #Redirect in them. URL's containing a local interwiki prefix (or
 * a non-canonical special page name) are still hard redirected regardless of
 * this setting.
 * @var bool $wgDisableHardRedirects
 */
$wgDisableHardRedirects = true;

/**
 * Disable the internal MySQL-based search, to allow it to be implemented by an
 * extension instead.
 * @var bool $wgDisableInternalSearch
 */
$wgDisableInternalSearch = false;

/**
 * Whether to enable language variant conversion.
 * @var bool $wgDisableLangConversion
 */
$wgDisableLangConversion = false;

/**
 * Flag set by Wikia staff to indicate that the Mercury section editor and
 * photo upload is disabled for this community
 * @see extensions/wikia/MercuryApi
 * @var bool $wgDisableMobileSectionEditor
 */
$wgDisableMobileSectionEditor = false;

/**
 * Disable output compression (enabled by default if zlib is available).
 * @var bool $wgDisableOutputCompression
 */
$wgDisableOutputCompression = false;

/**
 * Disable all query pages if miser mode is on, not just some.
 * @var bool $wgDisableQueryPages
 */
$wgDisableQueryPages = false;

/**
 * Set this to an array of special page names to prevent
 * maintenance/updateSpecialPages.php from updating those pages.
 * @var bool $wgDisableQueryPageUpdate
 */
$wgDisableQueryPageUpdate = false;

/**
 * If you've disabled search semi-permanently, this also disables updates to the
 * table. If you ever re-enable, be sure to rebuild the search table.
 * @var bool $wgDisableSearchUpdate
 */
$wgDisableSearchUpdate = true;

/**
 * Don't show articles in recirculation modules.
 * @see extensions/wikia/Recirculation/RecirculationHooks.class.php
 * @var bool $wgDisableShowInRecirculation
 */
$wgDisableShowInRecirculation = false;

/**
 * Set this to true to disable the full text search feature.
 * @var bool $wgDisableTextSearch
 */
$wgDisableTextSearch = false;

/**
 * Whether to enable language variant conversion for links.
 * @var bool $wgDisableTitleConversion
 */
$wgDisableTitleConversion = false;

/**
 * Setting this to true will disable the upload system's checks for
 * HTML/JavaScript. THIS IS VERY DANGEROUS on a publicly editable site, so USE
 * wgGroupPermissions TO RESTRICT UPLOADING to only those that you trust.
 * @var bool $wgDisableUploadScriptChecks
 */
$wgDisableUploadScriptChecks = false;

/**
 * Path of the djvudump executable. Enable this and $wgDjvuRenderer to enable
 * djvu rendering.
 * @see $wgDjvuRenderer
 * @var string $wgDjvuDump
 */
$wgDjvuDump = null;

/**
 * File extension for the DJVU post processor output.
 * @var string $wgDjvuOutputExtension
 */
$wgDjvuOutputExtension = 'jpg';

/**
 * Shell command for the DJVU post processor. Default: pnmtopng, since ddjvu
 * generates ppm output. Set this to false to output the ppm file directly.
 * @var string|bool $wgDjvuPostProcessor
 */
$wgDjvuPostProcessor = 'pnmtojpeg';

/**
 * Path of the ddjvu DJVU renderer. Enable this and $wgDjvuDump to enable djvu
 * rendering.
 * @see $wgDjvuDump
 * @var string $wgDjvuRenderer
 */
$wgDjvuRenderer = null;

/**
 * Path of the djvutoxml executable. This works like djvudump except much, much
 * slower as of version 3.5. For now I recommend you use djvudump instead. The
 * djvuxml output is probably more stable, so we'll switch back to it as soon as
 * they fix the efficiency problem.
 * http://sourceforge.net/tracker/index.php?func=detail&aid=1704049&group_id=32953&atid=406583
 * @var string $wgDjvuToXML
 */
$wgDjvuToXML = null;

/**
 * Path of the djvutxt DJVU text extraction utility. Enable this and $wgDjvuDump
 * to enable text layer extraction from djvu files.
 * @var string $wgDjvuTxt
 */
$wgDjvuTxt = null;

/**
 * List of DNS blacklists to use, if $wgEnableDnsBlacklist is true. This is an
 * array of either a URL or an array with the URL and a key (should the
 * blacklist require a key). For example:
 * @example
 * $wgDnsBlacklistUrls = array(
 *   // String containing URL
 *   'http.dnsbl.sorbs.net',
 *   // Array with URL and key, for services that require a key
 *   array( 'dnsbl.httpbl.net', 'mykey' ),
 *   // Array with just the URL. While this works, it is recommended that you
 *   // just use a string as shown above
 *   array( 'opm.tornevall.org' )
 * );
 * @since 1.16
 * @var Array $wgDnsBlacklistUrls
 */
$wgDnsBlacklistUrls = [ 'http.dnsbl.sorbs.net.' ];

/**
 * The HTML document type.  Ignored if $wgHtml5 is true, since <!DOCTYPE html>
 * doesn't actually have a doctype part to put this variable's contents in.
 * @var string $wgDocType
 */
$wgDocType = '-//W3C//DTD XHTML 1.0 Transitional//EN';

/**
 * Used to set a date when migrating a wiki to a different domain to force an
 * updated lastmod timestamp in sitemaps.
 * @see PLATFORM-3746
 * @var string $wgDomainChangeDate
 */
$wgDomainChangeDate = null;

/**
 * The URL of the document type declaration.  Ignored if $wgHtml5 is true,
 * since HTML5 has no DTD, and <!DOCTYPE html> doesn't actually have a DTD part
 * to put this variable's contents in.
 * @var string $wgDTD
 */
$wgDTD = 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd';

/**
 * List of language codes that don't correspond to an actual language.
 * These codes are mostly leftoffs from renames, or other legacy things.
 * This array makes them not appear as a selectable language on the installer,
 * and excludes them when running the transstat.php script.
 * @var Array $wgDummyLanguageCodes
 */
$wgDummyLanguageCodes = [
	'als' => 'gsw',
	'bat-smg' => 'sgs',
	'be-x-old' => 'be-tarask',
	'bh' => 'bho',
	'fiu-vro' => 'vro',
	'lol' => 'lol', # Used for In Context Translations
	'no' => 'nb',
	'qqq' => 'qqq', # Used for message documentation.
	'qqx' => 'qqx', # Used for viewing message keys.
	'roa-rup' => 'rup',
	'simple' => 'en',
	'zh-classical' => 'lzh',
	'zh-min-nan' => 'nan',
	'zh-yue' => 'yue',
];

/**
 * These communities should not be dumped with MediaWiki's
 * maintenance/dumpBackup.php for performance reasons.
 * @see extensions/wikia/WikiFactory/Dumps/runBackups.php
 * @var Array $wgDumpsDisabledWikis
 */
$wgDumpsDisabledWikis = [
	43339, // lyrics.wikia.com
	60540, // fr.lyrics.wikia.com
	78733, // websitewiki.wikia.com
];

/**
 * Character set for use in the article edit box. Language-specific encodings
 * may be defined. This historic feature is one of the first that was added by
 * former MediaWiki team leader Brion Vibber, and is used to support the
 * Esperanto x-system.
 * @var string $wgEditEncoding
 */
$wgEditEncoding = '';

/**
 * List of NS_MEDIAWIKI pages that users are allowed to edit.
 * @var Array $wgEditInterfaceWhitelist
 */
$wgEditInterfaceWhitelist = [
	// Interface messages
	'Blockedtext',
	'Blog-empty-user-blog',
	'Categoryblacklist',
	'Chat',
	'Chat-ban-option-list',
	'Chat-entry-point-guidelines',
	'Chat-join-the-chat',
	'Chat-live2',
	'Chat-start-a-chat',
	'Chat-status-away',
	'Chat-user-joined',
	'Chat-user-parted',
	'Chat-user-was-banned',
	'Chat-user-was-kicked',
	'Chat-welcome-message',
	'Community-corner',
	'Community-to-do-list',
	'Communitymessages-notice-msg',
	'Communitypage-policy-module-link-page-name',
	'Communitypage-subheader-welcome',
	'Communitypage-tasks-header-welcome',
	'Copyrightwarning',
	'Createpage-with-video',
	'Custom404page-noarticletext-alternative-found',
	'Deletereason-dropdown',
	'Description',
	'Editor-template-list',
	'Edittools',
	'Edittools-upload',
	'Emoticons',
	'Filedelete-reason-dropdown',
	'Forum-policies-and-faq',
	'Global-navigation-local-search-placeholder',
	'ImportJS',
	'Ipboptions',
	'Ipbreason-dropdown',
	'Licenses',
	'Mainpage',
	'Moveddeleted-notice',
	'Newarticletext',
	'Noarticletext',
	'Oasis-comments-header',
	'Pagetitle',
	'Pagetitle-view-mainpage',
	'Photosblacklist',
	'ProfileTags',
	'Protect-dropdown',
	'Recentchangestext',
	'Sidebar',
	'Sitenotice',
	'Sitenotice_id',
	'Smw_allows_pattern',
	'Talkpageheader',
	'Talkpagetext',
	'Titleblacklist',
	'TitleBlacklist',
	'Uploadtext',
	'User-identity-box-group-authenticated',
	'User-identity-box-group-blocked',
	'User-identity-box-group-bot',
	'User-identity-box-group-bureaucrat',
	'User-identity-box-group-chatmoderator',
	'User-identity-box-group-content-moderator',
	'User-identity-box-group-content-team-member',
	'User-identity-box-group-council',
	'User-identity-box-group-founder',
	'User-identity-box-group-helper',
	'User-identity-box-group-rollback',
	'User-identity-box-group-staff',
	'User-identity-box-group-sysop',
	'User-identity-box-group-threadmoderator',
	'User-identity-box-group-voldev',
	'User-identity-box-group-soap',
	'User-identity-box-group-wiki-manager',
	'Userrights-groups-help',
	'Welcome-bot-flag',
	'Welcome-enabled',
	'Welcome-message-anon',
	'Welcome-message-user',
	'Welcome-message-wall-anon',
	'Welcome-message-wall-user',
	'Welcome-user',
	'Welcome-user-page',
	'Wiki-navigation',
];

/**
 * Display user edit counts in various prominent places.
 * @var bool $wgEdititis
 */
$wgEdititis = false;

/**
 * The X-Frame-Options header to send on pages sensitive to clickjacking
 * attacks, such as edit pages. This prevents those pages from being displayed
 * in a frame or iframe. The options are:
 *
 *   - 'DENY': Do not allow framing. This is recommended for most wikis.
 *
 *   - 'SAMEORIGIN': Allow framing by pages on the same domain. This can be used
 *         to allow framing within a trusted domain. This is insecure if there
 *         is a page on the same domain which allows framing of arbitrary URLs.
 *
 *   - false: Allow all framing. This opens up the wiki to XSS attacks and thus
 *         full compromise of local user accounts. Private wikis behind a
 *         corporate firewall are especially vulnerable. This is not
 *         recommended.
 *
 * For extra safety, set $wgBreakFrames = true, to prevent framing on all pages,
 * not just edit pages.
 * @var string|bool $wgEditPageFrameOptions
 */
$wgEditPageFrameOptions = 'DENY';

/**
 * Mercury preview endpoint URL.
 * @see extensions/wikia/EditPageLayout/EditPageLayoutHelper.class.php
 * @var string $wgEditPreviewMercuryUrl
 */
$wgEditPreviewMercuryUrl = '/article-preview';

/**
 * Require email authentication before sending mail to an email addres. This is
 * highly recommended. It prevents MediaWiki from being used as an open spam
 * relay.
 * @var bool $wgEmailAuthentication
 */
$wgEmailAuthentication = true;

/**
 * Should editors be required to have a validated e-mail address before being
 * allowed to edit?
 * @var bool $wgEmailConfirmToEdit
 */
$wgEmailConfirmToEdit = false;

/**
 * Site admin email address.
 * @var string $wgEmergencyContact
 */
$wgEmergencyContact = 'community@fandom.com';

/**
 * Enable split testing (a/b testing) powered by data-warehouse.
 * @see extensions/wikia/AbTesting
 * @var bool $wgEnableAbTesting
 */
$wgEnableAbTesting = true;

/**
 * Enable AbuseFilterBypass extension.
 * @see extensions/wikia/AbuseFilterBypass
 * @var bool $wgEnableAbuseFilterBypass
 */
$wgEnableAbuseFilterBypass = true;

/**
 * Enable Abuse Filter extension.
 * @see lib/Wikia/src/Service/User/Permissions/data/PermissionsDefinesAfterWikiFactory.php
 * @see extensions/AbuseFilter
 * @var bool $wgEnableAbuseFilterExtension
 */
$wgEnableAbuseFilterExtension = false;

/**
 * Grant Sysops a permission to access Abuse Filter.
 * @see lib/Wikia/src/Service/User/Permissions/data/PermissionsDefinesAfterWikiFactory.php
 * @var bool $wgEnableAbuseFilterExtensionForSysop
 */
$wgEnableAbuseFilterExtensionForSysop = true;

/**
 * Show achievement badges with the RecentChange that earned them.
 * @see extensions/wikia/MyHome
 * @var bool $wgEnableAchievementsInActivityFeed
 */
$wgEnableAchievementsInActivityFeed = true;

/**
 * Enable ActivityFeed tag.
 * @see extensions/wikia/MyHome/ActivityFeedTag.php
 * @var bool $wgEnableActivityFeedTagExt
 */
$wgEnableActivityFeedTagExt = true;

/**
 * Enable AdminDashboard extension.
 * @see extensions/wikia/AdminDashboard
 * @var bool $wgEnableAdminDashboardExt
 */
$wgEnableAdminDashboardExt = true;

/**
 * Enable advertisement in content. Set to 0 to disable or 1+ to enable and
 * specify the number of advertisements.
 * @see extensions/wikia/AdEngine3/AdEngine3ContextService.class.php
 * @var int $wgEnableAdsInContent
 */
$wgEnableAdsInContent = 1;

/**
 * Enable AjaxPoll extension.
 * @see /extensions/wikia/AjaxPoll
 * @var bool $wgEnableAjaxPollExt
 */
$wgEnableAjaxPollExt = true;

/**
 * Enable AntiSpoof extension.
 * @see extensions/AntiSpoof
 * @var bool $wgEnableAntiSpoofExt
 */
$wgEnableAntiSpoofExt = true;

/**
 * Enable ApesterTag extension.
 * @see extensions/wikia/ApesterTag
 * @var bool $wgEnableApesterTagExt
 */
$wgEnableApesterTagExt = true;

/**
 * Enable the MediaWiki API for convenient access to machine-readable data via
 * api.php.
 *
 * @see http://www.mediawiki.org/wiki/API
 * @var bool $wgEnableAPI
 */
$wgEnableAPI = true;

/**
 * Used to set $wgArticleCommentsNamespaces properly.
 * @see $wgArticleCommentsNamespaces
 * @var bool $wgEnableArticleCommentsExt
 */
$wgEnableArticleCommentsExt = false;

/**
 * Used to put article comments extension in readonly mode
 */
$wgArticleCommentsReadOnlyMode = false;

/**
 * Enable ArticleVideo extension.
 * @see extensions/wikia/ArticleVideo
 * @see extensions/wikia/SiteWideMessages
 * @see extensions/wikia/Recirculation
 * @var bool $wgEnableArticleFeaturedVideo
 */
$wgEnableArticleFeaturedVideo = true;

/**
 * Enable meta-description tag for Articles.
 * @see /extensions/wikia/ArticleMetaDescription
 * @var bool $wgEnableArticleMetaDescription
 */
$wgEnableArticleMetaDescription = true;

/**
 * Enable ArticleVideo extension.
 * @see extensions/wikia/ArticleVideo
 * @var bool $wgEnableArticleRelatedVideo
 */
$wgEnableArticleRelatedVideo = true;

/**
 * Enable ArticlesAsResources extension.
 * @see extensions/wikia/ArticlesAsResources
 * @var bool $wgEnableArticlesAsResourcesExt
 */
$wgEnableArticlesAsResourcesExt = true;

/**
 * Enables support for Watchlists in ArticleComments.
 * @see extensions/wikia/ArticleComments
 * @var bool $wgEnableArticleWatchlist
 */
$wgEnableArticleWatchlist = true;

/**
 * Enable Author Profile links in the DesignSystem API
 * @see includes/wikia/models/DesignSystemGlobalNavigationModel.class.php
 * @var bool $wgEnableAuthorProfileLinks
 */
$wgEnableAuthorProfileLinks = true;

/**
 * If set to true, images that contain certain the exif orientation tag will
 * be rotated accordingly. If set to null, try to auto-detect whether a scaler
 * is available that can rotate.
 * @var bool $wgEnableAutoRotation
 */
$wgEnableAutoRotation = null;

/**
 * Enable Blogs extension.
 * @see /extensions/wikia/Blogs/
 * @var bool $wgEnableBlogArticles
 */
$wgEnableBlogArticles = true;

/**
 * Enable CanonicalHref extension.
 * @see extensions/wikia/CanonicalHref
 * @var bool $wgEnableCanonicalHref
 */
$wgEnableCanonicalHref = true;

/**
 * Enable the Captcha extension.
 * @see /extensions/wikia/Captcha
 * @var bool $wgEnableCaptchaExt
 */
$wgEnableCaptchaExt = true;

/**
 * Enable CategoryBlueLinks extension.
 * @see extensions/wikia/CategoryBlueLinks
 * @var bool $wgEnableCategoryBlueLinks
 */
$wgEnableCategoryBlueLinks = true;

/**
 * Enable CategoryGalleries
 * @see extensions/wikia/CategoryGalleries
 * @var bool $wgEnableCategoryGalleriesExt
 */
$wgEnableCategoryGalleriesExt = true;

/**
 * Enables the CategoryIntersection API and Special:CategoryIntersection page
 * which serves as an interface to demonstrate the API call's functionality.
 * @see extensions/wikia/WikiaApi/WikiaApiQueryCategoryIntersection.php
 * @see extensions/wikia/SpecialCategoryIntersection
 * @var bool $wgEnableCategoryIntersectionExt
 */
$wgEnableCategoryIntersectionExt = false;

/**
 * Enable CategoryPage3 extension which replaces category pages with a SEO friendly version
 * @see extensions/wikia/CategoryPage3/
 * @var bool $wgEnableCategoryPage3Ext
 */
$wgEnableCategoryPage3Ext = true;

/**
 * Enable CategoryTree extension.
 * @see /extensions/CategoryTree/
 * @var bool wgEnableCategoryTreeExt
 */
$wgEnableCategoryTreeExt = true;

/**
 * Enable tag for a form to search Community Central Help.
 * @see /extensions/wikia/SharedHelp/CentralHelpSearch.php
 * @var bool $wgEnableCentralHelpSearchExt
 */
$wgEnableCentralHelpSearchExt = false;

/**
 * Enable CharInsert extension.
 * @see /extensions/CharInsert
 * @var bool wgEnableCharInsertExt
 */
$wgEnableCharInsertExt = true;

/**
 * Enables Special:Chat and associated functions.
 * @see extensions/wikia/Chat2
 * @var bool $wgEnableChat
 */
$wgEnableChat = false;

/**
 * Enable CheckUser extension.
 * @see /extensions/CheckUser
 * @var bool wgEnableCheckUserExt
 */
$wgEnableCheckUserExt = true;

/**
 * Enable Cite extension.
 * @see /extensions/Cite
 * @var bool wgEnableCiteExt
 */
$wgEnableCiteExt = true;

/**
 * Enable CloseMyAccount extension.
 * @see extensions/wikia/CloseMyAccount
 * @see extensions/wikia/SpecialContact2
 * @see extensions/wikia/EditAccount
 * @var bool $wgEnableCloseMyAccountExt
 */
$wgEnableCloseMyAccountExt = true;

/**
 * Enable the CommentCSV extension.
 * @see extensions/wikia/CommentCSV
 * @var bool $wgEnableCommentCSVExt
 */
$wgEnableCommentCSVExt = true;

/**
 * Enable community data in curated main pages on mercury sitewide (SUS-1198).
 * @see extensions/wikia/MercuryApi/models/MercuryApi.class.php
 * @var bool $wgEnableCommunityData
 */
$wgEnableCommunityData = true;

/**
 * Enable CommunityMessages extension.
 * @see extensions/wikia/CommunityMessages
 * @var bool $wgEnableCommunityMessagesExt
 */
$wgEnableCommunityMessagesExt = true;

/**
 * Enable CommunityPage extension.
 * @see extensions/wikia/CommunityPage
 * @var bool $wgEnableCommunityPageExt
 */
$wgEnableCommunityPageExt = false;

/**
 * Enable community ActivityFeed widget.
 * @see extensions/wikia/WidgetFramework/Widgets/WidgetCommunity
 * @var bool $wgEnableCommunityWidget
 */
$wgEnableCommunityWidget = true;

/**
 * Enable Contact extension.
 * @see /extensions/wikia/SpecialContact2
 * @var bool $wgEnableContactExt
 */
$wgEnableContactExt = true;

/**
 * Enable. Content Review extension. Requires $wgUseSiteJs be true.
 * @see extensions/wikia/ContentReview
 * @see $wgUseSiteJs
 * @var bool $wgEnableContentReviewExt
 */
$wgEnableContentReviewExt = true;

/**
 * Enables Content Review Special Page
 * @see extensions/wikia/ContentReview
 * @see Special:ContentReview
 * @var bool $wgEnableContentReviewSpecialPage
 */
$wgEnableContentReviewSpecialPage = false;

/**
 * Enable ContentWarning extension.
 * @see extensions/wikia/ContentWarning
 * @var bool $wgEnableContentWarningExt
 */
$wgEnableContentWarningExt = false;

/**
 * Enable special parser handling for templates.
 * @see includes/wikia/parser/templatetypes/TemplateTypesParser.class.php
 * @var bool $wgEnableContextLinkTemplateParsing
 */
$wgEnableContextLinkTemplateParsing = true;

/**
 * Enables COPPA tool. Disabled globally, enabled on Community Central in
 * WikiFactory.
 * @see extensions/wikia/CoppaTool
 * @var bool $wgEnableCoppaToolExt
 */
$wgEnableCoppaToolExt = false;

/**
 * Enable a widget for page creation.
 * @see extensions/CreateBox/CreateBox.php
 * @var bool wgEnableCreateBoxExt
 */
$wgEnableCreateBoxExt = true;

/**
 * Enable CreateNewWiki extension. It's disabled globally and only enabled in
 * WikiFactory.
 * @see extensions/wikia/CreateNewWiki
 * @var bool $wgEnableCreateNewWiki
 */
$wgEnableCreateNewWiki = false;

/**
 * Enable CuratedContent extension.
 * @see extensions/wikia/CuratedContent
 * @var bool $wgEnableCuratedContentExt
 */
$wgEnableCuratedContentExt = true;

/**
 * Enable 404 page for missing articles suggesting the closest matching article.
 * @see extensions/wikia/Custom404Page
 * @var bool $wgEnableCustom404PageExt
 */
$wgEnableCustom404PageExt = null;

/**
 * Content languages with Custom404Page.
 * @see $wgEnableCustom404PageExt
 * @see extensions/wikia/Custom404Page
 * @var Array $wgEnableCustom404PageExtInLanguages
 */
$wgEnableCustom404PageExtInLanguages = [ 'en' ];

/**
 * Enable Embeddable Discussions extension.
 * @see extensions/wikia/EmbeddableDiscussions
 * @var bool $wgEnableDiscussions
 */
$wgEnableDiscussions = false;

/**
 * Enable image upload in Discussions front-end.
 * @see extensions/wikia/MercuryApi
 * @var bool $wgEnableDiscussionsImageUpload
 */
$wgEnableDiscussionsImageUpload = true;

/**
 * Enable Special:DiscussionsLog.
 * @see extensions/wikia/SpecialDiscussionsLog
 * @var bool $wgEnableDiscussionsLog
 */
$wgEnableDiscussionsLog = true;

/**
 * Replace Forum links in navigation with links to Discussions.
 * @see includes/wikia/Extensions.php
 * @var bool $wgEnableDiscussionsNavigation
 */
$wgEnableDiscussionsNavigation = false;

/**
 * Enable DismissableSiteNotice extension.
 * @see /extensions/DismissableSiteNotice
 * @var bool wgEnableDismissableSiteNoticeExt
 */
$wgEnableDismissableSiteNoticeExt = true;

/**
 * Enable DMCARequest extension.
 * @see extensions/wikia/DMCARequest
 * @var bool $wgEnableDMCARequestExt
 */
$wgEnableDMCARequestExt = false;

/**
 * Whether to use DNS blacklists in $wgDnsBlacklistUrls to check for open
 * proxies.
 * @since 1.16
 * @var bool $wgEnableDnsBlacklist
 */
$wgEnableDnsBlacklist = false;

/**
 * Show information about XML database dumps on Special:Statistics.
 * @see /extensions/wikia/WikiFactory/Dumps/DumpsOnDemand.php
 * @var bool $wgEnableDumpsOnDemandExt
 */
$wgEnableDumpsOnDemandExt = true;

/**
 * Enable EditAccount extension. Disabled globally, enabled on Community Central
 * via WikiFactory.
 * @see /extensions/wikia/EditAccount/
 * @var bool $wgEnableEditAccount
 */
$wgEnableEditAccount = false;

/**
 * Enable Editcount extension.
 * @see /extensions/wikia/Editcount
 * @var bool $wgEnableEditcountExt
 */
$wgEnableEditcountExt = true;

/**
 * Enable Editor Preference extension.
 * @see extensions/wikia/EditorPreference
 * @var bool $wgEnableEditorPreference
 */
$wgEnableEditorPreferenceExt = true;

/**
 * Enable WikitextEditorHighlighting extension
 * @see extensions/wikia/EditorSyntaxHighlighting
 * @see extensions/wikia/EditPageLayout/EditPageLayoutHelper.class.php
 * @var bool $wgEnableEditorSyntaxHighlighting
 */
$wgEnableEditorSyntaxHighlighting = true;

/**
 * Enable EditPage Layout.
 * @see extensions/wikia/EditPageLayout
 * @var bool $wgEnableEditPageLayoutExt
 */
$wgEnableEditPageLayoutExt = true;

/**
 * Set to true to enable the e-mail basic features: password reminders, etc. If
 * sending e-mail on your server doesn't work, you might want to disable this.
 * @var bool $wgEnableEmail
 */
$wgEnableEmail = true;

/**
 * Enable FANDOM email delivery extension.
 * @see extensions/wikia/Email
 * @var bool
 */
$wgEnableEmailExt = true;

/**
 * Enable FandomApp SmartBanner.
 * @see extensions/wikia/MercuryApi
 * @var bool $wgEnableFandomAppSmartBanner
 */
$wgEnableFandomAppSmartBanner = false;

/**
 * custom copy for FandomApp smart banner on mobile
 */
$wgFandomAppSmartBannerText = null;

/**
 * Used to map IntentX API endpoints to prod wiki id
 */
$wgFandomShopMap = [
	'3510' => 'Assassin\'s Creed',
	'532' => 'Avatar',
	'613320' => 'Danganronpa',
	'208733' => 'Dark Souls',
	'599420' => 'Don\'t Starve',
	'3035' => 'Fallout',
	'1241752' => 'Fate/Grand Order',
	'525179	' => 'Haikyuu!!',
	'509' => 'Harry Potter',
	'2233' => 'Marvel',
	'113' => 'Star Trek',
	'2125819' => 'Muppets',
	'1242' => 'Nintendo',
	'1081' => 'One Piece',
	'74' => 'Pokemon',
	'30404' => 'Red Dead',
	'1249' => 'Resident Evil',
	'4396' => 'Roblox',
	'147' => 'Star Wars',
	'621556' => 'Steven Universe',
	'1006948' => 'Doctor Who',
	'2569' => 'Thomas the Tank Engine',
	'13346' => 'The Walking Dead',
];

/**
 * configures smart banner to display custom text/link/image and target it by country an OS
 * example value:
 * {
 *  "os": [
 *      "ios",
 *      "android"
 *  ],
 *  "imageUrl": "https:\/\/vignette.wikia.nocookie.net\/rybatest\/images\/7\/71\/002-send-1.svg\/revision\/latest?cb=20180711085702",
 *  "title": "some short title",
 *  "text": "some body text",
 *  "linkText": "some link",
 *  "linkUrl": "some.url.com",
 *  "countries": [
 *      "pl",
 *      "us",
 *      "au"
 *  ]
 * }
 */
$wgSmartBannerAdConfiguration = [];

/**
 * Surprisingly, this variable enables FANDOM stories on search result page!
 * @see /extensions/wikia/Search/WikiaSearchController.class.php
 * @var bool $wgEnableFandomStoriesOnSearchResultPage
 */
$wgEnableFandomStoriesOnSearchResultPage = true;

/**
 * Whether to use Memcached for LinkCache.
 * @see LinkCache
 * @var bool $wgEnableFastLinkCache
 */
$wgEnableFastLinkCache = true;

/**
 * Enable the FeedsAndPosts extension
 * @see extensions/wikia/FeedsAndPosts
 * @var bool $wgEnableFeedsAndPostsExt
 */
$wgEnableFeedsAndPostsExt = true;

/**
 * Enable the Embedded Feeds module from Community Feeds
 * @see extensions/wikia/FeedsAndPosts
 * @var bool $wgEnableEmbeddedFeeds
 */
$wgEnableEmbeddedFeeds = false;

/**
 * Enable FileInfoFunctions extension.
 * @see extensions/wikia/ImageSizeInfoFunctions
 * @var bool $wgEnableFileInfoFunctionsExt
 */
$wgEnableFileInfoFunctionsExt = false;

/**
 * Enables FinishCreateWiki part of CreateNewWiki extension, which is needed
 * for every wiki.
 * @see extensions/wikia/CreateNewWiki/FinishCreateWiki_setup.php
 * @var bool $wgEnableFinishCreateWiki
 */
$wgEnableFinishCreateWiki = true;

/**
 * Enable FirstContributions extension.
 * @see extensions/wikia/FirstContributions
 * @var bool $wgEnableFirstContributionsExt
 */
$wgEnableFirstContributionsExt = true;

/**
 * Enable special flagging of closed accounts.
 * @see /extensions/wikia/EditAccount/
 * @var bool $wgEnableFlagClosedAccountsExt
 */
$wgEnableFlagClosedAccountsExt = true;

/**
 * Enable Forum extension.
 * @see extensions/wikia/Forum
 * @var bool $wgEnableForumExt
 */
$wgEnableForumExt = false;

/**
 * @var  $wgArchiveWikiForums
 */
$wgArchiveWikiForums = null;

/**
 * Hide all forum forms (make forum read-only)
 * @var bool $wgHideForumForms
 */
$wgHideForumForms = false;

/**
 * Disallow anonymous editing of Forum:Index.
 * @see extensions/wikia/ForumIndexProtector
 * @var bool $wgEnableForumIndexProtector
 */
$wgEnableForumIndexProtectorExt = true;

/**
 * Enables FounderProgressBar extension.
 * @see extensions/wikia/FounderProgressBar
 * @var bool $wgEnableFounderProgressBarExt
 */
$wgEnableFounderProgressBarExt = false;

/**
 * Enable Gadgets extension.
 * @see /extensions/Gadgets
 * @var bool $wgEnableGadgetsExt
 */
$wgEnableGadgetsExt = false;

/**
 * Enable GameGuides mobile app extension.
 * @see extensions/wikia/GameGuides
 * @var bool $wgEnableGameGuidesExt
 */
$wgEnableGameGuidesExt = true;

/**
 * Enable GlobalCSSJS extension.
 * @see /extensions/wikia/GlobalCSSJS
 * @var bool wgEnableGlobalCSSJSExt
 */
$wgEnableGlobalCSSJSExt = true;

/**
 * Enable GlobalShortcuts extension.
 * @see extensions/wikia/GlobalShortcuts
 * @var bool $wgEnableGlobalShortcutsExt
 */
$wgEnableGlobalShortcutsExt = true;

/**
 * Enable GlobalWatchlist extension.
 * @see /extensions/wikia/GlobalWatchlist
 * @var bool $wgEnableGlobalWatchlistExt
 */
$wgEnableGlobalWatchlistExt = true;

/**
 * Enable GoogleAmp extension.
 * @see extensions/wikia/GoogleAmp
 * @var bool $wgEnableGoogleAmp
 */
$wgEnableGoogleAmp = false;

/**
 * Enable GoogleDocs extension.
 * @see /extensions/wikia/GoogleDocs
 * @var bool $wgEnableGoogleDocsExt
 */
$wgEnableGoogleDocsExt = true;

/**
 * Enable Google Form parser tag.
 * @see extensions/wikia/GoogleFormTag
 * @var bool $wgEnableGoogleFormTagExt
 */
$wgEnableGoogleFormTagExt = true;

/**
 * Enables Google Tag Manager by default
 * @see /extensions/wikia/GoogleTagManager
 * @var bool $wgEnableGoogleTagManagerExt
 */
$wgEnableGoogleTagManagerExt = true;

/**
 * Enable Gracenote extension for Lyrics. Defaults to false, toggled in
 * WikiFactory.
 * @see extensions/3rdparty/LyricWiki/Gracenote
 * @var bool $wgEnableGracenoteExt
 */
$wgEnableGracenoteExt = false;

/**
 * Enable Highly (sic!) Automated Welcome extension.
 * @see extensions/wikia/HAWelcome/
 * @var bool $wgEnableHAWelcomeExt
 */
$wgEnableHAWelcomeExt = true;

/**
 * Enable HideTags extension.
 * @see extensions/wikia/HideTags/HideTags.php
 * @var bool $wgEnableHideTagsExt
 */
$wgEnableHideTagsExt = true;

/**
 * Enable ImageLazyLoad extension.
 * @see extensions/wikia/ImageLazyLoad
 * @var bool s$wgEnableImageLazyLoadExt
 */
$wgEnableImageLazyLoadExt = true;

/**
 * Enable ImageMap extension.
 * @see /extensions/ImageMap
 * @var bool wgEnableImageMapExt
 */
$wgEnableImageMapExt = true;

/**
 * Enable ImagePlaceholder extension.
 * @see /extensions/wikia/ImagePlaceholder
 * @var bool $wgEnableImagePlaceholderExt
 */
$wgEnableImagePlaceholderExt = true;

/**
 * Enable ImageReview extension. Disabled globally, enabled on Community Central
 * in WikiFactory.
 * @see extensions/wikia/ImageReview
 * @var bool $wgEnableImageReviewExt
 */
$wgEnableImageReviewExt = false;

/**
 * If $wgAllowExternalImages is false, you can allow an on-wiki whitelist of
 * regular expression fragments to match the image URL against. If the image
 * matches one of the regular expression fragments, the image will be displayed.
 * Set this to true to enable the on-wiki whitelist (MediaWiki:External image
 * whitelist) or false to disable it.
 * @var bool $wgEnableImageWhitelist
 */
$wgEnableImageWhitelist = true;

/**
 * Enable special parser handling for templates.
 * @see includes/wikia/parser/templatetypes/TemplateTypesParser.class.php
 * @var bool $wgEnableInfoIconTemplateParsing
 */
$wgEnableInfoIconTemplateParsing = true;

/**
 * Enable InputBox extension.
 * @see /extensions/InputBox
 * @var bool $wgEnableInputBoxExt
 */
$wgEnableInputBoxExt = true;

/**
 * Redirect Special:Insights to a help page when not enabled.
 * @see extensions/wikia/InsightsBlogpostRedirect
 * @var bool $wgEnableInsightsBlogpostRedirectExt
 */
$wgEnableInsightsBlogpostRedirectExt = true;

/**
 * Enables Insights extension.
 * @see extensions/wikia/InsightsV2
 * @see extensions/wikia/InsightsBlogpostRedirect
 * @var bool $wgEnableInsightsExt
 */
$wgEnableInsightsExt = true;

/**
 * Enable non-portable infoboxes category on Special:Insights.
 * @see extensions/wikia/InsightsV2
 * @see extensions/wikia/TemplateDraft
 * @var bool $wgEnableInsightsInfoboxes
 */
$wgEnableInsightsInfoboxes = true;

/**
 * Enable InsightsPagesWithoutInfobox extension.
 * @see extensions/wikia/InsightsV2
 * @var bool $wgEnableInsightsPagesWithoutInfobox
 */
$wgEnableInsightsPagesWithoutInfobox = true;

/**
 * Enables Popular pages Insights subpage.
 * @see extensions/wikia/InsightsV2
 * @var bool $wgEnableInsightsPopularPages
 */
$wgEnableInsightsPopularPages = true;

/**
 * Enable InsightsTemplatesWithoutType extension.
 * @see extensions/wikia/InsightsV2
 * @var bool $wgEnableInsightsTemplatesWithoutType
 */
$wgEnableInsightsTemplatesWithoutType = true;

/**
 * Enable InterwikiDispatcher extension.
 * @see /extensions/wikia/InterwikiDispatcher
 * @var bool $wgEnableInterwikiDispatcherExt
 */
$wgEnableInterwikiDispatcherExt = true;

/**
 * Allow running of javascript test suites via [[Special:JavaScriptTest]] (such
 * as QUnit).
 * @var bool $wgEnableJavaScriptTest
 */
$wgEnableJavaScriptTest = false;

/**
 * Enable JSVariables extension.
 * @see /extensions/wikia/JSVariables
 * @var bool $wgEnableJSVariablesExt
 */
$wgEnableJSVariablesExt = true;

/**
 * Enable Lightbox extension.
 * @var bool $wgEnableLightboxExt
 * @see extensions/wikia/Lightbox
 */
$wgEnableLightboxExt = true;

/**
 * Allow submitting posts of specific types.
 * @see extensions/wikia/MercuryApi/models/MercuryApi.class.php
 * @global bool $wgEnableLightweightContributions
 */
$wgEnableLightweightContributions = false;

/**
 * Enable LinkSuggest extension.
 * @see /extensions/wikia/LinkSuggest
 * @var bool $wgEnableLinkSuggestExt
 */
$wgEnableLinkSuggestExt = true;

/**
 * Enable LinkToMobileApp extension (displays a link while browsing with
 * Android).
 * @see extensions/wikia/LinkToMobileApp
 * @var bool $wgEnableLinkToMobileAppExt
 */
$wgEnableLinkToMobileAppExt = false;

/**
 * When enabled, ResourceLoader will output links without the server part.
 * @see app/includes/resourceloader
 * @var bool $wgEnableLocalResourceLoaderLinks
 */
$wgEnableLocalResourceLoaderLinks = true;

/**
 * Enable /wiki/Local_Sitemap with a tweaked version of Special:AllPages.
 * @see extensions/wikia/LocalSitemapPage
 * @var bool $wgEnableLocalSitemapPageExt
 */
$wgEnableLocalSitemapPageExt = true;

/**
 * Enable LookupContribs and LookupUser extensions.
 * @see /extensions/wikia/LookupContribs/
 * @see /extensions/wikia/LookupUser/
 * @var bool $wgEnableLookupContribsExt
 */
$wgEnableLookupContribsExt = false;

/**
 * Enable custom lyric tag for Lyrics. Defaults to false. Toggled in
 * WikiFactory.
 * @see extensions/3rdparty/LyricWiki/Tag_Lyric.php
 * @var bool $wgEnableLyricsTagExt
 *
 */
$wgEnableLyricsTagExt = false;

/**
 * Enable lyrics.wikia.com-specific code. Defaults to false; toggled in
 * WikiFactory.
 * @see extensions/3rdparty/LyricWiki
 * @var bool $wgEnableLyricWikiExt
 */
$wgEnableLyricWikiExt = false;

/**
 * Send MainPageData (e.g. CuratedContent data) via MercuryAPI calls.
 * @see extensions/wikia/MercuryApi/handlers/MercuryApiMainPageHandler.class.php
 * @var bool $wgEnableMainPageDataMercuryApi
 */
$wgEnableMainPageDataMercuryApi = true;

/**
 * Enable MainPageTag extension.
 * @see /extensions/wikia/MainPageTag
 * @var bool $wgEnableMainPageTag
 */
$wgEnableMainPageTag = true;

/**
 * Enable Mercury article HTML cleanup.
 * @see includes/wikia/parser/templatetypes/handlers/ArticleHTMLCleanup.class.php
 * @var bool $wgEnableMercuryHtmlCleanup
 */
$wgEnableMercuryHtmlCleanup = true;

/**
 * Redirect Special:Piggyback to Mercury's Piggyback.
 * @var bool $wgEnableMercuryPiggyback
 * @see Piggyback::execute()
 */
$wgEnableMercuryPiggyback = true;

/**
 * Enable MiniEditor in ArticleComments.
 * @see extensions/wikia/ArticleComments
 * @see extensions/wikia/MiniEditor
 * @see $wgEnableMiniEditorExt
 * @var bool $wgEnableMiniEditorExtForArticleComments
 */
$wgEnableMiniEditorExtForArticleComments = true;

/**
 * Enable MiniEditor in Forum.
 * @see extensions/wikia/MiniEditor
 * @see $wgEnableMiniEditorExt
 * @var bool $wgEnableMiniEditorExtForForum
 */
$wgEnableMiniEditorExtForForum = false;

/**
 * Enable MiniEditor in Wall.
 * @see extensions/wikia/MiniEditor
 * @see $wgEnableMiniEditorExt
 * @var bool $wgEnableMiniEditorExtForWall
 */
$wgEnableMiniEditorExtForWall = true;

/**
 * Enable MobileContent extension.
 * @see extensions/wikia/MobileContent
 * @var bool $wgEnableMobileContentExt
 */
$wgEnableMobileContentExt = false;

/**
 * Enable MultiDelete extension.
 * @see /extensions/wikia/MultiTasks/
 * @var bool $wgEnableMultiDeleteExt
 */
$wgEnableMultiDeleteExt = true;

/**
 * Enable MultiUpload extension.
 * @see /extensions/MultiUpload/
 * @var bool $wgEnableMultiUploadExt
 */
$wgEnableMultiUploadExt = true;

/**
 * Enable MultiWikiEdit extension.
 * @see /extensions/wikia/MultiTasks
 * @var bool $wgEnableMultiWikiEditExt
 *
 */
$wgEnableMultiWikiEditExt = true;

/**
 * Enable suggestions while typing in search boxes (results are passed around in
 * OpenSearch format) Requires $wgEnableOpenSearchSuggest = true; We keep this
 * enabled to support Monobook.
 * @see $wgEnableOpenSearchSuggest
 * @var bool $wgEnableMWSuggest
 **/
$wgEnableMWSuggest = false;

/**
 * Enable MyHome extension. Although the basic code of the extension is always
 * included, no matter what value this variable has.
 * @see extensions/wikia/MyHome/
 * @var bool $wgEnableMyHomeExt
 */
$wgEnableMyHomeExt = true;

/**
 * Enable special parser handling for navbox templates.
 * @see includes/wikia/parser/templatetypes/TemplateTypesParser.class.php
 * @var bool $wgEnableNavboxTemplateParsing
 */
$wgEnableNavboxTemplateParsing = false;

/**
 * Enable special parser handling for navigation templates.
 * @see includes/wikia/parser/templatetypes/TemplateTypesParser.class.php
 * @var bool $wgEnableNavigationTemplateParsing
 */
$wgEnableNavigationTemplateParsing = true;

/**
 * Enable Contribution Page Benefits dialog.
 * @see extensions/wikia/CommunityPage/CommunityPageSpecialHooks.class.php
 * @var bool $wgEnableNCFDialog
 */
$wgEnableNCFDialog = false;

/**
 * Enable Mercury based login and registration flow.
 * @see extensions/wikia/MercuryApi
 * @var bool $wgEnableNewAuth
 */
$wgEnableNewAuth = true;

/**
 * Enable popup-based authentication.
 * @see includes/User.php
 * @see includes/wikia/Extensions.php
 * @var bool $wgEnableNewAuthModal
 */
$wgEnableNewAuthModal = true;

/**
 * Enable user search in Special:Newpages. This is really a temporary hack
 * around an index install bug on some Wikipedias. Kill it once fixed.
 * @var bool $wgEnableNewpagesUserFilter
 */
$wgEnableNewpagesUserFilter = true;

/**
 * Use newer VE instead of the old one.
 * @see includes/OutputPage.php
 * @var bool $wgEnableNewVisualEditorExt
 */
$wgEnableNewVisualEditorExt = true;

/**
 * Enable "Not a valid Wikia" page.
 * @see extensions/wikia/NotAValidWikia
 * @see http://community.wikia.com/wiki/Community_Central:Not_a_valid_Wikia
 * @see $wgNotAValidWikia
 * @var bool extensions/wikia/NotAValidWikia
 */
$wgEnableNotAValidWikiaExt = false;

/**
 * Enable special parser handling for notice templates.
 * @see includes/wikia/parser/templatetypes/TemplateTypesParser.class.php
 * @var bool $wgEnableNoticeTemplateParsing
 */
$wgEnableNoticeTemplateParsing = true;

/**
 * Enables Special:Nuke.
 * @see extensions/Nuke
 * @var bool $wgEnableNukeExt
 */
$wgEnableNukeExt = true;

/**
 * Enable OggHandler extension.
 * @see extensions/OggHandler
 * @var bool $wgEnableOggHandlerExt
 */
$wgEnableOggHandlerExt = true;

/**
 * Enable OpenGraphMeta extensions for Facebook sharing.
 * @see /extensions/OpenGraphMeta
 * @see /extensions/wikia/OpenGraphMetaCustomizations
 * @var bool wgEnableOpenGraphMetaExt
 */
$wgEnableOpenGraphMetaExt = true;

/**
 * Enable OpenSearch suggestions requested by MediaWiki. Set this to false if
 * you've disabled MWSuggest or another suggestion script and want reduce load
 * caused by cached scripts pulling suggestions.
 * @see $wgEnableMWSuggest
 * @var bool $wgEnableOpenSearchSuggest
 */
$wgEnableOpenSearchSuggest = true;

/**
 * Enable Paginator extension.
 * @see extensions/wikia/Paginator
 * @var bool $wgEnablePaginatorExt
 */
$wgEnablePaginatorExt = true;

/**
 * Keep parsed pages in a cache (objectcache table or memcached) to speed up
 * output of the same page viewed by another user with the same options. This
 * can provide a significant speedup for medium to large pages, so you probably
 * want to keep it on. Extensions that conflict with the parser cache should
 * disable the cache on a per-page basis instead.
 * @var bool $wgEnableParserCache
 */
$wgEnableParserCache = true;

/**
 * Enable ParserFunctions extension.
 * @see /extensions/ParserFunctions
 * @var bool wgEnableParserFunctionsExt
 */
$wgEnableParserFunctionsExt = true;

/**
 * Enable Partner Feeds.
 * @see extensions/wikia/PartnerFeed
 * @var bool $wgEnablePartnerFeedExt
 */
$wgEnablePartnerFeedExt = true;

/**
 * Enable per-skin wikitext parser cache.
 * @see extensions/wikia/PerSkinParserCache
 * @var bool $wgEnablePerSkinParserCacheExt
 */
$wgEnablePerSkinParserCacheExt = true;

/**
 * Enable Phalanx extension.
 * @see extensions/wikia/Phalanx
 * @var bool wgEnablePhalanxExt
 */
$wgEnablePhalanxExt = true;

/**
 * Enable Special:Piggyback extension.
 * @see extensions/wikia/Piggyback
 * @see $wgEnablePiggybackExt
 * @var bool $wgEnablePiggybackExt
 */
$wgEnablePiggybackExt = true;

/**
 * Enable the Places extension.
 * @see extensions/wikia/Places
 * @var bool $wgEnablePlacesExt
 */
$wgEnablePlacesExt = false;

/**
 * Enable PlaybuzzTag extension.
 * @see extensions/wikia/PlaybuzzTag
 * @var bool $wgEnablePlaybuzzTagExt
 */
$wgEnablePlaybuzzTagExt = true;

/**
 * Enable Polldaddy parser tag.
 * @see extensions/wikia/PolldaddyTag
 * @var bool $wgEnablePolldaddyTagExt
 */
$wgEnablePolldaddyTagExt = true;

/**
 * Enable PoolCounter extension.
 * @see extensions/PoolCounter
 * @var bool $wgEnablePoolCounter
 */
$wgEnablePoolCounter = true;

/**
 * Enable query page to fetch data about popular pages.
 * @see extensions/wikia/InsightsV2
 * @var bool $wgEnablePopularPagesQueryPage
 */
$wgEnablePopularPagesQueryPage = true;

/**
 * Enable PortabilityDashboard extension.
 * @see extensions/wikia/PortabilityDashboard
 * @var bool $wgEnablePortabilityDashboardExt
 */
$wgEnablePortabilityDashboardExt = false;

/**
 * Enable PortableInfoboxBuilder extension.
 * @see extensions/wikia/TemplateClassification
 * @see extensions/wikia/PortableInfoboxBuilder
 * @var bool $wgEnablePortableInfoboxBuilderExt
 */
$wgEnablePortableInfoboxBuilderExt = true;

/**
 * Display PortableInfobox builder in Visual Editor.
 * @see extensions/wikia/PortableInfoboxBuilder
 * @var bool $wgEnablePortableInfoboxBuilderInVE
 */
$wgEnablePortableInfoboxBuilderInVE = true;

/**
 * Enable Europa InfoBox theme.
 * @see extensions/wikia/PortableInfobox
 * @see extensions/wikia/ThemeDesigner/ThemeDesignerController.class.php
 * @var bool $wgEnablePortableInfoboxEuropaTheme
 */
$wgEnablePortableInfoboxEuropaTheme = false;

/**
 * Enable PortableInfobox extension.
 * @see extensions/wikia/PortableInfobox
 * @see extensions/wikia/TemplateDraft
 * @var bool $wgEnablePortableInfoboxExt
 */
$wgEnablePortableInfoboxExt = true;

/**
 * Use smtp driver in WikiaMailer (and Postfix MTA as backend).
 * @see includes/wikia/WikiaMailer.php
 * @see extensions/wikia/SpecialEmailTest/SpecialEmailTest.php
 * @var bool $wgEnablePostfixEmail
 */
$wgEnablePostfixEmail = true;

/**
 * Enable Qualaroo extension.
 * @see extensions/wikia/Qualaroo
 * @var bool $wgEnableQualarooExt
 */
$wgEnableQualarooExt = true;

/**
 * Enable special parser handling for templates.
 * @see includes/wikia/parser/templatetypes/TemplateTypesParser.class.php
 * @var bool $wgEnableQuoteTemplateParsing
 */
$wgEnableQuoteTemplateParsing = true;

/**
 * Enable RandomImage extension.
 * @see /extensions/RandomImage
 * @var bool wgEnableRandomImageExt
 */
$wgEnableRandomImageExt = true;

/**
 * Enable RandomInCategory extension.
 * @var bool wgEnableRandomInCategoryExt
 * @see extensions/RandomInCategory
 */
$wgEnableRandomInCategoryExt = true;

/**
 * Enable RandomSelection extension.
 * @see /extensions/3rdparty/RandomSelection
 * @var bool $wgEnableRandomSelectionExt
 */
$wgEnableRandomSelectionExt = true;

/**
 * Enable RecentChanges extension.
 * @see extensions/wikia/RecentChanges
 * @var bool $wgEnableRecentChangesExt
 */
$wgEnableRecentChangesExt = true;

/**
 * Enable discussions recirculation.
 * @see extensions/wikia/Forum/ForumHooksHelper.class.php
 * @var bool $wgEnableRecirculationDiscussions
 */
$wgEnableRecirculationDiscussions = false;

/**
 * Enables Recirculation extension.
 * @see extensions/wikia/Recirculation
 * @var bool $wgEnableRecirculationExt
 */
$wgEnableRecirculationExt = true;

/**
 * Enable special parser handling for template references.
 * @see includes/wikia/parser/templatetypes/TemplateTypesParser.class.php
 * @var bool $wgEnableReferencesTemplateParsing
 */
$wgEnableReferencesTemplateParsing = true;

/**
 * Enable Related Pages extension and Oasis module.
 * @see extensions/wikia/RelatedPages
 * @var bool $wgEnableRelatedPagesExt
 */
$wgEnableRelatedPagesExt = true;

/**
 * Enable HTML emails.
 * @see User::sendMail() and User::sendConfirmationMail().
 * @var bool $wgEnableRichEmails
 */
$wgEnableRichEmails = true;

/**
 * Enable extension that generates robots.txt.
 * @see extensions/wikia/RobotsTxt
 * @var bool $wgEnableRobotsTxtExt
 */
$wgEnableRobotsTxtExt = true;

/**
 * Enable RSS extension.
 * @see /extensions/3rdparty/RSS/
 * @see /extensions/wikia/WikiaRS
 * @var bool wgEnableRssExt
 */
$wgEnableRssExt = true;

/**
 * Enable Rich Text Editor.
 * @see extensions/wikia/RTE
 * @var bool $wgEnableRTEExt
 */
$wgEnableRTEExt = true;

/**
 * Enable interwiki transcluding.  Only when iw_trans=1.
 * @var bool $wgEnableScaryTranscluding
 */
$wgEnableScaryTranscluding = true;

/**
 * Enable Scribunto (Lua templating) extension
 * @see extensions/Scribunto
 * @see extensions/SemanticScribunto
 * @var bool $wgEnableScribuntoExt
 */
$wgEnableScribuntoExt = true;

/**
 * Enable special parser handling for scrollbox templates.
 * @see includes/wikia/parser/templatetypes/TemplateTypesParser.class.php
 * @var bool $wgEnableScrollboxTemplateParsing
 */
$wgEnableScrollboxTemplateParsing = true;

/**
 * If true, searches for IP addresses will be redirected to that IP's
 * contributions page. E.g. searching for "1.2.3.4" will redirect to
 * [[Special:Contributions/1.2.3.4]]
 * @var bool $wgEnableSearchContributorsByIP
 */
$wgEnableSearchContributorsByIP = true;

/**
 * Enable SearchNearMatch extension.
 * @see /extensions/wikia/SearchNearMatch
 * @var bool $wgEnableSearchNearMatchExt
 */
$wgEnableSearchNearMatchExt = true;

/**
 * Allows running of selenium tests via maintenance/tests/RunSeleniumTests.php.
 * Used for core MediaWiki tests.
 * @var bool $wgEnableSelenium
 */
$wgEnableSelenium = false;

/**
 * Enable Semantic MediaWiki extension.
 * @see extensions/SemanticMediaWiki
 * @see extensions/SemanticForms
 * @see extensions/SemanticDrilldown
 * @see extensions/SemanticGallery
 * @see extensions/SemanticResultFormat
 * @see extensions/SemanticScribunto
 * @var bool $wgEnableSemanticMediaWikiExt
 */
$wgEnableSemanticMediaWikiExt = false;

/**
 * Enable SemanticScribunto extension.
 * @see extensions/SemanticScribunto
 * @var bool $wgEnableSemanticScribuntoExt
 */
$wgEnableSemanticScribuntoExt = false;

/**
 * Listen for postbacks (about bounces, unsubscribes, etc.) from SendGrid.
 * @see includes/wikia/api/SendGridPostBackApiController.class.php
 * @var bool $wgEnableSendGridPostback
 */
$wgEnableSendGridPostback = true;

/**
 * Enable SEO Link Hreflang extension.
 * @see extensions/wikia/SeoLinkHreflang
 * @var bool $wgEnableSeoLinkHreflangExt
 */
$wgEnableSeoLinkHreflangExt = true;

/**
 * If on, the sidebar navigation links are cached for users with the current
 * language set. This can save a touch of load on a busy site by shaving off
 * extra message lookups. However it is also fragile: changing the site
 * configuration, or having a variable $wgArticlePath, can produce broken links
 * that don't update as expected.
 * @var bool $wgEnableSidebarCache
 */
$wgEnableSidebarCache = false;

/**
 * Enable SitemapPage extension (global HTML sitemap listing all wikis).
 * @see extensions/wikia/SitemapPage
 * @var bool $wgEnableSitemapPageExt
 */
$wgEnableSitemapPageExt = false;

/**
 * Enable improved XML sitemaps at /wiki/Special:SitemapXml.
 * @see extensions/wikia/SitemapXml
 * @var bool $wgEnableSitemapXmlExt
 */
$wgEnableSitemapXmlExt = true;

/**
 * Enable SiteWideMessages.
 * @see /extensions/wikia/SiteWideMessages
 * @var bool $wgEnableSiteWideMessages
 */
$wgEnableSiteWideMessages = true;

/**
 * @deprecated since 1.17 Use $wgEnableDnsBlacklist instead, only kept for
 * backward compatibility.
 * @see User
 * @var bool $wgEnableSorbs
 */
$wgEnableSorbs = false;

/**
 * Enable SoundCloud parser tag.
 * @see extensions/wikia/SoundCloudTag
 * @var bool $wgEnableSoundCloudTagExt
 */
$wgEnableSoundCloudTagExt = true;

/**
 * Enable SpamBlacklist extension.
 * @see /extensions/SpamBlacklist
 * @var bool wgEnableSpamBlacklistExt
 */
$wgEnableSpamBlacklistExt = false;

/**
 * Enable Special:CSS.
 * @see extensions/wikia/SpecialCss
 * @var bool $wgEnableSpecialCssExt
 */
$wgEnableSpecialCssExt = true;

/**
 * Enable Special:Discussions.
 * @see extensions/wikia/Discussions
 * @see extensions/wikia/SpecialDiscussionsLog
 * @var $wgEnableSpecialDiscussions
 */
$wgEnableSpecialDiscussions = true;

/**
 * Enable Special:Phalanx (disabled globally, enabled via WikiFactory).
 * @see extensions/wikia/PhalanxII/PhalanxSpecial_setup.php
 * @var bool wgEnableSpecialPhalanxExt
 */
$wgEnableSpecialPhalanxExt = false;

/**
 * Enable Special:Unsubscribe.
 * @see extensions/wikia/SpecialUnsubscribe
 * @var bool $wgEnableSpecialUnsubscribeExt
 */
$wgEnableSpecialUnsubscribeExt = true;

/**
 * Enable SpecialVideos extension.
 * @see extensions/wikia/SpecialVideos
 * @see extensions/wikia/VideoEmbedTool
 * @var $wgEnableSpecialVideosExt
 */
$wgEnableSpecialVideosExt = true;

/**
 *
 * Enable Special:Withoutimages.
 * @see extensions/wikia/SpecialWihtoutimages/
 * @var bool wgEnableSpecialWithoutimagesExt
 */
$wgEnableSpecialWithoutimagesExt = true;

/**
 * Enables Spotify parser tag
 * @see extensions/wikia/SpotifyTag
 * @var bool $wgEnableSpotifyTagExt
 */
$wgEnableSpotifyTagExt = true;

/**
 * Enable StaffLog extension.
 * @see extensions/wikia/StaffLog
 * @var bool $wgEnableStaffLogExt
 */
$wgEnableStaffLogExt = true;

/**
 * Enable Special:StaffLog special page in StaffLog extension.
 * @see extensions/wikia/StaffLog
 * @var bool $wgEnableStaffLogSpecialPage
 */
$wgEnableStaffLogSpecialPage = false;

/**
 * Enable StaffPowers extension.
 * @see extensions/wikia/StaffPowers\
 * @var bool $wgEnableStaffPowersExt
 */
$wgEnableStaffPowersExt = true;

/**
 * Enables JavaScript (client-side) parsing and coloring for JS and CSS pages.
 * @see http://www.mediawiki.org/wiki/Extension:SyntaxHighlight_GeSHi
 * @see extensions/SyntaxHighlight_GeSHi
 * @var bool $wgEnableSyntaxHighlightGeSHiExt
 */
$wgEnableSyntaxHighlightGeSHiExt = true;

/**
 * Enable Tabber extension.
 * @see extensions/3rdparty/tabber
 * @see extensions/wikia/RTE/RTE.class.php
 * @var bool wgEnableTabberExt
 */
$wgEnableTabberExt = true;

/**
 * Enable TabView extension.
 * @see /extensions/wikia/TabView
 * @var bool $wgEnableTabViewExt
 */
$wgEnableTabViewExt = true;

/**
 * Enable special page displaying articles with special tags.
 * @see /extensions/wikia/TagsReport
 * @var bool $wgEnableTagsReport
 */
$wgEnableTagsReport = true;

/**
 * Enable TemplateClassification extension.
 * @see extensions/wikia/InsightsV2
 * @see extensions/wikia/TemplateClassification
 * @var bool $wgEnableTemplateClassificationExt
 */
$wgEnableTemplateClassificationExt = true;

/**
 * Enable TemplateDraft extension.
 * @see extensions/wikia/TemplateDraft
 * @see extensions/wikia/TemplateClassification
 * @see extensions/wikia/EditPageLayout
 * @var bool $wgEnableTemplateDraftExt
 */
$wgEnableTemplateDraftExt = true;

/**
 * Enable special parser handling of templates classified by Template
 * Classification Service. False prevents the application from making any calls
 * to Template Classification Service during article parsing.
 * @see includes/wikia/parser/templatetypes/TemplateTypesParser.class.php
 * @var bool $wgEnableTemplateTypesParsing
 */
$wgEnableTemplateTypesParsing = true;

/**
 * Enable TitleBlacklist extension.
 * @see extensions/TitleBlacklist
 * @var bool wgEnableTitleBlacklistExt
 */
$wgEnableTitleBlacklistExt = true;

/**
 * Enable page/event tracking.
 * @see extensions/wikia/Track
 * @var bool $wgEnableTracking
 */
$wgEnableTracking = true;

/**
 * Enable an extension that renders a button to manage tracking preferences on privacy policy pages
 * @var bool $wgEnableTrackingSettingsManager
 */
$wgEnableTrackingSettingsManager = false;

/**
 * Enable TwitterCards extension.
 * @see extensions/wikia/TwitterCards
 * @var bool $wgEnableTwitterCardsExt
 */
$wgEnableTwitterCardsExt = true;

/**
 * Enable Twitter parser tag.
 * @see extensions/wikia/TwitterTag
 * @var bool $wgEnableTwitterTagExt
 */
$wgEnableTwitterTagExt = true;

/**
 * Whether to enable uploads. Uploads have to be specially set up to be secure.
 * @var bool $wgEnableUploads
 */
$wgEnableUploads = true;

/**
 * Enable UserActivity extension.
 * @see extensions/wikia/UserActivity
 * @var bool $wgEnableUserActivityExt
 */
$wgEnableUserActivityExt = false;

/**
 * Set to true to enable user-to-user e-mail. This can potentially be abused, as
 * it's hard to track.
 * @var bool $wgEnableUserEmail
 */
$wgEnableUserEmail = false;

/**
 * Enables the second version of Special:Preferences.
 * @see extensions/wikia/UserPreferencesV2
 * @var bool $wgEnableUserPreferencesV2Ext
 */
$wgEnableUserPreferencesV2Ext = true;

/**
 * Enable UserRenameTool extension.
 * @see extensions/wikia/UserRenameTool
 * @see extensions/wikia/SpecialContact2
 * @var bool $wgEnableUserRenameToolExt
 */
$wgEnableUserRenameToolExt = true;

/**
 * Enable Verbatim extension.
 * @see /extensions/3rdparty/Verbatim
 * @var bool $wgEnableVerbatimExt
 */
$wgEnableVerbatimExt = false;

/**
 * Use redesigned video page.
 * @see extensions/wikia/FilePage/FilePageHooks.class.php
 * @var bool $wgEnableVideoPageRedesign
 */
$wgEnableVideoPageRedesign = true;

/**
 * Enable various features related to videos.
 * @see extensions/wikia/CreatePage/
 * @see extensions/wikia/EditPageLayout/
 * @see extensions/wikia/MiniEditor/
 * @see extensions/wikia/RTE/
 * @see extensions/wikia/VideoEmbedTool/
 * @var bool $wgEnableVideoToolExt
 */
$wgEnableVideoToolExt = true;

/**
 * Collect data about session and lifetime Wikia referrer.
 * @see extensions/wikia/VisitSource
 * @var bool $wgEnableVisitSourceExt
 */
$wgEnableVisitSourceExt = true;

/**
 * Enable Visual Editor.
 * @see extensions/VisualEditor
 * @see extensions/wikia/PortableInfoboxBuilder
 * @see extensions/wikia/EditorPreference
 * @var $wgEnableVisualEditorExt
 */
$wgEnableVisualEditorExt = true;

/**
 * Enable entry points to Visual Editor.
 * @see extensions/wikia/Parsoid
 * @see extensions/wikia/EditorPreference/EditorPreference.class.php
 * @var bool $wgEnableVisualEditorUI
 */
$wgEnableVisualEditorUI = false;

/**
 * Enable VK parser tag.
 * @see extensions/wikia/VKTag
 * @var bool $wgEnableVKTagExt
 */
$wgEnableVKTagExt = true;

/**
 * Enable Wall extension. Set by users in WikiFactory via Special:WikiFeatures.
 * @see $wgEnableWallEngine
 * @see extensions/wikia/Wall/
 * @var bool $wgEnableWallExt
 */
$wgEnableWallExt = false;

/**
 * Enable WDACReview (Wikis Directed at Children) tool. Disabled globally,
 * enabled on Community Central in WikiFactory.
 * @see extensions/wikia/WDACReview
 * @var bool $wgEnableWDACReviewExt
 */
$wgEnableWDACReviewExt = false;

/**
 * Enable Weibo parser tag.
 * @see extensions/wikia/WeiboTag
 * @var bool $wgEnableWeiboTagExt
 */
$wgEnableWeiboTagExt = true;

/**
 * Enables Special:WhereIsExtension. Disabled globally, enabled on Community
 * Central via WikiFactory.
 * @see /extensions/wikia/WhereIsExtension
 * @var bool $wgEnableWhereIsExtensionExt
 */
$wgEnableWhereIsExtensionExt = false;

/**
 * Enable Wikia Bar extension.
 * @see extensions/wikia/WikiaBar
 * @see skins/oasis/modules/FooterController.class.php
 * @var bool $wgEnableWikiaBarExt
 */
$wgEnableWikiaBarExt = true;

/**
 * Enable Follow extension (Watchlists improvements).
 * @see extensions/wikia/Follow
 * @var bool $wgEnableWikiaFollowedPages
 */
$wgEnableWikiaFollowedPages = true;

/**
 * Enable Follow extension (Watchlists improvements).
 * @see extensions/wikia/Follow
 * @var bool $wgEnableWikiaFollowedPagesOnlyPrefs
 */
$wgEnableWikiaFollowedPagesOnlyPrefs = true;

/**
 * Enable WikiaInYourLang extension (notify non-English users visiting English
 * wikis about communities in their native language).
 * @see extensions/wikia/WikiaInYourLang
 * @var bool $wgEnableWikiaInYourLangExt
 */
$wgEnableWikiaInYourLangExt = true;

/**
 * Enable WikiaIrcGateway extension.
 * @see extensions/wikia/WikiaIrcGateway
 * @var bool $wgEnableWikiaIrcGatewayExt
 */
$wgEnableWikiaIrcGatewayExt = true;

/**
 * Keep MediaWiki:Mainpage redirect up to date.
 * @see extensions/wikia/AutoMainpageFixer
 * @var bool $wgEnableWikiaMainpageFixer
 */
$wgEnableWikiaMainpageFixer = true;

/**
 * Enable WikiaMiniUpload extension.
 * @see /extensions/wikia/WikiaMiniUpload
 * @var bool $wgEnableWikiaMiniUploadExt
 */
$wgEnableWikiaMiniUploadExt = true;

/**
 * Enable Smart Banner.
 * @see skins/oasis/modules/OasisController.class.php
 * @see extensions/wikia/MercuryApi/MercuryApiController.class.php
 * @see extensions/wikia/WikiaMobile/WikiaMobileService.class.php
 * @var bool $wgEnableWikiaMobileSmartBanner
 */
$wgEnableWikiaMobileSmartBanner = null;

/**
 * Configuration for a smart banner.
 * @see skins/oasis/modules/OasisController.class.php
 * @see extensions/wikia/MercuryApi/MercuryApiController.class.php
 * @see extensions/wikia/WikiaMobile/WikiaMobileService.class.php
 * @example
 *  [
 *              'disabled' => 0,
 *              'name' => 'Warframe'
 *              'icon' => 'url/to/icon' // this can be full url or relative to extensions folder
 *              'meta' => [
 *                      'apple-itunes-app' => 'app-id=739263891',
 *                      'google-play-app' => 'app-id=com.wikia.singlewikia.warframe'
 *              ]
 * ]
 *
 * @var Array $wgWikiaMobileSmartBannerConfig
 */
$wgWikiaMobileSmartBannerConfig = [
	'name' => 'Game Guides',
	'icon' => 'https://static.wikia.nocookie.net/8af6c2f0-05aa-425c-a107-78c0551ca5e4',
	'meta' => [
		// The values below are public app IDs.
		'apple-itunes-app' => 'app-id=422467074',
		'google-play-app' => 'app-id=com.wikia.app.GameGuides'
	]
];

/**
 * Configure RabbitMQ publisher for wiki status change events.
 * @see extensions/wikia/WikiFactory/WikiStatusChangePublisher/WikiStatusChangeHooks
 * @var Array $wgWikiStatusChangePublisher
 */
$wgWikiStatusChangePublisher = [
	'exchange' => 'wiki-status-changed',
	'vhost' => 'events',
];

/**
 * Enable WikiaPhotoGallery extension.
 * @see extensions/wikia/WikiaPhotoGallery
 * @var bool $wgEnableWikiaPhotoGalleryExt
 */
$wgEnableWikiaPhotoGalleryExt = true;

/**
 * Enable Special:Version extension.
 * @see extensions/wikia/SpecialVersion
 * @var bool $wgEnableWikiaSpecialVersionExt
 */
$wgEnableWikiaSpecialVersionExt = true;

/**
 * Enable WikiaWhiteList extension.
 * @see /extensions/wikia/WikiaWhiteList
 * @var bool wgEnableWikiaWhiteListExt
 */
$wgEnableWikiaWhiteListExt = true;

/**
 * Enable Wiki Features extension.
 * @see extensions/wikia/WikiFeatures
 * @var bool $wgEnableWikiFeatures
 */
$wgEnableWikiFeatures = true;

/**
 * Enable wiki hieroglyphs extension.
 * @see /extensions/wikihiero
 * @var bool wgEnableWikiHieroExt
 */
$wgEnableWikiHieroExt = false;

/**
 * Enable WikisApiController
 * @see includes/wikia/api/WikisApiController.class.php
 * @var bool $wgEnableWikisApi
 */
$wgEnableWikisApi = false;

/**
 * Allow the API to be used to perform write operations (page edits, rollback,
 * etc.) when an authorised user accesses it.
 * @var bool $wgEnableWriteAPI
 */
$wgEnableWriteAPI = true;

/**
 * Allow users to enable email notification ("enotif") on Discussions changes.
 * @var bool $wgEnotifDiscussions
 */
$wgEnotifDiscussions = true;

/**
 * True: from page editor if s/he opted-in. False: Enotif mails appear to come
 * from $wgEmergencyContact
 * @see $wgEmergencyContact
 * @var bool $wgEnotifFromEditor
 */
$wgEnotifFromEditor = false;

/**
 * Send a generic mail instead of a personalised mail for each user.  This
 * always uses UTC as the time zone, and doesn't include the username. For pages
 * with many users watching, this can significantly reduce mail load. Has no
 * effect when using sendmail rather than SMTP.
 * @var bool $wgEnotifImpersonal
 */
$wgEnotifImpersonal = false;

/**
 * Maximum number of users to mail at once when using impersonal mail. Should
 * match the limit on your mail server.
 * @var int $wgEnotifMaxRecips
 */
$wgEnotifMaxRecips = 500;

/**
 * Send notification mails on minor edits to watchlist pages. This is enabled
 * by default. Does not affect user talk notifications.
 * @var bool $wgEnotifMinorEdits
 */
$wgEnotifMinorEdits = true;

/**
 * Set the Reply-to address in notifications to the editor's address, if user
 * allowed this in the preferences.
 * @var bool $wgEnotifRevealEditorAddress
 */
$wgEnotifRevealEditorAddress = false;

/**
 * Use real name instead of username in e-mail "from" field.
 * @var bool $wgEnotifUseRealName
 */
$wgEnotifUseRealName = false;

/**
 * Allow users to enable email notification ("enotif") when someone edits their
 * user talk page.
 * @var bool $wgEnotifUserTalk
 */
$wgEnotifUserTalk = true;

/**
 * Allow users to enable email notification ("enotif") on watchlist changes.
 * @var bool $wgEnotifWatchlist
 */
$wgEnotifWatchlist = true;

/**
 * Hooks that are used for outputting exceptions.
 *
 * Formats:
 *
 * $wgExceptionHooks[] = $funcname
 * $wgExceptionHooks[] = [ $class, $funcname ]
 *
 * Hooks should return strings or false
 * @var Array $wgExceptionHooks
 */
$wgExceptionHooks = [];

/**
 * An array of namespace keys in which the __INDEX__/__NOINDEX__ magic words
 * will not function, so users can't decide whether pages in that namespace are
 * indexed by search engines.  If set to null, default to $wgContentNamespaces.
 * Example:
 *   $wgExemptFromUserRobotsControl = array( NS_MAIN, NS_TALK, NS_PROJECT );
 * @var Array $wgExemptFromUserRobotsControl
 */
$wgExemptFromUserRobotsControl = null;

/**
 * Some tests and extensions use exiv2 to manipulate the EXIF metadata in some
 * image formats.
 * @var string $wgExiv2Command
 */
$wgExiv2Command = '/usr/bin/exiv2';

/**
 * Maximum number of calls per parse to expensive parser functions such as
 * PAGESINCATEGORY.
 * @var int $wgExpensiveParserFunctionLimit
 */
$wgExpensiveParserFunctionLimit = 100;

/**
 * Should we allow a broader set of characters in id attributes, per HTML5?  If
 * not, use only HTML 4-compatible IDs.  This option is for testing -- when the
 * functionality is ready, it will be on by default with no option. Currently
 * this appears to work fine in all browsers, but it's disabled by default
 * because it normalizes id's a bit too aggressively, breaking preexisting
 * content (particularly Cite).
 * @var bool $wgExperimentalHtmlIds
 */
$wgExperimentalHtmlIds = false;

/**
 * Whether to allow exporting the entire wiki into a single file.
 * @see Special:Export
 * @var bool $wgExportAllowAll
 */
$wgExportAllowAll = false;

/**
 * If set to false, disables the full-history option on Special:Export.
 * This is currently poorly optimized for long edit histories, so is
 * disabled on Wikimedia's sites.
 * @see Special:Export
 * @var bool $wgExportAllowHistory
 */
$wgExportAllowHistory = true;

/**
 * Return distinct author list (when not returning full history).
 * @see Special:Export
 * @var bool $wgExportAllowListContributors
 */
$wgExportAllowListContributors = false;

/**
 * Whether to allow the "export all pages in namespace" option.
 * @see Special:Export
 * @var bool $wgExportFromNamespaces
 */
$wgExportFromNamespaces = false;

/**
 * If set nonzero, Special:Export requests for history of pages with
 * more revisions than this will be rejected. On some big sites things
 * could get bogged down by very very long pages.
 * @see Special:Export
 * @var int $wgExportMaxHistory
 */
$wgExportMaxHistory = 0;

/**
 * If non-zero, Special:Export accepts a "pagelink-depth" parameter
 * up to this specified level, which will cause it to include all
 * pages linked to from the pages you specify. Since this number
 * can become *insanely large* and could easily break your wiki,
 * it's disabled by default for now.
 * @see Special:Export
 * @see Special:Import
 * @var int $wgExportMaxLinkDepth
 */
$wgExportMaxLinkDepth = 0;

/**
 * The URL path of the extensions directory.
 * Defaults to "{$wgScriptPath}/extensions".
 * @since 1.16
 * @var string|bool $wgExtensionAssetsPath
 */
$wgExtensionAssetsPath = false;

/**
 * An array of extension types and inside that their names, versions, authors,
 * urls, descriptions and pointers to localized description msgs. Note that
 * the version, url, description and descriptionmsg key can be omitted.
 *
 * <code>
 * $wgExtensionCredits[$type][] = array(
 *     'name' => 'Example extension',
 *     'version' => 1.9,
 *     'path' => __FILE__,
 *     'author' => 'Foo Barstein',
 *     'url' => 'http://wwww.example.com/Example%20Extension/',
 *     'description' => 'An example extension',
 *     'descriptionmsg' => 'exampleextension-desc',
 * );
 * </code>
 *
 * Where $type is 'specialpage', 'parserhook', 'variable', 'media' or 'other'.
 * Where 'descriptionmsg' can be an array with message key and parameters:
 * 'descriptionmsg' => array( 'exampleextension-desc', param1, param2, ... ),
 * @var Array $wgExtensionCredits
 */
$wgExtensionCredits = [];

/**
 * A list of callback functions which are called once MediaWiki is fully
 * initialised.
 * @see app/includes/Setup.php
 * @var Array $wgExtensionFunctions
 */
$wgExtensionFunctions = [];

/**
 * Extension messages files.
 *
 * Associative array mapping extension name to the filename where messages can
 * be found. The file should contain variable assignments. Any of the variables
 * present in languages/messages/MessagesEn.php may be defined, but $messages
 * is the most common.
 *
 * Variables defined in extensions will override conflicting variables defined
 * in the core.
 *
 * @example $wgExtensionMessagesFiles['Ext'] = __DIR__ .'/Ext.i18n.php';
 * @var Array $wgExtensionMessagesFiles
 *
 */
$wgExtensionMessagesFiles = [];

/**
 * Name of the external diff engine to use.
 * @var string $wgExternalDiffEngine
 */
$wgExternalDiffEngine = 'wikidiff2';

/**
 * Set a default target for external links, e.g. _blank to pop up a new window.
 * @var string|bool $wgExternalLinkTarget
 */
$wgExternalLinkTarget = false;

/**
 * An array of external mysql servers. Used by LBFactory_Simple, may be ignored
 * if $wgLBFactoryConf is set to another class.
 * @example $wgExternalServers = [ 'cluster1' => [ 'srv28', 'srv29' ] ];
 *
 */
$wgExternalServers = [];

/**
 * All wikis use shared database to fetch user and other shared data.
 * @var string $wgExternalSharedDB
 */
$wgExternalSharedDB = 'wikicities';

/**
 * External stores allow including content from non database sources following
 * URL links. Short names of ExternalStore classes may be specified in an array
 * here. CAUTION: Access to database might lead to code execution
 *
 * @example $wgExternalStores =  [ 'http','file','custom' ];
 * @var Array|bool $wgExternalStores
 */
$wgExternalStores =  [ 'DB' ];

/**
 * Store infobox info in a special Solr field.
 * @see extensions/wikia/Search/classes/IndexService/DefaultContent.php
 * @var bool $wgExtractInfoboxes
 */
$wgExtractInfoboxes = false;

/**
 * Additional namespaces. If the namespaces defined in Language.php and
 * Namespace.php are insufficient. Array for namespaces with gender distinction.
 * Note: the default form for the namespace should also be set
 * using $wgExtraNamespaces for the same index.
 * @since 1.18
 * @var Array $wgExtraGenderNamespaces
 */
$wgExtraGenderNamespaces = [];

/**
 * List of language names or overrides for default names in Names.php.
 * @see languages/Language.php
 * @see languages/Names.php
 * @var Array $wgExtraLanguageNames
 */
$wgExtraLanguageNames = [];

/**
 * Additional namespaces. If the namespaces defined in Language.php and
 * Namespace.php are insufficient, you can create new ones here, for example,
 * to import Help files in other languages. You can also override the namespace
 * names of existing namespaces. Extensions developers should use
 * $wgCanonicalNamespaceNames.
 *
 * PLEASE  NOTE: Once you delete a namespace, the pages in that namespace will
 * no longer be accessible. If you rename it, then you can access them through
 * the new namespace name.
 *
 * Custom namespaces should start at 100 to avoid conflicting with standard
 * namespaces, and should always follow the even/odd main/talk pattern.
 * $wgExtraNamespaces = [
 *     100 => "Hilfe",
 *     101 => "Hilfe_Diskussion",
 *     102 => "Aide",
 *     103 => "Discussion_Aide"
 * ];
 */
$wgExtraNamespaces = [
	110 => 'Forum',
	111 => 'Forum_talk',
];

/**
 * A subtitle to add to the tagline, for skins that have it.
 * @var string $wgExtraSubtitle
 */
$wgExtraSubtitle = '';

/**
 * Enable FandomCreator extension.
 * @see extensions/wikia/FandomCreator
 * @var bool $wgFandomCreatorCommunityId
 */
$wgFandomCreatorCommunityId = false;

/**
 * The URL path of the shortcut icon.
 * @var string|bool $wgFavicon
 */
$wgFavicon = '/favicon.ico';

/**
 * Label for features/promoted videos.
 * @see extensions/wikia/ArticleVideo/ArticleVideoContext.class.php
 * @var string $wgFeaturedVideoRecommendedVideosLabel
 */
$wgFeaturedVideoRecommendedVideosLabel = 'Promoted';

/**
 * Provide syndication feeds (RSS, Atom) for, e.g., Recentchanges, Newpages.
 * @var bool $wgFeed
 */
$wgFeed = true;

/**
 * _Minimum_ timeout for cached Recentchanges feed, in seconds. A cached version
 * will continue to be served out even if changes are made, until this many
 * seconds runs out since the last render. If set to 0, feed caching is
 * disabled. Use this for debugging only; feed generation can be pretty slow
 * with diffs.
 * @var int $wgFeedCacheTimeout
 */
$wgFeedCacheTimeout = 60; // 1 minute

/**
 * Available feeds objects. Should probably only be defined when a page is
 * syndicated ie when $wgOut->isSyndicated() is true.
 * @var Array $wgFeedClasses
 */
$wgFeedClasses = [
	'rss' => 'RSSFeed',
	'atom' => 'AtomFeed',
];

/**
 * When generating Recentchanges RSS/Atom feed, diffs will not be generated for
 * pages larger than this size.
 * @var int $wgFeedDiffCutoff
 */
$wgFeedDiffCutoff = 32768; // 32 KiB

/**
 * Set maximum number of results to return in syndication feeds (RSS, Atom) for
 * eg Recentchanges, Newpages.
 * @var int $wgFeedLimit
 */
$wgFeedLimit = 50;

/**
 * Fetch commons image description pages and display them on the local wiki?
 * @var bool $wgFetchCommonsDescriptions
 */
$wgFetchCommonsDescriptions = false;

/**
 * File backend structure configuration. This is an array of file backend
 * configuration arrays. Each backend configuration has the following
 * parameters:
 *     'name'        : A unique name for the backend
 *     'class'       : The file backend class to use
 *     'wikiId'      : A unique string that identifies the wiki (container prefix)
 *     'lockManager' : The name of a lock manager (see $wgLockManagers)
 * Additional parameters are specific to the class used.
 * @var Array $wgFileBackends
 */
$wgFileBackends = [];

/**
 * Files with these extensions will never be allowed as uploads.
 * @var Array $wgFileBlacklist
 */
$wgFileBlacklist = [
	# HTML may contain cookie-stealing JavaScript and web bugs
	'html', 'htm', 'js', 'jsb', 'mhtml', 'mht', 'xhtml', 'xht',
	# PHP scripts may execute arbitrary code on the server
	'php', 'phtml', 'php3', 'php4', 'php5', 'phps',
	# Other types that may be interpreted by some servers
	'shtml', 'jhtml', 'pl', 'py', 'cgi',
	# May contain harmful executables for Windows victims
	'exe', 'scr', 'dll', 'msi', 'vbs', 'bat', 'com', 'pif', 'cmd', 'vxd', 'cpl'
];

/**
 * Depth of the subdirectory hierarchy to be created under
 * $wgFileCacheDirectory.  The subdirectories will be named based on the MD5
 * hash of the title.  A value of 0 means all cache files will be put directly
 * into the main file cache directory.
 * @see $wgFileCacheDirectory
 * @var int $wgFileCacheDepth
 */
$wgFileCacheDepth = 2;

/**
 * Directory where the cached page will be saved. Will default to
 * "{$wgUploadDirectory}/cache" in Setup.php.
 * @var string|bool $wgFileCacheDirectory
 */
$wgFileCacheDirectory = false;

/**
 * This is the list of preferred extensions for uploading files. Uploading files
 * with extensions not in this list will trigger a warning. WARNING: If you add
 * any OpenOffice or Microsoft Office file formats here, such as odt or doc, and
 * untrusted users are allowed to upload files, then your wiki will be
 * vulnerable to cross-site request forgery (CSRF).
 * @var Array $wgFileExtensions
 */
$wgFileExtensions = [ 'png', 'gif', 'jpg', 'jpeg', 'ico', 'pdf', 'svg', 'odt',
	'ods', 'odp', 'odg', 'odc', 'odf', 'odi', 'odm' ];

/**
 * Metadata fields not shown on file pages.
 * @see includes/ImagePage.php
 * @var Array $wgFilePageFilterMetaFields
 */
$wgFilePageFilterMetaFields = [
	'altvideoid' => 1,
	'categoryid' => 1,
	'jpegbitratecode' => 1,
	'marketplaceid' => 1,
	'sourceid' => 1,
	'stdbitratecode' => 1,
	'streamurl' => 1,
	'thumbnail' => 1,
	'uniquename' => 1,
	'videoid' => 1,
	'videourl' => 1,
];

/**
 * @deprecated since 1.17 use $wgDeletedDirectory
 * @see $wgDeletedDirectory
 * @var Array $wgFileStore
 */
$wgFileStore = [];

/**
 * Similarly you can get a function to do the job. The function will be given
 * the following args:
 *   - a Title object for the article the edit is made on
 *   - the text submitted in the textarea (wpTextbox1)
 *   - the section number.
 * The return should be boolean indicating whether the edit matched some evilness:
 *  - true : block it
 *  - false : let it through
 *
 * @deprecated since 1.17 Use hooks. See SpamBlacklist extension.
 * @var bool|string|Closure $wgFilterCallback
 */
$wgFilterCallback = false;

/**
 * Show/hide links on Special:Log will be shown for these log types. This is
 * associative array of log type => boolean "hide by default".
 *
 * For example:
 *   $wgFilterLogTypes => array(
 *      'move' => true,
 *      'import' => false,
 *   );
 *
 * Will display show/hide links for the move and import logs. Move logs will be
 * hidden by default unless the link is clicked. Import logs will be shown by
 * default, and hidden when the link is clicked.
 *
 * A message of the form log-show-hide-<type> should be added, and will be used
 * for the link text.
 *
 * @see $wgLogTypes for a list of available log types.
 * @var Array $wgFilterLogTypes
 */
$wgFilterLogTypes = [
	'patrol' => true
];

/**
 * Set this to true to replace Arabic presentation forms with their standard
 * forms in the U+0600-U+06FF block. This only works if $wgLanguageCode is
 * set to "ar". Note that pages with titles containing presentation forms will
 * become inaccessible, run maintenance/cleanupTitles.php to fix this.
 */
$wgFixArabicUnicode = true;

/**
 * Set this to true to replace ZWJ-based chillu sequences in Malayalam text
 * with their Unicode 5.1 equivalents. This only works if $wgLanguageCode is
 * set to "ml". Note that some clients (even new clients as of 2010) do not
 * support these characters. If you enable this on an existing wiki, run
 * maintenance/cleanupTitles.php to fix any ZWJ sequences in existing page
 * titles.
 * @var bool $wgFixMalayalamUnicode
 */
$wgFixMalayalamUnicode = true;

/**
 * Abstract list of footer icons for skins in place of old copyrightico and poweredbyico code
 * You can add new icons to the built in copyright or poweredby, or you can create
 * a new block. Though note that you may need to add some custom css to get good styling
 * of new blocks in monobook. vector and modern should work without any special css.
 *
 * $wgFooterIcons itself is a key/value array.
 * The key is the name of a block that the icons will be wrapped in. The final id varies
 * by skin; Monobook and Vector will turn poweredby into f-poweredbyico while Modern
 * turns it into mw_poweredby.
 * The value is either key/value array of icons or a string.
 * In the key/value array the key may or may not be used by the skin but it can
 * be used to find the icon and unset it or change the icon if needed.
 * This is useful for disabling icons that are set by extensions.
 * The value should be either a string or an array. If it is a string it will be output
 * directly as html, however some skins may choose to ignore it. An array is the preferred format
 * for the icon, the following keys are used:
 *   src: An absolute url to the image to use for the icon, this is recommended
 *        but not required, however some skins will ignore icons without an image
 *   url: The url to use in the <a> arround the text or icon, if not set an <a> will not be outputted
 *   alt: This is the text form of the icon, it will be displayed without an image in
 *        skins like Modern or if src is not set, and will otherwise be used as
 *        the alt="" for the image. This key is required.
 *   width and height: If the icon specified by src is not of the standard size
 *                     you can specify the size of image to use with these keys.
 *                     Otherwise they will default to the standard 88x31.
 * @var Array $wgFooterIcons
 */
$wgFooterIcons = [
	'copyright' => [
		'copyright' => [], // placeholder for the built in copyright icon
	],
	'poweredby' => [
		'mediawiki' => [
			'src' => null, // Defaults to "$wgStylePath/common/images/poweredby_mediawiki_88x31.png"
			'url' => '//www.mediawiki.org/',
			'alt' => 'Powered by MediaWiki',
		]
	],
];

/**
 * Default maximum age for raw CSS/JS accesses.
 * @var int $wgForcedRawSMaxage
 */
$wgForcedRawSMaxage = 300;

/**
 * When translating messages with wfMsg(), it is not always clear what should
 * be considered UI messages and what should be content messages. For example,
 * for the English Wikipedia, there should be only one 'mainpage', so when
 * getting the link for 'mainpage', we should treat it as site content and call
 * wfMsgForContent(), but for rendering the text of the link, we call wfMsg().
 * The code behaves this way by default. However, sites like the Wikimedia
 * Commons do offer different versions of 'mainpage' and the like for different
 * languages. This array provides a way to override the default behavior. For
 * example, to allow language-specific main page and community portal, set:
 * @example $wgForceUIMsgAsContentMsg = array( 'mainpage', 'portal-url' );
 * @var Array $wgForceUIMsgAsContentMsg
 */
$wgForceUIMsgAsContentMsg = [];

/**
 * File repository structures. Each repository structure is an associative
 * array of properties configuring the repository. Repositories listed here will
 * be searched after the local file repository.
 * @see $wgLocalFileRepo
 * @var Array $wgForeignFileRepos
 */
$wgForeignFileRepos = [];

/**
 * Default parameters for the <gallery> tag.
 * @var Array $wgGalleryOptions
 */
$wgGalleryOptions = [
	// Default number of images per-row in the gallery. 0: adapt to screensize.
	'imagesPerRow' => 0,
	// Width of the cells containing images in galleries (in pixels).
	'imageWidth' => 120,
	// Height of the cells containing images in galleries (in pixels).
	'imageHeight' => 120,
	// Length of caption to truncate (in characters).
	'captionLength' => 25,
	// Show the filesize in bytes in categories.
	'showBytes' => true,
];

/**
 * Grant admins access to GameGuides content management tool.
 * @see lib/Wikia/src/Service/User/Permissions/data/PermissionsDefinesAfterWikiFactory.php
 * @var bool $wgGameGuidesContentForAdmins
 */
$wgGameGuidesContentForAdmins = true;

/**
 * Global user preferences (options) filter.
 * @see lib/Wikia/src/Factory/PreferencesFactory.php
 * @var Array $wgGlobalUserPreferenceWhiteList
 */
$wgGlobalUserPreferenceWhiteList = [
	'literals' => [
		'category-page-layout',
		'CategoryExhibitionSortType',
		'ccmeonemails',
		'cols',
		'contextchars',
		'createpagedefaultblank',
		'createpagepopupdisabled',
		'date',
		'diffonly',
		'disablecategoryselect',
		'disablefeaturedvideo',
		'disablelinksuggest',
		'disablemail',
		'disablesuggest',
		'disablesyntaxhighlighting',
		'disablewysiwyg',
		'editfont',
		'editondblclick',
		'editor',
		'editsection',
		'editsectiononrightclick',
		'editwidth',
		'enableGoSearch',
		'enableuserjs',
		'enableWatchlistFeed',
		'EnableWysiwyg',
		'enotifdiscussionsfollows',
		'enotifdiscussionsvotes',
		'enotiffollowedpages',
		'enotifminoredits',
		'enotifrevealaddr',
		'enotifusertalkpages',
		'enotifwallthread',
		'enotifwatchlistpages',
		'enotifyme',
		'extendwatchlist',
		'externaldiff',
		'externaleditor',
		'forceeditsummary',
		'hideEditsWikis',
		'hidefollowedpages',
		'hidefromattribution',
		'hideminor',
		'hidepatrolled',
		'hidepersonalachievements',
		'highlightbroken',
		'htmlemails',
		'https-opt-in',
		'imageReviewSort',
		'imagesize',
		'justify',
		'language',
		'marketingallowed',
		'math',
		'memory-limit',
		'minordefault',
		'myhomedefaultview',
		'myTools',
		'newpageshidepatrolled',
		'nocache',
		'noconvertlink',
		'norollbackdiff',
		'NotConfirmedLogin',
		'numberheadings',
		'oasis-toolbar-promotions',
		'previewonfirst',
		'previewontop',
		'quickbar',
		'rcdays',
		'RCFilters',
		'rclimit',
		'rememberpassword',
		'riched_disable',
		'riched_start_disabled',
		'riched_toggle_remember_state',
		'riched_use_popup',
		'riched_use_toggle',
		'rows',
		'searchAllNamespaces',
		'searcheverything',
		'searchlimit',
		'show_task_comments',
		'showAds',
		'showhiddencats',
		'showjumplinks',
		'shownumberswatching',
		'showtoc',
		'showtoolbar',
		'skin',
		'skinoverwrite',
		'smw-prefs-ask-options-collapsed-default',
		'smw-prefs-ask-options-tooltip-display',
		'stubthreshold',
		'thumbsize',
		'timecorrection',
		'underline',
		'unsubscribed',
		'upwiz_deflicense',
		'uselivepreview',
		'usenewrc',
		'userlandingpage',
		'variant',
		'viewmode',
		'visualeditor-betatempdisable',
		'visualeditor-enable',
		'walldelete',
		'wallshowsource',
		'watchcreations',
		'watchdefault',
		'watchdeletion',
		'watchlistdays',
		'watchlistdigest',
		'watchlistdigestclear',
		'watchlisthideanons',
		'watchlisthidebots',
		'watchlisthideliu',
		'watchlisthideminor',
		'watchlisthideown',
		'watchlisthidepatrolled',
		'watchmoves',
		'watchsubpages',
		'widget_bookmark_pages',
		'widgets',
		'WikiaBarDisplayState',
		'wllimit'
	],
	'regexes' => [
		'([a-z]+)-toolbar-contents$',
		'^forum_sort_.*',
		'^gadget-.*',
		'^searchNs.*$',
		'^wall_sort_.*',
	]
];

/**
 * We might want to remove it along with the piece of code in
 * Block::isWhitelistedFromAutoblocks() which is specific to FANDOM and very
 * old.
 * @see Block::isWhitelistedFromAutoblocks()
 * @var Array $wgGlobalWhitelistedFromAutoblocks
 */
$wgGlobalWhitelistedFromAutoblocks = [
		'38.127.199.5',  //chat-s2
		'38.127.199.4'   //chat-s1
];
// CONFIG_REVISION: make sure, it's still needed

/**
 * URL template for Google Amp version of an article.
 * @see extensions/wikia/GoogleAmp
 * @var sprint $wgGoogleAmpAddress
 */
$wgGoogleAmpAddress = 'http://{WIKI}.wikia.com/amp/{WIKI}/{ARTICLE}';

/**
 * Titles (with namespace prefix if needed) for which Google Amp is disabled.
 * @see extensions/wikia/GoogleAmp
 * @var Array $wgGoogleAmpArticleBlacklist
 */
$wgGoogleAmpArticleBlacklist = [];

/**
 * Namespace for which GoogleAmp is enabled.
 * @see extensions/wikia/GoogleAmp
 * @var Array $wgGoogleAmpNamespaces
 */
$wgGoogleAmpNamespaces = [];


/**
 * Configure RabbitMQ publisher for wiki status change events.
 * @see maintenance/wikia/migrateImagesToGcs.php
 * @var array $wgWikiStatusChangePublisher
 */
$wgGoogleCloudUploaderPublisher = [
	'exchange' => 'google-cloud-uploader.mediawiki-events',
	'vhost' => 'dc-file-sync',
];


/**
 * Go button goes straight to the edit screen if the article doesn't exist.
 * @var bool $wgGoToEdit
 */
$wgGoToEdit = false;

/**
 * Some languages need different word forms, usually for different cases.
 * Used in Language::convertGrammar().
 * @example $wgGrammarForms['en']['genitive']['car'] = 'car\'s';
 * @var Array $wgGrammarForms
 */
$wgGrammarForms = [];

/**
 * If set, 'screen' and 'handheld' media specifiers for stylesheets are
 * transformed such that they apply to the iPhone/iPod Touch Mobile Safari,
 * which doesn't recognize 'handheld' but does support media queries on its
 * screen size. Consider only using this if you have a *really good* handheld
 * stylesheet, as iPhone users won't have any way to disable it and use the
 * "grown-up" styles instead.
 * @var bool $wgHandheldForIPhone
 */
$wgHandheldForIPhone = false;

/**
 * Optionally, we can specify a stylesheet to use for media="handheld".
 * This is recognized by some, but not all, handheld/mobile/PDA browsers.
 * If left empty, compliant handheld browsers won't pick up the skin
 * stylesheet, which is specified for 'screen' media. Can be a complete URL,
 * base-relative path, or $wgStylePath-relative path. Will also be switched in
 * when 'handheld=yes' is added to the URL, like the 'printable=yes' mode for
 * print media.
 * @var string|bool $wgHandheldStyle
 */
$wgHandheldStyle = false;

/**
 * Set the following to false especially if you have a set of files that need to
 * be accessible by all wikis, and you do not want to use the hash (path/a/aa/)
 * directory layout.
 * @var bool $wgHashedSharedUploadDirectory
 */
$wgHashedSharedUploadDirectory = true;

/**
 * Set this to false if you do not want MediaWiki to divide your images
 * directory into many subdirectories, for improved performance. It's almost
 * always good to leave this enabled. In previous versions of MediaWiki, some
 * users set this to false to allow images to be added to the wiki by simply
 * copying them into $wgUploadDirectory and then running
 * maintenance/rebuildImages.php to register them in the database. This is no
 * longer recommended, use maintenance/importImages.php instead. Note that this
 * variable may be ignored if $wgLocalFileRepo is set.
 * @var bool $wgHashedUploadDirectory
 */
$wgHashedUploadDirectory = true;

/**
 * An array of preferences to not show for the user.
 * @var Array $wgHiddenPrefs
 */
$wgHiddenPrefs = [];

/**
 * Hide interlanguage links from the sidebar.
 * @var bool $wgHideInterlanguageLinks
 */
$wgHideInterlanguageLinks = false;

/**
 * The build directory for HipHop compilation, yo.
 * Defaults to $IP/maintenance/hiphop/build, bro.
 * @var string|bool $wgHipHopBuildDirectory
 */
$wgHipHopBuildDirectory = false;

/**
 * The HipHop build type. Can be either "Debug" or "Release".
 * Or "Gangsta", yo, to break da stuff.
 * @var string $wgHipHopBuildType
 */
$wgHipHopBuildType = 'Debug';

/**
 * Number of parallel processes to use during HipHop compilation, yo.
 * Or "detect" to guess from system properties, bro.
 * @var int|string $wgHipHopCompilerProcs
 */
$wgHipHopCompilerProcs = 'detect';

/**
 * wgHitcounterUpdateFreq sets how often page counters should be updated, higher
 * values are easier on the database. A value of 1 causes the counters to be
 * updated on every hit, any higher value n cause them to update *on average*
 * every n hits. Should be set to either 1 or something largish, eg 1000, for
 * maximum efficiency.
 * @var int $wgHitcounterUpdateFreq
 */
$wgHitcounterUpdateFreq = 1000;

/**
 * HTCP multicast address. Set this to a multicast IP address to enable HTCP.
 * Note that MediaWiki uses the old non-RFC compliant HTCP format, which was
 * present in the earliest Squid implementations of the protocol.
 * @see SquidUpdate
 * @see sockets.php
 * @var string|bool $wgHTCPMulticastAddress
 */
$wgHTCPMulticastAddress = false;

/**
 * HTCP multicast TTL.
 * @see $wgHTCPMulticastAddress
 * @see SquidUpdate
 * @see sockets.php
 * @var int $wgHTCPMulticastTTL
 */
$wgHTCPMulticastTTL = 1;

/**
 * HTCP multicast port.
 * @see $wgHTCPMulticastAddress
 * @see SquidUpdate
 * @see sockets.php
 * @var int $wgHTCPPort
 */
$wgHTCPPort = 4827;

/**
 * Should we output an HTML5 doctype?  If false, use XHTML 1.0 Transitional
 * instead, and disable HTML5 features.  This may eventually be removed and set
 * to always true.  If it's true, a number of other settings will be irrelevant
 * and have no effect.
 * @var bool $wgHtml5
 */
$wgHtml5 = true;

/**
 * Defines the value of the version attribute in the &lt;html&gt; tag, if any.
 * This is ignored if $wgHtml5 is false.  If $wgAllowRdfaAttributes and
 * $wgHtml5 are both true, and this evaluates to boolean false (like if it's
 * left at the default null value), it will be auto-initialized to the correct
 * value for RDFa+HTML5.  As such, you should have no reason to ever actually
 * set this to anything.
 * @see $wgHtml5
 * @see $wgAllowRdfaAttributes
 * @var string $wgHtml5Version
 */
$wgHtml5Version = null;

/**
 * If set, inline scaled images will still produce <img> tags ready for output
 * instead of showing an error message. This may be useful if errors are
 * transitory, especially if the site is configured to automatically render
 * thumbnails on request. On the other hand, it may obscure error conditions
 * from debugging. Enable the debug log or the 'thumbnail' log group to make
 * sure errors are logged to a file for review.
 * @var bool $wgIgnoreImageErrors
 */
$wgIgnoreImageErrors = false;

/**
 * These are additional characters that should be replaced with '-' in file
 * names.
 * @var string $wgIllegalFileChars
 */
$wgIllegalFileChars = ':';

/**
 * Limit images on image description pages to a user-selectable limit. In order
 * to reduce disk usage, limits can only be selected from a list. The user
 * preference is saved as an array offset in the database, by default the offset
 * is set with $wgDefaultUserOptions['imagesize']. Make sure you change it if
 * you alter the array (see bug 8858). This is the list of settings the user can
 * choose from.
 * @var Array $wgImageLimits
 */
$wgImageLimits = [
	[ 320, 240 ],
	[ 640, 480 ],
	[ 800, 600 ],
	[ 1024, 768 ],
	[ 1280, 1024 ],
	[ 10000, 10000 ]
];

/**
 * The convert command shipped with ImageMagick.
 * @var string $wgImageMagickConvertCommand
 */
$wgImageMagickConvertCommand = '/usr/bin/convert';

/**
 * RabbitMQ configuration for ImageReview.
 * @see extensions/wikia/ImageReview/ImageReviewEventsHooks.class.php
 * @var array $wgImageReview
 */
$wgImageReview = [
	'vhost' => 'dc-file-sync',
	'exchange' => 'amq.topic',
];

/**
 * An image can be used as a thumbnail of an article if it is used less than
 * this many times.
 * @see extensions/wikia/ImageServing/drivers/ImageServingDriverMainNS.class.php
 * @var int $wgImageServingMaxReuseCount
 */
$wgImageServingMaxReuseCount = 10;

/**
 * The number of Vignette hosts (used in URLs).
 * @deprecated
 * @see VignetteRequest::isVignetteUrl()
 * @see $wgLegacyVignetteUrl
 * @var int $wgImagesServers
 */
$wgImagesServers = 5;

/**
 * Set this to true if you use img_auth and want the user to see details on why
 * access failed.
 * @var bool $wgImgAuthDetails
 */
$wgImgAuthDetails = false;

/**
 * If this is enabled, img_auth.php will not allow image access unless the wiki
 * is private. This improves security when image uploads are hosted on a
 * separate domain.
 * @var bool $wgImgAuthPublicTest
 */
$wgImgAuthPublicTest = true;

/**
 * List of interwiki prefixes for wikis we'll accept as sources for
 * Special:Import (for sysops). Since complete page history can be imported,
 * these should be 'trusted'.
 *
 * If a user has the 'import' permission but not the 'importupload' permission,
 * they will only be able to run imports through this transwiki interface.
 *
 * @see Special:Import
 * @var Array $wgImportSources
 */
$wgImportSources = [];

/**
 * Optional default target namespace for interwiki imports.
 * Can use this to create an incoming "transwiki"-style queue.
 * Set to numeric key, not the name.
 *
 * Users may override this in the Special:Import dialog.
 * @see Special:Import
 * @var int $wgImportTargetNamespace
 */
$wgImportTargetNamespace = null;

/**
 * Whether to include the mediawiki.legacy JS library (old wikibits.js), and its
 * dependencies.
 * @var bool $wgIncludeLegacyJavaScript
 */
$wgIncludeLegacyJavaScript = true;


/**
 * RabbitMQ configuration for Indexing Pipeline.
 * @see extensions/wikia/IndexingPipeline/PipelineEventProducer.class.php
 * @var array $wgIndexingPipeline
 */
$wgIndexingPipeline = [
	'vhost' => 'indexer',
	'exchange' => 'events',
];

/**
 * Internal server name as known to Squid, if different.
 * @example $wgInternalServer = 'http://yourinternal.tld:8000';
 * @var string|bool $wgInternalServer
 */
$wgInternalServer = false;

/**
 * Interwiki caching settings. $wgInterwikiCache specifies path to constant
 * database file. This cdb database is generated by dumpInterwiki from
 * maintenance and has such key formats:
 * - dbname:key - a simple key (e.g. enwiki:meta)
 * - _sitename:key - site-scope key (e.g. wiktionary:meta)
 * - __global:key - global-scope key (e.g. __global:meta)
 * - __sites:dbname - site mapping (e.g. __sites:enwiki)
 * Sites mapping just specifies site name, other keys provide "local url" data
 * layout.
 * @var string|bool $wgInterwikiCache
 */
$wgInterwikiCache = false;

/**
 * Expiry time for cache of interwiki table.
 * @var int $wgInterwikiExpiry
 */
$wgInterwikiExpiry = 24 * 3600; // 1 day

/**
 * If interwiki mappings is cached ($wgInterwikiCache is specified), but it is
 * impossible to resolve interwiki link based on cached information, this will
 * be used as fallback.
 * @see $wgInterwikiCache
 * @var string $wgInterwikiFallbackSite
 */
$wgInterwikiFallbackSite = 'wiki';

/**
 * Treat language links as magic connectors, not inline links.
 * @var bool $wgInterwikiMagic
 */
$wgInterwikiMagic = true;

/**
 * If interwiki mappings is cached ($wgInterwikiCache is specified), we can
 * specify the number of domains to check for messages.
 * 1 - Just wiki(db)-level
 * 2 - wiki and global levels
 * 3 - site levels
 * @see $wgInterwikiCache
 * @var string $wgInterwikiScopes
 */
$wgInterwikiScopes = 3;

/**
 * Invalidate various caches when LocalSettings.php changes. This is equivalent
 * to setting $wgCacheEpoch to the modification time of LocalSettings.php, as
 * was previously done in the default LocalSettings.php file. On high-traffic
 * wikis, this should be set to false, to avoid the need to check the file
 * modification time, and to avoid the performance impact of unnecessary cache
 * invalidations.
 * @var bool $wgInvalidateCacheOnLocalSettingsChange
 */
$wgInvalidateCacheOnLocalSettingsChange = false;

/**
 * Array of invalid page redirect targets. Attempting to create a redirect to
 * any of the pages in this array will make the redirect fail. Userlogout is
 * hard-coded, so it does not need to be listed here. As of now, this only
 * checks special pages. Redirects to pages in other namespaces cannot be
 * invalidated by this variable.
 * @var Array $wgInvalidRedirectTargets
 */
$wgInvalidRedirectTargets = [
	'Filepath',
	'Mypage',
	'Mytalk'
];

/**
 * Characters to prevent during new account creations. This is used in a regular
 * expression character class during registration (regex metacharacters like /
 * are escaped).
 * @var string $wgInvalidUsernameCharacters
 */
$wgInvalidUsernameCharacters = '@:';

/**
 * Configuration for javascript testing.
 * @var Array $wgJavaScriptTestConfig
 */
$wgJavaScriptTestConfig = [
	'qunit' => [
		'documentation' => '//www.mediawiki.org/wiki/Manual:JavaScript_unit_testing',
	],
];

/**
 * Jobs that must be explicitly requested, i.e. aren't run by job runners unless
 * special flags are set.
 *
 * These can be:
 * - Very long-running jobs.
 * - Jobs that you would never want to run as part of a page rendering request.
 * - Jobs that you want to run on specialized machines (like transcoding, or
 *   a particular machine on your cluster has 'outside' web access you could
 *   restrict uploadFromUrl)
 * @var Array $wgJobTypesExcludedFromDefaultQueue
 */
$wgJobTypesExcludedFromDefaultQueue = [];

/**
 * The content type used in script tags.  This is mostly going to be ignored if
 * $wgHtml5 is true, at least for actual HTML output, since HTML5 doesn't
 * require a MIME type for JavaScript or CSS (those are the default script and
 * style languages).
 * @var string $wgJsMimeType
 */
$wgJsMimeType = 'text/javascript';

/**
 * Site language code, should be one of ./languages/Language(.*).php
 * @var string $wgLanguageCode
 */
$wgLanguageCode = 'en';

/**
 * Set this to eg 'ISO-8859-1' to perform character set conversion when
 * loading old revisions not marked with "utf-8" flag. Use this when
 * converting a wiki from MediaWiki 1.4 or earlier to UTF-8 without the
 * burdensome mass conversion of old text data. NOTE! This DOES NOT touch any
 * fields other than old_text.Titles, comments, user names, etc still must be
 * converted en masse in the database before continuing as a UTF-8 wiki.
 * @see iconv
 * @var string|bool $wgLegacyEncoding
 */
$wgLegacyEncoding = false;

/**
 * Whether or not to assign configuration variables to the global window object.
 * If this is set to false, old code using deprecated variables like:
 * " if ( window.wgRestrictionEdit ) ..."
 * or:
 * " if ( wgIsArticle ) ..."
 * will no longer work and needs to use mw.config instead. For example:
 * " if ( mw.config.exists('wgRestrictionEdit') )"
 * or
 * " if ( mw.config.get('wgIsArticle') )".
 * @var bool $wgLegacyJavaScriptGlobals
 */
$wgLegacyJavaScriptGlobals = true;

/**
 * If set to true, the MediaWiki 1.4 to 1.5 schema conversion will create stub
 * reference rows in the text table instead of copying the full text of all
 * current entries from 'cur' to 'text'. This will speed up the conversion step
 * for large sites, but requires that the cur table be kept around for those
 * revisions to remain viewable. maintenance/migrateCurStubs.php can be used to
 * complete the migration in the background once the wiki is back online. This
 * option affects the updaters *only*. Any present cur stub revisions will be
 * readable at runtime regardless of this setting.
 * @var bool $wgLegacySchemaConversion
 */
$wgLegacySchemaConversion = false;

/**
 * Allowed title characters -- regex character class
 * Don't change this unless you know what you're doing
 *
 * Problematic punctuation:
 *   -  []{}|#    Are needed for link syntax, never enable these
 *   -  <>        Causes problems with HTML escaping, don't use
 *   -  %         Enabled by default, minor problems with path to query rewrite
 *                rules, see below
 *   -  +         Enabled by default, but doesn't work with path to query
 *                rewrite rules, corrupted by apache
 *   -  ?         Enabled by default, but doesn't work with path to PATH_INFO
 *                rewrites
 *
 * All three of these punctuation problems can be avoided by using an alias,
 * instead of a rewrite rule of either variety.
 *
 * The problem with % is that when using a path to query rewrite rule, URLs are
 * double-unescaped: once by Apache's path conversion code, and again by PHP. So
 * %253F, for example, becomes "?". Our code does not double-escape to
 * compensate for this, indeed double escaping would break if the double-escaped
 * title was passed in the query string rather than the path. This is a minor
 * security issue because articles can be created such that they are hard to
 * view or edit.
 *
 * In some rare cases you may wish to remove + for compatibility with old links.
 *
 * Theoretically 0x80-0x9F of ISO 8859-1 should be disallowed, but
 * this breaks interlanguage links
 * @var string $wgLegalTitleChars
 */
$wgLegalTitleChars = " %!\"$&'()*,\\-.\\/0-9:;=?@A-Z\\\\^_`a-z~\\x80-\\xFF+";

/**
 * Set to an array of metadata terms. Else they will be loaded based on
 * $wgRightsUrl.
 * @var Array|bool $wgLicenseTerms
 */
$wgLicenseTerms = false;

/**
 * LinkHolderArray batch size; for debugging.
 * @var int $wgLinkHolderBatchSize
 */
$wgLinkHolderBatchSize = 1000;

/**
 * Load MediaWiki:Common.css in Oasis.
 * @see $wgOasisLoadCommonCSS
 * @var bool $wgLoadCommonCSS
 */
$wgLoadCommonCSS = false;

/**
 * Switch for loading the FileInfo extension by PECL at runtime.
 * This should be used only if fileinfo is installed as a shared object
 * or a dynamic library.
 * @var bool $wgLoadFileinfoExtension
 */
$wgLoadFileinfoExtension = false;

/**
 * The URL path to load.php. Defaults to
 * "{$wgScriptPath}/load{$wgScriptExtension}" in Setup.php
 * @see app/includes/Setup.php
 * @var string|bool $wgScript
 */
$wgLoadScript = false;

/**
 * Other wikis on this site, can be administered from a single developer
 * account. Array numeric key => database name.
 * @var Array $wgLocalDatabases
 */
$wgLocalDatabases = [];

/**
 * File repository structures
 *
 * $wgLocalFileRepo is a single repository structure, and $wgForeignFileRepos is
 * an array of such structures. Each repository structure is an associative
 * array of properties configuring the repository.
 *
 * Properties required for all repos:
 *   - class            The class name for the repository. May come from the core or an extension.
 *                      The core repository classes are FileRepo, LocalRepo, ForeignDBRepo.
 *                      FSRepo is also supported for backwards compatibility.
 *
 *   - name             A unique name for the repository (but $wgLocalFileRepo should be 'local').
 *                      The name should consist of alpha-numberic characters.
 *   - backend          A file backend name (see $wgFileBackends).
 *
 * For most core repos:
 *   - zones            Associative array of zone names that each map to an array with:
 *                          container : backend container name the zone is in
 *                          directory : root path within container for the zone
 *                      Zones default to using <repo name>-<zone> as the
 *                      container name and the container root as the zone directory.
 *   - url              Base public URL
 *   - hashLevels       The number of directory levels for hash-based division of files
 *   - transformVia404  Whether to skip media file transformation on parse and rely on a 404
 *                      handler instead.
 *   - initialCapital   Equivalent to $wgCapitalLinks (or $wgCapitalLinkOverrides[NS_FILE],
 *                      determines whether filenames implicitly start with a capital letter.
 *                      The current implementation may give incorrect description page links
 *                      when the local $wgCapitalLinks and initialCapital are mismatched.
 *   - pathDisclosureProtection
 *                      May be 'paranoid' to remove all parameters from error messages, 'none' to
 *                      leave the paths in unchanged, or 'simple' to replace paths with
 *                      placeholders. Default for LocalRepo is 'simple'.
 *   - fileMode         This allows wikis to set the file mode when uploading/moving files. Default
 *                      is 0644.
 *   - directory        The local filesystem directory where public files are stored. Not used for
 *                      some remote repos.
 *   - thumbDir         The base thumbnail directory. Defaults to <directory>/thumb.
 *   - thumbUrl         The base thumbnail URL. Defaults to <url>/thumb.
 *
 *
 * These settings describe a foreign MediaWiki installation. They are optional, and will be ignored
 * for local repositories:
 *   - descBaseUrl       URL of image description pages, e.g. http://en.wikipedia.org/wiki/File:
 *   - scriptDirUrl      URL of the MediaWiki installation, equivalent to $wgScriptPath, e.g.
 *                       http://en.wikipedia.org/w
 *   - scriptExtension   Script extension of the MediaWiki installation, equivalent to
 *                       $wgScriptExtension, e.g. .php5 defaults to .php
 *
 *   - articleUrl        Equivalent to $wgArticlePath, e.g. http://en.wikipedia.org/wiki/$1
 *   - fetchDescription  Fetch the text of the remote file description page. Equivalent to
 *                      $wgFetchCommonsDescriptions.
 *
 * ForeignDBRepo:
 *   - dbType, dbServer, dbUser, dbPassword, dbName, dbFlags
 *                      equivalent to the corresponding member of $wgDBservers
 *   - tablePrefix       Table prefix, the foreign wiki's $wgDBprefix
 *   - hasSharedCache    True if the wiki's shared cache is accessible via the local $wgMemc
 *
 * ForeignAPIRepo:
 *   - apibase              Use for the foreign API's URL
 *   - apiThumbCacheExpiry  How long to locally cache thumbs for
 *
 * If you leave $wgLocalFileRepo set to false, Setup will fill in appropriate values.
 * Otherwise, set $wgLocalFileRepo to a repository structure as described above.
 * If you set $wgUseInstantCommons to true, it will add an entry for Commons.
 * If you set $wgForeignFileRepos to an array of repostory structures, those will
 * be searched after the local file repo.
 * Otherwise, you will only have access to local media files.
 *
 * @see Setup.php for an example usage and default initialization.
 * @see $wgForeignFileRepos
 * @see $wgUseInstantCommons
 * @var Array|bool $wgLocalFileRepo
 */
$wgLocalFileRepo = false;

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
 * @see maintenance/rebuildLocalisationCache.php
 * @see languages/Language.php
 * @see includes/installer/DatabaseUpdater.php
 * @var Array $wgLocalisationCacheConf
 */
$wgLocalisationCacheConf = [
	'class' => 'LocalisationCache',
	'store' => 'files',
	'storeClass' => false,
	'storeDirectory' => false,
	'manualRecache' => true,
];

/**
 * Defines format of local cache.
 * true - Serialized object
 * false - PHP source file (Warning - security risk)
 * @var bool $wgLocalMessageCacheSerialized
 */
$wgLocalMessageCacheSerialized = true;

/**
 * The URL path of the skins directory. Should not point to an external domain.
 * Defaults to "{$wgScriptPath}/skins".
 * @var string|bool $wgLocalStylePath
 */
$wgLocalStylePath = false;

/**
 * Fake out the timezone that the server thinks it's in. This will be used for
 * date display and not for what's stored in the DB. Leave to null to retain
 * your server's OS-based timezone value. This variable is currently used only
 * for signature formatting and for local time/date parser variables
 * ({{LOCALTIME}} etc.) Timezones can be translated by editing MediaWiki
 * messages of type timezone-nameinlowercase like timezone-utc.
 * @example $wgLocaltimezone = 'GMT';
 * @example $wgLocaltimezone = 'PST8PDT';
 * @example $wgLocaltimezone = 'Europe/Sweden';
 * @example $wgLocaltimezone = 'CET';
 * @var string $wgLocaltimezone
 */
$wgLocaltimezone = null;

/**
 * Set an offset from UTC in minutes to use for the default timezone setting
 * for anonymous users and new user accounts. This setting is used for most
 * date/time displays in the software, and is overrideable in user preferences.
 * It is *not* used for signature timestamps. By default, this will be set to
 * match $wgLocaltimezone.
 * @see $wgLocaltimezone
 * @see date('Z')
 * @var int $wgLocalTZoffset
 */
$wgLocalTZoffset = null;

/**
 * Local user preferences (options) filter.
 * @see lib/Wikia/src/Factory/PreferencesFactory.php
 * @var Array $wgLocalUserPreferenceWhiteList
 */
$wgLocalUserPreferenceWhiteList = [
	'regexes' => [
		'^adoptionmails-([0-9]+)',
		'^founderemails-complete-digest-([0-9]+)$',
		'^founderemails-edits-([0-9]+)$',
		'^founderemails-joins-([0-9]+)$',
		'^founderemails-views-digest-([0-9]+)$',
	]
];

/**
 * Array of configuration arrays for each lock manager.
 * Each backend configuration has the following parameters:
 *     'name'        : A unique name for the lock manger
 *     'class'       : The lock manger class to use
 * Additional parameters are specific to the class used.
 * @var Array $wgLockManagers
 */
$wgLockManagers = [];

/**
 * Lists the message key strings for formatting individual events of each
 * type and action when listed in the logs. Extensions with custom log types may
 * add to this array in their setup files.
 * @var Array $wgLogActions
 */
$wgLogActions = [
	'block/block'        => 'blocklogentry',
	'block/unblock'      => 'unblocklogentry',
	'block/reblock'      => 'reblock-logentry',
	'protect/protect'    => 'protectedarticle',
	'protect/modify'     => 'modifiedarticleprotection',
	'protect/unprotect'  => 'unprotectedarticle',
	'protect/move_prot'  => 'movedarticleprotection',
	'rights/rights'      => 'rightslogentry',
	'rights/autopromote' => 'rightslogentry-autopromote',
	'upload/upload'      => 'uploadedimage',
	'upload/overwrite'   => 'overwroteimage',
	'upload/revert'      => 'uploadedimage',
	'import/upload'      => 'import-logentry-upload',
	'import/interwiki'   => 'import-logentry-interwiki',
	'merge/merge'        => 'pagemerge-logentry',
	'suppress/block'     => 'blocklogentry',
	'suppress/reblock'   => 'reblock-logentry',
];

/**
 * The same as $wgLogActions, but here values are names of functions,
 * not messages.
 * @see LogPage::actionText
 * @see LogFormatter
 * @var Array $wgLogActionsHandlers
 */
$wgLogActionsHandlers = [
	// move, move_redir
	'move/*'            => 'MoveLogFormatter',
	// delete, restore, revision, event
	'delete/*'          => 'DeleteLogFormatter',
	'suppress/revision' => 'DeleteLogFormatter',
	'suppress/event'    => 'DeleteLogFormatter',
	'suppress/delete'   => 'DeleteLogFormatter',
	'patrol/patrol'     => 'PatrolLogFormatter',
];

/**
 * Lists the message key strings for descriptive text to be shown at the
 * top of each log type. Extensions with custom log types may add to this array
 * in their setup files. Since 1.19, if you follow the naming convention
 * log-description-TYPE, where TYPE is your log type, yoy don't need to use this
 * array.
 * @var Array $wgLogHeaders
 */
$wgLogHeaders = [
	''        => 'alllogstext',
	'block'   => 'blocklogtext',
	'protect' => 'protectlogtext',
	'rights'  => 'rightslogtext',
	'delete'  => 'dellogpagetext',
	'upload'  => 'uploadlogpagetext',
	'move'    => 'movelogpagetext',
	'import'  => 'importlogpagetext',
	'patrol'  => 'patrol-log-header',
	'merge'   => 'mergelogpagetext',
	'suppress' => 'suppressionlogtext',
];

/**
 * Show a bar of language selection links in the user login and user
 * registration forms; edit the "loginlanguagelinks" message to
 * customise these.
 * @var bool $wgLoginLanguageSelector
 */
$wgLoginLanguageSelector = true;

/**
 * Lists the message key strings for each log type. The localized messages
 * will be listed in the user interface. Extensions with custom log types may
 * add to this array in their setup files. Since 1.19, if you follow the naming
 * convention log-name-TYPE, where TYPE is your log type, yoy don't need to use
 * this array.
 * @var Array $wgLogNames
 */
$wgLogNames = [
	''        => 'all-logs-page',
	'block'   => 'blocklogpage',
	'protect' => 'protectlogpage',
	'rights'  => 'rightslog',
	'delete'  => 'dellogpage',
	'upload'  => 'uploadlogpage',
	'move'    => 'movelogpage',
	'import'  => 'importlogpage',
	'patrol'  => 'patrol-log-page',
	'merge'   => 'mergelog',
	'suppress' => 'suppressionlog',
];

/**
 * The URL path of the wiki logo. Will default to
 * "{$wgStylePath}/common/images/wiki.png" in Setup.php.
 * @see Setup.php
 * @var string|bool $wgLogo
 */
$wgLogo = false;

/**
 * This restricts log access to those who have a certain right Users without
 * this will not see it in the option menu and can not view it. Restricted logs
 * are not added to recent changes. Logs should remain non-transcludable.
 * @example logtype => permissiontype
 * @var Array $wgLogRestrictions
 */
$wgLogRestrictions = [
	'suppress' => 'suppressionlog'
];

/**
 * The logging system has two levels: an event type, which describes the
 * general category and can be viewed as a named subset of all logs; and
 * an action, which is a specific kind of event that can exist in that
 * log type.
 * @var Array $wgLogTypes
 */
$wgLogTypes = [
	'',
	'block',
	'protect',
	'rights',
	'delete',
	'upload',
	'move',
	'import',
	'patrol',
	'merge',
	'suppress',
];

/**
 * Do not include those wikis on Special:LookupContribs page.
 * @see extensions/wikia/LookupContribs/SpecialLookupContribs_helper.php
 * @var Array $wgLookupContribsExcluded
 */
$wgLookupContribsExcluded = [];

/**
 * Array for extensions to register their maintenance scripts with the
 * system. The key is the name of the class and the value is the full
 * path to the file.
 * @var Array $wgMaintenanceScripts
 */
$wgMaintenanceScripts = [];

/**
 * When OutputHandler is used, mangle any output that contains
 * <cross-domain-policy>. Without this, an attacker can send their own
 * cross-domain policy unless it is prevented by the crossdomain.xml file at
 * the domain root.
 * @var bool $wgMangleFlashPolicy
 */
$wgMangleFlashPolicy = true;

/**
 * How long to wait for a MySQL slave to catch up to the master.
 * @see includes/db/LBFactory_Multi.php
 * @see includes/db/LBFactory.php
 * @var int $wgMasterWaitTimeout
 */
$wgMasterWaitTimeout = 10;

/**
 * Force thumbnailing of animated GIFs above this size to a single frame instead
 * of an animated thumbnail.  As of MW 1.17 this limit is checked against the
 * total size of all frames in the animation. It probably makes sense to keep
 * this equal to $wgMaxImageArea.
 * @var float $wgMaxAnimatedGifArea
 */
$wgMaxAnimatedGifArea = 1.25e7; // 12.5 million pixels

/**
 * Maximum article size in kibibytes.
 * @var int $wgMaxArticleSize
 */
$wgMaxArticleSize = 2048;

/**
 * Set this to the number of authors that you want to be credited below an
 * article text. Set it to zero to hide the attribution block, and a negative
 * number (like -1) to show all authors. Note that this will require 2-3 extra
 * database hits, which can have a not insignificant impact on performance for
 * large wikis.
 * @var int $wgMaxCredits
 */
$wgMaxCredits = 0;

/**
 * The maximum number of pixels a source image can have if it is to be scaled
 * down by a scaler that requires the full source image to be decompressed
 * and stored in decompressed form, before the thumbnail is generated.
 *
 * This provides a limit on memory usage for the decompression side of the
 * image scaler. The limit is used when scaling PNGs with any of the
 * built-in image scalers, such as ImageMagick or GD. It is ignored for
 * JPEGs with ImageMagick, and when using the VipsScaler extension.
 *
 * The default is 50 MB if decompressed to RGBA form, which corresponds to
 * 12.5 million pixels or 3500x3500.
 * @var float $wgMaxImageArea
 */
$wgMaxImageArea = 6e7; // 6 million pixels

/**
 * Article IDs to maximize area for article content (e.g. hide rail module).
 * Initialized here, but set on per-wiki basis in WikiFactory.
 * @see skins/oasis/modules/BodyModule.class.php
 * @var Array $wgMaximizeArticleAreaArticleIds
 */
$wgMaximizeArticleAreaArticleIds = [];

/**
 * Maximum number of pages to move at once when moving subpages with a page.
 * @var int $wgMaximumMovedPages
 */
$wgMaximumMovedPages = 100;

/**
 * Maximum entry size in the message cache, in bytes.
 * @var int $wgMaxMsgCacheEntrySize
 */
$wgMaxMsgCacheEntrySize = 10000;

/**
 * Maximum number of bytes in username. You want to run the maintenance
 * script ./maintenance/checkUsernames.php once you have changed this value.
 * @var int $wgMaxNameChars
 */
$wgMaxNameChars = 255;

/**
 * Maximum recursion depth for templates within templates for preprocessors.
 * @see $wgMaxTemplateDepth
 * @var int $wgMaxPPExpandDepth
 */
$wgMaxPPExpandDepth = 40;

/**
 * A complexity limit on template expansion.
 * @var int $wgMaxPPNodeCount
 */
$wgMaxPPNodeCount = 300000;

/**
 * Maximum number of links to a redirect page listed on
 * Special:Whatlinkshere/RedirectDestination.
 * @var int $wgMaxRedirectLinksRetrieved
 */
$wgMaxRedirectLinksRetrieved = 500;

/**
 * Max number of redirects to follow when resolving redirects. 1 means only the
 * first redirect is followed (default behavior). 0 or less means no redirects
 * are followed.
 * @var int $wgMaxRedirects
 */
$wgMaxRedirects = 1;

/**
 * Maximum file size created by shell processes under linux, in KiB.
 * ImageMagick convert for example can be fairly hungry for scratch space.
 * Set to 0 for unlimited size.
 */
$wgMaxShellFileSize = 102400; // 100 MiB

/**
 * Maximum amount of virtual memory available to shell processes under linux,
 * in KB. Set to 0 for unlimited memory.
 * @see OPS-8226
 * @var int $wgMaxShellMemory
 */
$wgMaxShellMemory = 0;

/**
 * Maximum CPU time in seconds for shell processes under Linux. Set to 0 for
 * unlimited time.
 * @var int $wgMaxShellTime
 */
$wgMaxShellTime = 180; // 3 minutes

/**
 * Maximum number of Unicode characters in signature.
 * @var int $wgMaxSigChars
 */
$wgMaxSigChars = 1200;

/**
 * Maximum number of titles to purge in any one client operation.
 * @see SquidUpdate
 * @var int $wgMaxSquidPurgeTitles
 */
$wgMaxSquidPurgeTitles = 400;

/**
 * Maximum recursion depth for templates within templates. The current parser
 * adds two levels to the PHP call stack for each template, and xdebug limits
 * the call stack to 100 by default. So this should hopefully stop the parser
 * before it hits the xdebug limit.
 * @var int $wgMaxTemplateDepth
 */
$wgMaxTemplateDepth = 40;

/**
 * Don't create thumbnails bigger than this number of pixels.
 * @see /extensions/wikia/VideoHandlers/handlers/VideoHandler.class.php
 * @var float $wgMaxThumbnailArea
 */
$wgMaxThumbnailArea = 0.9e7; // 9 million pixels

/**
 * Maximum indent level of toc (table of contents).
 * @var int $wgMaxTocLevel
 */
$wgMaxTocLevel = 999;

/**
 * Max size for uploads, in bytes. If not set to an array, applies to all
 * uploads. If set to an array, per upload type maximums can be set, using the
 * file and url keys. If the * key is set this value will be used as maximum
 * for non-specified types.
 *
 * For example:
 * $wgMaxUploadSize = array(
 *     '*' => 250 * 1024,
 *     'url' => 500 * 1024,
 * );
 * Sets the maximum for all uploads to 250 kB except for upload-by-url, which
 * will have a maximum of 500 kB.
 * @var int|Array $wgMaxUploadSize
 */
$wgMaxUploadSize = 1024 * 1024 * 10; // 10 MiB

/**
 * Plugins for media file type handling. Each entry in the array maps a MIME
 * type to a class name.
 * @var Array $wgMediaHandlers
 */
$wgMediaHandlers = [
	'image/gif'      => 'GIFHandler',
	'image/jpeg'     => 'JpegHandler',
	'image/png'      => 'PNGHandler',
	'image/svg'      => 'SvgHandler', // compat
	'image/svg+xml'  => 'SvgHandler', // official
	'image/tiff'     => 'TiffHandler',
	'image/vnd.djvu' => 'DjVuHandler', // official
	'image/x-bmp'    => 'BmpHandler',
	'image/x-djvu'   => 'DjVuHandler', // compat
	'image/x-ms-bmp' => 'BmpHandler',
	'image/x-xcf'    => 'XCFHandler',
	'image/x.djvu'   => 'DjVuHandler', // compat
];

/**
 * URL section corresponing to the deployment directory in /usr/wikia/.
 * @see wfReplaceImageServer()
 * @see maintenance/wikia/WikiFactoryVariables/migrateWikiFactoryToHttps.php
 * @see maintenance/wikia/WikiFactoryVariables/migrateWikiWordmarks.php
 * @global string $wgMedusaHostPrefix
 */
$wgMedusaHostPrefix = 'slot1.';

/**
 * Use persistent connections to MemCached, which are shared across multiple
 * requests.
 * @var bool $wgMemCachedPersistent
 */
$wgMemCachedPersistent = true;

/**
 * The list of MemCached servers and port numbers.
 * @see includes/cache/wikia/LibmemcachedBagOStuff.php
 * @see includes/objectcache/MemcachedPhpBagOStuff.php
 * @var Array $wgMemCachedServers
 */
$wgMemCachedServers = [
	0 => 'prod.twemproxy.service.consul:21000',
	1 => 'prod.twemproxy.service.consul:31000',
];

/**
 * Read/write timeout for MemCached server communication, in microseconds.
 * @var int $wgMemCachedTimeout
 */
$wgMemCachedTimeout = 1 * 1000000; // half a second

/**
 * The minimum amount of memory that MediaWiki "needs"; MediaWiki will try to
 * raise PHP's memory limit if it's below this amount.
 * @var string $wgMemoryLimit
 */
$wgMemoryLimit = '50M';

/**
 * Name of the project namespace. If left set to false, $wgSitename will be
 * used instead.
 *  @var string|bool $wgMetaNamespace
 */
$wgMetaNamespace = false;

/**
 * Name of the project talk namespace. Normally you can ignore this and it will
 * be something like $wgMetaNamespace . "_talk". In some languages, you may want
 * to set this manually for grammatical reasons.
 * @var string|false $wgMetaNamespaceTalk
 */
$wgMetaNamespaceTalk = false;

/**
 * Sets an external mime detector program. The command must print only the mime
 * type to standard output. The name of the file to process will be appended to
 * the command given here. If not set or NULL, mime_content_type will be used if
 * available.
 * @example $wgMimeDetectorCommand = "file -bi";
 * @var string $wgMimeDetectorCommand
 */
$wgMimeDetectorCommand = null;

/**
 * Sets the mime type info file to use by MimeMagic.php. If null, built-in
 * defaults will be used.
 * @var string $wgMimeInfoFile
 */
$wgMimeInfoFile = 'includes/mime.info';

/**
 * The default Content-Type header.
 * @var string $wgMimeType
 */
$wgMimeType = 'text/html';

/**
 * Files with these mime types will never be allowed as uploads
 * if $wgVerifyMimeType is enabled.
 * @see $wgVerifyMimeType
 * @var Array $wgMimeTypeBlacklist
 */
$wgMimeTypeBlacklist = [
	# HTML may contain cookie-stealing JavaScript and web bugs
	'text/html', 'text/javascript', 'text/x-javascript', 'application/x-shellscript',
	# PHP scripts may execute arbitrary code on the server
	'application/x-php', 'text/x-php',
	# Other types that may be interpreted by some servers
	'text/x-python', 'text/x-perl', 'text/x-bash', 'text/x-sh', 'text/x-csh',
	# Client-side hazards on Internet Explorer
	'text/scriptlet', 'application/x-msdownload',
	# Windows metafile, client-side vulnerability on some systems
	'application/x-msmetafile',
];

/**
 * Sets the mime type definition file to use by MimeMagic.php. If null, built-in
 * defaults will be used.
 * @example $wgMimeTypeFile = '/etc/mime.types';
 * @var string $wgMimeTypeFile
 */
$wgMimeTypeFile = 'includes/mime.types';

/**
 * Specifies the minimal length of a user password. If set to 0, empty pass-
 * words are allowed.
 * @var int $wgMinimalPasswordLength
 */
$wgMinimalPasswordLength = 1;

/**
 * Minimum upload chunk size, in bytes. When using chunked upload, non-final
 * chunks smaller than this will be rejected. May be reduced based on the
 * 'upload_max_filesize' or 'post_max_size' PHP settings.
 * @since 1.26
 * @var int $wgMinUploadChunkSize
 */
$wgMinUploadChunkSize = 1024; // 1 KiB

/**
 * Disable database-intensive features.
 * @var bool $wgMiserMode
 */
$wgMiserMode = true;

/**
 * Expiry time for the message cache key.
 * @var int $wgMsgCacheExpiry
 */
$wgMsgCacheExpiry = 24 * 3600; // one day

/**
 * Template for internal MediaWiki suggestion engine, defaults to API
 * action=opensearch. Placeholders: {searchTerms}, {namespaces}, {dbname}.
 * @var string|bool $wgMWSuggestTemplate
 */
$wgMWSuggestTemplate = false;

/**
 * Optionally, specify an explicit connection character set override for MySQL here.
 * If this value is set, it will overwrite any other settings, such as the implicit UTF-8 charset if $wgMysql5 is set.
 * @var string|null $wgMysqlConnectionCharacterSet
 */
$wgMysqlConnectionCharacterSet = null;

/**
 * Namespace aliases. These are alternate names for the primary localised
 * namespace names, which are defined by $wgExtraNamespaces and the language
 * file. If a page is requested with such a prefix, the request will be
 * redirected to the primary name. Set this to a map from namespace names to
 * IDs.
 * Example:
 *    $wgNamespaceAliases = array(
 *        'Wikipedian' => NS_USER,
 *        'Help' => 100,
 *    );
 * @var Array $wgNamespaceAliases
 */
$wgNamespaceAliases = [];

/**
 * Robot policies per namespaces. The default policy is given above, the array
 * is made of namespace constants as defined in includes/Defines.php.  You can-
 * not specify a different default policy for NS_SPECIAL: it is always noindex,
 * nofollow.  This is because a number of special pages (e.g., ListPages) have
 * many permutations of options that display the same data under redundant
 * URLs, so search engine spiders risk getting lost in a maze of twisty special
 * pages, all alike, and never reaching your actual content.
 *
 * Example:
 *   $wgNamespaceRobotPolicies = array( NS_TALK => 'noindex' );
 *
 * @var Array $wgNamespaceRobotPolicies
 */
$wgNamespaceRobotPolicies = [];

/**
 * Maintain a log of newusers at Log/newusers?
 * @var bool $wgNewUserLog
 */
$wgNewUserLog = true;

/**
 * If this is set to an array of domains, external links to these domain names
 * (or any subdomains) will not be set to rel="nofollow" regardless of the
 * value of $wgNoFollowLinks.  For instance:
 *
 * $wgNoFollowDomainExceptions = array( 'en.wikipedia.org', 'wiktionary.org' );
 *
 * This would add rel="nofollow" to links to de.wikipedia.org, but not
 * en.wikipedia.org, wiktionary.org, en.wiktionary.org, us.en.wikipedia.org,
 * etc.
 *
 * @see $wgNoFollowLinks
 * @var Array $wgNoFollowDomainExceptions
 */
$wgNoFollowDomainExceptions = [];

/**
 * If true, external URL links in wiki text will be given the
 * rel="nofollow" attribute as a hint to search engines that
 * they should not be followed for ranking purposes as they
 * are user-supplied and thus subject to spamming.
 * @var bool $wgNoFollowLinks
 */
$wgNoFollowLinks = true;

/**
 * Namespaces in which $wgNoFollowLinks doesn't apply, meaning external URL
 * links in wiki text will not be given the rel="nofollow" attribute.
 *
 * @see Language.php for a list of namespaces
 * @see $wgNoFollowLinks
 * @var Array $wgNoFollowNsExceptions
 */
$wgNoFollowNsExceptions = [];

/**
 * Pages in namespaces in this array can not be used as templates.
 * Elements must be numeric namespace ids. Among other things, this may be
 * useful to enforce read-restrictions which may otherwise be bypassed by using
 * the template mechanism.
 * @var Array $wgNonincludableNamespaces
 */
$wgNonincludableNamespaces = [];

/**
 * Dummy address which should be accepted during mail send action.
 * It might be necessary to adapt the address or to set it equal
 * to the $wgEmergencyContact address.
 * @see $wgEmergencyContact
 * @var string $wgNoReplyAddress
 */
$wgNoReplyAddress = 'noreply@fandom.com';

/**
 * Enable WikiaGrid.
 * @see extensions/wikia/SASS/SassUtil.php
 * @see extensions/wikia/WikiaPhotoGallery/WikiaPhotoGalleryHelper.class.php
 * @var bool $wgOasisGrid
 */
$wgOasisGrid = true;

/**
 * Load MediaWiki:Common.css Oasis.
 * @see $wgLoadCommonCSS
 * @var bool $wgOasisLoadCommonCSS
 */
$wgOasisLoadCommonCSS = false;

/**
 * Use redesigned (v. 2) wiki navigation.
 * @see app/skins/oasis/modules/templates/
 * @var bool $wgOasisNavV2
 */
$wgOasisNavV2 = true;

/**
 * Use old names for change_tags indices.
 * @var bool $wgOldChangeTagsIndex
 */
$wgOldChangeTagsIndex = false;

/**
 * Template for OpenSearch suggestions, defaults to API action=opensearch.
 * Sites with heavy load would tipically have these point to a custom PHP
 * wrapper to avoid firing up mediawiki for every keystroke. Placeholder:
 * {searchTerms}.
 * @see includes/search/SearchEngine.php
 * @var $wgOpenSearchTemplate
 */
$wgOpenSearchTemplate = false;

/**
 * Override the site's default RSS/ATOM feed for recentchanges that appears on
 * every page. Some sites might have a different feed they'd like to promote
 * instead of the RC feed (maybe like a "Recent New Articles" or "Breaking news"
 * one). Ex: $wgSiteFeed['format'] = "http://example.com/somefeed.xml"; Format
 * can be one of either 'rss' or 'atom'.
 * @var Array $wgOverrideSiteFeed
 */
$wgOverrideSiteFeed = [];

/**
 * Page property link table invalidation lists. When a page property changes,
 * this may require other link tables to be updated (e.g. adding __HIDDENCAT__
 * means the hiddencat tracking category will have been added, so
 * the categorylinks table needs to be rebuilt). Extensions may add to this
 * array in their setup files.
 * @var Array $wgPagePropLinkInvalidations
 */
$wgPagePropLinkInvalidations = [
	'hiddencat' => 'categorylinks',
];

/**
 * Page share services configuration.
 * Each entry consists of
 * - 'name' - unique name of the service (used for generating ID in markup and for choosing icon)
 * - 'url' - url which to open when we click share button
 *    $url is being replaced by escaped current documents' URL
 *    $title is being replaced by escaped current documents' title
 * - 'title' - title of the icon
 * - 'languages:include' - (optional) list of languages that should have this share option available
 *    defaults to all available languages
 * - 'languages:exclude' - (optional) list of languages that shouldn't have this share option available
 * @see extensions/wikia/PageShare/PageShareController.class.php
 * @var Array $wgPageShareServices
 */
$wgPageShareServices = [
	[
		'name' => 'line',
		'title' => 'Line',
		'href' => 'http://line.me/R/msg/text/?$title $url',
		'languages:include' => [ 'ja' ],
		'displayOnlyOnTouchDevices' => true,
	], [
		'name' => 'vkontakte',
		'title' => 'VK',
		'href' => 'http://vkontakte.ru/share.php?url=$url',
		'languages:include' => [ 'ru' ],
	], [
		'name' => 'facebook',
		'title' => 'Facebook',
		'href' => 'https://www.facebook.com/sharer/sharer.php?u=$url',
	], [
		'name' => 'odnoklassniki',
		'title' => 'Odnoklassniki',
		'href' => 'http://connect.odnoklassniki.ru/dk?cmd=WidgetSharePreview&st.cmd=WidgetSharePreview&st._aid=ExternalShareWidget_SharePreview&st.shareUrl=$url',
		'languages:include' => [ 'ru' ],
	], [
		'name' => 'twitter',
		'title' => 'Twitter',
		'href' => 'https://twitter.com/share?url=$url',
		'languages:exclude' => [ 'zh' ],
	], [
		'name' => 'googleplus',
		'title' => 'Google+',
		'href' => 'https://plus.google.com/share?url=$url',
		'languages:include' => [ 'ja' ],
	], [
		'name' => 'meneame',
		'title' => 'Menéame',
		'href' => 'http://meneame.net/submit.php?url=$url',
		'languages:include' => [ 'es' ],
	], [
		'name' => 'reddit',
		'title' => 'Reddit',
		'href' => 'http://www.reddit.com/submit?url=$url',
		'languages:exclude' => [ 'ja', 'zh', 'de', 'fr', 'es', 'ru', 'pl' ],
	], [
		'name' => 'tumblr',
		'title' => 'Tumblr',
		'href' => 'http://www.tumblr.com/share/link?url=$url',
		'languages:exclude' => [ 'ja', 'zh', 'fr', 'ru', 'pl' ],
	], [
		'name' => 'weibo',
		'title' => 'Sina Weibo',
		'href' => 'http://service.weibo.com/share/share.php?url=$url&title=$title',
		'languages:include' => [ 'zh' ],
	], [
		'name' => 'nk',
		'title' => 'NK',
		'href' => 'http://nk.pl/sledzik/widget?content=$url',
		'languages:include' => [ 'pl' ],
	], [
		'name' => 'wykop',
		'title' => 'Wykop',
		'href' => 'http://www.wykop.pl/dodaj/link/?url=$url&title=$title&desc=$description',
		'languages:include' => [ 'pl' ],
	],
];

/**
 * Show watching users in Page views.
 * @var bool $wgPageShowWatchingUsers
 */
$wgPageShowWatchingUsers = false;

/**
 * The expiry time for the parser cache, in seconds.
 * @var int $wgParserCacheExpireTime
 */
$wgParserCacheExpireTime = 14 * 24 * 3600; // 14 days

/**
 * Parser configuration. Associative array with the following members:
 *
 *  class             The class name
 *
 *  preprocessorClass The preprocessor class. Two classes are currently available:
 *                    Preprocessor_Hash, which uses plain PHP arrays for tempoarary
 *                    storage, and Preprocessor_DOM, which uses the DOM module for
 *                    temporary storage. Preprocessor_DOM generally uses less memory;
 *                    the speed of the two is roughly the same.
 *
 *                    If this parameter is not given, it uses Preprocessor_DOM if the
 *                    DOM module is available, otherwise it uses Preprocessor_Hash.
 *
 * The entire associative array will be passed through to the constructor as
 * the first parameter. Note that only Setup.php can use this variable --
 * the configuration will change at runtime via $wgParser member functions, so
 * the contents of this variable will be out-of-date. The variable can only be
 * changed during LocalSettings.php, in particular, it can't be changed during
 * an extension setup function.
 * @var Array $wgParserConf
 */
$wgParserConf = [
	'class' => 'Parser',
];

/**
 * Parser output hooks. This is an associative array where the key is
 * an extension-defined tag (typically the extension name), and the value is
 * a PHP callback. These will be called as an OutputPageParserOutput hook,
 * if the relevant tag has been registered with the parser output object.
 *
 * Registration is done with $pout->addOutputHook( $tag, $data ).
 *
 * The callback has the form:
 *    function outputHook( $outputPage, $parserOutput, $data ) { ... }
 * @var Array $wgParserOutputHooks
 */
$wgParserOutputHooks = [];

/**
 * Parser test suite files to be run by parserTests.php when no specific
 * filename is passed to it. Extensions may add their own tests to this array,
 * or site-local tests may be added via LocalSettings.php. Use full paths.
 * @var Array $wgParserTestFiles
 */
$wgParserTestFiles = [
	"$IP/tests/parser/parserTests.txt",
	"$IP/tests/parser/extraParserTests.txt"
];

/**
 * If configured, specifies target CodeReview installation to send test
 * result data from 'parserTests.php --upload'
 *
 * Something like this:
 * $wgParserTestRemote = array(
 *     'api-url' => 'http://www.mediawiki.org/w/api.php',
 *     'repo'    => 'MediaWiki',
 *     'suite'   => 'ParserTests',
 *     'path'    => '/trunk/phase3', // not used client-side; for reference
 *     'secret'  => 'qmoicj3mc4mcklmqw', // Shared secret used in HMAC validation
 * );
 * @var Array|bool $wgParserTestRemote
 */
$wgParserTestRemote = false;

/**
 * Limit password attempts to X attempts per Y seconds per IP per account.
 * Requires memcached.
 * @var Array $wgPasswordAttemptThrottle
 */
$wgPasswordAttemptThrottle = [ 'count' => 5, 'seconds' => 300 ];

/**
 * Whether to allow password resets ("enter some identifying data, and we'll
 * send an email with a temporary password you can use to get back into the
 * account") identified by various bits of data.  Setting all of these to false
 * (or the whole variable to false) has the effect of disabling password resets
 * entirely.
 * @var Array $wgPasswordResetRoutes
 */
$wgPasswordResetRoutes = [
	'username' => true,
	'email' => false,
];

/**
 * Password reminder email address. The address we should use as sender when a
 * user is requesting his password.
 * @var string $wgPasswordSender
 */
$wgPasswordSender = 'community@fandom.com';

/**
 * Phalanx RabbitMQ configuration.
 * @see extensions/wikia/PhalanxII
 * @var array $wgPhalanxQueue
 */
$wgPhalanxQueue = [
	'vhost' => 'phalanx',
	'exchange' => 'phalanx',
];

/**
 * Languages for which admins can create blocks and filters.
 * @var Array $wgPhalanxSupportedLanguages
 * @see extensions/wikia/PhalanxII
 */
$wgPhalanxSupportedLanguages = [
	'all' => 'All languages',
	'de'  => 'German',
	'en'  => 'English',
	'es'  => 'Spanish',
	'fr'  => 'French',
	'it'  => 'Italian',
	'pl'  => 'Polish',
	'ru'  => 'Russian',
];

/**
 * Executable path of the PHP cli binary (php/php5). Should be set up
 * on install.
 * @var string $wgPhpCli
 */
$wgPhpCli = 'php'; # SUS-5282 | binary location differ between distros, assume it's available in PATH
/**
 * Configuration for processing pool control, for use in high-traffic wikis.
 * An implementation is provided in the PoolCounter extension.
 *
 * This configuration array maps pool types to an associative array. The only
 * defined key in the associative array is "class", which gives the class name.
 * The remaining elements are passed through to the class as constructor
 * parameters. Example:
 *
 *   $wgPoolCounterConf = array( 'ArticleView' => array(
 *     'class' => 'PoolCounter_Client',
 *     'timeout' => 15, // wait timeout in seconds
 *     'workers' => 5, // maximum number of active threads in each pool
 *     'maxqueue' => 50, // maximum number of total threads in each pool
 *     ... any extension-specific options...
 *   );
 * @see app/extensions/PoolCounter
 * @var Array $wgPoolCounterConf
 */
$wgPoolCounterConf = null;

/**
 * PoolCounter hosts.
 * @see extensions/PoolCounter
 * @see $wgEnablePoolCounter
 * @var Array $wgPoolCounterServers
 */
$wgPoolCounterServers = [ 'poolcounter' ];

/**
 * Whether to emit more detailed debug logs for a PoolWorkArticleView
 * Controlled by $wgPoolWorkArticleViewDebugSampleRatio
 * @var bool $wgPoolWorkArticleViewDebugMode
 */
$wgPoolWorkArticleViewDebugMode = false;

/**
 * The fraction of PoolWorkArticleView executions that should be executed with more detailed logging
 * @var float $wgPoolWorkArticleViewDebugMode
 */
$wgPoolWorkArticleViewDebugSampleRatio = 0.05;

/**
 * Whether to preload the mediawiki.util module as blocking module in the top
 * queue. Before MediaWiki 1.19, modules used to load slower/less asynchronous
 * which allowed modules to lack dependencies on 'popular' modules that were
 * likely loaded already. This setting is to aid scripts during migration by
 * providing mediawiki.util unconditionally (which was the most commonly missed
 * dependency). It doesn't cover all missing dependencies obviously but should
 * fix most of them. This should be removed at some point after site/user
 * scripts have been fixed. Enable this if your wiki has a large amount of
 * user/site scripts that are lacking dependencies.
 * @var bool $wgPreloadJavaScriptMwUtil
 */
$wgPreloadJavaScriptMwUtil = false;

/**
 * Preprocessor caching threshold. Setting it to 'false' will disable
 * the preprocessor cache.
 * @var int $wgPreprocessorCacheThreshold
 */
$wgPreprocessorCacheThreshold = 1000;

/**
 * When calling getLocalURL() or getFullURL() on Title object with non-empty
 * query, URLs are like:
 * for false, no query:    http://a.wikia.com/wiki/Article
 * for false, with query:  http://a.wikia.com/index.php?title=Article&query=1
 * for true, no query:     http://a.wikia.com/wiki/Article
 * for true, with query:   http://a.wikia.com/wiki/Article?query=1
 * @see Title::getLocalURL()
 * @var bool $wgPrettyUrlWithTitleAndQuery
 */
$wgPrettyUrlWithTitleAndQuery = true;

/**
 * These are attributes we don't currently want to store in the attribute
 * service. They're private and are only used by MW for the time being.
 * Eventually these can be moved into the attribute service once we implement
 * some "visibility" of attributes in the service. The logic behind what is a
 * public versus private attribute should be handled in the service. This is a
 * temporary measure until we implement this logic on the service side.
 * @see includes/User.php
 * @var Array $wgPrivateUserAttributes
 */
$wgPrivateUserAttributes = [
	'birthday',
	'disabled-user-email',
	'disabled_date',
	'favoritelisttoken',
	'founderemails-counter',
	'gender',
	'LastAdoptionDate',
	'new_email',
	'realname',
	'registrationCountry',
	'renameData',
	'requested-closure-date',
	'SignUpRedirect',
	'swl_email',
	'swl_last_notify',
	'swl_last_view',
	'swl_last_watch',
	'swl_mail_count',
	'swl_watchlisttoplink',
	'watchlistAccessKey',
	'watchlisttoken',
];

/**
 * If true, print a raw call tree instead of per-function report.
 * @var bool $wgProfileCallTree
 */
$wgProfileCallTree = false;

/**
 * Only record profiling info for pages that took longer than this (in seconds).
 * @var float $wgProfileLimit
 */
$wgProfileLimit = 0.0;

/**
 * Don't put non-profiling info into log file.
 * @var bool $wgProfileOnly
 */
$wgProfileOnly = false;

/**
 * Should application server host be put into profiling table?
 * @var bool $wgProfilePerHost
 */
$wgProfilePerHost = false;

/**
 * Log sums from profiling into "profiling" table in db.
 *
 * You have to create a 'profiling' table in your database before using
 * this feature, see maintenance/archives/patch-profiling.sql
 *
 * @see StartProfiler.php
 * @var bool $wgProfileToDatabase
 */
$wgProfileToDatabase = false;

/**
 * Enable ProtectSiteJS extension.
 * @see extensions/wikia/ProtectSiteJS
 * @var bool $wgEnableProtectSiteJSExt
 */
$wgEnableProtectSiteJSExt = true;

/**
 * Big list of banned IP addresses, in the keys not the values.
 * @var Array $wgProxyList
 */
$wgProxyList = [];

/**
 * Cache for an open proxy list. When set to zero, Memached defaults will be
 * used.
 * @see ProxyTools
 * @var int $wgProxyMemcExpiry
 */
$wgProxyMemcExpiry = 24 * 3600; // 1 day

/**
 * Ports we want to scan for a proxy.
 * @var Array $wgProxyPorts
 */
$wgProxyPorts = [ 80, 81, 1080, 3128, 6588, 8000, 8080, 8888, 65506 ];

/**
 * Proxy whitelist, list of addresses that are assumed to be non-proxy despite
 * what the other methods might say.
 * @var Array $wgProxyWhitelist
 */
$wgProxyWhitelist = [
	'80.58.34.170',
	'81.178.98.202',
	'85.179.130.236',
	'85.195.139.203',
];

/**
 * Public attributes which we want to store and make available via the
 * attributes service. The logic behind what is a public versus private
 * attribute should be handled in the service. This is a temporary measure until
 * we implement this logic on the service side.
 * @see includes/User.php
 * @var Array $wgPublicUserAttributes
 */
$wgPublicUserAttributes = [
	'avatar',
	'avatar_rev',
	'bio',
	'coverPhoto',
	'fancysig',
	'fbPage',
	'discordHandle',
	'location',
	'name',
	'nickname',
	'occupation',
	'twitter',
	'UserProfilePagesV3_birthday',
	'UserProfilePagesV3_gender',
	'website',
	'wordpressId',
];

/**
 * Whether to purge the list of Squids defined in $wgSquidServers using Celery /
 * RabbitMQ or immediately (usually while responding to an HTTP request).
 * @see $wgSquidServers
 * @var bool $wgPurgeSquidViaCelery
 */
$wgPurgeSquidViaCelery = true;

/**
 * Whether to purge Vignette URLs using Celery / Rabbit MQ.
 * @see $wgPurgeSquidViaCelery
 * @var bool $wgPurgeVignetteUsingSurrogateKeys
 */
$wgPurgeVignetteUsingSurrogateKeys = true;

/**
 * Log IP addresses in the recentchanges table; can be accessed only by
 * extensions (e.g. CheckUser) or a DB admin.
 *
 * It was set to true, but we wanted to hide IPs on RecentChanges. Instead of
 * setting this to false, we removed a piece of code from RecentChanges. Quite
 * unfortunate. So I am setting this to false because some day we will bring
 * back the original code.
 *
 * @var bool $wgPutIPinRC
 */
$wgPutIPinRC = true;

/**
 * Qualaroo JS files to serve our user surveys.
 */
$wgQualarooUrl = '//s3.amazonaws.com/ki.js/52510/gQT.js';
$wgQualarooDevUrl = '//s3.amazonaws.com/ki.js/52510/fCN.js';

/**
 * Number of rows to cache in 'querycache' table when miser mode is on.
 * @var int $wgQueryCacheLimit
 */
$wgQueryCacheLimit = 1000;

/**
 * Integer defining default number of entries to show on special pages which are
 * query-pages such as Special:Whatlinkshere.
 * @var int $wgQueryPageDefaultLimit
 */
$wgQueryPageDefaultLimit = 50;

/**
 * Hostname of the datacenter-local Rabbit cluster.
 * @var string $wgRabbitHost
 */
$wgRabbitHost = 'prod.rabbit.service.consul';

/**
 * Port used by the datacenter-local Rabbit cluster.
 * @var string $wgRabbitPort
 */
$wgRabbitPort = 5672;

/**
 * Set to a filename to log rate limiter hits.
 * @var string $wgRateLimitLog
 */
$wgRateLimitLog = null;

/**
 * Simple rate limiter options to brake edit floods.  Maximum number actions
 * allowed in the given number of seconds; after that the violating client re-
 * ceives HTTP 500 error pages until the period elapses. [ 4, 60 ] for a maximum
 * of 4 hits in 60 seconds. This option set is experimental and likely
 * to change. Requires memcached.
 * @var Array $wgRateLimits
 */
$wgRateLimits = [
	'edit' => [
		'newbie' => [ 6, 60 ],
		'ip' => [ 6, 60 ],
		// SUS-4775: apply edit rate limit - 40 edits/min for users, 80 edits/min for bots
		'user' => [ 40, 60 ],
		'bot' => [ 80, 60 ],
	],
	'move' => [
		'newbie' => [ 2, 240 ],
		'user' => [ 2, 240 ],
		// SUS-4775: apply page move rate limit - 20 moves/min for admins, 80 moves/min for bots
		'sysop' => [ 20, 60 ],
		'bot' => [ 80, 60 ],
	],
	'emailuser' => [
		'user' => [ 2, 86400 ],
	],
	'mailpassword' => [
		'ip' => [ 1, 43200 ],
	],
	'changeemail' => [
		'ip' => [ 10, 3600 ],
		'user' => [ 4, 86400 ],
	],
	'share-email' => [
		'user' => [ 10, 3600 ], // 10 emails/hour
	],
];

/**
 * Array of IPs which should be excluded from rate limits. This may be useful
 * for whitelisting NAT gateways for conferences, etc.
 * @var Array $wgRateLimitsExcludedIPs
 */
$wgRateLimitsExcludedIPs = [
	'10.8.44.30',
	'10.8.44.102',
	'10.8.44.103',
	'10.8.44.104',
	'10.8.44.105',
	'10.8.44.106',
	'10.8.44.107',
	'87.204.220.63',
	'217.168.136.164',
	'74.120.190.9',
	'217.168.136.164', // POZO1
	'94.42.104.162', // POZO2
	'91.102.115.110', // POZ03
	'65.19.148.1', // SFO1
	'64.71.157.42', // Transit IP for the x-connect to our provider for the SF office exit point in the SJC DC
];

/**
 * Allow raw, unchecked HTML in <html>...</html> sections. THIS IS VERY
 * DANGEROUS on a publicly editable site, so USE wgGroupPermissions TO RESTRICT
 * EDITING to only those that you trust.
 * @var bool $wgRawHtml
 */
$wgRawHtml = false;

/**
 * Send recent changes updates via UDP. The updates will be formatted for IRC.
 * Set this to the IP address of the receiver.
 * @var string $wgRC2UDPAddress
 */
$wgRC2UDPAddress = 'prod.irc.service.sjc.consul'; // 'irc.wikia-inc.com';

/**
 * Notify external application about contributions via UDP.
 * @see includes/RecentChange.php
 * @see extensions/wikia/ArticleComments
 * @var bool $wgRC2UDPEnabled
 */
$wgRC2UDPEnabled = true;

/**
 * If this is set to true, $wgLocalInterwiki will be prepended to links in the
 * IRC feed. If this is set to a string, that string will be used as the prefix.
 * @var bool $wgRC2UDPInterwikiPrefix
 */
$wgRC2UDPInterwikiPrefix = false;

/**
 * Set to true to omit "bot" edits (by users with the bot permission) from the
 * UDP feed.
 * @var bool $wgRC2UDPOmitBots
 */
$wgRC2UDPOmitBots = false;

/**
 * Port number for RC updates.
 * @var int $wgRC2UDPPort
 */
$wgRC2UDPPort = 9390;

/**
 * Prefix to prepend to each UDP packet. This can be used to identify the wiki.
 * A script is available called mxircecho.py which listens on a UDP port, and
 * uses a prefix ending in a tab to identify the IRC channel to send the log
 * line to.
 * @var string $wgRC2UDPPrefix
 */
$wgRC2UDPPrefix = '';

/**
 * If the difference between the character counts of the text before and after
 * the edit is below that value, the value will be highlighted on the RC page.
 * @var int $wgRCChangedSizeThreshold
 */
$wgRCChangedSizeThreshold = 500;

/**
 * Filter $wgRCLinkDays by $wgRCMaxAge to avoid showing links for numbers
 * higher than what will be stored. Note that this is disabled by default
 * because we sometimes do have RC data which is beyond the limit for some
 * reason, and some users may use the high numbers to display that data which
 * is still there.
 * @var bool $wgRCFilterByAge
 */
$wgRCFilterByAge = false;

/**
 * List of Days options to list in the Special:Recentchanges and
 * Special:Recentchangeslinked pages.
 * @var Array $wgRCLinkDays
 */
$wgRCLinkDays = [ 1, 3, 7, 14, 30 ];

/**
 * List of Limits options to list in the Special:Recentchanges and
 * Special:Recentchangeslinked pages.
 * @var Array $wgRCLinkLimits
 */
$wgRCLinkLimits = [ 50, 100, 250, 500 ];

/**
 * Recentchanges items are periodically purged; entries older than this many
 * seconds will go. Default: 13 weeks = about three months.
 * @var int $wgRCMaxAge
 */
$wgRCMaxAge = 13 * 7 * 24 * 3600;

/**
 * Wikia change: Recentchanges items are periodically purged; keep the number of
 * rows at the stable level.
 * @var int $wgRCMaxRows
 */
$wgRCMaxRows = 20000;

/**
 * Show the amount of changed characters in recent changes.
 * @var bool $wgRCShowChangedSize
 */
$wgRCShowChangedSize = true;

/**
 * Show watching users in recent changes, watchlist and page history views.
 * @var bool $wgRCShowWatchingUsers
 */
$wgRCShowWatchingUsers = false;

/**
 * Set this to a string to put the wiki into read-only mode. The text will be
 * used as an explanation to users. This prevents most write operations. Cache
 * updates may still be possible. To prevent database writes completely, use the
 * read_only option in MySQL.
 * @see includes/WebStart.php
 * @see includes/db/Database.php
 * @global string $wgReadOnly
 */
$wgReadOnly = null;

/**
 * Enable Recommended Video AB Test by passing a RV playlist ID for given wikis.
 * @see extensions/wikia/MercuryApi
 * @see includes/resourceloader/ResourceLoaderStartUpModule.php
 * @var string $wgRecommendedVideoABTestPlaylist
 */
$wgRecommendedVideoABTestPlaylist = '';

/**
 * Set this to specify an external URL containing details about the content
 * license used on your wiki. If $wgRightsPage is set then this setting is
 * ignored.
 * @see includes/Metadata.php
 * @see includes/OutputPage.php
 * @var string $wgRightsUrl
 */
$wgRightsUrl = null;

/**
 * If this lock file exists (size > 0), the wiki will be forced into read-only
 * mode. Its contents will be shown to users as part of the read-only warning
 * message. Will default to "{$wgUploadDirectory}/lock_yBgMBwiR" in Setup.php
 * @var string $wgReadOnlyFile
 */
$wgReadOnlyFile = false;


/**
 * Allow redirection to another page when a user logs in.
 * To enable, set to a string like 'Main Page'
 * @var string $wgRedirectOnLogin
 */
$wgRedirectOnLogin = null;

/**
 * If local interwikis are set up which allow redirects, set this regexp to
 * restrict URLs which will be displayed as 'redirected from' links.
 *
 * It might look something like this:
 * $wgRedirectSources = '!^https?://[a-z-]+\.wikipedia\.org/!';
 *
 * Leave at false to avoid displaying any incoming redirect markers.
 * This does not affect intra-wiki redirects, which don't change the URL.
 * @var string|bool $wgRedirectSources
 */
$wgRedirectSources = false;

/**
 * By default MediaWiki does not register links pointing to same server in
 * externallinks dataset. Use this value to override that behaviour.
 * @var bool $wgRegisterInternalExternals
 */
$wgRegisterInternalExternals = false;

/**
 * Append a configured value to the parser cache and the sitenotice key so
 * that they can be kept separate for some class of activity.
 * @var string $wgRenderHashAppend
 */
$wgRenderHashAppend = '';

/**
 * Base URL for a repository wiki. Leave this blank if uploads are just stored
 * in a shared directory and not meant to be accessible through a separate wiki.
 * Otherwise the image description pages on the local wiki will link to the
 * image description page on this wiki. Please specify the namespace, as in the
 * example below.
 * @var string $wgRepositoryBaseUrl
 */
$wgRepositoryBaseUrl = 'https://commons.wikimedia.org/wiki/File:';

/**
 * Array of usernames which may not be registered or logged in from
 * Maintenance scripts can still use these
 */
$wgReservedUsernames = [
	'MediaWiki default', // Default 'Main Page' and MediaWiki: message pages
	'Conversion script', // Used for the old Wikipedia software upgrade
	'Maintenance script', // Maintenance scripts which perform editing, image import script
	'Template namespace initialisation script', // Used in 1.2->1.3 upgrade
	'ScriptImporter', // Default user name used by maintenance/importSiteScripts.php
	'msg:double-redirect-fixer', // Automatic double redirect fix
	'msg:usermessage-editor', // Default user for leaving user messages
	'msg:proxyblocker', // For Special:Blockme
];

/**
 * The default debug mode (on/off) for of ResourceLoader requests. This will
 * still be overridden when the debug URL parameter is used.
 * @var bool $wgResourceLoaderDebug
 */
$wgResourceLoaderDebug = false;

/**
 * If set to true, asynchronous loading of bottom-queue scripts in the <head>
 * will be enabled. This is an experimental feature that's supposed to make
 * JavaScript load faster.
 * @var bool $wgResourceLoaderExperimentalAsyncLoading
 */
$wgResourceLoaderExperimentalAsyncLoading = false;

/**
 * Maximum time in seconds to cache resources served by the resource loader.
 * @var Array $wgResourceLoaderMaxage
 */
$wgResourceLoaderMaxage = [
	'versioned' => [
		// Squid/Varnish but also any other public proxy cache between the
		// client and MediaWiki
		'server' => 30 * 24 * 3600, // 30 days
		// On the client side (e.g. in the browser cache).
		'client' => 30 * 24 * 3600, // 30 days
	],
	'unversioned' => [
		'server' => 5 * 60, // 5 minutes
		'client' => 5 * 60, // 5 minutes
	],
];

/**
 * If set to a positive number, ResourceLoader will not generate URLs whose
 * query string is more than this many characters long, and will instead use
 * multiple requests with shorter query strings. This degrades performance,
 * but may be needed if your web server has a low (less than, say 1024)
 * query string length limit or a low value for suhosin.get.max_value_length
 * that you can't increase. If set to a negative number, ResourceLoader will
 * assume there is no query string length limit.
 * @var int $wgResourceLoaderMaxQueryLength
 */
$wgResourceLoaderMaxQueryLength = -1;

/**
 * Maximum line length when minifying JavaScript. This is not a hard maximum:
 * the minifier will try not to produce lines longer than this, but may be
 * forced to do so in certain cases.
 * @var int $wgResourceLoaderMinifierMaxLineLength
 */
$wgResourceLoaderMinifierMaxLineLength = 1000;

/**
 * Put each statement on its own line when minifying JavaScript. This makes
 * debugging in non-debug mode a bit easier.
 * @var bool $wgResourceLoaderMinifierStatementsOnOwnLine
 */
$wgResourceLoaderMinifierStatementsOnOwnLine = false;

/**
 * Extensions should register foreign module sources here. 'local' is a
 * built-in source that is not in this array, but defined by
 * ResourceLoader::__construct() so that it cannot be unset.
 *
 * Example:
 *   $wgResourceLoaderSources['foo'] = [
 *       'loadScript' => 'http://example.org/w/load.php',
 *       'apiScript' => 'http://example.org/w/api.php'
 *   ];
 * @var Array $wgResourceLoaderSources
 */
$wgResourceLoaderSources = [];

/**
 * Enable embedding of certain resources using Edge Side Includes. This will
 * improve performance but only works if there is something in front of the
 * web server (e..g a Squid or Varnish server) configured to process the ESI.
 * @var bool $wgResourceLoaderUseESI
 */
$wgResourceLoaderUseESI = false;

/**
 * If set to true, JavaScript modules loaded from wiki pages will be parsed
 * prior to minification to validate it. Parse errors will result in a JS
 * exception being thrown during module load, which avoids breaking other
 * modules loaded in the same request.
 * @var bool $wgResourceLoaderValidateJS
 */
$wgResourceLoaderValidateJS = true;

/**
 * If set to true, statically-sourced (file-backed) JavaScript resources will
 * be parsed for validity before being bundled up into ResourceLoader modules.
 * This can be helpful for development by providing better error messages in
 * default (non-debug) mode, but JavaScript parsing is slow and memory hungry
 * and may fail on large pre-bundled frameworks.
 * @var bool $wgResourceLoaderValidateStaticJS
 */
$wgResourceLoaderValidateStaticJS = false;

/**
 * Client-side resource modules. Extensions should add their module definitions
 * here.
 *
 * Example:
 *   $wgResourceModules['ext.myExtension'] = [
 *      'scripts' => 'myExtension.js',
 *      'styles' => 'myExtension.css',
 *      'dependencies' => array( 'jquery.cookie', 'jquery.tabIndex' ),
 *      'localBasePath' => dirname( __FILE__ ),
 *      'remoteExtPath' => 'MyExtension',
 *   ];
 * @var Array $wgResourceModules
 */
$wgResourceModules = [];

/**
 * For consistency, restrict DISPLAYTITLE to titles that normalize to the same
 * canonical DB key.
 * @var bool $wgRestrictDisplayTitle
 */
$wgRestrictDisplayTitle = false;

/**
 * Rights which can be required for each protection level (via action=protect)
 *
 * You can add a new protection level that requires a specific
 * permission by manipulating this array. The ordering of elements
 * dictates the order on the protection form's lists.
 *
 *   - '' will be ignored (i.e. unprotected)
 *   - 'sysop' is quietly rewritten to 'protect' for backwards compatibility
 * @var Array $wgRestrictionLevels
 */
$wgRestrictionLevels = [ '', 'autoconfirmed', 'sysop' ];

/**
 * Set of available actions that can be restricted via action=protect
 * You probably shouldn't change this.
 * Translated through restriction-* messages.
 * Title::getRestrictionTypes() will remove restrictions that are not
 * applicable to a specific title (create and upload)
 * @var Array $wgRestrictionTypes
 */
$wgRestrictionTypes = [ 'create', 'edit', 'move', 'upload' ];

/**
 * Revision text may be cached in $wgMemc to reduce load on external storage
 * servers and object extraction overhead for frequently-loaded revisions. Set
 * to 0 to disable, or number of seconds before cache expiry.
 * @var int $wgRevisionCacheExpiry
 */
$wgRevisionCacheExpiry = 30 * 24 * 3600; // 30 days

/**
 * Override for copyright metadata.
 *
 * This is the name of the page containing information about the wiki's
 * copyright status, which will be added as a link in the footer if it is
 * specified. It overrides $wgRightsUrl if both are specified.
 * @see $wgRightsUrl
 * @var string $wgRightsPage
 */
$wgRightsPage = null;

/**
 * If either $wgRightsUrl or $wgRightsPage is specified then this variable gives
 * the text for the link. If using $wgRightsUrl then this value must be
 * specified. If using $wgRightsPage then the name of the page will also be used
 * as the link if this variable is not set.
 * @see $wgRightsUrl
 * @see $wgRightsPage
 * @var string $wgRightsText
 */
$wgRightsText = 'CC-BY-SA';

/**
 * Whether or not to block wiki in robots.txt.
 * @see extensions/wikia/RobotsTxt
 * @var bool $wgRobotsTxtBlockedWikis
 */
$wgRobotsTxtBlockedWiki = false;

/**
 * The URL path to index.php.
 *
 * Will default to "{$wgScriptPath}/index{$wgScriptExtension}" in Setup.php
 * @see app/includes/Setup.php
 * @var string|bool $wgScript
 */
$wgScript = false;

/**
 * The extension to append to script names by default. This can either be .php
 * or .php5.
 *
 * Some hosting providers use PHP 4 for *.php files, and PHP 5 for *.php5. This
 * variable is provided to support those providers.
 * @var string $wgScriptExtension
 */
$wgScriptExtension  = '.php';

/**
 * The base URL path. It might be a virtual path in case with use Apache
 * mod_rewrite for example. This *needs* to be set correctly. Other paths will
 * be set to defaults based on it unless they are directly set.
 * @var string $wgScriptPath
 */
$wgScriptPath = '';

/**
 * If set to true the 'searcheverything' preference will be effective only for
 * logged-in users. Useful for big wikis to maintain different search profiles
 * for anonymous and logged-in users.
 * @var bool $wgSearchEverythingOnlyLoggedIn
 */
$wgSearchEverythingOnlyLoggedIn = false;

/**
 * Set this to a URL to forward search requests to some external location.
 * If the URL includes '$1', this will be replaced with the URL-encoded
 * search term.
 *
 * For example, to forward to Google you'd have something like:
 * $wgSearchForwardUrl = 'http://www.google.com/search?q=$1' .
 *                       '&domains=http://example.com' .
 *                       '&sitesearch=http://example.com' .
 *                       '&ie=utf-8&oe=utf-8';
 * @var string $wgSearchForwardUrl
 */
$wgSearchForwardUrl = null;

/**
 * Regexp to match word boundaries, defaults for non-CJK languages
 * should be empty for CJK since the words are not separate.
 * @var string $wgSearchHighlightBoundaries
 */
$wgSearchHighlightBoundaries = '[\p{Z}\p{P}\p{C}]';

/**
 * Expiry time for search suggestion responses. When zero, Memcached defaults
 * will be used.
 * @var int $wgSearchSuggestCacheExpiry
 */
$wgSearchSuggestCacheExpiry = 20 * 60; // 20 minutes

/**
 * Search type. Leave as null to select the default search engine for the
 * selected database type (eg SearchMySQL), or set to a class name to override
 * to a custom search engine.
 * @var string $wgSearchType
 */
$wgSearchType = null;

/**
 * This should always be customised in LocalSettings.php.
 * @var string|bool $wgSecretKey
 */
$wgSecretKey = false;

/**
 * This is to let user authenticate using https when they come from http.
 * Based on an idea by George Herbert on wikitech-l:
 * http://lists.wikimedia.org/pipermail/wikitech-l/2010-October/050065.html
 * @since 1.17
 * @var bool $wgSecureLogin
 */
$wgSecureLogin = false;

/**
 * Configuration setting for core MediaWiki tests.
 * @var string $wgSeleniumConfigFile
 */
$wgSeleniumConfigFile = null;

/**
 * Per test suite configurations used by core MediaWiki tests.
 * @var Array $wgSeleniumTestConfigs
 */
$wgSeleniumTestConfigs = [];

/**
 * Some web hosts attempt to rewrite all responses with a 404 (not found)
 * status code, mangling or hiding MediaWiki's output. If you are using such a
 * host, you should start looking for a better one. While you're doing that,
 * set this to false to convert some of MediaWiki's 404 responses to 200 so
 * that the generated error pages can be seen.
 *
 * In cases where for technical reasons it is more important for MediaWiki to
 * send the correct status code than for the body to be transmitted intact,
 * this configuration variable is ignored.
 * @var bool $wgSend404Code
 */
$wgSend404Code = true;

/**
 * This is used for setting php's session.save_handler. In practice, you will
 * almost never need to change this ever. Other options might be 'user' or
 * 'session_mysql.' Setting to null skips setting this entirely (which might be
 * useful if you're doing cross-application sessions).
 * @var string $wgSessionHandler
 */
$wgSessionHandler = null;

/**
 * Memcached servers for session data.
 * @see includes/cache/MemcachedSessions.php
 * @see $wgMemCachedServers
 * @var Array $wgSessionMemCachedServers
 */
$wgSessionMemCachedServers = [
	0 => 'prod.twemproxy.service.consul:31001',
	1 => 'prod.twemproxy.service.consul:21001',
];

/**
 * Override to customise the session name.
 * @var string|bool $wgSessionName
 */
$wgSessionName = false;

/**
 * Store sessions in MemCached. This can be useful to improve performance, or to
 * avoid the locking behaviour of PHP's default session handler, which tends to
 * prevent multiple requests for the same user from acting concurrently.
 * @var bool $wgSessionsInMemcached
 */
$wgSessionsInMemcached = true;

/**
 * Shared database for multiple wikis. Commonly used for storing a user table
 * for single sign-on. The server for this database must be the same as for the
 * main database. For backwards compatibility the shared prefix is set to the
 * same as the local prefix, and the user table is listed in the default list of
 * shared tables. The user_properties table is also added so that users will
 * continue to have their preferences shared (preferences were stored in the
 * user table prior to 1.16). $wgSharedTables may be customized with a list of
 * tables to share in the shared database. However it is advised to limit what
 * tables you do share as many of MediaWiki's tables may have side effects if
 * you try to share them. EXPERIMENTAL! $wgSharedPrefix is the table prefix for
 * the shared database. It defaults to $wgDBprefix.
 * @var string $wgSharedDB
 */
$wgSharedDB = null;

/**
 * Prefix for Memcached keys shared between wikis.
 * @see extensions/wikia/Staging/Staging.setup.php
 * @see wfSharedMemcKey()
 * @var string $wgSharedKeyPrefix
 */
$wgSharedKeyPrefix = 'wikicities';

/**
 * Table prefix for the shared database.
 * @see $wgSharedDB
 * @see $wgDBprefix
 * @var string|bool $wgSharedPrefix
 */
$wgSharedPrefix = false;

/**
 * List of tables to share in the shared.
 *
 * @see $wgSharedDB
 * @var Array $wgSharedTables
 */
$wgSharedTables = [ 'user', 'user_properties' ];


/**
 * DB name with metadata about shared directory. Set this to false if the
 * uploads do not come from a wiki.
 * @var string|bool $wgSharedUploadDBname
 */
$wgSharedUploadDBname = false;

/**
 * Optional table prefix used in database.
 * @var string $wgSharedUploadDBprefix
 */
$wgSharedUploadDBprefix = '';

/**
 * Path on the file system where shared uploads can be found.
 * @var string $wgSharedUploadDirectory
 */
$wgSharedUploadDirectory = null;

/**
 * Full path on the web server where shared uploads can be found.
 * @var string $wgSharedUploadPath
 */
$wgSharedUploadPath = null;

/**
 * Locale for LC_CTYPE, to work around http://bugs.php.net/bug.php?id=45132
 * For Unix-like operating systems, set this to to a locale that has a UTF-8
 * character set. Only the character set is relevant.
 * @var string $wgShellLocale
 */
$wgShellLocale = 'en_US.utf8';
// CONFIG_REVISION: consider backporting wfInitShellLocale() from core MediaWiki

/**
 * Despite the catchy name, it's not what you think it is.
 * @see AnalyticsEngine
 * @see AdEngine3Service::areAdsShowableOnPage()
 * @var bool $wgShowAds
 */
$wgShowAds = true;

/**
 * Show thumbnails for old images on the image description page.
 * @var bool $wgShowArchiveThumbnails
 */
$wgShowArchiveThumbnails = true;

/**
 * If there are more than $wgMaxCredits authors, show $wgMaxCredits of them.
 * Otherwise, link to a separate credits page.
 * @see $wgMaxCredits
 * @var bool $wgShowCreditsIfMax
 */
$wgShowCreditsIfMax = true;

/**
 * If true, show a backtrace for database errors.
 * @var bool $wgShowDBErrorBacktrace
 */
$wgShowDBErrorBacktrace = false;

/**
 * Display debug data at the bottom of the main content area. Useful for
 * developers and technical users trying to working on a closed wiki.
 * @var bool $wgShowDebug
 */
$wgShowDebug = false;

/**
 * If set to true, uncaught exceptions will print a complete stack trace
 * to output. This should only be used for debugging, as it may reveal
 * private information in function parameters due to PHP's backtrace
 * formatting.
 * @see includes/Exception.php
 * @global bool $wgShowExceptionDetails
 */
$wgShowExceptionDetails = false;

/**
 * Expose backend server host names through the API and various HTML comments.
 * @var bool $wgShowHostnames
 */
$wgShowHostnames = true;

/**
 * Show IP address, for non-logged in users. It's necessary to switch this off
 * for some forms of caching. Will disable file cache.
 * @var bool $wgShowIPinHeader
 */
$wgShowIPinHeader = true;

/**
 * Whether to show "we're sorry, but there has been a database error" pages.
 * Displaying errors aids in debugging, but may display information useful
 * to an attacker.
 * @var bool $wgShowSQLErrors
 */
$wgShowSQLErrors = false;

/**
 * Show "Updated (since my last visit)" marker in RC view, watchlist and history
 * view for watched pages with new changes.
 * @var bool $wgShowUpdatedMarker
 */
$wgShowUpdatedMarker = true;

/**
 * Expiry time for the sidebar cache, in seconds.
 * @var int $wgSidebarCacheExpiry
 */
$wgSidebarCacheExpiry = 24 * 3600;

/**
 * Array of namespaces to generate a Google sitemap for when the
 * maintenance/generateSitemap.php script is run, or false if one is to be ge-
 * nerated for all namespaces.
 * @var Array|bool $wgSitemapNamespaces
 */
$wgSitemapNamespaces = false;

/**
 * Custom namespace priorities for sitemaps. Setting this will allow you to
 * set custom priorities to namsepaces when sitemaps are generated using the
 * maintenance/generateSitemap.php script.
 *
 * This should be a map of namespace IDs to priority
 * Example:
 *  $wgSitemapNamespacesPriorities = array(
 *      NS_USER => '0.9',
 *      NS_HELP => '0.0',
 *  );
 * @var Array|bool $wgSitemapNamespacesPriorities
 */
$wgSitemapNamespacesPriorities = false;

/**
 * Point robots to XML sitemap in robots.txt.
 * @see extensions/wikia/RobotsTxt/classes/WikiaRobots.class.php
 * @see extensions/wikia/Sitemap/SpecialSitemap_body.php
 * @var $wgSitemapXmlExposeInRobots
 */
$wgSitemapXmlExposeInRobots = true;

/**
 * Title of the current wiki. This is an initial value. It is updated
 * by WikiFactory.
 * @var string $wgSitename
 */
$wgSitename = 'MediaWiki';

/**
 * Site notice shown at the top of each page. MediaWiki:Sitenotice page,
 * which will override this. You can also provide a separate message for
 * logged-out users using the MediaWiki:Anonnotice page.
 * @var string $wgSiteNotice
 */
$wgSiteNotice = '';

/**
 * Set this to an integer to only do synchronous site_stats updates one every
 * *this many* updates. The other requests go into pending delta values in
 * $wgMemc. Make sure that $wgMemc is a global cache. If set to -1, updates
 * *only* go to $wgMemc (useful for daemons).
 * @var int $wgSiteStatsAsyncFactor
 */
$wgSiteStatsAsyncFactor = 1;

/**
 * Titles and categories to skip on category counter update.
 * @see Article::updateCategoryCounts()
 * @var Array $wgSkipCountForCategories
 */
$wgSkipCountForCategories = [];

/**
 * If slave DB lag is higher than this number of seconds, show an OBVIOUS
 * warning on some special pages.
 * @see $wgSlaveLagWarning
 * @var int $wgSlaveLagCritical
 */
$wgSlaveLagCritical = 30;

/**
 * If lag is higher than this number of seconds, show a warning in some special
 * pages (like watchlist).
 * @see $wgSlaveLagCritical
 * @var int $wgSlaveLagWarning
 */
$wgSlaveLagWarning = 10;

/**
 * Port for Solr.
 * @see extensions/wikia/Search
 * @see extensions/3rdparty/LyricWiki
 * @see $wgSolrPort
 * @var int $wgSolrDefaultPort
 */
$wgSolrDefaultPort = 8983;

/**
 * Port for Solr.
 * @see extensions/wikia/Search
 * @see extensions/wikia/VideoHandlers
 * @see $wgSolrDefaultPort
 * @var int $wgSolrDefaultPort
 */
$wgSolrPort = 8983;

/**
 * @deprecated since 1.17 Use $wgDnsBlacklistUrls instead, only kept for
 * backward compatibility.
 * @see User
 * @var Array $wgSorbsUrl
 */
$wgSorbsUrl = [];

/**
 * Whether or not to sort special pages in Special:Specialpages.
 * @var bool $wgSortSpecialPages
 */
$wgSortSpecialPages = true;

/**
 * SMTP configuration for WikiaMailer.
 * @see includes/wikia/WikiaMailer.php
 * @var Array $wgSMTP
 */
$wgSMTP = [
	'host'   => 'prod.smtp.service.consul',
	'port'   => 25,
	'auth'   => false,
	'IDHost' => ''
];

/**
 * Solr host for Search and ArticleService.
 * @see services/ArticleService.class.php
 * @see extensions/wikia/Search
 * @var string $wgSolrHost
 */
$wgSolrHost = 'prod.search-fulltext.service.consul';


/**
 * Solr host for key-value storage for ArticleService.
 * @see includes/wikia/services/ArticleService.class.php
 * @var string $wgSolrKvHost
 */
$wgSolrKvHost = 'prod.search-kv.service.consul';


/**
 * Master Solr server used by multiple components.
 * @see includes/wikia/services/tests/ArticleServiceTest.php
 * @see extensions/3rdparty/LyricWiki
 * @see extensions/wikia/Search
 * @see extensions/wikia/VideoHandlers
 * @var string $wgSolrMaster
 */
$wgSolrMaster = 'prod.search-master.service.sjc.consul';

/**
 * The list of bad URLs for SpamBlacklist
 * @see extensions/SpamBlacklist
 * @var Array $wgSpamBlacklistFiles
 */
$wgSpamBlacklistFiles = [];

/**
 * Edits matching these regular expressions in body text will be recognised as
 * spam and rejected automatically. There's no administrator override on-wiki,
 * so be careful what you set. :) May be an array of regexes or a single string
 * for backwards compatibility.
 * @var Array|string $wgSpamRegex
 */
$wgSpamRegex = [];

/**
 * User support email used in Special:Contact.
 * @see extensions/wikia/SpecialContact2
 * @var string $wgSpecialContactEmail
 */
$wgSpecialContactEmail = 'support@wikia.zendesk.com';

/**
 * Additional functions to be performed with updateSpecialPages.
 * Expensive Querypages are already updated.
 * @see PLATFORM-2275
 * @var Array $wgSpecialPageCacheUpdates
 */
$wgSpecialPageCacheUpdates = [
	'SiteStatsRegenerate' => [ 'SiteStatsInit', 'doAllAndCommit' ],
	'Statistics'          => [ 'SiteStatsUpdate', 'cacheUpdate' ],
];

/**
 * List of special pages, followed by what subtitle they should go under
 * at Special:SpecialPages. Extensions should add their special pages in their
 * setup files.
 * @var Array $wgSpecialPageGroups
 */
$wgSpecialPageGroups = [
	'DoubleRedirects'           => 'maintenance',
	'BrokenRedirects'           => 'maintenance',
	'Lonelypages'               => 'maintenance',
	'Uncategorizedpages'        => 'maintenance',
	'Uncategorizedcategories'   => 'maintenance',
	'Uncategorizedimages'       => 'maintenance',
	'Uncategorizedtemplates'    => 'maintenance',
	'Unusedcategories'          => 'maintenance',
	'Unusedimages'              => 'maintenance',
	'Protectedpages'            => 'maintenance',
	'Protectedtitles'           => 'maintenance',
	'Unusedtemplates'           => 'maintenance',
	'Withoutinterwiki'          => 'maintenance',
	'Longpages'                 => 'maintenance',
	'Shortpages'                => 'maintenance',
	'Ancientpages'              => 'maintenance',
	'Deadendpages'              => 'maintenance',
	'Wantedpages'               => 'maintenance',
	'Wantedcategories'          => 'maintenance',
	'Wantedfiles'               => 'maintenance',
	'Wantedtemplates'           => 'maintenance',
	'Unwatchedpages'            => 'maintenance',
	'Fewestrevisions'           => 'maintenance',

	'Userlogin'                 => 'login',
	'Userlogout'                => 'login',
	'CreateAccount'             => 'login',

	'Recentchanges'             => 'changes',
	'Recentchangeslinked'       => 'changes',
	'Watchlist'                 => 'changes',
	'Newimages'                 => 'changes',
	'Newpages'                  => 'changes',
	'Log'                       => 'changes',
	'Tags'                      => 'changes',

	'Upload'                    => 'media',
	'Listfiles'                 => 'media',
	'MIMEsearch'                => 'media',
	'FileDuplicateSearch'       => 'media',
	'Filepath'                  => 'media',

	'Listusers'                 => 'users',
	'Activeusers'               => 'users',
	'Listgrouprights'           => 'users',
	'BlockList'                 => 'users',
	'Contributions'             => 'users',
	'Emailuser'                 => 'users',
	'Listadmins'                => 'users',
	'Listbots'                  => 'users',
	'Userrights'                => 'users',
	'Block'                     => 'users',
	'Unblock'                   => 'users',
	'Preferences'               => 'users',
	'ChangeEmail'               => 'users',
	'ChangePassword'            => 'users',
	'DeletedContributions'      => 'users',
	'PasswordReset'             => 'users',

	'Mostlinked'                => 'highuse',
	'Mostlinkedcategories'      => 'highuse',
	'Mostlinkedtemplates'       => 'highuse',
	'Mostcategories'            => 'highuse',
	'Mostimages'                => 'highuse',
	'Mostrevisions'             => 'highuse',

	'Allpages'                  => 'pages',
	'Prefixindex'               => 'pages',
	'Listredirects'             => 'pages',
	'Categories'                => 'pages',
	'Disambiguations'           => 'pages',

	'Randompage'                => 'redirects',
	'Randomredirect'            => 'redirects',
	'Mypage'                    => 'redirects',
	'Mytalk'                    => 'redirects',
	'Mycontributions'           => 'redirects',
	'Search'                    => 'redirects',
	'LinkSearch'                => 'redirects',

	'ComparePages'              => 'pagetools',
	'Movepage'                  => 'pagetools',
	'MergeHistory'              => 'pagetools',
	'Revisiondelete'            => 'pagetools',
	'Undelete'                  => 'pagetools',
	'Export'                    => 'pagetools',
	'Import'                    => 'pagetools',
	'Whatlinkshere'             => 'pagetools',

	'Statistics'                => 'wiki',
	'Version'                   => 'wiki',
	'Lockdb'                    => 'wiki',
	'Unlockdb'                  => 'wiki',
	'Allmessages'               => 'wiki',
	'Popularpages'              => 'wiki',

	'Specialpages'              => 'other',
	'Blockme'                   => 'other',
	'Booksources'               => 'other',
	'JavaScriptTest'            => 'other',
];

/**
 * Special page list.
 * @see SpecialPage.php
 * @var Array $wgSpecialPages
 */
$wgSpecialPages = [];

/**
 * Show the contents of $wgHooks in Special:Version.
 * @var bool $wgSpecialVersionShowHooks
 */
$wgSpecialVersionShowHooks = false;

/**
 * To override default SQLite data directory ($docroot/../data).
 * @var string $wgSQLiteDataDir
 */
$wgSQLiteDataDir = '';

/**
 * SQL Mode - default is turning off all modes, including strict, if set.
 * null can be used to skip the setting for performance reasons and assume
 * DBA has done his best job. String override can be used for some additional
 * fun :-)
 * @var string $wgSQLMode
 */
$wgSQLMode = null;

/**
 * Cache timeout for the squid, will be sent as s-maxage (without ESI) or
 * Surrogate-Control (with ESI). Without ESI, you should strip out s-maxage in
 * the Squid config. 18000 seconds = 5 hours, more cache hits with 2678400 = 31
 * days
 */
$wgSquidMaxage = 24 * 3600;  // 1 day

/**
 * List of proxy servers to purge on changes; default port is 80. Use IP
 * addresses. When MediaWiki is running behind a proxy, it will trust
 * X-Forwarded-For headers sent/modified from these proxies when obtaining the
 * remote IP address.
 * @see $wgSquidServersNoPurge
 * @var Array $wgSquidServers
 */
$wgSquidServers = [];

/**
 * List of servers that aren't purged on page changes; use to set a
 * list of trusted proxies, etc. When MediaWiki is running behind a proxy, it
 * will trust X-Forwarded-For headers sent/modified from these proxies when
 * obtaining the remote IP address.
 * @see $wgSquidServers
 * @var Array $wgSquidServersNoPurge
 */
$wgSquidServersNoPurge = [
	'10.12.0.0/16', # RES LAN
	'10.14.0.0/16', # POZ LAN
	'10.8.0.0/16', # SJC LAN
	'23.235.32.0/20', # Fastly network
	'38.127.199.0/24', # Wikia network
	'43.249.72.0/22', # Fastly network
	'65.19.148.0/24', # Wikia network
	'74.120.184.0/21', # Wikia network
	'91.102.115.96/28', # Wikia network
	'103.244.50.0/24', # Fastly network
	'103.245.222.0/23', # Fastly network
	'103.245.224.0/24', # Fastly network
	'104.156.80.0/20', # Fastly network
	'127.1.0.0/16', # loopback
	'157.52.64.0/18', # Fastly network
	'172.111.64.0/18', # Fastly network
	'185.31.16.0/22', # Fastly network
	'199.27.72.0/21', # Fastly network
	'202.21.128.0/24', # Fastly network
	'203.57.145.0/24', # Fastly network
];

/**
 * Used for StaffWelcomePoster which creates a post upon community migration to
 * Discussions.
 * @see extensions/wikia/Discussions/maintenance/StaffWelcomePoster.class.php
 * @var Array $wgStaffWelcomePostLanguageToUserId
 */
$wgStaffWelcomePostLanguageToUserId = [
	'de' => 26339491, // Mira Laime
	'en' => 26339491, // Mira Laime
	'es' => 12648798, // Luchofigo85
	'fr' => 26442523, // Hypsoline
	'it' => 3279487, // Leviathan_89
	'ja' => 29395778, // Kuro0222
	'ko' => 24883131, // Miri-Nae
	'nl' => 4142476, // Yatalu
	'pl' => 1117661, // Nanaki
	'pt' => 5653518, // Ultragustavo25
	'ru' => 1121346, // Kuzura
	'vi' => 26041741, // KhangND
	'zh-hans' => 11909873, // Cal-Boy
	'zh-hant' => 56584     // Ffaarr
];

/**
 * Indicate a staging environment.
 * @see extensions/wikia/Staging/StagingHooks.class.php
 * @var bool $wgStagingEnvironment
 */
$wgStagingEnvironment = false;

/**
 * Destination for wfIncrStats() data...
 * 'cache' to go into the system cache, if enabled (memcached)
 * 'udp' to be sent to the UDP profiler (see $wgUDPProfilerHost)
 * false to disable
 * @var string|bool $wgStatsMethod
 */
$wgStatsMethod = false;

/**
 * If this is turned off, users may override the warning for files not covered
 * by $wgFileExtensions. WARNING: setting this to false is insecure for public
 * wikis.
 * @var bool $wgStrictFileExtensions
 */
$wgStrictFileExtensions = true;

/**
 * Filesystem stylesheets directory. Will default to "{$IP}/skins" in Setup.php.
 * @see app/includes/Setup.php
 * @var string|bool $wgStyleDirectory
 */
$wgStyleDirectory = false;

/**
 * Edit summaries matching these regular expressions in body text will be
 * recognised as spam and rejected automatically. There's no administrator
 * override on-wiki, so be careful what you set. :) May be an array of regexes
 * or a single string for backwards compatibility.
 * @var Array|string $wgSummarySpamRegex
 */
$wgSummarySpamRegex = [];

/**
 * Languages to actively link to Special:CloseMyAccount in Special:Contact.
 * @see extensions/wikia/SpecialContact2
 * @see $wgEnableCloseMyAccountExt
 * @var Array $wgSupportedCloseMyAccountLang
 */
$wgSupportedCloseMyAccountLang = [ 'de', 'en', 'es', 'fr', 'it', 'ja', 'pl',
	'pt', 'pt-br', 'ru', 'zh', 'zh-classical', 'zh-cn', 'zh-hans', 'zh-hant',
	'zh-hk', 'zh-min-nan', 'zh-mo', 'zh-my', 'zh-sg', 'zh-tw', 'zh-yue',
];

/**
 * Pick a converter defined in $wgSVGConverters.
 * @see $wgSVGConverters
 * @var string $wgSVGConverter
 */
$wgSVGConverter = 'rsvg';

/**
 * If not in the executable PATH, specify the SVG converter path.
 * @var string $wgSVGConverterPath
 */
$wgSVGConverterPath = '';

/**
 * Scalable Vector Graphics (SVG) may be uploaded as images. Since SVG support
 * is not yet standard in browsers, it is necessary to rasterize SVGs to PNG as
 * a fallback format. An external program is required to perform this
 * conversion. If set to an array, the first item is a PHP callable and any
 * further items are passed as parameters after $srcPath, $dstPath, $width,
 * $height.
 * @see $wgSVGConverter
 * @var Array $wgSVGConverters
 */
$wgSVGConverters = [
	'batik' => 'java -Djava.awt.headless=true -jar $path/batik-rasterizer.jar -w $width -d $output $input',
	'ImageMagick' => '$path/convert -background white -thumbnail $widthx$height\! $input PNG:$output',
	'ImagickExt' =>  [ 'SvgHandler::rasterizeImagickExt' ],
	'imgserv' => '$path/imgserv-wrapper -i svg -o png -w$width $input $output',
	'inkscape' => '$path/inkscape -z -w $width -f $input -e $output',
	'rsvg' => '$path/rsvg -w$width -h$height $input $output',
	'sodipodi' => '$path/sodipodi -z -w $width -f $input -e $output',
];

/**
 * Don't scale a SVG larger than this number of pixels.
 * @var int $wgSVGMaxSize
 */
$wgSVGMaxSize = 2048;

/**
 * Don't read SVG metadata beyond this point.
 * @var int $wgSVGMetadataCutoff
 */
$wgSVGMetadataCutoff = 262144; // 256 KiB

/**
 * Languages supported in SiteWideMessages extension.
 * @see /extensions/wikia/SiteWideMessages
 * @see $wgEnableSiteWideMessages
 * @var Array  $wgSWMSupportedLanguages
 */
$wgSWMSupportedLanguages = [ 'en', 'de', 'es', 'fr', 'it', 'pl', 'ja', 'nl', 'pt', 'ru', 'zh' ];

/**
 * Allow sysops to ban users from accessing Emailuser.
 * @var bool $wgSysopEmailBans
 */
$wgSysopEmailBans = true;

/**
 * Templates excluded from the "most included" list, used by WYSIWYG editor.
 * @see /includes/wikia/services/TemplateService.class.php
 * @var Array $wgTemplateExcludeList
 */
$wgTemplateExcludeList = [ '!' ];

/**
 * Adjust thumbnails on image pages according to a user setting. In order to
 * reduce disk usage, the values can only be selected from a list. This is the
 * list of settings the user can choose from:
 * @var Array $wgThumbLimits
 */
$wgThumbLimits = [ 120,150, 180, 200, 250, 300 ];

/**
 * If rendered thumbnail files are older than this timestamp, they will be
 * rerendered on demand as if the file didn't already exist. Update if there is
 * some need to force thumbs and SVG rasterizations to rerender, such as fixes
 * to rendering bugs.
 * @var string $wgThumbnailEpoch
 */
$wgThumbnailEpoch = '20030516000000';

/**
 * Adjust width of upright images when parameter 'upright' is used. This allows
 * a nicer look for upright images without the need to fix the width by
 * hardcoded px in wiki sourcecode.
 * @var float $wgThumbUpright
 */
$wgThumbUpright = 0.75;

/**
 * Path of the Tidy binary.
 * @see $wgUseTidy
 * @var string $wgTidyBin
 */
$wgTidyBin = 'tidy';

/**
 * When Tidy is used to make sure HTML output is sane, $wgTidyOpts can include
 * any number of parameters to modify Tidy's default behaviour.
 * @see $wgUseTidy
 * @var string $wgTidyOpts
 */
$wgTidyOpts = '';

/**
 * Browsers don't support TIFF inline generally. For inline display, we need to
 * convert to PNG or JPEG. Note scaling should work with ImageMagick, but may
 * not with GD scaling.
 *
 * @example $wgTiffThumbnailType = [ 'png', 'image/png' ];
 * @example $wgTiffThumbnailType = [ 'jpg', 'image/jpeg' ];
 * @var Array|bool $wgTiffThumbnailType
 */
$wgTiffThumbnailType = false;

/**
 * The local filesystem path to a temporary directory. This is not required to
 * be web accessible. Will default to "{$wgUploadDirectory}/tmp" in Setup.php
 * @see Setup.php
 * @see $wgUploadDirectory
 * @var string|bool $wgTmpDirectory
 *
 */
$wgTmpDirectory = '/tmp';

/**
 * Used in Parser::fetchScaryTemplateMaybeFromCache().
 * @see Parser
 * @var int $wgTranscludeCacheExpiry
 */
$wgTranscludeCacheExpiry = 3600; // in seconds

/**
 * For Hindi and Arabic use local numerals instead of Western style (0-9)
 * numerals in interface.
 * @var bool $wgTranslateNumerals
 */
$wgTranslateNumerals = true;

/**
 * Switch for trivial mime detection. Used by thumb.php to disable all fancy
 * things, because only a few types of images are needed and file extensions
 * can be trusted.
 * @var bool $wgTrivialMimeDetection
 */
$wgTrivialMimeDetection = false;

/**
 * Twitter account to use by TwitterCards extension.
 * @see extensions/wikia/TwitterCards
 * @var string $wgTwitterAccount
 */
$wgTwitterAccount = '@getfandom';

/**
 * Host for UDP profiler. The host should be running a daemon which can be
 * obtained from MediaWiki Subversion.
 * @see http://svn.wikimedia.org/svnroot/mediawiki/trunk/udpprofile
 * @var string $wgUDPProfilerHost
 */
$wgUDPProfilerHost = '127.0.0.1';

/**
 * Port for UDP profiler.
 * @see $wgUDPProfilerHost
 * @var string $wgUDPProfilerPort
 */
$wgUDPProfilerPort = '3811';

/**
 * Enable the UniversalEditButton for browsers that support it (currently only
 * Firefox with an extension). See http://universaleditbutton.org for more
 * background information.
 * @var bool $wgUniversalEditButton
 */
$wgUniversalEditButton = true;

/**
 * If to automatically update the img_metadata field if the metadata field is
 * outdated but compatible with the current version. Defaults to false.
 * @var bool $wgUpdateCompatibleMetadata
 */
$wgUpdateCompatibleMetadata = false;

/**
 * Number of rows to update per job (for a core MediaWiki job queue).
 * @var int $wgUpdateRowsPerJob
 */
$wgUpdateRowsPerJob = 500;

/**
 * Number of rows to update per query (for a core MediaWiki job queue).
 * @var int $wgUpdateRowsPerQuery
 */
$wgUpdateRowsPerQuery = 100;

/**
 * When you run the web-based upgrade utility, it will tell you what to set
 * this to in order to authorize the upgrade process. It will subsequently be
 * used as a password, to authorize further upgrades.
 *
 * For security, do not set this to a guessable string. Use the value supplied
 * by the install/upgrade process. To cause the upgrader to generate a new key,
 * delete the old key from LocalSettings.php.
 * @var string|bool $wgUpgradeKey
 */
$wgUpgradeKey = false;

/**
 * If set, this URL is added to the start of $wgUploadPath to form a complete
 * upload URL.
 * @see $wgUploadPath
 * @var string $wgUploadBaseUrl
 */
$wgUploadBaseUrl = '';

/**
 * The filesystem path of the images directory. Defaults to "{$IP}/images".
 * @var string|bool $wgUploadDirectory
 */
$wgUploadDirectory = false;

/**
 * Disable file delete/restore operations. Useful during uploads maintenance.
 * @var bool $wgUploadMaintenance
 */
$wgUploadMaintenance = false;

/**
 * Point the upload link for missing files to an external URL, as with
 * $wgUploadNavigationUrl. The URL will get (?|&)wpDestFile=<filename>
 * appended to it as appropriate.
 * @var string|bool $wgUploadMissingFileUrl
 */
$wgUploadMissingFileUrl = false;

/**
 * Point the upload navigation link to an external URL. Useful if you want to
 * use a shared repository by default without disabling local uploads (use
 * $wgEnableUploads = false for that).
 * @example $wgUploadNavigationUrl = 'http://commons.wikimedia.org/wiki/Special:Upload';
 * @var string|bool $wgUploadNavigationUrl
 */
$wgUploadNavigationUrl = false;

/**
 * Warn if uploaded files are larger than this (in bytes), or false to disable.
 * @var int|bool $wgUploadSizeWarning
 */
$wgUploadSizeWarning = false;

/**
 * The maximum age of temporary (incomplete) uploaded files, in seconds.
 * @var int $wgUploadStashMaxAge
 */
$wgUploadStashMaxAge = 6 * 3600; // 6 hours

/**
 * To enable remote on-demand scaling, set this to the thumbnail base URL.
 * Full thumbnail URL will be like
 * $wgUploadStashScalerBaseUrl/e/e6/Foo.jpg/123px-Foo.jpg where 'e6' are the
 * first two characters of the MD5 hash of the file name. If
 * $wgUploadStashScalerBaseUrl is set to false, thumbs are rendered locally
 * as needed.
 * @var string|bool $wgUploadStashScalerBaseUrl
 */
$wgUploadStashScalerBaseUrl = false;

/**
 * The external URL protocols. Used for parsing URLs.
 * @var Array $wgUrlProtocols
 */
$wgUrlProtocols = [
	'//',
	'ftp://',
	'git://',
	'gopher://',
	'http://',
	'https://',
	'irc://',
	'ircs://',
	'mailto:',
	'mms://',
	'news:',
	'nntp://',
	'svn://',
	'telnet://',
	'worldwind://',
	'xmpp:',
];

/**
 * Enable AJAX framework.
 * @var bool $wgUseAjax
 */
$wgUseAjax = true;

/**
 * If user doesn't specify any edit summary when making a an edit, MediaWiki
 * will try to automatically create one. This feature can be disabled by set-
 * ting this variable false.
 * @var bool $wgUseAutomaticEditSummaries
 */
$wgUseAutomaticEditSummaries = true;

/**
 * Use experimental, DMOZ-like category browser.
 * @var bool $wgUseCategoryBrowser
 */
$wgUseCategoryBrowser = false;

/**
 * Login / create account link behavior when it's possible for anonymous users
 * to create an account true = use a combined login / create account link
 * false = split login and create account into two separate links.
 * @var bool $wgUseCombinedLoginLink
 */
$wgUseCombinedLoginLink = true;

/**
 * Backward compatibility setting, will set $wgArticleCountMethod if it is null.
 * @deprecated since 1.18; use $wgArticleCountMethod instead
 * @var bool $wgUseCommaCount
 */
$wgUseCommaCount = false;

/**
 * Set this to true if you want detailed copyright information forms on Upload.
 * @see Special:Upload
 * @var bool $wgUseCopyrightUpload
 */
$wgUseCopyrightUpload = false;

/**
 * Translation using MediaWiki: namespace. Interface messages will be loaded
 * from the database.
 * @var bool $wgUseDatabaseMessages
 */
$wgUseDatabaseMessages = true;

/**
 * Do DELETE/INSERT for link updates instead of incremental.
 * @var bool $wgUseDumbLinkUpdate
 */
$wgUseDumbLinkUpdate = false;

/**
 * Enable to allow rewriting dates in page text. DOES NOT FORMAT CORRECTLY FOR
 * MOST LANGUAGES.
 * @var bool $wgUseDynamicDates
 */
$wgUseDynamicDates = false;

/**
 * If you run Squid3 with ESI support, enable this (default:false).
 * @var bool $wgUseESI
 */
$wgUseESI = false;

/**
 * Whether MediaWiki should send an ETag header.
 * @var bool $wgUseETag
 */
$wgUseETag = true;

/**
 * Activate external editor interface for files and pages.
 * @see http://www.mediawiki.org/wiki/Manual:External_editors
 * @var bool $wgUseExternalEditor
 */
$wgUseExternalEditor = false;

/**
 * This will cache static pages for non-logged-in users to reduce database
 * traffic on public sites. Must set $wgShowIPinHeader = false. ResourceLoader
 * requests to default language and skins are cached as well as single module
 * requests.
 * @see $wgShowIPinHeader
 * @var bool $wgUseFileCache
 */
$wgUseFileCache = false;

/**
 * When using the file cache, we can store the cached HTML gzipped to save disk
 * space. Pages will then also be served compressed to clients that support it.
 * THIS IS NOT COMPATIBLE with ob_gzhandler which is now enabled if supported in
 * the default LocalSettings.php! If you enable this, remove that setting first.
 * Requires zlib support enabled in PHP.
 * @var bool $wgUseGzip
 */
$wgUseGzip = false;

/**
 * Resizing can be done using PHP's internal image libraries or using
 * ImageMagick or another third-party converter, e.g. GraphicMagick. These
 * support more file formats than PHP, which only supports PNG, GIF, JPG, XBM
 * and WBMP. Use Image Magick instead of PHP builtin functions.
 * @var bool $wgUseImageMagick
 */
$wgUseImageMagick = true;

/**
 * Obsolete, always true, kept for compatibility with extensions.
 * @var bool $wgUseImageResize
 */
$wgUseImageResize = true;

/**
 * Use Commons as a remote file repository. Essentially a wrapper, when this
 * is enabled $wgForeignFileRepos will point at Commons with a set of default
 * settings.
 * @see $wgForeignFileRepos
 * @var bool $wgUseInstantCommons
 */
$wgUseInstantCommons = false;

/**
 * Set this to true to make a local copy of the message cache, for use in
 * addition to memcached. The files will be put in $wgCacheDirectory.
 * @see $wgCacheDirectory
 * @var bool $wgUseLocalMessageCache
 */
$wgUseLocalMessageCache = false;

/**
 * Use MimeMagicLite class instead of MimeMagic.
 * @see includes/wikia/MimeMagicLite.php
 * @var bool $wgUseMimeMagicLite
 */
$wgUseMimeMagicLite = true;

/**
 * Use new page patrolling to check new pages on Special:Newpages.
 * @var bool $wgUseNPPatrol
 */
$wgUseNPPatrol = true;

/**
 * Should forwarded Private IPs be accepted?
 * @var bool $wgUsePrivateIPs
 */
$wgUsePrivateIPs = true;

/**
 * Use RC Patrolling to check for vandalism.
 * @var bool $wgUseRCPatrol
 */
$wgUseRCPatrol = false;

/**
 * The time, in seconds, when an email confirmation email expires.
 * @var int $wgUserEmailConfirmationTokenExpiry
 */
$wgUserEmailConfirmationTokenExpiry = 7 * 24 * 3600; // 7 days

/**
 * Character used as a delimiter when testing for interwiki userrights
 * (In Special:UserRights, it is possible to modify users on different
 * databases if the delimiter is used, e.g. Someuser@enwiki).
 *
 * It is recommended that you have this delimiter in
 * $wgInvalidUsernameCharacters, or you will not be able to
 * modify the user rights of those users via Special:UserRights
 * @see $wgInvalidUsernameCharacters
 * @var string $wgUserrightsInterwikiDelimiter
 */
$wgUserrightsInterwikiDelimiter = '@';

/**
 * Disables Captcha on user signup.
 * @see extensions/wikia/UserLogin/UserSignupSpecialController.class.php
 * @var bool $wgUserSignupDisableCaptcha
 */
$wgUserSignupDisableCaptcha = false;

/**
 * Array of usernames who will be sent a notification email for every change
 * which occurs on a wiki. Users will not be notified of their own changes.
 * @var Array $wgUsersNotifiedOnAllChanges
 */
$wgUsersNotifiedOnAllChanges = [];

/**
 * If you operate multiple wikis, you can define a shared upload path here.
 * Uploads to this wiki will NOT be put there - they will be put into
 * $wgUploadDirectory. If $wgUseSharedUploads is set, the wiki will look in the
 * shared repository if no file of the given name is found in the local
 * repository (for [[File:..]], [[Media:..]] links). Thumbnails will also be
 * looked for and generated in this directory. Note that these configuration
 * settings can now be defined on a per-repository basis for an arbitrary number
 * of file repositories, using the $wgForeignFileRepos variable.
 * @see $wgUploadDirectory
 * @see $wgForeignFileRepos
 * @var bool $wgUseSharedUploads
 */
$wgUseSharedUploads = false;

/**
 * Use the site's Cascading Style Sheets (CSS)?
 * @var bool $wgUseSiteCss
 */
$wgUseSiteCss = true;

/**
 * Use the site's Javascript page?
 * @var bool $wgUseSiteJs
 */
$wgUseSiteJs = false;

/**
 * Enable Squid.
 * @see http://www.mediawiki.org/wiki/Manual:Squid_caching
 * @var bool $wgUseSquid
 */
$wgUseSquid = true;

/**
 * Allow filtering by change tag in recentchanges, history, etc. Has no effect
 * if no tags are defined in valid_tag.
 * @var bool $wgUseTagFilter
 */
$wgUseTagFilter = false;

/**
 * To use inline TeX, you need to compile 'texvc' (in the 'math' subdirectory of
 * the MediaWiki package and have latex, dvips, gs (ghostscript), andconvert
 * (ImageMagick) installed and available in the PATH.
 * @see math/README for more information.
 * @var bool $wgUseTeX
 */
$wgUseTeX = false;

/**
 * $wgUseTidy: use tidy to make sure HTML output is sane.
 * Tidy is a free tool that fixes broken HTML.
 * See http://www.w3.org/People/Raggett/tidy/
 * @see $wgTidyBin
 * @see $wgTidyConf
 * @see $wgTidyOpts
 * @see $wgTidyInternal
 * @var bool $wgUseTidy
 */
$wgUseTidy = false;

/**
 * Search form behavior
 * true = use Go & Search buttons
 * false = use Go button & Advanced search link
 * @var bool $wgUseTwoButtonsSearchForm
 */
$wgUseTwoButtonsSearchForm = true;

/**
 * Enable the new look for Special:NewFiles.
 * @see extensions/wikia/WikiaNewFiles
 * @see $wgEnableWikiaPhotoGalleryExt
 * @var bool $wgUseWikiaNewFiles
 */
$wgUseWikiaNewFiles = true;

/**
 * Send X-Vary-Options header for better caching (requires patched Squid).
 * @var bool $wgUseXVO
 */
$wgUseXVO = false;

/**
 * Validate the overall output using tidy and refuse to display the page if it's
 * not valid.
 * @var bool $wgValidateAllHtml
 */
$wgValidateAllHtml = false;

/**
 * List of valid skin names.
 * The key should be the name in all lower case, the value should be a properly
 * cased name for the skin. This value will be prefixed with "Skin" to create
 * the class name of the skin to load, and if the skin's class cannot be found
 * through the autoloader it will be used to load a .php file by that name
 * in the skins directory. The default skins will be added later,
 * by Skin::getSkinNames(). Use Skin::getSkinNames() as an accessor if you wish
 * to have access to the full list.
 * @var Array $wgValidSkinNames
 */
$wgValidSkinNames = [];

/**
 * Like $wgArticlePath, but on multi-variant wikis, this provides a
 * path format that describes which parts of the URL contain the
 * language variant.
 *
 *  @example $wgLanguageCode = 'sr';
 *  @example $wgVariantArticlePath = '/$2/$1';
 *  @example $wgArticlePath = '/wiki/$1';
 *
 * A link to /wiki/ would be redirected to /sr/Главна_страна
 *
 * It is important that $wgArticlePath not overlap with possible values
 * of $wgVariantArticlePath.
 *
 * @see $wgArticlePath
 * @var string|bool $wgVariantArticlePath
 */
$wgVariantArticlePath = false;

/**
 * Add X-Forwarded-Proto to the Vary and X-Vary-Options headers for API
 * requests and RSS/Atom feeds. Use this if you have an SSL termination setup
 * and need to split the cache between HTTP and HTTPS for API requests,
 * feed requests and HTTP redirect responses in order to prevent cache
 * pollution. This does not affect 'normal' requests to index.php other than
 * HTTP redirects.
 * @var bool $wgVaryOnXFP
 */
$wgVaryOnXFP = false;

/**
 * Blacklist for MediaWiki Verbatim extension.
 * @see /extensions/3rdparty/Verbatim
 * @see https://wikia-inc.atlassian.net/browse/CE-2559
 * @var Array $wgVerbatimBlacklist
 */
$wgVerbatimBlacklist = [ 'AP', 'AP1', 'AP2', 'AP3', 'AP4',
	'MP', 'MP1', 'MP2', 'MP3', 'MP4' ];

/**
 * Determines if the mime type of uploaded files should be checked.
 * @var bool $wgVerifyMimeType
 */
$wgVerifyMimeType = true;

/**
 * MediaWiki version number.
 * @var string $wgVersion
 */
$wgVersion = '1.19.24';

/**
 * Play videos on file page load.
 * @var bool $wgVideoPageAutoPlay
 * @see extensions/wikia/FilePage/
 */
$wgVideoPageAutoPlay = true;

/**
 * Replace existing thumbnails.
 * @see includes/wikia/vignette/VignetteRequest.php
 * @var bool $wgVignetteReplaceThumbnails
 */
$wgVignetteReplaceThumbnails = false;

/**
 * Disallow VisualEditor to ever appearing as a main/default/primary editor.
 * @see extensions/wikia/EditorPreference
 * @var bool $wgVisualEditorNeverPrimary
 */
$wgVisualEditorNeverPrimary = false;

/**
 * If false, Parsoid requests will be sent with 'Cache-control: no-cache'
 * @see extensions/VisualEditor
 * @see GlobalVarConfig::get()
 * @var bool $wgVisualEditorNoCache
 */
$wgVisualEditorNoCache = false;

/**
 * Skins integrated with VisualEditor.
 * @see extensions/VisualEditor/VisualEditor.hooks.php
 * @see extensions/wikia/EditorPreference/EditorPreference.class.php
 * @var array $wgVisualEditorSupportedSkins
 */
$wgVisualEditorSupportedSkins = [ 'oasis' ];

/**
 * Number of links to a page required before it is deemed "wanted".
 * @var int $wgWantedPagesThreshold
 */
$wgWantedPagesThreshold = 1;

/**
 * Pages anonymous user may see as an array, e.g.
 *
 * <code>
 * $wgWhitelistRead = array ( "Main Page", "Wikipedia:Help");
 * </code>
 *
 * Special:Userlogin and Special:ChangePassword are always whitelisted.
 *
 * NOTE: This will only work if $wgGroupPermissions['*']['read'] is false --
 * see below. Otherwise, ALL pages are accessible, regardless of this setting.
 *
 * Also note that this will only protect _pages in the wiki_. Uploaded files
 * will remain readable. You can use img_auth.php to protect uploaded files,
 * see http://www.mediawiki.org/wiki/Manual:Image_Authorization
 * @var Array|bool $wgWhitelistRead
 */
$wgWhitelistRead = false;

/**
 * Display Wikia Bar by default for those languages.
 * @see extensions/wikia/WikiaBar/
 * @var Array $wgWikiaBarMainLanguages
 */
$wgWikiaBarMainLanguages = [ 'de', 'en', 'es', 'fr' ];

/**
 * FANDOM's main top-level domain. It's used in many places across the entire
 * codebase.
 * @var string $wgWikiaBaseDomain
 */
$wgWikiaBaseDomain = 'wikia.com';
$wgFandomBaseDomain = 'fandom.com';
$wgWikiaOrgBaseDomain = 'wikia.org';

/**
 * User accounts that are used as bots but do not have the bot flag.
 * @see extensions/wikia/AchievementsII
 * @see includes/wikia/Wikia.php
 * @var Array $wgWikiaBotLikeUsers
 */
$wgWikiaBotLikeUsers = [
	'CreateWiki script',
	'Default',
	'Fandom',
	'FandomBot',
	'Maintenance script',
	'QATestsStaff',
	'Wikia',
	'WikiaBot',
	'WikiaStaff',
];

/**
 * Provides the current config revision for Special:Version.
 * @see includes/specials/SpecialVersion.php
 * @var string $wgWikiaConfRevision
 */
$wgWikiaConfRevision = '$HeadURL$';

/**
 * Disable all DPL extensions (DPL + DPL forum)
 * @see /extensions/DPLforum
 * @see /extensions/DynamicPageList
 * @var bool $wgWikiaDisableAllDPLExt
 */
$wgWikiaDisableAllDPLExt = false;

/**
 * A variable with an exceptionally descriptive name.
 * @see wfCreatePageSetupVars()
 * @see /extensions/wikia/CreatePage
 * @var bool $wgWikiaDisableDynamicLinkCreatePagePopup
 */
$wgWikiaDisableDynamicLinkCreatePagePopup = false;

/**
 * Enable Content Feeds extension.
 * @see extensions/wikia/ContentFeeds
 * @var bool $wgWikiaEnableContentFeedsExt
 */
$wgWikiaEnableContentFeedsExt = true;

/**
 * Enable Special:Createpage extension.
 * @see /extensions/wikia/CreatePage
 * @var bool $wgWikiaEnableCreatepageExt
 */
$wgWikiaEnableCreatepageExt = true;

/**
 * Enable/Disable dpl extension.
 * @see /extensions/DynamicPageList
 * @var bool $wgWikiaEnableDPLExt
 */
$wgWikiaEnableDPLExt = false;

/**
 * Enable DPL forum.
 * @see /extensions/DPLforum
 * @var bool $wgWikiaEnableDPLForum
 */
$wgWikiaEnableDPLForum = true;

/**
 * Enable FounderEmails extension.
 * @see extensions/wikia/FounderEmails
 * @var bool $wgWikiaEnableFounderEmailsExt
 */
$wgWikiaEnableFounderEmailsExt = true;

/**
 * Enable the "new" create page popup flow.
 * @see wfCreatePageSetupVars()
 * @see /extensions/wikia/CreatePage
 * @var bool $wgWikiaEnableNewCreatepageExt
 */
$wgWikiaEnableNewCreatepageExt = true;

/**
 * Enable shared Help pages.
 * @see /extensions/wikia/SharedHelp
 * @var bool $wgWikiaEnableSharedHelpExt
 */
$wgWikiaEnableSharedHelpExt = true;

/**
 * Enable WikiaSharedTalk extension.
 * @see /extensions/wikia/WikiaNewtalk/
 * @var bool $wgWikiaEnableSharedTalkExt
 */
$wgWikiaEnableSharedTalkExt = true;

/**
 * Enable WikiFactory Redirector.
 * @see /extensions/wikia/WikiFactory/redir/SpecialWikiFactoryRedir.php
 * @var bool $wgWikiaEnableWikiFactoryRedir
 */
$wgWikiaEnableWikiFactoryRedir = true;

/**
 * Enable YouTube extension.
 * @see extensions/wikia/YouTube/
 * @var bool $wgWikiaEnableYouTubeExt
 */
$wgWikiaEnableYouTubeExt = true;

/**
 * Data for Wikia Game Guides.
 * @see extensions/wikia/GameGuides
 * @var bool $wgWikiaGameGuidesContent
 */
$wgWikiaGameGuidesContent = [];

/**
 * Wikia Game Guides sponsored videos.
 * @var Array $wgWikiaGameGuidesSponsoredVideos
 * @see extensions/wikia/GameGuides
 */
$wgWikiaGameGuidesSponsoredVideos = [];

/**
 * Whether or not use extension's default access rights in Abuse Filter.
 * @see lib/Wikia/src/Service/User/Permissions/data/PermissionsDefinesAfterWikiFactory.php
 * @var bool $wgWikiaManualAbuseFilterRights
 */
$wgWikiaManualAbuseFilterRights = false;

/**
 * Top-level part of app ID for the LinkToMobileApp extension.
 * @see extensions/wikia/LinkToMobileApp
 * @var bool $wgWikiaMobileAppPackageId
 */
$wgWikiaMobileAppPackageId = 'com.wikia.singlewikia';

/**
 * Video providers supported in mobile app.
 * @see app/extensions/wikia/VideoHandlers
 * @var Array $wgWikiaMobileAppSupportedVideos
 */
$wgWikiaMobileAppSupportedVideos = [ 'youtube', ];

/**
 * Video providers supported in mobile skin.
 * @see app/skins/WikiaMobile.php
 * @see app/extensions/wikia/VideoHandlers
 * @see app/extensions/wikia/SpecialVideos
 * @var Array $wgWikiaMobileSupportedVideos
 */
$wgWikiaMobileSupportedVideos = [ 'dailymotion', 'vimeo', 'youtube', ];

/**
 * FANDOM no-cookie or cookie-less domain. Used in many places across the
 * codebase.
 * @var string $wgWikiaNocookieDomain
 */
$wgWikiaNocookieDomain = 'wikia.nocookie.net';

/**
 * Enable Special:Nuke for sysops. Disabled globally. Set in WikiFactory if
 * required.
 * @see lib/Wikia/src/Service/User/Permissions/data/PermissionsDefinesAfterWikiFactory.php
 * @var bool $wgWikiaNukeLocal
 */
$wgWikiaNukeLocal = false;

/**
 * If true, Search is accessible via Special:Search. Otherwise it is
 * Special:WikiaSearch.
 * @see extensions/wikia/Search/WikiaSearchController.class.php
 * @var bool $wgWikiaSearchIsDefault
 */
$wgWikiaSearchIsDefault = true;

/**
 * Languages supported in the Search.
 * @see extensions/wikia/Search/classes/MediaWikiService.php
 * @var Array $wgWikiaSearchSupportedLanguages
 */
$wgWikiaSearchSupportedLanguages = [
	'ar', 'bg', 'ca', 'cz', 'da', 'de', 'el', 'en', 'es', 'eu', 'fa', 'fi',
	'fr', 'ga', 'gl', 'hi', 'hu', 'hy', 'id', 'it', 'ja', 'ko', 'lv', 'nl',
	'no', 'pl', 'pt', 'ro', 'ru', 'sv', 'sv', 'th', 'tr', 'zh'
];

/**
 * Exclude wiki from Global Search
 * @see extensions/wikia/Search/classes/IndexService/CrossWikiCore.php
 * @var bool $wgExcludeWikiFromSearch
 */
$wgExcludeWikiFromSearch = false;

/**
 * Render some links with rel=nofollow attribute.
 * @see Article.php
 * @see Linker.php
 * @see Skin.php
 * @var bool $wgWikiaUseNoFollow
 */
$wgWikiaUseNoFollow = true;

/**
 * Switch defining whether to use nofollow for links to non-existing articles,
 * so called red links.
 * @see Linker.php
 * @var bool $wgWikiaUseNoFollowForContent
 */
$wgWikiaUseNoFollowForContent = true;

/**
 * Flag set by Wikia owner to indicate that the wikia is a COPPA wiki that
 * requires login for all edits
 * @see extensions/wikia/AdEngine/AdTargeting.class.php
 * @see extensions/wikia/MercuryApi/models/MercuryApi.class.php
 * @see includes/wikia/Wikia.php
 * @var bool $wgWikiDirectedAtChildrenByFounder
 */
$wgWikiDirectedAtChildrenByFounder = false;

/**
 * Flag set by Wikia staff to indicate that the wikia is a COPPA wiki that
 * requires login for all edits
 * @see extensions/wikia/AdEngine/AdTargeting.class.php
 * @see extensions/wikia/MercuryApi/models/MercuryApi.class.php
 * @var bool $wgWikiDirectedAtChildrenByStaff
 */
$wgWikiDirectedAtChildrenByStaff = false;

/**
 * Indicates whether wikicities database is in read-only mode.
 * @see extensions/wikia/WikiFactory/WikiFactory.php
 * @see extensions/wikia/FounderEmails
 * @see extensions/wikia/WikiFactory/
 * @deprecated
 * @var bool $wgWikicitiesReadOnly
 */
$wgWikicitiesReadOnly = false;

/**
 * Additional domains that need to be mapped to wikia.com and redirected
 * properly.
 * @see extensions/wikia/WikiFactory/Loader/WikiFactoryLoader.php
 * @var string[] $wgWikiFactoryDomains
 */
$wgWikiFactoryDomains = [
	# gTLDs
	'wikia.net',
	'wikia.info',
	# ccTLDs
	'wikia.at',
	'wikia.be',
	'wikia.ch',
	'wikia.cn',
	'wikia.de',
	'wikia.jp',
	'wikia.lt',
	'wikia.no',
	'wikia.pl',
	'wikia.tw',
	'wikia.co.uk',
	'wikia.us',
	'wikia.fr',
	# legacy wikicities domains
	'wikicities.com',
	'wikicities.net',
	'wikicities.org'
];

/**
 * Do not allow editing articles from these namespaces with Rich Text Editor.
 * @see extensions/wikia/RTE
 * @var Array $wgWysiwygDisabledNamespaces
 */
$wgWysiwygDisabledNamespaces = [];

/**
 * The default xmlns attribute.  Ignored if $wgHtml5 is true (or it's supposed
 * to be), since we don't currently support XHTML5, and in HTML5 (i.e., served
 * as text/html) the attribute has no effect, so why bother?
 * @var string $wgXhtmlDefaultNamespace
 */
$wgXhtmlDefaultNamespace = 'http://www.w3.org/1999/xhtml';

/**
 * Permit other namespaces in addition to the w3.org default. Use the prefix for
 * the key and the namespace for the value.
 * @example $wgXhtmlNamespaces['svg'] = 'http://www.w3.org/2000/svg';
 *
 * Normally we wouldn't have to define this in the root <html> element, but IE
 * needs it there in some circumstances. This is ignored if $wgHtml5 is true,
 * for the same reason as $wgXhtmlDefaultNamespace.
 * @see $wgHtml5
 * @see $wgXhtmlDefaultNamespace
 * @var Array $wgXhtmlNamespaces
 */
$wgXhtmlNamespaces = [];

/**
 * Additional XML types we can allow via mime-detection.
 * @example [ 'rootElement' => 'associatedMimeType' ]
 * @var Array $wgXMLMimeTypes
 */
$wgXMLMimeTypes = [
	'http://www.w3.org/2000/svg:svg' => 'image/svg+xml',
	'svg' => 'image/svg+xml',
	'http://www.lysator.liu.se/~alla/dia/:diagram' => 'application/x-dia-diagram',
	'http://www.w3.org/1999/xhtml:html' => 'text/html', // application/xhtml+xml?
	'html' => 'text/html', // application/xhtml+xml?
];

/**
 * Youku configuration.
 * @see extensions/wikia/VideoHandlers/
 * @var Array $wgYoukuConfig
 */
$wgYoukuConfig['playerColor'] = 0;

/**
 * whether or not create new wiki prompts users to alternatively create their community
 * in the community builder (fandom creator)
 * @see CAKE-2151
 */
$wgAllowCommunityBuilderCNWPrompt = false;

/**
 * Whether the community is scheduled to be migrated to a fandom.com domain, triggers a banner notification
 * @see SEO-669
 * @var bool $wgFandomComMigrationScheduled
 */
$wgFandomComMigrationScheduled = false;

/**
 * Environment-specific domain mappings to their normalized variants
 * @var string[] $wgDomainOverrides
 */
$wgEnvironmentDomainMappings = [];

/**
 * Whether the community is scheduled to be migrated to a wikia.org domain
 * @var bool $wgWikiaOrgMigrationScheduled
 */
$wgWikiaOrgMigrationScheduled = false;

/**
 * Custom messages to show on the migration banner (before and after migration).
 * @see PLATFORM-3895
 * @var string
 */
$wgFandomComMigrationCustomMessageBefore = '';
$wgFandomComMigrationCustomMessageAfter = '';

/**
 * Whether the community was migrated to a fandom.com domain, triggers a banner notification
 * @see SEO-669
 * @var bool $wgFandomComMigrationDone
 */
$wgFandomComMigrationDone = false;


/**
 * Whether the community was migrated to a wikia.org domain, triggers a banner notification
 * @var bool $wgWikiaOrgMigrationDone
 */
$wgWikiaOrgMigrationDone = false;

/**
 * Whether we should enable tracking cookie reset page. This is needed in transition phase
 * when we migrate wikis from .wikia.com to .fandom.com domain.
 */
$wgEnableResetTrackingPreferencesPage = false;

/**
 * Wether we should load the FastlyInsights extension. The extension will then add the Fastly Insights
 * script to pages - https://insights.fastlylabs.com
 */
$wgEnableFastlyInsights = false;

/**
 * Whether the closed wiki page should be shown, variable set by WikiFactoryLoader for closed wikis.
 */
$wgIncludeClosedWikiHandler = false;

/**
 * Watch Show extension default labels
 * @see IW-1470
 * @var string
 */
$wgWatchShowCTA = 'Watch This Show';
$wgWatchShowButtonLabel = 'Watch Now';

/**
 * Watch Show extension default values
 */
$wgWatchShowEnabledDate = '2099-12-31T00:00:00Z'; // ISO-8601

/**
 * Enables EditDraftSaving extension
 * @see SUS-79
 * @var bool
 */
$wgEnableEditDraftSavingExt = false;

/**
 * ArticleTags RabbitMQ configuration.
 * @see extensions/wikia/articleTagEvents
 * @var array $wgArticleTagExchangeConfig
 */
$wgArticleTagExchangeConfig = [
    'vhost' => 'events',
    'exchange' => 'article-tags',
];

/**
 * Enables QualtricsSiteIntercept extension
 * @see CORE-128
 * @var bool
 */
$wgEnableQualtricsSiteInterceptExt = false;

/**
 * Enables Quizzes extension on select communities
 * @see CAKE-4585
 * @var bool
 */
$wgEnableTriviaQuizzesExt = false;

/**
 * Enables Quizzes extension on select pages
 * @see CAKE-4585
 * @var string[] $wgTriviaQuizzesEnabledPages
 */
$wgTriviaQuizzesEnabledPages = [];

/**
 * Enables the Article Exporter Hooks
 * @see LORE-519
 * @var bool
 */
$wgEnableArticleExporterHooks = true;

/**
 * ArticleExporter RabbitMQ configuration.
 * @see extensions/wikia/ArticleExporter
 * @var array $wgArticleExporterExchange
 */
$wgArticleExporterExchange = [
    'vhost' => '/',
    'exchange' => 'taxonomy-ex',
    'routing' => 'taxonomy.article-edits'
];

/**
 * @see lib/Wikia/src/CircuitBreaker/CircuitBreakerFactory.php
 * @var string $wgCircuitBreakerType
 */
$wgCircuitBreakerType = 'noop';

/**
 * @see lib/Wikia/src/CircuitBreaker/RedisCircuitBreakerStorage.php
 * @var string $wgCircuitBreakerRedisHost
 */
$wgCircuitBreakerRedisHost = 'geo-redisshared-prod-master.query.consul';


/**
 * @see lib/Wikia/src/CircuitBreaker/RedisCircuitBreakerStorage.php
 * @var int $wgCircuitBreakerRedisDb
 */
$wgCircuitBreakerRedisDb = 4;

/**
 * @var $wgEnableHydralyticsExt
 */
$wgEnableHydralyticsExt = true;

/**
 * List of Unicode characters for which capitalization is overridden in
 * Language::ucfirst. The characters should be
 * represented as char_to_convert => conversion_override. See T219279 for details
 * on why this is useful during php version transitions.
 *
 * @warning: EXPERIMENTAL!
 *
 * @var array
 */
$wgOverrideUcfirstCharacters = [
	'ß' => 'ß',
	'ŉ' => 'ŉ',
	'ǅ' => 'ǅ',
	'ǆ' => 'ǅ',
	'ǈ' => 'ǈ',
	'ǉ' => 'ǈ',
	'ǋ' => 'ǋ',
	'ǌ' => 'ǋ',
	'ǰ' => 'ǰ',
	'ǲ' => 'ǲ',
	'ǳ' => 'ǲ',
	'ɪ' => 'ɪ',
	'ͅ' => 'ͅ',
	'ΐ' => 'ΐ',
	'ΰ' => 'ΰ',
	'և' => 'և',
	'ა' => 'ა',
	'ბ' => 'ბ',
	'გ' => 'გ',
	'დ' => 'დ',
	'ე' => 'ე',
	'ვ' => 'ვ',
	'ზ' => 'ზ',
	'თ' => 'თ',
	'ი' => 'ი',
	'კ' => 'კ',
	'ლ' => 'ლ',
	'მ' => 'მ',
	'ნ' => 'ნ',
	'ო' => 'ო',
	'პ' => 'პ',
	'ჟ' => 'ჟ',
	'რ' => 'რ',
	'ს' => 'ს',
	'ტ' => 'ტ',
	'უ' => 'უ',
	'ფ' => 'ფ',
	'ქ' => 'ქ',
	'ღ' => 'ღ',
	'ყ' => 'ყ',
	'შ' => 'შ',
	'ჩ' => 'ჩ',
	'ც' => 'ც',
	'ძ' => 'ძ',
	'წ' => 'წ',
	'ჭ' => 'ჭ',
	'ხ' => 'ხ',
	'ჯ' => 'ჯ',
	'ჰ' => 'ჰ',
	'ჱ' => 'ჱ',
	'ჲ' => 'ჲ',
	'ჳ' => 'ჳ',
	'ჴ' => 'ჴ',
	'ჵ' => 'ჵ',
	'ჶ' => 'ჶ',
	'ჷ' => 'ჷ',
	'ჸ' => 'ჸ',
	'ჹ' => 'ჹ',
	'ჺ' => 'ჺ',
	'ჽ' => 'ჽ',
	'ჾ' => 'ჾ',
	'ჿ' => 'ჿ',
	'ᲀ' => 'ᲀ',
	'ᲁ' => 'ᲁ',
	'ᲂ' => 'ᲂ',
	'ᲃ' => 'ᲃ',
	'ᲄ' => 'ᲄ',
	'ᲅ' => 'ᲅ',
	'ᲆ' => 'ᲆ',
	'ᲇ' => 'ᲇ',
	'ᲈ' => 'ᲈ',
	'ẖ' => 'ẖ',
	'ẗ' => 'ẗ',
	'ẘ' => 'ẘ',
	'ẙ' => 'ẙ',
	'ẚ' => 'ẚ',
	'ὐ' => 'ὐ',
	'ὒ' => 'ὒ',
	'ὔ' => 'ὔ',
	'ὖ' => 'ὖ',
	'ᾀ' => 'ᾈ',
	'ᾁ' => 'ᾉ',
	'ᾂ' => 'ᾊ',
	'ᾃ' => 'ᾋ',
	'ᾄ' => 'ᾌ',
	'ᾅ' => 'ᾍ',
	'ᾆ' => 'ᾎ',
	'ᾇ' => 'ᾏ',
	'ᾈ' => 'ᾈ',
	'ᾉ' => 'ᾉ',
	'ᾊ' => 'ᾊ',
	'ᾋ' => 'ᾋ',
	'ᾌ' => 'ᾌ',
	'ᾍ' => 'ᾍ',
	'ᾎ' => 'ᾎ',
	'ᾏ' => 'ᾏ',
	'ᾐ' => 'ᾘ',
	'ᾑ' => 'ᾙ',
	'ᾒ' => 'ᾚ',
	'ᾓ' => 'ᾛ',
	'ᾔ' => 'ᾜ',
	'ᾕ' => 'ᾝ',
	'ᾖ' => 'ᾞ',
	'ᾗ' => 'ᾟ',
	'ᾘ' => 'ᾘ',
	'ᾙ' => 'ᾙ',
	'ᾚ' => 'ᾚ',
	'ᾛ' => 'ᾛ',
	'ᾜ' => 'ᾜ',
	'ᾝ' => 'ᾝ',
	'ᾞ' => 'ᾞ',
	'ᾟ' => 'ᾟ',
	'ᾠ' => 'ᾨ',
	'ᾡ' => 'ᾩ',
	'ᾢ' => 'ᾪ',
	'ᾣ' => 'ᾫ',
	'ᾤ' => 'ᾬ',
	'ᾥ' => 'ᾭ',
	'ᾦ' => 'ᾮ',
	'ᾧ' => 'ᾯ',
	'ᾨ' => 'ᾨ',
	'ᾩ' => 'ᾩ',
	'ᾪ' => 'ᾪ',
	'ᾫ' => 'ᾫ',
	'ᾬ' => 'ᾬ',
	'ᾭ' => 'ᾭ',
	'ᾮ' => 'ᾮ',
	'ᾯ' => 'ᾯ',
	'ᾲ' => 'ᾲ',
	'ᾳ' => 'ᾼ',
	'ᾴ' => 'ᾴ',
	'ᾶ' => 'ᾶ',
	'ᾷ' => 'ᾷ',
	'ᾼ' => 'ᾼ',
	'ῂ' => 'ῂ',
	'ῃ' => 'ῌ',
	'ῄ' => 'ῄ',
	'ῆ' => 'ῆ',
	'ῇ' => 'ῇ',
	'ῌ' => 'ῌ',
	'ῒ' => 'ῒ',
	'ΐ' => 'ΐ',
	'ῖ' => 'ῖ',
	'ῗ' => 'ῗ',
	'ῢ' => 'ῢ',
	'ΰ' => 'ΰ',
	'ῤ' => 'ῤ',
	'ῦ' => 'ῦ',
	'ῧ' => 'ῧ',
	'ῲ' => 'ῲ',
	'ῳ' => 'ῼ',
	'ῴ' => 'ῴ',
	'ῶ' => 'ῶ',
	'ῷ' => 'ῷ',
	'ῼ' => 'ῼ',
	'ⅰ' => 'ⅰ',
	'ⅱ' => 'ⅱ',
	'ⅲ' => 'ⅲ',
	'ⅳ' => 'ⅳ',
	'ⅴ' => 'ⅴ',
	'ⅵ' => 'ⅵ',
	'ⅶ' => 'ⅶ',
	'ⅷ' => 'ⅷ',
	'ⅸ' => 'ⅸ',
	'ⅹ' => 'ⅹ',
	'ⅺ' => 'ⅺ',
	'ⅻ' => 'ⅻ',
	'ⅼ' => 'ⅼ',
	'ⅽ' => 'ⅽ',
	'ⅾ' => 'ⅾ',
	'ⅿ' => 'ⅿ',
	'ⓐ' => 'ⓐ',
	'ⓑ' => 'ⓑ',
	'ⓒ' => 'ⓒ',
	'ⓓ' => 'ⓓ',
	'ⓔ' => 'ⓔ',
	'ⓕ' => 'ⓕ',
	'ⓖ' => 'ⓖ',
	'ⓗ' => 'ⓗ',
	'ⓘ' => 'ⓘ',
	'ⓙ' => 'ⓙ',
	'ⓚ' => 'ⓚ',
	'ⓛ' => 'ⓛ',
	'ⓜ' => 'ⓜ',
	'ⓝ' => 'ⓝ',
	'ⓞ' => 'ⓞ',
	'ⓟ' => 'ⓟ',
	'ⓠ' => 'ⓠ',
	'ⓡ' => 'ⓡ',
	'ⓢ' => 'ⓢ',
	'ⓣ' => 'ⓣ',
	'ⓤ' => 'ⓤ',
	'ⓥ' => 'ⓥ',
	'ⓦ' => 'ⓦ',
	'ⓧ' => 'ⓧ',
	'ⓨ' => 'ⓨ',
	'ⓩ' => 'ⓩ',
	'ꞹ' => 'ꞹ',
	'ﬀ' => 'ﬀ',
	'ﬁ' => 'ﬁ',
	'ﬂ' => 'ﬂ',
	'ﬃ' => 'ﬃ',
	'ﬄ' => 'ﬄ',
	'ﬅ' => 'ﬅ',
	'ﬆ' => 'ﬆ',
	'ﬓ' => 'ﬓ',
	'ﬔ' => 'ﬔ',
	'ﬕ' => 'ﬕ',
	'ﬖ' => 'ﬖ',
	'ﬗ' => 'ﬗ',
	'𐓘' => '𐓘',
	'𐓙' => '𐓙',
	'𐓚' => '𐓚',
	'𐓛' => '𐓛',
	'𐓜' => '𐓜',
	'𐓝' => '𐓝',
	'𐓞' => '𐓞',
	'𐓟' => '𐓟',
	'𐓠' => '𐓠',
	'𐓡' => '𐓡',
	'𐓢' => '𐓢',
	'𐓣' => '𐓣',
	'𐓤' => '𐓤',
	'𐓥' => '𐓥',
	'𐓦' => '𐓦',
	'𐓧' => '𐓧',
	'𐓨' => '𐓨',
	'𐓩' => '𐓩',
	'𐓪' => '𐓪',
	'𐓫' => '𐓫',
	'𐓬' => '𐓬',
	'𐓭' => '𐓭',
	'𐓮' => '𐓮',
	'𐓯' => '𐓯',
	'𐓰' => '𐓰',
	'𐓱' => '𐓱',
	'𐓲' => '𐓲',
	'𐓳' => '𐓳',
	'𐓴' => '𐓴',
	'𐓵' => '𐓵',
	'𐓶' => '𐓶',
	'𐓷' => '𐓷',
	'𐓸' => '𐓸',
	'𐓹' => '𐓹',
	'𐓺' => '𐓺',
	'𐓻' => '𐓻',
	'𖹠' => '𖹠',
	'𖹡' => '𖹡',
	'𖹢' => '𖹢',
	'𖹣' => '𖹣',
	'𖹤' => '𖹤',
	'𖹥' => '𖹥',
	'𖹦' => '𖹦',
	'𖹧' => '𖹧',
	'𖹨' => '𖹨',
	'𖹩' => '𖹩',
	'𖹪' => '𖹪',
	'𖹫' => '𖹫',
	'𖹬' => '𖹬',
	'𖹭' => '𖹭',
	'𖹮' => '𖹮',
	'𖹯' => '𖹯',
	'𖹰' => '𖹰',
	'𖹱' => '𖹱',
	'𖹲' => '𖹲',
	'𖹳' => '𖹳',
	'𖹴' => '𖹴',
	'𖹵' => '𖹵',
	'𖹶' => '𖹶',
	'𖹷' => '𖹷',
	'𖹸' => '𖹸',
	'𖹹' => '𖹹',
	'𖹺' => '𖹺',
	'𖹻' => '𖹻',
	'𖹼' => '𖹼',
	'𖹽' => '𖹽',
	'𖹾' => '𖹾',
	'𖹿' => '𖹿',
	'𞤢' => '𞤢',
	'𞤣' => '𞤣',
	'𞤤' => '𞤤',
	'𞤥' => '𞤥',
	'𞤦' => '𞤦',
	'𞤧' => '𞤧',
	'𞤨' => '𞤨',
	'𞤩' => '𞤩',
	'𞤪' => '𞤪',
	'𞤫' => '𞤫',
	'𞤬' => '𞤬',
	'𞤭' => '𞤭',
	'𞤮' => '𞤮',
	'𞤯' => '𞤯',
	'𞤰' => '𞤰',
	'𞤱' => '𞤱',
	'𞤲' => '𞤲',
	'𞤳' => '𞤳',
	'𞤴' => '𞤴',
	'𞤵' => '𞤵',
	'𞤶' => '𞤶',
	'𞤷' => '𞤷',
	'𞤸' => '𞤸',
	'𞤹' => '𞤹',
	'𞤺' => '𞤺',
	'𞤻' => '𞤻',
	'𞤼' => '𞤼',
	'𞤽' => '𞤽',
	'𞤾' => '𞤾',
	'𞤿' => '𞤿',
	'𞥀' => '𞥀',
	'𞥁' => '𞥁',
	'𞥂' => '𞥂',
	'𞥃' => '𞥃',
];

/**
 * Variable to bump the cache of EasyTimeline
 * @var string
 */
$wgTimelineRenderHashAppend = 'v2';

$wgIsTestWiki = false;

/**
 * Variable storing country codes where Video Bridge can appear
 */
$wgVideoBridgeCountries = [];

/**
 * Variable for enabling/disabling forum migration message per wiki
 */
$wgEnableForumMigrationMessage = true;

/**
 * Variable for enabling/disabling forum migration message globally (value from Community Central's WikiFactory is used)
 */
$wgEnableForumMigrationMessageGlobal = false;

/**
 * Variable for enabling/disabling message that appears after forum migration
 */
$wgEnablePostForumMigrationMessage = false;

/**
 * The URL of the XHGUI instance to send profiling data to.
 * If null, ondemand profiling is disabled.
 * @var string|null $wgXhguiProfilerUrl
 */
$wgXhguiProfilerUrl = null;

/**
 * Expiration timestamp for post forum migration message
 */
$wgPostForumMigrationMessageExpiration = 0;
