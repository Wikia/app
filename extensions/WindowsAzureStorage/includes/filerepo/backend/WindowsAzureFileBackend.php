<?php
/**
 * @file
 * @ingroup FileBackend
 * @author Markus Glaser
 * @author Robert Vogel
 * @author Hallo Welt! - Medienwerkstatt GmbH
 */

/**
 * Copied and modified from Swift FileBackend:
 * 
 * Class for a Windows Azure Blob Storage based file backend.
 * Status messages should avoid mentioning the Azure account name
 * Likewise, error suppression should be used to avoid path disclosure.
 *
 * This requires the PHPAzure library to be present,
 * which is available at http://phpazure.codeplex.com/.
 * All of the library classes must be registed in $wgAutoloadClasses.
 * You may use the WindowsAzureSDK MediaWiki extension to fulfill this
 * requirement.
 *
 * @ingroup FileBackend
 */
class WindowsAzureFileBackend extends FileBackendStore {
	
	/** @var Microsoft_WindowsAzure_Storage_Blob */
	protected $storageClient = null;

	/** @var Array Map of container names to Azure container names */
	protected $containerPaths = array();
	
	/**
	 * @see FileBackend::__construct()
	 * Additional $config params include:
	 *    azureHost      : Windows Azure server URL
	 *    azureAccount   : Windows Azure user used by MediaWiki
	 *    azureKey       : Authentication key for the above user (used to get sessions)
	 *    //azureContainer : Identifier of the container. (Optional. If not provided wikiId will be used as container name)
     *    containerPaths : Map of container names to Azure container names
	 */
	public function __construct( array $config ) {
		parent::__construct( $config );
		$this->storageClient = new Microsoft_WindowsAzure_Storage_Blob(
				$config['azureHost'],
				$config['azureAccount'],
				$config['azureKey']
		);

		$this->containerPaths = (array)$config['containerPaths'];
	}

	/**
	 * @see FileBackend::resolveContainerPath()
	 */
	protected function resolveContainerPath( $container, $relStoragePath ) {
		//Azure blob naming conventions; http://msdn.microsoft.com/en-us/library/dd135715.aspx

		if ( strlen( urlencode( $relStoragePath ) ) > 1024 ) {
			return null;
		}

		return $relStoragePath;
	}

	/**
	 * @see FileBackend::doStoreInternal()
	 */
	function doStoreInternal( array $params ) {
		$status = Status::newGood();
		list( $dstCont, $dstRel ) = $this->resolveStoragePath( $params['dst'] );
		if ( $dstRel === null ) {
			$status->fatal( 'backend-fail-invalidpath', $params['dst'] );
			return $status;
		}

		if ( empty( $params['overwrite'] ) ) { //Blob should not be overridden
			// Check if the destination object already exists
			if ( $this->storageClient->blobExists( $dstCont, $dstRel ) ) {
				$status->fatal( 'backend-fail-alreadyexists', $params['dst'] );
				return $status;
			}
		}
		
		try {
			$result = $this->storageClient->putBlob( $dstCont, $dstRel, $params['src']);
		}
		catch ( Exception $e ) {
			$status->fatal( 'backend-fail-store', $dstRel, $dstCont );
		}
		return $status;
	}

	/**
	 * @see FileBackend::doCopyInternal()
	 */
	function doCopyInternal( array $params ) {
		$status = Status::newGood();
		list( $srcContainer, $srcDir ) = $this->resolveStoragePath( $params['src'] );
		list( $dstContainer, $dstDir ) = $this->resolveStoragePath( $params['dst'] );
		if ( $srcDir === null ) {
			$status->fatal( 'backend-fail-invalidpath', $params['src'] );
			return $status;
		}
		if ( $dstDir === null ) {
			$status->fatal( 'backend-fail-invalidpath', $params['dst'] );
			return $status;
		}
		
		if ( empty( $params['overwrite'] ) ) { //Blob should not be overridden
			if ( $this->storageClient->blobExists( $dstContainer, $dstDir ) ) {
				$status->fatal( 'backend-fail-alreadyexists', $params['dst'] );
				return $status;
			}
		}

		try {
			$result = $this->storageClient->copyBlob( $srcContainer, $srcDir, $dstContainer, $dstDir);
		}
		catch ( Exception $e ) {
			$status->fatal( 'backend-fail-copy', $e->getMessage() );
		}
		return $status;
	}

	/**
	 * @see FileBackend::doDeleteInternal()
	 */
	function doDeleteInternal( array $params ) {
		$status = Status::newGood();

		list( $srcCont, $srcRel ) = $this->resolveStoragePath( $params['src'] );
		if ( $srcRel === null ) {
			$status->fatal( 'backend-fail-invalidpath', $params['src'] );
			return $status;
		}

		// Check the source container
		try {
			$container = $this->storageClient->getContainer( $srcCont );
		}
		catch ( Exception $e ) {
			$status->fatal( 'backend-fail-delete', $srcRel );
			return $status;
		}

		// Actually delete the object
		try {
			$this->storageClient->deleteBlob( $srcCont, $srcRel );
		}
		catch ( Exception $e ) {
			$status->fatal( 'backend-fail-internal' );
		}

		return $status;
	}

