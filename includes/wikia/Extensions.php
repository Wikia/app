<?php
###############################################################################
#  Overwrite some variables, load extensions, etc. Former CustomSettings.php  #
###############################################################################

// TODO: Clean up after CK editor as default test is finished
if (isset( $wgCityId ) && is_numeric($wgCityId) ) {
	if ( in_array( intval( $wgCityId ), $wgCKEdefaultEditorTestWikis ) ) {
		$wgDefaultUserOptions['editor'] = 3;
	}
}

//can access ->cat_id or ->cat_name
$wgHub = WikiFactory::getCategory($wgCityId);

// SUS-4796 | force Oasis skin // FIXME remove after the post-sunset cleanup
$wgDefaultSkin = 'oasis';

# Language specific settings. Currently only used for $wgExtraNamespaces.
# Consider using /languages/messages/Wikia/ for customization.
# Please keep this in alphabetical order.
switch ( $wgLanguageCode ) {
	case "fi" :
		$wgExtraNamespaces[110] = 'Foorumi';
		$wgExtraNamespaces[111] = 'Keskustelu_foorumista';

		$wgNamespaceAliases['Forum'] = 110;
		$wgNamespaceAliases['Forum_talk'] = 111;
		break;

	case "no" :
		$wgExtraNamespaces[110] = 'Forum';
		$wgExtraNamespaces[111] = 'Forumdiskusjon';

		$wgNamespaceAliases['Forum'] = 110;
		$wgNamespaceAliases['Forum_talk'] = 111;
		break;

	case "pl" :
		$wgExtraNamespaces[110] = 'Forum';
		$wgExtraNamespaces[111] = 'Dyskusja_forum';

		//$wgNamespaceAliases['Forum'] = 110;
		$wgNamespaceAliases['Forum_talk'] = 111;
		break;

	case "ru" :
		$wgExtraNamespaces[110] = 'Форум';
		$wgExtraNamespaces[111] = 'Обсуждение_форума';

		$wgNamespaceAliases['Forum'] = 110;
		$wgNamespaceAliases['Forum_talk'] = 111;

		break;
	case "vi":
		$wgExtraNamespaces[110] = 'Diễn_đàn';
		$wgExtraNamespaces[111] = 'Thảo_luận_Diễn_đàn';

		$wgNamespaceAliases['Forum'] = 110;
		$wgNamespaceAliases['Forum_talk'] = 110;

		break;
	case "fa":
		$wgExtraNamespaces[110] = 'فوروم';
		$wgExtraNamespaces[111] = 'بحث_فوروم';

		break;

	case "es":
		$wgExtraNamespaces[110] = "Foro";
		$wgExtraNamespaces[111] = "Foro_Discusión";

		$wgNamespaceAliases["Forum"] = 110;
		$wgNamespaceAliases["Forum_talk"] = 111;

		break;
	case "ko":
		$wgExtraNamespaces[110] = "포럼";
		$wgExtraNamespaces[111] = "포럼토론";

		$wgNamespaceAliases["Forum"] = 110;
		$wgNamespaceAliases["Forum_talk"] = 111;

		break;
}

$wgNamespacesWithSubpages[110] = true; //Forum
$wgNamespacesWithSubpages[111] = true; //Forum talk

/*
 * WikisApi
 */
if ( ! empty( $wgEnableWikisApi ) ) {
	F::app()->registerApiController( 'WikisApiController', "{$IP}/includes/wikia/api/WikisApiController.class.php" );
}

/*
 * Code for http://lyrics.wikia.com/
 */
if ( ! empty( $wgEnableLyricWikiExt ) ) {
	$LW = "$IP/extensions/3rdparty/LyricWiki";
	include("$LW/Special_LinksToRedirects.php");
	include("$LW/lw_metaTags.php");
	include("$IP/extensions/wikia/WikiaApi/WikiaApiLyricwiki.php");
	include("$IP/extensions/3rdparty/LyricWiki/ImageServing_LyricWiki.php");
	include("$LW/SongOfTheDay/Special_SOTD.php");
	include("$LW/BetterLyricWikiTextSnippets.php");
	include("$LW/LyricsH1s.php");
	# Parser Extensions
	require_once "$LW/Parser_LWMagicWords.php";
	# Additional Tags
	require_once "$LW/Tag_XML.php";
	# New Special Pages
	require_once "$LW/Special_BatchMove.php";
	require_once "$LW/Special_Wikify.php";
	require_once "$LW/Special_WatchlistFeed.php";
	// We don't use this at the moment, so don't include it:
	// require_once "$LW/Special_GoogleSearch.php";
	# Other Extensions
	require_once "$LW/Templates.php";
	require_once "$LW/Hook_PreventBlanking.php";
	require_once "$LW/Special_ArtistRedirects.php";
	require_once "$LW/lw_spiderableBadArtists.php";
	require_once "$LW/lw_impliedRedirects.php";
	# Turn off subpages on the main namespace (otherwise every AC/DC song links back to "AC"), etc.
	$wgNamespacesWithSubpages[ NS_MAIN ] = false;

	require_once "$LW/LyricFind/LyricFind.setup.php";
}
/**
 * WgEnableHAWelcomeExt is enabled by default
 * Disable welcome tool if there is no available language
 */
if ( !in_array( $wgLanguageCode, $wgAvailableHAWLang ) ) {
	$wgEnableHAWelcomeExt = false;
}

if ( $wgEnableInsightsExt === null && in_array( $wgLanguageCode, $wgAvailableInsightsLang ) ) {
	$wgEnableInsightsExt = true;
}

if (empty($wgHelpWikiId)) {
	if (!empty($wgAvailableHelpLang[$wgLanguageCode])) {
		$wgHelpWikiId = $wgAvailableHelpLang[$wgLanguageCode];
	}
	else {
		$wgHelpWikiId = $wgAvailableHelpLang['en'];
	}
}

$wgLocalMessageCache = '/tmp/messagecache';

/**
 * List of readonly variables in WF (those can be changed
 * only by internal request via API)
 */
$wgWikiFactoryReadonlyBlacklist = [
	938, // AdTag is readonly
];

/**
 * The URL path of the icon for iPhone and iPod Touch web app bookmarks.
 * Defaults to no icon.
 * @see $wgLogo
 * @var string|bool
 */
$wgAppleTouchIcon = $wgLogo;

/**
 * define foreign file repo if there is shared upload
 */
if ( $wgSharedUploadDBname ) {
	$wgForeignFileRepos[] = array(
		'class'            => 'WikiaForeignDBViaLBRepo',  // WikiaForeignDBViaLBRepo enables cross-wiki video references
		'name'             => 'shared',
		'directory'        => $wgSharedUploadDirectory,
		'url'              => $wgSharedUploadPath,
		'hashLevels'       => $wgHashedSharedUploadDirectory ? 2 : 0,
		'hasSharedCache'   => $wgCacheSharedUploads,
		'descBaseUrl'      => $wgRepositoryBaseUrl,
		'fetchDescription' => $wgFetchCommonsDescriptions,
		'wiki'             => $wgSharedUploadDBname,
	);
}

/**
 * used in Monobook wikia div
 */
$wgWikicitiesNavLinks[] = array( 'text'=>'wikicitieshome', 'href'=>'wikicitieshome-url' );

putenv( 'GDFONTPATH=/usr/share/fonts/truetype/dejavu/' );
include_once "$IP/extensions/timeline/Timeline.php";
$wgTimelineSettings->fontFile = 'DejaVuSans.ttf';

if ( $wgDevelEnvironment ) {
	# lazy-load blobs from production when there's a miss on devbox blobs cluster
	include_once "$IP/extensions/wikia/Development/ExternalStoreDBFetchBlobHook.php";
}

if ( !empty( $wgEnableOpenGraphMetaExt ) ) {
	include( "$IP/extensions/OpenGraphMeta/OpenGraphMeta.php" );
	// Wikia-specific customizations to set image and description by ImageServing and ArticleService respectively.
	include( "$IP/extensions/wikia/OpenGraphMetaCustomizations/OpenGraphMetaCustomizations.setup.php");
}



if ( !empty( $wgEnableEditPageLayoutExt ) ) {
	include "$IP/extensions/wikia/EditPageLayout/EditPageLayout_setup.php";
}

/**
 * load extensions by using configuration variables
 */

#--- 5. EventCountdown
if (!empty($wgWikiaEnableEventCountdownExt)) {
	include("{$IP}/extensions/3rdparty/EventCountdown/EventCountdown.php");
}

#--- 12. MultiUpload
if( !empty( $wgEnableMultiUploadExt ) ) {
	if( empty($wgMaxUploadFiles) ) {
		$wgMaxUploadFiles = 10;
	}
	include( "{$IP}/extensions/MultiUpload/MultiUpload.php" );
}

#--- 13. Poem - sitewide
include("{$IP}/extensions/Poem/Poem.php");

#--- 14. AntiSpamInput - sitewide
include("{$IP}/extensions/wikia/AntiSpamInput/AntiSpamInput.php");

if ( !empty( $wgEnableCaptchaExt ) ) {
	include( "$IP/extensions/wikia/Captcha/Captcha.setup.php" );
}

# quick switch to turn this trigger on where/when requested
if (!empty($wgCaptchaForMainCreate)) {
	$wgCaptchaTriggersOnNamespace[NS_MAIN]['create'] = true;
}

#--- 24. Special:InterwikiEdit
if (!empty($wgWikiaEnableSpecialInterwikiEditExt)) {
	include("$IP/extensions/wikia/SpecialInterwikiEdit/SpecialInterwikiEdit.php");
}

