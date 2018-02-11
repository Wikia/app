<?php
require_once "$IP/includes/wikia/Defines.php";
require_once "$IP/includes/wikia/DefaultSettings.php";
require_once "$IP/includes/wikia/GlobalFunctions.php";

# Load the actual configuration

require_once "$IP/../config/secrets.php";

// TODO: Get rid of those. No DC detection, no DC-specific code.
$wgWikiaDatacenter = getenv( 'WIKIA_DATACENTER' );
$wgWikiaEnvironment = getenv( 'WIKIA_ENVIRONMENT' );

// TODO: Move it together with wgStyleVersion, include one file, no extra filesystem checks.
$wgWikiaIsDeployed = is_file( "$IP/../config/wikia.version.txt" );

// TODO: Defaulting to production is not a good idea. Production env should be explicitly
// indicated, never a default.
$wgDevelEnvironment = $wgStagingEnvironment = false;

$wgWikiaBaseDomain = "wikia.com";
$wgWikiaNocookieDomain = "wikia.nocookie.net";

// TODO: Find a person who would like to have that tattooed instead of some folk wisdom
// such as "born to write portable code".
if ( $wgWikiaEnvironment == WIKIA_ENV_DEV ) {
	$wgDevelEnvironment = true;
	$wgDevDomain = getenv( 'WIKIA_DEV_DOMAIN' );
} else if ( $wgWikiaEnvironment == WIKIA_ENV_PREVIEW
	|| $wgWikiaEnvironment == WIKIA_ENV_VERIFY
	|| $wgWikiaEnvironment == WIKIA_ENV_SANDBOX
	|| $wgWikiaEnvironment == WIKIA_ENV_STABLE
) {
	$wgStagingEnvironment = true;
} else if ( $wgWikiaEnvironment == WIKIA_ENV_STAGING ) {
	$wgWikiaBaseDomain = "wikia-staging.com";
	$wgWikiaNocookieDomain = "wikia-staging.nocookie.net";
}

// TODO: Get rid of those. No DC detection, no DC-specific code.
if ( empty( $wgWikiaDatacenter ) ) {
	throw new FatalError( 'Cannot determine the datacenter.' );
}

if ( empty( $wgWikiaEnvironment ) ) {
	throw new FatalError( 'Cannot determine the environment.' );
}

if ( $wgDevelEnvironment ) {
	$wgMedusaHostPrefix = '';
} else {
	$wgMedusaHostPrefix = "slot1.";
}

if ( empty($wgWikiaLocalSettingsPath) ) {
	$wgWikiaLocalSettingsPath = __FILE__;
}

// Formerly in CommonSettings.php

// TODO: Get rid of this
if ($wgDevelEnvironment) {
	// Defeat cachebuster on devboxes.  If you want a static cachebuster,
	// you can set whatever number you want in your own custom settings
	$wgStyleVersion = time();
} else {
	// This file is created and updated by deploytools2
	include_once("$IP/wgStyleVersion.php");
}

$wgAccountCreationThrottle = 5;
$wgAllowExternalImagesFrom = "http://images.{$wgWikiaBaseDomain}/";

$wgAllowUserCss = true;
$wgAllowUserJs = true;
// Disable site JS by default (CE-2475)
$wgUseSiteJs = false;

$wgAutoConfirmAge = 4 * 3600*24;
$wgBlockAllowsUTEdit = true;
$wgCompressRevisions = true;
$wgCookieDomain = ".{$wgWikiaBaseDomain}";
$wgCookiePrefix = "wikicities";
$wgDefaultSkin = 'oasis';
$wgEmailAuthentication = true;
$wgEnableScaryTranscluding = true;
$wgEnotifUserTalk = true;
$wgEnotifWatchlist = true;
$wgExternalDiffEngine = 'wikidiff2';
$wgHitcounterUpdateFreq = 1000;
$wgMaxUploadSize = 1024*1024*10; // 10MB
$wgMiserMode = true;
$wgRCMaxAge = (13*7) * 86400; #change to 13 weeks (91 days), matching the current MW default, may be increased later
$wgUseRCPatrol = false;
$wgUseTagFilter = false; // rt#22038
$wgStatsMethod = false;

$wgRightsPage = null;
$wgRightsIcon = "https://vignette.{$wgWikiaNocookieDomain}/messaging/images/a/a9/CC-BY-SA.png?1";
$wgRightsUrl  = null;
$wgRightsText = "CC-BY-SA";

// discussions hosts
$wgDiscussionsApiUrl = "https://services.{$wgWikiaBaseDomain}/discussion";

// on site notifications hosts
$wgOnSiteNotificationsApiUrl = "https://services.{$wgWikiaBaseDomain}/on-site-notifications";

$wgScriptPath	    = "";
$wgScript           = "$wgScriptPath/index.php";
$wgArticlePath      = "$wgScriptPath/wiki/$1";
$wgUploadPath       = "$wgScriptPath/images";
$wgLogo             = "$wgUploadPath/b/bc/Wiki.png";
$wgStyleDirectory   = "$IP/skins";
$wgCdnRootUrl       = 'https://' . str_replace( '.', '-', $wgMedusaHostPrefix ) . "images.{$wgWikiaNocookieDomain}";
$wgCdnApiUrl        = "https://api.{$wgWikiaNocookieDomain}/__cb$wgStyleVersion";
$wgResourceBasePath = "$wgCdnRootUrl/__cb$wgStyleVersion/common";
$wgStylePath        = "$wgResourceBasePath/skins";
$wgExtensionsPath   = "$wgResourceBasePath/extensions";
$wgTmpDirectory     = '/tmp';

$wgRestrictDisplayTitle = false;

$wgImagesDomainSharding = "images%s.{$wgWikiaNocookieDomain}"; // used by wfReplaceImageServer

if( $wgDevelEnvironment && empty( $wgWikiaIsDeployed ) ) {
	$wgCacheDirectory = "/var/cache/mediawiki";
} else {
	$wgCacheDirectory = "$IP/../cache/messages";
}

$wgLocalisationCacheConf[ "store"         ] = "files";
$wgLocalisationCacheConf[ "manualRecache" ] = true;
if (!empty($maintClass) && $maintClass == 'RebuildLocalisationCache') {
	# BAC-1235
	$wgLocalisationCacheConf[ "manualRecache" ] = false;
}

$wgVignetteUrl = "https://vignette.{$wgWikiaNocookieDomain}";
$wgLegacyVignetteUrl = "https://vignette<SHARD>.{$wgWikiaNocookieDomain}";

$wgWikiFactoryDB = $wgExternalSharedDB;

$wgUseSquid = true;
$wgUsePrivateIPs = true;
$wgSquidMaxage = 86400;
$wgPurgeSquidViaCelery = true;
$wgPurgeVignetteUsingSurrogateKeys = true;
$wgSquidServers = array();


/**
 * memcached configuration can be overwritten by using *Local variables.
 *
 * set class used by memcached clients
 */
$wgMemCachedPersistent = true;
$wgMainCacheType = CACHE_MEMCACHED;
$wgMessageCacheType = CACHE_MEMCACHED;
$wgParserCacheType = CACHE_MEMCACHED;
$wgParserCacheExpireTime = 86400 * 14;

/**
 * enable memcache for LinkCache
 */
$wgEnableFastLinkCache = true;

/**
 * session engine
 */
$wgSessionsInMemcached = true;

/**
* List of memcache proxy instances. There are two twemproxy instances on each proxy server.
*/
$wgMemCachedServers = array(
  0 => "prod.twemproxy.service.consul:21000",
  1 => "prod.twemproxy.service.consul:31000",
);

$wgSessionMemCachedServers = array(
  0 => "prod.twemproxy.service.consul:31001",
  1 => "prod.twemproxy.service.consul:21001",
);

if( ! $wgCommandLineMode ) {
	$wgMemCachedDebug = true;
	$wgMemCachedDebugLevel = 1;
}

$wgAllInOne = true;

$wgAddFromLink = true;

$wgImagesServers = 5; #Inez

define('MAGPIE_CACHE_ON', false);
define('MAGPIE_FETCH_TIME_OUT', 20);

$wgHTTPProxy = 'prod.border.service.consul:80'; // PLATFORM-1745


/**
 * Proxy blocking (see http://meta.wikimedia.org/wiki/Proxy_blocking)
 * $wgEnableSorbs = true;
 */

## EasyTimeline
putenv("GDFONTPATH=/usr/share/fonts/truetype/freefont/");
include_once( "$IP/extensions/timeline/Timeline.php" );
$wgTimelineSettings->ploticusCommand = "/usr/bin/ploticus";

## Attribution
$wgMaxCredits = 0;

#--- global file extensions
$wgFileExtensions[] = 'ico';
// $wgFileExtensions[] = 'ogg';
$wgFileExtensions[] = 'pdf';
// $wgFileExtensions[] = 'xcf';
$wgFileExtensions[] = 'svg';
// $wgFileExtensions[] = 'mid';


// allow upload of open office files - trac #2386
foreach (array('odt', 'ods', 'odp', 'odg', 'odc', 'odf', 'odi', 'odm') as $open_office_ext) {
	$wgFileExtensions[] = $open_office_ext;
}


$wgShowAds = true;

$wgDisableHardRedirects = true;

$wgNamespaceProtection[NS_TEMPLATE] = [ 'edittemplates' ];


// Disable local logging in CheckUser extension
$wgCheckUserLog = false;


$domainName = "{$wgWikiaBaseDomain}";


/**
 * valid values are 'user' 'newbie', 'anon', 'ip', and 'subnet'
 */
$wgRateLimits = array(
		'edit' => array(
			'newbie' => array(6, 60),
			'ip' => array(6, 60),
			),
		'move' => array(
			'newbie' => array(2, 240),
			'user' => array(2, 240),
			),
		'emailuser' => array(
			'user' => array( 2, 86400 ),
			),
		'mailpassword' => array(
			'ip' => array( 1, 43200 ),
			),
		);
$wgRateLimitLog = null;

# If PHP's memory limit is very low, some operations may fail.
# ini_set( 'memory_limit', '20M' );

if ( $wgCommandLineMode ) {
	if ( isset( $_SERVER ) && array_key_exists( 'REQUEST_METHOD', $_SERVER ) ) {
		die( "This script must be run from the command line\n" );
	}
}

## To enable image uploads, make sure the 'images' directory
## is writable, then uncomment this:
$wgEnableUploads    = true;
$wgDisableUploads   = ! $wgEnableUploads;
$wgUseImageResize   = true;
$wgUseImageMagick   = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";
$wgSVGConverter = 'rsvg';

$wgLocalInterwiki   = $wgSitename;

$wgUseLatin1 = false;


# $wgDefaultUserOptions['rcdays'] = 365;

$wgDefaultUserOptions['usenewrc'] = 1;


$wgDefaultUserOptions['enotifwatchlistpages'] = 1;
$wgDefaultUserOptions['enotifusertalkpages'] = 1;
$wgDefaultUserOptions['enotifdiscussionsfollows'] = 1;
$wgDefaultUserOptions['enotifdiscussionsvotes'] = 1;
$wgDefaultUserOptions['enotifminoredits'] = 1;
$wgDefaultUserOptions['watchdefault'] = 1;
$wgDefaultUserOptions['watchcreations'] = 1;
$wgDefaultUserOptions['htmlemails'] = 1;
$wgDefaultUserOptions['skin'] = 'oasis';
$wgDefaultUserOptions['imagesize'] = 1;

# $wgDefaultUserOptions['editondblclick'] = 1;

#$wgReadOnly = 'We apologise, the site is temporarily in read-only state till about 08:40 UTC';

# note that this will be overwritten by any wiki that creates a new
# $wgExtraNamespace array.
$wgExtraNamespaces = array(110 => 'Forum',
		111 => 'Forum_talk');



$wgNamespacesWithSubpages[NS_MAIN] = true;
$wgNamespacesWithSubpages[NS_TALK] = true;
$wgNamespacesWithSubpages[NS_USER] = true;
$wgNamespacesWithSubpages[NS_USER_TALK] = true;
$wgNamespacesWithSubpages[NS_PROJECT] = true;
$wgNamespacesWithSubpages[NS_PROJECT_TALK] = true;
$wgNamespacesWithSubpages[NS_IMAGE] = true;
$wgNamespacesWithSubpages[NS_IMAGE_TALK] = true;
$wgNamespacesWithSubpages[NS_MEDIAWIKI] = true;
$wgNamespacesWithSubpages[NS_MEDIAWIKI_TALK] = true;
$wgNamespacesWithSubpages[NS_TEMPLATE] = true;
$wgNamespacesWithSubpages[NS_TEMPLATE_TALK] = true;
$wgNamespacesWithSubpages[NS_HELP] = true;
$wgNamespacesWithSubpages[NS_HELP_TALK] = true;
$wgNamespacesWithSubpages[NS_CATEGORY] = true;
$wgNamespacesWithSubpages[NS_CATEGORY_TALK] = true;

