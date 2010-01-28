<?php
# QuoteMedia WikiMedia extension
# by Naoise Golden Santos (email)
# http://www.goldensantos.com/blog/?p=7

# Usage:
# <quotemedia mode="mini" symbol="MSFT"></QuoteMedia>
#
# To install it put this file in the extensions directory 
# To activate the extension, include it from your LocalSettings.php
# with: require("extensions/YourExtensionName.php");

$wgHooks['ParserFirstCallInit'][] = 'wfQuoteMedia';

function wfQuoteMedia( &$parser ) {
	$parser->setHook( "QuoteMedia", "renderQuoteMedia" );

	return true;
}

$wgQuoteMediaSettings = array(
    'mode'  => 'mini',        
    'symbol'  => 'MSFT',
	'width'  => '300',
	'height'  => '214',
	'counter'  => 10
);

# The callback function for converting the input text to HTML output
function renderQuoteMedia( $input, $argv ) {
        global $wgQuoteMediaSettings;

		foreach (array_keys($argv) as $key) {
			$wgQuoteMediaSettings[$key] = $argv[$key];
		}
		
		$link = '<link rel="stylesheet" type="text/css" href="&#72;ttp://app.quotemedia.com/css/tools.css" />';
		$style = '<style type="text/css">.qmmt_main, .qmmt_text_up, .qmmt_text_down, .qmmt_cycle, .qmmt_tab, .qmmt_tabactive{ font: 12px arial; }</style>';
		$script = '<script language="javascript" type="text/javascript" src="&#72;ttp://app.quotemedia.com/quotetools/';
		if ($wgQuoteMediaSettings['mode'] == 'mini') {
	        	$script .= 'miniCharts.go?webmasterId=91336&toolWidth='.$wgQuoteMediaSettings['width'].'&chhig='.$wgQuoteMediaSettings['height'].'&chbdr=cccccc&symbol=' . $wgQuoteMediaSettings['symbol'];
		} elseif ($wgQuoteMediaSettings['mode'] == 'news') {
			$script .= 'wideNews.go?perTopic=10&toolWidth=700&topic=' . $wgQuoteMediaSettings['symbol'];
		} elseif ($wgQuoteMediaSettings['mode'] == 'fundamentals') {
			$script .= 'detailedQuote.go?toolWidth='.$wgQuoteMediaSettings['width'].'&symbol=' . $wgQuoteMediaSettings['symbol'];
			$style = '<style type="text/css">.qmmt_text { font: 9px; color: #555;}</style>';
		} elseif ($wgQuoteMediaSettings['mode'] == 'news_yahoo') {
			return writeNews($wgQuoteMediaSettings['symbol']);
		}
        $script .= '"></script>';
    return $link.$style.$script;
}

function dateEST($date) {

    $date_time_array = getdate($date);
    $hours = $date_time_array['hours'];
    $minutes = $date_time_array['minutes'];
    $seconds = $date_time_array['seconds'];
    $month = $date_time_array['mon'];
    $day = $date_time_array['mday'];
    $year = $date_time_array['year'];
   
    $hours = $hours - 5;
	
    $timestamp= mktime($hours,$minutes,$seconds,$month,$day,$year);
    return $timestamp;
}

function writeNews($symbol = '', $class = 'news', $count = 10, $width = "100%") {
	$url 	= "http://finance.yahoo.com/rss/headline?s=" . $symbol;
	$rss = fetch_rss($url);
	$output = '';

 	if ($rss != false && stripos(serialize($rss), 'RSS feed not found') == false) {
	
		$output = "<table class='$class' width='$width'>" .  chr(10) . chr(13);
		$counter = 0;
		foreach ($rss->items as $item ) {
			$counter++;
			if ($counter <= 10 ) {
				$title = $item['title'];
				$url   = str_replace('http://', '&#72;ttp://', $item['link']);

				$pubdate  = $item['pubdate'];
				$pubdate  = str_replace(' Etc/GMT', '', $pubdate);
				$pubdate  = dateEST(strtotime($pubdate));

				$output .= "<tr valign='top'>" .  chr(10) . chr(13);
				$output .= "<td nowrap>" . date("m/d/y g:m a", $pubdate) . "</td>" .  chr(10) . chr(13);
				$output .= "<td><a href='$url' target='_blank' rel='nofollow'>$title</a></td>" .  chr(10) . chr(13);
				$output .= "</tr>" .  chr(10) . chr(13);
			}
		}

		$output .= "</table><a href='&#72;ttp://finance.yahoo.com/q/h?s=".$symbol."' target='_blank'>More News...</a>";
	}

	return $output;
}