#--- 25. WikiFactory
if ( !empty($wgWikiaEnableWikiFactoryExt) ) {
	include( "$IP/extensions/wikia/WikiFactory/SpecialWikiFactory.php" );
	include_once( "$IP/extensions/wikia/WikiFactoryChangedHooks/WikiFactoryChangedHooks.php" );
}
else {
	#--- 25-1. WikiFactory Redirector
	# this CANNOT exist at the same time as actual WikiFactory, since it uses the same name (by design)
	if ( !empty($wgWikiaEnableWikiFactoryRedir) ) {
		include( "$IP/extensions/wikia/WikiFactory/redir/SpecialWikiFactoryRedir.php" );
	}
}

#--- 28. Wikia Shared talk
if (!empty( $wgWikiaEnableSharedTalkExt )) {
	include( "$IP/extensions/wikia/WikiaNewtalk/wikia_newtalk.php" );
}

/**
 * DynamicPageList & DPLForum
 */
if( defined( 'REBUILD_LOCALISATION_CACHE_IN_PROGRESS' ) || !empty($wgWikiaEnableDPLExt) && empty( $wgWikiaDisableAllDPLExt ) ) {
	include( "$IP/extensions/DynamicPageList/DynamicPageList.php" );
	ExtDynamicPageList::setFunctionalRichness( 3 );
	ExtDynamicPageList::$options['allowcachedresults']['default']='true';
	ExtDynamicPageList::$options['dplcachestorage']['default']='memcache';
	ExtDynamicPageList::$respectParserCache = true; // BAC-549
}

if( !empty($wgWikiaEnableDPLForum) && empty( $wgWikiaDisableAllDPLExt ) ) {
	include( "$IP/extensions/DPLforum/DPLforum.php" );
}

#--- 30. External image white-list
if (!empty($wgAllowExternalWhitelistImages)) {
	include( "$IP/extensions/wikia/WikiaWhiteList/WikiaExternalImageList.php" );
}

#--- 31. DynamicFunctions
if (!empty( $wgWikiaEnableDynamicFunctionsExt )) {
	include( "$IP/extensions/3rdparty/DynamicFunctions/DynamicFunctions.php");
}

#--- 32. spoiler show/hide ext from tibia
if (!empty($wgWikiaEnableSpoilerExt)) {
	include("$IP/extensions/3rdparty/Spoiler/Spoiler.php");
}

#--- 35. Wikia White List
if( !empty( $wgEnableWikiaWhiteListExt )) {
	include( "$IP/extensions/wikia/WikiaWhiteList/WikiaWhiteList.php" );
}

#--- 36. Createpage
if (!empty( $wgWikiaEnableCreatepageExt)) {
	include( "$IP/extensions/wikia/CreatePage/CreatePage.php" );
}

#--- 38. SyntaxHighlight_GeSHi parser ext.; requires lib/geshi
if (!empty($wgEnableSyntaxHighlightGeSHiExt)) {
	include "$IP/extensions/SyntaxHighlight_GeSHi/SyntaxHighlight_GeSHi.php";
}

#--- 39. SharedHelp
if (!empty( $wgWikiaEnableSharedHelpExt )) {
	include("$IP/extensions/wikia/SharedHelp/SharedHelp.php");
	include("$IP/extensions/wikia/SharedHelp/SharedHelpArticleCreation.php");
}

if (!empty( $wgEnableCentralHelpSearchExt )) {
	include("$IP/extensions/wikia/SharedHelp/CentralHelpSearch.php");
}

#--- 42. WikiaEvents
if (!empty( $wgEnableSiteWideMessages )) {
	include ( "$IP/extensions/wikia/SiteWideMessages/SpecialSiteWideMessages.php" );
}

#--- 43. ArticleMetaDescription
if (!empty( $wgEnableArticleMetaDescription )) {
	include ( "$IP/extensions/wikia/ArticleMetaDescription/ArticleMetaDescription.php" );
}

#--- 44. AdEngine
include ( "$IP/extensions/wikia/AdEngine3/AdEngine3.setup.php" );
include ( "$IP/extensions/wikia/AdEngine3/AdHostMirrors.setup.php" );

include ( "$IP/extensions/wikia/TrackingOptIn/TrackingOptIn.setup.php" );

if (!empty($wgEnableOggHandlerExt)) {
	include("$IP/extensions/OggHandler/OggHandler.php");
}

if (!empty($wgEnableSimpleCalendarExt)) {
	include("$IP/extensions/3rdparty/SimpleCalendar/SimpleCalendar.php");
}

if ( defined( 'REBUILD_LOCALISATION_CACHE_IN_PROGRESS' ) || !empty($wgEnableSemanticMediaWikiExt)) {
	$smwgNamespaceIndex = 300;

	include("$IP/extensions/SemanticMediaWiki/SemanticMediaWiki.php");

	// hack for devboxes and other undefined environment, wgServer should be
	// defined as --server=http://domain.name or --server http://domain.name but
	// in this place we don't have them parsed by mediawiki yet (Maintenance class is called later)
	// so we have this naive parsing instead
	if( $wgCommandLineMode ) {
		$server = false;
		foreach( $argv as $key => $value ) {
			if( substr($value, 0 , 8 ) === "--server" ) {
				if( $value === "--server" ) {
					// next argument is server url
					if( isset( $argv[ $key + 1 ] ) ) {
						$server = $argv[ $key + 1 ];
					}
				}
				else {
					list( $p1, $p2 ) = explode( "=", $value );
					if( isset( $p2 ) ) {
						$server = $p2;
					}
				}
				if( $server ) {
					$wgServer = $server;
				}
				break;
			}
		}
	}

	# Function to switch on Semantic MediaWiki. This function must be called in
	# LocalSettings.php after including SMW_Settings.php.
	enableSemantics(preg_replace('/^https?:\/\//', '', $wgServer));

	$smwgNamespacesWithSemanticLinks[NS_USER] = false;
	$smwgShowFactbox = SMW_FACTBOX_NONEMPTY;

	$smwgAutoRefreshOnPurge = false; // disable automatic SMW data refresh on manual page purge

	# Import modified settings from local WikiFactory vars
	if (isset($smwgQMaxSizeLocal))
		$smwgQMaxSize = $smwgQMaxSizeLocal;
	if (isset($smwgQMaxDepthLocal))
		$smwgQMaxDepth = $smwgQMaxDepthLocal;
	if (isset($smwgShowFactboxLocal))
		$smwgShowFactbox = $smwgShowFactboxLocal;
	if (isset($smwgLinksInValuesLocal))
		$smwgLinksInValues = $smwgLinksInValuesLocal;

	global $wgContentNamespaces;
	foreach ($wgContentNamespaces as $ns) {
		$smwgNamespacesWithSemanticLinks[$ns] = true;
	}

	if( !empty($smwgNamespacesWithSemanticLinksExtra) && is_array($smwgNamespacesWithSemanticLinksExtra) ) {
		//list of extra (non-content) ns to add SMW to (rt#59993)
		foreach ($smwgNamespacesWithSemanticLinksExtra as $ns) {
			$smwgNamespacesWithSemanticLinks[$ns] = true;
		}
	}

}

if ( !empty( $wgEnableScribuntoExt ) ) {
	include "$IP/extensions/Scribunto/Scribunto.php";

	// SUS-5540: use the luasandbox extension as executor if it is available
	if ( extension_loaded( 'luasandbox' ) ) {
		$wgScribuntoDefaultEngine = 'luasandbox';
	} else {
		$wgScribuntoDefaultEngine = 'luastandalone'; # PLATFORM-1885
	}

	$wgScribuntoUseGeSHi = $wgEnableSyntaxHighlightGeSHiExt;
	$wgWysiwygDisabledNamespaces[] = NS_MODULE;

	/**
	 * Load Lua-based extensions
	 */
	include "$IP/extensions/wikia/InfoboxBuilder/InfoboxBuilder.php";
}

/**
 * Enable Semantic* extensions, but only when SemanticMediawiki is enabled above
 */

if ( defined( 'REBUILD_LOCALISATION_CACHE_IN_PROGRESS' ) || !empty( $wgEnableSemanticMediaWikiExt ) ) {
	if( defined( 'REBUILD_LOCALISATION_CACHE_IN_PROGRESS' ) || !empty( $wgEnableSemanticFormsExt ) ) {
		$sfgNamespaceIndex = 350;
		// SUS-5128 - use a single source for Google Maps API key
		$sfgGoogleMapsKey = $wgGoogleMapsKey;
		include "$IP/extensions/SemanticForms/SemanticForms.php";
	}

	if ( defined( 'REBUILD_LOCALISATION_CACHE_IN_PROGRESS' ) || !empty( $wgEnableSemanticDrilldownExt ) ) {
		$sdgNamespaceIndex = 370;
		include "$IP/extensions/SemanticDrilldown/SemanticDrilldown.php";

		// Disable WYSIWYG editor on Filter namespace
		$wgWysiwygDisabledNamespaces[] = SD_NS_FILTER;
	}

	if ( !empty( $wgEnableSemanticGalleryExt ) ) {
		include "$IP/extensions/SemanticGallery/SemanticGallery.php";
	}

	if ( !empty( $wgEnableSemanticResultFormatsExt ) ) {
		if ( file_exists( "$IP/extensions/SemanticResultFormats/SemanticResultFormats.php" ) ) {
			include "$IP/extensions/SemanticResultFormats/SemanticResultFormats.php";
		} else {
			include "$IP/extensions/SemanticResultFormats/SemanticResultFormats.settings.php";
		}
	}

	if ( !empty( $wgEnableSemanticScribuntoExt ) && !empty( $wgEnableScribuntoExt ) ) {
		include "$IP/extensions/SemanticScribunto/SemanticScribunto.php";
	}
}