$wgNamespacesWithSubpages[110] = true; //Forum
$wgNamespacesWithSubpages[111] = true; //Forum talk


$wgNamespacesToBeSearchedDefault = array(
		0 => true, //duh
		14 => true, //category
		);

// refer to extensions/wikia/WikiaSearch.setup.php for a list of possible profiles
$wgDefaultSearchProfile = 'default'; /** SEARCH_PROFILE_DEFAULT **/


/**
 * @name wgWikiFactoryDomains
 *
 * additional domains handled by Wiki Factory (don't put here wikia.com)
 */
$wgWikiFactoryDomains = array(
		# gTLDs
		"wikia.net",
		"wikia.org",
		"wikia.info",
		# ccTLDs
		"wikia.at",
		"wikia.be",
		"wikia.ch",
		"wikia.cn",
		"wikia.de",
		"wikia.jp",
		"wikia.lt",
		"wikia.no",
		"wikia.pl",
		"wikia.tw",
		"wikia.co.uk",
		"wikia.us",
		"wikia.fr",
		# legacy wikicities domains
		"wikicities.com",
		"wikicities.net",
		"wikicities.org"
		);

/**
 * wgConf local domains, used in HttpFunctions for checking if domain is local
 * or not
 */
$wgConf->localVHosts = array_merge( $wgWikiFactoryDomains, array(
			$wgWikiaBaseDomain,
			"uncyclopedia.org",
			"memory-alpha.org",
			"wowwiki.com",
			));

/**
 * @name $wgAccountsPerEmail
 * Sets the limit of registered accounts per email
 * null - unlimited
 * any number - the actual limit of accounts
 */
$wgAccountsPerEmail = 10; // Set to 10 by Mix <mix@wikia-inc.com> per CE-416.

/**
 * @name wgEnableMainPageTag
 * enable/disable MainPageTag extension
 */
$wgEnableMainPageTag = true;

/**
 * @name wgEnableCookiePolicyExt
 * enable/disable EU cookie policy notification
 */
$wgEnableCookiePolicyExt = true;


/**
 * @name wgEnableWikiaMiniUploadExt
 * enable/disable WikiaMiniUpload extension
 */
$wgEnableWikiaMiniUploadExt = true;

/**
 * @name wgEnableLinkSuggestExt
 * enable/disable LinkSuggest extension
 */
$wgEnableLinkSuggestExt = true;

/**
 * @name wgEnableCategoryTreeExt
 * enable/disable CategoryTree extension
 */
$wgEnableCategoryTreeExt = true;

/**
 * @name wgEnableCheckUserExt
 * enable/disable CheckUser extension
 */
$wgEnableCheckUserExt = true;

/**
 * @name wgEnableCiteExt
 * enable/disable Cite extension
 */
$wgEnableCiteExt = true;

/**
 * @name wgEnableWikiHieroExt
 * enable/disable wiki hieroglyphs extension
 */
$wgEnableWikiHieroExt = false;

/**
 * @name wgEnableRandomImageExt
 * enable/disable RandomImage extension
 */
$wgEnableRandomImageExt = true;

/**
 * @name wgEnableSpamBlacklistExt
 * enable/disable SpamBlacklist extension
 */
$wgEnableSpamBlacklistExt = false;
$wgSpamBlacklistFiles[] = array();

/**
 * @name wgEnableCharInsertExt
 * enable/disable CharInsert extension
 */
$wgEnableCharInsertExt = true;

/**
 * @name wgEnableDismissableSiteNoticeExt
 * enable/disable DismissableSiteNotice extension
 */
$wgEnableDismissableSiteNoticeExt = true;

/**
 * @name wgEnableImageMapExt
 * enable/disable ImageMap extension
 */
$wgEnableImageMapExt = true;

/**
 * @name wgEnableParserFunctionsExt
 * enable/disable ParserFunctions extension
 */
$wgEnableParserFunctionsExt = true;

/**
 * 3rdparty extensions
 */

/**
 * @name wgEnableRssExt
 * enable/disable RSS extension
 */
$wgEnableRssExt = true;

/**
 * @name wgEnableGlobalCSSJSExt
 * enable/disable GlobalCSSJS extension
 */
$wgEnableGlobalCSSJSExt = true;

/**
 * @name wgEnableAjaxPollExt
 * enable/disable AjaxPoll extension
 */
$wgEnableAjaxPollExt = true;

/**
 * @name wgEnableContactExt
 * enable/disable Contact extension
 */
$wgEnableContactExt = true;

/**
 * @name wgEnableInputBoxExt
 * enable/disable InputBox extension
 */
$wgEnableInputBoxExt = true;

/**
 * @name wgEnableRandomSelectionExt
 * enable/disable RandomSelection extension
 */
$wgEnableRandomSelectionExt = true;


/**
 * @name wgEnableTaskManagerExt
 * enable/disable TaskManager extension
 */
$wgEnableTaskManagerExt = true;

/**
 * @name wgEnableMultiDeleteExt
 * enable/disable MultiDelete extension
 */
$wgEnableMultiDeleteExt = true;

/**
 * @name wgEnableMultiWikiEditExt
 * enable/disable MultiWikiEdit extension
 */
$wgEnableMultiWikiEditExt = true;

/**
 * @name wgEnableTabViewExt
 * enable/disable TabView extension
 */
$wgEnableTabViewExt = true;

/**
 * @name wgEnableGoogleDocsExt
 * enable/disable GoogleDocs extension
 */
$wgEnableGoogleDocsExt = true;

/**
 * @name wgEnableJSVariablesExt
 * enable/disable JSVariables extension
 */
$wgEnableJSVariablesExt = true;

/**
 * @name wgEnableEditcountExt
 * enable/disable Editcount extension
 */
$wgEnableEditcountExt = true;

/**
 * @name $wgEnableMultiUploadExt
 * enable/disable MultiUpload extension
 */
$wgEnableMultiUploadExt = true;

/**
 * @name wgWikiaEnableSharedTalkExt
 * enable WikiaSharedTalk extension, enabled by default. Demand shared database
 * (so doesn't work on uncyclopedia)
 */
$wgWikiaEnableSharedTalkExt = true;

/**
 * @name $wgWikiaEnableDPLExt
 * Enable/Disable dpl extension
 */
$wgWikiaEnableDPLExt = false;

/**
 * @name $wgWikiaEnableDPLForum
 * Enable/Disable DPL forum
 */
$wgWikiaEnableDPLForum = true;

/**
 * @name $wgWikiaDisableAllDPLExt
 * Enable/Disable all DPL extensions (DPL + DPL forum)
 */
$wgWikiaDisableAllDPLExt = false;

/**
 * @name $wgShowHostnames
 * Display server hostname in page source code
 */
$wgShowHostnames = true;

/**
 * @name wgWikiaEnableWikiFactoryExt
 * enable WikiFactory extension
 */
$wgWikiaEnableWikiFactoryExt = false;

/**
 * @name wgWikiaEnableWikiFactoryRedir
 * enable WikiFactory Redirector
 */
$wgWikiaEnableWikiFactoryRedir = true;

/**
 * @name wgWikiaTaskDirectory;
 * path to Task Manager working directories
 */
$wgWikiaTaskDirectory = "/home/wikia/taskmanager/";

/**
 * @name wgEnableWikiaWhiteListExt
 * enable WikiaWhiteList extension
 */
$wgEnableWikiaWhiteListExt = true;

/**
 * @name wgAllowExternalWhitelistImages;
 * enable External image white-list
 */
$wgAllowExternalWhitelistImages = true;

/**
 * @name wgEditInterfaceWhitelist
 * List of NS_MEDIAWIKI pages that users are allowed to edit
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
	'Communitymessages-notice-msg',
	'Communitypage-tasks-header-welcome',
	'Communitypage-subheader-welcome',
	'Communitypage-policy-module-link-page-name',
	'Community-to-do-list',
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
	'User-identity-box-group-bureaucrat',
	'User-identity-box-group-chatmoderator',
	'User-identity-box-group-content-moderator',
	'User-identity-box-group-council',
	'User-identity-box-group-founder',
	'User-identity-box-group-helper',
	'User-identity-box-group-rollback',
	'User-identity-box-group-staff',
	'User-identity-box-group-sysop',
	'User-identity-box-group-threadmoderator',
	'User-identity-box-group-voldev',
	'User-identity-box-group-vstf',
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

$wgVerbatimBlacklist = [
	// CE-2559
	'AP',
	'AP1',
	'AP2',
	'AP3',
	'AP4',
	'MP',
	'MP1',
	'MP2',
	'MP3',
	'MP4',
];

/*
 * @name $wgWikiaEnableCreatepageExt
 * Special:Createpage extension
*/
$wgWikiaEnableCreatepageExt = true;
$wgWikiaDisableDynamicLinkCreatePagePopup = false;
$wgWikiaEnableNewCreatepageExt = true;

/**
 * @name wgWikiaEnableConfirmEditExt
 * enable captcha protection
 * @see #2191
 */
$wgWikiaEnableConfirmEditExt = false;

/**
 * @name wgEnableCaptchaExt
 *
 * Toggles the new Wikia Captcha extension.
 */
$wgEnableCaptchaExt = true;

/**
 * @name wgUserSignupDisableCaptcha
 *
 * Disables Captcha on user signup. Captcha should be enabled by default
 */
$wgUserSignupDisableCaptcha = false;

/**
 * @name $wgEnableArticleMetaDescription
 * enable meta-description tag for Articles
 */
$wgEnableArticleMetaDescription = true;

/**
 * @see $wgGenerateThumbnailOnParse
 */
$wgGenerateThumbnailOnParse = false;

/**
 * @name $wgDisableAnonymousEditing
 * enable/disable anonymous editing. See includes/wikia/CustomSettings.php
 */
$wgDisableAnonymousEditing = false;

/**
 * @name $wgEnableSiteWideMessages
 * enable/disable SiteWideMessages
 */
$wgEnableSiteWideMessages = true;


/**
 * Enables widget tag
 */
$wgEnableWidgetTag = true;

/**
 * @name wgEnableLookupContribsExt
 * Enable Lookup Contribs extension
 */
$wgEnableLookupContribsExt = false;

/**
 * @name wgEnableVerbatimExt
 * Enable Verbatim extension
 */
$wgEnableVerbatimExt = false;

/**
 *  PLATFORM-1179: Transition from internal mail back end to postfix.
 *  Both settings go through sendgrid, so wgForceSendGrid was a poorly named variable
 *  WikiaDB uses the "wikiadb" Factory and goes through wikia_mailer database queue
 *  Postfix uses the "smtp" Factory and goes directly to postfix
 */

$wgEnableWikiaDBEmail = false;
$wgEnablePostfixEmail = true;

/* @name $wgEnableTorBlockExt
 * Enables TorBlock extension (core)
 */
$wgEnableTorBlockExt = true;

/**
 * @name $wgEnableWhereIsExtensionExt
 * Enables WhereIsExtension (wikia)
 */
$wgEnableWhereIsExtensionExt = false;

/**
 * @name $wgEnableReCaptchaExt
 * Enable ReCaptcha extension (3rdparty)
 */
$wgEnableReCaptchaExt = true;

/**
 * @name $wgEnableAntiBotExt
 * Enables AntiBot extension
 */
$wgEnableAntiBotExt = true;

/**
 * @name $wgNotAValidWikia
 * Defines the address of a redirect when accesing not existing wiki
 * @see $wgEnableNotAValidWikiaExt
 */
$wgNotAValidWikia = "http://community.{$wgWikiaBaseDomain}/wiki/Community_Central:Not_a_valid_community";

/**
 * @name $wgEnableInterwikiDispatcherExt
 * Enables InterwikiDispatcher extension
 */
$wgEnableInterwikiDispatcherExt = true;

/**
 * @name $wgEnableExternalStorage
 * enable/disable external storage
 *
 * CAUTION: switching to false is not enough! One have to migrate back
 * all external revisions back to internal.
 */
$wgEnableExternalStorage = true;
$wgDefaultExternalStore = array( "DB://blobs20141" );
$wgExternalStores = array( "DB" );

/**
 * @name $wgBiggestCategoriesBlacklist
 * Lists phrases that disqualify a category from appearing in
 * the biggest category list (Monaco sidebar)
 *
 * Expand with caution.
 */
