<?php

/**
 * Class definitions for NSFileRepo
 */

class NSLocalRepo extends LocalRepo {
	var $fileFactory = array( 'NSLocalFile', 'newFromTitle' );
	var $oldFileFactory = array( 'NSOldLocalFile', 'newFromTitle' );
	var $fileFromRowFactory = array( 'NSLocalFile', 'newFromRow' );
	var $oldFileFromRowFactory = array( 'NSOldLocalFile', 'newFromRow' );

	static function getHashPathForLevel( $name, $levels ) {
		global $wgContLang;
		$bits = explode( ':',$name );
		$filename = $bits[ count( $bits ) - 1 ];
		$path = parent::getHashPathForLevel( $filename, $levels );
		return count( $bits ) > 1 ?
			$wgContLang->getNsIndex( $bits[0] ) .'/'. $path : $path;
	}

	/**
	 * Get a relative path including trailing slash, e.g. f/fa/
	 * If the repo is not hashed, returns an empty string
	 * This is needed because self:: will call parent if not included - exact same as in FSRepo
	 */
	function getHashPath( $name ) {
		return self::getHashPathForLevel( $name, $this->hashLevels );
	}

	/**
	 * Pick a random name in the temp zone and store a file to it.
	 * @param string $originalName The base name of the file as specified
	 *     by the user. The file extension will be maintained.
	 * @param string $srcPath The current location of the file.
	 * @return FileRepoStatus object with the URL in the value.
	 */
	function storeTemp( $originalName, $srcPath ) {
		$date = gmdate( "YmdHis" );
		$hashPath = $this->getHashPath( $originalName );
		$filename = $this->getFileNameStripped( $originalName );
		$dstRel = "$hashPath$date!$filename";
		$dstUrlRel = $hashPath . $date . '!' . rawurlencode( $filename );
		$result = $this->store( $srcPath, 'temp', $dstRel );
		$result->value = $this->getVirtualUrl( 'temp' ) . '/' . $dstUrlRel;
		return $result;
	}

	function getFileNameStripped($suffix) {
		return(NSLocalFile::getFileNameStripped($suffix));
	}
}

class NSLocalFile extends LocalFile {
	/**
	 * Get the path of the file relative to the public zone root
	 */
	function getRel() {
		return $this->getHashPath() . $this->getFileNameStripped( $this->getName() );
	}

	/**
	 * Get urlencoded relative path of the file
	 */
	function getUrlRel() {
		return $this->getHashPath() . 
			rawurlencode( $this->getFileNameStripped( $this->getName() ) );
	}

	/** Get the URL of the thumbnail directory, or a particular file if $suffix is specified */
	function getThumbUrl( $suffix = false ) {
		$path = $this->repo->getZoneUrl('thumb') . '/' . $this->getUrlRel();
		if ( $suffix !== false ) {
			$path .= '/' . rawurlencode( $this->getFileNameStripped( $suffix ) );
		}
		return $path;
	}


	/** Return the file name of a thumbnail with the specified parameters */
	function thumbName( $params ) {
		if ( !$this->getHandler() ) {
			return null;
		}
		$extension = $this->getExtension();
		list( $thumbExt, $thumbMime ) = $this->handler->getThumbType( $extension, $this->getMimeType() );
/* This is the part that changed from LocalFile */
		$thumbName = $this->handler->makeParamString( $params ) . '-' . $this->getFileNameStripped( $this->getName() );
/* End of changes */
		if ( $thumbExt != $extension ) {
			$thumbName .= ".$thumbExt";
		}
		$bits = explode( ':',$this->getName() );
		if ( count($bits) > 1 ) $thumbName = $bits[0] . ":" . $thumbName;
		return $thumbName;
	}


	/** Get the path of the thumbnail directory, or a particular file if $suffix is specified */
	function getThumbPath( $suffix = false ) {
		$path = $this->repo->getZonePath('thumb') . '/' . $this->getRel();
		if ( $suffix !== false ) {
			$path .= '/' . $this->getFileNameStripped( $suffix );
		}
		return $path;
	}

