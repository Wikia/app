<?php

require( dirname( __FILE__ ) . '/WebStoreStart.php' );

class WebStoreDelete extends WebStoreCommon {
	function execute() {
		global $wgRequest;
		if ( !$this->checkAccess() ) {
			$this->error( 403, 'webstore_access' );
			return false;
		}
		if ( strval( $this->deletedDir ) == '' ) {
			$this->error( 500, 'webstore_no_deleted' );
			return false;
		}
			
		if ( !$wgRequest->wasPosted() ) {
			echo $this->dtd();
?>
<html>
<head><title>delete.php Test Interface</title></head>
<body>
<form method="post" action="delete.php">
<p>Relative path to delete: <input type="text" name="src"/></p>
<p>Relative archive path: <input type="text" name="dst"/></p>
<p><input type="submit" value="OK"/></p>
</form></body></html>
<?php
			return true;
		}

		$srcRel = $wgRequest->getVal( 'src' );
		$dstRel = $wgRequest->getVal( 'dst' );
		// Check for directory traversal
		if ( !$this->validateFilename( $srcRel ) || 
			!$this->validateFilename( $dstRel ) )
		{
			$this->error( 400, 'webstore_path_invalid' );
			return false;
		}

		$srcPath = $this->publicDir . '/' . $srcRel;
		$dstPath = $this->deletedDir .'/'. $dstRel;

		$error = $this->movePath( $srcPath, $dstPath );
		if ( $error !== true ) {
			$this->error( 500, $error );
			return false;
		}

		echo <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<response><status>success</status></response>
EOT;
		return true;
	}
}

$d = new WebStoreDelete;
$d->execute();

?>