$wgBiggestCategoriesBlacklist = array('Image', 'images', 'Stub', 'stubs', 'Screenshot', 'screenshots', 'Screencap', 'screencaps',
		'Article', 'articles', 'Copy_edit', 'Fair_use', 'File', 'files', 'Panel', 'panels', 'Redirect', 'redirects', 'Template',
		'templates', 'Delete', 'deletion', 'TagSynced', 'Vorlagen', 'Dateien_nach_Lizenz', 'Lizenzvorlagen', 'Forenbeiträge',
		'Opisy_licencji', 'Szablony', 'Banned', 'Article_management_templates', 'Browse', 'Category_templates', 'Community',
		'Content', 'Copyright', 'Emoticons', 'Forums', 'General_wiki_templates', 'Help', 'Help_desk', 'Image_wiki_templates',
		'Infobox_templates', 'Policy', 'Public_domain_files', 'Site_administration', 'Site_maintenance',
		'Template_documentation', 'Watercooler', 'page', 'pages', 'need', 'needs', 'needed', 'needing', 'wiki', 'wikify',
		'templated', 'request', 'requests', 'requested', 'candidate', 'candidates', 'nomination', 'nominated', 'merge', 'merged',
		'cleanup', 'attention', 'infobox', 'deleting', 'Hidden_categories',
		/* rt#73258 */
		'Administration', 'Allgemeine_Vorlagen', 'Artikel-Vorlagen',
		'Begriffsklärung', 'Bildzitat', 'CC-by', 'CC-by-1.0', 'CC-by-2.0',
		'CC-by-2.5', 'CC-by-sa', 'CC-by-sa-1.0', 'CC-by-sa-2.0', 'CC-by-sa-2.5',
		'CC-sa-1.0', 'Code-Vorlagen', 'Copyrighted_free_use', 'Datei-Vorlagen',
		'Dateien', 'Dateien_von_flickr', 'Dringende_Löschanträge', 'FAL',
		'Forum', 'GFDL', 'GPL', 'Infobox-Vorlagen', 'Inhalt', 'Instandhaltung',
		'Kategorie-Vorlagen', 'LGPL', 'Lizenz_unbekannt', 'Löschanträge',
		'Neue_Seiten', 'PD', 'Skript-Benutzerkonten_von_Wikia',
		'Candidatas_para_borrado', 'Destruir', 'Esbozo', 'Esbozos',
		'Desambiguaciones', 'Administración_del_sitio', 'Ayuda', 'Comunidad',
		'Contenidos', 'Desambiguaciones', 'Foros', 'General', 'Imágenes',
		'Mesa_de_ayuda', 'Plantillas', 'Plantillas_de_categoría',
		'Plantillas_de_imágenes', 'Plantillas_de_mantenimiento',
		'Plantillas_generales', 'Políticas', 'Vídeos',
		);

/**
 * @name $wgEnableHardRedirectsWithJSText
 * enables Hardredirect extension
 */

$wgEnableHardRedirectsWithJSText = true;

$wgEnableSpecialSitemapExt = true;

/*
 * @name $wgEnableEditAccount
 * Enable EditAccount extension (Wikia)
 */
$wgEnableEditAccount = false;

/**
 * @name $wgEnableGlobalWatchlistExt
 * enables GlobalWatchlist extension
 */
$wgEnableGlobalWatchlistExt = true;
$wgDefaultUserOptions['watchlistdigest'] = 1;

/**
 * @name $wgLangToCentralMap
 * what lang have localized central wiki
 *
 * any url will do, it can be a page, too
 */
$wgLangToCentralMap = [
	'de' => "http://de.{$wgWikiaBaseDomain}/wiki/Wikia",
	'es' => "http://es.{$wgWikiaBaseDomain}/wiki/Wikia",
	'fr' => "http://fr.{$wgWikiaBaseDomain}/wiki/Accueil",
	'ja' => "http://ja.{$wgWikiaBaseDomain}/wiki/Wikia",
	'pl' => "http://pl.{$wgWikiaBaseDomain}/wiki/Wikia_Polska",
	'pt' => "http://pt-br.{$wgWikiaBaseDomain}/wiki/Wikia_em_Português",
	'ru' => "http://ru.{$wgWikiaBaseDomain}/wiki/Викия_на_русском",
	'zh' => "http://zh-tw.{$wgWikiaBaseDomain}/wiki/Wikia中文"
];

/*
 * @name wgSWMSupportedLanguages
 * array of languages supported in SWM extension
 */
$wgSWMSupportedLanguages = array( 'en', 'de', 'es', 'fr', 'it', 'pl', 'ja', 'nl', 'pt', 'ru', 'zh' );

/**
 * @name $wgEnableGadgetsExt
 * Enables Gadgets extension (MediaWiki)
 */
$wgEnableGadgetsExt = false;

/*
 * MediaWiki extensions requested by community
 */

/**
 * @name wgEnableBlogArticles
 * enable new blog articles (not NYC code!)
 */
$wgBlogAvatarSwiftContainer = 'common';
$wgBlogAvatarSwiftPathPrefix = '/avatars';
$wgBlogAvatarPath = "{$wgVignetteUrl}/common/avatars";
$wgEnableBlogArticles = true;

/**
 * @name $wgTemplateExcludeList
 * array containing excluded templates in the `most included` list - used by WYSIWYG editor
 */
$wgTemplateExcludeList = array('!');

/**
 * @name wgEnableTagsReport
 * enable special page displaying articles with special tags
 */
$wgEnableTagsReport = true;

/**
 * @name $wgUniversalCreationVariables
 * auxiliary variable used by CreateWiki task
 */
$wgUniversalCreationVariables = array();

/**
 * @name $wgLangCreationVariables
 * auxiliary variable used by CreateWiki task
 */
$wgLangCreationVariables = array();

/**
 * @name $wgEnableSearchNearMatchExt
 * enable few <s>search</s> go hooks
 */
$wgEnableSearchNearMatchExt = true;

/**
 * @name $wgWikiaEnableSharedHelpExt
 * enables SharedHelp extension (Wikia)
 */
$wgWikiaEnableSharedHelpExt = true;
$wgAvailableHelpLang = array(
		'en' => 177, /* default */
		'ca' => 3487, // Catalan, Help wiki same as for Spanish (es)
		'de' => 1779,
		'es' => 3487,
		'fi' => 3083,
		'fr' => 10261,
		'it' => 11250,
		'ja' => 3439,
		'ko' => 10465,
		'nl' => 10466,
		'pl' => 1686,
		'pt' => 696403,
		'pt-br' => 696403,
		'ru' => 3321,
		'uk' => 791363,
		'vi' => 423369,
		'zh' => 4079,
		'zh-classical' => 4079,
		'zh-cn' => 4079,
		'zh-hans' => 4079,
		'zh-hant' => 4079,
		'zh-hk' => 4079,
		'zh-min-nan' => 4079,
		'zh-mo' => 4079,
		'zh-my' => 4079,
		'zh-sg' => 4079,
		'zh-tw' => 4079,
		'zh-yue' => 4079,
		);

/**
 * @name wgEnableCentralHelpSearchExt
 * enables easy help search form tag (Wikia)
 */
$wgEnableCentralHelpSearchExt = false;

/**
 * @name $wgEnableVideoToolExt
 * enables Video Embed tool
 */
$wgEnableVideoToolExt = true;

/**
 * @name wgVETNonEnglishPremiumSearch
 * enables Enable premium videos search for non-English wikis
 */
$wgVETNonEnglishPremiumSearch = true;

/**
 * @name wgVETEnableSuggestions
 * enables suggestion in Video Embed Tool
 */
$wgVETEnableSuggestions = true;

/**
 * @name $wgAllowNonPremiumVideos
 * allows to upload non premium videos
 */
$wgAllowNonPremiumVideos = true;

/**
 * @name $wgEnableFlagClosedAccountsExt
 * enables special flagging of closed accounts, see EditAccount extension
 */
$wgEnableFlagClosedAccountsExt = true;

$wgEnableMyHomeExt = true;

/**
 * @name wgEnableHAWelcomeExt
 * enables Automatic Welcome Extension
 * @see extensions/wikia/HAWelcome/HAWelcome.php
 */
$wgEnableHAWelcomeExt = false;
$wgAvailableHAWLang = array(
		'br', 'ca', 'de', 'en', 'es', 'fa', 'fi', 'fr', 'gl', 'he', 'hu', 'ia', 'id', 'it',
		'ja', 'mk', 'nl', 'no', 'oc', 'pl', 'pms', 'pt', 'pt-br', 'ru', 'sv', 'tl', 'uk', 'vi',
		'zh', 'zh-classical', 'zh-cn', 'zh-hans', 'zh-hant', 'zh-hk', 'zh-min-nan', 'zh-mo', 'zh-my', 'zh-sg', 'zh-tw', 'zh-yue' );

/**
 * @name wgEnableCreateBoxExt
 * enables create box widget (replacement of our old hacked inputbox)
 * @see extensions/CreateBox/CreateBox.php
 */
$wgEnableCreateBoxExt = true;

/**
 * @name wgEnableAdsInContent
 * enables ads in content
 *
 * value is 0 to disable, 1+ to enable and set # of ads
 */
$wgEnableAdsInContent = 1;

/**
 * @name wgCrossoriginScssFile
 * enable CORS for this SCSS file
 */
$wgCrossoriginScssFile = 'skins/oasis/css/core/ads.scss';

// Enable CategorySelect extension for all not RTL wikis
if(!in_array($wgLanguageCode, array('ar','fa','he','ps','yi'))) {
	$wgEnableCategorySelectExt = true;
}

/**
 * @name wgEnableRandomWikiExt
 * enables RandomWiki extension (Wikia)
 * @see extensions/wikia/RandomWiki/SpecialRandomWiki.php
 */
$wgEnableRandomWikiExt = false;

/**
 * @name wgEnableRandomWikiOasisButton
 * enables RandomWiki button on Oasis skin (Wikia)
 * @see extensions/wikia/RandomWiki/SpecialRandomWiki.php
 */
$wgEnableRandomWikiOasisButton = true;

/**
 * @name wgWikiaEnableYouTubeExt
 * enables YouTube extension (Wikia)
 * @see extensions/wikia/YouTube/
 */
$wgWikiaEnableYouTubeExt = true;

/**
 * @name wgProtectsiteLimit
 * controls the maximum time a site can be locked
 * by the Protectsite extension
 */
$wgProtectsiteLimit = '12 hours';


/**
 * @name wgEnableWikiaIrcGatewayExt
 * enables WikiaIrcGateway extensions (Wikia)
 * @see extensions/wikia/WikiaIrcGateway/
 */
$wgEnableWikiaIrcGatewayExt = true;

/**
 * Show a bar of language selection links in the user login and user
 * registration forms; edit the "loginlanguagelinks" message to
 * customise these
 *
 * @see includes/DefaultSettings.php
 */
//uncommented as part of fix #135575
$wgLoginLanguageSelector = true; # waiting for ComTeam decision

/**
 * List of langs where Answers widget should appear
 *
 * @see extensions/wikia/WidgetFramework/Widgets/WidgetAnswers
 */
$answersIP = "$IP/extensions/wikia/Answers";
$wgEnableAnswersMonacoWidget = true;
$wgAvailableAnswersLang = array( 'en', 'de', 'es', 'fr', 'it', 'ja', 'no', 'nn', 'nb', 'nl', 'pl', 'pt', 'pt-br', 'zh' );
$wgAnswersURLs = array(
		# Defaults to lang.answers.wikia.com if no override is given here
		'en' => "answers.{$wgWikiaBaseDomain}",
		'de' => "frag.{$wgWikiaBaseDomain}",
		'es' => "respuestas.{$wgWikiaBaseDomain}",
		'fr' => "reponses.{$wgWikiaBaseDomain}",
		'it' => "risposte.{$wgWikiaBaseDomain}",
		'no' => "svar.{$wgWikiaBaseDomain}",
		'nn' => "svar.{$wgWikiaBaseDomain}",
		'nb' => "svar.{$wgWikiaBaseDomain}",
		'nl' => "antwoorden.{$wgWikiaBaseDomain}",
		'pl' => "zapytaj.{$wgWikiaBaseDomain}",
		'pt' => "respostas.{$wgWikiaBaseDomain}",
		'pt-br' => "respostas.{$wgWikiaBaseDomain}",
		'zh' => "zh.answers.{$wgWikiaBaseDomain}",
		);

/**
 * @name wgSkipCountForCategories
 * add here titles for categories which should be skipped when category counter
 * is updated
 * @see Article::updateCategoryCounts
 */
$wgSkipCountForCategories = array();

/**
 * @name $wgEnableDumpsOnDemandExt
 * show information about xml database dumps
 *
 * @see extensions/wikia/WikiFactory/Dumps/
 */
