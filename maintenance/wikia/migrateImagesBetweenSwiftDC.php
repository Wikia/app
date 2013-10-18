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
	private $imageSync;
	
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
		if ( empty( $this->source_container[ $this->imageSync->city_id ] ) ) {
			$this->source_container[ $this->imageSync->city_id ] = \Wikia\SwiftStorage::newFromWiki( $this->imageSync->city_id );
		}
		
		return $this->source_container[ $this->imageSync->city_id ];
	}
	
	/**
	 * Create container and authenticate - for destination Ceph/Swift storage
	 *
	 * @return SwiftStorage storage instance
	 */
	private function destConn() {
		if ( empty( $this->desc_container[ $this->imageSync->city_id ] ) ) {
			$this->desc_container[ $this->imageSync->city_id ] = \Wikia\SwiftStorage::newFromWiki( $this->imageSync->city_id, $this->mDC_dst );
		}
		
		return $this->desc_container[ $this->imageSync->city_id ];
	}
	
	/**
	 * @param None
	 */
	public function execute() {
		$this->mLimit = $this->getOption( 'limit', 50 );
		$this->mDC_dst = $this->getOption( 'dc', null );

		if ( empty( $this->mDC_dst ) ) {
			$this->error( "Please set destination DC (reston, iowa)", 1 );
		}
		
		$this->output( "Fetching {$this->mLimit} images to sync ...\n" );

		/* take X elements from queue */
		$imageSyncList = \Wikia\SwiftSync\ImageSync::newFromQueue( $this->mLimit );
		foreach ( $imageSyncList as $this->imageSync ) {
			$this->output( 
				sprintf( "Run %s operation on src file %s and dst file %s", 
					$this->imageSync->action,
					$this->imageSync->src,
					$this->imageSync->dst
				)
			);
			 
			if ( empty( $this->imageSync->city_id ) ) {
				$this->output( "\tWiki ID cannot be empty\n" );
			}
			
			if ( empty( $this->imageSync->dst ) || empty( $this->imageSync->src ) ) {
				$this->output( "\tSource and destination path cannot be empty\n" );
				continue;
			}
			
			if ( empty( $this->imageSync->action ) ) {
				$this->output("\tAction cannot be empty \n" );
				continue;
			} 

			if ( $this->imageSync->action != 'store' ) {
				continue;
			}
			
			echo print_r( $this->imageSync, true );

			switch ( $this->imageSync->action ) {
				case 'store' : $res = $this->store(); break;
				#case 'move'  : $res = $this->move(); break;
				#case 'copy'  : $res = $this->copy(); break;
				#case 'delete': $res = $this->delete(); break;
				default      : $res = false; $this->output( "\tInvalid action: {$this->imageSync->action} \n" ); break;
			}
			
			if ( $res === null ) {
				$this->output( "\tSource image doesn't exist\n" );
				$this->output( "\tCannot sync image to {$this->mDC_dst}\n" );
			}
			
			#echo $this->readSource( $this->imageSync->dst ) . "\n";
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
			$this->output( "Invalid path to read file content\n" );
			return null;
		}
		
		if ( strpos( $path, 'mwstore' ) === 0 ) {
			$path = preg_replace( '/mwstore\:\/\/swift-backend\/(.*)\/images/', '', $path );
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
		$this->output( "\tStore image into {$this->imageSync->dst}\n" );
		
		/* connect to source Ceph/Swift */
		$srcStorage = $this->srcConn();
		
		/* read source file to string (src here is tmp file, so dst should be set here) */
		$remoteFile = $this->getRemotePath( $this->imageSync->dst );
		
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
	
	/* 
	
	/* move image to the destination path */
	private function move( $src, $dst ) {
		
	}
	
	/* copy image to the destination path */
	private function copy( $src, $dst ) {
		
	}
	
	/* delete image from destination path */
	private function delete( $dst ) {
		
	}
}

$maintClass = "MigrateImagesBetweenSwiftDC";
require_once( RUN_MAINTENANCE_IF_MAIN );
