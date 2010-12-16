<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * An extension to ease the translation of Mediawiki and other projects.
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2006-2010, Niklas Laxström
 * @copyright Copyright © 2007-2010, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

define( 'TRANSLATE_VERSION', '2010-01-16' );

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Translate',
	'version'        => TRANSLATE_VERSION,
	'author'         => array( 'Niklas Laxström', 'Siebrand Mazeland' ),
	'description'    => '[[Special:Translate|Special page]] for translating Mediawiki and beyond',
	'descriptionmsg' => 'translate-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Translate',
);

// Setup class autoloads
$dir = dirname( __FILE__ ) . '/';
require_once( $dir . '_autoload.php' );

$wgExtensionMessagesFiles['Translate'] = $dir . 'Translate.i18n.php';
$wgExtensionMessagesFiles['PageTranslation'] = $dir . 'PageTranslation.i18n.php';
$wgExtensionAliasesFiles['Translate'] = $dir . 'Translate.alias.php';
$wgExtensionFunctions[] = 'efTranslateInit';

$wgSpecialPages['Translate'] = 'SpecialTranslate';
$wgSpecialPages['Translations'] = 'SpecialTranslations';
$wgSpecialPages['Magic'] = 'SpecialMagic';
$wgSpecialPages['TranslationChanges'] = 'SpecialTranslationChanges';
$wgSpecialPages['TranslationStats'] = 'SpecialTranslationStats';
$wgSpecialPages['LanguageStats'] = 'SpecialLanguageStats';
$wgSpecialPages['ImportTranslations'] = 'SpecialImportTranslations';
$wgSpecialPageGroups['Magic'] = 'wiki';
$wgSpecialPageGroups['Translate'] = 'wiki';
$wgSpecialPageGroups['Translations'] = 'pages';
$wgSpecialPageGroups['TranslationChanges'] = 'changes';
$wgSpecialPageGroups['TranslationStats'] = 'wiki';
$wgSpecialPageGroups['LanguageStats'] = 'wiki';
$wgSpecialPageGroups['PageTranslation'] = 'pagetools';

$wgHooks['EditPage::showEditForm:initial'][] = 'TranslateEditAddons::addTools';
$wgHooks['OutputPageBeforeHTML'][] = 'TranslateEditAddons::addNavigation';
$wgHooks['AlternateEdit'][] = 'TranslateEditAddons::intro';
$wgHooks['EditPageBeforeEditButtons'][] = 'TranslateEditAddons::buttonHack';
$wgHooks['EditPage::showEditForm:fields'][] = 'TranslateEditAddons::keepFields';
$wgHooks['SkinTemplateTabs'][] = 'TranslateEditAddons::tabs';

# Custom preferences
$wgDefaultUserOptions['translate'] = 0;
$wgDefaultUserOptions['translate-editlangs'] = 'default';
$wgDefaultUserOptions['translate-jsedit'] = 1;
$wgHooks['GetPreferences'][] = 'TranslatePreferences::onGetPreferences';
$wgHooks['GetPreferences'][] = 'TranslatePreferences::translationAssistLanguages';
$wgHooks['GetPreferences'][] = 'TranslatePreferences::translationJsedit';

# Recent changes filters
$wgHooks['SpecialRecentChangesQuery'][] = 'TranslateRcFilter::translationFilter';
$wgHooks['SpecialRecentChangesPanel'][] = 'TranslateRcFilter::translationFilterForm';
$wgHooks['SkinTemplateToolboxEnd'][] = 'TranslateToolbox::toolboxAllTranslations';



$wgEnablePageTranslation = false;
$wgPageTranslationNamespace = 1198;

$wgJobClasses['RenderJob'] = 'RenderJob';
$wgAvailableRights[] = 'translate';
$wgAvailableRights[] = 'translate-import';
$wgAvailableRights[] = 'translate-manage';

define( 'TRANSLATE_FUZZY', '!!FUZZY!!' );

#
# Configuration variables
#