$wgEnableDumpsOnDemandExt = true;

/**
 * @name $wgMaxThumbnailArea
 * Don't create thumbnails bigger than 3000x3000
 *
 * @see $wgMaxImageArea
 */
$wgMaxThumbnailArea = 0.9e7;

/*
 * @name $wgEnableImagePlaceholderExt
 * Enables ImagePlaceholder extension (Wikia)
 */
$wgEnableImagePlaceholderExt = true;

/*
 * @name $wgAmericanDates
 * switches default date key to render mdy instead of dmy
 * rt#22063
 */
$wgAmericanDates = true;

/*
 * @name $wgEnableAutoincrementExt
 * enables Autoincrement extension (core, for import)
 */
$wgEnableAutoincrementExt = false;

/*
 * @name $wgDumpsDisabledWikis
 * list of wiki IDs that should not be dumped
 */
$wgDumpsDisabledWikis = array(
		43339, # lyrics.wikia.com
		60540, # fr.lyrics.wikia.com
		78733, # websitewiki.wikia.com
		);

/*
 * @name $wgEnableStaffPowersExt
 * enables StaffPowers extension (Wikia)
 * @see extensions/wikia/StaffPowers/StaffPowers.php
 */
$wgEnableStaffPowersExt = true;

/*
 * @name $wgEnableWikiaSearchExt
 * enables Search extension (Wikia)
 */
$wgEnableWikiaSearchExt = true;

/**
 * @name $wgEnableFandomStoriesOnSearchResultPage
 * enables Fandom Stories module on Search Result Page
 */
$wgEnableFandomStoriesOnSearchResultPage = true;

/*
 * @name $wgEnableCrossWikiaSearch
 * enables cross-wikia search mode (Wikia Search Extension)
 */
$wgEnableCrossWikiaSearch = false;

/*
 * @name $wgCrossWikiaSearchExcludedWikis
 * a list of wikis that shouldn't be searched (Wikia Search Extension)
 */
$wgCrossWikiaSearchExcludedWikis = array(
		11557 /* answers.wikia.com */,
		425 /* uncyclopedia.wikia.com */,
		177 /* central */,
		95 /* scratchpad */,
		13604, 40726, 46734, 43960, 43963, 43964, 43965, 43966, 43967, 43952, /* techteam-qa1-10 */
		/** various foreign-language uncyclopedias **/
		667, 766, 1049, 483, 1238, 1183, 857, 2113, 2526, 5003, 4876, 1416, 1524, 859, 2219, 1159, 2794, 2258, 1183, 1512,
		/** end uncyclopedias **/
		);

/*
 * @name $wgWikiaSearchSupportedLanguages
 * language codes for supported fields
 */

$wgWikiaSearchSupportedLanguages = array(	'ar', 'bg', 'ca', 'cz', 'da', 'de', 'el',
				   		'en', 'es', 'eu', 'fa', 'fi', 'fr', 'ga',
						'gl', 'hi', 'hu', 'hy', 'id', 'it', 'ja',
					 	'ko', 'lv', 'nl', 'no', 'pl', 'pt', 'ro',
						'ru', 'sv', 'sv', 'th', 'tr', 'zh'
					);


/*
 * @name $wgWikiaSearchIsDefault
 * Moves Special:WikiaSearch page to Special:Search
 */
$wgWikiaSearchIsDefault	= true;

/*
 * @name $wgDisableFandomStoriesSearchResultsCaching
 * Disables 24-hour caching of fandom stories search results by search terms
 */
$wgDisableFandomStoriesSearchResultsCaching = false;

/*
 * @name $wgEnableFandomStoriesSearchLogging
 * Logs an informational message each time a fandom stories request is performed
 */
$wgEnableFandomStoriesSearchLogging = false;

/*
 * @name $wgEnableSearchRequestShadowing
 * Enables shadowing of fandom stories search requests
 */
$wgEnableSearchRequestShadowing = false;

/*
 * @name $wgSearchRequestSamplingRate
 * Specifies the search requests sampling rate (0 - 100)
 */
$wgSearchRequestSamplingRate = 0;

/*
 * @name $wgEnableRichEmails
 * enables HTML emails
 */
$wgEnableRichEmails = true;

/**
 * @name wgEnableSemanticMediaWikiExt
 *
 * enable SemanticMediaWiki main module, do not use triplestore by default
 */
$wgEnableSemanticMediaWikiExt = false;

/*
 * @name: $wgEnableCommunityWidget
 * enables community (ActivityFeed) widget
 */
$wgEnableCommunityWidget = true;

/*
 * @name: $wgEnableActivityFeedTagExt
 * enables activityfeed tag
 */
$wgEnableActivityFeedTagExt = true;

/*
 * @name: $wgEnableGracenoteExt
 * enables Gracenote extension (for lyrics wikis)
 * @see extensions/3rdparty/LyricWiki/Gracenote
 */
$wgEnableGracenoteExt = false;

/*
 * @name: $wgEnableLirycsTagExt
 * enables custom lyrics tag (for lyrics wikis)
 * @see extensions/3rdoarty/LyricWiki/Tag_Lyric.php
 */
$wgEnableLyricsTagExt = false;

/*
 * @name: $wgEnableLeftNavWidget
 * @see extensions/wikia/WidgetFramework/Widget/WidgetLeftNav/
 */
$wgEnableLeftNavWidget = null;

$wgAvailableLetNavWidgetLang = array( 'en', 'de', 'fr', 'es', 'pl', 'nl' );

/*
 * @name: $wgCaptchaTriggers
 * used by ConfirmEdit extension
 */
$wgCaptchaTriggers = array();
$wgCaptchaTriggers['edit']          = false; // Would check on every edit
$wgCaptchaTriggers['create']	    = false; // Check on page creation.
$wgCaptchaTriggers['addurl']        = true;  // Check on edits that add URLs
$wgCaptchaTriggers['createaccount'] = true;  // Special:Userlogin&type=signup
$wgCaptchaTriggers['badlogin']      = false;  // Special:Userlogin after failure

/*
 * @name $wgCaptchaTriggersOnNamespace
 * used by ConfirmEdit extension
 */
$wgCaptchaTriggersOnNamespace = array();
$wgCaptchaTriggersOnNamespace[NS_TALK]['create'] = true; // rt#19728
$wgCaptchaTriggersOnNamespace[110]['create'] = true; // rt#21729
$wgCaptchaTriggersOnNamespace[111]['create'] = true; // rt#21729

/*
 * @name: $wgEnableArticleCommentsExt
 * enable ArticleComments extension
 */
$wgEnableArticleCommentsExt = false;

/*
 * @name: $wgEnableArticleWatchlist
 * enables Add to Watchlist on comment feature
 */
$wgEnableArticleWatchlist = true;

/*
 * @name: $wgArticleCommentsNamespaces
 * namespaces where ArticleComments is enabled
 */
$wgArticleCommentsNamespaces = array(NS_MAIN, 500 /*NS_BLOG_ARTICLE*/);

/*
 * @name: $wgArticleCommentsHideDiscussionTab
 * Determine to show or hide discussion tab when ArticleComments are enabled (default: hide)
 */
$wgArticleCommentsHideDiscussionTab = true;

/*
 * @name $wgArticleCommentsLoadOnDemand
 * Whether or not to load Article Comments on page load or on demand (default: on page load)
 */
$wgArticleCommentsLoadOnDemand = true;

/*
 * @name: $wgEnablePiggybackExt
 * enable Special:Piggyback extension
 * @see extensions/wikia/Piggyback
 */
$wgEnablePiggybackExt = true;

/*
 * @name: $wgEnableStaffLogExt
 * enable StaffLog extension
 * @see extensions/wikia/StaffLog
 */
$wgEnableStaffLogExt = true;

/*
 * @name: $wgEnableStaffLogSpecialPage
 * enable StaffLog special page (required $wgEnableStaffLogExt)
 * @see extensions/wikia/StaffLog
 */
$wgEnableStaffLogSpecialPage = false;

/*
 * @name: $wgWikiaUseNoFollow
 * at wikia.com we render many links with rel=nofollow attribute
 */
$wgWikiaUseNoFollow = true;

/*
 * @name $wgWikiaUseNoFollowForContent
 * switch defining whether to use nofollow for red (non-existant) content links
 */
$wgWikiaUseNoFollowForContent = true;

/*
 * @name: $wgWikiaEnableSpecialProtectSiteExt
 * enable ProtectSite extension (Wikia)
 * @see extensions/wikia/SpecialProtectSite
 */
$wgWikiaEnableSpecialProtectSiteExt = true;

/**
 * @name wgEnableSemanticMapsExt
 * @see extensions/SemanticMaps
 */
$wgEnableSemanticMapsExt = false;

/**
 * @name wgEnableRandomInCategoryExt
 * @see extensions/RandomInCategory
 */
$wgEnableRandomInCategoryExt = true;

$wgEnableWikiaMainpageFixer = true;

/**
 * @name wgEnableWikiaPhotoGalleryExt
 * @see extensions/wikia/WikiaPhotoGallery
 *
 * WikiaPhotoGallery should be enabled together with ImageLightbox
 */
$wgEnableWikiaPhotoGalleryExt = true;

/**
 * @name wgEnableLightboxExt
 * @see extensions/wikia/Lightbox
 */
$wgEnableLightboxExt = true;

/**
 * @name wgVideoPageAutoPlay
 * @see extensions/wikia/VideoPage.php
 *
 * Play videos on file page load
 */
$wgVideoPageAutoPlay = true;

/**
 * @name wgEnableWikiaFollowedPagesOnlyPrefs
 * @see Contractor /Watchlist_improvements
 */
$wgEnableWikiaFollowedPagesOnlyPrefs = true;

/**
 * @name wgEnableRTEExt
 * @see extensions/wikia/RTE/RTE_setup.php
 */
$wgEnableRTEExt = true;
$wgWysiwygDisabledNamespaces = array();

/**
 * @name wgEnableOggHandlerExt
 */
$wgEnableOggHandlerExt = true;

/**
 * @name wgEnableWikiaFollowedPages
 * @see https://contractor.wikia-inc.com/wiki/Watchlist_improvements
 */
$wgEnableWikiaFollowedPages = true;

/**
 * @name wgWikiaBotLikeUsers
 * array containing user accounts that are used as bots but do not have the bot flag
 */
$wgWikiaBotLikeUsers = [
		'Wikia',
		'Default',
		'WikiaStaff',
		'Maintenance script',
		'CreateWiki script',
		'WikiaBot',
		'QATestsStaff',
		'Fandom',
		'FandomBot',
];

/**
 * Enable scribe report
 */
$wgEnableScribeReport = true;

/**
 * @name wgEnableTabberExt
 */
$wgEnableTabberExt = true;

/**
 * @name wgEnablePhalanxExt
 * @see extensions/wikia/Phalanx
 */
$wgEnablePhalanxExt = true;

/**
 * @name wgEnableSpecialPhalanxExt
 * @see extensions/wikia/Phalanx
 */
$wgEnableSpecialPhalanxExt = false;

/**
 * @name wgPhalanxSupportedLanguages
 * array containing list of languages for which admin can create blocks / filters
 * @FIXME language names are already defined elsewhere
 */
$wgPhalanxSupportedLanguages = array(
		'all' => 'All languages',
		'en' => 'English',
		'de' => 'German',
		'es' => 'Spanish',
		'fr' => 'French',
		'it' => 'Italian',
		'pl' => 'Polish',
		'ru' => 'Russian',
		);


/**
 * @name wgEnableCommunityMessagesExt
 * @see "Merge Sitenotice into Community Corner" project
 */
$wgEnableCommunityMessagesExt = true;

/**
 * Show achievement badges in activity feed below the RecentChange which
 * earned them.
 */
$wgEnableAchievementsInActivityFeed = true;

/**
 * Store achievements data in per-wiki tables instead of global db (wikicities)
 */
$wgEnableAchievementsStoreLocalData = true;

/**
 * @name wgArticleCommentsMaxPerPage
 */
$wgArticleCommentsMaxPerPage = 25;

/**
 * Enable the extension which listens for postbacks (about boundes, unsubscribes, opens, etc.) from SendGrid.
 */
$wgEnableSendGridPostback = true;

/**
 * @name wgEnableRecipesTweaksSavedPages
 * fine-grained control of a RecipesTweaks component (rt#65841)
 */
$wgEnableRecipesTweaksSavedPages = true;

/**
 * @name wgEnableCategoryGalleriesExt
 * Enables category galleries extension
 */
$wgEnableCategoryGalleriesExt = true;

/**
 * @name wgCategoryGalleryEnabledByDefault
 * Sets if category gallery will be shown by default
 */
