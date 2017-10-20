<?php
/**
 * WhereIsExtension
 *
 * A WhereIsExtension extension for MediaWiki
 * Provides a list of wikis with enabled selected extension
 *
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia.com>
 * @date 2008-07-02
 * @copyright Copyright (C) 2008 Maciej Błaszkowski, Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/WhereIsExtension/SpecialWhereIsExtension.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named WhereIsExtension.\n";
	exit( 1 ) ;
}

$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'WhereIsExtension',
	'author' => 'Maciej Błaszkowski (Marooned) <marooned@wikia.com>',
	'descriptionmsg' => 'whereisextension-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WhereIsExtension',
);

$wgExtensionMessagesFiles['WhereIsExtension'] = dirname(__FILE__) . '/SpecialWhereIsExtension.i18n.php';

//Register special page
if (!function_exists('extAddSpecialPage')) {
	require("$IP/extensions/ExtensionFunctions.php");
}
extAddSpecialPage(dirname(__FILE__) . '/SpecialWhereIsExtension_body.php', 'WhereIsExtension', 'WhereIsExtension');
$wgSpecialPageGroups['WhereIsExtension'] = 'wikia';