	/** Get the relative path for an archive file */
	function getArchiveRel( $suffix = false ) {
		$path = 'archive/' . $this->getHashPath();
		if ( $suffix === false ) {
			$path = substr( $path, 0, -1 );
		} else {
			$path .= $this->getFileNameStripped( $suffix );
		}
		return $path;
	}

	/** Get the URL of the archive directory, or a particular file if $suffix is specified */
	function getArchiveUrl( $suffix = false ) {
		$path = $this->repo->getZoneUrl( 'public' ) . '/archive/' . $this->getHashPath();
		if ( $suffix === false ) {
			$path = substr( $path, 0, -1 );
		} else {
			$path .= rawurlencode( $this->getFileNameStripped( $suffix ) );
		}
		return $path;
	}

	/** Get the virtual URL for an archive file or directory */
	function getArchiveVirtualUrl( $suffix = false ) {
		$path = $this->repo->getVirtualUrl() . '/public/archive/' . $this->getHashPath();
		if ( $suffix === false ) {
			$path = substr( $path, 0, -1 );
		} else {
			$path .= rawurlencode( $this->getFileNameStripped( $suffix ) );
		}
		return $path;
	}

	/** Get the virtual URL for a thumbnail file or directory */
	function getThumbVirtualUrl( $suffix = false ) {
		$path = $this->repo->getVirtualUrl() . '/thumb/' . $this->getUrlRel();
		if ( $suffix !== false ) {
			$path .= '/' . rawurlencode( $this->getFileNameStripped( $suffix ) );
		}
		return $path;
	}

	/** Get the virtual URL for the file itself */
	function getVirtualUrl( $suffix = false ) {
		$path = $this->repo->getVirtualUrl() . '/public/' . $this->getUrlRel();
		if ( $suffix !== false ) {
			$path .= '/' . rawurlencode( $this->getFileNameStripped( $suffix ) );
		}
		return $path;
	}

	/** Strip namespace (if any) from file name */
	function getFileNameStripped($suffix) {
		$bits = explode( ':', $suffix );
		return $bits[ count( $bits ) -1 ];
	}

	/**
	 * This function overrides the LocalFile because the archive name should not contain the namespace in the
	 * filename.  Otherwise the function would have worked.  This only affects reuploads
	 *
	 * Move or copy a file to its public location. Returns a FileRepoStatus object.
	 * On success, the value contains "new" or "archived", to indicate whether the file was new with that name.
	 *
	 * The archive name should be passed through to recordUpload for database
	 * registration.
	 *
	 * @param string $sourcePath Local filesystem path to the source image
	 * @param integer $flags A bitwise combination of:
	 *     File::DELETE_SOURCE    Delete the source file, i.e. move
	 *         rather than copy
	 * @return FileRepoStatus object. On success, the value member contains the
	 *     archive name, or an empty string if it was a new file.
	 */
	function publish( $srcPath, $flags = 0 ) {
		$this->lock();
		$dstRel = $this->getRel();
		/* This is the part that changed from LocalFile */
		$archiveName = gmdate( 'YmdHis' ) . '!' .
			$this->getFileNameStripped( $this->getName() );
		/* End of changes */
		$archiveRel = 'archive/' . $this->getHashPath() . $archiveName;
		$flags = $flags & File::DELETE_SOURCE ? LocalRepo::DELETE_SOURCE : 0;
		$status = $this->repo->publish( $srcPath, $dstRel, $archiveRel, $flags );
		if ( $status->value == 'new' ) {
			$status->value = '';
		} else {
			$status->value = $archiveName;
		}
		$this->unlock();
		return $status;
	}

