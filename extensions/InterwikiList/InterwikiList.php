<?php
/**
 * Extension:InterwikiList - Display a list of available interwiki prefixes
 * that editors can use. 
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @author Chad Horohoe <innocentkiller@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
 
$wgExtensionCredits['specialpage'][] = array(
        'name'			=> 'Interwiki List',
	'version'		=> '0.3',
        'url'			=> 'http://mediawiki.org/wiki/Extension:InterwikiList',
        'description'		=> 'Adds a [[Special:Interwikilist|special page]] to view available interwiki links',
        'author'		=> '[mailto:innocentkiller@gmail.com Chad Horohoe]',
        'descriptionmsg'	=> 'interwikilist-desc',
);

$dir = dirname(__FILE__) . '/';
$wgSpecialPages['InterwikiList'] = 'InterwikiList';
$wgAutoloadClasses['InterwikiList'] = $dir . 'InterwikiList_body.php';
$wgExtensionMessagesFiles['InterwikiList'] = $dir . 'InterwikiList.i18n.php';
$wgExtensionAliasesFiles['InterwikiList'] = $dir . 'InterwikiList.alias.php';
$wgSpecialPageGroups['InterwikiList'] = 'wiki';
