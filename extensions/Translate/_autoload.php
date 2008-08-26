<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Autoload definitions.
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['TranslateTasks'] = $dir . 'TranslateTasks.php';
$wgAutoloadClasses['TaskOptions'] = $dir . 'TranslateTasks.php';

$wgAutoloadClasses['TranslateUtils'] = $dir . 'TranslateUtils.php';
$wgAutoloadClasses['HTMLSelector'] = $dir . 'TranslateUtils.php';

$wgAutoloadClasses['MessageChecks'] = $dir . 'MessageChecks.php';
$wgAutoloadClasses['MessageGroups'] = $dir . 'MessageGroups.php';
$wgAutoloadClasses['AliasMessageGroup'] = $dir . 'MessageGroups.php';

$wgAutoloadClasses['MessageCollection'] = $dir . 'Message.php';
$wgAutoloadClasses['TMessage'] = $dir . 'Message.php';

$wgAutoloadClasses['TranslateEditAddons'] = $dir . 'TranslateEditAddons.php';
$wgAutoloadClasses['languages'] = $IP . '/maintenance/language/languages.inc';
$wgAutoloadClasses['MessageWriter'] = $IP . '/maintenance/language/writeMessagesArray.inc';

$wgAutoloadClasses['TranslateRcFilter'] = $dir . 'RcFilter.php';

$wgAutoloadClasses['SpecialTranslate'] = $dir . 'TranslatePage.php';
$wgAutoloadClasses['SpecialMagic'] = $dir . 'SpecialMagic.php';
$wgAutoloadClasses['SpecialTranslationChanges'] = $dir . 'SpecialTranslationChanges.php';
$wgAutoloadClasses['SpecialTranslationStats'] = $dir . 'Stats.php';

$wgAutoloadClasses['TranslatePreferences'] = $dir . 'TranslateUtils.php';

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
$wgAutoloadClasses['XliffFormatWriter'] = $dir . 'ffs/Xliff.php';


# utils
$wgAutoloadClasses['ResourceLoader'] = $dir . 'utils/ResourceLoader.php';
$wgAutoloadClasses['StringMatcher'] = $dir . 'utils/StringMatcher.php';


$wgAutoloadClasses['StringMangler'] = $dir . 'utils/StringMangler.php';
$wgAutoloadClasses['SmItem'] = $dir . 'utils/StringMangler.php';
$wgAutoloadClasses['SmRewriter'] = $dir . 'utils/StringMangler.php';
$wgAutoloadClasses['SmAffixRewriter'] = $dir . 'utils/StringMangler.php';
$wgAutoloadClasses['SmRegexRewriter'] = $dir . 'utils/StringMangler.php';


# predefined groups
$wgAutoloadClasses['PremadeMediawikiExtensionGroups'] = $dir . 'groups/MediaWikiExtensions.php';
$wgAutoloadClasses['FreeColMessageGroup'] = $dir . 'groups/FreeCol.php';


