<?php

/**
 * Abstract class to hold common functionality for the jqPlot result printers.
 *
 * @since 1.8
 *
 * @file
 * @ingroup SemanticResultFormats
 *
 * @licence GNU GPL v2+
 * @author mwjames
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Yaron Koren
 * @author Sanyam Goyal
 */
abstract class SRFjqPlot extends SMWAggregatablePrinter {

	public static function getCommonParams() {

		$params = array();

		$params['min'] = array(
			'type' => 'integer',
			'message' => 'srf-paramdesc-minvalue',
			'default' => false,
			'manipulatedefault' => false,
		);

		$params['direction'] = array(
			'message' => 'srf-paramdesc-direction',
			'default' => 'vertical',
			'values' => array( 'horizontal', 'vertical'),
		);

		$params['charttitle'] = array(
			'message' => 'srf_paramdesc_charttitle',
			'default' => '',
		);

		$params['charttext'] = array(
			'message' => 'srf-paramdesc-charttext',
			'default' => '',
		);

		$params['numbersaxislabel'] = array(
			'message' => 'srf_paramdesc_barnumbersaxislabel',
			'default' => '',
		);

		$params['labelaxislabel'] = array(
			'message' => 'srf-paramdesc-labelaxislabel',
			'default' => '',
		);

		$params['height'] = array(
			'type' => 'integer',
			'message' => 'srf_paramdesc_chartheight',
			'default' => 400,
			'lowerbound' => 1,
		);

		// TODO: this is a string to allow for %, but better handling would be nice
		$params['width'] = array(
			'message' => 'srf_paramdesc_chartwidth',
			'default' => '100%',
		);

		$params['smoothlines'] = array(
			'type' => 'boolean',
			'message' => 'srf-paramdesc-smoothlines',
			'default' => false,
		);

		// %.2f round number to 2 digits after decimal point e.g.  EUR %.2f, $ %.2f
		// %d a signed integer, in decimal
		$params['valueformat'] = array(
			'message' => 'srf-paramdesc-valueformat',
			'default' => '%d',
		);

		$params['ticklabels'] = array(
			'type' => 'boolean',
			'message' => 'srf-paramdesc-ticklabels',
			'default' => true,
		);

		$params['highlighter'] = array(
			'type' => 'boolean',
			'message' => 'srf-paramdesc-highlighter',
			'default' => false,
		);

		$params['theme'] = array(
			'message' => 'srf-paramdesc-theme',
			'default' => '',
			'values' => array( '', 'vector', 'simple' ),
		);

		$params['filling'] = array(
			'type' => 'boolean',
			'message' => 'srf-paramdesc-filling',
			'default' => true,
		);

		$params['chartlegend'] = array(
			'message' => 'srf-paramdesc-chartlegend',
			'default' => 'none',
			'values' => array( 'none', 'nw','n', 'ne', 'e', 'se', 's', 'sw', 'w' ),
		);

		$params['datalabels'] = array(
			'message' => 'srf-paramdesc-datalabels',
			'default' => 'none',
			'values' => array(  'none', 'value', 'label', 'percent' ),
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

		$params['class'] = array(
			'message' => 'srf-paramdesc-class',
			'default' => '',
		);

		return $params;
	}

	/**
	 * Prepare jqplot specific numbers ticks
	 *
	 * @since 1.8
	 *
	 * @param array $data
	 * @param $minValue
	 * @param $maxValue
	 *
	 * @return array
	 */
	public static function getNumbersTicks( $minValue, $maxValue ){
		$numbersticks = array();

		// Calculate the tick values for the numbers, based on the
		// lowest and highest number. jqPlot has its own option for
		// calculating ticks automatically - "autoscale" - but it
		// currently (September 2010, it also fails with the jpPlot 1.00b 2012)
		// fails for numbers less than 1, and negative numbers.
		// If both max and min are 0, just escape now.
		if ( $maxValue == 0 && $minValue == 0 ) {
			return null;
		}

		// Make the max and min slightly larger and bigger than the
		// actual max and min, so that the bars don't directly touch
		// the top and bottom of the graph
		if ( $maxValue > 0 ) {
			$maxValue += .001;
		}

		if ( $minValue < 0 ) { 
			$minValue -= .001; 
		}

		if ( $maxValue == 0 ) {
			$multipleOf10 = 0;
			$maxAxis = 0;
		} else {
			$multipleOf10 = pow( 10, floor( log( $maxValue, 10 ) ) );
			$maxAxis = ceil( $maxValue / $multipleOf10 ) * $multipleOf10;
		}

		if ( $minValue == 0 ) {
			$negativeMultipleOf10 = 0;
			$minAxis = 0;
		} else {
			$negativeMultipleOf10 = -1 * pow( 10, floor( log( ( abs( $minValue ) ), 10 ) ) );
			$minAxis = ceil( $minValue / $negativeMultipleOf10 ) * $negativeMultipleOf10;
		}

		$biggerMultipleOf10 = max( $multipleOf10, -1 * $negativeMultipleOf10 );
		$lowestTick = floor( $minAxis / $biggerMultipleOf10 + .001 );
		$highestTick = ceil( $maxAxis / $biggerMultipleOf10 - .001 );

		for ( $i = $lowestTick; $i <= $highestTick; $i++ ) {
			$numbersticks[] = ($i * $biggerMultipleOf10) ;
		}

		return $numbersticks;
	}
}