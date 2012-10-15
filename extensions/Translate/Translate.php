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
 * @copyright Copyright © 2006-2012, Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Version number used in extension credits and in other placed where needed.
 */
define( 'TRANSLATE_VERSION', '2012-01-31' );

/**
 * Extension credits properties.
 */
$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Translate',
	'version'        => TRANSLATE_VERSION,
	'author'         => array( 'Niklas Laxström', 'Siebrand Mazeland' ),
	'descriptionmsg' => 'translate-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Translate',
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
$wgExtensionMessagesFiles['TranslateAlias'] = $dir . 'Translate.alias.php';
$wgExtensionMessagesFiles['TranslateMagic'] = $dir . 'Translate.magic.php';

// Register initialization code
$wgExtensionFunctions[] = 'TranslateHooks::setupTranslate';
$wgHooks['CanonicalNamespaces'][] = 'TranslateHooks::setupNamespaces';
$wgHooks['UnitTestsList'][] = 'TranslateHooks::setupUnitTests';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'TranslateHooks::schemaUpdates';
$wgHooks['ParserTestTables'][] = 'TranslateHooks::parserTestTables';
$wgHooks['PageContentLanguage'][] = 'TranslateHooks::onPageContentLanguage';

// Register special pages into MediaWiki
$wgSpecialPages['Translate'] = 'SpecialTranslate';
$wgSpecialPageGroups['Translate'] = 'wiki';
$wgSpecialPages['Translations'] = 'SpecialTranslations';
$wgSpecialPageGroups['Translations'] = 'pages';
// Disabled by default
// $wgSpecialPages['Magic'] = 'SpecialMagic';
$wgSpecialPageGroups['Magic'] = 'wiki';
$wgSpecialPages['TranslationStats'] = 'SpecialTranslationStats';
$wgSpecialPageGroups['TranslationStats'] = 'wiki';
$wgSpecialPages['LanguageStats'] = 'SpecialLanguageStats';
$wgSpecialPageGroups['LanguageStats'] = 'wiki';
$wgSpecialPages['MessageGroupStats'] = 'SpecialMessageGroupStats';
$wgSpecialPageGroups['MessageGroupStats'] = 'wiki';
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
$wgAPIMetaModules['messagegroupstats'] = 'ApiQueryMessageGroupStats';
$wgAPIMetaModules['messagetranslations'] = 'ApiQueryMessageTranslations';
$wgAPIModules['translationreview'] = 'ApiTranslationReview';
$wgAPIModules['groupreview'] = 'ApiGroupReview';
$wgAPIModules['ttmserver'] = 'ApiTTMServer';
$wgHooks['APIQueryInfoTokens'][] = 'ApiTranslationReview::injectTokenFunction';
$wgHooks['APIQueryInfoTokens'][] = 'ApiGroupReview::injectTokenFunction';

// Register hooks.
$wgHooks['EditPage::showEditForm:initial'][] = 'TranslateEditAddons::addTools';
$wgHooks['SkinTemplateTabs'][] = 'TranslateEditAddons::addNavigationTabs';
// Same for Vector skin
$wgHooks['SkinTemplateNavigation'][] = 'TranslateEditAddons::addNavigationTabs';
$wgHooks['AlternateEdit'][] = 'TranslateEditAddons::intro';
$wgHooks['EditPageBeforeEditButtons'][] = 'TranslateEditAddons::buttonHack';
$wgHooks['EditPage::showEditForm:fields'][] = 'TranslateEditAddons::keepFields';
$wgHooks['SkinTemplateTabs'][] = 'TranslateEditAddons::tabs';
$wgHooks['LanguageGetTranslatedLanguageNames'][] = 'TranslateHooks::translateMessageDocumentationLanguage';
$wgHooks['ArticlePrepareTextForEdit'][] = 'TranslateEditAddons::disablePreSaveTransform';
// Fuzzy tags for speed.
$wgHooks['ArticleSaveComplete'][] = 'TranslateEditAddons::onSave';
$wgHooks['Translate:newTranslation'][] = 'TranslateEditAddons::updateTransverTag';

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
$wgHooks['Translate:newTranslation'][] = 'TranslationMemoryUpdater::update';
$wgHooks['Translate:newTranslation'][] = 'TranslateHooks::updateTM';

