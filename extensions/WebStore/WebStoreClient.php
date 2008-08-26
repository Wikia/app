<?php

class WebStoreClient extends FileStore {
	// Last error, in wikitext form
	var $lastError;

	function __construct() {
		wfLoadExtensionMessages( 'WebStore' );
	}

	function getURL( $script ) {
		global $wgServer, $wgScriptPath;
		return "$wgServer$wgScriptPath/extensions/WebStore/$script";
	}

	function setError( $errorMsg /*, ... */ ) {
		$params = array_slice( func_get_args(), 1 );
		$this->lastError = wfMsgReal( $errorMsg, $params );
	}

	function parseResponse( $text ) {
		if ( strval( $text ) == '' ) {
			// lastError should have been set by post/postFile, but just in case, we'll
			// set a fallback message here.
			if ( strval( $this->lastError ) == '' ) {
				$this->setError( 'webstore_no_response' );
			}
			return false;
		}
		wfSuppressWarnings();
		try {
			$response = new SimpleXMLElement( $text );
		} catch ( Exception $e ) {
			$response = false;
		}
		wfRestoreWarnings();
		if ( !$response ) {
			$this->setError( 'webstore_invalid_response', $text );
			return false;
		}
		if ( $response->errors ) {
			$errors = array();
			foreach ( $response->errors->children() as $error ) {
				$message = strval( $error->message );
				$params = array();
				if ( isset( $error->params ) ) {
					foreach ( $error->params->children as $param ) {
						$params[] = strval( $param );
					}
				}
				$errors[] = wfMsgReal( $message, $params );
			}
			if ( count( $errors ) == 1 ) {
				$this->lastError = wfMsg( 'webstore_backend_error', $errors[0] );
			} else {
				$errorsText = '';
				foreach ( $errors as $error ) {
					$errorsText .= '* ' . str_replace( "\n", ' ', $error );
				}
				$this->lastError = wfMsg( 'webstore_backend_error', $errorsText );
			}
		}
		return $response;
	}

	/**
	 * Publish a file, return "archived" if the file existed already and was archived,
	 * "new" if the file didn't exist, and "failure" if there was a problem. Details
	 * of the problem are put in $this->lastError.
	 *
	 * The source zone may be one of "local", "temp", "public" or "deleted". The
	 * file is copied if it is "public", and moved otherwise.
	 */
	function publish( $srcZone, $srcRel, $dstRel, $archiveRel ) {
		global $wgServer, $wgScriptPath;

		if ( $srcZone == 'local' ) {
			// Local pseudo-zone, need to store the file first.
			$sharedSrcRel = $this->store( $srcRel );
			if ( !$sharedSrcRel ) {
				return 'failure';
			}
			// Delete temporary source file, to simulate rename()
			unlink( $srcRel );
			$srcRel = $sharedSrcRel;
			$srcZone = 'temp';
		}

		$content = $this->post( $this->getURL( 'publish.php' ),
			array(
				'srcZone' => $srcZone,
				'src' => $srcRel,
				'dst' => $dstRel,
				'archive' => $archiveRel
			));
		$response = $this->parseResponse( $content );
		if ( $response ) {
			$status = $response->status;
		} else {
			$status = 'failure';
		}
		return $status;
	}

	function store( $fileName ) {
		$content = $this->postFile( $this->getURL( 'store.php' ), 'file', $fileName );
		$response = $this->parseResponse( $content );
		if ( isset( $response->location ) ) {
			return strval( $response->location );
		} else {
			return false;
		}
	}

	function delete( $src, $dst ) {
		$content = $this->post( $this->getURL( 'delete.php' ),
			array(
				'src' => $src,
				'dst' => $dst
			));
		$response = $this->parseResponse( $content );
		return isset( $response->status ) && $response->status == 'success';
	}

	function metadata( $zone, $path ) {
		$content = $this->post( $this->getURL( 'metadata.php' ),
			array(
				'zone' => $zone,
				'path' => $path,
			));
		$response = $this->parseResponse( $content );
		if ( !isset( $response->metadata ) ) {
			return false;
		}
		$metadata = array();
		foreach ( $response->metadata->children() as $item ) {
			$metadata[strval($item['name'])] = strval( $item );
		}
		return $metadata;
	}

	/**
	 * Store a temporary file and then delete the source on success
	 */
	function storeAndDelete( $fileName ) {
		$location = $this->store( $fileName );
		if ( $location !== false ) {
			unlink( $fileName );
		}
		return $location;
	}

	/**
	 * No-op, garbage collection is handled by the cleanup routine instead
	 */
	function unsave( $tempName ) {
		return true;
	}

	function post( $url, $params = array() ) {
		global $wgWebStoreSettings;
		$curl = curl_init( $url );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, wfArrayToCGI( $params ) );
		curl_setopt( $curl, CURLOPT_TIMEOUT, $wgWebStoreSettings['httpOverallTimeout'] );
		curl_setopt( $curl, CURLOPT_USERAGENT, "MediaWiki WebStore" );
		ob_start();
		curl_exec( $curl );
		$text = ob_get_contents();
		ob_end_clean();
		if ( $text === '' ) {
			$this->lastError = curl_error( $curl );
		}
		curl_close( $curl );
		return $text;
	}

	function postFile( $url, $fileParamName, $fileName, $params = array() ) {
		$post = WebStorePostFile::post( $url, $fileParamName, $fileName, $params );
		if ( !$post->content ) {
			$this->lastError = $post->error;
		} else {
			$this->lastError = false;
		}
		return $post->content;
	}
}
