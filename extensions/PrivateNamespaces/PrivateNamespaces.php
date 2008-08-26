<?PHP
/*
 * Created on 20 July, 2007
 *
 * PrivateNamespaces extension for MediaWiki 1.9.0+
 *
 * Copyright (C) 2007 Daniel Cannon (cannon.danielc at gmail.com)
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
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */


/**
 * A really simple extension to allow for making certain namespaces
 * "private"--that is, to prevent users lacking necessary rights from
 * reading, editing, moving, etc., any page in that namespace. It 
 * should cover transclusion, searching (though the titles will still
 * be visible), diffs, Special:Export, history paging, etc.
 *
 * NOTE: MediaWiki is designed to make content _open_, not to restrict
 * access to content. As such code such as this that prevents read
 * access is generally very fragile. While it has been tested under a
 * variety of set-ups, and most methods of circumvention have been
 * addressed, it should not be fully trusted as "secure". Be especially
 * careful when installing new extensions as they may open up a variety
 * of new ways to get around what this code aims to do.
 *
 * USAGE: 
 * Add require_once("$IP/extensions/PrivateNamespaces/PrivateNamespaces.php");
 * to your LocalSetings.php.
 *
 * To restrict access to a namespace with the id '100' to a group with
 * the right "foobar" add:
 * 	$wgPrivateNamespaces[100] = 'foobar';
 *
 */

/**
 * An array mapping namespace ids to the right needed to view or edit
 * pages in the namespace.
 */
$wgPrivateNamespaces = array();

/**
 * Hook userCan to perform additional validation checks.
 */
$wgHooks['userCan'][] = 'wfCheckIfPrivate'; 

/**
 * Hook BeforeParserFetchTemplateAndtitle to perform validation checks
 * when transcluding.
 */
$wgHooks['BeforeParserFetchTemplateAndtitle'][] = 'wfCheckPrivateTransclude';

/**
 * Perform the checks. If the namespace is in $wgPrivateNamespaces
 * then the user must have the specified right in order to perform
 * any action on the page.
 */
function wfCheckIfPrivate( $title, $user, $action, &$result) { 
	global $wgPrivateNamespaces;
	if ( in_array( $title->getNamespace(), $wgPrivateNamespaces ) ) {
		if ( !$user->isAllowed( $wgPrivateNamespaces[ 
				$title->getNamespace() ] ) ) {
			$result = false;
			return false;
		}
	}

	return true;
}

/**
 * Prevent the transcluding of a page whose read access is prevented by 
 * $wgPrivateNamespaces. NOTE: It may still be possible for a user who
 * has read access to a page to transclude in a public page and for that 
 * to then be cached and made visible to other users who shouldn't have
 * access to the content. We should, however, be able to hope that those
 * with restricted access would know better than to do so, however.
 */
function wfCheckPrivateTransclude( $parser, $title, &$skip, $id ) {
	global $wgUser;
	if ( !wfCheckIfPrivate( $title, $wgUser, 'read', $empty ) )
		$skip = true;
	return true;
}