if (!empty($wgEnableWikiFactoryReporter)) {
	include("$IP/extensions/wikia/WikiFactory/Reporter/SpecialWikiFactoryReporter.php");
}

if( !empty( $wgEnableWikiHieroExt ) ) {
	include( "$IP/extensions/wikihiero/wikihiero.php" );
}

if( !empty( $wgEnableRandomImageExt ) ) {
	include( "$IP/extensions/RandomImage/RandomImage.php" );
}

if( !empty( $wgEnableCategoryTreeExt ) ) {
	include( "$IP/extensions/CategoryTree/CategoryTree.php" );
}

if( !empty( $wgEnableCheckUserExt ) ) {
	include( "$IP/extensions/CheckUser/CheckUser.php" );
}

if( !empty( $wgEnableCiteExt ) ) {
	include( "$IP/extensions/Cite/Cite.php" );
}

if( !empty( $wgEnableCharInsertExt ) ) {
	include( "$IP/extensions/CharInsert/CharInsert.php" );
}

if( !empty( $wgEnableDismissableSiteNoticeExt ) ) {
	include( "$IP/extensions/DismissableSiteNotice/DismissableSiteNotice.php" );
}

if( !empty( $wgEnableImageMapExt ) ) {
	include( "$IP/extensions/ImageMap/ImageMap.php" );
}

if( !empty( $wgEnableParserFunctionsExt ) ) {
	include( "$IP/extensions/ParserFunctions/ParserFunctions.php" );
	$wgPFEnableStringFunctions = true;
}

if( !empty( $wgEnableRssExt ) ) {
	//SSW fb#16208
	//include( "$IP/extensions/3rdparty/RSS/rss.php" );
	require_once("$IP/extensions/3rdparty/RSS/magpierss/rss_fetch.inc");
	include( "$IP/extensions/wikia/WikiaRSS/WikiaRss.setup.php" );
}

if( !empty( $wgEnableGlobalCSSJSExt ) ) {
	include( "$IP/extensions/wikia/GlobalCSSJS/GlobalCSSJS.php" );
}

if( !empty( $wgEnableAjaxPollExt ) ) {
	include( "$IP/extensions/wikia/AjaxPoll/AjaxPoll.php" );
}

/**
 * Enable the loader that loads mini hacks/tools/tweaks
 */

if( !empty( $wgEnableForumIndexProtectorExt ) ) {
	include("$IP/extensions/wikia/ForumIndexProtector/ForumIndexProtector.php");
}

if( !empty( $wgEnableContactExt ) ) {
	include_once "$IP/extensions/wikia/ContactPageRedirects/ContactPageRedirects.setup.php";
}

if( !empty( $wgEnableInputBoxExt ) ) {
	include( "$IP/extensions/InputBox/InputBox.php" );
}

if( !empty( $wgEnableRandomSelectionExt ) ) {
	include( "$IP/extensions/3rdparty/RandomSelection/RandomSelection.php" );
}

if( !empty( $wgEnableMultiDeleteExt ) ) {
	include( "$IP/extensions/wikia/MultiTasks/SpecialMultiDelete.php" );
	include( "$IP/extensions/wikia/MultiTasks/SpecialMultiWikiFinder.php" );
}

if( !empty( $wgEnableMultiWikiEditExt ) ) {
	include( "$IP/extensions/wikia/MultiTasks/SpecialMultiWikiEdit.php" );
}

if( !empty( $wgEnableTabViewExt ) ) {
	include( "$IP/extensions/wikia/TabView/TabView.php" );
}

if( !empty( $wgEnableGoogleDocsExt ) ) {
	include( "$IP/extensions/wikia/GoogleDocs/GoogleDocs.php" );
}

if( !empty( $wgEnableGoogleTagManagerExt ) ) {
	include( "$IP/extensions/wikia/GoogleTagManager/GoogleTagManager.setup.php" );
}

if( !empty( $wgEnableJSVariablesExt ) ) {
	include( "$IP/extensions/wikia/JSVariables/JSVariables.php" );
}

if( !empty( $wgEnableEditcountExt ) ) {
	include( "$IP/extensions/wikia/Editcount/SpecialEditcount.php" );
}

if (!empty($wgEnableRegexParserFunctions)) {
	include( "$IP/extensions/RegexFun/RegexFun.php" );
}

if(!empty($wgEnableWikiaMiniUploadExt)) {
	include("$IP/extensions/wikia/WikiaMiniUpload/WikiaMiniUpload_setup.php");
}

if(!empty($wgEnableLinkSuggestExt)) {
	include("$IP/extensions/wikia/LinkSuggest/LinkSuggest.php");
}

if(!empty($wgEnableMainPageTag)) {
	include("$IP/extensions/wikia/MainPageTag/MainPageTag.php");
}

# Labeled Section Transclusion extension, trac #2660
if (!empty($wgEnableLabeledSectionTransExt)) {
	include("$IP/extensions/LabeledSectionTransclusion/lst.php");
	include("$IP/extensions/LabeledSectionTransclusion/compat.php");
	if (!empty($wgEnabledLabeledSectionTransVHeaders)) {
		include("$IP/extensions/LabeledSectionTransclusion/lsth.php");
	}
}

if (!empty($wgEnableVerbatimExt)) {
	include( "$IP/extensions/3rdparty/Verbatim/Verbatim.php" );
}

// Both UserActivity and LookupContribs need the LookupContribs core class
if ( !empty( $wgEnableLookupContribsExt ) || !empty( $wgEnableUserActivityExt ) ) {
	include( "$IP/extensions/wikia/LookupContribs/LookupContribs.php" );
}

// Only load the LookupUser extention when specifically enabled
if ( !empty( $wgEnableLookupContribsExt ) ) {
	include( "$IP/extensions/wikia/LookupUser/LookupUser.php" );
}

if( !empty( $wgEnableWhereIsExtensionExt ) ) {
	include( "$IP/extensions/wikia/WhereIsExtension/SpecialWhereIsExtension.php" );
}

if (!empty($wgEnableInterwikiDispatcherExt)) {
	include("$IP/extensions/wikia/InterwikiDispatcher/SpecialInterwikiDispatcher.php");
}

if( !empty( $wgEnableEditAccount ) ) {
	include("$IP/extensions/wikia/EditAccount/SpecialEditAccount.php");
}

if (!empty($wgEnableRTEExt)) {
	include("$IP/extensions/wikia/RTE/RTE_setup.php");
}

if( !empty( $wgEnableGlobalWatchlistExt ) ) {
	include( "$IP/extensions/wikia/GlobalWatchlist/GlobalWatchlist.php" );
}

if( !empty( $wgUseSiteJs ) && !empty( $wgEnableGadgetsExt ) ) {
	include( "$IP/extensions/Gadgets/Gadgets.php" );
}

if ( defined( 'REBUILD_LOCALISATION_CACHE_IN_PROGRESS' ) || !empty( $wgEnableVariablesExt ) ) {
	include("$IP/extensions/Variables/Variables.php");
}

if (!empty($wgEnableTagsReport)) {
	include("$IP/extensions/wikia/TagsReport/SpecialTagsReport.php");
}

include("$IP/extensions/wikia/Listusers/SpecialListusers.php");

if (!empty($wgEnableSearchNearMatchExt)) {
	include("$IP/extensions/wikia/SearchNearMatch/SearchNearMatch.php");
}

if( !empty( $wgEnableWikiaPhotoGalleryExt ) ) {
	include( "$IP/extensions/wikia/WikiaPhotoGallery/WikiaPhotoGallery_setup.php" );

	// For MediaGallery prototype stage, let's include this along with legacy gallery
	// TODO: check for $wgEnableMediaGalleryExt instead after the prototype stage
	include( "$IP/extensions/wikia/MediaGallery/MediaGallery.setup.php" );

	if ( !empty( $wgUseWikiaNewFiles) ) {
		include( "$IP/extensions/wikia/WikiaNewFiles/WikiaNewFiles_setup.php" );
	}
}

if ( !empty( $wgEnableRecirculationExt ) ) {
	include( "$IP/extensions/wikia/Recirculation/Recirculation.setup.php" );
}

// If any video tools are enabled, enable VET
if( !empty( $wgEnableVideoToolExt ) || !empty( $wgEnableSpecialVideosExt ) ) {
	include( "$IP/extensions/wikia/VideoEmbedTool/VideoEmbedTool_setup.php" );
}

if( !empty( $wgEnableFlagClosedAccountsExt ) ) {
	include("$IP/extensions/wikia/EditAccount/FlagClosedAccounts.php");
}

if( !empty( $wgEnableHAWelcomeExt ) ) {
	include("$IP/extensions/wikia/HAWelcome/HAWelcome.setup.php");
}

// Enable CategorySelect extension for all not RTL wikis
if (!in_array($wgLanguageCode, array('ar', 'fa', 'he', 'ps', 'yi')) && !isset($wgEnableCategorySelectExt) ) {
	$wgEnableCategorySelectExt = true;
}

if(!empty($wgEnableCategorySelectExt)) {
	include("$IP/extensions/wikia/CategorySelect/CategorySelect.setup.php");
}

