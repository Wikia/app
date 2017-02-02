<?php
/**
 * @file
 * @ingroup FileBackend
 * @author Russ Nelson
 * @author Aaron Schulz
 */

use Wikia\Logger\WikiaLogger;

/**
 * Class for an OpenStack Swift based file backend.
 *
 * This requires the SwiftCloudFiles MediaWiki extension, which includes
 * the php-cloudfiles library (https://github.com/rackspace/php-cloudfiles).
 * php-cloudfiles requires the curl, fileinfo, and mb_string PHP extensions.
 *
 * Status messages should avoid mentioning the Swift account name.
 * Likewise, error suppression should be used to avoid path disclosure.
 *
 * @ingroup FileBackend
 * @since 1.19
 */
class SwiftFileBackend extends FileBackendStore {
	/** @var CF_Authentication */
	protected $auth; // Swift authentication handler
	protected $authTTL; // integer seconds
	protected $swiftAnonUser; // string; username to handle unauthenticated requests
	protected $swiftTimeout; // integer; number of seconds timeout consistent with php-cloudfiles
	protected $maxContCacheSize = 100; // integer; max containers with entries

	/** @var CF_Connection */
	protected $conn; // Swift connection handle
	protected $connStarted = 0; // integer UNIX timestamp
	protected $connContainers = array(); // container object cache
	
	protected $objCache = array();

	/** @var BagOStuff */
	protected $srvCache;

	/**
	 * @see FileBackendStore::__construct()
	 * Additional $config params include:
	 *    swiftAuthUrl       : Swift authentication server URL
	 *    swiftUser          : Swift user used by MediaWiki (account:username)
	 *    swiftKey           : Swift authentication key for the above user
	 *    swiftAuthTTL       : Swift authentication TTL (seconds)
	 *    swiftAnonUser      : Swift user used for end-user requests (account:username)
	 *    shardViaHashLevels : Map of container names to sharding config with:
	 *                         'base'   : base of hash characters, 16 or 36
	 *                         'levels' : the number of hash levels (and digits)
	 *                         'repeat' : hash subdirectories are prefixed with all the
	 *                                    parent hash directory names (e.g. "a/ab/abc")
	 *	  swiftTimeout       : number of seconds timeout consistent with php-cloudfiles. Default: 10
	 */
	public function __construct( array $config ) {
		parent::__construct( $config );
		// Required settings
		$this->auth = new CF_Authentication(
			$config['swiftUser'],
			$config['swiftKey'],
			null, // account; unused
			$config['swiftAuthUrl']
		);
		/* <Wikia> */
		if ( !empty( $config['debug'] ) ) {
			$this->auth->setDebug( $config['debug'] );
		}
		$this->swiftTimeout = isset ( $config['swiftTimeout'] )
			? intval( $config['swiftTimeout'] )
			: 10;
		/* </Wikia> */
		// Optional settings
		$this->authTTL = isset( $config['swiftAuthTTL'] )
			? $config['swiftAuthTTL']
			: 120; // some sane number
		$this->swiftAnonUser = isset( $config['swiftAnonUser'] )
			? $config['swiftAnonUser']
			: '';
		$this->shardViaHashLevels = isset( $config['shardViaHashLevels'] )
			? $config['shardViaHashLevels']
			: '';
		/* <Wikia> */
		// caching credentials
		if ( !empty( $config['cacheAuthInfo'] ) && $config['cacheAuthInfo'] === true ) {
			$this->srvCache = wfGetMainCache();
		}
		$this->srvCache = $this->srvCache ? $this->srvCache : new EmptyBagOStuff();
		/* </Wikia> */
	}

	/**
	 * @see FileBackendStore::isValidContainerName()
	 */
	protected static function isValidContainerName( $container ) {
		return preg_match( '/^[a-z0-9][a-z0-9-_.]{0,199}$/i', $container );
	}
	
	/**
	 * @see FileBackendStore::resolveContainerPath()
	 */
	protected function resolveContainerPath( $container, $relStoragePath ) {
		if ( !mb_check_encoding( $relStoragePath, 'UTF-8' ) ) { // mb_string required by CF
			return null; // not UTF-8, makes it hard to use CF and the swift HTTP API
		} elseif ( strlen( urlencode( $relStoragePath ) ) > 1024 ) {
			return null; // too long for Swift
		}
		return $relStoragePath;
	}

	/**
	 * @see FileBackendStore::isPathUsableInternal()
	 */
	public function isPathUsableInternal( $storagePath ) {
		list( $container, $rel ) = $this->resolveStoragePathReal( $storagePath );
		if ( $rel === null ) {
			return false; // invalid
		}

		try {
			$this->getContainer( $container );
			return true; // container exists
		} catch ( NoSuchContainerException $e ) {
			$this->logException( $e, __METHOD__, array( 'path' => $storagePath ) );
		} catch ( InvalidResponseException $e ) {
			$this->logException( $e, __METHOD__, array( 'path' => $storagePath ) );
		} catch ( Exception $e ) { // some other exception?
			$this->logException( $e, __METHOD__, array( 'path' => $storagePath ) );
		}

		return false;
	}