$wgCategoryGalleryEnabledByDefault = true;

/**
 * @name wgEnableOpenXSPC
 * Switch to turn on/off OpenX Single-Page call of ads
 * NOTE: this can be overridden to false by setting
 * wgEnableSpotlightsV2_GlobalNav,
 * wgEnableSpotlightsV2_Rail or
 * wgEnableSpotlightsV2_Footer to false
 */
$wgEnableOpenXSPC = false;

/**
 * @name wgUseWikiaNewFiles
 * Enables new look for Special:NewFiles
 */
$wgUseWikiaNewFiles = true;

/**
 * @name wgEnablePartnerFeedExt
 * Enabled Partner Feeds
 */
$wgEnablePartnerFeedExt = true;

/**
 * @name $wgEnableAutomaticWikiAdoptionExt
 * enables Automatic Wiki Adoption extension
*/
$wgEnableAutomaticWikiAdoptionExt = true;

/**
 * @name $wgEnableAutomaticWikiAdoptionMaintenanceScript
 * enables Automatic Wiki Adoption maintenance script (checked on central in script)
 */
$wgEnableAutomaticWikiAdoptionMaintenanceScript = true;

/**
 * @name wgEnableRelatedPagesExt
 * Enables Related Pages extension and Oasis module
 */
$wgEnableRelatedPagesExt = true;

/**
 * @name wgEnableHideTagsExt
 * @see extensions/wikia/HideTags/HideTags.php
 */
$wgEnableHideTagsExt = true;

// temporary
$wgDefaultSkinBeforeWF = $wgDefaultSkin;
$wgDefaultSkin = null;

/**
 * @name $wgEnableNukeExt
 * enables Special:Nuke on all wikis (but not for sysops by default)
 */
$wgEnableNukeExt = true;

/**
 * @name $wgWikiaNukeLocal
 * enables Special:Nuke for sysops
 */
$wgWikiaNukeLocal = false;

/**
 * @name $wgWikiaEnableContentFeedsExt
 * enables Content Feeds extension
 */
$wgWikiaEnableContentFeedsExt = true;

/*
 * AbuseFilter stuff
 * force defaults to exist, so theres no confusion
 */
$wgEnableAbuseFilterExtension = false;
$wgEnableAbuseFilterExtensionForSysop = true; #by default, give AF access this to sysops
$wgWikiaManualAbuseFilterRights = false; #by default, use a standard set of sysop+VHS rights
$wgAbuseFilterBlockDuration = 'indefinite'; #by default, blocks user to infinity

/**
 * Category Exhibition default parameters
 */
$wgCategoryExhibitionPagesSectionRows = 4;
$wgCategoryExhibitionBlogsSectionRows = 4;
$wgCategoryExhibitionSubCategoriesSectionRows = 4;
$wgCategoryExhibitionMediaSectionRows = 4;

/**
 * @name $wgEnablePaginatorExt
 * enables paginator on all wikias
 */
$wgEnablePaginatorExt = true;

/**
 * @name $wgEnablePerSkinParserCacheExt
 * Enables per-skin wikitext parser cache
 * True by default since is a requirement for image SEO
 */
$wgEnablePerSkinParserCacheExt = true;

/**
 * @name $wgWikiaConfRevision
 * Provides the current conf revision number for Special:Version
 */
$wgWikiaConfRevision = '$HeadURL$';

/**
 * @name $wgEnableCreateNewWiki
 * Enables CreateNewWiki extention
 */
$wgEnableCreateNewWiki = false;

/**
 * @name $wgEnableFinishCreateWiki
 * Enables FinishCreateWiki part of CreateNewWiki extension
 */
$wgEnableFinishCreateWiki = true;

/**
 * Controls on which cluster new wiki databases are being created during the CreateNewWiki process
 */
$wgCreateDatabaseActiveCluster = "c7";

/**
 * @name $wgEnableGameGuidesExt
 * Enables the GameGuides mobile app extension
 */
$wgEnableGameGuidesExt = true;

/**
 * @name $wgEnableCuratedContentExt
 * Enables the CuratedContent extension
 */
$wgEnableCuratedContentExt = true;

/**
 * @name $wgGameGuidesContentForAdmins
 * Enables the GameGuides Content Managment Tool for admins
 */
$wgGameGuidesContentForAdmins = true;

/**
 * @name $wgPrettyUrlWithTitleAndQuery
 * When calling getLocalURL() or getFullURL() on Title object with non-empty query, URLs are like:
 * for false (default), no query:    http://a.wikia.com/wiki/Article
 * for false (default), with query:  http://a.wikia.com/index.php?title=Article&query=1
 * for true, no query:               http://a.wikia.com/wiki/Article
 * for true, with query:             http://a.wikia.com/wiki/Article?query=1
 */
$wgPrettyUrlWithTitleAndQuery = true;

/**
 * @name $wgEnableOpenGraphMetaExt
 * Enables OpenGraphMeta extension (core) and our customizations on it
 * @see extensions/OpenGraphMeta/
 * @see extensions/wikia/OpenGraphMetaCustomizations
 */
$wgEnableOpenGraphMetaExt = true;

/**
 * @name $wgEnableForumIndexProtector
 * Enables a hook that prevents anon from editing Forum:Index
 */
$wgEnableForumIndexProtector = true;

/**
 * @name $wgEnableChat
 * Enables the Special:Chat realtime-chat and associated rail modules, etc.
 */
$wgEnableChat = false;

/**
 * @name $wgChatPublicHost
 * Default chat host. According to environment we are in, can be prefixed with environment name taken
 * from $wgWikiaEnvironment variable.
 */
$wgChatPublicHost = 'chat.wikia-services.com:80';

/**
 * @name $wgChatPublicHostOverride
 * Overrides $wgChatPublicHost.
 * For development & testing purposes, set this variable to host and port of your machine.
 */
$wgChatPublicHostOverride = null;

/**
 * @name $wgChatPrivateServerOverride
 * Chat server API address, by default (if not set) taken from consul.
 * For development & testing purposes, set this variable to host and port of your machine.
 */
$wgChatPrivateServerOverride = null;

/**
 * Make sure the asset loading variables are set correctly for staging (preview. & verify.)
 * Enable JS server-side logging on staging servers
 */

if ( !empty($wgStagingEnvironment) ) {

	$wgWikiaCdnPrefix = $wgWikiaEnvironment;
	if ( $wgWikiaEnvironment === WIKIA_ENV_SANDBOX ) {
		$wgWikiaCdnPrefix = gethostname();
	}
	$stagingWiki = $wgMedusaHostPrefix ?: 'community.';
	$wgStylePath        = "//{$stagingWiki}{$wgWikiaCdnPrefix}.{$wgWikiaBaseDomain}/skins";
	$wgExtensionsPath   = "//{$stagingWiki}{$wgWikiaCdnPrefix}.{$wgWikiaBaseDomain}/extensions";
	$wgResourceBasePath = "//{$stagingWiki}{$wgWikiaCdnPrefix}.{$wgWikiaBaseDomain}";
	$wgCdnRootUrl = "//{$stagingWiki}{$wgWikiaCdnPrefix}.{$wgWikiaBaseDomain}";
	$wgCdnApiUrl = $wgCdnRootUrl;

	$wgDefaultRobotPolicy = 'noindex,nofollow'; # BugId:5127
}

/**
 * @name $wgEnableOneDotPlus
 * Enables the logging of events in an asyncronous manner via the OneDot call
 * @see extensions/wikia/WikiStats
 */
$wgEnableOneDotPlus = true;

/**
 * @name $wgEnableEditPageLayoutExt
 * Turns on the new edit page layout
 * @see extensions/wikia/EditPageLayout
 */
$wgEnableEditPageLayoutExt = true;

/**
 * @name $wgMaximizeArticleAreaArticleIds
 * Article IDs to maximize area for article content (e.g. hide rail module)
 * Should be set in WikiFactory
 * @see skins/oasis/modules/BodyModule.class.php
 */
$wgMaximizeArticleAreaArticleIds = array();

/**
 * @name $wgEnableSyntaxHighlightGeSHiExt
 * Enables a javascript (client side) parsing and coloring system (CSS) for JS and CSS pages
 * Should be set in WikiFactory
 * @see http://www.mediawiki.org/wiki/Extension:SyntaxHighlight_GeSHi
 */
$wgEnableSyntaxHighlightGeSHiExt = true;

/**
 * @name $wgEnableAntiSpoofExt
 * Enables AntiSpoof extension (Wikia)
 */
$wgEnableAntiSpoofExt = true;

/**
 * @name $wgEnableSpecialUnsubscribeExt
 * Enables SpecialUnsubscribe extension (Wikia)
 */
$wgEnableSpecialUnsubscribeExt = true;


/**
 * @name $wgWikiaEnableFounderEmailsExt
 * Enables FounderEmails extension (Wikia)
 */

$wgWikiaEnableFounderEmailsExt = true;

/**
 * @name $wgEnableCanonicalHref
 * Enable CanonicalHref extension (Wikia)
 */
$wgEnableCanonicalHref = true;

/**
 * @name $wgEnableCategoryBlueLinks
 * Enables CategoryBlueLinks extension (Wikia)
 */
$wgEnableCategoryBlueLinks = true;

/**
 * @name $wgEnableAdminDashboardExt
 * Enables AdminDashboard extension (Wikia)
 */
$wgEnableAdminDashboardExt = true;

/**
 * @name $wgEnableFounderProgressBarExt
 * Enables FounderProgressBar extension (Wikia)
 * (this will be enabled for new wikis during new wiki creation)
 */
$wgEnableFounderProgressBarExt = false;

/**
 * @name wgEnableMobileContentExt
 * enables MobileContent extension
 */
$wgEnableMobileContentExt = false;

/**
 * @name wgEnableSpecialWithoutimagesExt
 * enames Special:Withoutimages
 * @see extensions/wikia/SpecialWihtoutimages/
 */
$wgEnableSpecialWithoutimagesExt = true;

/**
 * @name $wgLookupContribsExcluded
 *
 * A list of db names excluded on Special:LookupContribs page (bugId:6196)
 *
 * @see extensions/wikia/LookupContribs/SpecialLookupContribs_helper.php line 262
 * @author Andrzej 'nAndy' Łukaszewski
 */
$wgLookupContribsExcluded = [];

/*
 * @name wgEnableWikiFeatures
 * Enable Wiki Features extension
 */
$wgEnableWikiFeatures = true;

/*
 * @name wgEnableMercuryPiggyback
 * This will cause Special:Piggyback to redirect to Mercury's Piggyback.
 */
$wgEnableMercuryPiggyback = true;

/**
 * @name $wgEnableWikiaSpecialVersionExt
 * enable wiki special version page
 */
$wgEnableWikiaSpecialVersionExt = true;

/**
 * @name $wgWikiaVideoRepoDBName
 * DB name of wiki that contains Wikia Video
 */
$wgWikiaVideoRepoDBName = 'video151';

/**
 * @name $wgWikiaVideoRepoPath
 * URL prefix for the Wikia Video repo
 */
$wgWikiaVideoRepoPath = "http://video.{$wgWikiaBaseDomain}/";

/**
 * @name $wgWikiaVideoRepoDirectory
 * filesystem path for video thumbnails
 */
$wgWikiaVideoRepoDirectory = '/images/v/video151/images';

/**
 * @name $wgEnableTracking
 * Enables the page and event tracking extention
 */
$wgEnableTracking = true;

/**
 * @name $wgEnableFileInfoFunctionsExt
 * Enables FileInfoFunctions extension
 */
$wgEnableFileInfoFunctionsExt = false;


/**
 * @name $wgEnablePlacesExt
 * Enables the Places extension
 */
$wgEnablePlacesExt = false;

/*
 * @name $wgOasisNavV2
 * Enable redesigned wiki navigation menu
 */
$wgOasisNavV2 = true;

/**
 * List of videos providers that we support in mobile
 */
$wgWikiaMobileSupportedVideos = [
	'screenplay',
	'ign',
	'ooyala',
	'youtube',
	'dailymotion',
	'vimeo',
	'bliptv',
	'uStream',
	'makerstudios'
];

/**
 * List of videos providers that we support in mobile app
 */
$wgWikiaMobileAppSupportedVideos = [
	'ooyala',
	'youtube',
];

/**
 * @name $wgEnableUserPreferencesV2Ext
 * Enables the second version of user preferences page (Special:Preferences).
 */
$wgEnableUserPreferencesV2Ext = true;

/**
 * All wikis migrated
 */
$wgVideoHandlersVideosMigrated = true;

/**
 * @name $wgEnableMiniEditorExt
 * Enables the MiniEditor extension (see: extensions/wikia/MiniEditor).
 */

