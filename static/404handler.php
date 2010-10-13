<?php
/**
 * This 404handler is built to get any requests for static files (eg: js/css) that weren't found.
 * Generally, this will mean that StaticChute.php has just not been run yet for the desired resource.
 *
 * This script will use StaticChute to create the file and store it to disk so that future requests will
 * get it directly (instead of depending on StaticChute).
 *
 * NOTE: This still wouldn't completely solve the problem where Varnish may timeout during the request (and
 * then cache a 404).  To fix that, we would need to get the StaticChute content in another script (with a shorter
 * timeout) and then detect the timeout error in this 404handler and return a 503.
 * If we do switch to that method, however, we'll have to make sure to set the correct headers from inside this 404
 * handler.  Right now, we only set headers on certain errors but generally rely on StaticChute to set most of the headers.
 *
 * The format expected is:
 * /static/[type]/[packages]/[checksum].[type]
 * Example:
 * /static/js/oasis_loggedin_js/abf89dac064128285033a8fc80bfc638.js
 *
 * @author Sean Colombo
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

///// CONFIG /////
// TODO: Is there a more intelligent way to do this?  Can we find $IP, then remove it from the front of 'dirname(__FILE__)'?  Finding $IP may take loading MW-stack though (probably too expensive for just this).
$DIR_NAME = "static";
$MIN_NUM_PARAMS = 3;
///// CONFIG /////

// From the Request, figure out the parameters for StaticChute.
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = preg_replace("/^\/?$DIR_NAME\/?(.*)$/i", "\\1", $requestUri);
$data = explode("/", $requestUri);

$dir = dirname(__FILE__);
require $dir . "/../extensions/wikia/StaticChute/StaticChute.php";

if(count($data) < $MIN_NUM_PARAMS){
	// Not enough parameters.  Return an error (but don't cache it).
	header('HTTP/1.0 400 Bad Request');
	echo $StaticChute->comment("Wrong number of parameters found.  Found " . count($data). " but expected at least " . $MIN_NUM_PARAMS);
	exit;
} else {
	// Feed the settings into StaticChute
	$params["type"] = $data[0];
	$params["packages"] = $data[1];
	$checksum = $data[2];
	$checksum = preg_replace("/^(.*)\?.*$/", "\\1", $checksum);
	$checksum = preg_replace("/^(.*)\..*?$/", "\\1", $checksum);
	$params["checksum"] = $checksum; // don't use the file extension or any querystyring as part of the checksum.

	// Run StaticChute to get the content (similar to how it is done in/extensions/wikia/StaticChute/index.php)
	$StaticChute = new StaticChute($params['type']);
	$files = $StaticChute->getFileList($params);
	if (empty($files)){
		header('HTTP/1.0 400 Bad Request');
		echo $StaticChute->comment("Invalid 'packages' or 'files'");
		exit;
	}
	$content = $StaticChute->process($files);

	// If content === true then it was a not-modified conditional-get. We don't get an opportunity to save the file, but this specific
	// request will just end up using its browser-cache, so not a big loss.
	if($content !== true){
		// Return the content if there was some, otherwise fail in a way that won't result in this empty page being cached in Varnish, CDNs, browsers, etc..
		$content = trim($content);
		if($content == ""){
			header('HTTP/1.0 503 Internal Server Error'); // this prevents us from caching this bad result in varnish
			echo $StaticChute->comment("StaticChute failed to generate content.");
			exit;
		} else {
			// Store the result in the correct static-file that the browser was looking for when it came here.
			$destDir = $dir . "/". $params['type'] . "/" . $params['packages'];
			@mkdir($destDir, 0775, true); // assume the directory doesn't exist and make it (recursive).
			$fileName = $destDir . "/" . $params['checksum'] . "." . $params['type'];

			// Avoid race-conditions by writing the file first, then moving it into place.
			$TMP_SUFFIX = "_TMP";
			file_put_contents($fileName . $TMP_SUFFIX, $content, LOCK_EX);
			rename($fileName . $TMP_SUFFIX, $fileName);

			// Print the whole content of the file (with correct headers).
			header('HTTP/1.0 200 OK');
			print $content;
		}
	}
}