	/**
	 * @see FileBackendStore::doCreateInternal()
	 */
	protected function doCreateInternal( array $params ) {
		$status = Status::newGood();

		list( $dstCont, $dstRel ) = $this->resolveStoragePathReal( $params['dst'] );
		if ( $dstRel === null ) {
			$status->fatal( 'backend-fail-invalidpath', $params['dst'] );
			return $status;
		}

		// (a) Check the destination container and object
		try {
			unset( $this->objCache[ $params['dst'] ] );
			$dContObj = $this->getContainer( $dstCont );
			if ( empty( $params['overwrite'] ) &&
				$this->fileExists( array( 'src' => $params['dst'], 'latest' => 1 ) ) )
			{
				$status->fatal( 'backend-fail-alreadyexists', $params['dst'] );
				return $status;
			}
		} catch ( NoSuchContainerException $e ) {
			$status->fatal( 'backend-fail-create', $params['dst'] );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		} catch ( InvalidResponseException $e ) {
			$status->fatal( 'backend-fail-connect', $this->name );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		} catch ( Exception $e ) { // some other exception?
			$status->fatal( 'backend-fail-internal', $this->name );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		}

		// (b) Get a SHA-1 hash of the object
		$sha1Hash = wfBaseConvert( sha1( $params['content'] ), 16, 36, 31 );

		// (c) Actually create the object
		try {
			// Create a fresh CF_Object with no fields preloaded.
			// We don't want to preserve headers, metadata, and such.
			$obj = new CF_Object( $dContObj, $dstRel, false, false ); // skip HEAD
			// Note: metadata keys stored as [Upper case char][[Lower case char]...]
			$obj->metadata = array( 'Sha1base36' => $sha1Hash );
			// Manually set the ETag (https://github.com/rackspace/php-cloudfiles/issues/59).
			// The MD5 here will be checked within Swift against its own MD5.
			$obj->set_etag( md5( $params['content'] ) );
			// Use the same content type as StreamFile for security
			$obj->content_type = StreamFile::contentTypeFromPath( $params['dst'] );
			// Actually write the object in Swift
			$obj->write( $params['content'] );
		} catch ( BadContentTypeException $e ) {
			$status->fatal( 'backend-fail-contenttype', $params['dst'] );
			$this->logException( $e, __METHOD__, $params );
		} catch ( InvalidResponseException $e ) {
			$status->fatal( 'backend-fail-connect', $this->name );
			$this->logException( $e, __METHOD__, $params );
		} catch ( Exception $e ) { // some other exception?
			$status->fatal( 'backend-fail-internal', $this->name );
			$this->logException( $e, __METHOD__, $params );
		}

		return $status;
	}

	/**
	 * @see FileBackendStore::doStoreInternal()
	 */
	protected function doStoreInternal( array $params ) {
		$status = Status::newGood();

		list( $dstCont, $dstRel ) = $this->resolveStoragePathReal( $params['dst'] );
		if ( $dstRel === null ) {
			$status->fatal( 'backend-fail-invalidpath', $params['dst'] );
			return $status;
		}

		// (a) Check the destination container and object
		try {
			unset( $this->objCache[ $params['dst'] ] );
			$dContObj = $this->getContainer( $dstCont );
			if ( empty( $params['overwrite'] ) &&
				$this->fileExists( array( 'src' => $params['dst'], 'latest' => 1 ) ) )
			{
				$status->fatal( 'backend-fail-alreadyexists', $params['dst'] );
				return $status;
			}
		} catch ( NoSuchContainerException $e ) {
			$status->fatal( 'backend-fail-copy', $params['src'], $params['dst'] );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		} catch ( InvalidResponseException $e ) {
			$status->fatal( 'backend-fail-connect', $this->name );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		} catch ( Exception $e ) { // some other exception?
			$status->fatal( 'backend-fail-internal', $this->name );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		}

		// (b) Get a SHA-1 hash of the object
		$sha1Hash = sha1_file( $params['src'] );
		if ( $sha1Hash === false ) { // source doesn't exist?
			$status->fatal( 'backend-fail-copy', $params['src'], $params['dst'] );
			return $status;
		}
		$sha1Hash = wfBaseConvert( $sha1Hash, 16, 36, 31 );

		// (c) Actually store the object
		try {
			// Create a fresh CF_Object with no fields preloaded.
			// We don't want to preserve headers, metadata, and such.
			$obj = new CF_Object( $dContObj, $dstRel, false, false ); // skip HEAD
			// Note: metadata keys stored as [Upper case char][[Lower case char]...]
			$obj->metadata = array( 'Sha1base36' => $sha1Hash );
			// The MD5 here will be checked within Swift against its own MD5.
			$obj->set_etag( md5_file( $params['src'] ) );
			// Use the same content type as StreamFile for security
			$obj->content_type = $this->getFileProps($params)['mime']; // Wikia cnange: use the same logic as for DB row (BAC-1199)
			// Actually write the object in Swift
			$obj->load_from_filename( $params['src'], True ); // calls $obj->write()
		} catch ( BadContentTypeException $e ) {
			$status->fatal( 'backend-fail-contenttype', $params['dst'] );
			$this->logException( $e, __METHOD__, $params );
		} catch ( IOException $e ) {
			$status->fatal( 'backend-fail-copy', $params['src'], $params['dst'] );
			$this->logException( $e, __METHOD__, $params );
		} catch ( InvalidResponseException $e ) {
			$status->fatal( 'backend-fail-connect', $this->name );
			$this->logException( $e, __METHOD__, $params );
		} catch ( Exception $e ) { // some other exception?
			$status->fatal( 'backend-fail-internal', $this->name );
			$this->logException( $e, __METHOD__, $params );
		}

		wfRunHooks( 'SwiftFileBackend::doStoreInternal', array( $params, &$status ) );

		return $status;
	}

