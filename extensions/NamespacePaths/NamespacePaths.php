<?php
/**
 * Copyright 2010 Daniel Friesen
 *
 * @file
 * @ingroup Extensions
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

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'NamespacePaths',
	'version' => '1.0',
	'author' => array( '[http://mediawiki.org/wiki/User:Dantman Daniel Friesen]', '[http://redwerks.org/mediawiki/ Redwerks]' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:NamespacePaths',
	'descriptionmsg' => 'namespacepaths-desc',
);

$wgExtensionMessagesFiles['NamespacePaths'] = dirname( __FILE__ ) . '/NamespacePaths.i18n.php';

$wgHooks['WebRequestPathInfoRouter'][] = 'efNamepacePathRouter';
$wgHooks['GetLocalURL::Article'][] = 'efNamepacePathsGetURL';

function efNamepacePathRouter( $router ) {
	global $wgNamespacePaths;
	$router->add( $wgNamespacePaths,
		array( 'data:page_title' => '$1', 'data:ns' => '$key' ),
		array( 'callback' => 'efNamespacePathCallback' )
	);
	return true;
}

function efNamespacePathCallback( &$matches, $data ) {
	$nstext = MWNamespace::getCanonicalName( intval( $data['ns'] ) );
	$matches['title'] = $nstext . ':' . $data['page_title'];
}

function efNamepacePathsGetURL( $title, &$url ) {
	global $wgNamespacePaths;
	// Ensure that the context of this url is one we'd do article path replacements in
	$ns = $title->getNamespace();
	if ( array_key_exists( $ns, $wgNamespacePaths ) ) {
		$url = str_replace( '$1', wfUrlencode( $title->getDBkey() ), $wgNamespacePaths[$ns] );
	}
	return true;
}

/** Settings **/
$wgNamespacePaths = array();

