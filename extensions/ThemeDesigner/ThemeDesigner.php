<?php
/**
 * @author Daniel Friesen (http://mediawiki.org/wiki/User:Dantman) <mediawiki@danielfriesen.name>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

if( !defined( 'MEDIAWIKI' ) ) die( "This is an extension to the MediaWiki package and cannot be run standalone." );

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Theme Designer',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ThemeDesigner',
	'author' => "[http://mediawiki.org/wiki/User:Dantman Daniel Friesen] [mailto:Daniel%20Friesen%20%3Cmediawiki@danielfriesen.name%3E <mediawiki@danielfriesen.name>]",
	'descriptionmsg' => 'themedesigner-desc',
);

$dir = dirname( __FILE__ ) . '/';

// Internationlization files
$wgExtensionMessagesFiles['ThemeDesigner'] = $dir . 'ThemeDesigner.i18n.php';
$wgExtensionMessagesFiles['ThemeDesignerAlias'] = $dir . 'ThemeDesigner.alias.php';

// Special page classes
$wgAutoloadClasses['SpecialThemeDesigner'] = $dir . 'SpecialThemeDesigner.php';
$wgSpecialPages['ThemeDesigner']           = 'SpecialThemeDesigner';
$wgSpecialPageGroups['ThemeDesigner']      = 'wiki';
