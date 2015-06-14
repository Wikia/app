<?php

/**
 * A query printer for sparklines (small inline charts) using the sparkline
 * JavaScript library.
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
 * @file
 * @ingroup SemanticResultFormats
 * @licence GNU GPL v2 or later
 *
 * @author mwjames
 */
class SRFSparkline extends SMWAggregatablePrinter {

	/**
	 * Corresponding message name
	 *
	 */
	public function getName() {
		return wfMessage( 'srf-printername-sparkline' )->text();
	}

	/**
	 * Prepare data output
	 *
	 * @since 1.8
	 *
	 * @param array $data label => value
	 */
	protected function getFormatOutput( array $data ) {

		//Init
		$dataObject = array();

		static $statNr = 0;
		$chartID = 'sparkline-' . $this->params['charttype'] . '-' . ++$statNr;

		$this->isHTML = true;

		// Prepare data array
		foreach ( $data as $key => $value ) {
			if ( $value >= $this->params['min'] ) {
				$dataObject['label'][] = $key;
				$dataObject['value'][] = $value;
			}
		}

		$dataObject['charttype'] = $this->params['charttype'];

		// Encode data objects
		$requireHeadItem = array ( $chartID => FormatJson::encode( $dataObject ) );
		SMWOutputs::requireHeadItem( $chartID, Skin::makeVariablesScript($requireHeadItem ) );

		// RL module
		SMWOutputs::requireResource( 'ext.srf.sparkline' );

		// Processing placeholder
		$processing = SRFUtils::htmlProcessingElement( false );

		// Chart/graph placeholder
		$chart = Html::rawElement( 'div', array(
			'id'    => $chartID,
			'class' => 'container',
			'style' => "display:none;"
			), null
		);

		// Beautify class selector
		$class = $this->params['class'] ? ' ' . $this->params['class'] : '';

		// Chart/graph wrappper
		return Html::rawElement( 'span', array(
			'class' => 'srf-sparkline' . $class,
			), $processing . $chart
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

		$params['min'] = array(
			'type' => 'integer',
			'message' => 'srf-paramdesc-minvalue',
			'default' => false,
			'manipulatedefault' => false,
		);

		$params['charttype'] = array(
			'message' => 'srf-paramdesc-charttype',
			'default' => 'bar',
			'values' => array ( 'bar', 'line', 'pie', 'discrete' )
		);

		$params['class'] = array(
			'message' => 'srf-paramdesc-class',
			'default' => '',
		);

		return $params;
	}
}