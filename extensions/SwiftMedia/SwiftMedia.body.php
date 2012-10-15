<?php
/**
 * Local file in the wiki's own database, only stored in Swift
 *
 * @file
 * @ingroup FileRepo
 */

/**
 * Class to represent a local file in the wiki's own database, only stored in Swift
 *
 * Provides methods to retrieve paths (physical, logical, URL),
 * to generate image thumbnails or for uploading.
 *
 * Note that only the repo object knows what its file class is called. You should
 * never name a file class explictly outside of the repo class. Instead use the
 * repo's factory functions to generate file objects, for example:
 *
 * RepoGroup::singleton()->getLocalRepo()->newFile($title);
 *
 * The convenience functions wfLocalFile() and wfFindFile() should be sufficient
 * in most cases.
 *
 * @ingroup FileRepo
 */
class SwiftFile extends LocalFile {
	/**#@+
	 * @private
	 */
	var
		$conn,             # our connection to the Swift proxy.
		$fileExists,       # does the file file exist on disk? (loadFromXxx)
		$dataLoaded,       # Whether or not all this has been loaded from the database (loadFromXxx)
		$swiftuser,
		$swiftkey,
		$authurl,
		$container;
	/**#@-*/

	/**
	 * Create a LocalFile from a title
	 * Do not call this except from inside a repo class.
	 *
	 * Note: $unused param is only here to avoid an E_STRICT
	 *
	 * @return SwiftFile
	 */
	static function newFromTitle( $title, $repo, $unused = null ) {
		if ( empty( $title ) ) {
			return null;
		}
		return new self( $title, $repo );
	}

	/**
	 * Create a LocalFile from a title
	 * Do not call this except from inside a repo class.
	 */
	static function newFromRow( $row, $repo ) {
		$title = Title::makeTitle( NS_FILE, $row->img_name );
		$file = new self( $title, $repo );
		$file->loadFromRow( $row );

		return $file;
	}

	/**
	 * Constructor.
	 * Do not call this except from inside a repo class.
	 */
	function __construct( $title, $repo ) {
		if ( !is_object( $title ) ) {
			throw new MWException( __CLASS__ . ' constructor given bogus title.' );
		}

		parent::__construct( $title, $repo );

		$this->tempPaths = array(); // Hash from rel to local copy.
	}

	/** splitMime inherited */
	/** getName inherited */
	/** getTitle inherited */
	/** getURL inherited */
	/** getViewURL inherited */
	/** isVisible inherited */

	/**
	 * We're re-purposing getPath() to checkout a copy of the file, if we don't already have a copy.
	 *
	 * @return string Path to a local copy of the file.
	 */
	public function getPath() {
		if ( !array_key_exists( '', $this->tempPaths ) ) {
			$this->tempPaths[''] = $this->repo->getLocalCopy( $this->repo->container, $this->getRel(), "getPath_" );
		}
		return $this->tempPaths[''];
	}

	/**
	 * We're re-purposing getPath() to checkout a copy of the file, if we don't already have a copy.
	 * Get a local copy of a particular archived file specified by $suffix
	 *
	 * @param string suffix Specific archived copy.
	 * @return string Path to a local copy of the file.
	 */
	public function getArchivePath( $suffix = false ) {
		if ( !$suffix ) {
			throw new MWException( "Can't call getArchivePath without a suffix" );
		}
		$rel = $this->getArchiveRel( $suffix );
		if ( !array_key_exists( $rel, $this->tempPaths ) ) {
			$this->tempPaths[$rel] = $this->repo->getLocalCopy( $this->repo->container, $rel );
		}
		return $this->tempPaths[$rel];
	}

	/**
	 * We're re-purposing getPath() to checkout a copy of the file, if we don't already have a copy.
	 * Get a local copy of a particular thumb specified by $suffix
	 *
	 * @param string suffix Specific thumbnail.
	 * @return string Path to a local copy of the file.
	 */
	public function getThumbPath( $suffix = false ) {
		if ( !$suffix ) {
			throw new MWException( "Can't call getThumbPath without a suffix" );
		}
		$rel = $this->getRel() . '/' . $suffix;
		if ( !array_key_exists( $rel, $this->tempPaths ) ) {
			$this->tempPaths[$rel] = $this->repo->getLocalCopy( $this->repo->getZoneContainer( 'thumb' ), $rel );
		}
		return $this->tempPaths[$rel];
		}

	function __destruct() {
		foreach ( $this->tempPaths as $path ) {
			// Clean up temporary data.
			wfDebug( __METHOD__ . ": deleting $path\n" );
			unlink( $path );
		}
		$this->tempPaths = array();
	}

