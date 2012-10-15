<?php

/**
 * A query printer for bar charts using the jqPlot JavaScript library.
 *
 * @since 1.5.1
 *
 * @licence GNU GPL v3
 *
 * @author Sanyam Goyal
 * @author Yaron Koren
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SRFjqPlotBar extends SMWAggregatablePrinter {
	
	protected static $m_barchartnum = 1;
	
	protected $m_charttitle;
	protected $m_barcolor;
	protected $m_bardirection;
	protected $m_numbersaxislabel;

	/**
	 * (non-PHPdoc)
	 * @see SMWResultPrinter::handleParameters()
	 */
	protected function handleParameters( array $params, $outputmode ) {
		parent::handleParameters( $params, $outputmode );
		
		$this->m_charttitle = $this->m_params['charttitle'];
		$this->m_barcolor = $this->m_params['barcolor'];
		$this->m_bardirection = $this->m_params['bardirection'];
		$this->m_numbersaxislabel = $this->m_params['numbersaxislabel'];
	}

	public function getName() {
		return wfMsg( 'srf_printername_jqplotbar' );
	}

	protected function loadJavascriptAndCSS() {
		global $wgOut;
		$wgOut->addModules( 'ext.srf.jqplotbar' );
		
		if ( $this->params['pointlabels'] ) {
			$wgOut->addModules( 'ext.srf.jqplotpointlabels' );
		}
	}

	/**
	 * Add the JS and CSS resources needed by this chart.
	 * 
	 * @since 1.7
	 */
	protected function addResources() {
		if ( self::$m_barchartnum > 1 ) {
			return;
		}

		// MW 1.17 +
		if ( class_exists( 'ResourceLoader' ) ) {
			$this->loadJavascriptAndCSS();
			return;
		}

		global $wgOut, $srfgJQPlotIncluded;
		global $srfgScriptPath;

		$scripts = array();
		$wgOut->includeJQuery();

		if ( !$srfgJQPlotIncluded ) {
			$wgOut->addScript( '<!--[if IE]><script language="javascript" type="text/javascript" src="' . $srfgScriptPath . '/jqPlot/excanvas.js"></script><![endif]-->' );
			$scripts[] = "$srfgScriptPath/jqPlot/jquery.jqplot.js";
			$srfgJQPlotIncluded = true;
		}

		$scripts[] = "$srfgScriptPath/jqPlot/jqplot.categoryAxisRenderer.js";
		$scripts[] = "$srfgScriptPath/jqPlot/jqplot.barRenderer.js";
		$scripts[] = "$srfgScriptPath/jqPlot/jqplot.canvasAxisTickRenderer.js";
		$scripts[] = "$srfgScriptPath/jqPlot/jqplot.canvasTextRenderer.js";

		if ( $this->params['pointlabels'] ) {
			$scripts[] = "$srfgScriptPath/jqPlot/jqplot.pointLabels.min.js";
		}
		
		foreach ( $scripts as $script ) {
			$wgOut->addScriptFile( $script );
		}

		// CSS file
		$wgOut->addExtensionStyle( "$srfgScriptPath/jqPlot/jquery.jqplot.css" );
	}

	/**
	 * Get the JS and HTML that needs to be added to the output to create the chart.
	 * 
	 * @since 1.7
	 * 
	 * @param array $data label => value
	 */
	protected function getFormatOutput( array $data ) {
		global $wgOut;

		$this->isHTML = true;

		$maxValue = count( $data ) == 0 ? 0 : max( $data );
		
		if ( $this->params['min'] === false ) {
			$minValue = count( $data ) == 0 ? 0 : min( $data );
		}
		else {
			$minValue = $this->params['min'];
		}
		
		foreach ( $data as $i => &$nr ) {
			if ( $this->m_bardirection == 'horizontal' ) {
				$nr = array( $nr, $i );
			}
		}
		
		$barID = 'bar' . self::$m_barchartnum;
		self::$m_barchartnum++;
		
		$labels_str = FormatJson::encode( array_keys( $data ) );
		$numbers_str = FormatJson::encode( array_values( $data ) );
		
		$labels_axis = 'xaxis';
		$numbers_axis = 'yaxis';
		
		$angle_val = -40;
		$barmargin = 6;
		
		if ( $this->m_bardirection == 'horizontal' ) {
			$labels_axis = 'yaxis';
			$numbers_axis = 'xaxis';
			$angle_val = 0;
			$barmargin = 8 ;
		}
		
		$barwidth = 20; // width of each bar
		$bardistance = 4; // distance between two bars

		// Calculate the tick values for the numbers, based on the
		// lowest and highest number. jqPlot has its own option for
		// calculating ticks automatically - "autoscale" - but it
		// currently (September 2010) fails for numbers less than 1,
		// and negative numbers.
		// If both max and min are 0, just escape now.
		if ( $maxValue == 0 && $minValue == 0 ) {
			return null;
		}
		// Make the max and min slightly larger and bigger than the
		// actual max and min, so that the bars don't directly touch
		// the top and bottom of the graph
		if ( $maxValue > 0 ) { $maxValue += .001; }
		if ( $minValue < 0 ) { $minValue -= .001; }
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
			$negativeMultipleOf10 = -1 * pow( 10, floor( log( $minValue, 10 ) ) );
			$minAxis = ceil( $minValue / $negativeMultipleOf10 ) * $negativeMultipleOf10;
		}
		
		$numbers_ticks = '';
		$biggerMultipleOf10 = max( $multipleOf10, -1 * $negativeMultipleOf10 );
		$lowestTick = floor( $minAxis / $biggerMultipleOf10 + .001 );
		$highestTick = ceil( $maxAxis / $biggerMultipleOf10 - .001 );
		
		for ( $i = $lowestTick; $i <= $highestTick; $i++ ) {
			$numbers_ticks .= ($i * $biggerMultipleOf10) . ', ';
		}

		$pointlabels = FormatJson::encode( $this->params['pointlabels'] );
		
		$js_bar =<<<END
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery.jqplot.config.enablePlugins = true;
	plot1 = jQuery.jqplot('$barID', [{$numbers_str}], {
		title: '{$this->m_charttitle}',
		seriesColors: ['$this->m_barcolor'],
		seriesDefaults: {
			fillToZero: true
		},
		series: [  {
			renderer: jQuery.jqplot.BarRenderer, rendererOptions: {
				barDirection: '{$this->m_bardirection}',
				barPadding: 6,
				barMargin: $barmargin
			},
			pointLabels: {show: $pointlabels}
		}],
		axes: {
			$labels_axis: {
				renderer: jQuery.jqplot.CategoryAxisRenderer,
				ticks: {$labels_str},
				tickRenderer: jQuery.jqplot.CanvasAxisTickRenderer,
				tickOptions: {
					angle: $angle_val
				}
			},
			$numbers_axis: {
				ticks: [$numbers_ticks],
				label: '{$this->m_numbersaxislabel}'
			}
		}
	});
});
</script>
END;
		$wgOut->addScript( $js_bar );
		
		$width = $this->params['width'];
		$height = $this->params['height'];
		
		return Html::element(
			'div',
			array(
				'id' => $barID,
				'style' => Sanitizer::checkCss( "margin-top: 20px; margin-left: 20px; width: {$width}px; height: {$height}px;" )
			)
		);
	}

	/**
	 * @see SMWResultPrinter::getParameters
	 */
	public function getParameters() {
		$params = parent::getParameters();
		
		$params['height'] = new Parameter( 'height', Parameter::TYPE_INTEGER, 400 );
		$params['height']->setMessage( 'srf_paramdesc_chartheight' );
		
		// TODO: this is a string to allow for %, but better handling would be nice
		$params['width'] = new Parameter( 'width', Parameter::TYPE_STRING, '100%' );
		$params['width']->setMessage( 'srf_paramdesc_chartwidth' );
		
		$params['charttitle'] = new Parameter( 'charttitle', Parameter::TYPE_STRING, ' ' );
		$params['charttitle']->setMessage( 'srf_paramdesc_charttitle' );
		
		$params['barcolor'] = new Parameter( 'barcolor', Parameter::TYPE_STRING, '#85802b' );
		$params['barcolor']->setMessage( 'srf_paramdesc_barcolor' );
		
		$params['bardirection'] = new Parameter( 'bardirection', Parameter::TYPE_STRING, 'vertical' );
		$params['bardirection']->setMessage( 'srf_paramdesc_bardirection' );
		$params['bardirection']->addCriteria( new CriterionInArray( 'horizontal', 'vertical' ) );
		
		$params['numbersaxislabel'] = new Parameter( 'numbersaxislabel', Parameter::TYPE_STRING, ' ' );
		$params['numbersaxislabel']->setMessage( 'srf_paramdesc_barnumbersaxislabel' );
		
		$params['min'] = new Parameter( 'min', Parameter::TYPE_INTEGER );
		$params['min']->setMessage( 'srf-paramdesc-minvalue' );
		$params['min']->setDefault( false, false );
		
		$params['pointlabels'] = new Parameter( 'pointlabels', Parameter::TYPE_BOOLEAN, false );
		$params['pointlabels']->setMessage( 'srf-paramdesc-pointlabels' );
		
		return $params;
	}
	
}
