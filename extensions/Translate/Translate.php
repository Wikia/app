<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * An extension to ease the translation of Mediawiki and other projects.
 *
 * @file
 * @ingroup Extensions
 *
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2006-2010, Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Version number used in extension credits and in other placed where needed.
 */
define( 'TRANSLATE_VERSION', '2011-05-15' );

/**
 * Extension credits properties.
 */
$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Translate',
	'version'        => TRANSLATE_VERSION,
	'author'         => array( 'Niklas Laxström', 'Siebrand Mazeland' ),
	'descriptionmsg' => 'translate-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Translate',
);

/**
 * @cond file_level_code
 * Setup class autoloading.
 */
$dir = dirname( __FILE__ ) . '/';
require_once( $dir . '_autoload.php' );
/** @endcond */

/**
 * @cond file_level_code
 */

// Register extension messages and other localisation.
$wgExtensionMessagesFiles['Translate'] = $dir . 'Translate.i18n.php';
$wgExtensionMessagesFiles['FirstSteps'] = $dir . 'FirstSteps.i18n.php';
$wgExtensionMessagesFiles['PageTranslation'] = $dir . 'PageTranslation.i18n.php';
$wgExtensionMessagesFiles['TranslateGroupDescriptions'] = $dir . 'TranslateGroupDescriptions.i18n.php';
$wgExtensionAliasesFiles['Translate'] = $dir . 'Translate.alias.php';

// Register initialization hook
$wgExtensionFunctions[] = 'efTranslateInit';
$wgHooks['CanonicalNamespaces'][] = 'efTranslateNamespaces';

// Register special pages into MediaWiki
$wgSpecialPages['Translate'] = 'SpecialTranslate';
$wgSpecialPageGroups['Translate'] = 'wiki';
$wgSpecialPages['Translations'] = 'SpecialTranslations';
$wgSpecialPageGroups['Translations'] = 'pages';
$wgSpecialPages['Magic'] = 'SpecialMagic';
$wgSpecialPageGroups['Magic'] = 'wiki';
$wgSpecialPages['TranslationChanges'] = 'SpecialTranslationChanges';
$wgSpecialPageGroups['TranslationChanges'] = 'changes';
$wgSpecialPages['TranslationStats'] = 'SpecialTranslationStats';
$wgSpecialPageGroups['TranslationStats'] = 'wiki';
$wgSpecialPages['LanguageStats'] = 'SpecialLanguageStats';
$wgSpecialPageGroups['LanguageStats'] = 'wiki';
$wgSpecialPages['ImportTranslations'] = 'SpecialImportTranslations';
$wgSpecialPageGroups['ImportTranslations'] = 'wiki';
$wgSpecialPages['ManageMessageGroups'] = 'SpecialManageGroups';
$wgSpecialPageGroups['ManageMessageGroups'] = 'wiki';
// Unlisted special page; does not need $wgSpecialPageGroups.
$wgSpecialPages['FirstSteps'] = 'SpecialFirstSteps';
// Unlisted special page; does not need $wgSpecialPageGroups.
$wgSpecialPages['SupportedLanguages'] = 'SpecialSupportedLanguages';
// Unlisted special page; does not need $wgSpecialPageGroups.
$wgSpecialPages['MyLanguage'] = 'SpecialMyLanguage';

// API
$wgAPIListModules['messagecollection'] = 'ApiQueryMessageCollection';
$wgAPIMetaModules['messagegroups'] = 'ApiQueryMessageGroups';

// Register hooks.
$wgHooks['EditPage::showEditForm:initial'][] = 'TranslateEditAddons::addTools';
$wgHooks['SkinTemplateTabs'][] = 'TranslateEditAddons::addNavigationTabs';
// Same for Vector skin
$wgHooks['SkinTemplateNavigation'][] = 'TranslateEditAddons::addNavigationTabs';
$wgHooks['AlternateEdit'][] = 'TranslateEditAddons::intro';
$wgHooks['EditPageBeforeEditButtons'][] = 'TranslateEditAddons::buttonHack';
$wgHooks['EditPage::showEditForm:fields'][] = 'TranslateEditAddons::keepFields';
$wgHooks['SkinTemplateTabs'][] = 'TranslateEditAddons::tabs';
$wgHooks['LanguageGetTranslatedLanguageNames'][] = 'TranslateEditAddons::translateMessageDocumentationLanguage';
$wgHooks['ArticlePrepareTextForEdit'][] = 'TranslateEditAddons::disablePreSaveTransform';

