<?php
/*
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @author Stephanie Amanda Stevens <phroziac@gmail.com>
 * @author SPQRobin <robin_1273@hotmail.com>
 * @copyright Copyright (C) 2005-2007 Stephanie Amanda Stevens
 * @copyright Copyright (C) 2007 SPQRobin
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * Formatting improvements Stephen Kennedy, 2006.
 */

if (!defined('MEDIAWIKI')) die();

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'SpecialInterwiki',
	'url'            => 'http://mediawiki.org/wiki/Extension:SpecialInterwiki',
	'description'    => 'Adds a [[Special:Interwiki|special page]] to view and edit the interwiki table',
	'svn-date'       => '$LastChangedDate: 2008-07-09 22:17:33 +0000 (Wed, 09 Jul 2008) $',
	'svn-revision'   => '$LastChangedRevision: 37451 $',
	'author'         => array( 'Stephanie Amanda Stevens', 'SPQRobin', 'others' ),
	'descriptionmsg' => 'interwiki-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Interwiki'] = $dir . 'SpecialInterwiki.i18n.php';
$wgExtensionAliasesFiles['Interwiki'] = $dir . 'SpecialInterwiki.alias.php';

$wgSpecialPages['Interwiki'] = 'SpecialInterwiki';
$wgAutoloadClasses['SpecialInterwiki'] = $dir . 'SpecialInterwiki_body.php';

$wgAvailableRights[] = 'interwiki';

$wgLogTypes[] = 'interwiki';
$wgLogNames['interwiki'] = 'interwiki_logpagename';
$wgLogHeaders['interwiki'] = 'interwiki_logpagetext';
$wgLogActions['interwiki/interwiki'] = 'interwiki_logentry';
$wgLogActions['interwiki/iw_add'] = 'interwiki_log_added';
$wgLogActions['interwiki/iw_delete'] = 'interwiki_log_deleted';
$wgLogActions['interwiki/iw_edit'] = 'interwiki_log_edited';
