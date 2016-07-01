<?php

/**
 * Script that sync files between distributed storages
 *
 * @author Moli
 * @ingroup Maintenance
 */
require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class MigrateImagesBetweenSwiftDC extends Maintenance {

	/* @private Int - number of images to sync */
	private $mLimit;
	/* @private String - destination DC */
	private $mDC_dst;
	/* @private Array - containers */
	private $source_container = [];
	private $dest_container = [];
	/* @var Wikia\SwiftSync\Queue object  */
	private $imageSyncQueueItem;

	// error codes 1-4 were used by the previous version of this script
	const ERROR_CANT_FIND_FILE = 5;
	const ERROR_FILE_IS_EMPTY = 6;
	const ERROR_FILE_EXISTS_IN_SOURCE_DC = 7;

	/**
	 * class constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'limit', 'Number of records to check. Default: 50' );
		$this->addOption( 'dc', 'Destination data center - res, iowa' );
		$this->mDescription = 'Sync files between Ceph servers in different DC';
	}

	/**
	 * @return \Wikia\Logger\WikiaLogger
	 */
	private function getLogger() {
		return Wikia\Logger\WikiaLogger::instance();
	}

	/**
	 * @return array
	 */
	private function getLoggerContext() {
		return [
			'id'      => $this->imageSyncQueueItem->id,
			'action'  => $this->imageSyncQueueItem->action,
			'city_id' => $this->imageSyncQueueItem->city_id,
			'src'     => $this->imageSyncQueueItem->src,
			'dst'     => $this->imageSyncQueueItem->dst,
			'@root'   => [
				'tags' => [ 'SwiftSync' ]
			]
		];
	}

	/**
	 * Create container and authenticate - for source Ceph/Swift storage
	 *
	 * @return Wikia\SwiftStorage storage instance
	 */
	private function srcConn() {
		if ( empty( $this->source_container[ $this->imageSyncQueueItem->city_id ] ) ) {
			if ( $this->imageSyncQueueItem->city_id == 0 ) {
				global $wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix;
				$this->source_container[ $this->imageSyncQueueItem->city_id ] =
					\Wikia\SwiftStorage::newFromContainer( $wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix );
			} else {
				$this->source_container[ $this->imageSyncQueueItem->city_id ] =
					\Wikia\SwiftStorage::newFromWiki( $this->imageSyncQueueItem->city_id );
			}
		}

		return $this->source_container[ $this->imageSyncQueueItem->city_id ];
	}

	/**
	 * Create container and authenticate - for destination Ceph/Swift storage
	 *
	 * @return Wikia\SwiftStorage storage instance
	 */
	private function destConn() {
		$city_id = $this->imageSyncQueueItem->city_id;

		if ( empty( $this->dest_container[ $city_id ] ) ) {
			if ( $city_id == 0 ) {
				global $wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix;
				$this->dest_container[ $city_id ] =
					\Wikia\SwiftStorage::newFromContainer( $wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix, $this->mDC_dst );
			} else {
				$this->dest_container[ $city_id ] =
					\Wikia\SwiftStorage::newFromWiki( $city_id, $this->mDC_dst );
			}
		}

		return $this->dest_container[ $city_id ];
	}

	/**
	 * @param None
	 */
	public function execute() {
		$this->mLimit = $this->getOption( 'limit', 50 );
		$this->mDC_dst = $this->getOption( 'dc', null );

		if ( empty( $this->mDC_dst ) ) {
			$this->error( "Please set destination DC (res, iowa)", 1 );
		}

		$this->output( "Fetching {$this->mLimit} images to sync ...\n" );

		$then = microtime( true );

		/* take X elements from queue */
		/* @var \Wikia\SwiftSync\ImageSync $imageSyncList */
		$imageSyncList = \Wikia\SwiftSync\ImageSync::newFromQueue( $this->mLimit );
		foreach ( $imageSyncList as $this->imageSyncQueueItem ) {
			$this->output( sprintf( "Run %s operation: (record: %d)\n", $this->imageSyncQueueItem->action, $this->imageSyncQueueItem->id ) );
			$this->output( sprintf( "\tSource: %s\n\tDestination: %s\n", $this->imageSyncQueueItem->src, $this->imageSyncQueueItem->dst ) );

			if ( is_null( $this->imageSyncQueueItem->city_id ) ) {
				$this->output( "\tWiki ID cannot be null\n" );
			} elseif ( empty( $this->imageSyncQueueItem->dst ) ) {
				$this->output( "\tSource and destination path cannot be empty\n" );
			} elseif ( empty( $this->imageSyncQueueItem->action ) ) {
				$this->output( "\tAction cannot be empty \n" );
			} elseif ( !in_array( $this->imageSyncQueueItem->action, [ 'store', 'delete', 'copy', 'move' ] ) ) {
				$this->output( "\tInvalid action: {$this->imageSyncQueueItem->action} \n" );
			} else {
				if ( $this->imageSyncQueueItem->action == 'delete' ) {
					$res = $this->delete();
				} else {
					$res = $this->store();
				}

				/**
				 * $res === true  - we're fine
				 * $res === false - error, keep an item in the queue (i.e. retry in the next run)
				 * $res === null  - error, move the item to archive (i.e. ignore the error)
				 */
				if ( $res === false ) {
					$this->output( "\tCannot finish operation {$this->imageSyncQueueItem->action} in destination DC \n\n" );
				} else {
					$this->imageSyncQueueItem->moveToArchive();
					$this->output( "\tRecord moved to archive\n\n" );
				}

				$this->getLogger()->debug( 'MigrateImagesBetweenSwiftDC' , [
					'is_ok'   => ( $res === true ),
					'retry'   => ( $res === false ),
					'id'      => $this->imageSyncQueueItem->id,
					'action'  => $this->imageSyncQueueItem->action,
					'city_id' => $this->imageSyncQueueItem->city_id,
					'src'     => $this->imageSyncQueueItem->src,
					'dst'     => $this->imageSyncQueueItem->dst,
				] );
			}
		}

		if ( $imageSyncList->count() > 0 ) {
			$this->getLogger()->debug( 'MigrateImagesBetweenSwiftDC: execute', [
				'dest_dc'    => $this->mDC_dst,
				'limit'      => $this->mLimit,
				'batch_size' => $imageSyncList->count(),
				'took'       => round( microtime( true ) - $then, 4 ),
			] );
		}
	}

	/**
	 * build remote path to container
	 *
	 * @param $path String - file path
	 *
	 * @return String $content
	 */
	private function getRemotePath( $path ) {
		if ( empty( $path ) ) {
			$this->output( "\tInvalid path to read file content\n" );
			return null;
		}

		if ( strpos( $path, 'mwstore' ) === 0 ) {
			$path = preg_replace( '/mwstore\:\/\/swift-backend\/(.*)\/(images|avatars)/', '', $path );
		}

		return $path;
	}

	/**
	 * Store image in destination path
	 *
	 * @return Boolean|null returns false for recoverable error and null for permanent error and true in the unlikely event of success
	 */
	private function store() {
		if ( $this->imageSyncQueueItem->action == 'move' ) {
			$this->output( "\tMove image {$this->imageSyncQueueItem->src} to {$this->imageSyncQueueItem->dst}\n" );
		} elseif ( $this->imageSyncQueueItem->action == 'copy' ) {
			$this->output( "\tCopy image {$this->imageSyncQueueItem->src} to {$this->imageSyncQueueItem->dst}\n" );
		} else {
			$this->output( "\tStore new image into {$this->imageSyncQueueItem->dst}\n" );
		}

		/* connect to source Ceph/Swift */
		$srcStorage = $this->srcConn();

		/* read source file to string (src here is tmp file, so dst should be set here) */
		$remoteFile = $this->getRemotePath( $this->imageSyncQueueItem->dst );

		$this->output( "\tRemote file: {$remoteFile} (Swift: " . $srcStorage->getSwiftServer() . " ) \n" );

		if ( !$srcStorage->exists( $remoteFile ) ) {
			$this->output( "\tCannot find image to sync \n" );
			$this->imageSyncQueueItem->setError( self::ERROR_CANT_FIND_FILE );

			$this->getLogger()->error( 'MigrateImagesBetweenSwiftDC: cannot find image to sync' , [
				'id'      => $this->imageSyncQueueItem->id,
				'action'  => $this->imageSyncQueueItem->action,
				'city_id' => $this->imageSyncQueueItem->city_id,
				'src'     => $this->imageSyncQueueItem->src,
				'dst'     => $this->imageSyncQueueItem->dst,
			]);

			$result = null;
		} else {
			/* save image content into memory and send content to destination storage */
			$fp = fopen( "php://memory", "wb" );
			if ( !$fp ) {
				$this->output( "\tCannot open memory stream\n" );
				$result = false;
			} else {
				/* read image content from source destination */
				fwrite( $fp, $srcStorage->read( $remoteFile ) );
				rewind( $fp );

				/* check the size of the source file - PLATFORM-841 */
				$size = intval( fstat( $fp )[ 'size' ] );

				if ( $size === 0 ) {
					$this->output( "\t'{$this->imageSyncQueueItem->dst}' file is empty!\n" );
					$this->imageSyncQueueItem->setError( self::ERROR_FILE_IS_EMPTY );

					$this->getLogger()->error( 'MigrateImagesBetweenSwiftDC: file is empty' , [
						'id'      => $this->imageSyncQueueItem->id,
						'action'  => $this->imageSyncQueueItem->action,
						'city_id' => $this->imageSyncQueueItem->city_id,
						'src'     => $this->imageSyncQueueItem->src,
						'dst'     => $this->imageSyncQueueItem->dst,
					]);

					fclose( $fp );
					return null;
				}

				/* connect to destination Ceph/Swift */
				$dstStorage = $this->destConn();

				$this->output( "\tConnect to dest Swift server: " . $dstStorage->getSwiftServer() . " \n" );

				$magic = MimeMagic::singleton();
				$ext = pathinfo( basename( $remoteFile ), PATHINFO_EXTENSION );
				$mime_type = $magic->guessTypesForExtension( $ext );
				if ( empty( $mime_type ) ) {
					$mime_type = 'unknown/unknown';
				}

				/* store image in destination path (fclose is called internally in store method) */
				$result = $dstStorage->store( $fp, $remoteFile, array(), $mime_type )->isOK();
			}
		}

		return $result;
	}

	/**
	 * Delete image from destination path
	 *
	 * @return Boolean|null returns false for recoverable error and null for permanent error and true in the unlikely event of success
	 */
	private function delete() {
		$this->output( "\tDelete {$this->imageSyncQueueItem->dst} image\n" );

		/* connect to source Ceph/Swift */
		$srcStorage = $this->srcConn();

		/* read source file to string (src here is tmp file, so dst should be set here) */
		$remoteFile = $this->getRemotePath( $this->imageSyncQueueItem->dst );

		$this->output( "\tRemote file: {$remoteFile} (Swift: " . $srcStorage->getSwiftServer() . " ) \n" );

		if ( !$srcStorage->exists( $remoteFile ) ) {
			/* connect to destination Ceph/Swift */
			$dstStorage = $this->destConn();

			$this->output( "\tConnect to dest Swift server: " . $dstStorage->getSwiftServer() . " \n" );

			/* store image in destination path */
			if ( $dstStorage->exists( $remoteFile ) ) {
				$result = $dstStorage->remove( $remoteFile )->isOK();
			} else {
				$this->output( "\tImage to delete does not exist in dest DC \n" );

				$this->getLogger()->error( 'MigrateImagesBetweenSwiftDC: file do delete does not exist in dest DC', $this->getLoggerContext());

				$result = null;
			}
		} else {
			$this->output( "\tImage still exists in source DC \n" );
			$this->imageSyncQueueItem->setError( self::ERROR_FILE_EXISTS_IN_SOURCE_DC );

			$this->getLogger()->error( 'MigrateImagesBetweenSwiftDC: file still exists in source DC' , $this->getLoggerContext());

			$result = null;
		}

		return $result;
	}
}

$maintClass = "MigrateImagesBetweenSwiftDC";
require_once( RUN_MAINTENANCE_IF_MAIN );
