<?php
/**
 * Autoload definitions.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2011, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/** @cond file_level_code */
$dir = dirname( __FILE__ ) . '/';
/** @endcond */

/**
 * @name   Core extension classes
 * @{
 */
$wgAutoloadClasses['TranslateTasks'] = $dir . 'TranslateTasks.php';
$wgAutoloadClasses['TaskOptions'] = $dir . 'TranslateTasks.php';

$wgAutoloadClasses['TranslateUtils'] = $dir . 'TranslateUtils.php';

$wgAutoloadClasses['TranslateHooks'] = $dir . 'TranslateHooks.php';

$wgAutoloadClasses['MessageChecker'] = $dir . 'MessageChecks.php';
$wgAutoloadClasses['MediaWikiMessageChecker'] = $dir . 'MediaWikiMessageChecker.php';

$wgAutoloadClasses['MessageGroup'] = $dir . 'Groups.php';
$wgAutoloadClasses['MessageGroupBase'] = $dir . 'Groups.php';
$wgAutoloadClasses['FileBasedMessageGroup'] = $dir . 'Groups.php';

$wgAutoloadClasses['MessageGroupOld'] = $dir . 'MessageGroups.php';
$wgAutoloadClasses['MessageGroups'] = $dir . 'MessageGroups.php';
$wgAutoloadClasses['WikiPageMessageGroup'] = $dir . 'MessageGroups.php';
$wgAutoloadClasses['AliasMessageGroup'] = $dir . 'MessageGroups.php';
$wgAutoloadClasses['RecentMessageGroup'] = $dir . 'MessageGroups.php';
$wgAutoloadClasses['WorkflowStatesMessageGroup'] = $dir . 'MessageGroups.php';

$wgAutoloadClasses['MessageCollection'] = $dir . 'MessageCollection.php';
$wgAutoloadClasses['MessageDefinitions'] = $dir . 'MessageCollection.php';

$wgAutoloadClasses['TMessage'] = $dir . 'Message.php';
$wgAutoloadClasses['ThinMessage'] = $dir . 'Message.php';
$wgAutoloadClasses['FatMessage'] = $dir . 'Message.php';

$wgAutoloadClasses['TranslateEditAddons'] = $dir . 'TranslateEditAddons.php';
$wgAutoloadClasses['TranslateRcFilter'] = $dir . 'RcFilter.php';
/**@}*/

/**
 * @name   MediaWiki core classes
 * These are not autoloaded by default in MediaWiki core until 1.19.
 * @{
 */
$wgAutoloadClasses['languages'] = $IP . '/maintenance/language/languages.inc';
$wgAutoloadClasses['MessageWriter'] = $IP . '/maintenance/language/writeMessagesArray.inc';
/**@}*/

/**
 * @name   Special pages
 * There are few more special pages in page translation section.
 * @{
 */
$wgAutoloadClasses['SpecialTranslate'] = $dir . 'specials/SpecialTranslate.php';
$wgAutoloadClasses['SpecialMagic'] = $dir . 'specials/SpecialMagic.php';
$wgAutoloadClasses['SpecialTranslationStats'] = $dir . 'specials/SpecialTranslationStats.php';
$wgAutoloadClasses['SpecialTranslations'] = $dir . 'specials/SpecialTranslations.php';
$wgAutoloadClasses['SpecialLanguageStats'] = $dir . 'specials/SpecialLanguageStats.php';
$wgAutoloadClasses['SpecialMessageGroupStats'] = $dir . 'specials/SpecialMessageGroupStats.php';
$wgAutoloadClasses['SpecialImportTranslations'] = $dir . 'specials/SpecialImportTranslations.php';
$wgAutoloadClasses['SpecialFirstSteps'] = $dir . 'specials/SpecialFirstSteps.php';
$wgAutoloadClasses['SpecialSupportedLanguages'] = $dir . 'specials/SpecialSupportedLanguages.php';
$wgAutoloadClasses['SpecialMyLanguage'] = $dir . 'specials/SpecialMyLanguage.php';
$wgAutoloadClasses['SpecialManageGroups'] = $dir . 'specials/SpecialManageGroups.php';
/**@}*/