	/**
	 * Do the work of a transform (from an original into a thumb).
	 * Contains filesystem-specific functions.
	 *
	 * @param $thumbName string: the name of the thumbnail file.
	 * @param $thumbUrl string: the URL of the thumbnail file.
	 * @param $params Array: an associative array of handler-specific parameters.
	 *                Typical keys are width, height and page.
	 * @param $flags Integer: a bitfield, may contain self::RENDER_NOW to force rendering
	 *
	 * @return MediaTransformOutput | false
	 */
	function maybeDoTransform( $thumbName, $thumbUrl, $params, $flags ) {
		global $wgIgnoreImageErrors, $wgThumbnailEpoch, $wgTmpDirectory;

		// get a temporary place to put the original.
		$thumbPath = tempnam( $wgTmpDirectory, 'transform_out_' );
		unlink( $thumbPath );
		$thumbPath .=  '.' . pathinfo( $thumbName, PATHINFO_EXTENSION );


		if ( $this->repo && $this->repo->canTransformVia404() && !( $flags & self::RENDER_NOW ) ) {
			return $this->handler->getTransform( $this, $thumbPath, $thumbUrl, $params );
		}

		// see if the file exists, and if it exists, is not too old.
		$conn = $this->repo->connect();
		$container = $this->repo->get_container( $conn, $this->repo->container . '-thumb' );
		try {
			$pic = $container->get_object( $this->getRel() . "/$thumbName" );
		} catch ( NoSuchObjectException $e ) {
			$pic = NULL;
		}
		if ( $pic ) {
			$thumbTime = $pic->last_modified;
			$tm = strptime( $thumbTime, '%a, %d %b %Y %H:%M:%S GMT' );
			$thumbGMT = gmmktime( $tm['tm_hour'], $tm['tm_min'], $tm['tm_sec'], $tm['tm_mon'] + 1, $tm['tm_mday'], $tm['tm_year'] + 1900 );
			wfDebug( __METHOD__ . ": $thumbName is dated $thumbGMT\n" );
			if ( gmdate( 'YmdHis', $thumbGMT ) >= $wgThumbnailEpoch ) {

				return $this->handler->getTransform( $this, $thumbPath, $thumbUrl, $params );
			}
		}
		$thumb = $this->handler->doTransform( $this, $thumbPath, $thumbUrl, $params );

		// Ignore errors if requested
		if ( !$thumb ) {
			$thumb = null;
		} elseif ( $thumb->isError() ) {
			$this->lastError = $thumb->toText();
			if ( $wgIgnoreImageErrors && !( $flags & self::RENDER_NOW ) ) {
				$thumb = $this->handler->getTransform( $this, $thumbPath, $thumbUrl, $params );
			}
		}

		// what if they didn't actually write out a thumbnail? Check the file size.
		if ( $thumb && file_exists( $thumbPath ) && filesize( $thumbPath ) ) {
			// Store the thumbnail into Swift, but in the thumb version of the container.
			wfDebug(  __METHOD__ . ': creating thumb ' . $this->getRel() . "/$thumbName\n" );
			$this->repo->write_swift_object( $thumbPath, $container, $this->getRel() . "/$thumbName" );
			// php-cloudfiles throws exceptions, so failure never gets here.
		}

		// Clean up temporary data, if it exists.
		if ( file_exists( $thumbPath ) ) {
			wfSuppressWarnings();
			unlink( $thumbPath );
			wfRestoreWarnings();
		}

		return $thumb;
	}

	/** transform inherited */

	/**
	 * We have nothing to do here.
	 */
	function migrateThumbFile( $thumbName ) {
		return;
	}
	/**
	 * Get the public root directory of the repository.
	 */
	protected function getRootDirectory() {
		throw new MWException( __METHOD__ . ': not implemented' );
	}

	/** getHandler inherited */
	/** iconThumb inherited */
	/** getLastError inherited */

	/**
	 * Get all thumbnail names previously generated for this file
	 * @param $archiveName string: the article name for the archived file (if archived).
	 * @return a list of files, the first entry of which is the directory name (if applicable).
	 */
	function getThumbnails( $archiveName = false ) {
		$this->load();

		if ( $archiveName ) {
			$prefix = $this->getArchiveRel( $archiveName );
		} else {
			$prefix = $this->getRel();
		}
		$conn = $this->repo->connect();
		$container = $this->repo->get_container( $conn, $this->repo->container . '-thumb' );
		$files = $container->list_objects( 0, NULL, $prefix );
		array_unshift( $files, 'unused' ); # return an unused $dir.
		return $files;
	}

	/**
	 * Delete cached transformed files
	 * @param $dir string Should always be the 'unused' we specified earlier.
	 * @param $files array of strings listing the thumbs to be deleted.
	 */
	function purgeThumbList( $dir, $files ) {
		global $wgExcludeFromThumbnailPurge;

		$conn = $this->repo->connect();
		$container = $this->repo->get_container( $conn, $this->repo->container . '-thumb' );
		foreach ( $files as $file ) {
			// Only remove files not in the $wgExcludeFromThumbnailPurge configuration variable
			$ext = pathinfo( $file, PATHINFO_EXTENSION );
			if ( in_array( $ext, $wgExcludeFromThumbnailPurge ) ) {
				continue;
			}

			wfDebug(  __METHOD__ . ' deleting ' . $container->name . "/$file\n" );
			$this->repo->swift_delete( $container, $file );
		}
	}

} // SwiftFile class

# ------------------------------------------------------------------------------

/**
 * Repository that stores files in Swift and registers them
 * in the wiki's own database.
 *
 * @file
 * @ingroup FileRepo
 */

class SwiftRepo extends LocalRepo {
	// The public interface to SwiftFile is through SwiftRepo's findFile and
	// newFile. They call into the repo's NewFile and FindFile, which call
	// one of these factories to create the File object.
	var $fileFactory = array( 'SwiftFile', 'newFromTitle' );
	var $fileFactoryKey = array( 'SwiftFile', 'newFromKey' );
	var $fileFromRowFactory = array( 'SwiftFile', 'newFromRow' );
	var $oldFileFactory = array( 'OldSwiftFile', 'newFromTitle' );
	var $oldFileFactoryKey = array( 'OldSwiftFile', 'newFromKey' );
	var $oldFileFromRowFactory = array( 'OldSwiftFile', 'newFromRow' );

	function __construct( $info ) {
		// We don't call parent::_construct because it requires $this->directory,
		// which doesn't exist in Swift.
		FileRepo::__construct( $info );

		// Required settings
		$this->url = $info['url'];

		// Optional settings
		$this->hashLevels = isset( $info['hashLevels'] ) ? $info['hashLevels'] : 2;
		$this->deletedHashLevels = isset( $info['deletedHashLevels'] ) ?
			$info['deletedHashLevels'] : $this->hashLevels;

		// This relationship is also hard-coded in rewrite.py, another part of this
		// extension. If you want to change this here, you might have to change it
		// there, too.
		$this->thumbUrl = "{$this->url}/thumb";

		// we don't have directories
		$this->deletedDir = false;

		// Required settings
		$this->swiftuser = $info['user'];
		$this->swiftkey = $info['key'];
		$this->authurl = $info['authurl'];
		$this->container = $info['container'];
	}

