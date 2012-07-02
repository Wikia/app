<?php

/* HTTPBase.php
 *
 * Copyright (C) 2008 MaxMind, Inc.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

class HTTPBase {

	var $server;
	var $numservers;
	var $url;
	var $queries;
	var $allowed_fields;
	var $num_allowed_fields;
	var $outputstr;
	var $isSecure;
	var $timeout;
	var $debug;
	var $check_field;
	var $wsIpaddrRefreshTimeout;
	var $wsIpaddrCacheFile;
	var $useDNS;
	var $ipstr;

	//TODO: Instead of passing the gateway_adapter all over the place, we might consider integrating everything for real.
	function __construct( &$gateway_adapter ) {
		$this->gateway_adapter = &$gateway_adapter;
		$this->isSecure = 0;
		$this->debug = 0;
		$this->timeout = 0;
		$this->check_field = "score";
		$this->wsIpaddrRefreshTimeout = 18000;
		$this->wsIpaddrCacheFile = $this->_getTempDir() . "/maxmind.ws.cache";
		if ( $this->debug == 1 ) {
			print "wsIpaddrRefreshTimeout: " . $this->wsIpaddrRefreshTimeout . "\n";
			print "wsIpaddrCacheFile: " . $this->wsIpaddrCacheFile . "\n";
			print "useDNS: " . $this->useDNS . "\n";
		}
	}

	// this function sets the checked field
	function set_check_field( $f ) {
		$this->check_field = $f;
	}

	// this function sets the allowed fields
	function set_allowed_fields( $i ) {
		$this->allowed_fields = $i;
		$this->num_allowed_fields = count( $i );
	}

	// this function queries the servers
	function query() {
		// query every server in the list
		if ( !$this->useDNS ) {
			$ipstr = $this->readIpAddressFromCache();
			if ( $this->debug == 1 ) {
				print "using ip addresses, IPs are " . $ipstr . "\n";
			}
		}
		// query every server using its ip address
		// if there was success reading the ip addresses
		// from the web or the cache file
		if ( $ipstr ) {
			$ipaddr = explode( ";", $ipstr );
			$numipaddr = count( $ipaddr );
			for ( $i = 0; $i < $numipaddr; $i++ ) {
				$result = $this->querySingleServer( $ipaddr[$i] );
				if ( $this->debug == 1 ) {
					print "ip address: " . $ipaddr[$i] . "\n";
					print "result: " . $result . "\n";
				}
				if ( $result ) {
					return $result;
				}
			}
		}

		// query every server using its domain name
		for ( $i = 0; $i < $this->numservers; $i++ ) {
			$result = $this->querySingleServer( $this->server[$i] );
			if ( $this->debug == 1 ) {
				print "server: " . $this->server[$i] . "\nresult: " . $result . "\n";
			}
			if ( $result ) {
				return $result;
			}
		}
		return 0;
	}

	// this function takes a input hash and stores it in the hash named queries
	function input( $vars ) {
		$numinputkeys = count( $vars );  // get the number of keys in the input hash
		$inputkeys = array_keys( $vars );   // get a array of keys in the input hash
		for ( $i = 0; $i < $numinputkeys; $i++ ) {
			$key = $inputkeys[$i];
			if ( $this->allowed_fields[$key] == 1 ) {
				// if key is a allowed field then store it in
				// the hash named queries
				$this->queries[$key] = urlencode( $this->filter_field( $key, $vars[$key] ) );
			} else {
				print "invalid input $key - perhaps misspelled field?";
				return 0;
			}
		}
		$this->queries["clientAPI"] = $this->API_VERSION;
	}

	// sub-class should override this if it needs to filter inputs
	function filter_field( $key, $value ) {
		return $value;
	}

	// this function returns the output from the server
	function output() {
		return $this->outputstr;
	}

	// write the ip Addresses and the time right now to
	// the cache file
	function writeIpAddressToCache( $filename, $ipstr ) {
		$datetime = time();
		$fh = fopen( $this->wsIpaddrCacheFile, 'w' );
		fwrite( $fh, $ipstr . "\n" );
		fwrite( $fh, $datetime . "\n" );
		fclose( $fh );
		if ( $this->debug == 1 ) {
			print "writing ip address to cache\n";
			print "ip str: " . $ipstr . "\n";
			print "date time: " . $datetime . "\n";
		}
	}

	function readIpAddressFromCache() {
		// if the cache file exists then
		// read the ip addresses and the time
		// IPs were cached
		if ( file_exists( $this->wsIpaddrCacheFile ) ) {
			$fh = fopen( $this->wsIpaddrCacheFile, 'r' );
			$ipstr = fgets( $fh, 1024 );
			$ipstr = rtrim( $ipstr );
			$datetime = fgets( $fh, 1024 );
			$datetime = rtrim( $datetime );
			fclose( $fh );
		} else {
			//otherwise, this thing complains loudly when the file doesn't exist. 
			$datetime = time();
			$ipstr = false;
		}

		// if the ip addresses expired or don't exist then
		// get them from the web and write
		// them to the cache file
		if ( ( ( time() - $datetime ) > $this->wsIpaddrRefreshTimeout ) | (!$ipstr ) ) {
			$tryIpstr = $this->readIpAddressFromWeb();
			if ( $tryIpstr ) {
				$ipstr = $tryIpstr;
			} else {
				if ( $this->debug == 1 ) {
					print "Warning, unable to get ws_ipaddr from www.maxmind.com\n";
				}
			}
			// we write to cache whether or not we were able to get $tryIpStr, since
			// in case DNS goes down, we don't want to check app/ws_ipaddr over and over
			$this->writeIpAddressToCache( $this->wsIpaddrCacheFile, $ipstr );
		}
		if ( $this->debug == 1 ) {
			print "reading ip address from cache\n";
			print "ip str: " . $ipstr . "\n";
			print "date time: " . $datetime . "\n";
		}
		// return the ip addresses
		return $ipstr;
	}

	function readIpAddressFromWeb() {
		// check if the curl module exists
		$url = "http://www.maxmind.com/app/ws_ipaddr";
		if ( extension_loaded( 'curl' ) ) {
			// open curl
			$ch = curl_init();

			// set curl options
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_TIMEOUT, $this->timeout );

			// get the content
			$content = curl_exec( $ch );
			$content = rtrim( $content );
			if ( $this->debug == 1 ) {
				print "using curl\n";
			}
		} else {
			// we using HTTP without curl
			// parse the url to get
			// host, path and query
			$url3 = parse_url( $url );
			$host = $url3["host"];
			$path = $url3["path"];

			// open the connection
			$fp = fsockopen( $host, 80, $errno, $errstr, $this->timeout );
			if ( $fp ) {
				// send the request
				fputs( $fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n" );
				while ( !feof( $fp ) ) {
					$buf .= fgets( $fp, 128 );
				}
				$lines = preg_split( "/\n/", $buf );
				// get the content
				$content = $lines[count( $lines ) - 1];
				// close the connection
				fclose( $fp );
			}
			if ( $this->debug == 1 ) {
				print "using fsockopen\n";
			}
		}
		if ( $this->debug == 1 ) {
			print "readIpAddressFromWeb found ip addresses: " . $content . "\n";
		}
		// TODO fix regexp so that it checks if it only has IP addresses
		if ( preg_match( "/([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})/", $content ) ) {
			return $content;
		}
		return "";
	}

	// this function queries a single server
	function querySingleServer( $server ) {
		$useHTTPProxy = $this->gateway_adapter->getGlobal( 'UseHTTPProxy' );
		$HTTPProxy = $this->gateway_adapter->getGlobal( 'HTTPProxy' );

		// check if we using the Secure HTTPS proctol
		if ( $this->isSecure == 1 ) {
			$scheme = "https://";  // Secure HTTPS proctol
		} else {
			$scheme = "http://";   // Regular HTTP proctol
		}

		// build a query string from the hash called queries
		$numquerieskeys = count( $this->queries ); // get the number of keys in the hash called queries
		$querieskeys = array_keys( $this->queries ); // get a array of keys in the hash called queries
		if ( $this->debug == 1 ) {
			print "number of query keys " . $numquerieskeys . "\n";
		}

		$query_string = "";

		for ( $i = 0; $i < $numquerieskeys; $i++ ) {
			// for each element in the hash called queries
			// append the key and value of the element to the query string
			$key = $querieskeys[$i];
			$value = $this->queries[$key];
			// encode the key and value before adding it to the string
			// $key = urlencode($key);
			// $value = urlencode($value);
			if ( $this->debug == 1 ) {
				print " query key " . $key . " query value " . $value . "\n";
			}
			$query_string = $query_string . $key . "=" . $value;
			if ( $i < $numquerieskeys - 1 ) {
				$query_string = $query_string . "&";
			}
		}

		// check if the curl module exists
		if ( extension_loaded( 'curl' ) ) {
			// use curl
			if ( $this->debug == 1 ) {
				print "using curl\n";
			}

			// open curl
			$ch = curl_init();

			$url = $scheme . $server . "/" . $this->url;

			// set curl options
			if ( $this->debug == 1 ) {
				print "url " . $url . "\n";
			}
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_TIMEOUT, $this->timeout );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );

			// this option lets you store the result in a string
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $query_string );

			// set proxy settings if necessary
			if ( $useHTTPProxy ) {
				curl_setopt( $ch, CURLOPT_HTTPPROXYTUNNEL, 1 );
				curl_setopt( $ch, CURLOPT_PROXY, $HTTPProxy );
			}

			// get the content
			$content = curl_exec( $ch );

			// For some reason curl_errno returns an error even when function works
			// Until we figure this out, will ignore curl errors - (not good i know)
//      $e = curl_errno($ch);//get error or sucess
//      if (($e == 1) & ($this->isSecure == 1)) {
			// HTTPS does not work print error message
//          print "error: this version of curl does not support HTTPS try build curl with SSL or specify \$ccfs->isSecure = 0\n";
//      }
//      if ($e > 0) {
			// we get a error msg print it
//        print "Received error message $e from curl: " . curl_error($ch) . "\n";
//	return 0;
//      }
			// close curl
			curl_close( $ch );
		} else {
			// curl does not exist
			// use the fsockopen function,
			// the fgets function and the fclose function
			if ( $this->debug == 1 ) {
				print "using fsockopen for querySingleServer\n";
			}

			$url = $scheme . $server . "/" . $this->url . "?" . $query_string;
			if ( $this->debug == 1 ) {
				print "url " . $url . " " . "\n";
			}

			// now check if we are using regular HTTP
			if ( $this->isSecure == 0 ) {
				// we using regular HTTP
				// parse the url to get
				// host, path and query
				$url3 = parse_url( $url );
				$host = $url3["host"];
				$path = $url3["path"];
				$query = $url3["query"];

				// open the connection
				$fp = fsockopen( $host, 80, $errno, $errstr, $this->timeout );
				if ( $fp ) {
					// send the request
					$post = "POST $path HTTP/1.0\nHost: " . $host . "\nContent-type: application/x-www-form-urlencoded\nUser-Agent: Mozilla 4.0\nContent-length: " . strlen( $query ) . "\nConnection: close\n\n$query";
					fputs( $fp, $post );
					while ( !feof( $fp ) ) {
						$buf .= fgets( $fp, 128 );
					}
					$lines = preg_split( "/\n/", $buf );
					// get the content
					$content = $lines[count( $lines ) - 1];
					// close the connection
					fclose( $fp );
				} else {
					return 0;
				}
			} else {
				// secure HTTPS requires CURL
				print "error: you need to install curl if you want secure HTTPS or specify the variable to be $ccfs->isSecure = 0";
				return 0;
			}
		}

		if ( $this->debug == 1 ) {
			print "content = " . $content . "\n";
		}
		// get the keys and values from
		// the string content and store them
		// the hash named outputstr
		// split content into pairs containing both
		// the key and the value
		$keyvaluepairs = explode( ";", $content );

		// get the number of key and value pairs
		$numkeyvaluepairs = count( $keyvaluepairs );

		// for each pair store key and value into the
		// hash named outputstr
		$this->outputstr = array( );
		for ( $i = 0; $i < $numkeyvaluepairs; $i++ ) {
			// split the pair into a key and a value
			list( $key, $value ) = explode( "=", $keyvaluepairs[$i] );
			if ( $this->debug == 1 ) {
				print " output " . $key . " = " . $value . "\n";
			}
			// store the key and the value into the
			// hash named outputstr
			$this->outputstr[$key] = $value;
		}
		// check if outputstr has the score if outputstr does not have
		// the score return 0
		if ( $this->outputstr[$this->check_field] == "" ) {
			return 0;
		}
		// one other way to do it
		// if (!array_key_exists("score",$this->outputstr)) {
		//  return 0;
		// }
		return 1;
	}

	function _getTempDir() {
		if ( ini_get( 'upload_tmp_dir' ) ) {
			return ini_get( 'upload_tmp_dir' );
		}

		if ( substr( PHP_OS, 0, 3 ) != 'WIN' ) {
			return '/tmp';
		}

		if ( isset( $_ENV['TMP'] ) ) {
			return $_ENV['TMP'];
		}

		if ( isset( $_ENV['TEMP'] ) ) {
			return $_ENV['TEMP'];
		}

		if ( is_dir( 'c:\\windows\\temp' ) ) {
			return 'c:\\windows\\temp';
		}

		if ( is_dir( 'c:\\winnt\\temp' ) ) {
			return 'c:\\winnt\\temp';
		}

		return '.';
	}

}

?>
