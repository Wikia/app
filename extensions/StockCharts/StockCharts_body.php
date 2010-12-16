<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

/**
 * Class for rendering stock charts via an extension function or parser function.
 */
class StockCharts {

	static $defaultWidth  = 300;
	static $defaultHeight = 250;
	static $minWidth      = 170;
	static $minHeight     = 170;

	public static function renderTagExtension( $source, $args = array(), $parser = null ) {
		list( $ticker, $width, $height, $chartTitle, $range, $extraArgs ) =
			self::getParams( $args );

		return self::renderStockChart( $ticker, $width, $height, $chartTitle, $range, $extraArgs );
	}

	public static function renderParserFunction( &$parser ) {
		$args = self::parseArgs( func_get_args() );

		list( $ticker, $width, $height, $chartTitle, $range, $extraArgs ) =
			self::getParams( $args );

		$output = self::renderStockChart( $ticker, $width, $height, $chartTitle, $range, $extraArgs );
		// render html code inline
		return $parser->insertStripItem( $output, $parser->mStripState );
	}

	/**
	 * Generate unique id to assign to divs, so we can render multiple charts on same page
	 */
	protected static function getUniqueStockChartID() {
		static $idx = 0;
		return $idx++;
	}

	/**
	 * Parse ParserFunction args list and return
	 * a key => value map of parameters
	 */
	protected static function parseArgs( $args ) {

		// knock off the magic word
		array_shift( $args );

		$result = array();
		foreach ( $args as $index => $param ) {
			$parts = explode( '=', $param, 2 );
			if ( count( $parts ) < 2 ) {
				continue;
			}

			$key = $parts[0];
			$value = $parts[1];

			// strip leading/trailing quotes
			if ( preg_match( '/^("|\')(.*)(\1)$/s', $value, $matches ) ) {
				$value = $matches[2];
			}

			$result[$key] = $value;
		}
		return $result;
	}

	/**
	 * Parameters.
	 * ticker - stock ticker
	 * width  - width of chart
	 * height - height of chart
	 * title  - custom title for chart
	 * range  - range / zoom of chart. Possible values:
	 *          '1 day', '5 days', '1 month', '3 months', '6 months', '1 year', '2 years', 5 years', '10 years', 'full'
	 *
	 * Returns extra params that we'll pass through to the chart. This way we can support new simple parameters
	 * without requiring a new release of the extension.
	 */
	protected static function getParams( $params ) {

		$ticker = @$params['ticker'];
		$width  = @$params['width'];
		$height = @$params['height'];
		$title  = @$params['title'];
		$range  = @$params['range'];

		// return any extra params not defined here, so we can pass through
		unset( $params['ticker'] );
		unset( $params['width'] );
		unset( $params['height'] );
		unset( $params['title'] );
		unset( $params['range'] );
		$extraParams = $params;

		return array( $ticker, $width, $height, $title, $range, $extraParams );
	}

	protected static function validateParams( &$ticker, &$width, &$height, &$chartTitle, $range, &$error ) {

		// ticker is a required param
		if ( !$ticker ) {
			wfLoadExtensionMessages( 'StockCharts' );
			$error = '<span style="color: red; font-weight: bold;">' . wfMsg( 'stockcharts-missingticker' ) . '</span>';
			return false;
		}

		// set default values
		if ( !$width || !is_numeric( $width ) || $width < self::$minWidth ) {
			$width = self::$defaultWidth;
		}

		if ( !$height || !is_numeric( $height ) || $height < self::$minHeight ) {
			$height = self::$defaultHeight;
		}

		return true;
	}

	/**
	 * Renders a stock chart.
	 * @param $args Assoc array of input params
	 * @return html to render
	 */
	protected static function renderStockChart( $ticker, $width = 0, $height = 0, $chartTitle = '', $range = '', $extraArgs = array() ) {
		global $wgSitename;

		$success = self::validateParams( $ticker, $width, $height, $chartTitle, $range, $error );
		if ( !$success ) {
			return $error;
		}

		// generate a unique container id so swf objects are dropped in the right divs
		$chartId = self::getUniqueStockChartID();

		// if there is a specified chart title, set up the optional tickerAlias param
		$tickerAlias = '';
		if ( $chartTitle ) {
			$tickerAlias = ',"tickerAlias":"' . urlencode( $chartTitle ) . '"';
		}

		// we'll pass through any extra args
		$extra = '';
		if ( count( $extraArgs ) > 0 ) {
			foreach ( $extraArgs as $key => $value ) {
				$extra .= ',"' . urlencode( $key ) . '":"' . urlencode( $value ) . '"';
			}
		}

		$embedCode = '<script src="http://charts.wikinvest.com/wikinvest/wikichart/javascript/scripts.php?partner=' . urlencode( $wgSitename ) . '&chartType=mwExtension" type="text/javascript"></script>' .
			'<div id="wikichartContainer_' . $chartId . '">' .
			'<div id="wikichartContainer_' . $chartId . '_noFlash" style="width: $WIDTHpx; display:none;">' .
			'<a href="http://get.adobe.com/flashplayer/">' .
			'<img src="http://cdn.wikinvest.com/wikinvest/images/adobe_flash_logo.gif" alt="Flash" style="border-width: 0px;"/><br />' .
			'Flash Player 9 or higher is required to view the chart<br /><strong>Click here to download Flash Player now</strong>' .
			'</a>' .
			'</div>' .
			'</div>' .
			'<script type="text/javascript">' .
			'if (typeof(embedWikichart)!= "undefined") {' .
			'embedWikichart("http://charts.wikinvest.com/WikiChartMiniWikipedia.swf","wikichartContainer_' . $chartId . '","$WIDTH","$HEIGHT",{"ticker":"$TICKER","rollingDate":"$RANGE","showAnnotations":"true","liveQuote":"true"' . $tickerAlias . $extra . '});}' .
			'</script>';

		// replace args
		$embedCode = str_replace( '$TICKER', $ticker, $embedCode );
		$embedCode = str_replace( '$WIDTH',  $width,  $embedCode );
		$embedCode = str_replace( '$HEIGHT', $height, $embedCode );
		$embedCode = str_replace( '$RANGE',  $range,  $embedCode );

		return $embedCode;
	}
}