$wgEnableMiniEditorExtForArticleComments = true;
$wgEnableMiniEditorExtForForum = false;
$wgEnableMiniEditorExtForWall = true;

/**
 * @name $wgEnableImageReviewExt
 * Enables ImageReview extension
 */
$wgEnableImageReviewExt = false;

/**
 * @name $wgEnableWDACReviewExt
 * Enables WDACReview (Wikis Directed at Children) tool
 */
$wgEnableWDACReviewExt = false;


/**
 * @name $wgEnableKruxTargeting
 * Enables Krux ad targeting
 */
$wgEnableKruxTargeting = true;

/**
 * @name $wgEnableCategoryIntersectionExt
 * Enables the CategoryIntersection API call and the Special:CategoryIntersection page
 * which serves as an interface to demonstrate the API call's functionality.
 */
$wgEnableCategoryIntersectionExt = false;

###################################################################################
# DC specific settings                                                            #
###################################################################################
switch ($wgWikiaDatacenter) {
	case 'res':
		# TODO: spread these settings inside this file to more appropriate places

		$wgDBserver   = "10.12.60.107"; #db-ra1

		###############################################################################
		#                             MEMCACHED CONFIGURATION                         #
		###############################################################################

		$wgReadOnly = "Our main datacenter is down, you are accessing our backup datacenter. We are working to fix the problem";
		$wgDBReadOnly = true;

		break;
}

/**
 * Mediawiki has a check in IEUrlExtension::areServerVarsBad for this variable
 * If server=Apache, it uses REQUEST_URI, otherwise QUERY_STRING
 * Our current Apache rewrite rule for __load changes QS but cannot change REQ_URI
 * By unsetting this variable, we go down the code path which works without changing core
 */
unset( $_SERVER['SERVER_SOFTWARE'] );

/**
 * @name $wgSuppressSpotlights
 * disable footer spotlights in Oasis
 */
$wgSuppressSpotlights = false;

/**
 * @name $wgSuppressWikiHeader
 * disable wiki header and wiki navigation in Oasis
 */
$wgSuppressWikiHeader = false;

/**
 * Memcache disabling stuff
 * &mpurge=none|readonly|writeonly
 * behavior controlled by Wikia::memcachePurge in Wikia.php
 */
$wgAllowMemcacheDisable = $wgAllowMemcacheReads = $wgAllowMemcacheWrites = true;

/**
 * @name $wgEnableGlobalUsageExt
 * Enables GlobalUsage extension (core)
 */
$wgEnableGlobalUsageExt = true;
$wgGlobalUsageDatabase = $wgWikiaVideoRepoDBName;

/**
 * @name $wgEnableForumExt
 * Enable the Forum extension
 */
$wgEnableForumExt = true;

/**
 * @name $wgEnableAbTesting
 * Enable the new split testing (a/b testing) powered
 * by the data-warehouse.
 */
$wgEnableAbTesting = true;

/**
 * @name $wgEnableContentWarningExt
 * Enable ContentWarning extension
 */
$wgEnableContentWarningExt = false;

/**
 * @name $wgEnableRecentChangesExt
 * Enable RecentChanges extension
 */
$wgEnableRecentChangesExt = true;

/**
 * @name $wgEnableCommentCSVExt
 * Enables the CommentCSV extension (see: extensions/wikia/CommentCSV).
 */
$wgEnableCommentCSVExt = true;

/**
 * @name wgEnableGameProAds
 * "Multiswitch" for GamePro ads setup
 *
 * @see CommonExtensions
 */
$wgEnableGameProAds = null;
$wgAvailableGameProAdsLang = array( 'de' );

/**
 * @name wgEnableTitleBlacklistExt
 * enable/disable TitleBlacklist extension
 */
$wgEnableTitleBlacklistExt = true;

/**
 * @name $wgEnableSpecialVideosExt
 * Enable SpecialVideos extension
 */
$wgEnableSpecialVideosExt = true;

/**
 * @name $wgEnableArticlesAsResourcesExt
 * Enable ArticlesAsResources extension
 */
$wgEnableArticlesAsResourcesExt = true;

/**
 * @name $wgEnableImageLazyLoadExt
 * Enable ImageLazyLoad extension
 */
$wgEnableImageLazyLoadExt = true;

/**
 * @name $wgWikiaGameGuidesContent
 * Variable that stores data for Wikia Game Guides content managment tool and application itself
 */
$wgWikiaGameGuidesContent = array();

/**
 * @name $wgEnableWikiaMobileSmartBanner
 * enable Smart Banner
 */
$wgEnableWikiaMobileSmartBanner = null;

/**
 * @name $wgWikiaMobileSmartBannerConfig
 * configuration for a smart banner
 *
 * @example
 *  [
 * 		'disabled' => 0,
 * 		'name' => 'Warframe'
 * 		'icon' => 'url/to/icon' // this can be full url or relative to extensions folder
 * 		'meta' => [
 * 			'apple-itunes-app' => 'app-id=739263891',
 * 			'google-play-app' => 'app-id=com.wikia.singlewikia.warframe'
 * 		]
 * ]
 */
$wgWikiaMobileSmartBannerConfig = null;

/**
 * @name $wgEnableWallExt
 * Enables Wall extension; should stay false here because it's being set by users in Special:WikiFeatures
 */
$wgEnableWallExt = false;

/**
 * @name $wgEnableWikiaBarExt
 * Enables Wikia Bar extension
 */
$wgEnableWikiaBarExt = true;

/**
 * @name wgWikiaBarMainLanguages
 * Determinates on which language wikis WikiaBar's default state will be "displayed"
 */
$wgWikiaBarMainLanguages = array( 'en', 'de', 'es', 'fr' );

/**
 * @name $wgOasisGrid
 * Enables WikiaGrid which makes our content container wider by 30px (1030px)
 */
$wgOasisGrid = true;

/**
 * fix performance issue in linkcache
 * if ( $wgAntiLockFlags & ALF_NO_LINK_LOCK ) then it will skip select "for update"
 * ask owen or geoff for details
 */
$wgAntiLockFlags = ALF_NO_LINK_LOCK;


/**
 * @name $wgVideoBlacklist
 * Comma-separated list of blacklisted words. Videos that contain them in title, keywords or description won't be ingested
 */
$wgVideoBlacklist = '';

/**
 * @name $wgVideoKeywordsBlacklist
 * Comma-separated list of blacklisted keywords that will be ommited while ingesting video (the video itself will be ingested)
 */
$wgVideoKeywordsBlacklist = '';

/**
 * @name $wgEnableVisualEditorExt
 * Enable the VisualEditor extension (duh!)
 */
$wgEnableVisualEditorExt = true;

/**
 * @name $wgVisualEditorNoCache
 */
$wgVisualEditorNoCache = false;

/**
 * @name $wgEnableVisualEditorUI
 * Enable the entry points to VisualEditor
 */
$wgEnableVisualEditorUI = false;

/**
 * Allow wiki match results for on-wiki search
 */
$wgOnWikiSearchIncludesWikiMatch = false;

/**
 * Set default value for showing the video page redesign
 */
$wgEnableVideoPageRedesign = true;

/**
 * Variable for defining limit of reuses of an image before it is regarded as ineligible for use as a thumbnail of article
 */
$wgImageServingMaxReuseCount = 10;

/**
 * @name wgBacklinksEnabled
 * Says whether or not to index outbound links for backlink support in Solr
 */
$wgBacklinksEnabled = false;

/**
 * @name wgExtractInfoboxes
 * Says whether we should be storing infobox info in a special Solr field
 */
$wgExtractInfoboxes = false;

/**
 * @name wgEnableSpecialCssExt
 * Enables Special:CSS
 */

$wgEnableSpecialCssExt = true;

/**
 * @name wgWikiaGameGuidesSponsoredVideos
 * Variable that stores data for Wikia Game Guides sponsored videos list
 */
$wgWikiaGameGuidesSponsoredVideos = [];

/**
 * Default wiki url for UserPageRedirects
 */
$wgCorporatePageRedirectWiki = "http://community.{$wgWikiaBaseDomain}/wiki/";

/**
 * @name wgAllVideosAdminOnly
 * When true, restricts video upload to admin/sysop only
 */
$wgAllVideosAdminOnly = false;


/**
 * Maximum number of Unicode characters in signature
 */
$wgMaxSigChars = 1200;

/**
 * @name $wgEnableVideoPageToolExt
 * Enable VideoPageTool extension
 */
$wgEnableVideoPageToolExt = false;

// re-defined in environment specific LocalSettings.php
if ( $wgDevelEnvironment ) {
	$wgFSSwiftServer = false;
	$wgFSSwiftConfig = [];
} else {
	$wgFSSwiftServer = $wgFSSwiftDC[ $wgWikiaDatacenter ][ 'server' ];
	$wgFSSwiftConfig = $wgFSSwiftDC[ $wgWikiaDatacenter ][ 'config' ];
}

/*
 * @name wgAvatarsUseService
 * Use user avatars service instead of direct operations on DFS
 *
 * @see PLATFORM-1419
 * @see PLATFORM-1453
 */
$wgAvatarsUseService = true;

/*
 * @name wgAvatarsMaintenance
 * Disable avatars related operations (uploads and deletes)
 */
$wgAvatarsMaintenance = false;

/*
 * @name wgAutomatedTestsIPsList
 * List of IPs that can disable captcha on UserSignup
 */
$wgAutomatedTestsIPsList = [];

/**
 * @name $wgEnableCoppaToolExt
 * Enables COPPA tool
 */
$wgEnableCoppaToolExt = false;

/**
 * @name $wgEnableTopicsForDFP
 * Enables the use of topics in DFP
 */
$wgEnableTopicsForDFP = false;

/**
 * @name $wgEnableAbuseFilterBypass
 * whether or not the abuse filter bypass extension is enabled
 */
$wgEnableAbuseFilterBypass = true;

/**
 * @name $wgOasisLoadCommonCSS
 * Makes MediaWiki:Common.css load in Oasis
 */
$wgOasisLoadCommonCSS = false;

/**
 * @name $wgLoadCommonCSS
 * Makes MediaWiki:Common.css load in Oasis
 */
$wgLoadCommonCSS = false;

/**
 * @name $wgBlockedAnalyticsProviders
 * Banned analytics providers
 */
$wgBlockedAnalyticsProviders = array('IVW');

/**
 * @name $wgUseMimeMagicLite
 * Turn on/off use of the MimeMagicLite class.  If off, MimeMagic
 * will be used instead of MimeMagicLite
 */
$wgUseMimeMagicLite = true;

/**
 * @name $wgMaxPPNodeCount
 * A complexity limit on template expansion
 */
$wgMaxPPNodeCount = 300000;

/*
 * @name $wgEnableVideosModuleExt
 * Enables the Videos Module extension
 */
$wgEnableVideosModuleExt = null;

/**
 * @name wgVideosModuleCategories
 * Stores page categories for Videos Module extension
 */
$wgVideosModuleCategories = [];

/*
 * A list of metadata fields that we should filter out when displaying on the file page
 * VID-714
 */
$wgFilePageFilterMetaFields = [
	'videoid' => 1,
	'altvideoid' => 1,
	'thumbnail' => 1,
	'sourceid' => 1,
	'videourl' => 1,
	'marketplaceid' => 1,
	'categoryid' => 1,
	'uniquename' => 1,
	'stdbitratecode' => 1,
	'jpegbitratecode' => 1,
	'streamurl' => 1,
];

/**
 * @name $wgEnablePoolCounter
 * Enables the PoolCounter
 */
$wgEnablePoolCounter = true;
$wgPoolCounterServers = [
	'prod.kubernetes-lb-l4.service.consul'
];

/**
 * Search config (PLATFORM-1759)
 *
 * @name $wgSolrMaster
 * points to the master index host (responsible for replicating index to slaves)
 * this must be kept consistent with our actual solr master
 *
 * @name $wgSolrDefaultPort
 * points to the default port where solr is listening
 */
$wgSolrHost = 'prod.search-fulltext.service.consul';
$wgSolrKvHost = 'prod.search-kv.service.consul';
$wgSolrMaster = 'prod.search-master.service.sjc.consul';
$wgSolrPort = $wgSolrDefaultPort = 8983;
$wgSolrProxy = false; # call Solr directly, instead of using a default HTTP proxy

/**
 * @name $wgLyricsApiSolrariumConfig
 * The name of solr core for Lyrics API extension
 */
$wgLyricsApiSolrariumConfig = [
	'adapter' => 'Solarium_Client_Adapter_Curl',
	'adapteroptions' => [
		'core' => 'lyricsapi',
		'host' => $wgSolrHost,
		'path' => '/solr/',
		'port' => $wgSolrPort,
		'proxy' => $wgSolrProxy,
	]
];