	/**
	 * Get a connection to the swift proxy.
	 *
	 * @return CF_Connection
	 */
	function connect() {
		$auth = new CF_Authentication( $this->swiftuser, $this->swiftkey, NULL, $this->authurl );
		try {
			$auth->authenticate();
		} catch ( AuthenticationException $e ) {
			throw new MWException( "We can't authenticate ourselves." );
		# } catch (InvalidResponseException $e) {
		#	throw new MWException( __METHOD__ . "unexpected response '$e'" );
		}
		return new CF_Connection( $auth );
	}

	/**
	 * Given a connection and container name, return the container.
	 * We KNOW the container should exist, so puke if it doesn't.
	 *
	 * @param $conn CF_Connection
	 *
	 * @return CF_Container
	 */
	function get_container( $conn, $cont ) {
		try {
			return $conn->get_container( $cont );
		} catch ( NoSuchContainerException $e ) {
			throw new MWException( "A container we thought existed, doesn't." );
		# } catch (InvalidResponseException $e) {
		#	throw new MWException( __METHOD__ . "unexpected response '$e'" );
		}
	}

	/**
	 * Given a filename, container, and object name, write the file into the object.
	 * None of these error conditions are recoverable by the user, so we just dump
	 * an Internal Error on them.
	 *
	 * @return CF_Container
	 */
	function write_swift_object( $srcPath, $dstc, $dstRel ) {
		try {
			$obj = $dstc->create_object( $dstRel );
			$obj->load_from_filename( $srcPath, True );
		} catch ( SyntaxException $e ) {
			throw new MWException( 'missing required parameters' );
		} catch ( BadContentTypeException $e ) {
			throw new MWException( 'No Content-Type was/could be set' );
		# } catch (InvalidResponseException $e) {
		#	throw new MWException( __METHOD__ . "unexpected response '$e'" );
		} catch ( IOException $e ) {
			throw new MWException( "error opening file '$e'" );
		}
	}

	/**
	 * Given a container and object name, delete the object.
	 * None of these error conditions are recoverable by the user, so we just dump
	 * an Internal Error on them.
	 */
	function swift_delete( $container, $rel ) {
		try {
			$container->delete_object( $rel );
		} catch ( SyntaxException $e ) {
			throw new MWException( "Swift object name not well-formed: '$e'" );
		} catch ( NoSuchObjectException $e ) {
			throw new MWException( "Swift object we are trying to delete does not exist: '$e'" );
		# } catch (InvalidResponseException $e) {
		#	throw new MWException( "unexpected response '$e'" );
		}
	}

	/**
	 * Store a batch of files
	 *
	 * @param $triplets Array: (src,zone,dest) triplets as per store()
	 * @param $flags Integer: bitwise combination of the following flags:
	 *     self::DELETE_SOURCE     Delete the source file after upload
	 *     self::OVERWRITE         Overwrite an existing destination file instead of failing
	 *     self::OVERWRITE_SAME    Overwrite the file if the destination exists and has the
	 *                             same contents as the source
	 * @return $status
	 */
	function storeBatch( $triplets, $flags = 0 ) {
		wfDebug( __METHOD__  . ': Storing ' . count( $triplets ) .
			" triplets; flags: {$flags}\n" );

		$status = $this->newGood();

		// Execute the store operation for each triplet
		$conn = $this->connect();

		foreach ( $triplets as $i => $triplet ) {
			list( $srcPath, $dstZone, $dstRel ) = $triplet;

			wfDebug( __METHOD__  . ": Storing $srcPath into $dstZone::$dstRel\n" );

			// Point to the container.
			$dstContainer = $this->getZoneContainer( $dstZone );
			$dstc = $this->get_container( $conn, $dstContainer );

			$good = true;

			// Where are we copying this from?
			if ( self::isVirtualUrl( $srcPath ) ) {
				$src = $this->getContainerRel( $srcPath );
				list ( $srcContainer, $srcRel ) = $src;
				$srcc = $this->get_container( $conn, $srcContainer );

				// See if we're not supposed to overwrite an existing file.
				if ( !( $flags & self::OVERWRITE ) ) {
					// does it exist?
					try {
						$objd = $dstc->get_object( $dstRel );
						// and if it does, are we allowed to overwrite it?
						if ( $flags & self::OVERWRITE_SAME ) {
							$objs = $srcc->get_object( $srcRel );
							if ( $objd->getETag() != $objs->getETag() ) {
								$status->fatal( 'fileexistserror', $dstRel );
								$good = false;
							}
						} else {
							$status->fatal( 'fileexistserror', $dstRel );
							$good = false;
						}
						$exists = true;
					} catch ( NoSuchObjectException $e ) {
						$exists = false;
					}
				}

				if ( $good ) {
					try {
						$this->swiftcopy( $srcc, $srcRel, $dstc, $dstRel );
					} catch ( InvalidResponseException $e ) {
						$status->error( 'filecopyerror', $srcPath, "{$dstc->name}/$dstRel" );
						$good = false;
					}
					if ( $flags & self::DELETE_SOURCE ) {
						$this->swift_delete( $srcc, $srcRel );
					}
				}
			} else {
				// See if we're not supposed to overwrite an existing file.
				if ( !( $flags & self::OVERWRITE ) ) {
					// does it exist?
					try {
						$objd = $dstc->get_object( $dstRel );
						// and if it does, are we allowed to overwrite it?
						if ( $flags & self::OVERWRITE_SAME ) {
							if ( $objd->getETag() != md5_file( $srcPath ) ) {
								$status->fatal( 'fileexistserror', $dstRel );
								$good = false;
							}
						} else {
							$status->fatal( 'fileexistserror', $dstRel );
							$good = false;
						}
						$exists = true;
					} catch ( NoSuchObjectException $e ) {
						$exists = false;
					}
				}
				if ( $good ) {
					wfDebug( __METHOD__  . ": Writing $srcPath to {$dstc->name}/$dstRel\n" );
					try {
						$this->write_swift_object( $srcPath, $dstc, $dstRel );
					} catch ( InvalidResponseException $e ) {
						$status->error( 'filecopyerror', $srcPath, "{$dstc->name}/$dstRel" );
						$good = false;
					}
					if ( $flags & self::DELETE_SOURCE ) {
						unlink ( $srcPath );
					}
				}
			}
			if ( $good ) {
				$status->successCount++;
			} else {
				$status->failCount++;
			}
			$status->success[$i] = $good;
		}
		return $status;
	}

