<?php
$wgHooks['ParserFirstCallInit'][] = "wfLastFm";

/**
 * @param Parser $parser
 * @return bool
 */
function wfLastFm( $parser ) {
     $parser->setHook( "lastfm", "renderLastFm" );
     return true;
 }

 # The callback function for converting the input text to HTML output
 function renderLastFm( $input, $argv ) {
     # $argv is an array containing any arguments passed to the extension like <example argument="foo" bar>..
     $output = "<a href=\"http://www.last.fm/user/";
     $output .= $input ;
     $output .= "/?chartstyle=tracks\">";
     $output .= "<img src=\"http://imagegen.last.fm/tracks/artists/";
     $output .= $input ;
     $output .= ".gif\" border=\"0\" alt=\"";
     $output .= $input ;
     $output .= "'s Last.fm Weekly Artists Chart\" /></a>";

     return $output;
 }