	/**
	 * @see FileBackendStore::doCopyInternal()
	 */
	protected function doCopyInternal( array $params ) {
		$status = Status::newGood();

		list( $srcCont, $srcRel ) = $this->resolveStoragePathReal( $params['src'] );
		if ( $srcRel === null ) {
			$status->fatal( 'backend-fail-invalidpath', $params['src'] );
			return $status;
		}

		list( $dstCont, $dstRel ) = $this->resolveStoragePathReal( $params['dst'] );
		if ( $dstRel === null ) {
			$status->fatal( 'backend-fail-invalidpath', $params['dst'] );
			return $status;
		}

		// (a) Check the source/destination containers and destination object
		try {
			unset( $this->objCache[ $params['src'] ] );
			unset( $this->objCache[ $params['dst'] ] );
			$sContObj = $this->getContainer( $srcCont );
			$dContObj = $this->getContainer( $dstCont );
			if ( empty( $params['overwrite'] ) &&
				$this->fileExists( array( 'src' => $params['dst'], 'latest' => 1 ) ) )
			{
				$status->fatal( 'backend-fail-alreadyexists', $params['dst'] );
				return $status;
			}
		} catch ( NoSuchContainerException $e ) {
			$status->fatal( 'backend-fail-copy', $params['src'], $params['dst'] );
			return $status;
		} catch ( InvalidResponseException $e ) {
			$status->fatal( 'backend-fail-connect', $this->name );
			return $status;
		} catch ( Exception $e ) { // some other exception?
			$status->fatal( 'backend-fail-internal', $this->name );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		}

		// (b) Actually copy the file to the destination
		try {
			$sContObj->copy_object_to( $srcRel, $dContObj, $dstRel );
		} catch ( NoSuchObjectException $e ) { // source object does not exist
			$status->fatal( 'backend-fail-copy', $params['src'], $params['dst'] );
			$this->logException( $e, __METHOD__, $params );
		} catch ( InvalidResponseException $e ) {
			$status->fatal( 'backend-fail-connect', $this->name );
			$this->logException( $e, __METHOD__, $params );
		} catch ( Exception $e ) { // some other exception?
			$status->fatal( 'backend-fail-internal', $this->name );
			$this->logException( $e, __METHOD__, $params );
		}
		
		wfRunHooks( 'SwiftFileBackend::doCopyInternal', array( $params, &$status ) );

		return $status;
	}

	/**
	 * @see FileBackendStore::doDeleteInternal()
	 */
	protected function doDeleteInternal( array $params ) {
		$status = Status::newGood();

		list( $srcCont, $srcRel ) = $this->resolveStoragePathReal( $params['src'] );
		if ( $srcRel === null ) {
			$status->fatal( 'backend-fail-invalidpath', $params['src'] );
			return $status;
		}

		try {
			unset( $this->objCache[ $params['src'] ] );
			$sContObj = $this->getContainer( $srcCont );
			$sContObj->delete_object( $srcRel );
		} catch ( NoSuchContainerException $e ) {
			$status->fatal( 'backend-fail-delete', $params['src'] );
			$this->logException( $e, __METHOD__, $params );
		} catch ( NoSuchObjectException $e ) {
			if ( empty( $params['ignoreMissingSource'] ) ) {
				$status->fatal( 'backend-fail-delete', $params['src'] );
				$this->logException( $e, __METHOD__, $params );
			}
		} catch ( InvalidResponseException $e ) {
			$status->fatal( 'backend-fail-connect', $this->name );
			$this->logException( $e, __METHOD__, $params );
		} catch ( Exception $e ) { // some other exception?
			$status->fatal( 'backend-fail-internal', $this->name );
			$this->logException( $e, __METHOD__, $params );
		}

		wfRunHooks( 'SwiftFileBackend::doDeleteInternal', array( $params, &$status ) );
		
		return $status;
	}

