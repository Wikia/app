<?php

/**
 * Common libray of independent functions that are shared among different printers
 *
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
 *
 * @file
 * @ingroup SemanticResultFormats
 * @licence GNU GPL v2 or later
 *
 * @since 1.8
 *
 * @author mwjames
 */
final class SRFUtils {

	/**
	 * Helper function that generates a html element, representing a
	 * processing/loading image as long as jquery is inactive
	 *
	 * @param boolean $isHtml
	 *
	 * @since 1.8
	 */
	public static function htmlProcessingElement( $isHtml = true ) {
		SMWOutputs::requireResource( 'ext.srf' );

		return Html::rawElement(
			'div',
			array( 'class' => 'srf-spinner mw-small-spinner' ),
			Html::element(
				'span',
				array( 'class' => 'srf-processing-text' ),
				wfMessage( 'srf-module-loading' )->inContentLanguage()->text()
			)
		);
	}

	/**
	 * Add JavaScript variables to the output
	 *
	 * @since 1.8
	 */
	public static function addGlobalJSVariables(){
		$options = array (
			'srfgScriptPath' => $GLOBALS['srfgScriptPath'],
			'srfVersion' => SRF_VERSION
		);

		$requireHeadItem = array ( 'srf.options' => $options );
		SMWOutputs::requireHeadItem( 'srf.options', Skin::makeVariablesScript( $requireHeadItem ) );
	}

	/**
	 * @brief Returns semantic search link for the current query
	 *
	 * Generate a link to access the current ask query
	 *
	 * @since 1.8
	 *
	 * @param string $link
	 *
	 * @return $link
	 */
	public static function htmlQueryResultLink( $link ) {
		// Get linker instance
		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker : new Linker;

		// Set caption
		$link->setCaption( '[+]' );

		// Set parameters
		$link->setParameter( '' , 'class' );
		$link->setParameter( '' , 'searchlabel' );
		return $link->getText( SMW_OUTPUT_HTML, $linker );
	}

}