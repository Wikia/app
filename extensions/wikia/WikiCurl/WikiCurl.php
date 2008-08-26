<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Wiki engine CURL extension
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author CorfiX <corfix@wikia.com> - original code/ideas
 * @author Tomasz Klim <tomek@wikia.com> - fixes, porting to PHP5, referer tracking, POST, timeout, verbose etc.
 * @author Tomasz Klim <tomek@wikia.com> - caching functionality, bandwidth counting
 * @copyright Copyright (C) 2007 Tomasz Klim, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'WikiCurl',
	'description' => 'universal CURL extension',
	'author' => 'Tomasz Klim'
);


class WikiCurl
{
    var $conn;
    var $referer;
    var $useReferer = false;
    var $cacheDir = false;
    var $cachePeriod = 86400;
    var $cacheOutput = '';
    var $totalTime = 0;
    var $totalSize = 0;
    var $lastTime = 0;
    var $delay = 0;

    function __construct( $allow_redirects = true ) {
	$this->conn = curl_init();
	curl_setopt($this->conn, CURLOPT_HEADER, 1);
	curl_setopt($this->conn, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($this->conn, CURLOPT_RETURNTRANSFER, 1);

	// using additional parameter only for compatibility
	// with old code, which assumes redirects to be allowed
	if ( $allow_redirects ) {
	    curl_setopt($this->conn, CURLOPT_FOLLOWLOCATION, 1);
	}

	// workaround for windows apache2-nossl
	if (strpos(PHP_OS, 'WIN')) {
	    curl_setopt($this->conn, CURLOPT_SSL_VERIFYPEER, 0);
	}
    }

    function __destruct() {
	curl_close($this->conn);
    }

    function setReferer($url) {
	$this->useReferer = true;
	$this->referer = $url;
    }

    function setDelay($delay) {
	$this->delay = $delay;
    }

    function setInterface($ip) {
	curl_setopt($this->conn, CURLOPT_INTERFACE, $ip);
    }

    function setTimeout($sec) {
	curl_setopt($this->conn, CURLOPT_TIMEOUT, $sec);
    }

    function setRange($range) {
	curl_setopt($this->conn, CURLOPT_RANGE, $range);  // "0-4096"
    }

    function setAgent($agent) {
	curl_setopt($this->conn, CURLOPT_USERAGENT, $agent);
    }

    function setProxy($proxy) {
	curl_setopt($this->conn, CURLOPT_PROXY, $proxy);
    }

    function setProxyPass($username, $password) {
	curl_setopt($this->conn, CURLOPT_PROXYUSERPWD, "$username:$password");
    }

    function setProxyPort($port) {
	curl_setopt($this->conn, CURLOPT_PROXYPORT, $port);
    }

    function setAuth($username, $password) {
	curl_setopt($this->conn, CURLOPT_USERPWD, "$username:$password");
    }

    function setCookies($cookies) {
	curl_setopt($this->conn, CURLOPT_COOKIEJAR, $cookies);
	curl_setopt($this->conn, CURLOPT_COOKIEFILE, $cookies);
    }

    // this method works properly only if this class is included from console script, because of php5-curl bug
    function setVerbose() {
	curl_setopt($this->conn, CURLOPT_VERBOSE, 1);
    }

    // sets the cache directory root and thus enables the file cache
    function setCacheDir($dir) {
	$this->cacheDir = $dir;
    }

    // sets the cache period in seconds
    function setCachePeriod($period) {
	$this->cachePeriod = $period;
    }

    function getCacheOutput() {
	$output = $this->cacheOutput;
	unset( $this->cacheOutput );
	$this->cacheOutput = '';
	return $output;
    }

    // TODO: make better error/status handling
    function getError() {
	return curl_error($this->conn);
    }

    function getErrno() {
	return curl_errno($this->conn);
    }

    function getMicroTime() {
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
    }

    function getTotalTime() {
	return $this->totalTime;
    }

    function getTotalSize() {
	return $this->totalSize;
    }

    function getTotalSpeed() {
	return (int)($this->totalSize / ($this->totalTime ? $this->totalTime : 1));
    }

    // this method doesn't work properly, if the last request hit the cache
    function getEffectiveUrl() {
	return curl_getinfo($this->conn, CURLINFO_EFFECTIVE_URL);
    }

    // this method doesn't work properly, if the last request hit the cache
    function getResponseCode() {
	return curl_getinfo($this->conn, CURLINFO_HTTP_CODE);
    }


    function deleteCachedUrl($url) {
	if ($this->cacheDir) {
	    $md5 = md5($url);
	    $file = $this->cacheDir . "/" . substr($md5,0,1) . "/" . substr($md5,0,2) . "/" . substr($md5,0,3) . "/" . substr($md5,0,4) . "/$md5.gz";

	    if ( file_exists($file) ) {
		$this->cacheOutput .= "cache delete $file $url\n";
		unlink($file);
	    }
	}
    }


    function request($url, $vars='', $post=false) {
	if ($post) {
	    curl_setopt($this->conn, CURLOPT_POST, true);  // this option is broken. turning off doesn't work.
	    curl_setopt($this->conn, CURLOPT_POSTFIELDS, $vars);
	} else {
	    curl_setopt($this->conn, CURLOPT_HTTPGET, true);  // this is the only way to turn off POST.
	}

	$fullurl = $url . ($post || $vars == '' ? '' : '?' . $vars);
	curl_setopt($this->conn, CURLOPT_URL, $fullurl);

	if ($this->useReferer) {
	    curl_setopt($this->conn, CURLOPT_REFERER, $referer);
	    $referer = $fullurl;
	}

	$time_start = $this->getMicroTime();
	$ret = curl_exec($this->conn);
	$time_end = $this->getMicroTime();

	$this->totalTime += ($time_end - $time_start);
	$this->totalSize += curl_getinfo($this->conn, CURLINFO_SIZE_DOWNLOAD);
	return $ret;
    }


    function get($url, $vars=null) {
	if ($vars != null && is_array($vars)) {
	    foreach ($vars as $k=>$v) {
		$q .= urlencode($k) . '=' . urlencode($v) . '&';
	    }
	}
	else $q = $vars;

	if ($this->cacheDir) {
	    $fullurl = $url . ($q == '' ? '' : '?' . $q);
	    $md5 = md5($fullurl);
	    $file = $this->cacheDir . "/" . substr($md5,0,1) . "/" . substr($md5,0,2) . "/" . substr($md5,0,3) . "/" . substr($md5,0,4) . "/$md5.gz";

	    if ( file_exists($file) && filemtime($file) + $this->cachePeriod > time() ) {
		$this->cacheOutput .= "cache get $file $fullurl\n";
		return $this->load_gz($file);
	    }
	}

	// enforce the delay, to protect bandwidth
	if ($this->delay) {
	    if ($this->lastTime + $this->delay > time()) {
		sleep($this->delay - (time() - $this->lastTime));
	    }
	    $this->lastTime = time();
	}

	$ret = $this->request($url, $q);

	// TODO: add http code checking here - we only want to cache 2xx, and maybe some of 3xx
	if ($ret && $this->cacheDir && $this->getResponseCode() < 400) {
	    $this->cacheOutput .= "cache set $file $fullurl\n";
	    $this->save_gz($file, $ret);
	}

        return $ret;
    }


    function post($url, $vars=null) {
	if ($vars != null && is_array($vars)) {
	    foreach ($vars as $k=>$v) {
		$q .= "$k=$v&";  //$q .= utf8_encode($k) . '=' . utf8_encode($v) . '&';
	    }
	}
	else $q = $vars;
	return $this->request($url, $q, true);
    }


    // load file from cache
    function load( $file ) {
	$fp = fopen( $file, 'r' );
	flock( $fp, LOCK_SH );
	$data = fread( $fp, filesize( $file ) );
	flock( $fp, LOCK_UN );
	fclose( $fp );
	return $data;
    }
    function load_gz( $file ) {
	$zp = gzopen( $file, 'r' );
	$data = '';
	while ( !gzeof( $zp ) ) {
	    $data .= gzread( $zp, 4096 );
	}
	gzclose( $zp );
	return $data;
    }

    // save file to cache
    function save( $file, $data ) {
	$fp = fopen( $file, 'w' );
	flock( $fp, LOCK_EX );
	fwrite( $fp, $data );
	flock( $fp, LOCK_UN );
	fclose( $fp );
    }
    function save_gz( $file, $data ) {
	$zp = gzopen( $file, 'w9' );
	gzwrite( $zp, $data );
	gzclose( $zp );
    }


    // this method builds the entire cache directory tree
    function buildCacheTree() {
	if ($this->cacheDir && !file_exists($this->cacheDir)) {

	    mkdir( $this->cacheDir, 0700 );
	    for ( $a = 0; $a <= 15; $a++ ) {

		$aa = $this->cacheDir . "/" . dechex($a);
		mkdir( $aa, 0700 );
		for ( $b = 0; $b <= 15; $b++ ) {

		    $bb = $aa . "/" . dechex($a) . dechex($b);
		    mkdir( $bb, 0700 );
		    for ( $c = 0; $c <= 15; $c++ ) {

			$cc = $bb . "/" . dechex($a) . dechex($b) . dechex($c);
			mkdir( $cc, 0700 );
			for ( $d = 0; $d <= 15; $d++ ) {

			    mkdir( $cc . "/" . dechex($a) . dechex($b) . dechex($c) . dechex($d), 0700 );
			}
		    }
		}
	    }
	}
    }
}

?>