/** Where to look for extension files */
$wgTranslateExtensionDirectory = "$IP/extensions/";

/** Which other language translations are displayed to help translator */
$wgTranslateLanguageFallbacks = array();

/** Name of the fuzzer bot */
$wgTranslateFuzzyBotName = 'FuzzyBot';

/** Address to css if non-default or false */
$wgTranslateCssLocation = $wgScriptPath . '/extensions/Translate';

/** Language code for special documentation language */
$wgTranslateDocumentationLanguageCode = false;

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

$wgTranslateMessageNamespaces = array( NS_MEDIAWIKI );

/** AC = Available classes */
$wgTranslateAC = array(
'core'                      => 'CoreMessageGroup',
'core-0-mostused'           => 'CoreMostUsedMessageGroup',
);

/**
 * Regexps for putting groups into subgroups. Deepest groups first.
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
	'/^out-mantis/' => array( 'mantis' ),
	'/^out-okawix/' => array( 'okawix' ),
	'/^page\|/' => array( 'page' ),
);

$wgTranslateAddMWExtensionGroups = false;
$wgTranslateGroupRoot = '/var/www/externals';
$wgTranslateGroupFiles = array();

/** EC = Enabled classes */
$wgTranslateEC = array();
$wgTranslateEC[] = 'core';

/** CC = Custom classes */
$wgTranslateCC = array();

/** Tasks */
$wgTranslateTasks = array(
	'view'                 => 'ViewMessagesTask',
	'untranslated'         => 'ViewUntranslatedTask',
	'optional'             => 'ViewOptionalTask',
//	'untranslatedoptional' => 'ViewUntranslatedOptionalTask',
	'review'               => 'ReviewMessagesTask',
	'reviewall'            => 'ReviewAllMessagesTask',
	'export-as-po'         => 'ExportasPoMessagesTask',
	'export-to-file'       => 'ExportToFileMessagesTask',
//	'export-to-xliff'      => 'ExportToXliffMessagesTask',
);

/** PHPlot for nice graphs */
$wgTranslatePHPlot = false;
$wgTranslatePHPlotFont = '/usr/share/fonts/truetype/ttf-dejavu/DejaVuSans.ttf';

/**
 * Currently supported spyc and syck.
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
**/
$wgTranslateYamlLibrary = 'spyc';

/**
 * Google API key if any. Currently only used for Google translation API.
 */
$wgGoogleApiKey = false;