// Custom preferences
$wgDefaultUserOptions['translate'] = 0;
$wgDefaultUserOptions['translate-editlangs'] = 'default';
$wgDefaultUserOptions['translate-jsedit'] = 1;
$wgHooks['GetPreferences'][] = 'TranslatePreferences::onGetPreferences';
$wgHooks['GetPreferences'][] = 'TranslatePreferences::translationAssistLanguages';
$wgHooks['GetPreferences'][] = 'TranslatePreferences::translationJsedit';

// Recent changes filters
$wgHooks['SpecialRecentChangesQuery'][] = 'TranslateRcFilter::translationFilter';
$wgHooks['SpecialRecentChangesPanel'][] = 'TranslateRcFilter::translationFilterForm';
$wgHooks['SkinTemplateToolboxEnd'][] = 'TranslateToolbox::toolboxAllTranslations';

// Translation memory updates
$wgHooks['ArticleSaveComplete'][] = 'TranslationMemoryUpdater::update';

// Translation display related
$wgHooks['ArticleContentOnDiff'][] = 'TranslateEditAddons::displayOnDiff';

// Search profile
$wgHooks['SpecialSearchProfiles'][] = 'TranslateEditAddons::searchProfile';
$wgHooks['SpecialSearchProfileForm'][] = 'TranslateEditAddons::searchProfileForm';
$wgHooks['SpecialSearchSetupEngine'][] = 'TranslateEditAddons::searchProfileSetupEngine';

// New rights
$wgAvailableRights[] = 'translate';
$wgAvailableRights[] = 'translate-import';
$wgAvailableRights[] = 'translate-manage';

$resourcePaths = array(
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'Translate'
);

// Client-side resource modules
$wgResourceModules['translate-css'] = array(
	'styles' => 'Translate.css',
) + $resourcePaths;

$wgResourceModules['ext.translate.special.languagestats'] = array(
	'scripts' => 'js/ext.translate.special.languagestats.js',
	'styles' => 'js/ext.translate.special.languagestats.css',
	'messages' => array( 'translate-langstats-expandall', 'translate-langstats-collapseall', 'translate-langstats-expand', 'translate-langstats-collapse' ),
) + $resourcePaths;

$wgResourceModules['ext.translate.quickedit'] = array(
	'scripts' => 'js/quickedit.js',
	'styles' => 'js/ext.translate.quickedit.css',
) + $resourcePaths;

$wgResourceModules['ext.translate.messagetable'] = array(
	'styles' => 'js/ext.translate.messagetable.css',
	'position' => 'top',
) + $resourcePaths;

$wgResourceModules['ext.translate.special.translate'] = array(
	'styles' => 'js/ext.translate.special.translate.css',
) + $resourcePaths;

$wgResourceModules['jquery.autoresize'] = array(
	'scripts' => 'js/jquery.autoresize.js',
) + $resourcePaths;

/** @endcond */


# == Configuration variables ==

# === Basic configuration ===

/**
 * Language code for message documentation. Suggested values are qqq or info.
 * If set to false (default), message documentation feature is disabled.
 */
$wgTranslateDocumentationLanguageCode = false;

/**
 * Name of the bot which will invalidate translations and do maintenance
 * for page translation feature. Also used for importing messages from external
 * sources.
 */
$wgTranslateFuzzyBotName = 'FuzzyBot';

/**
 * Default values for list of languages to show translators as an aid when
 * translating. Each user can override this setting in their preferences.
 * Example:
 *  $wgTranslateLanguageFallbacks['fi'] = 'sv';
 *  $wgTranslateLanguageFallbacks['sv'] = array( 'da', 'no', 'nn' );
 */
$wgTranslateLanguageFallbacks = array();

/**
 * Text that will be shown in translations if the translation is outdated.
 * Must be something that does not conflict with actual content.
 */
