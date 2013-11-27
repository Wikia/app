<?php
/**
 * Class definition for Wikia\SwiftSync\Hooks
 */
namespace Wikia\SwiftSync;

/**
 * SwiftFileBackend helper class to sync stored/removed/renamed file with local FS
 * 
 * @author moli
 * @package SwiftSync
 */
class Hooks {
	/* @String repoName - repo name */
	static private $repoName = 'local';

	/**
	 * init config for FSFileBackend class
	 *
	 * @return \FSFileBackend
	 */
	static private function initLocalFS( ) {
		global $wgUploadDirectory, $wgUploadDirectoryNFS;
		
		$repoName = self::$repoName;
		$directory = ( !empty( $wgUploadDirectoryNFS ) ) ? $wgUploadDirectoryNFS : $wgUploadDirectory;
		
		$config = array (
			'name'           => "{$repoName}-backend",
			'class'          => 'FSFileBackend',
			'lockManager'    => 'fsLockManager',
			'containerPaths' => array(
				"{$repoName}-public"  => "{$directory}",
				"{$repoName}-thumb"   => "{$directory}/thumb",
				"{$repoName}-deleted" => "{$directory}",
				"{$repoName}-temp"    => "{$directory}/temp"
			),
			'fileMode'       => 0644,
		);
		$class = $config['class'];

		return new $class( $config );
	}

	/* replace swith-backend with local-backend */
	private static function replaceBackend( $path ) {
		$path = preg_replace( 
			'/\/swift-backend\/(.*)\/images/', 
			sprintf( "/%s-backend/%s-public", self::$repoName, self::$repoName ), 
			$path
		);
		
		return $path;
	}
	
	/* save image into local repo */
	public static function doStoreInternal( $params, \Status $status ) {
		global $wgEnableSwithSyncToLocalFS, $wgDevelEnvironment;
		
		wfProfileIn( __METHOD__ );
		$fsParams = $params;

		if ( !empty( $wgEnableSwithSyncToLocalFS ) ) {
			if ( !empty( $params['dst'] ) && !empty( $params['src'] ) ) {
				# replace swift-backend storage URL with local-backend ... 
				$params['dst'] = self::replaceBackend( $params['dst'] );
				
				# ... and set correct destination path
				$params['dst'] = str_replace( "swift-backend", sprintf("%s-backend", self::$repoName), $params['dst'] );

				# don't sync dynamically generated timeline files (BAC-1081)
				if (strpos($params['dst'], '/local-public/timeline/') !== false) {
					wfDebug(__METHOD__ . ": syncing {$params['dst']} to NFS skipped!\n");
					wfProfileOut( __METHOD__ );
					return true;
				}
			
				# init FSFileBackend object
				$fsBackend = self::initLocalFS();
				
				# prepare dir for uploaded file ...
				$status = $fsBackend->prepare( [ 'dir' => dirname( $params['dst'] ) ] );
				
				# ... and if created save image in destination path
				if ( $status->isOK() ) {
					$status = $fsBackend->storeInternal( $params );
				} 
				
				if ( !$status->isOK() ) {
					\Wikia\SwiftStorage::log( __METHOD__, 'Cannot save image on local storage: ' . json_encode( $status ) );
				}
			} else {
				\Wikia\SwiftStorage::log( __METHOD__, 'Destination not defined' );
				$status->fatal( 'backend-fail-store', $params['dst'] );
			}
		}
		
		if ( empty( $wgDevelEnvironment ) ) { 
			Queue::newFromParams( $fsParams )->add();
		}
		
		wfProfileOut( __METHOD__ );
		
		return true;
	}
	
	public static function doCopyInternal( $params, \Status $status ) {
		global $wgEnableSwithSyncToLocalFS, $wgDevelEnvironment;
		
		wfProfileIn( __METHOD__ );
		$fsParams = $params;
		
		if ( !empty( $wgEnableSwithSyncToLocalFS ) ) {
			if ( !empty( $params['dst'] ) && !empty( $params['src'] ) ) {
				# replace swift-backend storage URL with local-backend ... 
				$params['dst'] = self::replaceBackend( $params['dst'] );
				$params['src'] = self::replaceBackend( $params['src'] );
		
				# init FSFileBackend object
				$fsBackend = self::initLocalFS();
				
				# prepare dir for copied file ...
				if ( strpos( $params['dst'], '/deleted/' ) !== false ) {
					$prepare_params = [ 
						'dir'       => dirname( $params['dst'] ),
						'noAccess'  => 1,
						'noListing' => 1 
					];	
				} else {
					$prepare_params = [ 
						'dir'       => dirname( $params['dst'] ) 
					];
				}
				$status = $fsBackend->prepare( $prepare_params );
				
				# ... and if created save image in destination path
				if ( $status->isOK() ) {
					$status = $fsBackend->copyInternal( $params );		
				} else {
					\Wikia\SwiftStorage::log( __METHOD__, 'Cannot create directory for copied file' );
				}
				
				if ( !$status->isOK() ) {	
					\Wikia\SwiftStorage::log( __METHOD__, 'Cannot copy image to ' .$params['dst'] );
				}		
			} else {
				$status->fatal( 'backend-fail-store', ( empty( $params['dst'] ) ) ? $params['dst'] : $params['src'] );
			}
		}
		
		if ( empty( $wgDevelEnvironment ) ) { 
			Queue::newFromParams( $fsParams )->add();
		}
		
		wfProfileOut( __METHOD__ );
		
		return true;
	}
	
	public static function doDeleteInternal( $params, \Status $status ) {
		global $wgEnableSwithSyncToLocalFS, $wgDevelEnvironment;
		
		wfProfileIn( __METHOD__ );
		
		if ( !empty( $params['src'] ) && ( strpos( $params['src'], '/images/thumb' ) !== false ) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		
		if ( empty( $params['op']  ) ) {
			$params['op'] = 'delete';
		}
		$fsParams = $params;
				
		if ( !empty( $wgEnableSwithSyncToLocalFS ) ) {
			if ( !empty( $params['src'] ) ) {
				# replace swift-backend storage URL with local-backend ... 
				$params['src'] = self::replaceBackend( $params['src'] );
		
				# init FSFileBackend object
				$fsBackend = self::initLocalFS();
				
				# ... and delete source image
				$status = $fsBackend->deleteInternal( $params );	
				
				if ( !$status->isOK() ) {	
					\Wikia\SwiftStorage::log( __METHOD__, 'Cannot remove image ' .$params['src'] );
				}	
			} else {
				$status->fatal( 'backend-fail-delete', $params['src'] );
				\Wikia\SwiftStorage::log( __METHOD__, 'Invalid source path' );
			}
		}
		
		if ( empty( $wgDevelEnvironment ) ) { 
			Queue::newFromParams( $fsParams )->add();
		}
		
		wfProfileOut( __METHOD__ );
		
		return true;
	}
}
