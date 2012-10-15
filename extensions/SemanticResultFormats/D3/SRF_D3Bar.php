<?php

/**
 * 
 *
 * @since 1.7
 *
 * @licence GNU GPL v3
 * @author James Hong Kong
 */
class SRFD3Bar extends SMWAggregatablePrinter {
	
	protected static $m_barchartnum = 1;
	
	public function getName() {
		return wfMsg( 'srf_printername_D3Bar' );
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

		global $wgOut;
		$wgOut->addModules( 'ext.srf.d3core' );
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
		
		$barID = 'bar' . self::$m_barchartnum;
		self::$m_barchartnum++;
		
		$labels_str = FormatJson::encode( array_keys( $data ) );
		$numbers_str = FormatJson::encode( array_values( $data ) );
		
		$labels_axis = 'xaxis';
		$numbers_axis = 'yaxis';
		
		$angle_val = -40;
		$barmargin = 6;
		
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

#		$pointlabels = FormatJson::encode( $this->params['pointlabels'] );

		$width = $this->params['width'];
		$height = $this->params['height'];
		$charttitle = $this->patams['charttitle'];
		
		$js_bar =<<<END
<script type="text/javascript">
$(document).ready(function() {
//Examples based on http://www.verisi.com/resources/d3-tutorial-basic-charts.htm
//Alternating to form a single series. Bar Color will switch back & forth 
//var data = d3.range(10).map(Math.random);
var data = {$numbers_str};
var colorlist = ["steelblue", "lightblue"];
var labellist = ($labels_str);
 
var w = $width,
    h = $height - 20 ,
    labelpad = $width / 3,
    barwidth = 20,
    x = d3.scale.linear().domain([0, 100]).range([0, w]),
    y = d3.scale.ordinal().domain(d3.range(data.length)).rangeBands([0, h], .2);
 
var vis = d3.select("#$barID")
    .append("svg:svg")
    .attr("width", $width - $barwidth  )
    .attr("height", h + 20)
    .append("svg:g")
    .attr("transform", "translate(20,0)")
    .attr("class", "chart");    
 
var bars = vis.selectAll("g.bar")
    .data(data)
    .enter().append("svg:g")
    .attr("class", "bar")
    .attr("transform", function(d, i) { return "translate(" + labelpad + "," + y(i) + ")"; });

bars.append("svg:rect")
    .attr("fill", function(d, i) { return colorlist[i % 2]; } )   //Alternate colors
    .attr("width", x )
    .attr("height", y.rangeBand())
    .text(function(d) { return d; });
 
bars.append("svg:text")
    .attr("x", 0)
    .attr("y", -2 + y.rangeBand() / 2)
    .attr("dx", -16)
    .attr("dy", ".55em")
    .attr("class", "barlabel")
    .attr("text-anchor", "end")
    .text(function(d, i) { return labellist[i]; });

//Generate labels for each bar
var labels = vis.selectAll("g.bar")
    .append("svg:text")
    .attr("class", "barvalue")
    .attr("x", 3)
//    .attr("x", function(d) { return x(d) + 2; })    
    .attr("y", -5 + y.rangeBand() / 2 + 10 )
    .attr("text-anchor", "right")
    .attr("transform", function(d) { return "translate(" + x(d) + ", 0)"; })
    .style("width", function(d) { return d * 10 + "px"; })   
    .text(function(d) {  return d; });
     
//END Generate labels for each bar 
 
var rules = vis.selectAll("g.rule")
    .data(x.ticks(10))
    .enter().append("svg:g")
    .attr("class", "rule")
    .attr("transform", function(d) { return "translate(" + x(d) + ", 0)"; });
 
// ---------------------------------------
// Add Title, then Legend
// ---------------------------------------
vis.append("svg:text")
   .attr("x", 0)
   .attr("y", 25    )
   .attr("class", "chartitle")
   .text('{$charttitle}'); 
 
rules.append("svg:line")
    .attr("y1", h)
    .attr("y2", h + 6)
    .attr("x1", labelpad)
    .attr("x2", labelpad)
    .attr("stroke", "black");
 
rules.append("svg:line")
    .attr("y1", 0)
    .attr("y2", h)
    .attr("x1", labelpad)
    .attr("x2", labelpad)
    .attr("stroke", "white")
    .attr("stroke-opacity", .3);
 
rules.append("svg:text")
    .attr("y", h + 2 )
    .attr("x", labelpad)
    .attr("dy", ".71em")
    .attr("text-anchor", "middle")
    .text(x.tickFormat(10));

});
</script>
END;
		$wgOut->addScript( $js_bar );
				
		return Html::element(
			'div',
			array(
				'id' => $barID,
				'style' => Sanitizer::checkCss( "margin-top: 20px; margin-left: 20px; margin-right: 20px; width: {$width}px; height: {$height}px;" )
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
		
		$params['min'] = new Parameter( 'min', Parameter::TYPE_INTEGER );
		$params['min']->setMessage( 'srf-paramdesc-minvalue' );
		$params['min']->setDefault( false, false );
		
		return $params;
	}
	
}