if ( !defined( 'TRANSLATE_FUZZY' ) ) {
	define( 'TRANSLATE_FUZZY', '!!FUZZY!!' );
}

/**
 * Define various web services that provide translation suggestions.
 * Example for tmserver translation memory from translatetoolkit.
 * <pre>
 * $wgTranslateTranslationServices['tmserver'] = array(
 *   'server' => 'http://127.0.0.1',
 *   'port' => 54321,
 *   'timeout-sync' => 3,
 *   'timeout-async' => 6,
 *   'database' => '/path/to/database.sqlite',
 *   'type' => 'tmserver',
 * );
 * </pre>
 *
 * For Google and Apertium, you should get an API key.
 * @see http://wiki.apertium.org/wiki/Apertium_web_service
 * @see http://code.google.com/apis/ajaxsearch/key.html
 *
 * The translation services are provided with the following information:
 * - server ip address
 * - versions of MediaWiki and Translate extension
 * - clients ip address encrypted with $wgProxyKey
 * - source text to translate
 * - private API key if provided
 */
$wgTranslateTranslationServices = array();
$wgTranslateTranslationServices['Google'] = array(
	'url' => 'http://ajax.googleapis.com/ajax/services/language/translate',
	'key' => null,
	'timeout-sync' => 3,
	'timeout-async' => 6,
	'type' => 'google',
);
$wgTranslateTranslationServices['Microsoft'] = array(
	'url' => 'http://api.microsofttranslator.com/V2/Http.svc/Translate',
	'key' => null,
	'timeout-sync' => 3,
	'timeout-async' => 6,
	'type' => 'microsoft',
);
$wgTranslateTranslationServices['Apertium'] = array(
	'url' => 'http://api.apertium.org/json/translate',
	'pairs' => 'http://api.apertium.org/json/listPairs',
	'key' => null,
	'timeout-sync' => 2,
	'timeout-async' => 6,
	'type' => 'apertium',
	'codemap' => array( 'no' => 'nb' ),
);

/**
 * List of tasks in Special:Translate. If you are only using page translation
 * feature, you might want to disable 'optional' task. Example:
 *  unset($wgTranslateTasks['optional']);
 */
$wgTranslateTasks = array(
	'view'                 => 'ViewMessagesTask',
	'untranslated'         => 'ViewUntranslatedTask',
	'optional'             => 'ViewOptionalTask',
	'suggestions'          => 'ViewWithSuggestionsTask',
//	'untranslatedoptional' => 'ViewUntranslatedOptionalTask',
	'review'               => 'ReviewMessagesTask',
	'reviewall'            => 'ReviewAllMessagesTask',
	'export-as-po'         => 'ExportasPoMessagesTask',
	'export-to-file'       => 'ExportToFileMessagesTask',
//	'export-to-xliff'      => 'ExportToXliffMessagesTask',
);

/**
 * Experimental support for Ask help button.
 * Might change into hook later on.
 * This is an array with keys page and params.
 * - page is a title of a local wiki page
 * - params is an array of key-value pairs of request params
 * -- param value can contain variable %MESSAGE% which will be replaced with
 *    full page name.
 * @since 2011-03-11
 */
$wgTranslateSupportUrl = false;


# === Page translation feature ===

/**
 * Enable page translation feature.
 *
 * Page translation feature allows structured translation of wiki pages
 * with simple markup and automatic tracking of changes.
 *
 * @defgroup PageTranslation Page Translation
 * @see http://translatewiki.net/wiki/Translating:Page_translation_feature
 */
$wgEnablePageTranslation = false;

/**
 * Number for the Translations namespace. Change this if it conflicts with
 * other namespace in your wiki.
 */
$wgPageTranslationNamespace = 1198;

/**
 * Hack to reduce database queries due to indirection in the database
 * layout. May go away in future.
 * Example:
 *  $wgTranslateStaticTags = array(
 *  	"tp:mark" => 3,
 *  	"tp:tag" => 4,
 *  	"tp:transver" => 5
 *  );
 */
$wgTranslateStaticTags = false;


# === Message group configuration ===

