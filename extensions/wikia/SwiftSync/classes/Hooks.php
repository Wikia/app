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

	/*
	 * init config for FSFileBackend class
	 */
	static private function initLocalFS( ) {
		global $wgUploadDirectory, $wgDeletedDirectory;
		
		$repoName = self::$repoName;
		$config = array (
			'name'           => "{$repoName}-backend",
			'class'          => 'FSFileBackend',
			'lockManager'    => 'fsLockManager',
			'containerPaths' => array(
				"{$repoName}-public"  => "{$wgUploadDirectory}",
				"{$repoName}-thumb"   => "{$wgUploadDirectory}/thumb",
				"{$repoName}-deleted" => "{$wgDeletedDirectory}",
				"{$repoName}-temp"    => "{$wgUploadDirectory}/temp"
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
	public static function doStoreInternal( $params, $status ) {
		global $wgEnableSwithSyncToLocalFS;
		
		wfProfileIn( __METHOD__ );
		$fsParams = $params;
		
		if ( !empty( $wgEnableSwithSyncToLocalFS ) ) {
			if ( !empty( $params['dst'] ) && !empty( $params['src'] ) ) {
				# replace swift-backend storage URL with local-backend ... 
				$params['dst'] = self::replaceBackend( $params['dst'] );
				
				# ... and set correct destination path
				$params['dst'] = str_replace( "swift-backend", sprintf("%s-backend", self::$repoName), $params['dst'] );
			
				# init FSFileBackend object
				$fsBackend = self::initLocalFS();
				
				# prepare dir for uploaded file ...
				$status = $fsBackend->prepare( [ 'dir' => dirname( $params['dst'] ) ] );
				
				# ... and if created save image in destination path
				if ( $status->isOK() ) {
					$status = $fsBackend->storeInternal( $params );
				} 
				
				if ( !$status->isOK() ) {
					\SwiftStorage::log( __METHOD__, 'Cannot save image on local storage' );
				}
			} else {
				\SwiftStorage::log( __METHOD__, 'Destination not defined' );
				$status->fatal( 'backend-fail-store', $params['dst'] );
			}
		}
		
		Queue::newFromParams( $fsParams )->add();
		
		wfProfileOut( __METHOD__ );
		
		return true;
	}
	
	public static function doCopyInternal( $params, $status ) {
		global $wgEnableSwithSyncToLocalFS;
		
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
					\SwiftStorage::log( __METHOD__, 'Cannot create directory for copied file' );
				}
				
				if ( !$status->isOK() ) {	
					\SwiftStorage::log( __METHOD__, 'Cannot copy image to ' .$params['dst'] );
				}		
			} else {
				$status->fatal( 'backend-fail-store', ( empty( $params['dst'] ) ) ? $params['dst'] : $params['src'] );
			}
		}
		
		Queue::newFromParams( $fsParams )->add();
		
		wfProfileOut( __METHOD__ );
		
		return true;
	}
	
	public static function doDeleteInternal( $params, $status ) {
		global $wgEnableSwithSyncToLocalFS;
		
		wfProfileIn( __METHOD__ );
		$fsParams = $params;
		
		if ( empty( $params['op']  ) ) {
			$params['op'] = 'delete';
		}
		
		if ( !empty( $wgEnableSwithSyncToLocalFS ) ) {
			if ( !empty( $params['src'] ) ) {
				# replace swift-backend storage URL with local-backend ... 
				$params['src'] = self::replaceBackend( $params['src'] );
		
				# init FSFileBackend object
				$fsBackend = self::initLocalFS();
				
				# ... and delete source image
				$status = $fsBackend->deleteInternal( $params );	
				
				if ( !$status->isOK() ) {	
					\SwiftStorage::log( __METHOD__, 'Cannot remove image ' .$params['src'] );
				}	
			} else {
				$status->fatal( 'backend-fail-delete', $params['src'] );
				\SwiftStorage::log( __METHOD__, 'Invalid source path' );
			}
		}
		
		Queue::newFromParams( $fsParams )->add();
		
		wfProfileOut( __METHOD__ );
		
		return true;
	}
}