if (!empty($wgEnableCreateBoxExt ) ) {
	include("$IP/extensions/CreateBox/CreateBox.php");
}

if( defined( 'REBUILD_LOCALISATION_CACHE_IN_PROGRESS' ) || !empty( $wgEnableLoopsExt ) ) {
	include("$IP/extensions/Loops/Loops.php");
}

if (!empty($wgEnableWikiaIrcGatewayExt)) {
	include("$IP/extensions/wikia/WikiaIrcGateway/WikiaIrcGateway.php");
}

if (!empty($wgEnableGoogleCalendarExt)) {
	include("$IP/extensions/3rdparty/googleCalendar/googleCalendar.php");
}

if (!empty($wgEnableAbuseFilterExtension)) {
	$wgUseTagFilter = true; // rt#22038

	include("$IP/extensions/AbuseFilter/AbuseFilter.php");

	// override default actions palette to exclude some
	$wgAbuseFilterAvailableActions = array( 'flag', 'throttle', 'warn', 'disallow', 'blockautopromote', 'block', 'tag', 'rangeblock' );
}

if (!empty($wgEnableWikiaSpecialVersionExt)) {
	include("$IP/extensions/wikia/SpecialVersion/WikiaSpecialVersion.setup.php");
}

if (!empty($wgEnableTabberExt)) {
	include("$IP/extensions/3rdparty/tabber/tabber.php");
}

if( !empty( $wgEnableDumpsOnDemandExt ) ) {
	include( "$IP/extensions/wikia/WikiFactory/Dumps/DumpsOnDemand.php" );
}

if (!empty($wgEnableNukeExt)) {
	include("$IP/extensions/Nuke/SpecialNuke.php");
}

if (!empty($wgEnableRandomInCategoryExt)) {
	include("$IP/extensions/RandomInCategory/RandomInCategory.php" );
}

if( defined( 'REBUILD_LOCALISATION_CACHE_IN_PROGRESS' ) || !empty( $wgEnableArrayExt ) ) {
	include( "$IP/extensions/Arrays/Arrays.php" );
}

if(!empty($wgEnableImagePlaceholderExt)) {
	include( "$IP/extensions/wikia/ImagePlaceholder/ImagePlaceholder_setup.php" );
}

// new MyHome code
// always include base files
include("$IP/extensions/wikia/MyHome/MyHome.php");
include("$IP/extensions/wikia/MyHome/ActivityFeedHelper.php");
if (!empty($wgEnableMyHomeExt)) {
	// include a special page if enabled in WF
	include("$IP/extensions/wikia/MyHome/SpecialMyHome.php");
}
if (!empty($wgEnableActivityFeedTagExt)) {
	// include an activity tag if enablde in WF
	include("$IP/extensions/wikia/MyHome/ActivityFeedTag.php");
}

if (!empty($wgEnableStaffPowersExt)) {
	include("$IP/extensions/wikia/StaffPowers/StaffPowers.php");
}

if (!empty($wgEnableGracenoteExt)) {
	include("$IP/extensions/3rdparty/LyricWiki/Gracenote/Tag_GracenoteLyrics.php");
}

if (!empty($wgEnableLyricsTagExt)) {
	include( "$IP/extensions/3rdparty/LyricWiki/Tag_Lyric.php" );
}

if ( !empty($wgEnablePiggybackExt ) ) {
	include("$IP/extensions/wikia/Piggyback/Piggyback.php");
}

if ( !empty( $wgEnableHealthCheckExt ) ) {
	include( "$IP/extensions/wikia/SpecialHealthcheck/SpecialHealthcheck.php" );
}

if (!empty($wgEnableRSHighscoresExt)) {
	include("$IP/extensions/3rdparty/RSHighscores/RSHighscores.php");
}

if ( !empty($wgEnableStaffLogExt ) ) {
	require_once("$IP/extensions/wikia/StaffLog/StaffLog.php");
}

if ( empty( $wgEnableArticleCommentsExt ) ) {
	$wgArticleCommentsNamespaces = array( -1 );
	if ( !empty( $wgEnableBlogArticles ) ) {
		$wgArticleCommentsNamespaces = array( 500 /* NS_BLOG_ARTICLE */ );
	}
}

$wgEnableWallEngine = $wgEnableWallExt || $wgEnableForumExt ;

// ArticleComments are always required (for CrossWiki notifications on non-wall Wikis)
include("$IP/extensions/wikia/ArticleComments/ArticleComments_setup.php");
include("$IP/extensions/wikia/WallNotifications/WallNotifications.setup.php");

if( !empty( $wgEnableWallEngine ) ) {
	include("$IP/extensions/wikia/Wall/Wall.setup.php");
} else {
	include("$IP/extensions/wikia/Wall/WallDisabled.setup.php");
}

// Enable new style forums (/wiki/Special:Forum)
if ( !empty( $wgEnableForumExt ) ) {
	include( "{$IP}/extensions/wikia/Forum/Forum.setup.php" );
	if ( is_null( $wgArchiveWikiForums ) ) {
		$wgArchiveWikiForums = true;
	}
} else {
	include( "{$IP}/extensions/wikia/Forum/ForumDisabled.setup.php" );
}

// Archive old style wiki forums (/wiki/Forums:Index)
if ( !empty( $wgArchiveWikiForums ) ) {
	include "$IP/extensions/wikia/ArchiveWikiForum/ArchiveWikiForum.setup.php";
}

//If Discussions are enabled, the forum disabled and the Discussions should be in the navigation
if ( !empty( $wgEnableDiscussionsNavigation ) && !empty( $wgEnableDiscussions )
	 && empty( $wgEnableForumExt )
) {
	// Then add /f Discussions link to Oasis Global Navigation if it doesn't have a custom value
	if ( empty( $wgOasisGlobalNavigation ) ) {
		$wgOasisGlobalNavigation =
			"*__NOLINK__oasis-on-the-wiki
**Special:WikiActivity|wikiactivity
**Special:Random|randompage
**Special:Videos|Videos
**Special:NewFiles|oasis-navigation-v2-new-photos
**Special:Chat|Chat
**/f|discussions
**Special:Maps|Maps";
	}
}

/**
 * Enable Discussions extension
 */
include( "$IP/extensions/wikia/Discussions/Discussions.setup.php" );

/**
 * Enable Special:DiscussionsLog
 */
if ( !empty( $wgEnableDiscussionsLog ) ) {
	include( "$IP/extensions/wikia/SpecialDiscussionsLog/SpecialDiscussionsLog.setup.php" );
}

/**
 * Enable Embeddable Discussions extension
 */
if ( !empty( $wgEnableDiscussions ) ) {
	include "$IP/extensions/wikia/EmbeddableDiscussions/EmbeddableDiscussions.setup.php";
}

if (!empty($wgEnableBlogArticles)) {
	include( "$IP/extensions/wikia/Blogs/Blogs.php" );
}


include("$IP/extensions/wikia/UserLogin/UserLogin.setup.php");

if( !empty($wgEnableUserPageRedirectsExt ) )  {
	include ("$IP/extensions/wikia/UserPageRedirects/UserPageRedirects.setup.php");
}

if( !empty( $wgWikiaEnableSpecialNewWikis ) ) {
	include( "$IP/extensions/wikia/SpecialNewWikis/SpecialNewWikis.php" );
}

if( !empty($wgWikiaStarterLockdown) ) {

	#lock down namespaces (just incase of any other permission gaps)
	$StarterLockdownNamespaces = array_merge(
		range( 0,15 ),   // core namespaces
		[ 110, 111 ],    // NS_FORUM (DPL)
		[ 400, 401 ],    // NS_LEGACY_VIDEO
		range( 500,503 ) // NS_BLOG & NS_BLOG_LISTING
	);

	foreach( $StarterLockdownNamespaces as $ns) {
		$wgNamespaceProtection[ $ns ] = [ 'editinterface' ];
	}
	unset( $StarterLockdownNamespaces );
}

if( !empty($wgWikiaEnableFounderEmailsExt) ) {
	include("$IP/extensions/wikia/FounderEmails/FounderEmails.php");
}

if( !empty( $wgWikiaEnableAutoPageCreateExt ) ) {
	include( "$IP/extensions/wikia/AutoPageCreate/AutoPageCreate.php" );
}

if ( !empty( $wgEnableLightboxExt ) ) {
	include( "$IP/extensions/wikia/Lightbox/Lightbox.setup.php" );
}

if( !empty( $wgEnableImageLazyLoadExt ) ) {
	//include( "$IP/extensions/wikia/ImageLazyLoad/ImageLazyLoad.setup.php" );
}

if( !empty( $wgEnableWikiaMainpageFixer ) ) {
	include( "$IP/extensions/wikia/AutoMainpageFixer/AutoMainpageFixer.php" );
}

include("$IP/extensions/wikia/UserProfilePageV3/UserProfilePage.setup.php");

// Michał Roszka (Mix) <michal@wikia-inc.com>
// BugId:10474
// I want the code of the extension to be included regardless of the $wgEnableAchievementsExt.
// The effective execution still depends on $wgEnableAchievementsExt's value.
// Also: grep extensions/wikia/AchievementsII/Ach_setup.php for BugId:10474
include("$IP/extensions/wikia/AchievementsII/Ach_setup.php");

if(!empty($wgWikiaEnableContentFeedsExt)) {
	include("$IP/extensions/wikia/ContentFeeds/ContentFeeds.php");
}