/**
 * Two-dimensional array of languages that cannot be translated.
 * Input can be exact group name, first part before '-' or '*' for all.
 * Second dimension should be language code mapped to reason for disabling.
 * Reason is parsed as wikitext.
 *
 * Example:
 * $wgTranslateBlacklist = array(
 *     '*' => array( // All groups
 *         'en' => 'English is the source language.',
 *     ),
 *     'core' => array( // Exact group
 *         'mul' => 'Not a real language.',
 *     ),
 *     'ext' => array( // Wildcard-like group
 *         'mul' => 'Not a real language',
 *     ),
 * );
 */

$wgTranslateBlacklist = array();

/**
 * Two-dimensional array of rules that blacklists certain authors from appearing
 * in the exports. This is useful for keeping bots and people doing maintenance
 * work in translations not to appear besides real translators everywhere.
 *
 * Rules are arrays, where first element is type: white or black. Whitelisting
 * always overrules blacklisting. Second element should be a valid pattern that
 * can be given a preg_match(). It will be matched against string of format
 * "group-id;language;author name", without quotes.
 * As an example by default we have rule that ignores all authors whose name
 * ends in a bot for all languages and all groups.
 */
$wgTranslateAuthorBlacklist = array();
$wgTranslateAuthorBlacklist[] = array( 'black', '/^.*;.*;.*Bot$/Ui' );

/**
 * Regexps for putting groups into subgroups at Special:Translate.
 * Deepest groups first.
 */
$wgTranslateGroupStructure = array(
	'/^core/' => array( 'core' ),
	'/^ext-collection/' => array( 'ext', 'collection' ),
	'/^ext-flaggedrevs/' => array( 'ext', 'flaggedrevs' ),
	'/^ext-readerfeedback/' => array( 'ext', 'readerfeedback' ),
	'/^ext-socialprofile/' => array( 'ext', 'socialprofile' ),
	'/^ext-translate/' => array( 'ext', 'translate' ),
	'/^ext-uniwiki/' => array( 'ext', 'uniwiki' ),
	'/^ext-ui/' => array( 'ext', 'usabilityinitiative' ),
	'/^ext/' => array( 'ext' ),
	'/^wikia/' => array( 'wikia' ),
	'/^tsint/' => array( 'tsint' ),
	'/^out-ihris-common/' => array( 'ihris', 'common' ),
	'/^out-ihris-i2ce/' => array( 'ihris', 'i2ce' ),
	'/^out-ihris-manage/' => array( 'ihris', 'manage' ),
	'/^out-ihris-qualify/' => array( 'ihris', 'qualify' ),
	'/^out-ihris/' => array( 'ihris' ),
	'/^out-mantis/' => array( 'mantis' ),
	'/^out-mifos/' => array( 'mifos' ),
	'/^out-nocc/' => array( 'nocc' ),
	'/^out-okawix/' => array( 'okawix' ),
	'/^out-openimages/' => array( 'openimages' ),
	'/^out-osm/' => array( 'osm' ),
	'/^out-pywikipedia/' => array( 'pywikipedia' ),
	'/^out-shapado/' => array( 'shapado' ),
	'/^out-statusnet-plugin/' => array( 'statusnet', 'plugin' ),
	'/^out-statusnet/' => array( 'statusnet' ),
//	'/^page\|/' => array( 'page' ),
);

/**
 * List of namespace that contain messages. No talk namespaces.
 * @see http://translatewiki.net/wiki/Translating:Group_configuration
 */
$wgTranslateMessageNamespaces = array( NS_MEDIAWIKI );

/**
 * AC = Available classes.
 * Basic classes register themselves in here.
 */
$wgTranslateAC = array(
	'core'                => 'CoreMessageGroup',
	'core-0-mostused'     => 'CoreMostUsedMessageGroup',
	'core-0-mostused-old' => 'OldCoreMostUsedMessageGroup',
);

/**
 * EC = Enabled classes.
 * Which of the basic classes are enabled.
 * To enable them all, use:
 *  $wgTranslateEC = $wgTranslateAC;
 */
$wgTranslateEC = array();
/**
 * Add MediaWiki core messages group.
 */
$wgTranslateEC[] = 'core';