	/**
	 * @see FileBackend::doCreateInternal()
	 */
	function doCreateInternal( array $params ) {
		$status = Status::newGood();

		list( $dstCont, $dstRel ) = $this->resolveStoragePath( $params['dst'] );
		if ( $dstRel === null ) {
			$status->fatal( 'backend-fail-invalidpath', $params['dst'] );
			return $status;
		}

		if ( empty( $params['overwrite'] ) ) { //Blob should not be overridden
			// Check if the destination object already exists
			if ( $this->storageClient->blobExists( $dstCont, $dstRel ) ) {
				$status->fatal( 'backend-fail-alreadyexists', $params['dst'] );
				return $status;
			}
		}

		// Actually create the object
		try {
			$this->storageClient->putBlobData( $dstCont, $dstRel, $params['content'] );
		}
		catch ( Exception $e ) {
			$status->fatal( 'backend-fail-internal' );
		}
		return $status;
	}

	/**
	 * @see FileBackend::doPrepare()
	 */

	function doPrepareInternal( $container, $dir, array $params ) {
		$status = Status::newGood();

		list( $c, $dir ) = $this->resolveStoragePath( $params['dir'] );
		if ( $dir === null ) {
			$status->fatal( 'backend-fail-invalidpath', $params['dir'] );
			return $status; // invalid storage path
		}
		try {
			$this->storageClient->createContainerIfNotExists( $c );
			$this->storageClient->setContainerAcl( $c, Microsoft_WindowsAzure_Storage_Blob::ACL_PUBLIC );
		}
		catch (Exception $e ) {
			$status->fatal( 'directorycreateerror', $params['dir'] );
			return $status;
		}
		return $status;
	}


	/**
	 * @see FileBackend::resolveContainerName()
	 */
	protected function resolveContainerName( $container ) {
		//Azure container naming conventions; http://msdn.microsoft.com/en-us/library/dd135715.aspx
		$container = strtolower($container);
		$container = preg_replace( '#[^a-z0-9\-]#', '', $container );
		$container = preg_replace( '#^-#', '', $container );
		$container = preg_replace( '#-$#', '', $container );
		$container = preg_replace( '#-{2,}#', '-', $container );

		return $container;
	}

	/**
	 * @see FileBackend::secure()
	 */
	function doSecureInternal( $container, $dir, array $params ) {
		$status = Status::newGood();

		try {
			if ( $this->storageClient->containerExists( $container ) ) {
				if ( $params['noAccess'] == true ) {
					$this->storageClient->setContainerAcl( $container, Microsoft_WindowsAzure_Storage_Blob::ACL_PRIVATE );
				}
			}
		}
		catch (Exception $e ) {
			$status->fatal( 'directorycreateerror', $container );
			return $status;
		}
		return $status;
	}

	/**
	 * @see FileBackend::getFileList()
	 */
	function getFileListInternal( $container, $dir, array $params ) {
		$files = array();
		
		try {
			if ( trim($dir) == '' ) {
				$blobs = $this->storageClient->listBlobs($container);
			}
			else {
				if ( strrpos($dir, '/') != strlen($dir)-1 ) {
					$dir = $dir.'/';
				}
				$blobs = $this->storageClient->listBlobs($container, $dir);
			}

			foreach( $blobs as $blob ) {
				// Only return the actual file name without the /
				$tempName = $blob->name;
				if ( trim($dir) != '' ) {
					if ( strstr( $tempName, $dir ) !== false ) {
						$tempName = substr($tempName, strpos( $tempName, $dir ) + strlen( $dir ) );
						$files[] = $tempName;
					}
				} else {
					$files[] = $tempName;
				}
				
			}
		}
		catch( Exception $e ) {
			return null;
		}

		// if there are no files matching the prefix, return empty array
		return $files;
	}

	/**
	 * @see FileBackend::getLocalCopy()
	 */
	function getLocalCopy( array $params ) {
		list( $srcCont, $srcRel ) = $this->resolveStoragePath( $params['src'] );
		if ( $srcRel === null ) {
			return null;
		}

		// Get source file extension
		$ext = FileBackend::extensionFromPath( $srcRel );
		// Create a new temporary file...
		$tmpFile = TempFSFile::factory( wfBaseName( $srcRel ) . '_', $ext );
		if ( !$tmpFile ) {
			return null;
		}
		$tmpPath = $tmpFile->getPath();

		try {
			$this->storageClient->getBlob( $srcCont, $srcRel, $tmpPath );
		}
		catch ( Exception $e ) {
			return null;
		}

		return $tmpFile;
	}
	
	/**
	 * @see FileBackend::getFileStat()
	 */
	protected function doGetFileStat( array $params ) {
		list( $srcCont, $srcRel ) = $this->resolveStoragePathReal( $params['src'] );
		if ( $srcRel === null ) {
			return false; // invalid storage path
		}

		$timestamp= false;
		$size = false;

		try {
			$blob = $this->storageClient->getBlobInstance( $srcCont, $srcRel );
			$timestamp = wfTimestamp( TS_MW, $blob->LastModified );
			$size = $blob->Size;
			return array(
				'mtime' => $timestamp,
				'size'  => $size
			);
		} catch ( Exception $e ) { 
			$stat = null;
		}
		return false;
	}
	
		/**
	 * Check if a file can be created at a given storage path.
	 * FS backends should check if the parent directory exists and the file is writable.
	 * Backends using key/value stores should check if the container exists.
	 *
	 * @param $storagePath string
	 * @return bool
	 */
	
	public function isPathUsableInternal( $storagePath ) {
		list( $c, $dir ) = $this->resolveStoragePath( $storagePath );
		if ( $dir === null ) {
			return false;
		}
		if ( !$this->storageClient->containerExists( $c ) ) {
			return false;
		}
		
		return true;
	}
}