/**
 * @name   Old-style file format support (FFS)
 * @{
 */
$wgAutoloadClasses['SimpleFormatReader'] = $dir . 'ffs/Simple.php';
$wgAutoloadClasses['SimpleFormatWriter'] = $dir . 'ffs/Simple.php';
$wgAutoloadClasses['WikiFormatReader'] = $dir . 'ffs/Wiki.php';
$wgAutoloadClasses['WikiFormatWriter'] = $dir . 'ffs/Wiki.php';
$wgAutoloadClasses['WikiExtensionFormatReader'] = $dir . 'ffs/WikiExtension.php';
$wgAutoloadClasses['WikiExtensionFormatWriter'] = $dir . 'ffs/WikiExtension.php';
$wgAutoloadClasses['XliffFormatWriter'] = $dir . 'ffs/Xliff.php';
/**@}*/

/**
 * @name   Various utilities
 * @{
 */
$wgAutoloadClasses['PHPVariableLoader'] = $dir . 'utils/ResourceLoader.php';
$wgAutoloadClasses['StringMangler'] = $dir . 'utils/StringMatcher.php';
$wgAutoloadClasses['StringMatcher'] = $dir . 'utils/StringMatcher.php';
$wgAutoloadClasses['FCFontFinder'] = $dir . 'utils/Font.php';
$wgAutoloadClasses['FuzzyBot'] = $dir . 'utils/FuzzyBot.php';

$wgAutoloadClasses['TranslatePreferences'] = $dir . 'utils/UserToggles.php';
$wgAutoloadClasses['TranslateToolbox'] = $dir . 'utils/ToolBox.php';

$wgAutoloadClasses['MessageIndex'] = $dir . 'utils/MessageIndex.php';
$wgAutoloadClasses['MessageIndexRebuildJob'] = $dir . 'utils/MessageIndexRebuildJob.php';
$wgAutoloadClasses['MessageTable'] = $dir . 'utils/MessageTable.php';
$wgAutoloadClasses['StatsTable'] = $dir . 'utils/StatsTable.php';
$wgAutoloadClasses['JsSelectToInput'] = $dir . 'utils/JsSelectToInput.php';
$wgAutoloadClasses['HTMLJsSelectToInputField'] = $dir . 'utils/HTMLJsSelectToInputField.php';
$wgAutoloadClasses['MessageGroupCache'] = $dir . 'utils/MessageGroupCache.php';
$wgAutoloadClasses['MessageGroupStats'] = $dir . 'utils/MessageGroupStats.php';
$wgAutoloadClasses['MessageWebImporter'] = $dir . 'utils/MessageWebImporter.php';
$wgAutoloadClasses['TranslationEditPage'] = $dir . 'utils/TranslationEditPage.php';
$wgAutoloadClasses['TranslationHelpers'] = $dir . 'utils/TranslationHelpers.php';
$wgAutoloadClasses['TranslationStats'] = $dir . 'utils/TranslationStats.php';

$wgAutoloadClasses['TranslationMemoryUpdater'] = $dir . 'utils/TranslationMemoryUpdater.php';

$wgAutoloadClasses['TranslateYaml'] = $dir . 'utils/TranslateYaml.php';

$wgAutoloadClasses['RevTag'] = $dir . 'utils/RevTag.php';

$wgAutoloadClasses['MessageHandle'] = $dir . 'utils/MessageHandle.php';
$wgAutoloadClasses['TTMServer'] = $dir . 'utils/TTMServer.php';


/**@}*/

/**
 * @name   Classes for predefined old-style message groups
 * @{
 */
$wgAutoloadClasses['PremadeMediawikiExtensionGroups'] = $dir . 'ffs/MediaWikiExtensions.php';
$wgAutoloadClasses['PremadeWikiaExtensionGroups'] = $dir . 'ffs//WikiaExtensions.php';
$wgAutoloadClasses['PremadeToolserverTextdomains'] = $dir . 'ffs/ToolserverTextdomains.php';
/**@}*/

/**
 * @name   Non-message translation item support
 * @{
 */
