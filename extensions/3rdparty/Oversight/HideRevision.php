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
	'name'           => 'Oversight',
	'author'         => 'Brion Vibber',
	'version' => preg_replace('/^.* (\d\d\d\d-\d\d-\d\d) .*$/', '\1', '$LastChangedDate: 2008-03-25 21:27:56 +0000 (Tue, 25 Mar 2008) $'), #just the date of the last change
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Oversight',
	'description'    => 'Hide individual revisions from all users for legal reasons, etc.',
	'descriptionmsg' => 'hiderevision-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['HideRevision'] = $dir . 'HideRevision.i18n.php';

$wgAutoloadClasses['HideRevisionForm'] = $dir . 'HideRevision_body.php';
$wgAutoloadClasses['SpecialOversight'] = $dir . 'HideRevision_body.php';

$wgSpecialPages['HideRevision'] = 'HideRevisionForm';
$wgSpecialPageGroups['HideRevision'] = 'pagetools';
$wgSpecialPages['Oversight'] = 'SpecialOversight';
$wgSpecialPageGroups['Oversight'] = 'pagetools';

$wgHooks['ArticleViewHeader'][] = 'hrArticleViewHeaderHook';
$wgHooks['DiffViewHeader'][] = 'hrDiffViewHeaderHook';
$wgHooks['UndeleteShowRevision'][] = 'hrUndeleteShowRevisionHook';
$wgHooks['UserRename::Local'][] = 'hrUserRenameLocalHook';

/**
 * Hook for article view, giving us a chance to insert a removal
 * tab on old version views.
 */
function hrArticleViewHeaderHook( $article ) {
	$oldid = intval( $article->mOldId );
	if( $oldid ) {
		hrInstallTab( $oldid );
	}
	return true;
}

/**
 * Hook for diff view, giving us a chance to insert a removal
 * tab on old version views.
 *
 * @param $diff
 * @param $oldRev
 * @param Revision $newRev
 */
function hrDiffViewHeaderHook( $diff, $oldRev, $newRev ) {
	if( !empty( $newRev ) && $newRev->getId() ) {
		hrInstallTab( $newRev->getId() );
	}
	return true;
}

/**
 * Hook for deletion archive revision view, giving us a chance to
 * insert a removal tab for a deleted revision.
 *
 * @param $title
 * @param Revision $rev
 */
function hrUndeleteShowRevisionHook( $title, $rev ) {
	hrInstallArchiveTab( $title, $rev->getTimestamp() );
	return true;
}

/**
 * Register tables that need to be updated when a user is renamed
 *
 * @param DatabaseBase $dbw
 * @param int $userId
 * @param string $oldUsername
 * @param string $newUsername
 * @param UserRenameProcess $process
 * @param int $wgCityId
 * @param array $tasks
 * @return bool
 */
function hrUserRenameLocalHook( $dbw, $userId, $oldUsername, $newUsername, $process, $wgCityId, array &$tasks ) {
	$tasks[] = array(
		'table' => 'hidden',
		'userid_column' => 'hidden_user',
		'username_column' => 'hidden_user_text',
	);

	return true;
}

class HideRevisionTabInstaller {
	function __construct( $linkParam ) {
		$this->mLinkParam = $linkParam;
	}

	function insertTab( $skin, &$content_actions ) {
		$special = Title::makeTitle( NS_SPECIAL, 'HideRevision' );
		$content_actions['hiderevision'] = array(
			'class' => false,
			'text' => wfMsgHTML( 'hiderevision-tab' ),
			'href' => $special->getLocalUrl( $this->mLinkParam ) );
		return true;
	}
}

/**
 * If the user is allowed, installs a tab hook on the skin
 * which links to a handy permanent removal thingy.
 */
function hrInstallTab( $id ) {
	global $wgUser;
	if( $wgUser->isAllowed( 'hiderevision' ) ) {
		global $wgHooks;
		$tab = new HideRevisionTabInstaller( 'revision[]=' . $id );
		$wgHooks['SkinTemplateTabs'][] = array( $tab, 'insertTab' );
	}
}

/**
 * If the user is allowed, installs a tab hook on the skin
 * which links to a handy permanent removal thingy for
 * archived (deleted) pages.
 *
 * @param Title $target
 */
function hrInstallArchiveTab( $target, $timestamp ) {
	global $wgUser;
	if( $wgUser->isAllowed( 'hiderevision' ) ) {
		global $wgHooks;
		$tab = new HideRevisionTabInstaller(
			'target=' . $target->getPrefixedUrl() .
			'&timestamp[]=' . $timestamp );
		$wgHooks['SkinTemplateBuildContentActionUrlsAfterSpecialPage'][] =
			array( $tab, 'insertTab' );
	}
}
