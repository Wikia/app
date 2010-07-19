<?php

class FundJS extends UnlistedSpecialPage {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct( 'FundJS' /*class*/ );
        }

	function execute( $par ) {

		global $wgOut;

                $this->setHeaders();

                // output only template content
                $wgOut->setArticleBodyOnly(true);

$flag = "sl1d1t1c1ohgvj1pp2wern";
$class = "fundimentals";
$cols = 2;
$symbol = "";
$width = '380';
$output = "";

if (isset($_REQUEST['symbol'])) {
	$symbol = $_REQUEST['symbol'];
}
if (isset($_REQUEST['flag'])) {
	$flag = $_REQUEST['flag'];
}
if (isset($_REQUEST['class'])) {
	$class = $_REQUEST['class'];
}
if (isset($_REQUEST['cols'])) {
	$cols = $_REQUEST['cols'];
}
if (isset($_REQUEST['width'])) {
	$width = $_REQUEST['width'];
}
$flags = array (
	'a' => 'Ask',
	'a2' => 'Ave Volume', 
	'a5' => 'Ask Size', 
	'b' => 'Bid', 
	'b2' => 'Ask (Real-time)', 
	'b3' => 'Bid (Real-time)', 
	'b4' => 'Book Value', 
	'b6' => 'Bid Size', 
	'c' => 'Change (%)', 
	'c1' => 'Change', 
	'c3' => 'Commission', 
	'c6' => 'Change (Real-time)', 
	'c8' => 'After Hours Change (Real-time)', 
	'd' => 'Div/Share', 
	'd1' => 'Last Trade Date', 
	'd2' => 'Trade Date', 
	'e' => 'EPS', 
	'e1' => 'Error Indication (returned for symbol changed / invalid)', 
	'e7' => 'EPS Est', 
	'e8' => 'EPS Est Next Year', 
	'e9' => 'EPS Est Next Quarter', 
	'f6' => 'Float Shares', 
	'g' => 'Day\'s Low', 
	'h' => 'Day\'s High', 
	'j' => 'Year Low', 
	'k' => 'Year High', 
	'g1' => 'Holdings Gain Percent', 
	'g3' => 'Annualized Gain', 
	'g4' => 'Holdings Gain', 
	'g5' => 'Holdings Gain Percent (Real-time)', 
	'g6' => 'Holdings Gain (Real-time)', 
	'i' => 'More Info', 
	'i5' => 'Order Book (Real-time)', 
	'j1' => 'Market Cap', 
	'j3' => 'Market Cap (Real-time)', 
	'j4' => 'EBITDA', 
	'j5' => '% From Year Low', 
	'j6' => '% Change From Year Low', 
	'k1' => 'Last Trade (Real-time) With Time', 
	'k2' => 'Change % (Real-time)', 
	'k3' => 'Last Trade Size', 
	'k4' => 'Change From Year High', 
	'k5' => '% Change From Year High', 
	'l' => 'Last Trade', 
	'l1' => 'Last Trade', 
	'l2' => 'High Limit', 
	'l3' => 'Low Limit', 
	'm' => 'Day\'s Range', 
	'm2' => 'Day\'s Range (Real-time)', 
	'm3' => '50-day Moving Ave', 
	'm4' => '200-day Moving Ave', 
	'm5' => 'Change From 200-day Moving Ave', 
	'm6' => '% Change From 200-day Moving Ave', 
	'm7' => 'Change From 50-day Moving Ave', 
	'm8' => '% Change From 50-day Ave', 
	'n' => 'Name', 
	'n4' => 'Notes', 
	'o' => 'Open', 
	'p' => 'Prev Close', 
	'p1' => 'Price Paid', 
	'p2' => 'Change (%)', 
	'p5' => 'Price/Sales', 
	'p6' => 'Price/Book', 
	'q' => 'Ex-Div Date', 
	'r' => 'P/E Ratio', 
	'r1' => 'Div Pay Date', 
	'r2' => 'P/E Ratio (Real-time)', 
	'r5' => 'PEG Ratio', 
	'r6' => 'Price/EPS Est Current Year', 
	'r7' => 'Price/EPS Est Next Year', 
	's' => 'Symbol', 
	's1' => 'Shares', 
	's7' => 'Short Ratio', 
	't1' => 'Time', 
	't6' => 'Trade Links', 
	't7' => 'Ticker Trend', 
	't8' => '1yr Target Price', 
	'v' => 'Volume', 
	'v1' => 'Holdings', 
	'v7' => 'Holdings (Real-time)', 
	'w' => 'Year\'s Range', 
	'w1' => 'Day\'s Change', 
	'w4' => 'Day\'s Change (Real-time)', 
	'x' => 'Exchange', 
	'y' => 'Div Yield'
	);

	
	
	
$url 	= "http://quote.yahoo.com/d/quotes.csv?e=csv&s=" . $symbol . "&f=" . $flag;
echo "//" . $url . chr(10);

global $wgHTTPProxy;

$ch = curl_init();    // Starts the curl handler
curl_setopt($c, CURLOPT_URL, $url); // Sets the paypal address for curl
curl_setopt($c, CURLOPT_FAILONERROR, 1);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); // Returns result to a variable instead of echoing
curl_setopt($c, CURLOPT_TIMEOUT, 3); // Sets a time limit for curl in seconds (do not set too low)
curl_setopt($c, CURLOPT_PROXY, $wgHTTPProxy); // set HTTP proxy
$info = curl_exec($c); // run the curl process (and return the result to $result
curl_close($ch);


$info	= str_ireplace('"', '', $info);
$output .= '<table width="' . $width . '" class="' . $class . '" cellpadding="0" cellspacing="0"><tr>';
$info = explode(',', $info);


$key = array();
$key_old = '';

for ($x=0; $x < strlen($flag); $x++) {	
	$key_new = substr($flag, $x, 1);
	if ($key_old != '' && eregi('[a-z]', $key_new)) {
		$key[sizeof($key)] = $key_old;
		$key_old = '';
	}
	
	$key_old .= $key_new;
	
	if ($x == strlen($flag) - 1) {
		$key[sizeof($key)] = $key_old;
	}
}

if (sizeof($key) == sizeof($info)) {
	for ($x=0; $x < sizeof($key); $x++) {
		$output .= '<th class="fundimentals">' . $flags[$key[$x]] . '<!--' . $info . '--></td>';
		
		switch ($key[$x]) {
			case 'c' :
				if (strstr($info[$x], '+')) {
					$color = 'green';
				} else {
					$color = 'red';
				}
				break;
			default:
				$color = 'black';
		}
		$output .= '<td class="fundimentals"><b><font color="'.$color.'">' . $info[$x] . '</font></b></td>';
		if (($x + 1) % $cols == 0) {
			$output .="</tr><tr>";
		}
	}
} else {
	$output .= "<td align='center'><b>Symbol not Found</b></td>";
}

$output .= '</tr></table>';
$output = str_replace("'", "\'", $output);
$output = str_replace(chr(10), "", $output);
$output = str_replace(chr(13), "", $output);
$output = str_replace(">", ">');" . chr(10) . chr(13) . "document.write('", $output);

echo "document.write('$output');";

}
	
}
