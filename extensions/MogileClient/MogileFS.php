<?php

/**
 * Copyright (c) 2007, Jens Frank, Domas Mituzas
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Wikimedia Foundation nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHORS ``AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * Class for accessing the MogileFS file system
 * Allows creation of classes, retrieval and storage of files, querying
 * existence of a file, etc.
 */

class MogileFS {
	var $socket;
	var $error;
	
	/**
	 * Constructor
	 * 
	 * TODO
	 */
	function MogileFS( $domain = null,
			   $hosts = null,
			   $root = '' )
	{
		global $wgMogileTrackers, $wgDBname;

		if ($domain == null)
			$domain=$wgDBname;

		if ($hosts == null) {
			if ($wgMogileTrackers!=null) {
				$hosts=$wgMogileTrackers;
			} else {
				die("wgMogileTrackers empty, please define hosts");
			}
		}

		$this->domain = $domain;
		$this->hosts  = $hosts;
		$this->root   = $root;
		$this->error  = '';
	}

	/**
	 * Factory method
	 * Creates a new MogileFS object and tries to connect to a
	 * mogilefsd.
	 *
	 * Returns false if it can't connect to any mogilefsd.
	 *
	 * TODO
	 */
	function NewMogileFS( $domain = null,
			      $hosts = null,
			      $root = '' )
	{
		global $wgDBname; 

		if ($domain == null)
			$domain=$wgDBname;

		$mfs = new MogileFS( $domain, $hosts, $root );
		return ( $mfs->connect() ? $mfs : false );
	}

	/**
	 * Connect to a mogilefsd
	 * Scans through the list of daemons and tries to connect one.
	 */
	function connect()
	{
		foreach ( $this->hosts as $host ) {
			list($ip,$port)=split(':',$host,2);
			if ($port==null)
				$port=7001;
			$this->socket = fsockopen( $ip, $port );
			if ( $this->socket ) {
				break;
			}
		}

		return $this->socket;
	}

	/**
	 * Send a request to mogilefsd and parse the result.
	 * @private
	 */
	function doRequest( $cmd,$args=array() )
	{
		$params=' domain='.urlencode($this->domain);
		foreach ($args as $key => $value)
			$params.='&'.urlencode($key)."=".urlencode($value);

		if ( ! $this->socket ) {
			$this->connect();
		}
		fwrite( $this->socket, $cmd . $params."\n" );
		$line = fgets( $this->socket );
		$words = explode( ' ', $line );
		if ( $words[0] == 'OK' ) {
			parse_str( trim( $words[1] ), $result );
		} else {
			$result = false;
			$this->error = join(" ",$words);
		}
		return $result;
	}

	/**
	 * Return a list of domains
	 */
	function getDomains()
	{
		$res = $this->doRequest( 'GET_DOMAINS' );
		if ( ! $res ) {
			return false;
		}
		$domains = array();
		for ( $i=1; $i <= $res['domains']; $i++ ) {
			$dom = 'domain'.$i;
			$classes = array();
			for ( $j=1; $j<=$res[$dom.'classes']; $j++ ) {
				$classes[$res[$dom.'class'.$j.'name']] = $res[$dom.'class'.$j.'mindevcount'];
			}
			$domains[] = array( 'name' => $res[$dom],
					'classes' => $classes );
		}
		return $domains;
	}

	/**
	 * Get an array of paths
	 */
	function getPaths( $key )
	{
		$res = $this->doRequest( "GET_PATHS", array("key" => $key));
		unset( $res['paths'] );
		return $res;
	}

	/** 
	 * Delete a file from system
	 */
	function delete ( $key )
	{
		$res = $this->doRequest( "DELETE", array("key" => $key));
		if ($res===false)
			return false;
		return true;
	}

	/**
	 * Rename a file
         */
	function rename ($from,$to)
	{
		$res = $this->doRequest( "RENAME", array("from_key"=>$from,"to_key"=>$to));
		if ($res===false) 
			return false;
		return true;
	}

	/**
	 * Get a file from the file service and return it as a string
	 * TODO
	 */
	function getFileData( $key )
	{
		$paths = $this->getPaths( $key );
		if ($paths == false)
			return false;
		foreach ( $paths as $path ) {
			$fh = fopen( $path, 'r' );
			$contents = '';

			if ( $fh ) {
				while (!feof($fh)) {
					$contents .= fread($fh, 8192);
				}
				fclose( $fh );
				return $contents;
			}
		}
		return false;
	}

	/**
	 * Get a file from the file service and send it directly to stdout
	 * uses fpassthru()
	 * TODO
	 */
	function getFileDataAndSend( $key )
	{
		$paths = $this->getPaths( $key );
		if (!$paths) 
			return false;
		foreach ( $paths as $path ) {
			$fh = fopen( $path, 'r' );

			if ( $fh ) {
				$success = fpassthru( $fh );
			}
			fclose( $fh );
			return $success;
		}
		return false;
	}

	/**
	 * Save a file to the MogileFS
	 * TODO
	 */
	function saveFile( $key, $class, $filename )
	{
		$res = $this->doRequest( "CREATE_OPEN", array("key"=>$key, "class"=>$class));

		if ( ! $res )
			return false;

		if ( preg_match( '/^http:\/\/([a-z0-9.-]*):([0-9]*)\/(.*)$/', $res['path'], $matches ) ) {
			$host = $matches[1];
			$port = $matches[2];
			$path = $matches[3];

			// $fout = fopen( $res['path'], 'w' );
			$fin = fopen( $filename, 'r' );
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_PUT,1);
			curl_setopt($ch,CURLOPT_URL, $res['path']);
			curl_setopt($ch,CURLOPT_VERBOSE, 0);
			curl_setopt($ch,CURLOPT_INFILE, $fin);
			curl_setopt($ch,CURLOPT_INFILESIZE, filesize($filename));
			curl_setopt($ch,CURLOPT_TIMEOUT, 4);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			if(!curl_exec($ch)) {
				$this->error=curl_error($ch);
				curl_close($ch);
				return false;
			}
			curl_close($ch);

			$closeres = $this->doRequest( "CREATE_CLOSE", array(
				"key"	=> $key,
				"class" => $class,
				"devid" => $res['devid'],
				"fid"   => $res['fid'],
				"path"  => urldecode($res['path'])
				));
			if ($closeres===false) {
				return false;
			} else {
				return true;
			}
		}
	}
}

