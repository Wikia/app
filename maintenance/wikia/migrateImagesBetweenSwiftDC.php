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
	private $source_container;
	private $dest_container;
	/* @private \Queue object  */
	private $imageSyncQueue;
	
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
	 * Create container and authenticate - for source Ceph/Swift storage
	 *
	 * @return SwiftStorage storage instance
	 */
	private function srcConn(){
		if ( empty( $this->source_container[ $this->imageSyncQueue->city_id ] ) ) {
			if ( $this->imageSyncQueue->city_id == 0 ) {
				global $wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix;
				$this->source_container[ $this->imageSyncQueue->city_id ] = 
					\Wikia\SwiftStorage::newFromContainer( $wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix );
			} else {
				$this->source_container[ $this->imageSyncQueue->city_id ] = 
					\Wikia\SwiftStorage::newFromWiki( $this->imageSyncQueue->city_id );
			}
		}
		
		return $this->source_container[ $this->imageSyncQueue->city_id ];
	}
	
	/**
	 * Create container and authenticate - for destination Ceph/Swift storage
	 *
	 * @return SwiftStorage storage instance
	 */
	private function destConn() {
		if ( empty( $this->desc_container[ $this->imageSyncQueue->city_id ] ) ) {
			if ( $this->imageSyncQueue->city_id == 0 ) {
				global $wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix;
				$this->desc_container[ $this->imageSyncQueue->city_id ] = 
					\Wikia\SwiftStorage::newFromContainer( $wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix, $this->mDC_dst );
			} else {
				$this->desc_container[ $this->imageSyncQueue->city_id ] = 
					\Wikia\SwiftStorage::newFromWiki( $this->imageSyncQueue->city_id, $this->mDC_dst );
			}
		}
		
		return $this->desc_container[ $this->imageSyncQueue->city_id ];
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

		/* take X elements from queue */
		$imageSyncList = \Wikia\SwiftSync\ImageSync::newFromQueue( $this->mLimit );
		foreach ( $imageSyncList as $this->imageSyncQueue ) {
			$this->output( sprintf( "Run %s operation: (record: %d)\n", $this->imageSyncQueue->action, $this->imageSyncQueue->id ) );
			$this->output( sprintf( "\tSource: %s\n\tDestination: %s\n", $this->imageSyncQueue->src, $this->imageSyncQueue->dst ) );
			
			$error = 0;
			if ( is_null( $this->imageSyncQueue->city_id ) ) {
				$this->output( "\tWiki ID cannot be null\n" );
				$error = 1;
			} elseif ( empty( $this->imageSyncQueue->dst ) ) {
				$this->output( "\tSource and destination path cannot be empty\n" );
				$error = 2;
			} elseif ( empty( $this->imageSyncQueue->action ) ) {
				$this->output("\tAction cannot be empty \n" );
				$error = 3;
			} elseif ( !in_array( $this->imageSyncQueue->action, [ 'store', 'delete', 'copy' ] ) ) {
				$this->output( "\tInvalid action: {$this->imageSyncQueue->action} \n" ); 
				$error = 4;
			} else {
				if ( $this->imageSyncQueue->action == 'delete' ) {
					$res = $this->delete();
				} else {
					$res = $this->store();
				}
				
				if ( $res === null ) {
					$this->output( "\tFile ({$this->imageSyncQueue->dst}) doesn't exist in source DC\n" );
					$error = 5;
				} 
				
				
				if ( $res === false ) {
					$this->output( "\tCannot finish operation {$this->imageSyncQueue->action} in destination DC \n\n" );					
				} else {
					$this->imageSyncQueue->setError( $error );
					$this->imageSyncQueue->moveToArchive();
					$this->output( "\tRecord moved to archive\n\n" );
				}
			}
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
	 * @param $city_id Int - Wikia ID
	 * @param $src String - source file
	 * @param $dst String - destination path
	 * 
	 * @return Boolean
	 */
	private function store() {
		if ( $this->imageSyncQueue->action == 'move' ) {
			$this->output( "\tMove image {$this->imageSyncQueue->src} to {$this->imageSyncQueue->dst}\n" );
		} elseif ( $this->imageSyncQueue->action == 'copy' ) {
			$this->output( "\tCopy image {$this->imageSyncQueue->src} to {$this->imageSyncQueue->dst}\n" );
		} else {
			$this->output( "\tStore new image into {$this->imageSyncQueue->dst}\n" );
		}
		
		/* connect to source Ceph/Swift */
		$srcStorage = $this->srcConn();
	
		/* read source file to string (src here is tmp file, so dst should be set here) */
		$remoteFile = $this->getRemotePath( $this->imageSyncQueue->dst );
		
		$this->output( "\tRemote file: {$remoteFile} \n" );

		if ( !$srcStorage->exists( $remoteFile ) ) {
			$this->output( "\tCannot find image to sync \n" );
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

				/* connect to destination Ceph/Swift */
				$dstStorage = $this->destConn();							

				/* store image in destination path */
				$result = $dstStorage->store( $fp, $remoteFile )->isOK();
			}
		}
		
		return $result;
	}	
	
	/* delete image from destination path */
	private function delete() {
		$this->output( "\tDelete {$this->imageSyncQueue->dst} image\n" );
		
		/* connect to source Ceph/Swift */
		$srcStorage = $this->srcConn();
		
		/* read source file to string (src here is tmp file, so dst should be set here) */
		$remoteFile = $this->getRemotePath( $this->imageSyncQueue->dst );
		
		$this->output( "\tRemote file: {$remoteFile} \n" );
		
		if ( !$srcStorage->exists( $remoteFile ) ) {
			/* connect to destination Ceph/Swift */
			$dstStorage = $this->destConn();							
			
			/* store image in destination path */
			if ( $dstStorage->exists( $remoteFile ) ) {
				$result = $dstStorage->remove( $remoteFile )->isOK();
			} else {
				$result = null;
			}
		} else {
			$this->output( "\tImage still exists in source DS \n" );
			$result = null;
		}
		
		return $result;
	}
}

$maintClass = "MigrateImagesBetweenSwiftDC";
require_once( RUN_MAINTENANCE_IF_MAIN );
