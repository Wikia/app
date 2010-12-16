<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * Autoload definitions.
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['TranslateTasks'] = $dir . 'TranslateTasks.php';
$wgAutoloadClasses['TaskOptions'] = $dir . 'TranslateTasks.php';

$wgAutoloadClasses['TranslateUtils'] = $dir . 'TranslateUtils.php';
$wgAutoloadClasses['HTMLSelector'] = $dir . 'TranslateUtils.php';

$wgAutoloadClasses['MessageChecker'] = $dir . 'MessageChecks.php';

$wgAutoloadClasses['MessageGroup'] = $dir . 'Groups.php';
$wgAutoloadClasses['MessageGroupBase'] = $dir . 'Groups.php';
$wgAutoloadClasses['FileBasedMessageGroup'] = $dir . 'Groups.php';

$wgAutoloadClasses['MessageGroupOld'] = $dir . 'MessageGroups.php';
$wgAutoloadClasses['MessageGroups'] = $dir . 'MessageGroups.php';
$wgAutoloadClasses['WikiPageMessageGroup'] = $dir . 'MessageGroups.php';
$wgAutoloadClasses['AliasMessageGroup'] = $dir . 'MessageGroups.php';

$wgAutoloadClasses['MessageCollection'] = $dir . 'MessageCollection.php';
$wgAutoloadClasses['MessageDefinitions'] = $dir . 'MessageCollection.php';
$wgAutoloadClasses['TMessage'] = $dir . 'Message.php';
$wgAutoloadClasses['ThinMessage'] = $dir . 'Message.php';
$wgAutoloadClasses['FatMessage'] = $dir . 'Message.php';

$wgAutoloadClasses['TranslateEditAddons'] = $dir . 'TranslateEditAddons.php';
$wgAutoloadClasses['languages'] = $IP . '/maintenance/language/languages.inc';
$wgAutoloadClasses['MessageWriter'] = $IP . '/maintenance/language/writeMessagesArray.inc';

$wgAutoloadClasses['TranslateRcFilter'] = $dir . 'RcFilter.php';

$wgAutoloadClasses['SpecialTranslate'] = $dir . 'TranslatePage.php';
$wgAutoloadClasses['SpecialMagic'] = $dir . 'SpecialMagic.php';
$wgAutoloadClasses['SpecialTranslationChanges'] = $dir . 'SpecialTranslationChanges.php';
$wgAutoloadClasses['SpecialTranslationStats'] = $dir . 'SpecialTranslationStats.php';
$wgAutoloadClasses['SpecialTranslations'] = $dir . 'SpecialTranslations.php';
$wgAutoloadClasses['SpecialLanguageStats'] = $dir . 'SpecialLanguageStats.php';
$wgAutoloadClasses['SpecialImportTranslations'] = $dir . 'SpecialImportTranslations.php';

$wgAutoloadClasses['SimpleFormatReader'] = $dir . 'ffs/Simple.php';
$wgAutoloadClasses['SimpleFormatWriter'] = $dir . 'ffs/Simple.php';
$wgAutoloadClasses['WikiFormatReader'] = $dir . 'ffs/Wiki.php';
$wgAutoloadClasses['WikiFormatWriter'] = $dir . 'ffs/Wiki.php';
$wgAutoloadClasses['WikiExtensionFormatReader'] = $dir . 'ffs/WikiExtension.php';
$wgAutoloadClasses['WikiExtensionFormatWriter'] = $dir . 'ffs/WikiExtension.php';
$wgAutoloadClasses['GettextFormatReader'] = $dir . 'ffs/Gettext.php';
$wgAutoloadClasses['GettextFormatWriter'] = $dir . 'ffs/Gettext.php';
$wgAutoloadClasses['JavaFormatReader'] = $dir . 'ffs/Java.php';
$wgAutoloadClasses['JavaFormatWriter'] = $dir . 'ffs/Java.php';
$wgAutoloadClasses['PhpVariablesFormatReader'] = $dir . 'ffs/PhpVariables.php';
$wgAutoloadClasses['PhpVariablesFormatWriter'] = $dir . 'ffs/PhpVariables.php';
$wgAutoloadClasses['OpenLayersFormatReader'] = $dir . 'ffs/OpenLayers.php';
$wgAutoloadClasses['OpenLayersFormatWriter'] = $dir . 'ffs/OpenLayers.php';
$wgAutoloadClasses['XliffFormatWriter'] = $dir . 'ffs/Xliff.php';

# utils
$wgAutoloadClasses['ResourceLoader'] = $dir . 'utils/ResourceLoader.php';
$wgAutoloadClasses['StringMangler'] = $dir . 'utils/StringMatcher.php';
$wgAutoloadClasses['StringMatcher'] = $dir . 'utils/StringMatcher.php';
$wgAutoloadClasses['FCFontFinder'] = $dir . 'utils/Font.php';