if ( (!empty( $wgEnableWikiaFollowedPages )) || (!empty( $wgEnableWikiaFollowedPagesOnlyPrefs )) ) {
	include( "$IP/extensions/wikia/Follow/Follow.php" );
}

if(!empty($wgEnableSendGridPostback)){
	F::app()->registerApiController( 'SendGridPostbackController', "{$IP}/includes/wikia/api/SendGridPostBackApiController.class.php" );
}

if ( !empty( $wgExpandTemplatesExt ) ) {
	include( "$IP/extensions/ExpandTemplates/ExpandTemplates.php" );
}

# MediaWiki extensions requested by community

# load Phalanx / all spam filtering extensions
if ( !empty( $wgEnablePhalanxExt ) ) {
	include( "$IP/extensions/wikia/PhalanxII/Phalanx_setup.php" );

	if ( !empty( $wgEnableSpecialPhalanxExt ) ) {
		include( "$IP/extensions/wikia/PhalanxII/PhalanxSpecial_setup.php" );
	}
}

# SpamBlacklist, excluded from Phalanx batch per #64973
if ( !empty( $wgEnableSpamBlacklistExt ) ) {
	$wgBlacklistSettings['spam']['files'] = 'DB: '. $wgDBname .' MediaWiki:Spam-blacklist';
	include( "$IP/extensions/SpamBlacklist/SpamBlacklist.php" );
}

# TitleBlacklist extension
if ( !empty( $wgEnableTitleBlacklistExt ) ) {
	include( "$IP/extensions/TitleBlacklist/TitleBlacklist.php" );
	$wgTitleBlacklistSources = array(
		array(
			'type' => TBLSRC_LOCALPAGE,
			'src'  => 'MediaWiki:TitleBlacklist',
		),
		array(
			'type' => TBLSRC_GLOBALPAGE,
			// GlobalTitle params for http://community.wikia.com/wiki/MediaWiki:GlobalTitleBlacklist
			'src' => [ 'GlobalTitleBlacklist', 8, 177 ]
		),
	);
}

# User Rename Tool
if (!empty($wgEnableUserRenameToolExt) && !empty($wgEnablePhalanxExt)) {
	include("$IP/extensions/wikia/UserRenameTool/SpecialRenameuser.php");
} else {
	# Add log type for user rename even when rename extanesion is not enabled
	include( "$IP/extensions/wikia/UserRenameTool/UserRenameLog.php" );
}

if (!empty($wgEnableCommunityMessagesExt)) {
	include( "$IP/extensions/wikia/CommunityMessages/CommunityMessages_setup.php" );
}

# try to enable gamercard tag for all of gaming hub, but only if its not set at all
# this allows "false" to still force it off
if ( !isset($wgEnableXBoxGamerCardTag) && !empty($wgHub) && $wgHub->cat_id == 2 ) {
	$wgEnableXBoxGamerCardTag = true;
}

# xbox gamercard tag (salvaged from social profile addon)
if (!empty($wgEnableXBoxGamerCardTag)) {
	include("$IP/extensions/wikia/XBoxGamerCardTag/XBoxGamerCardTag.php");
}

# Category Galleries
if (!empty($wgEnableCategoryGalleriesExt)) {
	include("$IP/extensions/wikia/CategoryGalleries/CategoryGalleries.php");
}

# Partner Feed
if (!empty($wgEnablePartnerFeedExt)) {
	include("$IP/extensions/wikia/PartnerFeed/PartnerFeed.setup.php");
}

include( "$IP/extensions/wikia/ThemeDesigner/ThemeDesigner_setup.php" );

# HideTags
if (!empty( $wgEnableHideTagsExt ) ) {
	include( "$IP/extensions/wikia/HideTags/HideTags.php" );
}

# Paginator
if (!empty( $wgEnablePaginatorExt )){
	include( "$IP/extensions/wikia/Paginator/Paginator.setup.php" );
}

/*
 * Send email from the app authenticated by a secret token
 */
if( file_exists("$IP/extensions/wikia/SpecialEmailTest/SpecialEmailTest.php") ) {
	include( "$IP/extensions/wikia/SpecialEmailTest/SpecialEmailTest.php" );
}

if ( !empty( $wgEnablePerSkinParserCacheExt ) ) {
	include( "$IP/extensions/wikia/PerSkinParserCache/PerSkinParserCache.php" );
}

if ( !empty($wgEnableCreateNewWiki) ) {
	include( "$IP/extensions/wikia/CreateNewWiki/CreateNewWiki_setup.php" );
}

if ( !empty($wgEnableFinishCreateWiki) ) {
	include( "$IP/extensions/wikia/CreateNewWiki/FinishCreateWiki_setup.php" );
}

/**
 * GameGuides mobile app extension
 */
if ( !empty( $wgEnableGameGuidesExt ) ) {
	include("$IP/extensions/wikia/GameGuides/GameGuides_setup.php");
}

/**
 * CuratedContent extension is spiritual successor of GameGuides extension
 */
if ( !empty( $wgEnableCuratedContentExt ) ) {
	include("$IP/extensions/wikia/CuratedContent/CuratedContent.setup.php");
}

if ( !empty( $wgEnableChat ) ){
	include( "$IP/extensions/wikia/Chat2/Chat_setup.php" );
}

if ( !empty( $wgEnableAntiSpoofExt ) ) {
	include( $IP . '/extensions/AntiSpoof/AntiSpoof.php' );
//	$wgSharedTables[] = 'spoofuser';
}
/**
 * @name $wgEnableCanonicalHref
 * Adds <link rel="canonical"> to article pages
 */
if ( !empty( $wgEnableCanonicalHref ) ) {
	include( "$IP/extensions/wikia/CanonicalHref/CanonicalHref.php" );
}

if ( !empty( $wgEnableSpecialUnsubscribeExt ) ) {
	include( "$IP/extensions/wikia/SpecialUnsubscribe/Unsubscribe.php" );
}

if ( !empty( $wgEnableUserStatisticsExt ) ) {
	include( "$IP/extensions/3rdparty/UserStatistics/UserStatistics.php" );
}

/**
 * @name $wgEnableAdminDashboardExt
 * Enables Admin Dashboard extension
 */
if ($wgEnableAdminDashboardExt) {
	include( "$IP/extensions/wikia/AdminDashboard/AdminDashboard.setup.php" );
}

/**
 * @name $wgEnableFounderProgressBarExt
 * Enables Founder Progress Bar extension
 */
if ($wgEnableFounderProgressBarExt) {
	include( "$IP/extensions/wikia/FounderProgressBar/FounderProgressBar.setup.php" );
}

if ( !empty( $wgEnableMobileContentExt ) ) {
	include( "$IP/extensions/wikia/MobileContent/MobileContent.setup.php" );
}

if (!empty($wgEnableSpecialWithoutimagesExt)) {
	include( "$IP/extensions/wikia/SpecialWithoutimages/SpecialWithoutimages.php" );
}

if ( !empty( $wgEnableCategoryBlueLinks ) ) {
	include( "$IP/extensions/wikia/CategoryBlueLinks/CategoryBlueLinks.php" );
}

if ( !empty( $wgEnableWikiFeatures ) ) {
	/**
	 * @name $wgWikiFeatures
	 * List of WF var allowed to use in Wiki Features
	 *
	 * we need this config in here because lang is not accessible
	 * in CommonSettings.php and some of the functionality are going to be release only
	 * for selected langs
	 *
	 * side effect of this change is that this variable can not be overwritten by wikifactory
	 * But we never set this var up by wikifactory becasue it is always global setting
	 *
	 */
	$wgWikiFeatures = array (
		'normal' => array (
			'wgEnableAjaxPollExt',
			'wgEnableBlogArticles',
			'wgEnableArticleCommentsExt',
			'wgEnableWallExt',
			'wgEnablePortableInfoboxEuropaTheme'
		),
		'labs' => array (
			'wgEnableMediaGalleryExt',
			'wgEnableChat'
		)
	);

	if ( empty( $wgWikiDirectedAtChildrenByStaff ) ) {
		$wgWikiFeatures['normal'][] = 'wgDisableAnonymousEditing';
	}

	include( "$IP/extensions/wikia/WikiFeatures/WikiFeatures.setup.php" );
	include_once( "$IP/extensions/wikia/WikiFactoryChangedHooks/WikiFactoryChangedHooks.php" );
}

if ( !empty( $wgEnableTracking ) ) {
	include( "$IP/extensions/wikia/Track/Track.php");
}

if ( !empty( $wgEnableFileInfoFunctionsExt ) ) {
	include( "$IP/extensions/wikia/ImageSizeInfoFunctions/ImageSizeInfoFunctions.php" );
}

/**
 * @name $wgEnableUserPreferencesV2Ext
 * Enables the second version of user preferences page (Special:Preferences).
 */
if (!empty($wgEnableUserPreferencesV2Ext)) {
	include( "$IP/extensions/wikia/UserPreferencesV2/UserPreferencesV2.setup.php" );
}

if ( !empty( $wgEnablePlacesExt ) ) {
	include( "$IP/extensions/wikia/Places/Places.setup.php" );
}

/* ProtectSiteJS */
if(!empty($wgEnableProtectSiteJSExt)) {
	include("$IP/extensions/wikia/ProtectSiteJS/ProtectSiteJS_setup.php");
}

