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

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Oversight',
	'author'         => 'Brion Vibber',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Oversight',
	'descriptionmsg' => 'hiderevision-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['HideRevision'] = $dir . 'HideRevision.i18n.php';
$wgExtensionMessagesFiles['HideRevisionAlias'] = $dir . 'HideRevision.alias.php';

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