	/**
	 * @see FileBackendStore::doPrepareInternal()
	 */
	protected function doPrepareInternal( $fullCont, $dir, array $params ) {
		$status = Status::newGood();

		// (a) Check if container already exists
		try {
			$contObj = $this->getContainer( $fullCont );
			// NoSuchContainerException not thrown: container must exist

			$status->merge( $this->setContainerAccess(
				$contObj,
				array( '.r:*' ), // read
				array( $this->auth->username, $this->swiftAnonUser ) // write
			) );

			return $status; // already exists
		} catch ( NoSuchContainerException $e ) {
			// NoSuchContainerException thrown: container does not exist
		} catch ( InvalidResponseException $e ) {
			$status->fatal( 'backend-fail-connect', $this->name );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		} catch ( Exception $e ) { // some other exception?
			$status->fatal( 'backend-fail-internal', $this->name );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		}

		// (b) Create container as needed
		try {
			$contObj = $this->createContainer( $fullCont );
			// Make container public to end-users...
			if ( $this->swiftAnonUser != '' ) {
				$status->merge( $this->setContainerAccess(
					$contObj,
					array( $this->auth->username, $this->swiftAnonUser ), // read
					array( $this->auth->username, $this->swiftAnonUser ) // write
				) );
			} else {
				$status->merge( $this->setContainerAccess(
					$contObj,
					array( '.r:*' ), // read
					array( $this->auth->username ) // write
				) );
			}
		} catch ( InvalidResponseException $e ) {
			$status->fatal( 'backend-fail-connect', $this->name );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		} catch ( Exception $e ) { // some other exception?
			$status->fatal( 'backend-fail-internal', $this->name );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		}

		return $status;
	}

	// Wikia change - begin (@author macbre)
	// this method is called when storage file / directory is deleted
	// and restricts access to ALL files in the current container (BAC-849)
	/**
	 * @see FileBackendStore::doSecureInternal()
	 *
	protected function doSecureInternal( $fullCont, $dir, array $params ) {
		$status = Status::newGood();

		try {
			// doPrepareInternal() should have been called,
			// so the Swift container should already exist...
			$contObj = $this->getContainer( $fullCont ); // normally a cache hit
			// NoSuchContainerException not thrown: container must exist

			// Make container private to end-users...
			$status->merge( $this->setContainerAccess(
				$contObj,
				array( $this->auth->username ), // read
				array( $this->auth->username ) // write
			) );
		} catch ( InvalidResponseException $e ) {
			$status->fatal( 'backend-fail-connect', $this->name );
			$this->logException( $e, __METHOD__, $params );
		} catch ( Exception $e ) { // some other exception?
			$status->fatal( 'backend-fail-internal', $this->name );
			$this->logException( $e, __METHOD__, $params );
		}

		return $status;
	}
	**/
	// Wikia change - end

	/**
	 * @see FileBackendStore::doCleanInternal()
	 */
	protected function doCleanInternal( $fullCont, $dir, array $params ) {
		$status = Status::newGood();

		// Only containers themselves can be removed, all else is virtual
		if ( $dir != '' ) {
			return $status; // nothing to do
		}

		// (a) Check the container
		try {
			$contObj = $this->getContainer( $fullCont, true );
		} catch ( NoSuchContainerException $e ) {
			return $status; // ok, nothing to do
		} catch ( InvalidResponseException $e ) {
			$status->fatal( 'backend-fail-connect', $this->name );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		} catch ( Exception $e ) { // some other exception?
			$status->fatal( 'backend-fail-internal', $this->name );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		}

		// (b) Delete the container if empty
		if ( $contObj->object_count == 0 ) {
			try {
				$this->deleteContainer( $fullCont );
			} catch ( NoSuchContainerException $e ) {
				return $status; // race?
			} catch ( InvalidResponseException $e ) {
				$status->fatal( 'backend-fail-connect', $this->name );
				$this->logException( $e, __METHOD__, $params );
				return $status;
			} catch ( Exception $e ) { // some other exception?
				$status->fatal( 'backend-fail-internal', $this->name );
				$this->logException( $e, __METHOD__, $params );
				return $status;
			}
		}

		return $status;
	}