$wgAutoloadClasses['ArrayMemoryCache'] = $dir . 'utils/MemoryCache.php';

$wgAutoloadClasses['TranslatePreferences'] = $dir . 'utils/UserToggles.php';
$wgAutoloadClasses['TranslateToolbox'] = $dir . 'utils/ToolBox.php';

$wgAutoloadClasses['MessageIndexRebuilder'] = $dir . 'utils/MessageIndexRebuilder.php';
$wgAutoloadClasses['MessageTable'] = $dir . 'utils/MessageTable.php';
$wgAutoloadClasses['JsSelectToInput'] = $dir . 'utils/JsSelectToInput.php';
$wgAutoloadClasses['HTMLJsSelectToInputField'] = $dir . 'utils/HTMLJsSelectToInputField.php';
$wgAutoloadClasses['MessageGroupCache'] = $dir . 'utils/MessageGroupCache.php';
$wgAutoloadClasses['MessageWebImporter'] = $dir . 'utils/MessageWebImporter.php';
$wgAutoloadClasses['TranslationEditPage'] = $dir . 'utils/TranslationEditPage.php';
$wgAutoloadClasses['TranslationHelpers'] = $dir . 'utils/TranslationHelpers.php';
$wgAutoloadClasses['TranslationStats'] = $dir . 'utils/TranslationStats.php';

# predefined groups
$wgAutoloadClasses['AllMediawikiExtensionsGroup'] = $dir . 'groups/MediaWikiExtensions.php';
$wgAutoloadClasses['PremadeMediawikiExtensionGroups'] = $dir . 'groups/MediaWikiExtensions.php';
$wgAutoloadClasses['PremadeWikiaExtensionGroups'] = $dir . 'groups/Wikia/WikiaExtensions.php';
$wgAutoloadClasses['CommonistMessageGroup'] = $dir . 'groups/Commonist.php';
$wgAutoloadClasses['MantisMessageGroup'] = $dir . 'groups/Mantis.php';
$wgAutoloadClasses['NoccMessageGroup'] = $dir . 'groups/Nocc.php';
$wgAutoloadClasses['OpenLayersMessageGroup'] = $dir . 'groups/OpenLayers.php';
$wgAutoloadClasses['WikiblameMessageGroup'] = $dir . 'groups/Wikiblame.php';
$wgAutoloadClasses['MediaWikiMessageChecker'] = $dir . 'groups/MediaWiki/Checker.php';


# complex messages
$wgAutoloadClasses['ComplexMessages'] = $dir . 'groups/ComplexMessages.php';
$wgAutoloadClasses['SpecialPageAliasesCM'] = $dir . 'groups/ComplexMessages.php';
$wgAutoloadClasses['MagicWordsCM'] = $dir . 'groups/ComplexMessages.php';
$wgAutoloadClasses['NamespaceCM'] = $dir . 'groups/ComplexMessages.php';

# page translation
$wgAutoloadClasses['PageTranslationHooks'] = $dir . 'tag/PageTranslationHooks.php';
$wgAutoloadClasses['TranslatablePage'] = $dir . 'tag/TranslatablePage.php';
$wgAutoloadClasses['TPException'] = $dir . 'tag/TranslatablePage.php';
$wgAutoloadClasses['TPParse'] = $dir . 'tag/TPParse.php';
$wgAutoloadClasses['TPSection'] = $dir . 'tag/TPSection.php';
$wgAutoloadClasses['SpecialPageTranslation'] = $dir . 'tag/SpecialPageTranslation.php';
$wgAutoloadClasses['RenderJob'] = $dir . 'tag/RenderJob.php';

$wgAutoloadClasses['TranslateSpyc'] = $dir . 'utils/TranslateYaml.php';
$wgAutoloadClasses['TranslateYaml'] = $dir . 'utils/TranslateYaml.php';
$wgAutoloadClasses['SpecialManageGroups'] = $dir . 'SpecialManageGroups.php';

$wgAutoloadClasses['FFS'] = $dir . 'FFS.php';
$wgAutoloadClasses['SimpleFFS'] = $dir . 'FFS.php';
$wgAutoloadClasses['JavaFFS'] = $dir . 'FFS.php';
$wgAutoloadClasses['YamlFFS'] = $dir . 'FFS.php';
$wgAutoloadClasses['RubyYamlFFS'] = $dir . 'FFS.php';
$wgAutoloadClasses['JavaScriptFFS'] = $dir . 'FFS.php';
$wgAutoloadClasses['GettextFFS'] = $dir . '/ffs/Gettext.php';

$wgAutoloadClasses['HtmlTag'] = $dir . 'utils/Html.php';
$wgAutoloadClasses['RawHtml'] = $dir . 'utils/Html.php';
$wgAutoloadClasses['TagContainer'] = $dir . 'utils/Html.php';