function efTranslateInit() {
	global $wgTranslatePHPlot, $wgAutoloadClasses, $wgHooks;
	if ( $wgTranslatePHPlot ) {
		$wgAutoloadClasses['PHPlot'] = $wgTranslatePHPlot;
	}

	// Database schema
	$wgHooks['LoadExtensionSchemaUpdates'][] = 'PageTranslationHooks::schemaUpdates';

	// Do not activate hooks if not setup properly
	if ( !efTranslateCheckPT() ) {
		$wgEnablePageTranslation = false;
		return true;
	}

	// Fuzzy tags for speed
	$wgHooks['ArticleSaveComplete'][] = 'TranslateEditAddons::onSave';

	global $wgEnablePageTranslation;
	if ( $wgEnablePageTranslation ) {

		// Special page + the right to use it
		global $wgSpecialPages, $wgAvailableRights;
		$wgSpecialPages['PageTranslation'] = 'SpecialPageTranslation';
		$wgAvailableRights[] = 'pagetranslation';

		// Namespaces
		global $wgPageTranslationNamespace, $wgExtraNamespaces;
		global $wgNamespacesWithSubpages, $wgNamespaceProtection;
		global $wgTranslateMessageNamespaces;
		// Defines for nice usage
		define ( 'NS_TRANSLATIONS', $wgPageTranslationNamespace );
		define ( 'NS_TRANSLATIONS_TALK', $wgPageTranslationNamespace + 1 );
		// Register them as namespaces
		$wgExtraNamespaces[NS_TRANSLATIONS]      = 'Translations';
		$wgExtraNamespaces[NS_TRANSLATIONS_TALK] = 'Translations_talk';
		$wgNamespacesWithSubpages[NS_TRANSLATIONS]      = true;
		$wgNamespacesWithSubpages[NS_TRANSLATIONS_TALK] = true;
		// Standard protection and register it for filtering
		$wgNamespaceProtection[NS_TRANSLATIONS] = array( 'translate' );
		$wgTranslateMessageNamespaces[] = NS_TRANSLATIONS;

		// Page translation hooks
		// Register our css, is there a better place for this?
		$wgHooks['OutputPageBeforeHTML'][] = 'PageTranslationHooks::injectCss';

		// Add transver tags and update translation target pages
		$wgHooks['ArticleSaveComplete'][] = 'PageTranslationHooks::onSectionSave';

		// Foo
		# $wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'TranslateTagHooks::addSidebar';

		// Register <languages/>
		$wgHooks['ParserFirstCallInit'][] = 'efTranslateInitTags';

		// Strip <translate> tags etc. from source pages when rendering
		$wgHooks['ParserBeforeStrip'][] = 'PageTranslationHooks::renderTagPage';

		// Check syntax for <translate>
		$wgHooks['ArticleSave'][] = 'PageTranslationHooks::tpSyntaxCheck';

		// Add transtag to page props for discovery
		$wgHooks['ArticleSaveComplete'][] = 'PageTranslationHooks::addTranstag';

		// Prevent editing of unknown pages in Translations namespace
		$wgHooks['getUserPermissionsErrorsExpensive'][] = 'PageTranslationHooks::translationsCheck';

		$wgHooks['ArticleViewHeader'][] = 'PageTranslationHooks::test';

		$wgHooks['ParserTestTables'][] = 'PageTranslationHooks::parserTestTables';

		$wgHooks['SkinTemplateToolboxEnd'][] = 'PageTranslationHooks::exportToolbox';
	}
}

function efTranslateCheckPT() {
	global $wgHooks, $wgMemc, $wgCommandLineMode;

	// Short circuit tests on cli, useless db trip and no reporting.
	if ( $wgCommandLineMode ) return true;

	$version = "3"; // Must be a string
	global $wgMemc;
	$memcKey = wfMemcKey( 'pt' );
	$ok = $wgMemc->get( $memcKey );

	if ( $ok === $version ) {
		return true;
	}

	// Add our tags if they are not registered yet
	// tp:tag is called also the ready tag
	$tags = array( 'tp:mark', 'tp:tag', 'tp:transver', 'fuzzy' );

	$dbw = wfGetDB( DB_MASTER );
	if ( !$dbw->tableExists( 'revtag_type' ) ) {
		$wgHooks['SiteNoticeAfter'][] = array( 'efTranslateCheckWarn', 'tpt-install' );
		return false;
	}

	foreach ( $tags as $tag ) {
		// TODO: use insert ignore
		$field = array( 'rtt_name' => $tag );
		$ret = $dbw->selectField( 'revtag_type', 'rtt_name', $field, __METHOD__ );
		if ( $ret !== $tag ) $dbw->insert( 'revtag_type', $field, __METHOD__ );
	}

	$wgMemc->set( $memcKey, $version );

	return true;
}

function efTranslateCheckWarn( $msg, &$sitenotice ) {
	global $wgOut;
	wfLoadExtensionMessages( 'PageTranslation' );
	$sitenotice = wfMsg( $msg );
	$wgOut->enableClientCache( false );
	return true;
}

function efTranslateInitTags( $parser ) {
	// For nice language list in-page
	$parser->setHook( 'languages', array( 'PageTranslationHooks', 'languages' ) );
	return true;
}

if ( !defined( 'TRANSLATE_CLI' ) ) {
	function STDOUT() { }
	function STDERR() { }
}

$wgTranslateTM = false;

/**
 * Set to the url of Apertium Machine Translation service to activate.
 */
$wgTranslateApertium = false;