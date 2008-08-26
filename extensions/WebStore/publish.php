<?php

/**
 * Move a temporary file to a public directory, and archive the existing file 
 * if there was one.
 */

require( dirname( __FILE__ ) . '/WebStoreStart.php' );

class WebStorePublish extends WebStoreCommon {
	const DELETE_SOURCE = 1;

	function execute() {
		global $wgRequest;

		if ( !$this->checkAccess() ) {
			$this->error( 403, 'webstore_access' );
			return false;
		}

		if ( !$wgRequest->wasPosted() ) {
			echo $this->dtd();
?>
<html>
<head><title>publish.php Test Interface</title></head>
<body>
<form method="post" action="publish.php">
<p>Source zone: <select name="srcZone" value="public">
<option>public</option>
<option>temp</option>
<option>deleted</option>
</select></p>
<p>Source: <input type="text" name="src"/></p>
<p>Destination: <input type="text" name="dst"/></p>
<p>Archive: <input type="text" name="archive"/></p>
<p><input type="submit" value="OK"/></p>
</form>
</body>
</html>
<?php
			return true;
		}

		$srcZone = $wgRequest->getVal( 'srcZone' );
		if ( !$srcZone ) {
			$srcZone = 'temp';
		}
		// Delete the source file if the source zone is not the public one
		$deleteSource = ( $srcZone != 'public' );

		$srcRel = $wgRequest->getVal( 'src' );
		$dstRel = $wgRequest->getVal( 'dst' );
		$archiveRel = $wgRequest->getVal( 'archive' );

		// Check for directory traversal
		if ( !$this->validateFilename( $srcRel ) || 
			!$this->validateFilename( $dstRel ) || 
			!$this->validateFilename( $archiveRel ) )
		{
			$this->error( 400, 'webstore_path_invalid' );
			return false;
		}

		// Don't publish into odd subdirectories of the public zone. 
		// Some directories may be temporary caches with a potential for 
		// data loss.
		if ( !preg_match( '!^archive|[a-zA-Z0-9]/!', $dstRel ) ) {
			$this->error( 400, 'webstore_path_invalid' );
			return false;
		}

		// Don't move anything to a filename that ends with the reserved suffix
		if ( substr( $dstRel, -12 ) == '.MW_WebStore' || 
			substr( $archiveRel, -12 ) == '.MW_WebStore' ) 
		{
			$this->error( 400, 'webstore_path_invalid' );
			return false;
		}

		$srcRoot = $this->getZoneRoot( $srcZone );
		if ( strval( $srcRoot ) == '' ) {
				$this->error( 400, 'webstore_invalid_zone', $srcZone );
				return false;
		}

		$srcPath = $srcRoot . '/' . $srcRel;
		$dstPath = $this->publicDir .'/'. $dstRel;
		$archivePath = $this->publicDir . '/archive/' . $archiveRel;

		if ( file_exists( $dstPath ) ) {
			if ( $dstRel == '' ) {
				$this->errors[] = new WebStoreError( 'webstore_no_archive' );
				$status = 'failure';
			} elseif ( $this->publishAndArchive( $srcPath, $dstPath, $archivePath, $deleteSource ) ) {
				$status = 'archived';
			} else {
				$status = 'failure';
			}
		} elseif ( $deleteSource ) {
			if ( $this->movePath( $srcPath, $dstPath ) ) {
				$status = 'new';
			} else {
				$status = 'failure';
			}
		} else {
			if ( $this->copyPath( $srcPath, $dstPath ) ) {
				$status = 'new';
			} else {
				$status = 'failure';
			}
		}

		$errors = $this->getErrorsXML();
		header( 'Content-Type: text/xml' );
		echo <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<response>
<status>$status</status>
$errors
</response>

EOT;
		return $status;
	}

	/**
	 * Does a three-way move:
	 *    $dstPath -> $archivePath
	 *    $srcPath -> $dstPath
	 * with a reasonable chance of atomic operation under various adverse conditions.
	 *
	 * @return true on success, error message on failure
	 */
	function publishAndArchive( $srcPath, $dstPath, $archivePath, $flags = 0 ) {
		$archiveLockFile = false;
		$dstLockFile = false;
		$success = true;
		do {
			// Create archive directory
			$archiveDir = dirname( $archivePath );
			if ( !wfMkdirParents( $archiveDir ) ) {
				$this->errors[] = new WebStoreError( 'webstore_archive_mkdir', $archiveDir );
				$success = false;
				break;
			}

			// Obtain both writer locks
			$archiveLockPath = "$archivePath.lock.MW_WebStore";
			$archiveLockFile = fopen( $archiveLockPath, 'w' );
			if ( !$archiveLockFile ) {
				$this->errors[] = new WebStoreError( 'webstore_lock_open', $archiveLockPath );
				$success = false;
				break;
			}
			if ( !flock( $archiveLockFile, LOCK_EX | LOCK_NB ) ) {
				$this->errors[] = new WebStoreError( 'webstore_archive_lock', $archiveLockPath );
				$success = false;
				break;
			}

			$dstLockPath = "$dstPath.lock.MW_WebStore";
			$dstLockFile = fopen( $dstLockPath, 'w' );
			if ( !$dstLockFile ) {
				$this->errors[] = new WebStoreError( 'webstore_lock_open', $dstLockFile );
				$success = false;
				break;
			}
			if ( !flock( $dstLockFile, LOCK_EX | LOCK_NB ) ) {
				$this->errors[] = new WebStoreError( 'webstore_dest_lock', $dstLockFile );
				$success = false;
				break;
			}

			// Copy the old file to the archive. Leave a copy in place in its 
			// current location for now so that webserving continues to work.
			// If we had access to the real C rename() call, then we could use
			// link() instead and avoid the copy, but the chance that PHP might 
			// copy and delete on the subsequent rename() call, thereby overwriting 
			// the archive, makes this a dangerous option.
			//
			// NO_LOCK option because we already have the lock
			$success = $this->copyPath( $dstPath, $archivePath, self::NO_LOCK );
			if ( !$success ) {
				break;
			}

			// Move in the new file
			if ( $flags & self::DELETE_SOURCE ) {
				if ( $this->windows ) {
					// PHP doesn't provide access to the MOVEFILE_REPLACE_EXISTING
					unlink( $dstPath );
				}
				if ( !rename( $srcPath, $dstPath ) ) {
					$this->errors[] = new WebStoreError( 'webstore_rename', $srcPath, $dstPath );
					$success = false;
					break;
				}
			} else {
				$success = $this->copyPath( $srcPath, $dstPath, self::NO_LOCK | self::OVERWRITE );
			}
		} while (false);
		
		// Close the lock files
		if ( $archiveLockFile ) {
			if ( !$this->closeAndDelete( $archiveLockFile, $archiveLockPath ) ) {
				$this->errors[] = new WebStoreWarning( 'webstore_lock_close', $archiveLockPath );
			}
		}
		if ( $dstLockFile ) {
			if ( !$this->closeAndDelete( $dstLockFile, $dstLockPath ) ) {
				$this->errors[] = new WebStoreWarning( 'webstore_lock_close', $dstLockPath );
			}
		}

		return $success;
	}
}

$w = new WebStorePublish;
$w->executeCommon();

?>
