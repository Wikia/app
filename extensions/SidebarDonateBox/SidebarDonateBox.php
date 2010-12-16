<?php
/**
 * SidebarDonateBox
 * @package SidebarDonateBox
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

if ( !defined( 'MEDIAWIKI' ) ) die( "This is an extension to the MediaWiki package and cannot be run standalone." );

$wgExtensionCredits['parserhook'][] = array (
	'name' => 'SidebarDonateBox',
	'url' => 'http://mediawiki.org/wiki/Extension:SidebarDonateBox',
	'version' => '1.1a',
	'author' => "[http://mediawiki.org/wiki/User:Dantman Daniel Friesen]",
	'description' => "Adds a custom donate box to the sidebar"
);

$wgHooks['SkinBuildSidebar'][] = 'efSidebarDonateBox';

function efSidebarDonateBox( $skin, &$bar ) {
	global $egSidebarDonateBoxContent;
	$bar['DONATE'] = $egSidebarDonateBoxContent;
	return true;
}

# Config variable holding the HTML content of the sidebar
$egSidebarDonateBoxContent = '';