	/**
	 * Append the contents of the source path to the given file, OR queue
	 * the appending operation in anticipation of a later appendFinish() call.
	 * @param $srcPath String: location of the source file
	 * @param $toAppendPath String: path to append to.
	 * @param $flags Integer: bitfield, may be FileRepo::DELETE_SOURCE to indicate
	 *        that the source file should be deleted if possible
	 * @return mixed Status or false
	 */

	function append( $srcPath, $toAppendPath, $flags = 0 ) {
		// Count the number of files whose names start with $toAppendPath
		$conn = $this->connect();
		$container = $this->repo->get_container( $conn, $this->repo->container . "-temp" );
		$nextone = count( $container->list_objects( 0, NULL, $srcPath ) );

		// Do the append to the next name
		$status = $this->store( $srcPath, 'temp', sprintf( "%s.%05d", $toAppendPath, $nextone ) );

		if ( $flags & self::DELETE_SOURCE ) {
			unlink( $srcPath );
		}

		return $status;
	}
	/**
	 * Finish the append operation.
	 * @param $toAppendPath String: path to append to.
	 */
	function appendFinish( $toAppendPath ) {
		$conn = $this->connect();
		$container = $this->repo->get_container( $conn, $this->repo->container . '-temp' );
		$parts = $container->list_objects( 0, NULL, $toAppendPath );
		// list_objects() returns a sorted list.

		// FIXME probably want to put this into a different container.
		$biggie = $container->create_object( $toAppendPath );
		foreach ( $parts as $part ) {
			$obj = $container->get_object( $part );
			$biggie->write( $obj->read() );
			$obj = $container->delete_object( $part );
		}
		return Status::newGood();
	}

	/**
	 * Move a group of files to the deletion archive.
	 * If no valid deletion archive is configured, this may either delete the
	 * file or throw an exception, depending on the preference of the repository.
	 *
	 * @param $sourceDestPairs Array of source/destination pairs. Each element
	 *        is a two-element array containing the source file path relative to the
	 *        public root in the first element, and the archive file path relative
	 *        to the deleted zone root in the second element.
	 * @return FileRepoStatus
	 */
	function deleteBatch( $sourceDestPairs ) {
		wfDebug(  __METHOD__ . ' deleting ' . var_export( $sourceDestPairs, true ) . '\n' );

		/**
		 * Move the files
		 */
		$triplets = array();
		foreach ( $sourceDestPairs as $pair ) {
			list( $srcRel, $archiveRel ) = $pair;

			$triplets[] = array( "mwrepo://{$this->name}/public/$srcRel", 'deleted', $archiveRel );

		}
		$status = $this->storeBatch( $triplets, FileRepo::OVERWRITE_SAME | FileRepo::DELETE_SOURCE );
		return $status;
	}


	function newFromArchiveName( $title, $archiveName ) {
		return OldSwiftFile::newFromArchiveName( $title, $this, $archiveName );
	}

	/**
	 * Checks existence of specified array of files.
	 *
	 * @param $files Array: URLs of files to check
	 * @param $flags Integer: bitwise combination of the following flags:
	 *     self::FILES_ONLY     Mark file as existing only if it is a file (not directory)
	 * @return Either array of files and existence flags, or false
	 */
	function fileExistsBatch( $files, $flags = 0 ) {
		if ( $flags != self::FILES_ONLY ) {
			// we ONLY support when $flags & self::FILES_ONLY is set!
			throw new MWException( "Swift Media Store doesn't have directories" );
		}
		$result = array();
		$conn = $this->connect();

		foreach ( $files as $key => $file ) {
			if ( !self::isVirtualUrl( $file ) ) {
				throw new MWException( __METHOD__ . " requires a virtual URL, not '$file'" );
			}
			$rvu = $this->getContainerRel( $file );
			list ( $cont, $rel ) = $rvu;
			$container = $this->get_container( $conn, $cont );
			try {
				$obj = $container->get_object( $rel );
				$result[$key] = true;
			} catch ( NoSuchObjectException $e ) {
				$result[$key] = false;
			}
		}

		return $result;
	}

	// FIXME: do we really need to reject empty titles?
	function newFile( $title, $time = false ) {
		if ( empty( $title ) ) {
			return null;
		}
		return parent::newFile( $title, $time );
	}

	/**
	 * Copy a file from one place to another place in the same container
	 * @param $srcContainer CF_Container
	 * @param $srcRel String: relative path to the source file.
	 * @param $dstContainer CF_Container
	 * @param $dstRel String: relative path to the destination.
	 */
	protected function swiftcopy( $srcContainer, $srcRel, $dstContainer, $dstRel ) {
		// The destination must exist already.
		$obj = $dstContainer->create_object( $dstRel );
		$obj->content_type = 'text/plain';

		try {
			$obj->write( '.' );
		} catch ( SyntaxException $e ) {
			throw new MWException( "Write failed: $e" );
		} catch ( BadContentTypeException $e ) {
			throw new MWException( "Missing Content-Type: $e" );
		} catch ( MisMatchedChecksumException $e ) {
			throw new MWException( __METHOD__ . "should not happen: '$e'" );
		}

		try {
			$obj = $dstContainer->get_object( $dstRel );
		} catch ( NoSuchObjectException $e ) {
			throw new MWException( 'The object we just created does not exist: ' . $dstContainer->name . "/$dstRel: $e" );
		}

		try {
			$srcObj = $srcContainer->get_object( $srcRel );
		} catch ( NoSuchObjectException $e ) {
			throw new MWException( 'Source file does not exist: ' . $srcContainer->name . "/$srcRel: $e" );
		}

		wfDebug( __METHOD__ . ' copying to ' . $dstContainer->name . "/$dstRel from " . $srcContainer->name . "/$srcRel\n" );

		try {
			$dstContainer->copy_object_from( $srcObj, $srcContainer, $dstRel );
		} catch ( SyntaxException $e ) {
			throw new MWException( 'Source file does not exist: ' . $srcContainer->name . "/$srcRel: $e" );
		} catch ( MisMatchedChecksumException $e ) {
			throw new MWException( "Checksums do not match: $e" );
		}
	}

