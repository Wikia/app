<?php

/**
 * Store a file to a temporary, private location
 *
 * TODO: expiration
 */

require( dirname( __FILE__ ) . '/WebStoreStart.php' );

class WebStoreStore extends WebStoreCommon {
	function execute() {
		global $wgRequest;

		if ( !$wgRequest->wasPosted() ) {
			echo $this->dtd();
			echo <<<EOT
<html>
<head><title>store.php Test Interface</title></head>
<body>
<form method="post" action="store.php" enctype="multipart/form-data" >
<p>File: <input type="file" name="file"/></p>
<p><input type="submit" value="OK"/></p>
</form></body></html>
EOT;
			return true;
		}

		$srcFile = $wgRequest->getFileTempname( 'file' );
		if ( !$srcFile ) {
			$this->error( 400, 'webstore_no_file' );
			return false;
		}

		// Use an hourly timestamped directory for easy cleanup
		$now = time();
		$this->cleanupTemp( $now );

		$timestamp = gmdate( self::$tempDirFormat, $now );
		if ( !wfMkdirParents( "{$this->tmpDir}/$timestamp" ) ) {
			$this->error( 500, 'webstore_dest_mkdir' );
			return false;
		}
		
		// Get the extension of the upload, needs to be preserved for type detection
		$name = $wgRequest->getFileName( 'file' );
		$n = strrpos( $name, '.' );
		if ( $n ) {
			$extension = '.' . Image::normalizeExtension( substr( $name, $n + 1 ) );
		} else {
			$extension = '';
		}

		// Pick a random temporary path
		$destRel =  $timestamp . '/' . md5( mt_rand() . mt_rand() . mt_rand() ) . $extension;
		if ( !@move_uploaded_file( $srcFile, "{$this->tmpDir}/$destRel" ) ) {
			$this->error( 400, 'webstore_move_uploaded', $srcFile, "{$this->tmpDir}/$destRel" );
			return false;
		}

		// Succeeded, return temporary location
		header( 'Content-Type: text/xml' );
		echo <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<response>
<location>$destRel</location>
</response>
EOT;
		return true;
	}

}

$s = new WebStoreStore;
$s->executeCommon();


