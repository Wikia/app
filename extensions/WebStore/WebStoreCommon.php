<?php

class WebStoreCommon {
	const NO_LOCK = 1;
	const OVERWRITE = 2;

	static $httpErrors = array(
		400 => 'Bad Request',
		403 => 'Access Denied',
		404 => 'File not found',
		500 => 'Internal Server Error',
	);

	static $tempDirFormat = 'Y-m-d\TH';

	var $accessRanges = array(), $publicDir = false, $tmpDir = false,
		$deletedDir = false, $tempExpiry = 7200,
		$inplaceScalerAccess = array(), $errors = array(),
		$pathDisclosureProtection = 'simple';

	function __construct() {
		global $wgWebStoreSettings, $wgUploadDirectory, $wgTmpDirectory, $wgFileStore;

		foreach ( $wgWebStoreSettings as $name => $value ) {
			$this->$name = $value;
		}
		if ( !$this->tmpDir ) {
			$this->tmpDir = $wgTmpDirectory;
		}
		if ( !$this->publicDir ) {
			$this->publicDir = $wgUploadDirectory;
		}
		if ( !$this->deletedDir ) {
			if ( isset( $wgFileStore['deleted']['directory'] ) ) {
				$this->deletedDir = $wgFileStore['deleted']['directory'];
			} else {
				// No deletion
				$this->errors[] = new WebStoreWarning( 'webstore_no_deleted' );
				$this->deletedDir = false;
			}
		}
		$this->windows = wfIsWindows();

		wfLoadExtensionMessages( 'WebStore' );
	}

	function setErrorHandler() {
		set_error_handler( array( $this, 'handleWarning' ), E_WARNING );
		ini_set( 'html_errors', 0 );
	}

	function handleWarning( $errno, $errstr, $errfile, $errline ) {
		$this->errors[] = new WebStoreWarning( 'webstore_php_warning', $errstr );
	}

	function dtd() {
		return <<<EOT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

EOT;
	}

	function error( $code, $msgName /*, ... */ ) {
		$params = array_slice( func_get_args(), 1 );
		$info = self::$httpErrors[$code];
		header( "HTTP/1.1 $code $info" );
		header( 'Content-Type: text/xml' );
		$this->errors[] = wfCreateObject( 'WebStoreError', $params );
		$errors = $this->getErrorsXML();
		echo <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<response>
<status>failure</status>
$errors
</response>

EOT;
	}

    function htmlError( $code, $msgName /*, ... */ ) {
		$params = array_slice( func_get_args(), 2 );
		$this->htmlErrorReal( $code, $msgName, $params );
	}

	function htmlErrorReal( $code, $msgName, $msgParams = array(), $extra = '' ) {
		global $wgLogo;
		$msgText = htmlspecialchars( wfMsgReal( $msgName, $msgParams ) );
		$encMsgName = htmlspecialchars( $msgName );
		$info = self::$httpErrors[$code];
		$logo = htmlspecialchars( $wgLogo );
		header( "HTTP/1.1 $code $info" );
		echo $this->dtd();
		echo <<<EOT
<html>
<head>
<title>$info</title></head>
<body>
<h1><img src="$logo" style='float:left;margin-right:1em' alt=''>$info</h1><p>
$encMsgName: $msgText
</p>
$extra
</body>
</html>

EOT;
	}

	function executeCommon() {
		if ( !$this->checkAccess() ) {
			$this->error( 403, 'webstore_access' );
			return false;
		}
		$this->setErrorHandler();
		$this->execute();
	}

