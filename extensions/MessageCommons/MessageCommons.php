<?php
/**
 * MessageCommons
 * @ingroup Extensions
 * @author Daniel Friesen (http://mediawiki.org/wiki/User:Dantman) <mediawiki@danielfriesen.name>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @note Some techniques borrowed from Wikia's SharedMessages system
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

$wgExtensionFunctions[] = 'efMessageCommonsSetup';
$wgHooks['MessagesPreLoad'][] = 'efMessageCommonsPreload';
$wgExtensionCredits['other'][] = array (
	'name' => 'MessageCommons',
	'url' => 'http://mediawiki.org/wiki/Extension:MessageCommons',
	'version' => '1.0a',
	'author' => "[http://mediawiki.org/wiki/User:Dantman Daniel Friesen] [mailto:Daniel%20Friesen%20%3Cmediawiki@danielfriesen.name%3E <mediawiki@danielfriesen.name>]",
	'description' => "Allows mediawiki messages to be shared from a central database"
);

function efMessageCommonsSetup() {
	global $wgDBprefix, $wgSharedDB, $wgSharedPrefix, $wgSharedUploadDBname, $wgSharedUploadDBprefix;
	global $egMessageCommonsDatabase, $egMessageCommonsPrefix;
	
	if( !isset($egMessageCommonsDatabase) ) {
		if( !isset($wgSharedUploadDBname) ) {
			$egMessageCommonsDatabase = $wgSharedUploadDBname;
			$egMessageCommonsPrefix   = $wgSharedUploadDBprefix;
		} elseif( !isset($wgSharedDB) ) {
			$egMessageCommonsDatabase = $wgSharedDB;
			if( isset($wgSharedPrefix) ) {
				$egMessageCommonsPrefix = $wgSharedPrefix;
			}
		}
	}
	if( !isset($egMessageCommonsPrefix) ) {
		$egMessageCommonsPrefix = $wgDBprefix;
	}
}

function efMessageCommonsPreload( $title, &$message ) {
	global $wgContLang, $wgLang, $egMessageCommonsIsCommons;
	if( $egMessageCommonsIsCommons ) return true;
	
	$text = null;
	
	$msgNames[] = $msgName = $title;
	if( strpos( $msgName, '/' ) === false ) {
		$msgNames[] = sprintf( '%s/%s', $msgName, $wgContLang->getCode() );
		$msgNames[] = sprintf( '%s/%s', $msgName, $wgLang->getCode() );
	}
	$msgNames = array_reverse(array_unique($msgNames));
	
	foreach( $msgNames as $msgName ) {
		$text = efMessageCommonsGetMsg( $msgName );
		if( isset($text) ) break;
	}
	
	if( isset($text) ) {
		$message = $text;
		return false;
	}
	return true;
}

function efMessageCommonsGetMsg( $msg ) {
	global $egMessageCommonsDatabase, $egMessageCommonsPrefix ;
	$title = Title::makeTitle(NS_MEDIAWIKI, $msg );
	$dbr = wfGetDB( DB_SLAVE );
	$row = $dbr->selectRow( array(
		"`{$egMessageCommonsDatabase}`.`{$egMessageCommonsPrefix}page`",
		"`{$egMessageCommonsDatabase}`.`{$egMessageCommonsPrefix}revision`",
		"`{$egMessageCommonsDatabase}`.`{$egMessageCommonsPrefix}text`"
	), array('*'), array(
		'page_namespace' => $title->getNamespace(),
		'page_title' => $title->getDBkey(),
		'page_latest = rev_id',
		'old_id = rev_text_id'
	) );
	if( !$row ) return null;
	return Revision::getRevisionText($row);
}

/** MessageCommons configuration **/
$egMessageCommonsIsCommons = false;
$egMessageCommonsLang      = 'en';
$egMessageCommonsDatabase  = null;
$egMessageCommonsPrefix    = null;
