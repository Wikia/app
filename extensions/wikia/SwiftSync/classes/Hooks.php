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
		global $wgUploadDirectory;

		$repoName = self::$repoName;

		$config = array (
			'name'           => "{$repoName}-backend",
			'class'          => 'FSFileBackend',
			'lockManager'    => 'fsLockManager',
			'containerPaths' => array(
				"{$repoName}-public"  => "{$wgUploadDirectory}",
				"{$repoName}-thumb"   => "{$wgUploadDirectory}/thumb",
				"{$repoName}-deleted" => "{$wgUploadDirectory}",
				"{$repoName}-temp"    => "{$wgUploadDirectory}/temp"
			),
			'fileMode'       => 0644,
		);
		$class = $config['class'];

		return new $class( $config );
	}

	/* replace swift-backend with local-backend */
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

		Queue::newFromParams( $params )->add();

		return true;
	}

	public static function doCopyInternal( $params, \Status $status ) {

		Queue::newFromParams( $params )->add();

		return true;
	}

	public static function doDeleteInternal( $params, \Status $status ) {

		if ( !empty( $params['src'] ) && ( strpos( $params['src'], '/images/thumb' ) !== false ) ) {
			return true;
		}

		if ( empty( $params['op']  ) ) {
			$params['op'] = 'delete';
		}

		Queue::newFromParams( $params )->add();

		return true;
	}

	public static function SyncFileToDC( $source, $dest) {

		Queue::newFromParams( [
			'city_id' => 0,
			'op' => 'store',
			'src' => $source,
			'dst' => $dest
		] )->add();

		return true;
	}
}
