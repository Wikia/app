<?php
/**
* A query printer for bar charts using the jqPlot JavaScript library.
 *
 * @author Sanyam Goyal
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class SRFjqPlotBar extends SMWResultPrinter {
	protected $m_width = '150';
	protected $m_height = '400';
	protected $m_charttitle = ' ';
	protected $m_barcolor = '#85802b' ;
	protected $m_bardirection = 'vertical';
	protected $m_numbersaxislabel = ' ';
	static protected $m_barchartnum = 1;

	protected function readParameters( $params, $outputmode ) {
		SMWResultPrinter::readParameters( $params, $outputmode );
		if ( array_key_exists( 'width', $this->m_params ) ) {
			$this->m_width = $this->m_params['width'];
		}
		if ( array_key_exists( 'height', $this->m_params ) ) {
			$this->m_height = $this->m_params['height'];
		}
		if ( array_key_exists( 'charttitle', $this->m_params ) ) {
		      $this->m_charttitle = $this->m_params['charttitle'];
		}
		if ( array_key_exists( 'barcolor', $this->m_params ) ) {
		      $this->m_barcolor = $this->m_params['barcolor'];
		}
		if ( array_key_exists( 'bardirection', $this->m_params ) ) {
			// keep it simple - only 'horizontal' makes sense as
			// an alternate value
			if ( $this->m_params['bardirection'] == 'horizontal' ) {
				$this->m_bardirection = $this->m_params['bardirection'];
			}
		}
		else{
		    $this->m_bardirection = 'vertical';
		}
		if ( array_key_exists( 'numbersaxislabel', $this->m_params ) ) {
		      $this->m_numbersaxislabel = $this->m_params['numbersaxislabel'];
		}
	}

	public function getName() {
		return wfMsg( 'srf_printername_jqplotbar' );
	}

	public static function registerResourceModules() {
		global $wgResourceModules, $srfgIP;

		$resourceTemplate = array(
			'localBasePath' => $srfgIP . '/jqPlot',
			'remoteExtPath' => 'SemanticResultFormats/jqPlot'
		);
		$wgResourceModules['ext.srf.jqplot'] = $resourceTemplate + array(
			'scripts' => array(
				'jquery.jqplot.js',
			),
			'styles' => array(
				'jquery.jqplot.css',
			),
			'dependencies' => array(
			),
		);
		$wgResourceModules['ext.srf.jqplotbar'] = $resourceTemplate + array(
			'scripts' => array(
				'jqplot.categoryAxisRenderer.js',
				'jqplot.barRenderer.js',
				'jqplot.canvasAxisTickRenderer.js',
				'jqplot.canvasTextRenderer.js',
				'excanvas.js',
			),
			'styles' => array(
			),
			'dependencies' => array(
				'ext.srf.jqplot',
			),
		);
	}

	protected function loadJavascriptAndCSS() {
		global $wgOut;
		$wgOut->addModules( 'ext.srf.jqplot' );
		$wgOut->addModules( 'ext.srf.jqplotbar' );
	}

	static public function addJavascriptAndCSS() {
		if ( self::$m_barchartnum > 1 ) {
			return;
		}

		// MW 1.17 +
		if ( class_exists( 'ResourceLoader' ) ) {
			self::loadJavascriptAndCSS();
			return;
		}

		global $wgOut, $smwgJQueryIncluded, $srfgJQPlotIncluded;
		global $srfgScriptPath;

		$scripts = array();
		if ( !$smwgJQueryIncluded ) {
			if ( method_exists( 'OutputPage', 'includeJQuery' ) ) {
				$wgOut->includeJQuery();
			} else {
				$scripts[] = "$srfgScriptPath/jqPlot/jquery-1.4.2.min.js";
			}
			$smwgJQueryIncluded = true;
		}

		if ( !$srfgJQPlotIncluded ) {
			$wgOut->addScript( '<!--[if IE]><script language="javascript" type="text/javascript" src="' . $srfgScriptPath . '/jqPlot/excanvas.js"></script><![endif]-->' );
			$scripts[] = "$srfgScriptPath/jqPlot/jquery.jqplot.js";
			$srfgJQPlotIncluded = true;
		}

		$scripts[] = "$srfgScriptPath/jqPlot/jqplot.categoryAxisRenderer.js";
		$scripts[] = "$srfgScriptPath/jqPlot/jqplot.barRenderer.js";
		$scripts[] = "$srfgScriptPath/jqPlot/jqplot.canvasAxisTickRenderer.js";
		$scripts[] = "$srfgScriptPath/jqPlot/jqplot.canvasTextRenderer.js";

		foreach ( $scripts as $script ) {
			$wgOut->addScriptFile( $script );
		}

		// CSS file
		$wgOut->addExtensionStyle( "$srfgScriptPath/jqPlot/jquery.jqplot.css" );
	}

	protected function getResultText( $res, $outputmode ) {
		global $wgOut, $wgParser;

		$wgParser->disableCache();

		self::addJavascriptAndCSS();

		$this->isHTML = true;

		$numbers = array();
		$labels = array();
		// print all result rows
		$count = 0;
		$max_number = 0;
		$min_number = 0;
		while ( $row = $res->getNext() ) {
			$name = $row[0]->getNextObject()->getShortWikiText();
			$name = str_replace( "'", "\'", $name );
			foreach ( $row as $field ) {
					while ( ( $object = $field->getNextObject() ) !== false ) {
					if ( $object->isNumeric() ) { // use numeric sortkey
						if ( method_exists( $object, 'getValueKey' ) ) {
							$nr = $object->getValueKey();
						} else {
							$nr = $object->getNumericValue();
						}
						$count++;
						if ( $nr > $max_number ) {
							$max_number = $nr;
						}
						if ( $nr < $min_number ) {
							$min_number = $nr;
						}

						if ( $this->m_bardirection == 'horizontal' ) {
							$numbers[] = "[$nr, $count]";
						} else {
							$numbers[] = "$nr";
						}
						$labels[] = "'$name'";
					}
				}
			}
		}
		$barID = 'bar' . self::$m_barchartnum;
		self::$m_barchartnum++;
		
		$labels_str = implode( ', ', $labels );
		$numbers_str = implode( ', ', $numbers );
		$labels_axis ="xaxis";
		$numbers_axis = "yaxis";
		$angle_val = -40;
		$barmargin = 6;
		if ( $this->m_bardirection == 'horizontal' ) {
			$labels_axis ="yaxis";
			$numbers_axis ="xaxis";
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
		if ( $max_number == 0 && $min_number == 0 ) {
			return null;
		}
		// Make the max and min slightly larger and bigger than the
		// actual max and min, so that the bars don't directly touch
		// the top and bottom of the graph
		if ( $max_number > 0 ) { $max_number += .001; }
		if ( $min_number < 0 ) { $min_number -= .001; }
		if ( $max_number == 0 ) {
			$multipleOf10 = 0;
			$maxAxis = 0;
		} else {
			$multipleOf10 = pow( 10, floor( log( $max_number, 10 ) ) );
			$maxAxis = ceil( $max_number / $multipleOf10 ) * $multipleOf10;
		}
		if ( $min_number == 0 ) {
			$negativeMultipleOf10 = 0;
			$minAxis = 0;
		} else {
			$negativeMultipleOf10 = -1 * pow( 10, floor( log( -1 * $min_number, 10 ) ) );
			$minAxis = ceil( $min_number / $negativeMultipleOf10 ) * $negativeMultipleOf10;
		}
		$numbers_ticks = '';
		$biggerMultipleOf10 = max( $multipleOf10, -1 * $negativeMultipleOf10 );
		$lowestTick = floor( $minAxis / $biggerMultipleOf10 + .001 );
		$highestTick = ceil( $maxAxis / $biggerMultipleOf10 - .001 );
		for ( $i = $lowestTick; $i <= $highestTick; $i++ ) {
			$numbers_ticks .= ($i * $biggerMultipleOf10) . ", ";
		}

		$js_bar =<<<END
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery.jqplot.config.enablePlugins = true;
	plot1 = jQuery.jqplot('$barID', [[$numbers_str]], {
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
			}
		}],
		axes: {
			$labels_axis: {
				renderer: jQuery.jqplot.CategoryAxisRenderer,
				ticks: [$labels_str],
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
		$text =<<<END
<div id="$barID" style="margin-top: 20px; margin-left: 20px; width: {$this->m_width}px; height: {$this->m_height}px;"></div>

END;
		return $text;
	}

	public function getParameters() {
		return array(
			array( 'name' => 'limit', 'type' => 'int', 'description' => wfMsg( 'smw_paramdesc_limit' ) ),
			array( 'name' => 'height', 'type' => 'int', 'description' => wfMsg( 'srf_paramdesc_chartheight' ) ),
			array( 'name' => 'charttitle', 'type' => 'string', 'description' => wfMsg( 'srf_paramdesc_charttitle' ) ),
			array( 'name' => 'barcolor', 'type' => 'string', 'description' => wfMsg( 'srf_paramdesc_barcolor' ) ),
			array( 'name' => 'bardirection', 'type' => 'enumeration', 'description' => wfMsg( 'srf_paramdesc_bardirection' ),'values' => array('horizontal', 'vertical')),
			array( 'name' => 'numbersaxislabel', 'type' => 'string', 'description' => wfMsg( 'srf_paramdesc_barnumbersaxislabel' ) ),
			array( 'name' => 'width', 'type' => 'int', 'description' => wfMsg( 'srf_paramdesc_chartwidth' ) ),
		);
	}
}
