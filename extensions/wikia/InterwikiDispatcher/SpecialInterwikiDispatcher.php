<?php
/**
 * InterwikiDispatcher - see ticket #2954
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 * @date 2008-07-08
 * @copyright Copyright (C) 2008 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/InterwikiDispatcher/SpecialInterwikiDispatcher.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named InterwikiDispatcher.\n";
	exit(1) ;
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'InterwikiDispatcher',
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
	'descriptionmsg' => 'interwikidispatcher-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/InterwikiDispatcher'
);


//Register hook
$wgHooks['GetFullURL'][] = 'InterwikiDispatcher::getInterWikiaURLHook';

//Register special page
if (!function_exists('extAddSpecialPage')) {
	require("$IP/extensions/ExtensionFunctions.php");
}
extAddSpecialPage(dirname(__FILE__) . '/SpecialInterwikiDispatcher_body.php' /* file */, 'InterwikiDispatcher' /* name */, 'InterwikiDispatcher' /* class */);
