<?php

/**
 * A query printer for pie charts using the jqPlot JavaScript library.
 *
 * @since 1.5.1
 *
 * @licence GNU GPL v3
 *
 * @author Sanyam Goyal
 * @author Yaron Koren
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SRFjqPlotPie extends SMWAggregatablePrinter {
	
	protected static $m_piechartnum = 1;
	
	protected $m_width;
	protected $m_height;
	protected $m_charttitle;

	/**
	 * (non-PHPdoc)
	 * @see SMWResultPrinter::handleParameters()
	 */
	protected function handleParameters( array $params, $outputmode ) {
		parent::handleParameters( $params, $outputmode );
		
		$this->m_width = $this->m_params['width'];
		$this->m_height = $this->m_params['height'];
		$this->m_charttitle = $this->m_params['charttitle'];
	}

	public function getName() {
		return wfMsg( 'srf_printername_jqplotpie' );
	}

	protected function loadJavascriptAndCSS() {
		global $wgOut;
		$wgOut->addModules( 'ext.srf.jqplot' );
		$wgOut->addModules( 'ext.srf.jqplotpie' );
	}

	/**
	 * Add the JS and CSS resources needed by this chart.
	 * 
	 * @since 1.7
	 */
	protected function addResources() {
		if ( self::$m_piechartnum > 1 ) {
			return;
		}

		// MW 1.17 +
		if ( class_exists( 'ResourceLoader' ) ) {
			$this->loadJavascriptAndCSS();
			return;
		}
		
		global $wgOut, $srfgScriptPath;
		global $srfgJQPlotIncluded;

		$wgOut->includeJQuery();

		if ( !$srfgJQPlotIncluded ) {
			$srfgJQPlotIncluded = true;
			$wgOut->addScript( '<!--[if IE]><script language="javascript" type="text/javascript" src="' . $srfgScriptPath . '/jqPlot/excanvas.js"></script><![endif]-->' );
			$wgOut->addScriptFile( "$srfgScriptPath/jqPlot/jquery.jqplot.js" );
		}

		$wgOut->addScriptFile( "$srfgScriptPath/jqPlot/jqplot.pieRenderer.js" );

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
		$json = array();
		
		foreach ( $data as $name => $value ) {
			$json[] = array( $name, $value );
		}
		
		$pie_data_str = '[' . FormatJson::encode( $json ) . ']';
		$pieID = 'pie' . self::$m_piechartnum;
		
		self::$m_piechartnum++;

    $chartlegend    = FormatJson::encode( $this->params['chartlegend'] );
    $legendlocation = FormatJson::encode( $this->params['legendlocation'] );
		$datalabels     = FormatJson::encode( $this->params['datalabels'] );
		$datalabeltype  = FormatJson::encode( $this->params['datalabeltype'] );

		$js_pie =<<<END
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery.jqplot.config.enablePlugins = true;
	plot1 = jQuery.jqplot('$pieID', $pie_data_str, {
		title: '$this->m_charttitle',
		seriesDefaults: {
			renderer: jQuery.jqplot.PieRenderer,
			rendererOptions: {
			  showDataLabels: $datalabels,
			  dataLabels: $datalabeltype,
				sliceMargin:2
			}
		},
			legend: { show:$chartlegend, location: $legendlocation }
	});
});
</script>
END;
		global $wgOut;
		$wgOut->addScript( $js_pie );

		$this->isHTML = true;
		
		return Html::element(
			'div',
			array(
				'id' => $pieID,
				'style' => Sanitizer::checkCss( "margin-top: 20px; margin-left: 20px; width: {$this->m_width}px; height: {$this->m_height}px;" )
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
		$params['width'] = new Parameter( 'width', Parameter::TYPE_STRING, '400' );
		$params['width']->setMessage( 'srf_paramdesc_chartwidth' );

		$params['charttitle'] = new Parameter( 'charttitle', Parameter::TYPE_STRING, ' ' );
		$params['charttitle']->setMessage( 'srf_paramdesc_charttitle' );
		
		$params['distributionlimit']->setDefault( 13 );

 		$params['chartlegend'] = new Parameter( 'chartlegend', Parameter::TYPE_BOOLEAN, true );
		$params['chartlegend']->setMessage( 'srf-paramdesc-chartlegend' );

		$params['legendlocation'] = new Parameter( 'legendlocation', Parameter::TYPE_STRING, 'ne' );
		$params['legendlocation']->setMessage( 'srf-paramdesc-legendlocation' );
		$params['legendlocation']->addCriteria( new CriterionInArray( 'nw','n', 'ne', 'e', 'se', 's', 'sw', 'w' ) );

		$params['datalabels'] = new Parameter( 'datalabels', Parameter::TYPE_BOOLEAN, false );
		$params['datalabels']->setMessage( 'srf-paramdesc-datalabels' );

		$params['datalabeltype'] = new Parameter( 'datalabeltype', Parameter::TYPE_STRING, ' ' );
		$params['datalabeltype']->setMessage( 'srf-paramdesc-datalabeltype' );
		$params['datalabeltype']->addCriteria( new CriterionInArray( 'percent','value', 'label' ) );
		
		
		return $params;
	}

}
