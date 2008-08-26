<?php

$wgExtensionFunctions[] = "wfStockQuote";
$wgExtensionCredits['parserhook'][] = array( 'name' => 'Stock Quote', 'url' => null, 'author' => 'Olipro' );
function wfStockQuote() {
  global $wgParser;
  $wgParser->setHook('stock', 'StockQuote');
}

function StockQuote($input, $argv, $parser) {
  global $wgParser;
  $wgParser->disableCache();
  $info = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=$input&f=sl1d1t1c1ohgv&e=csv");
  $info = str_ireplace('"', '', $info);
  $info = explode(',', $info);
  if($info[1] == '0.00') { return 'ERROR'; }
  if($argv['quote']) {
    return $info[1];
  } elseif($argv['change']) {
    return $info[4];
  } elseif($argv['high']) {
    return $info[6];
  } elseif($argv['low']) {
    return $info[7];
  } elseif($argv['open']) {
    return $info[5];
  } elseif($argv['volume']) {
    return number_format($info[8]);
  } else {
    return $info[1];
  }
}
?>