	/**
	 * Publish a batch of files
	 * @param $triplets Array: (source,dest,archive) triplets as per publish()
	 * @param $flags Integer: bitfield, may be FileRepo::DELETE_SOURCE to indicate
	 *        that the source files should be deleted if possible
	 */
	function publishBatch( $triplets, $flags = 0 ) {

		# paranoia
		$status = $this->newGood( array() );
		foreach ( $triplets as $triplet ) {
			list( $srcPath, $dstRel, $archiveRel ) = $triplet;

			if ( !$this->validateFilename( $dstRel ) ) {
				throw new MWException( "Validation error in $dstRel" );
			}
			if ( !$this->validateFilename( $archiveRel ) ) {
				throw new MWException( "Validation error in $archiveRel" );
			}
		}

		if ( !$status->ok ) {
			return $status;
		}

		try {
			$conn = $this->connect();
			$container = $this->get_container( $conn, $this->container );
		} catch ( InvalidResponseException $e ) {
			$status->fatal( "Unexpected Swift response: '$e'" );
		}

		if ( !$status->ok ) {
			return $status;
		}

		foreach ( $triplets as $i => $triplet ) {
			list( $srcPath, $dstRel, $archiveRel ) = $triplet;

			// Archive destination file if it exists
			try {
				$pic = $container->get_object( $dstRel );
			} catch ( InvalidResponseException $e ) {
				$status->error( "Unexpected Swift response: '$e'" );
				$status->failCount++;
				continue;
			} catch ( NoSuchObjectException $e ) {
				$pic = NULL;
			}

			if ( $pic ) {
				$this->swiftcopy( $container, $dstRel, $container, $archiveRel );
				wfDebug( __METHOD__ . ": moved file $dstRel to $archiveRel\n" );
				$status->value[$i] = 'archived';
			} else {
				$status->value[$i] = 'new';
			}

			$good = true;
			try {
				// Where are we copying this from?
				if ( self::isVirtualUrl( $srcPath ) ) {
					$src = $this->getContainerRel( $srcPath );
					list ( $srcContainer, $srcRel ) = $src;
					$srcc = $this->get_container( $conn, $srcContainer );

					$this->swiftcopy( $srcc, $srcRel, $container, $dstRel );
					if ( $flags & self::DELETE_SOURCE ) {
						$this->swift_delete( $srcc, $srcRel );
					}
				} else {
					$this->write_swift_object( $srcPath, $container, $dstRel );
					// php-cloudfiles throws exceptions, so failure never gets here.
					if ( $flags & self::DELETE_SOURCE ) {
						unlink ( $srcPath );
					}
				}
			} catch ( InvalidResponseException $e ) {
				$status->error( "Unexpected Swift response: '$e'" );
				$good = false;
			}

			if ( $good ) {
				$status->successCount++;
				wfDebug( __METHOD__ . ": wrote tempfile $srcPath to $dstRel\n" );
			} else {
				$status->failCount++;
			}
		}
		return $status;
	}

	/**
	 * Deletes a batch of files. Each file can be a (zone, rel) pairs, a
	 * virtual url or a real path. It will try to delete each file, but
	 * ignores any errors that may occur
	 *
	 * @param $pairs array List of files to delete
	 */
	function cleanupBatch( $files ) {
		$conn = $this->connect();
		foreach ( $files as $file ) {
			if ( is_array( $file ) ) {
				// This is a pair, extract it
				list( $cont, $rel ) = $file;
			} else {
				if ( self::isVirtualUrl( $file ) ) {
					// This is a virtual url, resolve it
					$path = $this->getContainerRel( $file );
					list( $cont, $rel ) = $path;
				} else {
					// FIXME: This is a full file name
					throw new MWException( __METHOD__ . ": $file needs an unlink()" );
				}
			}

			wfDebug( __METHOD__ . ": $cont/$rel\n" );
			$container = $this->get_container( $conn, $cont );
			$this->swift_delete( $container, $rel );
		}
	}

	/**
	 * Delete files in the deleted directory if they are not referenced in the
	 * filearchive table. This needs to be done in the repo because it needs to
	 * interleave database locks with file operations, which is potentially a
	 * remote operation.
	 * @return FileRepoStatus
	 */
	function cleanupDeletedBatch( $storageKeys ) {
		$conn = $this->connect();
		$cont = $this->getZoneContainer( 'deleted' );
		$container = $this->get_container( $conn, $cont );

		$dbw = $this->getMasterDB();
		$status = $this->newGood();
		$storageKeys = array_unique( $storageKeys );
		foreach ( $storageKeys as $key ) {
			$hashPath = $this->getDeletedHashPath( $key );
			$rel = "$hashPath$key";
			$dbw->begin();
			$inuse = $dbw->selectField( 'filearchive', '1',
				array( 'fa_storage_group' => 'deleted', 'fa_storage_key' => $key ),
				__METHOD__, array( 'FOR UPDATE' ) );
			if ( !$inuse ) {
				$sha1 = self::getHashFromKey( $key );
				$ext = substr( $key, strcspn( $key, '.' ) + 1 );
				$ext = File::normalizeExtension( $ext );
				$inuse = $dbw->selectField( 'oldimage', '1',
					array( 'oi_sha1' => $sha1,
						'oi_archive_name ' . $dbw->buildLike( $dbw->anyString(), ".$ext" ),
						$dbw->bitAnd( 'oi_deleted', File::DELETED_FILE ) => File::DELETED_FILE ),
					__METHOD__, array( 'FOR UPDATE' ) );
			}
			if ( !$inuse ) {
				wfDebug( __METHOD__ . ": deleting $key\n" );
				$this->swift_delete( $container, $rel );
			} else {
				wfDebug( __METHOD__ . ": $key still in use\n" );
				$status->successCount++;
			}
			$dbw->commit();
		}
		return $status;
	}

