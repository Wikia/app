<?php
/**
 * CodeTest
 *
 * @file
 * @ingroup CodeTest
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

class CodeTest {

	static function ParserAfterStrip( &$parser, &$text, &$stripState ) {
		$match = array();
		$text = $parser->extractTagsAndParams( array( 'codetest' ), $text, $match, $parser->uniqPrefix() );
		foreach ( $match as $uniq => $data ) {
			list( $tag, $content, $params, $original ) = $data;
			if ( $tag != 'codetest' ) {
				# This sometimes happends with comments, but in the case of
				# anything unforseen, just spit the original back out
				$text = str_replace( $uniq, $original, $text );
				continue;
			}

			$codeData = array_map( 'trim', explode( "\n", trim( $content ) ) );
			$expected = array();
			if ( isset( $params['sep'] ) )
				foreach ( $codeData as &$code )
					list( $code, $expected[] ) = explode( $params['sep'], $code, 2 );
			switch( $params['mode'] ) {
				case 'table':
					$content = self::tableModeReplace( $codeData, $expected );
					break;
			}

			$text = str_replace( $uniq, $content, $text );
		}
		return true;
	}

	static function tableModeReplace( $codeData, $expected = array() ) {
		$expecting = count( $codeData ) == count( $expected );
		$table = "\n{|\n";
		$table .= "|-\n";
		$table .= "!| Code\n";
		$table .= "!| Result\n";
		if ( $expecting ) $table .= "!| Expecting\n";
		foreach ( $codeData as $n => $code ) {
			$table .= "|-\n";
			$table .= "||\n<nowiki>" . htmlspecialchars( $code ) . "</nowiki>\n";
			$table .= "||\n{$code}\n";
			if ( $expecting ) $table .= "||\n{$expected[$n]}\n";
		}
		$table .= "|}\n";
		return $table;
	}
}
