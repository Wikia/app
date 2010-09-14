<?php
/**
 * This 404handler is built to get any requests for static files (eg: js/css) that weren't found.
 * Generally, this will mean that StaticChute.php has just not been run yet for the desired resource.
 *
 * This script will use StaticChute to create the file and store it to disk so that future requests will
 * get it directly (instead of depending on StaticChute).
 *
 * @author Sean Colombo
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

///// CONFIG /////
// TODO: Is there a more intelligent way to do this?  Can we find $IP, then remove it from the front of 'dirname(__FILE__)'?  Finding $IP may take loading MW-stack though (probably too expensive for just this).
$DIR_NAME = "static";
///// CONFIG /////

// From the Request, figure out the parameters for StaticChute.
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = preg_replace("/^\/?$DIR_NAME\/?(.*)$/i", "\\1", $requestUri);
$data = explode("/", $requestUri);

if(count($data) < 3){
	
	// TODO: DISPLAY SOME ERROR MESSAGE ABOUT WRONG NUMBER OF PARAMETERS.
	
} else {
	// Feed the settings into StaticChute
	$params["type"] = $data[0];
	$params["packages"] = $data[1];
	$params["checksum"] = $data[2];
	
print "PARAMS: <pre>";
print_r($params);
	
	// TODO: RUN STATICCHUTE TO GET CONTENT.
	
	// TODO: IF THE CONTENT COULDN'T BE GENERATED SUCCESSFULLY, RETURN AN ERROR COMMENT & HEADERS THAT DON'T ALLOW CACHING.
	
	// TODO: COMPUTE FILENAME FOR DATA.
	
	// TODO: STORE CONTENT IN FILE.
	
	// TODO: RETURN THE CONTENT (WITH CORRECT HEADERS).

}
