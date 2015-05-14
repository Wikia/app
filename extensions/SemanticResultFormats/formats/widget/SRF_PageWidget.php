<?php

/**
 * Extends the SMWEmbeddedResultPrinter with a JavaScript carousel widget
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
 * @since 1.8
 *
 * @author mwjames
 *
 * @ingroup SemanticResultFormats
 * @file
 */
class SRFPageWidget extends SMWEmbeddedResultPrinter {

	/**
	 * Get a human readable label for this printer.
	 *
	 * @return string
	 */
	public function getName() {
		return wfMessage( 'srf-printername-pagewidget' )->text();
	}

	/**
	 * @see SMWResultPrinter::getResultText
	 *
	 * @param SMWQueryResult $res
	 * @param $outputMode
	 *
	 * @return string
	 */
	protected function getResultText( SMWQueryResult $res, $outputMode ) {

		// Initialize
		static $statNr = 0;

		// Get results from SMWListResultPrinter
		$result = parent::getResultText( $res, $outputMode );

		// Count widgets
		$widgetID = 'pagewidget-' . ++$statNr;

		// Container items
		$result = Html::rawElement( 'div', array(
			'id' => $widgetID,
			'class' => 'container',
			'data-embedonly' => $this->params['embedonly'],
			'style' => 'display:none;'
			), $result
		);

		// Placeholder
		$processing = SRFUtils::htmlProcessingElement( $this->isHTML );

		// RL module
		SMWOutputs::requireResource( 'ext.srf.pagewidget.carousel' );

		// Beautify class selector
		$class = $this->params['class'] ? ' ' . $this->params['class'] : '';

		// Wrap results
		return Html::rawElement( 'div', array(
			'class' => 'srf-pagewidget' . $class,
			) , $processing . $result
		);
	}

	/**
	 * @see SMWResultPrinter::getParamDefinitions
	 *
	 * @since 1.8
	 *
	 * @param $definitions array of IParamDefinition
	 *
	 * @return array of IParamDefinition|array
	 */
	public function getParamDefinitions( array $definitions ) {
		$params = parent::getParamDefinitions( $definitions );

		$params['embedformat'] = array(
			'message' => 'smw-paramdesc-embedformat',
			'default' => 'ul',
			'values' => array( 'ul' ),
		);

		$params['class'] = array(
			'message' => 'srf-paramdesc-class',
			'default' => '',
		);

		$params['widget'] = array(
			'message' => 'srf-paramdesc-widget',
			'default' => 'carousel',
			'values' =>  array( 'carousel' ),
		);

		return $params;
	}
}