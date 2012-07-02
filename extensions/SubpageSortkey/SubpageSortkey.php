<?php
/**
 * Really simple extension to change the default sortkey to have something
 * to do with the subpages. See bug 22911. Requires at least MediaWiki 1.18
 *
 *  This program is free software; you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License as published by the Free
 *  Software Foundation; either version 2 of the License, or (at your option)
 *  any later version.
 *
 *  This program is distributed in the hope that it will be useful, but WITHOUT
 *  ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 *  FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 *  more details.
 *
 *  You should have received a copy of the GNU General Public License along with
 *  this program; if not, write to the Free Software Foundation, Inc., 59 Temple
 *  Place - Suite 330, Boston, MA 02111-1307, USA.
 *  http://www.gnu.org/copyleft/gpl.html
 *
 * @addtogroup Extensions
 *
 * @author Brian Wolff
 * @copyright Copyright © 2011 Brian Wolff
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Subpage Sortkey',
	'author' => array( '[http://mediawiki.org/wiki/User:Bawolff Brian Wolff]' ),
	'descriptionmsg' => 'subpagesortkey-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SubpageSortkey',
	'version' => 0.1,
);

// Syntax is as follows:
// * A positive number n represents the nth subpage section
// * A negative number -i represents the ith subpage section counting backwards
// * A range a..b represents all sections a to b inclusive
// * Ranges can be open.
// Examples:
// "0" would be just the base page name (a/b/c/d -> a).
// "0..2" would be the first 3 sections (a/b/c/d -> a/b/c)
// "0,2" would be a/b/c/d -> a/c
// "1.." would be a/b/c/d -> b/c/d
// "0,-2" would be a/b/c/d -> a/c

// The default sortkey subpage descriptor (aka "1,2,3..6" )
$wgSubpageSortkeyDefault = false;
// Per namespace sortkeys (array, each key is a namespace number)
// For example $wgSubpageSortkeyByNamespace[NS_TALK] = '1..';
$wgSubpageSortkeyByNamespace = array();
// If the subpage descriptor is empty, use the normal page name?
$wgSubpageSortkeyIfNoSubpageUseFullName = true;

$wgHooks['GetDefaultSortkey'][] = 'SubpageSortkey::onGetDefaultSortkey';
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['SubpageSortkey'] = $dir . 'SubpageSortkey_body.php';
$wgExtensionMessagesFiles['SubpageSortkey'] = $dir . 'SubpageSortkey.i18n.php';