	/**
	 * Makes no sense in our context -- don't let anybody call it.
	 */
	function getZonePath( $zone ) {
		throw new MWException( __METHOD__ . ': not implemented' );
	}

	/**
	 * Get the Swift container corresponding to one of the three basic zones
	 */
	public function getZoneContainer( $zone ) {
		switch ( $zone ) {
			case 'public':
				return $this->container;
			case 'temp':
				return $this->container . '-temp';
			case 'deleted':
				return $this->container . '-deleted';
			case 'thumb':
				return $this->container . '-thumb';
			default:
				return false;
		}
	}

	/**
	 * Get a local path corresponding to a virtual URL
	 */
	protected function getContainerRel( $url ) {
		if ( substr( $url, 0, 9 ) != 'mwrepo://' ) {
			throw new MWException( __METHOD__ . ': unknown protocol' );
		}

		$bits = explode( '/', substr( $url, 9 ), 3 );
		if ( count( $bits ) != 3 ) {
			throw new MWException( __METHOD__ . ": invalid mwrepo URL: $url" );
		}
		list( $repo, $zone, $rel ) = $bits;
		if ( $repo !== $this->name ) {
			throw new MWException( __METHOD__ . ': fetching from a foreign repo is not supported' );
		}
		$container = $this->getZoneContainer( $zone );
		if ( $container === false ) {
			throw new MWException( __METHOD__ . ": invalid zone: $zone" );
		}
		return array( $container, rawurldecode( $rel ) );
	}

	/**
	 * Remove a temporary file or mark it for garbage collection
	 * @param $virtualUrl String: the virtual URL returned by storeTemp
	 * @return Boolean: true on success, false on failure
	 */
	function freeTemp( $virtualUrl ) {
		$temp = "mwrepo://{$this->name}/temp";
		if ( substr( $virtualUrl, 0, strlen( $temp ) ) != $temp ) {
			wfDebug( __METHOD__ . ": Invalid virtual URL\n" );
			return false;
		}
		$path = $this->getContainerRel( $virtualUrl );
		list ( $c, $r ) = $path;
		$conn = $this->connect();
		$container = $this->get_container( $conn, $c );
		$this->swift_delete( $container, $r );
	}

	/**
	 * Called from elsewhere to turn a virtual URL into a path.
	 * Make sure you delete this file after you've used it!!
	 */
	function resolveVirtualUrl( $url ) {
		$path = $this->getContainerRel( $url );
		list( $c, $r ) = $path;
		return $this->getLocalCopy( $c, $r );
	}


	/**
	 * Given a container and relative path, return an absolute path pointing at a
	 * copy of the file MUST delete the produced file, or else store it in
	 * SwiftFile->tempPath so it will be deleted when the object goes out of
	 * scope.
	 */
	function getLocalCopy( $container, $rel, $prefix = 'swift_in_' ) {

		// get a temporary place to put the original.
		$tempPath = tempnam( wfTempDir(), $prefix );
		unlink( $tempPath );
		$tempPath .= '.' . pathinfo( $rel, PATHINFO_EXTENSION );

		/* Fetch the image out of Swift */
		$conn = $this->connect();
		$cont = $this->get_container( $conn, $container );

		try {
			$obj = $cont->get_object( $rel );
		} catch ( NoSuchObjectException $e ) {
			throw new MWException( "Unable to open original file at $container/$rel" );
		}

		wfDebug(  __METHOD__ . " writing to $tempPath\n" );
		try {
			$obj->save_to_filename( $tempPath );
		} catch ( IOException $e ) {
			throw new MWException( __METHOD__ . ": error opening '$e'" );
		} catch ( InvalidResponseException $e ) {
			throw new MWException( __METHOD__ . "unexpected response '$e'" );
		}

		return $tempPath;
	}


	/**
	 * Get properties of a file with a given virtual URL
	 * The virtual URL must refer to this repo
	 */
	function getFileProps( $virtualUrl ) {
		$path = $this->resolveVirtualUrl( $virtualUrl );
		$ret = File::getPropsFromPath( $path );
		unlink( $path );
		return $ret;
	}


	/**
	 * Get an UploadStash associated with this repo.
	 *
	 * @return UploadStash
	 */
	function getUploadStash() {
		return new SwiftStash( $this );
	}
}

class SwiftStash extends UploadStash {
	/**
	 * Wrapper function for subclassing.
	 */
	protected function newFile(  $path, $key, $data ) {
		wfDebug( __METHOD__ . ": deleting $key\n" );
		return new SwiftStashFile( $this, $this->repo, $path, $key, $data );
	}

}

class SwiftStashFile extends UploadStashFile {
	// public function __construct( $stash, $repo, $path, $key, $data ) {
	//	// We don't call parent:: because UploadStashFile expects to be able to call $this->resolveURL() and get a pathname.
	//	$this->sessionStash = $stash;
	//	$this->sessionKey = $key;
	//	$this->sessionData = $data;
	//	wfDebug( __METHOD__ . ": ($stash, $repo, $path, $key, $data)\n" );

	//	UnregisteredLocalFile::__construct( false, $repo, $path, false );
	//	$this->name = basename( $this->path );

	// }

	// function getPath() {
	// }
}

/**
 * Old file in the in the oldimage table
 *
 * @file
 * @ingroup FileRepo
 */

/**
 * Class to represent a file in the oldimage table
 *
 * @ingroup FileRepo
 */
class OldSwiftFile extends SwiftFile {
	var $requestedTime, $archive_name;

	const CACHE_VERSION = 1;
	const MAX_CACHE_ROWS = 20;

	static function newFromTitle( $title, $repo, $time = null ) {
		# The null default value is only here to avoid an E_STRICT
		if ( $time === null )
			throw new MWException( __METHOD__ . ' got null for $time parameter' );
		return new self( $title, $repo, $time, null );
	}

