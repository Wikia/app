<?php
/** \file
* \brief Contains setup code for the User Merge and Delete Extension.
*/

/**
 * UserMerge Extension for MediaWiki
 *
 * Copyright (C) Tim Laqua
 * Copyright (C) Thomas Gries
 * Copyright (C) Matthew April
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo "User Merge and Delete extension";
        exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'User Merge and Delete',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:User_Merge_and_Delete',
	'author'         => array( 'Tim Laqua', 'Thomas Gries', 'Matthew April' ),
	'descriptionmsg' => 'usermerge-desc',
	'version'        => '1.6.31'
);

$wgAvailableRights[] = 'usermerge';
# $wgGroupPermissions['bureaucrat']['usermerge'] = true;

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['UserMerge'] = $dir . 'UserMerge_body.php';

$wgExtensionMessagesFiles['UserMerge'] = $dir . 'UserMerge.i18n.php';
$wgExtensionMessagesFiles['UserMergeAlias'] = $dir . 'UserMerge.alias.php';
$wgSpecialPages['UserMerge'] = 'UserMerge';
$wgSpecialPageGroups['UserMerge'] = 'users';

$wgUserMergeProtectedGroups = array( "sysop" );

# Add a new log type
$wgLogTypes[]                         = 'usermerge';
$wgLogNames['usermerge']              = 'usermerge-logpage';
$wgLogHeaders['usermerge']            = 'usermerge-logpagetext';
$wgLogActions['usermerge/mergeuser']  = 'usermerge-success-log';
$wgLogActions['usermerge/deleteuser'] = 'usermerge-userdeleted-log';