	/**
	 * @see FileBackendStore::doFileExists()
	 */
	protected function doGetFileStat( array $params ) {
		list( $srcCont, $srcRel ) = $this->resolveStoragePathReal( $params['src'] );
		if ( $srcRel === null ) {
			return false; // invalid storage path
		}

		# <Wikia>
		if ( isset( $this->objCache[ $params['src'] ] ) ) {
			return $this->objCache[ $params['src'] ];
		}
		
		if ( empty( $params['latest'] ) ) {
			$params['latest'] = 1;
		}
		# </Wikia>

		$stat = false;
		try {
			$contObj = $this->getContainer( $srcCont );
			$srcObj = $contObj->get_object( $srcRel, $this->headersFromParams( $params ) );
			// macbre - causes infinite loop / sha1 is stored in doStoreInternal() ?
			$this->addMissingMetadata( $srcObj, $params['src'] ); 
			$stat = array(
				// Convert dates like "Tue, 03 Jan 2012 22:01:04 GMT" to TS_MW
				'mtime' => wfTimestamp( TS_MW, $srcObj->last_modified ),
				'size' => (int)$srcObj->content_length,
				'sha1' => $srcObj->getMetadataValue( 'Sha1base36' )
			);

			$this->objCache[ $params['src'] ] = $stat; // Wikia change
		} catch ( NoSuchContainerException $e ) {
			$this->logException( $e, __METHOD__, $params );
		} catch ( NoSuchObjectException $e ) {
			$this->logException( $e, __METHOD__, $params );
		}

		return $stat;
	}

	/**
	 * Fill in any missing object metadata and save it to Swift
	 *
	 * @param $obj CF_Object
	 * @param $path string Storage path to object
	 * @return bool Success
	 * @throws Exception cloudfiles exceptions
	 */
	protected function addMissingMetadata( CF_Object $obj, $path ) {
		if ( $obj->getMetadataValue( 'Sha1base36' ) !== null ) {
			return true; // nothing to do
		}
		
		# don't check SHA-1 for thumbnailers 
		if ( $this->isThumbnailer( $path ) ) {
			return true; //nothing to do
		}
		wfProfileIn( __METHOD__ );

		WikiaLogger::instance()->warning(
			__METHOD__ . ' - file was not stored with SHA-1 metadata',
			[
				'path' => $path,
				'object' => $obj->container->name
			]
		);

		$status = Status::newGood();
		$scopeLockS = $this->getScopedFileLocks( array( $path ), LockManager::LOCK_UW, $status );
		if ( $status->isOK() ) {
			$tmpFile = $this->getLocalCopy( array( 'src' => $path, 'latest' => 1 ) );
			if ( $tmpFile ) {
				$hash = $tmpFile->getSha1Base36();
				if ( $hash !== false ) {
					$obj->setMetadataValues( array( 'Sha1base36' => $hash ) );
					$obj->sync_metadata(); // save to Swift
					wfProfileOut( __METHOD__ );
					return true; // success
				}
			}
		}

		WikiaLogger::instance()->warning(
			__METHOD__ . ' - unable to set SHA-1 metadata',
			[
				'path' => $path,
				'object' => $obj->container->name
			]
		);

		$obj->setMetadataValues( array( 'Sha1base36' => false ) );
		wfProfileOut( __METHOD__ );
		return false; // failed
	}

	/**
	 * @see FileBackend::getFileContents()
	 */
	public function getFileContents( array $params ) {
		static $existsCache = [];

		list( $srcCont, $srcRel ) = $this->resolveStoragePathReal( $params['src'] );
		if ( $srcRel === null ) {
			return false; // invalid storage path
		}

		if ( isset( $existsCache[ $params['src'] ] ) ) {
			return $existsCache[ $params['src'] ];
		}

		if ( !$this->fileExists( $params ) ) {
			$existsCache[ $params['src'] ] = null;
			return null;
		}

		$data = false;
		try {
			$sContObj = $this->getContainer( $srcCont );
			$obj = new CF_Object( $sContObj, $srcRel, false, false ); // skip HEAD request
			$data = $obj->read( $this->headersFromParams( $params ) );
		} catch ( NoSuchContainerException $e ) {
		} catch ( InvalidResponseException $e ) {
			$this->logException( $e, __METHOD__, $params );
		} catch ( Exception $e ) { // some other exception?
			$this->logException( $e, __METHOD__, $params );
		}

		return $data;
	}

	/**
	 * @see FileBackendStore::getFileListInternal()
	 */
	public function getFileListInternal( $fullCont, $dir, array $params ) {
		return new SwiftFileBackendFileList( $this, $fullCont, $dir );
	}

