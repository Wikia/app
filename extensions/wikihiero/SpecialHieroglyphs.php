<?php

/**
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

class SpecialHieroglyphs extends SpecialPage {
	const HIEROGLYPHS_PER_ROW = 10;
	const CACHE_EXPIRY = 86400; // 1 day

	private $hiero;
	private $syntaxHelp = array(
		array( 'code' => '-', 'message' => 'wikihiero-separator', 'example' => 'A1 - B1' ),
		array( 'code' => ':', 'message' => 'wikihiero-superposition', 'example' => 'p:t' ),
		array( 'code' => '*', 'message' => 'wikihiero-juxtaposition', 'example' => 'p*t' ),
		array( 'code' => '!', 'message' => 'wikihiero-eol', 'example' => 'A1-B1 ! C1-D1' ),
		array( 'code' => '\\', 'message' => 'wikihiero-mirror', 'example' => 'A1\-A1' ),
		array( 'code' => '..', 'message' => 'wikihiero-void', 'example' => 'A1 .. B1' ),
		array( 'code' => '.', 'message' => 'wikihiero-half-void', 'example' => 'A1 . B1' ),
		array( 'code' => '<!-- -->', 'message' => 'wikihiero-comment', 'example' => 'A<!-- B1 -->1' ),
	);
	private $helpColumns = array(
		'code',
		'meaning',
		'example',
		'result',
	);

	public function __construct() {
		parent::__construct( 'Hieroglyphs' );
	}

	public function execute( $par ) {
		$this->setHeaders();
		$out = $this->getContext()->getOutput();
		$out->addModules( 'ext.wikihiero.Special' );
		$out->addModuleStyles( 'ext.wikihiero.Special' ); // apply CSS during slow load
		$out->addWikiMsg( 'wikihiero-special-page-text' );

		$out->addHTML( '<div id="hiero-result">' );

		$text = trim( $this->getContext()->getRequest()->getVal( 'text', '' ) );
		if ( $text !== '' ) {
			$hiero = new WikiHiero();
			$out->addHTML( '<table class="wikitable">'
				. '<tr><th>' . wfMsg( 'wikihiero-input' ) . '</th><th>'
				. wfMsg( 'wikihiero-result' ) . '</th></tr>'
				. '<tr><td><code>&lt;hiero&gt;' . nl2br( htmlspecialchars( $text ) )
				. "&lt;/hiero&gt;</code></td><td>{$hiero->render( $text )}</td></tr></table>"
			);
		}

		$out->addHTML( '</div>' ); // id="hiero-result"

		$out->addHTML(
			Html::openElement( 'form',
				array(
					'method' => 'get',
					'action' => $this->getTitle()->getLinkUrl(),
				)
			)
			. Html::element( 'textarea', array( 'id' => 'hiero-text', 'name' => 'text' ), $text )
			. Html::element( 'input', array(
				'type' => 'submit',
				'id' => 'hiero-submit',
				'name' => 'submit',
			) )
			. Html::closeElement( 'form' )
		);

		$this->hiero = new WikiHiero();

		$out->addHTML( '<table><tr><td>' );
		$out->addHTML( '<div class="mw-hiero-list">' );
		$out->addHTML( $this->listHieroglyphs() );
		$out->addHTML( '</div></td><td>' );
		$out->addHTML( $this->getToc() );
		$out->addHTML( '</td></tr></table>' );
	}

	/**
	 * Returns a HTML list of hieroglyphs
	 */
	private function listHieroglyphs() {
		global $wgMemc;

		$key = wfMemcKey( 'hiero-list',
			$this->getContext()->getLang()->getExtraHashOptions(),
			WikiHiero::getImagePath(),
			WIKIHIERO_VERSION
		);
		$html = $wgMemc->get( $key );
		if ( $html ) {
			return $html;
		}
		$html = '';

		$html .= $this->getHeading( 'wikihiero-syntax', 'syntax' );
		$html .= '<table class="wikitable"><tr>';
		foreach ( $this->helpColumns as $col ) {
			$html .= '<th>' . wfMessage( "wikihiero-th-$col" )->escaped() . '</th>';
		}
		$html .= '</tr>';
		foreach ( $this->syntaxHelp as $e ) {
			$html .= $this->getSyntaxHelp( $e['code'], $e['message'], $e['example'] );
		}
		$html .= "</table>\n";

		$files = array_keys( $this->hiero->getFiles() );
		natsort( $files );

		foreach ( $this->getCategories() as $cat ) {
			$alnum = strlen( $cat ) == 1;
			$html .= $this->getHeading( "wikihiero-category-$cat", "cat-$cat" );
			$html .= "<table class=\"wikitable\">\n";
			$upperRow = $lowerRow = '';
			$columns = 0;
			$rows = 0;
			foreach ( $files as $code ) {
				if ( strpos( $code, '&' ) !== false ) {
					continue; // prefab
				}
				if ( strpos( $code, $cat ) !== 0 || ( $alnum && !ctype_digit( $code[1] ) ) ) {
					continue; // wrong category
				}
				$upperRow .= '<td>' . $this->hiero->render( $code ) . '</td>';
				$lowerRow .= '<th>' . htmlspecialchars( $code ) . '</th>';
				$columns++;
				if ( $columns == self::HIEROGLYPHS_PER_ROW ) {
					$html .= "<tr>$upperRow</tr>\n<tr>$lowerRow</tr>\n";
					$upperRow = $lowerRow = '';
					$columns = 0;
					$rows++;
				}
			}
			if ( $columns ) {
				$html .= "<tr>$upperRow"
					. ( $columns && $rows ? '<td colspan="' . ( self::HIEROGLYPHS_PER_ROW - $columns ) . '">&#160;</td>' : '' ) . "</tr>\n";
				$html .= "<tr>$lowerRow"
					. ( $columns && $rows ? '<th colspan="' . ( self::HIEROGLYPHS_PER_ROW - $columns ) . '">&#160;</th>' : '' ) . "</tr>\n";
			}
			$html .= "</table>\n";
		}
		$wgMemc->set( $key, $html, self::CACHE_EXPIRY );
		return $html;
	}

	private function getToc() {
		$html = '<table class="toc mw-hiero-toc">';

		$syntax = wfMessage( 'wikihiero-syntax' )->text();
		$html .= '<tr><td colspan="5">'
				. Html::element( 'a',
					array( 'href' => "#syntax", 'title' => $syntax ),
					$syntax
				)
				. '</td></tr>';
		$count = 0;
		$cats = $this->getCategories();
		$end = array_pop( $cats );
		foreach ( $cats as $cat ) {
			if ( $count % 5 == 0 ) {
				$html .= '<tr>';
			}
			$html .= '<td>'
				. Html::element( 'a',
					array( 'href' => "#cat-$cat", 'title' => wfMessage( "wikihiero-category-$cat" )->text() ),
					$cat
				)
				. '</td>';
			$count++;
			if ( $count % 5 == 0 ) {
				$html .= '</tr>';
			}
		}
		$html .= '<tr><td colspan="5">'
				. Html::element( 'a',
					array( 'href' => "#cat-$end", 'title' => wfMessage( "wikihiero-category-$end" )->text() ),
					$end
				)
				. '</td></tr></table>';
		return $html;
	}

	/**
	 * Returns an array with hieroglyph categories from Gardiner's list
	 */
	private function getCategories() {
		$res = array();
		for ( $i = ord( 'A' ); $i <= ord( 'Z' ); $i++ ) {
			if ( $i != ord( 'J' ) ) {
				$res[] = chr( $i );
			}
		}
		$res[] = 'Aa';
		return $res;
	}

	private function getHeading( $message, $anchor ) {
		return "<h2 id=\"$anchor\">" . wfMessage( $message )->escaped() . "</h2>\n";
	}

	private function getSyntaxHelp( $code, $message, $example ) {
		return '<tr><th>' . htmlspecialchars( $code ) . '</th><td>'
			. wfMessage( $message )->escaped() . '</td><td>'
			. '<code>' . htmlspecialchars( "<hiero>$example</hiero>" ) . '</code></td><td>'
			. $this->hiero->render( $example )
			. "</td></tr>\n";
	}
 }