	/**
	 * The only thing changed here is that the array needs to strip the NS from the file name for the has (oldname is already fixed)
	 * Add the old versions of the image to the batch
	 */
	function addOlds() {
		$archiveBase = 'archive';
		$this->olds = array();
		$this->oldCount = 0;

		$result = $this->db->select( 'oldimage',
			array( 'oi_archive_name', 'oi_deleted' ),
			array( 'oi_name' => $this->oldName ),
			__METHOD__
		);
		foreach( $result as $row ) {
			$oldName = $row->oi_archive_name;
			$bits = explode( '!', $oldName, 2 );
			if( count( $bits ) != 2 ) {
				wfDebug( "Invalid old file name: $oldName \n" );
				continue;
			}
			list( $timestamp, $filename ) = $bits;
			if( $this->oldName != $filename ) {
				wfDebug( "Invalid old file name: $oldName \n" );
				continue;
			}
			$this->oldCount++;
			// Do we want to add those to oldCount?
			if( $row->oi_deleted & File::DELETED_FILE ) {
				continue;
			}
			$this->olds[] = array(
				"{$archiveBase}/{$this->oldHash}{$oldName}",
				/* This is the part that changed from LocalFile */
				"{$archiveBase}/{$this->newHash}{$timestamp}!" .
					$this->getFileNameStripped( $this->newName )
				/* End of changes */
			);
		}
		$this->db->freeResult( $result );
	}

	/**
	 * The only thing changed here is to strip NS from the file name
	 * Delete cached transformed files
	*/
	function purgeThumbnails( $options = array() ) {
		global $wgUseSquid;
		// Delete thumbnails
		$files = $this->getThumbnails();
		$dir = $this->getThumbPath();
		$urls = array();
		foreach ( $files as $file ) {
			# Check that the base file name is part of the thumb name
			# This is a basic sanity check to avoid erasing unrelated directories

			/* This is the part that changed from LocalFile */
			if ( strpos( $file, $this->getFileNameStripped($this->getName()) ) !== false ) {
			/* End of changes */
				$url = $this->getThumbUrl( $file );
				$urls[] = $url;
				wfSuppressWarnings();
				unlink( "$dir/$file" );
				wfRestoreWarnings();
			}
		}

		// Purge the squid
		if ( $wgUseSquid ) {
			SquidUpdate::purge( $urls );
		}
	}

	/**
	 * Replaces hard coded OldLocalFile::newFromRow to use $this->repo->oldFileFromRowFactory configuration
	 * This may not be necessary in the future if LocalFile is patched to allow configuration
	*/

	function getHistory( $limit = null, $start = null, $end = null, $inc = true ) {
		$dbr = $this->repo->getSlaveDB();
		$tables = array( 'oldimage' );
		$fields = OldLocalFile::selectFields();
		$conds = $opts = $join_conds = array();
		$eq = $inc ? '=' : '';
		$conds[] = "oi_name = " . $dbr->addQuotes( $this->title->getDBkey() );
		if( $start ) {
			$conds[] = "oi_timestamp <$eq " . $dbr->addQuotes( $dbr->timestamp( $start ) );
		}
		if( $end ) {
			$conds[] = "oi_timestamp >$eq " . $dbr->addQuotes( $dbr->timestamp( $end ) );
		}
		if( $limit ) {
			$opts['LIMIT'] = $limit;
		}
		// Search backwards for time > x queries
		$order = ( !$start && $end !== null ) ? 'ASC' : 'DESC';
		$opts['ORDER BY'] = "oi_timestamp $order";
		$opts['USE INDEX'] = array( 'oldimage' => 'oi_name_timestamp' );

		wfRunHooks( 'LocalFile::getHistory', array( &$this, &$tables, &$fields,
			&$conds, &$opts, &$join_conds ) );

		$res = $dbr->select( $tables, $fields, $conds, __METHOD__, $opts, $join_conds );
		$r = array();
		foreach( $res as $row ) {
		/* This is the part that changed from LocalFile */
			if ( $this->repo->oldFileFromRowFactory ) {
				$r[] = call_user_func( $this->repo->oldFileFromRowFactory, $row, $this->repo );
			} else {
				$r[] = OldLocalFile::newFromRow( $row, $this->repo );
			}
		/* End of changes */
		}
		if( $order == 'ASC' ) {
			$r = array_reverse( $r ); // make sure it ends up descending
		}
		return $r;
	}



