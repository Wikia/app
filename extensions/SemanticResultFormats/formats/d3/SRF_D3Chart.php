<?php

/**
 * A query printer for D3 charts using the D3 JavaScript library
 * and SMWAggregatablePrinter.
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
 * @file SRF_D3Chart.php
 * @ingroup SemanticResultFormats
 * @licence GNU GPL v2 or later
 *
 * @since 1.8
 *
 * @author mwjames
 */
class SRFD3Chart extends SMWAggregatablePrinter {

	/*
	 * @see SMWResultPrinter::getName
	 *
	 */
	public function getName() {
		return wfMessage( 'srf-printername-d3chart' )->text();
	}

	/**
	 * @see SMWResultPrinter::getFormatOutput
	 *
	 * @since 1.8
	 *
	 * @param array $data label => value
	 * @return string
	 */
	protected function getFormatOutput( array $data ) {

		// Object count
		static $statNr = 0;
		$d3chartID = 'd3-chart-' . ++$statNr;

		$this->isHTML = true;

		// Reorganize the raw data
		foreach ( $data as $name => $value ) {
			if ( $value >= $this->params['min'] ) {
				$dataObject[] = array( 'label' => $name , 'value' => $value );
			}
		}

		// Ensure right conversion
		$width = strstr( $this->params['width'] ,"%") ? $this->params['width'] : $this->params['width'] . 'px';

		// Prepare transfer objects
		$d3data = array (
			'data' => $dataObject,
			'parameters' => array (
				'colorscheme' => $this->params['colorscheme'] ? $this->params['colorscheme'] : null,
				'charttitle'  => $this->params['charttitle'],
				'charttext'   => $this->params['charttext'],
				'datalabels'  => $this->params['datalabels']
			)
		);

		// Encoding
		$requireHeadItem = array ( $d3chartID => FormatJson::encode( $d3data ) );
		SMWOutputs::requireHeadItem( $d3chartID, Skin::makeVariablesScript( $requireHeadItem ) );

		// RL module
		$resource = 'ext.srf.d3.chart.' . $this->params['charttype'];
		SMWOutputs::requireResource( $resource );

		// Chart/graph placeholder
		$chart = Html::rawElement( 'div', array(
			'id'    => $d3chartID,
			'class' => 'container',
			'style' => 'display:none;'
			), null
		);

		// Processing placeholder
		$processing = SRFUtils::htmlProcessingElement( $this->isHTML );

		// Beautify class selector
		$class = $this->params['charttype'] ?  '-' . $this->params['charttype'] : '';
		$class = $this->params['class'] ? $class . ' ' . $this->params['class'] : $class . ' d3-chart-common';

		// D3 wrappper
		return Html::rawElement( 'div', array(
			'class' => 'srf-d3-chart' . $class ,
			'style' => "width:{$width}; height:{$this->params['height']}px;"
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
			'default' => 'treemap',
			'values' => array( 'treemap', 'bubble' ),
		);

		$params['height'] = array(
			'type' => 'integer',
			'message' => 'srf_paramdesc_chartheight',
			'default' => 400,
			'lowerbound' => 1,
		);

		$params['width'] = array(
			'message' => 'srf_paramdesc_chartwidth',
			'default' => '100%',
		);

		$params['charttitle'] = array(
			'message' => 'srf_paramdesc_charttitle',
			'default' => '',
		);

		$params['charttext'] = array(
			'message' => 'srf-paramdesc-charttext',
			'default' => '',
		);

		$params['class'] = array(
			'message' => 'srf-paramdesc-class',
			'default' => '',
		);

		$params['datalabels'] = array(
			'message' => 'srf-paramdesc-datalabels',
			'default' => 'none',
			'values' => array( 'value', 'label' ),
		);

		$params['colorscheme'] = array(
			'message' => 'srf-paramdesc-colorscheme',
			'default' => '',
			'values' => $GLOBALS['srfgColorScheme'],
		);

		$params['chartcolor'] = array(
			'message' => 'srf-paramdesc-chartcolor',
			'default' => '',
		);

		return $params;
	}
}
