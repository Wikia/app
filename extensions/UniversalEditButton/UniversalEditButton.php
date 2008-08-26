<?php

/**
 * Adds a hidden <link> to the edit page into the HTML page headers
 * to support the Universal Edit Button extension for Firefox.
 *
 * That extension detects the presence of the link and adds a clickable
 * edit button into the URL bar -- in a consistent place, with a consistent
 * icon for any wiki that supports it.
 *
 * For more background information, see: http://universaleditbutton.org/
 *
 *
 * Copyright (C) 2008 Brion Vibber.
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

$wgExtensionCredits['other'][] = array(
	'name'           => 'UniversalEditButton',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:UniversalEditButton',
	'svn-date'       => '$LastChangedDate: 2008-07-09 12:41:27 +0000 (Wed, 09 Jul 2008) $',
	'svn-revision'   => '$LastChangedRevision: 37386 $',
	'description'    => 'Adds HTML header <code>&lt;link&gt;</code> to support Universal Edit Button browser extension.',
	'descriptionmsg' => 'universaleditbutton-desc',
	'author'         => array( 'Brion Vibber', 'Danny B.' ),
);

$wgHooks['BeforePageDisplay'][] = 'efUniversalEditLink';
$wgExtensionMessagesFiles['UniversalEditButton'] = dirname(__FILE__) . '/UniversalEditButton.i18n.php';

function efUniversalEditLink( $output ) {
	global $wgArticle, $wgTitle, $wgUser;
	if( isset( $wgArticle ) &&
		isset( $wgTitle ) &&
		($wgTitle->quickUserCan( 'edit' )
			&& ( $wgTitle->exists()
				|| $wgTitle->quickUserCan( 'create' ) ) ) ) {
		$output->addLink(
			array(
				'rel' => 'alternate',
				'type' => 'application/x-wiki',
				'title' => wfMsg( 'edit' ),
				'href' => $wgTitle->getFullURL( 'action=edit' ) ) );
	}
	return true;
}