	/**
	 * Do not call this function outside of SwiftFileBackendFileList
	 *
	 * @param $fullCont string Resolved container name
	 * @param $dir string Resolved storage directory with no trailing slash
	 * @param $after string Storage path of file to list items after
	 * @param $limit integer Max number of items to list
	 * @return Array
	 */
	public function getFileListPageInternal( $fullCont, $dir, $after, $limit ) {
		$files = array();

		try {
			$container = $this->getContainer( $fullCont );
			$prefix = ( $dir == '' ) ? null : "{$dir}/";
			$files = $container->list_objects( $limit, $after, $prefix );
		} catch ( NoSuchContainerException $e ) {
		} catch ( NoSuchObjectException $e ) {
		} catch ( InvalidResponseException $e ) {
			$this->logException( $e, __METHOD__, array( 'cont' => $fullCont, 'dir' => $dir ) );
		} catch ( Exception $e ) { // some other exception?
			$this->logException( $e, __METHOD__, array( 'cont' => $fullCont, 'dir' => $dir ) );
		}

		return $files;
	}

	/**
	 * @see FileBackendStore::doGetFileSha1base36()
	 */
	public function doGetFileSha1base36( array $params ) {
		$stat = $this->getFileStat( $params );
		if ( $stat ) {
			return $stat['sha1'];
		} else {
			return false;
		}
	}

	/**
	 * @see FileBackendStore::doStreamFile()
	 */
	protected function doStreamFile( array $params ) {
		$status = Status::newGood();

		list( $srcCont, $srcRel ) = $this->resolveStoragePathReal( $params['src'] );
		if ( $srcRel === null ) {
			$status->fatal( 'backend-fail-invalidpath', $params['src'] );
		}

		try {
			$cont = $this->getContainer( $srcCont );
		} catch ( NoSuchContainerException $e ) {
			$status->fatal( 'backend-fail-stream', $params['src'] );
			return $status;
		} catch ( InvalidResponseException $e ) {
			$status->fatal( 'backend-fail-connect', $this->name );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		} catch ( Exception $e ) { // some other exception?
			$status->fatal( 'backend-fail-stream', $params['src'] );
			$this->logException( $e, __METHOD__, $params );
			return $status;
		}

		try {
			$output = fopen( 'php://output', 'wb' );
			$obj = new CF_Object( $cont, $srcRel, false, false ); // skip HEAD request
			$obj->stream( $output, $this->headersFromParams( $params ) );
		} catch ( InvalidResponseException $e ) { // 404? connection problem?
			$status->fatal( 'backend-fail-stream', $params['src'] );
			$this->logException( $e, __METHOD__, $params );
		} catch ( Exception $e ) { // some other exception?
			$status->fatal( 'backend-fail-stream', $params['src'] );
			$this->logException( $e, __METHOD__, $params );
		}

		return $status;
	}

	/**
	 * @see FileBackendStore::getLocalCopy()
	 */
	public function getLocalCopy( array $params ) {
		list( $srcCont, $srcRel ) = $this->resolveStoragePathReal( $params['src'] );
		if ( $srcRel === null ) {
			return null;
		}

		/*if ( !$this->fileExists( $params ) ) {
			return null;
		}*/

		$tmpFile = null;
		try {
			$sContObj = $this->getContainer( $srcCont );
			$obj = new CF_Object( $sContObj, $srcRel, false, false ); // skip HEAD
			// Get source file extension
			$ext = FileBackend::extensionFromPath( $srcRel );
			// Create a new temporary file...
			$tmpFile = TempFSFile::factory( wfBaseName( $srcRel ) . '_', $ext );
			if ( $tmpFile ) {
				$handle = fopen( $tmpFile->getPath(), 'wb' );
				if ( $handle ) {
					$obj->stream( $handle, $this->headersFromParams( $params ) );
					fclose( $handle );
				} else {
					$tmpFile = null; // couldn't open temp file
				}
			}
		} catch ( NoSuchContainerException $e ) {
			$tmpFile = null;
			$this->logException( $e, __METHOD__, $params );
		} catch ( NoSuchObjectException $e ) {
			$tmpFile = null;
			$this->logException( $e, __METHOD__, $params );
		} catch ( InvalidResponseException $e ) {
			$tmpFile = null;
			$this->logException( $e, __METHOD__, $params );
		} catch ( Exception $e ) { // some other exception?
			$tmpFile = null;
			$this->logException( $e, __METHOD__, $params );
		}

		return $tmpFile;
	}

	/**
	 * Get headers to send to Swift when reading a file based
	 * on a FileBackend params array, e.g. that of getLocalCopy().
	 * $params is currently only checked for a 'latest' flag.
	 *
	 * @param $params Array
	 * @return Array
	 */
	protected function headersFromParams( array $params ) {
		$hdrs = array();
		if ( !empty( $params['latest'] ) ) {
			$hdrs[] = 'X-Newest: true';
		}
		return $hdrs;
	}

