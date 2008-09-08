<?php
/**
 * WhereIsExtension
 *
 * A WhereIsExtension extension for MediaWiki
 * Provides a list of wikis with enabled selected extension
 *
 * @author Maciej B³aszkowski (Marooned) <marooned@wikia.com>
 * @date 2008-07-02
 * @copyright Copyright (C) 2008 Maciej B³aszkowski, Wikia, Inc.
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

$wgAvailableRights[] = 'WhereIsExtension';
$wgGroupPermissions['*']['WhereIsExtension'] = true;

$wgExtensionMessagesFiles['WhereIsExtension'] = dirname(__FILE__) . '/SpecialWhereIsExtension.i18n.php';

//Register special page
if (!function_exists('extAddSpecialPage')) {
	require("$IP/extensions/ExtensionFunctions.php");
}
extAddSpecialPage(dirname(__FILE__) . '/SpecialWhereIsExtension_body.php', 'WhereIsExtension', 'WhereIsExtension');
?>