/*
 * @name $wgEnableEditorPreference
 * Enables the Editor Preference extension
 */
$wgEnableEditorPreferenceExt = true;

/*
 * @name $wgDefaultUserOptions
 * Default editor is VisualEditor. This is used in app/extensions/wikia/EditorPreference/EditorPreference.class.php
 */
$wgDefaultUserOptions['editor'] = 2;

/*
 * @name $wgEnableEditorSyntaxHighlighting
 * Enables WikitextEditorHighlighting extension
 */
$wgEnableEditorSyntaxHighlighting = true;

/**
 * @name $wgEnableScribuntoExt
 * Enables the Scribunto (Lua templating) extension
 */
$wgEnableScribuntoExt = true;

/**
 * @name $wgEnableCloseMyAccountExt
 * Enables the CloseMyAccount extension
 */
$wgEnableCloseMyAccountExt = true;
// Languages to actively link to CloseMyAccount in
$wgSupportedCloseMyAccountLang = [
	'en', 'de', 'es', 'fr', 'it', 'ja', 'pl', 'pt', 'pt-br',
	'ru', 'zh', 'zh-classical', 'zh-cn', 'zh-hans', 'zh-hant',
	'zh-hk', 'zh-min-nan', 'zh-mo', 'zh-my', 'zh-sg', 'zh-tw',
	'zh-yue',
];

$wgXhprofUDPHost = 'graph-s3';
$wgXhprofUDPPort = '3911';

/**
 * @name $wgVisualEditorNeverPrimary
 * Disallow VisualEditor to ever appearing as a main/default/primary editor
 */
$wgVisualEditorNeverPrimary = false;

/**
 * @name $wgEnableMWSuggest
 *
 * Disable MWSuggest (not used in new global navigation)
 */
$wgEnableMWSuggest = false;

/**
 * @name wgVignetteReplaceThumbnails
 *
 * Force vignette requests to replace existing thumbnails instead of serving
 * them directly from storage.
 */
$wgVignetteReplaceThumbnails = false;

/**
 * @name wgEnableLinkToMobileAppExt
 *
 * Enables LinkToMobileApp extension (adds LINK element in head for use in Android)
 */
$wgEnableLinkToMobileAppExt = false;

/**
 * @name wgWikiaMobileAppPackageId
 *
 * Sets main (common/global) part of app ID for the LinkToMobileApp extension
 */
$wgWikiaMobileAppPackageId = 'com.wikia.singlewikia';

/**
 * @name $wgEnableWikiaInYourLangExt
 * Enables WikiaInYourLang extension that displays a notification to a user
 * if a visited English wikia is available in his native language
 * @see CE-1103
 */
$wgEnableWikiaInYourLangExt = true;

/**
 * Enables Asynchronous caching of Video views
 * This will replace the cron job generating the views for all videos in every wikia
 * @see VID-2103, UC-140, UC-141
 */
$wgEnableAsyncVideoViewCache = true;

/**
 * @name $wgVisualEditorSupportedSkins
 *
 * List of skins VisualEditor integration supports
 */
$wgVisualEditorSupportedSkins = array( 'oasis', 'venus' );

/**
 * @name $wgEnableRegisterUnconfirmed
 *
 * Allow users register account without email confirmation
 */
$wgEnableRegisterUnconfirmed = false;

/**
 * @name $wgPageShareServices
 *
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
 */
$wgPageShareServices = [
	[
		'name' => 'line',
		'title' => 'Line',
		'href' => 'http://line.me/R/msg/text/?$title $url',
		'languages:include' => ['ja'],
		'displayOnlyOnTouchDevices' => true,
	],[
		'name' => 'vkontakte',
		'title' => 'VK',
		'href' => 'http://vkontakte.ru/share.php?url=$url',
		'languages:include' => ['ru'],
	], [
		'name' => 'facebook',
		'title' => 'Facebook',
		'href' => 'https://www.facebook.com/sharer/sharer.php?u=$url',
	], [
		'name' => 'odnoklassniki',
		'title' => 'Odnoklassniki',
		'href' => 'http://connect.odnoklassniki.ru/dk?cmd=WidgetSharePreview&st.cmd=WidgetSharePreview&st._aid=ExternalShareWidget_SharePreview&st.shareUrl=$url',
		'languages:include' => ['ru'],
	], [
		'name' => 'twitter',
		'title' => 'Twitter',
		'href' => 'https://twitter.com/share?url=$url',
		'languages:exclude' => ['zh'],
	], [
		'name' => 'googleplus',
		'title' => 'Google+',
		'href' => 'https://plus.google.com/share?url=$url',
		'languages:include' => ['ja'],
	], [
		'name' => 'meneame',
		'title' => 'Menéame',
		'href' => 'http://meneame.net/submit.php?url=$url',
		'languages:include' => ['es'],
	], [
		'name' => 'reddit',
		'title' => 'Reddit',
		'href' => 'http://www.reddit.com/submit?url=$url',
		'languages:exclude' => ['ja', 'zh', 'de', 'fr', 'es', 'ru', 'pl'],
	], [
		'name' => 'tumblr',
		'title' => 'Tumblr',
		'href' => 'http://www.tumblr.com/share/link?url=$url',
		'languages:exclude' => ['ja', 'zh', 'fr', 'ru', 'pl'],
	], [
		'name' => 'weibo',
		'title' => 'Sina Weibo',
		'href' => 'http://service.weibo.com/share/share.php?url=$url&title=$title',
		'languages:include' => ['zh'],
	], [
		'name' => 'nk',
		'title' => 'NK',
		'href' => 'http://nk.pl/sledzik/widget?content=$url',
		'languages:include' => ['pl'],
	], [
		'name' => 'wykop',
		'title' => 'Wykop',
		'href' => 'http://www.wykop.pl/dodaj/link/?url=$url&title=$title&desc=$description',
		'languages:include' => ['pl'],
	],
];

/**
 * @name $wgEnableEmailExt
 *
 * Enable the new email framework
 */
$wgEnableEmailExt = true;

/**
 * @name wgEditPreviewMercuryUrl
 *
 * URL of the Mercury preview endpoint
 */
$wgEditPreviewMercuryUrl = '/article-preview';

/**
 * @name $wgEnablePortableInfoboxExt
 *
 * Enable Portable Infobox extensions
 */
$wgEnablePortableInfoboxExt = true;
$wgEnablePortableInfoboxBuilderExt = true;
$wgEnablePortableInfoboxEuropaTheme = false;
$wgEnablePortableInfoboxBuilderInVE = true;
$wgEnablePortabilityDashboardExt = false;

/**
 * @name $wgEnableInsightsExt
 *
 * Enables Insights extension
 */
$wgEnableInsightsExt = true;

/**
 * @name $wgEnableInsightsInfoboxes
 *
 * Enables non-portable infoboxes category on Special:Insights
 */
$wgEnableInsightsInfoboxes = true;

/**
 * @name $wgEnablePopularPagesQueryPage
 *
 * Enables query page to fetch data about popular pages
 */
$wgEnablePopularPagesQueryPage = true;

/**
 * @name $wgEnableInsightsPopularPages
 *
 * Enables Popular pages Insights subpage
 */
$wgEnableInsightsPopularPages = true;

/**
 * @name $wgEnableInsightsBlogpostRedirectExt
 *
 * Enable extension for redirecting Special:Insights to help page when the page itself is not enabled
 */
$wgEnableInsightsBlogpostRedirectExt = true;

/**
 * @name $wgEnableMainPageDataMercuryApi
 *
 * Enable sending MainPageData (ie CuratedContent data) via MercuryAPI calls
 */
$wgEnableMainPageDataMercuryApi = true;

/**
 * @name $wgEnableNewAuth
 * This variable enables new Mercury based login and registration flow for a community.
 */
$wgEnableNewAuth = true;

/**
 * @name $wgEnableNewAuthModal
 * Enables new popup-based authentication
 */
$wgEnableNewAuthModal = true;

/**
 * @name wgEnableTemplateDraftExt
 *
 * Enables TemplateDraft extensions
 */
$wgEnableTemplateDraftExt = true;

$wgInjectorCacheClassProvider = function() {
	return new Doctrine\Common\Cache\ArrayCache();
};

/**
 * @name $wgLocalUserPreferenceWhiteList
 *
 * List of local user preferences (options) which is used
 * for filtering when preferences are being set
 */
$wgLocalUserPreferenceWhiteList = [
	'regexes' => [
		"^adoptionmails-([0-9]+)",
		"^founderemails-complete-digest-([0-9]+)$",
		"^founderemails-edits-([0-9]+)$",
		"^founderemails-joins-([0-9]+)$",
		"^founderemails-views-digest-([0-9]+)$",
	]
];

/**
 * @name $wgGlobalUserPreferenceWhiteList
 *
 * List of global user preferences (options) which is used
 * for filtering when preferences are being set
 */
$wgGlobalUserPreferenceWhiteList = [
	'literals' => [
		"CategoryExhibitionDisplayType",
		"CategoryExhibitionSortType",
		"ccmeonemails",
		"cols",
		"contextchars",
		"createpagedefaultblank",
		"createpagepopupdisabled",
		"date",
		"diffonly",
		"disablecategoryselect",
		"disablelinksuggest",
		"disablemail",
		"disablesuggest",
		"disablesyntaxhighlighting",
		"disablewysiwyg",
		"editfont",
		"editondblclick",
		"editor",
		"editsection",
		"editsectiononrightclick",
		"editwidth",
		"enableGoSearch",
		"enableuserjs",
		"enableWatchlistFeed",
		"EnableWysiwyg",
		"enotiffollowedpages",
		"enotifminoredits",
		"enotifrevealaddr",
		"enotifdiscussionsfollows",
		"enotifdiscussionsvotes",
		"enotifusertalkpages",
		"enotifwallthread",
		"enotifwatchlistpages",
		"enotifyme",
		"extendwatchlist",
		"externaldiff",
		"externaleditor",
		"forceeditsummary",
		"hideEditsWikis",
		"hidefollowedpages",
		"hidefromattribution",
		"hideminor",
		"hidepatrolled",
		"hidepersonalachievements",
		"highlightbroken",
		"htmlemails",
		"imageReviewSort",
		"imagesize",
		"language",
		"marketingallowed",
		"math",
		"memory-limit",
		"minordefault",
		"myhomedefaultview",
		"myTools",
		"newpageshidepatrolled",
		"nocache",
		"noconvertlink",
		"norollbackdiff",
		"NotConfirmedLogin",
		"numberheadings",
		"oasis-toolbar-promotions",
		"previewonfirst",
		"previewontop",
		"quickbar",
		"rcdays",
		"RCFilters",
		"rclimit",
		"rememberpassword",
		"riched_disable",
		"riched_start_disabled",
		"riched_toggle_remember_state",
		"riched_use_popup",
		"riched_use_toggle",
		"rows",
		"searchAllNamespaces",
		"searcheverything",
		"searchlimit",
		"show_task_comments",
		"showAds",
		"showhiddencats",
		"showjumplinks",
		"shownumberswatching",
		"showtoolbar",
		"skin",
		"skinoverwrite",
		"smw-prefs-ask-options-collapsed-default",
		"smw-prefs-ask-options-tooltip-display",
		"stubthreshold",
		"thumbsize",
		"timecorrection",
		"underline",
		"unsubscribed",
		"upwiz_deflicense",
		"uselivepreview",
		"usenewrc",
		"userlandingpage",
		"variant",
		"visualeditor-betatempdisable",
		"visualeditor-enable",
		"walldelete",
		"wallshowsource",
		"watchcreations",
		"watchdefault",
		"watchdeletion",
		"watchlistdays",
		"watchlistdigest",
		"watchlistdigestclear",
		"watchlisthideanons",
		"watchlisthidebots",
		"watchlisthideliu",
		"watchlisthideminor",
		"watchlisthideown",
		"watchlisthidepatrolled",
		"watchmoves",
		"watchsubpages",
		"widget_bookmark_pages",
		"widgets",
		"WikiaBarDisplayState",
		"wllimit"
	],
	'regexes' => [
		"([a-z]+)-toolbar-contents$",
		"^forum_sort_.*",
		"^gadget-.*",
		"^searchNs.*$",
		"^wall_sort_.*",
	]
];

/**
 * @name $wgEnableUserActivityExt
 *
 * Enable the UserActivity extensions
 */
$wgEnableUserActivityExt = false;

/**
 * TODO the logic behind what is a public versus private attribute should be handled in the
 * service. This is a temporary measure until we implement this logic on the service side.
 *
 * Public attributes which we want to store and make available via the attributes service
 */
