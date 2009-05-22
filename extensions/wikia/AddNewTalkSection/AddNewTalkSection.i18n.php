<?php

/**
 * AddNewTalkSection
 *
 * A AddNewTalkSection extension for MediaWiki
 * Make long talk pages easier to use, by adding an "add new section" link to the page end.
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2009-05-19
 * @copyright Copyright (C) 2009 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/AddNewTalkSection/AddNewTalkSection.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named AddNewTalkSection.\n";
	exit(1) ;
}

$messages = array(
	'en' => array(
		'addnewtalksection-link' => 'Add new section'
	)
);