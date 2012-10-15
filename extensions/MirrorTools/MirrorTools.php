<?php
/**
 * MirrorTools extension by Tisane
 * URL: http://www.mediawiki.org/wiki/Extension:MirrorTools
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
 
/* Alert the user that this is not a valid entry point to MediaWiki if they try to access the
special pages file directly.*/
 
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
		To install the MirrorTools extension, put the following line in LocalSettings.php:
		require( "extensions/MirrorTools/MirrorTools.php" );
EOT;
	exit( 1 );
}
 
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'MirrorTools',
	'author' => 'Tisane',
	'url' => 'https://www.mediawiki.org/wiki/Extension:MirrorTools',
	'descriptionmsg' => 'mirrortools-desc',
	'version' => '1.0.0',
);
 
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['ApiMirrorEditPage'] = $dir . 'APIMirrorTools.php';
$wgAutoloadClasses['MirrorEditPage'] = $dir . 'MirrorTools.classes.php';
$wgAPIModules['mirroredit'] = 'ApiMirrorEditPage';

// Path to internationalization file
$wgExtensionMessagesFiles['MirrorTools'] = $dir . 'MirrorTools.i18n.php';

// New user rights
$wgAvailableRights[] = 'mirroredit';
$wgGroupPermissions['MirrorTools']['mirroredit'] = true;