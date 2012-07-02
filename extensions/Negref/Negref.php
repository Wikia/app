<?php
/**
 * Negref
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

$wgExtensionCredits['parserhook'][] = array (
	"path" => __FILE__,
	"name" => "Negref",
	"author" => "[http://mediawiki.org/wiki/User:Dantman Daniel Friesen]",
	"description-msg" => 'negref-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Negref',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['NegRef'] = $dir . 'Negref.i18n.php';
$wgExtensionMessagesFiles['NegRefMagic'] = $dir . 'Negref.i18n.magic.php';
$wgHooks['ParserFirstCallInit'][] = 'efNegrefRegisterParser';

function efNegrefRegisterParser( &$parser ) {
	$parser->setFunctionHook( 'negref', 'efNegrefHook' );
	return true;
}

function efNegrefHook( $parser, $input, $replaceData='', $replaceRef='', $pattern='' ) {
	$data = $input;
	$ref = '';

	$keys = array_keys( $parser->mStripState->general->getArray() );
	foreach ( $keys as $key ) {
		if ( preg_match( '/^' . preg_quote( $parser->uniqPrefix(), '/' ) . '-(ref)-.*$/', $key ) ) {
			if ( substr_count( $input, $key ) > 0 ) {
				$data = str_replace( $key, '', $data );
				$ref .= $key;
			}
		}
	}

	return str_replace( $replaceRef, $ref, str_replace( $replaceData, $data, $pattern ) );
}