// Translation display related
$wgHooks['ArticleContentOnDiff'][] = 'TranslateEditAddons::displayOnDiff';

// Search profile
$wgHooks['SpecialSearchProfiles'][] = 'TranslateHooks::searchProfile';
$wgHooks['SpecialSearchProfileForm'][] = 'TranslateHooks::searchProfileForm';
$wgHooks['SpecialSearchSetupEngine'][] = 'TranslateHooks::searchProfileSetupEngine';

$wgHooks['LinkBegin'][] = 'SpecialMyLanguage::linkfix';

// New rights
$wgAvailableRights[] = 'translate';
$wgAvailableRights[] = 'translate-import';
$wgAvailableRights[] = 'translate-manage';
$wgAvailableRights[] = 'translate-messagereview';
$wgAvailableRights[] = 'translate-groupreview';

// New rights group
$wgGroupPermissions['translate-proofr']['translate-messagereview'] = true;
$wgAddGroups['translate-proofr'] = array( 'translate-proofr' );

// Logs
$wgLogTypes[] = 'translationreview';
$wgLogActionsHandlers['translationreview/message'] = 'TranslateHooks::formatTranslationreviewLogEntry';
$wgLogActionsHandlers['translationreview/group'] = 'TranslateHooks::formatTranslationreviewLogEntry';
// BC for <1.19
$wgLogHeaders['translationreview'] = 'log-description-translationreview';
$wgLogNames['translationreview'] = 'log-name-translationreview';

// New jobs
$wgJobClasses['MessageIndexRebuildJob'] = 'MessageIndexRebuildJob';

$resourcePaths = array(
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'Translate'
);

// Client-side resource modules
$wgResourceModules['ext.translate'] = array(
	'styles' => 'resources/ext.translate.css',
	'position' => 'top',
) + $resourcePaths;

$wgResourceModules['ext.translate.helplink'] = array(
	'styles' => 'resources/ext.translate.helplink.css',
	'position' => 'top',
) + $resourcePaths;

$wgResourceModules['ext.translate.messagetable'] = array(
	'scripts' => 'resources/ext.translate.messagetable.js',
	'styles' => 'resources/ext.translate.messagetable.css',
	'position' => 'top',
	'dependencies' => array(
		'mediawiki.util',
	),
	'messages' => array(
		'translate-messagereview-submit',
		'translate-messagereview-progress',
		'translate-messagereview-failure',
		'translate-messagereview-done',
		'api-error-badtoken',
		'api-error-emptypage',
		'api-error-fuzzymessage',
		'api-error-invalidrevision',
		'api-error-owntranslation',
		'api-error-unknownmessage',
		'api-error-unknownerror',
		'tpt-unknown-page'
	),
) + $resourcePaths;

$wgResourceModules['ext.translate.quickedit'] = array(
	'scripts' => 'resources/ext.translate.quickedit.js',
	'styles' => 'resources/ext.translate.quickedit.css',
	'messages' => array( 'translate-js-nonext', 'translate-js-save-failed' ),
	'dependencies' => array(
		'jquery.form',
		'jquery.ui.dialog',
		'jquery.autoresize',
		'mediawiki.util',
	),
) + $resourcePaths;

$wgResourceModules['ext.translate.selecttoinput'] = array(
	'scripts' => 'resources/ext.translate.selecttoinput.js',
) + $resourcePaths;

$wgResourceModules['ext.translate.special.importtranslations'] = array(
	'scripts' => 'resources/ext.translate.special.importtranslations.js',
	'dependencies' => array(
		'jquery.ui.autocomplete',
	),
) + $resourcePaths;

$wgResourceModules['ext.translate.special.languagestats'] = array(
	'scripts' => 'resources/ext.translate.special.languagestats.js',
	'styles' => 'resources/ext.translate.special.languagestats.css',
	'messages' => array( 'translate-langstats-expandall', 'translate-langstats-collapseall', 'translate-langstats-expand', 'translate-langstats-collapse' ),
) + $resourcePaths;

$wgResourceModules['ext.translate.special.pagetranslation'] = array(
	'styles' => 'resources/ext.translate.special.pagetranslation.css',
	'position' => 'top',
) + $resourcePaths;