	static function newFromArchiveName( $title, $repo, $archiveName ) {
		return new self( $title, $repo, null, $archiveName );
	}

	static function newFromRow( $row, $repo ) {
		$title = Title::makeTitle( NS_FILE, $row->oi_name );
		$file = new self( $title, $repo, null, $row->oi_archive_name );
		$file->loadFromRow( $row, 'oi_' );
		return $file;
	}

	/**
	 * @static
	 * @param  $sha1
	 * @param $repo LocalRepo
	 * @param bool $timestamp
	 * @return bool|OldLocalFile
	 */
	static function newFromKey( $sha1, $repo, $timestamp = false ) {
		$conds = array( 'oi_sha1' => $sha1 );
		if ( $timestamp ) {
			$conds['oi_timestamp'] = $timestamp;
		}
		$dbr = $repo->getSlaveDB();
		$row = $dbr->selectRow( 'oldimage', self::selectFields(), $conds, __METHOD__ );
		if ( $row ) {
			return self::newFromRow( $row, $repo );
		} else {
			return false;
		}
	}

	/**
	 * Fields in the oldimage table
	 */
	static function selectFields() {
		return array(
			'oi_name',
			'oi_archive_name',
			'oi_size',
			'oi_width',
			'oi_height',
			'oi_metadata',
			'oi_bits',
			'oi_media_type',
			'oi_major_mime',
			'oi_minor_mime',
			'oi_description',
			'oi_user',
			'oi_user_text',
			'oi_timestamp',
			'oi_deleted',
			'oi_sha1',
		);
	}

	/**
	 * @param $title Title
	 * @param $repo FileRepo
	 * @param $time String: timestamp or null to load by archive name
	 * @param $archiveName String: archive name or null to load by timestamp
	 */
	function __construct( $title, $repo, $time, $archiveName ) {
		parent::__construct( $title, $repo );
		$this->requestedTime = $time;
		$this->archive_name = $archiveName;
		if ( is_null( $time ) && is_null( $archiveName ) ) {
			throw new MWException( __METHOD__ . ': must specify at least one of $time or $archiveName' );
		}
	}

	function getCacheKey() {
		return false;
	}

	function getArchiveName() {
		if ( !isset( $this->archive_name ) ) {
			$this->load();
		}
		return $this->archive_name;
	}

	function isOld() {
		return true;
	}

	function isVisible() {
		return $this->exists() && !$this->isDeleted( File::DELETED_FILE );
	}

	function loadFromDB() {
		wfProfileIn( __METHOD__ );
		$this->dataLoaded = true;
		$dbr = $this->repo->getSlaveDB();
		$conds = array( 'oi_name' => $this->getName() );
		if ( is_null( $this->requestedTime ) ) {
			$conds['oi_archive_name'] = $this->archive_name;
		} else {
			$conds[] = 'oi_timestamp = ' . $dbr->addQuotes( $dbr->timestamp( $this->requestedTime ) );
		}
		$row = $dbr->selectRow( 'oldimage', $this->getCacheFields( 'oi_' ),
			$conds, __METHOD__, array( 'ORDER BY' => 'oi_timestamp DESC' ) );
		if ( $row ) {
			$this->loadFromRow( $row, 'oi_' );
		} else {
			$this->fileExists = false;
		}
		wfProfileOut( __METHOD__ );
	}

	function getCacheFields( $prefix = 'img_' ) {
		$fields = parent::getCacheFields( $prefix );
		$fields[] = $prefix . 'archive_name';
		$fields[] = $prefix . 'deleted';
		return $fields;
	}

	function getRel() {
		return 'archive/' . $this->getHashPath() . $this->getArchiveName();
	}

	function getUrlRel() {
		return 'archive/' . $this->getHashPath() . rawurlencode( $this->getArchiveName() );
	}

	function upgradeRow() {
		wfProfileIn( __METHOD__ );
		$this->loadFromFile();

		# Don't destroy file info of missing files
		if ( !$this->fileExists ) {
			wfDebug( __METHOD__ . ': file does not exist, aborting\n' );
			wfProfileOut( __METHOD__ );
			return;
		}

		$dbw = $this->repo->getMasterDB();
		list( $major, $minor ) = self::splitMime( $this->mime );

		wfDebug( __METHOD__ . ': upgrading ' . $this->archive_name . ' to the current schema\n' );
		$dbw->update( 'oldimage',
			array(
				'oi_width' => $this->width,
				'oi_height' => $this->height,
				'oi_bits' => $this->bits,
				'oi_media_type' => $this->media_type,
				'oi_major_mime' => $major,
				'oi_minor_mime' => $minor,
				'oi_metadata' => $this->metadata,
				'oi_sha1' => $this->sha1,
			), array(
				'oi_name' => $this->getName(),
				'oi_archive_name' => $this->archive_name ),
			__METHOD__
		);
		wfProfileOut( __METHOD__ );
	}

	/**
	 * @param $field Integer: one of DELETED_* bitfield constants
	 *               for file or revision rows
	 * @return bool
	 */
	function isDeleted( $field ) {
		$this->load();
		return ( $this->deleted & $field ) == $field;
	}

	/**
	 * Returns bitfield value
	 * @return int
	 */
	function getVisibility() {
		$this->load();
		return (int)$this->deleted;
	}

	/**
	 * Determine if the current user is allowed to view a particular
	 * field of this image file, if it's marked as deleted.
	 *
	 * @param $field Integer
	 * @return bool
	 */
	function userCan( $field ) {
		$this->load();
		return Revision::userCanBitfield( $this->deleted, $field );
	}
}

/**
 * Foreign file with an accessible MediaWiki database
 *
 * @ingroup FileRepo
 */
class SwiftForeignDBFile extends SwiftFile {

	/**
	 * @param $title
	 * @param $repo
	 * @param $unused
	 * @return SwiftForeignDBFile
	 */
	static function newFromTitle( $title, $repo, $unused = null ) {
		return new self( $title, $repo );
	}

