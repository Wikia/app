<?php
/**
 * @author automattic http://wordpress.org/extend/themes/profile/automattic
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
 * 
 * To install place the p2wiki folder into skins/ and add this line to your LocalSettings.php
 * require_once("$IP/skins/p2wiki/p2wiki.php");
 */

if( !defined( 'MEDIAWIKI' ) ) die( "This is an extension to the MediaWiki package and cannot be run standalone." );

$wgExtensionCredits['skin'][] = array (
	'path' => __FILE__,
	'name' => 'P2 wiki',
	'author' => array('[http://automattic.com/ Automattic]', '[http://mediawiki.org/wiki/User:Dantman Daniel Friesen]'),
	'description' => "P2 wiki, a wiki skin based on the [http://p2theme.com/ P2] WordPress theme.",
);

$skinID = basename(dirname(__FILE__));
$wgValidSkinNames[$skinID] = 'P2wiki';
$wgAutoloadClasses['SkinP2wiki'] = dirname(__FILE__).'/P2wiki.skin.php';
$wgExtensionMessagesFiles['SkinP2wiki'] = dirname(__FILE__).'/P2wiki.i18n.php';
$wgResourceModules["skins.$skinID"] = array(
	'styles' => array( "skins/$skinID/style/screen.css" => array( 'media' => 'screen' ) )
);