	/**
	 * Set read/write permissions for a Swift container
	 *
	 * @param $contObj CF_Container Swift container
	 * @param $readGrps Array Swift users who can read (account:user)
	 * @param $writeGrps Array Swift users who can write (account:user)
	 * @return Status
	 */
	protected function setContainerAccess(
		CF_Container $contObj, array $readGrps, array $writeGrps
	) {
		// Wikia change - begin
		// don't send multiple ACL requests for the same container over and over again (BAC-872)
		static $reqSent = [];

		$key = $contObj->name;
		$entry = implode( ',', $readGrps ) . '::' . implode( ',', $writeGrps );

		if (isset($reqSent[$key]) && $reqSent[$key] === $entry) {
			wfDebug( __METHOD__ . ": ACL already set\n" );
			return Status::newGood();
		}

		$reqSent[$key] = $entry;
		// Wikia change - end

		$creds = $contObj->cfs_auth->export_credentials();
		$url = $creds['storage_url'] . '/' . rawurlencode( $contObj->name );

		wfDebug( sprintf( "%s: %s (ACL - read: '%s', write: '%s')\n",
			__METHOD__,
			$url,
			implode( ',', $readGrps ),
			implode( ',', $writeGrps )
		)); // Wikia change

		// Note: 10 second timeout consistent with php-cloudfiles
		/* @var CurlHttpRequest $req */
		$req = MWHttpRequest::factory( $url, array( 'method' => 'POST', 'timeout' => $this->swiftTimeout, 'noProxy' => true ) );
		$req->setHeader( 'X-Auth-Token', $creds['auth_token'] );
		$req->setHeader( 'X-Container-Read', implode( ',', $readGrps ) );
		$req->setHeader( 'X-Container-Write', implode( ',', $writeGrps ) );

		return $req->execute(); // should return 204
	}

	/**
	 * Get a connection to the Swift proxy
	 *
	 * @return CF_Connection|false
	 * @throws InvalidResponseException
	 */
	protected function getConnection() {
		if ( $this->conn === false ) {
			throw new InvalidResponseException; // failed last attempt
		}
		// Session keys expire after a while, so we renew them periodically
		if ( $this->conn && ( time() - $this->connStarted ) > $this->authTTL ) {
			$this->closeConnection();
		}
		// Authenticate with proxy and get a session key...
		if ( $this->conn === null ) {
			$cacheKey = $this->getCredsCacheKey( $this->auth->username );
			$creds = $this->srvCache->get( $cacheKey ); // credentials

			if ( is_array( $creds ) ) { // cache hit
				$this->auth->load_cached_credentials( $creds['auth_token'], $creds['storage_url'], $creds['cdnm_url'] );
				$this->connStarted = time() - ceil( $this->authTTL / 2 ); // skew for worst case
			} else { // cache miss
				try {
					$this->auth->authenticate();
					$creds = $this->auth->export_credentials();
					$this->srvCache->set( $cacheKey, $creds, ceil( $this->authTTL / 2 ) ); // cache
					$this->connStarted = time();
				} catch ( AuthenticationException $e ) {
					$this->conn = false; // don't keep re-trying
					$this->logException( $e, __METHOD__, $creds );
				} catch ( InvalidResponseException $e ) {
					$this->conn = false; // don't keep re-trying
					$this->logException( $e, __METHOD__, $creds );
				}
			}

			$this->conn = new CF_Connection( $this->auth );
		}

		if ( !$this->conn ) {
			throw new InvalidResponseException; // auth/connection problem
		}
		return $this->conn;
	}

	/**
	 * @see FileBackendStore::doClearCache()
	 */
	protected function doClearCache( array $paths = null ) {
		// macbre: commented this out to reduce number of HEAD requests checking the existance of containers
		# $this->connContainers = array(); // clear container object cache
	}

	/**
	 * Get the cache key for a container
	 *
	 * @param string $username
	 * @return string
	 */
	private function getCredsCacheKey( $username ) {
		// Wikia change - begin
		global $wgFSSwiftServer;
		// Wikia change - end

		return wfForeignMemcKey(__CLASS__, $wgFSSwiftServer, 'usercreds', $username );
	}

	/**
	 * Get a Swift container object, possibly from process cache.
	 * Use $reCache if the file count or byte count is needed.
	 *
	 * @param $container string Container name
	 * @param $reCache bool Refresh the process cache
	 * @return CF_Container
	 */
	protected function getContainer( $container, $reCache = false ) {
		$conn = $this->getConnection(); // Swift proxy connection
		if ( $reCache ) {
			unset( $this->connContainers[$container] ); // purge cache
		}
		if ( !isset( $this->connContainers[$container] ) ) {
			$contObj = $conn->get_container( $container );
			// NoSuchContainerException not thrown: container must exist
			if ( count( $this->connContainers ) >= $this->maxContCacheSize ) { // trim cache?
				reset( $this->connContainers );
				$key = key( $this->connContainers );
				unset( $this->connContainers[$key] );
			}
			$this->connContainers[$container] = $contObj; // cache it
		}
		return $this->connContainers[$container];
	}

