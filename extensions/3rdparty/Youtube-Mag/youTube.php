<?php


$wgExtensionFunctions[] = "wfYouTube";


function wfYouTube() {
        global $wgParser;
        $wgParser->setHook( "youtube", "renderYouTube" );
}
function renderYouTube( $input ) {
getValue($videoWidth,$input,"width");
getValue($videoHeight,$input,"height");
getValue($videoSRC,$input,"source");

$output = "";
$output .= "<object width=" . $videoWidth . " height=" . $videoHeight . 
"><param name='movie' value=\"" . $videoSRC . "\"></param><embed src=" . $videoSRC . " type=\"application/x-shockwave-flash\" width=" . $videoWidth . " height=" . $videoHeight . "></embed></object>";

return $output;
}


?>