$wgPublicUserAttributes = [
	"avatar",
	"avatar_rev",
	"bio",
	"coverPhoto",
	"fancysig",
	"fbPage",
	"location",
	"name",
	"nickname",
	"occupation",
	"twitter",
	"website",
	'wordpressId',
	"UserProfilePagesV3_birthday",
	"UserProfilePagesV3_gender"
];

/**
 * TODO the logic behind what is a public versus private attribute should be handled in the
 * service. This is a temporary measure until we implement this logic on the service side.
 *
 * These are attributes we don't currently want to store in the attribute service. They're
 * private and are only used by MW for the time being. Eventually these can be moved into
 * the attribute service once we implement some "visibility" of attributes in the service.
 */
$wgPrivateUserAttributes = [
	"birthday",
	"disabled_date",
	"disabled-user-email",
	"favoritelisttoken",
	"founderemails-counter",
	"gender",
	"LastAdoptionDate",
	"new_email",
	"realname",
	"registrationCountry",
	"requested-closure-date",
	"renameData",
	"SignUpRedirect",
	"swl_email",
	"swl_last_notify",
	"swl_last_view",
	"swl_last_watch",
	"swl_mail_count",
	"swl_watchlisttoplink",
	"watchlistAccessKey",
	"watchlisttoken",
];

$wgUserAttributeWhitelist = array_merge( $wgPublicUserAttributes, $wgPrivateUserAttributes );

/**
 * @name $wgDisableAnonymousUploadForMercury
 *
 * This is temporary. See https://wikia-inc.atlassian.net/browse/INT-155
 * We are enabling photo upload from mercury for JP wiki without login.
 * This is temporary solution to disable such uploads.
 */
$wgDisableAnonymousUploadForMercury = false;

/**
 * @wgWikiDirectedAtChildrenByFounder
 * Flag set by Wikia owner to indicate that the wikia is a COPPA wiki that
 * requires login for all edits
 */
$wgWikiDirectedAtChildrenByFounder = false;

/**
 * @wgWikiDirectedAtChildrenByStaff
 * Flag set by Wikia staff to indicate that the wikia is a COPPA wiki that
 * requires login for all edits
 */
$wgWikiDirectedAtChildrenByStaff = false;

/**
 * @wgDisableMobileSectionEditor
 * Flag set by Wikia staff to indicate that the Mercury section editor and
 * photo upload is disabled for this community
 */
$wgDisableMobileSectionEditor = false;

/**
 * Enables collecting data about session and lifetime wikia referrer
 */
$wgEnableVisitSourceExt = true;

/**
 * @name $wgEnableContentReviewExt
 *
 * Enables Content Review extension
 * To enable the extension wgUseSiteJs must also be true (see CommonExtensions.php:3160)
 */
$wgEnableContentReviewExt = true;

/**
 * @name $wgEnableContentReviewSpecialPage
 *
 * Enables Content Review Special Page
 */
$wgEnableContentReviewSpecialPage = false;

/**
 * @name $wgEnableGoogleFormTagExt
 *
 * Enables Google Form parser tag
 */
$wgEnableGoogleFormTagExt = true;

/**
 * @name $wgEnablePolldaddyTagExt
 *
 * Enables Polldaddy parser tag
 */
$wgEnablePolldaddyTagExt = true;

/**
 * @name $wgEnablePollSnackTagExt
 *
 * Enables PollSnack parser tag
 */
$wgEnablePollSnackTagExt = true;

/**
 * @name $wgEnableSoundCloudTagExt
 *
 * Enables SoundCloud parser tag
 */
$wgEnableSoundCloudTagExt = true;

/**
 * @name $wgEnableSpotifyTagExt
 *
 * Enables Spotify parser tag
 */
$wgEnableSpotifyTagExt = true;

/**
 * @name $wgEnableTwitterTagExt
 *
 * Enables Twitter parser tag
 */
$wgEnableTwitterTagExt = true;

/**
 * @name $wgEnableVKTagExt
 *
 * Enables VK parser tag
 */
$wgEnableVKTagExt = true;

/**
 * @name $wgEnableWeiboTagExt
 *
 * Enables Weibo parser tag
 */
$wgEnableWeiboTagExt = true;

// SEO-related variables start (keep them sorted)

/**
 * @name $wgEnableCategoryPaginationExt
 *
 * Replaces MediaWiki-style pagination with a modern pager on category pages
 */
$wgEnableCategoryPaginationExt = true;

/**
 * @name $wgEnableCustom404PageExt
 *
 * Enables custom 404 page for missing articles suggesting the closest matching article
 */
$wgEnableCustom404PageExt = null;

/**
 * @name $wgEnableCustom404PageExtInLanguages
 *
 * Content languages to enable Custom404Page extension on
 * (in addition to any wiki that specifically enables it through WikiFactory)
 */
$wgEnableCustom404PageExtInLanguages = ['en'];

/**
 * @name $wgEnableLocalSitemapPageExt
 *
 * Enables /wiki/Local_Sitemap article showing a tweaked version of Special:AllPages
 */
$wgEnableLocalSitemapPageExt = true;

/**
 * @name $wgEnableNotAValidWikiaExt
 *
 * Enables "Not a valid Wikia" page
 *
 * @see http://community.wikia.com/wiki/Community_Central:Not_a_valid_Wikia
 * @see $wgNotAValidWikia
 */
$wgEnableNotAValidWikiaExt = false;

/**
 * @name $wgEnableRobotsTxtExt
 *
 * Enables extension that generates robots.txt
 */
$wgEnableRobotsTxtExt = true;


/**
 * @name $wgRobotsTxtBlockedWikis
 *
 * Whether or not to block wiki in robots.txt
 */
$wgRobotsTxtBlockedWiki = false;

/**
 * @name $wgEnableSeoLinkHreflangExt
 *
 * Enables SEO Link Hreflang extension
 */
$wgEnableSeoLinkHreflangExt = false;

/**
 * @name $wgEnableSitemapPageExt
 *
 * Enable SitemapPage extension (global HTML sitemap listing all wikis)
 */
$wgEnableSitemapPageExt = false;

/**
 * @name $wgEnableSitemapXmlExt
 *
 * Enables the improved XML sitemaps (at /wiki/Special:SitemapXml)
 */
$wgEnableSitemapXmlExt = true;

/**
 * @name $wgEnableTwitterCardsExt
 * Enable TwitterCards extension
 */
$wgEnableTwitterCardsExt = true;
$wgTwitterAccount = '@getfandom';

/**
 * @name $wgSitemapXmlExposeInRobots
 *
 * Whether to point robots to the new XML sitemap in robots.txt
 */
$wgSitemapXmlExposeInRobots = true;

/**
 * @name $wgRobotsTxtCustomRules
 * The list of custom rules for robots.txt. Supported rules: allowSpecialPage and disallowNamespace.
 */
$wgRobotsTxtCustomRules = [ 'disallowNamespace' => [ NS_HELP, NS_USER ] ];

// SEO-related variables end

/**
 * Enables special Parser handling of templates classified by Template Classification Service
 * When switched to false, prevents the application from making any calls to Template Classification
 * Service during article parsing
 */
$wgEnableTemplateTypesParsing = true;
/**
 * Enables special Parser handling of specific template types
 */
$wgEnableReferencesTemplateParsing = true;
$wgEnableNavboxTemplateParsing = true;
$wgEnableNoticeTemplateParsing = true;
$wgEnableNavigationTemplateParsing = true;
$wgEnableScrollboxTemplateParsing = true;
$wgEnableQuoteTemplateParsing = true;
$wgEnableContextLinkTemplateParsing  = true;
$wgEnableInfoIconTemplateParsing = true;

/**
 * Enables special handling of data tables
 */
$wgEnableDataTablesParsing = true;

/**
 * Enables mercury article html cleanup
 */
$wgEnableMercuryHtmlCleanup = true;

/**
 * Enable the AppPromoLanding.
 */
$wgEnableAppPromoLandingExt = true;

/**
 * Enable TemplateClassification extension
 * and related Insights lists
 */
$wgEnableTemplateClassificationExt = true;
$wgEnableInsightsPagesWithoutInfobox = true;
$wgEnableInsightsTemplatesWithoutType = true;

/**
 * Enable discussions on Mercury
 */
$wgEnableDiscussions = false;

/**
 * Replace Forum links with links to Discussions.
 */
$wgEnableDiscussionsNavigation = false;

/**
 * Enables possibility to submit a post with OG or Image only.
 */
$wgEnableDiscussionsPostsWithoutText = false;

/**
 * Enable GlobalShortcuts extension
 */
$wgEnableGlobalShortcutsExt = true;

/**
 * Special:Discussions page to enable discussions on a wiki
 * JIRA Epic: Automate DisSites Q2_2016 (https://wikia-inc.atlassian.net/browse/SOC-2238)
 */
$wgEnableSpecialDiscussions = true;

/**
 * Special:DiscussionsLog page to view user logs for discussion users
 */
$wgEnableDiscussionsLog = true;

/**
 * @name $wgEnableRecirculationExt
 *
 * Enables the recirculation extension
 */
$wgEnableRecirculationExt = true;

/**
 * Disables showing articles in recirculation modules
 */
$wgDisableShowInRecirculation = false;

/**
 * Enable community data in curated main pages on mercury sitewide (SUS-1198)
 */
$wgEnableCommunityData = true;

/**
 * Enable the more permanenet version of the Community Page
 */
$wgEnableCommunityPageExt = false;

/**
 * Enable New Contribution Flow Dialog
 */
$wgEnableNCFDialog = false;

/**
 * Enable hiding of the Top Contributors module in Community Page
 */
$wgCommunityPageDisableTopContributors = false;

/**
 * FandomCreator enabled community
 */
$wgFandomCreatorCommunityId = false;

/**
 * Enable tracking for create new page flow
 */
$wgEnableFlowTracking = true;

/**
 * This control to turn off all emails should be set to false by default
 */
$wgDisableAllEmail = false;

/**
 * Controls if the community is approved for Wikia.org program
 */
$wgIsInWikiaOrgProgram = false;

/**
 * Enable Author Profile links in the DS API (FC-260 / FAN-1324)
 */
$wgEnableAuthorProfileLinks = true;


/**
 * Article featured video
 */
$wgEnableArticleFeaturedVideo = true;
$wgArticleVideoFeaturedVideos = [];
$wgArticleVideoFeaturedVideos2 = [];

/**
 * Featured video recommended videos label
 */
$wgFeaturedVideoRecommendedVideosLabel = 'Promoted';

/**
 * Article related video
 */
$wgEnableArticleRelatedVideo = true;

/**
 * First Contributions API module
 */
$wgEnableFirstContributionsExt = true;

/**
 * Apester Tag
 */
$wgEnableApesterTagExt = true;

/**
 * Playbuzz widget tag
 */
$wgEnablePlaybuzzTagExt = true;

/**
 * FandomApp SmartBanner switch
 */
$wgEnableFandomAppSmartBanner = false;

/**
 * Semantic Scribunto extensions
 */
$wgEnableSemanticScribuntoExt = false;

/**
 * Enable image upload in discussions-front-end
 */
$wgEnableDiscussionsImageUpload = true;

/**
 * Google Amp experiment
 */
$wgEnableGoogleAmp = false;
// list of namespaces for which AMP is enabled - for example [ 0 ]
$wgGoogleAmpNamespaces = [];
// list of titles (with NS prefix where needed) for which AMP is disabled
$wgGoogleAmpArticleBlacklist = [];
// Template for amp version of an article
$wgGoogleAmpAddress = 'http://{WIKI}.wikia.com/amp/{WIKI}/{ARTICLE}';

/**
 * JWPlayer's recommended videos playlist associated with a wiki
 */

$wgRecommendedVideoPlaylist = null;






require __DIR__.'/../config/LocalSettings.php';

/* @var $wgDBcluster string */
// in some cases $wgMemc is still null at this point, let's initialize it (SUS-2699)
$wgMemc = wfGetMainCache();

if ( WikiFactoryLoader::checkPerClusterReadOnlyFlag( $wgDBcluster ) ) {
	$wgReadOnly = WikiFactoryLoader::PER_CLUSTER_READ_ONLY_MODE_REASON;
}

# this has to be fired after extensions - because any extension may add some new permissions (initialized with their default values)
if ( !empty( $wgGroupPermissionsLocal ) ) {
	WikiFactoryLoader::LocalToGlobalPermissions( $wgGroupPermissionsLocal );
}

if (!empty($wgInjectorCacheClassProvider)) {
	\Wikia\DependencyInjection\InjectorInitializer::init($wgInjectorCacheClassProvider());
} else {
	\Wikia\DependencyInjection\InjectorInitializer::init();
}
