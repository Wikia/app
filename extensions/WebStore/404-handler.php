<?php

/**
 * A 404 handler to render thumbnails via a cluster of scaler servers
 */
require( dirname( __FILE__ ) . '/WebStoreStart.php' );

class WebStore404Handler extends WebStoreCommon {
	var $phpErrors = array();

	function execute() {
		global $wgUploadBaseUrl, $wgUploadPath, $wgScriptPath, $wgServer;

		// Determine URI
		if ( $_SERVER['REQUEST_URI'][0] == '/' ) {
			$url = ( !empty( $_SERVER['HTTPS'] ) ? 'https://' : 'http://' ) . 
				$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		} else {
			$url = $_SERVER['REQUEST_URI'];
		}

		if ( $wgUploadBaseUrl ) {
			$thumbBase = $wgUploadBaseUrl . $wgUploadPath . '/thumb';
		} else {
			$thumbBase = $wgServer . $wgUploadPath . '/thumb';
		}
		if ( substr( $url, 0, strlen( $thumbBase ) ) != $thumbBase ) {
			// Not a thumbnail URL
			header( 'X-Debug: not thumb' );
			$this->real404();
			return true;
		}

		$rel = substr( $url, strlen( $thumbBase ) + 1 ); // plus one for slash
		// Check for path traversal
		if ( !$this->validateFilename( $rel ) ) {
			header( 'X-Debug: invalid path traversal' );
			$this->real404();
			return false;
		}

		if ( !preg_match( '!^(\w)/(\w\w)/([^/]*)/([^/]*)$!', $rel, $parts ) ) {
			header( 'X-Debug: regex mismatch' );
			$this->real404();
			return false;
		}

		list( $all, $hash1, $hash2, $filename, $thumbName ) = $parts;
		$srcNamePos = strrpos( $thumbName, $filename );
		if ( $srcNamePos === false ) {
			header( 'X-Debug: filename/fn2 mismatch' );
			$this->real404();
			return false;
		}
		$extraExt = substr( $thumbName, $srcNamePos + strlen( $filename ) );
		if ( $extraExt != '' && $extraExt[0] != '.' ) {
			header( "X-Debug: invalid trailing characters in filename: $extraExt" );
			$this->real404();
			return false;
		}
		// Determine MIME type
		$extPos = strrpos( $filename, '.' );
		$srcExt = $extPos === false ? '' : substr( $filename, $extPos + 1 );
		$magic = MimeMagic::singleton();
		$mime = $magic->guessTypesForExtension( $srcExt );
		$handler = MediaHandler::getHandler( $mime );
		if ( !$handler ) {
			header( 'X-Debug: no handler' );
			$this->real404();
			return false;
		}

		// Parse parameter string
		$paramString = substr( $thumbName, 0, $srcNamePos - 1 );
		$params = $handler->parseParamString( $paramString );
		if ( !$params ) {
			header( "X-Debug: handler for $mime says param string is invalid" );
			$this->real404();
			return false;
		}

		// Open the destination temporary file
		$dstPath = "{$this->publicDir}/thumb/$rel";
		$tmpPath = "$dstPath.temp.MW_WebStore";
		$tmpFile = @fopen( $tmpPath, 'a+' );
		if ( !$tmpFile ) {
			$this->htmlError( 500, 'webstore_temp_open', $tmpPath );
			return false;
		}

		// Get an exclusive lock
		if ( !flock( $tmpFile, LOCK_EX | LOCK_NB ) ) {
			wfDebug( "Waiting for shared lock..." );
			if ( !flock( $tmpFile, LOCK_SH ) ) {
				wfDebug( "failed\n" );
				$this->htmlError( 500, 'webstore_temp_lock' );
				return false;
			}
			wfDebug( "OK\n" );
			// Close it and see if it appears at $dstPath
			fclose( $tmpFile );
			if ( $this->windows ) {
				// Rename happens after unlock on windows, so we have to wait for it
				usleep( 200000 );
			}
			if ( file_exists( $dstPath ) ) {
				// Stream it out
				$magic = MimeMagic::singleton();
				$type = $magic->guessMimeType( $dstPath );
				$dstFile = fopen( $dstPath, 'r' );
				if ( !$dstFile ) {
					$this->htmlError( 500, 'webstore_dest_open' );
					return false;
				}

				$this->streamFile( $dstFile, $type );
				fclose( $dstFile );
				return true;
			} else {
				// Something went wrong, only the forwarding process knows what
				$this->real404();
				return true;
			}
		}

		// Send an image scaling request to a host in the scaling cluster

		$error = false;
		$errno = false;
		$tmpUnlinkDone = false;
		do {
			$scalerUrl = "$wgServer$wgScriptPath/extensions/WebStore/inplace-scaler.php";

			// Pick a server
			$servers = $this->scalerServers;
			shuffle( $servers );
			foreach( $servers as $server ) {
				if ( strpos( $server, ':' ) === false ) {
					$server .= ':80';
				}

				$post = WebStorePostFile::post( $scalerUrl, 'data', 
					"{$this->publicDir}/$hash1/$hash2/$filename",
					$params, 
					$server, $tmpFile, $this->httpConnectTimeout, $this->httpOverallTimeout );

				// Try next server unless that one was successful
				if ( !$post->errno ) {
					break;
				}
			}

			if ( $post->errno ) {
				break;
			}

			if ( $post->responseCode != 200 ) {
				# Pass through image scaler errors (but don't keep the file)
				$info = self::$httpErrors[$post->responseCode];
				header( "HTTP/1.1 {$post->responseCode} $info" );
				$this->streamFile( $tmpFile );
				break;
			}

			fseek( $tmpFile, 0, SEEK_END );
			if ( ftell( $tmpFile ) == 0 ) {
				$this->htmlError( 500, 'webstore_scaler_empty_response' );
				break;
			}

			// Report PHP errors
			if ( count( $this->phpErrors ) ) {
				$errors = '<ul>';
				foreach ( $this->phpErrors as $error ) {
					$errors .= "<li>$error</li>";
				}
				$errors .= '</ul>';
				$info = self::$httpErrors[500];
				header( "HTTP/1.1 500 $info" );
				echo $this->dtd();
				$msg = wfMsgHtml( 'webstore_php_error' );
				echo <<<EOT
<html><head><title>500 $info</title></head>
<body>
<h1>500 $info</h1>
<p>$msg</p>
$errors
</body>
</html>
EOT;
				restore_error_handler();
				break;
			}

			// Request completed successfully.
			// Move the file to its destination
			if ( $this->windows ) {
				fclose( $tmpFile );
				// Wait for other processes to close the file if rename fails
				for ( $i = 0; $i < 10; $i++ ) {
					if ( !rename( $tmpPath, $dstPath ) ) {
						usleep( 50000 );
					} else {
						break;
					}
				}
				$tmpFile = fopen( $dstPath, 'r' );
				if ( !$tmpFile ) {
					$this->htmlError( 500, 'webstore_dest_open' );
				}
				$tmpUnlinkDone = true;
			} else {
				rename( $tmpPath, $dstPath );
				// Unlock so that other processes can start streaming the file out
				flock( $tmpFile, LOCK_UN );
				$tmpUnlinkDone = true;
			}

			// Stream it ourselves
			$this->streamFile( $tmpFile, $post->contentType );
		} while (false);

		if ( $tmpFile ) {
			if ( !$tmpUnlinkDone ) {
				$this->closeAndDelete( $tmpFile, $tmpPath );
			} else {
				fclose( $tmpFile );
			}
		}

		if ( $post->errno ) {
			$this->htmlError( 500, 'webstore_curl', $post->error );
			return false;
		}

		return true;
	}

	function streamFile( $file, $contentType = false ) {
		if ( $contentType ) {
			header( "Content-Type: $contentType" );
		}
		fseek( $file, 0 );
		fpassthru( $file );
		return true;
	}

	function real404() {
		if ( $this->fallback404 ) {
			require( $this->fallback404 );
		} else {
			$this->htmlError( 404, 'webstore_404' );
		}
	}

	function setErrorHandler() {
		set_error_handler( array( $this, 'handleError' ) );
	}

	function handleError( $errno, $errstr, $errfile, $errline ) {
		$callback = $this->getErrorCleanupFunction();
		$this->phpErrors[] = call_user_func( $callback, "$errstr in $errfile line $errline" );
	}
}

$h = new WebStore404Handler;
$h->setErrorHandler();
$h->execute();


