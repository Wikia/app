<?php
/**

 DPLforum v3.3.3 -- DynamicPageList-based forum extension

 Author: Ross McClure
 http://www.mediawiki.org/wiki/User:Algorithm

 DynamicPageList written by: n:en:User:IlyaHaykinson n:en:User:Amgine
 http://en.wikinews.org/wiki/User:Amgine
 http://en.wikinews.org/wiki/User:IlyaHaykinson

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
 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 http://www.gnu.org/copyleft/gpl.html

 To install, add following to LocalSettings.php
   require_once("$IP/extensions/DPLforum/DPLforum.php");

*/

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and is not a valid access point" );
	die( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'DPLforum',
	'author' => 'Ross McClure',
	'version' => '3.4.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:DPLforum',
	'descriptionmsg' => 'dplforum-desc',
);

// Hooked functions
$wgHooks['ParserFirstCallInit'][] = 'wfDPLinit';
$wgHooks['CanonicalNamespaces'][] = 'wfDPLforumCanonicalNamespaces';

// Set up i18n and autoload the main class
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['DPLforum'] = $dir . 'DPLforum.i18n.php';
$wgExtensionMessagesFiles['DPLforumMagic'] = $dir . 'DPLforum.i18n.magic.php';
$wgExtensionMessagesFiles['DPLforumNamespaces'] = $dir . 'DPLforum.namespaces.php';
$wgAutoloadClasses['DPLForum'] = $dir . 'DPLforum_body.php';

function wfDPLinit( &$parser ) {
	$parser->setHook( 'forum', 'parseForum' );
	$parser->setFunctionHook( 'forumlink', array( new DPLForum(), 'link' ) );
	return true;
}

function parseForum( $input, $argv, $parser ) {
	$f = new DPLForum();
	return $f->parse( $input, $parser );
}

/**
 * Register the canonical names for our namespace and its talkspace.
 *
 * @param $list Array: array of namespace numbers with corresponding
 *                     canonical names
 * @return Boolean: true
 */
function wfDPLforumCanonicalNamespaces( &$list ) {
	if ( !in_array( 'Forum', $list ) ) {
		$list[NS_FORUM] = 'Forum';
	}
	if ( !in_array( 'Forum_talk', $list ) ) {
		$list[NS_FORUM_TALK] = 'Forum_talk';
	}
	return true;
}