	function validateFilename( $filename ) {
		if ( strval( $filename ) == '' ) {
			return false;
		}
		/**
		 * Use the same traversal protection as Title::secureAndSplit()
		 */
		if ( strpos( $filename, '.' ) !== false &&
		     ( $filename === '.' || $filename === '..' ||
		       strpos( $filename, './' ) === 0  ||
		       strpos( $filename, '../' ) === 0 ||
		       strpos( $filename, '/./' ) !== false ||
		       strpos( $filename, '/../' ) !== false ) )
		{
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Copy from one open file handle to another, until EOF
	 */
	function copyFile( $src, $dest ) {
		while ( !feof( $src ) ) {
			$data = fread( $src, 1048576 );
			if ( $data === false ) {
				return false;
			}
			if ( fwrite( $dest, $data ) === false ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Close and delete a file, using an order of operations appropriate for the OS
	 */
	function closeAndDelete( $file, $path ) {
		wfDebug( "Deleting $file, $path\n" );
		if ( $this->windows ) {
			// Close lock file
			if ( !fclose( $file ) ) return false;

			// Ignore errors on unlink, it may just be a second thread reusing the file
			unlink( $path );
		} else {
			// Unlink first and then close, so that we don't accidentally unlink a lockfile
			// which is locked by someone else.
			if ( !unlink( $path ) ) return false;
			if ( !fclose( $file ) ) return false;
		}
		return true;
	}

	/**
	 * Move a file from one place to another. Fails if the destination file already exists.
	 * Requires a filesystem with locking semantics to work concurrently, i.e. not NFS.
	 *
	 * $flags may be:
	 * 		self::NO_LOCK if you already have the destination lock.
	 * Returns true on success and false on failure.
	 */
	function movePath( $srcPath, $dstPath, $flags = 0 ) {
		$lockFile = false;
		$success = true;
		do {
			// Create destination directory
			if ( !wfMkdirParents( dirname( $dstPath ) ) ) {
				$this->errors[] = new WebStoreError( 'webstore_dest_mkdir', $dstPath );
				$success = false;
				break;
			}

			// Open lock file
			// The MW_WebStore suffix should be protected at the middleware entry points
			if ( !($flags & self::NO_LOCK) ) {
				$lockFileName = "$dstPath.lock.MW_WebStore";
				$lockFile = fopen( $lockFileName , 'w' );
				if ( !$lockFile ) {
					$this->errors[] = new WebStoreError( 'webstore_lock_open', $lockFileName );
					$success = false;
					break;
				}
				if ( !flock( $lockFile, LOCK_EX | LOCK_NB ) ) {
					$this->errors[] = new WebStoreError( 'webstore_dest_lock', $lockFileName );
					$success = false;
					break;
				}
			}

			// Check for destination existence
			if ( file_exists( $dstPath ) ) {
				$this->errors[] = new WebStoreError( 'webstore_dest_exists', $dstPath );
				$success = false;
				break;
			}

			// This is the critical gap, the reason for the locking.

			// Rename the file
			if ( !rename( $srcPath, $dstPath ) ) {
				wfDebug( "$srcPath -> $dstPath\n" );
				$this->errors[] = new WebStoreError( 'webstore_rename', $srcPath, $dstPath );
				$success = false;
				break;
			}
		} while (false);

		// Close and delete the lockfile
		if ( $lockFile && !($flags & self::NO_LOCK) ) {
			if ( !$this->closeAndDelete( $lockFile, $lockFileName ) )  {
				$this->errors[] = new WebStoreWarning( 'webstore_lock_close', $lockFileName );
			}
		}
		return $success;
	}

	/*
	 * Atomically copy a file from one place to another. Fails if the destination file
	 * already exists. Requires a filesystem with locking semantics to work concurrently,
	 * i.e. not NFS.
	 *
	 * $flags may be:
	 *      * self::NO_LOCK if you already have the destination lock (*.lock.MW_WebStore)
	 *      * self::OVERWRITE to overwrite the destination if it exists
	 *
	 * Returns true on success and false on failure.
	 */
	function copyPath( $srcPath, $dstPath, $flags = 0 ) {
		$success = true;
		$tempFile = false;
		$srcFile = false;

		do {
			// Create destination directory
			$dstDir = dirname( $dstPath );
			if ( !wfMkdirParents( $dstDir ) ) {
				$this->errors[] = new WebStoreError( 'webstore_dest_mkdir', $dstDir );
				$success = false;
				break;
			}

			// Open the source file
			$srcFile = fopen( $srcPath, 'r' );
			if ( !$srcFile ) {
				$this->errors[] = new WebStoreError( 'webstore_src_open', $srcPath );
				$success = false;
				break;
			}

			// Copy the file to a temporary location in the same directory as the target
			// Open the temporary file and lock it
			$tempFileName = "$dstPath.temp.MW_WebStore";
			$tempFile = fopen( $tempFileName, 'a+' );
			if ( !$tempFile ) {
				$this->errors[] = new WebStoreError( 'webstore_temp_open', $tempFileName );
				$success = false;
				break;
			}
			if ( !flock( $tempFile, LOCK_EX | LOCK_NB ) ) {
				$this->errors[] = new WebStoreError( 'webstore_temp_lock', $tempFileName );
				$success = false;
				break;
			}
			// Truncate the file if there's anything in it (unlikely)
			if ( ftell( $tempFile ) ) {
				ftruncate( $tempFile, 0 );
			}
			// Copy the data from filehandle to filehandle
			if ( !$this->copyFile( $srcFile, $tempFile ) ) {
				$this->errors[] = new WebStoreError( 'webstore_temp_copy', $srcPath, $tempFileName );
				$success = false;
				break;
			}

			// On Windows, close the temporary file now so that we don't get a lock error
			// This creates a gap where another process may overwrite the temporary file
			if ( $this->windows ) {
				if ( !fclose( $tempFile ) ) {
					$this->errors[] = new WebStoreError( 'webstore_temp_close', $tempFileName );
					$success = false;
					break;
				}
				$tempFile = false;
			}

			// Atomically move the temporary file into its final destination
			if ( $flags & self::OVERWRITE ) {
				if ( $this->windows && file_exists( $dstPath ) ) {
					unlink( $dstPath );
				}
				if ( !rename( $tempFileName, $dstPath ) ) {
					$this->errors[] = new WebStoreError( 'webstore_rename', $tempFileName, $dstPath );
					$success = false;
				}
			} else {
				$success = $this->movePath( $tempFileName, $dstPath, $flags );
			}
		} while ( false );

		// Close the source file
		$error2 = true;
		if ( $srcFile ) {
			if ( !fclose( $srcFile ) ) {
				$this->errors[] = new WebStoreWarning( 'webstore_src_close', $srcPath );
			}
		}
		// Close the temporary file
		if ( $tempFile ) {
			if ( !fclose( $tempFile, $tempFileName ) ) {
				$this->errors[] = new WebStoreWarning( 'webstore_temp_close', $tempFileName );
			}
		}
		return $success;
	}

	function checkAccess() {
		foreach ( $this->accessRanges as $range ) {
			if ( IP::isInRange( $_SERVER['REMOTE_ADDR'], $range ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Clean up temporary directories
	 * @param integer $now The current unix timestamp
	 */
	function cleanupTemp( $now ) {
		$expiry = max( $this->tempExpiry, 7200 );
		$cleanupDir = $this->tmpDir . '/' . gmdate( self::$tempDirFormat, $now - $expiry );
		$this->cleanup( $cleanupDir );
	}

	/**
	 * Delete a directory if it's not being deleted already
	 */
	function cleanup( $path ) {
		if ( file_exists( $path )  ) {
			$lockFile = fopen( "$path.deleting", 'a+' );
			if ( flock( $lockFile, LOCK_EX | LOCK_NB ) ) {
				$dir = opendir( $path );
				if ( !$dir ) {
					fclose( $lockFile );
					return;
				}
				while ( false !== ( $fileName = readdir( $dir ) ) ) {
					unlink( $fileName );
				}
				closedir( $dir );
				rmdir( $path );
			}
			fclose( $lockFile );
		}
	}

	/**
	 * Get the root directory for a given zone: public, temp or deleted
	 */
	function getZoneRoot( $zone ) {
		switch ( $zone ) {
			case 'public':
				return $this->publicDir;
			case 'temp':
				return $this->tmpDir;
			case 'deleted':
				return $this->deletedDir;
			default:
				return false;
		}
	}

	function getErrorCleanupFunction() {
		switch ( $this->pathDisclosureProtection ) {
			case 'simple':
				$callback = array( $this, 'simpleClean' );
				break;
			case 'paranoid':
				$callback = array( $this, 'paranoidClean' );
				break;
			default:
				$callback = array( $this, 'passThrough' );
		}
		return $callback;
	}

	function getErrorsXML() {
		if ( !count( $this->errors ) ) {
			return '';
		}
		$callback = $this->getErrorCleanupFunction();

		$xml = "<errors>\n";
		foreach ( $this->errors as $error ) {
			$xml .= $error->getXML( $callback );
		}
		$xml .= "</errors>\n";
		return $xml;
	}

	function paranoidClean( $param ) {
		return '[hidden]';
	}

	function simpleClean( $param ) {
		if ( !isset( $this->simpleCleanPairs ) ) {
			global $IP;
			$this->simpleCleanPairs = array(
				$this->publicDir => 'public',
				$this->tmpDir => 'temp',
				$IP => '$IP',
				dirname( __FILE__ ) => '$IP/extensions/WebStore',
			);
			if ( $this->deletedDir ) {
				$this->simpleCleanPairs[$this->deletedDir] = 'deleted';
			}
		}
		return strtr( $param, $this->simpleCleanPairs );
	}

	function passThrough( $param ) {
		return $param;
	}
}

class WebStoreError {
	var $type, $message, $params;
	function __construct( $message /*, parameters... */ ) {
		$this->type = 'error';
		$this->message = $message;
		$this->params = array_slice( func_get_args(), 1 );
	}

	function getXML( $cleanCallback = false ) {
		if ( $cleanCallback ) {
			foreach ( $this->params as $i => $param ) {
				$this->params[$i] = call_user_func( $cleanCallback, $param );
			}
		}

		$xml = "<{$this->type}>\n" .
			Xml::element( 'message', null, $this->message ) . "\n" .
			Xml::element( 'text', null, wfMsgReal( $this->message, $this->params ) ) ."\n";
		foreach ( $this->params as $param ) {
			$xml .= Xml::element( 'param', null, $param );
		}
		$xml .= "</{$this->type}>\n";
		return $xml;
	}
}

class WebStoreWarning extends WebStoreError {
	var $type, $message, $params;
	function __construct( $message /*, parameters... */ ) {
		$this->type = 'warning';
		$this->message = $message;
		$this->params = array_slice( func_get_args(), 1 );
	}
}