/**
 * CC = Custom classes.
 * Custom classes register themselves here.
 * Key is always the group id, while the value is an message group object
 * or callable function.
 */
$wgTranslateCC = array();

/**
 * Enable all configured MediaWiki extensions.
 * Extensions which do not exist are ignored.
 * @see Translate/groups/mediawiki-defines.txt
 */
$wgTranslateAddMWExtensionGroups = false;

/**
 * Location in the filesystem to which paths are relative in custom groups.
 */
$wgTranslateGroupRoot = '/var/www/externals';

/**
 * The newest and recommended way of adding custom groups is YAML files.
 * See examples under Translate/groups
 * Usage example:
 *  $wgTranslateGroupFiles[] = "$IP/extensions/Translate/groups/Shapado/Shapado.yml";
 */
$wgTranslateGroupFiles = array();


# === System setup related configuration ===

/**
 * Location of your extensions, if not the default. Only matters
 * if you are localising your own extensions with this extension.
 */
$wgTranslateExtensionDirectory = "$IP/extensions/";

/**
 * Set location of cache files. Defaults to $wgCacheDirectory.
 */
$wgTranslateCacheDirectory = false;

# ==== PHPlot ====

/**
 * For Special:TranslationStats PHPlot is needed to produce graphs.
 * Set this the location of phplot.php.
 */
$wgTranslatePHPlot = false;

/**
 * The default font for PHPlot for drawing text. Only used if the automatic
 * best font selection fails. The automatic best font selector uses language
 * code to call fc-match program. If you have open_basedir restriction or
 * safe-mode, using the found font is likely to fail. In this case you need
 * to change the code to use hard-coded font, or copy fonts to location PHP
 * can access them, and make sure fc-match returns only those fonts.
 */
$wgTranslatePHPlotFont = '/usr/share/fonts/truetype/ttf-dejavu/DejaVuSans.ttf';

# ==== YAML driver ====

/**
 * Currently supported YAML drivers are spyc and syck and sycl-pecl.
 *
 * For syck we're shelling out to perl. So you need:
 *
 * * At least perl 5.8 (find out what you have by running "perl -v")
 * * Install these modules from CPAN
 *   * YAML::Syck
 *   * PHP::Serialization.
 *   * File::Slurp
 *
 * You should be able to do this with:
 *   for module in 'YAML::Syck' 'PHP::Serialization' 'File::Slurp'; do cpanp -i $module; done
 *
 * For the shell to work, you also need an en.UTF-8 locale installed on your system.
 * add a line "en.UTF-8" to your /etc/locale.gen or uncomment an existing one and run locale-gen
 * if you do not have it already.
 *
 * For syck-pecl you need libsyck and pecl install syck-beta
 */
$wgTranslateYamlLibrary = 'spyc';


# Startup code
function efTranslateNamespaces( &$list ) {
	global $wgPageTranslationNamespace;
	if ( !defined( 'NS_TRANSLATIONS' ) ) {
		define( 'NS_TRANSLATIONS', $wgPageTranslationNamespace );
		define( 'NS_TRANSLATIONS_TALK', $wgPageTranslationNamespace + 1 );
	}
	$list[NS_TRANSLATIONS]      = 'Translations';
	$list[NS_TRANSLATIONS_TALK] = 'Translations_talk';
	return true;
}

/**
 * Initialises the extension.
 * Does late-initialization that is not possible at file level,
 * because it depends on user configuration.
 * @private
 */
