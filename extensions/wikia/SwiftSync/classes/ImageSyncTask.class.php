<?php

namespace Wikia\SwiftSync;

use Wikia\Tasks\Tasks\BaseTask;
use \Wikia\SwiftStorage;

/**
 * A Celery task that is run to synchronize SJC and RES DFS storage
 *
 * @see SUS-3611
 */
class ImageSyncTask extends BaseTask {

	public static function newLocalTask(): self {
		global $wgCityId;
		return ( new self() )->wikiId( $wgCityId );
	}

	/**
	 * @param array $tasks
	 * @throws \WikiaException
	 */
	public function synchronize( array $tasks ) {
		foreach($tasks as $task) {
			if ($task['op'] === 'delete') {
				$res = $this->delete( $task );
			} else {
				$res = $this->store( $task );
			}

			if (!$res) {
				$this->error( __METHOD__, $task);
				throw new \WikiaException( __METHOD__ );
			}
			else {
				$this->info( __METHOD__, $task);
			}
		}
	}

	/**
	 * Store image in destination path
	 *
	 * @param array $task
	 * @return bool
	 */
	private function store( array $task ) {
		/* connect to source Ceph/Swift */
		$srcStorage = $this->srcConn();

		/* read source file to string (src here is tmp file, so dst should be set here) */
		$remoteFile = $this->getRemotePath( $task['dst'] );

		if ( !$srcStorage->exists( $remoteFile ) ) {
			$this->error( 'MigrateImagesBetweenSwiftDC: cannot find image to sync' , $task);
			$result = false;
		} else {
			/* save image content into memory and send content to destination storage */
			$fp = fopen( "php://memory", "wb" );
			if ( !$fp ) {
				$this->error( "Cannot open memory stream", $task );
				$result = false;
			} else {
				/* read image content from source destination */
				fwrite( $fp, $srcStorage->read( $remoteFile ) );
				rewind( $fp );

				/* check the size of the source file - PLATFORM-841 */
				$size = intval( fstat( $fp )[ 'size' ] );

				if ( $size === 0 ) {
					$this->error( "File is empty!", $task );

					fclose( $fp );
					return false;
				}

				/* connect to destination Ceph/Swift */
				$dstStorage = $this->destConn();

				$magic = \MimeMagic::singleton();
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
	 * @param array $task
	 * @return bool
	 */
	private function delete( array $task ) {
		/* connect to source Ceph/Swift */
		$srcStorage = $this->srcConn();

		/* read source file to string (src here is tmp file, so dst should be set here) */
		$remoteFile = $this->getRemotePath( $task['dst'] );

		if ( !$srcStorage->exists( $remoteFile ) ) {
			/* connect to destination Ceph/Swift */
			$dstStorage = $this->destConn();

			/* store image in destination path */
			if ( $dstStorage->exists( $remoteFile ) ) {
				$result = $dstStorage->remove( $remoteFile )->isOK();
			} else {
				$this->error( 'MigrateImagesBetweenSwiftDC: file do delete does not exist in dest DC', $task);
				$result = false;
			}
		} else {
			$this->error( 'MigrateImagesBetweenSwiftDC: new version of the file exists in source DC' , $task);
			$result = false;
		}

		return $result;
	}

	/**
	 * Create container and authenticate - for source Ceph/Swift storage
	 *
	 * @return \Wikia\SwiftStorage storage instance
	 */
	private function srcConn() {
		global $wgCityId;
		return SwiftStorage::newFromWiki( $wgCityId, WIKIA_DC_SJC );
	}

	/**
	 * Create container and authenticate - for destination Ceph/Swift storage
	 *
	 * @return \Wikia\SwiftStorage storage instance
	 */
	private function destConn() {
		global $wgCityId;
		return SwiftStorage::newFromWiki( $wgCityId, WIKIA_DC_RES );
	}

	/**
	 * build remote path to container
	 *
	 * @param $path String - file path
	 *
	 * @return String $content
	 */
	private function getRemotePath( string $path ) : string {
		if ( strpos( $path, 'mwstore' ) === 0 ) {
			$path = preg_replace( '/mwstore\:\/\/swift-backend\/(.*)\/(images|avatars)/', '', $path );
		}

		return $path;
	}

}
