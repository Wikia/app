<?php

namespace Wikia;

/**
 * SwiftStorage
 *
 * Provides access to Swift-based distributed file system.
 *
 * Uses SwiftCloudFiles extension
 *
 * @author macbre
 *
 * @see $wgFSSwiftServer
 * @see $wgFSSwiftConfig
 */
class SwiftStorage {

	/* @var \WikiaGlobalRegistry $wg */
	private $wg;

	/* @var \CF_Connection $connection */
	private $connection;
	/* @var \CF_Container $container */
	private $container;

	private $authToken;     // e.g. "AUTH_xxxx"
	private $containerName; // e.g. "poznan"
	private $pathPrefix;    // e.g. "/pl/images" - must start with /

	/**
	 * Get storage instance to access uploaded files for a given wiki
	 *
	 * @param $cityId number|string city ID or wiki name
	 * @return SwiftStorage storage instance
	 */
	public static function newFromWiki( $cityId ) {
		$wgUploadPath = \WikiFactory::getVarValueByName( 'wgUploadPath', $cityId );
		$path = trim( parse_url( $wgUploadPath, PHP_URL_PATH ), '/' ); ;

		list( $containerName, $prefix ) = explode( '/', $path, 2 );

		return new self( $containerName, '/' . $prefix );
	}

	/**
	 * Get storage instance to access given Swift container
	 *
	 * @param $containerName string container name
	 * @param $pathPrefix string path prefix
	 * @return SwiftStorage storage instance
	 */
	public static function newFromContainer( $containerName, $pathPrefix = '' ) {
		if ($pathPrefix !== '') {
			$pathPrefix = '/' . ltrim($pathPrefix, '/');
		}

		return new self( $containerName,  $pathPrefix );
	}

	/**
	 * Setup storage
	 *
	 * Use newFromWiki() and newFromContainer() methods
	 *
	 * @param $containerName string container (aka bucket) name
	 * @param $pathPrefix string prefix to be prepended to remote names
	 * @throws \Exception
	 */
	private function __construct( $containerName, $pathPrefix = '' ) {
		$this->wg = \F::app()->wg;

		$this->connect( $this->wg->FSSwiftConfig );

		$this->container = $this->getContainer( $containerName );
		$this->containerName = $containerName;
		$this->pathPrefix = rtrim( $pathPrefix, '/' ) . '/';
	}

	/**
	 * Connect to Swift backend
	 *
	 * @param $config array Swift configuration
	 * @throws \Exception
	 */
	private function connect( Array $config ) {
		$auth = new \CF_Authentication(
			$config['swiftUser'],
			$config['swiftKey'],
			null,
			$config['swiftAuthUrl']
		);

		$auth->authenticate();
		$this->connection = new \CF_Connection( $auth );

		$this->authToken = $auth->auth_token;
	}

	/**
	 * Get the container (create it if necessary)
	 *
	 * @param $containerName string container name
	 * @return \CF_Container object
	 * @throws \Exception
	 */
	private function getContainer( $containerName ) {
		try {
			$container = $this->connection->get_container( $containerName );
		}
		catch ( \NoSuchContainerException $ex ) {
			$container =  $this->connection->create_container( $containerName );
		}

		// set public ACL
		$url = sprintf( 'http://%s/swift/v1/%s', $this->wg->FSSwiftServer, $containerName );

		/* @var $req \CurlHttpRequest */
		$req = \MWHttpRequest::factory( $url, array( 'method' => 'POST', 'noProxy' => true ) );
		$req->setHeader( 'X-Auth-Token', $this->authToken );
		$req->setHeader( 'X-Container-Read', '.r:*' );

		$status = $req->execute();

		return $status->isOK() ? $container : false;
	}

	/**
	 * Prepend given name with remote path
	 *
	 * @param $remoteFile string remote file name
	 * @return string remote path
	 */
	private function getRemotePath( $remoteFile ) {
		$remotePath = $this->pathPrefix . '/' . ltrim( $remoteFile, '/' );
		return ltrim( $remotePath, '/' );
	}

	/**
	 * Uploads given local file to Swift storage
	 *
	 * @param $localFile string local file name
	 * @param $remoteFile string remote file name
	 * @param array $headers optional headers
	 * @param bool $mimeType
	 * @return \Status result
	 */
	public function store( $localFile, $remoteFile, Array $headers = array(), $mimeType = false ) {
		$res = \Status::newGood();

		$remotePath = $this->getRemotePath( $remoteFile );
		wfDebug( __METHOD__ . ": {$localFile} -> {$remotePath}\n" );

		$time = microtime( true );

		try {
			$fp = @fopen( $localFile, 'r' );
			if ( !$fp ) {
				\Wikia::log( __METHOD__, 'fopen', "{$localFile} doesn't exist" );
				return \Status::newFatal( "{$localFile} doesn't exist" );
			}

			// check file size - sending empty file results in "HTTP 411 MissingContentLengh"
			$size = fstat( $fp )['size'];
			if ( $size === 0 ) {
				\Wikia::log( __METHOD__, 'fstat', "{$localFile} is empty" );
				return \Status::newFatal( "{$localFile} is empty" );
			}

			$object = $this->container->create_object( $remotePath );

			// metadata
			if ( is_string( $mimeType ) ) {
				$object->content_type = $mimeType;
			}
			$object->headers = $headers;

			// upload it
			$object->write( $fp, $size );
			fclose( $fp );
		}
		catch ( \Exception $ex ) {
			\Wikia::log( __METHOD__, 'exception - ' . $localFile, $ex->getMessage() );
			return \Status::newFatal( $ex->getMessage() );
		}

		$time = round( ( microtime( true ) - $time ) * 1000 );
		wfDebug( __METHOD__ . ": {$localFile} uploaded in {$time} ms\n" );

		return $res;
	}

	/**
	 * Remove fiven remote file
	 *
	 * @param $remoteFile string remote file name
	 * @return \Status result
	 */
	public function remove( $remoteFile ) {
		$res = \Status::newGood();

		try {
			$this->container->delete_object( $this->getRemotePath( $remoteFile ) );
		}
		catch ( \Exception $ex ) {
			\Wikia::log( __METHOD__, 'exception - ' . $remoteFile, $ex->getMessage() );
			return \Status::newFatal( $ex->getMessage() );
		}

		return $res;
	}

	/**
	 * Check if given remote file exists
	 *
	 * @param $remoteFile string remote file name
	 * @return bool exists?
	 */
	public function exists( $remoteFile ) {
		try {
			$this->container->get_object( $this->getRemotePath( $remoteFile ) );
		}
		catch ( \NoSuchObjectException $ex ) {
			return false;
		}

		return true;
	}

	/**
	 * Return public URL for given remote file
	 *
	 * @param $remoteFile string remote file name
	 * @return string public URL
	 */
	public function getUrl( $remoteFile ) {
		return sprintf( 'http://%s/%s%s%s',
			$this->wg->FSSwiftServer,
			$this->containerName,
			$this->pathPrefix,
			ltrim( $remoteFile, '/' )
		);
	}
}