function efTranslateInit() {
	global $wgTranslatePHPlot, $wgAutoloadClasses, $wgHooks;

	if ( $wgTranslatePHPlot ) {
		$wgAutoloadClasses['PHPlot'] = $wgTranslatePHPlot;
	}

	global $wgReservedUsernames, $wgTranslateFuzzyBotName;
	$wgReservedUsernames[] = $wgTranslateFuzzyBotName;

	// Hook for database schema.
	$wgHooks['LoadExtensionSchemaUpdates'][] = 'PageTranslationHooks::schemaUpdates';

	// Do not activate hooks if not setup properly
	global $wgEnablePageTranslation;
	if ( !efTranslateCheckPT() ) {
		$wgEnablePageTranslation = false;
		return true;
	}

	// Fuzzy tags for speed.
	$wgHooks['ArticleSaveComplete'][] = 'TranslateEditAddons::onSave';

	// Page translation setup check and init if enabled.
	if ( $wgEnablePageTranslation ) {
		// Special page and the right to use it
		global $wgSpecialPages, $wgAvailableRights, $wgSpecialPageGroups;
		$wgSpecialPages['PageTranslation'] = 'SpecialPageTranslation';
		$wgSpecialPageGroups['PageTranslation'] = 'pagetools';
		$wgAvailableRights[] = 'pagetranslation';

		global $wgLogNames, $wgLogActionsHandlers, $wgLogTypes, $wgLogHeaders;
		$wgLogTypes[] = 'pagetranslation';
		$wgLogHeaders['pagetranslation'] = 'pt-log-header';
		$wgLogNames['pagetranslation'] = 'pt-log-name';
		$wgLogActionsHandlers['pagetranslation/mark'] = 'PageTranslationHooks::formatLogEntry';
		$wgLogActionsHandlers['pagetranslation/unmark'] = 'PageTranslationHooks::formatLogEntry';
		$wgLogActionsHandlers['pagetranslation/moveok'] = 'PageTranslationHooks::formatLogEntry';
		$wgLogActionsHandlers['pagetranslation/movenok'] = 'PageTranslationHooks::formatLogEntry';

		global $wgJobClasses;
		$wgJobClasses['RenderJob'] = 'RenderJob';
		$wgJobClasses['MoveJob'] = 'MoveJob';

		// Namespaces
		global $wgPageTranslationNamespace, $wgExtraNamespaces;
		global $wgNamespacesWithSubpages, $wgNamespaceProtection;
		global $wgTranslateMessageNamespaces, $wgVersion;

		// Define constants for more readable core
		if ( !defined( 'NS_TRANSLATIONS' ) ) {
			define( 'NS_TRANSLATIONS', $wgPageTranslationNamespace );
			define( 'NS_TRANSLATIONS_TALK', $wgPageTranslationNamespace + 1 );
		}

		if ( version_compare( $wgVersion, '1.17alpha', '<' ) ) {
			efTranslateNamespaces( $wgExtraNamespaces );
		}

		$wgNamespacesWithSubpages[NS_TRANSLATIONS]      = true;
		$wgNamespacesWithSubpages[NS_TRANSLATIONS_TALK] = true;

		// Standard protection and register it for filtering
		$wgNamespaceProtection[NS_TRANSLATIONS] = array( 'translate' );
		$wgTranslateMessageNamespaces[] = NS_TRANSLATIONS;

		/// Page translation hooks

		/// @todo Register our css, is there a better place for this?
		$wgHooks['OutputPageBeforeHTML'][] = 'PageTranslationHooks::injectCss';

		// Add transver tags and update translation target pages
		$wgHooks['ArticleSaveComplete'][] = 'PageTranslationHooks::onSectionSave';

		// Register \<languages/>
		$wgHooks['ParserFirstCallInit'][] = 'efTranslateInitTags';

		// Strip \<translate> tags etc. from source pages when rendering
		$wgHooks['ParserBeforeStrip'][] = 'PageTranslationHooks::renderTagPage';

		// Check syntax for \<translate>
		$wgHooks['ArticleSave'][] = 'PageTranslationHooks::tpSyntaxCheck';
		$wgHooks['EditFilterMerged'][] = 'PageTranslationHooks::tpSyntaxCheckForEditPage';

		// Add transtag to page props for discovery
		$wgHooks['ArticleSaveComplete'][] = 'PageTranslationHooks::addTranstag';

		// Prevent editing of unknown pages in Translations namespace
		$wgHooks['getUserPermissionsErrorsExpensive'][] = 'PageTranslationHooks::preventUnknownTranslations';
		// Prevent editing of translation pages directly
		$wgHooks['getUserPermissionsErrorsExpensive'][] = 'PageTranslationHooks::preventDirectEditing';

		// Locking during page moves
		$wgHooks['getUserPermissionsErrorsExpensive'][] = 'PageTranslationHooks::lockedPagesCheck';

		// Our custom header for translation pages
		$wgHooks['ArticleViewHeader'][] = 'PageTranslationHooks::test';

		// Our tables are needed for parser tests
		$wgHooks['ParserTestTables'][] = 'PageTranslationHooks::parserTestTables';

		// Prevent section pages appearing in categories
		$wgHooks['LinksUpdate'][] = 'PageTranslationHooks::preventCategorization';

		// Custom move page that can move all the associated pages too
		$wgHooks['SpecialPage_initList'][] = 'PageTranslationHooks::replaceMovePage';
	}
}