if ( !empty($wgCityId) && $wgCityId != 1252 /* starter.wikia.com */ && !$wgDevelEnvironment ) {
	// this allows for starter images to be taken from the appropriate language starter wiki directly
	// @note Make sure that newly added starter is protected (e.g. from being removed by automated deletion scripts)
	//       use WikiFactory::setFlags( <city_id>, WikiFactory::FLAG_PROTECTED )
	$languageStarters = array(
		//	"en" => "starter", # handled by the default/else case below
		"de" => "destarter",
		"es" => "esstarter",
		"fi" => "fistarter",
		"fr" => "starterbeta",
		"ja" => "jastarter",
		"ko" => "starterko",
		"nl" => "nlstarter",
		"pl" => "plstarter",
		"ru" => "rustarter",
		//	"it" => "italianstarter", # ARGH, this won't work without clumsy logic, thankfully it has no images
		"zh" => "zhstarter",
	);

	if ( array_key_exists( $wgLanguageCode, $languageStarters ) ) {
		$wgStarterWikiDBName = $languageStarters[$wgLanguageCode];
		$starterDirectory = "/images/s/starter/{$wgLanguageCode}/images";
		$starterPath = "http://images.{$wgWikiaBaseDomain}/starter/{$wgLanguageCode}/images";
		$starterUrl = "http://{$wgLanguageCode}.starter.{$wgWikiaBaseDomain}/wiki/File:";
	} else {
		$wgStarterWikiDBName = 'starter';
		$starterDirectory = "/images/s/starter/{$wgLanguageCode}/images";
		$starterPath = "http://images.{$wgWikiaBaseDomain}/starter/images";
		$starterUrl = "http://starter.{$wgWikiaBaseDomain}/wiki/File:";
	}

	$wgForeignFileRepos[] = array(
		'class'            => 'WikiaForeignDBViaLBRepo',
		'name'             => $wgStarterWikiDBName,
		'directory'        => $starterDirectory,
		'url'              => $starterPath,
		'hashLevels'       => 2,
		'hasSharedCache'   => true,
		'descBaseUrl'      => $starterUrl,
		'fetchDescription' => true,
		'wiki'             => $wgStarterWikiDBName,
		'checkRedirects'   => false,
		'checkDuplicates'  => false,
		'allowBlocking'    => true,
	);
}

if (!empty($wgEnableMiniEditorExtForArticleComments)
	|| !empty($wgEnableMiniEditorExtForForum)
	|| !empty($wgEnableMiniEditorExtForWall)) {
	$wgEnableMiniEditorExt = true;
	include( "$IP/extensions/wikia/MiniEditor/MiniEditor.setup.php" );
}

if ( !empty( $wgEnableImageReviewExt ) ) {
	include("$IP/extensions/wikia/ImageReview/ImageReview.setup.php");
}

/**
 * WDACReview (Wikis Directed at Children) tool
 */
if ( !empty( $wgEnableWDACReviewExt ) ) {
	include( "$IP/extensions/wikia/WDACReview/WDACReview.setup.php" );
}

if ( !empty( $wgEnableCategoryIntersectionExt ) ){
	include("$IP/extensions/wikia/WikiaApi/WikiaApiQueryCategoryIntersection.php");
	include("$IP/extensions/wikia/SpecialCategoryIntersection/SpecialCategoryIntersection.php");
}

if ( !empty( $wgEnableGlobalUsageExt ) ) {
	include( "$IP/extensions/GlobalUsage/GlobalUsage.php" );
}

if ( !empty( $wgEnableAbTesting ) ) {
	include( "$IP/extensions/wikia/AbTesting/AbTesting.setup.php");
}

if ( !empty( $wgEnableContentWarningExt ) ) {
	include( "$IP/extensions/wikia/ContentWarning/ContentWarning.setup.php");
}

if ( !empty( $wgEnableRecentChangesExt ) ) {
	include( "$IP/extensions/wikia/RecentChanges/RecentChanges.setup.php");
}

if ( !empty( $wgEnableCommentCSVExt ) ) {
	include( "$IP/extensions/wikia/CommentCSV/CommentCSV.php" );
}

if ( !empty( $wgEnableArticlesAsResourcesExt )  ) {
	include( "$IP/extensions/wikia/ArticlesAsResources/ArticlesAsResources.setup.php" );
}

/**
 * Our own extension which template is being shared among two [three] other extensions (Article Comments [Blog], Wall)
 * It has one method which is a hook fired in ChangesList.php and it fires our own hook via which we can change
 * header of RecentChanges blocks
 */
$wgEnableWikiaRecentChangesBlockHandlerExt = (!empty($wgEnableArticleCommentsExt) || !empty($wgEnableWallExt));
if( !empty($wgEnableWikiaRecentChangesBlockHandlerExt) ) {
	include( "$IP/extensions/wikia/WikiaRecentChangesBlockHandler/WikiaRecentChangesBlockHandler.setup.php" );
}

if ( !empty($wgEnableSpecialVideosExt) ) {
	include("$IP/extensions/wikia/SpecialVideos/SpecialVideos.setup.php");
}

/**
 * Wikia UI Styleguide Elements for Oasis skin
 */
include( "$IP/extensions/wikia/WikiaStyleGuide/WikiaStyleGuideElements.setup.php" );

/*
 * WikiaBar Extension
 */
if ( !empty( $wgEnableWikiaBarExt ) ) {
	include( "{$IP}/extensions/wikia/WikiaBar/WikiaBar.setup.php" );
}

if ( !empty( $wgEnableVisualEditorExt ) ) {
	include( "$IP/extensions/VisualEditor/VisualEditor.php" );
	include( "$IP/extensions/VisualEditor/wikia/VisualEditor.php" );

	// Override default settings in extensions/VisualEditor/VisualEditor.php
	$wgDefaultUserOptions[ 'visualeditor-enable' ] = 1;
	switch ( $wgWikiaEnvironment ) {
		case WIKIA_ENV_PROD:
		case WIKIA_ENV_PREVIEW:
		case WIKIA_ENV_VERIFY:
		case WIKIA_ENV_SANDBOX:
			$wgVisualEditorParsoidURL = 'http://parsoid';
			break;
		case WIKIA_ENV_DEV:
			// Note: This must NOT end with a slash due to Parsoid bug (wtf?)
			$wgVisualEditorParsoidURL = "http://dev.$wgWikiaDatacenter-dev.k8s.wikia.net/parsoid";
			break;
		default:
	}
}

if ( !empty( $wgEnableWAMApiExt ) ) {
	include("$IP/extensions/wikia/WAM/WAM.setup.php");
}

if( !empty($wgEnableWAMPageExt) ) {
	include("$IP/extensions/wikia/WAMPage/WAMPage.setup.php");
}

if ( is_null( $wgEnableWikiaMobileSmartBanner ) ) {
	$wgEnableWikiaMobileSmartBanner = !empty( $wgHub ) && $wgHub->cat_id == WikiFactoryHub::CATEGORY_ID_GAMING;
}

if( !empty( $wgEnableSpecialCssExt ) ) {
	include("$IP/extensions/wikia/SpecialCss/SpecialCss.setup.php");
}

if ( !empty( $wgEnableFormatNumExt ) ) {
	include( "$IP/extensions/FormatNum/FormatNum.php" );
}

if ( empty( $wgRightsUrl ) ) {
	switch( $wgLanguageCode ) {
		case 'de':
			$wgRightsUrl  = 'https://www.fandom.com/de/licensing-de';
			break;
		case 'es':
			$wgRightsUrl  = 'https://www.fandom.com/es/licensing-es';
			break;
		case 'fi':
			$wgRightsUrl  = "http://yhteiso.{$wgWikiaBaseDomain}/wiki/Suomen_Wikia:Lisenssointi";
			break;
		case 'fr':
			$wgRightsUrl  = 'https://www.fandom.com/fr/licensing-fr';
			break;
		case 'it':
			$wgRightsUrl  = 'https://www.fandom.com/it/licensing-it';
			break;
		case 'ja':
			$wgRightsUrl  = 'https://www.fandom.com/ja/licensing-ja';
			break;
		case 'nl':
			$wgRightsUrl  = "http://nl.community.{$wgWikiaBaseDomain}/wiki/Auteursrecht";
			break;
		case 'pl':
			$wgRightsUrl  = 'https://www.fandom.com/pl/licensing-pl';
			break;
		case 'pt':
			$wgRightsUrl  = 'https://www.fandom.com/pt-br/licensing-pt-br';
			break;
		case 'pt-br':
			$wgRightsUrl  = 'https://www.fandom.com/pt-br/licensing-pt-br';
			break;
		case 'ru':
			$wgRightsUrl  = 'https://www.fandom.com/ru/licensing-ru';
			break;
		case 'zh':
			$wgRightsUrl  = 'https://www.fandom.com/zh/licensing-zh';
			break;
		case 'zh-tw':
			$wgRightsUrl  = 'https://www.fandom.com/zh-tw/licensing-zh-tw';
			break;
		default:
			$wgRightsUrl  = 'https://www.fandom.com/licensing';
			break;
	}
}

if( !empty( $wgOasisResponsive ) ) {
	include("$IP/extensions/wikia/EditPreview/EditPreview.setup.php");
}

// Swift client library, must be enabled globally
include( "$IP/extensions/SwiftCloudFiles/SwiftCloudFiles.php" );

$wgFileBackends['swift-backend'] = array(
	'name'          => 'swift-backend',
	'class'         => 'SwiftFileBackend',
	'lockManager'   => 'nullLockManager',
	'swiftAuthUrl'  => $wgFSSwiftConfig['swiftAuthUrl'],  # defined in CommonSettings.php
	'swiftUser'     => $wgFSSwiftConfig['swiftUser'],
	'swiftKey'      => $wgFSSwiftConfig['swiftKey'],
	'swiftAuthTTL'	=> 120,
	'swiftTimeout'  => 30,
	'cacheAuthInfo'	=> true,
	'wikiId'        => '',
	'isMultiMaster' => false,
	'debug'         => false,
	'url'           => "http://{$wgFSSwiftServer}/swift/v1",
);

