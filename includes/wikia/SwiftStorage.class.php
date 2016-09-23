<?php

namespace Wikia;

use Wikia\Logger\Loggable;

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

	use Loggable;

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
	 * @param $dataCenter string|null name of data center (res, iowa ... )
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
			$this->swiftServer = $this->wg->FSSwiftDC[ $dataCenter ][ 'server' ];
			$this->swiftConfig = $this->wg->FSSwiftDC[ $dataCenter ][ 'config' ];
		} else {
			$this->swiftConfig = $this->wg->FSSwiftConfig;
			$this->swiftServer = $this->wg->FSSwiftServer;
		}

		$this->containerName = $containerName;
		$this->pathPrefix = rtrim( $pathPrefix, '/' );

		try {
			$this->connect( $this->swiftConfig );
		}
		catch( \Exception $ex ) {
			$this->error( 'SwiftStorage: connect failed', [
				'exception'  => $ex,
			]);

			throw $ex;
		}

		$this->container = $this->getContainerObject( $containerName );
	}

	/**
	 * Extend the context of all messages sent from this class
	 *
	 * @return array
	 */
	protected function getLoggerContext() {
		return [
			'prefix'       => $this->getContainerName() . $this->getPathPrefix(), // eg. "poznan" + "/pl/images"
			'swift-server' => $this->getSwiftServer(),
		];
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
	private function getContainerObject( $containerName ) {
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
			$this->warning( 'SwiftStorage: unable to set ACL', [
				'exception' => new \Exception( $status->getMessage(), $req->getStatus() ),
				'url'       => $url,
				'errors'    => $status->getErrorsArray(),
				'headers'   => $req->getResponseHeaders(),
			]);
		}

		return $container;
	}

	/**
	 * Return an instance of Swift object for a given remote file name
	 *
	 * @param string $remoteFile
	 * @return \CF_Object
	 * @throws NoSuchObjectException
	 */
	private function getObject( $remoteFile ) {
		return $this->container->get_object( $this->getRemotePath( $remoteFile ) );
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
	 * When passing a stream this method will close it internally (via fclose)
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
		
		wfDebug( __METHOD__ . ": {$file} -> {$remotePath} [{$this->swiftServer}]\n" );

		$time = microtime( true );

		try {
			if ( !is_resource( $localFile )  ) {
				$fp = @fopen( $localFile, 'r' );
				if ( !$fp ) {
					$this->error( 'SwiftStorage: fopen - file does not exist', [
						'exception'  => new \Exception($file)
					]);
					return \Status::newFatal( "{$file} doesn't exist" );
				}
			} else {
				$fp = $localFile;
			}

			// check file size - sending empty file results in "HTTP 411 MissingContentLength" (PLATFORM-841)
			$size = intval( fstat( $fp )['size'] );
			if ( $size === 0 ) {
				$this->error( 'SwiftStorage: fopen - file is empty', [
					'exception'  => new \Exception($file)
				]);
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
			$this->error( 'SwiftStorage: exception', [
				'op'         => 'store',
				'args'       => [ $localFile, $remoteFile, $metadata, $mimeType ],
				'exception'  => $ex
			]);
			return \Status::newFatal( $ex->getMessage(), get_class($ex) );
		}

		$time = round( ( microtime( true ) - $time ) * 1000 );
		wfDebug( __METHOD__ . ": {$localFile} uploaded in {$time} ms [{$this->swiftServer}]\n" );

		return $res;
	}

	/**
	 * Remove given remote file
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
			$this->error( 'SwiftStorage: exception', [
				'op'         => 'remove',
				'args'       => [ $remoteFile ],
				'exception'  => $ex
			]);
			return \Status::newFatal( $ex->getMessage() );
		}

		return $res;
	}
	
	/**
	 * Read remote file to string
	 *
	 * @param string $remoteFile remote file name
	 * @param resource $fp stream to use for reading (optional)
	 * @return String|null|boolean $content
	 */
	public function read( $remoteFile, &$fp = null ) {
		try {
			$object = $this->getObject( $remoteFile );

			if ( is_resource( $fp ) ) {
				return $object->stream( $fp );
			}
			else {
				return $object->read();
			}
		}
		catch ( \InvalidResponseException $ex ) {
			$this->error( 'SwiftStorage: exception', [
				'op'         => 'read',
				'args'       => [ $remoteFile ],
				'exception'  => $ex
			]);
			return null;
		}
		catch ( \NoSuchObjectException $ex ) {
			return null;
		}
	}

	/**
	 * Check if given remote file exists
	 *
	 * @param $remoteFile string remote file name
	 * @return bool exists?
	 */
	public function exists( $remoteFile ) {
		try {
			$object = $this->getObject( $remoteFile );
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
	 * Return Swift server 
	 */
	public function getSwiftServer() {
		return $this->swiftServer;
	}

	public function getContainerName() {
		return $this->containerName;
	}

	/**
	 * @return \CF_Container
	 */
	public function getContainer() {
		return $this->container;
	}

	public function getPathPrefix() {
		return $this->pathPrefix;
	}

	/**
	 * @return \CF_Connection
	 */
	public function getConnection() {
		return $this->connection;
	}
}
