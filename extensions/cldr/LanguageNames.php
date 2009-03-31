<?php
if (!defined('MEDIAWIKI')) die();
/**
 * An extension which provised localised language names for other extensions.
 *
 * @addtogroup Extensions
 * @file
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2007-2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'Language Names',
	'version' => '1.5 (CLDR 1.6.0)',
	'author' => 'Niklas Laxström',
	'url' => 'http://unicode.org/cldr/repository_access.html',
	'description' => 'Extension which provides localised language names',
	'descriptionmsg' => 'cldr-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['cldr'] = $dir . 'LanguageNames.i18n.php';
$wgAutoloadClasses['LanguageNames'] = $dir . 'LanguageNames.body.php';