	/**
	 * Create a ForeignDBFile from a title
	 * Do not call this except from inside a repo class.
	 */
	static function newFromRow( $row, $repo ) {
		$title = Title::makeTitle( NS_FILE, $row->img_name );
		$file = new self( $title, $repo );
		$file->loadFromRow( $row );
		return $file;
	}

	function publish( $srcPath, $flags = 0 ) {
		$this->readOnlyError();
	}

	function recordUpload( $oldver, $desc, $license = '', $copyStatus = '', $source = '',
		$watch = false, $timestamp = false ) {
		$this->readOnlyError();
	}

	function restore( $versions = array(), $unsuppress = false ) {
		$this->readOnlyError();
	}

	function delete( $reason, $suppress = false ) {
		$this->readOnlyError();
	}

	function move( $target ) {
		$this->readOnlyError();
	}

	function getDescriptionUrl() {
		// Restore remote behaviour
		return File::getDescriptionUrl();
	}

	function getDescriptionText() {
		// Restore remote behaviour
		return File::getDescriptionText();
	}
}

/**
 * A foreign repository with an accessible MediaWiki database
 *
 * @ingroup FileRepo
 */
class SwiftForeignDBRepo extends SwiftRepo {
	# Settings
	var $dbType, $dbServer, $dbUser, $dbPassword, $dbName, $dbFlags,
		$tablePrefix, $hasSharedCache;

	# Other stuff
	var $dbConn;
	var $fileFactory = array( 'SwiftForeignDBFile', 'newFromTitle' );
	var $fileFromRowFactory = array( 'SwiftForeignDBFile', 'newFromRow' );

	function __construct( $info ) {
		parent::__construct( $info );
		$this->dbType = $info['dbType'];
		$this->dbServer = $info['dbServer'];
		$this->dbUser = $info['dbUser'];
		$this->dbPassword = $info['dbPassword'];
		$this->dbName = $info['dbName'];
		$this->dbFlags = $info['dbFlags'];
		$this->tablePrefix = $info['tablePrefix'];
		$this->hasSharedCache = $info['hasSharedCache'];
	}

	/**
	 * @return DatabaseBase
	 */
	function getMasterDB() {
		wfDebug( __METHOD__ . ": {$this->dbServer}\n" );
		if ( !isset( $this->dbConn ) ) {
			$this->dbConn = DatabaseBase::factory( $this->dbType,
				array(
					'host' => $this->dbServer,
					'user'   => $this->dbUser,
					'password' => $this->dbPassword,
					'dbname' => $this->dbName,
					'flags' => $this->dbFlags,
					'tablePrefix' => $this->tablePrefix
				)
			);
		}
		return $this->dbConn;
	}

	/**
	 * @return DatabaseBase
	 */
	function getSlaveDB() {
		return $this->getMasterDB();
	}

	function hasSharedCache() {
		return $this->hasSharedCache;
	}

	/**
	 * Get a key on the primary cache for this repository.
	 * Returns false if the repository's cache is not accessible at this site.
	 * The parameters are the parts of the key, as for wfMemcKey().
	 */
	function getSharedCacheKey( /*...*/ ) {
		if ( $this->hasSharedCache() ) {
			$args = func_get_args();
			array_unshift( $args, $this->dbName, $this->tablePrefix );
			return call_user_func_array( 'wfForeignMemcKey', $args );
		} else {
			return false;
		}
	}

	function store( $srcPath, $dstZone, $dstRel, $flags = 0 ) {
		throw new MWException( get_class( $this ) . ': write operations are not supported' );
	}

	function publish( $srcPath, $dstRel, $archiveRel, $flags = 0 ) {
		throw new MWException( get_class( $this ) . ': write operations are not supported' );
	}

	function deleteBatch( $sourceDestPairs ) {
		throw new MWException( get_class( $this ) . ': write operations are not supported' );
	}
}

/**
 * A foreign repository with a MediaWiki database accessible via the configured LBFactory
 *
 * @file
 * @ingroup FileRepo
 */

/**
 * A foreign repository with a MediaWiki database accessible via the configured LBFactory
 *
 * @ingroup FileRepo
 */
class SwiftForeignDBViaLBRepo extends SwiftRepo {
	var $wiki, $dbName, $tablePrefix;
	var $fileFactory = array( 'SwiftForeignDBFile', 'newFromTitle' );
	var $fileFromRowFactory = array( 'SwiftForeignDBFile', 'newFromRow' );

	function __construct( $info ) {
		parent::__construct( $info );
		$this->wiki = $info['wiki'];
		list( $this->dbName, $this->tablePrefix ) = wfSplitWikiID( $this->wiki );
		$this->hasSharedCache = $info['hasSharedCache'];
	}

	/**
	 * @return DatabaseBase
	 */
	function getMasterDB() {
		return wfGetDB( DB_MASTER, array(), $this->wiki );
	}

	/**
	 * @return DatabaseBase
	 */
	function getSlaveDB() {
		return wfGetDB( DB_SLAVE, array(), $this->wiki );
	}

	/**
	 * @return bool
	 */
	function hasSharedCache() {
		return $this->hasSharedCache;
	}

	/**
	 * Get a key on the primary cache for this repository.
	 * Returns false if the repository's cache is not accessible at this site.
	 * The parameters are the parts of the key, as for wfMemcKey().
	 */
	function getSharedCacheKey( /*...*/ ) {
		if ( $this->hasSharedCache() ) {
			$args = func_get_args();
			array_unshift( $args, $this->wiki );
			return implode( ':', $args );
		} else {
			return false;
		}
	}

	function store( $srcPath, $dstZone, $dstRel, $flags = 0 ) {
		throw new MWException( get_class( $this ) . ': write operations are not supported' );
	}

	function publish( $srcPath, $dstRel, $archiveRel, $flags = 0 ) {
		throw new MWException( get_class( $this ) . ': write operations are not supported' );
	}

	function deleteBatch( $fileMap ) {
		throw new MWException( get_class( $this ) . ': write operations are not supported' );
	}
}