	/**
	 * Create a Swift container
	 *
	 * @param $container string Container name
	 * @return CF_Container
	 */
	protected function createContainer( $container ) {
		$conn = $this->getConnection(); // Swift proxy connection
		$contObj = $conn->create_container( $container );
		$this->connContainers[$container] = $contObj; // cache it
		return $contObj;
	}

	/**
	 * Delete a Swift container
	 *
	 * @param $container string Container name
	 * @return void
	 */
	protected function deleteContainer( $container ) {
		$conn = $this->getConnection(); // Swift proxy connection
		$conn->delete_container( $container );
		unset( $this->connContainers[$container] ); // purge cache
	}

	/**
	 * Close the connection to the Swift proxy
	 *
	 * @return void
	 */
	protected function closeConnection() {
		if ( $this->conn ) {
			$this->srvCache->delete( $this->getCredsCacheKey( $this->auth->username ) );
			$this->conn->close(); // close active cURL handles in CF_Http object
			$this->conn = null;
			$this->connStarted = 0;
		}
	}

	/**
	 * Log an unexpected exception for this backend
	 *
	 * @param $e Exception
	 * @param $func string
	 * @param $params mixed
	 * @return void
	 */
	protected function logException( Exception $e, $func, $params ) {
		// Wikia change - begin
		global $wgFSSwiftServer;

		if ( $e instanceof InvalidResponseException ) { // possibly a stale token
			$this->closeConnection(); // force a re-connect and re-auth next time
		}

		if ( $e instanceof NoSuchObjectException ) {
			return;
		}

		\Wikia\Logger\WikiaLogger::instance()->error( __CLASS__, [
			'exception' => $e,
			'func' => $func,
			'params' => $params,
			'swift_server' => $wgFSSwiftServer
		]);
		// Wikia change - end
	}
	
	/**
	 * Check if image path contains /thumb/ 
	 *
	 * @param $path image path
	 * @return Boolean
	 */
	private function isThumbnailer( $path ) {
		if ( strpos( $path, '/images/thumb/' ) !== false ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * SwiftFileBackend helper class to page through object listings.
 * Swift also has a listing limit of 10,000 objects for sanity.
 * Do not use this class from places outside SwiftFileBackend.
 *
 * @ingroup FileBackend
 */
class SwiftFileBackendFileList implements Iterator {
	/** @var Array */
	protected $bufferIter = array();
	protected $bufferAfter = null; // string; list items *after* this path
	protected $pos = 0; // integer

	/** @var SwiftFileBackend */
	protected $backend;
	protected $container; //
	protected $dir; // string storage directory
	protected $suffixStart; // integer

	const PAGE_SIZE = 5000; // file listing buffer size

	/**
	 * @param $backend SwiftFileBackend
	 * @param $fullCont string Resolved container name
	 * @param $dir string Resolved directory relative to container
	 */
	public function __construct( SwiftFileBackend $backend, $fullCont, $dir ) {
		$this->backend = $backend;
		$this->container = $fullCont;
		$this->dir = $dir;
		if ( substr( $this->dir, -1 ) === '/' ) {
			$this->dir = substr( $this->dir, 0, -1 ); // remove trailing slash
		}
		if ( $this->dir == '' ) { // whole container
			$this->suffixStart = 0;
		} else { // dir within container
			$this->suffixStart = strlen( $this->dir ) + 1; // size of "path/to/dir/"
		}
	}

	public function current() {
		return substr( current( $this->bufferIter ), $this->suffixStart );
	}

	public function key() {
		return $this->pos;
	}

	public function next() {
		// Advance to the next file in the page
		next( $this->bufferIter );
		++$this->pos;
		// Check if there are no files left in this page and
		// advance to the next page if this page was not empty.
		if ( !$this->valid() && count( $this->bufferIter ) ) {
			$this->bufferAfter = end( $this->bufferIter );
			$this->bufferIter = $this->backend->getFileListPageInternal(
				$this->container, $this->dir, $this->bufferAfter, self::PAGE_SIZE
			);
		}
	}

	public function rewind() {
		$this->pos = 0;
		$this->bufferAfter = null;
		$this->bufferIter = $this->backend->getFileListPageInternal(
			$this->container, $this->dir, $this->bufferAfter, self::PAGE_SIZE
		);
	}

	public function valid() {
		return ( current( $this->bufferIter ) !== false ); // no paths can have this value
	}
}