$wgAutoloadClasses['ComplexMessages'] = $dir . 'ffs/MediaWikiComplexMessages.php';
$wgAutoloadClasses['SpecialPageAliasesCM'] = $dir . 'ffs/MediaWikiComplexMessages.php';
$wgAutoloadClasses['MagicWordsCM'] = $dir . 'ffs/MediaWikiComplexMessages.php';
$wgAutoloadClasses['NamespaceCM'] = $dir . 'ffs/MediaWikiComplexMessages.php';
/**@}*/

/**
 * @name   Classes for page translation feature
 * @ingroup PageTranslation
 * @{
 */
$wgAutoloadClasses['PageTranslationHooks'] = $dir . 'tag/PageTranslationHooks.php';
$wgAutoloadClasses['TranslatablePage'] = $dir . 'tag/TranslatablePage.php';
$wgAutoloadClasses['TPException'] = $dir . 'tag/TPException.php';
$wgAutoloadClasses['TPParse'] = $dir . 'tag/TPParse.php';
$wgAutoloadClasses['TPSection'] = $dir . 'tag/TPSection.php';
$wgAutoloadClasses['SpecialPageTranslation'] = $dir . 'tag/SpecialPageTranslation.php';
$wgAutoloadClasses['SpecialPageTranslationMovePage'] = $dir . 'tag/SpecialPageTranslationMovePage.php';
$wgAutoloadClasses['SpecialPageTranslationDeletePage'] = $dir . 'tag/SpecialPageTranslationDeletePage.php';
$wgAutoloadClasses['RenderJob'] = $dir . 'tag/RenderJob.php';
$wgAutoloadClasses['MoveJob'] = $dir . 'tag/MoveJob.php';
$wgAutoloadClasses['DeleteJob'] = $dir . 'tag/DeleteJob.php';
/**@}*/

/**
 * @name   Classes for new-style file format support (FFS)
 * @{
 */
$wgAutoloadClasses['FFS'] = $dir . 'FFS.php';
$wgAutoloadClasses['SimpleFFS'] = $dir . 'FFS.php';
$wgAutoloadClasses['JavaFFS'] = $dir . 'FFS.php';
$wgAutoloadClasses['YamlFFS'] = $dir . 'FFS.php';
$wgAutoloadClasses['RubyYamlFFS'] = $dir . 'FFS.php';
$wgAutoloadClasses['JavaScriptFFS'] = $dir . 'FFS.php';
$wgAutoloadClasses['OpenLayersFFS'] = $dir . 'FFS.php';
$wgAutoloadClasses['ShapadoJsFFS'] = $dir . 'FFS.php';
$wgAutoloadClasses['GettextFFS'] = $dir . '/ffs/Gettext.php';
$wgAutoloadClasses['FlatPhpFFS'] = $dir . 'ffs/PhpVariables.php';
$wgAutoloadClasses['DtdFFS'] = $dir . 'ffs/DTD.php';
$wgAutoloadClasses['PythonSingleFFS'] = $dir . 'FFS.php';
/**@}*/

/**
 * @name   Classes for different kind of html building
 * @{
 */
$wgAutoloadClasses['HtmlTag'] = $dir . 'utils/Html.php';
$wgAutoloadClasses['RawHtml'] = $dir . 'utils/Html.php';
$wgAutoloadClasses['TagContainer'] = $dir . 'utils/Html.php';
/**@}*/

/**
 * @name   API modules
 * @{
 */
$wgAutoloadClasses['ApiQueryMessageCollection'] = $dir . 'api/ApiQueryMessageCollection.php';
$wgAutoloadClasses['ApiQueryMessageGroups'] = $dir . 'api/ApiQueryMessageGroups.php';
$wgAutoloadClasses['ApiQueryMessageGroupStats'] = $dir . 'api/ApiQueryMessageGroupStats.php';
$wgAutoloadClasses['ApiQueryMessageTranslations'] = $dir . 'api/ApiQueryMessageTranslations.php';
$wgAutoloadClasses['ApiTranslationReview'] = $dir . 'api/ApiTranslationReview.php';
$wgAutoloadClasses['ApiGroupReview'] = $dir . 'api/ApiGroupReview.php';
$wgAutoloadClasses['ApiTTMServer'] = $dir . 'api/ApiTTMServer.php';
/**@}*/
