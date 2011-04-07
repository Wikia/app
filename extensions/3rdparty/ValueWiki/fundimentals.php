<?php

#http://quote.yahoo.com/d/quotes.csv?s=IDWD.pk&d=t&f=sl1d1t1c1ohgvj1pp2wern;

$wgHooks['ParserFirstCallInit'][] = "wfFundimentals";

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Fundimentals',
	'url' => 'http://www.valuewiki.com',
	'author' => 'Zach'
);

include( "SpecialFundJS.php" );

function wfFundimentals( $parser ) {
        $parser->setHook('fundimentals', 'fundimentals');
        return true;
}

function fundimentals($input, $argv, $parser) {
	$parser->disableCache();

	$flag = "sl1d1t1c1ohgvj1pp2wern";
	$class = "fundimentals";
	$cols = 2;
	$symbol = "";
	$width = '300';
	$debug = 0;
	$output = "";

	foreach ($argv as $key => $value) {
		switch ($key) {
			case 'cols':
				$cols = $value;
				break;
			case 'flag':
				$flag = $value;
				break;
			case 'symbol':
				$symbol = $value;
				break;
			case 'width':
				$width = $value;
				break;
		}
	}

	$url = Title::newFromText( 'FundJS', NS_SPECIAL )->getFullURL();
	$output = "<script language='javascript' src='$url?symbol=$symbol&flag=$flag&cols=$cols&width=$width'></script>";

	return $output;
}

