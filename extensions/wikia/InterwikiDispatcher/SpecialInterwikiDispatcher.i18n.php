<?php
/**
 * InterwikiDispatcher - see ticket #2954
 *
 * @author Maciej B³aszkowski (Marooned) <marooned@wikia.com>
 * @date 2008-07-08
 * @copyright Copyright (C) 2008 Maciej B³aszkowski, Wikia Inc.
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

$messages = array(
	'en' => array(
		'interwikidispatcher'			=> 'InterwikiDispatcher',	//the name displayed on Special:SpecialPages
	)
);
?>