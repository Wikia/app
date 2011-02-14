<?php
/**
 * A query printer for pie charts using the jqPlot JavaScript library.
 *
 * @author Sanyam Goyal
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    die( 'Not an entry point.' );
}

class SRFjqPlotPie extends SMWResultPrinter {
	protected $m_width = 400;
	protected $m_height = 400;
	protected $m_charttitle = " ";
	static protected $m_piechartnum = 1;

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
	}

	public function getName() {
		return wfMsg( 'srf_printername_jqplotpie' );
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
		$wgResourceModules['ext.srf.jqplotpie'] = $resourceTemplate + array(
			'scripts' => array(
				'jqplot.pieRenderer.js',
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
		$wgOut->addModules( 'ext.srf.jqplotpie' );
	}

	protected function addJavascriptAndCSS() {
		if ( self::$m_piechartnum > 1 ) {
			return;
		}

		// MW 1.17 +
		if ( class_exists( 'ResourceLoader' ) ) {
			self::loadJavascriptAndCSS();
			return;
		}
		global $wgOut, $srfgScriptPath;
		global $smwgJQueryIncluded, $srfgJQPlotIncluded;

                if ( !$smwgJQueryIncluded ) {
			if ( method_exists( 'OutputPage', 'includeJQuery' ) ) {
				$wgOut->includeJQuery();
			} else {
				$scripts[] = "$srfgScriptPath/jqPlot/jquery-1.4.2.min.js";
			}
			$smwgJQueryIncluded = true;
		}

		if ( !$srfgJQPlotIncluded ) {
			$srfgJQPlotIncluded = true;
			$wgOut->addScript( '<!--[if IE]><script language="javascript" type="text/javascript" src="' . $srfgScriptPath . '/jqPlot/excanvas.js"></script><![endif]-->' );
			$wgOut->addScriptFile( "$srfgScriptPath/jqPlot/jquery.jqplot.js" );
		}

		$wgOut->addScriptFile( "$srfgScriptPath/jqPlot/jqplot.pieRenderer.js" );

		// CSS file
		$wgOut->addExtensionStyle( "$srfgScriptPath/jqPlot/jquery.jqplot.css" );
	}

	protected function getResultText( $res, $outputmode ) {
		global $wgOut, $wgParser;
	
		$wgParser->disableCache();

		self::addJavascriptAndCSS();

		$this->isHTML = true;

		$t = "";
		$pie_data = array();
		// print all result rows
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
						$pie_data[] .= "['$name', $nr]";
					}
				}
			}
		}
		$pie_data_str = "[[" . implode( ', ', $pie_data ) . "]]";
		$pieID = 'pie' . self::$m_piechartnum;
		self::$m_piechartnum++;

		$js_pie =<<<END
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery.jqplot.config.enablePlugins = true;
	plot1 = jQuery.jqplot('$pieID', $pie_data_str, {
		title: '$this->m_charttitle',
		seriesDefaults: {
			renderer: jQuery.jqplot.PieRenderer,
			rendererOptions: {
				sliceMargin:2
			}
		},
			legend: { show:true }
	});
});
</script>
END;
		$wgOut->addScript( $js_pie );

		$text =<<<END
<div id="$pieID" style="margin-top: 20px; margin-left: 20px; width: {$this->m_width}px; height: {$this->m_height}px;"></div>

END;
		return $text;
	}

	public function getParameters() {
		return array(
			array( 'name' => 'limit', 'type' => 'int', 'description' => wfMsg( 'smw_paramdesc_limit' ) ),
			array( 'name' => 'height', 'type' => 'int', 'description' => wfMsg( 'srf_paramdesc_chartheight' ) ),
			array( 'name' => 'charttitle', 'type' => 'string', 'description' => wfMsg( 'srf_paramdesc_charttitle' ) ),
			array( 'name' => 'width', 'type' => 'int', 'description' => wfMsg( 'srf_paramdesc_chartwidth' ) ),
		);
	}

}
