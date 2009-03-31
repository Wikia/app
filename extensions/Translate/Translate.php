<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * An extension to ease the translation of Mediawiki and other projects.
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2006-2008, Niklas Laxström
 * @copyright Copyright © 2007-2008, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

define( 'TRANSLATE_VERSION', '9 (2008-12-07)' );

$wgExtensionCredits['specialpage'][] = array(
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
$wgExtensionAliasesFiles['Translate'] = $dir . 'Translate.alias.php';
$wgExtensionFunctions[] = 'efTranslateInit';

$wgSpecialPages['Translate'] = 'SpecialTranslate';
$wgSpecialPages['Translations'] = 'SpecialTranslations';
$wgSpecialPages['Magic'] = 'SpecialMagic';
$wgSpecialPages['TranslationChanges'] = 'SpecialTranslationChanges';
$wgSpecialPages['TranslationStats'] = 'SpecialTranslationStats';
$wgSpecialPages['LanguageStats'] = 'SpecialLanguageStats';
$wgSpecialPageGroups['Magic'] = 'wiki';
$wgSpecialPageGroups['Translate'] = 'wiki';
$wgSpecialPageGroups['Translations'] = 'pages';
$wgSpecialPageGroups['TranslationChanges'] = 'changes';
$wgSpecialPageGroups['TranslationStats'] = 'wiki';
$wgSpecialPageGroups['LanguageStats'] = 'wiki';

$wgHooks['EditPage::showEditForm:initial'][] = 'TranslateEditAddons::addTools';
$wgHooks['OutputPageBeforeHTML'][] = 'TranslateEditAddons::addNavigation';
$wgHooks['UserToggles'][] = 'TranslatePreferences::TranslateUserToggles';
$wgHooks['SpecialRecentChangesQuery'][] = 'TranslateRcFilter::translationFilter';
$wgHooks['SpecialRecentChangesPanel'][] = 'TranslateRcFilter::translationFilterForm';
$wgHooks['SkinTemplateToolboxEnd'][] = 'TranslateToolbox::toolboxAllTranslations';

// Tag hooks
$wgHooks['getUserPermissionsErrorsExpensive'][] = 'TranslateTagHooks::disableEdit';
$wgHooks['ParserAfterStrip'][] = 'TranslateTagHooks::renderTagPage';
$wgHooks['OutputPageBeforeHTML'][] = 'TranslateTagHooks::injectCss';
$wgHooks['ArticleSaveComplete'][] = 'TranslateTagHooks::onSave';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'TranslateTagHooks::addSidebar';
$wgHooks['ArticleSave'][] = 'TranslateTag::save';
$wgHooks['ParserFirstCallInit'][] = 'efTranslateInitTags';
$wgHooks['BeforeParserFetchTemplateAndtitle'][] = 'TranslateTagHooks::onTemplate';


$wgJobClasses['FuzzyJob'] = 'FuzzyJob';
$wgJobClasses['RenderJob'] = 'RenderJob';
$wgAvailableRights[] = 'translate';

define( 'TRANSLATE_FUZZY', '!!FUZZY!!' );
define( 'TRANSLATE_INDEXFILE', $dir . 'data/messageindex.ser' );
define( 'TRANSLATE_CHECKFILE', $dir . 'data/messagecheck.ser' );
define( 'TRANSLATE_ALIASFILE', $dir . 'aliases.txt' );

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
'core-mostused'             => 'CoreMostUsedMessageGroup',
);

/**
 * Regexps for putting groups into subgroups. Deepest groups first.
 */
$wgTranslateGroupStructure = array(
	'/^core/' => array( 'core' ),
	'/^ext-flaggedrevs/' => array( 'ext', 'flaggedrevs' ),
	'/^ext-socialprofile/' => array( 'ext', 'socialprofile' ),
	'/^ext-uniwiki/' => array( 'ext', 'uniwiki' ),
	'/^ext/' => array( 'ext' ),
	'/^page\|/' => array( 'page' ),
);

$wgTranslateAddMWExtensionGroups = false;

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
	'untranslatedoptional' => 'ViewUntranslatedOptionalTask',
	'problematic'          => 'ViewProblematicTask',
	'review'               => 'ReviewMessagesTask',
	'reviewall'            => 'ReviewAllMessagesTask',
	'export-as-po'         => 'ExportasPoMessagesTask',
//	'export'               => 'ExportMessagesTask',
	'export-to-file'       => 'ExportToFileMessagesTask',
//	'export-to-xliff'      => 'ExportToXliffMessagesTask',
);

/** PHPlot for nice graphs */
$wgTranslatePHPlot = false;
$wgTranslatePHPlotFont = '/usr/share/fonts/truetype/ttf-dejavu/DejaVuSans.ttf';

// Options for <translate> tag
/**
 * Can be used to define where translation of sections are stored for tag
 * translations.
 * Two item array, where first item is namespace and latter is page name.
 * Namespace is either null which means the same as the current namespace, or
 * integer denoting some fixed namespace.
 * Page name can have following variables:
 * - $NS: the namespace of the source page with
 * - $PAGE: name of the page without namespace
 * - $FULLNAME: name of the page with possible namespace
 * - $KEY: automatically or assigned unique key for section,
 *         without this page names may not be unique!
 * - $SNIPPET: automatically constructed snippet of the section contents to give
 *             more meaningful names for the pages.
 */
$wgTranslateTagTranslationLocation = array(
	null, // Namespace is whatever the page is in
	'$PAGE/translations/$KEY-$SNIPPET'
);

if ( $wgDebugComments ) {
	require_once( "$dir/utils/MemProfile.php" );
} else {
	function wfMemIn() { }
	function wfMemOut() { }
}

function efTranslateInit() {
	global $wgTranslatePHPlot, $wgAutoloadClasses;
	if ( $wgTranslatePHPlot ) {
		$wgAutoloadClasses['PHPlot'] = $wgTranslatePHPlot;
	}
}


function efTranslateInitTags( $parser ) {
	// For nice language list in-page
	$parser->setHook( 'languages', array( 'TranslateTagHooks', 'languages' ) );
	return true;
}
