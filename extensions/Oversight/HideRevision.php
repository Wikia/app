<?php

/**
 * See http://www.mediawiki.org/wiki/Extension:Oversight
 * - Add a "permanently hide this revision" link on old revision / diff view
 * - Goes to a tool to slurp revisions into an alternate archive table
 * - Add a log for this
 *
 * Copyright (C) 2006 Brion Vibber <brion@pobox.com>
 * http://www.mediawiki.org/
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

$wgAvailableRights[] = 'hiderevision';
$wgAvailableRights[] = 'oversight';

// The 'hiderevision' permission allows use of revision hiding.
$wgGroupPermissions['*']['hiderevision'] = false;
$wgGroupPermissions['oversight']['hiderevision'] = true;

// 'oversight' permission is required to view a previously-hidden revision.
$wgGroupPermissions['*']['oversight'] = false;
$wgGroupPermissions['oversight']['oversight'] = true;

// You could add a group like this:
// $wgGroupPermissions['censor']['hiderevision'] = true;
// $wgGroupPermissions['quiscustodiet']['oversight'] = true;

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Oversight',
	'author'         => 'Brion Vibber',
	'svn-date'       => '$LastChangedDate: 2008-11-29 12:00:43 +0100 (sob, 29 lis 2008) $',
	'svn-revision'   => '$LastChangedRevision: 44035 $',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Oversight',
	'description'    => 'Hide individual revisions from all users for legal reasons, etc.',
	'descriptionmsg' => 'hiderevision-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['HideRevision'] = $dir . 'HideRevision.i18n.php';
$wgExtensionAliasesFiles['HideRevision'] = $dir . 'HideRevision.alias.php';

$wgAutoloadClasses['HideRevisionForm'] = $dir . 'HideRevision_body.php';
$wgAutoloadClasses['SpecialOversight'] = $dir . 'HideRevision_body.php';
$wgAutoloadClasses['HideRevisionHooks'] = $dir . 'HideRevision.hooks.php';

$wgSpecialPages['HideRevision'] = 'HideRevisionForm';
$wgSpecialPages['Oversight'] = 'SpecialOversight';
$wgSpecialPageGroups['HideRevision'] = 'pagetools';
$wgSpecialPageGroups['Oversight'] = 'pagetools';

$wgHooks['ArticleViewHeader'][] = 'HideRevisionHooks::onArticleViewHeader';
$wgHooks['DiffViewHeader'][] = 'HideRevisionHooks::onDiffViewHeader';
$wgHooks['UndeleteShowRevision'][] = 'HideRevisionHooks::onUndeleteShowRevision';
$wgHooks['ContributionsToolLinks'][] = 'HideRevisionHooks::onContributionsToolLinks';