$wgFileBackends['gcs-backend'] = [
	'name' => 'gcs-backend',
	'class' => 'GcsFileBackend',
	'lockManager' => 'nullLockManager',
	'wikiId'	=> '',
	'gcsCredentials' => $wgGcsConfig['gcsCredentials'],
	'gcsBucket' => $wgGcsConfig['gcsBucket'],
	'gcsTemporaryBucket' => $wgGcsConfig['gcsTemporaryBucket'],
	'gcsObjectNamePrefix' => 'mediawiki/',
];

// SER-3444 always use GCS
$wgEnabledFileBackend = 'gcs-backend';
// This is required to be able run CoppaTool tasks on all wikis
include( "{$IP}/extensions/wikia/CoppaTool/legacy/CoppaToolLegacyTasks.setup.php" );
if ( !empty( $wgEnableCoppaToolExt ) ) {
	include( "{$IP}/extensions/wikia/CoppaTool/CoppaTool.setup.php" );
}

// Include mime types directly in PHP
if ( $wgUseMimeMagicLite ) {
	include( "$IP/includes/wikia/MimeMagicLite.php" );
}

if ( !empty( $wgEnableAbuseFilterBypass ) ) {
	include( "{$IP}/extensions/wikia/AbuseFilterBypass/AbuseFilterBypass.php" );
}

if ( !empty( $wgEnableQualarooExt ) && empty( $wgIsTestWiki ) ) {
	include "$IP/extensions/wikia/Qualaroo/Qualaroo.setup.php";
}

if ( !empty( $wgEnablePoolCounter ) ) {
	include "$IP/extensions/PoolCounter/PoolCounterClient.php";
	$wgPoolCountClientConf = [
		'servers' => $wgPoolCounterServers,
		'timeout' => 0.5
	];

	$wgPoolCounterConf = [
		'ArticleView' => [
			'class' => 'PoolCounter_Client',
			'timeout' => 15,
			'workers' => 2,
			'maxqueue' => 100,
		],
	];
}

if( !empty( $wgEnableLyricsApi ) ) {
	// This is not a secret.  The token is used for attribution in Apple Music links.
	// https://affiliate.itunes.apple.com/resources/documentation/basic_affiliate_link_guidelines_for_the_phg_network/
	$wgLyricsItunesAffiliateToken = '11lwWb';
	include "$IP/extensions/wikia/LyricsApi/LyricsApi.setup.php";
}

if ( !empty( $wgEnableEditorPreferenceExt ) ) {
	include "$IP/extensions/wikia/EditorPreference/EditorPreference.php";
}

if( !empty( $wgEnableEditorSyntaxHighlighting ) ) {
	include "$IP/extensions/wikia/EditorSyntaxHighlighting/EditorSyntaxHighlighting.setup.php";
}

if ( !empty( $wgEnableCloseMyAccountExt ) ) {
	include "$IP/extensions/wikia/CloseMyAccount/CloseMyAccount.setup.php";
}

if ( $wgWikiaEnvironment !== WIKIA_ENV_PROD && $wgWikiaEnvironment !== WIKIA_ENV_DEV ) {
	include "$IP/extensions/wikia/Staging/Staging.setup.php";
}

if ( !empty( $wgEnableRelatedPagesExt ) ) {
	include "$IP/extensions/wikia/RelatedPages/RelatedPages.php";
}

if ( !empty($wgEnableLinkToMobileAppExt) ) {
	include "$IP/extensions/wikia/LinkToMobileApp/LinkToMobileApp.php";
}

if ( !empty($wgEnableWikiaInYourLangExt) ) {
	include "$IP/extensions/wikia/WikiaInYourLang/WikiaInYourLang.setup.php";
}

include "$IP/extensions/wikia/IndexingPipeline/IndexingPipeline.setup.php";

/**
 * Turn on the Email handling framework
 */
if ( !empty( $wgEnableEmailExt ) ) {
	include "$IP/extensions/wikia/Email/Email.setup.php";
}

if ( !empty( $wgEnableFandomCreatorEmailExt ) ) {
	include "$IP/extensions/wikia/FandomCreatorEmail/FandomCreatorEmail.setup.php";
}

/**
 * Includes that are needed for wikiamobile skin to work
 */
include_once( "$IP/extensions/wikia/WikiaMobile/WikiaMobile.setup.php" );

/**
 * Includes that are needed for Mercury to work
 */
include_once( "$IP/extensions/wikia/ArticleAsJson/ArticleAsJson.setup.php" );
include_once( "$IP/extensions/wikia/MercuryApi/MercuryApi.setup.php" );

/**
 * Insights
 */
if ( !empty( $wgEnableInsightsExt ) ) {
	include( "$IP/extensions/wikia/InsightsV2/InsightsV2.setup.php" );
	/**
	 * Unconverted Infoboxes Insight subpage
	 */
	if ( !empty( $wgEnableInsightsInfoboxes ) && !empty( $wgEnablePortableInfoboxExt ) ) {
		include "$IP/extensions/wikia/InsightsV2/InsightsUnconvertedInfoboxes.setup.php";
	}

	/**
	 * Popular Pages Insight subpage
	 */
	if ( !empty( $wgEnableInsightsPopularPages ) || !empty( $wgEnablePopularPagesQueryPage ) ) {
		include "$IP/extensions/wikia/InsightsV2/PopularPages.setup.php";
	}

	if ( !empty( $wgEnableTemplateClassificationExt ) ) {
		/**
		 * Pages without infobox Insight subpage (on EN communities)
		 */
		if ( !empty( $wgEnableInsightsPagesWithoutInfobox ) ) {
			include "$IP/extensions/wikia/InsightsV2/PagesWithoutInfobox.setup.php";
		}
		/**
		 * Templates without type Insight subpage (on EN communities)
		 */
		if ( !empty( $wgEnableInsightsTemplatesWithoutType ) ) {
			include "$IP/extensions/wikia/InsightsV2/InsightsTemplatesWithoutType.setup.php";
		}
	}
}

/**
 * Extension for redirecting to blogpost announcing Insigts when Insights aren't enabled on specific wikia yet
 */
if ( empty( $wgEnableInsightsExt ) && !empty( $wgEnableInsightsBlogpostRedirectExt ) ) {
	include( "$IP/extensions/wikia/InsightsBlogpostRedirect/InsightsBlogpostRedirect.setup.php" );
}

/**
 * Enable the TemplateDraft extension
 */
if ( !empty( $wgEnableTemplateDraftExt ) ) {
	include( "$IP/extensions/wikia/TemplateDraft/TemplateDraft.setup.php" );
}

/**
 * Portable Infobox extension
 */
if ( !empty($wgEnablePortableInfoboxExt) ) {
	include "$IP/extensions/wikia/PortableInfobox/PortableInfobox.setup.php";
}

if ( !empty( $wgEnablePortableInfoboxBuilderExt ) ) {
	include "$IP/extensions/wikia/PortableInfoboxBuilder/PortableInfoboxBuilder.setup.php";
}
if ( !empty( $wgEnablePortabilityDashboardExt ) ) {
	include "$IP/extensions/wikia/PortabilityDashboard/PortabilityDashboard.setup.php";
}

include "$IP/extensions/wikia/PortabilityDashboard/PortabilityDashboardHooks.setup.php";

$wgEnablePortableInfoboxBuilderInVE = $wgEnablePortableInfoboxBuilderInVE && $wgEnablePortableInfoboxBuilderExt;

if ( !empty( $wgEnableDMCARequestExt ) ) {
	include "$IP/extensions/wikia/DMCARequest/DMCARequest.setup.php";
}

/**
 * Enables TemplateClassification extension (on EN communities)
 */
if ( !empty( $wgEnableTemplateClassificationExt ) ) {
	include "$IP/extensions/wikia/TemplateClassification/TemplateClassification.setup.php";
}

/**
 * Enables VisitSource extension
 */
if ( !empty( $wgEnableVisitSourceExt ) ) {
	include "$IP/extensions/wikia/VisitSource/VisitSource.setup.php";
}

/**
 * Mark all JA wikis as special (no GA sampling)
 */
if( $wgLanguageCode === 'ja' ) {
	$wgIsGASpecialWiki = true;
}

$wgPreferenceServiceRead = true;

/**
 * Enable the Content Review extension
 */
// Load classes that should always be available
include "$IP/extensions/wikia/ContentReview/ContentReviewShared.setup.php";

if ( !empty( $wgUseSiteJs ) && !empty( $wgEnableContentReviewExt ) ) {
	include( "$IP/extensions/wikia/ContentReview/ContentReview.setup.php" );

	if ( !empty( $wgEnableContentReviewSpecialPage ) ) {
		include( "$IP/extensions/wikia/ContentReview/ContentReviewSpecialPage.setup.php" );
	}
}

include "$IP/extensions/wikia/ContentReview/ImportJS.setup.php";

/**
 * Parser tags which are replacing verbatim tags
 */
if ( !empty( $wgEnableFliteTagExt ) ) {
	include "$IP/extensions/wikia/FliteTag/FliteTag.setup.php";
}