/**
 * Checks if page translation was set up properly.
 * @ingroup PageTranslation
 * @private
 */
function efTranslateCheckPT() {
	global $wgHooks, $wgMemc, $wgCommandLineMode;

	# Short circuit tests on cli, useless db trip and no reporting.
	if ( $wgCommandLineMode ) {
		return true;
	}

	$version = "3"; # Must be a string
	$memcKey = wfMemcKey( 'pt' );
	$ok = $wgMemc->get( $memcKey );

	if ( $ok === $version ) {
		return true;
	}

	/** Add our tags if they are not registered yet
	 *  tp:tag is called also the ready tag
	 * @todo Remove useless complication that is revtag_type table.
	 */
	$tags = array( 'tp:mark', 'tp:tag', 'tp:transver', 'fuzzy' );

	$dbw = wfGetDB( DB_MASTER );
	if ( !$dbw->tableExists( 'revtag_type' ) ) {
		$wgHooks['SiteNoticeAfter'][] = array( 'efTranslateCheckWarn', 'tpt-install' );
		return false;
	}

	foreach ( $tags as $tag ) {
		/// @todo: use insert ignore
		$field = array( 'rtt_name' => $tag );
		$ret = $dbw->selectField( 'revtag_type', 'rtt_name', $field, __METHOD__ );

		if ( $ret !== $tag ) {
			$dbw->insert( 'revtag_type', $field, __METHOD__ );
		}
	}

	$wgMemc->set( $memcKey, $version );

	return true;
}

/**
 * Replaces the sitenotice with a warning that the extension is not
 * set up properly. Also disables caching to avoid the notices getting
 * stuck.
 * @param $msg \string Message key
 * @param $sitenotice \string
 * @return \bool true
 */
function efTranslateCheckWarn( $msg, &$sitenotice ) {
	global $wgOut;
	$sitenotice = wfMsg( $msg );
	$wgOut->enableClientCache( false );
	return true;
}

/**
 * Registers \<languages> tag with the parser.
 * @param $parser Parser
 * @return \bool true
 */
function efTranslateInitTags( $parser ) {
	// For nice language list in-page
	$parser->setHook( 'languages', array( 'PageTranslationHooks', 'languages' ) );
	return true;
}

/** @cond cli_support */
if ( !defined( 'TRANSLATE_CLI' ) ) {
	function STDOUT() { }
	function STDERR() { }
}
/** @endcond */

/**
 * Helper function for adding namespace for message groups.
 *
 * It defines constants for the namespace (and talk namespace) and sets up
 * restrictions and some other configuration.
 * @param $id \int Namespace number
 * @param $name \string Name of the namespace
 */
function wfAddNamespace( $id, $name ) {
	global $wgExtraNamespaces, $wgContentNamespaces,
		$wgTranslateMessageNamespaces, $wgNamespaceProtection,
		$wgNamespacesWithSubpages, $wgNamespacesToBeSearchedDefault;

	$constant = strtoupper( "NS_$name" );

	define( $constant, $id );
	define( $constant . '_TALK', $id + 1 );

	$wgExtraNamespaces[$id]   = $name;
	$wgExtraNamespaces[$id + 1] = $name . '_talk';

	$wgContentNamespaces[]           = $id;
	$wgTranslateMessageNamespaces[]  = $id;

	$wgNamespacesWithSubpages[$id]   = true;
	$wgNamespacesWithSubpages[$id + 1] = true;

	$wgNamespaceProtection[$id] = array( 'translate' );

	$wgNamespacesToBeSearchedDefault[$id] = true;
}

/** @defgroup TranslateSpecialPage Special pages of Translate extension */
