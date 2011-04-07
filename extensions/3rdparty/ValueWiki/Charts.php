<?php

# Chart WikiMedia extension
# by Zach Greenberger

# Usage:
# <Chart symbol="MSFT"></Chart>
#
# To install it put this file in the extensions directory
# To activate the extension, include it from your LocalSettings.php
# with: require("extensions/YourExtensionName.php");

$wgHooks['ParserFirstCallInit'][] = "wfChart";

function wfChart( $parser ) {
    # registers the <Chart> extension with the WikiText parser
    $parser->setHook( "Chart", "renderChart" );
    return true;
}

$wgChartSettings = array(
    'time'  => '1d',
    'symbol'  => 'MSFT'
);

# The callback function for converting the input text to HTML output
function renderChart( $input, $argv ) {

	global $wgChartSettings, $chartCount, $wgExtensionsPath, $wgOut;

	# FIXME: evil, I know, but needed to lift Read-Only lock ASAP. Needs a rewrite...
	$wgOut->addHTML( "<script type='text/javascript' src='$wgExtensionsPath/3rdparty/ValueWiki/chart.js'></script>" );

	$domain = 'ichart.finance.yahoo.com';
#die( var_dump( $input ) );
	foreach (array_keys($argv) as $key) {
		$wgChartSettings[$key] = $argv[$key];
	}

	$chartCount = $chartCount + 1;

	$output = '';
	$crlf = chr(10).chr(13);

	$styles = array(
		'1d'  => 'ch_tab',
		'5d'  => 'ch_tab',
		'3m'  => 'ch_tab',
		'6m'  => 'ch_tab',
		'1y'  => 'ch_tab',
		'2y'  => 'ch_tab',
		'5y'  => 'ch_tab',
		'my'  => 'ch_tab'
	);

	if ($wgChartSettings['time'] == '0d') {
		$output .= '<img src="&#72;ttp://ichart.finance.yahoo.com/t?s=' . $wgChartSettings['symbol'] . '"><br>';
	} else {
		$styles[$wgChartSettings['time']] = 'ch_tabactive';

		$output .= '<META HTTP-EQUIV="imagetoolbar" CONTENT="no">'.$crlf;

		$output .= '<table cellpadding="0" cellspacing="0" border="0" class="ch_main" width="360">'.$crlf;
		$output .= '	<tr>'.$crlf;
		$output .= '		<td style="text-align: center;" valign="bottom">'.$crlf;
		$output .= '			<script language="javascript">'.$crlf;
		$output .= '			var gSymbol_'.$chartCount.' = "'.$wgChartSettings['symbol'].'";'.$crlf;
		$output .= '			var gDomain_'.$chartCount.' = getDomain("'.$wgChartSettings['symbol'].'");'.$crlf;
		$output .= '			document.write("<img src=\"" + getUrl('.$chartCount.') + "\" id=\"chart_'.$chartCount.'\" name=\"chart\" vspace=\"7\">")'.$crlf;
		$output .= '			</script>'.$crlf;
		$output .= '			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">'.$crlf;
		$output .= '				<tr>'.$crlf;
		$output .= '					<td id="ch_tab0_'.$chartCount.'" class="'.$styles['1d'].'" onclick="enableTab(\''.$chartCount.'\', \'0\', \'1d\');" style="border-left: 0px none;">Today</td>'.$crlf;
		$output .= '					<td id="ch_tab1_'.$chartCount.'" class="'.$styles['5d'].'" onclick="enableTab(\''.$chartCount.'\', \'1\', \'5d\');">5d</td>'.$crlf;
		$output .= '					<td id="ch_tab2_'.$chartCount.'" class="'.$styles['3m'].'" onclick="enableTab(\''.$chartCount.'\', \'2\', \'3m\');">3m</td>'.$crlf;
		$output .= '					<td id="ch_tab3_'.$chartCount.'" class="'.$styles['6m'].'" onclick="enableTab(\''.$chartCount.'\', \'3\', \'6m\');">6m</td>'.$crlf;
		$output .= '					<td id="ch_tab4_'.$chartCount.'" class="'.$styles['1y'].'" onclick="enableTab(\''.$chartCount.'\', \'4\', \'1y\');">1y</td>'.$crlf;
		$output .= '					<td id="ch_tab5_'.$chartCount.'" class="'.$styles['2y'].'" onclick="enableTab(\''.$chartCount.'\', \'5\', \'2y\');">2y</td>'.$crlf;
		$output .= '					<td id="ch_tab6_'.$chartCount.'" class="'.$styles['5y'].'" onclick="enableTab(\''.$chartCount.'\', \'6\', \'5y\');">5y</td>'.$crlf;
		$output .= '					<td id="ch_tab7_'.$chartCount.'" class="'.$styles['my'].'" onclick="enableTab(\''.$chartCount.'\', \'7\', \'my\');">Max</td>'.$crlf;
		$output .= '				</tr>'.$crlf;
		$output .= '			</table></td>'.$crlf;
		$output .= '	</tr>'.$crlf;
		$output .= '</table>'.$crlf;
	}

	return $output;
}
?>