$wgResourceModules['ext.translate.special.supportedlanguages'] = array(
	'styles' => 'resources/ext.translate.special.supportedlanguages.css',
	'position' => 'top',
) + $resourcePaths;

$wgResourceModules['ext.translate.special.translate'] = array(
	'styles' => 'resources/ext.translate.special.translate.css',
	'scripts' => 'resources/ext.translate.special.translate.js',
	'position' => 'top',
	'dependencies' => array( 'mediawiki.util' ),
	'messages' => array(
		'translate-workflow-set-do',
		'translate-workflow-set-doing',
		'translate-workflow-set-done',
		'translate-workflow-set-error-alreadyset',
	),
) + $resourcePaths;

$wgResourceModules['jquery.autoresize'] = array(
	'scripts' => 'resources/jquery.autoresize.js',
) + $resourcePaths;

// Doesn't exist in 1.17, but declaring twice causes an error
if ( version_compare( $wgVersion, '1.18', '<' ) ) {
$wgResourceModules['jquery.form'] = array(
	'scripts' => 'resources/jquery.form.js',
) + $resourcePaths;
}

/** @endcond */


# == Configuration variables ==

# === Basic configuration ===
# <source lang=php>
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
 * Add a preference "Do not send me e-mail newsletters" in the e-mail preferences.
 */
$wgTranslateNewsletterPreference = false;

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
/*
$wgTranslateTranslationServices['TTMServer'] = array(
	'database' => false, // Passed to wfGetDB
	'cutoff' => 0.75,
	'timeout-sync' => 0, // Unused
	'timeout-async' => 0, // Unused
	'type' => 'ttmserver',
	'public' => false,
);
*/

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
	'timeout-sync' => 6,
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
//	'review'               => 'ReviewMessagesTask',
	'acceptqueue'          => 'AcceptQueueMessagesTask',
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

/**
 * When unprivileged users opens a translation editor, he will
 * see message stating that special permission is needed for translating
 * messages. If this variable is defined, there is a button which will
 * take the user to that page to ask for permission.
 */
$wgTranslatePermissionUrl = 'Project:Translator';

# </source>
# === Page translation feature ===
# <source lang=php>
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

# </source>
# === Message group configuration ===
# <source lang=php>

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
	'/^ext-semantic/' => array( 'ext', 'semantic' ),
	'/^ext-socialprofile/' => array( 'ext', 'socialprofile' ),
	'/^ext-translate/' => array( 'ext', 'translate' ),
	'/^ext-uniwiki/' => array( 'ext', 'uniwiki' ),
	'/^ext-ui/' => array( 'ext', 'usabilityinitiative' ),
	'/^ext/' => array( 'ext' ),
	'/^wikia/' => array( 'wikia' ),
	'/^tsint/' => array( 'tsint' ),
	'/^out-eol/' => array( 'eol' ),
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

/**
 * List of possible message group review workflow states and colors for each state.
 * Users who have translate-groupreview right can set this in Special:Translate.
 * The state is visible in Special:Translate, Special:MessageGroupStats and
 * Special:LanguageStats. If the value is false, the workflow states feature
 * is disabled.
 * Up two 32 characters each.
 * Example:
 * array(
 *      'new' => 'FF0000', // red
 *      'needs_proofreading' => '0000FF', // blue
 *      'ready' => 'FFFF00', // yellow
 *      'published' => '00FF00', // green
 * );
 *
 */
$wgTranslateWorkflowStates = false;

# </source>
# === System setup related configuration ===
# <source lang=php>
/**
 * Location of your extensions, if not the default. Only matters
 * if you are localising your own extensions with this extension.
 */
$wgTranslateExtensionDirectory = "$IP/extensions/";

/**
 * Set location of cache files. Defaults to $wgCacheDirectory.
 */
$wgTranslateCacheDirectory = false;

/**
 * Configures where message index is stored.
 * Available classes are CachedMessageIndex and FileCachedMessageIndex.
 * FileCachedMessageIndex needs $wgCacheDirectory to be functional.
 */
$wgTranslateMessageIndex = array( 'CachedMessageIndex' );
// $wgTranslateMessageIndex = array( 'FileCachedMessageIndex' );

# </source>
# ==== PHPlot ====
# <source lang=php>
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

# </source>
# ==== YAML driver ====
# <source lang=php>
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

# </source>

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