	/** Instantiating this class using "self"
	 * If you're reading this, you're problably wondering why on earth are the following static functions, which are copied
	 * verbatim from the original extended class "LocalFIle" included here?
	 * The answer is that "self", will instantiate the class the code is physically in, not the class extended from it.
	 * Without the inclusion of these methods in "NSLocalFile, "self" would instantiate a "LocalFile" class, not the
	 * "NSLocalFile" class we want it to.  Since there are only two methods within the "LocalFile" class that use "self",
	 * I just copied that code into the new "NSLocalFile" extended class, and the copied code will instantiate the "NSLocalFIle"
	 * class instead of the "LocalFile" class (at least in PHP 5.2.4)
	 */

	/**
	 * Create a NSLocalFile from a title
	 * Do not call this except from inside a repo class.
	 *
	 * Note: $unused param is only here to avoid an E_STRICT
	 */
	static function newFromTitle( $title, $repo, $unused = null ) {
		return new self( $title, $repo );
	}
	/**
	 * Create a NSLocalFile from a title
	 * Do not call this except from inside a repo class.
	 */

	static function newFromRow( $row, $repo ) {
		$title = Title::makeTitle( NS_FILE, $row->img_name );
		$file = new self( $title, $repo );
		$file->loadFromRow( $row );
		return $file;
	}
}

class NSOldLocalFile extends OldLocalFile {

	function getRel() {
		return 'archive/' . $this->getHashPath() . 
			$this->getFileNameStripped( $this->getArchiveName() );
	}
	function getUrlRel() {
		return 'archive/' . $this->getHashPath() . 
			urlencode( $this->getFileNameStripped( $this->getArchiveName() ) );
	}
	function publish( $srcPath, $flags = 0 ) {
		return NSLocalFile::publish( $srcPath, $flags );
	}
	function getThumbUrl( $suffix = false ) {
		return NSLocalFile::getThumbUrl( $suffix );
	}
	function thumbName( $params ) {
		return NSLocalFile::thumbName( $params );
	}
	function getThumbPath( $suffix = false ) {
		return NSLocalFile::getThumbPath( $suffix );
	}
	function getArchiveRel( $suffix = false ) {
		return NSLocalFile::getArchiveRel( $suffix );
	}
	function getArchiveUrl( $suffix = false ) {
		return NSLocalFile::getArchiveUrl( $suffix );
	}
	function getArchiveVirtualUrl( $suffix = false ) {
		return NSLocalFile::getArchiveVirtualUrl( $suffix );
	}
	function getThumbVirtualUrl( $suffix = false ) {
		return NSLocalFile::getArchiveVirtualUrl( $suffix );
	}
	function getVirtualUrl( $suffix = false ) {
		return NSLocalFile::getVirtualUrl( $suffix );
	}
	function getFileNameStripped($suffix) {
		return NSLocalFile::getFileNameStripped( $suffix );
	}
	function addOlds() {
		return NSLocalFile::addOlds();
	}
	function purgeThumbnails($options = array() ) {
		return NSLocalFile::purgeThumbnails( $options );
	}
	/**
	 * Replaces hard coded OldLocalFile::newFromRow to use $this->repo->oldFileFromRowFactory configuration
	 * This may not be necessary in the future if LocalFile is patched to allow configuration
	*/
	function getHistory( $limit = null, $start = null, $end = null, $inc = true ) {
		return NSLocalFile::getHistory( $limit, $start , $end, $inc );
	}

	/** See comment above about Instantiating this class using "self" */

	static function newFromTitle( $title, $repo, $time = null ) {
		# The null default value is only here to avoid an E_STRICT
		if( $time === null )
			throw new MWException( __METHOD__.' got null for $time parameter' );
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
}
