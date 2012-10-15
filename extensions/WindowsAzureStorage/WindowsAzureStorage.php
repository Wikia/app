<?php
/*
 (c) Hallo Welt! Medienwerkstatt GmbH, 2011 GPL
 
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 http://www.gnu.org/copyleft/gpl.html
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	echo 'To install WindowsAzureStorage, put the following line in LocalSettings.php: include_once( "$IP/extensions/WindowsAzureStorage/WindowsAzureStorage.php" );'."\n";
	exit( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'WindowsAzureStorage',
	'author'         => array( '[http://www.hallowelt.biz Hallo Welt! Medienwerkstatt GmbH]', 'Markus Glaser', 'Robert Vogel' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:WindowsAzureStorage',
	'version'        => '1.0.0',
	'descriptionmsg' => 'windowsazurestorage-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['WindowsAzureStorage'] = $dir . 'WindowsAzureStorage.i18n.php';

$wgAutoloadClasses['WindowsAzureFileBackend'] = $dir . 'includes/filerepo/backend/WindowsAzureFileBackend.php';