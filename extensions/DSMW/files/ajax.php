<?php
/**
 * This file is used to get some informations about a remote DSMW in the
 * AJAX script
 *
 * @copyright INRIA-LORIA-SCORE Team
 * @author Muller Jean-Philippe
 */
    $url = $_GET['url'];
    $url = urldecode( $url );
    $val = file_get_contents_curl( $url );

    if ( strstr( $val, "<?xml version=\"1.0\"?>" ) === false ) {
        $response = "false";
    } else $response = "true";

    echo ( $response );

    function file_get_contents_curl( $url ) {
    if ( extension_loaded( 'curl' ) ) {
    $ch = curl_init();

    curl_setopt( $ch, CURLOPT_HEADER, 0 );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 ); // Set curl to return the data instead of printing it to the browser.
    curl_setopt( $ch, CURLOPT_URL, $url );

    $data = curl_exec( $ch );
    curl_close( $ch );
    } else {// if curl is not loaded
        if ( ini_get( 'allow_url_fopen' ) === '1' ) {
        $data = file_get_contents( $url );
        }
    }
    return $data;
}

?>