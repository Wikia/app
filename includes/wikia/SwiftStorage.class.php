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
 * @author moli
 *
 * @see $wgFSSwiftServer
 * @see $wgFSSwiftConfig
 */
class SwiftStorage {

	const LOG_GROUP = 'swift-storage';

	/* @var \WikiaGlobalRegistry $wg */
	private $wg;

	/* @var \CF_Connection $connection */
	private $connection;
	/* @var \CF_Container $container */
	private $container;

	private $authToken;     // e.g. "AUTH_xxxx"
	private $containerName; // e.g. "poznan"
	private $pathPrefix;    // e.g. "/pl/images" - must start with /
	
	private $swiftConfig;   // default $wgFSSwiftConfig
	private $swiftServer;   // default $wgFSSwiftServer

	/**
	 * Get storage instance to access uploaded files for a given wiki
	 *
	 * @param $cityId number|string city ID or wiki name
	 * @param $dataCenter string|null name of datacenter (res, iowa ... )
	 * @return SwiftStorage storage instance
	 */
	public static function newFromWiki( $cityId, $dataCenter = null ) {
		$wgUploadPath = \WikiFactory::getVarValueByName( 'wgUploadPath', $cityId );
		$path = trim( parse_url( $wgUploadPath, PHP_URL_PATH ), '/' ); ;

		list( $containerName, $prefix ) = explode( '/', $path, 2 );

		return new self( $containerName, '/' . $prefix, $dataCenter );
	}

	/**
	 * Get storage instance to access given Swift container
	 *
	 * @param $containerName string container name
	 * @param $pathPrefix string path prefix
	 * @return SwiftStorage storage instance
	 */
	public static function newFromContainer( $containerName, $pathPrefix = '', $dataCenter = null ) {
		if ($pathPrefix !== '') {
			$pathPrefix = '/' . ltrim($pathPrefix, '/');
		}

		return new self( $containerName,  $pathPrefix, $dataCenter );
	}

	/**
	 * Setup storage
	 *
	 * Use newFromWiki() and newFromContainer() methods
	 *
	 * @param $containerName string container (aka bucket) name
	 * @param $pathPrefix string prefix to be prepended to remote names
	 * @param $dataCenter string|null name of DC (res, iowa ... )
	 * @throws \Exception
	 */
	private function __construct( $containerName, $pathPrefix = '', $dataCenter = null ) {
		$this->wg = \F::app()->wg;

		if ( !is_null( $dataCenter )  ) {
			$this->swiftServer = $this->wg->FSSwiftDC[ $dataCenter ][ 'servers' ][ array_rand( $this->wg->FSSwiftDC[ $dataCenter ][ 'servers' ] ) ];
			$this->swiftConfig = $this->wg->FSSwiftDC[ $dataCenter ][ 'config' ];
			array_walk( $this->swiftConfig, function( &$v, $k, $data ) { $v = sprintf( $v, $data ); }, $this->swiftServer );			 
		} else {
			$this->swiftConfig = $this->wg->FSSwiftConfig;
			$this->swiftServer = $this->wg->FSSwiftServer;
		}
		$this->connect( $this->swiftConfig );

		$this->container = $this->getContainer( $containerName );
		$this->containerName = $containerName;
		$this->pathPrefix = rtrim( $pathPrefix, '/' );
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
		$url = sprintf( 'http://%s/swift/v1/%s', $this->swiftServer, $containerName );

		wfDebug( sprintf( "%s: %s (ACL - read: '.r:*')\n",
			__METHOD__,
			$url
		));

		/* @var $req \CurlHttpRequest */
		$req = \MWHttpRequest::factory( $url, array( 'method' => 'POST', 'noProxy' => true ) );
		$req->setHeader( 'X-Auth-Token', $this->authToken );
		$req->setHeader( 'X-Container-Read', '.r:*' );

		$status = $req->execute();

		if (!$status->isOK()) {
			self::log(__METHOD__, 'can\'t set ACL');
		}

		return $container;
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
	 * @param $localFile string|resource local file name or handler to content stream
	 * @param $remoteFile string remote file name
	 * @param array $metadata optional metadata
	 * @param bool $mimeType
	 * @return \Status result
	 */
	public function store( $localFile, $remoteFile, Array $metadata = array(), $mimeType = false ) {
		$res = \Status::newGood();

		$remotePath = $this->getRemotePath( $remoteFile );
		$file = ( is_resource( $localFile ) ) ? get_resource_type( $localFile ) : $localFile; 
		
		wfDebug( __METHOD__ . ": {$file} -> {$remotePath}\n" );

		$time = microtime( true );

		try {
			if ( !is_resource( $localFile )  ) {
				$fp = @fopen( $localFile, 'r' );
				if ( !$fp ) {
					self::log( __METHOD__ . '::fopen', "<{$localFile}> doesn't exist" );
					return \Status::newFatal( "{$localFile} doesn't exist" );
				}
			} else {
				$fp = $localFile;
			}

			// check file size - sending empty file results in "HTTP 411 MissingContentLengh"
			$size = (float)fstat( $fp )['size'];
			if ( $size === 0 ) {
				self::log( __METHOD__ . '::fstat', "<{$file}> is empty" );
				return \Status::newFatal( "{$file} is empty" );
			}

			$object = $this->container->create_object( $remotePath );

			// metadata
			if ( is_string( $mimeType ) ) {
				$object->content_type = $mimeType;
			}

			if (!empty($metadata)) {
				$object->setMetadataValues($metadata);
			}

			// upload it
			$object->write( $fp, $size );
			
			if ( is_resource( $fp ) ) {
				fclose( $fp );
			}
		}
		catch ( \Exception $ex ) {
			self::log( __METHOD__ . '::exception',  $localFile . ' - ' . $ex->getMessage() );
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

		$remotePath = $this->getRemotePath( $remoteFile );
		wfDebug( __METHOD__ . ": {$remotePath}\n" );

		try {
			$this->container->delete_object( $remotePath );
		}
		catch ( \Exception $ex ) {
			self::log( __METHOD__ . '::exception',  $remotePath . ' - ' . $ex->getMessage() );
			return \Status::newFatal( $ex->getMessage() );
		}

		return $res;
	}
	
	/**
	 * Read remote file to string
	 *
	 * @param $remoteFile string remote file name
	 * @return String $content
	 */
	public function read( $remoteFile ) {
		$content = '';
		try {
			$remoteFile = $this->getRemotePath( $remoteFile );
			$object = $this->container->get_object( $remoteFile );
			$content = $object->read();
		}
		catch ( \InvalidResponseException $e ) {
			self::log( __METHOD__ . '::exception', $remoteFile . ' - ' . $e->getMessage() );
			return null;
		}
		catch ( \NoSuchObjectException $e ) {
			return null;
		}
		
		return $content;
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
		return sprintf( 'http://%s/%s%s/%s',
			$this->swiftServer,
			$this->containerName,
			$this->pathPrefix,
			ltrim( $remoteFile, '/' )
		);
	}

	/**
	 * Log to /var/log/private file
	 *
	 * @param $method string method
	 * @param $msg string message to log
	 */
	public static function log($method, $msg) {
		\Wikia::log(self::LOG_GROUP . '-WIKIA', false, $method . ': ' . $msg, true /* $force */);
	}
}
