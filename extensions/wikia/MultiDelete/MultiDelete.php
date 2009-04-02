<?php

/**
 * MultiDelete
 *
 * A MultiDelete extension for MediaWiki
 * Deletes batch of pages
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2009-01-09
 * @copyright Copyright (C) 2009 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/MultiDelete/MultiDelete.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named MultiDelete.\n";
	exit(1) ;
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'MultiDelete',
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)], Bartek Łapiński',
	'description' => 'This extension deletes a batch of pages or a page on multiple wikis.'
);

//$wgExtensionFunctions[] = 'MultiDeleteInit';
$wgExtensionMessagesFiles['MultiDelete'] = dirname(__FILE__) . '/MultiDelete.i18n.php';

//Register special page
if (!function_exists('extAddSpecialPage')) {
	require("$IP/extensions/ExtensionFunctions.php");
}
extAddSpecialPage(dirname(__FILE__) . '/MultiDelete_body.php', 'MultiDelete', 'MultiDelete');
$wgSpecialPageGroups['MultiDelete'] = 'wikia';
