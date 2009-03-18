<?php

/**
 * MagicLinks
 *
 * A MagicLinks extension for MediaWiki
 * Replaces some syntex into clickable links
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2009-03-17
 * @copyright Copyright (C) 2008 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/SiteWideMessages/SpecialSiteWideMessages.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named MagicLinks.\n";
	exit(1) ;
}

$wgExtensionCredits['other'][] = array(
	'name' => 'MagicLinks',
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
	'description' => 'Replaces some syntex into clickable links (generaly used for svn revisions and ticket systems).'
);

$wgExtensionFunctions[] = 'MagicLinksInit';

function MagicLinksInit() {
	global $wgHooks;
	$wgHooks['OutputPageBeforeHTML'][] = 'MagicLinksReplaceLinks';
}

function MagicLinksReplaceLinks(&$out, &$text) {
	$aSearch = array(
		'/(?<=^|[[(<>\s])(t:r(\d+))/mi',	//new svn
		'/(?<=^|[[(<>\s])(r(\d+))/mi',	//old svn
		'/(?<=^|[[(<>\s])(rt#(\d+))/mi',	//new tickets (RT)
		'/(?<=^|[[(<>\s])(trac#(\d+))/mi',	//old tickets (trac)
	);
	$aReplace = array(
		'<a class="magicLink svnNew" href="http://trac.wikia-code.com/changeset/\2">\1</a>',
		'<a class="magicLink svnOld" href="https://trac.wikia-inc.com/trac/wikia/changeset/\2">\1</a>',
		'<a class="magicLink ticketRT" href="https://rt.wikia-inc.com/Ticket/Display.html?id=\2">\1</a>',
		'<a class="magicLink ticketTrac" href="https://trac.wikia-inc.com/trac/wikia/ticket/\2">\1</a>',
	);
	$text = preg_replace($aSearch, $aReplace, $text);
	return true;
}