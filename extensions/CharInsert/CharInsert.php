<?php
# Copyright (C) 2004,2006 Brion Vibber <brion@pobox.com>
# http://www.mediawiki.org/
# 
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or 
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
# http://www.gnu.org/copyleft/gpl.html

/**
 * Extension to create new character inserts which can be used on
 * the edit page to make it easy to get at special characters and
 * such forth.
 *
 * @file
 * @author Brion Vibber <brion at pobox.com>
 * @ingroup Extensions
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die();
}

$wgHooks['ParserFirstCallInit'][] = 'setupSpecialChars';

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'CharInsert',
	'author' => 'Brion Vibber',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CharInsert',
	'descriptionmsg' => 'charinsert-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['CharInsert'] = $dir . 'CharInsert.i18n.php';

function setupSpecialChars( &$parser ) {
	$parser->setHook( 'charinsert', 'charInsert' );
	return true;
}

function charInsert( $data ) {
	return implode( "<br />\n",
		array_map( 'charInsertLine',
			explode( "\n", trim( $data ) ) ) );
}

function charInsertLine( $data ) {
	return implode( "\n",
		array_map( 'charInsertItem',
			preg_split( '/\\s+/', charInsertArmor( $data ) ) ) );
}

function charInsertArmor( $data ) {
	return preg_replace_callback(
		'!<nowiki>(.*?)</nowiki>!i',
		'charInsertNowiki',
		$data );
}

function charInsertNowiki( $matches ) {
	return str_replace(
		array( '\t', '\r', ' ' ),
		array( '&#9;', '&#12;', '&#32;' ),
		$matches[1] );
}

function charInsertItem( $data ) {
	$chars = explode( '+', $data );
	if( count( $chars ) > 1 && $chars[0] !== '' ) {
		return charInsertChar( $chars[0], $chars[1], 'Click the character while selecting a text' );
	} elseif( count( $chars ) == 1 ) {
		return charInsertChar( $chars[0] );
	} else {
		return charInsertChar( '+' );
	}
}

function charInsertChar( $start, $end = '', $title = null ) {
	$estart = charInsertJsString( $start );
	$eend   = charInsertJsString( $end   );
	if( $eend == '' ) {
		$inline = charInsertDisplay( $start );
	} else {
		$inline = charInsertDisplay( $start . $end );
	}
	return Xml::element( 'a',
		array(
			'onclick' => "insertTags('$estart','$eend','');return false",
			'href'    => '#' ),
		$inline );
}

function charInsertJsString( $text ) {
	return strtr(
		charInsertDisplay( $text ),
		array(
			"\\"   => "\\\\",
			"\""   => "\\\"",
			"'"    => "\\'",
			"\r\n" => "\\n",
			"\r"   => "\\n",
			"\n"   => "\\n",
		) );
}

function charInsertDisplay( $text ) {
	static $invisibles = array(     '&nbsp;',     '&#160;' );
	static $visibles   = array( '&amp;nbsp;', '&amp;#160;' );
	return Sanitizer::decodeCharReferences(
			str_replace( $invisibles, $visibles, $text ) );
}


