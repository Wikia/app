<?php

# RSS News Feed extension
# Adds news from an RSS feed to your wiki
# To use, include this file from your LocalSettings.php


$wgExtensionFunctions[] = "wfRSSFeedExtension";

function wfRSSFeedExtension() {
	global $wgParser;
	$wgParser->setHook( "rss", "renderRSS" );
}

function renderRSS( $paramstring )
{
	global $wgOut;

        if ( ! @include_once( 'magpierss-0.71.1/rss_fetch.inc' ) ) {
		return "<br /><b>Error: Missing magpierss-0.71.1. Download from <a href=\"http://magpierss.sourceforge.net/\">Sourceforge</a> ".
			"and unpack to extensions/rss</b><br />";
	}
	$count = 99;				# limit to 99 news entries by default

	$wgOut->setSquidMaxage( 300 ); 		# Cache for 5 minutes only
	$wgOut->enableClientCache(false);

	$options = explode( "\n", trim( $paramstring ) );
	if ( isset( $options[0] ) ) {
		$url = $options[0];
		if ( isset( $options[1] ) ) {
			$count = IntVal( $options[1] );
		}
	} else {
        	return "<br /><b>Error: no RSS feed given.</b><br />";
	}

        $rss = fetch_rss( $url );
	if ( ! $rss ) {
		return "<br /><b>Error opening RSS feed $url.</b><br />";
	}

        $text =  "<div class=\"rssfeed\"><h2>" . $rss->channel['title'] . "</h2>\n";
        $text .= "<ul>\n";
	$n = 1;
        foreach ( $rss->items as $item ) {
                $href = $item['link'];
                $title = $item['title'];
                $text .= "<li><a href=\"$href\">$title</a></li>\n";
		$n++;
		if ( $n > $count )
			break;
        }
        $text .= "</ul></div>\n";
	return $text;
}


