<?php

class WebStorePostFile {
	var $curl, $content, $outputFile, $errno, $error, $responseCode, $contentType, $success,
		$sourceFile, $sourcePath;

	static function post( $url, $fileParamName, $sourcePath, $params = array(), $proxy = false, 
		$outputFile = false, $connectTimeout = 10, $overallTimeout = 180 ) 
	{
		$postObj = new WebStorePostFile( $url, $fileParamName, $sourcePath, $params, $proxy, 
			$outputFile, $connectTimeout, $overallTimeout );
		$postObj->_post();
		return $postObj;
	}

	function __construct( $url, $fileParamName, $sourcePath, $params = array(), $proxy = false, 
		$outputFile = false, $connectTimeout = 10, $overallTimeout = 180 )
	{
		$this->boundary = dechex( mt_rand() ) . dechex( mt_rand() ) . dechex( mt_rand() );
		$this->prefixSent = false;
		$this->suffixSent = false;
		$this->sourcePath = $sourcePath;
		
		// Form parameters
		$this->formDataPrefix = "--{$this->boundary}\r\n";
		foreach ( $params as $name => $value ) {
			$this->formDataPrefix .= 
				"Content-Disposition: form-data; name=\"$name\"\r\n\r\n" .
				urlencode( $value ) .
				"\r\n--{$this->boundary}\r\n";
		}
		// Data file
		$this->formDataPrefix .= 
			"Content-Disposition: form-data; name=\"$fileParamName\"; filename=\"" . urlencode( basename( $sourcePath ) ) . "\"\r\n" .
			"Content-Transfer-Encoding: binary\r\n\r\n";

		$this->outputFile = $outputFile;
		$this->curl = curl_init( $url );
		curl_setopt( $this->curl, CURLOPT_POST, true );
		curl_setopt( $this->curl, CURLOPT_HTTPHEADER, array( 
			"Content-Type: multipart/form-data; boundary={$this->boundary}",
			'Transfer-Encoding: chunked'
		));
		if ( $proxy !== false ) {
			curl_setopt( $this->curl, CURLOPT_PROXY, $proxy );
			wfDebug( "Sending curl request: $url on $proxy\n" );
		} else {
			wfDebug( "Sending curl request: $url\n" );
		}
		if ( $outputFile !== false ) {
			curl_setopt( $this->curl, CURLOPT_FILE, $outputFile );
		}
		curl_setopt( $this->curl, CURLOPT_READFUNCTION, array( $this, 'curlRead' ) );
		curl_setopt( $this->curl, CURLOPT_CONNECTTIMEOUT, $connectTimeout );
		curl_setopt( $this->curl, CURLOPT_TIMEOUT, $overallTimeout );
		curl_setopt( $this->curl, CURLOPT_USERAGENT, "MediaWiki WebStore" );
	}

	function _post() {
		$this->sourceFile = @fopen( $this->sourcePath, 'r' );
		if ( !$this->sourceFile ) {
			$this->error = wfMsg( 'webstore_postfile_not_found' );
			$this->errno = true;
			$this->success = false;
			return false;
		}

		if ( $this->outputFile === false ) {
			ob_start();
			$this->success = curl_exec( $this->curl );
			$this->content = ob_get_contents();
			ob_end_clean();
		} else {
			ftruncate( $this->outputFile, 0 );
			$this->success = curl_exec( $this->curl );
		}
		if ( !$this->success ) {
			$this->errno = curl_errno( $this->curl );
			$this->error = curl_error( $this->curl );
		} else {
			$this->errno = false;
			$this->responseCode = curl_getinfo( $this->curl, CURLINFO_HTTP_CODE );
			$this->contentType = curl_getinfo( $this->curl, CURLINFO_CONTENT_TYPE );
		}
		curl_close( $this->curl );
		return $this->success;
	}

	function curlRead( $curl, $inFile, $maxLength ) {
		if ( !$this->prefixSent ) {
			$data = $this->formDataPrefix;
			$this->prefixSent = true;
		} elseif ( feof( $this->sourceFile ) ) {
			if ( !$this->suffixSent ) {
				$data = "\r\n--{$this->boundary}--\r\n";
				$this->suffixSent = true;
			} else {
				$data = '';
			}
		} else {
			$data = fread( $this->sourceFile, $maxLength - 30 );
		}
		return $data;
	}
}