if ( !empty( $wgEnableGoogleFormTagExt ) ) {
	include "$IP/extensions/wikia/GoogleFormTag/GoogleFormTag.setup.php";
}

if ( !empty( $wgEnablePolldaddyTagExt ) ) {
	include "$IP/extensions/wikia/PolldaddyTag/PolldaddyTag.setup.php";
}

if ( !empty( $wgEnableSoundCloudTagExt ) ) {
	include "$IP/extensions/wikia/SoundCloudTag/SoundCloudTag.setup.php";
}
if ( !empty( $wgEnableSpotifyTagExt ) ) {
	include "$IP/extensions/wikia/SpotifyTag/SpotifyTag.setup.php";
}

if ( !empty( $wgEnableUserActivityExt ) ) {
	include "$IP/extensions/wikia/UserActivity/UserActivity.setup.php";
}

if ( !empty( $wgEnableTwitterTagExt ) ) {
	include "$IP/extensions/wikia/TwitterTag/TwitterTag.setup.php";
}

if ( !empty( $wgEnableVKTagExt ) ) {
	include "$IP/extensions/wikia/VKTag/VKTag.setup.php";
}

if ( !empty( $wgEnableWeiboTagExt ) ) {
	include "$IP/extensions/wikia/WeiboTag/WeiboTag.setup.php";
}

/**
 * SEO extensions (keep them ordered)
 */
if ( $wgEnableCustom404PageExt === true
	 || ( $wgEnableCustom404PageExt === null && in_array( $wgLanguageCode, $wgEnableCustom404PageExtInLanguages ) )
) {
	include( "$IP/extensions/wikia/Custom404Page/Custom404Page.setup.php" );
}

if ( !empty( $wgEnableLocalSitemapPageExt ) ) {
	include( "$IP/extensions/wikia/LocalSitemapPage/LocalSitemapPage.setup.php" );
}

if ( !empty( $wgEnableNotAValidWikiaExt ) ) {
	include( "$IP/extensions/wikia/NotAValidWikia/NotAValidWikia.setup.php" );
}

if ( !empty( $wgEnableRobotsTxtExt ) ) {
	include( "$IP/extensions/wikia/RobotsTxt/RobotsTxt.setup.php" );
}

if ( !empty( $wgEnableSeoLinkHreflangExt ) ) {
	include "$IP/extensions/wikia/SeoLinkHreflang/SeoLinkHreflang.setup.php";
}

if ( !empty( $wgEnableSitemapPageExt ) ) {
	include( "$IP/extensions/wikia/SitemapPage/SitemapPage.setup.php" );
}

if ( !empty( $wgEnableSitemapXmlExt ) ) {
	include( "$IP/extensions/wikia/SitemapXml/SitemapXml.setup.php" );
}

if ( !empty( $wgEnableTwitterCardsExt ) ) {
	include( "$IP/extensions/wikia/TwitterCards/TwitterCards.setup.php" );
}

if ( !empty( $wgEnableGlobalShortcutsExt ) ) {
	include "$IP/extensions/wikia/GlobalShortcuts/GlobalShortcuts.setup.php";
}

// We want to enable Community Page also for japanese communities excluding newly created and head-fi wikia
if ( !empty( $wgEnableCommunityPageExt ) || ( $wgLanguageCode == 'ja' && $wgCityId < 1411887 ) && $wgCityId != 1350187 ) {
	include "$IP/extensions/wikia/CommunityPage/CommunityPage.setup.php";
}

include "$IP/extensions/wikia/FandomCreator/FandomCreator.setup.php";

/**
 * @name $wgEnableNewAuthModal
 * Enables new popup-based authentication
 */
if ( !isset($wgEnableNewAuthModal) && in_array( $wgLanguageCode, [ 'es', 'ru' ] ) ) {
	$wgEnableNewAuthModal = true;
}

if ( !empty( $wgEnableArticleFeaturedVideo ) || !empty( $wgEnableArticleRelatedVideo ) ) {
	include "$IP/extensions/wikia/ArticleVideo/ArticleVideo.setup.php";
}

if ( !empty( $wgEnableFirstContributionsExt ) ) {
	include "$IP/extensions/wikia/FirstContributions/FirstContributions.setup.php";
}

if ( !empty( $wgEnableApesterTagExt ) ) {
	include "$IP/extensions/wikia/ApesterTag/ApesterTag.setup.php";
}

if ( !empty( $wgEnablePlaybuzzTagExt ) ) {
	include "$IP/extensions/wikia/PlaybuzzTag/PlaybuzzTag.setup.php";
}

if ( !empty( $wgEnableTrackingSettingsManager ) ) {
	include "$IP/extensions/wikia/TrackingOptIn/TrackingSettingsManager.setup.php";
}

if ( !empty( $wgEnableResetTrackingPreferencesPage ) ) {
	include "$IP/extensions/wikia/TrackingOptIn/ResetTrackingPreferences.setup.php";
}

include "$IP/extensions/wikia/JWPlayerTag/JWPlayerTag.setup.php";

include_once("$IP/extensions/wikia/DataWarehouse/DataWarehouseEventProducer.setup.php");

include "$IP/extensions/wikia/HTTPSSupport/HTTPSSupport.setup.php";

// Search should be enabled globally, always
include "$IP/extensions/wikia/Search/WikiaSearch.setup.php";

// Mercury auth pages related functionality - redirects, email confirmation.
include "$IP/extensions/wikia/AuthPages/AuthPages.setup.php";

include "$IP/extensions/wikia/DownloadYourData/DownloadYourData.setup.php";

// SUS-4738 | Handles requests to be forgotten
include "$IP/extensions/wikia/Privacy/Privacy.setup.php";

include "$IP/extensions/wikia/Announcements/Announcements.setup.php";

// SUS-5473 | Expose a button on Special:Statistics allowing Wikia Staff members to schedule
// updateSpecialPages.php maintenance script run.
include "$IP/extensions/wikia/UpdateSpecialPagesScheduler/UpdateSpecialPagesScheduler.setup.php";

if ( !empty( $wgEnableFeedsAndPostsExt ) ) {
	include "$IP/extensions/wikia/FeedsAndPosts/FeedsAndPosts.setup.php";
}

include "$IP/extensions/wikia/FandomComMigration/FandomComMigration.setup.php";
include "$IP/extensions/wikia/WikiaOrgMigration/WikiaOrgMigration.setup.php";

// SUS-5817
if ( $wgEnableFastlyInsights ) {
	include "$IP/extensions/wikia/FastlyInsights/FastlyInsights.setup.php";
}

include "$IP/extensions/wikia/LanguageWikisIndex/LanguageWikisIndex.setup.php";

if ( $wgIncludeClosedWikiHandler ) {
	include "$IP/extensions/wikia/WikiFactory/Loader/closedWikiHandler.php";
}

// SRE-116
include "$IP/extensions/wikia/ProtectSiteII/ProtectSite.php";

// This extension is enabled globally and handles Sync between datacenters
// It does work on devboxes if you need to enable for testing, but we are not running the sync script
if ( empty( $wgDevelEnvironment ) ) {
	include "$IP/lib/Wikia/src/SwiftSync/SwiftSync.setup.php";
}

// SEO-670 | SEO friendly category pages
if ( !empty( $wgEnableCategoryPage3Ext ) ) {
	include "$IP/extensions/wikia/CategoryPage3/CategoryPage3.setup.php";
}

// Category Exhibition
// If you want to delete this extension remember to update CategoryPage3
include("$IP/extensions/wikia/CategoryExhibition/CategoryExhibition_setup.php" );

if ( !empty( $wgWatchShowURL) || !empty($wgWatchShowURLMobile ) ) {
	include "$IP/extensions/wikia/WatchShow/WatchShow.setup.php";
}

// SUS-79
if ( !empty( $wgEnableEditDraftSavingExt ) ) {
	include "$IP/extensions/wikia/EditDraftSaving/EditDraftSaving.setup.php";
}

// PLATFORM-3973
include_once( "$IP/extensions/wikia/FilePage/FilePage.setup.php" );

// CORE-128
if ( !empty( $wgEnableQualtricsSiteInterceptExt ) ) {
	include "$IP/extensions/wikia/QualtricsSiteIntercept/QualtricsSiteIntercept.setup.php";
}

// CAKE-4585
if ( !empty( $wgEnableTriviaQuizzesExt ) ) {
    include "$IP/extensions/wikia/TriviaQuizzes/TriviaQuizzes.setup.php";
}

include_once "$IP/extensions/wikia/AffiliateService/AffiliateService.setup.php";

// LORE-519
if ( !empty ( $wgEnableArticleExporterHooks ) ) {
    include "$IP/extensions/wikia/ArticleExporter/ArticleExporterHooks.setup.php";
}
// LORE-519
include "$IP/extensions/wikia/ArticleExporter/ArticleExporter.setup.php";

// LORE-823
include "${IP}/extensions/wikia/TaxonomyCategoryListing/TaxonomyCategoryListing.setup.php";

// DE-4374
if ( !empty ( $wgEnableHydralyticsExt ) ) {
	include "$IP/extensions/wikia/Hydralytics/Hydralytics.setup.php";
}

if ( $wgEnableArticleCommentsExt || $wgEnableWallExt || $wgEnableDiscussions ) {
	include "$IP/extensions/wikia/FeedsReportedPage/FeedsReportedPage.setup.php";
}

include_once "$IP/extensions/wikia/WikiDescription/WikiDescription.setup.php";

$wgUCPCommunityCNWAddress = 'https://ucp.fandom.com/wiki/Special:CreateNewWiki';
